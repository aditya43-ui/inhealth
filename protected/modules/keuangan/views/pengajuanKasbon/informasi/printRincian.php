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
            <td style="text-align: right;"> <b> No. Kuitansi :  <?= $model->no_kuitansi ?>  </b></td>
        </tr>
        <tr class="upper">
            <td>
                <div class="judulcontent" style="text-align: center !important; font-size: 11pt; font-weight: bold; font-family: 'Arial' !important;">PERMOHONAN KAS BON OPERASIONAL </div>
            </td>
        </tr>
    </thead>
</table>

<div class="border">

    <table width="100%">
        <tr>
            <td colspan="3"> <b> Pemohon </b> </td>
        </tr>
        <tr>
            <td width="5%"> </td>
            <td width="15%"> Nama </td>
            <td> : <?= $model->pegawaimengajukan->namaLengkap ?></td>
        </tr>
        <tr>
            <td> </td>
            <td> Unit </td>
            <td> : <?= (!empty($model->pegawaimengajukan->unitkerja)?$model->pegawaimengajukan->unitkerja->namaunitkerja:""); ?></td>
        </tr>
        <tr>
            <td> </td>
            <td> Nominal </td>
            <td> : <?= MyFormatter::formatUang($model->nominal_kasbon) ?></td>
        </tr>
        <tr>
            <td> </td>
            <td> Tgl/No. Pengajuan </td>
            <td> : <?= MyFormatter::formatDateTimeForUser($model->tgl_pengajuan) . "/" . $model->no_pengajuan; ?></td>
        </tr>
        <tr>
            <td> </td>
            <td> Nominal </td>
            <td> : <?= ucwords(strtolower(MyFormatter::formatNumberTerbilang($model->nominal_kasbon)))  ?> Rupiah </td>
        </tr>
    </table>
</div>
<br>

<div class="border">
    <table width="100%">
        <tr>
            <td colspan="2"> <b> Keperluan </b> </td>
        </tr>
        <tr>
            <td width="5%"> </td>
            <td> <?= $model->keperluan ?></td>
        </tr>
    </table>
</div>

<br> 

<table width="100%" style="font-weight: bold;">
    <tr>
        <td width="33%" style="text-align: center;">
            Menyetujui II
            <br>
            <br>
            <br>
            <?= $model->pegawaimenyetujui2->namaLengkap ?> <br>
        </td>
        <td width="33%" style="text-align: center;">
            <b> Menyetujui I </b>
            <br>
            <br>
            <br>
            <?= $model->pegawaimenyetujui1->namaLengkap ?> <br>

        </td>
        <td width="33%" style="text-align: center;">
            <b> Mengatahui</b>
            <br>
            <br>
            <br>
            <?= $model->pegawaimengetahui->namaLengkap ?> <br>
        </td>
    </tr>
</table>