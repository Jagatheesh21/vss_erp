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
use App\Http\Controllers\StagewiseReceiveController;
use App\Http\Controllers\StagewiseIssueController;
use App\Http\Controllers\GrnRejectionController;

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
    Route::get('rm_issuance', [GRNInwardRegisterController::class,'rmIssuanceData'])->name('rmissuance.index');
    Route::get('rm_issuance-create', [GRNInwardRegisterController::class,'rmIssuance'])->name('rmissuance.create');
    Route::post('/rm_issuance-data', [GRNInwardRegisterController::class,'storeData'])->name('rmissuance.storedata');
    Route::post('/rm_issuance-fetchdata', [GRNInwardRegisterController::class,'grnRmFetchData'])->name('grnrmfetchdata');
    Route::post('/rm_heatno-fetchdata', [GRNInwardRegisterController::class,'grnHeatFetchData'])->name('grnheatfetchdata');
    Route::post('/rm_coilno-fetchdata', [GRNInwardRegisterController::class,'grnCoilFetchData'])->name('grncoilfetchdata');
    Route::get('sf_receive/list', [StagewiseReceiveController::class,'sfReceiveList'])->name('sfreceive');
    Route::get('sf_receive/create', [StagewiseReceiveController::class,'sfReceiveCreateForm'])->name('sfreceive.create');
    Route::post('sf-receive', [StagewiseReceiveController::class,'sfReceiveEntry'])->name('sfreceive.store');
    Route::post('sf-receive/part_no', [StagewiseReceiveController::class,'sfPartFetchEntry'])->name('sfpartfetchdata');
    Route::get('sf_issue/list', [StagewiseIssueController::class,'sfIssueList'])->name('sfissue');
    Route::get('sf_issue/create', [StagewiseIssueController::class,'sfIssueCreateForm'])->name('sfissue.create');
    Route::post('sf_issue', [StagewiseIssueController::class,'sfIssueEntry'])->name('sfissue.store');
    Route::post('sf_issue/part_no', [StagewiseIssueController::class,'sfIssuePartFetchEntry'])->name('sfissuepartfetchdata');
    Route::get('os_receive/list', [StagewiseReceiveController::class,'osReceiveList'])->name('osreceive');
    Route::get('os_receive/create', [StagewiseReceiveController::class,'osReceiveCreateForm'])->name('osreceive.create');
    Route::post('os-receive', [StagewiseReceiveController::class,'osReceiveEntry'])->name('osreceive.store');
    Route::post('os-receive/part_no', [StagewiseReceiveController::class,'osPartFetchEntry'])->name('ospartfetchdata');
    Route::get('fqc_inspection/list', [StagewiseReceiveController::class,'osReceiveList'])->name('osreceive');

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
        'grnqcrejection' => GrnRejectionController::class,
        'process-master' => ItemProcesmasterController::class,
    ]);
});

