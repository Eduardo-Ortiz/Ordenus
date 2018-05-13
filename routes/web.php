<?php

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
Route::get('control/orders/login/{area}', 'Control\OrdersController@login');

Route::post('control/orders/login', 'Control\OrdersController@authenticate');

Route::get('control/orders', 'Control\OrdersController@index');

Route::get('control/orders/panel', 'Control\OrdersController@panel');

Route::get('control/orders/fetch', 'Control\OrdersController@fetch');


Route::get('/admin', function () {
    return view('admin/index');
});

Route::delete('admin/products/parent/{product}', 'Admin\ProductController@destroyFromParent');

Route::post('admin/products/update/{product}', 'Admin\ProductController@updateProduct');

Route::resource('admin/products','Admin\ProductController', [
    'as' => 'admin'
]);

Route::delete('admin/menu-categories/parent/{menu_category}', 'Admin\MenuCategoriesController@destroyFromParent');

Route::resource('admin/menu-categories','Admin\MenuCategoriesController', [
    'as' => 'admin'
]);


Route::resource('admin/areas','Admin\AreaController', [
    'as' => 'admin'
]);

Route::resource('admin/areas','Admin\AreaController', [
    'as' => 'admin'
]);

Route::get('admin/units', function () {
    return view('admin/units/index');
});

Route::post('admin/units/edit/{unit}', 'Admin\UnitController@update');

Route::resource('admin/units','Admin\UnitController', [
    'as' => 'admin'
]);

Route::get('admin/supplies/allunits/{supply}', 'Admin\SupplyController@getUnits');

Route::post('admin/supplies/all', 'Admin\SupplyController@getAll');

Route::delete('admin/supplies/parent/{supply}', 'Admin\SupplyController@destroyFromParent');

Route::resource('admin/supplies','Admin\SupplyController', [
    'as' => 'admin'
]);

Route::post('admin/supplies-categories/supplies', 'Admin\SuppliesCategoriesController@getChilds');

Route::delete('admin/supplies-categories/parent/{supplies_category}', 'Admin\SuppliesCategoriesController@destroyFromParent');

Route::resource('admin/supplies-categories','Admin\SuppliesCategoriesController', [
    'as' => 'admin'
]);

Route::get('admin/equivalences/{unit}', 'Admin\EquivalencesController@getFromUnit');

Route::get('admin/equivalences/available/{unit}', 'Admin\EquivalencesController@getAvailableEquivalences');

Route::post('admin/equivalences', 'Admin\EquivalencesController@store');

Route::delete('admin/equivalences', 'Admin\EquivalencesController@destroy');

Route::get('icons/{class}', 'IconsController@getAll');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::get('menu', 'General\MenuController@index');

Route::get('menu/{menu_category}', 'General\MenuController@category')->name('menu.categories');


