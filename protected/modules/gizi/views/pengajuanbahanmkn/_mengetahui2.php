<style>
    .uang {
        text-align: right !important;
    }
</style>

<?php
echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan' => $judulLaporan, 'deskripsi' => "", 'colspan' => 10));

$sukses = null;
if (isset($_GET['sukses'])) {
    $sukses = $_GET['sukses'];
}
if ($sukses > 0) {
    Yii::app()->user->setFlash('success', "Status Mengetahui berhasil disimpan!");
}
$this->widget('bootstrap.widgets.BootAlert');
?>
<table bgcolor='white' class='table' style="box-shadow:none;" width="100%">
    <tr bgcolor='white'>
        <td width="50%">
            <table bgcolor='white' class='table' style="box-shadow:none;" width="100%">
                <tr bgcolor='white'>
                    <td width="200px">
                        <b>No Permintaan</b>
                    </td>
                    <td>
                        : <?php echo $modPengajuan->nopengajuan; ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>Tgl. Permintaan</b>
                    </td>
                    <td>
                        : <?php echo MyFormatter::formatDateTimeForUser($modPengajuan->tglpengajuanbahan); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>Tgl. Minta Dikirim</b>
                    </td>
                    <td>
                        : <?php echo (!empty($modPengajuan->tglmintadikirim) ? MyFormatter::formatDateTimeForUser($modPengajuan->tglmintadikirim) : "-"); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>No Rencana</b>
                    </td>
                    <td>
                        : <?php echo (isset($modPengajuan->renkebbahanmakanan) ? $modPengajuan->renkebbahanmakanan->renkebbahanmakanan_no : "-"); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>Tgl. Rencana</b>
                    </td>
                    <td>
                        : <?php echo (isset($modPengajuan->renkebbahanmakanan) ? MyFormatter::formatDateTimeForUser($modPengajuan->renkebbahanmakanan->renkebbahanmakanan_tgl) : "-"); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>Pegawai Pemesan</b>
                    </td>
                    <td>
                        : <?php echo (isset($modPengajuan->mengajukan) ? $modPengajuan->mengajukan->namaLengkap : "-"); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>Keterangan</b>
                    </td>
                    <td>
                        : <?php echo $modPengajuan->keterangan_bahan; ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>Jenis PPh</b>
                    </td>
                    <td>
                        : <?php echo (isset($modPengajuan->pajak) ? $modPengajuan->pajak->pajak_nama : "-"); ?>
                    </td>
                </tr>
            </table>
        </td>
        <td width="50%">
            <table bgcolor='white' class='table' style="box-shadow:none;">
                <tr bgcolor='white'>
                    <td width="200px">
                        <b>No Referensi</b>
                    </td>
                    <td>
                        : <?php echo $modPengajuan->noreferensi; ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>Sumber Dana</b>
                    </td>
                    <td>
                        : <?php echo (isset($modPengajuan->sumberdana) ? $modPengajuan->sumberdana->sumberdana_nama : "-"); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>Supplier</b>
                    </td>
                    <td>
                        : <?php echo (isset($modPengajuan->supplier) ? $modPengajuan->supplier->supplier_nama : "-"); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>Alamat</b>
                    </td>
                    <td>
                        : <?php echo $modPengajuan->alamatpengiriman; ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>No Telp</b>
                    </td>
                    <td>
                        : <?php echo (isset($modPengajuan->supplier) ? $modPengajuan->supplier->supplier_telp : "-"); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>Tgl. Permintaan Uang Muka</b>
                    </td>
                    <td>
                        : <?php echo (!empty($modPengajuan->tglpermintaanuangmuka) ? MyFormatter::formatDateTimeForUser($modPengajuan->tglpermintaanuangmuka) : "-"); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>Jumlah Permintaan Uang Muka</b>
                    </td>
                    <td>
                        : Rp <?php echo (!empty($modPengajuan->jmlpermintaanuangmuka) ? MyFormatter::formatNumberForPrint($modPengajuan->jmlpermintaanuangmuka, 2) : "-"); ?>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<table id="tableBarang" class="table border" bgcolor='white'>
    <thead>
        <th>No.</th>
        <th>Kelompok</th>
        <th>Nama</th>
        <th>Spesifikasi Bahan Makanan</th>
        <th>Tgl. Kedaluwarsa</th>
        <th>Jumlah Permintaan</th>
        <th>Jumlah Persediaan</th>
        <th>Satuan</th>
        <th>Harga Netto</th>
        <th>Keringanan (%)</th>
        <th>Keringanan (Rp)</th>
        <th>PPN (%)</th>
        <th>PPN (Rp)</th>
        <th>PPh (%)</th>
        <th>PPh (Rp)</th>
        <th>Subtotal</th>
    </thead>
    <tbody>
        <?php
        $no = 1;
        $subTotal = 0;
        foreach ($modDetailPengajuan as $detail) :
            $jmlQty = ($detail->qty_pengajuan * $detail->harganettobhn);
            $jmlDiskon = round((($jmlQty * $detail->persendiscount) / 100), 2);
            $jmlPpn = round(((($jmlQty - $jmlDiskon) * $detail->persenppn) / 100), 2);
            $jmlPph = round(((($jmlQty - $jmlDiskon) * $detail->persenpph) / 100), 2);
            $totalAll = round(($jmlQty - $jmlDiskon + $jmlPpn - $jmlPph), 2);
            $subTotal += $totalAll;
        ?>
            <tr bgcolor='white'>
                <td bgcolor='white'><?php echo $no; ?></td>
                <td bgcolor='white'><?php echo $detail->bahanmakanan->kelbahanmakanan; ?></td>
                <td bgcolor='white'><?php echo $detail->bahanmakanan->namabahanmakanan; ?></td>
                <td bgcolor='white'><?php echo $detail->bahanmakanan->ket_spesifikasibahanmakanan; ?></td>
                <td bgcolor='white'><?php echo MyFormatter::formatDateTimeForUser($detail->bahanmakanan->tglkadaluarsabahan); ?></td>
                <td bgcolor='white' style="text-align:right;"><?php echo number_format($detail->qty_pengajuan, 2, ",", "."); ?></td>
                <td bgcolor='white' style="text-align:right;"><?php echo number_format($detail->bahanmakanan->jmlpersediaan, 2, ",", "."); ?></td>
                <td bgcolor='white'><?php echo $detail->satuanbahan; ?></td>
                <td bgcolor='white' style="text-align:right;"><?php echo (Params::cekHiddenHargaGizi() == true) ? "Rp " . number_format($detail->harganettobhn, 2, ",", ".") : "Hidden"; ?></td>
                <td bgcolor='white' style="text-align:right;"><?php echo number_format($detail->persendiscount, 2, ",", "."); ?></td>
                <td bgcolor='white' style="text-align:right;"><?php echo (Params::cekHiddenHargaGizi() == true) ? "Rp " . number_format($jmlDiskon, 2, ",", ".") : "Hidden"; ?></td>
                <td bgcolor='white' style="text-align:right;"><?php echo number_format($detail->persenppn, 2, ",", "."); ?></td>
                <td bgcolor='white' style="text-align:right;"><?php echo (Params::cekHiddenHargaGizi() == true) ? "Rp " . number_format($jmlPpn, 2, ",", ".") : "Hidden"; ?></td>
                <td bgcolor='white' style="text-align:right;"><?php echo number_format($detail->persenpph, 2, ",", "."); ?></td>
                <td bgcolor='white' style="text-align:right;"><?php echo (Params::cekHiddenHargaGizi() == true) ? "Rp " . number_format($jmlPph, 2, ",", ".") : "Hidden"; ?></td>
                <td bgcolor='white' style="text-align:right;"><?php echo (Params::cekHiddenHargaGizi() == true) ? "Rp " . number_format($totalAll, 2, ",", ".") : "Hidden"; ?></td>
            </tr>
        <?php
            $no++;
        endforeach;

        ?>
    </tbody>
    <tfoot>
        <tr>
            <td class='border' colspan='15' style='text-align:right;'><b> Total</b></td>
            <td class='border' style='text-align:right;'><b> <?php echo (Params::cekHiddenHargaGizi() == true) ? "Rp " . number_format($subTotal, 2, ",", ".") : "Hidden"; ?></b></td>
        </tr>
    </tfoot>
