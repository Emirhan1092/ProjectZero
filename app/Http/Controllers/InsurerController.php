<?php

namespace App\Http\Controllers;

use App\Models\Insurer;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InsurerController extends Controller
{

    public function list(Request $request)
    {
        $insurers = Insurer::query()
            ->where(function ($query) use ($request) {
                $query->where('id', 'LIKE', '%' . $request->id . '%')
                    ->where('user_id', 'LIKE', '%' . $request->user_id . '%')
                    ->where('insurer_name', 'LIKE', '%' . $request->insurer_name . '%')
                    ->where('insurance_company', 'LIKE', '%' . $request->insurance_company . '%')
                    ->where('email', 'LIKE', '%' . $request->email . '%')
                    ->where('phone_number', 'LIKE', '%' . $request->phone_number . '%')
                    ->where('address', 'LIKE', '%' . $request->address . '%');

            })->paginate(10);


        return view('layouts.content.list.insurers', compact('insurers'));
    }












}
