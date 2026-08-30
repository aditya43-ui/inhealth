<?php

if (count((array)$modAnamnesa) > 0) : ?>

<table width="100%" border="1">
    <tr>
        <td style="width:20%">SMF</td>
        <td style="width:30%"><?php echo $modPendaftaran->jeniskasuspenyakit->jeniskasuspenyakit_nama;  ?></td>
        <td style="width:20%">NO. Rekam Medik</td>
        <td style="width:30%"><?php echo $modPasien->no_rekam_medik; ?></td>
    </tr>
    <tr>
        <td style="width:20%">Nama</td>
        <td style="width:30%"><?php echo $modPasien->nama_pasien; ?></td>
        <td style="width:20%">Tgl. Lahir / UMUR</td>
        <td style="width:30%"><?php echo MyFormatter::formatDateTimeId($modPasien->tanggal_lahir); ?> / <?php echo CustomFunction::hitungUmur($modPasien->tanggal_lahir); ?></td>
    </tr>
    <tr>
        <td style="width:20%">Jenis Kelamin</td>
        <td style="width:30%"><?php echo $modPasien->jeniskelamin; ?></td>
        <td style="width:20%">No. Pendaftaran</td>
        <td style="width:30%"><?php echo $modPendaftaran->no_pendaftaran; ?></td>
    </tr>
</table>

<?php 
    echo $this->renderPartial($this->path_view_pencarian . 'rawatjalan._anamnesa', array(
        'format' => $format,
        'modPendaftaran' => $modPendaftaran,
        'judul_print' => $judul_print,
        'modPasien' => $modPasien,
        'modAnamnesa' => $modAnamnesa,
    ), true);
endif; 

echo "<br>";

foreach ($modPemeriksaanFisiks as $modPemeriksaanFisik) {

$modPemeriksaanGambar = RIPemeriksaangambarT::model()->findAllByAttributes(array('pemeriksaanfisik_id'=>$modPemeriksaanFisik->pemeriksaanfisik_id));
        
if (empty($modPemeriksaanFisik)) {
    $modPemeriksaanFisik = new RIPemeriksaanFisikT;
}

$modGambarTubuh = new RIGambartubuhM();
$modBagianTubuh = new RIBagiantubuhM();
$jumlah=0;
$hasil=null;
$gcs_eye=$modPemeriksaanFisik->gcs_eye;
$gcs_motorik=$modPemeriksaanFisik->gcs_motorik;
$gcs_verbal=$modPemeriksaanFisik->gcs_verbal;

$jumlah = $gcs_eye + $gcs_motorik + $gcs_verbal;
$namaGCS=GcsM::model()->find(''.$jumlah.'>=gcs_nilaimin AND '.$jumlah.'<=gcs_nilaimax AND gcs_aktif=TRUE');
if(!empty($namaGCS)){//Jika Nilai GCSnya ada
    $hasil=$namaGCS->gcs_nama;
}else{
    $hasil='Nilai GCS Tidak Ditemukan';
}



echo $this->renderPartial($this->path_view_pencarian . 'rawatinap._pemeriksaanFisikRi', array(
    'format' => $format,
    'hasil' => $hasil,
    'modPendaftaran' => $modPendaftaran,
    'judul_print' => $judul_print,
    'modPasien' => $modPasien,
    'modPemeriksaanFisik' => $modPemeriksaanFisik,
    'modPemeriksaanGambar' => $modPemeriksaanGambar,
    'modGambarTubuh' => $modGambarTubuh,
    'modBagianTubuh' => $modBagianTubuh
        ), true);

}
?>
<?php 
    
    foreach ($modReseptur as $item) {

        $modDetailResep = ResepturdetailT::model()->findAllByAttributes(array(
            'reseptur_id'=>$item->reseptur_id,
        ));

        echo $this->renderPartial($this->path_view_pencarian.'rawatinap._resepturRi',array(
            'modPendaftaran'=>$modPendaftaran,
            'judulLaporan'=>$judul_print,
            "modDetailResep"=>$modDetailResep, 
            'modReseptur'=>$item
        ),true);
    }
    ?>