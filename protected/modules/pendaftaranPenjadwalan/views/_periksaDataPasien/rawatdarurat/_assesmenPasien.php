<?php
/**
* - digunakan untuk untuk gprintout asesmen Pasien IGD
* 
* @author       Deni Hamdani <denihamdani@piindonesia.co.id>
* @website      <piindonesia.co.id>
 *@wiki         <https://piiproject.atlassian.net/wiki/display/MDO>
*/
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/themes/neon18/assets/css/custom.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/prinoutInput.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/prinout.css');

$modPasien = $modPendaftaran->pasien;

?>

<style>
    .tab_detail th, .tab_detail td {
        border: 1px solid black;
        padding: 3px;
        vertical-align: top;
    }
    
    .tab_detail th {
        text-align: center;
        font-weight: bold;
    }
    
    .row_soap hr {
        border-top: 1px solid black;
    }
    
    .tab_detail {
        width: 100%;
    }
    
    .tab_judul {
        text-align: center;
        vertical-align: middle !important   ;
    }
    
</style>

<table width="100%" border="1">
    <tr>
        <td style="width:20%">SMF</td>
        <td style="width:30%"><?php echo $modPendaftaran->jeniskasuspenyakit->jeniskasuspenyakit_nama;  ?></td>
        <td style="width:20%">No. Rekam Medik</td>
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
$ceklis = '<span class="fa fa-check-square-o"></span>';
$unceklis = '<span class="fa fa-square-o"></span>';
?>
<p style="margin: 0; text-align: center;"><h3>ASESMEN PASIEN</h3></p>
<table class="tab_detail" width="100%">
    <thead>
        <tr>
            <th colspan="3">DOKUMEN KEPERAWATAN PIE</th>
        </tr>
        <tr>
            <td>MASALAH KEPERAWATAN</td>
            <td>TINDAKAN KEPERAWATAN</td>
            <td>EVALUASI KEPERAWATAN</td>
        </tr>
    </thead>
    <tbody>
        <?php 
        $first = true;
        foreach ($masalahKeperawatan as $item) : ?>
        <tr>
            <td>
                <?php
                foreach ($item['masalah'] as $masalah) {
                    $checked = false;
                    if (!empty($model->masalah)) {
                        $checked = !empty($model->masalah[$masalah['masalahkeperawatan_id']]);
                    }

                    echo CHtml::checkbox('pie[masalah]['.$masalah['masalahkeperawatan_id'].']', $checked, array('disabled'=>true)).
                        "<label> ".$masalah['masalahkeperawatan_nama'].'</label><br>';
                }
                ?>
            </td>
            <td>
                <?php
                foreach ($item['tindakan'] as $tindakan) {
                    $checked = false;
                    if (!empty($model->tindakan)) {
                        $checked = !empty($model->tindakan[$tindakan['tindakankeperawatan_id']]);
                    }

                    echo CHtml::checkbox('pie[tindakan]['.$tindakan['tindakankeperawatan_id'].']', $checked, array('disabled'=>true)).
                        "<label> ".$tindakan['tindakankeperawatan_nama'].'</label><br>';
                }
                ?>
            </td>
            <?php if ($first): 
                $first = false;
                ?>
            <td rowspan="<?php echo count((array)$masalahKeperawatan); ?>" class="row_soap">
                <b>Subjective</b><br>
                <?php echo $model->evaluasiaskep_subjektif; ?>
                <hr>
                <b>Objective</b>
                <?php echo $model->evaluasiaskep_objektif; ?>
                <hr>
                <b>Assessment</b>
                <?php echo $model->evaluasiaskep_assessment; ?>
                <hr>
                <b>Planning</b>
                <?php echo $model->evaluasiaskep_planning; ?>
            </td>
            <?php endif; ?>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!--PEMAKAIAN OBAT-->

<?php

