<?php $linkHalaman = CustomFunction::getUrlByMenuID(3270); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sapegawai-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
    'focus' => '#',
)); ?>
<?php
$this->breadcrumbs = array(
    'Resign Pegawai',
);
?>
<?php
$sukses = null;
if (isset($_GET['sukses'])) {
    $sukses = $_GET['sukses'];
}
if ($sukses > 0) {
    Yii::app()->user->setFlash('success', 'Data ' . $model->nama_pegawai . ' berhasil disimpan');
    $this->widget('bootstrap.widgets.BootAlert');
}
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Resign <b>Pegawai</b>
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
                    <i class="entypo-user"></i> Data <b>Pegawai</b>
                    <span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="entypo-arrows-ccw"></i>', array('class' => 'btn btn-default btn-mini', 'onclick' => 'setPegawaiReset();', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk mengulang data pegawai')); ?>
                </div>
            </div>
            <div class="panel-body">
                <!--RIWAYAT MUTASI PEGAWAI-->
                <?php if (!empty($pegawai_id)) : ?>
                    <?php
                    $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                        'id' => 'data-riwayat',
                        'content' => array(
                            'content-datariwayat' => array(
                                'header' => '<b>Riwayat Mutasi Kerja</b>',
                                'isi' => $this->renderPartial('_riwayat', array(), true),
                                'active' => false,
                            ),
                        ),
                    ));
                    ?>
                <?php else : ?>
                    <!--DATA PEGAWAI-->
                    <?php echo $this->renderPartial('_formPegawai', array('form' => $form, 'model' => $model, true)); ?>
                    <?php /*
                        <fieldset class="box" id="data-riwayat">
                                <legend class="rim">Riwayat Mutasi Kerja</legend>
                                <?php echo $this->renderPartial('_riwayat',array(),true); ?>
                        </fieldset>
                         * 
                         */ ?>
                <?php endif; ?>
                <!--END - RIWAYAT MUTASI PEGAWAI-->
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data <b>Resign</b>
                </div>
            </div>
            <div class="panel-body">
                <?php echo $form->errorSummary($model); ?>
                <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                                            ?></p>-->
                <fieldset class="box" id="tablePegawaimutasi">
                    <div class="row">
                        <div class="col-sm-6">
                            <?php echo $form->textFieldRow($modPegresign, 'noresign', array('placeholder' => 'No Surat', 'class' => 'span4', 'onkeypress' => 'return $(this).focusNextInputField(event)')) ?>
                            <div class="control-group">
                                <?php echo $form->labelEx($modPegresign, 'tglresign', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php
                                    $this->widget('MyDateTimePicker', array(
                                        'model' => $modPegresign,
                                        'attribute' => 'tglresign',
                                        'mode' => 'date',
                                        'options' => array(
                                            'showOn' => true,
                                            // 'maxDate' => 'd',
                                            'onkeyup' => "js:function(){setUmur(this.value);}",
                                            'onSelect' => 'js:function(){setUmur(this.value);}',
                                            'yearRange' => "-150:+0",
                                        ),
                                        'htmlOptions' => array(
                                            'placeholder' => '00/00/0000', 'class' => 'span4 dtPicker2 datemask', 'onkeyup' => "return $(this).focusNextInputField(event)"
                                        ),
                                    )); ?>
                                </div>
                            </div>
                            <?php echo $form->dropDownListRow($modPegresign, 'jabatan_id', CHtml::listData($modPegresign->getJabatanItems(), 'jabatan_id', 'jabatan_nama'), array('class' => 'span4', 'empty' => '-- Pilih --', 'class' => 'span4', 'onkeypress' => 'return $(this).focusNextInputField(event)', 'readonly' => true)) ?>
                            <div class="control-group">
                                <?php echo $form->labelEx($modPegresign, 'alasanresign', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php echo $form->textArea($modPegresign, 'alasanresign', array('placeholder' => 'Alasan Resign', 'rows' => 3, 'cols' => 30, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <?php echo $form->dropDownListRow($modPegresign, 'unitkerja_id', CHtml::listData($modPegresign->getUnitKerjaItems(), 'unitkerja_id', 'namaunitkerja'), array('class' => 'span4', 'empty' => '-- Pilih --', 'onkeypress' => 'return $(this).focusNextInputField(event)', 'readonly' => true)) ?>
                            <?php echo $form->textFieldRow($modPegresign, 'lamakerja', array('placeholder' => '00 Thn 00 Bln 00 Hr', 'class' => 'form-control span4 umur', 'onblur' => 'setTglLahir(this);', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20, 'readonly' => true)); ?>
                            <div class="control-group">
                                <?php echo $form->labelEx($modPegresign, 'lampiran_surat', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php echo Chtml::activeFileField($modPegresign, 'lampiran_surat', array('maxlength' => 254, 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
        <div class="form-actions">
            <?php echo CHtml::htmlButton(
                $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'submitButton', 'onKeypress' => 'return formSubmit(this,event)', 'name' => 'submitPegmutasi')
            ); ?>
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                '#',
                array(
                    'title' => 'Ulang',
                    'class' => 'btn btn-default',
                    'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                )
            ); ?>
            <?php
            $tips = array(
                '0' => 'simpan',
                '1' => 'ulang',
            );
            $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
    </div>
</div>
<?php
$this->endWidget();
$urlGetPegmutasi = $this->createUrl('GetPegmutasi');
if (!empty($pegawai_id)) {
    $js = <<< JS
function Pegmutasidata()
{
    pegawai_id = {$pegawai_id};
    if(pegawai_id==''){
        myAlert('Anda belum memilih pegawai');
        return false;
    }else{
        $.post("${urlGetPegmutasi}", {pegawai_id:pegawai_id,},
        function(data){
            $("#tableRiwayatPegmutasi").children("tbody").append(data.tr);
        }, "json");
    }   
}
function ViewPegmutasi() {
    if ($("#cekRiwayatPegawaimutasi").is(":checked")) {
        Pegmutasidata();
        $("#tableRiwayatPegmutasi").slideDown(60);
    } else {
        $("#tableRiwayatPegmutasi").children("tbody").children("tr").remove();
        $("#tableRiwayatPegmutasi").slideUp(60);
    }
}
$(document).ready(function(){
    Pegmutasidata();
});
JS;
    Yii::app()->clientScript->registerScript('pencatatanriwayat', $js, CClientScript::POS_HEAD);
}
?>
<script type="text/javascript">
    function hapus(obj) {
        myConfirm('Anda yakin akan menghapus item ini?', 'Perhatian!',
            function(r) {
                if (r) {
                    url = $(obj).attr('href');
                    $(location).attr('href', url);
                }
            });
    }
</script>
<?php if (empty($pegawai_id)) $this->renderPartial('_jsFunctions', array()); ?>