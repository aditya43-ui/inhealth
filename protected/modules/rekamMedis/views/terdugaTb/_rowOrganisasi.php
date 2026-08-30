<?php
    $i = (isset($i) ? $i : '' );
?>
<tr>
	<td>
		<?php   
			$this->widget('MyDateTimePicker',array(
				'model'=>$model,
				'attribute'=>'['.$i.']tglpengambilan',
				'mode'=>'date',
				'options'=> array(
					'showOn' => false,
					// 'maxDate' => 'd',
					'yearRange'=> "-150:+0",
				),
				'htmlOptions'=>array('placeholder'=>'00/00/0000','class'=>'dtPicker2 datemask', 'onkeyup'=>"return $(this).focusNextInputField(event)"
				),
			)); 
		?>
	</td>
	<td>
		<?php   
			$this->widget('MyDateTimePicker',array(
				'model'=>$model,
				'attribute'=>'['.$i.']tglhasil',
				'mode'=>'date',
				'options'=> array(
					'showOn' => false,
					// 'maxDate' => 'd',
					'yearRange'=> "-150:+0",
				),
				'htmlOptions'=>array('placeholder'=>'00/00/0000','class'=>'dtPicker2 datemask', 'onkeyup'=>"return $(this).focusNextInputField(event)"
				),
			)); 
		?>
	</td>
	<td>
		<?php echo CHtml::activeDropDownList($model, '['.$i.']hasil', LookupM::getItems('hasiltb'), array('empty' => '-- Pilih --', 'class'=>'form-control hasil')) ?>
	</td>
	<td>
		<?php echo CHtml::link('<i class="icon-plus">&nbsp;</i>','',array('class' => 'btn btn-default', 'title'=>'Tambah data','rel'=>'tooltip','onclick'=>'tambahOrganisasi(this);return false','id'=>'tambah','style'=>'cursor:pointer;')); ?>
		<?php echo CHtml::link('<i class="icon-minus">&nbsp;</i>','#',array('class' => 'btn btn-default', 'style'=>'display:none;','title'=>'Hapus data','rel'=>'tooltip','id'=>'hapus','onclick'=>'hapusOrganisasi(this);return false','style'=>'cursor:pointer;')); ?>
	</td>
</tr>