$terapi = AsesmenigdterapiT::model()->findAllByAttributes(array(
    'asesmenpasienigd_id'=>$model->asesmenpasienigd_id,
));

$tindakan = AsesmenigdtindakT::model()->findAllByAttributes(array(
    'asesmenpasienigd_id'=>$model->asesmenpasienigd_id,
));


?>



<table class="tab_detail" width="100%">
    <thead>
        <tr>
            <th colspan="6">PEMBERIAN OBAT</th>
        </tr>
        <tr>
            <th>Pukul</th>
            <th>Nama Obat / Infus</th>
            <th>Dosis</th>
            <th>Rute</th>
            <th>Diperiksa Oleh</th>
            <th>Diberikan Oleh</th>
        </tr>
    </thead>
    <tbody>
        <?php if (count((array)$terapi) == 0) : ?>
        <tr>
            <td colspan="6">Data Tidak ditemukan</td>
        </tr>
        <?php else : ?>
            <?php foreach ($terapi as $item) :
                $periksa = PegawaiM::model()->findByPk($item->terapi_diperiksa);
                $pemberi = PegawaiM::model()->findByPk($item->terapi_diberikan);
                ?>
                    <tr>
                        <td><?php echo MyFormatter::formatDateTimeForUser($item->asesmenigdterapi_tgl); ?></td>
                        <td><?php echo $item->obatalkes_nama; ?></td>
                        <td><?php echo $item->terapi_dosis; ?></td>
                        <td><?php echo $item->terapi_rute; ?></td>
                        <td><?php echo $periksa->namaLengkap; ?></td>
                        <td><?php echo $pemberi->namaLengkap; ?></td>
                    </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

<!--PEMAKAIAN TINDAKAN-->

<table class="tab_detail">
    <thead>
        <tr>
            <th colspan="3">PEMBERIAN TINDAKAN</th>
        </tr>
        <tr>
            <th>Pukul</th>
            <th>Uraian Tindakan</th>
            <th>Nama</th>
        </tr>
    </thead>
    <tbody>
        <?php if (count((array)$tindakan) == 0) : ?>
        <tr>
            <td colspan="3">Data Tidak ditemukan</td>
        </tr>
        <?php else : ?>
            <?php foreach ($tindakan as $item): 
                $pegawai = PegawaiM::model()->findByPk($item->tindakan_oleh);
                ?>
            <tr>
                <td><?php echo MyFormatter::formatDateTimeForUser($item->asesmenigdtindak_tgl); ?></td>
                <td><?php echo $item->tindakan_nama; ?></td>
                <td><?php echo $pegawai->namaLengkap; ?></td>
            </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

<table class="tab_detail">
    <tr>
        <td width="50%">
            <?php
            
            if (!empty($model->tindakanlanjutan)) {
                echo "Tindak Lanjutan di : ".$model->tindakanlanjutan;
            } else if (!empty($model->rujukankeluar_id)) {
                $keluar = RujukankeluarM::model()->findByPk($model->rujukankeluar_id);
                echo "Dirujuk ke Rumah Sakit : ".$keluar->rumahsakitrujukan;
            } else if (!empty($model->dipulangkan) || !empty($model->dipulangkan_tgl)) {
                $carakeluar = CarakeluarM::model()->findByPk($model->dipulangkan);
                echo ucfirst(strtolower($carakeluar->carakeluar_nama))." ";
                if (!empty($model->dipulangkan_tgl)) {
                    echo "pada tanggal : ".MyFormatter::formatDateTimeForUser($model->dipulangkan_tgl);
                }
            }
            
            ?>
        </td>
        <td>
            Edukasi kesehatan pasien pulang:<br>
            <ul>
                
            <?php 
            
            if (!empty($model->edukasipasien)) {
                foreach ($model->edukasipasien as $item) { 
            ?>
                <li><?php echo $item; ?></li>
            <?php
                }
            }
            
            ?>
            </ul>
        </td>
    </tr>
</table>
