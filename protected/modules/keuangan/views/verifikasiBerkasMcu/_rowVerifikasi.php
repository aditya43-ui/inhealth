<tr>
	<td>
		<?php echo $modVerifikasi->no_pendaftaran ; ?>
		<?php echo CHtml::activeHiddenField($modVerifikasi,'[ii]pendaftaran_id',array('class'=>'span2')); ?>
		<?php echo CHtml::activeHiddenField($modVerifikasi,'[ii]pasien_id',array('class'=>'span2')); ?>
		<?php echo CHtml::activeHiddenField($modVerifikasi,'[ii]ruangan_id',array('class'=>'span2')); ?>
		<?php echo CHtml::activeHiddenField($modVerifikasi,'[ii]rumahsakitrujukan',array('class'=>'span2')); ?>
		<?php echo CHtml::activeHiddenField($modVerifikasi,'[ii]berkas_1',array('class'=>'span2')); ?>
		<?php echo CHtml::activeHiddenField($modVerifikasi,'[ii]berkas_2',array('class'=>'span2')); ?>
		<?php echo CHtml::activeHiddenField($modVerifikasi,'[ii]berkas_3',array('class'=>'span2')); ?>
		<?php echo CHtml::activeHiddenField($modVerifikasi,'[ii]berkas_4',array('class'=>'span2')); ?>
		<?php echo CHtml::activeHiddenField($modVerifikasi,'[ii]berkas_5',array('class'=>'span2')); ?>
	</td>
	<td><?php echo $modVerifikasi->no_rekam_medik ; ?></td>
	<td><?php echo $modVerifikasi->ruangan_nama ; ?></td>
	<td><?php echo $modVerifikasi->nama_pasien ; ?></td>
	<td>
		<?php echo CHtml::activeTextField($modVerifikasi,'[ii]nosurat_rs',array('class'=>'span2','readonly'=>true)); ?><br>
		<?php echo CHtml::activeHiddenField($modVerifikasi,'[ii]tglsurat_rs',array('class'=>'span2','readonly'=>true)); ?></td>
	<td><?php echo CHtml::activeTextField($modVerifikasi,'[ii]tglberkasmcumasuk',array('class'=>'span2','readonly'=>true)); ?>
		<?php echo CHtml::activeHiddenField($modVerifikasi,'[ii]tgljatuhtempo',array('class'=>'span2','readonly'=>true)); ?>
		<?php echo CHtml::activeHiddenField($modVerifikasi,'[ii]tglverifikasiberkasmcu',array('class'=>'span2','readonly'=>true)); ?></td>
	<td><?php echo $modVerifikasi->rumahsakitrujukan ; ?></td>
	<td>
		<?php echo CHtml::activeTextField($modVerifikasi,'[ii]tagihan',array('class'=>'span2 integer')); ?>
	</td>
	<td><?php echo CHtml::activeTextField($modVerifikasi,'[ii]statusverifikasiberkas',array('class'=>'span2','readonly'=>true)); ?></td>	
	<td style="text-align:center;">
		<?php // echo CHtml::activeCheckBox($modVerifikasi,'[ii]checklist',array('class'=>'inputFormTabel lebar2')); ?>
		<?php echo CHtml::link("<i class='icon-edit'></i>", '#', array('onclick'=>'setDialog(this);return false;','rel'=>'tooltip','title'=>'Klik untuk verifikasi berkas')); ?>
	</td>
</tr>