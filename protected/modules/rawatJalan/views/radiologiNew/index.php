<style>
    .integer {
        text-align: right;
    }

    .icons {
        margin-left: 180px;
        float: right;
    }

    .col-acc {
        height: 300px !important;
    }

    .label_nama_periksa {
        width: calc(100% - 30px);
        display: inline-block;
    }

    .label_tarif {
        width: 20px;
        display: inline-block;
    }
</style>
<?php


$pg_login = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
$pg_loginpps = PpdsM::model()->findByPk(Yii::app()->user->getState('ppds_id'));

$modul_id = Yii::app()->user->getState('modul_id');
// $readonly = $pg_login->kelompokpegawai_id == 2 && $modul_id != 7;
if(!empty($pg_login->kelompokpegawai_id)){
    // var_dump('as');die;
    $readonly = $pg_login->kelompokpegawai_id == 2 && $modul_id != 7;
}
if (!empty($pg_loginpps->kelompokpegawai_id)){
    // var_dump('as2');die;
    $readonly = $pg_loginpps->kelompokpegawai_id == 2 && $modul_id != 7;

}
$hide = $readonly ? " hide" : "";
$hidden = $readonly ? " hidden" : "";
$display = "display:" . ($readonly ? " none;" : "block;");
$visibility = "visibility:" . ($readonly ? " visible; " : "hidden; ");

$this->breadcrumbs = array(
    'Radiologi',
);

if (isset($_GET['sukses'])) {
    Yii::app()->user->setFlash('success', "Data berhasil disimpan!");
}
$this->widget('bootstrap.widgets.BootAlert');
?>

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.tiler.js'); ?>

<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'rjpasien-radiologi-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#' . CHtml::activeId($modKirimKeUnitLain, 'catatandokterpengirim'),
    'htmlOptions' => array(
        'onKeyPress' => 'return disableKeyPress(event)',
        'onsubmit' => 'return requiredCheck(this);'
    ),
)); ?>
<?php
$loginpemakai = Yii::app()->user->id;
$criteria = new CDbCriteria;
$criteria->addCondition('loginpemakai_id = ' . $loginpemakai);
$pegawai = LoginpemakaiK::model()->find($criteria);
$kelPegawai = PegawaiM::model()->findByPk($pegawai->pegawai_id);
$kelPegawaippds = PpdsM::model()->findByPk($pegawai->ppds_id);

