<?php
// use Symfony\Component\Routing\Route;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::prefix('admin')->group(function () {
    Route::resource('products', ProductController::class);   
});

Route::get('/', 'ProductController@home');
Route::get('product/fetch_image/{id}', 'ProductController@fetch_image');
Route::get('product/fetch_detail/{id}', 'ProductController@fetch_detail');
Route::delete('image_detail/{id?}/delete', 'ProductImageController@destroy');