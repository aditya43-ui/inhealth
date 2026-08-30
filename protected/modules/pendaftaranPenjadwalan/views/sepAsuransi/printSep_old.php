<?php $data = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); ?>
<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Arial">

<style>
    .barcode-label {
        margin-top: -20px;
        z-index: 1;
        text-align: center;
        letter-spacing: 10px;
    }

    td {
        font-size: 11pt !important;
    }

    body {
        width: 21.7cm;

    }

    td.header {
        padding-left: 30px;
    }

    td {
        font-size: 9pt !important;
    }
</style>
<?php //echo $this->renderPartial('pendaftaranPenjadwalan.views.pendaftaranRawatJalan._headerPrintStatus'); 
?>
<table width="100%" border="0" style="text-align:left;">
    <thead>
        <th width="25%" style="padding-left:20px;"><img src="<?php echo Yii::app()->getBaseUrl('webroot') . '/images/BPJS.jpg'; ?>" width="200px"></th>
        <th align='center' style="font-weight:bold;padding-right:200px;">
            <font style="font-size:17px;"><?php echo $judul_print; ?><br><?php echo $data->nama_rumahsakit; ?></font>
        </th>
        <!-- <th  style = "padding:0px;"><!--<img src="<?php //echo Params::urlProfilRSDirectory().$data->logo_rumahsakit 
                                                        ?>" width="120px"></th>-->
    </thead>
    <tbody>
        <td colspan="4">
            <table border="0" width=100%' style="text-align:left;">
                <tr>
                    <td class="header">No. SEP</td>
                    <td>:</td>
                    <td style="padding-left:20px;">
                        <font style="font-size:17px;font-weight:bold;font-family: arial;"><?php echo $modSep->nosep; ?></font>
                    </td>
                    <td>&nbsp;</td>
                    <td>
                        <font>No. DMK</font>
                    </td>
                    <td>:</td>
                    <td><?php echo $modPasien->no_rekam_medik; ?></td>
                </tr>
                <tr>
                    <td class="header">Tgl. SEP</td>
                    <td>:</td>
                    <td style="padding-left:20px;"><?php echo date("d/m/Y", strtotime($modSep->tglsep)); ?></td>
                    <td>&nbsp;</td>
                    <td>Peserta</td>
                    <td>:</td>
                    <td><?php echo isset($modJenisPeserta->jenispeserta_nama) ? $modJenisPeserta->jenispeserta_nama : '-'; ?></td>
                </tr>
                <tr>
                    <td class="header">No. Kartu</td>
                    <td>:</td>
                    <td style="padding-left:20px;"><?php echo $modSep->nokartuasuransi; ?></td>
                    <td>&nbsp;</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td class="header">Nama Peserta</td>
                    <td>:</td>
                    <td style="padding-left:20px;"><?php echo $modAsuransiPasienBpjs->namapemilikasuransi; ?></td>
                    <td>&nbsp;</td>
                    <td>COB</td>
                    <td>:</td>
                    <td></td>
                </tr>
                <tr>
                    <td class="header">Tgl. Lahir</td>
                    <td>:</td>
                    <td style="padding-left:20px;"><?php echo date("d/m/Y", strtotime($modPasien->tanggal_lahir)); ?></td>
                    <td>&nbsp;</td>
                    <td>Jenis Rawat</td>
                    <td>:</td>
                    <td><?php
                        if ($modSep->jnspelayanan == Params::JENISPELAYANAN_RI) {
                            echo "RAWAT INAP";
                        } else {
                            echo "RAWAT JALAN";
                        }
                        ?></td>
                </tr>
                <tr>
                    <td class="header">Jenis Kelamin</td>
                    <td>:</td>
                    <td style="padding-left:20px;"><?php echo $modPasien->jeniskelamin; ?></td>
                    <td>&nbsp;</td>
                    <td>Kelas Rawat</td>
                    <td>:</td>
                    <td><?php echo $modAsuransiPasienBpjs->kelastanggunganasuransi->kelasbpjs_id; ?></td>
                </tr>
                <tr>
                    <td class="header">Poli Tujuan</td>
                    <td>:</td>
                    <td style="padding-left:20px;"><?php echo $modPendaftaran->ruangan->ruangan_nama; ?></td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td class="header">Asal Faskes Tk. I</td>
                    <td>:</td>
                    <td style="padding-left:20px;"><?php echo empty($modRujukan) ? "-" : $modRujukan->rujukandari->namaperujuk; ?></td>
                    <td>&nbsp;</td>
                    <td style="padding-left:20px" rowspan="2">Pasien/<br>Keluarga Pasien</td>
                    <td style="padding-left:20px">&nbsp;</td>
                    <td style="padding-left:20px" rowspan="2">Petugas<br>BPJS Kesehatan</td>
                </tr>
                <tr valign="top">
                    <td class="header">Diagnosa Awal</td>
                    <td>:</td>
                    <td style="padding-left:20px;"><?php
                                                    $ar = explode(" ", $modSep->diagnosaawal);
                                                    $diag = DiagnosaM::model()->findAllByAttributes(array(
                                                        'diagnosa_kode' => $ar,
                                                    ));
                                                    foreach ($diag as $item) {
                                                        echo $item->diagnosa_nama . ". ";
                                                    }
                                                    ?></td>
                    <td>&nbsp;</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td class="header">Catatan</td>
                    <td>:</td>
                    <td style="padding-left:20px;"><?php echo $modSep->catatansep; ?></td>
                    <td>&nbsp;</td>
                    <td></td>
                    <td></td>
                    <td></td>

                </tr>
                <tr>
                    <td class="header" colspan="3" style="font-size: 6pt !important;">*Saya Menyetujui BPJS Kesehatan menggunakan informasi Medis Pasien jika diperlukan<br>*SEP bukan sebagai bukti penjaminan peserta</td>
                    <td>&nbsp;</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td class="header" colspan="3" style="font-size: 6pt !important;"></td>
                    <td>&nbsp;</td>
                    <td style="padding-left:20px">
                        <div style="padding:0px;margin:0px;height:10px;width:120px;border-top: solid 2px #000;"></div>
                    </td>
                    <td></td>
                    <td style="padding-left:20px">
                        <div style="padding:0px;margin:0px;height:10px;width:120px;border-top: solid 2px #000;"></div>
                    </td>
                </tr>
            </table>
        </td>
    </tbody>
