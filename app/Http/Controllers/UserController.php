<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function list(Request $request)
    {
        $users = User::query()
        ->where(function ($query) use ($request) {
            $query->where('name' , 'LIKE' ,'%' . $request->name . '%' )
                ->where('email' , 'LIKE' ,'%' . $request->mail . '%' )
                ->where('phone_number' , 'LIKE' ,'%' . $request->phone_number . '%' )
                ->where('id' , 'LIKE' ,'%' . $request->id . '%' )
                ->where('role_id' , 'LIKE' , '%' . $request->role_id . '%')
                ->where('role' , 'LIKE' , '%' . $request->role . '%');

        })->paginate(10);


        return view('roles.users.list', compact('users'));
    }

    public function create()
    {
        $users = User::all();

        return view('roles.users.create-update', compact('users'));
    }
    public function edit(Request $request, int $userID)
    {
        $user = User::find($userID);

        if (!$user) {
            return redirect()->route('user.list')->with('error', 'Kullanıcı bulunamadı.');
        }




        return view('roles.users.create-update', compact('user')

        );
    }




    public function store(UserRequest $request)
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


        $data = $request->except(['_token', 'image']);
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

        $roleData = json_decode($request->input('role'), true);

        if(!empty($roleData)){
            if(!empty($roleData['role'] && $roleData['role_id'])){}
            {
                $data['role'] = $roleData['role'];
                $data['role_id'] = $roleData['role_id'];

            }

        }
        $data['phone'] = $request->input('phone');
        $data['name'] = $request->input('name');
        $data['email'] = $request->input('email');
        User::create($data);
        return redirect()->route('dashboard')->with([
            'success' => 'İşlem başarıyla gerçekleştirildi!',
            'alert_message' => 'Kullanıcı Oluşturma'
        ]);



    }

    public  function  update(Request $request, int $userID)
    {
        $user = User::query()->find($userID);

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
        $data = $request->except(['_token', '_method', 'image']);

        if($request->hasFile("image")) {
            if($user && $user->image)
            {
                Storage::disk('public')->delete($user->image); // Eski görseli sil

            }
                $data["image"] = $publicPath . "/" . $fileName;
                $imageFile->storeAs($folder, $fileName, "public");

        }
        if(!empty($roleData)){
            if(!empty($roleData['role'] && $roleData['role_id'])){}
            {
                $data['role'] = $roleData['role'];
                $data['role_id'] = $roleData['role_id'];

            }

        }
        $data['email'] = $request->input('email');
        $data['password'] = bcrypt($request->input('password'));
        $data['phone'] = $request->input('phone');
        $user->update($data);
        return redirect()->route('users.list')->with([
            'success' => 'İşlem başarıyla gerçekleştirildi!',
            'alert_message' => 'Kullanıcı Güncelleme'
        ] , compact('user'));

    }
}


