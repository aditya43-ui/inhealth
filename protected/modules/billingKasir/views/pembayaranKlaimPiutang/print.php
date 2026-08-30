<style>
    body {
        color: black;
    }

    .border th,
    .border td {
        border: 1px solid #000;
        padding: 2px;
    }

    .table thead:first-child {
        border-top: 1px solid #000;
    }

    thead th {
        background: none;
        color: #333;
    }

    .table tbody tr td,
    .table tbody tr th {
        background-color: none;
    }

    .table {
        box-shadow: none;
    }

    .judulcontent {
        text-align: center;
    }
</style>

<?php
if (isset($caraPrint)) {
    if ($caraPrint == 'EXCEL') {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $judulKuitansi . '-' . date("Y/m/d") . '.xls"');
        header('Cache-Control: max-age=0');
    }
    // echo $this->renderPartial('application.views.headerReport.headerDefault', array('judulLaporan'=>$judulKuitansi));
}
?>
<?php
$nopengajuan = "-";
$tglpengajuan = "-";
$pengajuanid = "";

$pembkalimdetMod = PembklaimdetalT::model()->findByAttributes(array('pembayarklaim_id' => $modPembayaranKlaim->pembayarklaim_id));

if (isset($pembkalimdetMod)) {
    $pengajuanDetMod = PengajuanklaimdetailT::model()->findByAttributes(array('pengajuanklaimdetail_id' => $pembkalimdetMod->pengajuanklaimdetail_id));

    if (isset($pengajuanDetMod)) {
        $pengajuanMod = PengajuanklaimpiutangT::model()->findByAttributes(array('pengajuanklaimpiutang_id' => $pengajuanDetMod->pengajuanklaimpiutang_id));

        if (isset($pengajuanMod)) {
            $nopengajuan = $pengajuanMod->nopengajuanklaimanklaim;
            $tglpengajuan = MyFormatter::formatDateTimeForUser($pengajuanMod->tglpengajuanklaimanklaim);
            $pengajuanid = $pengajuanMod->pengajuanklaimpiutang_id;
        }
    }
}
$totalDiskon = 0;

$pembkalimdetAll = PembklaimdetalT::model()->findAllByAttributes(array('pembayarklaim_id' => $modPembayaranKlaim->pembayarklaim_id));

if (count((array)$pembkalimdetAll) > 0) {
    foreach ($pembkalimdetAll as $detailPem) {
        $totalDiskon += $detailPem->jmldiskon;
    }
}
?>
<?php echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array()); ?>
<div class="judulcontent">
    <b>RINCIAN PEMBAYARAN KLAIM PIUTANG PENJAMIN</b>
</div>
<br>
<table class='table' style="border: 0;">
    <tr>
        <td width="50%">
            <table class='table' style="border: 0;">
                <tr>
                    <td width="180px"> Pembayaran Ke- </td>
                    <td>
                        : <?php echo $modPembayaranKlaim->bayarke; ?>
                    </td>
                </tr>
                <tr>
                    <td> Tgl. Pembayaran Klaim</td>
                    <td>
                        : <?php echo MyFormatter::formatDateTimeForuser($modPembayaranKlaim->tglpembayaranklaim); ?>
                    </td>
                </tr>
                <tr>
                    <td> No Pembayaran Klaim </td>
                    <td>
                        : <?php echo $modPembayaranKlaim->nopembayaranklaim; ?>
                    </td>
                </tr>
                <tr>
                    <td> Tgl. Pengajuan Klaim </td>
                    <td>
                        : <?php echo $tglpengajuan; ?>
                    </td>
                </tr>
                <tr>
                    <td> No. Pengajuan Klaim </td>
                    <td>
                        : <?php echo $nopengajuan; ?>
                    </td>
                </tr>
                <tr>
                    <td> Jenis Penjamin </td>
                    <td>
                        : <?php echo $modPembayaranKlaim->carabayar->carabayar_nama; ?>
                    </td>
                </tr>
                <tr>
                    <td> Penjamin </td>
                    <td>
                        : <?php echo $modPembayaranKlaim->penjamin->penjamin_nama; ?>
                    </td>
                </tr>
            </table>
        </td>
        <td width="50%">
            <table class='table' style="border: 0;">
                <tr>
                    <td width="150px"> Total Tagihan </td>
                    <td>
                        : Rp <?php echo (!empty($modPembayaranKlaim->totalpiutang) ? MyFormatter::formatNumberForPrint($modPembayaranKlaim->totalpiutang, 2) : "-"); ?>
                    </td>
                </tr>
                <tr>
                    <td> Total Keringanan </td>
                    <td>
                        : Rp <?php echo (!empty($totalDiskon) ? MyFormatter::formatNumberForPrint($totalDiskon, 2) : "-"); ?>
                    </td>
                </tr>
                <tr>
                    <td> Total Piutang </td>
                    <td>
                        : Rp <?php echo (!empty($modPembayaranKlaim->totalpiutang) ? MyFormatter::formatNumberForPrint($modPembayaranKlaim->totalpiutang, 2) : "-"); ?>
                    </td>
                </tr>
                <tr>
                    <td> Total Telah Bayar </td>
                    <td>
                        : Rp <?php echo (!empty($modPembayaranKlaim->telahbayar) ? MyFormatter::formatNumberForPrint($modPembayaranKlaim->telahbayar, 2) : "-"); ?>
                    </td>
                </tr>
                <tr>
                    <td> Total Bayar </td>
                    <td>
                        : Rp <?php echo (!empty($modPembayaranKlaim->totalbayar) ? MyFormatter::formatNumberForPrint($modPembayaranKlaim->totalbayar, 2) : "-"); ?>
                    </td>
                </tr>
                <tr>
                    <td> Total Sisa Piutang </td>
                    <td>
                        : Rp <?php echo (!empty($modPembayaranKlaim->totalsisapiutang) ? MyFormatter::formatNumberForPrint($modPembayaranKlaim->totalsisapiutang, 2) : "-"); ?>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<br>
