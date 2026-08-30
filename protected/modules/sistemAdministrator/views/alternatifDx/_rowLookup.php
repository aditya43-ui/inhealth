<tr>
	<td style="text-align: center;">
		<?php echo CHtml::activeHiddenField($model, '[ii]alternatifdx_id',array('readonly'=>true));?>
		<?php echo CHtml::activeHiddenField($model, '[ii]diagnosakep_id',array('readonly'=>true));?>
		<?php echo CHtml::activeTextField($model, '[ii]alternatifdx_nama',array('class'=>'span12'));?>
	</td>
	<td style="text-align: center;">
		<?php echo CHtml::activeCheckBox($model,'[ii]alternatifdx_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event);","onClick"=>'cek(this);','checked'=>'checked')); ?>
	</td>
	<td style="text-align: center;" class="rowbutton">
		<?php echo CHtml::link('<i class="icon-plus-sign icon-white"></i>', '#', array('class' => 'btn btn-danger','onclick'=>'tambahLookup()')); ?>
		<?php echo CHtml::link('<i class="icon-minus-sign icon-white"></i>', '#', array('class' => 'btn btn-default','onclick'=>'hapusLookup(this)')); ?>
	</td>
</tr>
