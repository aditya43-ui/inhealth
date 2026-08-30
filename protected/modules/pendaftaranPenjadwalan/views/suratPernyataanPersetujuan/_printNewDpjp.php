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
        size: landscape;
        font-style:"Arial Narrow", Arial, sans-serif;
    }
    .font2 tr th{
        font-style:"Arial narrow";
    }
</style>	 
<table width="100%">
    <tbody>
        <tr>
            <td></td>
            <td align="right" width="50%"><font color="black" face="Liberation Serif">RM 9.21</font> </td>
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
<table width="100%">
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr class="font">
        <td style="font-style:Arial Narrow;">FORMULIR DAFTAR DPJP</td>
    </tr>
</table>
<table class="font2" width="100%" border="1">
    <tr>
        <th width="14%" rowspan="2">Diagnosis</th>
        <th align="center" colspan="3">DPJP</th>
        <th align="center" colspan="3">DPJP Utama</th>
        <th width="14%" rowspan="2">Keterangan</th>
    </tr>
    <tr>
        <th width="20%">Nama</th>
        <th>Tgl Mulai</th>
        <th>Tgl Akhir</th>
        <th width="20%">Nama</th>
        <th>Tgl Mulai</th>
        <th>Tgl Akhir</th>
    </tr>
    <?php for($i= 0; $i <= 11; $i++){?>
        <tr height="40px">
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    <?php }?>
</table>