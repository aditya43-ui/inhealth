<?php

$pasien = PasienM::model()->findByPk($model->pasien_id);
$ruangan = RuanganM::model()->findByPk($model->ruangan_id);
$kelas = KelaspelayananM::model()->findByPk($model->kelaspelayanan_id);

$ahli = PegawaiM::model()->findByPk($model->ahligizi_id);
?>

<style>
    .tab_header > tbody > tr > td {
        border: 1px solid black;
    }
    
    .tab_header td {
        vertical-align: top;
    }
    
    .no_tab_header td {
        padding: 2px;
    }
    
    .tab_asesmen {
        width: 100%;
    }
    
    .tab_asesmen td {
        padding: 5px;
        vertical-align: top;
    }
    
    .antrobio > tbody > tr > td {
        border: 1px solid black;
        padding: 2px;
    }
</style>

<table width="100%" class="tab_header">
    <tr>
        <td rowspan="3" width="100" style="text-align: center; vertical-align: middle;">PENGKAJIAN DAN ASUHAN GIZI</td>
        <td rowspan="2">
            <table class="no_tab_header">
                <tr>
                    <td>Nama</td>
                    <td width="10">: </td>
                    <td><?php echo $pasien->namadepan.$pasien->nama_pasien; ?></td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td width="10">: </td>
                    <td><?php echo $pasien->alamat_pasien; ?></td>
                </tr>
                <tr>
                    <td>Jenis Kelamin</td>
                    <td width="10">: </td>
                    <td><?php echo $pasien->jeniskelamin; ?></td>
                </tr>
            </table>
        </td>
        <td width="200" style="padding: 2px;">No. RM : <?php echo $pasien->no_rekam_medik; ?></td>
    </tr>
    <tr>
        <td>
            <table class="no_tab_header">
                <tr>
                    <td>Tgl. Lahir</td>
                    <td width="10">: </td>
                    <td><?php echo $pasien->namadepan.$pasien->nama_pasien; ?></td>
                </tr>
                <tr>
                    <td>Ruangan</td>
                    <td width="10">: </td>
                    <td><?php echo $ruangan->ruangan_nama; ?></td>
                </tr>
                <tr>
                    <td>Kelas</td>
                    <td width="10">: </td>
                    <td><?php echo $kelas->kelaspelayanan_nama; ?></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="2" style="padding: 2px;">
            Diagnosis Medis :<br>
            <?php echo $model->diagnosa; ?>
        </td>
    </tr>
    <tr>
        <td colspan="3" style="padding: 2px;">
            <?php 
            $time_konsul = strtotime($model->tgl_konsultasi);
            ?>
            <div class="pull-left">Tanggal : <?php echo MyFormatter::formatDateTimeForUser(date('Y-m-d'), $time_konsul);?></div>
            <div class="pull-right">Jam : <?php echo date('H:i:s', $time_konsul); ?></div>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            <h4 style="font-weight: bold; text-align: center;">Riwayat Gizi</h4>
            <ul>
                <li>Frekuensi Makan Utama : <?php echo $model->frekuensi_makan ?> Kali/Hari</li>
                <li>Frekuensi Selingan/Snack : <?php echo $model->frekuensi_selingan ?> Kali/Hari</li>
                <li>Alergi Makanan : <?php echo !$model->alergi_makanan ? "Tidak" : ("Ya, Jenis : ".$model->alergi_makanan_jenis) ?> </li>
                <li>Alergi Makanan : <?php echo !$model->pantangan_makanan ? "Tidak" : ("Ya, Jenis : ".$model->pantangan_makanan_jenis) ?> </li>
            </ul>
        </td>
    </tr>
    <tr>
        <td colspan="3" style="padding: 2px;">
            <h5 style="font-weight: bold; text-align: center;">Kebiasaan Makan Berkaitan dengan Penyakit</h5>
            <?php echo empty($model->kebiasaan_makan_penyakit) ? "-" : $model->kebiasaan_makan_penyakit; ?>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            <h4 style="font-weight: bold; text-align: center;">Asesmen Gizi</h4>
            <table class="tab_asesmen">
                <tbody>
                    <?php 
                    $detail = AsesmengizidetT::model()->findAllByAttributes(array(
                        'asesmengizi_id'=>$model->asesmengizi_id,
                    ));
                    
                    foreach ($detail as $det) :
                        $m = AsesmengiziitemM::model()->findByPk($det->asesmengiziitem_id);
                    ?>
                    <tr>
                        <td width="150"><?php echo $m->asesmengiziitem_nama; ?></td>
                        <td width="10">: </td>
                        <td><?php echo $det->nilai; ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            <table width="100%" class="antrobio">
                <tbody>
                    <tr>
                        <td width="50%">
                            Antropometri<br>
                            <?php echo empty($model->antropometri) ? "-" : $model->antropometri; ?>
                        </td>
                        <td>
                            Biokimia<br>
                            <?php echo empty($model->biokimia) ? "-" : $model->biokimia; ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="50%">
                            Klinis/Fisik<br>
                            <?php echo empty($model->klinik_fisik) ? "-" : $model->klinik_fisik; ?>
                        </td>
                        <td>
                            Riwayat Gizi Diet/Penyakit dan Lain-lain<br>
                            <?php echo empty($model->riwayat_gizi_penyakit) ? "-" : $model->riwayat_gizi_penyakit; ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="3" style="padding: 2px;">
            <h4 style="font-weight: bold; text-align: center;">Diagnosis Gizi</h4>
            <?php echo empty($model->diagnosis_gizi) ? "-" : $model->diagnosis_gizi; ?>
        </td>
    </tr>
    <tr>
        <td colspan="3" style="padding: 2px;">
            <h4 style="font-weight: bold; text-align: center;">Intervensi Gizi</h4>
            <?php echo empty($model->intervensi_gizi) ? "-" : $model->intervensi_gizi; ?>
            
        </td>
    </tr>
    <tr>
        <td colspan="3" style="padding: 2px;">
            <h4 style="font-weight: bold; text-align: center;">Intervensi Gizi</h4>
            <?php echo empty($model->monitoringevaluasi_gizi) ? "-" : $model->monitoringevaluasi_gizi; ?>
            
        </td>
    </tr>
    <tr>
        <td colspan="3" style="font-weight: bold; padding: 2px;">
            <div class="pull-right">Ahli Gizi : <?php echo empty($ahli) ? "-" : $ahli->namaLengkap; ?></div>
        </td>
    </tr>
</table>

<?php if (empty($riwayat)) : ?>
<br>
<div class="form-actions">
    <?php echo CHtml::link('<i class="entypo-back"></i> Kembali', Yii::app()->request->urlReferrer, array(
        'class'=>'btn btn-danger'
    )); ?>
</div>

<?php endif; ?>
