<table>
    <thead>
        <tr>
            <th>user_id</th>
            <th>name</th>
            <th>email</th>
            <th>creation_date</th>
            <th>last_update_date</th>
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
        </tr>
        @endforeach
    </tbody>
</table>