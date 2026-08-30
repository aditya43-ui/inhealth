<head>
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/entypo/css/entypo.css">        
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/font-awesome/css/font-awesome.css">
</head>

<style>
    p{
        text-align: justify;
    }
    tr, td {
        padding: 7px;
    }
    table#persetujuan {
        
        text-align: center;
    }
</style>

<?php 

$modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
$modAnamnesa = AnamnesaT::model()->findByAttributes(array(
    'pendaftaran_id'=>$modPendaftaran->pendaftaran_id,
), array(
    'order'=>'anamesa_id desc',
));

if (empty($modAnamnesa)) {
    $modAnamnesa = new AnamnesaT;
}

$modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); 
$konfig = KonfigsystemK::model()->find();

$jenis = ($model->jenissurat == Params::SURAT_PERSETUJUAN_PERSETUJUAN) ? "Persetujuan" : "Penolakan";
$jenis2 = ($model->jenissurat == Params::SURAT_PERSETUJUAN_PERSETUJUAN) ? "menyetujui" : "menolak";

?>
<h3><p style="margin: 0; text-align: center;"><?php echo $model->jenissurat; ?> TINDAKAN ANASTESI</p></h3>
<br>
<p align="justify">
    Setelah mendapat informasi mengenai tindakan anatesi/sedasi, maka yang bertanda tangan di bawah ini :
</p>
<table width="100%" style="width:500px;">
<tr>
    <td>Nama</td>
    <td>:</td>
    <td> <?php echo $model->namapenanggungjawab; ?> </td>
</tr>
<tr>
    <td>Umur</td>
    <td>:</td>
    <td> <?php echo $model->umurpenanggungjawab; ?></td>
</tr>
<tr>
    <td>Jenis Kelamin</td>
    <td>:</td>
    <td> <?php echo $model->jeniskelamin_penanggungjawab; ?></td>
</tr>
<tr>
    <td>Alamat</td>
    <td>:</td>
    <td> <?php echo $model->alamat_penanggungjawab; ?></td>
</tr>
<tr>
    <td>No. Kartu Identitas</td>
    <td>:</td>
    <td> <?php echo $model->jenisidentitas_penanggungjawab; ?></td>
</tr>
<tr>
    <td></td>
    <td></td>
    <td> <?php echo $model->noidentitas_penanggungjawab; ?></td>
</tr>
</table>
<br>
<p align="justify">
   Menyatakan <?php echo $model->jenissurat; ?> untuk dilakukan tindakan anatesi berupa :
</p>
<?php
if($model->jnsanestesi_sedasiberatsedang == true){
    echo '- Sedasi sedang dan berat<br>';
}
if($model->jnsanestesi_umum == true){
    echo '- Anestesi Umum<br>';
}
if($model->jnsanestesi_kombinasi == true){
    echo '- Anestesi Kombinasi<br>';
} 
if ($model->jnsanestesi_regional_sedasi == true) {
    echo '- Anestesi Regional - Sedasi<br>';
}
if ($model->jnsanestesi_regional_tnpsedasi == true) {
    echo '- Anestesi Regional - Tanpa Sedasi<br>';
}
if ($model->jnsanestesi_regional_sab == true) {
    echo '- Anestesi Regional - SAB<br>';
}
if ($model->jnsanestesi_regional_epidural == true) {
    echo '- Anestesi Regional - Epidural<br>';
}
if ($model->jnsanestesi_regional_blokperifer == true) {
    echo '- Anestesi Regional - Block Perifer<br>';
}
if ($model->jnsanestesi_regional_kombinasi == true) {
    echo '- Anestesi Regional - Kombinasi<br>';
}
?>

<br>
<p align="justify">
   Terhadap Pasien :
</p>
<table cellpadding="10">
    <tr>
        <td>Nama</td>
        <td>:</td>
        <td><?=$modPasien->nama_pasien?></td>
    </tr>
    <tr>
        <td>Tanggal Lahir</td>
        <td>:</td>
        <td><?=$modPasien->tempat_lahir?>, <?=$format->formatDateTimeForUser($modPasien->tanggal_lahir)?></td>
    </tr>
    <tr>
        <td>No. Rekam Medis</td>
        <td>:</td>
        <td><?=$modPasien->no_rekam_medik?></td>
    </tr>
    <tr>
        <td>Diagnosis</td>
        <td>:</td>
        <td><?=$diagnosa?></td>
    </tr>
    <tr>
        <td>Tindakan</td>
        <td>:</td>
        <td><?php
        echo "<ul>";
        if (!empty($pasienkirimkeunitlain_id)) {
            $tindakan = PermintaankepenunjangT::model()->findAllByAttributes(array(
                'pasienkirimkeunitlain_id'=>$pasienkirimkeunitlain_id,
            ));
            
            foreach ($tindakan as $item) {
                if (!empty($item->operasi_id)) {
                    echo "<li>".$item->operasi->operasi_nama."</li>";
                }
            }
        } else if (!empty($pasienmasukpenunjang_id)) {
            $tindakan = RencanaoperasiT::model()->findAllByAttributes(array(
                'pasienmasukpenunjang_id'=>$pasienmasukpenunjang_id,
            ));
            
            foreach ($tindakan as $item) {
                if (!empty($item->operasi_id)) {
                    echo "<li>".$item->operasi->operasi_nama."</li>";
                }
            }
        } else if (!empty($pendaftaran_id)) {
            $kitim = PasienkirimkeunitlainT::model()->findAllByAttributes(array(
                'pendaftaran_id'=>$pendaftaran_id,
                'create_ruangan'=>Yii::app()->user->getState('ruangan_id'),
            ));
            
            foreach ($kitim as $det) {
                $tindakan = PermintaankepenunjangT::model()->findAllByAttributes(array(
                    'pasienkirimkeunitlain_id'=>$det->pasienkirimkeunitlain_id,
                ));
                
                foreach ($tindakan as $item) {
                    if (!empty($item->operasi_id)) {
                        echo "<li>".$item->operasi->operasi_nama."</li>";
                    }
                }
            }
        }
        
        echo "</ul>";
        
        ?></td>
    </tr>
