<tr>
	<td style="text-align: center;">
		<?php echo CHtml::textField("noUrut", $i,array('readonly'=>true,'class'=>'nourut span1'));?>		
	</td>
	<td style="text-align: center;">
		<?php echo CHtml::activeTextField($model, '[ii]tipeinsiden_nama',array('class'=>'span3','readonly'=>true));?>		
		<?php echo CHtml::activeHiddenField($model, '[ii]tipeinsiden_id',array('class'=>'span3 tipeinsiden_id','readonly'=>true));?>		
	</td>
        <td style="text-align: center;">
		<?php echo CHtml::activeTextField($model, '[ii]kelompoksubtipeinsiden_nama',array('class'=>'span3 nama','readonly'=>true));?>		
	</td>
	<td style="text-align: center;">
		<?php echo CHtml::activeTextField($model, '[ii]kelompoksubtipeinsiden_namalainnya',array('class'=>'span3','readonly'=>true));?>		
	</td>
        <td style="text-align: center;">
		<?php echo CHtml::activeTextField($model, '[ii]kelompoksubtipeinsiden_aktif',array('class'=>'span3','readonly'=>true));?>		
	</td>
	<td style="text-align: center;" class="rowbutton">
		<?php echo CHtml::link('<i class="icon-minus-sign icon-white"></i>', '#', array('class'=>'btn btn-primary','onclick'=>'hapusTemporary(this)')); ?>
	</td>
</tr>