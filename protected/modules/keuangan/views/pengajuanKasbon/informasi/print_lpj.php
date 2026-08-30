<?php
$width = '96%';
$font_size = '9pt';
$max_width = "max-width: 4.5cm;";
$width_dr = '';

if (isset($_GET['caraPrint'])) {
    if ($_GET['caraPrint'] == 'EXCEL') {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="rincianbiayaperawatanpasien-' . date("Y/m/d") . '.xls"');
        header('Cache-Control: max-age=0');
    } else if ($_GET['caraPrint'] == 'PDF') {
        $width = '100%';
        $font_size = '7pt';
        $max_width = "max-width: 3cm;";
        $width_dr = "3cm";
    }
}
?>

<style>
    /* pre, blockquote {page-break-inside: avoid;} */
    table {
        page-break-inside: auto
    }

    tr {
        page-break-inside: avoid;
        page-break-after: auto
    }

    thead {
        display: table-header-group
    }

    tfoot {
        display: table-footer-group
    }

    body {
        width: 100%;
        color: black;
    }

    .identitas {
        line-height: 12px;
    }

    .identitas td {
        vertical-align: top;
    }

    .judulcontent {
        text-align: center !important;
    }

    .rincian th,
    .rincian td {
        border: 1px solid black;
        background-color: white;
        color: black;
        padding: 5px;
        vertical-align: top;
    }

    .rincian tfoot td {
        font-weight: bold;
    }

    .table-rincian td,
    th {
        border-top: solid #000 1px;
        border-bottom: solid #000 1px;
        font-family: "Arial" !important;

    }

    .tab_detail thead td {
        /* border-top: solid #000 1px !important;
        vertical-align: top;
        border-bottom: solid #000 1px !important; */
        font-family: "Arial" !important;

    }

    TABLE,
    TBODY,
    TFOOT,
    TR,
    TH,
    TD {
        font-family: "Arial" !important;
        font-size: 9pt !important;
    }

    .tab_detail tfoot td,
    .footee {
        font-weight: bold;
    }

    .tab_detail .closing td {
        border-bottom: 1px solid black;
    }

    .tab_detail .upper td {
        border-top: 1px solid black;
    }

    .tab_detail .grand_total td {
        border-top: 1px solid black;
        border-bottom: 1px solid black;
    }

    .hddn {
        display: none;
    }

    @page {
        font-size: <?= $font_size ?> !important;
        margin: 0;
        margin-bottom: 5cm;
        padding-bottom: 5cm;
        font-family: "Arial" !important;
    }

    @media print {

        html,
        body {
            size: auto;
            margin: 0cm, 0.25cm, 0cm, 0.25cm;
            margin-top: 0.25cm;
            margin-right: 0.1cm;
            margin-left: 0.2cm;
            margin-bottom: 1cm;
            font-family: "Arial" !important;
            font-size: <?= $font_size ?>;
        }

        html,
        header {
            margin: 0cm, 0.25cm, 0cm, 0.25cm;
            margin-top: 0.25cm;
            margin-right: 0.1cm;
            font-family: "Arial" !important;
            font-size: <?= $font_size ?>;
        }

        TABLE,
        TBODY,
        TFOOT,
        TR,
        TH,
        TD {
            font-family: "Arial" !important;
            font-size: <?= $font_size ?> !important;
        }

        div.footer {
            position: fixed;
            bottom: 0;
        }

        pre,
        blockquote {
            page-break-inside: avoid;
        }

        table {
            page-break-inside: auto
        }

        tr {
            page-break-inside: avoid;
            page-break-after: auto
        }

        thead {
            display: table-header-group;
        }

        tfoot {
            display: table-footer-group;
        }
    }

    .border {
        border: 1px solid black;
    }

    .tab_header .upper td {
        border-top: 1px solid black;
    }

    .tab_border td,
    .tab_border th {
        border: 1px solid black !important;
        /* Set border menjadi 1 garis saja */
    }
</style>
<?php
$format = new MyFormatter;
?>

<table class="tab_header" style="width: 100%; border: none !important; text-align: center">
    <thead>
        <tr>
            <td>
                <?php
                echo $this->renderPartial('application.views.headerReport._headerRadiologi', array());
                ?>
            </td>
        </tr>
        <tr>
            <td style="text-align: right;"> <b> No. Kuitansi : <?= $model->no_lpj ?> </b></td>
        </tr>
        <tr class="upper">
            <td>
                <div class="judulcontent" style="text-align: center !important; font-size: 11pt; font-weight: bold; font-family: 'Arial' !important;">SLIP PENGELUARAN KAS / BANK </div>
            </td>
        </tr>
        <tr class="upper">
            <td> </td>
        </tr>
    </thead>
