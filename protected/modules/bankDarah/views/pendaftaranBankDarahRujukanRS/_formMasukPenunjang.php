<?php echo $form->hiddenField($modPasienMasukPenunjang, 'pasienmasukpenunjang_id', array('readonly'=>true,'class'=>'span3')); ?>
<?php echo $form->hiddenField($modPasienMasukPenunjang, 'pasienkirimkeunitlain_id', array('readonly'=>true,'class'=>'span3')); ?>
<?php echo $form->hiddenField($modPasienMasukPenunjang, 'ruangan_id', array('readonly'=>true,'class'=>'span3')); ?>

<?php echo $form->dropDownListRow($modPasienMasukPenunjang,'jeniskasuspenyakit_id', CHtml::listData(BDPendaftaranT::model()->getJenisKasusPenyakitItems($modPasienMasukPenunjang->ruangan_id), 'jeniskasuspenyakit_id', 'jeniskasuspenyakit_nama') ,array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'span3')); ?>
<?php echo $form->dropDownListRow($modPasienMasukPenunjang,'kelaspelayanan_id', CHtml::listData(BDPendaftaranT::model()->getKelasPelayananItems($modPasienMasukPenunjang->ruangan_id), 'kelaspelayanan_id', 'kelaspelayanan_nama') ,array('onchange'=>'setChecklistPemeriksaanLab();setTindakanPemeriksaanReset();','empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'span3')); ?>
<div class="control-group">
    <?php echo $form->labelEx($modPasienMasukPenunjang,'pegawai_id',array('class'=>'control-label')); ?>
    <div class="controls">
        <?php echo $form->dropDownList($modPasienMasukPenunjang,'pegawai_id', CHtml::listData(BDPendaftaranT::model()->getDokterItems($modPasienMasukPenunjang->ruangan_id), 'pegawai_id', 'nama_pegawai') ,array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span3')); ?>
    </div>
</div>
<div class="control-group">
    <?php echo CHtml::label('Analis','perawat_id',array('class'=>'control-label')); ?>
    <div class="controls">
        <?php echo $form->dropDownList($modPasienMasukPenunjang,'perawat_id', CHtml::listData(BDPegawaiM::model()->getTenagaLaboratoriums($modPasienMasukPenunjang->ruangan_id), 'pegawai_id', 'nama_pegawai') ,array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span3')); ?>
    </div>
</div>

