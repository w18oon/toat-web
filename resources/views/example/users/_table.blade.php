<table class="table">
    <thead>
        <tr class="">
            <th class="text-center" width="5%">
                <div>ID</div>
                <div><small>รหัส</small></div>
            </th>
            <th width="20%">
                <div>Username</div>
                <div><small>ชื่อเข้าใช้งาน</small></div>
            </th>
            <th  class="hidden-sm hidden-xs">
                <div>Email Adress</div>
                <div><small>อีเมล์</small></div>
            </th>
            <th width="20%" class="hidden-sm hidden-xs text-right">
                <div>Create Date</div>
                <div><small>วันที่สร้าง</small></div>
            </th>
            <th width="20%" class="hidden-sm hidden-xs text-right">
                <div>Last Update Date</div>
                <div><small>วันที่สร้าง</small></div>
            </th>
            <th class="no-sort" width="20%"></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
        <tr>
            <td class="text-center">{{ $user->user_id }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td class="text-right hidden-sm hidden-xs">{{ $user->creation_date->format(trans('date.time-format')) }}</td>
            <td class="text-right hidden-sm hidden-xs">{{ $user->last_update_date->format(trans('date.time-format')) }}</td>
            <td class="text-center">
                {!! Form::open(['route' => ['example.users.destroy', $user], 'method' => 'POST']) !!}

                    @method('DELETE')
                    <a href="{{ route('example.users.interface', [$user]) }}"  class="btn btn-outline btn-success btn-xs">
                        Interface
                    </a>
                    <button type="submit" class="btn btn-danger btn-xs">
                        <i class="fa fa-times"></i> Remove
                    </button>
                    <a href="{{ route('example.users.edit', [$user]) }}" class="btn btn-white btn-xs">
                        <i class="fa fa-edit m-r-xs"></i> Edit
                    </a>

                {!! Form::close() !!}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>