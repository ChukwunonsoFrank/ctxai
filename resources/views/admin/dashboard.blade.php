@extends('admin.layout.layout')


@section('content')


@if(Session::has('login_success'))
    <script>
    Swal.fire(
    'Login Successfull',
    'Welcome back',
    'success'
        )
    </script>
@endif

<!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
            <div class="container-fluid">
                <div class="row page-titles mx-0">
                    <div class="col-sm-6 p-md-0">
                        <div class="welcome-text">
                            <h4>Hi, welcome back!</h4>
                            <h6 class="mb-0">Admin</h6>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Admin</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0)">Dashboard</a></li>
                        </ol>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-3 col-sm-6">
                        <div class="card">
                            <div class="stat-widget-one card-body">
                                <div class="stat-icon d-inline-block">
                                    <i class="ti-money text-success border-success"></i>
                                </div>
                                <div class="stat-content d-inline-block">
                                    <div class="stat-text">Total Deposit</div>
                                    <div class="stat-digit">{{ $details['deposits'] }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card">
                            <div class="stat-widget-one card-body">
                                <div class="stat-icon d-inline-block">
                                    <i class="ti-tradingbot text-primary border-primary"></i>
                                </div>
                                <div class="stat-content d-inline-block">
                                    <div class="stat-text">Earned</div>
                                   
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card">
                            <div class="stat-widget-one card-body">
                                <div class="stat-icon d-inline-block">
                                    <i class="ti-layout-grid2 text-pink border-pink"></i>
                                </div>
                                <div class="stat-content d-inline-block">
                                    <div class="stat-text">Subscriptions</div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">All Active Robots</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table text-dark  student-data-table m-t-20">
                                        <thead>
                                            <tr>
                                                <th>User</th>
                                                <th>Strategy</th>
                                                <th>Amount</th>
                                                <th>Amount earned</th>
                                                <th>Will Expire</th>
                                                <th>Account type</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                                <th>Start</th>
                                                <th>End</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @forelse ($tradingbots as $tradingbot )
                                            <tr>
                                                <td>{{ $tradingbot->username}}</td>
                                                <td>{{ $tradingbot->name}}</td>
                                                <td>@money(floatval($tradingbot->amount))</td>
                                                <td>@money(floatval($tradingbot->amount_earned))</td>
                                                <td>{{ $tradingbot->profit_limit_exceed}}</td>
                                                <td>{{ $tradingbot->account_type}}</td>
                                                <td> 
                                                    @if ($tradingbot->status == 1)
                                                        <span class='badge badge-success'>Active</span>
                                                    @elseif ($tradingbot->status == 0)
                                                        <span class='badge badge-danger'>Expired</span>
                                                    @else
                                                        <span class='badge badge-secondary'>Profit Exceeded</span>
                                                    @endif
                                                    
                                                </td>
                                                <td>
                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Action</button>
                                                    <div class="dropdown-menu">
                                                        <form style="float:left; margin-left:10px;" action="{{ url('admin/dashboard') }}" method="POST">
                                                            @csrf
                                                            @method('POST')
                                                            <input type="hidden" name="tradingbotid" value="{{ $tradingbot->id }}">
                                                            
                                                            <input type="hidden" name="action" value="stoprobot">

                                                            @if ($tradingbot->status == 1)
                                                            <button type="submit" class="dropdown-item text-danger">Stop Robot</button>
                                                            @elseif ($tradingbot->status == 0)
                                                                <span class='badge badge-danger'>Expired</span>
                                                            @else
                                                                <span class='badge badge-secondary'>Profit Exceeded</span>
                                                            @endif
                                                            
                                                        </form>
                                                        

                                                    </div>
                                                </div>
                                                </td>
                                                

                                                <td>{{ $tradingbot->duration_start}}</td>
                                                <td>{{ $tradingbot->duration_end}}</td>
                                               
                                            </tr>
                                        @endforeach
                                            
                                            
                                        </tbody>
                                    </table>
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

