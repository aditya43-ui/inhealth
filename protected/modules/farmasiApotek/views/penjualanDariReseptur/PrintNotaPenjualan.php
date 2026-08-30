<style>
.barcode-label {
    margin-top: -20px;
    z-index: 1;
    text-align: center;
    letter-spacing: 10px;
}

td,
th {
    font-size: 8pt !important;
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
        font-size: 8pt !important;
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
        /* transform: scale(2); */
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
    font-size: 9pt;
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
    font-size: 8pt !important;
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
    font-size: 9pt !important;
}

.footer tr,
.footer td,
.footer th {
    vertical-align: top;
    border: 0px solid;
    border-collapse: separated;
    border-spacing: 0px;
}

.res-tr th {
    font-size: 9pt !important;
}
</style>

<?php
    // var_dump($modReseptur->attributes); die;
?><br><br>
<center>
    <div style="width: 50%; margin-left: 15px;">
        <div class="garis1"></div>
        <div style="font-size: 8pt;">
            <h2><?php echo $modPenjualan->nojual_inv ?? $modPenjualan->noresep; ?></h2>
        </div>
        <div class="garis1"></div>
        <div style="padding-top: 1px;padding-bottom: 1px;"></div>
        <div style="text-align: center; font-size: 8pt;">
            INSTALASI FARMASI<br>RSUD Dr. SAIFUL ANWAR<br>NOTA
            PENJUALAN<br>(<?php echo $modPenjualan->ruangan->ruangan_nama ?? ''; ?>)
        </div>
        <div style="font-size: 8pt;">Untuk Pasien (SALINAN) : <strong><?php echo $modPenjualan->penjamin->penjamin_nama ?></strong></div>
        <div class="garis2"></div>
        <table style="width: 100%;">
            <tr>
                <td style="width: 50%;">
                    <table style="width: 100%;">
                        <tr>
                            <td style="width: 35%;">No. RM / No. Bill</td>
                            <td style="text-align: center;">:</td>
                            <td style="width: 60%;">
                                <?php echo $modPasien->no_rekam_medik." / ".$modPendaftaran->no_pendaftaran; ?></td>
                        </tr>
                        <tr>
                            <td>Nama</td>
                            <td style="text-align: center;">:</td>
                            <td><?php echo $modPasien->nama_pasien ?></td>
                        </tr>
                    </table>
                </td>
                <td>
                    <table style="width: 100%;">
                        <tr>
                            <td style="width: 30%;">Tanggal</td>
                            <td style="text-align: center;">:</td>
                            <td style="width: 65%;">
                                <?php echo date('d/m/Y H:i:s', strtotime($modPenjualan->create_time))?>
                            </td>
                        </tr>
                        <tr>
                            <td>Ruangan</td>
                            <td style="text-align: center;">:</td>
                            <td><?php echo $modPenjualan->ruanganasal_nama; ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <table style="width: 100%;">
                        <tr>
                            <td style="width: 17%; font-size: 8pt;" colspan="1">Alamat Pasien</td>
                            <td style="width: 3%; text-align: center; font-size: 8pt;"> :</td>
                            <td style="font-size: 8pt;">
                            <?php echo $modPasien->alamat_pasien ?>
                            </td>
                        </tr>
                    </table>

                </td>
            </tr>



        </table>

        <table class="res-detail">
            <thead>
                <tr class="res-tr">
                    <th style="width: 10%;">No.</th>
                    <th style="width: 51%;">Nama Obat</th>
                    <th style="width: 12%; text-align: center;">Jumlah</th>
                    <th style="width: 27%; text-align: center;">Sub Total</th>
                </tr>
            </thead>
            <tbody>
                <?php $subtotal = 0 ?>
                <?php foreach($modResepturDet as $i => $det):?>
                <?php
                $subtotal += $det->hargajual_oa;
            ?>
                <tr class="res-tr">
                    <td><?php echo $i + 1 ?></td>
                    <td><?php echo $det->obatalkes->obatalkes_nama ?></td>
                    <td style="text-align: center;"><?php echo $det->qty_oa ?></td>
                    <td style="text-align: center;">
                        <?php echo MyFormatter::formatNumberForPrint($det->hargajual_oa, 2) ?></td>
                </tr>
                <?php endforeach;?>
            </tbody>
            <tfoot class="footer">
            <tr class="res-tr">
                    <td></td>
                    <td colspan="2">Sub Total</td>
                    <td style="text-align:center;"><?php echo MyFormatter::formatNumberForPrint($subtotal, 2) ?></td>
                </tr>
                <tr class="res-tr">
                    <td></td>
                    <td colspan="2">Pembulatan</td>
                    <td style="text-align:center;"><?php echo MyFormatter::formatNumberForPrint(0, 2) ?></td>
                </tr>
                <tr class="res-tr">
                    <td></td>
                    <td colspan="2">Total</td>
                    <td style="text-align:center;"><?php echo MyFormatter::formatNumberForPrint($subtotal, 2) ?></td>
                </tr>
            </tfoot>
        </table>
        <?php
            if(Yii::app()->user->getState('modul_id') == Params::MODUL_ID_APOTEK) {
                $petugas = PegawaiM::model()->findByPk($modPenjualan->loginpemakai->pegawai_id);
            } else {
                $petugas = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
            }
        ?>
        <br>
        <div style="text-align: right; font-size: 8pt;">
            Petugas : <?php echo $petugas->namaLengkap ?? '' ?><br>
            Tanggal Cetak : <?php echo MyFormatter::formatDateTimeForUser(date('Y-m-d')) ?>
        </div>
    </div>
</center>

<!-- testes -->