</table>
<br>
<p align="justify">
   Saya menyatakan dengan sesungguhnya dan tanpa aksaan bahwa :
</p>
<p align="justify">
   1. Saya telah membaca penjelasan secara teliti tentang tindakan yang diberikan, mengerti dan menyetujui 
   penjelasan tentang tindakan yang akan dilakukan termasuk kemungkinan komplikasi yang mungkin terjadi serta 
   kelebihan atau kelemahan dari setiap jenis pilihan pembiusan yang dapat dilakukan, serta telah diberikan kesempatan 
   untuk bertanya dan berdiskusi dengan dokter
</p>
<p align="justify">
   2. Saya menyadari bahwa pelayanan di rumah sakit ini merupakan suatu kerja team (termasuk dokter dan perawat anestesi) 
   dan bahwasanya anestesi untuk tindakan operasi ini akan dilakukan di bawah pengawasan dokter 
   <u><?php echo $model->pegawai->namaLengkap; ?></u>
 </p>
<p align="justify">
    3. Saya mengerti bahwa tindakan anestesi mengandung beberapa risiko, termasuk perubahan tekanan darah, reaksi obat (alergi), 
    henti jantung, kerusakan otak, kelumpuhan, kerusakan saraf serta kompilasi lain yang juga mungkin terjadi, bahkan kematian.
</p>
<p align="justify">
    4. Saya menyadari dan mengerti bahwa ilmu kedokteran (termasuk anestesi) bukan merupakan ilmu pengetahuan yang pasti dalam praktiknya, 
    sehingga tidak ada seorang pun yang dapat menjanjikan atau menjamin sesuatu yang berhubungan dengan praktik ilmu kedokteran (termasuk anestesi).
</p>
<p align="justify">
    5. Saya mempunyai kewajiban untuk memberikan kepada dokter mengenai semua penyakit dan obat yang saya/pasien minum seperti aspirin, pengencer darah, 
    kontrasepsi, obat-obat flu, narkotika, marijuana, kokain dan lain-lain, mengingat hal-hal tersebut dapat menimbulkan kompilasi bagi anestesi maupun pembedahan.
</p>
<p align="justify">
    Berdasrkan hal-hal tersebut di atas, saya menjamin sepenuhnya bahwa tindakan saya untuk menyetujui tindakan anestesi di atas adalah untuk mewakili kepentingan saya/pasien 
    dan keluarga pasien, dan saya bertanggung jawab sepenuhnya apabila terdapat pihak lain yang mengajukan keberatan atas persetujuan ini.
</p>
<p align="justify">
    Demikian surat persetujuan ini dibuat dengan penuh kesadaran dan tanpa paksaan dari pihak manapun juga.
</p>
<table width="100%" id="persetujuan">
    <tr>
        <td></td>
        <td><?= Yii::app()->user->getState('kabupaten_nama'); ?>, <?= date(' d M Y')?></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td>Yang membuat pernyataan,</td>
        <td></td>
        <td></td>
        <td>Saksi Pihak Keluarga,</td>
    </tr>
    <tr>
        <td></td>
        <td><?php echo $model->hubungan_pembuatpernyataan; ?>
        </td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td><?php echo $model->namapenanggungjawab; ?></td>
        <td></td>
        <td></td>
        <td><?php echo $model->nama_pihakkeluarga; ?></td>
    </tr>
    <tr>
        <td style="text-align: right">No. KTP/SIM</td>
        <td><?php echo $model->noidentitas_penanggungjawab; ?></td>
        <td></td>
        <td style="text-align: right">No. KTP/SIM</td>
        <td><?php echo $model->noidentitas; ?>
            </td>
    </tr>
    <tr>
        <td></td>
        <td>Dokter,</td>
        <td></td>
        <td></td>
        <td>Saksi Pihak RS,</td>
    </tr>
    <tr>
        <td></td>
        <td>
            <?php echo $model->pegawai->namaLengkap; ?></td>
        <td></td>
        <td></td>
        <td>
            <?php echo $model->pegawaisaksi->namaLengkap; ?>
        </td>
    </tr>
</table>