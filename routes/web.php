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
use App\Http\Controllers\StageQrCodeLockController;
use App\Http\Controllers\RetrunRMDetailsController;
use App\Http\Controllers\RMDcController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PermissionController;
use Spatie\Permission\Contracts\Role;

// invoice updated

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
Route::group(['middleware' => ['auth','role:Super Admin']], function () {
    Route::get('role_permission/{role_id}',[RoleController::class,'role_permission'])->name('role_permission');
    Route::post('assign_permission',[RoleController::class,'assign_permissions'])->name('assign_permission');
    Route::resource('roles',RoleController::class);
    Route::resource('permissions',PermissionController::class);
});
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
    Route::get('/rm-printdata/{id}', [GRNInwardRegisterController::class,'rmIssuancePrint'])->name('rmissuance.show');
    Route::get('rm_issuance', [GRNInwardRegisterController::class,'rmIssuanceData'])->name('rmissuance.index');
    Route::get('rm_returnreceipt', [GRNInwardRegisterController::class,'rmReturnReceipt'])->name('returnrmreceipt');
    Route::get('rm_return', [GRNInwardRegisterController::class,'rmReturnData'])->name('returnrm.index');
    Route::post('rm_returnstore', [GRNInwardRegisterController::class,'rmReturnStore'])->name('returnrm.store');
    Route::get('rm_issuance-create', [GRNInwardRegisterController::class,'rmIssuance'])->name('rmissuance.create');
    Route::post('/rm_issuance-data', [GRNInwardRegisterController::class,'storeData'])->name('rmissuance.storedata');
    Route::post('/rm_issuance-fetchdata', [GRNInwardRegisterController::class,'grnRmFetchData'])->name('grnrmfetchdata');
    Route::post('/rm_heatno-fetchdata', [GRNInwardRegisterController::class,'grnHeatFetchData'])->name('grnheatfetchdata');
    Route::post('/rm_coilno-fetchdata', [GRNInwardRegisterController::class,'grnCoilFetchData'])->name('grncoilfetchdata');
    Route::post('/grnqc-fetchdata', [GRNInwardRegisterController::class,'grnQcFetchData'])->name('grnqcfetchdata');
    Route::get('sf_receive/list', [StagewiseReceiveController::class,'sfReceiveList'])->name('sfreceive');
    Route::get('sf_receive/create', [StagewiseReceiveController::class,'sfReceiveCreateForm'])->name('sfreceive.create');
    Route::post('sf-receive', [StagewiseReceiveController::class,'sfReceiveEntry'])->name('sfreceive.store');
    Route::post('sf-receive/part_no', [StagewiseReceiveController::class,'sfPartFetchEntry'])->name('sfpartfetchdata');
    Route::get('/sfreceive-qrprintdata/{id}', [StagewiseReceiveController::class,'sfPartReceiveQrCode'])->name('sfpartreceiveqrcode');
    Route::get('/sfissue-qrprintdata/{id}', [StagewiseIssueController::class,'sfPartIssueQrCode'])->name('sfpartissueqrcode');
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
    Route::get('/dcrmsupplier-data/id', [RMDcController::class,'dcRmSupplierData'])->name('dcrmsupplierdata');
    Route::get('rmdc_receive/create', [RMDcController::class,'rmdcReceiveData'])->name('rmdc_receive');
    Route::post('rmdcreceiverc-data', [RMDcController::class,'rmdcReceiveRcData'])->name('rmdcreceivercdata');
    Route::post('rmdcreceivepart-data', [RMDcController::class,'rmdcReceivePartData'])->name('rmdcreceivepartdata');
    Route::post('rmdcreceive-store', [RMDcController::class,'rmdcReceiveStore'])->name('rmdcreceive.store');
    Route::post('dcrmgrn-data', [RMDcController::class,'dcrmGrnData'])->name('dcrmgrndata');
    Route::post('dcrmgrncoil-data', [RMDcController::class,'dcrmGrnCoilData'])->name('dcrmgrncoildata');
    Route::post('dcrmgrncoilqty-data', [RMDcController::class,'dcrmGrnCoilQtyData'])->name('dcrmgrncoilqtydata');
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
    Route::post('pts_fqc/store', [FinalQcInspectionController::class,'ptsFqcApproval'])->name('pts_fqc_approval.store');
    Route::post('/invoicedetails/index', [InvoiceDetailsController::class,'index'])->name('invoicedetails');
    Route::get('/invoicepart-data/id', [InvoiceDetailsController::class,'cusPartData'])->name('cuspartdata');
    Route::post('invoicefetch-rc', [InvoiceDetailsController::class,'invoiceItemRc'])->name('invoiceitemrc');
    Route::post('invoicefetch-rcqty', [InvoiceDetailsController::class,'invoiceQtyRc'])->name('invoiceqtyrc');
    Route::get('invoice_correction-request', [InvoiceDetailsController::class,'invoiceCorrectionRequest'])->name('invoice_correction_request');
    Route::get('invoicefetch-request', [InvoiceDetailsController::class,'invoiceFetchData'])->name('invoicefetchdata');
    Route::get('/invoice_correction-form/id', [InvoiceDetailsController::class,'invoiceCorrectionForm'])->name('invoicecorrectionform');
    Route::get('/invoice_print-form/id', [InvoiceDetailsController::class,'invoicePrint'])->name('invoiceprint');
    Route::post('invoice_print-pdf', [InvoiceDetailsController::class,'invoicePrintPdf'])->name('invoiceprintpdf');
    Route::get('/invoice_reprint-form/id', [InvoiceDetailsController::class,'invoiceRePrint'])->name('invoicereprint');
    Route::get('invoicereprintfetch-request', [InvoiceDetailsController::class,'invoiceReprintFetchDatas'])->name('invoicereprintfetchdata');
    Route::post('invoice_reprint-pdf', [InvoiceDetailsController::class,'invoiceRePrintPdf'])->name('invoicereprintpdf');
    Route::get('/supplymentaryinvoice/list', [InvoiceDetailsController::class,'supplymentaryInvoice'])->name('supplymentaryinvoice');
    Route::get('supplymentaryinvoice_receive/create', [InvoiceDetailsController::class,'supplymentaryInvoiceCreateForm'])->name('supplymentaryinvoice.create');
    Route::post('supplymentaryinvoice_receive/store', [InvoiceDetailsController::class,'supplymentaryInvoiceStore'])->name('supplymentaryinvoice.store');
    Route::get('/supplymentaryinvoice_print-form/id', [InvoiceDetailsController::class,'supplymentaryInvoicePrint'])->name('supplymentaryinvoiceprint');
    Route::get('/supplymentaryinvoice_reprint-form/id', [InvoiceDetailsController::class,'supplymentaryReInvoicePrint'])->name('supplymentaryreinvoiceprint');
    Route::post('supplymentaryinvoicefetch-po', [InvoiceDetailsController::class,'supplymentaryinvoiceItemPo'])->name('supplymentaryinvoiceitempo');
    Route::get('/traceability-form/id', [InvoiceDetailsController::class,'traceability'])->name('traceability');
    Route::post('rccheckdata', [InvoiceDetailsController::class,'rcCheckData'])->name('rcinvoice_data');
    Route::get('/user-management/id', [UserController::class,'userIndex'])->name('userindex');
    Route::get('/user-management/create', [UserController::class,'userCreate'])->name('usercreate');
    Route::post('/user-management/store', [UserController::class,'userStore'])->name('userstore');
    Route::get('user-management/{id}/edit', [UserController::class,'userEdit'])->name('useredit');
    Route::get('department/export/excel', [DepartmentController::class, 'export_excel'])->name('department.export_excel');
    Route::post('rmreturn-receive/part_no', [RetrunRMDetailsController::class,'rmReturnPartFetchEntry'])->name('rmreturnpartfetchdata');



    Route::resources([
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
        'customerpomaster'=>CustomerPoMasterController::class,
        'delivery_challan'=>DcTransactionDetailsController::class,
        'dcprint'=>DcPrintController::class,
        'invoicedetails'=>InvoiceDetailsController::class,
        'invoicecorrectionmaster'=>InvoiceCorrectionMasterController::class,
        'invoicecorrectiondetail'=>InvoiceCorrectionDetailController::class,
        'stageqrcodelock'=>StageQrCodeLockController::class,
        'retrunrmdetails'=>RetrunRMDetailsController::class,
        'rmdc'=>RMDcController::class,
    ]);
});