if($kelPegawai != null){


    if ((!empty($kelPegawai->loginpemakai_id == Yii::app()->user->getState('loginpemakai_id')) && !empty($kelPegawai->kelompokpegawai_id == Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN))) {
?>


        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Riwayat Pemeriksaan Radiologi Pasien</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <div class="block-tabel">
                    <?php $this->renderPartial($this->path_view . '_listKiriimKeUnitLain2', array('modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain)) ?>
                    <div class="control-group">
                        <?php #endregion
                        //echo ''; var_dump($modPendaftaran); die;
                        ?>

                    </div>
                </div>
            </div>
        </div>


        <?php
        // $tips = array(
        //     '0' => 'simpan',
        //     '1' => 'print',
        // );
        // $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
        // $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));

        $idPasienKirimKeUnitLain = isset($_GET['idPasienKirimKeUnitLain']) ? $_GET['idPasienKirimKeUnitLain'] : null;
        $urlPrint = Yii::app()->createAbsoluteUrl($this->module->id . '/' . $this->id . '/print&id=' . $modPendaftaran->pendaftaran_id . '&idPasienKirimKeUnitLain=' . $idPasienKirimKeUnitLain);
        $urlPrintRiwayat = Yii::app()->createAbsoluteUrl($this->module->id . '/' . $this->id . '/printRiwayat&id=' . $modPendaftaran->pendaftaran_id);
        $urlPrintPermintaan = Yii::app()->createAbsoluteUrl($this->module->id . '/' . $this->id . '/print&id=' . $modPendaftaran->pendaftaran_id);
        $js = <<< JSCRIPT
			function print(caraPrint){
				window.open("${urlPrint}&caraPrint="+caraPrint,"",'location=_new, width=460px');
			}
			function printRiwayat(caraPrint){
				window.open("${urlPrintRiwayat}&caraPrint="+caraPrint,"",'location=_new, width=900px');
			}
			function printPermintaan(idPasienKirimKeUnitLain){
				window.open("${urlPrintPermintaan}&idPasienKirimKeUnitLain="+idPasienKirimKeUnitLain+"&caraPrint="+"PRINT","",'location=_new, width=460px');
			}
JSCRIPT;
        Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
        ?>
        </div>
        </div>
        <?php $this->endWidget(); ?>
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
        <script>
            function batalPeriksa(idPemeriksaanrad) {
                $('#tblFormPemeriksaanRad #periksarad_' + idPemeriksaanrad).detach();
                if ($('#tblFormPemeriksaanRad tr').length == 1)
                    $('#tblFormPemeriksaanRad').append('<tr id="trPeriksaRadKosong"><td colspan="4"></td></tr>');
            }

            function batalKirim(pasienkirimkeunitlain_id, pasien_id, is_bisa = true) {
                if(is_bisa) {
                myConfirm("Apakah Anda akan membatalkan kirim pasien ke Radiologi?", "Perhatian!", function(r) {
                    if (r) {
                        $.post('<?php echo $this->createUrl('ajaxBatalKirim') ?>', {
                            pasienkirimkeunitlain_id: pasienkirimkeunitlain_id,
                            pasien_id: pasien_id
                        }, function(data) {
                            $('#tblListPemeriksaanRad').html(data.result);
                            myAlert(data.pesan);
                            location.replace(
                                '<?php echo $this->createUrl('index') ?>&pendaftaran_id=<?php echo $_GET['pendaftaran_id'] ?>'
                            );
                        }, 'json');
                    }
                }); } else {
                    myAlert("Anda tidak memiliki akses");
                }
            }

            function hitungTotal() {
                var total = 0;
                $('.tarif_satuan').each(
                    function() {
                        qty = $(this).parents('tr').find('.qty').val();
                        total += unformatNumber(this.value) * qty;
                    }
                );
                $('#periksaTotal').val(formatNumber(total));
            }

            function cekInput() {
                if (requiredCheck($("#rjpasien-radiologi-t-form"))) {
                    //var deposit = $('#deposit').val();
                    var periksaTotal = unformatNumber($('#periksaTotal').val());
                    var tr = $("#tblFormPemeriksaanRad > tbody > tr").length;
                    if (tr > 0) {
                        $('#rjpasien-radiologi-t-form').submit();
                    } else {
                        alert("Tindakan Radiologi belum dipilih");
                        return false;
                    }
                }
                return false;
            }

            // function setTrue(obj) {

            //     var cito = $(obj).is(':checked');

            //     if (cito) {
            //         $(obj).closest('td').find('.apa-cito').val("ya");
            //     } else {
            //         $(obj).closest('td').find('.apa-cito').val("tidak");

            //     }
            // }


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
                        modul_id: <?php echo Params::MODUL_ID_RAD ?>,
                        judulnotifikasi: 'Pasien Rujukan',
                        isinotifikasi: '<?php echo $modPasien->nama_pasien ?> dengan <?php echo $modPasien->no_rekam_medik ?> telah dirujuk pada <?php echo $modKirimKeUnitLain->tgl_kirimpasien ?> dari <?php echo $modKirimKeUnitLain->ruangan->ruangan_nama ?>'
                    }; // 16 
                    insert_notifikasi(params);
                <?php
                }
                ?>

                <?php $r = RuanganM::model()->find(' instalasi_id = ' . Params::INSTALASI_ID_RAD . ' and ruangan_id is not null order by ruangan_nourut') ?>

                <?php if (!isset($_GET['idPasienKirimKeUnitLain'])) : ?>
                    $('#RJPasienKirimKeUnitLainT_ruangan_id').val(<?= $r->ruangan_id ?>);
                <?php endif; ?>


                var ppds = jQuery('#<?php echo CHtml::activeId($modKirimKeUnitLain, 'ppds_id') ?>');
                jQuery(ppds).multiselect({
                    includeSelectAllOption: false,
                    buttonClass: "form-control",
                    maxHeight: 300,
                    buttonWidth: '182px',
                    enableCaseInsensitiveFiltering: true
                }).hide();
            });
        </script>
    <?php } else if ((!empty($kelPegawai->loginpemakai_id == Yii::app()->user->getState('loginpemakai_id')) && !empty($kelPegawai->kelompokpegawai_id == Params::KELOMPOKPEGAWAI_ID_DOKTER_UMUM))) { ?>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Riwayat Pemeriksaan Radiologi Pasien</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <div class="block-tabel">
                    <?php $this->renderPartial($this->path_view . '_listKiriimKeUnitLain2', array('modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain)) ?>
                    <div class="control-group">
                        <?php #endregion
                        //echo ''; var_dump($modPendaftaran); die;
                        ?>

                    </div>
                </div>
            </div>
        </div>


        <?php
        // $tips = array(
        //     '0' => 'simpan',
        //     '1' => 'print',
        // );
        // $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
        // $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));

        $idPasienKirimKeUnitLain = isset($_GET['idPasienKirimKeUnitLain']) ? $_GET['idPasienKirimKeUnitLain'] : null;
        $urlPrint = Yii::app()->createAbsoluteUrl($this->module->id . '/' . $this->id . '/print&id=' . $modPendaftaran->pendaftaran_id . '&idPasienKirimKeUnitLain=' . $idPasienKirimKeUnitLain);
        $urlPrintRiwayat = Yii::app()->createAbsoluteUrl($this->module->id . '/' . $this->id . '/printRiwayat&id=' . $modPendaftaran->pendaftaran_id);
        $urlPrintPermintaan = Yii::app()->createAbsoluteUrl($this->module->id . '/' . $this->id . '/print&id=' . $modPendaftaran->pendaftaran_id);
        $js = <<< JSCRIPT
			function print(caraPrint){
				window.open("${urlPrint}&caraPrint="+caraPrint,"",'location=_new, width=460px');
			}
			function printRiwayat(caraPrint){
				window.open("${urlPrintRiwayat}&caraPrint="+caraPrint,"",'location=_new, width=900px');
			}
			function printPermintaan(idPasienKirimKeUnitLain){
				window.open("${urlPrintPermintaan}&idPasienKirimKeUnitLain="+idPasienKirimKeUnitLain+"&caraPrint="+"PRINT","",'location=_new, width=460px');
			}
JSCRIPT;
        Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
        ?>
        </div>
        </div>
        <?php $this->endWidget(); ?>
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
        <script>
            function inputperiksa(obj, ruangan_id, sub=null) { // console.log("sniff 1");
                if ($(obj).is(':checked')) {

                    $(obj).trigger('change');

                    var pemeriksaanrad_id = obj.value;
                    var kelaspelayanan_id = $('.kelaspelayanan')
                        .val() //$('#<?php //echo CHtml::activeId($modKirimKeUnitLain, 'kelaspelayanan_id') 
                                        ?>').val();
                    var pendaftaran_id = '<?php echo $modPendaftaran->pendaftaran_id; ?>';
                    if (kelaspelayanan_id === '') {
                        myAlert("Silakan pilih kelas pelayanan terlebih dahulu!");
                        $(obj).attr('checked', false);
                        return false;
                    }

                    ajaxinputperiksa(pemeriksaanrad_id, kelaspelayanan_id, pendaftaran_id, obj);

                    if(sub !== null) {

                        $('.sub-' + sub).find('input[type="checkbox"]').each(function() {

                            pemeriksaanrad_id = $(this).val();

                            if($(this).is(':checked') === false) {
                                $(this).prop('checked', 'checked');
                                ajaxinputperiksa(pemeriksaanrad_id, kelaspelayanan_id, pendaftaran_id, $(this));
                            }
                            
                        });

                        var kelas = $(obj);
                        console.log('kelas sub: ' . kelas);

                    }

                    console.log('kelas', kelaspelayanan_id);
                    
                } else {
                    batalPeriksa(obj.value);
                    if(sub !== null) {
                        $('.sub-' + sub).find('input[type="checkbox"]').each(function() {

                            if($(this).is(':checked')) {
                                $(this).prop('checked', false);
                                batalPeriksa($(this).val());
                                hitungTotal();
                            }

                        });

                    } else {
                        hitungTotal();
                    }

                    //        myConfirm("Apakah Anda akan membatalkan pemeriksaan ini?","Perhatian!",function(r) {
                    //            if(r){
                    //                batalPeriksa(obj.value);
                    //                hitungTotal();
                    //            }else{
                    //                $(obj).attr('checked', 'checked');
                    //            }
                    //        });
                }
            }

            function ajaxinputperiksa(pemeriksaanrad_id, kelaspelayanan_id, pendaftaran_id, obj = null) {
                jQuery.ajax({
                    'url': '<?php echo Yii::app()->createUrl('rawatJalan/radiologiNew/loadFormPemeriksaanRad') ?>',
                    'data': {
                        pemeriksaanrad_id: pemeriksaanrad_id,
                        kelaspelayanan_id: kelaspelayanan_id,
                        pendaftaran_id: pendaftaran_id
                    },
                    'type': 'post',
                    'dataType': 'json',
                    'success': function(data) {
                        if (data.form == '') {
                            $(obj).removeAttr("checked");
                            myAlert(
                                "Pemeriksaan belum memilik tarif silakan hubungi SIMRS untuk memeriksa tarif pemeriksaan tersebut"
                            );
                        }
                        $('#tblFormPemeriksaanRad #trPeriksaRadKosong').detach();
                        $('#tblFormPemeriksaanRad > tbody').append(data.form);
                        $("#tblFormPemeriksaanRad > tbody > tr:last .integer").maskMoney({
                            "defaultZero": true,
                            "allowZero": true,
                            "decimal": ",",
                            "thousands": ".",
                            "precision": 0,
                            "symbol": null
                        });
                        $('.integer').each(function() {
                            this.value = formatNumber(this.value)
                        });
                        //                         $('.integer').parent().detach(); // hapus kolom tarif
                        hitungTotal();
                    },
                    'cache': false
                });
            }

            function batalPeriksa(idPemeriksaanrad) {
                $('#tblFormPemeriksaanRad #periksarad_' + idPemeriksaanrad).detach();
                if ($('#tblFormPemeriksaanRad tr').length == 1)
                    $('#tblFormPemeriksaanRad').append('<tr id="trPeriksaRadKosong"><td colspan="4"></td></tr>');
            }

            function batalKirim(pasienkirimkeunitlain_id, pasien_id, is_bisa = true) {
                if(is_bisa) {
                myConfirm("Apakah Anda akan membatalkan kirim pasien ke Radiologi?", "Perhatian!", function(r) {
                    if (r) {
                        $.post('<?php echo $this->createUrl('ajaxBatalKirim') ?>', {
                            pasienkirimkeunitlain_id: pasienkirimkeunitlain_id,
                            pasien_id: pasien_id
                        }, function(data) {
                            $('#tblListPemeriksaanRad').html(data.result);
                            myAlert(data.pesan);
                            location.replace(
                                '<?php echo $this->createUrl('index') ?>&pendaftaran_id=<?php echo $_GET['pendaftaran_id'] ?>'
                            );
                        }, 'json');
                    }
                }); } else {
                    myAlert("Anda tidak memiliki akses");
                }
            }

            function hitungTotal() {
                var total = 0;
                $('.tarif_satuan').each(
                    function() {
                        qty = $(this).parents('tr').find('.qty').val();
                        total += unformatNumber(this.value) * qty;
                    }
                );
                $('#periksaTotal').val(formatNumber(total));
            }

            function cekInput() {
                if (requiredCheck($("#rjpasien-radiologi-t-form"))) {
                    //var deposit = $('#deposit').val();
                    var periksaTotal = unformatNumber($('#periksaTotal').val());
                    var tr = $("#tblFormPemeriksaanRad > tbody > tr").length;
                    if (tr > 0) {
                        $('#rjpasien-radiologi-t-form').submit();
                    } else {
                        alert("Tindakan Radiologi belum dipilih");
                        return false;
                    }
                }
                return false;
            }

            // function setTrue(obj) {

            //     var cito = $(obj).is(':checked');

            //     if (cito) {
            //         $(obj).closest('td').find('.apa-cito').val("ya");
            //     } else {
            //         $(obj).closest('td').find('.apa-cito').val("tidak");

            //     }
            // }


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
                        modul_id: <?php echo Params::MODUL_ID_RAD ?>,
                        judulnotifikasi: 'Pasien Rujukan',
                        isinotifikasi: '<?php echo $modPasien->nama_pasien ?> dengan <?php echo $modPasien->no_rekam_medik ?> telah dirujuk pada <?php echo $modKirimKeUnitLain->tgl_kirimpasien ?> dari <?php echo $modKirimKeUnitLain->ruangan->ruangan_nama ?>'
                    }; // 16 
                    insert_notifikasi(params);
                <?php
                }
                ?>

                <?php $r = RuanganM::model()->find(' ruangan_id in (' . Params::RUANGAN_ID_RAD . ') order by ruangan_nourut') ?>

                <?php if (!isset($_GET['idPasienKirimKeUnitLain'])) : ?>
                    $('#RJPasienKirimKeUnitLainT_ruangan_id').val(<?= $r->ruangan_id ?>);
                <?php endif; ?>


                var ppds = jQuery('#<?php echo CHtml::activeId($modKirimKeUnitLain, 'ppds_id') ?>');
                jQuery(ppds).multiselect({
                    includeSelectAllOption: false,
                    buttonClass: "form-control",
                    maxHeight: 300,
                    buttonWidth: '182px',
                    enableCaseInsensitiveFiltering: true
                }).hide();
            });
        </script>
    <?php } else { ?>


        <?php echo $form->errorSummary($modKirimKeUnitLain);
        echo $form->hiddenField($modKirimKeUnitLain, 'kelaspelayanan_id', array('class' => 'kelaspelayanan'));
        ?>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Riwayat Pemeriksaan Radiologi Pasien</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <div class="block-tabel">
                    <?php 
                        if(isset($_GET['lihat'])) {
                            $this->renderPartial($this->path_view . '_listKirimKeUnitLain2', array('modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain));
                        } else {
                            $this->renderPartial($this->path_view . '_listKirimKeUnitLain', array('modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain));
                            
                        }
                    ?>
                   
                </div>
            </div>
        </div>


<div class="row" <?=$hidden?>>
    <div class="col-sm-12">


                <div id="form-caripemeriksaan" class="col-sm-12 form-horizontal" style="margin-bottom: 30px;">
                    <br>



                    <div class="row">
                        <!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') 
                                                    ?></p>-->
                        <?php //echo CHtml::hiddenField('url',$this->createUrl('',array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id)),array('readonly'=>TRUE));
                        ?>
                        <?php //echo CHtml::hiddenField('berubah','',array('readonly'=>TRUE));
                        ?>
                        <div class="col-sm-6">
                            <div class="control-group">
                                <label class="control-label required" for="RJPasienKirimKeUnitLainT_tgl_kirimpasien">
                                    Tanggal Permintaan
                                    <span class="required">*</span>
                                </label>
                                <?php $modKirimKeUnitLain->tgl_kirimpasien = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modKirimKeUnitLain->tgl_kirimpasien, 'yyyy-MM-dd hh:mm:ss', 'medium', null)); ?>
                                <div class="controls">
                                    <?php
                                    $this->widget('MyDateTimePicker', array(
                                        'model' => $modKirimKeUnitLain,
                                        'attribute' => 'tgl_kirimpasien',
                                        'mode' => 'datetime',
                                        'options' => array(
                                            'dateFormat' => Params::DATE_FORMAT,
                                        ),
                                        'htmlOptions' => array('readonly' => true, 'class' => 'span3'),
                                    ));
                                    ?>
                                </div>
                                <div class="controls hide">
                                    <?php echo $form->checkBox($modKirimKeUnitLain, 'is_elektif', array('id' => 'is_elektif')); ?>
                                    <label for="is_elektif">Pemeriksaan Elektif</label>
                                </div>
                            </div>

                            <div class="control-group hide">
                                <label class="control-label required" for="RJPasienKirimKeUnitLainT_tgl_kirimpasien">
                                    Tgl Rencana Pemeriksaan
                                    <span class="required">*</span>
                                </label>

                                <div class="controls">
                                    <?php
                                    $modKirimKeUnitLain->tglrencanapemeriksaan = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modKirimKeUnitLain->tglrencanapemeriksaan, 'yyyy-MM-dd hh:mm:ss', 'medium', null));

                                    $this->widget('MyDateTimePicker', array(
                                        'model' => $modKirimKeUnitLain,
                                        'attribute' => 'tglrencanapemeriksaan',
                                        'mode' => 'datetime',
                                        'options' => array(
                                            'dateFormat' => Params::DATE_FORMAT,
                                        ),
                                        'htmlOptions' => array('readonly' => true, 'class' => 'col-sm-8'),
                                    )); ?>
                                </div>
                            </div>



                            <?php echo $form->dropDownListRow(
                                $modKirimKeUnitLain,
                                'pegawai_id',
                                CHtml::listData($modKirimKeUnitLain->getDokterItems(), 'pegawai_id', 'NamaLengkap'),
                                array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")
                            );
                            ?>

                            <?php
                            echo $form->dropDownListRow(
                                $modKirimKeUnitLain,
                                'ppds_id',
                                CHtml::listData($modKirimKeUnitLain->getPPDS(), 'ppds_id', 'ppds_nama'),
                                array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")
                            );
                            ?>
                            <div class="control-group">
                                <?php echo CHtml::Label('Jenis Pelayanan', 'jenispemeriksaanrad_id', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php echo $form->dropDownList($modKirimKeUnitLain, 'ruangan_id', CHtml::listData(RuanganM::model()->findAll('ruangan_id in (' . Params::RUANGAN_ID_RAD . ') order by ruangan_nama'), 'ruangan_id', 'ruangan_nama'), array('empty' => '-- Pilih --', 'class' => 'span3')); ?>
                                </div>
                            </div>



                            <?php echo $form->textAreaRow($modKirimKeUnitLain, 'catatandokterpengirim', array('placeholder' => 'Catatan', 'onkeypress' => "return $(this).focusNextInputField(event);")) ?>
                            <?php echo CHtml::hiddenField("form_index", null, array('readonly' => true)); ?>
                            <?php echo CHtml::hiddenField('periksaTotal', '', array('class' => 'span2', 'style' => 'text-align:right;', 'disabled' => 'disabled')); ?>
                            <div class="control-group">
                                <?php echo CHtml::activeLabel($modPemeriksaanRad, 'jenispemeriksaanrad_id', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php echo CHtml::activeDropDownList($modPemeriksaanRad, 'jenispemeriksaanrad_nama', CHtml::listData(JenispemeriksaanradM::model()->findAll(array(
                                        'condition' => 'jenispemeriksaanrad_aktif = true',
                                        'order' => 'jenispemeriksaanrad_urutan',
                                    )), 'jenispemeriksaanrad_nama', 'jenispemeriksaanrad_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)", "onchange" => "updateChecklistPemeriksaanRad();", 'placeholder' => 'Nama Jenis Pemeriksaan Radiologi',)); ?>
                                </div>
                                <div class="controls hide">
                                    <?php echo $form->checkBox($modPemeriksaanRad, 'is_paket', array('id' => 'is_paket', "onchange" => "updateChecklistPemeriksaanRad();")); ?>
                                    <label for="is_paket">Paket</label>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo CHtml::activeLabel($modPemeriksaanRad, 'pemeriksaanrad_id', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php echo CHtml::hiddenfield('kelaspelayanan_id', $modPendaftaran->kelaspelayanan_id) ?>
                                    <?php echo CHtml::hiddenfield('carabayar_id', $modPendaftaran->carabayar_id) ?>
                                    <?php echo CHtml::hiddenfield('penjamin_id', $modPendaftaran->penjamin_id) ?>
                                    <?php echo CHtml::activeTextField($modPemeriksaanRad, 'pemeriksaanrad_nama', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)", "onchange" => "updateChecklistPemeriksaanRad();", 'placeholder' => 'Nama Pemeriksaan Radiologi', 'style' => 'font-family: Arial, Helvetica, sans-serif;')); ?>
                                    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', "onclick" => "updateChecklistPemeriksaanRad();", 'rel' => 'tooltip', 'title' => 'Klik untuk mencari pemeriksaan')); ?>
                                    <?php CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), array('class' => 'btn btn-default', 'type' => 'button', "onclick" => "setChecklistPemeriksaanLabReset();", 'rel' => 'tooltip', 'title' => 'Klik untuk mengulang pencarian')); ?>
                                </div>
                            </div>

                            <?php if (Yii::app()->user->getState('isbayarkekasirpenunjang') == true) { ?>
                                <div classs="control-group">
                                    <label class="control-label"></label>
                                    <div class="controls">
                                        <?php echo $form->checkBox($modKirimKeUnitLain, 'isbayarkekasirpenunjang', array('onkeyup' => "return $(this).focusNextInputField(event);", 'title' => "Pilih jika pasien harus membayar ke kasir terlebih dahulu sebelum periksa", 'rel' => 'tooltip')) ?>
                                        <label>Bayar ke Kasir</label>
                                    </div>

                                </div>
                            <?php } ?>
                        </div>


                        <div class="col-sm-6">
                            <div class="panel panel-success">
                                <div class="panel-heading">
                                    <div class="panel-title">
                                        <i class="entypo-credit-card"></i> Tabel <b>Pemeriksaan Radiologi
                                            <?php echo isset($modJenisTarif) ? "- " . $modJenisTarif->jenistarif->jenistarif_nama : ""; ?></b>
                                    </div>
                                </div>
                                <div class="panel-body table-responsive">
                                    <div class="block-tabel">
                                        <table id="tblFormPemeriksaanRad" class="table table-bordered table-condensed">
                                            <thead>
                                                <tr>
                                                    <th>Jenis Pemeriksaan</th>
                                                    <th>Pemeriksaan</th>
                                                    <th>Jumlah</th>
                                                    <th hidden>Tarif</th>
                                                    <th>Cito</th>
                                                    <th>Batal</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if (!$modKirimKeUnitLain->isNewRecord) {
                                                    $permintaan = PermintaankepenunjangT::model()->findAllByAttributes(array(
                                                        'pasienkirimkeunitlain_id' => $modKirimKeUnitLain->pasienkirimkeunitlain_id
                                                    ));

                                                    foreach ($permintaan as $item) {
                                                        echo $this->renderPartial('_formLoadPemeriksaanRadUpdate', array(
                                                            'item' => $item,
                                                        ), true);
                                                    }
                                                } ?>
                                                <!--<tr id="trPeriksaRadKosong"><td colspan="4"></td></tr>-->
                                            </tbody>
                                        </table>
                                        <table class="table table-bordered table-condensed">
                                            <tr>
                                                <td width="70%" style="text-align: right;">
                                                    <!--Total Biaya Pemeriksaan-->
                                                </td>
                                                <td><?php // echo CHtml::textField('periksaTotal', '', array('class' => 'span2', 'style' => 'text-align:right;', 'disabled' => 'disabled')); ?>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <script>
                                function deletePemeriksaan(obj) {
                                    myConfirm('Apakah Anda yakin akan membatalkan pemeriksaan tersebut?', 'Perhatian!', function(r) {
                                        if (r) {
                                            $(obj).parents('tr').detach();
                                            updateChecklistPemeriksaanRad();
                                        } else {
                                            return false;
                                        }
                                    });
                                }
                            </script>
                            <?php if(isset($_GET['lihat'])){?>
                            <div class="form-actions" hidden>
                                <?php echo CHtml::htmlButton(
                                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                                    array('class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'cekInput();', 'onKeypress' => 'return formSubmit(this,event)', 'id' => 'btn_simpan', 'disabled'=>$modPendaftaran->isPasienPulangAtauTindakLanjut($_GET['konsulpoli_id'] ?? null))
                                );
                                ?>
                                <?php
                                if (isset($_GET['idPasienKirimKeUnitLain'])) {
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
                                $tips = array(
                                    '0' => 'simpan',
                                    '1' => 'print',
                                );


                                $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
                                $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));

                                $idPasienKirimKeUnitLain = isset($_GET['idPasienKirimKeUnitLain']) ? $_GET['idPasienKirimKeUnitLain'] : null;
                                $urlPrint = Yii::app()->createAbsoluteUrl($this->module->id . '/' . $this->id . '/print&id=' . $modPendaftaran->pendaftaran_id . '&idPasienKirimKeUnitLain=' . $idPasienKirimKeUnitLain);
                                $urlPrintRiwayat = Yii::app()->createAbsoluteUrl($this->module->id . '/' . $this->id . '/printRiwayat&id=' . $modPendaftaran->pendaftaran_id);
                                $urlPrintPermintaan = Yii::app()->createAbsoluteUrl($this->module->id . '/' . $this->id . '/print&id=' . $modPendaftaran->pendaftaran_id);
                                $js = <<< JSCRIPT
			function print(caraPrint){
				window.open("${urlPrint}&caraPrint="+caraPrint,"",'location=_new, width=460px');
			}
			function printRiwayat(caraPrint){
				window.open("${urlPrintRiwayat}&caraPrint="+caraPrint,"",'location=_new, width=900px');
			}
			function printPermintaan(idPasienKirimKeUnitLain){
				window.open("${urlPrintPermintaan}&idPasienKirimKeUnitLain="+idPasienKirimKeUnitLain+"&caraPrint="+"PRINT","",'location=_new, width=460px');
			}
JSCRIPT;
                                Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
                                ?>
                            </div>
                            <?php }else{ ?>
                                <div class="form-actions" >
                                <?php echo CHtml::htmlButton(
                                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                                    array('class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'cekInput();', 'onKeypress' => 'return formSubmit(this,event)', 'id' => 'btn_simpan', 'disabled'=>$modPendaftaran->isPasienPulangAtauTindakLanjut($_GET['konsulpoli_id'] ?? null))
                                );
                                ?>
                                <?php
                                if (isset($_GET['idPasienKirimKeUnitLain'])) {
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
                                $tips = array(
                                    '0' => 'simpan',
                                    '1' => 'print',
                                );


                                $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
                                $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));

                                $idPasienKirimKeUnitLain = isset($_GET['idPasienKirimKeUnitLain']) ? $_GET['idPasienKirimKeUnitLain'] : null;
                                $urlPrint = Yii::app()->createAbsoluteUrl($this->module->id . '/' . $this->id . '/print&id=' . $modPendaftaran->pendaftaran_id . '&idPasienKirimKeUnitLain=' . $idPasienKirimKeUnitLain);
                                $urlPrintRiwayat = Yii::app()->createAbsoluteUrl($this->module->id . '/' . $this->id . '/printRiwayat&id=' . $modPendaftaran->pendaftaran_id);
                                $urlPrintPermintaan = Yii::app()->createAbsoluteUrl($this->module->id . '/' . $this->id . '/print&id=' . $modPendaftaran->pendaftaran_id);
                                $js = <<< JSCRIPT
			function print(caraPrint){
				window.open("${urlPrint}&caraPrint="+caraPrint,"",'location=_new, width=460px');
			}
			function printRiwayat(caraPrint){
				window.open("${urlPrintRiwayat}&caraPrint="+caraPrint,"",'location=_new, width=900px');
			}
			function printPermintaan(idPasienKirimKeUnitLain){
				window.open("${urlPrintPermintaan}&idPasienKirimKeUnitLain="+idPasienKirimKeUnitLain+"&caraPrint="+"PRINT","",'location=_new, width=460px');
			}
JSCRIPT;
                                Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
                                ?>
                            </div>
                            <?php }?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php echo $form->errorSummary($modKirimKeUnitLain); ?>
        <div class="formInputTab <?=$hide?>" style="width: 100%; overflow-x: hidden;">
            <div class="row daftar-pemeriksaan" style="margin: 15px 0;">
                <table style="width: 100%; border: none; height:auto; ">
                    <tr>
                        <td>
                            <div id="formPeriksaRad" class="">

                                <?php echo CHtml::hiddenField('berubah', '', array('readonly' => TRUE)); ?>
                                <?php

                                $ceklist = false;


                                foreach ($modJenis as $i => $jenis) {

                                    $cekperiksa = '';

                                    foreach ($modPeriksaRad as $j => $pemeriksaan) {

                                        if ($pemeriksaan->jenispemeriksaanrad_id == $jenis->jenispemeriksaanrad_id) {

                                            $cekperiksa .= '<label class="checkbox inline">' . CHtml::checkBox("pemeriksaanLab[]", $ceklist, array(
                                                'value' => $pemeriksaan->kode_unik,
                                                'onclick' => "inputperiksa(this," . Params::RUANGAN_ID_LAB_KLINIK . ");"
                                            ));
                                            $cekperiksa .= "<span>" . $pemeriksaan->pemeriksaanrad_nama . "</span></label><br>";
                                        }
                                    }

                                    $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                                        'id' => 'tabel-riwayatanamnesa_' . $i,
                                        'content' => array(
                                            'content-detailanamnesa_' . $i => array(
                                                'header' => '<h6>' . $jenis->jenispemeriksaanrad_nama . '</h6>',
                                                'isi' => $cekperiksa,
                                                'active' => false,
                                            ),
                                        ),
                                    ));
                                }


                                // echo '<pre>';


                                // die;

                                ?>

                                <!-- </div> -->
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <?php $this->endWidget(); ?>
        <?php
        $js = <<< JSCRIPT
//==================================================Validasi===============================================
//*Jangan Lupa untuk menambahkan hiddenField dengan id "berubah" di setiap form
//* hidden field dengan id "url"
//*Copas Saja hiddenfield di Line 36 dan 35
//* ubah juga id button simpannya jadi "btn_simpan"


function myFunction() {


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
JSCRIPT;
        Yii::app()->clientScript->registerScript('js', $js, CClientScript::POS_READY);
        ?>


        <script>
            $(document).ready(function() {
                $("flip").click(function() {
                    $("p").toggle();
                });
            });



            function setChecklistPemeriksaanLabReset() {
                $("#form-caripemeriksaan").find("input:not(:disabled):not([readonly])").each(function() {
                    $(this).val("");
                });
                updateChecklistPemeriksaanRad();



            }


            function updateChecklistPemeriksaanRad() {
                var form_index = $('#form_index').val();
                var cek = [];

                if ($('#is_paket').is(':checked')) {

                    $('#TarifpemeriksaanradruanganV_jenispemeriksaanrad_nama').val('');
                    $('#TarifpemeriksaanradruanganV_jenispemeriksaanrad_nama').attr('readonly', true);

                } else {

                    $('#TarifpemeriksaanradruanganV_jenispemeriksaanrad_nama').attr('readonly', false);

                }


                $('#tblFormPemeriksaanRad tbody tr').each(function() {

                    var id = $(this).attr('id');
                    cek.push(parseInt(id.replace('periksarad_', '')));
                    // cek.push('');

                });

                $('.daftar-pemeriksaan').addClass("animation-loading");
                $.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('/rawatJalan/radiologiNew/SetChecklistPemeriksaanRad'); ?>',
                    data: {
                        data: $("#form-caripemeriksaan :input").serialize()
                    },
                    dataType: "json",
                    success: function(data) {
                        $('.daftar-pemeriksaan').html(data.content);
                        cekScreen();
                        // $('.checkboxlist-tile').tile({widths : [ 190 ]});

                        $('#formPeriksaRad').tile({
                            widths: [280],
                        });

                        $('.accordion-toggle').attr('style', 'width: 250px;');
                        $('.glyphicon-chevron-down').attr('style', 'font-size:16px; margin-top: -30px;');
                        $('.accordion-inner').attr('style', 'width: 250px;');

                        $('.daftar-pemeriksaan').removeClass("animation-loading");
                        // setCheckedPemeriksaan($("#form-tindakanpemeriksaan-"+form_index),$('.daftar-pemeriksaan'));

                        var cekc = [];
                        $.each(cek, function(key, val) {

                            $('#formPeriksaRad').find('input[type="checkbox"][value="' + val + '"]').prop(
                                "checked", "checked");
                            cekc.push(val);

                        });

                        $('.kode_unik_tr').each(function() {
                            $('input[type="checkbox"][value="' + $(this).val() + '"]').prop('checked', 'checked');
                        });

                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                        myAlert('Pemeriksaan tidak tersedia');
                        $('.daftar-pemeriksaan').removeClass("animation-loading");
                    }
                });
            }


            function setCheckedPemeriksaan(obj_table, obj_dialog) {
                var form_index = $('#form_index').val();
                $(obj_table).find('input[name$="[pemeriksaanrad_id]"]').each(function() {
                    var pemeriksaanrad_id = $(this).val();
                    $(obj_dialog).find('input[name$="[is_pilih]"][value=' + pemeriksaanrad_id + ']').attr('checked', true);
                });

            }

            function cekScreen() {
                $('#formPeriksaRad').find(".ganti").each(function() {
                    if ((screen.width <= 1200) && (screen.height <= 2000)) {
                        $(this).addClass("col-sm-12");
                        $(this).removeClass("col-sm-3");
                        console.log('Resolusi layar saat ini a width: ' + screen.width + ' height:' + screen.height);
                    } else {
                        $(this).removeClass("col-sm-12");
                        $(this).addClass("col-sm-3")
                        console.log('Resolusi layar saat ini b width: ' + screen.width + ' heihgt:' + screen.height);
                    }
                });

            }


            function inputperiksa(obj, ruangan_id, sub=null) { // console.log("sniff 2");
                if ($(obj).is(':checked')) {

                    $(obj).trigger('change');

                    var pemeriksaanrad_id = obj.value;
                    var kelaspelayanan_id = $('#kelaspelayanan_id').val();
                    var carabayar_id = $('#carabayar_id').val();
                    var penjamin_id = $('#penjamin_id').val();
                    var is_paket = $('#is_paket').is(":checked") ? $('#is_paket').val() : 0;
                    var pendaftaran_id = '<?php echo $modPendaftaran->pendaftaran_id; ?>';

                    if (kelaspelayanan_id === '') {
                        myAlert("Silakan pilih kelas pelayanan terlebih dahulu!");
                        $(obj).attr('checked', false);
                        return false;
                    }

                    console.log('kelas: ', kelaspelayanan_id);

                    ajaxinputperiksa(pemeriksaanrad_id, kelaspelayanan_id, pendaftaran_id, carabayar_id, penjamin_id, is_paket, obj);

                    if(sub !== null) {

                        $('.sub-' + sub).find('input[type="checkbox"]').each(function() {

                            pemeriksaanrad_id = $(this).val();

                            if($(this).is(':checked') === false) {
                                $(this).prop('checked', 'checked');
                                ajaxinputperiksa(pemeriksaanrad_id, kelaspelayanan_id, pendaftaran_id, carabayar_id, penjamin_id, is_paket, $(this));
                            }
                            
                        });

                        var kelas = $(obj);
                        console.log('kelas sub: ' . kelas);

                    } 

                } else {
                    batalPeriksa(obj.value);
                    
                    if(sub !== null) {
                        $('.sub-' + sub).find('input[type="checkbox"]').each(function() {

                            if($(this).is(':checked')) {
                                $(this).prop('checked', false);
                                batalPeriksa($(this).val());
                                hitungTotal();
                            }

                        });

                    } else {
                        hitungTotal();
                    }

                }
            }

            function ajaxinputperiksa(pemeriksaanrad_id, kelaspelayanan_id, pendaftaran_id, carabayar_id, penjamin_id, is_paket, obj = null) {
                jQuery.ajax({
                    'url': '<?php echo Yii::app()->createUrl('rawatJalan/radiologiNew/loadFormPemeriksaanRad') ?>',
                    'data': {
                        pemeriksaanrad_id: pemeriksaanrad_id,
                        kelaspelayanan_id: kelaspelayanan_id,
                        carabayar_id: carabayar_id,
                        penjamin_id: penjamin_id,
                        pendaftaran_id: pendaftaran_id,
                        is_paket: is_paket,
                    },
                    'type': 'post',
                    'dataType': 'json',
                    'success': function(data) {
                        if (data.form == '') {
                            $(obj).removeAttr("checked");
                            myAlert(
                                "Pemeriksaan belum memilik tarif silakan hubungi SIMRS untuk memeriksa tarif pemeriksaan tersebut"
                            );
                        }
                        $('#tblFormPemeriksaanRad #trPeriksaRadKosong').detach();
                        $('#tblFormPemeriksaanRad > tbody').append(data.form);
                        $("#tblFormPemeriksaanRad > tbody > tr:last .integer").maskMoney({
                            "defaultZero": true,
                            "allowZero": true,
                            "decimal": ",",
                            "thousands": ".",
                            "precision": 0,
                            "symbol": null
                        });
                        $('.integer').each(function() {
                            this.value = formatNumber(this.value)
                        });
                        //                         $('.integer').parent().detach(); // hapus kolom tarif

                        $('.apa-paket:last').val((is_paket == 1) ? 'ya' : 'tidak');
                        $('.is-paket:last').prop('checked', (is_paket == 1));
                        hitungTotal();
                    },
                    'cache': false
                });
            }



            function batalPeriksa(idPemeriksaanrad) {
                $('#tblFormPemeriksaanRad #periksarad_' + idPemeriksaanrad).detach();
                if ($('#tblFormPemeriksaanRad tr').length == 1)
                    $('#tblFormPemeriksaanRad').append('<tr id="trPeriksaRadKosong"><td colspan="4"></td></tr>');
            }

            function batalKirim(pasienkirimkeunitlain_id, pasien_id, is_bisa = true) {
                if(is_bisa) {
                myConfirm("Apakah Anda akan membatalkan kirim pasien ke Radiologi?", "Perhatian!", function(r) {
                    if (r) {
                        $.post('<?php echo $this->createUrl('ajaxBatalKirim') ?>', {
                            pasienkirimkeunitlain_id: pasienkirimkeunitlain_id,
                            pasien_id: pasien_id
                        }, function(data) {
                            $('#tblListPemeriksaanRad').html(data.result);
                            myAlert(data.pesan);
                            location.replace(
                                '<?php echo $this->createUrl('index') ?>&pendaftaran_id=<?php echo $_GET['pendaftaran_id'] ?>'
                            );
                        }, 'json');
                    }
                }); } else {
                    myAlert("Anda tidak memiliki akses");
                }
            }

            function hitungTotal() {
                var total = 0;
                $('.tarif_satuan').each(
                    function() {
                        qty = $(this).parents('tr').find('.qty').val();
                        total += unformatNumber(this.value) * qty;
                    }
                );
                $('#periksaTotal').val(formatNumber(total));
            }




            function cekInput() {
                if (requiredCheck($("#rjpasien-radiologi-t-form"))) {
                    //var deposit = $('#deposit').val();
                    var periksaTotal = unformatNumber($('#periksaTotal').val());
                    var tr = $("#tblFormPemeriksaanRad > tbody > tr").length;
                    if (tr > 0) {
                        $('#rjpasien-radiologi-t-form').submit();
                    } else {
                        alert("Tindakan Radiologi belum dipilih");
                        return false;
                    }
                }
                return false;
            }

            function setTrue(obj) {

                var cito = $(obj).is(':checked');

                if (cito) {
                    $(obj).closest('td').find('.apa-cito').val("ya");
                } else {
                    $(obj).closest('td').find('.apa-cito').val("tidak");

                }
            }


            $(document).ready(function() {
                updateChecklistPemeriksaanRad();

                $('#formPeriksaRad').tile({
                    widths: [280],
                });

                $('.accordion-toggle').attr('style', 'width: 250px;');
                $('.glyphicon-chevron-down').attr('style', 'font-size:16px; margin-top: -30px;');
                $('.accordion-inner').attr('style', 'width: 250px;');

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
                        modul_id: <?php echo Params::MODUL_ID_RAD ?>,
                        judulnotifikasi: 'Pasien Rujukan',
                        isinotifikasi: '<?php echo $modPasien->nama_pasien ?> dengan <?php echo $modPasien->no_rekam_medik ?> telah dirujuk pada <?php echo $modKirimKeUnitLain->tgl_kirimpasien ?> dari <?php echo $modKirimKeUnitLain->ruangan->ruangan_nama ?>'
                    }; // 16 
                    insert_notifikasi(params);
                <?php
                }
                ?>

                <?php $r = RuanganM::model()->find(' ruangan_id in (' . Params::RUANGAN_ID_RAD . ') order by ruangan_nourut') ?>

                <?php if (!isset($_GET['idPasienKirimKeUnitLain'])) : ?>
                    $('#RJPasienKirimKeUnitLainT_ruangan_id').val(<?= $r->ruangan_id ?>);
                <?php endif; ?>


                var ppds = jQuery('#<?php echo CHtml::activeId($modKirimKeUnitLain, 'ppds_id') ?>');
                jQuery(ppds).multiselect({
                    includeSelectAllOption: false,
                    buttonClass: "form-control",
                    maxHeight: 300,
                    buttonWidth: '182px',
                    enableCaseInsensitiveFiltering: true
                }).hide();
            });
        </script>

