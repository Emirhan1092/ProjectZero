<?php

namespace App\Http\Controllers;

use App\Models\CarCatalog;
use App\Models\CarFilter;
use App\Models\CarGroup;
use App\Models\CarModel;
use App\Models\Car;
use App\Models\CarSchemas;
use App\Models\CarSubGroup;
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
        $catalog = CarCatalog::where('brand_name', $catalogName)->first();

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
            return response()->json([]);
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
                    'key'   => $logItem->name,
                    'value' => $logItem->value
                ];
            }

            $car = Car::where('car_id', $logItems->first()->car_id)->first();
            $carModel = CarModel::where('name', $car->model_name)->first();
            if ($car) {
                $result['car_id'] = $logItems->first()->car_id;
                $result['Name'] = $car->name;
                $result['Brand'] = $car->brand_name;
                $result['ModelImage'] = $carModel->img;
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
            $subGroupNames = [];

            $carGroups31 = CarSubGroup::where('car_id', $carGroup->car_id)
                ->where('parent_id', $carGroup->group_id)
                ->get();
            $Names = [];

            foreach ($carGroups31 as $carSubGroup) {
                if (!in_array($carSubGroup->name, array_column($subGroupNames, 'subGroupName'))) {
                    $subGroupNames[] = [
                        'subGroupName' => $carSubGroup->name,
                    ];
                }

                $carSchemas = CarSchemas::where('group_id', $carSubGroup->group_id)
                    ->whereNotNull('part_name')
                    ->whereNotNull('part_group_id')
                    ->get();

                foreach ($carSchemas as $carSchema) {
                    $Names[] = [
                        'partName' => $carSchema->part_name,
                        'part_group_id' => $carSchema->part_group_id,
                        'img' => $carSchema->img,
                    ];
                }
            }


                $result[] = [
                    'car_id' => $car_id,
                    'part_id' => $carGroup->group_id,
                    'groupName' => $carGroup->name,
                    'subGroupNames' => $subGroupNames,
                    'PartInformations' => $Names,
                ];

        }

        return response()->json($result);
    }









    public function list()
    {
        $catalogs = CarCatalog::all();
        $models = CarModel::all();

        return view('cars.catalog.list', compact('catalogs', 'models'));
    }



}
