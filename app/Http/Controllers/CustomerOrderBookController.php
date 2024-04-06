<?php

namespace App\Http\Controllers;

use App\Models\CustomerOrderBook;
use App\Http\Requests\StoreCustomerOrderBookRequest;
use App\Http\Requests\UpdateCustomerOrderBookRequest;

class CustomerOrderBookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(StoreCustomerOrderBookRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(CustomerOrderBook $customerOrderBook)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CustomerOrderBook $customerOrderBook)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerOrderBookRequest $request, CustomerOrderBook $customerOrderBook)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CustomerOrderBook $customerOrderBook)
    {
        //
    }
}
