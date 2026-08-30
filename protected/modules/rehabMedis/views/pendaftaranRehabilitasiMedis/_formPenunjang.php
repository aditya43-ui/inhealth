<div id="form-pemeriksaan">
    <?php echo $form->hiddenField($modPasienMasukPenunjang, 'pendaftaran_id', array('readonly'=>true,'class'=>'span3')); ?>
    <?php echo $form->hiddenField($modPasienMasukPenunjang, 'pasienmasukpenunjang_id', array('readonly'=>true,'class'=>'span3')); ?>
    <?php echo $form->hiddenField($modPasienMasukPenunjang, 'ruangan_id', array('readonly'=>true,'class'=>'span3')); ?>

    <?php echo $form->dropDownListRow($modPasienMasukPenunjang,'jeniskasuspenyakit_id', CHtml::listData($model->getJenisKasusPenyakitItems($modPasienMasukPenunjang->ruangan_id), 'jeniskasuspenyakit_id', 'jeniskasuspenyakit_nama') ,array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'span3')); ?>
    <?php echo $form->dropDownListRow($modPasienMasukPenunjang,'kelaspelayanan_id', CHtml::listData($model->getKelasPelayananItems($modPasienMasukPenunjang->ruangan_id), 'kelaspelayanan_id', 'kelaspelayanan_nama') ,array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)",'onchange'=>"setKarcis();", 'class'=>'span3')); ?>
    <div class="control-group">
        <?php echo $form->labelEx($modPasienMasukPenunjang,'pegawai_id',array('class'=>'control-label required', 'label'=>'Dokter <span class="required">*</span>')); ?>
        <div class="controls">
            <?php //echo $form->dropDownList($modPasienMasukPenunjang,'pegawai_id', CHtml::listData($model->getDokterItems($modPasienMasukPenunjang->ruangan_id), 'pegawai_id', 'nama_pegawai') ,array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span3')); ?>
            <?php echo $form->dropDownList($modPasienMasukPenunjang,'pegawai_id', CHtml::listData(PegawairuanganV::model()->findAllByAttributes(['ruangan_id'=>$modPasienMasukPenunjang->ruangan_id]), 'pegawai_id', 'namaLengkap') ,array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span3')); ?>
        </div>
    </div>
    <?php /* echo CHtml::htmlButton(Yii::t('mds','{icon} Pilih Pemeriksaan',array('{icon}'=>'<i class="icon-edit icon-white"></i>')),array('class' => 'btn btn-danger', 'type'=>'button', "onclick"=>"setChecklistPemeriksaanRehab($('#form-pemeriksaan')); ")); ?>
    <div id="form-tindakanpemeriksaan">
        <table class="table table-condensed table-striped">
            <thead>
                <th>No.</th>
                <th>Nama Pemeriksaan</th>
                <th>Jumlah</th>
                <th>Satuan</th>
                <th>Harga</th>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
     * 
     */ ?>
</div>


