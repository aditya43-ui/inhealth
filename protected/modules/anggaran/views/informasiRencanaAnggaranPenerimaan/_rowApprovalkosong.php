<?php 
if(!empty($modDetails)) {
    $this->renderPartial('_rowApproval',array('modDetails'=>$modDetails,'format'=>$format,'digit_str'=>$digit_str,'removeButton'=>true));
} else {
?>
<tr>
    <td>
        <?php echo CHtml::textField('no_urut','1',array('readonly'=>true,'class'=>'span1 integer2', 'style'=>'width:20px;')); ?>
	</td>
    <td>
        <?php echo CHtml::textField('renanggaran_ke','1',array('readonly'=>true,'class'=>'span1 integer2', 'style'=>'width:20px;')); ?>
		<?php echo CHtml::activeHiddenField($modDetail,'[0]renanggaranpenerimaandet_id',array('class'=>'span2 integer2','style'=>'width:20px;','readonly'=>true)); ?>
    </td>
    <td>
        <div class="controls">
		<?php $modDetail->tglrenanggaranpen = $format->formatDateTimeForUser($modDetail->tglrenanggaranpen); ?>
		<?php 
			$this->widget('MyDateTimePicker', array(
				'model'=>$modDetail,
				'attribute'=>'[0]tglrenanggaranpen',
				'value' => 'tglrenanggaranpen', 
				'mode' => 'date',
				'options' => array(
					'dateFormat' => Params::DATE_FORMAT,
				),
				'htmlOptions' => array('readonly' => true,'style'=>'width:80px;','class' => "tanggalanggaran"),
			));
		?>		
		</div>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modDetail,'[0]nilaipenerimaan',array('class'=>'span2 integer2 nilaianggaran','style'=>'width:90px;','onkeyup'=>'hitungTotalApprove();','onkeypress'=> 'return $(this).focusNextInputField(event);')); ?>
    </td>
    <td>
         <?php 
            if(!isset($removeButton)){
                $removeButton = false;
            }
            if($removeButton){ ?>
				<div style="display:none;" class="tambahRow">
				<?php
                echo CHtml::link("<i class='icon-plus'></i>", '#', array('onclick'=>'addRowApproval(this);return false;','rel'=>'tooltip','title'=>'Klik untuk menambah termin')); 
                ?>
				</div>
				<?php 
                echo CHtml::link("<i class='icon-minus'></i>", '#', array('onclick'=>'hapusApprove(this,'.(isset($modRencanaDetail->renanggaranpenerimaandet_id) ? $modRencanaDetail->renanggaranpenerimaandet_id : 0).');return false;','rel'=>'tooltip','title'=>'Klik untuk membatalkan termin'));
            } else { ?>
			<div style="display:none;" class="tambahRow">
				<?php echo CHtml::link("<i class='icon-plus'></i>", '#', array('onclick'=>'addRowApproval(this);return false;','rel'=>'tooltip','title'=>'Klik untuk menambah termin')); ?>
			</div>
				<?php echo CHtml::link("<i class='icon-minus'></i>", '#', array('onclick'=>'hapusApprove(this,'.(isset($modRencanaDetail->renanggaranpenerimaandet_id) ? $modRencanaDetail->renanggaranpenerimaandet_id : 0).');return false;','rel'=>'tooltip','title'=>'Klik untuk membatalkan termin')); ?>
        <?php } ?>
    </td>
</tr>
<?php } ?>