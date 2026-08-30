<?php echo $form->dropDownListRow($modPenanggungJawab,'pengantar', LookupM::getItems('pengantar'), array('class'=>'span3','empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
<?php echo $form->textFieldRow($modPenanggungJawab,'nama_pj', array('placeholder'=>'Nama Lengkap Penanggung Jawab','class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
<?php echo $form->radioButtonListInlineRow($modPenanggungJawab,'jeniskelamin', LookupM::getItems('jeniskelamin'), array('class'=>'','empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
<div class="control-group ">
    <?php echo $form->labelEx($modPenanggungJawab,'no_identitas', array('class'=>'control-label refreshable')) ?>
    <div class="controls">
        <?php echo $form->dropDownList($modPenanggungJawab,'jenisidentitas', LookupM::getItems('jenisidentitas'), array('empty'=>'-- Pilih --','class'=>'span2','style'=>'width:80px;','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
        <?php echo $form->textField($modPenanggungJawab,'no_identitas', array('placeholder'=>'No. Identitas','class'=>'span2','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
        <?php echo $form->error($modPenanggungJawab, 'jenisidentitas'); ?>
        <?php echo $form->error($modPenanggungJawab, 'no_identitas'); ?>
    </div>
</div>
<div class="control-group ">
	<?php echo $form->labelEx($modPenanggungJawab,'hubungankeluarga', array('class'=>'control-label refreshable')) ?>
	<div class="controls">
		<?php echo $form->dropDownList($modPenanggungJawab,'hubungankeluarga', LookupM::getItems('hubungankeluarga'), array('class'=>'span3','empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
	</div>
</div>
<?php echo $form->textFieldRow($modPenanggungJawab,'tempatlahir_pj', array('placeholder'=>'Kota/Kabupaten Kelahiran','class'=>'span3 all-caps','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
<div class="control-group ">
    <?php echo $form->labelEx($modPenanggungJawab,'tgllahir_pj', array('class'=>'control-label')) ?>
    <div class="controls">
        <?php   
        $this->widget('MyDateTimePicker',array(
                                'model'=>$modPenanggungJawab,
                                'attribute'=>'tgllahir_pj',
                                'mode'=>'date',
                                'options'=> array(
//                                            'dateFormat'=>Params::DATE_FORMAT,
                                    'showOn' => false,
                                    'maxDate' => 'd',
                                    'onkeyup'=>"js:function(){setUmurPjp(this.value);}",
                                    'onSelect'=>'js:function(){setUmurPjp(this.value);}',
                                    'yearRange'=> "-150:+0",
                                ),
                                'htmlOptions'=>array('placeholder'=>'00/00/0000','class'=>'dtPicker2 datemask', 'onblur'=>'setUmurPjp(this.value);','onkeyup'=>"return $(this).focusNextInputField(event)"
                                ),
        )); ?>
        <?php echo $form->error($modPenanggungJawab, 'tgllahir_pj'); ?>
    </div>
</div>
<div class="control-group ">
     <?php echo $form->labelEx($modPenanggungJawab,'umur', array('class'=>'control-label')) ?>
      <div class="controls">
       <?php
       $this->widget('CMaskedTextField', array(
       'model' => $modPenanggungJawab,
       'attribute' => 'umur_pj',
       'mask' => '99 Thn 99 Bln 99 Hr',
       'htmlOptions' => array('placeholder'=>'00 Thn 00 Bln 00 Hr','onkeyup'=>"return $(this).focusNextInputField(event)",'onblur'=>'setTglLahirPjp(this)', 'onchange'=>'setNamaGelar()', 'class'=>'span3')
        ));
        ?>
        <?php echo $form->error($modPenanggungJawab, 'umur_pj'); ?>
        </div>
</div>        
<?php echo $form->textAreaRow($modPenanggungJawab,'alamat_pj', array('placeholder'=>'Alamat Lengkap Penanggung Jawab','class'=>'span3','onchange'=>'convertToUpper(this)', 'onkeyup'=>'convertToUpper(this)','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
<?php echo $form->textFieldRow($modPenanggungJawab,'no_mobilepj', array('placeholder'=>'No. Ponsel Penanggug Jawab','onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'numbers-only span3')); ?>
<?php echo $form->textFieldRow($modPenanggungJawab,'no_teleponpj', array('placeholder'=>'No. Telepon Penanggug Jawab','onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'numbers-only span3')); ?>