<style>
    .integer {
        text-align: right;
    }
</style>
<?php
$this->breadcrumbs = array(
    'Radiologi',
);
$this->widget('bootstrap.widgets.BootAlert');
?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'rjpasien-radiologi-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#' . CHtml::activeId($modKirimKeUnitLain, 'catatandokterpengirim'),
    'htmlOptions' => array(
        'onKeyPress' => 'return disableKeyPress(event)',
        'onsubmit' => 'return requiredCheck(this);'
    ),
));

$sukses = isset($_GET['sukses'])?$_GET['sukses']:'tak de';
echo CHtml::hiddenField('sukses', $sukses);

?>

<?php 
$loginpemakai = Yii::app()->user->id;
$criteria = new CDbCriteria;
$criteria->addCondition('loginpemakai_id = ' . $loginpemakai);
$pegawai = LoginpemakaiK::model()->find($criteria);
$kelPegawai = PegawaiM::model()->findByPk($pegawai->pegawai_id);

if (!in_array(Yii::app()->user->getState('pegawai_id'), array(1, 1028)) && Yii::app()->user->getState('kelompokpegawai_id') == Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN) {



    $idPasienKirimKeUnitLain = isset($_GET['pasienkirim_id']) ? $_GET['pasienkirim_id'] : null;
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
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Tabel <b>Riwayat Pemeriksaan Radiologi Pasien</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <div class="block-tabel">
            <?php $this->renderPartial($this->path_view . '_listKirimKeUnitLain2', array('modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain)) ?>
            <div class="control-group">
                <span hidden><?php echo $form->dropDownListRow($modKirimKeUnitLain, 'kelaspelayanan_id', CHtml::listData($modPendaftaran->getKelasPelayananItems(), 'kelaspelayanan_id', 'kelaspelayanan_nama'), array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'reqKunjungan')); ?></span>
            </div>
        </div>
    </div>
</div>
<br/>
<style>
    input {
        font-family: FontAwesome;
      }
      
      #cari_modul{
        font-family: FontAwesome !important;
      }
</style>
<?php  }else{   ?>
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
                <span hidden><?php echo $form->dropDownListRow($modKirimKeUnitLain, 'kelaspelayanan_id', CHtml::listData($modPendaftaran->getKelasPelayananItems(), 'kelaspelayanan_id', 'kelaspelayanan_nama'), array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'reqKunjungan')); ?></span>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">

    <div id="form-caripemeriksaan" class="col-sm-12 form-horizontal" style="margin-bottom: 30px;">
