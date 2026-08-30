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
$identitaspasien = !empty($identitaspasien)?$identitaspasien:false;
$nodokrm = !empty($nodokrm)?$nodokrm:'';
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
        </tr>
    </tbody>
</table>