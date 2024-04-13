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
use App\Http\Controllers\DcMasterController;
use App\Http\Controllers\CustomerMasterController;
use App\Http\Controllers\CustomerPoMasterController;
use App\Http\Controllers\CustomerProductMasterController;
use App\Http\Controllers\FinalQcInspectionController;
use App\Http\Controllers\DcTransactionDetailsController;
use App\Http\Controllers\DcPrintController;
use App\Http\Controllers\InvoiceDetailsController;
use App\Http\Controllers\InvoiceCorrectionMasterController;
use App\Http\Controllers\InvoiceCorrectionDetailController;
// invoice updated
use App\Http\Controllers\PermissionController;

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
    Route::get('/customers-data/id', [CustomerMasterController::class,'customersData'])->name('customersdata');
    Route::post('customers-edit', [CustomerMasterController::class,'customersEditData'])->name('customerseditdata');
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
    Route::get('fg_receive/list', [StagewiseReceiveController::class,'fgReceiveList'])->name('fgreceive');
    Route::get('fg_receive/create', [StagewiseReceiveController::class,'fgReceiveCreateForm'])->name('fgreceive.create');
    Route::post('fg-receive', [StagewiseReceiveController::class,'fgReceiveEntry'])->name('fgreceive.store');
    Route::post('fg-receive/part_no', [StagewiseReceiveController::class,'fgPartFetchEntry'])->name('fgpartfetchdata');
    Route::get('fg-receive/fqc_approval', [StagewiseReceiveController::class,'fgFqcApproval'])->name('fgfqc');
    Route::post('dcfetch-rc', [DcTransactionDetailsController::class,'dcItemRc'])->name('dcitemrc');
    Route::get('/dcpart-data/id', [DcTransactionDetailsController::class,'dcPartData'])->name('dcpartdata');
    Route::post('dcsupplier-print', [DcPrintController::class,'dcSupplierPrintData'])->name('dcsupplierprintdata');
    Route::post('dcmulti-print', [DcPrintController::class,'dcMultiPrintData'])->name('dcmultiprintdata');
    Route::post('dcmulti-pdf', [DcPrintController::class,'dcMultiPdfData'])->name('dcmultipdf');
    Route::get('/dcmulti-receive', [DcPrintController::class,'ptsMultiDCReceive'])->name('ptsmultidcreceive');
    Route::get('/ptsdcmulti-receivelist', [DcPrintController::class,'ptsdcMultiList'])->name('ptsmultidcreceivelist');
    Route::get('/ptsdcmulti-inwardlist', [DcPrintController::class,'ptsInwardData'])->name('ptsinwarddata');
    Route::post('ptsdcmulti-receive', [DcPrintController::class,'ptsdcMultiReceiveData'])->name('ptsdcmultireceivedata');
    Route::post('ptsdcmulti-store', [DcPrintController::class,'ptsMultiDcStore'])->name('ptsdcmultidcstore');
    Route::get('pts_production_receive/list', [StagewiseReceiveController::class,'ptsProductionReceiveList'])->name('ptsproductionreceive');
    Route::get('pts_production_receive/create', [StagewiseReceiveController::class,'ptsProductionReceiveCreateForm'])->name('ptsproductionreceive.create');
    Route::post('pts_production-receive', [StagewiseReceiveController::class,'ptsProductionReceiveEntry'])->name('ptsproductionreceive.store');
    Route::post('pts_production-receive/part_no', [StagewiseReceiveController::class,'ptsProductionReceivePartFetchEntry'])->name('ptsproductionpartfetchdata');
    Route::get('pts_fqc/list', [FinalQcInspectionController::class,'ptsFqcList'])->name('ptsfqclist');
    Route::get('pts_fqc/create', [FinalQcInspectionController::class,'ptsFqcCreate'])->name('ptsfqccreate');
    Route::get('department/getDepartments', [DepartmentController::class,'getDepartments'])->name('getDepartments');
    Route::post('pts_fqc/store', [FinalQcInspectionController::class,'ptsFqcApproval'])->name('pts_fqc_approval.store');
    Route::get('/invoicepart-data/id', [InvoiceDetailsController::class,'cusPartData'])->name('cuspartdata');
    Route::post('invoicefetch-rc', [InvoiceDetailsController::class,'invoiceItemRc'])->name('invoiceitemrc');
    Route::get('invoice_correction-request', [InvoiceDetailsController::class,'invoiceCorrectionRequest'])->name('invoice_correction_request');
    Route::get('invoicefetch-request', [InvoiceDetailsController::class,'invoiceFetchData'])->name('invoicefetchdata');
    Route::get('/invoice_correction-form/id', [InvoiceDetailsController::class,'invoiceCorrectionForm'])->name('invoicecorrectionform');
    Route::get('/invoice_print-form/id', [InvoiceDetailsController::class,'invoicePrint'])->name('invoiceprint');
    Route::post('invoice_print-pdf', [InvoiceDetailsController::class,'invoicePrintPdf'])->name('invoiceprintpdf');

    Route::resources([
        'roles' => RoleController::class,
        'permissions' => PermissionController::class,
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
        'dc_master' => DcMasterController::class,
        'fqc_approval'=>FinalQcInspectionController::class,
        'customermaster'=>CustomerMasterController::class,
        'customer-products'=>CustomerProductMasterController::class,
        'delivery_challan'=>DcTransactionDetailsController::class,
        'dcprint'=>DcPrintController::class,
    ]);
});

