<?php
if (!empty($caraPrint)) {
    if ($caraPrint == 'EXCEL') {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="PENGAJUAN KLAIM PIUTANG-' . date("Y/m/d") . '.xls"');
        header('Cache-Control: max-age=0');
    }
    //echo $this->renderPartial('application.views.headerReport.headerDefault', array('judulLaporan' => 'PENGAJUAN KLAIM PIUTANG'));
}
?>

<style>
    body {
        color: black;
    }

    .border th,
    .border td {
        border: 1px solid #000;
        padding: 2px;
        color: black;
    }

    .table thead:first-child {
        border-top: 1px solid #000;
    }

    /* thead th{
      background:none;
      color:#333;
  } */

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
<table style="width: 100%; border: none;">
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
                    <div class="judulcontent">
                        <b>RINCIAN PENGAJUAN KLAIM PIUTANG PENJAMIN</b>
                    </div>
                    <br>
                    <table style="width: 100%; border: none;">
                        <tr>
                            <td width="50%">
                                <table style="width: 100%; border: none;">
                                    <tr>
                                        <td width="180px"> Tgl. Pengajuan Klaim </td>
                                        <td>
                                            : <?php echo MyFormatter::formatDateTimeForUser($modPengajuanKlaim->tglpengajuanklaimanklaim); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td> No. Pengajuan Klaim</td>
                                        <td>
                                            : <?php echo $modPengajuanKlaim->nopengajuanklaimanklaim; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td> Tgl. Jatuh Tempo </td>
                                        <td>
                                            : <?php echo MyFormatter::formatDateTimeForuser($modPengajuanKlaim->tgljatuhtempo); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td> Jenis Penjamin </td>
                                        <td>
                                            : <?php echo $modPengajuanKlaim->carabayar->carabayar_nama; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td> Penjamin </td>
                                        <td>
                                            : <?php echo $modPengajuanKlaim->penjamin->penjamin_nama; ?>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td width="50%">
                                <table style="width: 100%; border: none;">
                                    <tr>
                                        <td width="150px"> Total Tagihan </td>
                                        <td>
                                            : Rp <?php echo (!empty($modPengajuanKlaim->totaltagihan) ? MyFormatter::formatNumberForPrint($modPengajuanKlaim->totaltagihan, 2) : "-"); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td> Total Keringanan </td>
                                        <td>
                                            : Rp <?php echo (!empty($modPengajuanKlaim->totaldiskon) ? MyFormatter::formatNumberForPrint($modPengajuanKlaim->totaldiskon, 2) : "-"); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td> Total Piutang </td>
                                        <td>
                                            : Rp <?php echo (!empty($modPengajuanKlaim->totalpiutang) ? MyFormatter::formatNumberForPrint($modPengajuanKlaim->totalpiutang, 2) : "-"); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td> Total Pengajuan </td>
                                        <td>
                                            : Rp <?php echo (!empty($modPengajuanKlaim->totalbayar) ? MyFormatter::formatNumberForPrint($modPengajuanKlaim->totalbayar, 2) : "-"); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td> Total Sisa Piutang </td>
                                        <td>
                                            : Rp <?php echo (!empty($modPengajuanKlaim->totalsisapiutang) ? MyFormatter::formatNumberForPrint($modPengajuanKlaim->totalsisapiutang, 2) : "-"); ?>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>

                    <table width="90%" style='margin-left:auto; margin-right:auto;' class="border">
                        <thead class="border">
                            <th>No.</th>
                            <th>Tgl. Pendaftaran / <br> No. Pendaftaran</th>
                            <th>Tgl. Pembayaran / <br> No. Pembayaran</th>
                            <th>No. Kartu Peserta</th>
                            <th>No. Rekam Medik</th>
                            <th>Instalasi / <br> Ruangan</th>
                            <th>Nama Pasien</th>
                            <th>No. Referensi</th>
                            <th>Jumlah Tagihan</th>
                            <th>Jumlah Pembayaran</th>
                            <th>Keringanan (Rp)</th>
                            <th>Jumlah Piutang</th>
                            <th>Jumlah Pengajuan</th>
                            <th>Sisa Tagihan</th>
                        </thead>
                        <tbody>
                            <?php
                            $total_piutang = 0;
                            $total_bayar = 0;
                            $total_telah_bayar = 0;
                            $total_sisa_piutang = 0;
                            $total_tagihan = 0;
                            $no = 0;

                            foreach ($modPengajuanKlaimDetail as $i => $pengajuan) {
                                $pendaftaran = $pengajuan->pendaftaran;
                                $pasien = $pengajuan->pendaftaran->pasien;
                                $admisi = PasienadmisiT::model()->findByPk($pendaftaran->pasienadmisi_id);
                                $pembayaran = PembayaranpelayananT::model()->findByPk($pengajuan->pembayaranpelayanan_id);
                                $asuransi = AsuransipasienM::model()->findByPk($pendaftaran->asuransipasien_id);

                                if (isset($admisi) && !empty($admisi->pasienadmisi_id)) {
                                    $ruangannama = $admisi->ruangan->ruangan_nama;
                                    $instalasinama = $admisi->ruangan->instalasi->instalasi_nama;
                                } else {
                                    $ruangannama = $pendaftaran->ruangan->ruangan_nama;
                                    $instalasinama = $pendaftaran->ruangan->instalasi->instalasi_nama;
                                }

                                $total_tagihan += $pengajuan->jmltagihan;
                                $total_telah_bayar += $pengajuan->jmltelahbayar;
                                $total_piutang += $pengajuan->jmlpiutang;
                                $total_bayar += $pengajuan->jumlahbayar;
                                $total_sisa_piutang += $pengajuan->jmlsisapiutang;
                                $no++;
                            ?>
                                <tr class="border">
                                    <td style="text-align: center"><?php echo $no; ?></td>
                                    <td>
                                        <?php echo MyFormatter::formatDateTimeForUser($pendaftaran->tgl_pendaftaran) . ' / <br>' . $pendaftaran->no_pendaftaran; ?>
                                    </td>
                                    <td>
                                        <?php echo MyFormatter::formatDateTimeForUser($pembayaran->tglpembayaran) . ' / <br>' . $pembayaran->nopembayaran; ?>
                                    </td>
                                    <td>
                                        <?php echo (isset($asuransi) ? $asuransi->nopeserta : ""); ?>
                                    </td>
                                    <td>
                                        <?php echo $pasien->no_rekam_medik; ?>
                                    </td>
                                    <td>
                                        <?php echo $instalasinama . ' / <br>' . $ruangannama; ?>
                                    </td>
                                    <td>
                                        <?php echo $pasien->nama_pasien; ?>
                                    </td>
                                    <td>
                                        <?php echo $pengajuan->noreferensi; ?>
                                    </td>
                                    <td style="text-align:right;">
                                        <?php echo MyFormatter::formatNumberForPrint($pengajuan->jmltagihan, 2); ?>
                                    </td>
                                    <td style="text-align:right;">
                                        <?php echo MyFormatter::formatNumberForPrint($pengajuan->jmltelahbayar, 2); ?>
                                    </td>
                                    <td style="text-align:right;">
                                        <?php echo MyFormatter::formatNumberForPrint($pengajuan->jmldiskon, 2); ?>
                                    </td>
                                    <td style="text-align:right;">
                                        <?php echo MyFormatter::formatNumberForPrint($pengajuan->jmlpiutang, 2); ?>
                                    </td>
                                    <td style="text-align:right;">
                                        <?php echo MyFormatter::formatNumberForPrint($pengajuan->jumlahbayar, 2); ?>
                                    </td>
                                    <td style="text-align:right;">
                                        <?php echo MyFormatter::formatNumberForPrint($pengajuan->jmlsisapiutang, 2); ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="8">
                                    <div class='pull-right'><b>Total</b></div>
                                </td>
                                <td style="text-align:right;"><?php echo MyFormatter::formatNumberForPrint($total_tagihan, 2); ?></td>
                                <td style="text-align:right;"><?php echo MyFormatter::formatNumberForPrint($total_telah_bayar, 2); ?></td>
                                <td></td>
                                <td style="text-align:right;"><?php echo MyFormatter::formatNumberForPrint($total_piutang, 2); ?></td>
                                <td style="text-align:right;"><?php echo MyFormatter::formatNumberForPrint($total_bayar, 2); ?></td>
                                <td style="text-align:right;"><?php echo MyFormatter::formatNumberForPrint($total_sisa_piutang, 2); ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td>
                <div class="footer-space">&nbsp;</div>
            </td>
        </tr>
    </tfoot>
</table>
<div class="">
</div>

<?php
if (isset($_GET['frame'])) {
    echo CHtml::link(Yii::t('mds', '{icon} Print Rincian', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "print();"));
?>
    <script type='text/javascript'>
        function print() {
            window.open("<?php echo $this->createUrl("detail", array("id" => $_GET['id'], "caraPrint" => "PRINT")) ?>", "", 'location=_new, width=1024px');
        }
    </script>
<?php } else { ?>

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
<?php } ?>