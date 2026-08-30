<div class="row-fluid">
    <div class="col-md-12">
        <div class="control-group">
            <?php echo CHtml::label("Uraian <span class='required'>*</span>","nama_pasal", array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo CHtml::activeTextArea($modRiwayatPengadaan, 'riwayatpengadaan_catatan',array('class' => 'autogrow span4 required')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($modRiwayatPengadaan, 'riwayatpengadaan_lampiran', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->fileField($modRiwayatPengadaan, 'riwayatpengadaan_lampiran',array()); ?>
            </div>
        </div>
    </div>
</div>