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
                            <li class="breadcrumb-item active"><a href="javascript:void(0)">Coins</a></li>
                        </ol>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-6 col-xxl-6">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Create New Wallet</h4>
                            </div>
                            <div class="card-body">
                                <div class="basic-form">
                                    @if(session('status'))
                                    <div class="alert alert-success mb-1 mt-1">
                                        {{ session('status') }}
                                    </div>
                                    @endif
                                    <form action="{{ route('coins.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <label>Coin name</label>
                                            <input class="form-control" type="text" name="coin_name" />
                                            @error('coin_name')
                                            <span class="text-danger text-left">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Coin code</label>
                                            <input class="form-control" type="text" name="coin_code" />
                                            @error('coin_code')
                                            <span class="text-danger text-left">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Coin Wallet</label>
                                            <input class="form-control" type="text" name="coin_wallet" />
                                            @error('coin_wallet')
                                            <span class="text-danger text-left">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-dark btn-block">Add new wallet</button>
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
                                <h4 class="card-title">All coins</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                @if ($message = Session::get('success'))
                                    <div class="alert alert-success">
                                        <p>{{ $message }}</p>
                                    </div>
                                @endif
                                    <table class="table student-data-table m-t-20">
                                        <thead>
                                            <tr>
                                                <th>Coin Name</th>
                                                <th>Coin Code</th>
                                                <th>Coin wallet</th>
                                                <th>action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @forelse ($coins as $coin)
                                            <tr>
                                                <td>{{ $coin->coin_name }}</td>
                                                <td>{{ $coin->coin_code }}</td>
                                                <td>{{ $coin->coin_wallet }}</td>
                                                <td>
                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Action</button>
                                                    <div class="dropdown-menu">
                                                    <form action="{{ route('coins.destroy',$coin->id) }}" method="Post">
                                                        <a class="dropdown-item" href="{{ route('coins.edit',$coin->id) }}">Edit</a>
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
                                    {!! $coins->links() !!}
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

