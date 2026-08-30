<?php
    $print = !empty($print)?$print:0;
    $profil = ProfilrumahsakitM::model()->find();
    $namars = !empty($profil)?$profil->nama_rumahsakit:'';
    $data = !empty($modPendaftaran->pasienadmisi->kamarruangan)?$modPendaftaran->pasienadmisi->kamarruangan->kamarruangan_nokamar:'-';
    $peg = PegawaiM::model()->findByPk($modPendaftaran->pegawai_id);
    $dokterpenanggungjawab = !empty($peg->namaLengkap)?$peg->namaLengkap:'';
    $modPj = PenanggungjawabM::model()->findByPk($modPendaftaran->penanggungjawab_id);
    if (!empty($modPj)){                                    
        $tandatangan_nama = $modPj->nama_pj;            
        $tandatangan_telepon = $modPj->no_teleponpj;
        $tandatangan_hubungan = $modPj->hubungankeluarga;
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
            <td align="right" width="50%"><font color="black" face="Liberation Serif">RM 8.21</font> </td>
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
                <font width size="3" color="black" face="Liberation Serif">No RM : <?php echo $modPendaftaran->pasien->no_rekam_medik;?></font><br>
                <font width size="3" color="black" face="Liberation Serif">Nama Pasien : <?php echo $nama_pasien;?> <?php if($modPendaftaran->pasien->jeniskelamin == "Laki-Laki"){
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
<table class="w-100 prinout no-grid" style="text-align: center;" width="100%">
    <tr>
        <th align="center" style="text-align:center;"><span style="font-size: 15pt"><b>PERYATAAN PERSETUJUAN MEMBUKA RAHASIA KEDOKTERAN</b></span></th>
    </tr>    
</table>
<br/>

<table class="w-100 prinout no-grid" >
    <tr>
        <td colspan="5">Saya pasien atau atau Wali pasien, yang bertanda tangan dibawah ini :</td>
    </tr>    
    <tr>
        <td colspan="2">&nbsp;</td>
        <td width="15%">Nama Pasien</td>
        <td width="1%">:</td>
        <td><?= $modPendaftaran->pasien->nama_pasien . '('.$data.')'. '&nbsp;&nbsp;&nbsp;('.$modPendaftaran->pasien->jeniskelamin.')'?></td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td colspan="2">&nbsp;</td>
        <td>Tgl Lahir</td>
        <td>:</td>
        <td><?= $modPendaftaran->pasien->tanggal_lahir.', &nbsp;&nbsp;&nbsp; Umur : '.$modPendaftaran->umur ?></td>
        <td rowspan="5"></td>
    </tr>
    <tr>
        <td colspan="2">&nbsp;</td>
        <td>Tanggal Masuk RS</td>
        <td>:</td>
        <td><?= $modPendaftaran->tgl_pendaftaran ?></td>
    </tr>
    <tr>
        <td colspan="2">&nbsp;</td>
        <td>Dokter Penanggung Jawab</td>
        <td>:</td>
        <td><?= $dokterpenanggungjawab ?></td>
    </tr>
    <tr>
        <td colspan="2">&nbsp;</td>
        <td>No Rekam Medis</td>
        <td>:</td>
        <td><?= $modPendaftaran->pasien->no_rekam_medik ?></td>
    </tr>    
    <tr>
        <td colspan="5">Menyatakan bahwa sesuai Kewajiban Simpan Rahasia Kedokteran dan mengacu pada Peraturan Menteri Kesehatan Republik Indonesia Nomor <b>269/KEMENKES/PER/III/2008</b>, saya menyetujui pemberian penjelasan yang terkait kondisi medis kepada</td>
    </tr>    
    <tr>
        <td width="1%" rowspan="5" style="vertical-align: top">&nbsp;</td>
        <td width="1%" rowspan="5" style="vertical-align: top">a.</td>
        <td>Nama</td>
        <td>:</td>
        <td><b><?= !empty($modPendaftaran->penanggungjawab->nama_pj)?$modPendaftaran->penanggungjawab->nama_pj:'<input type="text" id="fname" name="fname"><br><br>' ?></b></td>
    </tr>
    <tr>
        <td colspan="5">&nbsp;</td>
    </tr>
    <tr>
        <td>No Telp / HP</td>
        <td>:</td>
        <td><b><?= (!empty($tandatangan_telepon)?$tandatangan_telepon:'<input type="text" id="fname" name="fname"><br><br>') ?></b></td>
    </tr>
    <tr>
        <td colspan="5">&nbsp;</td>
    </tr>
    <tr>
        <td>Hubungan dengan Pasien</td>
        <td>:</td>
        <td><?= (!empty($tandatangan_hubungan)?$tandatangan_hubungan:'<input type="text" id="fname" name="fname"><br><br>') ?></td>
    </tr>
    <tr>
        <td width="10" rowspan="5" style="vertical-align: top">&nbsp;</td>
        <td width="10" rowspan="5" style="vertical-align: top">b.</td>
        <td>Nama</td>
        <td>:</td>
        <td style="border-bottom: 1px solid #333;"></td>
    </tr>
    <tr>
        <td colspan="5">&nbsp;</td>
    </tr>
    <tr>
        <td>No Telp / HP</td>
        <td>:</td>
        <td style="border-bottom: 1px solid #333;"></td>
    </tr>
    <tr>
        <td colspan="5">&nbsp;</td>
    </tr>
    <tr>
        <td>Hubungan dengan Pasien</td>
        <td>:</td>
        <td style="border-bottom: 1px solid #333;"></td>
    </tr>
    <tr>
        <td colspan="5">&nbsp;</td>
    </tr>      
    <tr>
        <td width="10" rowspan="5" style="vertical-align: top">&nbsp;</td>
        <td width="10" rowspan="5" style="vertical-align: top">c.</td>
        <td colspan="3">Penanggung Jawab biaya, jaminan, asuransi : <?= $modPendaftaran->penjamin->penjamin_nama ?></td>       
    </tr>
    <tr>
        <td colspan="5">&nbsp;</td>
    </tr>
    <tr>
        <td>Nama contact person</td>
        <td>:</td>
        <td><?= (!empty($modSurat->penanggung_jawab_biaya_nama)?$modSurat->penanggung_jawab_biaya_nama:'<input type="text" id="fname" name="fname"><br><br>') ?></td>
    </tr>
    <tr>
        <td colspan="5">&nbsp;</td>
    </tr>
    <tr>
        <td>Telp</td>
        <td>:</td>
        <td><?= (!empty($modSurat->penanggung_jawab_biaya_telepon)?$modSurat->penanggung_jawab_biaya_telepon:'<input type="text" id="fname" name="fname"><br><br>') ?></td>
    </tr>
    <tr>
        <td colspan="5">Kebutuhan Privasi yang diminta pasien selama perawatan :</td>
    </tr>
    <tr>
        <td colspan="5" height="100px">
            <?= (!empty($modSurat->privasi)?$modSurat->privasi:'<textarea rows="5" cols="200"></textarea>') ?>
        </td>
    </tr>
    <tr>
        <td colspan="5">Demikian pernyataan ini dibuat dengan penuh kesadaran dan tanpa paksaan :</td>
    </tr>
</table>

<br/>

<table class="w-100 prinout no-grid" style="text-align: center;" width="100%">
    <tr>
        <td width="10">&nbsp;</td>
        <td>&nbsp;</td>
        <td align="center"><?= $profil->propinsi->propinsi_nama.', Jam '.date('d-m-Y') ?></td>        
        <td width="10">&nbsp;</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td></td>
        <td align="center">Pembuat Pernyataan,</td>
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
        <td class="pihakpertama"></td>
        <td class="pihakkedua">(<?= $modPendaftaran->pasien->nama_pasien ?>)</td>
        <td>&nbsp;</td>
    </tr>        
    <tr>
        <td colspan="4" style="text-align: left;"><b><i>MKP 1.2 EP 2&3 / Akreditrasi SNARS edisi 1.1</i></b></td>                
    </tr>
</table>













