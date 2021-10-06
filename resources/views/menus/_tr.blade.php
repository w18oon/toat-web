<tr>
    <td class="text-center">
        @include('shared._status_active', ['isActive' =>  $menu->active ])
    </td>
    <td class="">
        @if ($noParent)
            <h3 class="no-margins pb-2">
                <strong class="text-navy">{{ $menu->menu_title }}</strong>
            </h3>
            @include('menus._program_code', ['menu' => $menu])
        @else
            <div class="pl-4">
                <div class="pb-1">
                    <i class="fa fa-arrow-circle-o-right text-muted"></i> {{ $menu->menu_title }}
                </div>
                @include('menus._program_code', ['menu' => $menu])
            </div>
        @endif
    </td>
    <td class="">
        {{ $menu->parent_format }}
    </td>
    <td class="text-center">{{ $menu->sort_order }}</td>
    <td class="small">{{ $menu->url }}</td>
    <td class="text-center">
        <a href="{{ route('menus.edit', $menu) }}" class="btn btn-white btn-xs">
            <i class="fa fa-edit m-r-xs"></i> Edit
        </a>
    </td>
</tr>