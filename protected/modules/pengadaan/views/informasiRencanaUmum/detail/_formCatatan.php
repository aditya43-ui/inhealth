<div class="row-fluid">
    <div class="col-md-12">
        <div class="control-group">
            <?php echo CHtml::label("Uraian","nama_pasal", array('class' => 'control-label')) ?>
            <div class="controls">
                <?php 
                $modRiwayatPengadaan->riwayatpengadaan_catatan = 'Melakukan Review Rencana Umum Pengadaan';
                echo CHtml::activeTextArea($modRiwayatPengadaan, 'riwayatpengadaan_catatan',array('class' => 'autogrow span4')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($modRiwayatPengadaan, 'riwayatpengadaan_lampiran', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::activeFileField($modRiwayatPengadaan, 'riwayatpengadaan_lampiran',array()); ?>
                <?php echo CHtml::activeHiddenField($modRiwayatPengadaan, 'statusnya',array()); ?>
            </div>
        </div>
    </div>
</div>