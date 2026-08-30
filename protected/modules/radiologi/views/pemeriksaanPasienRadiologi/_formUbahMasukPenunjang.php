<div class="col-sm-12"><br>
    <?php //echo $form->dropDownListRow($modPasienMasukPenunjang, 'jeniskasuspenyakit_id', CHtml::listData(ROPendaftaranT::model()->getJenisKasusPenyakitItems($modPasienMasukPenunjang->ruangan_id), 'jeniskasuspenyakit_id', 'jeniskasuspenyakit_nama'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3')); ?>
    <div class="control-group">
        <?php echo $form->labelEx($modPasienMasukPenunjang, 'pegawai_id', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->dropDownList($modPasienMasukPenunjang, 'pegawai_id', CHtml::listData(ROPendaftaranT::model()->getDokterItems($modPasienMasukPenunjang->ruangan_id), 'pegawai_id', 'NamaLengkap'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span4')); ?>
            <?= CHtml::activeCheckBox($modPasienMasukPenunjang, 'ceklis', array('title'=>'Klik untuk masukan nama dokter luar.' , 'id' =>'ceklis'))?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Dokter Luar', 'dokterluar', array('class' => 'control-label', "id"=>"judul")); ?>
        <div class="controls">
            <?php echo $form->textField($modPasienMasukPenunjang, 'dokterluar',  array('id'=>'dokter','onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3', 'style'=>"display:none;")); ?>
        </div>
    </div>
    <div class="control-group">
    	<?php echo CHtml::label('PPDS','ppds_id',array('class'=>'control-label')); ?>
    	<div class="controls">
    		<?php echo $form->dropDownList($modPasienMasukPenunjang,'ppds_id', CHtml::listData(PpdsM::model()->findAll('ppds_aktif = true'), 'ppds_id', 'ppds_nama') ,array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span4')); ?>
    	</div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Radiografer', 'perawat_id', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->dropDownList($modPasienMasukPenunjang, 'perawat_id', CHtml::listData(ROPegawaiM::model()->getTenagaRads($modPasienMasukPenunjang->ruangan_id), 'pegawai_id', 'nama_pegawai'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span4')); ?>
        </div>
    </div>
</div>