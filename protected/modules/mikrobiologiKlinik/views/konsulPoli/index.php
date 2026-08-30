<?php
$this->breadcrumbs = array(
    'Konsul Poli',
);
$this->widget('bootstrap.widgets.BootAlert');
?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<!--<h6>Tabel <b>Konsultasi Poliklinik</b></h6>-->
<?php 
        $loginpemakai = Yii::app()->user->id;
        $criteria = new CDbCriteria;
        $criteria->addCondition('loginpemakai_id = ' . $loginpemakai);
        $pegawai = LoginpemakaiK::model()->find($criteria);
        $kelPegawai = PegawaiM::model()->findByPk($pegawai->pegawai_id);
         if ((!empty($kelPegawai->loginpemakai_id == Yii::app()->user->getState('loginpemakai_id')) && !empty($kelPegawai->kelompokpegawai_id == Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN))) {     
?>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Tabel <b>Pelayanan Konsultasi</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php $this->renderPartial($this->path_view . '_listKonsulPoli2', array('modRiwayatKonsul' => $modRiwayatKonsul)); ?>
    </div>
</div>
<!--</div>-->
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'searchKonsulPoli',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('enctype' => 'multipart/form-data','onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#' . CHtml::activeId($modKonsul, 'ruangan_id'),
)); ?>
<!--<legend class="rim2">Konsultasi Poliklinik</legend>-->