</table>

<!--
<p>&nbsp;</p>
<table width="100%" border = "1">
    <tr>
        <td colspan ="2"  style = "padding:0px;"><img src="<? php // echo Yii::app()->getBaseUrl('webroot').'/images/BPJS.jpg'; 
                                                            ?>" width="300px" style = "height:50px;"></td>
        <td colspan = "4" align='center' style="font-weight:bold;padding:0px;"><?php //echo $judul_print; 
                                                                                ?><br><?php echo $data->nama_rumahsakit; ?></td>        
        <td  style = "padding:0px;"><img src="<?php //echo Params::urlProfilRSDirectory().$data->logo_rumahsakit 
                                                ?>" width="120px"></td>
    </tr>    
    <tr>        
        <td width="1%" >No. SEP</td>
        <td width="2%">:</td>
        <td width="25%"><?php //echo $modSep->nosep; 
                        ?></td>
        <td width="5%"></td>
        <td width="18%">No. D.M.K.</td>
        <td width="2%">:</td>
        <td width="30%"><?php //echo $modPasien->no_rekam_medik; 
                        ?></td>
    </tr>
    <tr>
        <td>Tgl. SEP</td>
        <td>:</td>
        <td><?php //echo $modSep->tglsep; 
            ?></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td>No. Kartu</td>
        <td>:</td>
        <td><?php //echo $modSep->nokartuasuransi; 
            ?></td>
        <td></td>
        <td>Peserta</td>
        <td>:</td>
        <td><?php //echo isset($modJenisPeserta->jenispeserta_nama)?$modJenisPeserta->jenispeserta_nama:'-';
            ?></td>
    </tr>
    <tr>
        <td>Nama Peserta</td>
        <td>:</td>
        <td><?php //echo $modAsuransiPasienBpjs->namapemilikasuransi;
            ?></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td>Tgl. Lahir</td>
        <td>:</td>
        <td><?php //echo $modPasien->tanggal_lahir; 
            ?></td>
        <td></td>
        <td>COB</td>
        <td>:</td>
        <td></td>
    </tr>
    <tr>
        <td>Jenis Kelamin</td>
        <td>:</td>
        <td><?php //echo $modPasien->jeniskelamin; 
            ?></td>
        <td></td>
        <td>Jenis Rawat</td>
        <td>:</td>
        <td><?php //echo LookupM::model()->findByAttributes(array('lookup_type'=>'jenispelayanan','lookup_value'=>$modSep->jnspelayanan))->lookup_name; 
            ?></td>
    </tr>
    <tr>
        <td>Poli Tujuan</td>
        <td>:</td>
        <td><? php // echo $modPendaftaran->ruangan->ruangan_nama; 
            ?></td>
        <td></td>
        <td>Kelas Rawat</td>
        <td>:</td>
        <td><?php //echo $modAsuransiPasienBpjs->kelastanggunganasuransi->kelasbpjs_id; 
            ?></td>
    </tr>
    <tr>
        <td width="18%">Asal Faskes Tk.I</td>
        <td width="2%">:</td>
        <td width="25%"><?php //echo "-"; 
                        ?></td>
        <td width="5%"></td>
        <td width="18%"></td>
        <td width="2%"></td>
        <td width="30%"></td>
    </tr>
    <tr>
        <td>Diagnosa Awal</td>
        <td>:</td>
        <td><?php //echo $modSep->diagnosaawal; 
            ?></td>
        <td></td>
        <td>Pasien/<br>Keluarga Pasien</td>
        <td></td>
        <td>Petugas<br>Bpjs Kesehatan</td>
    </tr>
    <tr>
        <td>Catatan</td>
        <td>:</td>
        <td><?php //echo $modSep->catatansep; 
            ?></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td colspan="3" style="font-size: 8pt !important;">*Saya Menyetujui BPJS Kesehatan menggunakan informasi Medis Pasien jika diperlukan<br>*SEP bukan sebagai bukti penjaminan peserta</td>
        <td></td>
        <td colspan="3">______________________________________</td>
    </tr>
   <tr>
        <td colspan="3"></td>
        <td colspan="3"></td>
        <td ><img src="<?php //echo Params::urlProfilRSDirectory().$data->logo_rumahsakit 
                        ?>" width="120"></td>
    </tr>

</table>-->