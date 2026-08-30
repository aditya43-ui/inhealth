<style>
    .sorot {
        background-color: yellow !important;
    }

</style>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'pasienpulang-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    'focus' => '#' . CHtml::activeId($modelPulang, 'penerimapasien'),
));
?>
<?php
$this->breadcrumbs = array(
    'Transaksi Pasien Pulang'
);
if (isset($_GET['sukses'])) {
    Yii::app()->user->setFlash('success', "Data pasien pulang berhasil disimpan!");
}
?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Pasien <b>
                <?php
                if (isset($_GET['melarikandiri']) && $_GET['melarikandiri'] == 1) {
                    echo "Melarikan Diri";
                } else if (isset($_GET['meninggal']) && $_GET['meninggal'] == 1) {
                    echo "Meninggal";
                } else {
                    echo "Pulang";
                } ?>
            </b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Informasi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-user"></i> Data <b>Pasien</b>
                </div>
            </div>
            <div class="panel-body">
                <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo CHtml::label('Tgl. Pendaftaran', 'tgl_pendaftaran', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo CHtml::textField('tgl_pendaftaran', MyFormatter::formatDateTimeForUser($modPasienPIV->tgl_pendaftaran), array('readonly' => true)); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">No. Pendaftaran</label>
                            <div class="controls">
                                <?php echo CHtml::activeTextField($modPasienPIV, 'no_pendaftaran', array('readonly' => true, 'class' => 'span2')); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::activeLabel($modPasienPIV, 'umur', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo CHtml::activeTextField($modPasienPIV, 'umur', array('readonly' => true)); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::activeLabel($modPasienPIV, 'jeniskasuspenyakit_nama', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo CHtml::activeTextField($modPasienPIV, 'jeniskasuspenyakit_nama', array('readonly' => true)); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo CHtml::activeLabel($modPasienPIV, 'no_rekam_medik', array('class' => 'no_rek control-label')); ?>
                            <div class="controls">
                                <?php
                                if (!isset($_GET['pendaftaran_id'])) {
                                    $this->widget('MyJuiAutoComplete', array(
                                        'model' => $modPasienPIV,
                                        'attribute' => 'no_rekam_medik',
                                        'value' => '',
                                        'source' => 'js: function(request, response) {
													   $.ajax({
														   url: "' . Yii::app()->createUrl('ActionAutoComplete/PasienRawatInap2') . '",
														   dataType: "json",
														   data: {
															   term: request.term,
														   },
														   success: function (data) {
																   response(data);
														   }
													   })
													}',
                                        'options' => array(
                                            'showAnim' => 'fold',
                                            'minLength' => 2,
                                            'focus' => 'js:function( event, ui ) {
														$(this).val( ui.item.label);
														return false;
													}',
                                            'select' => 'js:function( event, ui ) {
														  $("#' . CHtml::activeId($modPasienPIV, 'tgl_pendaftaran') . '").val(ui.item.tgl_pendaftaran);
														  $("#' . CHtml::activeId($modPasienPIV, 'no_pendaftaran') . '").val(ui.item.no_pendaftaran);   
														  $("#' . CHtml::activeId($modPasienPIV, 'umur') . '").val(ui.item.umur);     
														  $("#' . CHtml::activeId($modPasienPIV, 'jeniskasuspenyakit_nama') . '").val(ui.item.jeniskasuspenyakit_nama);
														  $("#' . CHtml::activeId($modPasienPIV, 'no_pendaftaran') . '").val(ui.item.no_pendaftaran);   
														  $("#' . CHtml::activeId($modPasienPIV, 'nama_pasien') . '").val(ui.item.nama_pasien);     
														  $("#' . CHtml::activeId($modPasienPIV, 'jeniskelamin') . '").val(ui.item.jeniskelamin);  
														  $("#' . CHtml::activeId($modPasienPIV, 'no_pendaftaran') . '").val(ui.item.no_pendaftaran);  
														  $("#' . CHtml::activeId($modPasienPIV, 'nama_bin') . '").val(ui.item.nama_bin);   
														  $("#' . CHtml::activeId($modelPulang, 'pendaftaran_id') . '").val(ui.item.pendaftaran_id);     
														  $("#' . CHtml::activeId($modelPulang, 'pasien_id') . '").val(ui.item.pasien_id);    
														  $("#' . CHtml::activeId($modelPulang, 'pasienadmisi_id') . '").val(ui.item.pasienadmisi_id);
														  $("#' . CHtml::activeId($modMasukKamar, 'masukkamar_id') . '").val(ui.item.masukkamar_id); 
														  $("#' . CHtml::activeId($modMasukKamar, 'tglmasukkamar') . '").val(ui.item.tglmasukkamar); 
															  }'
                                        ),
                                        'htmlOptions' => array(
                                            'readonly' => false,
                                            'placeholder' => 'No. Rekam Medik',
                                            'size' => 20,
                                            'class' => 'span3',
                                            'onkeypress' => "return $(this).focusNextInputField(event);",
                                        ),
                                        'tombolDialog' => array('idDialog' => 'dialogDaftarPasien', 'idTombol' => 'tombolPasienDialog'),
                                    ));
                                } else {
                                    echo CHtml::activeTextField($modPasienPIV, 'no_rekam_medik', array('readonly' => true));
                                }
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::activeLabel($modPasienPIV, 'jeniskelamin', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo CHtml::activeTextField($modPasienPIV, 'jeniskelamin', array('readonly' => true)); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::activeLabel($modPasienPIV, 'nama_pasien', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo CHtml::activeTextField($modPasienPIV, 'nama_pasien', array('readonly' => true)); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::activeLabel($modPasienPIV, 'nama_alias', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo CHtml::activeTextField($modPasienPIV, 'nama_bin', array('readonly' => true)); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php
                            if (!empty($modPendaftaran->pendaftaran_id)) {
                                echo CHtml::hiddenField("pegawaiPemeriksa", $modPendaftaran->pegawai_id);
                                echo CHtml::hiddenField("ruanganAsal", $modPendaftaran->ruangan_id);
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <?php
                $is_meninggal = false;
                if (isset($_GET['meninggal']) && $_GET['meninggal'] == 1) {
                    $is_meninggal = true;
                }
                ?>
                <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                                            ?></p>-->
                <?php echo $form->errorSummary(array($modelPulang)); ?>
                <div class="row">
                    <div class="col-sm-6">
                        <?php echo $form->hiddenField($modelPulang, 'pasienadmisi_id', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true)); ?>
                        <?php echo $form->hiddenField($modelPulang, 'pendaftaran_id', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true)); ?>
                        <?php echo $form->hiddenField($modelPulang, 'pasien_id', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true)); ?>
                        <div class="control-group">
                            <?php
                            echo $form->labelEx($modelPulang, 'tglpasienpulang', array(
                                'class' => 'control-label',
                                'label' => ($is_meninggal ? "Tanggal Pasien ke Pemulasaran Jenazah" : "Tanggal Pasien Pulang"),
                            ))
                            ?>
                            <div class="controls">
                                <?php
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $modelPulang,
                                    'attribute' => 'tglpasienpulang',
                                    'mode' => 'datetime',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                        'maxDate' => 'd',
                                    ),
                                    'htmlOptions' => array('readonly' => true, 'class' => 'span3 dtPicker3'),
                                ));
                                ?>
                                <?php echo $form->error($modelPulang, 'tglpasienpulang'); ?>
                            </div>
                        </div>
                        <div class="control-group " <?php echo $is_meninggal ? "hidden" : "" ?>>
                            <?php echo $form->labelEx($modelPulang, 'carakeluar_id', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                if ((isset($_GET['melarikandiri']) && $_GET['melarikandiri'] == 1) || (isset($_GET['meninggal']) && $_GET['meninggal'] == 1)) {
                                    echo $form->hiddenField($modelPulang, 'carakeluar_id');
                                    echo $form->dropDownList($modelPulang, 'carakeluar_id', CHtml::listData($modelPulang->getCarakeluarItems(), 'carakeluar_id', 'carakeluar_nama'), array(
                                        'class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'onclick' => 'carakeluar(this.value);', 'disabled' => true,
                                        'ajax' => array(
                                            'type' => 'POST',
                                            'url' => $this->createUrl('SetDropDownKondisiKeluar', array('encode' => false, 'model_nama' => get_class($modelPulang))),
                                            'update' => "#" . CHtml::activeId($modelPulang, 'kondisikeluar_id'),
                                        ),
                                    ));
                                } else {
                                    echo $form->dropDownList($modelPulang, 'carakeluar_id', CHtml::listData($modelPulang->getCarakeluarItems(), 'carakeluar_id', 'carakeluar_nama'), array(
                                        'class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'onclick' => 'carakeluar(this.value);',
                                        'ajax' => array(
                                            'type' => 'POST',
                                            'url' => $this->createUrl('SetDropDownKondisiKeluar', array('encode' => false, 'model_nama' => get_class($modelPulang))),
                                            'update' => "#" . CHtml::activeId($modelPulang, 'kondisikeluar_id'),
                                        ),
                                    ));
                                }
                                ?>
                                <?php echo $form->error($modelPulang, 'carakeluar_id'); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label((($is_meninggal ? "Kondisi Meninggal" : "Kondisi Pulang")) . ' <span class="required">*</span>', 'RIPasienPulangT_kondisikeluar_id', array('class' => 'control-label required')) ?>
                            <?php //echo $form->labelEx($modelPulang,'kondisikeluar_id', array('class'=>'control-label'))   
                            ?>
                            <div class="controls">
                                <?php echo $form->dropDownList($modelPulang, 'kondisikeluar_id', CHtml::listData($modelPulang->getKondisikeluarItems($modelPulang->carakeluar_id), 'kondisikeluar_id', 'kondisikeluar_nama'), array('class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'onclick' => 'pasienmeninggal(this.value);'));
                                ?>
                                <?php echo $form->error($modelPulang, 'kondisikeluar_id'); ?>
                            </div>
                        </div>
                        <div <?php echo $is_meninggal ? "hidden" : "" ?>>
                            <?php echo $form->textFieldRow($modelPulang, 'penerimapasien', array('placeholder' => 'Penerima Pasien', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                            <div class="control-group">
                                <?php echo CHtml::label('Tgl. Masuk Kamar', 'tglmasukkamar', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php echo $form->textField($modMasukKamar, 'tglmasukkamar', array('class' => 'span3', 'readonly' => true)) ?>
                                    <?php
                                    echo $form->hiddenField($modMasukKamar, 'masukkamar_id', array(
                                        'onkeypress' => "return $(this).focusNextInputField(event)",
                                        'class' => 'span2', 'readonly' => TRUE
                                    ));
                                    ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php //echo $form->labelEx($modMasukKamar,'tglkeluarkamar', array('class'=>'control-label'))  
                                ?>
                                <?php echo CHtml::label('Tgl. Pulang Kamar', 'tglkeluarkamar', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php
                                    $this->widget('MyDateTimePicker', array(
                                        'model' => $modMasukKamar,
                                        'attribute' => 'tglkeluarkamar',
                                        'mode' => 'datetime',
                                        'options' => array(
                                            'dateFormat' => Params::DATE_FORMAT,
                                        ),
                                        'htmlOptions' => array(
                                            'readonly' => true,
                                            'class' => 'span3 dtPicker3',
                                            'onkeypress' => "return $(this).focusNextInputField(event);",
                                        ),
                                    ));
                                    ?>
                                    <?php echo $form->error($modMasukKamar, 'tglkeluarkamar'); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php //echo $form->labelEx($modMasukKamar,'jamkeluarkamar', array('class'=>'control-label'));  
                                ?>
                                <?php echo CHtml::label('Jam Pulang Kamar', 'jamkeluarkamar', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php
                                    $this->widget('MyDateTimePicker', array(
                                        'model' => $modMasukKamar,
                                        'attribute' => 'jamkeluarkamar',
                                        'mode' => 'time',
                                        'options' => array(
                                            'dateFormat' => Params::DATE_FORMAT,
                                        ),
                                        'htmlOptions' => array(
                                            'readonly' => true,
                                            'class' => 'span3 dtPicker3',
                                            'onkeypress' => "return $(this).focusNextInputField(event);",
                                        ),
                                    ));
                                    ?>
                                    <?php echo $form->error($modMasukKamar, 'jamkeluarkamar'); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo $form->labelEx($modMasukKamar, 'lamadirawat_kamar', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php echo $form->textField($modMasukKamar, 'lamadirawat_kamar', array('class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> Hari
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo $form->labelEx($modelPulang, 'hariperawatan', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php echo $form->textField($modelPulang, 'hariperawatan', array('class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> Hari
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo $form->labelEx($modelPulang, 'keterangankeluar', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php echo $form->textArea($modelPulang, 'keterangankeluar', array('placeholder' => 'Keterangan Pasien Pulang', 'class' => 'span3', 'cols' => 50, 'rows' => 3)); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    $is_hidden = "";
                    if (isset($_GET['melarikandiri']) && $_GET['melarikandiri'] == 1) {
                        $is_hidden = "hidden";
                    }
                    ?>
                    <div class="col-sm-6" <?php echo $is_hidden; ?>>
                        <div class="control-group">
                            <!--fieldset class="box"-->
                            <h6 class="rim" <?php echo $is_meninggal ? "hidden" : "" ?>>
                                <?php echo CHtml::checkBox('isDead', $modelPulang->isDead, array('onkeypress' => "return $(this).focusNextInputField(event)")) ?>
                                <label for="isDead">Pasien Meninggal</label>
                            </h6>
                            <div class="control-group">
                                <?php echo $form->labelEx($modelPulang, 'tgl_meninggal', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php
                                    $this->widget('MyDateTimePicker', array(
                                        'model' => $modelPulang,
                                        'attribute' => 'tgl_meninggal',
                                        'mode' => 'datetime',
                                        'options' => array(
                                            'dateFormat' => Params::DATE_FORMAT,
                                            'maxDate' => 'd',
                                            // 'maxTime' => '11:00',
                                            // 'hourMax' => date('H'),
                                            // 'minuteMax' => date('i'),
                                            // 'secondMax' => date('s'),
                                        ),
                                        'htmlOptions' => array('readonly' => true, 'class' => 'span3 dtPicker3', 'disabled' => true),
                                    ));
                                    ?>
                                </div>
                            </div>
                            <!--</fieldset>-->
                            <!--fieldset class="box"-->
                            <!--</fieldset>-->
                        </div>
                        <div class="panel panel-success boxkirimdokumen" hidden>
                            <div class="panel-heading">
                                <div class="panel-title">
                                    Form Kirim Dokumen Rekam Medik
                                </div>
                            </div>
                            <div class="panel-body">
                                <?php //echo CHtml::hiddenField('statusdokrm', $modUbahStatus->statusdokrm); 
                                ?>
                                <?php //echo $this->renderPartial('_formStatusDokPP', array('form' => $form, 'modUbahStatus' => $modUbahStatus), true); 
                                ?>
                            </div>
                        </div>
                        <?php
                        // if (!$is_meninggal) {
                        //     echo $this->renderPartial('_formRencanaKontrol', array('form' => $form, 'model' => $modRenKontrol), true);
                        // }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    Tabel Diagnosa Kematian (ICD 10)
                </div>
            </div>
            <div class="panel-body">
                <?php 
                    echo CHtml::htmlButton(
                        '<i class="icon-plus icon-white"></i> Tambah Diagnosa ICD 10',
                        array(
                            'onclick' => '$("#dialogDiagnosa").dialog("open")',
                            'class' => 'btn btn-primary',
                            'rel' => "tooltip",
                            'title' => "Klik untuk menambahkan Diagnosa 10 Pasien",
                        )
                    );
                ?>

                <div class="div-table-diagnosameninggal table-responsive">
                    <table class="table table-striped table-condensed" id="table-diagnosameninggal">
                        <thead>
                            <th>No</th>
                            <th>Kode Diagnosa</th>
                            <th>Nama Diagnosa</th>
                            <th>Nama Lain</th>
                            <th>Hapus</th>
                        </thead>
                        <tbody>
                            <?php 
                                if(!empty($modRiwayatDiagnosaMortalitas)) {
                                    foreach ($modRiwayatDiagnosaMortalitas as $i => $data) {
                                        $data->diagnosa_kode = $data->diagnosa->diagnosa_kode;
                                        $data->diagnosa_namalainnya = $data->diagnosa->diagnosa_namalainnya;
                                        $this->renderPartial('diagnosaMeninggal/_rowDiagnosaAdaData', [
                                            'jumlahtr' => $i, 
                                            'modMortalitas' => $data 
                                        ]);
                                    }
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
                
            </div>
        </div>
        <br>
        <div class="col-sm-12">
            <div class="control-group">
            <label for="penyebabkematian" class="control-label">Penyebab Kematian </label>
            <div class="controls">
                <?php echo $form->textArea($modKematian, 'penyebabkematian', array('placeholder' => 'Penyebab Kematian', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        </div>
        <div class="panel panel-success" hidden>
            <div class="panel-heading">
                <div class="panel-title">
                    Surat Kematian Pasien
                </div>
            </div>
            <div class="panel-body">
                <?php 
                    $this->renderPartial('suratkematian/_formSuratKematian', ['form' => $form, 'modKematian' => $modKematian])
                ?>
            </div>
        </div>
        <div class="form-actions">
            <?php
            $disableSave = false;
            $disableSave = (!empty($_GET['id'])) ? true : (($tersimpan == 'Ya') ? true : false);
            ?>
            <?php $disablePrint = ($disableSave) ? false : true; ?>
            <?php
            echo CHtml::htmlButton($modelPulang->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onclick' => 'cekValidasi(this)', 'disabled' => $disableSave));
            ?>
            <?php
            echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl($this->module->id . '/TindakLanjutDrTransaksi'), array(
                'title' => 'Ulang',
                'class' => 'btn btn-default',
                'onclick' => 'window.parent.myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = "' . $this->createUrl('TindakLanjutDrTransaksi') . '";} ); return false;'
            ));
            ?>
             <?php 
                echo CHtml::Link("Print Surat Kematian Pasien", "javascript:printSuratKematian(" . $modPendaftaran->pendaftaran_id . ", " . $modKematian->suratketerangan_id .")",
                array("class"=>"btn btn-success", 
                        "rel"=>"tooltip",
                        "title"=>"Klik untuk membuat Surat Keterangan Kematian",
                        'disabled' => $disablePrint
                ));

                echo CHtml::htmlButton(
                    
                    Yii::t('mds', '{icon} Print Resume', array('{icon}' => '<i class="entypo-print"></i>')),
                    array('class' => 'btn btn-success', 'type' => 'button', 'onclick' => 'printResume(' .$modPendaftaran->pendaftaran_id .')')
                );
            ?>
            <?php
            $content = $this->renderPartial('../tips/transaksi', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
    </div>
</div>
<?php 
// dialog dignosa
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogDiagnosa',
    'options' => array(
        'title' => 'Daftar Diagnosa',
        'autoOpen' => false,        
        'modal' => true,
        'width' => 600,
        'height' => 500,
        'resizable' => false,
    ),
));

$this->renderPartial($this->path_view . 'diagnosaMeninggal/_dignosa');

$this->endWidget();
?>
<script type="text/javascript">
    function printSuratKematian(pendaftaran_id, suratketerangan_id) {
        window.open('<?php echo $this->createUrl('/pemulasaranJenazah/suratKeterangan/PrintSuratMeninggal') ?>' + '&pendaftaran_id=' + pendaftaran_id + '&suratketerangan_id=' + suratketerangan_id, 'printwin', 'left=100,top=100,width=700,height=450,scrollbars=1');
    }

    function printResume(pendaftaran_id) {
        window.open('<?php echo $this->createUrl('/rekamMedis/resumeMedis/print'); ?>&pendaftaran_id=' + pendaftaran_id, 'printwin', 'left=100,top=100,width=480,height=640');
    }

    
    function hapusDiagnosa(obj, mortalitas_id) {
        if(mortalitas_id != '') {
            $.post('<?= $this->createUrl('/pendaftaranPenjadwalan/verifikasiDiagnosa/hapusDiagnosaKematian') ?>', {
                mortalitas_id:mortalitas_id
            }, function(data){
                if(data.status == 1) {
                    $(obj).parents('tr').detach();
                    
                }
            }, 'json');
        } else {
            $(obj).parents('tr').detach();
        }
    }

    $(function(){
        jQuery('.pilihanSearch').multiselect({
                includeSelectAllOption: true,
                buttonClass: "form-control",
                maxHeight: 300,
                buttonWidth: '182px',
                enableCaseInsensitiveFiltering: true
        }).hide();
    });

    function addRowDiagnosa(diagnosa_id, diagnosa_kode, diagnosa_nama, diagnosa_namalainnya) {
        var jumlahtr = $('#table-diagnosameninggal tbody tr').length;
        $.post('<?= $this->createUrl('addRowDiagnosa') ?>', {
            jumlahtr:jumlahtr,
            diagnosa_id:diagnosa_id,
            diagnosa_kode:diagnosa_kode,
            diagnosa_nama:diagnosa_nama,
            diagnosa_namalainnya:diagnosa_namalainnya
        }, function(data){
            var sudahadadiagnosa = false;
            $("#table-diagnosameninggal tbody tr .row_diagnosa_x_id").each(function() {
                if($(this).val() == diagnosa_id) {
                    sudahadadiagnosa = true;
                }
            });
            if(sudahadadiagnosa) {
                window.parent.myAlert('Diagnosis yang Anda input telah terdaftar, silakan cek kembali!');
                return false;
            }

            $('#table-diagnosameninggal tbody').append(data.html);
            updateSorotX();
        }, 'json');
    }

    function updateSorotX() {
        $("#PPdiagnosa-m-grid table tbody tr td").removeClass('sorot');
        $("#table-diagnosameninggal tbody tr .row_diagnosa_x_id").each(function() {
            $("#PPdiagnosa-m-grid table tbody #pilih_dialog_" + $(this).val()).parents("tr").find("td").addClass("sorot");
        });
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
                    isinotifikasi: 'Pasien <?php echo $modelPulang->pasien->nama_pasien; ?> tidak memiliki nomor mobile'
                }; // 16 
                // simpanNotifikasi(params);
        <?php
            }
        }
        ?>
        <?php
        if (isset($_GET['smspasien'])) {
            if ($_GET['smspasien'] == 0) {
        ?>
                var params = [];
                params = {
                    instalasi_id: <?php echo Yii::app()->user->getState("instalasi_id"); ?>,
                    modul_id: <?php echo Yii::app()->session['modul_id']; ?>,
                    judulnotifikasi: 'GAGAL KIRIM SMS PASIEN',
                    isinotifikasi: 'Pasien <?php echo $modelPulang->pasien->nama_pasien; ?> tidak memiliki nomor mobile'
                }; // 16 
                // simpanNotifikasi(params);
        <?php
            }
        }
        ?>
        <?php
        if (isset($modelPulang->pasienpulang_id)) {
        ?>
            var params = [];
            params = {
                instalasi_id: <?php echo Yii::app()->user->getState("instalasi_id"); ?>,
                modul_id: <?php echo Yii::app()->session['modul_id']; ?>,
                judulnotifikasi: 'Pasien Pulang',
                isinotifikasi: '<?php echo $modelPulang->pasien->nama_pasien; ?> dengan <?php echo $modelPulang->pasien->no_rekam_medik; ?> telah pulang pada <?php echo $modelPulang->tglpasienpulang ?> dari <?php echo $modelPulang->ruangan_nama ?>'
            }; // 16 
            // simpanNotifikasi(params);
        <?php
        }
        ?>
    });
</script>
<?php $this->endWidget(); ?>
<?php
if ($tersimpan == 'Ya') {
?>
    <script>
        //parent.location.reload(); RND-6894
    </script>
<?php
}
?>
<script type="text/javascript">
    function hitungHariRawat(obj) { //RSSP-934
        var tgl_pulang = $(obj).val();
        var tgladmisi = '<?php echo $modPasienPIV->tgladmisi; ?>';
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/' . 'HitungHariRawatPulang'); ?>',
            data: {
                tgl_pulang: tgl_pulang,
                tgladmisi: tgladmisi
            },
            dataType: "json",
            success: function(data) {
                $('#PIMasukKamarT_lamadirawat_kamar').val(data.lamadirawat_kamar);
                $('#PIPasienPulangT_hariperawatan').val(data.hariperawatan);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    function carakeluar(value) {
        if (value == "<?php echo Params::CARAKELUAR_ID_DIRUJUK ?>") {
            $('#pakeRujukan').attr('checked', true);
            $('#divRujukan input').removeAttr('disabled');
            $('#divRujukan select').removeAttr('disabled');
            $('#divRujukan').slideToggle(500);
        } else if (value == "<?php echo Params::CARAKELUAR_ID_MENINGGAL ?>") {
            var date = new Date();
            $('#pakeRujukan').removeAttr('checked');
            $('#divRujukan input').attr('disabled', 'true');
            $('#divRujukan select').attr('disabled', 'true');
            $('#divRujukan input').attr('value', '');
            $('#divRujukan select').attr('value', '');
            $('#divRujukan').hide(500);
            $('#PIPasienPulangT_tgl_meninggal').val('<?php
                                                        echo Yii::app()->dateFormatter->formatDateTime(
                                                            CDateTimeParser::parse(date('Y-m-d H:i:s'), 'yyyy-MM-dd HH:ii:ss')
                                                        );
                                                        ?>');
        } else {
            $('#pakeRujukan').removeAttr('checked');
            $('#divRujukan input').attr('disabled', 'true');
            $('#divRujukan select').attr('disabled', 'true');
            $('#divRujukan input').attr('value', '');
            $('#divRujukan select').attr('value', '');
            $('#divRujukan').hide(500);
        }
    }

    function pasienmeninggal(value) {
        if (value == "<?php echo Params::KONDISIKELUAR_ID_MENINGGAL_1 ?>" || value == "<?php echo Params::KONDISIKELUAR_ID_MENINGGAL_2 ?>") {
            $('#isDead').attr('checked', true);
            $('#PIPasienPulangT_tgl_meninggal').removeAttr('disabled');
        } else {
            $('#isDead').removeAttr('checked');
            $('#PIPasienPulangT_tgl_meninggal').attr('disabled', 'true');
        }
    }
    $('#isDead').change(function() {
        if ($(this).is(':checked')) {
            $('#PIPasienPulangT_tgl_meninggal').removeAttr('disabled');
            $('#PIPasienPulangT_kondisipulang_id').val('<?php echo Params::KONDISIPULANG_MENINGGAL_1 ?>');
            $('#PIPasienPulangT_tgl_meninggal').val('<?php
                                                        echo Yii::app()->dateFormatter->formatDateTime(
                                                            CDateTimeParser::parse(date('Y-m-d H:i:s'), 'yyyy-MM-dd HH:ii:ss')
                                                        );
                                                        ?>');
        } else {
            $('#PIPasienPulangT_tgl_meninggal').attr('disabled', 'true');
            $('#PIPasienPulangT_kondisipulang_id').val('');
            $('#PIPasienPulangT_tgl_meninggal').val('');
        }
    });

    function konfirmasi() {
        window.parent.myConfirm("<?php echo Yii::t('mds', 'Do You want to cancel?') ?>", "Perhatian!", function(r) {
            if (r) {
                $('#dialogPasienPulang').dialog('close');
            } else {
                $('#PIPasienPulangT_carakeluar_id').focus();
                return false;
            }
        });
    }
    $('#isKontrol').change(function() {
        if ($(this).is(':checked')) {
            $('#PIPendaftaranT_tglrenkontrol, #PIPendaftaranT_ruangankontrol_id').removeAttr('disabled');
            $("#PIPendaftaranT_ruangankontrol_id").addClass('required');
            $('#PIPendaftaranT_tglrenkontrol').val();
        } else {
            $('#PIPendaftaranT_tglrenkontrol, #PIPendaftaranT_ruangankontrol_id').attr('disabled', 'true');
            $('#PIPendaftaranT_tglrenkontrol').val('');
            $("#PIPendaftaranT_ruangankontrol_id").val('');
            $("#PIPendaftaranT_ruangankontrol_id").removeClass('required');
        }
    });

    function cekValidasi(obj) {
        $('.form-actions').addClass('animation-loading');
        var kontrol = $('#isKontrol');
        var rujukan = $('#pakeRujukan');
        var tglren = $("#PIPendaftaranT_tglrenkontrol");
        var ruren = $("#PIPendaftaranT_ruangankontrol_id");
        var carakeluar = $("#PIPasienPulangT_carakeluar_id");
        var kondisikeluar = $("#PIPasienPulangT_kondisikeluar_id");
        var insdok = $("#PengirimanrmT_instalasi_id").val();
        var rudok = $("#PengirimanrmT_ruangan_id").val();
        var adadok = $("#formKirimDok").val();
        if (kontrol.is(':checked')) {
            if (ruren.val() == '') {
                ruren.attr('style', 'border:red 1px solid');
                myAlert("Maaf, polik kontrol belum diisi", 'Perhatian!');
                return false;
            } else {
                ruren.attr('style', '');
                //$(obj).submit();
            }
            if (tglren.val() == '') {
                tglren.attr('style', 'border:red 1px solid');
                myAlert("Maaf, tanggal rencana kontrol belum diisi", 'Perhatian!');
                return false;
            } else {
                tglren.attr('style', '');
                //$(obj).submit();
            }
        } else {
            //$(obj).submit();
        }
        var jumlahtr = $('#table-diagnosameninggal tbody tr').length;
        if(jumlahtr < 1 && carakeluar.val() == 4) {
            myAlert('Diagnosa kematian wajib ditambahkan!');
            return false;
        }
        if (carakeluar.val() == '') {
            carakeluar.attr('style', 'border:red 1px solid');
        } else {
            carakeluar.attr('style', '');
        }
        if (kondisikeluar.val() == '') {
            kondisikeluar.attr('style', 'border:red 1px solid');
        } else {
            kondisikeluar.attr('style', '');
        }
        if (adadok == 'ada') {
            if (insdok === "") {
                myAlert("Instalasi Tujuan Dokumen Rekam Medis harus diisi ");
                return false;
            }
            if (rudok === "") {
                myAlert("Ruangan Tujuan Dokumen Rekam Medis harus diisi ");
                return false;
            }
        }
        if (carakeluar.val() == '' || kondisikeluar.val() == '') {
            myAlert("Maaf, Cara Keluar dan Kondisi Keluar wajib diisi", 'Perhatian!')
            return false;
        } else {
            if (rujukan.is(':checked')) {
                if (requiredCheck($("#pasienpulang-t-form"))) {
                    $("#pasienpulang-t-form").submit();
                } else {
                    return false;
                }
            } else {
                if(requiredCheck($("#pasienpulang-t-form"))) {
                    $("#pasienpulang-t-form").submit();
                } else {
                    return false;
                }
            }
            //$(obj).submit();
        }
    }
    /**
     * untuk print pasien pulang
     */
    function print(caraPrint) {
        var pasienpulang_id = '<?php echo isset($modelPulang->pasienpulang_id) ? $modelPulang->pasienpulang_id : null ?>';
        window.open('<?php echo $this->createUrl('printPasienPulang'); ?>&pasienpulang_id=' + pasienpulang_id + '&caraPrint=' + caraPrint, 'printwin', 'left=100,top=100,width=1000,height=640');
    }

    function printKontrol(caraPrint) {
        var pasienpulang_id = '<?php echo isset($modelPulang->pasienpulang_id) ? $modelPulang->pasienpulang_id : null ?>';
        window.open('<?php echo $this->createUrl('printPasienKontrol'); ?>&pasienpulang_id=' + pasienpulang_id + '&caraPrint=' + caraPrint, 'printwin', 'left=100,top=100,width=1000,height=640');
    }
    /**
     * 
     * @param {type} obj
     * @returns {menampilkan field tanggal kontrol}
     */
    function openTglKontrol(obj) {
        var ruangan = $(obj).val();
        if (ruangan == '') {
            $("#tanggal_kontrol").attr('style', 'display:none;');
            $("#<?php echo CHtml::activeId($modPendaftaran, 'tglrenkontrol') ?>").val('');
        } else {
            $("#tanggal_kontrol").attr('style', 'display:block;');
            $("#<?php echo CHtml::activeId($modPendaftaran, 'tglrenkontrol') ?>").val('');
        }
    }
    $('#isDead').change(function() {
        if ($(this).is(':checked')) {
            $('#PIPasienPulangT_carakeluar_id').val('<?php echo Params::CARAKELUAR_ID_MENINGGAL ?>');
        } else {
            $('#PIPasienPulangT_carakeluar_id').val('');
        }
    });
</script>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDaftarPasien',
    'options' => array(
        'title' => 'Daftar Pasien',
        'autoOpen' => false,
        'resizable' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
    ),
));
$modPasienDialog = new PIInfopasienmasukkamarV('searchPIDialog');
$modPasienDialog->unsetAttributes();
$modPasienDialog->tgl_pendaftaran = date('m/d/Y') . ' - ' . date('m/d/Y');
if (isset($_GET['PIInfopasienmasukkamarV'])) {
    $modPasienDialog->attributes = $_GET['PIInfopasienmasukkamarV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'daftarpasien-v-grid',
    'dataProvider' => $modPasienDialog->searchPIDialog(),
    'template' => "{summaryNonPage}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'filter' => $modPasienDialog,
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
			"id" => "selectPendaftaran",
			"onClick" => "
				$(\"#dialogDaftarPasien\").dialog(\"close\");
				$(\"#tgl_pendaftaran\").val(\"$data->tgl_pendaftaran\");
				$(\"#PIInfopasienmasukkamarV_tgl_pendaftaran\").val(\"$data->tgl_pendaftaran\");
				$(\"#PIInfopasienmasukkamarV_no_pendaftaran\").val(\"$data->no_pendaftaran\");
				$(\"#PIInfopasienmasukkamarV_umur\").val(\"$data->umur\");
				$(\"#PIInfopasienmasukkamarV_pasienadmisi_id\").val(\"$data->tgladmisi \");
				$(\"#PIInfopasienmasukkamarV_tglmasukkamar\").val(\"$data->tglmasukkamar \");
				$(\"#PIInfopasienmasukkamarV_jeniskasuspenyakit_nama\").val(\"$data->jeniskasuspenyakit_nama\");
				$(\"#PIInfopasienmasukkamarV_jeniskelamin\").val(\"$data->jeniskelamin\");
				$(\"#PIInfopasienmasukkamarV_no_rekam_medik\").val(\"$data->no_rekam_medik\");
				$(\"#PIInfopasienmasukkamarV_nama_pasien\").val(\"$data->nama_pasien\"); 
				$(\"#PIInfopasienmasukkamarV_nama_bin\").val(\"$data->nama_bin\");
				$(\"#PIPasienPulangT_tglpindahkamar\").val(\"$data->tglmasukkamar\");
				$(\"#PIMasukKamarT_masukkamar_id\").val(\"$data->masukkamar_id \");
				$(\"#PIPasienPulangT_pendaftaran_id\").val(\"$data->pendaftaran_id \");
				$(\"#PIPasienPulangT_pasien_id\").val(\"$data->pasien_id \");
				$(\"#PIPasienPulangT_pasienadmisi_id\").val(\"$data->pasienadmisi_id \");
				$(\"#PIPasienPulangT_ruangan_id\").val(\"$data->ruangan_nama \");
				$(\"#PIMasukKamarT_pasienadmisi_id\").val(\"$data->tgladmisi \");
				$(\"#PIMasukKamarT_carabayar_id\").val(\"$data->carabayar_nama \");
				$(\"#PIMasukKamarT_penjamin_id\").val(\"$data->penjamin_nama \");
				$(\"#PIMasukKamarT_kelaspelayanan_id\").val(\"$data->kelaspelayanan_nama \");
				$(\"#PIMasukKamarT_pegawai_id\").val(\"$data->nama_pegawai \");
				$(\"#PIMasukKamarT_kelaspelayanan_id\").val(\"$data->kelaspelayanan_nama \");
			"))',
        ),
        'no_rekam_medik',
        array(
            'name' => 'tgl_pendaftaran',
            'type' => 'raw',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)',
            'filter' =>
            CHtml::activeTextField($modPasienDialog, 'tgl_pendaftaran', array('class' => 'span3', 'readonly' => true)),
            /*$this->widget('MyDateTimePicker', array(
				'model' => $modPasienDialog,
				'attribute' => 'tgl_pendaftaran',
				'mode' => 'date', //date / datetime
				'gridFilter' => true,
				'options' => array(
				'dateFormat' => Params::DATE_FORMAT,
				'maxDate'=>'d',
				),
				'htmlOptions' => array('readonly' => true, 'class' => "span2",
				'onkeypress' => "return $(this).focusNextInputField(event)"),
				),true),*/
        ),
        'no_pendaftaran',
        'nama_pasien',
        array(
            'header' => 'Nama Alias',
            'type' => 'raw',
            'name' => 'nama_bin',
            'value' => '"$data->nama_bin"',
        ),
        array(
            'header' => 'Penjamin',
            'type' => 'raw',
            'name' => 'penjamin_nama',
            'value' => '$data->penjamin_nama',
        ),
        array(
            'header' => 'Jenis Penjamin',
            'type' => 'raw',
            'name' => 'carabayar_nama',
            'value' => '$data->carabayar_nama',
        ),
        array(
            'header' => 'Nama Dokter',
            'type' => 'raw',
            'name' => 'nama_pegawai',
            'value' => '"$data->nama_pegawai"',
        ),
        // 'ruangan_nama',
        'jeniskasuspenyakit_nama',
        // 'statusperiksa',                
    ),
    'afterAjaxUpdate' => 'function(id, data){
			jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
//			jQuery("#' . CHtml::activeId($modPasienDialog, 'tgl_pendaftaran') . '").datepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional["id"], {"dateFormat":"dd M yy","maxDate":"d","timeText":"Waktu","hourText":"Jam","minuteText":"Menit","secondText":"Detik","showSecond":true,"timeOnlyTitle":"Pilih Waktu","timeFormat":"hh:mm:ss","changeYear":true,"changeMonth":true,"showAnim":"fold","yearRange":"-80y:+20y"}));
//			jQuery("#' . CHtml::activeId($modPasienDialog, 'tgl_pendaftaran') . '_date").on("click", function(){jQuery("#' . CHtml::activeId($modPasienDialog, 'tgl_pendaftaran') . '").datepicker("show");});
            jQuery("#' . CHtml::activeId($modPasienDialog, 'tgl_pendaftaran') . '").daterangepicker({
                "maxDate": "' . date('m/d/Y') . '",
                "showDropdowns": true,
            });
		}',
));
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
<script>
    $(document).ready(function() {
        $('input[name="PIInfopasienmasukkamarV[tgl_pendaftaran]"]').daterangepicker({
            "maxDate": "<?php echo date('m/d/Y') ?>",
            "showDropdowns": true,
        });
    });
</script>