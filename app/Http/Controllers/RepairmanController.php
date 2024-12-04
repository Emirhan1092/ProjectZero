<?php

namespace App\Http\Controllers;

use App\Models\RepairMan;
use Illuminate\Http\Request;

class RepairmanController extends Controller
{
    public function list(Request $request)
    {
        $repairmans = Repairman::query()
            ->where(function ($query) use ($request) {
                $query->where('id', 'LIKE', '%' . $request->id . '%')
                    ->where('user_id', 'LIKE', '%' . $request->user_id . '%')
                    ->where('name', 'LIKE', '%' . $request->name . '%')
                    ->where('shop_name', 'LIKE', '%' . $request->shop_name . '%')
                    ->where('address', 'LIKE', '%' . $request->address . '%')
                    ->where('phone_number', 'LIKE', '%' . $request->phone_number . '%')
                    ->where('number_of_services', 'LIKE', '%' . $request->number_of_services . '%')
                    ->where('rating', 'LIKE', '%' . $request->rating . '%')
                    ->where('status', 'LIKE', '%' . $request->status . '%')
                    ->where('star', 'LIKE', '%' . $request->star . '%')
                    ->where('start_date', 'LIKE', '%' . $request->start_date . '%');



            })->paginate(10);


        return view('roles.repairmans.list', compact('repairmans'));
    }
}
