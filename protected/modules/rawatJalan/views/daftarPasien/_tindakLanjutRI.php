<?php
$this->widget('bootstrap.widgets.BootAlert');
?>
<?php
if (isset($_GET['sukses'])) {
    Yii::app()->user->setFlash('success', "Data pasien berhasil disimpan!");
}
?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'rjpasienadmisi-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
));
?>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-file-alt"></i> Data <b>Pasien</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modPendaftaran, 'tgl_pendaftaran', array('class' => 'control-label')); ?>
                    <?php echo CHtml::activeHiddenField($modPendaftaran, 'pendaftaran_id', array('class' => 'control-label')); ?>
                    <?php
                    if (!empty($modPasienPulang)) {
                        echo CHtml::activeHiddenField($modPasienPulang, 'tglpasienpulang', array('class' => 'span3 realtime', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true));
                        echo CHtml::activeHiddenField($modPasienPulang, 'pendaftaran_id', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true));
                        echo CHtml::activeHiddenField($modPasienPulang, 'pasien_id', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true));
                        echo CHtml::activeHiddenField($modPasienPulang, 'carakeluar_id', array('value' => Params::CARAKELUAR_ID_RAWATINAP, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true));
                        echo CHtml::activeHiddenField($modPasienPulang, 'kondisikeluar_id', array('value' => Params::KONDISIKELUAR_ID_RAWATINAP, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true));
                        echo CHtml::activeHiddenField($modPasienPulang, 'lamarawat', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true));
                    }
                    ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modPendaftaran, 'tgl_pendaftaran', array('readonly' => true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modPendaftaran, 'no_pendaftaran', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modPendaftaran, 'no_pendaftaran', array('readonly' => true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modPendaftaran, 'umur', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modPendaftaran, 'umur', array('readonly' => true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modPendaftaran, 'jeniskasuspenyakit_id', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modPendaftaran->jeniskasuspenyakit, 'jeniskasuspenyakit_nama', array('readonly' => true)); ?>
                        <?php echo CHtml::activeHiddenField($modPendaftaran, 'kelaspelayanan_id', array('readonly' => true)); ?>
                        <?php echo CHtml::activeHiddenField($modPendaftaran, 'carabayar_id', array('readonly' => true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modPendaftaran->dokter, 'dokter_pemeriksa', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modPendaftaran->dokter, 'nama_pegawai', array('readonly' => true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label"></label>
                    <div class="controls">
                        <?php
                        if (!empty($modPasien->photopasien)) {
                            echo CHtml::image(Params::urlPhotoPasienDirectory() . $modPasien->photopasien, 'Foto pasien', array('width' => 120));
                        } else {
                            echo CHtml::image(Params::urlPhotoPasienDirectory() . 'no_photo.jpeg', 'Foto pasien', array('width' => 120));
                        }
                        ?>
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modPasien, 'no_rekam_medik', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modPasien, 'no_rekam_medik', array('readonly' => true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modPasien, 'jeniskelamin', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modPasien, 'jeniskelamin', array('readonly' => true)); ?>
                    </div>
                </div>

                <div class="control-group">
                    <?php echo CHtml::activeLabel($modPasien, 'nama_pasien', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modPasien, 'nama_pasien', array('readonly' => true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modPasien, 'nama_bin', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modPasien, 'nama_bin', array('readonly' => true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modPendaftaran->kelaspelayanan, 'kelaspelayanan_nama', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modPendaftaran->kelaspelayanan, 'kelaspelayanan_nama', array('readonly' => true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modPasien, 'alamat_pasien', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modPasien, 'alamat_pasien', array('readonly' => true)); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-user-nurse"></i> Dokter Penerima dan DPJP
        </div>
    </div>
    <div class="panel-body">
        <?php echo $this->renderPartial($this->path_view.'_dpjp', array(
            'modelPulang' => $modPasienPulang,
            'form' => $form,
        ), true); ?>
    </div>
</div>

<div class="form-actions">
    <?php
    $disableSave = false;
    $status = isset($status) ? $status : "";
    $disableSave = (($status > 0) ? true : false);
    ?>
    <?php $disablePrint = ($disableSave) ? false : true; ?>
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'disabled' => $disableSave)); ?>
    <?php if ($disablePrint == false) { ?>
        <?php echo CHtml::link(Yii::t('mds', '{icon} Print Status Pasien', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printStatusRI();return false", 'disabled' => $disablePrint)); ?>
    <?php } else { ?>
        <?php echo CHtml::link(Yii::t('mds', '{icon} Print Status Pasien', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'disabled' => $disablePrint)); ?>
    <?php } ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        'javascript:void(0);',
        array(
            'class' => 'btn btn-default',
            'onclick' => 'closeDialog(); return false;'
        )
    ); ?>
</div>

<?php /*
<div class="block-tabel">
    <h6>Admisi <b>Ruangan</b></h6>
    <div class="row">
    <div class="col-sm-6">
    <?php echo $form->textFieldRow($modPasienAdmisi,'tgladmisi',array('readonly'=>true,'class'=>'span3 realtime', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>

    <div class='control-group'>
        <?php echo CHtml::label("Ruangan Inap <span class='required'>*</span>", CHtml::activeId($modPendaftaran,'ruangan_id'),array('class'=>'control-label required'))?>                                   
        <div class='controls'>
            <?php echo $form->dropDownList($modPasienAdmisi,'ruangan_id', CHtml::listData($modPendaftaran->getRuanganItems(Params::INSTALASI_ID_RI), 'ruangan_id', 'ruangan_nama') ,
                                  array('empty'=>'-- Pilih --',
                                'onchange'=>"setDropdownDokter(this.value);setDropdownJeniskasuspenyakit(this.value);setAntrianRuanganAdmisi()",
                                'onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'span3',
                                'ajax'=>array(
                                      'type'=>'POST',
                                      'url'=>$this->createUrl('SetDropdownKamarKosong',array('encode'=>false,'namaModel'=>get_class($modPasienAdmisi))),
                                      'update'=>'#'.CHtml::activeId($modPasienAdmisi, 'kamarruangan_id'),
                                      ),
                                )); ?>  
            <div class="checkbox inline">
                <i class="icon-home" style="margin:0" rel="tooltip" title="Ceklis jika Kunjungan Rumah"></i>
                <?php echo $form->checkBox($modPendaftaran,'kunjunganrumah', array('onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                <?php // echo CHtml::activeLabel($modPendaftaran, 'kunjunganrumah'); ?> 
            </div><?php echo CHtml::hiddenField('max-antrian-ruangan',0, array('rel'=>'tooltip','title'=>'Maksimum Antrian Ruangan','readonly'=>true,'onkeyup'=>"return $(this).focusNextInputField(event)",'style'=>'width:25px;',)); ?>
        </div>
    </div>
    <div class="control-group">
		<?php echo $form->LabelEx($modPasienAdmisi,'kamarruangan_id',array('class'=>'control-label'));?>
        <div class='controls'>
            <?php echo $form->dropDownList($modPasienAdmisi,'kamarruangan_id', array() ,
                            array('empty'=>'-- Pilih --',
                                'onkeypress'=>"return $(this).focusNextInputField(event)",
                                'class'=>'span2',
                                'ajax'=>array(
                                      'type'=>'POST',
                                      'url'=>$this->createUrl('SetDropdownKelasPelayanan',array('encode'=>false,'namaModel'=>get_class($modPasienAdmisi))),
                                      'update'=>'#'.CHtml::activeId($modPasienAdmisi, 'kelaspelayanan_id')),
                              )); ?>
            <?php echo $form->checkBox($modPasienAdmisi,'rawatgabung', array('onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
            <?php echo $form->LabelEx($modPasienAdmisi,'rawatgabung');?>
        </div>
    </div>
    <?php echo $form->dropDownListRow($modPendaftaran,'jeniskasuspenyakit_id', CHtml::listData($modPendaftaran->getJenisKasusPenyakitItems($modPasienAdmisi->ruangan_id), 'jeniskasuspenyakit_id', 'jeniskasuspenyakit_nama') ,array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'span3')); ?>
    </div>
    <div class="col-sm-6">
    <?php echo $form->dropDownListRow($modPasienAdmisi,'kelaspelayanan_id', CHtml::listData($modPendaftaran->getKelasPelayananItems(), 'kelaspelayanan_id', 'kelaspelayanan_nama') ,array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span3')); ?>
    <div class="control-group">
        <?php echo $form->labelEx($modPasienAdmisi,'pegawai_id',array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo $form->dropDownList($modPasienAdmisi,'pegawai_id', CHtml::listData($modPendaftaran->getDokterItems($modPasienAdmisi->ruangan_id), 'pegawai_id', 'NamaLengkap') ,array('onchange'=>'setAntrianDokterAdmisi();','empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span3')); ?>
            <?php echo CHtml::hiddenField('max-antrian-dokter',0, array('rel'=>'tooltip','title'=>'Maksimum Antrian Dokter','readonly'=>true,'onkeyup'=>"return $(this).focusNextInputField(event)",'style'=>'width:25px;','value'=>0)); ?>
        </div>
    </div>
	<div class="control-group">
        <?php echo CHtml::label('Jenis Penjamin','',array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($modPasienAdmisi,'carabayar_nama',array('value'=>$modPendaftaran->carabayar->carabayar_nama, 'readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->hiddenField($modPasienAdmisi,'carabayar_id',array('value'=>$modPendaftaran->carabayar_id, 'readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>	
    <?php 
//    echo $form->dropDownListRow($modPasienAdmisi,'penjamin_id', CHtml::listData($modPendaftaran->getPenjaminItems($modPendaftaran->carabayar_id), 'penjamin_id', 'penjamin_nama') ,array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'span3')); 
    ?>
	<div class="control-group">
        <?php echo CHtml::label('Penjamin','',array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($modPasienAdmisi,'penjamin_nama',array('value'=>$modPendaftaran->penjamin->penjamin_nama, 'readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->hiddenField($modPasienAdmisi,'penjamin_id',array('value'=>$modPendaftaran->penjamin_id, 'readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <?php echo $form->hiddenField($modPendaftaran,'is_bpjs', array('readonly'=>true,'class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
    </div>
    </div>
    
</div>
 * 
 */ ?>

<?php
$this->endWidget();
//if($status=='1'){
?>
<script>
    //    parent.location.reload();
    function closeDialog() {
        myConfirm("Apakah Anda ingin mengulang", "perhatian!", function(r) {
            if (r) {
                window.location.href = window.location.href;
            }
        });
    }
    /**
     * print status rawat inap dan karcis
     */
    function printStatusRI() {
        window.open('<?php echo Yii::app()->createUrl('pendaftaranPenjadwalan/pendaftaranRawatInap/printStatusRI', array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id, 'pasienadmisi_id' => $modPasienAdmisi->pasienadmisi_id, 'pasien_id' =>$modPasien->pasien_id)); ?>', 'printwin', 'left=100,top=100,width=480,height=640');
        <?php if ($modPasienAdmisi->carabayar_id == Params::CARABAYAR_ID_MEMBAYAR) { ?>
            window.open('<?php echo Yii::app()->createUrl('pendaftaranPenjadwalan/pendaftaranRawatInap/printKarcisRI', array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id, 'pasienadmisi_id' => $modPasienAdmisi->pasienadmisi_id)); ?>', '', 'left=600,top=100,width=480,height=640');
        <?php } ?>
    }
</script>
<?php
//}
?>

<script type="text/javascript">
    <?php if (Yii::app()->user->getState('isbridging') == TRUE) { ?>
        /**
         * set form asuransi 
         * @returns {undefined} */
        function setFormAsuransi(carabayar_id) {
            var carabayar_id_umum = <?php echo Params::CARABAYAR_ID_MEMBAYAR; ?>;
            var carabayar_id_bpjs = <?php echo Params::CARABAYAR_ID_BPJS; ?>;
            if (carabayar_id == carabayar_id_umum) {
                sembunyiFormAsuransi();
                sembunyiFormBpjs();

                $('#form-bpjs').hide();
                $('#form-asuransi').show();
                $('#form-rujukan').show();
            } else if (carabayar_id == carabayar_id_bpjs) {
                tampilFormBpjs();
                sembunyiFormAsuransi();
                sembunyiFormRujukan();

                $('#form-asuransi').hide();
                $('#form-bpjs').show();
                $('#form-rujukan').hide();
            } else {
                tampilFormAsuransi();
                sembunyiFormBpjs();
                $('#form-bpjs').hide();
                $('#form-asuransi').show();
                $('#form-rujukan').show();
            }
        }
    <?php } else { ?>
        /**
         * set form asuransi 
         * @returns {undefined} */
        function setFormAsuransi(carabayar_id) {
            var carabayar_id_umum = <?php echo Params::CARABAYAR_ID_MEMBAYAR; ?>;
            var carabayar_id_bpjs = <?php echo Params::CARABAYAR_ID_BPJS; ?>;
            if (carabayar_id == carabayar_id_umum) {
                sembunyiFormAsuransi();
            } else {
                tampilFormAsuransi();
            }
        }
    <?php } ?>
    /**
     * set dropdown dokter ruangan
     * @param {type} ruangan_id
     * @param {type} pegawai_id
     * @returns {undefined}
     */
    function setDropdownDokter(ruangan_id) {
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('SetDropdownDokter'); ?>',
            data: {
                ruangan_id: ruangan_id
            }, //
            dataType: "json",
            success: function(data) {
                $("#<?php echo CHtml::activeId($modPendaftaran, "pegawai_id"); ?>").html(data.listDokter);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    /**
     * set antrian ruangan
     * @param {type} obj
     * @returns {undefined} */
    function setAntrianDokterAdmisi(ruangan_id) {
        var ruangan_id = $("#<?php echo CHtml::activeId($modPasienAdmisi, 'ruangan_id') ?>").val();
        var pegawai_id = $("#<?php echo CHtml::activeId($modPasienAdmisi, 'pegawai_id') ?>").val();
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('SetAntrianDokter'); ?>',
            data: {
                ruangan_id: ruangan_id,
                pegawai_id: pegawai_id
            },
            dataType: "json",
            success: function(data) {
                $('#max-antrian-dokter').val(data.maxantriandokter);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    /**
     * set dropdown jeniskasuspenyakit_id
     * @param {type} ruangan_id
     * @returns {undefined} */
    function setDropdownJeniskasuspenyakit(ruangan_id) {
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('SetDropdownJeniskasuspenyakit'); ?>',
            data: {
                ruangan_id: ruangan_id
            }, //
            dataType: "json",
            success: function(data) {
                $("#<?php echo CHtml::activeId($modPendaftaran, "jeniskasuspenyakit_id"); ?>").html(data.listKasuspenyakit);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    /**
     * set antrian ruangan
     * @param {type} obj
     * @returns {undefined} */
    function setAntrianRuanganAdmisi() {
        var ruangan_id = $("#<?php echo CHtml::activeId($modPasienAdmisi, 'ruangan_id') ?>").val();
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('SetAntrianRuangan'); ?>',
            data: {
                ruangan_id: ruangan_id
            },
            dataType: "json",
            success: function(data) {
                if (data.maxantrianruangan != null) {
                    if (data.no_urutantri > data.maxantrianruangan) {
                        myAlert("Pasien Sudah Mencapai Maksimal Antrian Poliklinik " + data.maxantrianruangan + " Pasien");
                    }
                    $('#max-antrian-ruangan').val(data.maxantrianruangan);
                } else {
                    $('#max-antrian-ruangan').val(0);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    function sembunyiFormAsuransi() {
        $('#content-asuransi').find(".required").addClass("not-required").removeClass("required");
        $('#form-asuransi > .accordion-group > .accordion-heading').find(".btn").removeClass("btn-primary");
        $('#form-asuransi > .accordion-group > .accordion-heading').find(".icon-ok").addClass("icon-minus").removeClass("icon-ok");
        $('#content-asuransi').removeClass().addClass("accordion-body collapse");
        $('#content-asuransi').removeAttr("style").attr("style", "height:0px");
        $('#content-asuransi').find("input,select,textarea").attr("disabled", true);

    }

    function tampilFormAsuransi() {
        $('#form-asuransi > .accordion-group > .accordion-heading').find(".btn").addClass("btn-primary");
        $('#form-asuransi > .accordion-group > .accordion-heading').find(".icon-minus").addClass("icon-ok").removeClass("icon-minus");
        $('#content-asuransi').removeClass().addClass("accordion-body in collapse");
        $('#content-asuransi').find(".not-required").addClass("required").removeClass("not-required");
        $('#content-asuransi').removeAttr("style").attr("style", "height:auto");
        $('#content-asuransi').find("input,select,textarea").removeAttr("disabled");

    }

    function sembunyiFormBpjs() {
        $('#content-bpjs').find(".required").addClass("not-required").removeClass("required");
        $('#form-bpjs > .accordion-group > .accordion-heading').find(".btn").removeClass("btn-primary");
        $('#form-bpjs > .accordion-group > .accordion-heading').find(".icon-ok").addClass("icon-minus").removeClass("icon-ok");
        $('#content-bpjs').removeClass().addClass("accordion-body collapse");
        $('#content-bpjs').removeAttr("style").attr("style", "height:0px");
        $('#content-bpjs').find("input,select,textarea").attr("disabled", true);
        var is_bpjs = $("#<?php echo CHtml::activeId($modPendaftaran, "is_bpjs"); ?>");
        is_bpjs.val(0);
    }

    function tampilFormBpjs() {
        $('#form-bpjs > .accordion-group > .accordion-heading').find(".btn").addClass("btn-primary");
        $('#form-bpjs > .accordion-group > .accordion-heading').find(".icon-minus").addClass("icon-ok").removeClass("icon-minus");
        $('#content-bpjs').removeClass().addClass("accordion-body in collapse");
        $('#content-bpjs').find(".not-required").addClass("required").removeClass("not-required");
        $('#content-bpjs').removeAttr("style").attr("style", "height:auto");
        $('#content-bpjs').find("input,select,textarea").removeAttr("disabled");
        var is_bpjs = $("#<?php echo CHtml::activeId($modPendaftaran, "is_bpjs"); ?>");
        is_bpjs.val(1);
    }

    function sembunyiFormRujukan() {
        $('#content-rujukan').find(".required").addClass("not-required").removeClass("required");
        $('#form-rujukan > .accordion-group > .accordion-heading').find(".btn").removeClass("btn-primary");
        $('#form-rujukan > .accordion-group > .accordion-heading').find(".icon-ok").addClass("icon-minus").removeClass("icon-ok");
        $('#content-rujukan').removeClass().addClass("accordion-body collapse");
        $('#content-rujukan').removeAttr("style").attr("style", "height:0px");
        $('#content-rujukan').find("input,select,textarea").attr("disabled", true);
        var is_pasienrujukan = $("#<?php echo CHtml::activeId($modPendaftaran, "is_pasienrujukan"); ?>");
        is_pasienrujukan.val(0);
    }

    function tampilFormRujukan() {
        $('#form-rujukan > .accordion-group > .accordion-heading').find(".btn").addClass("btn-primary");
        $('#form-rujukan > .accordion-group > .accordion-heading').find(".icon-minus").addClass("icon-ok").removeClass("icon-minus");
        $('#content-rujukan').removeClass().addClass("accordion-body in collapse");
        $('#content-rujukan').find(".not-required").addClass("required").removeClass("not-required");
        $('#content-rujukan').removeAttr("style").attr("style", "height:auto");
        $('#content-rujukan').find("input,select,textarea").removeAttr("disabled");
        var is_pasienrujukan = $("#<?php echo CHtml::activeId($modPendaftaran, "is_pasienrujukan"); ?>");
        is_pasienrujukan.val(0);
    }
    $(document).ready(function() {
        // Notifikasi Pasien
        <?php
        if (isset($smspasien)) {
            if ($smspasien == 0) {
        ?>
                var params = [];
                params = {
                    instalasi_id: <?php echo Yii::app()->user->getState("instalasi_id"); ?>,
                    modul_id: <?php echo Yii::app()->session['modul_id']; ?>,
                    judulnotifikasi: 'GAGAL KIRIM SMS PASIEN',
                    isinotifikasi: 'Pasien <?php echo $modPasien->nama_pasien; ?> tidak memiliki nomor mobile'
                }; // 16 
                insert_notifikasi(params);
        <?php
            }
        }
        ?>

        <?php
        if (isset($modPasienAdmisi->pasienadmisi_id)) {
        ?>
            var params = [];
            params = {
                instalasi_id: <?php echo Yii::app()->user->getState("instalasi_id"); ?>,
                modul_id: <?php echo Params::MODUL_ID_GUDANGFARMASI; ?>,
                judulnotifikasi: 'Pasien Tindak Lanjut',
                isinotifikasi: '<?php echo $modPasien->nama_pasien ?> dengan <?php echo $modPasien->no_rekam_medik ?> telah dirujuk pada <?php echo $modPasienAdmisi->tgladmisi ?> ke <?php echo $modPasienAdmisi->ruangan->ruangan_nama ?>'
            }; // 16 
            insert_notifikasi(params);
        <?php
        }
        ?>
    });
</script>