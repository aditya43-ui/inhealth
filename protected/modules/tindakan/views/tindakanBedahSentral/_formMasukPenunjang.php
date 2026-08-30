<?php echo $form->hiddenField($modPendaftaran, 'pendaftaran_id', array('readonly'=>true,'class'=>'span3')); ?>
<?php echo $form->hiddenField($modPendaftaran, 'ruangan_id', array('readonly'=>true,'class'=>'span3')); ?>

<?php echo $form->dropDownListRow($modPendaftaran,'jeniskasuspenyakit_id', CHtml::listData(RJPendaftaranT::model()->getJenisKasusPenyakitItems($modPendaftaran->ruangan_id), 'jeniskasuspenyakit_id', 'jeniskasuspenyakit_nama') ,array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'span3')); ?>
<?php echo $form->dropDownListRow($modPendaftaran,'kelaspelayanan_id', CHtml::listData(RJPendaftaranT::model()->getKelasPelayananItems($modPendaftaran->ruangan_id), 'kelaspelayanan_id', 'kelaspelayanan_nama') ,array('onchange'=>'setChecklistPemeriksaanBedah();setTindakanPemeriksaanReset();','empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'span3')); ?>