<?php } ?>
<?php }else{?>
    <?php
    if ((!empty($kelPegawaippds->loginpemakai_id == Yii::app()->user->getState('loginpemakai_id')) && !empty($kelPegawaippds->kelompokpegawai_id == Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN))) {
?>


        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Riwayat Pemeriksaan Radiologi Pasien</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <div class="block-tabel">
                    <?php $this->renderPartial($this->path_view . '_listKiriimKeUnitLain2', array('modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain)) ?>
                    <div class="control-group">
                        <?php #endregion
                        //echo ''; var_dump($modPendaftaran); die;
                        ?>

                    </div>
                </div>
            </div>
        </div>


        <?php
        // $tips = array(
        //     '0' => 'simpan',
        //     '1' => 'print',
        // );
        // $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
        // $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));

        $idPasienKirimKeUnitLain = isset($_GET['idPasienKirimKeUnitLain']) ? $_GET['idPasienKirimKeUnitLain'] : null;
        $urlPrint = Yii::app()->createAbsoluteUrl($this->module->id . '/' . $this->id . '/print&id=' . $modPendaftaran->pendaftaran_id . '&idPasienKirimKeUnitLain=' . $idPasienKirimKeUnitLain);
        $urlPrintRiwayat = Yii::app()->createAbsoluteUrl($this->module->id . '/' . $this->id . '/printRiwayat&id=' . $modPendaftaran->pendaftaran_id);
        $urlPrintPermintaan = Yii::app()->createAbsoluteUrl($this->module->id . '/' . $this->id . '/print&id=' . $modPendaftaran->pendaftaran_id);
        $js = <<< JSCRIPT
			function print(caraPrint){
				window.open("${urlPrint}&caraPrint="+caraPrint,"",'location=_new, width=460px');
			}
			function printRiwayat(caraPrint){
				window.open("${urlPrintRiwayat}&caraPrint="+caraPrint,"",'location=_new, width=900px');
			}
			function printPermintaan(idPasienKirimKeUnitLain){
				window.open("${urlPrintPermintaan}&idPasienKirimKeUnitLain="+idPasienKirimKeUnitLain+"&caraPrint="+"PRINT","",'location=_new, width=460px');
			}
JSCRIPT;
        Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
        ?>
        </div>
        </div>
        <?php $this->endWidget(); ?>
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
        <script>
            function batalPeriksa(idPemeriksaanrad) {
                $('#tblFormPemeriksaanRad #periksarad_' + idPemeriksaanrad).detach();
                if ($('#tblFormPemeriksaanRad tr').length == 1)
                    $('#tblFormPemeriksaanRad').append('<tr id="trPeriksaRadKosong"><td colspan="4"></td></tr>');
            }

            function batalKirim(pasienkirimkeunitlain_id, pasien_id, is_bisa = true) {
                if(is_bisa) {
                myConfirm("Apakah Anda akan membatalkan kirim pasien ke Radiologi?", "Perhatian!", function(r) {
                    if (r) {
                        $.post('<?php echo $this->createUrl('ajaxBatalKirim') ?>', {
                            pasienkirimkeunitlain_id: pasienkirimkeunitlain_id,
                            pasien_id: pasien_id
                        }, function(data) {
                            $('#tblListPemeriksaanRad').html(data.result);
                            myAlert(data.pesan);
                            location.replace(
                                '<?php echo $this->createUrl('index') ?>&pendaftaran_id=<?php echo $_GET['pendaftaran_id'] ?>'
                            );
                        }, 'json');
                    }
                }); } else {
                    myAlert("Anda tidak memiliki akses");
                }
            }

            function hitungTotal() {
                var total = 0;
                $('.tarif_satuan').each(
                    function() {
                        qty = $(this).parents('tr').find('.qty').val();
                        total += unformatNumber(this.value) * qty;
                    }
                );
                $('#periksaTotal').val(formatNumber(total));
            }

            function cekInput() {
                if (requiredCheck($("#rjpasien-radiologi-t-form"))) {
                    //var deposit = $('#deposit').val();
                    var periksaTotal = unformatNumber($('#periksaTotal').val());
                    var tr = $("#tblFormPemeriksaanRad > tbody > tr").length;
                    if (tr > 0) {
                        $('#rjpasien-radiologi-t-form').submit();
                    } else {
                        alert("Tindakan Radiologi belum dipilih");
                        return false;
                    }
                }
                return false;
            }

            // function setTrue(obj) {

            //     var cito = $(obj).is(':checked');

            //     if (cito) {
            //         $(obj).closest('td').find('.apa-cito').val("ya");
            //     } else {
            //         $(obj).closest('td').find('.apa-cito').val("tidak");

            //     }
            // }


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
                        modul_id: <?php echo Params::MODUL_ID_RAD ?>,
                        judulnotifikasi: 'Pasien Rujukan',
                        isinotifikasi: '<?php echo $modPasien->nama_pasien ?> dengan <?php echo $modPasien->no_rekam_medik ?> telah dirujuk pada <?php echo $modKirimKeUnitLain->tgl_kirimpasien ?> dari <?php echo $modKirimKeUnitLain->ruangan->ruangan_nama ?>'
                    }; // 16 
                    insert_notifikasi(params);
                <?php
                }
                ?>

                <?php $r = RuanganM::model()->find(' instalasi_id = ' . Params::INSTALASI_ID_RAD . ' and ruangan_id is not null order by ruangan_nourut') ?>

                <?php if (!isset($_GET['idPasienKirimKeUnitLain'])) : ?>
                    $('#RJPasienKirimKeUnitLainT_ruangan_id').val(<?= $r->ruangan_id ?>);
                <?php endif; ?>


                var ppds = jQuery('#<?php echo CHtml::activeId($modKirimKeUnitLain, 'ppds_id') ?>');
                jQuery(ppds).multiselect({
                    includeSelectAllOption: false,
                    buttonClass: "form-control",
                    maxHeight: 300,
                    buttonWidth: '182px',
                    enableCaseInsensitiveFiltering: true
                }).hide();
            });
        </script>
    <?php } else if ((!empty($kelPegawaippds->loginpemakai_id == Yii::app()->user->getState('loginpemakai_id')) && !empty($kelPegawaippds->kelompokpegawai_id == Params::KELOMPOKPEGAWAI_ID_DOKTER_UMUM))) { ?>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Riwayat Pemeriksaan Radiologi Pasien</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <div class="block-tabel">
                    <?php $this->renderPartial($this->path_view . '_listKiriimKeUnitLain2', array('modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain)) ?>
                    <div class="control-group">
                        <?php #endregion
                        //echo ''; var_dump($modPendaftaran); die;
                        ?>

                    </div>
                </div>
            </div>
        </div>


        <?php
        // $tips = array(
        //     '0' => 'simpan',
        //     '1' => 'print',
        // );
        // $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
        // $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));

        $idPasienKirimKeUnitLain = isset($_GET['idPasienKirimKeUnitLain']) ? $_GET['idPasienKirimKeUnitLain'] : null;
        $urlPrint = Yii::app()->createAbsoluteUrl($this->module->id . '/' . $this->id . '/print&id=' . $modPendaftaran->pendaftaran_id . '&idPasienKirimKeUnitLain=' . $idPasienKirimKeUnitLain);
        $urlPrintRiwayat = Yii::app()->createAbsoluteUrl($this->module->id . '/' . $this->id . '/printRiwayat&id=' . $modPendaftaran->pendaftaran_id);
        $urlPrintPermintaan = Yii::app()->createAbsoluteUrl($this->module->id . '/' . $this->id . '/print&id=' . $modPendaftaran->pendaftaran_id);
        $js = <<< JSCRIPT
			function print(caraPrint){
				window.open("${urlPrint}&caraPrint="+caraPrint,"",'location=_new, width=460px');
			}
			function printRiwayat(caraPrint){
				window.open("${urlPrintRiwayat}&caraPrint="+caraPrint,"",'location=_new, width=900px');
			}
			function printPermintaan(idPasienKirimKeUnitLain){
				window.open("${urlPrintPermintaan}&idPasienKirimKeUnitLain="+idPasienKirimKeUnitLain+"&caraPrint="+"PRINT","",'location=_new, width=460px');
			}
JSCRIPT;
        Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
        ?>
        </div>
        </div>
        <?php $this->endWidget(); ?>
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
        <script>
            function inputperiksa(obj, ruangan_id, sub=null) { // console.log("sniff 3");
                if ($(obj).is(':checked')) {

                    $(obj).trigger('change');

                    var pemeriksaanrad_id = obj.value;
                    var kelaspelayanan_id = $('.kelaspelayanan')
                        .val() //$('#<?php //echo CHtml::activeId($modKirimKeUnitLain, 'kelaspelayanan_id') 
                                        ?>').val();
                    var pendaftaran_id = '<?php echo $modPendaftaran->pendaftaran_id; ?>';
                    if (kelaspelayanan_id === '') {
                        myAlert("Silakan pilih kelas pelayanan terlebih dahulu!");
                        $(obj).attr('checked', false);
                        return false;
                    }
                    console.log('kelas', kelaspelayanan_id);

                    ajaxinputperiksa(pemeriksaanrad_id, kelaspelayanan_id, pendaftaran_id, obj);

                    if(sub !== null) {

                        $('.sub-' + sub).find('input[type="checkbox"]').each(function() {

                            pemeriksaanrad_id = $(this).val();

                            if($(this).is(':checked') === false) {
                                $(this).prop('checked', 'checked');
                                ajaxinputperiksa(pemeriksaanrad_id, kelaspelayanan_id, pendaftaran_id, $(this));
                            }
                            
                        });

                        var kelas = $(obj);
                        console.log('kelas sub: ' . kelas);

                    } 

                    
                } else {
                    batalPeriksa(obj.value);
                    if(sub !== null) {
                        $('.sub-' + sub).find('input[type="checkbox"]').each(function() {

                            if($(this).is(':checked')) {
                                $(this).prop('checked', false);
                                batalPeriksa($(this).val());
                                hitungTotal();
                            }

                        });

                    } else {
                        hitungTotal();
                    }
                    //        myConfirm("Apakah Anda akan membatalkan pemeriksaan ini?","Perhatian!",function(r) {
                    //            if(r){
                    //                batalPeriksa(obj.value);
                    //                hitungTotal();
                    //            }else{
                    //                $(obj).attr('checked', 'checked');
                    //            }
                    //        });
                }
            }

            function ajaxinputperiksa(pemeriksaanrad_id, kelaspelayanan_id, pendaftaran_id,  obj = null) {
                jQuery.ajax({
                    'url': '<?php echo Yii::app()->createUrl('rawatJalan/radiologiNew/loadFormPemeriksaanRad') ?>',
                    'data': {
                        pemeriksaanrad_id: pemeriksaanrad_id,
                        kelaspelayanan_id: kelaspelayanan_id,
                        pendaftaran_id: pendaftaran_id
                    },
                    'type': 'post',
                    'dataType': 'json',
                    'success': function(data) {
                        if (data.form == '') {
                            $(obj).removeAttr("checked");
                            myAlert(
                                "Pemeriksaan belum memilik tarif silakan hubungi SIMRS untuk memeriksa tarif pemeriksaan tersebut"
                            );
                        }
                        $('#tblFormPemeriksaanRad #trPeriksaRadKosong').detach();
                        $('#tblFormPemeriksaanRad > tbody').append(data.form);
                        $("#tblFormPemeriksaanRad > tbody > tr:last .integer").maskMoney({
                            "defaultZero": true,
                            "allowZero": true,
                            "decimal": ",",
                            "thousands": ".",
                            "precision": 0,
                            "symbol": null
                        });
                        $('.integer').each(function() {
                            this.value = formatNumber(this.value)
                        });
                        //                         $('.integer').parent().detach(); // hapus kolom tarif
                        hitungTotal();
                    },
                    'cache': false
                });
            }

            function batalPeriksa(idPemeriksaanrad) {
                $('#tblFormPemeriksaanRad #periksarad_' + idPemeriksaanrad).detach();
                if ($('#tblFormPemeriksaanRad tr').length == 1)
                    $('#tblFormPemeriksaanRad').append('<tr id="trPeriksaRadKosong"><td colspan="4"></td></tr>');
            }

            function batalKirim(pasienkirimkeunitlain_id, pasien_id, is_bisa = true) {
                if(is_bisa) {
                myConfirm("Apakah Anda akan membatalkan kirim pasien ke Radiologi?", "Perhatian!", function(r) {
                    if (r) {
                        $.post('<?php echo $this->createUrl('ajaxBatalKirim') ?>', {
                            pasienkirimkeunitlain_id: pasienkirimkeunitlain_id,
                            pasien_id: pasien_id
                        }, function(data) {
                            $('#tblListPemeriksaanRad').html(data.result);
                            myAlert(data.pesan);
                            location.replace(
                                '<?php echo $this->createUrl('index') ?>&pendaftaran_id=<?php echo $_GET['pendaftaran_id'] ?>'
                            );
                        }, 'json');
                    }
                }); } else {
                    myAlert("Anda tidak memiliki akses");
                }
            }

            function hitungTotal() {
                var total = 0;
                $('.tarif_satuan').each(
                    function() {
                        qty = $(this).parents('tr').find('.qty').val();
                        total += unformatNumber(this.value) * qty;
                    }
                );
                $('#periksaTotal').val(formatNumber(total));
            }

            function cekInput() {
                if (requiredCheck($("#rjpasien-radiologi-t-form"))) {
                    //var deposit = $('#deposit').val();
                    var periksaTotal = unformatNumber($('#periksaTotal').val());
                    var tr = $("#tblFormPemeriksaanRad > tbody > tr").length;
                    if (tr > 0) {
                        $('#rjpasien-radiologi-t-form').submit();
                    } else {
                        alert("Tindakan Radiologi belum dipilih");
                        return false;
                    }
                }
                return false;
            }

            // function setTrue(obj) {

            //     var cito = $(obj).is(':checked');

            //     if (cito) {
            //         $(obj).closest('td').find('.apa-cito').val("ya");
            //     } else {
            //         $(obj).closest('td').find('.apa-cito').val("tidak");

            //     }
            // }


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
                        modul_id: <?php echo Params::MODUL_ID_RAD ?>,
                        judulnotifikasi: 'Pasien Rujukan',
                        isinotifikasi: '<?php echo $modPasien->nama_pasien ?> dengan <?php echo $modPasien->no_rekam_medik ?> telah dirujuk pada <?php echo $modKirimKeUnitLain->tgl_kirimpasien ?> dari <?php echo $modKirimKeUnitLain->ruangan->ruangan_nama ?>'
                    }; // 16 
                    insert_notifikasi(params);
                <?php
                }
                ?>

                <?php $r = RuanganM::model()->find(' ruangan_id in (' . Params::RUANGAN_ID_RAD . ') order by ruangan_nourut') ?>

                <?php if (!isset($_GET['idPasienKirimKeUnitLain'])) : ?>
                    $('#RJPasienKirimKeUnitLainT_ruangan_id').val(<?= $r->ruangan_id ?>);
                <?php endif; ?>


                var ppds = jQuery('#<?php echo CHtml::activeId($modKirimKeUnitLain, 'ppds_id') ?>');
                jQuery(ppds).multiselect({
                    includeSelectAllOption: false,
                    buttonClass: "form-control",
                    maxHeight: 300,
                    buttonWidth: '182px',
                    enableCaseInsensitiveFiltering: true
                }).hide();
            });
        </script>
    <?php } else { ?>


        <?php echo $form->errorSummary($modKirimKeUnitLain);
        echo $form->hiddenField($modKirimKeUnitLain, 'kelaspelayanan_id', array('class' => 'kelaspelayanan'));
        ?>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Riwayat Pemeriksaan Radiologi Pasien</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <div class="block-tabel">
                    <?php $this->renderPartial($this->path_view . '_listKirimKeUnitLain', array('modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain)) ?>
                    <div class="control-group">
                        <?php #endregion
                        //echo ''; var_dump($modPendaftaran); die;
                        ?>

                    </div>
                </div>
            </div>
        </div>


<div class="row" <?=$hidden?>>
    <div class="col-sm-12">


                <div id="form-caripemeriksaan" class="col-sm-12 form-horizontal" style="margin-bottom: 30px;">
                    <br>



                    <div class="row">
                        <!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') 
                                                    ?></p>-->
                        <?php //echo CHtml::hiddenField('url',$this->createUrl('',array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id)),array('readonly'=>TRUE));
                        ?>
                        <?php //echo CHtml::hiddenField('berubah','',array('readonly'=>TRUE));
                        ?>
                        <div class="col-sm-6">
                            <div class="control-group">
                                <label class="control-label required" for="RJPasienKirimKeUnitLainT_tgl_kirimpasien">
                                    Tanggal Permintaan
                                    <span class="required">*</span>
                                </label>
                                <?php $modKirimKeUnitLain->tgl_kirimpasien = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modKirimKeUnitLain->tgl_kirimpasien, 'yyyy-MM-dd hh:mm:ss', 'medium', null)); ?>
                                <div class="controls">
                                    <?php
                                    $this->widget('MyDateTimePicker', array(
                                        'model' => $modKirimKeUnitLain,
                                        'attribute' => 'tgl_kirimpasien',
                                        'mode' => 'datetime',
                                        'options' => array(
                                            'dateFormat' => Params::DATE_FORMAT,
                                        ),
                                        'htmlOptions' => array('readonly' => true, 'class' => 'span3'),
                                    ));
                                    ?>
                                </div>
                                <div class="controls hide">
                                    <?php echo $form->checkBox($modKirimKeUnitLain, 'is_elektif', array('id' => 'is_elektif')); ?>
                                    <label for="is_elektif">Pemeriksaan Elektif</label>
                                </div>
                            </div>

                            <div class="control-group hide">
                                <label class="control-label required" for="RJPasienKirimKeUnitLainT_tgl_kirimpasien">
                                    Tgl Rencana Pemeriksaan
                                    <span class="required">*</span>
                                </label>

                                <div class="controls">
                                    <?php
                                    $modKirimKeUnitLain->tglrencanapemeriksaan = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modKirimKeUnitLain->tglrencanapemeriksaan, 'yyyy-MM-dd hh:mm:ss', 'medium', null));

                                    $this->widget('MyDateTimePicker', array(
                                        'model' => $modKirimKeUnitLain,
                                        'attribute' => 'tglrencanapemeriksaan',
                                        'mode' => 'datetime',
                                        'options' => array(
                                            'dateFormat' => Params::DATE_FORMAT,
                                        ),
                                        'htmlOptions' => array('readonly' => true, 'class' => 'col-sm-8'),
                                    )); ?>
                                </div>
                            </div>



                            <?php echo $form->dropDownListRow(
                                $modKirimKeUnitLain,
                                'pegawai_id',
                                CHtml::listData($modKirimKeUnitLain->getDokterItems(), 'pegawai_id', 'NamaLengkap'),
                                array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")
                            );
                            ?>

                            <?php
                            echo $form->dropDownListRow(
                                $modKirimKeUnitLain,
                                'ppds_id',
                                CHtml::listData($modKirimKeUnitLain->getPPDS(), 'ppds_id', 'ppds_nama'),
                                array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")
                            );
                            ?>
                            <div class="control-group">
                                <?php echo CHtml::Label('Jenis Pelayanan', 'jenispemeriksaanrad_id', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php echo $form->dropDownList($modKirimKeUnitLain, 'ruangan_id', CHtml::listData(RuanganM::model()->findAll('ruangan_id in (' . Params::RUANGAN_ID_RAD . ') order by ruangan_nama'), 'ruangan_id', 'ruangan_nama'), array('empty' => '-- Pilih --', 'class' => 'span3')); ?>
                                </div>
                            </div>



                            <?php echo $form->textAreaRow($modKirimKeUnitLain, 'catatandokterpengirim', array('placeholder' => 'Catatan', 'onkeypress' => "return $(this).focusNextInputField(event);")) ?>
                            <?php echo CHtml::hiddenField("form_index", null, array('readonly' => true)); ?>
                            <?php echo CHtml::hiddenField('periksaTotal', '', array('class' => 'span2', 'style' => 'text-align:right;', 'disabled' => 'disabled')); ?>
                            <div class="control-group">
                                <?php echo CHtml::activeLabel($modPemeriksaanRad, 'jenispemeriksaanrad_id', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php echo CHtml::activeDropDownList($modPemeriksaanRad, 'jenispemeriksaanrad_nama', CHtml::listData(JenispemeriksaanradM::model()->findAll(array(
                                        'condition' => 'jenispemeriksaanrad_aktif = true',
                                        'order' => 'jenispemeriksaanrad_urutan',
                                    )), 'jenispemeriksaanrad_nama', 'jenispemeriksaanrad_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)", "onchange" => "updateChecklistPemeriksaanRad();", 'placeholder' => 'Nama Jenis Pemeriksaan Radiologi',)); ?>
                                </div>
                                <div class="controls hide">
                                    <?php echo $form->checkBox($modPemeriksaanRad, 'is_paket', array('id' => 'is_paket', "onchange" => "updateChecklistPemeriksaanRad();")); ?>
                                    <label for="is_paket">Paket</label>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo CHtml::activeLabel($modPemeriksaanRad, 'pemeriksaanrad_id', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php echo CHtml::hiddenfield('kelaspelayanan_id', $modPendaftaran->kelaspelayanan_id) ?>
                                    <?php echo CHtml::hiddenfield('carabayar_id', $modPendaftaran->carabayar_id) ?>
                                    <?php echo CHtml::hiddenfield('penjamin_id', $modPendaftaran->penjamin_id) ?>
                                    <?php echo CHtml::activeTextField($modPemeriksaanRad, 'pemeriksaanrad_nama', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)", "onchange" => "updateChecklistPemeriksaanRad();", 'placeholder' => 'Nama Pemeriksaan Radiologi', 'style' => 'font-family: Arial, Helvetica, sans-serif;')); ?>
                                    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', "onclick" => "updateChecklistPemeriksaanRad();", 'rel' => 'tooltip', 'title' => 'Klik untuk mencari pemeriksaan')); ?>
                                    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), array('class' => 'btn btn-default', 'type' => 'button', "onclick" => "setChecklistPemeriksaanLabReset();", 'rel' => 'tooltip', 'title' => 'Klik untuk mengulang pencarian')); ?>
                                </div>
                            </div>

                            <?php if (Yii::app()->user->getState('isbayarkekasirpenunjang') == true) { ?>
                                <div classs="control-group">
                                    <label class="control-label"></label>
                                    <div class="controls">
                                        <?php echo $form->checkBox($modKirimKeUnitLain, 'isbayarkekasirpenunjang', array('onkeyup' => "return $(this).focusNextInputField(event);", 'title' => "Pilih jika pasien harus membayar ke kasir terlebih dahulu sebelum periksa", 'rel' => 'tooltip')) ?>
                                        <label>Bayar ke Kasir</label>
                                    </div>

                                </div>
                            <?php } ?>
                        </div>


                        <div class="col-sm-6">
                            <div class="panel panel-success">
                                <div class="panel-heading">
                                    <div class="panel-title">
                                        <i class="entypo-credit-card"></i> Tabel <b>Pemeriksaan Radiologi
                                            <?php echo isset($modJenisTarif) ? "- " . $modJenisTarif->jenistarif->jenistarif_nama : ""; ?></b>
                                    </div>
                                </div>
                                <div class="panel-body table-responsive">
                                    <div class="block-tabel">
                                        <table id="tblFormPemeriksaanRad" class="table table-bordered table-condensed">
                                            <thead>
                                                <tr>
                                                    <th>Jenis Pemeriksaan</th>
                                                    <th>Pemeriksaan</th>
                                                    <th>Jumlah</th>
                                                    <th hidden>Tarif</th>
                                                    <!-- <th>Total Tarif</th> -->
                                                    <!-- <th>Paket</th> -->
                                                    <th>Cito</th>
                                                    <th>Batal</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if (!$modKirimKeUnitLain->isNewRecord) {
                                                    $permintaan = PermintaankepenunjangT::model()->findAllByAttributes(array(
                                                        'pasienkirimkeunitlain_id' => $modKirimKeUnitLain->pasienkirimkeunitlain_id
                                                    ));

                                                    foreach ($permintaan as $item) {
                                                        echo $this->renderPartial('_formLoadPemeriksaanRadUpdate', array(
                                                            'item' => $item,
                                                        ), true);
                                                    }
                                                } ?>
                                                <!--<tr id="trPeriksaRadKosong"><td colspan="4"></td></tr>-->
                                            </tbody>
                                        </table>
                                        <table class="table table-bordered table-condensed">
                                            <tr>
                                                <td width="70%" style="text-align: right;">
                                                    <!--Total Biaya Pemeriksaan-->
                                                </td>
                                                <td><?php echo CHtml::hiddenField('periksaTotal', '', array('class' => 'span2', 'style' => 'text-align:right;', 'disabled' => 'disabled')); ?>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <script>
                                function deletePemeriksaan(obj) {
                                    myConfirm('Apakah Anda yakin akan membatalkan pemeriksaan tersebut?', 'Perhatian!', function(r) {
                                        if (r) {
                                            $(obj).parents('tr').detach();
                                            updateChecklistPemeriksaanRad();
                                        } else {
                                            return false;
                                        }
                                    });
                                }
                            </script>
                            <?php if(isset($_GET['lihat'])){?>
                            <div class="form-actions" hidden>
                                <?php echo CHtml::htmlButton(
                                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                                    array('class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'cekInput();', 'onKeypress' => 'return formSubmit(this,event)', 'id' => 'btn_simpan')
                                );
                                ?>
                                <?php
                                if (isset($_GET['idPasienKirimKeUnitLain'])) {
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
                                $tips = array(
                                    '0' => 'simpan',
                                    '1' => 'print',
                                );


                                $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
                                $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));

                                $idPasienKirimKeUnitLain = isset($_GET['idPasienKirimKeUnitLain']) ? $_GET['idPasienKirimKeUnitLain'] : null;
                                $urlPrint = Yii::app()->createAbsoluteUrl($this->module->id . '/' . $this->id . '/print&id=' . $modPendaftaran->pendaftaran_id . '&idPasienKirimKeUnitLain=' . $idPasienKirimKeUnitLain);
                                $urlPrintRiwayat = Yii::app()->createAbsoluteUrl($this->module->id . '/' . $this->id . '/printRiwayat&id=' . $modPendaftaran->pendaftaran_id);
                                $urlPrintPermintaan = Yii::app()->createAbsoluteUrl($this->module->id . '/' . $this->id . '/print&id=' . $modPendaftaran->pendaftaran_id);
                                $js = <<< JSCRIPT
			function print(caraPrint){
				window.open("${urlPrint}&caraPrint="+caraPrint,"",'location=_new, width=460px');
			}
			function printRiwayat(caraPrint){
				window.open("${urlPrintRiwayat}&caraPrint="+caraPrint,"",'location=_new, width=900px');
			}
			function printPermintaan(idPasienKirimKeUnitLain){
				window.open("${urlPrintPermintaan}&idPasienKirimKeUnitLain="+idPasienKirimKeUnitLain+"&caraPrint="+"PRINT","",'location=_new, width=460px');
			}
JSCRIPT;
                                Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
                                ?>
                            </div>
                            <?php }else{ ?>
                                <div class="form-actions" >
                                <?php echo CHtml::htmlButton(
                                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                                    array('class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'cekInput();', 'onKeypress' => 'return formSubmit(this,event)', 'id' => 'btn_simpan')
                                );
                                ?>
                                <?php
                                if (isset($_GET['idPasienKirimKeUnitLain'])) {
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
                                $tips = array(
                                    '0' => 'simpan',
                                    '1' => 'print',
                                );


                                $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
                                $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));

                                $idPasienKirimKeUnitLain = isset($_GET['idPasienKirimKeUnitLain']) ? $_GET['idPasienKirimKeUnitLain'] : null;
                                $urlPrint = Yii::app()->createAbsoluteUrl($this->module->id . '/' . $this->id . '/print&id=' . $modPendaftaran->pendaftaran_id . '&idPasienKirimKeUnitLain=' . $idPasienKirimKeUnitLain);
                                $urlPrintRiwayat = Yii::app()->createAbsoluteUrl($this->module->id . '/' . $this->id . '/printRiwayat&id=' . $modPendaftaran->pendaftaran_id);
                                $urlPrintPermintaan = Yii::app()->createAbsoluteUrl($this->module->id . '/' . $this->id . '/print&id=' . $modPendaftaran->pendaftaran_id);
                                $js = <<< JSCRIPT
			function print(caraPrint){
				window.open("${urlPrint}&caraPrint="+caraPrint,"",'location=_new, width=460px');
			}
			function printRiwayat(caraPrint){
				window.open("${urlPrintRiwayat}&caraPrint="+caraPrint,"",'location=_new, width=900px');
			}
			function printPermintaan(idPasienKirimKeUnitLain){
				window.open("${urlPrintPermintaan}&idPasienKirimKeUnitLain="+idPasienKirimKeUnitLain+"&caraPrint="+"PRINT","",'location=_new, width=460px');
			}
JSCRIPT;
                                Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
                                ?>
                            </div>
                            <?php }?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php echo $form->errorSummary($modKirimKeUnitLain); ?>
        <div class="formInputTab <?=$hide?>" style="width: 100%; overflow-x: hidden;">
            <div class="row daftar-pemeriksaan" style="margin: 15px 0;">
                <table style="width: 100%; border: none; height:auto; ">
                    <tr>
                        <td>
                            <div id="formPeriksaRad" class="">

                                <?php echo CHtml::hiddenField('berubah', '', array('readonly' => TRUE)); ?>
                                <?php

                                $ceklist = false;


                                foreach ($modJenis as $i => $jenis) {

                                    $cekperiksa = '';

                                    foreach ($modPeriksaRad as $j => $pemeriksaan) {

                                        if ($pemeriksaan->jenispemeriksaanrad_id == $jenis->jenispemeriksaanrad_id) {

                                            $cekperiksa .= '<label class="checkbox inline">' . CHtml::checkBox("pemeriksaanLab[]", $ceklist, array(
                                                'value' => $pemeriksaan->kode_unik,
                                                'onclick' => "inputperiksa(this," . Params::RUANGAN_ID_LAB_KLINIK . ");"
                                            ));
                                            $cekperiksa .= "<span>" . $pemeriksaan->pemeriksaanrad_nama . "</span></label><br>";
                                        }
                                    }

                                    $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                                        'id' => 'tabel-riwayatanamnesa_' . $i,
                                        'content' => array(
                                            'content-detailanamnesa_' . $i => array(
                                                'header' => '<h6>' . $jenis->jenispemeriksaanrad_nama . '</h6>',
                                                'isi' => $cekperiksa,
                                                'active' => false,
                                            ),
                                        ),
                                    ));
                                }


                                // echo '<pre>';


                                // die;

                                ?>

                                <!-- </div> -->
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <?php $this->endWidget(); ?>
        <?php
        $js = <<< JSCRIPT
//==================================================Validasi===============================================
//*Jangan Lupa untuk menambahkan hiddenField dengan id "berubah" di setiap form
//* hidden field dengan id "url"
//*Copas Saja hiddenfield di Line 36 dan 35
//* ubah juga id button simpannya jadi "btn_simpan"


function myFunction() {


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
JSCRIPT;
        Yii::app()->clientScript->registerScript('js', $js, CClientScript::POS_READY);
        ?>


        <script>
            $(document).ready(function() {
                $("flip").click(function() {
                    $("p").toggle();
                });
            });



            function setChecklistPemeriksaanLabReset() {
                $("#form-caripemeriksaan").find("input:not(:disabled):not([readonly])").each(function() {
                    $(this).val("");
                });
                updateChecklistPemeriksaanRad();



            }


            function updateChecklistPemeriksaanRad() {
                var form_index = $('#form_index').val();
                var cek = [];

                if ($('#is_paket').is(':checked')) {

                    $('#TarifpemeriksaanradruanganV_jenispemeriksaanrad_nama').val('');
                    $('#TarifpemeriksaanradruanganV_jenispemeriksaanrad_nama').attr('readonly', true);

                } else {

                    $('#TarifpemeriksaanradruanganV_jenispemeriksaanrad_nama').attr('readonly', false);

                }


                $('#tblFormPemeriksaanRad tbody tr').each(function() {

                    var id = $(this).attr('id');
                    cek.push(parseInt(id.replace('periksarad_', '')));
                    // cek.push('');

                });

                $('.daftar-pemeriksaan').addClass("animation-loading");
                $.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('/rawatJalan/radiologiNew/SetChecklistPemeriksaanRad'); ?>',
                    data: {
                        data: $("#form-caripemeriksaan :input").serialize()
                    },
                    dataType: "json",
                    success: function(data) {
                        $('.daftar-pemeriksaan').html(data.content);
                        cekScreen();
                        // $('.checkboxlist-tile').tile({widths : [ 190 ]});

                        $('#formPeriksaRad').tile({
                            widths: [280],
                        });

                        $('.accordion-toggle').attr('style', 'width: 250px;');
                        $('.glyphicon-chevron-down').attr('style', 'font-size:16px; margin-top: -30px;');
                        $('.accordion-inner').attr('style', 'width: 250px;');

                        $('.daftar-pemeriksaan').removeClass("animation-loading");
                        // setCheckedPemeriksaan($("#form-tindakanpemeriksaan-"+form_index),$('.daftar-pemeriksaan'));

                        var cekc = [];
                        $.each(cek, function(key, val) {

                            $('#formPeriksaRad').find('input[type="checkbox"][value="' + val + '"]').prop(
                                "checked", "checked");
                            cekc.push(val);

                        });

                        $('.kode_unik_tr').each(function() {
                            $('input[type="checkbox"][value="' + $(this).val() + '"]').prop('checked', 'checked');
                        });

                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                        myAlert('Pemeriksaan tidak tersedia');
                        $('.daftar-pemeriksaan').removeClass("animation-loading");
                    }
                });
            }


            function setCheckedPemeriksaan(obj_table, obj_dialog) {
                var form_index = $('#form_index').val();
                $(obj_table).find('input[name$="[pemeriksaanrad_id]"]').each(function() {
                    var pemeriksaanrad_id = $(this).val();
                    $(obj_dialog).find('input[name$="[is_pilih]"][value=' + pemeriksaanrad_id + ']').attr('checked', true);
                });

            }

            function cekScreen() {
                $('#formPeriksaRad').find(".ganti").each(function() {
                    if ((screen.width <= 1200) && (screen.height <= 2000)) {
                        $(this).addClass("col-sm-12");
                        $(this).removeClass("col-sm-3");
                        console.log('Resolusi layar saat ini a width: ' + screen.width + ' height:' + screen.height);
                    } else {
                        $(this).removeClass("col-sm-12");
                        $(this).addClass("col-sm-3")
                        console.log('Resolusi layar saat ini b width: ' + screen.width + ' heihgt:' + screen.height);
                    }
                });

            }


            function inputperiksa(obj, ruangan_id, sub=null) { // console.log("sniff 4");
                if ($(obj).is(':checked')) {

                    $(obj).trigger('change');

                    var pemeriksaanrad_id = obj.value;
                    var kelaspelayanan_id = $('#kelaspelayanan_id').val();
                    var carabayar_id = $('#carabayar_id').val();
                    var penjamin_id = $('#penjamin_id').val();
                    var is_paket = $('#is_paket').is(":checked") ? $('#is_paket').val() : 0;
                    //$('#<?php //echo CHtml::activeId($modKirimKeUnitLain, 'kelaspelayanan_id') 
                            ?>').val();
                    var pendaftaran_id = '<?php echo $modPendaftaran->pendaftaran_id; ?>';
                    if (kelaspelayanan_id === '') {
                        myAlert("Silakan pilih kelas pelayanan terlebih dahulu!");
                        $(obj).attr('checked', false);
                        return false;
                    }

                    console.log('kelas: ', kelaspelayanan_id);

                    ajaxinputperiksa(pemeriksaanrad_id, kelaspelayanan_id, pendaftaran_id, carabayar_id, penjamin_id, is_paket, obj);

                    if(sub !== null) {

                        $('.sub-' + sub).find('input[type="checkbox"]').each(function() {

                            pemeriksaanrad_id = $(this).val();

                            if($(this).is(':checked') === false) {
                                $(this).prop('checked', 'checked');
                                ajaxinputperiksa(pemeriksaanrad_id, kelaspelayanan_id, pendaftaran_id, carabayar_id, penjamin_id, is_paket, $(this));
                            }
                            
                        });

                        var kelas = $(obj);
                        console.log('kelas sub: ' . kelas);

                    } 

                } else {
                    batalPeriksa(obj.value);
                    if(sub !== null) {
                        $('.sub-' + sub).find('input[type="checkbox"]').each(function() {

                            if($(this).is(':checked')) {
                                $(this).prop('checked', false);
                                batalPeriksa($(this).val());
                                hitungTotal();
                            }

                        });

                    } else {
                        hitungTotal();
                    }
                    //        myConfirm("Apakah Anda akan membatalkan pemeriksaan ini?","Perhatian!",function(r) {
                    //            if(r){
                    //                batalPeriksa(obj.value);
                    //                hitungTotal();
                    //            }else{
                    //                $(obj).attr('checked', 'checked');
                    //            }
                    //        });
                }
            }

            function ajaxinputperiksa(pemeriksaanrad_id, kelaspelayanan_id, pendaftaran_id, carabayar_id, penjamin_id, is_paket, obj = null) {
                jQuery.ajax({
                    'url': '<?php echo Yii::app()->createUrl('rawatJalan/radiologiNew/loadFormPemeriksaanRad') ?>',
                    'data': {
                        pemeriksaanrad_id: pemeriksaanrad_id,
                        kelaspelayanan_id: kelaspelayanan_id,
                        carabayar_id: carabayar_id,
                        penjamin_id: penjamin_id,
                        pendaftaran_id: pendaftaran_id,
                        is_paket: is_paket,
                    },
                    'type': 'post',
                    'dataType': 'json',
                    'success': function(data) {
                        if (data.form == '') {
                            $(obj).removeAttr("checked");
                            myAlert(
                                "Pemeriksaan belum memilik tarif silakan hubungi SIMRS untuk memeriksa tarif pemeriksaan tersebut"
                            );
                        }
                        $('#tblFormPemeriksaanRad #trPeriksaRadKosong').detach();
                        $('#tblFormPemeriksaanRad > tbody').append(data.form);
                        $("#tblFormPemeriksaanRad > tbody > tr:last .integer").maskMoney({
                            "defaultZero": true,
                            "allowZero": true,
                            "decimal": ",",
                            "thousands": ".",
                            "precision": 0,
                            "symbol": null
                        });
                        $('.integer').each(function() {
                            this.value = formatNumber(this.value)
                        });
                        //                         $('.integer').parent().detach(); // hapus kolom tarif

                        $('.apa-paket:last').val((is_paket == 1) ? 'ya' : 'tidak');
                        $('.is-paket:last').prop('checked', (is_paket == 1));
                        hitungTotal();
                    },
                    'cache': false
                });
            }



            function batalPeriksa(idPemeriksaanrad) {
                $('#tblFormPemeriksaanRad #periksarad_' + idPemeriksaanrad).detach();
                if ($('#tblFormPemeriksaanRad tr').length == 1)
                    $('#tblFormPemeriksaanRad').append('<tr id="trPeriksaRadKosong"><td colspan="4"></td></tr>');
            }

            function batalKirim(pasienkirimkeunitlain_id, pasien_id, is_bisa = true) {
                if(is_bisa) {
                myConfirm("Apakah Anda akan membatalkan kirim pasien ke Radiologi?", "Perhatian!", function(r) {
                    if (r) {
                        $.post('<?php echo $this->createUrl('ajaxBatalKirim') ?>', {
                            pasienkirimkeunitlain_id: pasienkirimkeunitlain_id,
                            pasien_id: pasien_id
                        }, function(data) {
                            $('#tblListPemeriksaanRad').html(data.result);
                            myAlert(data.pesan);
                            location.replace(
                                '<?php echo $this->createUrl('index') ?>&pendaftaran_id=<?php echo $_GET['pendaftaran_id'] ?>'
                            );
                        }, 'json');
                    }
                }); } else {
                    myAlert("Anda tidak memiliki akses");
                }
            }

            function hitungTotal() {
                var total = 0;
                $('.tarif_satuan').each(
                    function() {
                        qty = $(this).parents('tr').find('.qty').val();
                        total += unformatNumber(this.value) * qty;
                    }
                );
                $('#periksaTotal').val(formatNumber(total));
            }




            function cekInput() {
                if (requiredCheck($("#rjpasien-radiologi-t-form"))) {
                    //var deposit = $('#deposit').val();
                    var periksaTotal = unformatNumber($('#periksaTotal').val());
                    var tr = $("#tblFormPemeriksaanRad > tbody > tr").length;
                    if (tr > 0) {
                        $('#rjpasien-radiologi-t-form').submit();
                    } else {
                        alert("Tindakan Radiologi belum dipilih");
                        return false;
                    }
                }
                return false;
            }

            function setTrue(obj) {

                var cito = $(obj).is(':checked');

                if (cito) {
                    $(obj).closest('td').find('.apa-cito').val("ya");
                } else {
                    $(obj).closest('td').find('.apa-cito').val("tidak");

                }
            }


            $(document).ready(function() {
                updateChecklistPemeriksaanRad();

                $('#formPeriksaRad').tile({
                    widths: [280],
                });

                $('.accordion-toggle').attr('style', 'width: 250px;');
                $('.glyphicon-chevron-down').attr('style', 'font-size:16px; margin-top: -30px;');
                $('.accordion-inner').attr('style', 'width: 250px;');

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
                        modul_id: <?php echo Params::MODUL_ID_RAD ?>,
                        judulnotifikasi: 'Pasien Rujukan',
                        isinotifikasi: '<?php echo $modPasien->nama_pasien ?> dengan <?php echo $modPasien->no_rekam_medik ?> telah dirujuk pada <?php echo $modKirimKeUnitLain->tgl_kirimpasien ?> dari <?php echo $modKirimKeUnitLain->ruangan->ruangan_nama ?>'
                    }; // 16 
                    insert_notifikasi(params);
                <?php
                }
                ?>

                <?php $r = RuanganM::model()->find(' ruangan_id in (' . Params::RUANGAN_ID_RAD . ') order by ruangan_nourut') ?>

                <?php if (!isset($_GET['idPasienKirimKeUnitLain'])) : ?>
                    $('#RJPasienKirimKeUnitLainT_ruangan_id').val(<?= $r->ruangan_id ?>);
                <?php endif; ?>


                var ppds = jQuery('#<?php echo CHtml::activeId($modKirimKeUnitLain, 'ppds_id') ?>');
                jQuery(ppds).multiselect({
                    includeSelectAllOption: false,
                    buttonClass: "form-control",
                    maxHeight: 300,
                    buttonWidth: '182px',
                    enableCaseInsensitiveFiltering: true
                }).hide();
            });
        </script>

<?php } ?>
    <?php }?>