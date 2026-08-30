<style>
    .border th,
    .border td {
        border: 1px solid #000;
    }


    .table thead:first-child {
        border-top: 1px solid #000;
    }

    thead th {
        background: none;
        color: #333;
    }

    .table tbody tr:hover td,
    .table tbody tr:hover th {
        background-color: none;
    }
</style>
<?php
//echo $this->renderPartial('application.views.headerReport.headerAnggaran',array('judulLaporan'=>$judulLaporan, 'deskripsi'=>$deskripsi, 'colspan'=>10));
echo $this->renderPartial('application.views.headerReport.headerRincian');

$sukses = null;
if (isset($_GET['sukses'])) {
    $sukses = $_GET['sukses'];
}
if ($sukses > 0) {
    Yii::app()->user->setFlash('success', "Status menyetujui berhasil disimpan!");
}
$this->widget('bootstrap.widgets.BootAlert');
$modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
?>

<table width="100%" style="margin: 0;" cellpadding="0" cellspacing="0">
    <tr>
        <td align="center" valig="middle" colspan="2">
            <b>
                <h3><?php echo $judulLaporan; ?></h3>
            </b>
        </td>
    </tr>

</table> <br>
<table width="100%" style="margin: 0;" cellpadding="0" cellspacing="0">
    <tr>
        <td style="width:150px">No. Rencana</td>
        <td style="width:10px">:</td>
        <td><?php echo $model->renkebbahanmakanan_no; ?></td>

        <td style="width:150px">Sumber Dana</td>
        <td style="width:10px">:</td>
        <td>
            <h4><?php echo (!empty($model->sumberdana_id) ? $model->sumberdana->sumberdana_nama : ""); ?>
        </td>
    </tr>
    <tr>
        <td>Tanggal Rencana : </td>
        <td>:</td>
        <td><?php echo $format->formatDateTimeForUser(MyFormatter::formatDateTimeForUser($model->renkebbahanmakanan_tgl)); ?></td>
    </tr>
