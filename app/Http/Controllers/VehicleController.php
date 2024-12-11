<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function list(Request $request)
    {
         $vehicles = Vehicle::query()
            ->where(function ($query) use ($request) {
                $query->where('id', 'LIKE', '%' . $request->id . '%')
                    ->where('user_id', 'LIKE', '%' . $request->user_id . '%')
                    ->where('brand', 'LIKE', '%' . $request->brand. '%')
                    ->where('model', 'LIKE', '%' . $request->model . '%')
                    ->where('year', 'LIKE', '%' . $request->year . '%')
                    ->where('color', 'LIKE', '%' . $request->color . '%')
                    ->where('kilometers', 'LIKE', '%' . $request->kilometers . '%')
                    ->where('VIN', 'LIKE', '%' . $request->VIN . '%')
                ->where('engine_number', 'LIKE', '%' . $request->engine_number . '%')
                ->where('fuel_type', 'LIKE', '%' . $request->fuel_type . '%');


            })->paginate(10);


        return view('layouts.content.list.vehicles', compact('vehicles'));
    }

    public function create()
    {
        $vehicles = Vehicle::all();

        return view('layouts.content.create-update.vehicles', compact('vehicles'));
    }

    public function edit(Request $request, int $id)
    {

        $vehicle = Vehicle::where('id' , $id)->first();
        if (!$vehicle) {
            return redirect()->route('vehicles.list')->with('error', 'Kullanıcı bulunamadı.');
        }


        return view('layouts.content.create-update.vehicles', compact('vehicle')

        );
    }
    public function store(Request $request)
    {




        $data = $request->except(['_token']);
        if (!empty($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        } else {
            $data['password'] = bcrypt('defaultpassword');
        }





        $data['user_id'] = $request->input('user_id');
        $data['brand'] = $request->input('brand');
        $data['model'] = $request->input('model');
        $data['color'] = $request->input('color');
        $data['kilometers'] = $request->input('kilometers');
        $data['vehicle_register_plate'] = $request->input('vehicle_register_plate');
        $data['VIN'] = $request->input('VIN');
        $data['fuel_type'] = $request->input('fuel_type');


        Vehicle::create($data);
        return redirect()->route('dashboard')->with([
            'success' => 'İşlem başarıyla gerçekleştirildi!',
            'alert_message' => 'Kullanıcı Oluşturma'
        ]);


    }

    public function update(Request $request, int $vehicleId)
    {
        $vehicle = Vehicle::query()->find($vehicleId);




        $data = $request->except(['_token', '_method']);

        $data['user_id'] = $request->input('user_id');
        $data['brand'] = $request->input('brand');
        $data['model'] = $request->input('model');
        $data['color'] = $request->input('color');
        $data['kilometers'] = $request->input('kilometers');
        $data['vehicle_register_plate'] = $request->input('vehicle_register_plate');
        $data['VIN'] = $request->input('VIN');
        $data['fuel_type'] = $request->input('fuel_type');


        $vehicle->update($data);
        return redirect()->route('vehicles.list')->with([
            'success' => 'İşlem başarıyla gerçekleştirildi!',
            'alert_message' => 'Kullanıcı Güncelleme'
        ], compact('vehicle'));

    }

}
