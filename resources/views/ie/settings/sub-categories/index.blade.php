@extends('layouts.app')

@section('title', 'Sub-Categories')

@section('page-title')
    {{-- PC --}}
    <h2 class="hidden-xs hidden-sm">
        {{ $category->name }} : Sub-Categories <br>
        <small>ประเภทการเบิกย่อย</small>
    </h2>
    <ol class="breadcrumb hidden-xs hidden-sm">
        <li class="breadcrumb-item">
            <a href="{{ route('ie.settings.categories.index') }}"> All Categories </a>
        </li>
        <li class="breadcrumb-item active">
            <strong>{{ $category->name }} : Sub-Categories</strong>
        </li>
    </ol>
    {{-- MOBILE --}}
    <h3 class="m-t-md m-b-sm show-xs-only show-sm-only">
        {{ $category->name }} : Sub-Categories <br>
        <small>ประเภทการเบิกย่อย</small>
    </h3>
@stop

@section('page-title-action')
    <div class="text-right m-t-lg">
        <a href="{{ route('ie.settings.sub-categories.create',[$category->category_id]) }}"
            class="btn btn-primary pull-right">
            <i class="fa fa-plus"></i> New Sub-Category
        </a>
    </div>
@stop

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-content">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr class="active">
                            <th width="8%" class="text-center"></th>
                            <th width="43%">
                                <div>Name / Description</div>
                                <div><small>ชื่อ / รายละเอียด</small></div>
                            </th>
                            {{-- <th>
                                <div>Description</div>
                                <div><small>รายละเอียด</small></div>
                            </th> --}}
                            <th width="10%" class="text-center hidden-sm hidden-xs">
                                <div>Required Attachment</div>
                                <div><small>บังคับแนบเอกสาร</small></div>
                            </th>
                            <th width="10%" class="text-center hidden-sm hidden-xs">
                                <div>Start Date</div>
                                <div><small>วันที่เริ่มใช้งาน</small></div>
                            </th>
                            <th width="12%" class="text-center hidden-sm hidden-xs">
                                <div>End Date</div>
                                <div><small>วันที่สิ้นสุดการใช้งาน</small></div>
                            </th>
                            <th width="10%" class="text-right"></th>
                        </tr>
                    </thead>
                    <tbody>
                    @if(count($sub_categories) > 0)
                        @foreach ($sub_categories as $index => $sub_category)
                            <tr>
                                <td class="text-center">
                                    <span class="hidden-xs">
                                        {!! activeIcon($sub_category->active) !!}
                                    </span>
                                    <span class="show-xs-only">
                                        <span class="m-t-sm">
                                        {!! activeMiniIcon($sub_category->active) !!}
                                        </span>
                                    </span>
                                </td>
                                <td style="white-space: normal;">
                                    <div>
                                        {{ $sub_category->name }} <br>
                                        <small style="color:#999;">{{ $sub_category->description }}</small>
                                    </div>
                                </td>
                               {{--  <td class="">
                                    {{ $sub_category->description }}
                                </td> --}}
                                <td class="text-center hidden-sm hidden-xs">
                                @if($sub_category->required_attachment)
                                    <span><i class="fa fa-check-circle-o text-navy"></i></span>
                                @endif
                                </td>
                                <td class="text-center hidden-sm hidden-xs">
                                    {{ dateFormatDisplay($sub_category->start_date) }}
                                </td>
                                <td class="text-center hidden-sm hidden-xs">
                                    {{ dateFormatDisplay($sub_category->end_date) }}
                                </td>
                                <td class="text-right">
                                    <a href="{{ route('ie.settings.sub-categories.infos.index',[$category->category_id,$sub_category->sub_category_id]) }}" class="btn btn-block btn-info btn-outline btn-xs"><i class="fa fa-folder"></i> Info. </a>
                                    <a href="{{ route('ie.settings.policies.index',[$category->category_id,$sub_category->sub_category_id]) }}" class="btn btn-block btn-primary btn-outline btn-xs"><i class="fa fa-key"></i> Policy </a>
                                    <a href="{{ route('ie.settings.sub-categories.edit', [$category->category_id,$sub_category->sub_category_id]) }}" class="btn btn-block btn-warning btn-outline btn-xs"><i class="fa fa-edit"></i> Edit </a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td class="text-center" colspan="7">
                                <h2 style="color:#AAA;margin-top: 30px;margin-bottom: 30px;">Not Found.</h2>
                            </td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
            @if(isset($sub_categories))
            <div class="text-right">
                {{ $sub_categories->links() }}
            </div>
            @endif
            </div>
        </div>
    </div>
</div>
@endsection