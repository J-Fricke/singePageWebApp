<script id="loginFormTemplate" type="text/html">
    @{{#statusMessage}}
    <div class="alert alert-success" role="success">@{{message}}</div>
    @{{/statusMessage}}
    @{{#error}}
    <div class="alert alert-danger" role="danger">@{{message}}</div>
    @{{/error}}
    <form id="loginForm" class="form-signin">
        <h2 class="form-signin-heading">Please sign in</h2>
        <label for="inputEmail" class="sr-only">Email address</label>
        <input type="email" id="inputEmail" class="form-control" name='email' placeholder="Email address" required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" class="form-control" name='password' placeholder="Password" required>
        {{--<div class="checkbox">--}}
        {{--<label>--}}
        {{--<input type="checkbox" value="remember-me"> Remember me--}}
        {{--</label>--}}
        {{--</div>--}}
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
        <br>
        <a data-toggle="modal" href="#resetPasswordModal" data-target="#resetPasswordModal">Reset Password</a>
    </form>
</script>


<div id="resetPasswordModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Reset Password</h4>
            </div>
            <div class="modal-body">
                <form id="passwordResetRequest">
                    <label for="inputEmail2" class="sr-only">Email address</label>
                    <input type="email" id="inputEmail2" class="form-control" name='email' placeholder="Email address" required autofocus>
                    <button class="btn btn-lg btn-primary btn-block" type="submit">Request Password Reset</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->