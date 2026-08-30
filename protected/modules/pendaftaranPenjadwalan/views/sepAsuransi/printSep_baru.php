<?php $data = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); ?>
<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Arial">

<style>     
    .barcode-label{
        margin-top:-20px;
        z-index: 1;
        text-align: center;
        letter-spacing: 10px;
    }
    td{
        font-size: 11pt !important;
    }
    body{
        width: 21.7cm;          

    }

    td.header
    {
        padding-left:30px;
    }

    td
    {
        font-size: 9pt !important;
        vertical-align: top;
    }

    .qr_data img {
        max-width: none;
        width: 100px;
        padding-left: 10px;
    }
</style>
<table width="100%" border = "0" style = "text-align:left;">
    <thead>
    <th width = "25%"><img src="<?php echo Yii::app()->getBaseUrl('webroot') . '/images/logo_bpjs.png'; ?>" width="200px"></th>
    <th style="font-weight:bold; text-align: left;"><span style="font-size:17px;"><?php echo $judul_print; ?><br><?php echo $data->nama_rumahsakit; //." (".Yii::app()->user->getState('ppkpelayanan').")"; ?></span></th>        
    <!--th align='right' width="25%" style="font-weight:bold;"><span style="font-size:17px;"><?php // echo $modAsuransiPasienBpjs->jenispeserta_bpjs; ?></span></th-->        
   <!--<th  style = "padding: 0;"><!--<img src="<?php //echo Params::urlProfilRSDirectory().$data->logo_rumahsakit   ?>" width="120px"></th>-->
