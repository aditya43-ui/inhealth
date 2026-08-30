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
            height: 297mm;
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
    @media print {
    .page-break { padding-top: 50px; display: block; page-break-before: always; }
    }
</style>
<?php $modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); ?>
<div class="container">
    <div class="row-fluid" >
        <table width="100%" border="0px">
            <tr>
                <td width="15%" align="center">
                    <img src="<?php echo Params::pathImageErrorAdmin() . "Jawa_Timur.png" ?> " style="max-width: 80px; width:80px;"/>
                </td>
                <td align="center">
                    <div style="font-size:13pt !important">
                        <b><?php
                            echo strtoupper($modProfilRs->namakepemilikanrs) . ' ';
                            echo strtoupper($modProfilRs->propinsi->propinsi_nama);
                            ?>
                        </b>
                    </div>
                    <div style="font-size:13pt !important">
                        <b><?php echo strtoupper($modProfilRs->nama_rumahsakit); ?></b>
                    </div>
                    <div style="font-size:10pt !important">
                        <i><?php echo $modProfilRs->alamatlokasi_rumahsakit; ?>, Telp. <?php echo $modProfilRs->notelphumas; ?>-1013, Fax. <?php echo $modProfilRs->no_faksimili; ?></i>
                    </div>

                    <div style="font-size:10pt !important">
                        <u><b>SURABAYA - 60286</b></u>
                    </div>
                </td>
                <td width="15%" align="center">
                    <img src="<?php echo Params::urlProfilRSDirectory() . $modProfilRs->logo_rumahsakit ?> " style="max-width: 80px; width:80px;"/>
                </td>
            </tr>
        </table>
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
                <td width="35%" style="vertical-align:top; text-align: center"> PIHAK KEDUA<br> </td>
                <td width="30%"> </td>
                <td width="35%" style="vertical-align:top; text-align: center"> PIHAK KESATU<br> </td>
            </tr>
            <tr>
                <td width="35%" style="vertical-align:top; text-align: center"> <?php echo $sup->supplier_nama ?></td> 
                <td width="30%"> </td>
                <td width="35%" style="vertical-align:top; text-align: center"> PEJABAT PEMBUAT KOMITMEN</td> 
            </tr>
            <tr>
                <td width="35%"> </td>
                <td width="30%"> </td>
                <td width="35%" height="80px"> </td>
            </tr>
            <tr>
                <td width="35%" style="vertical-align:top; text-align: center; text-decoration: underline"> <?php echo $sup->direktursupplier ?></td>
                <td width="30%"> </td>
                <td width="35%" style="vertical-align:top; text-align: center; text-decoration: underline"> <?php echo!empty($modPengadaan->rencanaumumpengadaan_id) ? $modPengadaan->rencanaumumpengadaan->pegawaippk->namaLengkap : '' ?></td>
            </tr>
            <tr>
                <td width="35%" style="vertical-align:top; text-align: center;"> Direktur</td>
                <td width="30%"> </td>
                <td width="35%" style="vertical-align:top; text-align: center"> 
                    <?php // echo!empty($modPengadaan->rencanaumumpengadaan_id) ? $modPengadaan->rencanaumumpengadaan->pegawaippk->jabatan->jabatan_nama : '' ?> 
                    <?php echo!empty($modPengadaan->rencanaumumpengadaan_id) ? $modPengadaan->rencanaumumpengadaan->pegawaippk->pangkat->pangkat_nama : '';  ?> </td>
            </tr>
            <tr>
                <td width="35%"> </td>
                <td width="30%"> </td>
                <td width="35%" style="vertical-align:top; text-align: center"> NIP. <?php echo!empty($modPengadaan->rencanaumumpengadaan_id) ? $modPengadaan->rencanaumumpengadaan->pegawaippk->nomorindukpegawai : '' ?></td>
            </tr>
        </table>
        <br>
        <br>
        <table width="100%">
            <tr>
                <td style="vertical-align:top; text-align: center"> Mengetahui :<br> </td>
            </tr>
            <tr>
                <td style="vertical-align:top; text-align: center">KUASA PENGGUNA ANGGARAN<br> </td>
            </tr>
            <tr>
                <td height="80px"> </td>
            </tr>
            <tr>
                <td style="vertical-align:top; text-align: center; text-decoration: underline"> <?php echo!empty($modPengadaan->rencanaumumpengadaan_id) ? $modPengadaan->rencanaumumpengadaan->pegawaikpa->namaLengkap : '' ?></td>
            </tr>
            <tr>
                <td width="35%" style="vertical-align:top; text-align: center"> 
                    <?php // echo!empty($modPengadaan->rencanaumumpengadaan_id) ? $modPengadaan->rencanaumumpengadaan->pegawaikpa->jabatan->jabatan_nama : '' ?> 
                    <?php echo!empty($modPengadaan->rencanaumumpengadaan_id) ? $modPengadaan->rencanaumumpengadaan->pegawaikpa->pangkat->pangkat_nama : '';  ?>
                </td>
            </tr>
            <tr>
                <td width="35%" style="vertical-align:top; text-align: center"> <?php echo!empty($modPengadaan->rencanaumumpengadaan_id) ? $modPengadaan->rencanaumumpengadaan->pegawaikpa->nomorindukpegawai : '' ?></td>
            </tr>
        </table>
    </div>
