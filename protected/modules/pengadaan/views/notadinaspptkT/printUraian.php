<head>
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/entypo/css/entypo.css">        
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/font-awesome/css/font-awesome.css">
</head>
<style>
    @page {
        size: landscape;
        margin: 27mm 16mm 27mm 16mm;
        font-size: 10px !important;
        padding-top: 30px;
        margin-top: 0px;
        margin-bottom: 0px;
    }
    @media print {
        html, body {
            padding-top: 30px;
            line-height: 1.5;
        }
        div.footer {
            position: fixed;
            bottom: 0;
        }
        td{
            padding: 5px !important;
        }
    }
    table.footer {
        position: fixed;
        bottom: 0;
    }

    td{
        padding: 5px !important;
    }
    @media all {
        .page-break { display: none; }
    }

    @media print {
        .page-break { display: block; page-break-before: always;}
    }
</style>
<?php
$modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());

$modInfo = InformasipersiapanpengadaanV::model()->findByAttributes(array('persiapanpengadaan_id' => $model->persiapanpengadaan_id));
$cekpengadaansumberdana = PengadaansumberdanaT::model()->findAllByAttributes(array('rencanaumumpengadaan_id' => $modInfo->rencanaumumpengadaan_id));
if (!empty($cekpengadaansumberdana)) {
    //Kode Rekening
    $model->koderekening = '';
    foreach ($cekpengadaansumberdana as $value) {
        $cekRekening = Rekening5M::model()->findByPk($value->rekening5_id);
        $model->koderekening .= !empty($cekRekening) ? $cekRekening->kdrekening5 . ', ' : ' ';
    }
}
?>
<div class="container">
    <div class="row-fluid" >
        <table width="100%" border="0px">
            <tr>
                <td align="center" style="vertical-align:top">
                    <div style="font-size:12pt !important">
                        DAFTAR URAIAN JENIS PEKERJAAN/BARANG
                    </div>
                    <div style="font-size:12pt !important">
                        PROGRAM. <?php echo $modInfo->programkerja_kode ?> KEGIATAN. <?php echo $modInfo->kegiatanprogram_kode ?> KODE REK. <?php echo $model->koderekening; ?>
                    </div>
                    <div style="font-size:10pt !important;">
                        (<?php echo $modInfo->nama_pekerjaan ?>)
                    </div>
                    <hr style="border:1px solid">
                </td>
            </tr>
        </table>
    </div>
    <div class="row-fluid" >
        <table width="100%">
            <tr>
                <td width="80%" style="vertical-align:top">
                    <?php
                    $a = '<table border="1" style="width:100%; text-align:right">
                            <thead>
                                <tr>
                                    <th style="text-align: center"> No. </th>
                                    <th style="text-align: center"> Uraian / Jenis </th>
                                    <th style="text-align: center"> Jumlah <br>(Rp) </th>
                                </tr>
                                <tr>
                                    <td style="text-align: center; width:50px">1</td>
                                    <td style="text-align: center">2</td>
                                    <td style="text-align: center">3</td>
                                </tr>
                            </thead>
                            <tbody>';
                    $no = 1;
                    foreach ($modelDetail as $value) {
                        $a .= '<tr>
                                    <td style="text-align: center; width:50px">' . $no++ . '</td>
                                    <td style="text-align: center">' . $value->notadinaspptkdet_uraian . '</td>
                                    <td style="text-align: right">Rp&nbsp;' . number_format($value->jumlah_diterima) . '</td>
                                </tr>';
                    }
                    $a .= '</tbody>
                           <tfoot>
                                <tr>
                                    <th> </th>
                                    <th style="text-align: center"> TOTAL </th>
                                    <th style="text-align: right">Rp&nbsp;' . number_format($model->jumlah_diterima) . '&nbsp;</td>
                                </tr>
                           </tfoot>
                           </table>';
                    echo $a;
                    ?>
                </td>
            </tr>
        </table>
    </div>
    <div class="row-fluid" >
        <table width="100%">
            <tr>
                <td width="30%"></td>
                <td width="40%"></td>
                <td width="30%" height="50px" style="vertical-align:top; text-align: left;">Surabaya, <?php echo date('d ') . MyFormatter::getMonthId(date('m')) . date(' Y'); ?></td>
            </tr>
            <tr>
                <td width="30%" style="vertical-align:top; text-align: center;">Kepala Bagian Tata Usaha</td>
                <td width="40%"></td>
                <td width="30%" style="vertical-align:top; text-align: center;">Pejabat Pembuat Komitmen<br> </td>
            </tr>
            <tr>
                <td width="30%"> </td>
                <td width="40%"> </td>
                <td width="30%" height="80px"> </td>
            </tr>
            <tr>
                <td width="30%" style="vertical-align:top; text-align: center; text-decoration: underline"><?php echo $model->pegpjk->namaLengkap; ?></td>
                <td width="40%"> </td>
                <td width="30%" style="vertical-align:top; text-align: center; text-decoration: underline"><?php echo $model->pegppk->namaLengkap; ?></td>
            </tr>
            <tr>
                <td width="30%" style="vertical-align:top; text-align: center"> <?php echo $model->pegpjk->pangkat->pangkat_nama; ?></td>
                <td width="40%"> </td>
                <td width="30%" style="vertical-align:top; text-align: center"> <?php echo $model->pegppk->pangkat->pangkat_nama; ?></td>
            </tr>
            <tr>
                <td width="30%" style="vertical-align:top; text-align: center"> NIP. <?php echo $model->pegpjk->nomorindukpegawai; ?></td>
                <td width="40%"> </td>
                <td width="30%" style="vertical-align:top; text-align: center"> NIP. <?php echo $model->pegppk->nomorindukpegawai; ?></td>
            </tr>
        </table>
    </div>
</div>
