<?php

namespace App\Http\Controllers;

use App\Models\CarCatalog;
use App\Models\CarFilter;
use App\Models\CarGroup;
use App\Models\CarModel;
use App\Models\Car;
use App\Models\CarPart;
use App\Models\CarSchemas;
use App\Models\CarSubGroup;
use App\Models\Cart;
use App\Models\User;
use App\Models\Vehicle;
use Dflydev\DotAccessData\Data;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function PHPUnit\Framework\isEmpty;

class DataCarController extends Controller
{

    public function getModelsByCatalog(Request $request, $catalogId)
    {
        $catalog = CarCatalog::where('catalog_id', $catalogId)->first();

        if ($catalog) {
            $models = $this->getModels($catalog->catalog_id);

            if ($models) {
                return response()->json(['models' => $models]);
            } else {
                return response()->json(['message' => 'No models found for this catalog'], 404);
            }
        } else {
            return response()->json(['message' => 'Catalog not found'], 404);
        }
    }

    public function getModels($catalogId)
    {
        $models = CarModel::where('catalog_id', $catalogId)->get();

        if ($models->isNotEmpty()) {
            $modelNames = [];
            foreach ($models as $model) {
                $modelNames[] = $model->name;
            }
            return $modelNames;
        }
        return null;
    }

    public function getParametersByModel(Request $request, $catalogName, $modelName)
    {
        $catalog = CarCatalog::where('catalog_id', $catalogName)->first();
        if ($catalog) {
            $parameters = $this->getParameters($modelName);

            if ($parameters) {
                return response()->json(['parameters' => $parameters]);
            } else {
                return response()->json(['message' => 'No parameters found for this model'], 404);
            }
        } else {
            return response()->json(['message' => 'Catalog not found'], 404);
        }
    }

    public function getParameters($modelName)
    {
        $dataCar = Car::where('model_name', $modelName)->get();
        if ($dataCar->isNotEmpty()) {
            $parameters = [];
            foreach ($dataCar as $car) {
                $parameters[] = $car->parameters;
            }
            return $parameters;
        }
        return null;
    }


    public function carParameterList($modelName, Request $request)
    {
        $selectedValues = json_decode($request->input('selectedValues', '[]'), true);

        if (empty($selectedValues)) {
            $allCars = CarFilter::where('model_name', $modelName)->get();
            $carData = $allCars->groupBy('car_id')->map(function ($logItems) {
                $result = [];

                foreach ($logItems as $logItem) {
                    $result[] = [
                        'key' => $logItem->name,
                        'value' => $logItem->value
                    ];
                }

                $car = Car::where('car_id', $logItems->first()->car_id)->first();
                if ($car) {
                    $result['car_id'] = $logItems->first()->car_id;
                    $result['Name'] = $car->name;
                    $result['Brand'] = $car->brand_name;
                }

                return $result;
            });

            $carData = $carData->filter(function ($car) {
                return $car !== null;
            });

            return response()->json($carData->values());
        }

        $query = CarFilter::where('model_name', $modelName);
        $log2 = $query->get();
        foreach ($selectedValues as $selectedValue) {
            $filteredLog2 = collect();

            foreach ($log2 as $logItem) {
                if ($logItem->key === $selectedValue['key'] && $logItem->value === $selectedValue['value']) {
                    $carMatches = CarFilter::where('car_id', $logItem->car_id)->get();
                    $filteredLog2 = $filteredLog2->merge($carMatches);
                }
            }

            $log2 = $filteredLog2;
        }

        if ($log2->isEmpty()) {
            return response()->json([]);
        }

        $carData = $log2->groupBy('car_id')->map(function ($logItems) {
            $result = [];

            foreach ($logItems as $logItem) {
                $result[] = [
                    'key' => $logItem->name,
                    'value' => $logItem->value
                ];
            }

            $car = Car::where('car_id', $logItems->first()->car_id)->first();
            if ($car) {
                $result['car_id'] = $logItems->first()->car_id;
                $result['Name'] = $car->name;
                $result['Brand'] = $car->brand_name;
            }

            return $result;
        });

        $carData = $carData->filter(function ($car) {
            return $car !== null;
        });

        return response()->json($carData->values());
    }


    public function carGroupList(Request $request)
    {
        $result = [];

        $car_id = $request->input('car_id');

        $carGroups = CarGroup::where('car_id', $car_id)->get();
        foreach ($carGroups as $carGroup) {
            $subGroupNames = $this->getSubGroups($carGroup->group_id, $car_id);

            $result[] = [
                'car_id' => $car_id,
                'part_id' => $carGroup->group_id,
                'groupName' => $carGroup->name,
                'subGroupNames' => $subGroupNames,
            ];
        }

        return response()->json($result);
    }

