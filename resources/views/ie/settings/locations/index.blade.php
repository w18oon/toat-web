@extends('layouts.app')

@section('title', 'Locations')

@section('page-title')
    <h2>
        <div>Locations</div>
        <div><small>พื้นที่ทั้งหมด</small></div>
    </h2>
    <ol class="breadcrumb hidden-xs hidden-sm">
        <li class="active">
            <strong>Locations</strong>
        </li>
    </ol>
@stop

@section('page-title-action')
    <div class="text-right m-t-lg">
        <button class="btn btn-primary" data-toggle="modal" href="#modal-create-form">
            <i class="fa fa-plus"></i> New Location
        </button>
    </div>
@stop

@section('content')
<div class="row">
    <div class="col-lg-12">
    <div class="ibox float-e-margins">
        <div class="ibox-content">
            <div class="table-resposive">
                <table class="table table-hover" id="tableLocations">
                    <thead>
                        <tr class="active">
                            <th class="no-sort" width="10%"></th>
                            <th width="30%">
                                <div>Name</div>
                                <div><small>ชื่อ</small></div>
                            </th>
                            <th width="50%" class="hidden-xs">
                                <div>Description</div>
                                <div><small>รายละเอียด</small></div>
                            </th>
                            <th class="no-sort" width="10%"></th>
                        </tr>
                    </thead>
                    <tbody>
                    @if(count($locations) > 0)
                        @foreach ($locations as $location)
                            <tr>
                                <td class="text-center">
                                    <span class="hidden-xs">
                                        {!! activeIcon($location->active) !!}
                                    </span>
                                    {{-- <span class="show-xs-only">
                                        {!! activeMiniIcon($location->active) !!}
                                    </span> --}}
                                </td>
                                <td>
                                    {{ $location->name }}
                                </td>
                                <td class="hidden-xs">
                                    {{ $location->description }}
                                </td>
                                <td class="text-right">
                                    <a href="#" id="btn_edit_{{ $location->location_id }}" data-location-id="{{ $location->location_id }}" class="btn btn-block btn-outline btn-warning btn-xs">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td class="text-center" colspan="4">
                                <h2 style="color:#AAA;margin-top: 30px;margin-bottom: 30px;">Not Found.</h2>
                            </td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
            @if(isset($locations))
            <div class="text-right">
                {{ $locations->links() }}
            </div>
            @endif
        </div>
    </div>
    </div>
</div>

@include('ie.settings.locations._modal_create')
@include('ie.settings.locations._modal_edit')

@endsection


@section('scripts')
@parent
    <script>
        $(document).ready(function(){

            // $('#modal-create-form .chosen-select').chosen({width: "100%"});
            // FORM CREATE SWITCHERY
            var elem = document.querySelector('#modal-create-form .js-switch');
            var switchery = new Switchery(elem, { color: '#1AB394' });

            $("[id^='btn_edit_']").click(function(){
                $("#modal-edit-form").modal('show');
                let id = $(this).attr('data-location-id');
                $.ajax({
                    url: "/ie/settings/locations/"+id+"/edit",
                    type: 'GET',
                    beforeSend: function( xhr ) {
                        $("#modal-body-edit-form").html('\
                            <div class="m-t-lg m-b-lg">\
                                <div class="text-center sk-spinner sk-spinner-wave">\
                                    <div class="sk-rect1"></div>\
                                    <div class="sk-rect2"></div>\
                                    <div class="sk-rect3"></div>\
                                    <div class="sk-rect4"></div>\
                                    <div class="sk-rect5"></div>\
                                </div>\
                            </div>');
                    }
                })
                .done(function(result) {
                    $("#modal-body-edit-form").html(result);
                    // $("#modal-body-edit-form .chosen-select").chosen({width: "100%"});
                    // FORM EDIT SWITCHERY
                    var elem = document.querySelector('#modal-body-edit-form .js-switch');
                    var switchery = new Switchery(elem, { color: '#1AB394' });
                });
            });

        });
    </script>
@endsection