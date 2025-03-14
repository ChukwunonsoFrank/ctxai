<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorewithdrawRequest;
use App\Http\Requests\UpdatewithdrawRequest;
use App\Models\withdraw;
use App\Mail\RegistrationMail;
use Illuminate\Support\Facades\Mail;

class WithdrawController extends Controller
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
    public function store(StorewithdrawRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(withdraw $withdraw)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(withdraw $withdraw)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatewithdrawRequest $request, withdraw $withdraw)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(withdraw $withdraw)
    {
        //
    }
}
