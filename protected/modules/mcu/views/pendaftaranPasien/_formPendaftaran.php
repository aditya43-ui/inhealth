<!--upload lagi karena RND-12742-->
<?php
$realtime = !isset($_GET['sukses']) ? 'realtime' : '';
?>
<?php echo $form->hiddenField($model, 'pendaftaran_id', array('readonly' => true, 'class' => 'span3')); ?>

<?php if (Yii::app()->user->getState('tgltransaksimundur')) { ?>
    <div class="control-group">
        <?php echo CHtml::Label('Tgl. Pendaftaran <span class="required">*</span> <i class="entypo-arrows-ccw"></i>', 'tgl_pendaftaran', array('rel' => 'tooltip', 'title' => 'Klik untuk set Realtime', 'class' => 'control-label', 'onclick' => '$("#MCPendaftaranT_tgl_pendaftaran").addClass("realtime");', 'style' => ' cursor: pointer;')) ?>
        <div class="controls">
            <?php
            $model->tgl_pendaftaran = (!empty($model->tgl_pendaftaran) ? date("d/m/Y H:i:s", strtotime($model->tgl_pendaftaran)) : date("d/m/Y H:i:s"));
            $this->widget('MyDateTimePicker', array(
                'model' => $model,
                'attribute' => 'tgl_pendaftaran',
                'mode' => 'datetime',
                'options' => array(
                    'showOn' => false,
                    'maxDate' => 'd',
                ),
                'htmlOptions' => array('class' => 'dtPicker3 ' . $realtime, 'onkeyup' => "return $(this).focusNextInputField(event)", 'onchange' => '$(this).removeClass("realtime")'),
            ));
            ?>
        </div>
    </div>
<?php
} else {
    echo $form->textFieldRow($model, 'tgl_pendaftaran', array('readonly' => true, 'class' => 'span3 realtime', 'onkeyup' => "return $(this).focusNextInputField(event);"));
}
?>
<div class='control-group'>
    <?php echo CHtml::label("Poliklinik <span class='required'>*</span>", CHtml::activeId($model, 'ruangan_id'), array('class' => 'control-label')) ?>
    <div class='controls'>
        <?php // echo $form->dropDownList($model,'ruangan_id', CHtml::listData($model->getRuanganMcuItems(Params::INSTALASI_ID_RJ), 'ruangan_id', 'ruangan_nama') ,
        /*     echo $form->dropDownList($model,'ruangan_id', CHtml::listData($model->getRuanganMCU(), 'ruangan_id', 'ruangan_nama') ,
                                      array('empty'=>'-- Pilih --',
                                    'onchange'=>"setDropdownDokter(this.value);setDropdownJeniskasuspenyakit(this.value);setKarcis();setAntrianRuangan()",
                                    'onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'span3',
                                    'ajax'=>array(
                                          'type'=>'POST',
                                          'url'=>$this->createUrl('SetDropdownKelasPelayanan',array('encode'=>false,'namaModel'=>get_class($model))),
                                          'update'=>'#'.CHtml::activeId($model, 'kelaspelayanan_id')),
                                    ));*/
        echo CHtml::dropDownList("ruanganidlogin", $model->ruangan_id, CHtml::listData($model->getRuanganMCU(), 'ruangan_id', 'ruangan_nama'), array('empyt' => '-- Pilih --', 'disabled' => true, 'class' => 'span3'));
        echo $form->hiddenField($model, 'ruangan_id', array('class' => 'required'));
        ?>

        <div class="checkbox inline">
            <i class="icon-home" style="margin:0" rel="tooltip" title="Ceklis jika Kunjungan Rumah"></i>
            <?php echo $form->checkBox($model, 'kunjunganrumah', array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
            <?php // echo CHtml::activeLabel($model, 'kunjunganrumah'); 
            ?>
        </div><?php echo CHtml::textField('max-antrian-ruangan', 0, array('rel' => 'tooltip', 'title' => 'Maksimum Antrian Ruangan', 'readonly' => true, 'onkeyup' => "return $(this).focusNextInputField(event)", 'style' => 'width:25px;',)); ?>
    </div>
</div>
<div class="control-group">
    <label class="control-label">Jenis Kasus Penyakit <span class="required">*</span></label>
    <div class="controls">
        <?php (empty($model->jeniskasuspenyakit_id)) ? $model->jeniskasuspenyakit_id = 18 : null ?>
        <?php echo $form->dropDownList($model, 'jeniskasuspenyakit_id', CHtml::listData($model->getJenisKasusPenyakitMCU($model->ruangan_id), 'jeniskasuspenyakit_id', 'jeniskasuspenyakit_nama'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3')); ?>
    </div>
</div>
<div class="control-group"hidden>
    <label class="control-label">Kelas Pelayanan <span class="required">*</span></label>
    <div class="controls">
        <?php
        //echo $form->dropDownListRow($model,'kelaspelayanan_id', CHtml::listData($model->getKelasPelayananItems($model->ruangan_id), 'kelaspelayanan_id', 'kelaspelayanan_nama') ,array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)",'onchange'=>"setKarcis()", 'class'=>'span3')); 
        echo $form->dropDownList($model, 'kelaspelayanan_id', CHtml::listData($model->getKelasPelayananItemsMCU(), 'kelaspelayanan_id', 'kelaspelayanan_nama'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3', 'disabled' => false, "onchange" => 'updateChecklistTindakanMcu();'));
        /**  echo $form->hiddenField($model,'kelaspelayanan_id'); **/
        ?>
    </div>
</div>
<div class="control-group">
    <?php echo $form->labelEx($model, 'pegawai_id', array('class' => 'control-label')); ?>
    <div class="controls">
        <?php echo $form->dropDownList($model, 'pegawai_id', CHtml::listData($model->getDokterItems($model->ruangan_id), 'pegawai_id', 'namaLengkap'), array('onchange' => 'setCountDokterDPJP();', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3')); ?>
        <?php echo CHtml::textField('max-antrian-dokter', 0, array('rel' => 'tooltip', 'title' => 'Maksimum Antrian Dokter', 'readonly' => true, 'onkeyup' => "return $(this).focusNextInputField(event)", 'style' => 'width:25px;', 'value' => 0)); ?>
    </div>
</div>
<div class="control-group">
    <?php echo $form->labelEx($model, 'ppjp_id', array('class' => 'control-label', 'label' => 'PPJP')); ?>
    <div class="controls">
        <?php echo $form->dropDownList($model, 'ppjp_id', PegawairuanganV::getDropPegawaiTambah(null, array(), array(
            'p.kelompokpegawai_id' => array(Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN),
            'p.unitkerja_id' => Params::UNITKERJA_ID_RAWAT_JALAN,
            't.instalasi_id' => Params::INSTALASI_ID_RJ,
        )), array('onchange' => 'setAntrianDokter();', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3')); ?>
    </div>
</div>
<div class="control-group">
    <?php echo $form->labelEx($model, 'carabayar_id', array('class' => 'control-label')) ?>
    <div class="controls">
        <?php
        echo $form->dropDownList($model, 'carabayar_id', CHtml::listData($model->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama'), array(
            'class' => 'form-control span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
            'style' => 'width:170px;'
        ));
        ?>
        <?php echo $form->error($model, 'carabayar_id'); ?>
    </div>
</div>
<div class="control-group">
    <?php echo $form->labelEx($model, 'penjamin_id', array('class' => 'control-label')) ?>
    <div class="controls">
        <?php
        echo $form->dropDownList($model, 'penjamin_id', empty($model->carabayar_id) ? array() : CHtml::listData($model->getPenjaminItems($model->carabayar_id), 'penjamin_id', 'penjamin_nama'), array(
            'class' => 'form-control span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
            'style' => 'width:170px;'
        ));
        ?>
        <?php echo $form->error($model, 'penjamin_id'); ?>
    </div>
</div>
<?php //echo $form->dropDownListRow($model, 'carabayar_id', CHtml::listData($model->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama'), array(
//     'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
//     'ajax' => array(
//         'type' => 'POST',
//         'url' => $this->createUrl('SetDropdownPenjaminPasien', array('encode' => false, 'namaModel' => get_class($model))),
//         //                                                        'update'=>'#'.CHtml::activeId($model, 'penjamin_id'),  //DIHIDE KARENA DIGANTIKAN DENGAN 'success'
//         'success' => 'function(data){$("#' . CHtml::activeId($model, "penjamin_id") . '").html(data); setKarcis();}',
//     ),
//     'onchange' => 'setFormAsuransi(this.value);$("#max-antrian-dokter").onblur',
//     'class' => 'span3',
// )); 
?>

<?php //echo $form->dropDownListRow($model, 'penjamin_id', CHtml::listData($model->getPenjaminItems($model->carabayar_id), 'penjamin_id', 'penjamin_nama'), array('empty' => '-- Pilih --', 'onchange' => 'setKarcis(); ', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3')); 
?>