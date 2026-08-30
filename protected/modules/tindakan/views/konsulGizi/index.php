<?php
$this->breadcrumbs = array(
    'Konsul Gizi',
);

$this->widget('bootstrap.widgets.BootAlert');
?>
<!--<legend class="rim2">Konsultasi Gizi</legend>-->
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'rjpasien-konsulGizi-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onSubmit' => 'return cekInputan(this);'),
    'focus' => '#' . CHtml::activeId($modKirimKeUnitLain, 'catatandokterpengirim'),
)); ?>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Tabel <b>Pelayanan Konsultasi Gizi</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <div id="tblGizi">
            <div class="col-sm-6">
                <table id="tblFormPermintaanGizi" class="table table-bordered table-striped table-condensed">
                    <thead>
                        <tr>
                            <th>Pilih</th>
                            <th>Pelayanan</th>
                            <!--<th>Tarif</th>-->
                        </tr>
                    </thead>
                    <tbody id="bodyTblFormPermintaanGizi"></tbody>
                </table>
            </div>
            <div class="col-sm-6">
                <?php $this->renderPartial($this->path_view . '_listKirimKeUnitLain', array('modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain)) ?>
                <div class="control-group" id="tarif_konsulgizi">
                    <legend class="rim"> Daftar Permintaan Tindakan Konsultasi Gizi</legend>
                    <table id="tbl_tarifkonsulgizi" class="items table table-bordered table-striped table-condensed" id="tblListKonsul">
                        <thead>
                            <tr>
                                <th>Permintaan Konsultasi Gizi</th>
                                <th>Tarif</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="antirow">
    <div class="row" style="margin-top: 17px;">
        <!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') 
                                    ?></p>-->
        <?php echo $form->errorSummary($modKirimKeUnitLain); ?>
        <?php echo CHtml::hiddenField('url', $this->createUrl('', array('pendaftaran_id' => $modPendaftaran->pendaftaran_id)), array('readonly' => TRUE)); ?>
        <?php echo CHtml::hiddenField('berubah', '', array('readonly' => TRUE)); ?>
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
                            'maxDate' => 'd',
                        ),
                        'htmlOptions' => array('readonly' => true),
                    )); ?>
                </div>
            </div>
            <?php echo $form->hiddenfield($modPendaftaran, 'kelaspelayanan_id', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true)); ?>
            <?php echo $form->dropDownListRow(
                $modKirimKeUnitLain,
                'pegawai_id',
                CHtml::listData($modKirimKeUnitLain->getDokterItems(), 'pegawai_id', 'NamaLengkap'),
                array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")
            );
            ?>
        </div>
        <div class="col-sm-6">
            <?php echo $form->dropDownListRow(
                $modKirimKeUnitLain,
                'ahligizi',
                CHtml::listData($modKirimKeUnitLain->getAhliGiziItems(), 'pegawai_id', 'nama_pegawai'),
                array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")
            );
            ?>
            <?php echo $form->dropDownListRow(
                $modKirimKeUnitLain,
                'ruangan_id',
                CHtml::listData($modKirimKeUnitLain->getRuanganGiziItems(), 'ruangan_id', 'ruangan_nama'),
                array(
                    'empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",
                    'onchange' => 'loadFormTindakanGizi(this.value)'
                )
            ); ?>
            <?php echo $form->textAreaRow($modKirimKeUnitLain, 'catatandokterpengirim', array('placeholder' => 'Catatan Dokter', 'onkeypress' => "return $(this).focusNextInputField(event);")) ?>
        </div>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
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
    $content = $this->renderPartial('rawatJalan.views.tips.tips', array(), true);
    $this->widget('UserTips', array('type' => 'admin', 'content' => $content));
    $ruanganGizi = Params::RUANGAN_ID_GIZI;
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
loadFormTindakanGizi(${ruanganGizi});
JS;
Yii::app()->clientScript->registerScript('js', $js, CClientScript::POS_READY);
?>

