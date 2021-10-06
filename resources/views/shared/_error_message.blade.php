@if ($message = Session::get('error'))
    <div class="alert alert-danger alert-block tw-border-2 tw-border-red-dark">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $message }}</strong>
    </div>
@endif

@if ( count( $errors ) > 0 )
    <ul class="list-unstyled alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>

        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif