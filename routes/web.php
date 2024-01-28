<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\RawMaterialCategoryController;
use App\Http\Controllers\RawMaterialController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\SupplierProductController;
use App\Http\Controllers\PODetailController;
use App\Http\Controllers\POProductDetailController;

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

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/suppliers-data/id', [SupplierController::class,'suppliersdata'])->name('suppliersdata');
Route::get('/rmcategorydata-data/id', [SupplierProductController::class,'rmcategorydata'])->name('rmcategorydata');
Route::get('/posuppliers-data/id', [PODetailController::class,'posuppliersdata'])->name('posuppliersdata');
Route::get('/posuppliersrmdata-data/{raw_material_category_id}/{scode}', [PODetailController::class,'posuppliersrmdata'])->name('posuppliersrmdata');

Route::resources([
    'roles' => RoleController::class,
    'users' => UserController::class,
    'products' => ProductController::class,
    'department' => DepartmentController::class,
    'raw_material_category' => RawMaterialCategoryController::class,
    'raw_material' => RawMaterialController::class,
    'supplier' => SupplierController::class,
    'supplier-products' => SupplierProductController::class,
    'po' => PODetailController::class,
    'po-products' => POProductDetailController::class,
]);
