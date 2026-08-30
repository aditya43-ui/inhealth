<?php
$this->breadcrumbs = array(
    'Konsul Poli',
);
$this->widget('bootstrap.widgets.BootAlert');
?>

<style>
    tr td .add-on {
        margin: 0 !important;
    }
</style>

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>

<!--<legend class="rim">Tabel Konsultasi MCU</legend>-->

<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'rjkonsul-poli-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#' . CHtml::activeId($modKonsul, 'catatan_dokter_konsul'),
)); ?>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Konsultasi MCU
        </div>
    </div>
    <div class="panel-body">
        <?php $this->renderPartial($this->path_view . '_listKonsulMCU', array('modRiwayatKonsul' => $modRiwayatKonsul)); ?>
        <!--<legend class="rim2">Konsultasi Poliklinik</legend>-->
        <!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') 
                                    ?></p>-->

        <?php echo $form->errorSummary(array($modKonsul, $modelPendaftaran)); ?>
        <table style="width: 100%; border: none;">
            <tr>
                <td>
                    <div class="row">
                        <div class="col-sm-6">
                            <?php echo CHtml::hiddenField('url', $this->createUrl('', array('pendaftaran_id' => $modPendaftaran->pendaftaran_id)), array('readonly' => TRUE)); ?>
                            <?php echo CHtml::hiddenField('berubah', '', array('readonly' => TRUE)); ?>

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
                                    )); ?>
                                </div>
                            </div>
                            <?php echo $form->dropDownListRow(
                                $modKonsul,
                                'ruangan_id',
                                CHtml::listData($modKonsul->getRuanganInstalasi(), 'ruangan_id', 'ruangan_nama'),
                                array('empty' => '-- Pilih --', 'class' => 'span3', 'disabled' => true, 'onkeypress' => "return $(this).focusNextInputField(event);", 'onchange' => 'setTarif()')
                            ); ?>
                            <?php echo $form->dropDownListRow(
                                $modKonsul,
                                'pegawai_id',
                                CHtml::listData($modKonsul->getDokterItems($modPendaftaran->ruangan_id), 'pegawai_id', 'NamaLengkap'),
                                array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")
                            ); ?>
                            <?php echo $form->textAreaRow($modKonsul, 'catatan_dokter_konsul', array('placeholder' => 'Catatan Dokter', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        </div>
                        <div class="col-sm-6">
                            <div class="control-group block-tabel" id="loadTarif">
                                <div class="panel panel-success">
                                    <div class="panel-heading">
                                        <div class="panel-title">
                                            <i class="glyphicon glyphicon-file"></i> Daftar Tindakan Konsultasi MCU
                                        </div>
                                    </div>
                                    <div class="panel-body table-responsive">
                                        <table id="tblFormTarifMCU" class="table table-bordered table-condensed">
                                            <thead>
                                                <tr>
                                                    <th>Pilih</th>
                                                    <th>Ruangan Tujuan</th>
                                                    <th>Uraian Tindakan</th>
                                                    <th <?php echo Params::HIDDEN_HARGA ?>>Tarif</th>
                                                </tr>
                                            </thead>
                                            <tbody id="bodyTblFormTarifMCU"></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        </table>

        <div class="form-actions">
            <?php echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
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
            $ruanganMCU = $modKonsul->ruangan_id; // ruangan Klinik MCU (sesuai dengan yang di dropdown)

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
loadFormTindakanMCU(${ruanganMCU});

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
<script type="text/javascript">
    function loadFormTindakanMCU(ruangan_id) {
        var penjamin_id = '<?php echo $modPendaftaran->penjamin_id; ?>';
        var kelaspelayanan_id = '<?php echo $modPendaftaran->kelaspelayanan_id; ?>';
        $("#loadTarif").addClass("animation-loading");
        $.post('<?php echo $this->createUrl('ajaxSetTarif') ?>', {
            ruangan_id: ruangan_id,
            penjamin_id: penjamin_id,
            kelaspelayanan_id: kelaspelayanan_id
        }, function(data) {
            $('#loadTarif').removeClass("animation-loading");
            $('#bodyTblFormTarifMCU').html(data.form);
        }, 'json');

    }

    function viewDetailKonsul(idKonsulAntarPoli) {
        $.post('<?php echo $this->createUrl('ajaxDetailKonsul') ?>', {
            idKonsulAntarPoli: idKonsulAntarPoli
        }, function(data) {
            $('#contentDetailKonsul').html(data.result);
        }, 'json');
        $('#dialogDetailKonsul').dialog('open');
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
                modul_id: <?php echo Params::MODUL_ID_RI ?>,
                judulnotifikasi: 'Pasien Rujukan',
                isinotifikasi: '<?php echo $modPasien->nama_pasien ?> dengan <?php echo $modPasien->no_rekam_medik ?> telah dirujuk pada <?php echo $modKirimKeUnitLain->tgl_kirimpasien ?> dari <?php echo $modKirimKeUnitLain->ruangan->ruangan_nama ?>'
            }; // 16 
            insert_notifikasi(params);
        <?php
        }
        ?>
    });
</script>