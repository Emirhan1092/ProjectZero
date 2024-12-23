<?php

namespace App\Http\Controllers;

use App\Http\Requests\InformationFileRequest;
use App\Models\Car;
use App\Models\CarPart;
use App\Models\CarSchemas;
use App\Models\Cart;
use App\Models\Insurer;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class InformationController extends Controller
{



    public function create()
    {
        return view('layouts.content.create-update.information-files');
    }


    public function generatePDF($finalResult)
    {
        $pdf = PDF::loadView('pdf.report', ['data' => $finalResult]);

        $pdfContent = $pdf->output();
        $title = "merhaba";
        $body = "merhaba";
        $subject ="merhaba";
        $emailController = new EmailController();
        $emailController->sendWelcomeEmail($title, $body, $subject, $pdfContent);
        $pdf->save(storage_path('app/public/report.pdf'));

        return $pdf->download('report.pdf');
    }


    public function store(Request $request)
    {



        $InsurerInformations = [];
        $Insurer = collect($request->input())
            ->filter(function ($value, $key) {
                return Str::startsWith($key, 'insurer');

            })
            ->toArray();

        foreach ($Insurer as $key => $value) {
            $InsurerId = $value;
            $InsurerModel = Insurer::where('id', $InsurerId)->first();
            $InsurerInformations[] = [
                'insurer_id' => $InsurerId,
                'insurer_name' => $InsurerModel->insurer_name,
                'insurer_address' => $InsurerModel->address,
                'insurer_email' => $InsurerModel->email,
            ];
        }




        $files = $request->allFiles();
        $authName = auth()->user()->name;
        $authId = auth()->user()->id;

        $partInfo = [];


        $partInfoValues = collect($request->input())
            ->filter(function ($value, $key) {
                return Str::startsWith($key, 'partInfo');

            })
            ->toArray();
        if (!$partInfoValues) {

            return redirect()->back()->withErrors(['partInfo' => 'En az bir parça seçilmelidir.']);
        }
        $customerInformations = [];
        $customer = null;
        foreach ($partInfoValues as $key => $value) {

            $part_id = explode('/', $value)[0];
            $count = explode('/', $value)[1];
            $part_group_id = explode('/', $value)[2];
            $car_id = explode('/', $value)[3];

            $partInfo[] = [
                'part_id' => $part_id,
                'model_name' => Car::where('car_id', $car_id)->first()->model_name,
                'brand_name' => Car::where('car_id', $car_id)->first()->brand_name,
                'car_img' => CarPart::where('group_id', $part_group_id)
                             ->where('car_id', $car_id)
                             ->where('part_id', $part_id)
                             ->first()->img,
                'count' => $count,

            ];

            $customer =  Cart::where('part_id' , $part_id)->first();


        }
        if($customer){
            $customerInformations[] = [
                'customer_id'  =>$customer->customer_id,
                'customer_name' => User::where('id' , $customer->customer_id)->first()->name,
                'customer_phone_number' => User::where('id' , $customer->customer_id)->first()->phone_number,
                'customer_car_id' => $customer->customer_car_id,
            ];


        }
        $finalResult = [];
        $result = [];
        if (!empty($files)) {

            foreach ($files as $key => $fileArray) {
                if (is_array($fileArray)) {
                    foreach ($fileArray as $file) {
                        $extention = $file->getClientOriginalExtension();
                        $originalName = $file->getClientOriginalName();
                       $originalNameExploded = explode('.', $originalName)[0];
                        $originalNameFinal = Str::slug($originalNameExploded) . '.' . $extention;
                        $folder = "customer";
                        $storagePath = storage_path("app/public/" . $folder . "/" . $originalNameFinal);
                        if (file_exists($storagePath)) {
                            return redirect()->back()->withErrors([
                                'image' => "Aynı görsel daha önce yüklenmiştir."
                            ]);
                        }
                        else {
                            $file->storeAs($folder, $originalNameFinal, 'public');
                        }



                        $result[] = [
                            'file_name' => $key,
                            'file' => $originalNameFinal,
                        ];
                    }
                }
            }
        }
        $finalResult[] = [
            'files' => $result,
            'saved_by_name' => $authName,
            'saved_by_id' => $authId,
            'part_info' => $partInfo,
            'customer_informations' => $customerInformations,
            'insurer_informations' => $InsurerInformations,
        ];
        $this->generatePDF($finalResult);

        $finalResult = $finalResult[0];

        $files = json_encode($finalResult['files']);
        $partInfo = json_encode($finalResult['part_info']);
        $customerInformations = json_encode($finalResult['customer_informations']);
        $insurerInformations = json_encode($InsurerInformations);

        DB::table('customer_files_ınformations')->insert([
            'saved_by_name' => $finalResult['saved_by_name'],
            'saved_by_id' => $finalResult['saved_by_id'],
            'files' => $files,
            'part_info' => $partInfo,
            'customer_informations' => $customerInformations,
            'insurer_informations' => $insurerInformations,
        ]);


        return redirect()->route('addInformations.create')->with([
            'success' => 'İşlem Bşarılı!',
            'alert_message' => 'Mail Gönderme Ve Kaydetme Başarılı'
        ]);

    }





    public function getParametersByUser($userId)
    {
       $shoppingCartInfos =  Cart::where('customer_id', $userId)
           ->where('added_by_user_id' , auth()->id())
           ->get();

       $result = [];
       foreach ($shoppingCartInfos as $shoppingCartInfo) {

           $result[] =  [
               'part_id' => $shoppingCartInfo->part_id,
               'image' => $shoppingCartInfo->img,
               'count' => $shoppingCartInfo->count,
               'part_group_id' => $shoppingCartInfo->group_id,
               'car_id' => $shoppingCartInfo->car_id,
           ];

       }


       return response()->json($result);


    }
    public function updatePartCount(Request $request)
    {


        $partId = $request->input('part_id');
        $groupId = $request->input('group_id');
        $carId = $request->input('car_id');
        $newCount = $request->input('count');

        $cart = Cart::where('part_id', $partId)
            ->where('group_id', $groupId)
            ->where('car_id', $carId)
            ->first();

        if ($cart) {
            $cart->count = $newCount;
            $cart->save();

            return response()->json(['status' => 'success', 'message' => 'Count güncellendi']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Kayıt bulunamadı'], 404);
        }
    }

}

