<?php
    $i = (isset($i) ? $i : '');
?>
<tr>
                        
	<?php //echo $form->hiddenField($model,'pegawai_id',array('class'=>'span1 pegawai', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
	<?php //echo $form->hiddenField($model,'['.$x.']nama_pegawai',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
	<td>
		<?php echo $form->textField($model,'['.$i.']nourutprestasi',array('class'=>'span1 pegawai ', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
	</td>
	<td style="padding-right: 0;">
		<?php 
		$this->widget('MyDateTimePicker',array(
								'model'=>$model,
								'attribute'=>'['.$i.']tglprestasidiperoleh',
								'mode'=>'date',
								'options'=> array(
									'showOn' => false,
									// 'maxDate' => 'd',
									'yearRange'=> "-150:+0",
								),
								'htmlOptions'=>array('placeholder'=>'00/00/0000','class'=>'dtPicker2 datemask', 'onkeyup'=>"return $(this).focusNextInputField(event)"
								),
		)); ?>
	</td>
	<td>
		<?php echo $form->textField($model,'['.$i.']instansipemberi',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
	</td>
	<td>
		<?php echo $form->textField($model,'['.$i.']pejabatpemberi',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
	</td>
	<td>
		<?php echo $form->textField($model,'['.$i.']namapenghargaan',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
	</td>
	<td>
		<?php echo $form->textField($model,'['.$i.']keteranganprestasi',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
	</td>
	<td>
		<?php echo CHtml::link('<i class="icon-plus">&nbsp;</i>','',array('title'=>'Tambah data','rel'=>'tooltip','onclick'=>'tambahOrganisasi(this);return false','id'=>'tambah','style'=>'cursor:pointer;')); ?>
		<?php echo CHtml::link('<i class="icon-minus">&nbsp;</i>','#',array('style'=>'display:none;','title'=>'Hapus data','rel'=>'tooltip','id'=>'hapus','onclick'=>'hapusOrganisasi(this);return false','style'=>'cursor:pointer;')); ?>
	</td>
	<?php echo $form->hiddenField($model,'['.$i.']create_time',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
	<?php echo $form->hiddenField($model,'['.$i.']update_time',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
	<?php echo $form->hiddenField($model,'['.$i.']create_loginpemakai_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
	<?php echo $form->hiddenField($model,'['.$i.']update_loginpemakai_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
	<?php echo $form->hiddenField($model,'['.$i.']create_ruangan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
</tr>