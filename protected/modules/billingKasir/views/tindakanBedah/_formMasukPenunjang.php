<?php echo $form->hiddenField($modPasienMasukPenunjang, 'pasienmasukpenunjang_id', array('readonly'=>true,'class'=>'span3')); ?>
<?php echo $form->hiddenField($modPasienMasukPenunjang, 'pasienkirimkeunitlain_id', array('readonly'=>true,'class'=>'span3')); ?>
<div class="control-group">
    <?php echo $form->labelEx($modPasienMasukPenunjang,'tglmasukpenunjang', array('class'=>'control-label')) ?>
    <div class="controls">
        <?php   
            $modPasienMasukPenunjang->tglmasukpenunjang = (!empty($modPasienMasukPenunjang->tglmasukpenunjang) ? date("d/m/Y H:i:s",strtotime($modPasienMasukPenunjang->tglmasukpenunjang)) : null);
            $this->widget('MyDateTimePicker',array(
                            'model'=>$modPasienMasukPenunjang,
                            'attribute'=>'tglmasukpenunjang',
                            'mode'=>'datetime',
                            'options'=> array(
//                                    'dateFormat'=>Params::DATE_FORMAT,
                                'showOn' => false,
//                                'maxDate' => 'd',
                            ),
                            'htmlOptions'=>array('class'=>'span3 dtPicker3 datetimemask','onkeyup'=>"return $(this).focusNextInputField(event)",),
        )); ?>
        <?php echo $form->error($modPasienMasukPenunjang, 'tglmasukpenunjang'); ?>
    </div>
</div>
<div class='control-group'>
    <?php echo CHtml::label("Ruangan <span class='required'>*</span>", CHtml::activeId($modPasienMasukPenunjang,'ruangan_id'),array('class'=>'control-label required'))?>                                   
    <div class='controls'>
        <?php echo $form->dropDownList($modPasienMasukPenunjang,'ruangan_id', CHtml::listData(BKPendaftaranT::model()->getRuanganItems(Params::INSTALASI_ID_IBS), 'ruangan_id', 'ruangan_nama') ,
                              array('empty'=>'-- Pilih --',
                            'onchange'=>"setDropdownDokter(this.value);setDropdownJeniskasuspenyakit(this.value);",
                            'onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'span3',
                            )); ?>  
    </div>
</div>
<?php echo $form->dropDownListRow($modPasienMasukPenunjang,'jeniskasuspenyakit_id', CHtml::listData(BKPendaftaranT::model()->getJenisKasusPenyakitItems($modPasienMasukPenunjang->ruangan_id), 'jeniskasuspenyakit_id', 'jeniskasuspenyakit_nama') ,array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'span3')); ?>
<?php echo $form->dropDownListRow($modPasienMasukPenunjang,'kelaspelayanan_id', CHtml::listData(BKPendaftaranT::model()->getKelasPelayananItems(), 'kelaspelayanan_id', 'kelaspelayanan_nama') ,array('onchange'=>'setChecklistPemeriksaanBedahSentral();','empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'span3')); ?>
<div class="control-group">
    <?php echo $form->labelEx($modPasienMasukPenunjang,'pegawai_id',array('class'=>'control-label')); ?>
    <div class="controls">
        <?php echo $form->dropDownList($modPasienMasukPenunjang,'pegawai_id', CHtml::listData(BKPendaftaranT::model()->getDokterItems($modPasienMasukPenunjang->ruangan_id), 'pegawai_id', 'nama_pegawai') ,array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span3')); ?>
    </div>
</div>

