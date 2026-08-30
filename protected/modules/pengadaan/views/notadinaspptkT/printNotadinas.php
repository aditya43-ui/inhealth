<head>
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/entypo/css/entypo.css">        
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/font-awesome/css/font-awesome.css">
</head>
<style>
    @page {
        size: 7in 9.25in;
        margin: 27mm 16mm 27mm 16mm;
        font-size: 10px !important;
        padding-top: 30px;
        margin-top: 0px;
        margin-bottom: 0px;
    }
    @media print {
        html, body {
            padding-top: 30px;
            width: 210mm;
            height: 330mm;
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
<?php $modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); ?>
<div class="container">
    <div class="row-fluid" >
        <table width="100%" border="0px">
            <tr>
                <td align="center" style="vertical-align:top">
                    <div style="font-size:12pt !important">
                        RUMAH SAKIT UMUM DAERAH DOKTER SOETOMO
                    </div>
                    <div style="font-size:12pt !important">
                        PEJABAT PELAKSANA TEKNIS KEGIATAN
                    </div>
                    <div style="font-size:12pt !important">
                        UMUM DAN KEUANGAN RSUD.Dr.SOETOMO
                    </div>
                    <div style="font-size:12pt !important; font-weight: bold">
                        <?php echo $modProfilRs->alamatlokasi_rumahsakit; ?>, Telp. <?php echo $modProfilRs->notelphumas; ?> - 5501013
                    </div>
                    <hr style="border:1px solid">
                </td>
            </tr>
        </table>
    </div>
    <div class="row-fluid" >
        <table width="100%">
            <tr>
                <td width="80%" style="vertical-align:top"><?php echo!empty($model->isi_surat) ? $model->isi_surat : ""; ?></td>
            </tr>
            <tr>
                <td width="80%" style="vertical-align:top">
                    <?php
                    $modInfo = InformasipersiapanpengadaanV::model()->findByAttributes(array('persiapanpengadaan_id' => $model->persiapanpengadaan_id));
                    $cekpengadaansumberdana = PengadaansumberdanaT::model()->findAllByAttributes(array('rencanaumumpengadaan_id' => $modInfo->rencanaumumpengadaan_id));
                    if (!empty($cekpengadaansumberdana)) {
                        //Kode Rekening
                        $model->koderekening = '';
                        $model->kegiatanprogram_nama = '';
                        $model->programkerja_nama = '';
                        $model->subprogramkerja_nama = '';
                        $model->subprogramkerja_nama .= !empty($modInfo) ? $modInfo->subprogramkerja_kode : ' ';
                        $model->programkerja_nama .= !empty($modInfo) ? $modInfo->programkerja_kode : ' ';
                        if (!empty($model->mappingrekeninganggaran_id)) {
                            $mapping = MappingrekeninganggaranM::model()->findByPk($model->mappingrekeninganggaran_id);
                            $model->koderekening .= !empty($mapping) ? $mapping->kodeanggaran : ' ';
                        }
                        
                    }

                    $a = '<table border="1" style="width:98%; text-align:right">
                            <thead>
                                <tr>
                                    <th style="text-align: center"> Penanggung <br>Jawab <br>Kegiatan </th>
                                    <th style="text-align: center"> Alamat </th>
                                    <th style="text-align: center"> Kode <br>Prog/Keg </th>
                                    <th style="text-align: center"> Kode <br>Rekening </th>
                                    <th style="text-align: center"> Keterangan </th>
                                    <th style="text-align: center"> Jumlah <br>(Rp) </th>';
                    if ($model->ispph22 == true) {
                        $a .= '         <th style="text-align: center"> Pph 22 <br>(Rp) </th>
                                    <th style="text-align: center"> Jumlah <br>yang diterima <br>(Rp) </th>';
                    }
                    $a .= '     </tr>
                            </thead>
                            <tbody>';
                    $no = 1;
                    foreach ($modelDetail as $value) {
                        $a .= '<tr>
                                    <td style="text-align: center">' . $model->pegpjk_jabatan . '</td>
                                    <td style="text-align: center">' . $modProfilRs->alamatlokasi_rumahsakit . '</td>
                                    <td style="text-align: center">' . $model->programkerja_nama . '/' . $model->subprogramkerja_nama . '</td>
                                    <td style="text-align: center">' . $model->koderekening . '</td>
                                    <td style="text-align: center">' . $value->notadinaspptkdet_ket . '</td>
                                    <td style="text-align: right">Rp&nbsp;' . number_format($value->jumlah_harga) . '</td>';
                        if ($model->ispph22 == true) {
                            $a .= '     <td style="text-align: right">Rp&nbsp;' . number_format($value->jumlah_pph22) . '</td>
                                    <td style="text-align: right">Rp&nbsp;' . number_format($value->jumlah_diterima) . '</td>';
                        }
                        $a .= '</tr>';
                    }
                    $a .= '</tbody>
                           <tfoot>
                                <tr>';
                    if ($model->ispph22 == true) {
                        $a .= '     <th colspan=7 style="text-align: center"> Jumlah </th>';
                    } else {
                        $a .= '     <th colspan=5 style="text-align: center"> Jumlah </th>';
                    }
                    $a .= '     <th style="text-align: right">Rp&nbsp;' . number_format($model->jumlah_diterima) . '&nbsp;</td>
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
                <td width="35%"></td>
                <td width="30%"></td>
                <td width="35%" style="vertical-align:top; text-align: center;">Pejabat Pelaksana Teknis Kegiatan<br> </td>
            </tr>
            <tr>
                <td width="35%"> </td>
                <td width="30%"> </td>
                <td width="35%" height="80px"> </td>
            </tr>
            <tr>
                <td width="35%"> </td>
                <td width="30%"> </td>
                <td width="35%" style="vertical-align:top; text-align: center; text-decoration: underline"><?php echo $model->pegpptk->namaLengkap; ?></td>
            </tr>
            <tr>
                <td width="35%"> </td>
                <td width="30%"> </td>
                <td width="35%" style="vertical-align:top; text-align: center"> <?php echo $model->pegpptk->pangkat->pangkat_nama; ?></td>
            </tr>
            <tr>
                <td width="35%"> </td>
                <td width="30%"> </td>
                <td width="35%" style="vertical-align:top; text-align: center"> NIP. <?php echo $model->pegpptk->nomorindukpegawai; ?></td>
            </tr>
        </table>
    </div>
</div>
