<?php

namespace App\Http\Controllers;

use App\Models\CarOwner;
use Illuminate\Http\Request;

class CarOwnerController extends Controller
{
    public function list(Request $request)
    {
        $carOwners = CarOwner::query()
            ->where(function ($query) use ($request) {
                $query->where('id', 'LIKE', '%' . $request->id . '%')
                    ->where('user_id', 'LIKE', '%' . $request->user_id . '%')
                    ->where('vehicle_id', 'LIKE', '%' . $request->vehicle_id . '%')
                    ->where('accident_id', 'LIKE', '%' . $request->accident_id . '%')
                    ->where('name', 'LIKE', '%' . $request->name . '%')
                    ->where('licence_informations', 'LIKE', '%' . $request->licence_informations . '%')
                    ->where('email', 'LIKE', '%' . $request->email . '%')

                    ->where('phone_number', 'LIKE', '%' . $request->phone_number . '%')
                    ->where('address', 'LIKE', '%' . $request->address . '%')
                    ->where('birth_date', 'LIKE', '%' . $request->birth_date . '%');


            })->paginate(10);


        return view('layouts.content.list.car-owners', compact('carOwners'));
    }
}
