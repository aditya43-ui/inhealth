<tr>
	<td style="text-align: center;">
		<?php echo CHtml::textField("noUrut", $i,array('readonly'=>true,'class'=>'nourut span1'));?>		
	</td>
	<td style="text-align: center;">
		<?php echo CHtml::activeTextField($model, '[ii]tiperesiko_nama',array('class'=>'span3','readonly'=>true));?>		
	</td>
	<td style="text-align: center;">
		<?php echo CHtml::activeTextField($model, '[ii]tiperesiko_namalain',array('class'=>'span3','readonly'=>true));?>		
	</td>
        <td style="text-align: center;">
		<?php echo CHtml::activeTextField($model, '[ii]tiperesiko_kode',array('class'=>'span3','readonly'=>true));?>		
	</td>
        <td style="text-align: center;">
		<?php echo CHtml::activeTextField($model, '[ii]tiperesiko_keterangan',array('class'=>'span3','readonly'=>true));?>		
	</td>
        <td style="text-align: center;">
		<?php echo CHtml::activeTextField($model, '[ii]tiperesiko_aktif',array('class'=>'span3','readonly'=>true));?>		
	</td>
	<td style="text-align: center;" class="rowbutton">
		<?php echo CHtml::link('<i class="icon-minus-sign icon-white"></i>', '#', array('class'=>'btn btn-primary','onclick'=>'hapusTemporary(this)')); ?>
	</td>
</tr>