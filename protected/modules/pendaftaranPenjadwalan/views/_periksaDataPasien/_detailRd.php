
<?php echo $this->renderPartial($this->path_view_pencarian.'rawatdarurat._detailRdAsesmen',array(
            'format' => $format,
            'dataTriase' => $dataTriase,
            'modFisik' => $modFisik,
            'modAsesTriase' => $modAsesTriase,
            'modAsesTriDet' => $modAsesTriDet,
            'getTriase' => $getTriase,
            'modTriPeg' => $modTriPeg,
            'judulLaporan' => $judulLaporan,
            'modLookup' => $modLookup,
            'modPendaftaran' => $modPendaftaran,
            'modPasien' => $modPasien,
            'getFlaCcs' => $getFlaCcs,
            'dataFlaCcs' => $dataFlaCcs,
            'modFlaCcs' => $modFlaCcs,
            'modPendaftaran' => $modPendaftaran
    ),true); ?>

<?php echo $this->renderPartial($this->path_view_pencarian.'rawatdarurat._assesmenPasien',array(
            'model'=>$model,
            'modPendaftaran'=>$modPendaftaran,
            'pasien'=>$pasien,
            'masalahKeperawatan'=>$masalahKeperawatan,
    ),true); ?>


<br>
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
        'judul_print' => $judulLaporan,
        'modPasien' => $modPasien,
        'modAnamnesa' => $modAnamnesa,
    ), true);
endif; 
?>
<br>
<?php echo $this->renderPartial($this->path_view_pencarian.'rawatdarurat._pemeriksaanFisikRd',array(
            'format' => $format,
           'modPendaftaran' => $modPendaftaran,
           'judul_print' => $judulLaporan,
           'modPasien' => $modPasien,
           'modPemeriksaanFisik' => $modPemeriksaanFisik,
           'modPemeriksaanGambar' => $modPemeriksaanGambar,
           'modGambarTubuh' => $modGambarTubuh,
           'modBagianTubuh' => $modBagianTubuh
     ),true); ?>

<?php 
    
    foreach ($modReseptur as $item) {

        $modDetailResep = ResepturdetailT::model()->findAllByAttributes(array(
            'reseptur_id'=>$item->reseptur_id,
        ));

        echo $this->renderPartial($this->path_view_pencarian.'rawatdarurat._resepturRd',array(
            'modPendaftaran'=>$modPendaftaran,
            'judulLaporan'=>$judulLaporan,
            "modDetailResep"=>$modDetailResep, 
            'modReseptur'=>$item
        ),true);
    }
    ?>