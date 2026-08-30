<style>
.judul-ab {
    font-weight: bold;
}

.inp-ab {
    margin-left: 20px;
}

.space-ab1 {
    margin-left: 20px;
    margin-right: 20px;
}

.space-ab2 {
    margin-left: 20px;
    margin-right: 20px;
}
</style>

<?php echo $form->errorSummary($cci); ?>


<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-book"></i> &nbsp;<b>Pemeriksaan Candida Colonization Index</b>
            <?php // echo $form->hiddenField($cci, 'pemeriksaanpewarnaan_id', array('class' => '', 'onkeypress' => "return $(this).focusNextInputField(event)", 'readonly' => true)); ?>
        </div>
    </div>
    <div class="panel-body" id="">
        <div class="row row-fluid">
            <div class="col-sm-6">
                <div class="control-group">
                    <label class="control-label">Dokter Lab 1 <span class="required">*</span></label>
                    <div class="controls">
                        <?php
                            echo $form->dropDownList($cci, 'pegawai_id', CHtml::listData(PegawairuanganV::model()->findAll(' ruangan_id = 1131 and kelompokpegawai_id = 1 '), 'pegawai_id', 'namaLengkap'), array(
                                'empty' => '-- Pilih --', 'class' => 'span4 required',
                            ));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Dokter Lab 2</label>
                    <div class="controls">
                        <?php
                            echo $form->dropDownList($cci, 'dpjp_id', CHtml::listData(PegawairuanganV::model()->findAll(' ruangan_id = 1131 and kelompokpegawai_id = 1 '), 'pegawai_id', 'namaLengkap'), array(
                                'empty' => '-- Pilih --', 'class' => 'span4',
                            ));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Analis</label>
                    <div class="controls">
                        <?php
                            echo $form->dropDownList($cci, 'perawat_id', CHtml::listData(PegawairuanganV::model()->findAll(' ruangan_id = 1131 and kelompokpegawai_id in (2, 20) '), 'pegawai_id', 'namaLengkap'), array(
                                'empty' => '-- Pilih --', 'class' => 'span4',
                            ));
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="control-group">
                    <label class="control-label">Tanggal Pemeriksaan <span class="required">*</span></label>
                    <div class="controls">
                        <?php
                    
                            $this->widget('MyDateTimePicker', array(
                                'model' => $cci,
                                'attribute' => 'tgl_pemeriksaan',
                                'mode' => 'datetime',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                ),
                                'htmlOptions' => array('class' => 'dtPicker3 span3 required', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                ),
                            ));

                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Jenis Pemeriksaan </label>
                    <div class="controls">
                        <?php echo $form->textField($cci, 'jenis_pemeriksaan', array('readonly' => true, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row row-fluid">
            <div class="col-sm-12">
                <div class="panel panel-gradient">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <b>Hasil Pemeriksaan</b>
                        </div>
                    </div>
                    <div class="panel-body">

                        <div class="row row-fluid">
                            <div class="col-sm-6">
                                <div class="" style="margin-left: 20px;">
                                    <div class="control-group">
                                        <label class="control-label">Sputum </label>
                                        <div class="controls">
                                            <?php echo $form->dropDownList($cci,'sputum', LookupM::getItems('mikro_sputum'),array('class'=>'span3', 'empty'=>'-- Pilih --')); ?>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">SWAB Tenggorok </label>
                                        <div class="controls">
                                            <?php echo $form->dropDownList($cci,'swab_tenggorok', LookupM::getItems('mikro_swab_tenggorok'),array('class'=>'span3', 'empty'=>'-- Pilih --')); ?>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Urine </label>
                                        <div class="controls">
                                            <?php echo $form->dropDownList($cci,'urine', LookupM::getItems('mikro_urine'),array('class'=>'span3', 'empty'=>'-- Pilih --')); ?>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Swab Perineum/Perianal </label>
                                        <div class="controls">
                                            <?php echo $form->dropDownList($cci,'swab_perineum', LookupM::getItems('mikro_swab_perineum'),array('class'=>'span3', 'empty'=>'-- Pilih --')); ?>
                                        </div>
                                    </div>
                                    <div class="control-group ">
                                        <label class="control-label">&nbsp;Lain-lain</label>

                                        <div class="controls">
                                            <?php echo $form->textArea($cci, 'cci_lain', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 500)); ?>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Interprestasi </label>
                                        <div class="controls">
                                            <?php echo $form->dropDownList($cci,'interprestasi', LookupM::getItems('mikro_interprestasi_cci'),array('class'=>'span3', 'empty'=>'-- Pilih --')); ?>
                                        </div>
                                    </div>
                                   
                                </div>

                            </div>
                            <div class="col-sm-6">
                                <div class="panel panel-gradient" style="width: 104%;">
                                    <div class="panel-heading">
                                        <div class="panel-title">
                                            <b>Saran / Expertise</b>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="control-group">
                                            <label class="control-label">Saran / Expertise</label>
                                            <div class="controls">
                                                <?php $this->widget('ext.redactorjs.Redactor', array('model' => $cci, 'attribute' => 'saran', 'toolbar' => 'mini', 'height' => '200px')) ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row-fluid">
    <div class="form-actions">
        <?php

            if (!isset($_GET['sukses'])) {
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit'));
                echo "&nbsp;";
            } else {
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'onclick' => 'formSubmit(this,event);', 'onkeypress' => 'formSubmit(this,event);', 'disabled' => true));
                echo "&nbsp;";
            }       
                
            if (!isset($_GET['pemeriksaancci_id'])) {
                echo CHtml::link(Yii::t('mds', '{icon} Print CCI', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('disabled' => true, 'class' => 'btn btn-info', 'onclick' => "return false"));
            } else {
                echo CHtml::link(Yii::t('mds', '{icon} Print CCI', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printCci();return false"));
            }
            
                $content = $this->renderPartial('akuntansi.views.tips.tipsaddedit3a', array(), true);
                $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                
    
?>
    </div>
</div>

<script>

function setBiakan(ket) {

    var isi = $('<?= CHtml::activeId($cci, 'biakan_kultur_ket') ?>').val();

    if (isi !== "") {
        $('<?= CHtml::activeId($cci, 'biakan_kultur_ket') ?>').val(ket);
    } else {
        var isi_arr = isi.split(', ');
        isi_arr.push(ket);
        var isi_join = isi_arr.join(', ');
    }
    $('<?= CHtml::activeId($cci, 'biakan_kultur_ket') ?>').val(ket);

    $('#dialogBiakan').dialog('close');
}

function printCci() {
    window.open(
        '<?php echo $this->createUrl('printCci', array('pemeriksaancci_id' => $cci->pemeriksaancci_id)); ?>',
        'printwin', 'left=100,top=100,width=720,height=960');
}

$(document).ready(function() {

var dokterlab_1  = jQuery('#<?php echo CHtml::activeId($cci, 'pegawai_id') ?>');
var dokterlab_2  = jQuery('#<?php echo CHtml::activeId($cci, 'dpjp_id') ?>');
var petugas  = jQuery('#<?php echo CHtml::activeId($cci, 'perawat_id') ?>');

jQuery(dokterlab_1).multiselect({
    includeSelectAllOption: true,
    buttonClass: "form-control",
    maxHeight: 300,
    buttonWidth: '240px',
    enableCaseInsensitiveFiltering: true
}).hide();

jQuery(dokterlab_2).multiselect({
    includeSelectAllOption: true,
    buttonClass: "form-control",
    maxHeight: 300,
    buttonWidth: '240px',
    enableCaseInsensitiveFiltering: true
}).hide();

jQuery(petugas).multiselect({
    includeSelectAllOption: true,
    buttonClass: "form-control",
    maxHeight: 300,
    buttonWidth: '240px',
    enableCaseInsensitiveFiltering: true
}).hide();

});


</script>