@extends('frontend.main_master')

@section('content')

<div class="body-content">
    <div class="container">
        <div class="row">
            @include('frontend.common.user_sidebar')
            <div class="col-md-2">

            </div>
            <div class="col-md-6">
                <div class="card">
                    <h3 class="text-center"> <span class="text-danger">Hi....</span>
                    <strong>{{ Auth::user()->name }}</strong> Update Your Profile
                    </h3>
                    <div class="card-body">
                        <form method="POST" action="{{ route('user.profile.store') }}" enctype="multipart/form-data" >
                            @csrf

                            <div class="form-group">
                                <label class="info-title" for="name">Name</label>
                                <input type="text" name="name" value="{{ $user->name }}" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="info-title" for="email">Email</label>
                                <input type="email" name="email" value="{{ $user->email }}" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="info-title" for="phone">Phone</label>
                                <input type="text" name="phone" value="{{ $user->phone }}" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="info-title" for="profile">User Image</label>
                                <input type="file" name="profile_photo_path"  class="form-control">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-danger">Update</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
