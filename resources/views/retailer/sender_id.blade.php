    <div class="panel panel-default">
        <div class="panel-heading">Sender ID</div>

        <div class="panel-body">
            <form class="form-horizontal" id="sender_id_block" >
                {{ csrf_field() }}

                <div class="form-group{{ $errors->has('sender_id') ? ' has-error' : '' }}">
                    <label for="Sender ID" class="col-md-4 control-label">Sender Id</label>

                    <div class="col-md-8 sender_id_display">
                        {{$sender_id->CSI_SENDER_ID}}

                    </div>
                </div>

                <div class="form-group{{ $errors->has('temporary_sender_id') ? ' has-error' : '' }}">
                    <label for="temporary_sender_id" class="col-md-4 control-label">Temporary Sender Id</label>
                    <div class="col-md-8">
                        <input id="temporary_sender_id" type="text" value="{{$sender_id->CSI_TEMP_SENDERID}}" class="form-control" name="temporary_sender_id" required>

                        @if ($errors->has('temporary_sender_id'))
                        <span class="help-block">
                            <strong>{{ $errors->first('temporary_sender_id') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>

                <div id="sender_id_status"> Active </div>

                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <button type="submit" class="btn btn-primary">
                            Edit / Save
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>