</thead>
</table>
<table width="100%" border = "0" style = "text-align:left;">
<tbody>
<tr>
    <td width="45%">
        <table border = "0"  style = "text-align:left;">
            <tr>
                <td width="150">No. SEP</td>
                <td width="10">:</td>
                <td><b><?php echo $modSep->nosep; ?></b></td>
            </tr>
            <tr>
                <td>Tgl. SEP</td>
                <td>:</td>
                <td><?php echo date('d/m/Y', strtotime($modSep->tglsep)); ?></td>
            </tr>
            <tr>
                <td>No. Kartu</td>
                <td>:</td>
                <td><?php echo $modSep->nokartuasuransi; ?> / <b>RM : <?php echo $modPasien->no_rekam_medik; ?></b></td>
            </tr>
            <tr>
                <td>Nama Peserta</td>
                <td>:</td>
                <td><?php echo $modAsuransiPasienBpjs->namapemilikasuransi; ?></td>
            </tr>
            <tr>
                <td>Tgl. Lahir</td>
                <td>:</td>
                <td><?php echo date('d/m/Y', strtotime($modPasien->tanggal_lahir)); ?> </td>
            </tr>
            <tr>
                <td>Kelamin</td>
                <td>:</td>
                <td><?php echo ucfirst(strtolower($modPasien->jeniskelamin)); ?></td>
            </tr>
            <tr>
                <td>No. Telepon</td>
                <td>:</td>
                <td><?php echo $modSep->no_telpon_peserta; ?></td>
            </tr>
            <tr>
                <td>Sub/Spesialis</td>
                <td>:</td>
                <td><?php echo $modPendaftaran->ruangan->ruangan_nama;   ?></td>
            </tr>
            <tr>
                <td>DPJP Yang Melayani</td>
                <td>:</td>
                <td><?php 
                if ($modSep->jnspelayanan == 1) {
                    echo $modSep->nama_dpjp; 

                } else if ($modSep->jnspelayanan == 2) {
                    echo $modSep->dpjpygmelayani_nama;
                }
                
                ?></td>
            </tr>
            <tr>
                <td>Faskes Perujuk</td>
                <td>:</td>
                <td>
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
            </tr>
            <tr>
                <td>Diagnosa Awal</td>
                <td>:</td>
                <td style="text-align:justify;font-size: 8pt !important;"><?php echo $modSep->diagnosaawal ." ". $modSep->nama_diagnosaawal; ?></td>
            </tr>
            <tr>
                <td>Catatan</td>
                <td>:</td>
                <td><?php echo $modSep->catatansep; ?></td>
            </tr>
        </table>
    </td>
    <td>
    <table border = "0"  style = "text-align:left;">
        <tr>
            <td width="150">Peserta</td>
            <td width="10">:</td>
            <td><?php echo isset($modAsuransiPasienBpjs->jenispeserta_bpjs) ? $modAsuransiPasienBpjs->jenispeserta_bpjs : '-'; ?></td>
        </tr>
        <tr>
            
            <td>COB</td>
            <td>:</td>
            <td><?php echo ($modSep->cob == 0) ? "-" : $modSep->no_asuransi_cob . "-" . $modSep->namaasuransi_cob; ?></td>
        </tr>
        <tr>
            
            <td>Prolanis PRB</td>
            <td>:</td>
            <td><?php echo empty($modAsuransiPasienBpjs->bpjs_prolanisprb) ? "-" : $modAsuransiPasienBpjs->bpjs_prolanisprb; ?></td>
        </tr>
        <tr>
            
            <td>Jns. Rawat</td>
            <td>:</td>
            <td><?php echo ($modSep->jnspelayanan == 2) ? "R. Jalan" : "R. Inap"; ?></td>


        </tr>
        <tr>
            <td>Jns. Kunjungan</td>
            <td>:</td>
            <td><?php 
            $datJenis = LookupM::model()->findByAttributes(array(
                'lookup_value'=>$modSep->jenis_kunjungan,
                'lookup_type'=>'bpjs_jnskunjungan',
            ));

            if (!empty($datJenis)) {
                echo $datJenis->lookup_name;
            } else {
                "-";
            }

            $kunjungan = "";
            if ($modSep->politujuan == "IGD") {
                $kunjungan = "Kunjungan Pertama";
            } else {
                $sepDat = SepT::model()->countByAttributes(array(
                    'norujukan'=>$modSep->norujukan,
                ));

                if ($sepDat > 1) {
                    $kunjungan = "Kunjungan Ke-".$sepDat;
                } else {
                    $kunjungan = "Kunjungan Pertama";
                }
            }
            if (!empty($kunjungan)) {
                echo " (".$kunjungan.")";
            }
            
            ?></td>



            
        </tr>
        <tr>
            

            <td>Poli Perujuk</td>
            <td>: </td>
            <td><?php echo $modSep->polirujukan; ?></td>

            
        </tr>
        <tr>
            
            <td>Kls. Hak</td>
            <td>:</td>
            <td><?php

            $kelas = KelaspelayananM::model()->findByAttributes(array(
                'kelasbpjs_id' => $modSep->klsrawat,
            ));

            $kelasLayanan = KelaspelayananM::model()->findByPk($modPendaftaran->kelaspelayanan_id);

            $is_naik = true;
            if (empty($kelasLayanan->kelasbpjs_id)) {
                // echo $kelasLayanan->kelaspelayanan_nama;
            } else if ($kelasLayanan->kelasbpjs_id > $kelas->kelasbpjs_id) {
                // echo $kelasLayanan->kelaspelayanan_nama;
            } else {
                // echo $kelas->kelaspelayanan_nama;
                $is_naik = false;
            }
            echo (($modSep->jnspelayanan == 2)? ("Kelas ".$kelas->kelasbpjs_id) : (!empty($kelasTanggunan)? ("Kelas ".$kelasTanggunan->kelasbpjs_id) : ""));
                ?></td>


           
    <!--        <td colspan="3" rowspan="3"><div>
                    <img src="index.php?r=barcode/myBarcodeSep&code=<?php echo $modSep->nosep; ?>&is_text=" style="transform:scale(1.0)">
                </div></td>-->
            
<!--        <td></td>
    <td></td>-->
        </tr>
        <tr>
            
            <td>Kls. Rawat</td>
            <td>:</td>
            <td><?php
                echo !$is_naik ? "-" : $kelas->kelaspelayanan_nama;
            ?></td>

            
        </tr>
        <tr>
            
            <td>Penjamin</td>
            <td>:</td>
            <td><?php $modSep->penjamin_lakalantas; ?></td>
        </tr>
        <tr>
            
            <td>&nbsp;</td> 
        </tr>
        <tr>
            
            <td></td>
        </tr>
        </table>
    </td>
    <td width="150" class="qr_data">
    <?php
    
                    $this->widget('ext.qrcode.QRCodeGenerator', array(
                        'data' => $modSep->nosep,
                        'subfolderVar' => false,
                        'displayImage' => true, // default to true, if set to false display a URL path
                        'errorCorrectionLevel' => 'L', // available parameter is L,M,Q,H
                        'matrixPointSize' => 10, // 1 to 10 only
                    ))
                    
            ?>
    </td>
</tr>
<tr>
<td colspan="3">
    <table border = "0"  style = "text-align:left; width:100%;">
        <tr>
            <td colspan="3" style="font-size: 7pt !important;">*Saya Menyetujui BPJS Kesehatan menggunakan informasi Medis Pasien jika diperlukan<br>*SEP bukan sebagai bukti penjaminan peserta</td>
            <td></td>
            <td colspan="3" align="center" style="font-size: 8pt !important;">Pasien/Keluarga Pasien</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
