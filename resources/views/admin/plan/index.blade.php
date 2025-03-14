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
                            <li class="breadcrumb-item active"><a href="javascript:void(0)">Plans</a></li>
                        </ol>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-12 col-xxl-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Create New Plan</h4>
                            </div>
                            <div class="card-body text-dark">
                                <div class="basic-form">
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    @if(session('status'))
                                    <div class="alert alert-success mb-1 mt-1">
                                        {{ session('status') }}
                                    </div>
                                    @endif
                                    <form class="row" action="{{ route('plans.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="col-lg-6 form-group">
                                            <label>Plan name</label>
                                            <input class="form-control" type="text" name="name" value="{{ old('name') }}"/>
                                            @error('name')
                                            <span class="text-danger text-left">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-lg-6 form-group">
                                            <label>Risk type name</label>
                                            <input class="form-control" type="text" name="risk_type" value="{{ old('risk_type') }}"/>
                                            @error('risk_type')
                                            <span class="text-danger text-left">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-lg-6 form-group">
                                            <label>min amount</label>
                                            <input class="form-control" type="number" name="min_amount" value="{{ old('min_amount') }}"/>
                                            @error('min_amount')
                                            <span class="text-danger text-left">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-lg-6 form-group">
                                            <label>Max amount</label>
                                            <input class="form-control" type="number" name="max_amount" value="{{ old('max_amount') }}"/>
                                            @error('max_amount')
                                            <span class="text-danger text-left">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-lg-6 form-group">
                                            <label>Min Roi Percentage in %</label>
                                            <input class="form-control" type="number" name="min_roi_percentage" value="{{ old('min_roi_percentage') }}"/>
                                            @error('min_roi_percentage')
                                                <span class="text-danger text-left">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-lg-6 form-group">
                                            <label>Max Roi Percentage in %</label>
                                            <input class="form-control" type="number" name="max_roi_percentage" value="{{ old('max_roi_percentage') }}"/>
                                            @error('max_roi_percentage')
                                            <span class="text-danger text-left">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-lg-6 form-group">
                                            <label>Order (ie 1 shows first 2 shows second ... etc)</label>
                                            <input class="form-control" type="number" name="order" min="0" value="{{ old('order') }}"/>
                                            @error('order')
                                            <span class="text-danger text-left">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-lg-6 form-group">
                                            <label>Duration in hours (1 means an hour)</label>
                                            <input class="form-control" type="number" name="plan_duration" min="1" value="{{ old('plan_duration') }}"/>
                                            @error('plan_duration')
                                            <span class="text-danger text-left">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-lg-6 form-group">
                                            <label>Image</label>
                                            <input type="file" name="image" class="form-control" placeholder="image">
                                            @error('image')
                                            <span class="text-danger text-left">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        
                                        <div class="col-lg-6 form-group">
                                            <button type="submit" class="btn btn-dark btn-block">Add Plan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">All Plans</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                @if ($message = Session::get('success'))
                                    <div class="alert alert-success">
                                        <p>{{ $message }}</p>
                                    </div>
                                @endif
                                    <table class="table student-data-table m-t-20 text-dark">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Amounts</th>
                                                <th>Roi's</th>
                                                <th>action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @forelse ($plans as $plan)
                                            <tr>
                                                <td><img src="/images/plans/{{ $plan->image }}" class="rounded" width="30px" alt="">{{ $plan->name }}</td>
                                                <td>
                                                    Min : @money($plan->min_amount) 
                                                    Max :  @money($plan->max_amount) 
                                                </td>
                                                <td>
                                                    Min : {{ $plan->min_roi_percentage }}%
                                                    Max : {{ $plan->max_roi_percentage }}%
                                                </td>
                                                <td>
                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Action</button>
                                                    <div class="dropdown-menu">
                                                    <form action="{{ route('plans.destroy',$plan->id) }}" method="Post">
                                                        <a class="dropdown-item" href="{{ route('plans.edit',$plan->id) }}">Edit</a>
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger">Delete</button>
                                                    </form>
                                                    </div>
                                                </div>
                                                </td>
                                            </tr>
                                            @empty
                                            <div class="alert alert-danger" role="alert">
                                            No data found
                                            </div>
                                        @endforelse
                                        
                                            
                                        </tbody>
                                    </table>
                                    {!! $plans->links() !!}
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

