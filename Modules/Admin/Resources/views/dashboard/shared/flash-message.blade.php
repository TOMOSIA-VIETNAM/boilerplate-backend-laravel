@if(Session::has('error'))
    <div class="row">
        <div class="col-12">
            <div class="alert alert-danger alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ Session::get('error') }}</strong>
            </div>
        </div>
    </div>
@endif

@if(Session::has('success'))
    <div class="row">
        <div class="col-12">
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ Session::get('success') }}</strong>
            </div>
        </div>
    </div>
@endif
