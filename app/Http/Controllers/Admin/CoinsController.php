<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorecoinRequest;
use App\Http\Requests\UpdatecoinRequest;
use App\Models\Coins;

class CoinsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $coins = Coins::orderBy('id','desc')->paginate(5);
        return view('admin.coins.index', compact('coins'));
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
    public function store(StorecoinRequest $request)
    {
        //
        $request->validate([
            'coin_name' => 'required',
            'coin_code' => 'required',
            'coin_wallet' => 'required',
        ]);
        $validated = $request->post();
        $validated['coin_qr'] = 1;
        
        Coins::create($validated);

        return redirect()->route('coins.index')->with('success','Coins has been created successfully.');
    }

    /**
     * Display the specified resource.
     *  * @param  \App\Coins  $Coins
    * @return \Illuminate\Http\Response
     */
    public function show(Coins $coin)
    {
        //
        return view('admin.coins.show',compact('coin'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param  \App\Models\Coins $coins
     * @return \Illuminate\Http\Response
     */
    public function edit(Coins $coin)
    {
        //
        return view('admin.coins.edit',compact('coin'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatecoinRequest $request, Coins $coin)
    {
        //
        $request->validate([
            'coin_name' => 'required',
            'coin_code' => 'required',
            'coin_wallet' => 'required',
        ]);
        $validated = $request->post();
        $validated['coin_qr'] = 1;

        $coin->fill($request->post())->save();

        

        return redirect()->route('coins.index')->with('success','Coins Has Been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Coins $coin)
    {
        //
        $coin->delete();
        return redirect()->route('coins.index')->with('success','Coins has been deleted successfully');
    }
}
