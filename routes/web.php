<?php

use App\Http\Controllers\AccidentController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\DataCarController;
use App\Http\Controllers\ExpertiseController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CarOwnerController;

use App\Http\Controllers\InfoUserController;
use App\Http\Controllers\InsurerController;
use App\Http\Controllers\LawyerController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\RepairmanController;
use App\Http\Controllers\ResetController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\ShoppingCartController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::group(['middleware' => 'auth'], function () {

    Route::get('/', [HomeController::class, 'home']);
	Route::get('dashboard', function () {
		return view('dashboard');
	})->name('dashboard');

	Route::get('billing', function () {
		return view('billing');
	})->name('billing');

	Route::get('profile', function () {
		return view('profile');
	})->name('profile');


    Route::get('static-sign-in', function () {
		return view('static-sign-in');
	})->name('sign-in');

    Route::post('/user/store', [UserController::class, 'store'])->name('users.store');
    Route::post('/user/{id}/update', [UserController::class, 'update'])->name('users.update');
    Route::get('user/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::get('/user/create' , [UserController::class, 'create'])->name('users.create');
    Route::get('/user/list' , [UserController::class , 'list']  )->name('users.list');




    Route::get('/cars/catalog/{catalogName}/models', [DataCarController::class, 'getModelsByCatalog']);
    Route::get('/cars/catalog/{catalogName}/models/{modelName}/parameters', [DataCarController::class, 'getParametersByModel']);
    Route::get('/cars/models/{modelName}/parameters', [DataCarController::class, 'carParameterList']);
    Route::get('/cars/catalog', [DataCarController::class, 'list'])->name('catalog.list');
    Route::get('/cars/car_id/{carId}/parameters', [DataCarController::class, 'carGroupList']);
    Route::get('car/catalog/{part_group_id}/parameters' , [DataCarController::class, 'getParametersByPartGroup']);
    Route::match(['get', 'post'],'cars/shoppingCart/{partId}/{group_id}/parameters', [DataCarController::class, 'getShoppingCart']);
    Route::get('/shoppingCart/partId/{partId}/groupId/{groupId}/parameters', [ShoppingCartController::class, 'getShoppingCartPartGroup']);
    Route::get('/shoppingCart' , [ShoppingCartController::class, 'getShoppingCartPart'])->name('shopping.cart');
    Route::get('/shoppingCart/List' , [ShoppingCartController::class, 'list'])->name('shopping.cart.list');
    Route::get('/shopping-cart/increase/{user_id}/{group_id}/{part_id}', [ShoppingCartController::class, 'increaseQuantity'])->name('shoppingCart.increaseQuantity');
    Route::match(['get', 'post'] ,'/cart/decrease-quantity/{userId}/{groupId}/{partId}', [ShoppingCartController::class, 'decreaseQuantity']);

    Route::get('/accident/list' , [AccidentController::class, 'list'])->name('accident.list');

    Route::post('/accident/store', [AccidentController::class, 'store'])->name('accidents.store');
    Route::post('/accident/{id}/update', [AccidentController::class, 'update'])->name('accidents.update');
    Route::get('/accident/{id}/edit', [AccidentController::class, 'edit'])->name('accidents.edit');
    Route::get('/accident/create' , [AccidentController::class, 'create'])->name('accidents.create');

    Route::get('/insurer/list' , [InsurerController::class, 'list'])->name('insurer.list');
    Route::get('/lawyer/list' , [LawyerController::class, 'list'])->name('lawyer.list');
    Route::get('/carOwners/list' , [CarOwnerController::class, 'list'])->name('carOwners.list');
    Route::get('/repairmans/list' ,  [RepairmanController::class, 'list'])->name('repairmans.list');
    Route::get('/experts/list' ,  [ExpertiseController::class, 'list'])->name('experts.list');

    Route::get('static-sign-up', function () {
		return view('static-sign-up');
	})->name('sign-up');

    Route::get('/logout', [SessionsController::class, 'destroy']);
	Route::get('/user-profile', [InfoUserController::class, 'create']);
	Route::post('/user-profile', [InfoUserController::class, 'store']);
    Route::get('/login', function () {
		return view('dashboard');
	})->name('sign-up');
});



Route::group(['middleware' => 'guest'], function () {
    Route::get('/register', [RegisterController::class, 'create']);
    Route::post('/register', [RegisterController::class, 'store']);
    Route::get('/login', [SessionsController::class, 'create']);
    Route::post('/session', [SessionsController::class, 'store']);
	Route::get('/login/forgot-password', [ResetController::class, 'create']);
	Route::post('/forgot-password', [ResetController::class, 'sendEmail']);
	Route::get('/reset-password/{token}', [ResetController::class, 'resetPass'])->name('password.reset');
	Route::post('/reset-password', [ChangePasswordController::class, 'changePassword'])->name('password.update');

});

Route::get('/login', function () {
    return view('session/login-session');
})->name('login');
