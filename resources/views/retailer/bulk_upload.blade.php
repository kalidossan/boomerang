<div class="container">
    @if ( Session::has('success') )
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
            <span class="sr-only">Close</span>
        </button>
        <strong>{{ Session::get('success') }}</strong>
    </div>
    @endif

    @if ( Session::has('error') )
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
            <span class="sr-only">Close</span>
        </button>
        <strong>{{ Session::get('error') }}</strong>
    </div>
    @endif

    @if (count($errors) > 0)
    <div class="alert alert-danger">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
        <div>
            @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
            @endforeach
        </div>
    </div>
    @endif

    <div class="col-md-6">
    <div class="panel panel-default ">
        <div class="panel-heading">Bulk Customer Upload</div>

        <div class="panel-body">

            <div class="row">
                
                <div><a class="btn btn-primary btn-sm dowmload-tpl" href="{{ url('/download-tpl') }}">Download  Template</a></div>

            </div>

            <form id="bulk_upload_customer" action="{{ route('import') }}" method="POST" class="import-customers"  enctype="multipart/form-data">
                {{ csrf_field() }}

                <div class="xls-title" >Choose your xls/csv File : </div>

                <input type="file" name="file" class="form-control bulk-upload">
                
                <input type="hidden" id="bulk_upload_file" value="{{csrf_token()}}" id="bulk_upload_token" name="bulk_upload_token" />

                <input type="submit" id="bulk_upload_submit" class="btn btn-primary btn-sm" style="margin-left: 3%">
            </form>

        </div>
    </div>
    </div>

</div>


