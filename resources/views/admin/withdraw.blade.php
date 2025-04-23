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
                            <li class="breadcrumb-item active"><a href="javascript:void(0)">withdrawals</a></li>
                        </ol>
                    </div>
                </div>

                
                <div class="row">
                    <div class="col-lg-12">
                    @if(Session::has('withdraw_message'))
                        <div class="alert alert-success" role="alert">
                        {{Session::get('withdraw_message')}}
                        </div>
                    @endif
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">All Withdraws</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table text-dark student-data-table m-t-20">
                                        <thead>
                                            <tr>
                                                <th>User</th>
                                                <th>gateway</th>
                                                <th>Amount</th>
                                                <th>Userwalletid</th>
                                                <th>status</th>
                                                <th>action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @forelse ($withdraws as $withdraw )
                                            <tr>
                                                <td>#{{ $withdraw->user_id}} {{ $withdraw->username}}</td>
                                                <td>
                                                    @if($withdraw->gateway === "BTC")
                                                        Bitcoin
                                                    @endif
                                                    @if($withdraw->gateway === "ETH")
                                                        Ethereum
                                                    @endif
                                                    @if($withdraw->gateway === "USDT")
                                                        USDT
                                                    @endif
                                                    @if($withdraw->gateway === "USDT ERC20")
                                                        USDT (ERC20)
                                                    @endif
                                                    @if($withdraw->gateway === "USDT TRC20")
                                                        USDT (TRC20)
                                                    @endif
                                                    @if($withdraw->gateway === "USDT BEP20")
                                                        USDT (BEP20)
                                                    @endif
                                                    @if($withdraw->gateway === "LTC")
                                                        Litecoin
                                                    @endif
                                                    @if($withdraw->gateway === "BNB")
                                                        BNB
                                                    @endif
                                                    @if($withdraw->gateway === "SOL")
                                                        Solana
                                                    @endif
                                                    @if($withdraw->gateway === "TRX")
                                                        Tron
                                                    @endif
                                                    @if($withdraw->gateway === "XRP")
                                                        XRP
                                                    @endif
                                                </td>
                                                <td>{{ $withdraw->amount }}</td>
                                                <td>{{ $withdraw->userwallet_id }}</td>
                                                <td>
                                                    @if ($withdraw->withdraw_status == 1)
                                                        <div class="badge badge-success">Approved</div>
                                                    @elseif($withdraw->withdraw_status == 0)
                                                        <div class="badge badge-danger">Pending</div>
                                                    @elseif($withdraw->withdraw_status == 3)
                                                        <div class="badge badge-default text-white">Declined</div>
                                                    @endif
                                                </td>
                                                <td>
                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Action</button>
                                                    <div class="dropdown-menu">
                                                        <form style="float:left; margin-left:10px;" action="{{ url('admin/withdraws') }}" method="POST">
                                                            @csrf
                                                            @method('POST')
                                                            <input type="hidden" name="withdrawid" value="{{ $withdraw->id }}">
                                                            
                                                            <input type="hidden" name="action" value="approve">
                                                            <button type="submit" class="dropdown-item text-success">Approve</button>
                                                        </form>
                                                        <form style="float:left; margin-left:10px;" action="{{ url('admin/withdraws') }}" method="POST">
                                                            @csrf
                                                            @method('POST')
                                                            <input type="hidden" name="withdrawid" value="{{ $withdraw->id }}">
                                                            
                                                            <input type="hidden" name="action" value="decline">
                                                            <button type="submit" class="dropdown-item text-danger">Decline</button>
                                                        </form>
                                                        

                                                    </div>
                                                </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center">
                            <div>
                                {{ $withdraws->links() }}
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

