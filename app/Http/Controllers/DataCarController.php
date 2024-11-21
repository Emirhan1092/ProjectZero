<?php

namespace App\Http\Controllers;

use App\Models\CarCatalog;
use App\Models\CarFilter;
use App\Models\CarModel;
use App\Models\Car;
use Dflydev\DotAccessData\Data;
use Illuminate\Http\Request;

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








    public function list()
    {
        $catalogs = CarCatalog::all();
        $models = CarModel::all();

        return view('cars.catalog.list', compact('catalogs', 'models'));
    }



}
