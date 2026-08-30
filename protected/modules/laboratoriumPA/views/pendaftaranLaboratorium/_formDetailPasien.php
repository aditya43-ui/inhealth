<?php echo $form->textFieldRow($modPasien,'alamatemail',array('placeholder'=>'contoh: info@piinformasi.com','class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
<div class="control-group ">
    <?php echo $form->labelEx($modPasien,'suku_id', array('class'=>'control-label refreshable')); ?>
    <div class="controls">
		<?php echo $form->dropDownList($modPasien,'suku_id', CHtml::listData($modPasien->getSukuItems(), 'suku_id', 'suku_nama'),array('class'=>'span3','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
	</div>
</div>
<div class="control-group ">
    <?php echo $form->labelEx($modPasien,'pendidikan_id', array('class'=>'control-label refreshable')) ?>
    <div class="controls">
		<?php echo $form->dropDownList($modPasien,'pendidikan_id', CHtml::listData($modPasien->getPendidikanItems(), 'pendidikan_id', 'pendidikan_nama'),array('empty'=>'-- Pilih --','class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
	</div>
</div>
<?php echo $form->textFieldRow($modPasien,'nama_ayah',array('placeholder'=>'Nama Ayah Kandung Pasien','class'=>'span3 '.$nama_kapital, 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
<div class="control-group ">
    <?php echo $form->labelEx($modPasien,'anakke', array('class'=>'control-label')) ?>
    <div class="controls">
        <?php echo $form->textField($modPasien,'anakke', array('class'=>'span1 integer','maxlength'=>2,'onkeypress'=>"return $(this).focusNextInputField(event)", )).' dari '; ?> 
        <?php echo $form->textField($modPasien,'jumlah_bersaudara', array('class'=>'span1 integer','maxlength'=>2,'onkeypress'=>"return $(this).focusNextInputField(event)", )).' bersaudara'; ?>    
    </div>
</div>
