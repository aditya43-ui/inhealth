<div class="row-fluid">
    <div class="col-md-12">
        <div class="control-group">
            <?php echo CHtml::label("Pegawai","nama_pasal", array('class' => 'control-label')) ?>
            <div class="controls">
                <?php 
                echo CHtml::activeTextField($modRevisi, 'pegawai_revisi',array('class' => 'span4', 'readonly' => true)); 
                echo CHtml::activeHiddenField($modRevisi, 'pegawai_id',array('class' => 'span4')); 
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Tanggal","nama_pasal", array('class' => 'control-label')) ?>
            <div class="controls">
                <?php 
                echo CHtml::activeTextField($modRevisi, 'revisi_tanggal',array('class' => 'span4', 'readonly' => true)); 
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Alasan Revisi","nama_pasal", array('class' => 'control-label')) ?>
            <div class="controls">
                <?php 
                echo CHtml::activeTextArea($modRevisi, 'revisi_alasan',array('class' => 'autogrow span4')); 
                echo CHtml::activeHiddenField($modRiwayatPengadaan, 'riwayatpengadaan_catatan',array('class' => 'autogrow span4')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Dokumen","nama_pasal", array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo CHtml::activeFileField($modRevisi, 'revisi_file',array()); ?>
                <?php echo CHtml::activeHiddenField($modRiwayatPengadaan, 'statusnya',array()); ?>
            </div>
        </div>
    </div>
</div>