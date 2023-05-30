<?php

use App\Http\Controllers\Admin\Products;
use App\Http\Controllers\Authentication;
use App\Http\Controllers\Admin\Orders;
use App\Http\Controllers\Orders as ControllersOrders;
use App\Models\Product;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function (Product $product) {
    $products = $product->whereStatus('active')->orderBy('id','desc')->get();
    return view('welcome',compact('products'));
});

Route::prefix('admin')->name('admin.')->group(function(){

Route::get('/login',[Authentication::class,'login']);
Route::redirect('/','/admin/login');
Route::post('/signin',[Authentication::class,'signin'])->name('signin');

Route::middleware('user_auth')->group(function(){

    Route::get('dashboard',[Authentication::class,'dashboard'])->name('dashboard');
    Route::get('logout',[Authentication::class,'logout'])->name('logout');
    Route::resource('products',Products::class);
    Route::get('orders',[Orders::class,'index'])->name('orders.index');
});
});

Route::post('place-order',[ControllersOrders::class,'place_order'])->name('orders.place_order');
Route::post('stripe', [ControllersOrders::class,'stripe_payment'])->name('stripe.post');
Route::get('order-success',[ControllersOrders::class,'payment_success'])->name('payment_success');
Route::put('order-update/{order}',[ControllersOrders::class,'update'])->name('orders.update');