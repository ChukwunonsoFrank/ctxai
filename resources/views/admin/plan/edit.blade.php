@extends('admin.layout.layout')


@section('content')


<!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
            <div class="container-fluid">
                <div class="row page-titles mx-0">
                    
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Admin</a></li>
                            <li class="breadcrumb-item"><a href="/admin/coins">Plans</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0)">Edit Plan</a></li>
                        </ol>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-12 col-xxl-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Edit Plans</h4>
                            </div>
                            <div class="card-body">
                                <div class="basic-form">
                                    @if(session('status'))
                                    <div class="alert alert-success mb-1 mt-1">
                                        {{ session('status') }}
                                    </div>
                                    @endif
                                    <form class="row" action="{{ route('plans.update',$plan->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="col-lg-6 form-group">
                                            <label>Plan name</label>
                                            <input class="form-control" type="text" name="name" value="{{ $plan->name }}"/>
                                            @error('name')
                                            <span class="text-danger text-left">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-lg-6 form-group">
                                            <label>Risk type name</label>
                                            <input class="form-control" type="text" name="risk_type" value="{{ $plan->risk_type }}"/>
                                            @error('risk_type')
                                            <span class="text-danger text-left">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-lg-6 form-group">
                                            <label>min amount</label>
                                            <input class="form-control" type="number" name="min_amount" value="{{ $plan->min_amount }}"/>
                                            @error('min_amount')
                                            <span class="text-danger text-left">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-lg-6 form-group">
                                            <label>Max amount</label>
                                            <input class="form-control" type="number" name="max_amount" value="{{ $plan->max_amount }}"/>
                                            @error('max_amount')
                                            <span class="text-danger text-left">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-lg-6 form-group">
                                            <label>Min Roi Percentage in %</label>
                                            <input class="form-control" type="number" name="min_roi_percentage" value="{{ $plan->min_roi_percentage }}"/>
                                            @error('min_roi_percentage')
                                                <span class="text-danger text-left">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-lg-6 form-group">
                                            <label>Max Roi Percentage in %</label>
                                            <input class="form-control" type="number" name="max_roi_percentage" value="{{ $plan->max_roi_percentage }}"/>
                                            @error('max_roi_percentage')
                                            <span class="text-danger text-left">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-lg-6 form-group">
                                            <label>Order (ie 1 shows first 2 shows second ... etc)</label>
                                            <input class="form-control" type="number" name="order" value="{{ $plan->order }}"/>
                                            @error('order')
                                            <span class="text-danger text-left">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-lg-6 form-group">
                                            <label>Duration in hours (1 means an hour)</label>
                                            <input class="form-control" type="number" name="plan_duration" value="{{ $plan->plan_duration }}"/>
                                            @error('plan_duration')
                                            <span class="text-danger text-left">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-lg-6 form-group">
                                            <label>Image</label>
                                            <input type="file" name="image" class="form-control" placeholder="image">
                                            <img src="/images/plans/{{ $plan->image }}" width="100px">
                                            @error('image')
                                            <span class="text-danger text-left">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        
                                        <div class="col-lg-6 form-group">
                                            <button type="submit" class="btn btn-dark btn-block">Update Plan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
                
                
                
            </div>
        </div>
        <!--**********************************
            Content body end
        ***********************************-->



    



@endsection