<div style="padding-left: 20px; padding-right: 20px">
    <table width="100%" style='margin-left:auto; margin-right:auto;' class="border">
        <thead class="border">
            <th>No.</th>
            <th>Tgl. Pembayaran Klaim / <br> No. Pembayaran Klaim</th>
            <th>Tgl. Pengajuan Kalaim / <br> No. Pengajuan Klaim</th>
            <th>Pembayaran Ke-</th>
            <th>Jenis Penjamin / <br> Penjamin</th>
            <th>Total Tagihan</th>
            <th>Total Telah Bayar</th>
            <th>Total Pembayaran</th>
            <th>Biaya Administrasi</th>
            <th>Total Penerimaan</th>
            <th>Total Sisa Tagihan</th>
            <th>Hapus Piutang Tak Tertagih</th>
        </thead>
        <tbody>
            <?php
            $criteriaPem = new CDbCriteria();
            $criteriaPem->select = "t.tglpembayaranklaim, t.nopembayaranklaim, pengajuanklaimpiutang_t.tglpengajuanklaimanklaim, pengajuanklaimpiutang_t.nopengajuanklaimanklaim, t.bayarke, carabayar_m.carabayar_nama, penjaminpasien_m.penjamin_nama, t.totalpiutang, t.totalbayar, t.telahbayar, t.totalsisapiutang, t.biaya_administrasi, t.totalpenerimaan, t.pegawaipenghapusan_id";
            $criteriaPem->group = $criteriaPem->select;

            if (!empty($pengajuanid)) {
                $criteriaPem->addCondition('pengajuanklaimpiutang_t.pengajuanklaimpiutang_id = ' . $pengajuanid);
            }
            $criteriaPem->join = "join pembklaimdetal_t on pembklaimdetal_t.pembayarklaim_id = t.pembayarklaim_id
    join pengajuanklaimdetail_t on pengajuanklaimdetail_t.pengajuanklaimdetail_id = pembklaimdetal_t.pengajuanklaimdetail_id
    join pengajuanklaimpiutang_t on pengajuanklaimpiutang_t.pengajuanklaimpiutang_id = pengajuanklaimdetail_t.pengajuanklaimpiutang_id
    join carabayar_m on carabayar_m.carabayar_id = t.carabayar_id
    join penjaminpasien_m on penjaminpasien_m.penjamin_id = t.penjamin_id";
            $criteriaPem->order = "t.bayarke ASC";
            $detailPembayaran = PembayarklaimT::model()->findAll($criteriaPem);
            $no = 0;

            foreach ($detailPembayaran as $i => $byr) {
                $no++;
            ?>
                <tr class="border">
                    <td style="text-align: center"><?php echo $no; ?></td>
                    <td>
                        <?php echo MyFormatter::formatDateTimeForUser($byr->tglpembayaranklaim) . ' / <br>' . $byr->nopembayaranklaim; ?>
                    </td>
                    <td>
                        <?php echo MyFormatter::formatDateTimeForUser($byr->tglpengajuanklaimanklaim) . ' / <br>' . $byr->nopengajuanklaimanklaim; ?>
                    </td>
                    <td style="text-align:center;">
                        <?php echo $byr->bayarke; ?>
                    </td>
                    <td>
                        <?php echo $byr->carabayar_nama . ' / <br>' . $byr->penjamin_nama; ?>
                    </td>
                    <td style="text-align:right;">
                        Rp <?php echo MyFormatter::formatNumberForPrint($byr->totalpiutang, 2); ?>
                    </td>
                    <td style="text-align:right;">
                        Rp <?php echo MyFormatter::formatNumberForPrint($byr->telahbayar, 2); ?>
                    </td>
                    <td style="text-align:right;">
                        Rp <?php echo MyFormatter::formatNumberForPrint($byr->totalbayar, 2); ?>
                    </td>
                    <td style="text-align:right;">
                        Rp <?php echo MyFormatter::formatNumberForPrint($byr->biaya_administrasi, 2); ?>
                    </td>
                    <td style="text-align:right;">
                        Rp <?php echo MyFormatter::formatNumberForPrint($byr->totalpenerimaan, 2); ?>
                    </td>
                    <td style="text-align:right;">
                        Rp <?php echo MyFormatter::formatNumberForPrint($byr->totalsisapiutang, 2); ?>
                    </td>
                    <td style="text-align:center;">
                        <?php echo (!empty($byr->pegawaipenghapusan_id) ? "DIHAPUSKAN" : "-"); ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<br><br>

<?php
$profil = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
$alamat = !empty($profil->alamatlokasi_rumahsakit) ? $profil->alamatlokasi_rumahsakit : "";
$motto = !empty($profil->motto) ? $profil->motto : "";
$telp = !empty($profil->no_telp_profilrs) ? $profil->no_telp_profilrs : "";
$email = !empty($profil->email) ? $profil->email : "";
$website = !empty($profil->website) ? $profil->website : "";
$layoutkiri = $alamat . "<br>" . "Telp:" . $telp . " Email:" . $email . " Website:" . $website;
?>
<table width="100%" class="footer">
    <tr>
        <td width="70%" style="text-align:left" align="left" class="alamatfooter"><?php echo  $layoutkiri ?></td>
        <td class="mottofooter" style="text-align:right" width="30%" align="right"><?php echo $motto ?></td>
    </tr>
</table>