<?php $linkHalaman = CustomFunction::getUrlByMenuID(1283); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sapegawai-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onsubmit' => 'return requiredCheck(this);', 'enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
    'focus' => '#',
)); ?>
<?php
$this->breadcrumbs = array(
    'Promosi Pegawai',
);
if (empty($pegawai_id)) {
    echo '<div class="row">';
}
?>
<div class="col-sm-12">
    <div class="panel panel-gradient">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="glyphicon glyphicon-briefcase"></i> Promosi <b>Pegawai</b>
                <span class="pull-right">
                    <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                        <i class="fas fa-external-link-alt"></i> Ke Halaman Informasi
                    </a>
                </span>
            </div>
        </div>
        <div class="panel-body">
            <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                                        ?></p>-->
            <?php
            $sukses = null;
            if (isset($_GET['sukses'])) {
                $sukses = $_GET['sukses'];
            }
            if ($sukses > 0)
                $this->widget('bootstrap.widgets.BootAlert');
            echo $form->errorSummary($modPegmutasi);
            ?>
            <div class="panel panel-success" id="form-pegawai">
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
                        <?php echo $this->renderPartial('form/_formPegawai', array('form' => $form, 'model' => $model, true)); ?>
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
                        <i class="entypo-user"></i> Promosi Pegawai
                    </div>
                </div>
                <div class="panel-body">
                    <?php echo $form->errorSummary($model); ?>
                    <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                                                ?></p>-->
                    <fieldset class="box" id="tablePegawaimutasi">
                        <div class="row">
                            <div class="col-sm-6">
                                <?php echo $form->textFieldRow($modPegmutasi, 'prom_nomorsurat', array('placeholder' => 'Nomor Surat', 'class' => 'span3', 'onkeypress' => 'return $(this).focusNextInputField(event)')) ?>
                                <?php //echo $form->dropDownListRow($modPegmutasi,'prom_golongan_lama',CHtml::listData($modPegmutasi->getGolonganItems(),'golonganpegawai_nama','golonganpegawai_nama'),array('class' => 'span3','empty'=>'-- Pilih --','class'=>'span3','onkeypress'=>'return $(this).focusNextInputField(event)')) 
                                ?>
                                <?php echo $form->dropDownListRow($modPegmutasi, 'prom_jabatan_lama', CHtml::listData($modPegmutasi->getJabatanItems(), 'jabatan_nama', 'jabatan_nama'), array('class' => 'span3', 'empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => 'return $(this).focusNextInputField(event)')) ?>
                                <?php //echo $form->dropDownListRow($modPegmutasi,'prom_pangkat_lama',CHtml::listData($modPegmutasi->getPangkatItems(),'pangkat_nama','pangkat_nama'),array('class' => 'span3','empty'=>'-- Pilih --','class'=>'span3','onkeypress'=>'return $(this).focusNextInputField(event)')) 
                                ?>
                                <?php echo $form->dropDownListRow($modPegmutasi, 'prom_unitkerja', CHtml::listData($modPegmutasi->getRuanganItems(), 'ruangan_nama', 'ruangan_nama'), array('class' => 'span3', 'empty' => '-- Pilih --', 'onkeypress' => 'return $(this).focusNextInputField(event)')) ?>
                                <?php //echo $form->dropDownListRow($modPegmutasi,'pangkat_nama',CHtml::listData($modPegmutasi->getPangkatItems(),'pangkat_nama','pangkat_nama'),array('empty'=>'-- Pilih --','class'=>'span3','onkeypress'=>'return $(this).focusNextInputField(event)')) 
                                ?>
                                <?php echo $form->dropDownListRow($modPegmutasi, 'jenispromosi', LookupM::getItems('jenispromosi'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                            </div>
                            <div class="col-sm-6">
                                <div class="control-group">
                                    <?php echo CHtml::label("", '', array('class' => 'control-label')); ?>
                                    <div class="controls">
                                    </div>
                                </div>
                                <br>
                                <?php //echo $form->dropDownListRow($modPegmutasi,'prom_golongan_baru',CHtml::listData($modPegmutasi->getGolonganItems(),'golonganpegawai_nama','golonganpegawai_nama'),array('class' => 'span3 required','empty'=>'-- Pilih --','onkeypress'=>'return $(this).focusNextInputField(event)')) 
                                ?>
                                <?php echo $form->dropDownListRow($modPegmutasi, 'prom_jabatan_baru', CHtml::listData($modPegmutasi->getJabatanItems(), 'jabatan_nama', 'jabatan_nama'), array('class' => 'span3 required', 'empty' => '-- Pilih --', 'onkeypress' => 'return $(this).focusNextInputField(event)')) ?>
                                <?php //echo $form->dropDownListRow($modPegmutasi,'prom_pangkat_baru',CHtml::listData($modPegmutasi->getPangkatItems(),'pangkat_nama','pangkat_nama'),array('class' => 'span3','empty'=>'-- Pilih --','onkeypress'=>'return $(this).focusNextInputField(event)')) 
                                ?>
                                <?php echo $form->dropDownListRow($modPegmutasi, 'prom_unitkerja_baru', CHtml::listData($modPegmutasi->getRuanganItems(), 'ruangan_nama', 'ruangan_nama'), array('class' => 'span3', 'empty' => '-- Pilih --', 'onkeypress' => 'return $(this).focusNextInputField(event)')) ?>
                                <?php echo $form->textFieldRow($modPegmutasi, 'prom_lokasikerja_baru', array('placeholder' => 'Lokasi Kerja Baru', 'class' => 'span3', 'onkeypress' => 'return $(this).focusNextInputField(event)')) ?>
                                <?php //echo $form->dropDownListRow($modPegmutasi,'pangkat_baru',CHtml::listData($modPegmutasi->getPangkatItems(),'pangkat_nama','pangkat_nama'),array('empty'=>'-- Pilih --','onkeypress'=>'return $(this).focusNextInputField(event)')) 
                                ?>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">
                        <i class="glyphicon glyphicon-file"></i> Surat Keputusan
                    </div>
                </div>
                <div class="panel-body">
                    <fieldset class="box" id="tableSuratKeputusan">
                        <div class="row">
                            <div class="col-sm-6">
                                <?php echo CHtml::hiddenField('url', $this->createUrl('', array('idPegawai' => $model->pegawai_id)), array('readonly' => TRUE)); ?>
                                <?php echo CHtml::hiddenField('berubah', '', array('readonly' => TRUE)); ?>
                                <?php echo $form->hiddenField($modPegmutasi, 'pegawai_id', array('readonly' => TRUE)); ?>
                                <?php echo $form->textFieldRow($modPegmutasi, 'prom_nosk', array('class' => 'span3', 'onkeypress' => 'return $(this).focusNextInputField(event)', 'value' => date('Ymd'))) ?>
                                <div class="control-group">
                                    <?php echo $form->labelEx($modPegmutasi, 'prom_tglsk', array('class' => 'control-label')); ?>
                                    <div class="controls">
                                        <?php
                                        $this->widget('MyDateTimePicker', array(
                                            'model' => $modPegmutasi,
                                            'attribute' => 'prom_tglsk',
                                            'mode' => 'date',
                                            'options' => array(
                                                'showOn' => false,
                                                'maxDate' => 'd',
                                                'yearRange' => "-150:+0",
                                            ),
                                            'htmlOptions' => array(
                                                'placeholder' => '00/00/0000', 'class' => 'span3 dtPicker2 datemask required', 'onkeyup' => "return $(this).focusNextInputField(event)"
                                            ),
                                        )); ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <?php echo $form->labelEx($modPegmutasi, 'prom_tmtsk', array('class' => 'control-label')); ?>
                                    <div class="controls">
                                        <?php
                                        $this->widget('MyDateTimePicker', array(
                                            'model' => $modPegmutasi,
                                            'attribute' => 'prom_tmtsk',
                                            'mode' => 'date',
                                            'options' => array(
                                                'showOn' => false,
                                                // 'maxDate' => 'd',
                                                'yearRange' => "-150:+0",
                                            ),
                                            'htmlOptions' => array(
                                                'placeholder' => '00/00/0000', 'class' => 'span3 dtPicker2 datemask', 'onkeyup' => "return $(this).focusNextInputField(event)"
                                            ),
                                        )); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <?php echo $form->dropDownListRow($modPegmutasi, 'prom_mengetahui_nama', CHtml::listData($modPegmutasi->getMengetahuiItems(), 'nama_pegawai', 'nama_pegawai'), array('empty' => '-- Pilih --', 'onkeypress' => 'return $(this).focusNextInputField(event)')) ?>
                                <?php echo $form->dropDownListRow($modPegmutasi, 'prom_pimpinan_nama', CHtml::listData($modPegmutasi->getMengetahuiItems(), 'nama_pegawai', 'nama_pegawai'), array('empty' => '-- Pilih --', 'onkeypress' => 'return $(this).focusNextInputField(event)')) ?>
                                <?php echo $form->fileFieldRow($modPegmutasi, 'prom_file_sk', array('accept' => 'application/pdf')); ?>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
            <div class="form-actions">
                <?php echo CHtml::htmlButton(
                    $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                    array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'submitButton', 'onKeypress' => 'return formSubmit(this,event)')
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
</div>
<?php
if (empty($pegawai_id)) {
    echo '</div>';
}
?>
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
<?php echo $this->renderPartial('js/_jsFunctions', array('model' => $modPegmutasi), true); ?>