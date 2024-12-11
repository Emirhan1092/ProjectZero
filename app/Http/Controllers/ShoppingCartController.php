<?php

namespace App\Http\Controllers;

use App\Models\CarPart;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShoppingCartController extends Controller
{
    public function getShoppingCartPartGroup($partId , $groupId)
    {
       return $this->getShoppingCartPart($partId, $groupId);
    }

    public function getShoppingCartPart($partId, $groupId)
    {
        $currentUser = auth()->user();


        $partsInformations = CarPart::where('part_id', $partId)
            ->where('group_id', $groupId)
            ->join('catalog_cars', 'catalog_car_parts.car_id', '=', 'catalog_cars.car_id')
            ->select(
                'catalog_car_parts.car_id',
                'catalog_car_parts.part_id',
                'catalog_car_parts.img',
                'catalog_car_parts.number',
                'catalog_car_parts.name as part_name',
                'catalog_cars.name',
                'catalog_cars.model_name',
                'catalog_cars.brand_name'
            )
            ->distinct()
            ->get();
        foreach ($partsInformations as $part) {
            $existingCartItem = Cart::where('part_id', $part->part_id)
                ->where('group_id', $groupId)
                ->where('user_id', $currentUser->id)
                ->first();

            if (!$existingCartItem) {
                Cart::create([
                    'part_id' => $part->part_id,
                    'part_img' => $part->img,
                    'part_name' => $part->part_name,
                    'model_name' => $part->model_name,
                    'brand_name' => $part->brand_name,
                    'part_number' => $part->number,
                    'car_id' => $part->car_id,
                    'car_name' => $part->name,
                    'group_id' => $groupId,
                    'user_id' => $currentUser->id,
                    'user_name' => $currentUser->name,
                    'user_role' => $currentUser->role,
                    'quantity' => 1,
                ]);
                return redirect()->back()->with([
                    'success' => 'İşlem başarıyla gerçekleştirildi!',
                    'alert_message' => 'Sepete Eklendi'
                ]);
            } else {
                $existingCartItem->quantity += 1;
                $existingCartItem->save();
                return redirect()->back()->with([
                    'success' => 'İşlem başarıyla gerçekleştirildi!',
                    'alert_message' => 'Ürün miktarı arttırıldı '
                ]);
            }
        }

    }
    public function list()
    {
        $currentUser = auth()->user();
        $existingCartItem = Cart::where('user_id', $currentUser->id)
            ->where('user_role', $currentUser->role)
            ->where('user_id', $currentUser->id)
            ->get();
        return view('layouts.content.list.shopping-cart', compact('existingCartItem'));

    }

    public function increaseQuantity($userId, $groupId, $partId)
    {

        $cartItem = Cart::where('user_id', $userId)
            ->where('group_id', $groupId)
            ->where('part_id', $partId)
            ->first();

        if ($cartItem) {
            $cartItem->quantity += 1;
            $cartItem->save();
        }

        return response()->json(['new_quantity' => $cartItem->quantity]);
    }

    public function decreaseQuantity($userId, $groupId, $partId)
    {
        $cartItem = Cart::where('user_id', $userId)
            ->where('group_id', $groupId)
            ->where('part_id', $partId)
            ->first();

        if ($cartItem && $cartItem->quantity > 1) {
            $cartItem->quantity -= 1;
            $cartItem->save();
            return response()->json([
                'new_quantity' => $cartItem->quantity,
                'deleted' => false,
                'group_id' => $cartItem->group_id,
                'part_id' => $cartItem->part_id
            ]);
        }

        if ($cartItem && $cartItem->quantity == 1) {
            $cartItem->delete();
            return response()->json([
                'new_quantity' => 0,
                'deleted' => true,
                'group_id' => $cartItem->group_id,
                'part_id' => $cartItem->part_id
            ]);
        }

        return response()->json(['error' => 'Item not found'], 404);
    }




}

