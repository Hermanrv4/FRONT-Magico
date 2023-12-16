<div class="modal fade theme-modal {!! isset($modal_class_01)?$modal_class_01:'' !!}" id="{!! isset($modal_id)?$modal_id:'' !!}" tabindex="-1" role="dialog" aria-hidden="true" style="z-index:999999!important;">
    <div class="modal-dialog modal-dialog-centered {!! isset($modal_class_02)?$modal_class_02:'modal-lg' !!}" role="document">
        <div class="modal-content {!! isset($modal_class_03)?$modal_class_03:'' !!}">
            @if(isset($modal_title))
                <div class="modal-header">
                    <h4 class="modal-title" id="{!! isset($modal_id)?$modal_id:'' !!}-title">{!! $modal_title !!}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
            @endif
            <div class="modal-body">
                {!! isset($modal_body)?$modal_body:'' !!}
            </div>
            @if(isset($modal_footer))
                <div class="modal-footer justify-content-between">
                    {!! $modal_footer !!}
                </div>
            @endif
        </div>
    </div>
</div>
