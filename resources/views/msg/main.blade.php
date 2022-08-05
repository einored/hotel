@if(session('success'))
    <div class="alert alert-success"> 
        {{ session('success') }}
    </div>
@endif

@if(session('delete'))
    <div class="alert alert-delete"> 
        {{ session('delete') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-error"> 
        {{ session('error') }}
    </div>
@endif