<br>
    <div class="row">
      
        <div class="col-sm-6">
        <div class="panel panel-success">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <i class="glyphicon glyphicon-file"></i> Form <b>Perujuk</b>
                            </div>
                        </div>
                        <div class="panel-body table-responsive">
                            <?php //echo CHtml::hiddenField('ruangan_id', '', array('readonly' => true)); ?>
                      
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
                            'maxDate' => '+6m',
                        ),
                        'htmlOptions' => array('readonly' => true, 'class' => 'span3'),
                    ));
                    ?>
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
                    $modKirimKeUnitLain, 'ppds_id', CHtml::listData($modKirimKeUnitLain->getPPDS(), 'ppds_id', 'ppds_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")
            );
            ?>
         
            <?php echo $form->textAreaRow($modKirimKeUnitLain, 'catatandokterpengirim', array('placeholder' => 'Catatan', 'onkeypress' => "return $(this).focusNextInputField(event);")) ?>
            <div class='control-group'>
                <?php echo CHtml::label("Cyto <span class='required'>*</span>", CHtml::activeId($modKirimKeUnitLain, 'is_cyto'), array('class' => 'control-label required')) ?>
                <div class='controls'>
                <?php echo CHtml::activeDropDownList($modKirimKeUnitLain, 'is_cito', array('0'=>'Biasa','1'=>'Cyto'), array('onchange'=>'hitungCyto(this)','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'inputFormTabel span3')); ?>
                </div>
            </div>
            <div classs="control-group">
                <label class="control-label"></label>
                <div class="controls">
                    <?php echo $form->checkBox($modKirimKeUnitLain, 'isbayarkekasirpenunjang', array('onkeyup' => "return $(this).focusNextInputField(event);", 'title' => "Pilih jika pasien harus membayar ke kasir terlebih dahulu sebelum periksa", 'rel' => 'tooltip')) ?>
                    <label>Bayar ke Kasir</label>
                </div>
            </div>
        </div></div>
        </div>
        <div class="col-sm-6">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">
                        <i class="entypo-credit-card"></i> Tabel <b>Pemeriksaan Radiologi <?php echo isset($modJenisTarif) ? "- " . $modJenisTarif->jenistarif->jenistarif_nama : ""; ?></b>
                    </div>
                </div>
                <div class="panel-body table-responsive">
                    <div class="block-tabel">
                        <table id="tblFormPemeriksaanRad" class="table table-bordered table-condensed">
                            <thead>
                                <tr>
                                    <th>Jenis Pemeriksaan</th>
                                    <th>Pemeriksaan</th>
                                    <!--<th>Tarif</th>-->
                                    <th>Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!$modKirimKeUnitLain->isNewRecord) {
                                    $det = PermintaankepenunjangT::model()->findAllByAttributes(array(
                                        'pasienkirimkeunitlain_id'=>$modKirimKeUnitLain->pasienkirimkeunitlain_id
                                    ));

                                    foreach ($det as $item) {
                                        echo $this->renderPartial($this->path_view . '_formLoadPemeriksaanRadUpdate', array(
                                            'item' => $item, 'id_tindakan' => $item->daftartindakan_id, 'paket' => null
                                        ), true);
                                    }
                                } ?>
                            </tbody>
                        </table>
                        <table class="table table-bordered table-condensed">
                            <tr>
                                <td width="70%" style="text-align: right;">
                                    <!--Total Biaya Pemeriksaan-->
                                </td>
                                <td><?php echo CHtml::hiddenField('periksaTotal', '', array('class' => 'span2', 'style' => 'text-align:right;', 'disabled' => 'disabled')); ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php echo CHtml::hiddenField("form_index", null, array('readonly' => true)); ?>
<br><br>
    <div class="row">
        <div class="control-group" style="float:left;">
            <?php echo CHtml::activeLabel($modPemeriksaanRad, 'jenispemeriksaanrad_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::activeDropDownList($modPemeriksaanRad, 'jenispemeriksaanrad_nama', CHtml::listData(JenispemeriksaanradM::model()->findAll(array(
                    'condition' => 'jenispemeriksaanrad_aktif = true',
                    'order' => 'jenispemeriksaanrad_urutan',
                )), 'jenispemeriksaanrad_nama', 'jenispemeriksaanrad_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)", "onchange" => "updateChecklistPemeriksaanRad();", 'placeholder' => 'Nama Jenis Pemeriksaan Radiologi',)); ?>
            </div>
        </div>
        <div class="control-group" style="float:left;">
            <?php echo CHtml::activeLabel($modPemeriksaanRad, 'pemeriksaanrad_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::hiddenfield('kelaspelayanan_id', $modPendaftaran->kelaspelayanan_id) ?>
                <?php echo CHtml::activeTextField($modPemeriksaanRad, 'pemeriksaanrad_nama', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)", "onchange" => "updateChecklistPemeriksaanRad();", 'placeholder' => 'Nama Pemeriksaan Radiologi', 'style' => 'font-family: Arial, Helvetica, sans-serif;')); ?>
                <?php echo CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', "onclick" => "updateChecklistPemeriksaanRad();", 'rel' => 'tooltip', 'title' => 'Klik untuk mencari pemeriksaan')); ?>
                <?php echo CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), array('class' => 'btn btn-default', 'type' => 'button', "onclick" => "setChecklistPemeriksaanLabReset();", 'rel' => 'tooltip', 'title' => 'Klik untuk mengulang pencarian')); ?>
            </div>
        </div>
    </div>
