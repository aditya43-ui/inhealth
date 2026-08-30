<?php
if (isset($caraPrint)) {
    if ($caraPrint == 'EXCEL') {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $judul_print . '-' . date("Y/m/d") . '.xls"');
        header('Cache-Control: max-age=0');
    }
}
?>
<style>
    .grid {
        font-size: 9px;
        font-family: tahoma;
        color: black;
    }

    .control-label {
        float: left;
        text-align: right;
        width: 50%;
        color: black;
        padding-right: 10px;
        font-size: 8pt;
    }

    .border th,
    .border td {
        border: 1px solid #000;
        padding: 2px;
    }

    .kecil {
        font-size: 7px;
        font-family: tahoma;
    }
</style>
<?php
$format = new MyFormatter;
?>
<?php $modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); ?>
<?php
// if (!isset($_GET['frame'])){
   ?>
<table width="100%">
    <thead>
        <tr>
             <td>
                <div class="header"><?php
                    echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array());
                    ?></div>
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <div class="content">
<?php
// }
?>
<table style="width: 100%; border: none; color:black;" class="grid" cellpadding="0" cellspacing="0">
    <tr>
        <td  colspan="5">Atas Nama : <?php echo $modPenjualan->pasien->namadepan . ' ' . $modPenjualan->pasien->nama_pasien; ?></td>
        <td  colspan="5">No RM : <?php echo $modPenjualan->pasien->no_rekam_medik; ?></td>
    </tr>
    <tr>
        <td colspan="5"> Alamat : <?php echo $modPenjualan->pasien->alamat_pasien; ?></td>
        <td colspan="5"> No. Registrasi : <?php echo $modPenjualan->pendaftaran->no_pendaftaran ?></td>
    </tr>
    <tr>
        <td colspan="5"> Apoteker : apt. Zulia Khozanah A M.Farm </td>
        <td colspan="5"> Tanggal : <?php echo $format->formatDateTimeForUser($modPenjualan->tglpenjualan); ?> </td>
    </tr>
    <tr>
        <td colspan="5"> Penanggung : <?php if (!empty($pj)) { echo $pj->nama_pj;}else{ echo "-";} ?></td>
        <td colspan="5"> Penjamin : <?php echo $modPenjualan->penjamin->penjamin_nama; ?> </td>
    </tr>
    <tr>
        <!-- . ' ['.$modPenjualan->ruanganasal_nama.' / '.!empty($modPenjualan->kelaspelayanan->kelaspelayanan_nama) ? $modPenjualan->kelaspelayanan->kelaspelayanan_nama : "-".']' -->
        <!-- <td colspan="5"> <b> No Resep : <?php //echo $modPenjualan->noresep; ?></b></td> -->
        
    </tr>
    <tr>
        <!-- <td colspan="3"> <b> Pasien : <?php //echo $modPenjualan->pasien->namadepan . ' ' . $modPenjualan->pasien->nama_pasien . ' [' . $modPenjualan->pasien->no_rekam_medik . '] (Penjamin: ' . $modPenjualan->penjamin->penjamin_nama . ')'; ?></b></td> -->
        <!-- <td colspan="3">1985115/SIPA-35 78/2014/2953</td> -->
    </tr>
  
