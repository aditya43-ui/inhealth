<?php

$jenis = ($modSuratPersetujuan->jenissurat == Params::SURAT_PERSETUJUAN_PERSETUJUAN) ? "Persetujuan" : "Penolakan";
$jenis2 = ($modSuratPersetujuan->jenissurat == Params::SURAT_PERSETUJUAN_PERSETUJUAN) ? "menyetujui" : "menolak";

?>

<style>
	@media screen { 
        .bag {
            margin-left : 300px;
            margin-right : 300px;
        }
    }
    
    p{
        text-align: justify;
    }
    tr, td {
        padding: 7px;
    }
    table#persetujuan {
        
        text-align: center;
    }
    .garis_bawah{
        width:100%;
        border-style:solid;
        border-width: 0.01px;
        border-top:none;
    }
    
</style>
<?php $tindakan = 'anastesi';?>
<div class="bag">
    <?php if ($jenisSurat->jenissurat_nama == Params::JENISSURAT_NAMA_PERSETUJUAN_SEDASI || $jenisSurat->jenissurat_nama == Params::JENISSURAT_NAMA_PENOLAKAN_SEDASI){?>
        <h3><center><?php echo $modSuratPersetujuan->jenissurat; ?> TINDAKAN SEDASI</center></h3>
        <?php $tindakan = 'sedasi';?>
    <?php }else{?>
        <h3><center><?php echo $modSuratPersetujuan->jenissurat; ?> TINDAKAN KEDOKTERAN</center></h3>
    <?php }?>
    
    <div class="garis_bawah"></div>
<br>
<div>

</div>
<p>Yang bertandatangan dibawah ini, saya, nama, <u><?php echo $modSuratPersetujuan->nama_menyetujui; ?></u>
umur <u><?php echo $modSuratPersetujuan->umur_menyetujui; ?></u> tahun, laki-laki/perempuan,
<br>
alamat <u><?php echo $modSuratPersetujuan->alamat_menyetujui; ?></u>
<br>
Dengan ini menyatakan <?= $jenis;?> untuk dilakukannya tindakan <u><?php echo $modSuratPersetujuan->tindakanmedis; ?></u>
<br>
terhadap  <u><?php echo $modSuratPersetujuan->tindakanterhadap; ?></u> saya, Bernama 
<?=$modPasien->nama_pasien?>,umur <?php $umur = explode(" ", $modPendaftaran->umur); echo $umur[0] ?> tahun.
<br>
Saya memahami perlunya dan manfaat tindakan <?= $tindakan;?> tersebut sebagaimana telah dijelaskan seperti di atas
kepada saya, termasuk risiko dan komplikasi yang mungkin timbul, apabila tindakan tersebut dilakukan.
Saya juga menyadari bahwa oleh karena ilmu kedokteran adalah bukan ilmu pasti, maka keberhasilan anastesi
kedokteran bukanlah keniscayaan, melainkan sangat bergantung pada saat ijin Tuhan Yang Maha Esa.
<br>
<br>
<u><?= Yii::app()->user->getState('kabupaten_nama'); ?></u>, tanggal <u><?= date(' d M Y', strtotime($modSuratPersetujuan->create_time)); ?></u>, pukul <u><?= date('H:i:s', strtotime($modSuratPersetujuan->create_time));?></u>,
<br><br>Saksi,</p>

<table width="100%" id="persetujuan">
    <tr>
        <td>Dokter</td>
        <td></td>
        <td>Petugas Admisi/Perawat/Bidan</td>
        <td></td>
        <td>Pasien</td>
        <td></td>
        <td>Saksi/Keluarga</td>
    </tr>
    <tr>
        <td colspan="7"></td>
    </tr>
    <tr>
        <td colspan="7"></td>
    </tr>
    <tr>
        <td colspan="7"></td>
    </tr>
    <tr>
        <td>( <?php echo isset($modSuratPersetujuan->dokter->NamaLengkap) ?  "<u>".$modSuratPersetujuan->dokter->NamaLengkap."</u>" : ""; ?> )</td>
        <td></td>
        <td>( <?php echo isset($modSuratPersetujuan->pegawaisaksi1->NamaLengkap) ?  "<u>".$modSuratPersetujuan->pegawaisaksi1->NamaLengkap."</u>" : ""; ?> )</td>
        <td></td>
        <td>( <u><?php echo $modPasien->nama_pasien; ?></u> )</td>
        <td></td>
        <td>( <u><?php echo empty($modSuratPersetujuan->nama_saksi2) ? "-" : $modSuratPersetujuan->nama_saksi2; ?></u> )</td>
    </tr>
    
</table>
</div>