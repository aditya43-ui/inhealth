<?php $data = ProfilrumahsakitM::model()->findByPk(Params::DEFAULT_PROFIL_RUMAH_SAKIT); ?>
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
        vertical-align: top;
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
                    <td width="15%">No. SEP</td>
                    <td width="2%">:</td>
                    <td width="40%"><b><?php echo $modSep->nosep; ?></b></td>
                    <td width="5%"></td>
                    <td width="15%">Peserta</td>
                    <td width="2%">:</td>
                    <td><?php echo isset($modAsuransiPasienBpjs->jenispeserta_bpjs) ? $modAsuransiPasienBpjs->jenispeserta_bpjs : '-'; ?></td>
                </tr>
                <tr>
                    <td>Tgl. SEP</td>
                    <td>:</td>
                    <td><?php echo date('Y-m-d', strtotime($modSep->tglsep)); ?></td>
                    <td></td>
                    <td>COB</td>
                    <td>:</td>
                    <td><?php echo ($modSep->cob == 0) ? "-" : $modSep->no_asuransi_cob . "-" . $modSep->namaasuransi_cob; ?></td>
                </tr>
                <tr>
                    <td>No. Kartu</td>
                    <td>:</td>
                    <td><?php echo $modSep->nokartuasuransi; ?> ( <b>MR. <?php echo $modPasien->no_rekam_medik; ?></b> )</td>
                    <td></td>
                    <td>Jns. Rawat</td>
                    <td>:</td>
                    <td><?php echo ($modSep->jnspelayanan == 2) ? "R. Jalan" : "R. Inap"; ?></td>
                </tr>
                <tr>
                    <td>Nama Peserta</td>
                    <td>:</td>
                    <td><?php echo $modAsuransiPasienBpjs->namapemilikasuransi . " (" . substr($modPasien->jeniskelamin, 0, 1) . ")"; ?></td>
                    <td></td>
                    <td>Kls. Rawat</td>
                    <td>:</td>
                    <td><?php
                        echo ($modSep->jnspelayanan == 2) ? "-" : $modSep->klsrawat;
                        ?></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Tgl. Lahir</td>
                    <td>:</td>
                    <td><?php echo $modPasien->tanggal_lahir; ?></td>
                    <td></td>
                    <td>Penjamin</td>
                    <td>:</td>
                    <td><?php $modSep->penjaminsep_kll; ?></td>
                </tr>
                <tr>
                    <td>No. Telepon</td>
                    <td>:</td>
                    <td><?php echo $modSep->no_telpon_peserta; ?></td>
                </tr>
                <tr>
                    <td>Sub/Spesialis</td>
                    <td>:</td>
                    <td><?php echo $modSep->politujuan; //$modPendaftaran->ruangan->ruangan_nama;   
                        ?></td>
                    <td></td>
                    <!--        <td colspan="3" rowspan="3"><div>
                    <img src="index.php?r=barcode/myBarcodeSep&code=<?php echo $modSep->nosep; ?>&is_text=" style="transform:scale(1.0)">
                </div></td>-->
                    <td colspan="3" style="font-size: 8pt !important;">Pasien/Keluarga Pasien</td>
                    <!--        <td></td>
    <td></td>-->
                </tr>
                <tr>
                    <td>DPJP Yang Melayani</td>
                    <td>:</td>
                    <td><?php echo $modSep->nama_dpjp; ?></td>
                </tr>
                <tr>
                    <td width="18%">Faskes Perujuk</td>
                    <td width="2%">:</td>
                    <td width="40%">
                        <?php
                        if (empty($modAsuransiPasienBpjs->nama_feskestk1) || $modAsuransiPasienBpjs->nama_feskestk1 == "") {
                            $modPendaftaran = PendaftaranT::model()->findByAttributes(array('sep_id' => $modSep->sep_id));
                            if (!empty($modPendaftaran->rujukan_id)) {
                                $modRujukan = RujukanT::model()->findByPk($modPendaftaran->rujukan_id);
                                echo $modRujukan->nama_perujuk;
                            }
                        } else {
                            echo $modAsuransiPasienBpjs->nama_feskestk1;
                        }
                        ?>
                    </td>
                    <td></td>

                    <!--        <td width="18%"></td>
 <td width="2%"></td>
 <td width="30%"></td>-->
                </tr>
                <tr>
                    <td>Diagnosa Awal</td>
                    <td>:</td>
                    <td style="text-align:justify;font-size: 8pt !important;"><?php echo $modSep->diagnosaawal . " " . $modSep->nama_diagnosaawal; ?></td>
                    <td></td>
                    <td colspan="3">___________________</td>
                    <!--        <td></td>
    <td></td>
    <td></td>-->
                </tr>
                <tr>
                    <td>Catatan</td>
                    <td>:</td>
                    <td><?php echo $modSep->catatansep; ?></td>
                    <td></td>
                    <!--<td colspan="3" style="font-size: 11pt !important;">Pasien/Keluarga Pasien</td>-->
                    <td colspan="3"></td>
                    <!--        <td></td>
            <td></td>-->
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="3" style="font-size: 7pt !important;">*Saya Menyetujui BPJS Kesehatan menggunakan informasi Medis Pasien jika diperlukan<br>*SEP bukan sebagai bukti penjaminan peserta</td>
                    <td></td>
                    <?php /*
              <td colspan="3">
              <img src="index.php?r=barcode/myBarcodeSep&code=<?php echo $modSep->nosep; ?>&is_text=" style="transform:scale(1.3)">
              </td>
             * 
             */ ?>
                </tr>
            </table>
        </td>
    </tbody>
</table>

<!--
<p>&nbsp;</p>
<table width="100%" border = "1">
    <tr>
        <td colspan ="2"  style = "padding:0px;"><img src="<?php // echo Yii::app()->getBaseUrl('webroot').'/images/BPJS.jpg';   
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
        <td><?php // echo $modPendaftaran->ruangan->ruangan_nama;   
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