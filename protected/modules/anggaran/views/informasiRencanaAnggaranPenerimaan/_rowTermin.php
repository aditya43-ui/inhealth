<?php 
if ($update){ ?>

<?php
foreach ($modDetail as $i => $detail){
	$i++;
	$detail->nilaipenerimaan = $detail->nilaipenerimaan / (int)$digit_str;	
	$detail->nilaipenerimaan = $format->formatNumberForUser($detail->nilaipenerimaan);	
?>
<tr>
    <td>
        <?php echo CHtml::textField('no_urut',''.$i.'',array('readonly'=>true,'class'=>'span1 integer', 'style'=>'width:20px;')); ?>
    </td>
    <td>
        <?php echo $format->formatNumberForUser($detail->renanggaran_ke); ?>
		<?php echo CHtml::activeHiddenField($detail,'['.$i.']renanggaran_ke',array('value'=>$i,'class'=>'span2 integer','style'=>'width:20px;','readonly'=>true)); ?>
		<?php echo CHtml::activeHiddenField($detail,'['.$i.']renanggaranpenerimaandet_id',array('class'=>'span2 integer','style'=>'width:20px;','readonly'=>true)); ?>
    </td>
	<td>
        <div class="controls">
		<?php $detail->tglrenanggaranpen = $format->formatDateTimeForUser($detail->tglrenanggaranpen); ?>
		<?php 
			$this->widget('MyDateTimePicker', array(
				'model'=>$detail,
				'attribute'=>'['.$i.']tglrenanggaranpen',
				'mode' => 'date',
				'options' => array(
					'dateFormat' => Params::DATE_FORMAT,
				),
				'htmlOptions' => array('readonly' => true,'style'=>'width:80px;'),
			));
		?>
		</div>
	</td>
    <td>
		<?php echo CHtml::activeTextField($detail,'['.$i.']nilaipenerimaan',array('class'=>'span2 integer','style'=>'width:90px;','readonly'=>true)); ?>
	</td>
    <td>
        <a onclick="hapusRencana(this,<?php echo (isset($detail->renanggaranpenerimaandet_id) ? $detail->renanggaranpenerimaandet_id : 0); ?>);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk menghapus rencana"><i class="icon-form-silang"></i></a>
    </td>
</tr>
<?php } ?>

<?php }else {

	for ($i = 1; $i <= $termin; $i++) {  ?>
<tr>
    <td>
        <?php echo CHtml::textField('no_urut',''.$i.'',array('readonly'=>true,'class'=>'span1 integer', 'style'=>'width:20px;')); ?>
    </td>
    <td>
        <?php echo $format->formatNumberForUser($i); ?>
		<?php echo CHtml::activeHiddenField($modDetail,'['.$i.']termin',array('value'=>$i,'class'=>'span2 integer','style'=>'width:90px;','readonly'=>true)); ?>
		<?php echo CHtml::activeHiddenField($modDetail,'['.$i.']renanggaranpenerimaandet_id',array('class'=>'span2 integer','style'=>'width:20px;','readonly'=>true)); ?>
    </td>
	<td>
	<div class="input-append">
		<?php echo CHtml::activeTextField($modDetail, '['.$i.']tglrenanggaranpen', array('readonly'=>true,'class'=>'tanggal dtPicker2', 'style'=>'float:left;')); ?>
		<span class="add-on"><i class="entypo-calendar"></i></span>
	</div>
	</td>
    <td>
		<?php echo CHtml::activeTextField($modDetail,'['.$i.']nilaipenerimaan',array('class'=>'span2 integer','style'=>'width:90px;','readonly'=>true)); ?>
	</td>
    <td>
        <a onclick="hapusRencana(this,<?php echo (isset($detail->renanggaranpenerimaandet_id) ? $detail->renanggaranpenerimaandet_id : 0); ?>);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk menghapus rencana"><i class="icon-form-silang"></i></a>
    </td>
</tr>
<?php }
} ?>
