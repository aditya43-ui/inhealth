<?php

$pg_login = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
$pg_loginpps = PpdsM::model()->findByPk(Yii::app()->user->getState('ppds_id'));

$modul_id = Yii::app()->user->getState('modul_id');
// $readonly = $pg_login->kelompokpegawai_id == 2 && $modul_id != 7;
if(!empty($pg_login->kelompokpegawai_id)){
    $readonly = $pg_login->kelompokpegawai_id == 2 && $modul_id != 7;
}
if (!empty($pg_loginpps->kelompokpegawai_id)){
    $readonly = $pg_loginpps->kelompokpegawai_id == 2 && $modul_id != 7;

}
$hide = $readonly ? " hide" : "";
$hidden = $readonly ? " hidden" : "";
$display = "display:" . ($readonly ? " none;" : "block;");
$visibility = "visibility:" . ($readonly ? " visible; " : "hidden; ");


?>

<?php
$this->breadcrumbs = array(
    'Bedah Sentral',
);
?>
<?php
if (isset($_GET['sukses'])) {
    Yii::app()->user->setFlash('success', "Data berhasil disimpan!");
}

// if (isset($_GET['hapusdata'])) {
//     Yii::app()->user->setFlash('success', "Data berhasil dihapus!");
// }

$this->widget('bootstrap.widgets.BootAlert');
?>
<!--<legend class="rim2">Bedah Sentral</legend>-->
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.tiler.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'rjkonsul-poli-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#' . CHtml::activeId($modKirimKeUnitLain, 'catatandokterpengirim'),
    'htmlOptions' => array(
        'onKeyPress' => 'return disableKeyPress(event)',
        'onsubmit' => 'return requiredCheck(this);'
    ),
));
?>
<div class="formInputTab">
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="entypo-credit-card"></i> Tabel <b>Riwayat Bedah Sentral Pasien</b>
            </div>
        </div>
        <div class="panel-body table-responsive">
            <div class="block-tabel">
                <?php $this->renderPartial($this->path_view . '_listKirimKeUnitLain', array('modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain, 'modDaftar' => $modPendaftaran)) ?>
            </div>
        </div>
    </div>
    <?php
    if (!in_array(Yii::app()->user->getState('pegawai_id'), array(1, 1028)) && strtolower($this->id) == "bedahsentraltrd" && Yii::app()->user->getState('kelompokpegawai_id') == Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN) {
        goto formEnd;
    } ?>
    <div class="panel panel-success" <?=$hidden?>>
        <div class="panel-heading">
            <div class="panel-title">
                <i class="entypo-credit-card"></i><b>Daftar Rencana Operasi</b>
            </div>
        </div>
        <div class="panel-body table-responsive">
            <div class="antirow">
                <div class="row">
                    <div class="col-sm-6">
                        <?php echo CHtml::hiddenField('url', $this->createUrl('', array('pendaftaran_id' => $modPendaftaran->pendaftaran_id)), array('readonly' => TRUE)); ?>
                        <?php echo CHtml::hiddenField('berubah', '', array('readonly' => TRUE)); ?>
                        <div class="control-group">
                            <?php //echo $form->labelEx($modKirimKeUnitLain, 'tgl_kirimpasien', array('class' => 'control-label')) 
                            ?>
                            <?php echo CHtml::label("Tanggal Kirim Permintaan <span class='required'>*</span>", '', array('class' => 'control-label')); ?>
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
                                    'htmlOptions' => array('readonly' => true, 'class' => 'readonly'),
                                ));
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label("Tanggal Rencana Operasi <span class='required'>*</span>", '', array('class' => 'control-label')); ?>
                            <?php $modKirimKeUnitLain->tglrencanaoperasi = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modKirimKeUnitLain->tglrencanaoperasi, 'yyyy-MM-dd hh:mm:ss', 'medium', null)); ?>
                            <div class="controls">
                                <?php
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $modKirimKeUnitLain,
                                    'attribute' => 'tglrencanaoperasi',
                                    'mode' => 'datetime',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                    ),
                                    'htmlOptions' => array('readonly' => true, 'class' => 'readonly'),
                                ));
                                ?>
                            </div>
                            <!-- <div class="controls">
                        <?php // echo $form->checkBox($modKirimKeUnitLain, 'is_elektif', array('id'=>'is_elektif')); 

                        ?> <label for="is_elektif">Operasi
                            Elektif</label>
                    </div> -->
                    <?php

                        $modul = Yii::app()->user->getState('modul_id');

                        $cd = new CDbCriteria;
                        $cd->select = 'distinct pegawai_id, nama_pegawai, gelarbelakang_nama';
                        $cd->addCondition('kelompokpegawai_id <> 21 and gelarbelakang_nama <> \'Sp.EM\' and pegawai_aktif is true');
                        $cd->order = 'nama_pegawai';
                        $dokters = DokterV::model()->findAll($cd);
                    
                    ?>
                        </div>

                        <?php if($modul == Params::MODUL_ID_RD):?>
                            <?php echo $form->dropDownListRow($modKirimKeUnitLain, 'pegawai_id', CHtml::listData($dokters, 'pegawai_id', 'NamaLengkap'), array('empty' => '-- Pilih --', 'class' => 'span4 multiselect required', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        <?php else:?>
                            <?php echo $form->dropDownListRow($modKirimKeUnitLain, 'pegawai_id', CHtml::listData($modKirimKeUnitLain->getDokterItems(), 'pegawai_id', 'NamaLengkap'), array('empty' => '-- Pilih --', 'class' => 'span5 required', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        <?php endif;?>
                        <span id="urut-<?php echo str_replace(' ', '-', strtolower(Params::KRUBEDAH_PPDS)); ?>">
                            <div class="control-group pelaksanaoperasi awal">
                                <?php echo CHtml::label('PPDS ' . " ", 'ppds_id', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php echo $form->dropDownList($modRencanaOperasi, 'ppds_id', CHtml::listData($modRencanaOperasi->getPPDS(), 'ppds_id', 'ppds_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span4 krubedah_id')); ?>
                                </div>
                            </div>
                            <div class='control-group'>
                                <?php echo CHtml::label("Ruangan <span class='required'>*</span>", CHtml::activeId($modKirimKeUnitLain, 'is_cyto'), array('class' => 'control-label required')) ?>
                                <div class='controls'>
                                    <?php

                                    $listRuangan = RuanganM::model()->findAllByAttributes(array(
                                        'instalasi_id' => 7, 'ruangan_aktif' => true
                                    ), array(
                                        'order' => 'ruangan_nama'
                                    ));
                                    $listItemRuangan = CHtml::listData($listRuangan, 'ruangan_id', 'ruangan_nama');
                                    $listOptionRuangan = array();
                                    foreach ($listRuangan as $item) {
                                        $listOptionRuangan[$item->ruangan_id] = array(
                                            'data-batas' => $item->is_batasorderbedah ? 1 : 0
                                        );
                                    }


                                    echo CHtml::activeDropDownList($modKirimKeUnitLain, 'ruangan_id', $listItemRuangan, array('empty' => '-- Pilih --', 'onchange' => 'hitungBatasRuangan();', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'inputFormTabel span4 input_ruangan_id', 'options' => $listOptionRuangan));
                                    ?>
                                </div>
                            </div>


                            <?php
                            if (!empty($modRencanaOperasi->rencanaoperasi_id)) {
                                $look = $modRencanaOperasi->getKruBedahByLookup(Params::KRUBEDAH_PPDS, $modRencanaOperasi->rencanaoperasi_id);
                                if (count((array)$look) > 0) {
                                    $length = 1;
                                    foreach ($look as $det) {
                                        $det->pegawai_nama = $det->pegawai->namaLengkap;
                                        echo $this->renderPartial($this->path_view . '_rowKruBedah', array('length' => $length, 'model' => $det, 'i' => $i), true);
                                        $i++;
                                        $length++;
                                    }
                                }
                            }
                            ?>
                        </span>
                        <?php
                        echo $this->renderPartial($this->path_view . '_inputKruBedah', array('form' => $form, 'modKirimKeUnitLain' => $modKirimKeUnitLain, 'modRencanaOperasi' => $modRencanaOperasi));
                        ?>


                        <div class="control-group">
                            <?php echo CHtml::label('Indikasi Operasi', '', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textArea($modKirimKeUnitLain, 'indikasioperasi', array('class' => 'span5')); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('Sifat Operasi', '', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($modKirimKeUnitLain, 'sifatoperasi', array('placeholder' => '', 'class' => 'span5', 'readonly' => false)) ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('Vital Sign Terakhir', '', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textArea($modKirimKeUnitLain, 'vitalsignterakhir', array('class' => 'span5')); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('Catatan Permintaan', '', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textArea($modKirimKeUnitLain, 'catatandokterpengirim', array('class' => 'span5')); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('Estimasi Lama Operasi'  . " <span class='required'>*</span>", '', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($modKirimKeUnitLain, 'estimasioperasi', array('placeholder' => '', 'class' => 'span4 float3 required', 'readonly' => false)) ?>&emsp;<label>Jam</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <?php
                        echo $this->renderPartial(
                            $this->path_view . '_formRencanaOperasi',
                            array('modPendaftaran' => $modPendaftaran, 'modJenisTarif' => $modJenisTarif, 'modKirimKeUnitLain' => $modKirimKeUnitLain)
                        );
                        ?>
                        <div class="form-actions">
                            <?php if (isset($_GET['lihat'])) { ?>
                            <?php } else { ?>
                                <?php
                                echo CHtml::htmlButton(
                                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                                    array('class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'id' => 'btn_simpan', 'disabled'=>$modPendaftaran->isPasienPulangAtauTindakLanjut($_GET['konsulpoli_id'] ?? null))
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
                            <?php } ?>

                            <?php
                            $content = $this->renderPartial('rawatJalan.views.tips.tips', array(), true);
                            $this->widget('UserTips', array('type' => 'admin', 'content' => $content));
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row" style="margin-top: 20px; margin-left: 20px;" <?=$hidden?>>
        <div class="control-group" style="float:left;">
            <?php echo CHtml::label('Kegiatan Operasi', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::dropDownList("kegiatan_operasi", '', CHtml::listData(RJKegiatanOperasiM::model()->findAll(" kegiatanoperasi_aktif is true ORDER BY kegiatanoperasi_nama ASC "), 'kegiatanoperasi_id', 'kegiatanoperasi_nama'), array('empty' => '-- Pilih --', "onchange" => "updateChecklistOperasi();", 'placeholder' => 'Nama Jenis Operasi')); ?>
            </div>
        </div>
        <div class="control-group" style="float:left;">
            <?php echo CHtml::label('Operasi', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::textField("operasi", '', array('class' => 'inputFormTabel lebar3', "onkeyup" => "updateChecklistOperasi();", 'placeholder' => 'Nama Operasi', 'style' => 'font-family: Arial, Helvetica, sans-serif;')); ?>
                <?php echo CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', "onclick" => "updateChecklistOperasi();", 'rel' => 'tooltip', 'title' => 'Klik untuk mencari pemeriksaan')); ?>
                <?php echo CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), array('class' => 'btn btn-default', 'type' => 'button', "onclick" => "setChecklistOperasiReset();", 'rel' => 'tooltip', 'title' => 'Klik untuk mengulang pencarian')); ?>
            </div>
        </div>
    </div>
    <table style="width: 100%; border: none; margin-top: 17px;" <?=$hidden?>>
        <tr>
            <td>
                <div id="formOperasi">
                    <?php echo $this->renderPartial($this->path_view . '_formOperasi', array('modKegiatanOperasi' => $modKegiatanOperasi, 'modOperasi' => $modOperasi)); ?>
                    <?php echo $form->errorSummary($modKirimKeUnitLain); ?>
                </div>
            </td>
        </tr>
    </table>
    <?php formEnd: ?>
</div>
<?php $this->endWidget(); ?>

<?php
$idPasienKirimKeUnitLain = isset($_GET['idPasienKirimKeUnitLain']) ? $_GET['idPasienKirimKeUnitLain'] : null;
$urlPrint = Yii::app()->createAbsoluteUrl($this->module->id . '/' . $this->id . '/print&id=' . $modPendaftaran->pendaftaran_id . '&idPasienKirimKeUnitLain=' . $idPasienKirimKeUnitLain);
$urlPrintRiwayat = Yii::app()->createAbsoluteUrl($this->module->id . '/' . $this->id . '/printRiwayat&id=' . $modPendaftaran->pendaftaran_id);
$urlPrintRujukan =  Yii::app()->createAbsoluteUrl($this->module->id . '/' . $this->id . '/printRujukan&id=' . $modPendaftaran->pendaftaran_id);
$urlIndex =  Yii::app()->createAbsoluteUrl($this->module->id . '/' . $this->id . '/index&id=' . $modPendaftaran->pendaftaran_id);
$js = <<< JSCRIPT
function printRujukan(caraPrint,rujukankeluar_id){
    window.open("${urlPrintRujukan}&rujukankeluar_id="+rujukankeluar_id+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
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

echo $this->renderPartial('rawatJalan.views.bedahSentralNew._dialog', ['modPendaftaran' => $modPendaftaran], true);
echo $this->renderPartial('rawatJalan.views.bedahSentralNew._jsFunctionElektif', ['modPendaftaran' => $modPendaftaran], true);
?>

<?php
$konfig = KonfigsystemK::model()->find();
$batas_jam = $konfig->jambataspesanbedah ?? 24;
?>

<script type="text/javascript">
    var batasjam = <?php echo $batas_jam; ?>;
    var kirim = '<?php echo isset($_GET['idPasienKirimKeUnitLain']) ? $_GET['idPasienKirimKeUnitLain'] : '' ?>';

    function batalKirim(idPasienKirimKeUnitLain, pendaftaran_id, obj) {

        console.log(kirim == idPasienKirimKeUnitLain);

        myConfirm("Apakah Anda akan membatalkan kirim pasien ke Bedah Sentral?", "Perhatian!", function(r) {
            if (r) {
                $.post('<?php echo $this->createUrl('ajaxBatalKirim') ?>', {
                    idPasienKirimKeUnitLain: idPasienKirimKeUnitLain,
                    pendaftaran_id: pendaftaran_id
                }, function(data) {
                    window.location.replace('<?php echo $this->createUrl('index', array('pendaftaran_id' => $modPendaftaran->pendaftaran_id, 'hapusdata' => 1)); ?>');


                    myAlert(data.pesan);
                }, 'json');
            }
        });
    }

    function hitungBatasRuangan() {

        var ruangan_nama = $(".input_ruangan_id option:selected").html();
        var is_batas = $(".input_ruangan_id option:selected").data('batas');
        var currentTime = new Date();
        var currentHours = currentTime.getHours();
        /*
        if (is_batas == 1 && currentHours >= batasjam) {
            myAlert("Pemesanan ke ruangan " + ruangan_nama + " dibatasi sampai jam " + batasjam + ".");
            $(".input_ruangan_id").val(null).change();
            return false;
        }
        */
        return true;

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
                modul_id: <?php echo Params::MODUL_ID_BEDAHSENTRAL ?>,
                judulnotifikasi: 'Pasien Rujukan',
                isinotifikasi: '<?php echo $modPasien->nama_pasien ?> dengan <?php echo $modPasien->no_rekam_medik ?> telah dirujuk pada <?php echo $modKirimKeUnitLain->tgl_kirimpasien ?> dari <?php echo $modKirimKeUnitLain->ruangan->ruangan_nama ?>'
            }; // 16 
            insert_notifikasi(params);
        <?php
        }
        ?>
        updateChecklistOperasi();

    $(".float3").maskMoney(
        {"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":"","precision":1}
    );
});
</script>


<script>
    $('#formOperasi').tile({
        widths: [350]
    });
    $('.accordion-toggle').attr('style', 'width: 350px; margin-right: 200px;');
    $('.glyphicon-chevron-down').attr('style', 'font-size:16px; margin-top: -30px;');
    $('.accordion-inner').attr('style', 'width: 350px;');
    $('.jquery-tiler-column').attr('style', 'float: left; width: 350px; margin-right: 40px;');
</script>
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
    function updateChecklistOperasi() {

        var cek = [];

        var kegiatan_operasi = $('#kegiatan_operasi').val();
        var operasi = $('#operasi').val();

        $(".tr-operasi").each(function() {

            var id = $(this).find('.operasi_id').val();
            cek.push(id);
        });

        console.log(cek);

        $('#formOperasi').addClass("animation-loading");

        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('/rawatJalan/bedahSentralNew/SetChecklistOperasi'); ?>',
            data: {
                kegiatan_operasi: kegiatan_operasi,
                operasi: operasi,
            }, //
            dataType: "json",
            success: function(data) {
                $('#formOperasi').html(data.content);

                $('#formOperasi').tile({
                    widths: [350]
                });
                $('.accordion-toggle').attr('style', 'width: 350px; margin-right: 200px;');
                $('.glyphicon-chevron-down').attr('style', 'font-size:16px; margin-top: -30px;');
                $('.accordion-inner').attr('style', 'width: 350px;');
                $('.jquery-tiler-column').attr('style', 'float: left; width: 350px; margin-right: 40px;');

                if (cek.length > 0) {

                    cek.forEach(function(val, idx) {
                        $('#formOperasi').find('input[type="checkbox"][value="' + val + '"]').prop("checked", "checked");

                    });
                }


            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });

        $('#formOperasi').removeClass("animation-loading");


        $(document).ready(function() {

            var dpjp = jQuery('#<?php echo CHtml::activeId($modKirimKeUnitLain, 'pegawai_id') ?>');

            jQuery(dpjp).multiselect({
            includeSelectAllOption: false,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '240px',
            enableCaseInsensitiveFiltering: true
        }).hide();

});


    }
</script>