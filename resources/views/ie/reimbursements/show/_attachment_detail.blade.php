<div class="clearfix">
    <div class="clearfix m-b-xs">
        <small class="font-bold">Attachments (ไฟล์แนบ)</small>
        {{-- BUTTON ADD ATTACHMENT --}}
        @if($reim->isRequester() && $reim->isNotLock())
            <div class="text-right" style="font-size: 10px">
                @include('ie.reimbursements.show._add_attachment')
            </div>
        @endif
    </div>
    <ul class="list-unstyled project-files text-right m-b-xs mini-scroll-bar"
        style="max-height: 100px;overflow: auto;">
        {{-- ATTACHMENT LISTS --}}
        @if(count($reim->attachments) > 0)
            @foreach($reim->attachments as $attachment)
            <li style="width: 97%;overflow: hidden;white-space: nowrap;text-overflow: ellipsis;">
                @if($reim->isRequester() && $reim->isNotLock())
                {!! Form::open(['route' =>[ 'attachments.remove', $attachment->id],
                                'method' => 'delete',
                                'style' => 'display: inline-block;',
                                'id' => 'form-remove-attachment']) !!}
                    <button type="submit" title="Remove {{ $attachment->original_name }}"
                            class="btn btn-link btn-xs"
                            style="font-size: 11px; margin-left: 5px; color: #ED5565;">
                        <i class="fa fa-times"></i>
                    </button>
                {!! Form::close() !!}
                @endif
                <a href="{!! route('attachments.download', [$attachment->id]) !!}"
                    style="margin-left: 0px;color: #337ab7;">
                @if($attachment->is_image)
                    <i class="fa fa-file-picture-o"></i>
                @else
                    <i class="fa fa-file-text-o"></i>
                @endif
                &nbsp;{{ $attachment->original_name }}
                </a>
            </li>
            @endforeach
        @else
            <li> - </li>
        @endif
    </ul>
</div>
<hr class="m-t-sm m-b-xs">