</table>
<div class="row">
    <div class="col-sm-4" style="text-align:center;">
        <?php
        //        echo "<div class='control-group' style='height: 80px; margin-top: 0;'>";
        //            echo "Manajer Umum,<br>Mengetahui";
        //        echo '</div>';
        ?>
        <div class="control-group">
            <!--(<?php // echo isset($modPengajuan->idpegawai_mengetahui) ? $modPengajuan->mengetahui->namaLengkap : "&nbsp;"; 
                    ?> )-->
        </div>
    </div>

    <div class="col-sm-4" style="text-align:center;">
        <?php
        if (isset($_GET['sukses'])) {
            echo "<div class='control-group' style='height: 80px; margin-top: 0;'>";
            //            echo "Manajer Keuangan,<br>Mengetahui";
        } else {
            echo "<div class='control-group' style='height: 80px; margin-top: 0;'>";
            if ($modPengajuan->idpegawai_mengetahui2 == Yii::app()->user->getState('pegawai_id')) {
                echo CHtml::link(Yii::t('mds', ' Mengetahui'), $this->createUrl($this->id . '/index'), array(
                    'class' => 'btn btn-danger',
                    'onclick' => 'myConfirm("Apakah Anda yakin?","Perhatian!",
					function(r) {if(r) window.location = "' . $this->createUrl('ApproveMengetahui2', array('pengajuanbahanmkn_id' => $modPengajuan->pengajuanbahanmkn_id, 'approve' => true)) . '";} ); return false;'
                ));
            } else {
                echo CHtml::link(Yii::t('mds', ' Mengetahui'), 'javascript:void(0);', array(
                    'class' => 'btn btn-danger',
                    'onclick' => 'myAlert("Maaf, Anda tidak berhak mengapprove pengajuan ini!"); '
                ));
            }
        }
        echo '</div>';
        ?>
        <div class="control-group">
            ( <?php echo (!empty($modPengajuan->tgl_mengetahui2) ? "" : (isset($modPengajuan->idpegawai_mengetahui2) ? $modPengajuan->mengetahui2->namaLengkap : "&nbsp;")); ?> )
        </div>
    </div>
</div>

<?php
echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
$urlPrint = $this->createUrl('printApproveMengetahui2', array('pengajuanbahanmkn_id' => $modPengajuan->pengajuanbahanmkn_id));
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