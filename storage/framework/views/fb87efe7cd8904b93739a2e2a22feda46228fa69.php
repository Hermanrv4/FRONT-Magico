<div class="modal fade theme-modal <?php echo isset($modal_class_01)?$modal_class_01:''; ?>" id="<?php echo isset($modal_id)?$modal_id:''; ?>" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered <?php echo isset($modal_class_02)?$modal_class_02:'modal-xl'; ?>" role="document">
        <div class="modal-content <?php echo isset($modal_class_03)?$modal_class_03:''; ?>">
            <?php if(isset($modal_title)): ?>
                <div class="modal-header <?php echo isset($modal_class_04)?$modal_class_04:''; ?>">
                    <h4 class="modal-title" id="<?php echo isset($modal_id)?$modal_id:''; ?>-title"><b><?php echo $modal_title; ?></b></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
            <?php endif; ?>
            <div class="modal-body">
                <?php echo isset($modal_body)?$modal_body:''; ?>

            </div>
            <?php if(isset($modal_footer)): ?>
                <div class="modal-footer justify-content-between">
                    <?php echo $modal_footer; ?>

                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php /**PATH /var/www/html/magico.pe/resources/views/admin/component/engine/modal.blade.php ENDPATH**/ ?>