<div class="panel panel-default">
    <div class="panel-heading">Reset Password</div>
    <div class="panel-body">
        <form class="form-horizontal" id="password_reset_update" >
            {{ csrf_field() }}
            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                <label for="password_update" class="col-md-4 control-label">Password</label>

                <div class="col-md-8">
                    <input id="password_update" type="text" class="form-control" name="password_update" required>

                    @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>
                <div class="col-md-8">
                    <input id="password-confirm" type="text" class="form-control" name="password_confirmation_update" required>

                    @if ($errors->has('password_confirmation'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                    </span>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                    <button type="submit_update" class="btn btn-primary">
                        Reset Password
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