</div>
<div class="formInputTab" style="width: 100%; overflow-x: hidden;">
    <?php echo $form->errorSummary($modKirimKeUnitLain); ?>

    <div class="row daftar-pemeriksaan" style="margin: 15px -15px;">
        <table style="width: 100%; border: none; height:500px; ">
            <tr>
                <td>
                    <div id="formPeriksaLab">
                        <?php
                        $jenisPeriksa = '';
                        foreach ($modPeriksaRad as $i => $pemeriksaan) {
                            $ceklist = false;
                            if ($pemeriksaan->jenispemeriksaanrad->jenispemeriksaanrad_aktif == false) continue;
                            if ($jenisPeriksa != $pemeriksaan->jenispemeriksaanrad->jenispemeriksaanrad_nama) {
                                $pemeriksaanrad_kode = '';
                                // mengambil data pemeriksaan kode
                                if(!empty($pemeriksaan->pemeriksaanrad_kode)) {
                                    $pemeriksaanrad_kode = $pemeriksaan->pemeriksaanrad_kode;
                                }
                                echo ($jenisPeriksa != '') ? "</div></div></div></div>" : "";
                                $jenisPeriksa = $pemeriksaan->jenispemeriksaanrad->jenispemeriksaanrad_nama;
                                echo "<div class='col-sm-4'>";
                                echo "<div class='panel panel-success'>";
                                echo "<div class='panel-heading'>"
                                    .    "  <div class='panel-title'><i class='glyphicon glyphicon-file'></i> " . $pemeriksaan->jenispemeriksaanrad->jenispemeriksaanrad_nama . "</div>";
                                echo "</div>";
                                echo "<div class='panel-body boxtindakan'  style=''>";
                                //echo "<h6>".$pemeriksaan->jenispemeriksaanrad->jenispemeriksaanrad_nama."</h6>";
                                echo '<label class="checkbox inline">' . CHtml::checkBox("pemeriksaanRad[]", $ceklist, array(
                                    'value' => $pemeriksaan->pemeriksaanrad_id,
                                    'onclick' => "inputperiksa(this);"
                                ));
                                echo "<span>" . $pemeriksaan->pemeriksaanrad_nama . ' - '. $pemeriksaanrad_kode . "</span></label><br>";
                            } else {
                                $jenisPeriksa = $pemeriksaan->jenispemeriksaanrad->jenispemeriksaanrad_nama;
                                echo '<label class="checkbox inline">' . CHtml::checkBox("pemeriksaanRad[]", $ceklist, array(
                                    'value' => $pemeriksaan->pemeriksaanrad_id,
                                    'onclick' => "inputperiksa(this);"
                                ));
                                $pemeriksaanrad_kode = '';
                                if(!empty($pemeriksaan->pemeriksaanrad_kode)) {
                                    $pemeriksaanrad_kode = $pemeriksaan->pemeriksaanrad_kode;
                                }
                                echo "<span>" . $pemeriksaan->pemeriksaanrad_nama . ' - '.  $pemeriksaanrad_kode ."</span></label><br>";
                            }
                        }
                        echo "</div></div></div></div>";
                        ?>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    
    <div class="form-actions">
        <?php echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
            array('class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'cekInput();', 'onKeypress' => 'return formSubmit(this,event)', 'id' => 'btn_simpan')
        );
        ?>
        <?php
        if (isset($_GET['pasienkirim_id'])) {
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

        $idPasienKirimKeUnitLain = isset($_GET['pasienkirim_id']) ? $_GET['pasienkirim_id'] : null;
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
<?php } ?> 
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
    function inputperiksa(obj) {
        if ($(obj).is(':checked')) {
            var pemeriksaanrad_id = obj.value;
            var kelaspelayanan_id = $('#<?php echo CHtml::activeId($modKirimKeUnitLain, 'kelaspelayanan_id') ?>').val();
            var pendaftaran_id = '<?php echo $modPendaftaran->pendaftaran_id; ?>';
            if (kelaspelayanan_id === '') {
                myAlert("Silakan pilih kelas pelayanan terlebih dahulu!");
                $(obj).attr('checked', false);
                return false;
            }
            jQuery.ajax({
                'url': '<?php echo Yii::app()->createUrl('rawatJalan/radiologi/loadFormPemeriksaanRad') ?>',
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
                        myAlert("Pemeriksaan belum memilik tarif silakan hubungi SIMRS untuk memeriksa tarif pemeriksaan tersebut");
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
        } else {
            batalPeriksa(obj.value);
            hitungTotal();
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

    function batalPeriksa(idPemeriksaanrad) {
        $('#tblFormPemeriksaanRad #periksarad_' + idPemeriksaanrad).detach();
        if ($('#tblFormPemeriksaanRad tr').length == 1)
            $('#tblFormPemeriksaanRad').append('<tr id="trPeriksaRadKosong"><td colspan="4"></td></tr>');
    }

    function batalKirim(pasienkirimkeunitlain_id, pendaftaran_id) {
        myConfirm("Apakah Anda akan membatalkan kirim pasien ke Radiologi?", "Perhatian!", function(r) {
            if (r) {
                $.post('<?php echo $this->createUrl('ajaxBatalKirim') ?>', {
                    pasienkirimkeunitlain_id: pasienkirimkeunitlain_id,
                    pendaftaran_id: pendaftaran_id
                }, function(data) {
                    $('#tblListPemeriksaanRad').html(data.result);
                    myAlert(data.pesan);
                }, 'json');
            }
        });
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
    });
    /**
     * update (refresh) checklist pemeriksaan lab
     * harus include /js/jquery.tiler.js
     * @param {obj} form_checklist
     */
    function updateChecklistPemeriksaanRad() {
        var form_index = $('#form_index').val();
        var cek = [];

        $('#tblFormPemeriksaanRad tbody tr').each(function() {

            var id = $(this).attr('id');
            cek.push(parseInt(id.replace('periksarad_', '')));
            // cek.push('');

        });

        $('.daftar-pemeriksaan').addClass("animation-loading");
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('/rawatJalan/radiologi/SetChecklistPemeriksaanRad'); ?>',
            data: {
                data: $("#form-caripemeriksaan :input").serialize()
            },
            dataType: "json",
            success: function(data) {
                $('.daftar-pemeriksaan').html(data.content);
                cekScreen();
                // $('.checkboxlist-tile').tile({widths : [ 190 ]});
                $('.daftar-pemeriksaan').removeClass("animation-loading");
                // setCheckedPemeriksaan($("#form-tindakanpemeriksaan-"+form_index),$('.daftar-pemeriksaan'));

                var cekc = [];
                $.each(cek, function(key, val) {

                    $('#formPeriksaRad').find('input[type="checkbox"][value="' + val + '"]').prop("checked", "checked");
                    cekc.push(val);

                });

            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    /**
     * set checked pemeriksaan yang sudah ada di daftar
     */
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


    $(document).ready(function() {
           var pemeriksaanrad = jQuery('#<?php echo CHtml::activeId($modPemeriksaanRad, 'jenispemeriksaanrad_nama') ?>');	
           jQuery(pemeriksaanrad).multiselect({
                   includeSelectAllOption: false,
                   buttonClass: "form-control",
                   maxHeight: 300,
                   buttonWidth: '182px',
                   enableCaseInsensitiveFiltering: true
           }).hide();
        <?php if ($this->action->id == "update"): ?>
            updateChecklistPemeriksaanRad();
        <?php endif; ?>
    });


    function searchPemeriksaanRAD() {
            $('#rjpasien-laboratorium-t-form input[name*="jenispemeriksaanrad_nama"]').each(function() {
            });
    }

   

    $(document).ready(function() {
           var pegawai = jQuery('#<?php echo CHtml::activeId($modKirimKeUnitLain, 'pegawai_id') ?>');	
           jQuery(pegawai).multiselect({
                   includeSelectAllOption: false,
                   buttonClass: "form-control",
                   maxHeight: 300,
                   buttonWidth: '182px',
                   enableCaseInsensitiveFiltering: true
           }).hide();
       });


    function searchPegawai() {
            $('#rjpasien-laboratorium-t-form input[name*="pegawai_id"]').each(function() {
            });
    }



    $(document).ready(function() {
           var ppds = jQuery('#<?php echo CHtml::activeId($modKirimKeUnitLain, 'ppds_id') ?>');	
           jQuery(ppds).multiselect({
                   includeSelectAllOption: false,
                   buttonClass: "form-control",
                   maxHeight: 300,
                   buttonWidth: '182px',
                   enableCaseInsensitiveFiltering: true
           }).hide();
       });


    function searchPegawai() {
            $('#rjpasien-laboratorium-t-form input[name*="ppds_id"]').each(function() {
            });
    }
    
</script>
