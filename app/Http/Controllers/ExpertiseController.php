<?php

namespace App\Http\Controllers;

use App\Models\Expertise;
use Illuminate\Http\Request;

class ExpertiseController extends Controller
{
    public function list(Request $request)
    {
        $experts = Expertise::query()
            ->where(function ($query) use ($request) {
                $query->where('id', 'LIKE', '%' . $request->id . '%')
                    ->where('user_id', 'LIKE', '%' . $request->user_id . '%')
                    ->where('name', 'LIKE', '%' . $request->name . '%')
                    ->where('email', 'LIKE', '%' . $request->email . '%')
                    ->where('company_name', 'LIKE', '%' . $request->company_name . '%')
                    ->where('phone_number', 'LIKE', '%' . $request->phone_number . '%')
                    ->where('expertise_area', 'LIKE', '%' . $request->expertise_area . '%')
                    ->where('number_of_services', 'LIKE', '%' . $request->number_of_services . '%')
                    ->where('rating', 'LIKE', '%' . $request->rating . '%')
                    ->where('status', 'LIKE', '%' . $request->status . '%')
                    ->where('star', 'LIKE', '%' . $request->star . '%')
                    ->where('start_date', 'LIKE', '%' . $request->start_date . '%');

            })->paginate(10);


        return view('roles.experts.list', compact('experts'));
    }
}
