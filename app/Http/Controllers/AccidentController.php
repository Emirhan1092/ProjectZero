<?php

namespace App\Http\Controllers;

use App\Models\Accident;
use Illuminate\Http\Request;

class AccidentController extends Controller

{
    public function list(Request $request)
    {
        $accidents = Accident::query()
            ->where(function ($query) use ($request) {
                $query->where('id', 'LIKE', '%' . $request->id . '%')
                    ->where('vehicle_id', 'LIKE', '%' . $request->vehicle_id . '%')
                    ->where('user_id', 'LIKE', '%' . $request->user_id . '%')
                    ->where('repairman_id', 'LIKE', '%' . $request->repairman_id . '%')
                    ->where('accident_type', 'LIKE', '%' . $request->accident_type . '%')
                    ->where('accident_date', 'LIKE', '%' . $request->accident_data . '%')
                ->where('description', 'LIKE', '%' . $request->description . '%')
                    ->where('accident_status', 'LIKE', '%' . $request->accident_status . '%');

            })->paginate(10);


        return view('layouts.content.list.accidents', compact('accidents'));
    }

    public function create()
    {
        $accidents = Accident::all();

        return view('layouts.content.create-update.accidents', compact('accidents'));
    }

    public function edit(Request $request, int $userID)
    {

        $accident = Accident::where('id' , $userID)->first();
        if (!$accident) {
            return redirect()->route('accidents.list')->with('error', 'Kullanıcı bulunamadı.');
        }


        return view('layouts.content.create-update.accidents', compact('accident')

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





        $data['repairman_id'] = $request->input('repairman_id');
        $data['user_id'] = $request->input('user_id');
        $data['vehicle_id'] = $request->input('vehicle_id');
        $data['user_id'] = $request->input('user_id');
        $data['accident_status'] = $request->input('accident_status');
        $data['accident_type'] = $request->input('accident_type');
        $data['description'] = $request->input('description');


        Accident::create($data);
        return redirect()->route('dashboard')->with([
            'success' => 'İşlem başarıyla gerçekleştirildi!',
            'alert_message' => 'Kullanıcı Oluşturma'
        ]);


    }

    public function update(Request $request, int $accidentID)
    {
        $accident = Accident::query()->find($accidentID);




        $data = $request->except(['_token', '_method']);

        $data['repairman_id'] = $request->input('repairman_id');
        $data['user_id'] = $request->input('user_id');
        $data['vehicle_id'] = $request->input('vehicle_id');
        $data['user_id'] = $request->input('user_id');
        $data['accident_status'] = $request->input('accident_status');
        $data['accident_type'] = $request->input('accident_type');
        $data['description'] = $request->input('description');

        $accident->update($data);
        return redirect()->route('accidents.list')->with([
            'success' => 'İşlem başarıyla gerçekleştirildi!',
            'alert_message' => 'Kullanıcı Güncelleme'
        ], compact('accident'));

    }



}
