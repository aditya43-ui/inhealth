<div class="col-sm-12">
    <div class="control-group">
        <label class="control-label">Catatan</label>
        <div class="controls" style="width:79%;">
            <?php 
                echo CHtml::activeTextArea($model, 'riwayatpengadaan_catatan',array('class' => 'autogrow', 'style'=>'width:100%;'))
            ?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Lampiran</label>
            <div class="controls">
                <?php echo CHtml::activeFileField($model, 'riwayatpengadaan_lampiran',array()); ?>
                <?php echo CHtml::activeHiddenField($model, 'statusnya',array()); ?>
            </div>
    </div>
</div>