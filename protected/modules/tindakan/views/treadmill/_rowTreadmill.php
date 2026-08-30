<tr>
    <td>
		<?php echo CHtml::hiddenField('no_urut',0,array('readonly'=>true,'class'=>'span1 integer', 'style'=>'width:20px;')); ?>
        <?php echo CHtml::activeTextField($modTreadmillDetail,'[ii]duration_treadmill',array('readonly'=>false,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modTreadmillDetail,'[ii]age_elev',array('readonly'=>false,'class'=>'span1')); ?>
    </td>
    <td>
				<?php echo CHtml::activeTextField($modTreadmillDetail,'[ii]td_systolic',array('readonly'=>false,'class'=>'span1 integer')); ?> /
				<?php echo CHtml::activeTextField($modTreadmillDetail,'[ii]td_diastolic',array('readonly'=>false,'class'=>'span1 integer')); ?> mmHg
    </td>
    <td>
        <?php echo CHtml::activeTextField($modTreadmillDetail,'[ii]heartrate_treadmill',array('readonly'=>false,'class'=>'span1 integer')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modTreadmillDetail,'[ii]workload_kph',array('readonly'=>false,'class'=>'span1 integer')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modTreadmillDetail,'[ii]est02_rate_min',array('readonly'=>false,'class'=>'span1 integer')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modTreadmillDetail,'[ii]max02_intake',array('readonly'=>false,'class'=>'span1 integer')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modTreadmillDetail,'[ii]mets_treadmill',array('readonly'=>false,'class'=>'span1 integer')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modTreadmillDetail,'[ii]fitnessclassification',array('readonly'=>false,'class'=>'span2')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modTreadmillDetail,'[ii]walking_kmhr_treadmill',array('readonly'=>false,'class'=>'span2')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modTreadmillDetail,'[ii]jogging_kmhr_treadmill',array('readonly'=>false,'class'=>'span2')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modTreadmillDetail,'[ii]bicycling_kmhr_treadmill',array('readonly'=>false,'class'=>'span2')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextArea($modTreadmillDetail,'[ii]sports_kmhr_treadmill',array('readonly'=>false,'class'=>'span2')); ?>
    </td>	
	<?php if(!isset($_GET['id'])){ ?>
		<td><a onclick="batal(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk membatalkan detail treadmill ini"><i class="icon-form-silang"></i></a></td>	
	<?php } ?>
</tr>