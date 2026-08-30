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

<table style="width: 100%; border: none; color:black;" class="grid" cellpadding="0" cellspacing="0">
    <tr>
        <td width="12%" align="left" style="margin-left: -15px;margin-top:10px;">
            <img src="<?php echo Params::urlProfilRSDirectory() . $modProfilRs->logo_rumahsakit ?>" style="max-width: 80px; width:80px;" />
        </td>
        <td align="left" style="font-size:11px;">
            <div>
                <b><?php echo strtoupper($modProfilRs->nama_rumahsakit);
                    ?></b>
            </div>
            <div>
                <b><?php echo strtoupper($modProfilRs->alamatlokasi_rumahsakit);
                    ?></b>
            </div>
        </td>
        <td></td>
        <td style="font-size:11px;">
            <div>
                <h4>NOTA PENJUALAN OBAT <br> <?php echo strtoupper(RuanganM::model()->findByPk(Yii::app()->user->getState('ruangan_id'))->ruangan_nama) ?> </h4>
            </div>
        </td>
    </tr>
    <tr>
        <!-- . ' ['.$modPenjualan->ruanganasal_nama.' / '.!empty($modPenjualan->kelaspelayanan->kelaspelayanan_nama) ? $modPenjualan->kelaspelayanan->kelaspelayanan_nama : "-".']' -->
        <td colspan="3"> <b> No Resep : <?php echo $modPenjualan->noresep; ?></b></td>
        <td colspan="3">Apoteker : apt. Zulia Khozanah A M.Farm </td>
    </tr>
    <tr>
        <td colspan="3"> <b> Pasien : <?php echo $modPenjualan->pasien->namadepan . ' ' . $modPenjualan->pasien->nama_pasien . ' [' . $modPenjualan->pasien->no_rekam_medik . '] (Penjamin: ' . $modPenjualan->penjamin->penjamin_nama . ')'; ?></b></td>
        <!-- <td colspan="3">1985115/SIPA-35 78/2014/2953</td> -->
    </tr>
    <tr>
        <td colspan="3"> Alamat : <?php echo $modPenjualan->pasien->alamat_pasien; ?></td>
        <td colspan="3"></td>
    </tr>
    <tr>
        <td colspan="3"> Tanggal : <?php echo $format->formatDateTimeForUser($modPenjualan->tglpenjualan); ?> </td>
        <td colspan="3"></td>
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
        foreach ($modPenjualanDetail as $modObat) {
            if (!empty($modObat->formulaobatkronis_id)) {
                $modFormularium = FormulaobatkronisM::model()->findByPk($modObat->formulaobatkronis_id);
                $totaladmin = round(($modObat->biayaadministrasi * $modFormularium->jumlahobat_maksimal), 2);
                $hargasatuan = $modObat->ppnperobat + $modObat->hargasatuan_oa;
        ?>
                <tr>
                    <td><?php echo $modObat->obatalkes->obatalkes_nama; ?></td>
                    <td style="text-align: right"><?php echo $format->formatNumberForPrint($hargasatuan, 2); ?></td>
                    <td style="text-align: right">
                        <?php echo $modFormularium->jumlahobat_minimal . " " . $modObat->satuankecil->satuankecil_nama; ?>
                    </td>
                    <td style="text-align: right">
                        <?php
                        $subtotal = $hargasatuan * $modFormularium->jumlahobat_minimal;
                        $total += $subtotal;
                        echo $format->formatNumberForPrint($subtotal, 2);
                        ?>
                    </td>
                </tr>
        <?php }
        } ?>
    </tbody>
</table>
<table width="100%" style='color:black;' class="grid">
    <tr>
        <td>
            <table cellpadding="0" cellspacing="0">
                <tr>
                    <td>Total</td>
                    <td>: Rp.<?php echo $format->formatNumberForPrint($total, 2) . ' [' . $modPenjualan->carabayar->carabayar_nama . ']'; ?></td>
                </tr>
                <tr>
                    <td colspan="2"><?php echo strtoupper(MyFormatter::formatNumberTerbilang($total)); ?> RUPIAH</td>
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
                        <br>
                        *) Sudah termasuk ppn, barang yang sudah dibeli tidak dapat ditukar atau dikembalikan <br>
                        <b><i>printed by <?php echo ($modPenjualan->printed_by == 0) ? '' : $modPenjualan->printed_by ?>&nbsp;<?php echo Yii::app()->user->getState('nama_pegawai'); ?></i> <?= date('Y-m-d h:i:s') ?> </b>
                    </td>
                </tr>
            </table>
        </td>
        <td><i><?php echo Yii::app()->user->getState('pesandistruk'); ?></i></td>
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