</table><br>
<table class="table" style="box-shadow:none;" id="table-rencanaanggaranpenerimaan">
    <thead>
        <tr>
            <th class="border" style="text-align: center;">No.</th>
            <th class="border" style="text-align: center;">Golongan</th>
            <th class="border" style="text-align: center;">Jenis</th>
            <th class="border" style="text-align: center;">Kelompok</th>
            <th class="border" style="text-align: center;">Nama Bahan Makanan</th>
            <th class="border" style="text-align: center;">Satuan </th>
            <th class="border" style="text-align: center;">Stok Akhir</th>
            <th class="border" style="text-align: center;">Minimal Stok</th>
            <th class="border" style="text-align: center;">Maksimal Stok</th>
            <th class="border" style="text-align: center;">Jumlah Kebutuhan</th>
            <th class="border" width="75" style="text-align: center;">Harga</th>
            <th class="border" style="text-align: center;">PPN (%)</th>
            <th class="border" style="text-align: center;">PPN (Rp)</th>
            <th class="border" width="75" style="text-align: center;">Sub Total</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $total = 0;
        $subtotal = 0;
        foreach ($modDetails as $i => $modBarang) {
            $barang = BahanmakananM::model()->findByPk($modBarang->bahanmakanan_id);
            $gol_nama = "";
            if (!empty($barang->golbahanmakanan_id)) {
                $gol = GolbahanmakananM::model()->findByPk($barang->golbahanmakanan_id);
                if (!empty($gol)) {
                    $gol_nama = $gol->golbahanmakanan_nama;
                }
            }
            $jmlTotal = ($modBarang->harga_barangdet * $modBarang->jmlpermintaandet);
            $jmlppn = (($jmlTotal * $modBarang->persen_ppn) / 100);
            $subtotal = ($jmlTotal + $jmlppn);
            $total += $subtotal;

        ?>
            <tr>
                <td class="border" style="text-align: center;"><?php echo ($i + 1) . "."; ?></td>
                <td class="border"><?php echo $gol_nama; ?></td>
                <td class="border"><?php echo $barang->jenisbahanmakanan; ?></td>
                <td class="border"><?php echo $barang->kelbahanmakanan; ?></td>
                <td class="border"><?php echo (!empty($modBarang->bahanmakanan_id)) ? $barang->namabahanmakanan : ""; ?></td>
                <td class="border" style="text-align: center;"><?php echo $modBarang->satuanbahan; ?></td>
                <td class="border" style="text-align: center;" nowrap><?php echo $modBarang->stokakhir_bahanmakanan; ?></td>
                <td class="border" style="text-align: center;" nowrap><?php echo $modBarang->minstok_bahanmakanan; ?></td>
                <td class="border" style="text-align: center;" nowrap><?php echo $modBarang->makstok_bahanmakanan; ?></td>
                <td class="border" style="text-align: center;"><?php echo number_format($modBarang->jmlpermintaandet, 2, ",", "."); ?></td>
                <td class="border" style="text-align: right;" nowrap><?php echo (Params::cekHiddenHargaGizi() == true) ? "Rp " . number_format($modBarang->harga_barangdet, 2, ",", ".") : "Hidden"; ?></td>
                <td class="border" style="text-align: center;"><?php echo $modBarang->persen_ppn; ?></td>
                <td class="border" style="text-align: right;" nowrap><?php echo (Params::cekHiddenHargaGizi() == true) ? "Rp " . number_format($jmlppn, 2, ",", ".") : "Hidden"; ?></td>
                <td class="border" style="text-align: right;" nowrap><?php
                                                                        echo (Params::cekHiddenHargaGizi() == true) ? "Rp " . number_format($subtotal, 2, ",", ".") : "Hidden"; ?>
                </td>
            </tr>
        <?php } ?>
    <tfoot>
        <tr>
            <td class="border" colspan="13" style="text-align:right;"><b>Total (Rp)</b></td>
            <td class="border" style="text-align:right;"><b>
                    <?php echo (Params::cekHiddenHargaGizi() == true) ? number_format($total, 2, ",", ".") : "Hidden"; ?>
                </b>
            </td>
        </tr>
    </tfoot>
    </tbody>
</table>

<div class="row">
    <div class="col-sm-6"></div>
    <div class="col-sm-6" style="text-align:center;">
        <?php
        if (isset($_GET['sukses'])) {
            echo "<div class='control-group' style='margin-bottom: 57.5px;margin-top: 10px;'>";
            echo "Kepala Instalasi Gizi,<br>Menyetujui";
        } else {
            echo "<div class='<div class='control-group' style='margin-bottom: 50px;'>";
            if ($model->pegmenyetujui_id == Yii::app()->user->getState('pegawai_id')) {
                echo CHtml::link(
                    Yii::t('mds', ' Menyetujui'),
                    $this->createUrl($this->id . '/index'),
                    array(
                        'class' => 'btn btn-danger',
                        'onclick' => 'myConfirm("Apakah Anda yakin?",    "Perhatian!",
                                    function(r) {if(r) window.location = "' . $this->createUrl('ApproveMenyetujui', array('renkebbahanmakanan_id' => $model->renkebbahanmakanan_id, 'approve' => true)) . '";} ); return false;'
                    )
                );
            } else {
                echo CHtml::link(Yii::t('mds', ' Menyetujui'), 'javascript:void(0);', array(
                    'class' => 'btn btn-danger',
                    'onclick' => 'myAlert("Maaf, Anda tidak berhak mengapprove pengajuan ini!"); '
                ));
            }
        }
        echo "</div>";
        ?>
        <div class="control-group">
            ( <?php echo isset($model->pegmenyetujui_id) ? $model->pegawaimenyetujui->namaLengkap : ""; ?> )
        </div>
    </div>
</div>
<?php
echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
$urlPrint = $this->createUrl('printApproveMenyetujui', array('renkebbahanmakanan_id' => $model->renkebbahanmakanan_id));
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$url =  Yii::app()->createAbsoluteUrl($module . '/' . $controller);
$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
?>