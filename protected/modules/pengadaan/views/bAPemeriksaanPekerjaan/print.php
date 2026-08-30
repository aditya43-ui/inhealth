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
        .page-break { padding-top: 70px; display: block; page-break-before: always; }
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
    <div class="row-fluid" >
        <table width="100%">
            <tr>
                <td width="90%" style="vertical-align:top; text-align: justify"><?php echo!empty($model->dasar) ? $model->dasar : ""; ?></td>
            </tr>
        </table>
    </div>
    <div class="row-fluid" >

        <table width="100%">
            <tr>
                <td width="25%">
                    <table width="100%">
                        <tr>
                            <td align="center"> 
                                PENYEDIA BARANG/JASA <br>
                                <?php $modSurat = SuratperjanjiankerjaT::model()->findByPk($model->suratperjanjiankerja_id); ?>
                                <?php echo!empty($modSurat->supplier->supplier_nama) ? $modSurat->supplier->supplier_nama : "" ?>
                            </td>
                        </tr>
                        <tr>
                            <td height="85px">

                            </td>
                        </tr>
                        <tr>
                            <td align="center"> 
                                <u> <b> <?php echo $modSurat->supplier->direktursupplier; ?> </b> </u> <br>
                                Direktur
                            </td>
                        </tr>
                    </table>
                </td>
                <td width="75%">
                    <table width="100%">
                        <tr>
                            <td width="40%">
                            </td>
                            <td width="60%">TIM TEKNIS</td>
                        </tr>
                        <tr>
                            <td width="40%">
                            </td>
                            <td width="60%">&nbsp;</td>
                        </tr>
                        <tr>
                            <td width="40%">
                            </td>
                            <td width="60%">
                                <?php
                                $modTeknisi = PegtimteknisT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $model->suratperjanjiankerja_id, 'bapemeriksaanpekerjaan_id' => $model->bapemeriksaanpekerjaan_id));
                                //$cekPegpphp = PegpphpT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $model->suratperjanjiankerja_id));
                                $a = '<table border="0" style="width:100%; text-align:right">';
                                $no = 1;
                                foreach ($modTeknisi as $panitia) {
                                    $cekPegawai = PegawaiM::model()->findByPk($panitia->pegawai_id);
                                    $a .= '<tr >
                                    <td width="5%">' . $no++ . '. </td>
                                    <td width="5%" align="left">Nama </td>
                                    <td width="5%">: </td>
                                    <td align="left">' . $cekPegawai->namaLengkap . '</td>
                                </tr>
                                <tr>
                                    <td width="5%"></td>
                                    <td align="left" width="5%">Tanda Tangan </td>
                                    <td width="5%">: </td>
                                    <td align="left"> ............................................ </td>
                                </tr>';
                                }
                                $a .= '</table>';
                                echo $a;
                                ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

    </div>

</div>
<div class="page-break"></div>
<div class="row-fluid" >
    <?php echo $this->renderPartial('application.views.headerReport.headerBeritaAcara'); ?>
</div>
<div class="row-fluid" >
    <table width="100%">
        <tr>
            <td width="90%" style="vertical-align:top; text-align: justify">
                <table>
                    <tr>
                        <td>Daftar</td>
                        <td>:</td>
                        <td colspan="3">Lampiran Berita Acara Pemeriksaan Pekerjaan <?php if ($modsurat->istermin == true) {
        echo '(TERMIN ' . $model->terminke . ')';
    } else {
        echo '';
    } ?></td>
                    </tr>
                    <tr>
                        <td>Nomor</td>
                        <td>:</td>
                        <td colspan="3">  <?php echo $model->nomor_beritaacara ?></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>

<div class="row-fluid">
    <div class="col-sm-12">
        <table border="1" id="tabel_lampiran" width="100%">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Uraian Pekerjaan</th>
                    <th>Satuan</th>
                    <th>Volume</th>
                    <th>Harga Satuan (Rp)</th>
                    <th>Jumlah Harga (Rp)</th>
                    <th>Hasil Pemeriksaan</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $modSPKRincian = ADBapemeriksaanpekerjaandetT::model()->findAllByAttributes(array('bapemeriksaanpekerjaan_id' => $model->bapemeriksaanpekerjaan_id));

                $jumlah = 0;
                $ppn = 0;
                if (count($modSPKRincian)) {

                    foreach ($modSPKRincian as $key => $value) {
                        if ($value->hasil_pemeriksaan == 1) {
                            $hasil = "<i class='fa fa-check'>";
                        } else {
                            $hasil = "<i class='fa fa-times'></i>";
                        }
                        echo "
                        <tr>
                            <td><center>" .
                        ($key + 1)
                        . "<center></td>
                            <td style='text-align:left'>" . $value->nama_barang . "</td>
                            <td style='text-align:center'>" . $value->satuan_barang . "</td>
                            <td style='text-align:center'>" . $value->jumlah_barang . "</td>
                            <td style='text-align:right'>" . number_format((float)$value->harga_satuan,2,",",".") . "</td>
                            <td style='text-align:right'>" . number_format((float)$value->jumlah_harga,2,",",".") . "</td>
                            <td style='text-align:center'>" . $hasil . "</td>
                            <td style='text-align:center'>" . $value->keterangan_pemeriksaan . "</td>
                        </tr>
                        ";
                        $jumlah += $value->jumlah_harga;
                    }
                }
                $ppn = $model->jumlah_pajak;
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="5" style="text-align: right">Jumlah : </th>
                    <th style='text-align:right'><?php echo number_format((float)$jumlah,2,",",".") ?></th>
                    <?php
                    if ($modsurat->istermin == true) {
                        ?>
                        <th colspan="2" rowspan="5">&nbsp;</th>
<?php } else { ?>
                        <th colspan="2" rowspan="3">&nbsp;</th>
<?php } ?>
                </tr>
                <tr>
                    <th colspan="5" style="text-align: right">PPN 10% : </th>
                    <th style='text-align:right'><?php echo number_format((float)$ppn,2,",",".") ?></th>
                </tr>
                <tr>
                    <th colspan="5" style="text-align: right">Total : </th>
                    <th style='text-align:right'><?php echo number_format((float)$jumlah + $ppn,2,",",".") ?></th>
                </tr>
