<div class='white-container'>
    <legend class="rim2">Transaksi <b>Penulisan Resep</b></legend>
    <?php
    $this->breadcrumbs = array(
        'Reseptur',
    );
    ?>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting.js'); ?>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php
    if (isset($_GET['sukses'])) {
        if ($_GET['sukses'] == 1) {
            Yii::app()->user->setFlash("success", "Data berhasil disimpan!");
        }
    }
    ?>
    <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'id' => 'rjreseptur-t-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
        'focus' => '#therapiobat_nama',
        'htmlOptions' => array(
            'onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'
        ),
    )); ?>
    <fieldset class='box' id="form-infopasien">
        <legend class="rim">Data Pasien
            <span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="entypo-arrows-ccw"></i>', array('class' => 'btn btn-danger btn-mini', 'onclick' => 'setInfoPasienReset();', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk mengulang data kunjungan')); ?></span>
        </legend>
        <div class="row">
            <?php $this->renderPartial('_formInfoPasien', array('form' => $form, 'modInfoRI' => $modInfoRI)); ?>
        </div>
    </fieldset>
    <div class="formInputTab">
        <fieldset class='box' id="form-dataresep">
            <legend class="rim">Data Resep</legend>
            <?php $this->renderPartial('_formDataResep', array('form' => $form, 'modReseptur' => $modReseptur, 'modPendaftaran' => $modPendaftaran)); ?>
        </fieldset>
        <?php
        if (!isset($_GET['sukses'])) {
            $this->renderPartial('_formInputObat', array('modPendaftaran' => $modPendaftaran, 'form' => $form, 'modReseptur' => $modReseptur));
        }
        ?>
        <div class='block-tabel'>
            <h6>Tabel <b>Obat Alkes</b></h6>
            <table class="items table table-striped table-condensed" id="table-obatalkespasien">
                <thead>
                    <tr>
                        <th>Resep</th>
                        <th>R ke</th>
                        <th>Kode / Nama Obat</th>
                        <th>Sumber Dana</th>
                        <th>Satuan Kecil</th>
                        <th>Jumlah</th>
                        <th>Stok</th>
                        <th>Estimasi Harga</th>
                        <!--<th>Discount (%)</th>-->
                        <th>Sub Total</th>
                        <th>Signa</th>
                        <th>Etiket</th>
                        <th>Iter</th>
                        <th>Batal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($_GET['reseptur_id'])) {
                        if (count((array)$modResepturDetail) > 0) {
                            foreach ($modResepturDetail as $i => $modDetail) {
                                $modDetail->jmlstok = StokobatalkesT::getJumlahStok($modDetail->obatalkes_id, Yii::app()->user->getState('ruangan_id'));
                                echo $this->renderPartial('_rowDetail', array('modResepturDetail' => $modDetail));
                            }
                        }
                    }
                    ?>
                </tbody>
                <tfoot>
                    <tr>

                        <td colspan="8" style="text-align: right;"><b>Total Estimasi Harga</b></td>
                        <td><input type="text" readonly name="totalHargaReseptur" id="totalHargaReseptur" class="inputFormTabel lebar2 integer" /></td>
                        <td colspan="2"></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="form-actions">
            <?php
            $disableSave = false;
            $disableSave = (!empty($_GET['sukses'])) ? true : false;
            ?>
            <?php $disablePrint = ($disableSave) ? false : true; ?>
            <?php
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'cekObat();', 'onkeypress' => 'cekObat();', 'disabled' => $disableSave)); //formSubmit(this,event)        
            //  jika tanpa cek obat
            /**echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
                            array('class' => 'btn btn-danger', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)', 'disabled'=>$disableSave));
             * 
             */
            ?>
            <?php
            echo CHtml::link(
                Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                $this->createUrl($this->id . '/index'),
                array(
                    'class' => 'btn btn-default',
                    'onclick' => 'return refreshForm(this);'
                )
            );
            ?>
            <?php
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print Resep', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'disabled' => $disablePrint, 'type' => 'button', 'onclick' => 'printRecordTerakhir(\'PRINT\')'));
            ?>
            <?php
            if ($disablePrint) {
                echo CHtml::Link("<i class=\"icon-list icon-white\"></i> Penjualan Resep", Yii::app()->controller->createUrl("PenjualanDariReseptur/Index", array("reseptur_id" => $modReseptur->reseptur_id)), array('class' => 'btn btn-info', "rel" => "tooltip", "title" => "berfungsi saat setelah data tersimpan", 'disabled' => true));
            } else {
                echo CHtml::Link("<i class=\"icon-list icon-white\"></i> Penjualan Resep", Yii::app()->controller->createUrl("PenjualanDariReseptur/Index", array("reseptur_id" => $modReseptur->reseptur_id)), array('class' => 'btn btn-info', "target" => "_BLANK", "rel" => "tooltip", "title" => "Klik untuk menjual resep"));
            }
            ?>
            <?php
            $content = $this->renderPartial('tips/tipsReseptur', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>

<?php
$urlPrintRecordTerakhir =  Yii::app()->createAbsoluteUrl($this->module->id . '/' . $this->id . '/print&id=' . $modPendaftaran->pendaftaran_id);
$js = <<< JSCRIPT
function printRecordTerakhir(caraPrint)
{
    window.open("${urlPrintRecordTerakhir}&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
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
<?php $this->renderPartial('_jsFunctions', array('modReseptur' => $modReseptur, 'modReseptur' => $modReseptur, 'modResepturDetail' => $modResepturDetail)); ?>