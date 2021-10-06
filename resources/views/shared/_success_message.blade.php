@if ($message = Session::get('success'))
    <div class="alert alert-success alert-block tw-border-2 tw-border-green-dark">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $message }}</strong>
    </div>
@endif