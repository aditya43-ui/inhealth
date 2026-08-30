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
        margin-left: 5px;
    }

    .tab_etiket td {
        font-size: 6pt;
        font-family: Arial, Helvetica, sans-serif;
        /* vertical-align: top; */
        padding-left: 2px;
        padding-right: 1px;
        padding-top: 0px;
    }

    #logo {
        width: 30px;
        height: 30px;
    }

    .text {
        border-collapse: collapse;
    }

    .text tr td {
        font-size: 6.6pt;
        /* font-family: Arial, Helvetica, sans-serif;
            /* vertical-align: top; */
        /* padding-left: 2px;
            padding-right: 1px;
            padding-top: 0px; */
    }

    .header {
        text-align: center;
        font-size: 6.5pt;
    }

    .tbl-resep tr,
    .tbl-resep td {
        vertical-align: top;
        line-height: 1pt;
    }

    .tbl-resep-obat tr,
    .tbl-resep-obat td {
        vertical-align: top;
        line-height: 8pt;
    }

    .tbl-resep-obat {
        margin: -4pt 0;
    }

    table tr,
    table td {
        vertical-align: top;
        font-size: 6.5pt;
    }
</style>
<div class="header">
    <div style=""><br>INSTALASI FARMASI<br>RSUD Dr. SAIFUL ANWAR MALANG</div>
</div>
<hr style="text-align: center; width: 90%; margin: -1px 0;">
<div class="content" style="margin-left: 10px; width: 90%; margin-top: 0px;">
    <table style="width: 100%;" class="tbl-resep">
        <tr>
            <td style="width: 40%;">No. Resep </td>
            <td style="width: 3%;"> : </td>
            <td><?php echo $modPenjualan->noresep;?></td>
        <tr>
        <tr>
            <td>Tanggal </td>
            <td> : </td>
            <td><?php echo MyFormatter::formatDateTimeForUser($modPenjualan->tglpenjualan);?></td>
        <tr>
        <tr>
            <td>Nama Px </td>
            <td> : </td>
            <td><?php echo "<b>" . substr($modPasien->nama_pasien,0, 22) . "</b>";?></td>
        <tr>
        <tr>
            <td>No. RM / Tgl. Lahir </td>
            <td> : </td>
            <td><?php echo "<b>" . $modPasien->no_rekam_medik . "</b> - " . date('d-m-Y', strtotime($modPasien->tanggal_lahir));?></td>
        <tr>
        <tr>
            <td style="width: 40%;">Ruangan </td>
            <td style="width: 3%;"> : </td>
            <td style="font-size: 6pt;"><?php echo substr($modPendaftaran->ruangan->ruangan_nama, 0, 24);?></td>
        <tr>
        <tr>
    </table>
    <table style="width: 100%; margin-top: -5pt; margin-bottom: 0pt;" class="">
        <tr>
            <td style="width: 40%;">Nama Obat </td>
            <td style="width: 3%;"> : </td>
            <td style="padding: 2px;"><?php echo $obat['obatalkes_nama'] . " - " . $obat['jumlahpermintaan_obatnonracikan']?></td>
        </tr>
    </table>
    <table style="width: 100%;  margin-top: -3pt; margin-bottom: -3pt;" class="tbl-obat">
    <tr class="tr-long">
            <td style="width: 40%;">Aturan </td>
            <td style="width: 3%;"> : </td>
            <td><?php echo $obat['etiket']; ?></td>
        <tr>
        </table>
    <table style="width: 100%;" class="tbl-resep">
        <tr>
            <td style="width: 40%;">Exp. Date </td>
            <?php
                $exp = "";

                if(!empty($obat['kadaluarsa'])) {
                    $exp = $obat['kadaluarsa'];
                }
            ?>
            <td style="width: 3%;"> : </td>
            <td><?=$exp ?></td>
        <tr>
        <tr>
            <td style="width: 40%;">Waktu </td>
            <td style="width: 3%;"> : </td>
            <td></td>
        <tr>
    </table>
</div>