<?php
if ($modsurat->istermin == true) {
    ?>
                    <tr>
                        <th colspan="5" style="text-align: right">Dibulatkan : </th>
                        <th style='text-align:right'><?php echo number_format((float)$model->total_dibulatkan,2,",",".") ?></th>
                    </tr>
                    <tr>
                        <th colspan="5" style="text-align: right">Termin <?php echo $cekTermin->terminke; ?> (<?php echo $cekTermin->jumlah_persen ?>%) : </th>
                        <th style='text-align:right'><?php echo number_format((float)$cekTermin->jumlah_harga,2,",","."); ?>
                        </th>
                    </tr>
    <?php
}
?>
            </tfoot>
        </table>

    </div>
</div>
<div class="row-fluid" >

    <table width="100%" >
        <tr>
            <td width="25%" style="vertical-align:top">
                <table width="100%" border="1">
                    <tr>
                        <td > 
                            <u>Kolom Keterangan</u> <br>

                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table>
                                <tr>
                                    <td><i class='fa fa-check'></i></td>
                                    <td>=</td>
                                    <td>Sesuai kontak</td>
                                </tr>
                                <tr>
                                    <td><i class='fa fa-times'></i></td>
                                    <td>=</td>
                                    <td>Tidak sesuai kontrak</td>
                                </tr>
                            </table> 
                        </td>
                    </tr>

                </table>
            </td>
            <td width="75%">
                <table width="100%">
                    <tr>
                        <td width="40%">
                        </td>
                        <td width="60%">Surabaya, <?php echo date('d ', strtotime($model->bapemeriksaanpekerjaan_tanggal)) . MyFormatter::getMonthId(date('m', strtotime($model->bapemeriksaanpekerjaan_tanggal))) . date(' Y', strtotime($model->bapemeriksaanpekerjaan_tanggal)); ?></td>
                    </tr>
                    <tr>
                        <td width="40%">
                        </td>
                        <td width="60%">&nbsp;</td>
                    </tr>
                    <tr>
                        <td width="40%">
                        </td>
                        <td width="60%">TIM TEKNIS</td>
                    </tr>
                    <tr>
                        <td width="40%">
                        </td>
                        <td width="60%">
                            <?php
                            $modTeknisi = PegtimteknisT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $model->suratperjanjiankerja_id, 'bapemeriksaanpekerjaan_id' => $model->bapemeriksaanpekerjaan_id));
                            //$cekPegpphp = PegpphpT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $model->suratperjanjiankerja_id));
                            $a = '<table border="0" style="width:100%; text-align:right">';
                            $no = 1;
                            foreach ($modTeknisi as $panitia) {
                                $cekPegawai = PegawaiM::model()->findByPk($panitia->pegawai_id);
                                $a .= '<tr >
                                    <td width="5%">' . $no++ . '. </td>
                                    <td width="5%" width="5%" align="left">Nama </td>
                                    <td width="5%">: </td>
                                    <td align="left">' . $cekPegawai->namaLengkap . '</td>
                                </tr>
                                <tr>
                                    <td width="5%"></td>
                                    <td width="5%" width="5%" align="left">Tanda Tangan </td>
                                    <td width="5%">: </td>
                                    <td align="left"> ............................................ </td>
                                </tr>';
                            }
                            $a .= '</table>';
                            echo $a;
                            ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

</div>

<script>
    $(document).ready(function () {
        $("table tbody").find("table").attr("border", "0");
        $("table tbody").find("table").attr("border", "0");
        $("table tbody").find("table").css("width", "100%");
        $("p").css("text-align", " justify");
        $("h2").css("text-align", " center");
        $("h3").css("text-align", " center");
        $("big").parent().css("text-align", "center");

        $("table tbody").find("table td").attr("text-align", "justify");
        $("table tbody").find("table td").css("vertical-align", "top");
    });
</script>