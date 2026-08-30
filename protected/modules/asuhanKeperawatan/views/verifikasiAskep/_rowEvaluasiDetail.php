<?php ?>
<tr class="rencanaaskepdet">
	<td>		
		<?php echo CHtml::activeHiddenField($modEvaluasiDet, '[0]evaluasiaskepdet_id', array('readonly' => true, 'class' => 'inputFormTabel')) ?>
		<?php echo CHtml::activeHiddenField($modEvaluasiDet, '[0]diagnosakep_id', array('readonly' => true, 'class' => 'inputFormTabel')) ?>
		<?php
		echo CHtml::activeHiddenField($modEvaluasiDet, '[0]isdiagnosa', array('value' => 1, 'onkeyup' => "return $(this).focusNextInputField(event);", 'class' => 'control-label'));
		?>
		<?php echo CHtml::activeTextField($modEvaluasiDet, '[0]diagnosakep_nama', array('readonly' => true, 'class' => 'span3')); ?>	
	</td>
	<td>

		<?php echo CHtml::activeTextArea($modEvaluasiDet, '[0]evaluasiaskepdet_subjektif', array('class' => 'span2')); ?>	

	</td>
	<td>

		<?php echo CHtml::activeTextArea($modEvaluasiDet, '[0]evaluasiaskepdet_objektif', array('class' => 'span2')); ?>

	</td>
	<td>

		<?php echo CHtml::activeTextArea($modEvaluasiDet, '[0]evaluasiaskepdet_assessment', array('class' => 'span2')); ?>

	</td>
	<td>

		<?php echo CHtml::activeTextArea($modEvaluasiDet, '[0]evaluasiaskepdet_planning', array('class' => 'span2')); ?>

	</td>
	<td>

		<?php
		echo CHtml::activeDropDownList($modEvaluasiDet, '[0]evaluasiaskepdet_hasil', array('tercapai' => 'Tercapai',
			'tidak tercapai' => 'Tidak Tercapai',), array('empty' => '-- Pilih --', 'class' => 'span2'));
		?>

    </td>
</tr>
