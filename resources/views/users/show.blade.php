@extends('users.layout')
  
@section('content')
<div class="col-lg-12 margin-tb pb-5"> 
<div class="mt-3">
    <div class="card">
                                    <div class="card-header text-center">
                                        <strong class="card-title pull-left">User Details
                                            </strong>
                                        <div class="pull-right">
                                            <a class="btn btn-primary" href="{{ route('users.index') }}"> Back</a>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <ul class="list-group mt-3">
                                            <li class="list-group-item"><strong>Name:</strong> {{ $user->name }}</li>
                                            <li class="list-group-item"><strong>Email:</strong> {{ $user->email }}</li>
                                            <li class="list-group-item"><strong>Referral link:</strong> {{ URL::to('/register?ref='.$user->referral_token) }}</li>
                                            <li class="list-group-item"><strong>Referrer:</strong> {{ $user->referrer->name ?? 'Not Specified' }}</li>
                                            <li class="list-group-item"><strong>Referral Count:</strong> {{ count($user->referrals)  ?? '0' }}</li>
                                            <li class="list-group-item"><strong>Your Position:</strong> {{ $user->position }}</li>
                                        </ul>
                                        
                                    </div>
                                  </div>
</div>
</div>
    
@endsection