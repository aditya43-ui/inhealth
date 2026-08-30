<tr>
	<td style="text-align: center;">
		<?php echo CHtml::activeHiddenField($modPenunjang, '[ii]datapenunjang_id', array('readonly' => true)); ?>
		<?php echo CHtml::activeHiddenField($modPenunjang, '[ii]pengkajianaskep_id', array('readonly' => true)); ?>

		<?php echo CHtml::activeTextField($modPenunjang, '[ii]datapenunjang_tgl', array('class' => 'span2 datetimemask', 'value' => date('d/m/Y H:i:s'))); ?>
	</td>
	<td style="text-align: center;">
		<?php echo CHtml::activeTextField($modPenunjang, '[ii]datapenunjang_nama', array('class' => 'span12')); ?>
	</td>
	<td style="text-align: center;" class="rowbutton">
		<?php echo CHtml::link('<i class="icon-plus-sign icon-white"></i>', '#', array('class' => 'btn btn-primary', 'onclick' => 'tambahPenunjang()')); ?>
		<?php echo CHtml::link('<i class="icon-minus-sign icon-white"></i>', '#', array('class' => 'btn btn-primary', 'onclick' => 'hapusPenunjang(this)')); ?>
	</td>
</tr>
