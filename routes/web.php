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
use App\Http\Controllers\PoCorrectionController;
use App\Http\Controllers\RackmasterController;
use App\Http\Controllers\RackStockmasterController;
use App\Http\Controllers\GRNInwardRegisterController;
use App\Http\Controllers\GrnQualityController;
use App\Http\Controllers\HeatNumberController;
use App\Http\Controllers\ItemProcesmasterController;
use App\Http\Controllers\DcMasterController;

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

Route::middleware(['auth'])->group(function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/suppliers-data/id', [SupplierController::class,'suppliersdata'])->name('suppliersdata');
    Route::get('/rmcategorydata-data/id', [SupplierProductController::class,'rmcategorydata'])->name('rmcategorydata');
    Route::post('add_purchase_item', [PODetailController::class,'addPurchaseItem'])->name('add_purchase_item');
    Route::post('add_grn_item', [GRNInwardRegisterController::class,'addGRNItem'])->name('add_grn_item');
    Route::get('/posuppliers-data/id', [PODetailController::class,'posuppliersdata'])->name('posuppliersdata');
    Route::post('/posuppliersrmdata-data', [PODetailController::class,'posuppliersrmdata'])->name('posuppliersrmdata');
    Route::post('/posuppliersproductdata-data', [PODetailController::class,'posuppliersproductdata'])->name('posuppliersproductdata');
    Route::get('/poprint-data/{id}', [PODetailController::class,'poprint'])->name('po.print');
    Route::get('/pocorrection-data/{id}', [PODetailController::class,'pocorrection'])->name('po.correction');
    Route::get('/pocorrection-approval-data/{id}', [PoCorrectionController::class,'approval'])->name('pocorrection.approval');
    Route::get('/grnsuppliers-fetchdata/id', [PODetailController::class,'grn_supplierfetchdata'])->name('grn_supplierfetchdata');
    Route::get('/grnrm-fetchdata/id', [GRNInwardRegisterController::class,'grn_rmfetchdata'])->name('grn_rmfetchdata');
    Route::get('/grn_iqc-data/{id}', [GrnQualityController::class,'approval'])->name('grn_iqc.approval');

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
        'po-correction' => PoCorrectionController::class,
        'rack-stockmaster' => RackStockmasterController::class,
        'rackmaster' => RackmasterController::class,
        'grn_inward' => GRNInwardRegisterController::class,
        'grn_heat_no' => HeatNumberController::class,
        'grn_qc' => GrnQualityController::class,
        'process-master' => ItemProcesmasterController::class,
        'dc_master' => DcMasterController::class,
        
    ]);
});