</div>

<div class="page-break"></div>

<div class="container">
    <div class="row-fluid">
        <?php 
            $tanggal = date('d', strtotime($modSPK->tglsuratperjanjian));
            $bulan = MyFormatter::getMonthId(date('m', strtotime($modSPK->tglsuratperjanjian)));
            $tahun = date('Y', strtotime($modSPK->tglsuratperjanjian));
        ?>
        <table width="60%">
            <tr>
                <td width="15%"> Lampiran SPK No  </td>
                <td width="45%"> : <?php echo $modSPK->nomor_dokumen; ?></td>
            </tr>
            <tr>
                <td width="15%"> Tanggal  </td>
                <td width="45%"> : <?php echo $tanggal." ".$bulan." ".$tahun ?></td>
            </tr>
            <tr>
                <td width="15%"> Paket Pekerjaan  </td>
                <td width="45%"> : <?php echo $modSPK->namapekerjaan; ?></td>
            </tr>
        </table>
        <br>
        <br>

        <table width="100%" border="1">
            <thead>
                <tr>
                    <th> No. </th>
                    <th> Nama Barang </th>
                    <th> Satuan </th>
                    <th> Jumlah Barang</th>
                    <th> Harga Satuan (Rp.)</th>
                    <th> Jumlah Harga (Rp.)</th>
                </tr>
            </thead>
            <?php if(!empty($modRincianSPK)) :?>
                <?php foreach ($modRincianSPK as $i => $mod) :?>
            <tbody>
                <tr> 
                    <td style="text-align: center"> <?php echo $i+1; ?> </td>
                    <td style="text-align: left"> <?php echo strtoupper($mod->barang_nama) ?> </td>
                    <td style="text-align: center"> <?php echo strtoupper($mod->barang_satuan) ?> </td>
                    <td style="text-align: center"> <?php echo $mod->barang_jumlah ?> </td>
                    <td style="text-align: right"> <?php echo MyFormatter::formatNumberForPrint($mod->barang_harga, 2) ?> </td>
                    <td style="text-align: right"> <?php echo MyFormatter::formatNumberForPrint($mod->barang_total, 2) ?> </td>
                </tr>
            </tbody>
                <?php endforeach;?>
            <?php endif;?>
            <tfoot>
                <tr>
                    <td rowspan="3"></td>
                    <td> Jumlah </td>
                    <td colspan="3" style="border-bottom: none"></td>
                    <td style="text-align: right"> <?php echo MyFormatter::formatNumberForPrint($modSPK->jumlah_harga, 2); ?> </td>
                </tr>
                <tr>
                    <td> PPN 10% </td>
                    <td colspan="3"></td>
                    <td style="text-align: right"> <?php echo MyFormatter::formatNumberForPrint($modSPK->jumlah_pajak, 2); ?> </td>
                </tr>
                <tr>
                    <td> Total : </td>
                    <td colspan="3"></td>
                    <td style="text-align: right"> <?php echo MyFormatter::formatNumberForPrint($modSPK->jumlah_harga + $modSPK->jumlah_pajak, 2); ?></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>