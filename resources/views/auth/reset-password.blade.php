@extends('frontend.main_master')

@section('content')

<!-- ============================================== HEADER : END ============================================== -->
<div class="breadcrumb">
    <div class="container">
        <div class="breadcrumb-inner">
            <ul class="list-inline list-unstyled">
                <li><a href="home.html">Home</a></li>
                <li class='active'>Reset Password</li>
            </ul>
        </div><!-- /.breadcrumb-inner -->
    </div><!-- /.container -->
</div><!-- /.breadcrumb -->

<div class="body-content">
    <div class="container">

        <div class="sign-in-page">
            <div class="row justify-content-center">
                <!-- Forgot Password -->
                <div class="col-md-6 col-sm-6 sign-in">
                    <h4 class="">Reset password</h4>

                    <form method="POST" action="{{ route('password.update') }}" class="register-form outer-top-xs">
                        @csrf

                        <input type="hidden" name="token" value="{{ $request->route('token') }}">

                        <div class="form-group">
                            <label class="info-title" for="exampleInputEmail1">Email Address <span>*</span></label>
                            <input type="email" id="email" name="email"
                                class="form-control unicase-form-control text-input">
                        </div>
                        <div class="form-group">
                            <label class="info-title" for="password">Password <span>*</span></label>
                            <input type="password" id="password" name="password"
                                class="form-control unicase-form-control text-input">
                        </div>
                        <div class="form-group">
                            <label class="info-title" for="password_confirmation">Comfirm Password <span>*</span></label>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                class="form-control unicase-form-control text-input">
                        </div>

                        <button type="submit" class="btn-upper btn btn-primary checkout-page-button">Reset Password</button>
                    </form>
                </div>
                <!-- Forgot Password -->

            </div><!-- /.row -->
        </div><!-- /.sigin-in-->

        <!-- ============================================== BRANDS CAROUSEL ============================================== -->
        @include('frontend.body.brands')
        <!-- ============================================== BRANDS CAROUSEL : END ============================================== -->


    </div><!-- /.container -->
</div><!-- /.body-content -->


@endsection