<?php 

// if (empty($modSep->print_ke)) {
//    $modSep->print_ke = 0;
// }

// $modSep->print_ke++;
// $modSep->save();


?>
        <tr>
            <td colspan="3" style="font-size: 8pt !important;">Cetakan Ke-<?php echo $modSep->print_ke; ?> (<?php echo date('d/m/Y H:i:s'); ?>) SIMARS INNOVA eHospital / <?php echo $_SERVER['REMOTE_ADDR']; ?></td>
            <td></td>
            <td colspan="3" align="center">_____________</td>
        </tr>
    </table>
</td>
</tr>
</tbody>
</table>




<!--
<p>&nbsp;</p>
<table width="100%" border = "1">
    <tr>
        <td colspan ="2"  style = "padding:0px;"><img src="<?php // echo Yii::app()->getBaseUrl('webroot').'/images/BPJS.jpg';   ?>" width="300px" style = "height:50px;"></td>
        <td colspan = "4" align='center' style="font-weight:bold;padding:0px;"><?php //echo $judul_print;   ?><br><?php echo $data->nama_rumahsakit; ?></td>        
        <td  style = "padding:0px;"><img src="<?php //echo Params::urlProfilRSDirectory().$data->logo_rumahsakit   ?>" width="120px"></td>
    </tr>    
    <tr>        
        <td width="1%" >No. SEP</td>
        <td width="2%">:</td>
        <td width="25%"><?php //echo $modSep->nosep;   ?></td>
        <td width="5%"></td>
        <td width="18%">No. D.M.K.</td>
        <td width="2%">:</td>
        <td width="30%"><?php //echo $modPasien->no_rekam_medik;   ?></td>
    </tr>
    <tr>
        <td>Tgl. SEP</td>
        <td>:</td>
        <td><?php //echo $modSep->tglsep;   ?></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td>No. Kartu</td>
        <td>:</td>
        <td><?php //echo $modSep->nokartuasuransi;   ?></td>
        <td></td>
        <td>Peserta</td>
        <td>:</td>
        <td><?php //echo isset($modJenisPeserta->jenispeserta_nama)?$modJenisPeserta->jenispeserta_nama:'-';  ?></td>
    </tr>
    <tr>
        <td>Nama Peserta</td>
        <td>:</td>
        <td><?php //echo $modAsuransiPasienBpjs->namapemilikasuransi;  ?></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td>Tgl. Lahir</td>
        <td>:</td>
        <td><?php //echo $modPasien->tanggal_lahir;   ?></td>
        <td></td>
        <td>COB</td>
        <td>:</td>
        <td></td>
    </tr>
    <tr>
        <td>Jenis Kelamin</td>
        <td>:</td>
        <td><?php //echo $modPasien->jeniskelamin;   ?></td>
        <td></td>
        <td>Jenis Rawat</td>
        <td>:</td>
        <td><?php //echo LookupM::model()->findByAttributes(array('lookup_type'=>'jenispelayanan','lookup_value'=>$modSep->jnspelayanan))->lookup_name;   ?></td>
    </tr>
    <tr>
        <td>Poli Tujuan</td>
        <td>:</td>
        <td><?php // echo $modPendaftaran->ruangan->ruangan_nama;   ?></td>
        <td></td>
        <td>Kelas Rawat</td>
        <td>:</td>
        <td><?php //echo $modAsuransiPasienBpjs->kelastanggunganasuransi->kelasbpjs_id;   ?></td>
    </tr>
    <tr>
        <td width="18%">Asal Faskes Tk.I</td>
        <td width="2%">:</td>
        <td width="25%"><?php //echo "-";   ?></td>
        <td width="5%"></td>
        <td width="18%"></td>
        <td width="2%"></td>
        <td width="30%"></td>
    </tr>
    <tr>
        <td>Diagnosa Awal</td>
        <td>:</td>
        <td><?php //echo $modSep->diagnosaawal;   ?></td>
        <td></td>
        <td>Pasien/<br>Keluarga Pasien</td>
        <td></td>
        <td>Petugas<br>Bpjs Kesehatan</td>
    </tr>
    <tr>
        <td>Catatan</td>
        <td>:</td>
        <td><?php //echo $modSep->catatansep;   ?></td>
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
        <td ><img src="<?php //echo Params::urlProfilRSDirectory().$data->logo_rumahsakit   ?>" width="120"></td>
    </tr>

</table>-->
