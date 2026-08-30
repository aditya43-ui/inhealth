<tr>
	<td style="text-align: center;">
		<?php echo CHtml::textField("noUrut", $i,array('readonly'=>true,'class'=>'nourut span1'));?>		
	</td>
	<td style="text-align: center;">
		<?php echo $model->namabahanmakanan; ?>
		<?php echo CHtml::activeHiddenField($model, '[ii]bahanmakanan_id',array('class'=>'span3'));?>	
		<?php echo CHtml::activeHiddenField($model, '[ii]bahanmenudiet_id',array('class'=>'span3'));?>	
	</td>
	<td style="text-align: right;">
		<?php echo CHtml::activeHiddenField($model, '[ii]satuanbahan',array('class'=>'span3','readonly'=>true));?>	
		<?php echo CHtml::activeTextField($model, '[ii]jmlbahan',array('class'=>'span1 float2')).' '.$model->satuanbahan;?>	
	</td>
	
	<td style="text-align: center;" class="rowbutton">
		<?php //echo CHtml::link('<i class="icon-plus-sign icon-white"></i>', '#', array('class' => 'btn btn-danger','onclick'=>'tambahLookup()')); ?>
		<?php echo CHtml::link('<i class="'.MyIcon::getIcons('batal').'"></i>', '#', array('class'=>'','onclick'=>'hapusBahanMenuDiet(this)')); ?>
	</td>
</tr>