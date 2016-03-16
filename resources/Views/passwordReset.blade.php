@extends('layouts.main')
@section('title')
    Reset Password
@endsection
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">Reset Password</div>
        <div class="panel-body">
            {{--@include('errors.errors')--}}
            <form id="resetPassword" class="login-form" role="form" method="POST" action="/api/resetPassword">
                {{--<input type="hidden" name="_token" value="{{ csrf_token() }}">--}}
                <input type="hidden" name="token" value="{{ $token }}">

                <input class="form-control" type="email" name="email" value="" placeholder="Email" required autofocus>
                <input class="form-control" type="password" name="password" placeholder="New Password" required>
                <input class="form-control" type="password" name="password_confirmation" placeholder="Confirm New Password" required>
                <button type="submit" class="btn btn-lg btn-primary btn-block">
                    Reset Password
                </button>
            </form>
        </div>
    </div>
@endsection
