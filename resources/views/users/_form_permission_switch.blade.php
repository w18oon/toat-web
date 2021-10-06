@foreach ($menu->permissions as $perm)
    <td class="text-center ">
        {!! Form::checkbox('permission[]' ,true , $user->hasPermission($perm)  , ['class' => 'form-control js-switch','id'=>'cb_permission_'.$perm->permission_id,'data-perm-id'=>$perm->permission_id ]) !!}
    </td>
@endforeach