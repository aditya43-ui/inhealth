<?php
    $print = !empty($print)?$print:0;
    $profil = ProfilrumahsakitM::model()->find();
    $namars = !empty($profil)?$profil->nama_rumahsakit:'';
    
    $custom = new CustomFunction;
    foreach($surat as $d){

    } 
?>
<?php 
if (!empty($modPendaftaran)) {
    $nomor_pendaftaran = $modPendaftaran->no_pendaftaran;
    $nama_pasien = $modPendaftaran->pasien->nama_pasien;
    $umur = $modPendaftaran->umur;
    $alamat = $modPendaftaran->pasien->alamat_pasien;

} else if (!empty($modPenjualan->pasienpegawai_id)) {
    $pegpas = PegawaiM::model()->findByPk($modPenjualan->pasienpegawai_id);
    if (!empty($pegpas)) {
        $nomor_pendaftaran = "-";
        $nama_pasien = $pegpas->namaLengkap;
        $alamat = $pegpas->alamat_pegawai;
        $umur = CustomFunction::hitungUmur($pegpas->tgl_lahirpegawai, $modPenjualan->tglpenjualan);
    } else {
        $nomor_pendaftaran = "-";
        $nama_pasien = "-";
        $umur = "-";
        $alamat = "-";
    }
} else {
    $nomor_pendaftaran = "-";
    $nama_pasien = "-";
    $umur = "-";
    $alamat = "-";

}

$modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); 
// echo '<pre>';
// var_dump($modProfilRs);die;?>
<style>
     .font td{
        font-weight:bold;
        font-size:15px;
        font-style:"Arial narrow";
    }
    @page { 
        size: potrait;
        font-style:"Arial Narrow", Arial, sans-serif;
        size: A4;
        margin: 0;
    }
    .font2 tr th{
        font-style:"Arial narrow";
    }
</style>	 
<table width="100%">
    <tbody>
        <tr>
            <td></td>
            <td align="right" width="50%"><font color="black" face="Liberation Serif">RM 26.21</font> </td>
        </tr>
    </tbody>
</table>
<table width="100%">
    <tbody>
        <tr>
            <td width="100" valign="MIDDLE" align="left" rowspan="2">
                 <img src="<?php echo Params::urlProfilRSDirectory().$modProfilRs->logo_rumahsakit_2?> " style="max-width: 80px; width:80px;"/>
            </td>
            <td valign="MIDDLE" align="left" colspan=" 9">
                <br>
                <!-- <b><font size="5" color="black" face="Liberation Serif">INSTALASI FARMASI APOTEK</font></b><br> -->
                <b><font size="4" color="black" face="Liberation Serif"><b><?php echo strtoupper($modProfilRs->nama_rumahsakit); ?></b></font></b><br>
                <font color="black" face="Liberation Serif"><?php echo $modProfilRs->alamatlokasi_rumahsakit; ?></font><br>
                <font color="black" face="Liberation Serif">Telp. <?php echo $modProfilRs->no_telp_profilrs; ?> Fax.  / <?php echo $modProfilRs->no_faksimili." - ".$modProfilRs->kabupaten->kabupaten_nama; ?></font>
            </td>
            <td align="LEFT" colspan="7" style="height: 20px; border-top:1px solid;border-right:1px solid; border-left:1px solid;border-bottom:1px solid;">
                <br>
                <font size="3" color="black" face="Liberation Serif">No RM : <?php echo $modPendaftaran->pasien->no_rekam_medik;?></font><br>
                <font size="3" color="black" face="Liberation Serif">Nama Pasien : <?php echo $nama_pasien;?> <?php if($modPendaftaran->pasien->jeniskelamin == "Laki-Laki"){
                    echo "(L)";
                }else{
                    echo "(P)";
                } ?></font><br>
                <font size="3" color="black" face="Liberation Serif">Tgl. Lahir/Umur  : <?php echo MyFormatter::formatDateTimeForUser($modPendaftaran->pasien->tanggal_lahir)." / ". $modPendaftaran->umur;?></font><br>
                <font size="3" color="black" face="Liberation Serif">NIK : <?php echo ($modPendaftaran->pasien->no_identitas_pasien == null) ? $modPendaftaran->pasien->no_identitas_pasien : "-";?></font>
            </td>
        </tr>
        
    </tbody>
</table>
<table class="w-100 prinout no-grid" style="text-align: center;"  width='100%'>
    <tr>
        <th align="center" style="text-align:center;"><b>FORMULIR PERMINTAAN PELAYANAN KEROHANIAN</b></th>
    </tr>       
