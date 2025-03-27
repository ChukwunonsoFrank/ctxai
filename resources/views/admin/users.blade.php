@extends('admin.layout.layout')


@section('content')

<!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
            <div class="container-fluid px-0">
                <div class="row page-titles mx-0">
                    
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Admin</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0)">Users</a></li>
                        </ol>
                    </div>
                </div>


                
                <div class="row">
                    <div class="col-lg-12">
                    @if(Session::has('users_message'))
                        <div class="alert alert-success" role="alert">
                        {{Session::get('users_message')}}
                        </div>
                    @endif
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">All Users</h4>
                             
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table text-dark student-data-table m-t-20" id="myTable">
                                        <thead>
                                            <tr>
                                                <th>Username</th>
                                                <th>Email</th>
                                               
                                                <th>Live Balance</th>
                                                <th>Demo Balance</th>
                                                <th>status</th>
                                                <th>action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @forelse ($users as $user )
                                            <tr>
                                            
                                                <td> {{ $user['username']}}   </br>
                                                    @php
                                                        $value = App\Models\User::where(['refcode' =>  $user['referral_code']])->first();
                                                    @endphp
                                                    @if (isset($value))
                                                        <span class="badge badge-success"> {{ $value->username }} </span>
                                                        
                                                    @endif
                                                    
                                                </td>
                                                <td>{{ $user['email'] }}</td>
                                                <td> @money(floatval($user['balance']))</td>
                                                <td> @money(floatval($user['demo_balance']))</td>
                                                <td>
                                                @if ($user['status'] == 1)
                                                    <div class="badge badge-success">Active</div>
                                                    <a class="updateAdminStatus" id="user-{{$user['id']}}" user_id="{{$user['id']}}" href="javascript:void(0)" >
                                                        <i style="font-size:large;" class="mdi mdi-bookmark-plus" status="active"></i>
                                                    </a>
                                                @else
                                                    <div class="badge badge-danger">Inactive</div>
                                                    <a class="updateAdminStatus" id="user-{{$user['id']}}" user_id="{{$user['id']}}" href="javascript:void(0)" >
                                                        <i style="font-size:large;" class="mdi mdi-bookmark-remove" status="inactive"></i>
                                                    </a>
                                                @endif
                                                </td>
                                                <td>
                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Action</button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="{{ url('admin/viewusers') }}/{{ $user['id'] }}">View user</a>
                                                        <form style="float:left; margin-left:10px;" action="{{ url('admin/users') }}" method="POST">
                                                            @csrf
                                                            @method('POST')
                                                            <input type="hidden" name="userid" value="{{ $user['id'] }}">
                                                            <input type="hidden" name="action" value="delete">
                                                            <button onclick="return confirm('Are you sure you want to delete?');" type="submit" class="dropdown-item text-danger">Delete</button>
                                                        </form>
                                                        @if ($user['status'] == 1)
                                                            <form style="float:left; margin-left:10px;" action="{{ url('admin/users') }}" method="POST">
                                                                @csrf
                                                                @method('POST')
                                                                <input type="hidden" name="userid" value="{{ $user['id'] }}">
                                                                <input type="hidden" name="action" value="deactivate">
                                                                <button type="submit" class="dropdown-item text-danger">Deactivate</button>
                                                            </form>
                                                        @else
                                                            <form style="float:left; margin-left:10px;" action="{{ url('admin/users') }}" method="POST">
                                                                @csrf
                                                                @method('POST')
                                                                <input type="hidden" name="userid" value="{{ $user['id'] }}">
                                                                <input type="hidden" name="action" value="activate">
                                                                <button type="submit" class="dropdown-item text-success">Activate</button>
                                                            </form>
                                                        @endif
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
                    </div>
                    
                </div>
                
            </div>
        </div>
        <!--**********************************
            Content body end
        ***********************************-->


@endsection

@section('footer')
<script>
// new DataTable('#myTable', {
//     responsive: true
// });

var table = $('#myTable').DataTable({
        ordering: false,
        responsive: true,
        pageLength: 100,
        columnDefs: [
            { responsivePriority: 1, targets: 0 }, // Make Column 1 the first priority
            { responsivePriority: 2, targets: 1 }, // Make Column 2 the second priority
            { responsivePriority: 3, targets: '_all' } // Make all other columns less of a priority
        ]
    });

    // if ($(window).width() < 600) {
    //     table.columns(':gt(1)').visible(false); // Hide columns starting from index 2
    // }

   
</script>
@endsection

