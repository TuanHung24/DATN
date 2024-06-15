@if(session('Error'))
    <div class="alert alert-danger d-flex align-items-center" role="alert">
        <div>
            {{ session('Error') }}
        </div>
    </div>
@endif
@if(session('Success'))
    <div class="alert alert-success d-flex align-items-center" role="alert">
        <div>
            {{ session('Success') }}
        </div>
    </div>
@endif