</table>
<br/>

<table class="w-100 prinout no-grid">
    <tr>
        <td width='10'>1.</td>
        <td>KEBUTUHAN ROHANI YANG DIMINTA PASIEN</td>
    </tr> 
    <tr>
        <td>&nbsp;</td>
        <td>
            <?php echo !empty($d->kebutuhanprivasi) ? $d->kebutuhanprivasi : '<textarea rows="5" cols="200"></textarea>';?>
        </td>
    </tr>
    <tr>
        <td width='10'>2.</td>
        <td>PERMINTAAN KHUSUS PELANGAN KEROHANIAN</td>
    </tr> 
    <tr>
        <td>&nbsp;</td>
        <td>
            <?= 
                empty($d)?'<input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">': $custom->set_pilihan_ceklis($d->kebutuhanrohani)  
            ?><label for='permintaan_terapidzikir'> Ruqyah Syari'ah</label>
        </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>
            <?= 
                empty($d)? '<input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">': $custom->set_pilihan_ceklis($d->permintaan_terapidzikir)  
            ?> <label for='permintaan_terapidzikir'>Terapi dzikir</label>
        </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>
            <?= 
                empty($d)? '<input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">': $custom->set_pilihan_ceklis($d->permintaan_terapitahajud)  
            ?> <label for='permintaan_terapitahajud'>Terapi sholat tahajud</label>
        </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>
            <?= 
                empty($d)? '<input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">': $custom->set_pilihan_ceklis($d->permintaan_talqin)  
            ?> <label for='permintaan_talqin'>Talqin</label>
        </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>
            <?= 
                empty($d)? '<input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">': $custom->set_pilihan_ceklis($d->permintaan_konsulkeagamaan)  
            ?> <label for='permintaan_konsulkeagamaan'>Konsultasi keagamaan pasien/keluarga/karyawan</label>
        </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>
            <?= 
                empty($d)? '<input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">': $custom->set_pilihan_ceklis($d->permintaan_pendampingannonmus)  
            ?> <label for='permintaan_pendampingannonmus'>Pendampingan rohani non muslim</label>
        </td>
    </tr>
    <tr>
        <td width='10'>3.</td>
        <td>PERMINTAAN PELAYANAN JENAZAH</td>
    </tr> 
    <tr>
        <td>&nbsp;</td>
        <td>
            <?= 
                 empty($d)? '<input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">': $custom->set_pilihan_ceklis($d->permintaan_pemulasaran)  
            ?> <label for='permintaan_pemulasaran'>Pemulasaran, pemandian dan pengkafanan</label>
        </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>
            <?= 
                 empty($d)? '<input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">': $custom->set_pilihan_ceklis($d->permintaan_pengantaran)  
            ?> <label for='permintaan_pengantaran'>Pengantaran jenazah</label>
        </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>
            <?= 
                 empty($d)? '<input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">': $custom->set_pilihan_ceklis($d->permintaan_pengawetan)  
            ?> <label for='permintaan_pengawetan'>Pengawetan jenazah</label>
        </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>
            <?= 
                 empty($d)? '<input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">': $custom->set_pilihan_ceklis($d->permintaan_mensholatkan)  
            ?> <label for='permintaan_mensholatkan'>Mensholatkan jenazah</label>
        </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>
            <?= 
                 empty($d)? '<input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">': $custom->set_pilihan_ceklis($d->permintaan_lainnya)  
            ?> <label for='permintaan_lainnya'>Lainnya ...</label>
        </td>
    </tr>
</table>

<br/>

<table class="w-100 prinout no-grid" style="text-align: center;" width="100%">
    <tr>
        <td width="10">&nbsp;</td>        
        <td>&nbsp;</td>
        <td><?= $profil->kabupaten->kabupaten_nama.', '.MyFormatter::formatDateTimeForUser($modPendaftaran->tgl_pendaftaran) ?></td>
        <td width="10">&nbsp;</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>Pemohon</td>
        <td>Mengetahui,</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>(<?= $modPendaftaran->pasien->nama_pasien ?>)</td>
        <td>(<?= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' ?>)</td>
        <td>&nbsp;</td>
    </tr>    
    <tr>
        <td>&nbsp;</td>
        <td>Nama & Tandatangan</td>
        <td>Nama & Tandatangan</td>
        <td>&nbsp;</td>
    </tr> 
</table>

<br/>
<br/>
<br/>
<b><i>HPK 1.1 Akreditasi SNARS Edisi 1.1</i></b>
<br/>
<b><i>SPBK 2 / Sertifikasi Syariah 1441 N</i></b>












