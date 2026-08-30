<?php echo $form->textFieldRow($modPasien,'alamatemail',array('placeholder'=>'contoh: info@.com','style'=>'width:190px;', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
<div class="control-group">
    <?php echo $form->labelEx($modPasien,'suku_id', array('class'=>'control-label refreshable')) ?>
    <div class="controls">
		<?php echo $form->dropDownList($modPasien,'suku_id', CHtml::listData($modPasien->getSukuItems(), 'suku_id', 'suku_nama'),array('style'=>'width:190px;','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
	</div>
</div>
<div class="control-group">
    <?php echo $form->labelEx($modPasien,'pendidikan_id', array('class'=>'control-label refreshable')) ?>
    <div class="controls">
		<?php echo $form->dropDownList($modPasien,'pendidikan_id', CHtml::listData($modPasien->getPendidikanItems(), 'pendidikan_id', 'pendidikan_nama'),array('empty'=>'-- Pilih --','style'=>'width:190px;', 'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
	</div>
</div>
<?php echo $form->textFieldRow($modPasien,'nama_ibu',array('placeholder'=>'Nama Ibu Kandung Pasien','style'=>'width:190px;'.$nama_kapital, 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
<div class="control-group">
    <?php echo $form->labelEx($modPasien,'anakke', array('class'=>'control-label')) ?>
    <div class="controls">
        <?php echo $form->textField($modPasien,'anakke', array('placeholder'=>'00','class'=>'integer','style'=>'width:40px;','maxlength'=>2,'onkeypress'=>"return $(this).focusNextInputField(event)", )).' dari '; ?> 
        <?php echo $form->textField($modPasien,'jumlah_bersaudara', array('placeholder'=>'00','class'=>'integer','style'=>'width:40px;','maxlength'=>2,'onkeypress'=>"return $(this).focusNextInputField(event)", )).' bersaudara'; ?>    
    </div>
</div>
