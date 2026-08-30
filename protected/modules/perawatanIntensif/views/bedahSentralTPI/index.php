<?php
$this->breadcrumbs = array(
    'Bedah Sentral',
);

$this->widget('bootstrap.widgets.BootAlert');
//$this->renderPartial('/_ringkasDataPasien',array('modPendaftaran'=>$modPendaftaran,'modPasien'=>$modPasien,'modAdmisi'=>$modAdmisi));
//
//echo '<legend class="rim">BEDAH SENTRAL</legend><hr>';
//$this->renderPartial('/_tabulasi',array('modPendaftaran'=>$modPendaftaran, 'modAdmisi'=>$modAdmisi));
?>
<style type="text/css">
    #form-carioperasi {
        width: 330px;
    }
</style>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.tiler.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'rjbedahsentral-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#' . CHtml::activeId($modKirimKeUnitLain, 'catatandokterpengirim'),
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
)); ?>
<legend class="rim">Tabel Riwayat Bedah Sentral Pasien</legend>
<?php $this->renderPartial('_listKirimKeUnitLain', array('modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain)) ?>

<div class="formInputTab">
    <!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') 
                                ?></p>-->

    <?php echo $form->errorSummary($modKirimKeUnitLain, $modPasienMasukPenunjang); ?>

    <div id='content-operasi' class='box'>
        <?php
        echo $this->renderPartial('_formCariOperasi', array(
            'kegiatanOperasiSearch' => $kegiatanOperasiSearch,
            'operasiSearch' => $operasiSearch
        ));
        ?>
        <div class='checklists_operasi'>
            <?php
            echo $this->renderPartial('_formOperasi', array(
                'modKegiatanOperasi' => $modKegiatanOperasi,
                'modOperasi' => $modOperasi
            ));
            ?>
        </div>
    </div>
    <table style="width: 100%; border: none;">
        <tr>
            <td width="50%">
                <?php echo CHtml::hiddenField('deposit', $modDeposit, array('onclick' => 'cekInput()')); ?>
                <div class="control-group">
                    <?php echo $form->labelEx($modKirimKeUnitLain, 'tgl_kirimpasien', array('class' => 'control-label')) ?>
                    <?php $modKirimKeUnitLain->tgl_kirimpasien = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modKirimKeUnitLain->tgl_kirimpasien, 'yyyy-MM-dd hh:mm:ss', 'medium', null)); ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $modKirimKeUnitLain,
                            'attribute' => 'tgl_kirimpasien',
                            'mode' => 'datetime',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate' => '+6m',
                            ),
                            'htmlOptions' => array('readonly' => true),
                        )); ?>
                    </div>
                </div>
                <?php echo $form->dropDownListRow(
                    $modKirimKeUnitLain,
                    'pegawai_id',
                    CHtml::listData($modKirimKeUnitLain->getDokterItems(), 'pegawai_id', 'NamaLengkap'),
                    array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")
                ); ?>
                    <?php
            echo $form->dropDownListRow(
                    $modKirimKeUnitLain, 'ppds_id', CHtml::listData($modKirimKeUnitLain->getPPDS(), 'ppds_id', 'ppds_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")
            );
            ?>
         
                <?php echo $form->textAreaRow($modKirimKeUnitLain, 'catatandokterpengirim', array('onkeypress' => "return $(this).focusNextInputField(event);")) ?>
                <div class='control-group'>
                        <?php echo CHtml::label("Ruangan <span class='required'>*</span>", CHtml::activeId($modKirimKeUnitLain, 'is_cyto'), array('class' => 'control-label required')) ?>
                        <div class='controls'>
                            <?php 
                            
                            $listRuangan = RuanganM::model()->findAllByAttributes(array(
                                'instalasi_id' => 7, 'ruangan_aktif'=>true
                            ), array(
                                'order'=>'ruangan_nama'
                            ));
                            $listItemRuangan = CHtml::listData($listRuangan, 'ruangan_id', 'ruangan_nama');
                            $listOptionRuangan = array();
                            foreach ($listRuangan as $item) {
                                $listOptionRuangan[$item->ruangan_id] = array(
                                    'data-batas' => $item->is_batasorderbedah ? 1 : 0
                                );
                            }
                            
                            
                            echo CHtml::activeDropDownList($modKirimKeUnitLain, 'ruangan_id', $listItemRuangan, array('empty' => '-- Pilih --','onchange'=>'hitungBatasRuangan();','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'inputFormTabel span3 input_ruangan_id', 'options'=>$listOptionRuangan)); ?>
                        </div>
                    </div>
                <div class='control-group'>
                    <?php echo CHtml::label("Cyto <span class='required'>*</span>", CHtml::activeId($modKirimKeUnitLain, 'is_cyto'), array('class' => 'control-label required')) ?>
                    <div class='controls'>
                        <?php echo CHtml::activeDropDownList($modKirimKeUnitLain, 'is_cyto', array('0' => 'Biasa', '1' => 'Cyto'), array('onchange' => 'hitungCyto(this)', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'inputFormTabel span3')); ?>
                    </div>
                </div>
            </td>
            <td width="50%">
                <legend class="rim">Tabel Tindakan Rencana Operasi <?php echo isset($modJenisTarif) ? "- " . $modJenisTarif->jenistarif->jenistarif_nama : ""; ?></legend>
                <?php echo $this->renderPartial(
                    '_formRencanaOperasi',
                    array('modPendaftaran' => $modPendaftaran, 'modJenisTarif' => $modJenisTarif)
                ); ?>
            </td>
        </tr>
    </table>

    <div class="form-actions">
        <?php echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
            array('class' => 'btn btn-danger', 'id' => 'btn_submit', 'onKeypress' => 'cekInput()', 'onclick' => 'cekInput()')
        ); ?>
        <?php
        if (isset($_GET['idPasienKirimKeUnitLain'])) {
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
        } else {
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'disabled' => 'disabled'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'disabled' => 'disabled'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'disabled' => 'disabled'));
        }
        $content = $this->renderPartial('../tips/tips', array(), true);
        $this->widget('UserTips', array('type' => 'admin', 'content' => $content)); ?>
    </div>

