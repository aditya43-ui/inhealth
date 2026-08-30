<tr>
	<td style="width: 30%;">
		<?php echo CHtml::checkBox("pilihruangan", true, array("onkeyup"=>"return $(this).focusNextInputField(event);")); ?>
		<?php echo CHtml::activeHiddenField($ruangan, '[]ruangan_id',array()); ?>
		<label><?php echo $modPenjadwalanDetail->ruangan_nama; ?></label>
	</td>
	<td style="width: 30%;">
		<?php echo CHtml::label('Pola Shift','',array('control-label'))." ".CHtml::activeTextField($modPenjadwalanDetail, '[]pola_shift',array('placeholder'=>'PSML','class'=>'span2 all-caps')); ?>
	</td>
	<td>
		<?php $shiftygdiperbolehkan = '';
			if(count((array)$modShift) > 0){ ?>
			<?php 
				
				foreach($modShift as $i=>$shift){
					$shift->jmlpegawai = 0;
					$shiftygdiperbolehkan .= $shift->shift_kode;
			?>		
			<div class="control-group">							
				<?php echo CHtml::label($shift->shift_nama.' ('.$shift->shift_kode.')','',array('class'=>'control-label')); ?>
				<div class="controls">
					<?php echo CHtml::activeTextField($shift, '['.$shift->ruangan_id.']['.$shift->shift_id.']jmlpegawai',array('class'=>'span1 integer')); ?>
					<?php echo CHtml::activeHiddenField($shift, '['.$shift->ruangan_id.']['.$shift->shift_id.']shift_kode',array('readonly'=>true,'class'=>'span1')); ?>
				</div>		
			</div>	
			<?php } ?>	
		<?php }else{ ?>
		<div>-- Data tidak ditemukan --</div>
		<?php } ?>
		<?php echo CHtml::activeHiddenField($modPenjadwalanDetail, '[]shiftygdiperbolehkan',array('class'=>'span2','value'=>$shiftygdiperbolehkan)); ?>
	</td>
</tr>