</table>
<table width="100%" style='text-align: left; color:black; margin-top: 7px; margin-bottom: 7px;' class="grid border isi" cellspacing=0>
    <thead>
        <tr>
            <th style="text-align: center;">Item</th>
            <th style="text-align: center;">Harga</th>
            <th style="text-align: center;">Qty</th>
            <th style="text-align: center;">Sub</th>
        </tr>
    </thead>
    <tbody>
    <?php
        $total = 0;
        $subtotal = 0;
        $embalase = 0;
        $semua = 0;
        $diskon = 0;
        foreach ($modPenjualanDetail as $modObat) {
            $totaladmin = round(($modObat->biayaadministrasi * $modObat->qty_oa), 2);
            $hargasatuan = $modObat->ppnperobat + $modObat->hargasatuan_oa;
        ?>
            <tr>
                <td><?php echo $modObat->obatalkes->obatalkes_nama; ?></td>
                <td style="text-align: right"><?php echo $format->formatNumberForPrint($hargasatuan, 2); ?></td>
                <td style="text-align: right">
                    <?php
                    $qty_oa = $modObat->qty_oa;
                    if (!empty($modObat->formulaobatkronis_id)) {
                        $modFormularium = FormulaobatkronisM::model()->findByPk($modObat->formulaobatkronis_id);
                        $qty_oa = $modFormularium->jumlahobat_minimal;
                    }
                    echo $qty_oa . " " . $modObat->satuankecil->satuankecil_nama;
                    ?>
                </td>
                <?php if ($modPenjualan->discount > 0) : ?>
                    <td align="right"> <?= MyFormatter::formatNumberForPrint($modObat->discount, 2) ?> </td>
                <?php endif; ?>
                <td style="text-align: right">
                    <?php
                    $subtotal = $qty_oa * $hargasatuan;
                    $total += $subtotal;
                    $embalase = !empty($modPenjualan->jasaembalase) ? $modPenjualan->jasaembalase : 0;
                    $semua = $total + $embalase - $modPenjualan->discount;

                    echo $format->formatNumberForPrint($subtotal - $modObat->discount, 2);
                    ?>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<table width="100%" style='color:black;' class="grid">
    <tr>
        <td>
            <table cellpadding="0" cellspacing="0">
                <tr>
                <td width="10%">Sub Total</td>
                    <td>: Rp.<?php echo $format->formatNumberForPrint($total, 2); ?></td>
                </tr>
                <?php if ($embalase > 0) { ?>
                    <tr>
                        <td>Jasa Embalase</td>
                        <td>: Rp.<?php echo $format->formatNumberForPrint($embalase, 2); ?></td>
                    </tr>
                <?php } ?>

                <?php if ($modPenjualan->discount > 0) { ?>
                    <tr>
                        <td>Keringanan</td>
                        <td>: Rp.<?php echo $format->formatNumberForPrint($modPenjualan->discount, 2); ?></td>
                    </tr>
                <?php } ?>
                <tr>
                    <td>Total</td>
                    <td>: Rp.<?php echo $format->formatNumberForPrint($semua, 2) . ' [' . $modPenjualan->carabayar->carabayar_nama . ']'; ?></td>
                </tr>
                <tr>
                    <td colspan="2"><?php echo strtoupper(MyFormatter::formatNumberTerbilang($semua)); ?> RUPIAH</td>
                </tr>
                <tr>
                    <td>Dokter</td>
                    <td>:
                        <?php
                        $modDokter = PegawaiM::model()->findByPk($modPenjualan->pegawai_id);
                        echo !empty($modDokter) ? $modDokter->namaLengkap  : "-"
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Petugas</td>
                    <td>: <?php echo Yii::app()->user->getState('nama_pegawai'); ?></td>
                </tr>
                <tr>
                    <td colspan="2" class="kecil">
                        <br><br>
                        <b><i>printed by <?php echo ($modPenjualan->printed_by == 0) ? '' : $modPenjualan->printed_by ?>&nbsp;<?php echo Yii::app()->user->getState('nama_pegawai'); ?></i> <?= date('Y-m-d h:i:s') ?> </b>
                    </td>
                </tr>
            </table>
        </td>
        <!-- <td><i><?php //echo Yii::app()->user->getState('pesandistruk'); ?></i></td> -->
        <td align="center" width="30%">
            <div style="text-align: center;">
                <div><?php //echo Yii::app()->user->getState("kabupaten_nama").", ".MyFormatter::formatDateTimeId(date('Y-m-d')); 
                        ?></div>
                <div>Paraf</div>
                <div>&nbsp;</div>
                <div>&nbsp;</div>
                <div>&nbsp;</div>
                <div>&nbsp;</div>
                <div><?php echo Yii::app()->user->getState('nama_pegawai'); ?></div>
            </div>
        </td>
    </tr>
</table>