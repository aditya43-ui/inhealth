<?php
$this->breadcrumbs = array(
    'Konsul Poli',
);
$this->widget('bootstrap.widgets.BootAlert');
?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>

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
            <i class="entypo-credit-card"></i> Tabel <b>Riwayat Order Tindakan Pasien</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php $this->renderPartial($this->path_view . '_listRuangTindakan2', array('modRiwayatKonsul' => $modRiwayatKonsul)); ?>
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
        'title' => 'Detail Tindakan',
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
        'title' => 'Hasil Pemeriksaan Tindakan',
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
    function viewDetailKonsul(idKonsulAntarTindakan) {
        $.post('<?php echo $this->createUrl('ajaxDetailKonsul') ?>', {
            idKonsulAntarTindakan: idKonsulAntarTindakan
        }, function(data) {
            $('#contentDetailKonsul').html(data.result);
        }, 'json');
        $('#dialogDetailKonsul').dialog('open');
    }

    function viewDetailKonsulHasil(idKonsulAntarTindakan) {
        $.post('<?php echo $this->createUrl('ajaxDetailKonsulHasil') ?>', {
            idKonsulAntarTindakan: idKonsulAntarTindakan
        }, function(data) {
            $('#contentDetailKonsulHasil').html(data.result);
        }, 'json');
        $('#dialogDetailKonsulHasil').dialog('open');
    }

    function batalKonsul(idKonsulAntarTindakan, pendaftaran_id) {
        myConfirm("Apakah Anda akan membatalkan konsul ini?", "Perhatian!", function(r) {
            if (r) {
                $.post('<?php echo $this->createUrl('ajaxBatalKonsul') ?>', {
                    idKonsulAntarTindakan: idKonsulAntarTindakan,
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
                $('.titleTindakan').html('Daftar Tindakan');
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
                judulnotifikasi: 'Pasien Rujukan Tindakan',
                isinotifikasi: '<?php echo $modPasien->nama_pasien ?> dengan <?php echo $modPasien->no_rekam_medik ?> telah dirujuk pada <?php echo $modKirimKeUnitLain->tgl_kirimpasien ?> dari <?php echo $modKirimKeUnitLain->ruangan->ruangan_nama ?>'
            }; // 16 
            insert_notifikasi(params);
        <?php
        }
        ?>
        <?php
        if (isset($_GET['idKonsulTindakan'])) {
        ?>
            var params = [];
            params = {
                instalasi_id: <?php echo Yii::app()->user->getState("instalasi_id"); ?>,
                modul_id: <?php echo Params::MODUL_ID_RJ ?>,
                judulnotifikasi: 'Pasien Tindakan',
                isinotifikasi: 'Pasien <?php echo $modPasien->nama_pasien ?> dengan nomor rekam medik <?php echo $modPasien->no_rekam_medik ?> telah dikonsul ke <?php echo $modKonsulPoli->ruangtujuan->ruangan_nama ?> pada <?php echo $modKonsulPoli->tglordertindakan ?> dari <?php echo $modKonsulPoli->ruangasal->ruangan_nama ?>'
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

       $(document).ready(function() {
           
           var pegawai = jQuery('#<?php echo CHtml::activeId($modKonsul, 'pegawai_id') ?>');	
           jQuery(pegawai).multiselect({
                   includeSelectAllOption: false,
                   buttonClass: "form-control",
                   maxHeight: 300,
                   buttonWidth: '182px',
                   enableCaseInsensitiveFiltering: true
           }).hide();
       });


    function checkAll() {
        if ($('#checkAllRuangan').is(':checked')) {
            $('#searchKonsulTindakan input[name*="ruangan_id"]').each(function() {
                $(this).attr('checked', true);
            });
        } else {
            $('#searchKonsulTindakan input[name*="ruangan_id"]').each(function() {
                $(this).removeAttr('checked');
            });
        }
    }
</script>
<div class="form-actions">
    <?php // echo CHtml::htmlButton(
       // Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="' . MyIcon::getIcons('simpan') . '"></i>')),
      //  array('class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'id' => 'btn_simpan')
   // ); ?>
    <?php
    // if (isset($_GET['idKonsulTindakan'])) {
    //     echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')')) . "&nbsp";
    //     echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
    //     echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
    // } else {
    //     echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'disabled' => 'disabled')) . "&nbsp";
    //     echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'disabled' => 'disabled'));
    //     echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'disabled' => 'disabled'));
    // }
    ?>
    <?php
  //  $content = $this->renderPartial('rawatJalan.views.tips.tips', array(), true);
   // $this->widget('UserTips', array('type' => 'admin', 'content' => $content));
    $idKonsulTindakan = isset($_GET['idKonsulTindakan']) ? $_GET['idKonsulTindakan'] : null;
    $urlPrint = Yii::app()->createAbsoluteUrl($this->module->id . '/' . $this->id . '/print&id=' . $modPendaftaran->pendaftaran_id . '&idKonsulTindakan=' . $idKonsulTindakan);
    $urlPrintRiwayat = Yii::app()->createAbsoluteUrl($this->module->id . '/' . $this->id . '/printRiwayat&id=' . $modPendaftaran->pendaftaran_id);
    $urlPrintPermintaan = Yii::app()->createAbsoluteUrl($this->module->id . '/' . $this->id . '/print&id=' . $modPendaftaran->pendaftaran_id);
    $js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}&caraPrint="+caraPrint,"",'location=_new, width=460px');
    console.log('kesini 2);
}
function printRiwayat(caraPrint)
{
    window.open("${urlPrintRiwayat}&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
function printPermintaan(idKonsulTindakan)
{
    window.open("${urlPrintPermintaan}&idKonsulTindakan="+idKonsulTindakan+"&caraPrint="+"PRINT","",'location=_new, width=460px');
}
JSCRIPT;
    Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
    ?>
</div>
<?php } else { ?>
    <div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Tabel <b>Riwayat Order Tindakan Pasien</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php $this->renderPartial($this->path_view . '_listRuangTindakan', array('modRiwayatPasienKeunitLain' => $modRiwayatPasienKeunitLain)); ?>
    </div>
</div>
<!--</div>-->
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'searchKonsulTindakan',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('enctype' => 'multipart/form-data','onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#' . CHtml::activeId($modKirimKeUnitLain, 'ruangan_id'),
)); ?>

<div class="antirow">
    <div class="row">
        <!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') 
                                    ?></p>-->
        <?php echo $form->errorSummary(array($modKirimKeUnitLain, $modelPendaftaran)); ?>
        <?php echo CHtml::hiddenField('url', $this->createUrl('', array('pendaftaran_id' => $modPendaftaran->pendaftaran_id)), array('readonly' => TRUE)); ?>
        <?php echo CHtml::hiddenField('berubah', '', array('readonly' => TRUE)); ?>
        <div class="col-sm-6">
            <?php echo $form->dropDownListRow(
                $modKirimKeUnitLain,
                'ruangan_id',
                CHtml::listData(RuangantindakanV::model()->findAllByAttributes(array('ruangan_aktif'=>true), array('order'=>'ruangan_nama ASC')), 'ruangan_id', 'ruangan_nama'),
                array('empty' => '-- Pilih --', 'class' => 'form-control span3', 'onkeypress' => "return $(this).focusNextInputField(event);",
                // 'multiple' => 'multiple',
               // 'readonly' => true,
                'onchange' => 'setTarif()')
            );
            ?>
            <div class="control-group">
                <?php echo Chtml::label('Tanggal Permintaan', 'tgl_kirimpasien', array('class' => 'control-label')) ?>
                <?php $modKirimKeUnitLain->tgl_kirimpasien = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modKirimKeUnitLain->tgl_kirimpasien, 'yyyy-MM-dd hh:mm:ss', 'medium', null)); ?>
                <div class="controls">
                    <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $modKirimKeUnitLain,
                        'attribute' => 'tgl_kirimpasien',
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
            
            <div class="control-gruop">
                <?php echo CHtml::label('Dokter DPJP', '', ['class' => 'control-label']); ?>
                
                <div class="controls">
                    <?php
                    echo $form->dropDownList(
                        $modKirimKeUnitLain,
                        'pegawai_id',
                        CHtml::listData(PegawairuanganV::model()->findAll('kelompokpegawai_id ='.Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK.' and ruangan_id='.Yii::app()->user->getState('ruangan_id')), 'pegawai_id', 'NamaLengkap'),
                        array( 'class' => 'span3 dokter-konsul', 
                        'onkeypress' => "return $(this).focusNextInputField(event);", 'empty' => '-- Pilih --')
                    ); ?>
                </div>
            </div>
            <br><br><br>
            <div class="control-gruop">
                <?php echo CHtml::label('PPDS', '', ['class' => 'control-label']); ?>
                <div class="controls">
                    <?php echo $form->dropDownList(
                        $modKirimKeUnitLain,
                        'ppds_id',
                        CHtml::listData(PpdsM::model()->findAll("t.ppds_aktif is TRUE AND t.ppds_status = 'AKTIF' order by ppds_nama ASC"), 'ppds_id', 'ppds_nama'),
                        array('empty' => '-- Pilih --', 'class' => 'span3 dokter-konsul', 'onkeypress' => "return $(this).focusNextInputField(event);")
                    ); ?>
                </div>
            </div>
            <br><br><br>
            

            <div class="control-gruop">
                <?php echo CHtml::label('Catatan Permintaan', '', ['class' => 'control-label']); ?>
                <div class="controls">
                    <?php echo $form->textArea($modKirimKeUnitLain, 'catatandokterpengirim') ?>
                </div>
            </div>
           
           
        </div>
       
    </div>

    <!-- <div style="line-height: 250px;">
          .          
    </div> -->
    
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
        'title' => 'Detail Tindakan',
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
        'title' => 'Hasil Pemeriksaan Tindakan',
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
    function viewDetailKonsul(idKonsulAntarTindakan) {
        $.post('<?php echo $this->createUrl('ajaxDetailKonsul') ?>', {
            idKonsulAntarTindakan: idKonsulAntarTindakan
        }, function(data) {
            $('#contentDetailKonsul').html(data.result);
        }, 'json');
        $('#dialogDetailKonsul').dialog('open');
    }

    function viewDetailKonsulHasil(idKonsulAntarTindakan) {
        $.post('<?php echo $this->createUrl('ajaxDetailKonsulHasil') ?>', {
            idKonsulAntarTindakan: idKonsulAntarTindakan
        }, function(data) {
            $('#contentDetailKonsulHasil').html(data.result);
        }, 'json');
        $('#dialogDetailKonsulHasil').dialog('open');
    }

    function batalKonsul(idKonsulAntarTindakan, pendaftaran_id) {
        myConfirm("Apakah Anda akan membatalkan konsul ini?", "Perhatian!", function(r) {
            if (r) {
                $.post('<?php echo $this->createUrl('ajaxBatalKonsul') ?>', {
                    idKonsulAntarTindakan: idKonsulAntarTindakan,
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
                $('.titleTindakan').html('Daftar Tindakan');
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
                judulnotifikasi: 'Pasien Rujukan Tindakan',
                isinotifikasi: '<?php echo $modPasien->nama_pasien ?> dengan <?php echo $modPasien->no_rekam_medik ?> telah dirujuk pada <?php echo $modKirimKeUnitLain->tgl_kirimpasien ?> dari <?php echo $modKirimKeUnitLain->ruangan->ruangan_nama ?>'
            }; // 16 
            insert_notifikasi(params);
        <?php
        }
        ?>
        
        <?php
        if (isset($_GET['idKonsulTindakan'])) {
        ?>
            var params = [];
            params = {
                instalasi_id: <?php echo Yii::app()->user->getState("instalasi_id"); ?>,
                modul_id: <?php echo Params::MODUL_ID_RJ ?>,
                judulnotifikasi: 'Pasien Tindakan',
                isinotifikasi: 'Pasien <?php echo $modPasien->nama_pasien ?> dengan nomor rekam medik <?php echo $modPasien->no_rekam_medik ?> telah dikonsul ke <?php echo $modKonsulPoli->ruangtujuan->ruangan_nama ?> pada <?php echo $modKonsulPoli->tglordertindakan ?> dari <?php echo $modKonsulPoli->ruangasal->ruangan_nama ?>'
            }; // 16 
            insert_notifikasi(params);
        <?php
        }
        ?>
    });

    $(document).ready(function() {
           
           var ruangan = jQuery('#<?php echo CHtml::activeId($modKirimKeUnitLain, 'ruangan_id') ?>');	
           jQuery(ruangan).multiselect({
                   includeSelectAllOption: true,
                   buttonClass: "form-control",
                   maxHeight: 300,
                   buttonWidth: '182px',
                   enableCaseInsensitiveFiltering: true
           }).hide();
       });

       $(document).ready(function() {
           
           var pegawai = jQuery('#<?php echo CHtml::activeId($modKonsul, 'pegawai_id') ?>');	
           jQuery(pegawai).multiselect({
                   includeSelectAllOption: false,
                   buttonClass: "form-control",
                   maxHeight: 300,
                   buttonWidth: '182px',
                   enableCaseInsensitiveFiltering: true
           }).hide();
       });


       $(document).ready(function() {
        var ppds = jQuery('#<?php echo CHtml::activeId($modKirimKeUnitLain, 'ppds_id') ?>');
    jQuery(ppds).multiselect({
        includeSelectAllOption: false,
        buttonClass: "form-control",
        maxHeight: 300,
        buttonWidth: '265px',
        enableCaseInsensitiveFiltering: true
    }).hide();
    
});
$(document).ready(function() {
        var dpjp = jQuery('#<?php echo CHtml::activeId($modKirimKeUnitLain, 'pegawai_id') ?>');
    jQuery(dpjp).multiselect({
        includeSelectAllOption: false,
        buttonClass: "form-control",
        maxHeight: 300,
        buttonWidth: '265px',
        enableCaseInsensitiveFiltering: true
    }).hide();
    
});

    function checkAll() {
        if ($('#checkAllRuangan').is(':checked')) {
            $('#searchKonsulTindakan input[name*="ruangan_id"]').each(function() {
                $(this).attr('checked', true);
            });
        } else {
            $('#searchKonsulTindakan input[name*="ruangan_id"]').each(function() {
                $(this).removeAttr('checked');
            });
        }
    }
</script>
<div class="form-actions">
    <?php if (isset($_GET['lihat'])) { ?>
        <?php echo ""; ?>
    <?php }else{ ?>
        <?php 
            echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="' . MyIcon::getIcons('simpan') . '"></i>')),
            array('class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'id' => 'btn_simpan', 'disabled' => isset($_GET['sukses']) ? true : false)); 
        ?>
        <?php
        if (isset($_GET['idKonsulTindakan'])) {
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')')) . "&nbsp";
            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
        } else {
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'disabled' => 'disabled')) . "&nbsp";
            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'disabled' => 'disabled'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'disabled' => 'disabled'));
        }
        ?>
    <?php }?>
    <?php
    $content = $this->renderPartial('rawatJalan.views.tips.tips', array(), true);
    $this->widget('UserTips', array('type' => 'admin', 'content' => $content));
    $idKonsulTindakan = isset($_GET['idKonsulTindakan']) ? $_GET['idKonsulTindakan'] : null;
    $urlPrint = Yii::app()->createAbsoluteUrl($this->module->id . '/' . $this->id . '/print&id=' . $modPendaftaran->pendaftaran_id . '&idKonsulTindakan=' . $idKonsulTindakan);
    $urlPrintRiwayat = Yii::app()->createAbsoluteUrl($this->module->id . '/' . $this->id . '/printRiwayat&id=' . $modPendaftaran->pendaftaran_id);
    $urlPrintPermintaan = Yii::app()->createAbsoluteUrl($this->module->id . '/' . $this->id . '/print&id=' . $modPendaftaran->pendaftaran_id);
    $js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}&caraPrint="+caraPrint,"",'location=_new, width=460px');
    console.log('kesini');
}
function printRiwayat(caraPrint)
{
    window.open("${urlPrintRiwayat}&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
function printPermintaan(permintaankirimkeunitlain_id)
{
    window.open("${urlPrintPermintaan}&permintaankirimkeunitlain_id="+permintaankirimkeunitlain_id+"&caraPrint="+"PRINT","",'location=_new, width=460px');
}
JSCRIPT;
    Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
    ?>
</div>

<?php $this->endWidget(); ?>

<?php  } ?>
