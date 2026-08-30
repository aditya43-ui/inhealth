<tr>
	<td style="text-align: center;">
		<?php echo CHtml::activeHiddenField($model, '[ii]lookup_id',array('readonly'=>true));?>
		<?php echo CHtml::activeHiddenField($model, '[ii]lookup_type',array('readonly'=>true));?>
		<?php echo CHtml::activeTextField($model, '[ii]lookup_name',array('class'=>'span3', 'onkeyup'=>"namaLain(this)"));?>
	</td>
	<td style="text-align: center;">
		<?php echo CHtml::activeTextField($model, '[ii]lookup_value',array('class'=>'span3 namalain'));?>	
	</td>
	<td style="text-align: center;">
		<?php echo CHtml::activeTextField($model, '[ii]lookup_kode',array('class'=>'span3'));?>	
	</td>
	<td style="text-align: center;">
		<?php echo CHtml::activeTextField($model, '[ii]lookup_urutan',array('class'=>'span3 integer'));?>	
	</td>
        <td style="text-align: center">
                <?php if (isset($_POST['is_update'])): ?><?php echo CHtml::activeCheckBox($model, '[ii]lookup_aktif',array('class'=>'span3')); ?><?php endif; ?>
        </td>
	<td style="text-align: center;" class="rowbutton">
		<?php echo CHtml::link('<i class="icon-plus-sign icon-white"></i>', '#', array('class'=>'btn btn-primary','onclick'=>'tambahLookup()')); ?>
		<?php echo CHtml::link('<i class="icon-minus-sign icon-white"></i>', '#', array('class'=>'btn btn-primary','onclick'=>'hapusLookup(this)')); ?>
	</td>
</tr>