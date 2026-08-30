<?php
$readonly = FALSE;
?>
<div class="row-fluid">
    <div class="span6">
        <div class="control-group">
            <?php echo CHtml::label("Instalasi <font style=color:red;> * </font>", 'instalasi_id', array('class' => 'control-label required')); ?>
            <div class="controls">
            <?php echo CHtml::textField('instalasi_tujuan', $modInfoKunjungan->instalasitujuan_nama, array('onchange' => "if($(this).val()=='') setKunjunganReset(); else setKunjungan(this.value,'','','')", 'class' => 'span3', 'placeholder' => 'Scan Barcode Pada Print Status', 'onkeyup' => "return $(this).focusNextInputField(event);", 'readonly' => true)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::hiddenField('pendaftaran_id', $modInfoKunjungan->pendaftaran_id, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            <?php echo CHtml::hiddenField('instalasiasal_id', $modInfoKunjungan->pendaftaran_id, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            <?php
            $pasienadmisi_id = (isset($modInfoKunjungan->pasienadmisi_id) ? $modInfoKunjungan->pasienadmisi_id : null);
            echo CHtml::hiddenField('pasienadmisi_id', $pasienadmisi_id, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);"));
            ?>
            <?php echo CHtml::label("Barcode", 'cari_pendaftaran_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::textField('cari_pendaftaran_id', $modInfoKunjungan->pendaftaran_id, array('onchange' => "if($(this).val()=='') setKunjunganReset(); else setKunjungan(this.value,'','','')", 'class' => 'span3', 'placeholder' => 'Scan Barcode Pada Print Status', 'onkeyup' => "return $(this).focusNextInputField(event);", 'readonly' => true)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Nama Pasien <font style=color:red;> * </font>", 'nama_pasien', array('class' => 'control-label required')); ?>
            <div class="controls">
                <?php echo CHtml::hiddenField('namadepan', $modInfoKunjungan->namadepan, array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                <?php
                    echo CHtml::textField('nama_pasien', $modInfoKunjungan->nama_pasien, array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'readonly' => true));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Tanggal Lahir', 'tanggal_lahir', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::textField('tanggal_lahir', $modInfoKunjungan->tanggal_lahir, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Umur", 'umur', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::textField('umur', CustomFunction::hitungUmur($modInfoKunjungan->tanggal_lahir), array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Jenis Kelamin", 'jeniskelamin', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::textField('jeniskelamin', $modInfoKunjungan->jeniskelamin, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Alamat Pasien", 'alamat_pasien', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::textArea('alamat_pasien', $modInfoKunjungan->alamat_pasien, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
    </div>
    <div class="span6">
        <div class="control-group no_pendaftaran">
            <?php echo CHtml::label("No. Pendaftaran <font style=color:red;> * </font>", 'no_pendaftaran', array('class' => 'control-label required')); ?>
            <div class="controls">
                <?php
                    echo CHtml::textField('no_pendaftaran', $modInfoKunjungan->no_pendaftaran, array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'readonly' => true));

                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("No. Rekam Medik <font style=color:red;> * </font>", 'no_rekam_medik', array('class' => 'control-label required')); ?>
            <div class="controls">
                <?php echo CHtml::hiddenField('pasien_id', $modInfoKunjungan->pasien_id, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                <?php // echo CHtml::textField('no_rekam_medik',$modInfoKunjungan->no_rekam_medik,array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
                ?>
                <?php
                    echo CHtml::textField('no_rekam_medik', $modInfoKunjungan->no_rekam_medik, array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'readonly' => true));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Ruangan Asal", 'ruangan_nama', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php

                echo CHtml::hiddenField('ruangan_id', $modInfoKunjungan->ruanganasal_id, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                ?>
                <?php echo CHtml::textField('ruangan_nama', $modInfoKunjungan->ruanganasal_nama, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Ruangan Tujuan", 'ruangan_nama', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php

                echo CHtml::hiddenField('ruangantujuan_id', $modInfoKunjungan->ruangantujuan_id, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                ?>
                <?php echo CHtml::textField('ruangantujuan_nama', $modInfoKunjungan->ruangantujuan_nama, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'Dokter Perujuk', array('class' => 'control-label')) ?>
            <div class="controls">
            <?php echo CHtml::textField('dokter_perujuk', $modInfoKunjungan->dokterperujuk_gelardepan.$modInfoKunjungan->dokterperujuk_nama.", ".$modInfoKunjungan->dokterperujuk_gelarbelakang, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Kelas Pelayanan", 'kelaspelayanan_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::hiddenField('kelaspelayanan_id', $modInfoKunjungan->kelaspelayanan_id, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo CHtml::textField('kelaspelayanan_nama', $modInfoKunjungan->kelaspelayanan_nama, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo CHtml::hiddenField('carabayar_id', Params::CARABAYAR_ID_BPJS, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            <?php echo CHtml::hiddenField('penjamin_id', Params::CARABAYAR_ID_BPJS, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->labelEx($model,'Jenis Penjamin/Penjamin', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo CHtml::textField('carabayar_nama', $modInfoKunjungan->carabayar_nama." / ".$modInfoKunjungan->penjamin_nama, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Tgl. SEP', '', array('class' => 'control-label')) ?>
            <div class="controls">
            <?php echo CHtml::textField('tgl_sep', empty($modInfoKunjungan->tglsep_utama) ? null : MyFormatter::formatDateTimeForUser($modInfoKunjungan->tglsep_utama), array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('No. SEP', '', array('class' => 'control-label')) ?>
            <div class="controls">
            <?php echo CHtml::textField('no_sep', $modInfoKunjungan->nosep_utama, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <div align="center">
            <?php
            $url_photopasien = (!empty($modPasien->photopasien) ? Params::urlPasienTumbsDirectory() . "kecil_" . $modPasien->photopasien : Params::urlPhotoPasienDirectory() . "no_photo.jpeg");
            ?>
            <img id="photo-preview" src="<?php echo $url_photopasien ?>" width="128px" />
        </div>
    </div>
</div>

<?php
//========= Dialog buat cari data pendaftaran / kunjungan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPasien',
    'options' => array(
        'title' => 'Pencarian Data Kunjungan Pasien',
        'autoOpen' => false,
        'modal' => true,
        'width' => 980,
        'height' => 480,
        'resizable' => false,
    ),
));
$modDialogKunjungan = new ARPasienM('searchDialogKunjungan');
$modDialogKunjungan->unsetAttributes();

$modDialogKunjungan->instalasi_id = Params::INSTALASI_ID_RJ;
// $modDialogKunjungan->tgl_pendaftaran = date('m/d/Y') . ' - ' . date('m/d/Y');

if (isset($_GET['ARPasienM'])) {
    $modDialogKunjungan->attributes = $_GET['ARPasienM'];
    $modDialogKunjungan->instalasi_id = (isset($_GET['ARPasienM']['instalasi_id']) ? $_GET['ARPasienM']['instalasi_id'] : null);
    $modDialogKunjungan->no_pendaftaran = (isset($_GET['ARPasienM']['no_pendaftaran']) ? $_GET['ARPasienM']['no_pendaftaran'] : "");
    $modDialogKunjungan->tgl_pendaftaran = (isset($_GET['ARPasienM']['tgl_pendaftaran']) ? $_GET['ARPasienM']['tgl_pendaftaran'] : "");
    $modDialogKunjungan->instalasi_nama = (isset($_GET['ARPasienM']['instalasi_nama']) ? $_GET['ARPasienM']['instalasi_nama'] : "");
    $modDialogKunjungan->carabayar_nama = (isset($_GET['ARPasienM']['carabayar_nama']) ? $_GET['ARPasienM']['carabayar_nama'] : "");
    $modDialogKunjungan->ruangan_nama = (isset($_GET['ARPasienM']['ruangan_nama']) ? $_GET['ARPasienM']['ruangan_nama'] : "");
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'datakunjungan-grid',
    'dataProvider' => $modDialogKunjungan->searchDialogKunjungan(),
    'filter' => $modDialogKunjungan,
    'template' => "{summaryNonPage}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                        "id" => "selectPendaftaran",
                                        "onClick" => "
                                            setInfoPasien($data->pendaftaran_id, \"\", \"\", \"\");
                                            $(\"#dialogPasien\").dialog(\"close\");
                                        "))',
        ),
        'no_pendaftaran',
        array(
            'header' => 'Tanggal Pendaftaran / Masuk Kamar',
            'type' => 'raw',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)
								.(isset($data->tglmasukkamar) ? "<br>".MyFormatter::formatDateTimeForUser($data->tglmasukkamar) : "")',
            'filter' =>
            CHtml::activeTextField($modDialogKunjungan, 'tgl_pendaftaran', array('class' => 'span3', 'readonly' => true)),
            /*$this->widget('MyDateTimePicker', array(
                'model' => $modDialogKunjungan,
                'attribute' => 'tgl_pendaftaran',
                'mode' => 'date', //date / datetime
                'gridFilter' => true,
                'options' => array(
                    'dateFormat' => Params::DATE_FORMAT,
                    'maxDate' => 'd',
                ),
                'htmlOptions' => array('readonly' => true, 'class' => "span2",
                    'onkeypress' => "return $(this).focusNextInputField(event)"),
                    ), true),*/
        ),
        array(
            'name' => 'no_rekam_medik',
            'type' => 'raw',
            'value' => '$data->no_rekam_medik',
        ),
        'nama_pasien',
        array(
            'name' => 'jeniskelamin',
            'type' => 'raw',
            'filter' => LookupM::model()->getItems('jeniskelamin'),
        ),
        array(
            'name' => 'instalasi_id',
            'value' => '$data->instalasi_nama',
            'type' => 'raw',
            'filter' => CHtml::activeHiddenField($modDialogKunjungan, 'instalasi_id') . CHtml::activeTextField($modDialogKunjungan, 'instalasi_nama'),
        ),
        array(
            'name' => 'ruangan_nama',
            'type' => 'raw',
        ),
        array(
            'name' => 'carabayar_nama',
            'type' => 'raw',
            'value' => '$data->carabayar_nama',
        ),
        array(
            'name' => 'alamat_pasien',
            'type' => 'raw',
            'value' => '$data->alamat_pasien',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
				jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
//				jQuery("#' . CHtml::activeId($modDialogKunjungan, 'tgl_pendaftaran') . '").datepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional["id"], {"dateFormat":"dd M yy","maxDate":"d","timeText":"Waktu","hourText":"Jam","minuteText":"Menit","secondText":"Detik","showSecond":true,"timeOnlyTitle":"Pilih Waktu","timeFormat":"hh:mm:ss","changeYear":true,"changeMonth":true,"showAnim":"fold","yearRange":"-80y:+20y"}));
//				jQuery("#' . CHtml::activeId($modDialogKunjungan, 'tgl_pendaftaran') . '_date").on("click", function(){jQuery("#' . CHtml::activeId($modDialogKunjungan, 'tgl_pendaftaran') . '").datepicker("show");});
                                jQuery("#' . CHtml::activeId($modDialogKunjungan, 'tgl_pendaftaran') . '").daterangepicker({
                                    "maxDate": "' . date('m/d/Y') . '",
                                    "showDropdowns": true,
                                });
			}',
));

$this->endWidget();
////======= end pendaftaran dialog =============
?>
<script>
    $(document).ready(function() {
        $('input[name="ARPasienM[tgl_pendaftaran]"]').daterangepicker({
            // "maxDate": "<?php echo date('m/d/Y') ?>",
            "showDropdowns": true,
        });
    });
</script>