</table>

<div class="border">

</div>
<br>

<table style="" width="100%" class="tab_border" cellspacing="0" cellpadding="0">
    <tr>
        <td width="20%"> <b> DIBAYARKAN KEPADA </b></td>
        <td> <?= $model->pegawaimengajukan->namaLengkap ?></td>
    </tr>
    <tr>
        <td> <b> TERBILANG </b></td>
        <td> <?= ucwords(strtolower(MyFormatter::formatNumberTerbilang($model->nominal_kasbon))) ?> Rupiah </td>
    </tr>
</table>
<?php 
    $hitung_row = 0;
    if (!empty($modLPJ)) {
        $hitung_row = count($modLPJ) + 1;
    }
?>
<table style="" width="100%" class="tab_border" cellspacing="0" cellpadding="0">
    <tr>
        <td width="30%" style="text-align: center;"> <b> PERINCIAN </b></td>
        <td width="15%" style="text-align: center;"> <b> ACCOUNT </b></td>
        <td width="15%" style="text-align: center;"> <b> JUMLAH </b></td>
        <td width="15%" style="text-align: center;"> <b> HARGA SATUAN </b></td>
        <td width="15%" style="text-align: center;"> <b> SUBTOTAL </b></td>
        <td width="10%" style="text-align: center; vertical-align: middle !important" rowspan="<?= $hitung_row ?>" > <b style="writing-mode: vertical-rl;text-orientation: sideways-right; !important">  
            D <br> 
            E <br>
            B <br>
            E <br>
            T </b></td>
    </tr>
    <?php if (!empty($modLPJ)) {
        $hitung_row = count($modLPJ);
        $total = 0;
        ?>
        <?php foreach($modLPJ as $key => $det) {
            $hitung = $det['jumlah'] *  $det['harga_satuan'];
            ?>
            <tr>
                <td> <?= $det['perincian_pembayaran_lpj'] ?></td>
                <td> </td>
                <td> <?= $det['jumlah'] ?></td>
                <td style="text-align: right;"> <?= number_format($det['harga_satuan'], 0, ",", ".") ?></td>
                <td style="text-align: right;"> <?= number_format($hitung, 0, ",", ".") ?></td>
            </tr>
        <?php 
            $total += $hitung;
            } ?>
    <?php } ?>
</table>
<table style="" width="100%" class="tab_border" cellspacing="0" cellpadding="0">
    <tr>
        <td width="30%" style="text-align: center;" rowspan="2"> <b> TOTAL </b> </td>
        <td width="15%" style="text-align: center;"> <b> KAS</b></td>
        <td width="15%" style="text-align: right;"> <b> Rp. </b></td>
        <td width="15%"> </td>
        <td width="15%" style="text-align: right;"> <?= number_format($total, 0, ",", ".") ?> </td>
        <td style="text-align: center;" rowspan="2"> <B> KREDIT </B> </td>
    </tr>
    <tr>
        <td style="text-align: center;"> <b> BANK </b></td>
        <td style="text-align: right;"> <b> Rp. </b></td>
        <td> <b> </b></td>
        <td> <b> </b></td>
    </tr>
</table>

<br>

<table width="100%" style="font-weight: bold;">
    <tr>
        <!-- <td width="25%" style="text-align: center;">
            <br>
            Disetujui oleh
            <br>
            <br>
            <br>
            <?php
            //$modProfil = ProfilrumahsakitM::model()->find();
            ?>
            <b> <u> <?php //echo $modProfil->namadirektur_rumahsakit ?> </u> </b>
            <br>
            Direktur
        </td> -->
        <td width="30%" style="text-align: center;">
            <br>
            Diverifikasi II Oleh,
            <br>
            <br>
            <br>
            <b> <u> <?= $model->pegawaimenyetujui2->namaLengkap ?> </u></b>
            <br>
        </td>
        <td width="35%" style="text-align: center;">
            <br>
            <b> Diverifikasi I Oleh, </b>
            <br>
            <br>
            <br>
            <u> <b> <?= $model->pegawaimenyetujui1->namaLengkap ?> </b></u>
            <br>

        </td>
        <td width="30%" style="text-align: center;">
            <b> 
            <?php echo Yii::app()->user->getState('kabupaten_nama').", ".$format->formatDateTimeId(date('Y-m-d')); ?>
            <br>
                Disiapkan Oleh</b>
            <br>
            <br>
            <br>
            <hr style="border: 1px solid black">
        </td>
    </tr>
</table>