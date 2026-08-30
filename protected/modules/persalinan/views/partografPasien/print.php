<?php

$pasien = $pendaftaran->pasien;

?>

<style>
    body {
        font-size: 10px;
    }
</style>
<div style="text-align: right">RM.RI.09.a</div>
<h3 style="text-align: center;">PARTOGRAF</h3>
<table width="100%">
    <tr>
        <td>No. RM</td>
        <td>: <?php echo $pasien->no_rekam_medik?> </td>
        <td>Nama Ibu</td>
        <td>: <?php echo $pasien->namadepan.$pasien->nama_pasien?> </td>
        <td>Tanggal Lahir</td>
        <td>: <?php echo MyFormatter::formatDateTimeForUser($pasien->tanggal_lahir); ?> </td>
        <td>
            G : <?php echo empty($partograf->gravida) ? "-" : $partograf->gravida ?>
            P : <?php echo empty($partograf->para) ? "-" : $partograf->para ?>
            A : <?php echo empty($partograf->abortus) ? "-" : $partograf->abortus ?>
            H : <?php echo empty($partograf->jml_anakhidup) ? "-" : $partograf->jml_anakhidup ?>
        </td>
        <td rowspan="3" width="100">
            <?php 
            $profil=ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); 
            //if(!empty($profil->logo_rumahsakit) && file_exists(Params::pathProfilRSDirectory().$profil->logo_rumahsakit)){ ?>
                 
                 <img src="<?php echo Params::urlProfilRSPDFPath().$profil->logo_rumahsakit ?> " style="float:left; max-width: 60px; width:60px;" class='image_report'/>
             <?php //} ?>
        </td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td>Tanggal</td>
        <td>: <?php echo MyFormatter::formatDateTimeForUser($partograf->tglawal_pelayanan); ?></td>
        <td>Jam</td>
        <td>: <?php echo $partograf->jamawal_pelayanan; ?></td>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td>Ketubah Pecah Sejak Jam</td>
        <td>: <?php echo date('H:i:s', strtotime($partograf->ketubahpecahsejak_jam)); ?></td>
        <td>Mules Sejak Jam</td>
        <td>: <?php echo date('H:i:s', strtotime($partograf->mulessejak_jam)); ?></td>
        <td></td>
    </tr>
</table>



<?php echo $this->renderPartial($this->path_view."grafik/_kesejahteraanJanin", array(
    'partograf'=>$partograf
)); ?>

<?php echo $this->renderPartial($this->path_view."grafik/_kemajuanPersalinan", array(
    'partograf'=>$partograf, 'kontraksi'=>$kontraksi, 'jalanlahir'=>$jalanlahir
)); ?>


<?php echo $this->renderPartial($this->path_view."grafik/_kesejahteraanIbu", array(
    'model'=>$modelIbu, 'pendaftaran_id'=>$partograf->pendaftaran_id, 'partograf'=>$partograf,
), true); ?>
