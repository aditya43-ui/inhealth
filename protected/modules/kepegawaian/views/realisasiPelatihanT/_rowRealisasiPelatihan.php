<?php foreach ($modRencanaDiklat as $i => $model){ 
	$i++;
	$model->nama_pegawai = $model->pegawai->nama_pegawai;
	$model->nomorindukpegawai = $model->pegawai->nomorindukpegawai;
	$model->jenisdiklat_nama = $model->jenisdiklat->jenisdiklat_nama;
	$model->rencanadiklat_periode = $format->formatDateTimeForUser($model->rencanadiklat_periode);
	$model->lamadiklat = $model->lamadiklat." ".$model->satuan_lama;
	?>
<tr>
	<td>
		<?php echo CHtml::activecheckBox($model, '['.$i.']ceklis', array('checked'=>true,'rel'=>'tooltip' ,'data-original-title'=>'Cek untuk pilih realisasi pelatihan')); ?>
	</td>
    <td>
        <?php echo CHtml::textField('no_urut',$i,array('readonly'=>true,'class'=>'span1 integer', 'style'=>'width:20px;')); ?>
		<?php echo CHtml::activeHiddenField($model,'['.$i.']rencanadiklat_id',array('readonly'=>true,'class'=>'span2')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($model,'['.$i.']nomorindukpegawai',array('readonly'=>true,'class'=>'span3','style'=>'width:140px;')); ?>
    </td>
	<td>
		<?php echo  CHtml::activeHiddenField($model, '['.$i.']pegawai_id',array('readonly'=>true)); ?>
		<?php echo  CHtml::activeTextField($model, '['.$i.']nama_pegawai',array('readonly'=>true, 'style'=>'width:150px;')); ?>
	</td>
	<td>
		<?php echo  CHtml::activeHiddenField($model, '['.$i.']jenisdiklat_id',array('readonly'=>true)); ?>
		<?php echo  CHtml::activeTextField($model, '['.$i.']jenisdiklat_nama',array('readonly'=>true, 'style'=>'width:200px;')); ?>
	</td>
	<td>
		<?php echo  CHtml::activeTextField($model, '['.$i.']namadiklat',array('readonly'=>true, 'style'=>'width:200px;')); ?>
	</td>
	<td>
		<?php echo  CHtml::activeTextField($model, '['.$i.']rencanadiklat_periode',array('readonly'=>true, 'style'=>'width:70px;')); ?>
	</td>
	<td>
		<?php echo  CHtml::activeTextField($model, '['.$i.']lamadiklat',array('readonly'=>true, 'style'=>'width:70px;')); ?>
	</td>
	<td>
		<?php echo  CHtml::activeTextField($model, '['.$i.']tempat_diklat',array('readonly'=>true, 'style'=>'width:200px;')); ?>
	</td>
    <td>
        <?php echo CHtml::activeTextField($modPegawaiDiklat,'['.$i.']nomorkeputusandiklat',array('class'=>'span3 nomorkeputusandiklat required','style'=>'width:140px;', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
	<td>
		<?php 
			$this->widget('MyDateTimePicker', array(
				'model'=>$modPegawaiDiklat,
				'attribute'=>'['.$i.']tglditetapkandiklat',
				'value' => 'tglditetapkandiklat', 
				'mode' => 'date',
				'options' => array(
					'dateFormat' => Params::DATE_FORMAT,
				),
				'htmlOptions' => array('readonly' => true,'style'=>'width:80px;', 'onkeypress'=>"return $(this).focusNextInputField(event);",'class'=>'tglditetapkandiklat required'),
			));
		?>
	</td>
    <td>
        <?php echo CHtml::activeTextField($modPegawaiDiklat,'['.$i.']pejabatygmemdiklat',array('class'=>'span3 pejabatygmemdiklat','style'=>'width:150px;', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
	<td>
		<?php echo  CHtml::activeTextArea($modPegawaiDiklat,'['.$i.']pegawaidiklat_keterangan',array('rows'=>2, 'cols'=>10, 'class'=>'span3 pegawaidiklat_keterangan', 'onkeypress'=>"return $(this).focusNextInputField(event);",'style'=>'width:120px;')); ?>
	</td>
</tr>
<?php }  ?>
