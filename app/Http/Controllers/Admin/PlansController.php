<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreplanRequest;
use App\Http\Requests\UpdateplanRequest;
use App\Models\plans;

use Illuminate\Http\Request;

class PlansController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $plans = plans::orderBy('id','desc')->paginate(5);
        return view('admin.plan.index', compact('plans'));
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
    public function store(StoreplanRequest $request)
    {
        //
        // dd($request->all());
        $request->validate([
            'name' => 'required',
            'risk_type' => 'required',
            'min_amount' => 'required',
            'max_amount' => 'required',
            'min_roi_percentage' => 'required',
            'max_roi_percentage' => 'required',
            'order' => 'required',
            'plan_duration' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $input = $request->all();
  
        if ($image = $request->file('image')) {
            $destinationPath = 'images/plans/';
            $planImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $planImage);
            $input['image'] = "$planImage";
        }
        $input['status'] = 1;
        
        plans::create($input);

        return redirect()->route('plans.index')->with('success','Coins has been created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(plans $plan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    /**
     * Show the form for editing the specified resource.
     * @param  \App\Models\plans $coins
     * @return \Illuminate\Http\Response
     */
    public function edit(plans $plan)
    {
        //
        return view('admin.plan.edit',compact('plan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateplanRequest $request, plans $plan)
    {
        //
        $request->validate([
            'name' => 'required',
            'risk_type' => 'required',
            'min_amount' => 'required',
            'max_amount' => 'required',
            'min_roi_percentage' => 'required',
            'max_roi_percentage' => 'required',
            'order' => 'required',
            'plan_duration' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $input = $request->all();
  
        if ($image = $request->file('image')) {
            $destinationPath = 'images/plans/';
            $planImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $planImage);
            $input['image'] = "$planImage";
        }else{
            unset($input['image']);
        }
        $validated = $request->post();
        $validated['status'] = 1;

        $plan->fill($request->post())->save();

        

        return redirect()->route('plans.index')->with('success','Coins Has Been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(plans $plan)
    {
        //
        $plan->delete();
        return redirect()->route('plans.index')->with('success','Coins has been deleted successfully');
    }
}
