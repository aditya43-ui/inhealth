<tr>
	<td>
		<?php echo CHtml::textField('no_urut',0,array('readonly'=>true,'class'=>'span1 integer', 'style'=>'width:20px;')); ?>
		<?php //echo CHtml::activeHiddenField($modStoreEdDetail,'[ii]satuankecil_id',array('readonly'=>true,'class'=>'span1')); ?>
		<?php //echo CHtml::activeHiddenField($modStoreEdDetail,'[ii]qtystoked',array('readonly'=>true,'class'=>'span1')); ?>
		<?php //echo CHtml::activeHiddenField($modStoreEdDetail,'[ii]tglkadaluarsa',array('readonly'=>true,'class'=>'span1')); ?>
		<?php //echo CHtml::activeHiddenField($modStoreEdDetail,'[ii]obatalkes_id',array('readonly'=>true,'class'=>'span1')); ?>
		<?php echo CHtml::activeHiddenField($model,'[ii]ruangan_id',array('readonly'=>true,'class'=>'span1')); ?>
		<?php echo CHtml::activeHiddenField($model,'[ii]shift_id',array('readonly'=>true,'class'=>'span1')); ?>
		<?php //echo CHtml::activeHiddenField($modStoreEdDetail,'[ii]supplier_nama',array('readonly'=>true,'class'=>'span1')); ?>
	</td>
	<td>
		<?php echo (!empty($model->ruangan_nama) ? $model->ruangan_nama : "") ?>
	</td>
	<td>
		<?php echo (!empty($model->shift_nama) ? $model->shift_nama : "") ?>
	</td>
	<td>
		<?php echo CHtml::activeTextField($model, '[ii]jmlformasi',array('readonly'=>true,'style'=>'width:50px;')); ?>
	</td>
	<td>
		<?php echo CHtml::activeCheckBox($model, '[ii]formasishift_aktif',array('checked'=>'checked')); ?>
	</td>
</tr>