<?php
$this->breadcrumbs = array(
    'Reseptur',
);

$this->widget('bootstrap.widgets.BootAlert');
//$this->renderPartial('/_ringkasDataPasien',array('modPendaftaran'=>$modPendaftaran,'modPasien'=>$modPasien,'modAdmisi'=>$modAdmisi));
//
//echo '<legend class="rim">RESEPTUR</legend><hr>';
//$this->renderPartial('/_tabulasi',array('modPendaftaran'=>$modPendaftaran, 'modAdmisi'=>$modAdmisi));

?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-file-medical"></i> Reseptur
        </div>
    </div>
    <div class="panel-body">
        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'rjreseptur-t-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'focus' => '#namaObatNonRacik',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
        )); ?>

        <!--div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Pemeriksaan Reseptur</div>
    </div>
    <div class="panel-body"-->

        <div class="panel panel-success" data-collapsed="1">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="fas fa-history"></i> Riwayat Resep Pasien
                </div>
                <div class="panel-options">
                    <?php echo CHtml::link('<i class="glyphicon glyphicon-chevron-down" style="color: #fff;"></i>', '#', array('data-rel' => 'collapse')); ?>
                </div>
            </div>
            <div class="panel-body" id="list-rujukankeluar">
                <?php echo $this->renderPartial('_listResep', array(
                    'modRiwayatResep' => $modRiwayatResep,
                ), true); ?>
            </div>
        </div>

        <div class="formInputTab">
            <div class="row" style="margin-top: 17px;">
                <?php echo $this->renderPartial('_formInputObat', array('form' => $form, 'modReseptur' => $modReseptur, 'modDeposit' => $modDeposit, 'modPasien' => $modPasien, 'modPendaftaran' => $modPendaftaran), true); ?>
            </div>

            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">
                        <i class="entypo-credit-card"></i> Tabel <b>Reseptur</b>
                    </div>
                </div>
                <div class="panel-body table-responsive">
                    <table class="items table table-striped table-condensed" id="table-obatalkespasien">
                        <thead>
                            <tr>
                                <th>Resep</th>
                                <th>R ke</th>
                                <th>Kode / Nama Obat</th>
                                <th>Jumlah</th>
                                <th>Harga Satuan (Rp)</th>
                                <th>PPN (%)</th>
                                <th>PPN (Rp)</th>
                                <th>Subtotal (Rp)</th>
                                <th>Signa</th>
                                <th>Cara Penggunaan Obat</th>
                                <th>Sediaan</th>
                                <th>Batal</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                        <tfoot>
                            <tr>
                                <td colspan="7" style="text-align: right;"><b>Total</b></td>
                                <td><?php echo CHtml::textfield('totalHargaReseptur', 0, array('class' => 'span2 integer-decimal', 'readonly' => true)); ?></td>
                                <td colspan="4"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <?php
            if (isset($_GET['sukses'])) {
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="' . MyIcon::getIcons('simpan') . '"></i>')),
                    array('class' => 'btn btn-danger', 'id' => 'btn_submit', 'disabled' => true)
                );
                echo CHtml::link(
                    Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                    $this->createUrl($this->id . '/index/&pendaftaran_id=' . $_GET['pendaftaran_id'] . '&pasienadmisi_id=' . $_GET['pasienadmisi_id']),
                    array(
                        'class' => 'btn btn-default',
                        'onclick' => 'return refreshForm(this);'
                    )
                );
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Print Detail', array('{icon}' => '<i class="' . MyIcon::getIcons('cetak') . '"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'printRecordTerakhir(\'PRINT\')'));
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Print Resep', array('{icon}' => '<i class="' . MyIcon::getIcons('cetak') . '"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'printResep(\'PRINT\')'));
            } else {
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="' . MyIcon::getIcons('simpan') . '"></i>')),
                    array('class' => 'btn btn-danger', 'id' => 'btn_submit', 'onclick' => 'cekObat();', 'onKeypress' => 'cekObat();')
                );
                echo CHtml::link(
                    Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                    $this->createUrl($this->id . '/index/&pendaftaran_id=' . $_GET['pendaftaran_id'] . '&pasienadmisi_id=' . $_GET['pasienadmisi_id']),
                    array(
                        'class' => 'btn btn-default',
                        //'disabled'=>true,
                        'onclick' => 'return refreshForm(this);'
                    )
                );
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Print Detail', array('{icon}' => '<i class="' . MyIcon::getIcons('cetak') . '"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'disabled' => 'disabled'));
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Print Resep', array('{icon}' => '<i class="' . MyIcon::getIcons('cetak') . '"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'disabled' => 'disabled'));
            }
            ?>
            <?php $content = $this->renderPartial('../tips/tips', array(), true);
            $this->widget('UserTips', array('type' => 'admin', 'content' => $content)); ?>
            <!--/div>
</div-->
            <?php
            $urlPrint =  Yii::app()->createAbsoluteUrl($this->module->id . '/' . $this->id . '/print&id=' . $modPendaftaran->pendaftaran_id);
            $urlPrintRecordTerakhir =  Yii::app()->createAbsoluteUrl($this->module->id . '/' . $this->id . '/print&id=' . $modPendaftaran->pendaftaran_id);
            $urlPrintResep =  Yii::app()->createAbsoluteUrl('farmasiApotek/InformasiPasienResep/printResepDokter&id=' . $modReseptur->reseptur_id);
            $js = <<< JSCRIPT
function print(caraPrint,idReseptur)
{
    window.open("${urlPrint}&idReseptur="+idReseptur+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
function printRecordTerakhir(caraPrint)
{
    window.open("${urlPrintRecordTerakhir}&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
function printResep(caraPrint)
{
    window.open("${urlPrintResep}&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
            Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
            ?>
        </div>

        <?php $this->endWidget(); ?>
    </div>

    <?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'dialogDetailresep',
        'options' => array(
            'title' => 'Detail Reseptur',
            'autoOpen' => false,
            'modal' => true,
            'width' => 800,
            'resizable' => false,
            'position' => 'top',
        ),
    ));

    echo '<div id="contentDetailResep">dialog content here</div>';

    $this->endWidget('zii.widgets.jui.CJuiDialog');
    ?>

    <script type="text/javascript">
        function viewDetailResep(idReseptur, pendaftaran_id) {

            $.post('<?php echo $this->createUrl('ajaxDetailResep') ?>', {
                idReseptur: idReseptur,
                pendaftaran_id: pendaftaran_id
            }, function(data) {
                $('#contentDetailResep').html(data.result);
            }, 'json');
            $('#dialogDetailresep').dialog('open');
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
        });
    </script>