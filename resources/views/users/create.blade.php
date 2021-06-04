@extends('users.layout')
  
@section('content')
<div class="col-lg-12 margin-tb pb-5"> 
<div class="mt-3">
    <div class="card">
        <div class="card-header text-center">
            <div class="pull-left">
                <h3>Add New WaitList User</h3>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('users.index') }}"> Back</a>
            </div>
        </div>
        <div class="card-body card-block">
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                @if ($errors->any())
                    <div class="alert alert-danger" role="alert">
                        <strong>There were some problems with your input</strong><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li style="list-style-type: none;">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if(Session::has('flash_message'))
                    <div class="alert {{ Session::get('alert-class', 'alert-info') }}">
                        {{ Session::get('flash_message') }}
                        {{ Session::forget('flash_message') }}
                    </div>
                @endif

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="name" class=" form-control-label">Name</label>
                        <input type="text" id="name" name="name" placeholder="" class="form-control">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="email" class=" form-control-label">Email</label>
                        <input type="email" id="email" name="email" placeholder="" class="form-control">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="password" class=" form-control-label">Password</label>
                        <input type="password" id="password" name="password" placeholder="" class="form-control">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="cpassword" class=" form-control-label">Confirm Password</label>
                        <input type="password" name="cpassword" class="form-control" placeholder="">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="referrer_id" class=" form-control-label">Referrer Id</label>
                        <input type="text" name="referrer_id" class="form-control" placeholder="">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="position" class=" form-control-label">Waitlist Position</label>
                        <input type="number" name="position" class="form-control" placeholder="">
                    </div>                    
                </div>
            
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary btn-sm">
                <i class="fa fa-dot-circle-o"></i> Submit
            </button>
            <button type="reset" class="btn btn-danger btn-sm">
                <i class="fa fa-ban"></i> Reset
            </button>
        </div>
        </form>
    </div>
</div>
</div>
@endsection