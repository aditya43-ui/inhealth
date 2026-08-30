<tr>
	<td style="text-align: center;">
		<?php echo CHtml::activeHiddenField($model, '[ii]indikatorimplkepdet_id',array('readonly'=>true));?>
		<?php echo CHtml::activeHiddenField($model, '[ii]implementasikep_id',array('readonly'=>true));?>
		<?php echo CHtml::activeTextField($model, '[ii]indikatorimplkepdet_indikator',array('placeholder' => 'Indikator Implementasi Keperawatan', 'class'=>'span12 required'));?>
	</td>
	<td style="text-align: center;">
		<?php echo CHtml::activeCheckBox($model,'[ii]indikatorimplkepdet_aktif', array('rel' => 'tooltip', 'title' => 'Klik untuk mengaktifkan / menonaktifkan Indikator Implementasi Keperawatan','onkeypress'=>"return $(this).focusNextInputField(event);","onClick"=>'cek(this);','checked'=>'checked')); ?>
	</td>
	<td style="text-align: center;" class="rowbutton">
		<?php echo CHtml::link('<i class="icon-plus-sign icon-white"></i>', '#', array('rel' => 'tooltip', 'title' => 'Tambah Indikator', 'class'=>'btn btn-primary','onclick'=>'tambahLookup()')); ?>
		
	</td>
        <td style="text-align: center;" class="rowbutton">
		
		<?php echo CHtml::link('<i class="icon-minus-sign icon-white"></i>', '#', array('rel' => 'tooltip', 'title' => 'Hapus Indikator', 'class'=>'btn btn-danger','onclick'=>'hapusLookup(this)')); ?>
	</td>
</tr>
