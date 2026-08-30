<div id="form-pemeriksaan">
    <?php echo $form->hiddenField($modPasienMasukPenunjang, 'pendaftaran_id', array('readonly' => true, 'class' => 'span3')); ?>
    <?php echo $form->hiddenField($modPasienMasukPenunjang, 'pasienmasukpenunjang_id', array('readonly' => true, 'class' => 'span3')); ?>
    <?php echo $form->hiddenField($modPasienMasukPenunjang, 'ruangan_id', array('readonly' => true, 'class' => 'span3')); ?>
    <div class="box2">
        <?php if(!isset($_GET['sukses']) && count($model->getJenisKasusPenyakitItems($modPasienMasukPenunjang->ruangan_id)) == 1) {$modPasienMasukPenunjang->jeniskasuspenyakit_id = $model->getJenisKasusPenyakitItems($modPasienMasukPenunjang->ruangan_id)[0]->jeniskasuspenyakit_id;}?>
        
        <div class="control-group">
            <?php // echo $form->labelEx($modPasienMasukPenunjang,'pegawai_id',array('class'=>'control-label')); 
            ?>
            <?php echo CHtml::label('Jenis Pelayanan <span class="required">*</span>', 'pegawai_id', array('class' => 'control-label required')); ?>
            <div class="controls">
            <?php echo $form->dropDownList($modPasienMasukPenunjang, 'jeniskasuspenyakit_id', CHtml::listData($model->getJenisKasusPenyakitItems($modPasienMasukPenunjang->ruangan_id), 'jeniskasuspenyakit_id', 'jeniskasuspenyakit_nama'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3 required')); ?>
            </div>
        </div>
        
        <?php echo $form->dropDownListRow($modPasienMasukPenunjang, 'kelaspelayanan_id', CHtml::listData($model->getKelasPelayananItems($modPasienMasukPenunjang->ruangan_id), 'kelaspelayanan_id', 'kelaspelayanan_nama'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'onchange' => "setKarcis();", 'class' => 'span3')); ?>
        <div class="control-group">
            <?php // echo $form->labelEx($modPasienMasukPenunjang,'pegawai_id',array('class'=>'control-label')); 
            ?>
            <?php echo CHtml::label('Dokter <span class="required">*</span>', 'pegawai_id', array('class' => 'control-label required')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($modPasienMasukPenunjang, 'pegawai_id', CHtml::listData($model->getDokterItems($modPasienMasukPenunjang->ruangan_id), 'pegawai_id', 'namaLengkap'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3 required')); ?>
            </div>
        </div>
        <div class="control-group hide">
            <?php echo CHtml::label('Radiografer', 'perawat_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($modPasienMasukPenunjang, 'perawat_id', CHtml::listData(ROPegawaiM::model()->getTenagaRads($modPasienMasukPenunjang->ruangan_id), 'pegawai_id', 'nama_pegawai'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3')); ?>
            </div>
        </div>
    </div>
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Pilih Pemeriksaan', array('{icon}' => '<i class="glyphicon glyphicon-briefcase"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', "onclick" => "setChecklistPemeriksaanRad($('#form-pemeriksaan')); ")); ?>
    <div id="form-tindakanpemeriksaan" style="margin-top: 8px;">
        <table class="table table-bordered table-condensed table-striped">
            <thead>
                <th>No.</th>
                <th>Jenis Pemeriksaan</th>
                <th>Nama Pemeriksaan</th>
                <th>Tgl. Rencana Pemeriksaan</th>
                <th>Elektif</th>
                <th>Jumlah</th>
                <th>Tarif</th>
                <th>Satuan</th>
                <th>Batal</th>
                <!--<th>Total Tarif</th>-->
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    <?php echo CHtml::hiddenField('is_elektif_kirim', '0', array('class' => 'span3 is_elektif')); ?>
</div>