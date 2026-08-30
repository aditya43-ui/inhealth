<tr>
    <td>
        <?php echo CHtml::hiddenField('no_urut',0,array('readonly'=>true,'class'=>'span1 integer', 'style'=>'width:20px;')); ?>
        <?php echo CHtml::activeTextField($model,'vod_spheris',array('readonly'=>false,'class'=>'span1 float')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($model,'vod_cylindrys',array('readonly'=>false,'class'=>'span1 float')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($model,'vos_spheris',array('readonly'=>false,'class'=>'span1 float')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($model,'vos_cylindrys',array('readonly'=>false,'class'=>'span1 float')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($model,'add_kacamata',array('readonly'=>false,'class'=>'span1 float')); ?>
    </td>
</tr>

