<?php $data=ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); ?>
<!--KUITANSI -->
<style>
    body {
        letter-spacing: 2px;
    }
    table, td, div{
        font-size: 12pt;
        font-family: Arial;
    }
    .catatan{
        font-size: 8pt;
        text-align: left;
    }
    .uang{
        font-size: 12pt;
        font-weight: bold;
    }   
    .terbilang{
        font-style: italic;
    }
    .tandatangan{
        text-align: center;
        vertical-align: top;
    }

    table {
        width: 100%;
        /* margin: 5px; */
    }

    table tr, table td {
        line-height: 20pt;
        /* margin: 5px; */
    }

    .tbl-utama tr, .tbl-utama td {
        border-collapse: collapsed;
        border: 1px solid black;
    }

    .txt-center td {
        text-align: center;
    }

    .tbl-cld tr, .tbl-cld td {
        border: 1px solid white;
    }
</style>

<?php
    $profil = ProfilrumahsakitM::model()->find();
?>

<table class="tbl-utama">
    <tbody>
        <tr class="txt-center">
            <td style="width: 35%; font-weight: bold;">
                <?= $profil->nama_rumahsakit ?><br>
                <?= $profil->alamatlokasi_rumahsakit ?>, Malang
            </td>
            <td colspan="2" style="font-size: 16pt; font-weight: bold;">Kwitansi</td>
            <td style="width: 35%;"></td>
        </tr>
        <tr>
            <td colspan="2" style="background-color: #707070;">&emsp;</td>
            <td colspan="2" style="background-color: #B8B8B8;">&emsp;</td>
        </tr>
        <tr class="no-bukti">
            <td colspan="4">
                <br><br>
                <center>
                    <div style="font-size: 14pt;"><b>No. Bukti Pembayaran:
                    <?php $str = $modPembayaran->nopembayaran;
                            $c = explode('-', $str);
                            echo $c[0] . "-" . $c[1] . "SA" . $c[2];
                     ?></b></div>
                </center>
                <br><br>
                <table class="tbl-cld" style="width: 80%; margin-left: 80px;">
                    <tr>
                        <td>Sudah terima dari</td>
                        <td>: <?php echo $modPendaftaran->pasien->nama_pasien ?></td>
                    </tr>
                    <?php
                        $tandabukti = TandabuktibayarT::model()->findByAttributes(array(
                            'pembayaranpelayanan_id' => $modPembayaran->pembayaranpelayanan_id,
                        ));
                        $jml_uang_terbilang = ($tandabukti->uangditerima + $tandabukti->bank_nominal) == 0 ? "NOL RUPIAH" : strtoupper(MyFormatter::formatNumberTerbilang(($tandabukti->uangditerima + $tandabukti->bank_nominal))) . " RUPIAH"; 
                        $jml_uang = $tandabukti->uangditerima + $tandabukti->bank_nominal;

                        $jeniskasuspenyakit = JeniskasuspenyakitM::model()->findByPk($modPendaftaran->jeniskasuspenyakit_id);
                    ?>
                    <tr>
                        <td>Jumlah Uang</td>
                        <td>: Rp. <?= MyFormatter::formatNumberForPrint($jml_uang, 2) ?></td>
                    </tr>
                    <tr>
                        <td><b>Dengan Huruf<b></td>
                        <td><b>: <?= $jml_uang_terbilang ?><b></td>
                    </tr>
                    <tr>
                        <td colspan=2>&emsp;</td>
                    </tr>
                    <tr>
                        <td>Untuk Pembayaran</td>
                        <td>: <?= $jeniskasuspenyakit->jeniskasuspenyakit_nama ?></td>
                    </tr>
                    <tr>
                        <td colspan=2>&emsp;</td>
                    </tr>
                    <tr>
                        <td>Nama Pasien</td>
                        <td>: <?php echo $modPendaftaran->pasien->nama_pasien ?></td>
                    </tr>
                    <tr>
                        <td>No. RM / No. Billing</td>
                        <td>: <?php echo $modPendaftaran->pasien->no_rekam_medik . " / " . $modPendaftaran->no_pendaftaran ?></td>
                    </tr>
                </table>
                <br><br>
                <table class="tbl-cld" style="width: 30%; margin-left: 70%; text-align: center;">
                        <tr>
                            <td>Malang, <?= date('d-m-Y') ?></td>
                        </tr>
                        <tr>
                            <td>Petugas Kasir</td>
                        </tr>
                </table>
                <br><br><br><br><br>
                <br><br><br><br><br>
                <br><br><br><br><br>
            </td>
        </tr>
    </tbody>
</table>