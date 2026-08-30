<div class="control-group">
	<?php echo $form->labelEx($modKecelakaan,'jeniskecelakaan_id', array('class'=>'control-label refreshable')) ?>
	<div class="controls">
		<?php echo $form->dropDownList($modKecelakaan,'jeniskecelakaan_id', CHtml::listData($modKecelakaan->getJenisKecelakaanItems(), 'jeniskecelakaan_id', 'jeniskecelakaan_nama'), array('class'=>'span3','empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
	</div>
</div>
<?php echo $form->textFieldRow($modKecelakaan,'tempatkecelakaan', array('class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
<?php echo $form->textFieldRow($modKecelakaan,'keterangankecelakaan', array('class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)",)); ?>
<div class="control-group">
    <?php echo $form->labelEx($modKecelakaan,'tglkecelakaan', array('class'=>'control-label')) ?>
    <div class="controls">
        <?php   
            $modKecelakaan->tglkecelakaan = (!empty($modKecelakaan->tglkecelakaan) ? date("d/m/Y H:i:s",strtotime($modKecelakaan->tglkecelakaan)) : null);
            $this->widget('MyDateTimePicker',array(
                            'model'=>$modKecelakaan,
                            'attribute'=>'tglkecelakaan',
                            'mode'=>'datetime',
                            'options'=> array(
                                'showOn' => false,
                                'maxDate' => 'd',
                            ),
                            'htmlOptions'=>array('class'=>'dtPicker3 datetimemask','onkeyup'=>"return $(this).focusNextInputField(event)",),
        )); ?>
        <?php echo $form->error($modKecelakaan, 'tglkecelakaan'); ?>
    </div>
</div>