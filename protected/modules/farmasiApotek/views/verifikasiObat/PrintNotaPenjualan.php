<style>
.barcode-label {
    margin-top: -20px;
    z-index: 1;
    text-align: center;
    letter-spacing: 10px;
}

td,
th {
    font-size: 6pt !important;
    /*        font-weight: bold;*/
}

body {
    width: 61mm;
}

.content {
    -webkit-transform: rotate(-90deg);
    -moz-transform: rotate(-90deg);
    -o-transform: rotate(-90deg);
    -ms-transform: rotate(0deg);
    transform: rotate(0deg);
    color: #000000;
    height: 60mm;
    width: 70mm;
    margin: 6px 0px 30px 5px;
    position: relative;
}

@media print {
    .barcode-label {
        margin-top: -20px;
        z-index: 1;
        text-align: center;
        letter-spacing: 10px;
    }

    td,
    th {
        font-size: 6pt !important;
    }

    body {
        width: 61mm;
        font-family: "Courier New", Courier, monospace;
    }

    .content {
        -webkit-transform: rotate(-90deg);
        -moz-transform: rotate(-90deg);
        -o-transform: rotate(-90deg);
        -ms-transform: rotate(0deg);
        transform: rotate(0deg);
        color: #000000;
        height: 6cm;
        width: 7cm;
        margin: 0px 0px 30px 5px;
        position: relative;
        margin-top: 1%;
    }
}

@page {
    margin-top: 1%;
}

.tab_etiket {
    border-collapse: collapse;
    margin-right: 5px;
}

.tab_etiket td {
    font-size: 5pt;
    vertical-align: top;
    padding-left: 2px;
    padding-right: 4px;
}

.garis1 {
    border-top: 1px dotted;
    margin-top: 0px;
}

.garis2 {
    border-top: 1px solid black;
    /* margin-top: -10px; */
}

table tr,
table td {
    vertical-align: top;
}

.res-detail {
    width: 100%;
    border-collapse: collapse;
}

.res-detail tr,
.res-detail td,
.res-detail th {
    vertical-align: top;
    border: 1px solid;
    border-right: 0px solid;
    border-left: 0px solid;
    border-collapse: separated;
    border-spacing: 0px;
}

.footer tr,
.footer td,
.footer th {
    vertical-align: top;
    border: 0px solid;
    border-collapse: separated;
    border-spacing: 0px;
}
</style>

<?php
    // var_dump($modReseptur->attributes); die;
?><br><br>
<center>
    <div style="width: 92%; margin-left: 15px;">
        <div class="garis1"></div>
        <div style="">
            <h3><?php echo $modPenjualan->nojual_inv ?? $modPenjualan->noresep; ?></h3>
        </div>
        <div class="garis1"></div>
        <div style="padding-top: 1px;padding-bottom: 1px;"></div>
        <div style="text-align: center;">
            INSTALASI FARMASI<br>RSUD Dr. SAIFUL ANWAR<br>NOTA
            PENJUALAN<br>(<?php echo $modPenjualan->ruangan->ruangan_nama ?? ''; ?>)
        </div>
        Untuk Pasien (SALINAN) : <strong><?php echo $modPenjualan->penjamin->penjamin_nama ?></strong>
        <div class="garis2"></div>
        <table style="width: 100%;">
            <tr>                <td style="width: 50%;">
                    <table style="width: 100%;">
                        <tr>
                            <td style="width: 40%;">No. RM / No. Bill</td>
                            <td style="width: 60%;"> :
                                <?php echo $modPasien->no_rekam_medik." / ".$modPendaftaran->no_pendaftaran; ?></td>
                        </tr>
                        <tr>
                            <td>Nama</td>
                            <td> : <?php echo $modPasien->nama_pasien ?></td>
                        </tr>
                        <tr>
                            <td>Alamat Pasien</td>
                            <td> : <?php echo $modPasien->alamat_pasien ?></td>
                        </tr>
                    </table>
                </td>
                <td>
                    <table style="width: 100%;">
                        <tr>
                            <td style="width: 40%;">Tanggal</td>
                            <td style="width: 60%;"> :
                                <?php echo date('d/m/Y H:i:s', strtotime($modPenjualan->create_time))?>
                            </td>
                        </tr>
                        <tr>
                            <td>Ruangan Asal</td>
                            <td> : <?php echo $modPenjualan->ruanganasal_nama; ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                        </tr>
                    </table>
                </td>
            </tr>



        </table>

        <table class="res-detail">
            <thead>
                <tr>
                    <th style="width: 10%;">No.</th>
                    <th style="width: 40%;">Nama Obat</th>
                    <th style="width: 23%; text-align: center;">Jumlah</th>
                    <th style="width: 27%; text-align: center;">Sub Total</th>
                </tr>
            </thead>
            <tbody>
                <?php $subtotal = 0 ?>
                <?php foreach($modResepturDet as $i => $det):?>
                <?php
                $subtotal += $det->hargajual_oa;
            ?>
                <tr>
                    <td><?php echo $i + 1 ?></td>
                    <td><?php echo $det->obatalkes->obatalkes_nama ?></td>
                    <td style="text-align: center;"><?php echo $det->qty_oa ?></td>
                    <td style="text-align: center;">
                        <?php echo MyFormatter::formatNumberForPrint($det->hargajual_oa, 2) ?></td>
                </tr>
                <?php endforeach;?>
            </tbody>
            <tfoot class="footer">
                <tr>
                    <td></td>
                    <td colspan="2">Sub Total</td>
                    <td style="text-align:center;"><?php echo MyFormatter::formatNumberForPrint($subtotal, 2) ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="2">Pembulatan</td>
                    <td style="text-align:center;"><?php echo MyFormatter::formatNumberForPrint(0, 2) ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="2">Total</td>
                    <td style="text-align:center;"><?php echo MyFormatter::formatNumberForPrint($subtotal, 2) ?></td>
                </tr>
            </tfoot>
        </table>
        <?php
    $petugas = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
?>
        <br>
        <div style="text-align: right;">
            Petugas : <?php echo $petugas->namaLengkap ?><br>
            Tanggal Cetak : <?php echo MyFormatter::formatDateTimeForUser(date('Y-m-d')) ?>
        </div>
    </div>
</center>
<div style="visibility: hidden; height: 400px;">

</div>
<!-- testes -->