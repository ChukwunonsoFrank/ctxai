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
                            <li class="breadcrumb-item active"><a href="javascript:void(0)">Send Emails To All</a></li>
                        </ol>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-12 col-xxl-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Send Emails</h4>
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
                                    @if(session('success'))
                                    <div class="alert alert-success mb-1 mt-1">
                                        {{ session('success') }}
                                    </div>
                                    @endif
                                    <form class="row" method="post" action="{{ url('admin/email')}}">@CSrf
                                        <div class="col-lg-6 form-group">
                                            <label>Subject</label>
                                            <input class="form-control" type="text" name="subject" value="{{ old('subject') }}"/>
                                            @error('subject')
                                            <span class="text-danger text-left">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-lg-6 form-group">
                                            <label>Message</label>
                                            <textarea class="form-control" style="height:150px" name="message" placeholder="content"></textarea>
                                            @error('subject')
                                            <span class="text-danger text-left">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        
                                        <div class="col-lg-6 form-group">
                                            <button type="submit" class="btn btn-dark btn-block">Send Email</button>
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