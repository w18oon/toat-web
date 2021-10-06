@extends('layouts.app')

@section('title', 'Permission Settings')

@section('page-title')
    <h2><i class="fa fa-key"></i><x-get-program-code url="/users" /> Permission Settings</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/users">Users</a>
        </li>
        <li class="breadcrumb-item active">
            <strong>Permissions settings</strong>
        </li>
    </ol>
@stop
@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-content m-b-sm">
                <div>
                    <h2>Username : <strong>{{ $user->name }}</strong></h2>
                    <small><i class="fa fa-envelope"></i> : {{ $user->email }} </small>
                </div>
            </div>
            <div class="ibox-title">
                <h5>Permission settings</h5>
                <span id="ajax_spinner" class="pull-right">
                    @include('layouts._progress_bar',['size'=>16])
                </span>
            </div>
            <div class="ibox-content ">
                <table class="table ">
                    <thead>
                        <tr class="">
                            <th >Menu</th>
                            <th class="text-center" width="5%">Enter</th>
                            <th class="text-center" width="5%">View</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($menuList as $menu)
                            <tr class="">
                                <td >
                                    <h3 class="no-margins pb-2">
                                        <strong class="text-navy">{{ $menu->menu_title }}</strong>
                                    </h3>
                                    @include('menus._program_code', ['menu' => $menu])
                                </td>
                                @if (count($menu->children) == 0)
                                    @include('users._form_permission_switch', ['menu' => $menu])
                                @else
                                    <td></td>
                                    <td></td>
                                @endif
                            </tr>
                            @foreach ($menu->children ?? [] as $secondMenu)
                                <tr>
                                    <td>
                                        <div class="pl-4">
                                            <div class="pb-1">
                                                <i class="fa fa-arrow-circle-o-right text-muted"></i> {{ $secondMenu->menu_title }}
                                            </div>
                                            @include('menus._program_code', ['menu' => $secondMenu])
                                        </div>
                                    </td>
                                    @if (count($secondMenu->children) == 0)
                                        @include('users._form_permission_switch', ['menu' => $secondMenu])
                                    @else
                                        <td></td>
                                        <td></td>
                                    @endif
                                </tr>

                                @foreach ($secondMenu->children ?? [] as $thirdMenu)
                                    <tr>
                                        <td>
                                            <div class="pl-4 ml-4">
                                                <div class="pb-1">
                                                    <i class="fa fa-arrow-circle-o-right text-muted"></i> {{ $thirdMenu->menu_title }}
                                                </div>
                                                @include('menus._program_code', ['menu' => $thirdMenu])
                                            </div>
                                        </td>
                                        @include('users._form_permission_switch', ['menu' => $thirdMenu])
                                    </tr>
                                @endforeach
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@stop

@section('scripts')

<script type="text/javascript">

    $(document).ready(function () {

        $("#ajax_spinner").hide();

        var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
        elems.forEach(function(elem) {
          var switchery = new Switchery(elem,{ color: '#1AB394', size: 'small' });
        });

        $('[id^="cb_permission_"]').on('change',function(){
            var input_check = this;
            var permission_id = $(input_check).attr('data-perm-id');
            var is_checked = $(input_check).is(":checked");

            $.ajax({
                url: "{{ url('/') }}/users/{{ $user->user_id }}/assign-permission",
                type: 'POST',
                data: {_token: "{{ csrf_token() }}", permission_id:permission_id, is_checked:is_checked}
            })
            .done(function() {
                toastr.options = {
                    "timeOut": "100",
                }
                toastr.success('Permission was set !')
            });
        });

        $( document ).ajaxStart(function() {
            $("#ajax_spinner").show();
        });

        $( document ).ajaxStop(function() {
            $("#ajax_spinner").hide();
        });

    });

</script>

@stop