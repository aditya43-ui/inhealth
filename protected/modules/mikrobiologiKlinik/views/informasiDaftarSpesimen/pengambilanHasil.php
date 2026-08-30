<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Pengambilan Hasil</div>
    </div>
    <div class="panel-body">
        <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.tiler.js'); //UNTUK PEMERIKSAAN LAB ?>
        <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'pengambilansample-t-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array(
                'onKeyPress' => 'return disableKeyPress(event);',
                'onkeyup' => (!isset($_GET['sukses'])) ? 'cekDisabled(this);' : '',
                'onsubmit' => 'return requiredCheck(this);',
                'onclick' => (!isset($_GET['sukses'])) ? 'cekDisabled(this);' : ''),
        ));
        ?>
        <?php
        if (isset($_GET['sukses'])) {
            Yii::app()->user->setFlash('success', "Data pasien berhasil disimpan !");
        }
        ?>
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

        <div class="col-sm-12">
            <div class = "control-group">
                <?php echo CHtml::label("Pengambil", '', array('class' => 'control-label')) ?>
                <div class = "controls">
                    <?php echo $form->checkBox($modPengambilan, 'pasien', array('onClick' => 'cekPasien(this)', 'rel' => 'tooltip', 'title' => 'Klik jika yang mengambil adalah pasien sendiri', 'class' => 'span1', 'maxlength' => 100)); ?>
                    <?php echo $form->hiddenField($modPengambilan, 'nama_pasien', array('value' => $modPasien->pasien_id)); ?>
                    <label> Pasien </label>
                </div>
            </div>
            <div class = "control-group">
                <?php echo CHtml::label("Tanggal Pengambilan <span class='required'>*</span>", '', array('class' => 'control-label')) ?>
                <div class = "controls">
                    <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $modPengambilan,
                        'attribute' => 'tgl_pengambilanhasil',
                        'mode' => 'datetime',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                        ),
                        'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3 span3 required', 'onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'width:180px;'
                        ),
                    ));
                    ?>
                </div>
            </div>
            <div class = "control-group">
                <?php echo CHtml::label("Nama Pengambil Hasil <span class='required'>*</span>", 'nomor_dokumen', array('class' => 'control-label')) ?>
                <div class = "controls">
                    <?php echo $form->textField($modPengambilan, 'nama_pengambilhasil', array('class' => 'span3 required', 'maxlength' => 100)); ?>
                </div>
            </div>
            <div class = "control-group" id='hubungan'>
                <?php echo CHtml::label("Hubungan Pengambil <span class='required'>*</span>", '', array('class' => 'control-label')) ?>
                <div class = "controls">
                    <?php echo $form->dropDownList($modPengambilan, 'hubungan_pengambilhasil', LookupM::getItems("hubungankeluarga"), array('onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --', 'class' => 'span3')); ?>
                </div>
            </div>
            <div class = "control-group">
                <?php echo CHtml::label("No. Identitas Pengambil", 'nomor_dokumen', array('class' => 'control-label')) ?>
                <div class = "controls">
                    <?php echo $form->textField($modPengambilan, 'noidentitas_pengambilhasil', array('class' => 'span3', 'maxlength' => 100)); ?>
                </div>
            </div>
            <div class = "control-group">
                <?php echo CHtml::label("Alamat Pengambil <span class='required'>*</span>", 'nomor_dokumen', array('class' => 'control-label')) ?>
                <div class = "controls">
                    <?php echo $form->textArea($modPengambilan, 'alamat_pengambilhasil', array('class' => 'span3 required', 'maxlength' => 100)); ?>
                </div>
            </div>
            <div class = "control-group">
                <?php echo CHtml::label("No. Telepon  Pengambil", 'nomor_dokumen', array('class' => 'control-label')) ?>
                <div class = "controls">
                    <?php echo $form->textField($modPengambilan, 'notelp_pengambilhasil', array('class' => 'span3 integer2', 'maxlength' => 100)); ?>
                </div>
            </div>
        </div>
    </div>
    <?php
    echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => (isset($_GET['sukses'])) ? 'btn btn-primary' : 'btn btn-primary submit', 'type' => 'submit', 'disabled' => (isset($_GET['sukses'])) ? true : false));
    ?>
    <?php
    echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), (!empty($spesimen_id)) ? $this->createUrl($this->id . '/PengambilanHasil', array('spesimen_id' => $spesimen_id, 'pasien_id' => $modPasien->pasien_id)) : $this->createUrl($this->id . '/index'), array('class' => 'btn btn-danger',
        'onclick' => 'return refreshForm(this);'));
    ?>

    <?php $this->endWidget(); ?>           
</div>
</div>
<script>
    function cekPasien(obj) {
        var pasien = $('#AmbilhasilSpesimenT_pasien');
        var pasien_id = $('#AmbilhasilSpesimenT_nama_pasien').val();
        if (pasien.is(" :checked")) {
            $.ajax({
                type: 'POST',
                data: {pasien_id: pasien_id},
                url: '<?php echo $this->createUrl('generatePasien'); ?>',
                dataType: "json",
                success: function (data) {
                    if (data.pesan != "") {
                        return false;
                    } else {
                        $("#<?php echo CHtml::activeId($modPengambilan, 'nama_pengambilhasil'); ?>").val(data.nama_pengambil);
                        $("#<?php echo CHtml::activeId($modPengambilan, 'noidentitas_pengambilhasil'); ?>").val(data.noidentitas_pengambil);
                        $("#<?php echo CHtml::activeId($modPengambilan, 'alamat_pengambilhasil'); ?>").val(data.alamat_pengambil);
                        $("#<?php echo CHtml::activeId($modPengambilan, 'notelp_pengambilhasil'); ?>").val(data.nomobile_pengambil);
                        $("#hubungan").hide();
                        $("#<?php echo CHtml::activeId($modPengambilan, 'hubungan_pengambilhasil') ?>").removeClass('required');
                        $("#<?php echo CHtml::activeId($modPengambilan, 'hubungan_pengambilhasil') ?>").val('');
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        } else {
            setKunjunganReset();
            $("#hubungan").show();
            $("#<?php echo CHtml::activeId($modPengambilan, 'hubungan_pengambilhasil') ?>").attr('class', 'required');
        }
    }

    /**
     * untuk mereset form kunjungan
     * @returns {undefined} */
    function setKunjunganReset() {
        $("#<?php echo CHtml::activeId($modPengambilan, 'nama_pengambilhasil'); ?>").val("");
        $("#<?php echo CHtml::activeId($modPengambilan, 'noidentitas_pengambilhasil'); ?>").val("");
        $("#<?php echo CHtml::activeId($modPengambilan, 'alamat_pengambilhasil'); ?>").val("");
        $("#<?php echo CHtml::activeId($modPengambilan, 'notelp_pengambilhasil'); ?>").val("");
    }

    $(document).ready(function () {
    <?php if (empty($modPengambilan->hubungan_pengambilhasil) && !empty($modPengambilan->nama_pengambilhasil)) { ?>
        $("#hubungan").hide();
        $("#AmbilhasilSpesimenT_pasien").attr('checked', true);
    <?php } else { ?>
        $("#hubungan").show();
        $("#<?php echo CHtml::activeId($modPengambilan, 'hubungan_pengambilhasil') ?>").attr('class', 'required');
    <?php }
    ?>
    });

</script>


