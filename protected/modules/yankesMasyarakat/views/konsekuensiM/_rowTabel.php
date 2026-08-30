<tr>
	<td style="text-align: center;">
		<?php echo CHtml::textField("noUrut", $i,array('readonly'=>true,'class'=>'nourut span1'));?>		
	</td>
	<td style="text-align: center;">
		<?php echo CHtml::activeTextField($model, '[ii]konsekuensi_domain',array('class'=>'span3','readonly'=>true));?>		
	</td>
	<td style="text-align: center;">
		<?php echo CHtml::activeTextField($model, '[ii]konsekuensi_bobot',array('class'=>'span3','readonly'=>true));?>		
	</td>
        <td style="text-align: center;">
		<?php echo CHtml::activeTextField($model, '[ii]konsekuensi_namabobot',array('class'=>'span3','readonly'=>true));?>		
	</td>
        <td style="text-align: center;">
		<?php echo CHtml::activeTextField($model, '[ii]konsekuensi_deskripsi',array('class'=>'span3','readonly'=>true));?>		
	</td>
        <td style="text-align: center;">
		<?php echo CHtml::activeTextField($model, '[ii]konsekuensi_aktif',array('class'=>'span3','readonly'=>true));?>		
	</td>
	<td style="text-align: center;" class="rowbutton">
		<?php echo CHtml::link('<i class="icon-minus-sign icon-white"></i>', '#', array('class'=>'btn btn-primary','onclick'=>'hapusTemporary(this)')); ?>
	</td>
</tr>