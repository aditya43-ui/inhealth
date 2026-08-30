<head>
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/entypo/css/entypo.css">        
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/font-awesome/css/font-awesome.css">
</head>
<?php $modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); ?>

<style>
    @page {
        font-size: 12pt !important;
        margin:0;
    }
    @media print {
        html, body {
            margin: 1cm;
            font-family: "Times New Roman", Times, serif;
            font-size:12pt;
/*            width:  21cm;
            height: 33cm;*/
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
    
    td {
        font-family: "Arial";
        color: black;
        font-size:16px !important;
    }
    th {
        font-family: "Arial";
        color: black;
        font-size:16px !important;
    }
    p {
        font-family: "Arial", Times, serif;
        font-size:16px !important;
    }
    @media print {
        .page-break { padding-top: 1cm;  display: block; page-break-before: always; }
    }
    h4{
        font-family: Arial, sans-serif;
        font-size: 20px !important;
    }
    .garis {
        border-top: 3px double black;
    }

</style>
<?php
$modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
$suratperjanjiankerja_id = $model->suratperjanjiankerja_id;
if (!empty($model->terminke)) {
    $cekTermin = SuratperjanjiankerjaterminT::model()->findByAttributes(array('suratperjanjiankerja_id' => $suratperjanjiankerja_id, 'terminke' => $model->terminke));
} else {
    $cekpemeriksaanpekerjaan = ADBapemeriksaanpekerjaanT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $suratperjanjiankerja_id));
    $jumlahpemeriksaan = count($cekpemeriksaanpekerjaan) + 1;

    $cekTermin = SuratperjanjiankerjaterminT::model()->findByAttributes(array('suratperjanjiankerja_id' => $suratperjanjiankerja_id, 'urutan' => $jumlahpemeriksaan));
}
?>
<div class="container">
    <div class="row-fluid" >
        <?php echo $this->renderPartial('application.views.headerReport.headerBeritaAcara'); ?>
    </div>
    <br>
    <div class="row-fluid" >
        <table width="100%">
            <tr>
                <td width="90%" style="vertical-align:top; text-align: justify; font-size: 16px !important;"><?php echo!empty($model->dasar) ? $model->dasar : ""; ?></td>
            </tr>
        </table>
    </div>
    <div class="row-fluid" >
        <table width="100%">
            <tr>
                <td width="50%" align="center">
                    <table>
                        <tr>
                            <td align="center" style="font-size: 16px !important;"> <b> PIHAK KEDUA</b> <br><?php echo $model->jabatan_pihakkedua ?></td>
                        </tr>
                        <tr>
                            <td height="85px"> </td>
                        </tr>
                        <tr>
                            <td align="center" style="font-size: 16px !important;">
                                <b><u> <?php echo $model->pegpihakkedua->namaLengkap ?> </u></b> <br> 
                                NIP. <?php echo $model->pegpihakkedua->nomorindukpegawai; ?>
                            </td>
                        </tr>
                    </table>
                </td>
                <td width="50%" align="center">
                    <table>
                        <tr>
                            <td align="center" style="font-size: 16px !important;"> <b> PIHAK KESATU </b> <br><?php echo $model->jabatan_pihakkesatu ?></td>
                        </tr>
                        <tr>
                            <td height="85px"> </td>
                        </tr>
                        <tr>
                            <td align="center" style="font-size: 16px !important;"> 
                                <b><u> <?php echo $model->pegpihakkesatu->namaLengkap ?> </u></b><br>
                                NIP. <?php echo $model->pegpihakkesatu->nomorindukpegawai; ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>

    <div class="page-break"> </div>

    <div class="row-fluid" >
        <?php echo $this->renderPartial('application.views.headerReport.headerBeritaAcara'); ?>
    </div>
    <br><br>
    <div class="row-fluid">
        <p style="font-size: 16px !important;"> <u> Lampiran Berita Acara Penyerahan Barang / Jasa <?php if($modSurat->istermin == true){ echo '(TERMIN ' . $model->terminke . ')'; }else{ echo '';} ?></u></p>
        <table>
            <tr>
                <td style="font-size: 16px !important;"> Nomor </td>
                <td style="font-size: 16px !important;"> : </td>
                <td style="font-size: 16px !important;"> <?php echo $model->nomor_beritaacara ?> </td>
            </tr>
            <tr>
                <td style="font-size: 16px !important;"> Tanggal </td>
                <td style="font-size: 16px !important;"> : </td>
                <td style="font-size: 16px !important;"> <?php echo date('d ', strtotime($model->bapenyerahanbarangjasa_tanggal)) . MyFormatter::getMonthId(date('m', strtotime($model->bapenyerahanbarangjasa_tanggal))) . date(' Y', strtotime($model->bapenyerahanbarangjasa_tanggal)); ?> </td>
            </tr>
        </table>
        <br>            
        <table width="100%" border="1">
            <thead>
                <tr>
                    <th style="font-size: 16px !important;"> No. </th>
                    <th style="font-size: 16px !important;">Uraian Pekerjaan</th>
                    <th style="font-size: 16px !important;">Satuan</th>
                    <th style="font-size: 16px !important;">Volume</th>
                    <th style="font-size: 16px !important;">Harga Satuan (Rp)</th>
                    <th style="font-size: 16px !important;">Jumlah Harga (Rp)</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $modDetail = SuratperjanjiankerjarincianT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $model->suratperjanjiankerja_id));
                $jumlah = 0;
                $ppn = 0;
                if (!empty($modDetail)) {
                    foreach ($modDetail as $key => $value) {
                        echo "
                        <tr>
                            <td style='text-align:center; font-size: 16px !important;'>" . ($key + 1) . "</td>
                            <td style='text-align:left; font-size: 16px !important;'>" . $value->barang_nama . "</td>
                            <td style='text-align:center; font-size: 16px !important;'>" . $value->barang_satuan . "</td>
                            <td style='text-align:center; font-size: 16px !important;'>" . $value->barang_jumlah . "</td>
                            <td style='text-align:right; font-size: 16px !important;'>" . number_format((float)$value->barang_harga,2,",",".") . "</td>
                            <td style='text-align:right; font-size: 16px !important;'>" . number_format((float)$value->barang_jumlah * $value->barang_harga,2,",",".") . "</td>
                        </tr>
                        ";
                        $jumlah += $value->barang_total;
                    }
                }
                $jumlah = $modSurat->jumlah_harga;
                $ppn = $modSurat->jumlah_pajak;
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <?php
                    if ($modSurat->istermin == true) {
                        ?>
                        <td colspan="4" rowspan="5">&nbsp;</td>
                    <?php } else { ?>
                        <td colspan="4" rowspan="3">&nbsp;</td>
                    <?php } ?>
                    <td style="text-align: left; font-size: 16px !important;"> Jumlah : </td>
                    <td style="text-align: right; font-size: 16px !important;">
                        <?=
                        number_format((float)$jumlah,2,",",".") .
                        CHtml::activeHiddenField($model, 'jumlah_harga', array('class' => 'span3', 'readonly' => true, 'value' => $jumlah))
                        ?>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: left; font-size: 16px !important;"> PPN 10% :</td>
                    <td style="text-align: right; font-size: 16px !important;">
                        <?=
                        number_format((float)$ppn,2,",",".") .
                        CHtml::activeHiddenField($model, 'jumlah_pajak', array('class' => 'span3', 'readonly' => true, 'value' => $ppn))
                        ?>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: left; font-size: 16px !important;"> Total :  </td>
                    <td style="text-align: right; font-size: 16px !important;">
                        <?=
                        number_format((float)$jumlah + $ppn,2,",",".") .
                        CHtml::activeHiddenField($model, 'total_harga', array('class' => 'span3', 'readonly' => true, 'value' => ($jumlah + $ppn)))
                        ?>
                    </td>
                </tr>
                <?php
                if ($modSurat->istermin == true) {
                    ?>
                    <tr>
                        <td style="text-align: left; font-size: 16px !important;">Dibulatkan : </td>
                        <td style='text-align:right; font-size: 16px !important;'><?php echo number_format((float)$model->total_dibulatkan,2,",",".") ?></td>
                    </tr>
                    <tr>
                        <td style="text-align: left; font-size: 16px !important;">Termin <?php echo $cekTermin->terminke; ?> (<?php echo $cekTermin->jumlah_persen ?>%) : </td>
                        <td style='text-align:right; font-size: 16px !important;'><?php echo number_format((float)$cekTermin->jumlah_harga,2,",","."); ?></td>
                    </tr>
                    <?php
                }
                ?>
            </tfoot>
        </table>
    </div>
    <div class="row-fluid" >
        <table width="100%">
            <tr>
                <td width="50%" align="center">
                    <table>
                        <tr>
                            <td align="center" style="font-size: 16px !important;"> <b> PIHAK KEDUA</b> <br><?php echo $model->jabatan_pihakkedua ?></td>
                        </tr>
                        <tr>
                            <td height="85px"> </td>
                        </tr>
                        <tr>
                            <td align="center" style="font-size: 16px !important;">
                                <b><u> <?php echo $model->pegpihakkedua->namaLengkap ?> </u></b> <br> 
                                NIP. <?php echo $model->pegpihakkedua->nomorindukpegawai; ?>
                            </td>
                        </tr>
                    </table>
                </td>
                <td width="50%" align="center">
                    <table>
                        <tr>
                            <td align="center" style="font-size: 16px !important;"> <b> PIHAK KESATU </b> <br><?php echo $model->jabatan_pihakkesatu ?></td>
                        </tr>
                        <tr>
                            <td height="85px"> </td>
                        </tr>
                        <tr>
                            <td align="center" style="font-size: 16px !important;"> 
                                <b><u> <?php echo $model->pegpihakkesatu->namaLengkap ?> </u></b><br>
                                NIP. <?php echo $model->pegpihakkesatu->nomorindukpegawai; ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
</div>