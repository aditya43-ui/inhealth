<head>
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/entypo/css/entypo.css">        
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/font-awesome/css/font-awesome.css">
</head>
<style>
    @page {
        /*   size: 7in 9.25in;*/
        /*   margin: 27mm 16mm 27mm 16mm;*/
        font-size: 12pt !important;
        margin-top:0;
        margin-bottom:0;
        margin-left:0;
        margin-right:0;
    }
    @media print {
        html, body {
            padding:1cm 1.5cm 1cm 1.5cm;
            font-family: "Times New Roman", Times, serif;
            font-size:12pt;
            width:  21cm;
            height: 33cm;
        }
        div.footer {
            position: fixed;
            bottom: 0;
        }
    }
    table.footer {
        position: fixed;
        bottom: 0;
    }

    @media all {
        .page-break { display: none; }
    }

    @media print {
        .page-break { display: block; page-break-before: always; }
    }
    td {
        font-family: "Arial";
        color: black;
        font-size:12pt;
    }
    th {
        font-family: "Arial";
        color: black;
        font-size:12pt;
    }
    p {
        font-family: "Arial", Times, serif;
        font-size:12pt;
    }
    h4 {
        font-family: "Arial", Times, serif;
        font-size:14pt;
    }
    #judul{
        font-size:14pt;
    }
    u {
        font-family: "Arial", Times, serif;
        font-size:12pt;
    }

    .tabel-pemenang{
        color: black;
        font-family: Arial;
        font-size: 12pt; 
    }
    .garis {
        border-top: 3px double black;
    }

    blockquote {
        text-align: center;
        border: none;
    }
    @media all {
        .page-break { display: none; }
    }

    @media print {
        .page-break { display: block; page-break-before: always;}
    }

</style>
<?php $modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); ?>
<div class="container">
    <div class="row-fluid" >
        <?php echo $this->renderPartial('application.views.headerReport.headerBeritaAcara'); ?>
    </div>
    <div class="row-fluid" >
        <table width="100%">
            <tr>
                <td width="80%" style="vertical-align:top"><?php echo!empty($model->isi_surat) ? $model->isi_surat : ""; ?></td>
            </tr>
        </table>
    </div>
    <div class="row-fluid" >
        <table width="100%">
            <tr>
                <td width="40%" style="vertical-align:top; text-align: center;"> <b> PIHAK KEDUA </b> <br>  <?php echo $sup->supplier_nama ?> </td>
                <td width="20%"> </td>
                <td width="40%" style="vertical-align:top; text-align: center;"> <b> PIHAK KESATU </b> <br> PEJABAT PEMBUAT KOMITMEN </td>
            </tr>
            <tr>
                <td width="40%"> </td>
                <td width="20%"> </td>
                <td width="40%" height="80px"> </td>
            </tr>
            <tr>
                <td width="40%" style="vertical-align:top; text-align: center;"> <b> <u> <?php echo $sup->direktursupplier ?> </u> </b> <br> Direktur </td>
                <td width="20%"> </td>
                <td width="45%" style="vertical-align:top; text-align: center; text-decoration: underline"> <b> <?php echo !empty($model->pegpihakkesatu_id) ? $model->pegpihakkesatu->namaLengkap : '' ?> </b> </td>
            </tr>
            <tr>
                <td width="40%"> </td>
                <td width="20%"> </td>
                <td width="40%" style="vertical-align:top; text-align: center"> NIP. <?php echo!empty($model->pegpihakkesatu_id) ? $model->pegpihakkesatu->nomorindukpegawai : '' ?></td>
            </tr>
        </table>
    </div>