    private function getSubGroups($parent_id, $car_id)
    {
        $subGroups = CarSubGroup::where('car_id', $car_id)
            ->where('parent_id', $parent_id)
            ->get();
        $subGroupNames = [];
        foreach ($subGroups as $subGroup) {
            $subGroupDetails = [
                'subGroupName' => $subGroup->name,
                'group_id' => $subGroup->group_id,
                'parent_id' => $subGroup->parent_id,
                'children' => $this->getSubGroups($subGroup->group_id, $car_id),
            ];


            $carSchemas = CarSchemas::where('branch_id', $subGroup->group_id)->get();
            $partInformations = [];
            foreach ($carSchemas as $carSchema) {
                $partInformations[] = [
                    'partName' => $carSchema->part_name,
                    'part_group_id' => $carSchema->part_group_id,
                    'img' => $carSchema->img,
                ];
            }

            $subGroupDetails['partInformations'] = $partInformations;

            $subGroupNames[] = $subGroupDetails;
        }

        return $subGroupNames;
    }

    public function addAndSelectUser()

    {
        $users = User::all();

        $data = $users->map(function ($user) {
            return [
                'name' => $user->name,
                'id' => $user->id,
            ];
        });

        return response()->json(['users' => $data]);
    }

    public function carOption(int $userId)
    {
        $car_informations = Vehicle::where('user_id', $userId)->get(['VIN', 'id']);
        return response()->json(['cars' => $car_informations]);

    }


    public function getParametersByPartGroup(Request $request)
    {
        $random1 = $request->input('partGroupId');
        $partsInformations = CarPart::join('catalog_car_schemas', 'catalog_car_schemas.part_group_id', '=', 'catalog_car_parts.group_id')
            ->join('catalog_cars', 'catalog_cars.car_id', '=', 'catalog_car_parts.car_id')
            ->join('catalog_models', 'catalog_cars.model_name', '=', 'catalog_models.name')
            ->where('catalog_car_parts.group_id', $random1)
            ->selectRaw('DISTINCT catalog_car_parts.part_id,
                 catalog_car_parts.number,
                 catalog_car_parts.name,
                 catalog_car_parts.description,
                 catalog_car_parts.car_id,
                 catalog_car_parts.group_id,
                 catalog_car_parts.position_number,
                 catalog_cars.brand_name,
                 catalog_car_schemas.img as schema_img,
                 catalog_models.img as model_img')
            ->get();

        return response()->json($partsInformations);
    }

    public function getShoppingCart($part_id, $group_id)
    {
        $result = [
            'part_id' => $part_id,
            'group_id' => $group_id,
        ];

        return response()->json($result);
    }


    public function list()
    {
        $catalogs = CarCatalog::all();
        $models = CarModel::all();

        return view('layouts.content.list.cars-catalog', compact('catalogs', 'models'));
    }

    public function carPartsAdded(Request $request)
    {
        $selectedValues = json_decode($request->input('selectedValues', '[]'), true);

        $currentUser = auth()->user();
        $uniqueKeys = [];
        $createList = [];
        foreach ($selectedValues as $selectedValue) {
            if (isset($selectedValue['customerCarId'])) {
                $customer_car_id = $selectedValue['customerCarId'];
            }
            if (isset($selectedValue['customerId'])) {
                $customer_id = $selectedValue['customerId'];
            }
            $part_id = $selectedValue['part_id'] ?? null;
            $count = $selectedValue['count'] ?? null;
            $car_id = $selectedValue['car_id'] ?? null;
            $group_id = $selectedValue['group_id'] ?? null;

            if (!$part_id || !$car_id || !$group_id) {
                continue;
            }

            $uniqueKey = $part_id . '-' . $car_id . '-' . $group_id;

            if (in_array($uniqueKey, $uniqueKeys)) {
                continue;
            }

            $uniqueKeys[] = $uniqueKey;

            $car_information = CarPart::where('part_id', $part_id)
                ->where('car_id', $car_id)
                ->where('group_id', $group_id)
                ->first();

            if (!$car_information) {
                continue;
            }

            $createList[] = [
                'added_by_user_name' => $currentUser->name,
                'added_by_user_id' => $currentUser->id,
                'added_by_user_role' => $currentUser->role,
                'customer_id' => $customer_id,
                'customer_car_id' => $customer_car_id,
                'car_id' => $car_information->car_id,
                'group_id' => $car_information->group_id,
                'part_id' => $car_information->part_id,
                'img' => $car_information->img,
                'number' => $car_information->number,
                'count' => $count,
            ];
        }

        if (!empty($createList)) {
            Cart::insert($createList);
        }

  ;

        return response()->json([
            'message' => 'Tüm parçalar başarıyla sepete eklendi!',
            'alert_message' => 'Sepete Eklendi',
            'redirect' => route('catalog.list'),
        ]);
    }




}
