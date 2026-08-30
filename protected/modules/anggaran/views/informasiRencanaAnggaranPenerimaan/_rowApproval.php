<?php
foreach($modDetails AS $i=>$modRencanaDetail){
$i++;
$modRencanaDetail->nilaipenerimaan = $modRencanaDetail->nilaipenerimaan; // / (int)$digit_str;	
$modRencanaDetail->nilaipenerimaan = $format->formatNumberForPrint($modRencanaDetail->nilaipenerimaan);	
$modRencanaDetail->renanggaran_ke = $format->formatNumberForPrint($modRencanaDetail->renanggaran_ke);	
?>
<tr>
    <td>
        <?php echo CHtml::textField('no_urut',''.$i.'',array('readonly'=>true,'class'=>'span1 integer2', 'style'=>'width:20px;')); ?>
	</td>
    <td>
		<?php echo CHtml::activeTextField($modRencanaDetail,'['.$i.']renanggaran_ke',array('class'=>'span2 integer2','style'=>'width:20px;','readonly'=>true)); ?>
		<?php echo CHtml::activeHiddenField($modRencanaDetail,'['.$i.']renanggaranpenerimaandet_id',array('class'=>'span2 integer2','style'=>'width:20px;','readonly'=>true)); ?>
    </td>
    <td>
        <div class="controls">
		<?php $modRencanaDetail->tglrenanggaranpen = $format->formatDateTimeForUser($modRencanaDetail->tglrenanggaranpen); ?>
		<?php 
			$this->widget('MyDateTimePicker', array(
				'model'=>$modRencanaDetail,
				'attribute'=>'['.$i.']tglrenanggaranpen',
				'mode' => 'date',
				'options' => array(
					'dateFormat' => Params::DATE_FORMAT,
				),
				'htmlOptions' => array('readonly' => true,'style'=>'width:80px;','class'=>'tanggalanggaran'),
			));
		?>
		</div>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modRencanaDetail,'['.$i.']nilaipenerimaan',array('class'=>'span2 integer2 nilaianggaran','style'=>'width:90px;','onkeyup'=>'hitungTotalApprove();','onkeypress'=> 'return $(this).focusNextInputField(event);')); ?>
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