</div>
<?php $this->endWidget(); ?>
<?php
$idPasienKirimKeUnitLain = isset($_GET['idPasienKirimKeUnitLain']) ? $_GET['idPasienKirimKeUnitLain'] : null;
$urlPrint = Yii::app()->createAbsoluteUrl($this->module->id . '/' . $this->id . '/print&id=' . $modPendaftaran->pendaftaran_id . '&idPasienKirimKeUnitLain=' . $idPasienKirimKeUnitLain);
$urlPrintRiwayat = Yii::app()->createAbsoluteUrl($this->module->id . '/' . $this->id . '/printRiwayat&id=' . $modPendaftaran->pendaftaran_id);

$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}&caraPrint="+caraPrint,"",'location=_new, width=460px');
}
function printRiwayat(caraPrint)
{
    window.open("${urlPrintRiwayat}&caraPrint="+caraPrint,"",'location=_new, width=900px');
}

JSCRIPT;
Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
?>
<?php 
$konfig = KonfigsystemK::model()->find(); 
$batas_jam = $konfig->jambataspesanbedah ?? 24;
?>
<script type="text/javascript">

    var singkatan_waktu = {'Asia/Jakarta': 'WIB', 'Asia/Makassar': 'WITA', 'Asia/Jayapura': 'WIT'};
    var mon = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"];
    var batasjam = <?php echo $batas_jam; ?>;

    //function batalKirim(idPasienKirimKeUnitLain,pendaftaran_id)
    //{
    //    window.parent.myConfirm("Apakah Anda akan membatalkan kirim pasien ke Bedah Sentral?","Perhatian!",function(r) {
    //        if(r){
    //            $.post('<?php echo $this->createUrl('ajaxBatalKirim') ?>', {idPasienKirimKeUnitLain: idPasienKirimKeUnitLain, pendaftaran_id:pendaftaran_id}, function(data){
    //                $('#tblListRencanaOperasi').html(data.result);
    //            }, 'json');
    //        }
    //    });
    //}

    function hitungTotal() {
        var total = 0;
        $('.tarif_satuan').each(
            function() {
                qty = $(this).parents('tr').find('.qty').val();
                total += unformatNumber(this.value) * qty;
            }
        );

        $('#totalTarif').val(formatNumber(total));
    }

    function hitungTotalTarif() {
        var totalTarif = 0;
        $('#tbl_tarifkonsulgizi > tbody > tr').each(function() {
            totalTarif += unformatNumber($(this).find('label[name*="[harga_tariftindakan]"]').val());
        });
        $('#totalTarif').val(formatNumber(totalTarif));
    }

    function hitungBatasRuangan() {

        var ruangan_nama = $(".input_ruangan_id option:selected").html();
        var is_batas = $(".input_ruangan_id option:selected").data('batas');
        var currentTime = new Date();
        var currentHours = currentTime.getHours();
        if (is_batas == 1 && currentHours >= batasjam) {
            myAlert("Pemesanan ke ruangan " + ruangan_nama + " dibatasi sampai jam " + batasjam + ".");
            $(".input_ruangan_id").val(null).change();
            return false;
        }

    }

    function cekInput() {
        var deposit = $('#deposit').val();
        var totalTarif = unformatNumber($('#totalTarif').val());
        var pemeriksaan = $('#tblFormRencanaOperasi > tbody tr').length;
        if (pemeriksaan <= 0) {
            window.parent.myAlert("Pilih dahulu pemeriksaan");
            return false;
        }
        if (deposit == "") {
            //		window.parent.myConfirm("Pasien Belum Melakukan Deposit!","Perhatian!",function(r) {
            //		   if(r){	
            // notifikasi
            var totalTarif = $('#totalTarif').val();
            var params = [];
            params = {
                instalasi_id: <?php echo Yii::app()->user->getState("instalasi_id"); ?>,
                modul_id: 19,
                judulnotifikasi: 'Deposit Tidak Mencukupi',
                isinotifikasi: '<?php echo $modPasien->nama_pasien ?> / <?php echo $modPasien->no_rekam_medik;
                                                                        echo "-";
                                                                        echo $modPendaftaran->no_pendaftaran; ?> diruangan <?php echo $modPendaftaran->ruangan->ruangan_nama ?> tidak mencukupi. Total  Deposit = Rp <?php echo isset($modDeposit) ? MyFormatter::formatUang($modDeposit) : 0; ?>. Total Tagihan = Rp ' + totalTarif + '. Silakan hubungi kasir'
            };
            insert_notifikasi(params);
            disableOnSubmit('#btn_submit');
            setTimeout(function() {
                $('#rjbedahsentral-t-form').submit();
            }, 2000);
            //		   }
            //	   });
        } else if (deposit < totalTarif) {
            window.parent.myConfirm("Uang deposit tidak mencukupi, Silakan hubungi kasir!", "Perhatian!", function(r) {
                if (r) {
                    // notifikasi
                    var totalTarif = $('#totalTarif').val();
                    var params = [];
                    params = {
                        instalasi_id: <?php echo Yii::app()->user->getState("instalasi_id"); ?>,
                        modul_id: 19,
                        judulnotifikasi: 'Deposit Tidak Mencukupi',
                        isinotifikasi: '<?php echo $modPasien->nama_pasien ?> / <?php echo $modPasien->no_rekam_medik;
                                                                                echo "-";
                                                                                echo $modPendaftaran->no_pendaftaran; ?> diruangan <?php echo $modPendaftaran->ruangan->ruangan_nama ?> tidak mencukupi. Total  Deposit = Rp <?php echo isset($modDeposit) ? MyFormatter::formatUang($modDeposit) : 0; ?>. Total Tagihan = Rp ' + totalTarif + '. Silakan hubungi kasir'
                    };
                    simpanNotifikasi(params);
                    disableOnSubmit('#btn_submit');
                    setTimeout(function() {
                        $('#rjbedahsentral-t-form').submit();
                    }, 2000);
                }
            });
        } else {
            $('#rjbedahsentral-t-form').submit();
        }
    }

    $(document).ready(function() {
        <?php
        if (isset($modKirimKeUnitLain->pasienkirimkeunitlain_id)) {
        ?>
            var params = [];
            params = {
                instalasi_id: <?php echo Yii::app()->user->getState("instalasi_id"); ?>,
                modul_id: <?php echo Params::MODUL_ID_BEDAHSENTRAL ?>,
                judulnotifikasi: 'Pasien Rujukan',
                isinotifikasi: '<?php echo $modPasien->nama_pasien ?> dengan <?php echo $modPasien->no_rekam_medik ?> telah dirujuk pada <?php echo $modKirimKeUnitLain->tgl_kirimpasien ?> dari <?php echo $modKirimKeUnitLain->ruangan->ruangan_nama ?>'
            }; // 16 
            simpanNotifikasi(params);
        <?php
        }
        ?>
    })
</script>
<?php echo $this->renderPartial('_jsFunctions', array()); ?>