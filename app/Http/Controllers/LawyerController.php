<?php

namespace App\Http\Controllers;

use App\Models\Lawyer;
use Illuminate\Http\Request;

class LawyerController extends Controller
{

    public function list(Request $request)
    {
        $lawyers = Lawyer::query()
            ->where(function ($query) use ($request) {
                $query->where('id', 'LIKE', '%' . $request->id . '%')
                    ->where('user_id', 'LIKE', '%' . $request->user_id . '%')
                    ->where('name', 'LIKE', '%' . $request->name . '%')
                    ->where('email', 'LIKE', '%' . $request->email . '%')
                    ->where('phone_number', 'LIKE', '%' . $request->phone_number . '%')
                    ->where('address', 'LIKE', '%' . $request->address . '%')
                ->where('specialization', 'LIKE', '%' . $request->specialization . '%')
                ->where('license_expiry', 'LIKE', '%' . $request->license_expiry . '%');


            })->paginate(10);


        return view('layouts.content.list.lawyers', compact('lawyers'));
    }

}
