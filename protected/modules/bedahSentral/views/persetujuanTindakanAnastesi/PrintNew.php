<?php

$jenis = ($model->jenissurat == Params::SURAT_PERSETUJUAN_PERSETUJUAN) ? "Persetujuan" : "Penolakan";
$jenis2 = ($model->jenissurat == Params::SURAT_PERSETUJUAN_PERSETUJUAN) ? "menyetujui" : "menolak";

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
<div class="bag">
    <h3><center><?php echo $model->jenissurat; ?> TINDAKAN ANASTESI</center></h3>
    <div class="garis_bawah"></div>
<br>
<div>

</div>
<p>Yang bertandatangan dibawah ini, saya, nama, <u><?php echo $model->namapenanggungjawab; ?></u>
umur <u><?php echo $model->umurpenanggungjawab; ?></u> tahun, <?= $model->jeniskelamin_penanggungjawab;?>,
<br>
alamat <u><?php echo $model->alamat_penanggungjawab; ?></u>
<br>
Dengan ini menyatakan <?= $jenis;?> untuk dilakukannya tindakan <u><?php echo $informasi->jenisanestesi; ?></u>
<br>
terhadap  <u><?php echo $informasi->penerimainformasi_hubungandgnpasien; ?></u> saya, Bernama 
<?=$modPasien->nama_pasien?>, umur <?php $umur = explode(" ", $modPendaftaran->umur); echo $umur[0] ?> tahun, <?= $modPasien->jeniskelamin;?>.
<br>
alamat <u><?php echo $modPasien->alamat_pasien; ?></u>
<br>
Saya memahami perlunya dan manfaat tindakan anastesi tersebut sebagaimana telah dijelaskan seperti di atas
kepada saya, termasuk risiko dan komplikasi yang mungkin timbul, apabila tindakan tersebut dilakukan.
Saya juga menyadari bahwa oleh karena ilmu kedokteran adalah bukan ilmu pasti, maka keberhasilan anastesi
kedokteran bukanlah keniscayaan, melainkan sangat bergantung pada saat ijin Tuhan Yang Maha Esa.
<br>
<br>
<u><?= Yii::app()->user->getState('kabupaten_nama'); ?></u>, tanggal <u><?= date(' d M Y', strtotime($model->create_time)); ?></u>, pukul <u><?= date('H:i:s', strtotime($model->create_time));?></u>,
<br><br>Saksi,</p>

<table width="100%" id="persetujuan">
    <tr>
        <td></td>
        <td>Yang Menyatakan,</td>
        <td></td>
        <td>Keluarga Pasien</td>
        <td></td>
        <td>Petugas Kesehatan</td>
    </tr>
    <tr>
        <td colspan="6"></td>
    </tr>
    <tr>
        <td colspan="6"></td>
    </tr>
    <tr>
        <td colspan="6"></td>
    </tr>
    <tr>
        <td></td>
        <td>( <?php echo $model->namapenanggungjawab; ?> )</td>
        <td></td>
        <td>( <?php echo $model->nama_pihakkeluarga; ?> )</td>
        <td></td>
        <td>( <?php echo empty($model->doktermenyetujui) ? "-" : $model->doktermenyetujui->namaLengkap; ?> )</td>
    </tr>
    
</table>
</div>