<div class="antirow">
    <div class="row">
        <!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') 
                                    ?></p>-->
        <?php echo $form->errorSummary(array($modKonsul, $modelPendaftaran)); ?>
        <?php echo CHtml::hiddenField('url', $this->createUrl('', array('pendaftaran_id' => $modPendaftaran->pendaftaran_id)), array('readonly' => TRUE)); ?>
        <?php echo CHtml::hiddenField('berubah', '', array('readonly' => TRUE)); ?>
        <div class="col-sm-6">
            <div class="control-group">
                <?php echo $form->labelEx($modKonsul, 'tglkonsulpoli', array('class' => 'control-label')) ?>
                <?php $modKonsul->tglkonsulpoli = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modKonsul->tglkonsulpoli, 'yyyy-MM-dd hh:mm:ss', 'medium', null)); ?>
                <div class="controls">
                    <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $modKonsul,
                        'attribute' => 'tglkonsulpoli',
                        'mode' => 'datetime',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                            'maxDate' => 'd',
                        ),
                        'htmlOptions' => array('readonly' => true),
                    ));
                    ?>
                </div>
            </div>
            <?php echo $form->dropDownListRow(
                $modKonsul,
                'ruangan_id',
                CHtml::listData(RuangankonsulV::model()->findAll(), 'ruangan_id', 'ruangan_nama'),
                array('empty' => '-- Pilih --', 'class' => 'form-control span3', 'onkeypress' => "return $(this).focusNextInputField(event);",
                'multiple' => 'multiple',
                'onchange' => 'setTarif()')
            );
            ?>
        </div>
        <div class="col-sm-6">
            <?php echo $form->dropDownListRow(
                $modKonsul,
                'pegawai_id',
                CHtml::listData($modKonsul->getDokterItems($modPendaftaran->ruangan_id), 'pegawai_id', 'NamaLengkap'),
                array('empty' => '-- Pilih --', 'class' => 'span3 dokter-konsul', 'onkeypress' => "return $(this).focusNextInputField(event);")
            ); ?>
            <?php 
            // if(Yii::app()->user->getState('modul_id') != Params::MODUL_ID_RJ){
                ?>
            <?php //echo $form->textAreaRow($modKonsul, 'catatan_dokter_konsul', array('placeholder' => 'Catatan Dokter', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            <!-- <div class="control-group">
                <?php //echo CHtml::label('SOAP', 'SOAP', array('class' => 'control-label')) ?>
                <div class="controls">
                    <div class="form-inline">
                        <?php //echo $form->textArea($modKonsul, 'catatan_dokter_konsul', array('placeholder' => 'Catatan Dokter', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                    </div>
                </div>
            </div> -->
    <?php //} ?>
        </div>
    </div>
    <?php 
    // if(Yii::app()->user->getState('modul_id') == Params::MODUL_ID_RJ){
        ?>
    <div class="row">
        <div class="col-sm-6">
            <br/>
            <b>Catatan Dokter</b>
            <br/>
            <br/>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="control-group">
                <label class="control-label">Uraian Konsultasi</label>
                <div class="controls" style="width:80%; margin-bottom: 20px;">
                    <?php echo $form->textArea($modKonsul, 'uraian_konsul', array('style' => 'width: 1550px; height: 200px; ')); ?>
                </div>
            </div>
            
            
        </div>
    </div>
    <?php //} ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">
                        <i class="glyphicon glyphicon-file"></i> Daftar Tindakan Konsultasi
                    </div>
                </div>
                <div id="inputanHemodialisa" class="hidden">
                    <br>
                    <div class="control-group">
                        <?php echo CHtml::label('Dialisat', 'Dialisat', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <div class="form-inline">
                                <?php echo $form->radioButtonList($modKonsul, 'jenisdialisat_id', PeriksahdT::getJenisDialisat(), array('separator' => '', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                            </div>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Lama Hemodialisa', 'Lama Hemodialisa', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <div class="form-inline">
                                <?php echo $form->textField($modKonsul, 'lama_hd', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span1 integer')); ?> Jam
                            </div>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Penarikan Cairan', 'Penarikan Cairan', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <div class="form-inline">
                                <?php echo $form->textField($modKonsul, 'penarikan_cairan', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span1 integer')); ?> ml
                            </div>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Akses Vaskular', 'Akses Vaskular', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->dropDownList(
                                $modKonsul,
                                'aksesvaskular_id',
                                CHtml::listData(AksesvaskularM::model()->findAll('aksesvaskular_aktif is TRUE'), 'aksesvaskular_id', 'aksesvaskular_nama'),
                                array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")
                            ); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Tranfusi', 'Tranfusi', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <div class="form-inline">
                                <?php echo $form->radioButtonList($modKonsul, 'jenistransfusi_id', JenistransfusiM::getJenisTransfusi(), array('separator' => '', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="tarif_poliklinik">
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$js = <<< JS
//==================================================Validasi===============================================
//*Jangan Lupa untuk menambahkan hiddenField dengan id "berubah" di setiap form
//* hidden field dengan id "url"
//*Copas Saja hiddenfield di Line 36 dan 35
//* ubah juga id button simpannya jadi "btn_simpan"
function palidasiForm(obj)
{
    var berubah = $('#berubah').val();
    if(berubah=='Ya'){
        myConfirm("Apakah Anda Akan menyimpan Perubahan Yang Sudah Dilakukan?","Perhatian!",function(r) {
            if(r){
                $('#url').val(obj);
                $('#btn_simpan').click();
            }
        });
    }      
}
JS;
Yii::app()->clientScript->registerScript('js', $js, CClientScript::POS_READY);
?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDetailKonsul',
    'options' => array(
        'title' => 'Detail Konsul',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'resizable' => false,
        'position' => 'top',
    ),
));
echo '<div id="contentDetailKonsul"></div>';
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDetailKonsulHasil',
    'options' => array(
        'title' => 'Hasil Jawaban Konsul',
        'autoOpen' => false,
        'modal' => true,
        'width' => 650,
        'resizable' => false,
        'position' => 'top',
    ),
));
echo '<div id="contentDetailKonsulHasil">dialog content here</div>';
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
<script type="text/javascript">
    function viewDetailKonsul(idKonsulAntarPoli) {
        $.post('<?php echo $this->createUrl('ajaxDetailKonsul') ?>', {
            idKonsulAntarPoli: idKonsulAntarPoli
        }, function(data) {
            $('#contentDetailKonsul').html(data.result);
        }, 'json');
        $('#dialogDetailKonsul').dialog('open');
    }

    function viewDetailKonsulHasil(idKonsulAntarPoli) {
        $.post('<?php echo $this->createUrl('ajaxDetailKonsulHasil') ?>', {
            idKonsulAntarPoli: idKonsulAntarPoli
        }, function(data) {
            $('#contentDetailKonsulHasil').html(data.result);
        }, 'json');
        $('#dialogDetailKonsulHasil').dialog('open');
    }

    function batalKonsul(idKonsulAntarPoli, pendaftaran_id) {
        myConfirm("Apakah Anda akan membatalkan konsul ini?", "Perhatian!", function(r) {
            if (r) {
                $.post('<?php echo $this->createUrl('ajaxBatalKonsul') ?>', {
                    idKonsulAntarPoli: idKonsulAntarPoli,
                    pendaftaran_id: pendaftaran_id
                }, function(data) {
                    $('#tblListKonsul').html(data.result);
                }, 'json');
            }
        });
    }

    function setTarif() {
        var ruangan_id = $('#<?php echo CHtml::activeId($modKonsul, 'ruangan_id'); ?>').val();
        var penjamin_id = '<?php echo $modPendaftaran->penjamin_id; ?>';
        var kelaspelayanan_id = '<?php echo $modPendaftaran->kelaspelayanan_id; ?>';
        $.post('<?php echo $this->createUrl('ajaxSetTarif') ?>', {
            ruangan_id: ruangan_id,
            penjamin_id: penjamin_id,
            kelaspelayanan_id: kelaspelayanan_id
        }, function(data) {
            $('#tarif_poliklinik').html(data.result);
            $('.dokter-konsul').html(data.dokter);
            if (ruangan_id == '<?php echo Params::RUANGAN_ID_HEMODIALISA; ?>') {
                $('.titleTindakan').html('Pengantar Permintaan Tindakan Hemodialisa');
                $('#inputanHemodialisa').removeClass('hidden');
            } else {
                $('.titleTindakan').html('Daftar Tindakan Konsultasi Poliklinik');
                $('#inputanHemodialisa').addClass('hidden');
            }
        }, 'json');
    }
    $(document).ready(function() {
        // Notifikasi Pasien
        <?php
        if (isset($_GET['smspasien'])) {
            if ($_GET['smspasien'] == 0) {
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
        if (isset($modKirimKeUnitLain->pasienkirimkeunitlain_id)) {
        ?>
            var params = [];
            params = {
                instalasi_id: <?php echo Yii::app()->user->getState("instalasi_id"); ?>,
                modul_id: <?php echo Params::MODUL_ID_RJ ?>,
                judulnotifikasi: 'Pasien Rujukan',
                isinotifikasi: '<?php echo $modPasien->nama_pasien ?> dengan <?php echo $modPasien->no_rekam_medik ?> telah dirujuk pada <?php echo $modKirimKeUnitLain->tgl_kirimpasien ?> dari <?php echo $modKirimKeUnitLain->ruangan->ruangan_nama ?>'
            }; // 16 
            insert_notifikasi(params);
        <?php
        }
        ?>
        <?php
        if (isset($_GET['idKonsulPoli'])) {
        ?>
            var params = [];
            params = {
                instalasi_id: <?php echo Yii::app()->user->getState("instalasi_id"); ?>,
                modul_id: <?php echo Params::MODUL_ID_RJ ?>,
                judulnotifikasi: 'Pasien Konsul Poli',
                isinotifikasi: 'Pasien <?php echo $modPasien->nama_pasien ?> dengan nomor rekam medik <?php echo $modPasien->no_rekam_medik ?> telah dikonsul ke <?php echo $modKonsulPoli->politujuan->ruangan_nama ?> pada <?php echo $modKonsulPoli->tglkonsulpoli ?> dari <?php echo $modKonsulPoli->poliasal->ruangan_nama ?>'
            }; // 16 
            insert_notifikasi(params);
        <?php
        }
        ?>
    });

    $(document).ready(function() {
           
           var ruangan = jQuery('#<?php echo CHtml::activeId($modKonsul, 'ruangan_id') ?>');	
           jQuery(ruangan).multiselect({
                   includeSelectAllOption: true,
                   buttonClass: "form-control",
                   maxHeight: 300,
                   buttonWidth: '182px',
                   enableCaseInsensitiveFiltering: true
           }).hide();
       });


    function checkAll() {
        if ($('#checkAllRuangan').is(':checked')) {
            $('#searchKonsulPoli input[name*="ruangan_id"]').each(function() {
                $(this).attr('checked', true);
            });
        } else {
            $('#searchKonsulPoli input[name*="ruangan_id"]').each(function() {
                $(this).removeAttr('checked');
            });
        }
    }
</script>
<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="' . MyIcon::getIcons('simpan') . '"></i>')),
        array('class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'id' => 'btn_simpan')
    ); ?>
    <?php
    if (isset($_GET['idKonsulPoli'])) {
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')')) . "&nbsp";
        echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
    } else {
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'disabled' => 'disabled')) . "&nbsp";
        echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'disabled' => 'disabled'));
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'disabled' => 'disabled'));
    }
    ?>
    <?php
    $content = $this->renderPartial('rawatJalan.views.tips.tips', array(), true);
    $this->widget('UserTips', array('type' => 'admin', 'content' => $content));
    $idKonsulPoli = isset($_GET['idKonsulPoli']) ? $_GET['idKonsulPoli'] : null;
    $urlPrint = Yii::app()->createAbsoluteUrl($this->module->id . '/' . $this->id . '/print&id=' . $modPendaftaran->pendaftaran_id . '&idKonsulPoli=' . $idKonsulPoli);
    $urlPrintRiwayat = Yii::app()->createAbsoluteUrl($this->module->id . '/' . $this->id . '/printRiwayat&id=' . $modPendaftaran->pendaftaran_id);
    $urlPrintPermintaan = Yii::app()->createAbsoluteUrl($this->module->id . '/' . $this->id . '/print&id=' . $modPendaftaran->pendaftaran_id);
    $js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}&caraPrint="+caraPrint,"",'location=_new, width=460px');
}
function printRiwayat(caraPrint)
{
    window.open("${urlPrintRiwayat}&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
function printPermintaan(idKonsulPoli)
{
    window.open("${urlPrintPermintaan}&idKonsulPoli="+idKonsulPoli+"&caraPrint="+"PRINT","",'location=_new, width=460px');
}
JSCRIPT;
    Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
    ?>
</div>
<?php } else { ?>

    <div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Tabel <b>Pelayanan Konsultasi</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php $this->renderPartial($this->path_view . '_listKonsulPoli', array('modRiwayatKonsul' => $modRiwayatKonsul)); ?>
    </div>
</div>
<!--</div>-->
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'searchKonsulPoli',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('enctype' => 'multipart/form-data','onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#' . CHtml::activeId($modKonsul, 'ruangan_id'),
)); ?>
<!--<legend class="rim2">Konsultasi Poliklinik</legend>-->

<div class="antirow">
    <div class="row">
        <!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') 
                                    ?></p>-->
        <?php echo $form->errorSummary(array($modKonsul, $modelPendaftaran)); ?>
        <?php echo CHtml::hiddenField('url', $this->createUrl('', array('pendaftaran_id' => $modPendaftaran->pendaftaran_id)), array('readonly' => TRUE)); ?>
        <?php echo CHtml::hiddenField('berubah', '', array('readonly' => TRUE)); ?>
        <div class="col-sm-6">
            <div class="control-group">
                <?php echo $form->labelEx($modKonsul, 'tglkonsulpoli', array('class' => 'control-label')) ?>
                <?php $modKonsul->tglkonsulpoli = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modKonsul->tglkonsulpoli, 'yyyy-MM-dd hh:mm:ss', 'medium', null)); ?>
                <div class="controls">
                    <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $modKonsul,
                        'attribute' => 'tglkonsulpoli',
                        'mode' => 'datetime',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                            'maxDate' => 'd',
                        ),
                        'htmlOptions' => array('readonly' => true),
                    ));
                    ?>
                </div>
            </div>
            <?php echo $form->dropDownListRow(
                $modKonsul,
                'ruangan_id',
                CHtml::listData(RuangankonsulV::model()->findAll(), 'ruangan_id', 'ruangan_nama'),
                array('empty' => '-- Pilih --', 'class' => 'form-control span3', 'onkeypress' => "return $(this).focusNextInputField(event);",
                'multiple' => 'multiple',
                'onchange' => 'setTarif()')
            );
            ?>
        </div>
        <div class="col-sm-6">
            <?php echo $form->dropDownListRow(
                $modKonsul,
                'pegawai_id',
                CHtml::listData($modKonsul->getDokterItems($modPendaftaran->ruangan_id), 'pegawai_id', 'NamaLengkap'),
                array('empty' => '-- Pilih --', 'class' => 'span3 dokter-konsul', 'onkeypress' => "return $(this).focusNextInputField(event);")
            ); ?>
            <?php 
            // if(Yii::app()->user->getState('modul_id') != Params::MODUL_ID_RJ){
                ?>
            <?php //echo $form->textAreaRow($modKonsul, 'catatan_dokter_konsul', array('placeholder' => 'Catatan Dokter', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            <!-- <div class="control-group">
                <?php //echo CHtml::label('SOAP', 'SOAP', array('class' => 'control-label')) ?>
                <div class="controls">
                    <div class="form-inline">
                        <?php //echo $form->textArea($modKonsul, 'catatan_dokter_konsul', array('placeholder' => 'Catatan Dokter', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                    </div>
                </div>
            </div> -->
    <?php //} ?>
        </div>
    </div>
    <?php 
    // if(Yii::app()->user->getState('modul_id') == Params::MODUL_ID_RJ){
        ?>
    <div class="row">
        <div class="col-sm-6">
            <br/>
            <b>Catatan Dokter</b>
            <br/>
            <br/>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="control-group">
                <label class="control-label">Uraian Konsultasi</label>
                <div class="controls" style="width:80%; margin-bottom: 20px;">
                    <?php echo $form->textArea($modKonsul, 'uraian_konsul', array('style' => 'width: 1550px; height: 200px; ')); ?>
                </div>
            </div>
            
            
        </div>
    </div>
    <?php //} ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">
                        <i class="glyphicon glyphicon-file"></i> Daftar Tindakan Konsultasi
                    </div>
                </div>
                <div id="inputanHemodialisa" class="hidden">
                    <br>
                    <div class="control-group">
                        <?php echo CHtml::label('Dialisat', 'Dialisat', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <div class="form-inline">
                                <?php echo $form->radioButtonList($modKonsul, 'jenisdialisat_id', PeriksahdT::getJenisDialisat(), array('separator' => '', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                            </div>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Lama Hemodialisa', 'Lama Hemodialisa', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <div class="form-inline">
                                <?php echo $form->textField($modKonsul, 'lama_hd', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span1 integer')); ?> Jam
                            </div>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Penarikan Cairan', 'Penarikan Cairan', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <div class="form-inline">
                                <?php echo $form->textField($modKonsul, 'penarikan_cairan', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span1 integer')); ?> ml
                            </div>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Akses Vaskular', 'Akses Vaskular', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->dropDownList(
                                $modKonsul,
                                'aksesvaskular_id',
                                CHtml::listData(AksesvaskularM::model()->findAll('aksesvaskular_aktif is TRUE'), 'aksesvaskular_id', 'aksesvaskular_nama'),
                                array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")
                            ); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Tranfusi', 'Tranfusi', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <div class="form-inline">
                                <?php echo $form->radioButtonList($modKonsul, 'jenistransfusi_id', JenistransfusiM::getJenisTransfusi(), array('separator' => '', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="tarif_poliklinik">
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$js = <<< JS
//==================================================Validasi===============================================
//*Jangan Lupa untuk menambahkan hiddenField dengan id "berubah" di setiap form
//* hidden field dengan id "url"
//*Copas Saja hiddenfield di Line 36 dan 35
//* ubah juga id button simpannya jadi "btn_simpan"
function palidasiForm(obj)
{
    var berubah = $('#berubah').val();
    if(berubah=='Ya'){
        myConfirm("Apakah Anda Akan menyimpan Perubahan Yang Sudah Dilakukan?","Perhatian!",function(r) {
            if(r){
                $('#url').val(obj);
                $('#btn_simpan').click();
            }
        });
    }      
}
JS;
Yii::app()->clientScript->registerScript('js', $js, CClientScript::POS_READY);
?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDetailKonsul',
    'options' => array(
        'title' => 'Detail Konsul',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'resizable' => false,
        'position' => 'top',
    ),
));
echo '<div id="contentDetailKonsul"></div>';
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDetailKonsulHasil',
    'options' => array(
        'title' => 'Hasil Jawaban Konsul',
        'autoOpen' => false,
        'modal' => true,
        'width' => 650,
        'resizable' => false,
        'position' => 'top',
    ),
));
echo '<div id="contentDetailKonsulHasil">dialog content here</div>';
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
<script type="text/javascript">
    function viewDetailKonsul(idKonsulAntarPoli) {
        $.post('<?php echo $this->createUrl('ajaxDetailKonsul') ?>', {
            idKonsulAntarPoli: idKonsulAntarPoli
        }, function(data) {
            $('#contentDetailKonsul').html(data.result);
        }, 'json');
        $('#dialogDetailKonsul').dialog('open');
    }

    function viewDetailKonsulHasil(idKonsulAntarPoli) {
        $.post('<?php echo $this->createUrl('ajaxDetailKonsulHasil') ?>', {
            idKonsulAntarPoli: idKonsulAntarPoli
        }, function(data) {
            $('#contentDetailKonsulHasil').html(data.result);
        }, 'json');
        $('#dialogDetailKonsulHasil').dialog('open');
    }

    function batalKonsul(idKonsulAntarPoli, pendaftaran_id) {
        myConfirm("Apakah Anda akan membatalkan konsul ini?", "Perhatian!", function(r) {
            if (r) {
                $.post('<?php echo $this->createUrl('ajaxBatalKonsul') ?>', {
                    idKonsulAntarPoli: idKonsulAntarPoli,
                    pendaftaran_id: pendaftaran_id
                }, function(data) {
                    $('#tblListKonsul').html(data.result);
                }, 'json');
            }
        });
    }

    function setTarif() {
        var ruangan_id = $('#<?php echo CHtml::activeId($modKonsul, 'ruangan_id'); ?>').val();
        var penjamin_id = '<?php echo $modPendaftaran->penjamin_id; ?>';
        var kelaspelayanan_id = '<?php echo $modPendaftaran->kelaspelayanan_id; ?>';
        $.post('<?php echo $this->createUrl('ajaxSetTarif') ?>', {
            ruangan_id: ruangan_id,
            penjamin_id: penjamin_id,
            kelaspelayanan_id: kelaspelayanan_id
        }, function(data) {
            $('#tarif_poliklinik').html(data.result);
            $('.dokter-konsul').html(data.dokter);
            if (ruangan_id == '<?php echo Params::RUANGAN_ID_HEMODIALISA; ?>') {
                $('.titleTindakan').html('Pengantar Permintaan Tindakan Hemodialisa');
                $('#inputanHemodialisa').removeClass('hidden');
            } else {
                $('.titleTindakan').html('Daftar Tindakan Konsultasi Poliklinik');
                $('#inputanHemodialisa').addClass('hidden');
            }
        }, 'json');
    }
    $(document).ready(function() {
        // Notifikasi Pasien
        <?php
        if (isset($_GET['smspasien'])) {
            if ($_GET['smspasien'] == 0) {
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
        if (isset($modKirimKeUnitLain->pasienkirimkeunitlain_id)) {
        ?>
            var params = [];
            params = {
                instalasi_id: <?php echo Yii::app()->user->getState("instalasi_id"); ?>,
                modul_id: <?php echo Params::MODUL_ID_RJ ?>,
                judulnotifikasi: 'Pasien Rujukan',
                isinotifikasi: '<?php echo $modPasien->nama_pasien ?> dengan <?php echo $modPasien->no_rekam_medik ?> telah dirujuk pada <?php echo $modKirimKeUnitLain->tgl_kirimpasien ?> dari <?php echo $modKirimKeUnitLain->ruangan->ruangan_nama ?>'
            }; // 16 
            insert_notifikasi(params);
        <?php
        }
        ?>
        <?php
        if (isset($_GET['idKonsulPoli'])) {
        ?>
            var params = [];
            params = {
                instalasi_id: <?php echo Yii::app()->user->getState("instalasi_id"); ?>,
                modul_id: <?php echo Params::MODUL_ID_RJ ?>,
                judulnotifikasi: 'Pasien Konsul Poli',
                isinotifikasi: 'Pasien <?php echo $modPasien->nama_pasien ?> dengan nomor rekam medik <?php echo $modPasien->no_rekam_medik ?> telah dikonsul ke <?php echo $modKonsulPoli->politujuan->ruangan_nama ?> pada <?php echo $modKonsulPoli->tglkonsulpoli ?> dari <?php echo $modKonsulPoli->poliasal->ruangan_nama ?>'
            }; // 16 
            insert_notifikasi(params);
        <?php
        }
        ?>
    });

    $(document).ready(function() {
           
           var ruangan = jQuery('#<?php echo CHtml::activeId($modKonsul, 'ruangan_id') ?>');	
           jQuery(ruangan).multiselect({
                   includeSelectAllOption: true,
                   buttonClass: "form-control",
                   maxHeight: 300,
                   buttonWidth: '182px',
                   enableCaseInsensitiveFiltering: true
           }).hide();
       });


    function checkAll() {
        if ($('#checkAllRuangan').is(':checked')) {
            $('#searchKonsulPoli input[name*="ruangan_id"]').each(function() {
                $(this).attr('checked', true);
            });
        } else {
            $('#searchKonsulPoli input[name*="ruangan_id"]').each(function() {
                $(this).removeAttr('checked');
            });
        }
    }
</script>
<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="' . MyIcon::getIcons('simpan') . '"></i>')),
        array('class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'id' => 'btn_simpan')
    ); ?>
    <?php
    if (isset($_GET['idKonsulPoli'])) {
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')')) . "&nbsp";
        echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
    } else {
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'disabled' => 'disabled')) . "&nbsp";
        echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'disabled' => 'disabled'));
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'disabled' => 'disabled'));
    }
    ?>
    <?php
    $content = $this->renderPartial('rawatJalan.views.tips.tips', array(), true);
    $this->widget('UserTips', array('type' => 'admin', 'content' => $content));
    $idKonsulPoli = isset($_GET['idKonsulPoli']) ? $_GET['idKonsulPoli'] : null;
    $urlPrint = Yii::app()->createAbsoluteUrl($this->module->id . '/' . $this->id . '/print&id=' . $modPendaftaran->pendaftaran_id . '&idKonsulPoli=' . $idKonsulPoli);
    $urlPrintRiwayat = Yii::app()->createAbsoluteUrl($this->module->id . '/' . $this->id . '/printRiwayat&id=' . $modPendaftaran->pendaftaran_id);
    $urlPrintPermintaan = Yii::app()->createAbsoluteUrl($this->module->id . '/' . $this->id . '/print&id=' . $modPendaftaran->pendaftaran_id);
    $js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}&caraPrint="+caraPrint,"",'location=_new, width=460px');
}
function printRiwayat(caraPrint)
{
    window.open("${urlPrintRiwayat}&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
function printPermintaan(idKonsulPoli)
{
    window.open("${urlPrintPermintaan}&idKonsulPoli="+idKonsulPoli+"&caraPrint="+"PRINT","",'location=_new, width=460px');
}
JSCRIPT;
    Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
    ?>
</div>
    <?php } ?>
<?php $this->endWidget(); ?>
