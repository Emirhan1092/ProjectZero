<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CustomerAndVehicleController extends Controller
{

    public function create()
    {


        return view('layouts.content.create-update.customers-and-vehicles');
    }




    public function store(Request $request)
    {


        if ($request->hasFile('image')) {
            $imageFile = $request->file('image');
            $originalName  = $imageFile->getClientOriginalName();
            $originalExtension = $imageFile->getClientOriginalExtension();
            $explodeName = explode('.', $originalName)[0];
            $fileName = Str::slug($explodeName) . '.' . $originalExtension;
            $folder = "/users" ;
            $publicPath = "/storage/app/public/" . $folder ;
            if (file_exists(public_path($publicPath . "/" . $fileName))) {
                return redirect()->back()->withErrors([
                    'image' => "Aynı görsel daha önce yüklenmiştir."
                ]);
            }

        }


        $data = $request->except(['_token', 'image' , 'brand' , 'model' , 'year' , 'color' , 'kilometers' , 'VIN' ,'engine_number' , 'fuel_type']);
        $dataforCar = $request->except(['_token', 'image' , 'name','email' ,'phone_number']);

        if (!empty($data['password']))
        {
            $data['password'] = bcrypt($data['password']);
        }
        else
        {
            $data['password'] = bcrypt('defaultpassword');
        }


        if ($request->hasFile("image")) {
            $data["image"] = $publicPath . "/" . $fileName;
            $imageFile->storeAs($folder, $fileName, "public");
        }
        $data['role'] = 'car_owner';
       $role =  User::where('role' , 'car_owner')->get();
       $roleId  = $role->first()->role_id;
       $data['role_id'] = $roleId;

        $data['phone_number'] = $request->input('phone_number');
        $data['name'] = $request->input('name');
        $data['email'] = $request->input('email');
        $data['remember_token'] = Str::random(10);


        $user = User::create($data);

        $userId = $user->id;
        $dataforCar['user_id'] = $userId;
        $dataforCar['brand'] = $request->input('brand');
        $dataforCar['year'] = $request->input('year');

        $dataforCar['model'] = $request->input('model');
        $dataforCar['color'] = $request->input('color');

        $dataforCar['kilometers'] = $request->input('kilometers');
        $dataforCar['vehicle_register_plate'] = $request->input('vehicle_register_plate');
        $dataforCar['VIN'] = $request->input('VIN');
        $dataforCar['fuel_type'] = $request->input('fuel_type');


       Vehicle::create($dataforCar);





        return redirect()->route('dashboard')->with([
            'success' => 'İşlem başarıyla gerçekleştirildi!',
            'alert_message' => 'Müşteri ve Araç Oluşturma'
        ]);



    }


}




