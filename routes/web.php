<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CommonController;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Middleware\Validuser;
use App\Http\Controllers\Admin\AdminController as AdminControllerMain;
use Illuminate\Support\Facades\Route;


Route::get('/', [AdminController::class, 'index'])->name('login');
Route::get('/register', [AdminController::class, 'register'])->name('register');
Route::post('/store', [AdminController::class, 'store'])->name('store');

Route::post('/checkadmin', [AdminController::class, 'checkadmin'])->name('checkadmin');
Route::post('/delete', [AdminController::class, 'delete'])->name('delete');
Route::get('/logout', [AdminController::class, 'logout'])->name('logout');

Route::get('/error', function () {
    abort(500);
});

Route::get('/admin/profile', [AdminControllerMain::class, 'profile'])->name('admin.profile');

Route::get('/admin/logout', [AdminControllerMain::class, 'logout'])->name('admin.logout');
Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard')->middleware(Validuser::class);

Route::middleware([Validuser::class, RoleMiddleware::class])->group(function () {
    Route::get('/admin/dashboard', [AdminControllerMain::class, 'dashboard'])->name('admin.dashboard');

    Route::get('/admin/userdata', [AdminControllerMain::class, 'userdata'])->name('admin.userdata');
    Route::post('/admin/category', [AdminControllerMain::class, 'category'])
        ->name('admin.category');
    Route::post('/admin/subcategory', [AdminControllerMain::class, 'subcategory'])
        ->name('admin.subcategory');
    Route::post('common/getdata', [CommonController::class, 'getdata'])
        ->name('common.getdata');
    Route::post('common/getdatedata', [CommonController::class, 'getdatedata'])->name('common.getdatedata');
    Route::get('/admin/categories', [AdminControllerMain::class, 'categories'])
        ->name('admin.categories');
    Route::get('/admin/subcategories', [AdminControllerMain::class, 'subcategories'])
        ->name('admin.subcategories');


    Route::post('/admin/deletecategory', [AdminControllerMain::class, 'deletecategory'])
        ->name('admin.deletecategory');

    Route::post('/admin/deletesubcategory', [AdminControllerMain::class, 'deleteSubCategory'])
        ->name('admin.deleteSubCategory');

    Route::post('/admin/deleteproduct', [AdminControllerMain::class, 'deleteProduct'])
        ->name('admin.deleteProduct');

    Route::get('/admin/products', [AdminControllerMain::class, 'products'])
        ->name('admin.products');
    Route::post('/admin/productstore', [AdminControllerMain::class, 'productstore'])
        ->name('admin.productstore');

    Route::get('/admin/usersData', [AdminControllerMain::class, 'usersData'])->name('admin.usersData');
    Route::get('/admin/categorysData', [AdminControllerMain::class, 'categorysData'])->name('admin.categorysData');
    Route::get('/admin/subcategorysData', [AdminControllerMain::class, 'subcategorysData'])->name('admin.subcategorysData');
    Route::get('/admin/productsData', [AdminControllerMain::class, 'productsData'])->name('admin.productsData');
});


Route::post('/filter-data', [CommonController::class, 'filterData'])->name('filter-data');
