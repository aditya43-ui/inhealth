<tr>
    <td>
		<?php echo CHtml::hiddenField('no_urut',0,array('readonly'=>true,'class'=>'span2 integer', 'style'=>'width:20px;')); ?>
		<?php echo CHtml::activeTextField($modHearingTest,'nmperusahaan_rwt',array('readonly'=>false,'class'=>'span2 required')); ?>
    </td>
    <td>
		<?php echo CHtml::activeTextField($modHearingTest,'lamabekerja',array('readonly'=>false,'class'=>'span1 required')); ?> / 
		<?php echo CHtml::activeTextField($modHearingTest,'satuan_lamakrj',array('readonly'=>false,'class'=>'span1 required')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modHearingTest,'jnspekerjaan_rwt',array('readonly'=>false,'class'=>'span2')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modHearingTest,'kontakdgnbising',array('readonly'=>false,'class'=>'span2')); ?>
	</td>
</tr>