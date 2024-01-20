<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\SupplierProduct;
use App\Models\Supplier;
use App\Models\ModeOfUnit;
use App\Models\RawMaterial;
use App\Models\RawMaterialCategory;
use App\Http\Requests\StoreSupplierProductRequest;
use App\Http\Requests\UpdateSupplierProductRequest;

class SupplierProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $supplier_products = SupplierProduct::with(['category','product','material','uom'])->get();
        return view('supplier-products.index',compact('supplier_products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSupplierProductRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(SupplierProduct $supplierProduct)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SupplierProduct $supplierProduct)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSupplierProductRequest $request, SupplierProduct $supplierProduct)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SupplierProduct $supplierProduct)
    {
        //
    }
}
