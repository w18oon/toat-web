<div class="text-muted" style="font-size: 11px;">
    <i class="fa fa-folder-open "></i> Program Code:
    @if ($programInfo =  $menu->programInfo)
        {{ $programInfo->program_code }}: {{ $programInfo->description }}
    @else
        -
    @endif
</div>