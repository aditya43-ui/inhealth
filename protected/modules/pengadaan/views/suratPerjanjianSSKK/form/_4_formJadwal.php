<div class="col-sm-6">
    <?php
        echo $form->textFieldRow($model,'tanggal_awal',array('class' => 'span3', 'readonly' => true));
        echo $form->textFieldRow($model,'tanggal_akhir',array('class' => 'span3', 'readonly' => true));
    ?>
</div>

<div class="col-sm-6">
    <div class="control-group">
        <?php echo $form->labelEx($model,'jangk_waktu',array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model,'jangk_waktu',array('class' => 'span1 numbers-only', 'readonly' => true));   ?>
        </div>        
        <div class="controls">
            <label>Hari</label>
        </div>
    </div>    
    
    <div class="control-group">
        <label class="control-label">Masa Pemeliharaan</label>
        <div class="controls">
            <?php echo $form->textField($model,'pemeliharaan_masa',array('class' => 'numbers-only span1')); ?>
        </div>        
        <div class="controls">
            <?php echo $form->dropDownList($model,'pemeliharaan_satuan', Params::satuanWaktu(),array('class' => 'span2', 'empty' => '-- Pilih --')); ?>
        </div>
    </div>
</div>