<script type="text/javascript">
    function loadFormTindakanGizi(idRuangan) {
        var idKelasPelayanan = <?php echo $modPendaftaran->kelaspelayanan_id; ?>;
        $('#tblGizi').addClass("animation-loading");
        $.post("<?php echo Yii::app()->createUrl('rawatJalan/KonsulGizi/loadFormTindakanGizi') ?>", {
            idRuangan: idRuangan,
            idKelasPelayanan: idKelasPelayanan
        }, function(data) {
            $('#tblGizi').removeClass("animation-loading");
            $('#bodyTblFormPermintaanGizi').html(data.form);
        }, "json");
    }

    function batalKirim(idPasienKirimKeUnitLain, pendaftaran_id) {
        myConfirm("Apakah Anda akan membatalkan kirim pasien?", "Perhatian!", function(r) {
            if (r) {
                $.post('<?php echo $this->createUrl('ajaxBatalKirim') ?>', {
                    idPasienKirimKeUnitLain: idPasienKirimKeUnitLain,
                    pendaftaran_id: pendaftaran_id
                }, function(data) {
                    //            $('#tblListPemeriksaanRad').html(data.result);
                    location.reload();
                }, 'json');
            }
        });
    }

    function cekInputan(obj) {
        var jmlTindakan = $('#tblFormPermintaanGizi tr').length;
        if ($(".ceklis").length < 1) {
            myAlert("Pilih pelayanan konsultasi gizi terlebih dahulu");
            return false;
        } else {
            if (requiredCheck(obj)) {
                return true;
            } else {
                return false;
            }
        }
    }

    function ceklist(obj) {
        var kelaspelayanan_id = $('#RJPendaftaranT_kelaspelayanan_id').val();
        var pendaftaran_id = '<?php echo $modPendaftaran->pendaftaran_id; ?>';
        var daftartindakan_id = $(obj).parents('tr').find('input[name$="[idDaftarTindakan]"]').val();
        if ($(obj).is(':checked')) {
            $.post('<?php echo Yii::app()->createUrl('rawatJalan/konsulGizi/CekTindakanGiziKelas') ?>', {
                daftartindakan_id: daftartindakan_id,
                kelaspelayanan_id: kelaspelayanan_id,
                pendaftaran_id: pendaftaran_id
            }, function(data) {
                $(obj).each(function() {
                    if ($(this).is(':checked')) {
                        if (data.status != 'ada') {
                            $(obj).removeAttr('checked');
                            myAlert('Konsultasi belum memilik tarif silakan hubungi instalasi gizi untuk memeriksa tarif konsultasi tersebut');
                        } else {
                            $(this).val(1);
                            $('#tarif_konsulgizi').show();
                            $('#tbl_tarifkonsulgizi tbody').append(data.result);
                        }
                    } else {
                        $(this).val(0);
                    }
                });
            }, 'json');
        } else {
            $('.daftartindakan_id').each(function() {
                var daftartindakan = $(this).val();
                if (daftartindakan == daftartindakan_id) {
                    myConfirm("Apakah Anda akan membatalkan tindakan konsultasi gizi?", "Perhatian!", function(r) {
                        if (r) {
                            removeTabel(daftartindakan_id);
                        }
                    });
                }
            });
        }
    }

    function removeTabel(daftartindakan_id) {
        var daftartindakan_id = daftartindakan_id;
        $('#tbl_tarifkonsulgizi').find('#daftartindakan_id_' + daftartindakan_id).parent().parent().remove();
    }
    $('#tarif_konsulgizi').hide();

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
                instalasi_id: <?php echo Params::INSTALASI_ID_GIZI; ?>,
                modul_id: <?php echo Params::MODUL_ID_GIZI ?>,
                judulnotifikasi: 'Pasien Rujukan',
                isinotifikasi: '<?php echo $modPasien->nama_pasien ?> dengan <?php echo $modPasien->no_rekam_medik ?> telah dirujuk pada <?php echo $modKirimKeUnitLain->tgl_kirimpasien ?> dari <?php echo $modKirimKeUnitLain->ruangan->ruangan_nama ?>'
            }; // 16 
            insert_notifikasi(params);
        <?php
        }
        ?>
    });
</script>