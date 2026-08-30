<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label("Tgl. Pembayaran", 'tgl_rekam', array('class' => 'control-label')) ?>
            <div class="controls">
                <div class="daterange daterange-inline input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
                    <i class="entypo-calendar"></i>
                    <span><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                    <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                    <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                </div>
            </div>
        </div>
        <?php echo $form->textFieldRow($model, 'nopembayaran', array('placeholder' => 'No. Pembayaran', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
        <?php echo $form->textFieldRow($model, 'no_pendaftaran', array('placeholder' => 'No. Pendaftaran', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
        <?php echo $form->textFieldRow($model, 'no_rekam_medik', array('placeholder' => 'No. Rekam Medik', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
        <?php
        $carabayar = CarabayarM::model()->findAll(array(
            'condition' => 'carabayar_aktif = true',
            'order' => 'carabayar_nourut',
        ));
        $penjamin = PenjaminpasienM::model()->findAll(array(
            'condition' => 'penjamin_aktif = true',
            'order' => 'penjamin_nama',
        ));
        $pegawai = DokterV::model()->findAllByAttributes(array(
            'instalasi_id' => Params::INSTALASI_ID_RJ,
            'pegawai_aktif' => true,
        ), array(
            'order' => 'nama_pegawai',
        ));
        foreach ($carabayar as $idx => $item) {
            $penjamins = PenjaminpasienM::model()->findByAttributes(array(
                'carabayar_id' => $item->carabayar_id,
                'penjamin_aktif' => true,
            ));
            if (empty($penjamins)) unset($carabayar[$idx]);
        }
        $kelas = KelaspelayananM::model()->findAll('kelaspelayanan_aktif = true order by kelaspelayanan_nama');
        $kamar = KamarruanganM::model()->findAll(array(
            'join' => 'join ruangan_m r on r.ruangan_id = t.ruangan_id',
            'condition' => 't.kamarruangan_aktif = true and r.instalasi_id = ' . Params::INSTALASI_ID_RI,
            'order' => 't.kamarruangan_nokamar, t.kamarruangan_nobed',
        ));
        echo $form->dropDownListRow($model, 'carabayar_nama', CHtml::listData($carabayar, 'carabayar_nama', 'carabayar_nama'), array(
            'empty' => '-- Pilih --',
            'class' => 'span4',
            'ajax' => array(
                'type' => 'POST',
                'url' => $this->createUrl('/actionDynamic/getPenjaminPasien', array('encode' => false, 'namaModel' => get_class($model))),
                'success' => 'function(data){$("#' . CHtml::activeId($model, "penjamin_id") . '").html(data); }',
            ),
        ));
        echo $form->dropDownListRow($model, 'penjamin_nama', CHtml::listData($penjamin, 'penjamin_nama', 'penjamin_nama'), array('empty' => '-- Pilih --', 'class' => 'span4', 'maxlength' => 50));
        echo $form->dropDownListRow($model, 'kelastanggungan_id', CHtml::listData($kelas, 'kelaspelayanan_id', 'kelaspelayanan_nama'), array('empty' => '-- Pilih --', 'class' => 'span4', 'maxlength' => 50));
        ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'nama_pasien', array('placeholder' => 'Nama Pasien', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
        <div class="control-group">
                    <?php echo Chtml::label("NIK", 'no_identitas_pasien', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'no_identitas_pasien', array('class' => 'span4 custom-only', 'maxlength' => 50, 'rows' => 3, 'placeholder' => 'NIK')); ?>
                    </div>
                </div>
        <div class="control-group">
            <?php //echo $form->textFieldRow($model,'petugasadministrasi_nama',array('class'=>'span4','onkeypress'=>"return $(this).focusNextInputField(event)")); 
            ?>
            <?php echo $form->dropDownListRow($model, 'petugasadministrasi_id',  CHtml::listData($model->getKasirRuanganItems(), 'pegawai_id', 'pegawai.nama_pegawai'), array('empty' => '-- Pilih --', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
            <?php //echo $form->textFieldRow($model,'dokterpendaftaran_nama',array('class'=>'span4','onkeypress'=>"return $(this).focusNextInputField(event)")); 
            ?>
        </div>
        <?php
        // $instalasi = InstalasiM::model()->findAllByAttributes(array(
        //     'instalasi_id' => array(2, 3, 4, 8),
        // ));
        $instalasi = InstalasiM::model()->findAll(['order'=>'instalasi_aktif = true']);
        // $ruangan = RuanganM::model()->findAllByAttributes(array(
        //     'instalasi_id' => array(2, 3, 4, 8, ),
        //     'ruangan_aktif' => true,
        // ), array(
        //     'order' => 'instalasi_id, ruangan_nama',
        // ));
        $ruangan = RuanganM::model()->findAll(['order'=>'ruangan_aktif = true']);
        echo $form->dropDownListRow($model, 'instalasiakhir_id', CHtml::listData($instalasi, 'instalasi_id', 'instalasi_nama'), array(
            'empty' => '-- Pilih --',
            'class' => 'span4',
            'ajax' => array(
                'type' => 'POST',
                'url' => $this->createUrl('/actionDynamic/GetRuangAkhirDariInsAkhir', array('encode' => false, 'namaModel' => get_class($model))),
                'success' => 'function(data){$("#' . CHtml::activeId($model, "ruanganakhir_id") . '").html(data); }',
            ),
        ));
        echo $form->dropDownListRow($model, 'ruanganakhir_id', CHtml::listData($ruangan, 'ruangan_id', 'ruangan_nama'), array('empty' => '-- Pilih --', 'class' => 'span4', 'maxlength' => 50));
        echo $form->dropDownListRow($model, 'kelaspelayanan_id', CHtml::listData($kelas, 'kelaspelayanan_id', 'kelaspelayanan_nama'), array('empty' => '-- Pilih --', 'class' => 'span4', 'maxlength' => 50));
        echo $form->dropDownListRow($model, 'kamarruangan_id', CHtml::listData($kamar, 'kamarruangan_id', 'kamarDanTempatTidurPolos'), array('empty' => '-- Pilih --', 'class' => 'span4', 'maxlength' => 50));
        echo $form->dropDownListRow($model, 'closingkasir_id', array(2 => 'BELUM', 1 => 'SUDAH'), array('class' => 'span4', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)"));
        ?>
    </div>
</div>
<?php //echo $form->textFieldRow($model,'dokteradmisi_nama',array('class'=>'span4','onkeypress'=>"return $(this).focusNextInputField(event)")); 
?>
<!--<div class="control-group">
	<label for="tglbkm" class="control-label">-->
<?php //echo CHtml::activecheckBox($model, 'ceklis', array('uncheckValue'=>0,'rel'=>'tooltip' ,'data-original-title'=>'Cek untuk pencarian berdasarkan tanggal bkm')); 
?>
<!--Tanggal Bkm-->
<!--/label>
	 <div class="control-group">-->
<?php //$model->tgl_awal = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($model->tgl_awal, 'yyyy-MM-dd hh:mm:ss'),'medium','medium'); 
?>
<?php // echo CHtml::label('','tglbkm', array('class'=>'control-label inline')) 
?>
<!--<div class="controls">-->
<?php
/*   $this->widget('MyDateTimePicker',array(
								'model'=>$model,
								'attribute'=>'tgl_bkm_awal',
								'mode'=>'date',
								'options'=> array(
									'dateFormat'=>Params::DATE_FORMAT,
									'maxDate' => 'd',
								),
								'htmlOptions'=>array('class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
								),
		)); */ ?>
<!--</div>
</div>
<div class="control-group">-->
<?php //$model->tgl_akhir = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($model->tgl_akhir, 'yyyy-MM-dd hh:mm:ss'),'medium','medium'); 
?>
<?php //echo CHtml::label('Sampai Dengan','sampaiDenganbkm', array('class'=>'control-label inline')) 
?>
<!--<div class="controls">-->
<?php
/*$this->widget('MyDateTimePicker',array(
								'model'=>$model,
								'attribute'=>'tgl_bkm_akhir',
								'mode'=>'date',
								'options'=> array(
									'dateFormat'=>Params::DATE_FORMAT,
//                                                    'minDate' => 'd',
								),
								'htmlOptions'=>array('class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
								),
		));*/ ?>
<!--</div>
</div>-->