<?php echo $form->hiddenField($modPasienMasukPenunjang, 'pasienmasukpenunjang_id', array('readonly'=>true,'class'=>'span3')); ?>
<?php echo $form->hiddenField($modPasienMasukPenunjang, 'pasienkirimkeunitlain_id', array('readonly'=>true,'class'=>'span3')); ?>
<?php echo $form->hiddenField($modPasienMasukPenunjang, 'ruangan_id', array('readonly'=>true,'class'=>'span3')); ?>

<?php echo $form->dropDownListRow($modPasienMasukPenunjang,'jeniskasuspenyakit_id', CHtml::listData(RMPendaftaranT::model()->getJenisKasusPenyakitItems(Params::RUANGAN_ID_FISIOTERAPI), 'jeniskasuspenyakit_id', 'jeniskasuspenyakit_nama') ,array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'span3')); ?>
<?php echo $form->dropDownListRow($modPasienMasukPenunjang,'kelaspelayanan_id', CHtml::listData(RMPendaftaranT::model()->getKelasPelayananItems(Params::RUANGAN_ID_FISIOTERAPI), 'kelaspelayanan_id', 'kelaspelayanan_nama') ,array('onchange'=>'setChecklistPemeriksaanRehab();setTindakanPemeriksaanReset();','empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'span3')); ?>
<div class="control-group">
    <?php echo $form->labelEx($modPasienMasukPenunjang,'pegawai_id',array('class'=>'control-label')); ?>
    <div class="controls">
        <?php echo $form->dropDownList($modPasienMasukPenunjang,'pegawai_id', CHtml::listData(RMPendaftaranT::model()->getDokterItems(Yii::app()->user->getState('ruangan_id')), 'pegawai_id', 'nama_pegawai') ,array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span3')); ?>
    </div>
</div>
<div class="control-group ">
    <?php echo CHtml::label('Tanggal Tindakan', 'tgl_tindakan_semua', array('class'=>'control-label')); ?>
    <div class="controls">
            <?php   
                    $this->widget('MyDateTimePicker',array(
                                    'name'=>'tgl_tindakan_semua',
                                    'mode'=>'datetime',
                                    'options'=> array(
                                        'dateFormat'=>Params::DATE_FORMAT,
                                        'maxDate' => 'd',
                                    ),
                                    'htmlOptions'=>array('readonly'=>true,'class'=>'span3'),
            )); ?>
    </div>
</div>