</div>
<div class="page-break"></div>
<div class="container" style="padding-top:30px !important">
    <div class="row-fluid" >
        <?php echo $this->renderPartial('application.views.headerReport.headerBeritaAcara'); ?>
    </div>

    <table border="0" cellpadding="1" cellspacing="1" style="width:100%">
        <tbody>
            <tr>
                <?php 
                $modSPK = SuratperjanjiankerjaT::model()->findByPk($model->suratperjanjiankerja_id);
                $mTermin = SuratperjanjiankerjaterminT::model()->findByAttributes(array('suratperjanjiankerja_id' => $modSPK->suratperjanjiankerja_id, 'terminke' => $model->terminke));

                if ($modSPK->istermin == true) { ?>
                <td colspan="2" style="font-size:12pt !important; text-decoration: underline">Lampiran Berita Acara Kemajuan Hasil Pekerjaan (TERMIN <?php echo $mTermin->terminke; ?>)</td>
                <?php } else { ?>
                <td colspan="2" style="font-size:12pt !important; text-decoration: underline">Lampiran Berita Acara Kemajuan Hasil Pekerjaan</td>
                <?php } ?>
            </tr>
            <tr>
                <td style="text-align:left; width:70px">Nomor</td>
                <td>: <?php echo $model->nomor_beritaacara; ?></td>
            </tr>
            <tr>
                <td style="text-align:left; width:70px">Tanggal</td>
                <td>: <?php echo date('d ', strtotime($model->bakemajuanhasilpekerjaan_tanggal)).MyFormatter::getMonthId(date('m', strtotime($model->bakemajuanhasilpekerjaan_tanggal))).date(' Y', strtotime($model->bakemajuanhasilpekerjaan_tanggal));  ?></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
        </tbody>
    </table>

    <table border="1" cellpadding="1" cellspacing="1" style="width:100%">
        <thead>
            <tr>
                <th style="text-align:center; width:30px"> <p>No.</p> </th>
                <th style="text-align:center; width:180px"> <p> Uraian Pekerjaan </p> </th>
                <th style="text-align:center; width:20px"> <p> Satuan </p> </th>
                <th style="text-align:center; width:20px"> <p> Volume </p> </th>
                <th style="text-align:center; width:40px"> <p> Harga Satuan (Rp)</p> </th>
                <th style="text-align:center; width:30px"> <p> Jumlah Harga (Rp)</p> </th>
            </tr>
        </thead>
        <tbody
        <?php
        $jumlah = 0;
        $ppn = 0;
        if (count($modelDetail)) {

            foreach ($modelDetail as $key => $value) {
                $value->harga_total = $value->volume_barang * $value->harga_satuan;
                echo "
                        <tr>
                            <td style=\"text-align: center\">" . ($key + 1) . "</td>
                            <td>" . $value->nama_barang . "</td>
                            <td style=\"text-align: center\">" . $value->barang_satuan . "</td>
                            <td style=\"text-align: center\">" . $value->volume_barang . "</td>
                            <td style=\"text-align: right\">" . number_format((float)$value->harga_satuan,2,",",".") . "</td>
                            <td style=\"text-align: right\">" . number_format((float)$value->harga_total,2,",",".") . "</td>
                        </tr>
                        ";

                $jumlah += $value->volume_barang * $value->harga_satuan;
            }
        }

        $ppn = $cekSuratPerjanjian->jumlah_pajak;
        ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="5" style="text-align: right; "><b>Jumlah  </b></td>
            <td style="text-align: right;">
                <?=
                number_format((float)$jumlah,2,",",".") .
                CHtml::activeHiddenField($model, 'jumlah_harga', array('class' => 'span3', 'readonly' => true, 'value' => $jumlah))
                ?>
            </td>
        </tr>
        <tr>
            <td colspan="5" style="text-align: right;"><b>PPN 10% *)</b></td>
            <td style="text-align: right;">
                <?=
                number_format((float)$ppn,2,",",".") .
                CHtml::activeHiddenField($model, 'jumlah_pajak', array('class' => 'span3', 'readonly' => true, 'value' => $ppn))
                ?>
            </td>
        </tr>
        <tr>
            <td colspan="5" style="text-align: right;"><b>Jumlah + PPN *)</b></td>
            <td style="text-align: right;">
                <?=
                number_format((float)$jumlah + $ppn,2,",",".") .
                CHtml::activeHiddenField($model, 'total_harga', array('class' => 'span3', 'readonly' => true, 'value' => ($jumlah + $ppn)))
                ?>
            </td>
        </tr>
        <?php 
        $modSPK = SuratperjanjiankerjaT::model()->findByPk($model->suratperjanjiankerja_id);
        if ($modSPK->istermin == true) { ?>
        <tr>
            <td colspan="5" style="text-align: right;"><b>Dibulatkan</b></td>
            <td style="text-align: right;">
                <?=
                number_format((float)$model->total_dibulatkan,2,",",".")?>
            </td>
        </tr>
        <tr>
            <td colspan="5" style="text-align: right;"><b>Termin <?php echo $model->terminke." (".$model->termin_persen."%)"?></b></td>
            <td style="text-align: right;">
                <?=
                number_format((float)$model->total_pembayaran,2,",",".");
                ?>
            </td>
        </tr>
        <?php }?>
    </tfoot>
</table>
    <br>
    <br>
    <div class="row-fluid" >
        <table width="100%">
            <tr>
                <td width="40%" style="vertical-align:top; text-align: center;"> <b> PIHAK KEDUA </b> <br>  <?php echo $sup->supplier_nama ?> </td>
                <td width="20%"> </td>
                <td width="40%" style="vertical-align:top; text-align: center;"> <b> PIHAK KESATU </b> <br> PEJABAT PEMBUAT KOMITMEN </td>
            </tr>
            <tr>
                <td width="40%"> </td>
                <td width="20%"> </td>
                <td width="40%" height="80px"> </td>
            </tr>
            <tr>
                <td width="40%" style="vertical-align:top; text-align: center;"> <b> <u> <?php echo $sup->direktursupplier ?> </u> </b> <br> Direktur </td>
                <td width="20%"> </td>
                <td width="45%" style="vertical-align:top; text-align: center; text-decoration: underline"> <b> <?php echo !empty($model->pegpihakkesatu_id) ? $model->pegpihakkesatu->namaLengkap : '' ?> </b> </td>
            </tr>
            <tr>
                <td width="40%"> </td>
                <td width="20%"> </td>
                <td width="40%" style="vertical-align:top; text-align: center"> NIP. <?php echo!empty($model->pegpihakkesatu_id) ? $model->pegpihakkesatu->nomorindukpegawai : '' ?></td>
            </tr>
        </table>
        <br><br><br><br>
        <i>*) Jika Diperlukan</i>
    </div>
</div>
<p>&nbsp;</p>

<script>
    $(document).ready(function () {
//        $("table tbody").find("table").attr("border", "0");
//        $("table tbody").find("table").attr("border", "0");
//        $("table tbody").find("table").css("width", "100%");
//        $("p").css("text-align", " center");
        $("h2").css("text-align", " center");
        $("h3").css("text-align", " center");
        $("h3").css("color", " black");
        $("big").parent().css("text-align", "center");

//        $("table tbody").find("table td").attr("text-align", "justify");
//        $("table tbody").find("table td").css("vertical-align", "top");
    });
</script>
