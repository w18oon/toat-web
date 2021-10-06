<table class="table">
    <thead>
        <tr class="">
            <th class="text-center" width="5%">
                <div>Active</div>
                <div><small>สถานะ</small></div>
            </th>
            <th width="20%">
                <div>Username</div>
                <div><small>ชื่อเข้าใช้งาน</small></div>
            </th>
            <th  class="hidden-sm hidden-xs">
                <div>Department Code</div>
                <div><small>รหัสแผนก</small></div>
            </th>
            <th width="20%" class="hidden-sm hidden-xs text-right">
                <div>Create Date</div>
                <div><small>วันที่สร้าง</small></div>
            </th>
            <th width="20%" class="hidden-sm hidden-xs text-right">
                <div>Last Update Date</div>
                <div><small>วันที่สร้าง</small></div>
            </th>
            @if (canEnter('/users'))
                <th class="no-sort" width="20%"></th>
            @endif
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
        <tr>
            <td class="text-center">
                @include('shared._status_active', ['isActive' =>  $user->active ])
            </td>
            <td>
                {{ $user->name }}
                <div class="small">
                    <i class="fa fa-envelope-o"></i> {{ $user->email }}
                </div>
            </td>
            <td>{{ $user->department_code }}</td>
            <td class="text-right hidden-sm hidden-xs">{{ $user->creation_date->format(trans('date.time-format')) }}</td>
            <td class="text-right hidden-sm hidden-xs">{{ $user->last_update_date->format(trans('date.time-format')) }}</td>
            @if (canEnter('/users'))
            <td class="text-center">
                <a href="{{ route('users.permissions', [$user]) }}" class="btn btn-white btn-sm">
                    <i class="fa fa-edit m-r-xs"></i> Permission
                </a>
                <a href="{{ route('users.edit', [$user]) }}" class="btn btn-white btn-sm">
                    <i class="fa fa-edit m-r-xs"></i> Edit
                </a>
            </td>
            @endif
        </tr>
        @endforeach
    </tbody>
</table>