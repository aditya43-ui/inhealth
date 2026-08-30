<style type="text/css">
body{
    width: 10.5cm;
}
</style>

<?php 
if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan, 'colspan'=>10)); 

 $style = 'margin-left:auto; margin-right:auto;';
    if (isset($caraPrint)){
        if ($caraPrint == "EXCEL")
            $style = "cellpadding='10',cellspasing='6', width='100%'";
//            $td = "width='100%'";
    } else{
        $style = "style='margin-left:auto; margin-right:auto;'";
//        $td ='';
    }
?>
<?php
$ruangan_id = null;
$idKonsul = null;
foreach ($modRiwayatKonsul as $i => $val) {
    $ruangan_id = $val->ruangan_id;
    $idKonsul = $val->konsulpoli_id;
}

if($ruangan_id != Params::RUANGAN_ID_HEMODIALISA){
?>
<table width="100%" <?php echo $style; ?> >
    <tr>
        <td width="30%"><label class='control-label'><?php echo CHtml::encode($modPendaftaran->getAttributeLabel('tgl_pendaftaran')); ?></label></td>
        <td width="60%"><?php echo CHtml::encode($modPendaftaran->tgl_pendaftaran); ?></td>
    </tr>
    <tr>
        <td width="30%"><label class='control-label'><?php echo CHtml::encode($modPendaftaran->getAttributeLabel('no_pendaftaran')); ?> / No. Permintaan</label></td>
        <td width="60%"><?php echo CHtml::encode($modPendaftaran->no_pendaftaran); ?> / <?php echo $_GET['idKonsulPoli']; ?></td>
    </tr>
    <tr>
        <td width="30%"><label class='control-label'>No. Rekam Medik</label></td>
        <td width="60%"><?php echo CHtml::encode($modPendaftaran->pasien->no_rekam_medik); ?></td>
    </tr>
    <tr>
        <td width="30%"><label class='control-label'><?php echo CHtml::encode($modPendaftaran->pasien->getAttributeLabel('nama_pasien')); ?></label></td>
        <td width="60%"><?php echo CHtml::encode($modPendaftaran->pasien->nama_pasien); ?></td>
    </tr>
    <tr>
        <td width="30%"><label class='control-label'>Tgl. Lahir / Umur</label></td>
        <td width="60%"><?php echo CHtml::encode(MyFormatter::formatDateTimeId($modPendaftaran->pasien->tanggal_lahir)); ?> / <?php echo CHtml::encode($modPendaftaran->umur); ?></td>
    </tr>
    <tr>
        <td width="30%"><label class='control-label'><?php echo CHtml::encode($modPendaftaran->pasien->getAttributeLabel('jeniskelamin')); ?></label></td>
        <td width="60%"><?php echo CHtml::encode($modPendaftaran->pasien->jeniskelamin); ?></td>
    </tr>
    <tr>
        <td width="30%"><label class='control-label'>Kasus Penyakit</label></td>
        <td width="60%"><?php echo CHtml::encode($modPendaftaran->jeniskasuspenyakit->jeniskasuspenyakit_nama);?></td>
    </tr>
    <tr>
        <td width="30%"><label class='control-label'>Kelas Pelayanan</label></td>
        <td width="60%"><?php echo CHtml::encode($modPendaftaran->kelaspelayanan->kelaspelayanan_nama); ?></td>
    </tr>
</table>
<br>
<table id="tblListPemeriksaanRad" class="table table-bordered table-condensed" border="1">
    <thead>
        <tr>
            <th>Tanggal Konsul</th>
            <th>No. Pendaftaran</th>
            <th>Poliklinik Asal</th>
            <th>Poliklinik Tujuan</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($modRiwayatKonsul as $i => $konsul) { ?>
        <tr>
            <td><?php echo $konsul->tglkonsulpoli ?></td>
            <td><?php echo $konsul->pendaftaran->no_pendaftaran ?></td>
            <td><?php echo $konsul->poliasal->ruangan_nama ?></td>
            <td><?php echo $konsul->politujuan->ruangan_nama ?></td>
        </tr>
    <?php } ?>
    </tbody>
    
</table>

<?php
}
else{
    $modKonsul = KonsulPoliT::model()->findByPk($idKonsul);
?>

<table width="100%" <?php echo $style; ?>>
    <tr>
        <td>Nama</td><td>:</td><td><?php echo CHtml::encode($modPendaftaran->pasien->nama_pasien); ?></td>
    </tr>
    <tr>
        <td>No.RM/No. Pendaftaran</td><td>:</td><td><?php echo CHtml::encode($modPendaftaran->pasien->no_rekam_medik).'/'.CHtml::encode($modPendaftaran->no_pendaftaran); ?></td>
    </tr>
    <tr>
        <td>Tgl. Lahir/Umur</td><td>:</td><td><?php echo CHtml::encode(MyFormatter::formatDateTimeForUser($modPendaftaran->pasien->tanggal_lahir)); ?> / <?php echo CHtml::encode($modPendaftaran->umur); ?></td>
    </tr>
     <tr>
        <td>Jenis Kelamin</td><td>:</td><td><?php echo CHtml::encode($modPendaftaran->pasien->jeniskelamin); ?></td>
    </tr>
    <tr>
        <td>Alamat</td><td>:</td><td><?php echo CHtml::encode($modPendaftaran->pasien->alamat_pasien); ?></td>
    </tr>
     <tr>
        <td>Diagnosa</td><td>:</td><td><?php echo CHtml::encode($modPendaftaran->jeniskasuspenyakit->jeniskasuspenyakit_nama);?></td>
    </tr>
</table>
<br>
Instruksi program hemodialisa:
<br>
<br>
<table>
    <tr>
        <td>1. Lama Hemodialisa</td>
        <td>: <?php echo $modKonsul->lama_hd; ?> Jam</td>
    </tr>
    <tr>
        <td>2. Dialisat</td>
        <td>: <?php echo !empty($modKonsul->jenisdialisat_id) ? $modKonsul->jenisdialisat->jenisdialisat_nama : ""; ?></td>
    </tr>
    <tr>
        <td>3. Penarikan Cairan</td>
        <td>: <?php echo $modKonsul->penarikan_cairan; ?> ml</td>
    </tr>
    <tr>
        <td>4. Akses</td>
        <td>: <?php echo !empty($modKonsul->aksesvaskular_id) ? $modKonsul->aksesvaskular->aksesvaskular_nama : ""; ?></td>
    </tr>
    <tr>
        <td>5. Transfusi</td>
        <td>: <?php echo !empty($modKonsul->jenistransfusi_id) ? $modKonsul->jenistransfusi->jenistransfusi_nama : ""; ?></td>
    </tr>
    <!-- <tr>
        <td>7. Lain-lain</td>
        <td>: <?php //echo $modKonsul->catatan_dokter_konsul; ?></td>
    </tr> -->
</table>
<table style="width: 100%; border: none;">
    <tr>
        <td width="20%" align="center">Subjective</td>
        <td width="40%" align="center"><?php
            foreach ($modRiwayatKonsul as $i => $konsul) {
                echo (isset($konsul->objective) ? CHtml::encode(preg_replace('#</?p.*?>#is', '', $konsul->objective)) : " - ");
            }
        ?></td>
        <td width="20%" align="center">Objective</td>
        <td width="40%" align="center"><?php
            foreach ($modRiwayatKonsul as $i => $konsul) {
                echo (isset($konsul->subjective) ? CHtml::encode(preg_replace('#</?p.*?>#is', '', $konsul->subjective)) : " - ");
            }
        ?></td>
    </tr>
    <tr>
        <td width="20%" align="center">Assessment</td>
        <td width="40%" align="center"><?php
            foreach ($modRiwayatKonsul as $i => $konsul) {
                echo (isset($konsul->assessment) ? CHtml::encode(preg_replace('#</?p.*?>#is', '', $konsul->assessment)) : " - ");
            }
        ?></td>
        <td width="20%" align="center">Planning</td>
        <td width="40%" align="center"><?php
            foreach ($modRiwayatKonsul as $i => $konsul) {
                echo (isset($konsul->planning) ? CHtml::encode(preg_replace('#</?p.*?>#is', '', $konsul->planning)) : " - ");
            }
        ?></td>
    </tr>
</table>
<br>
<br>
<?php
}
?>

<table style="width: 100%; border: none;">
    <tr>
        <td colspan="2" width="40%" align="left" valign="">Catatan Dokter : <?php echo (isset($riwayat->catatandokterpengirim) ? CHtml::encode($riwayat->catatandokterpengirim) : " - "); ?></td>
        <td width="60%" align="center"></td>
    </tr>
    <tr>
        <td width="40%" align="center"></td>
        <td width="20%" align="center"></td>
        <td width="40%" align="center">Dokter Penanggungjawab</td>
    <tr>
    <tr>
        <td colspan="2">&nbsp;</td>
    <tr>
    <tr>
        <td colspan="2">&nbsp;</td>
    <tr>
    <tr>
        <td colspan="2">&nbsp;</td>
    <tr>
    <tr>
        <?php 
            $modRuangan = RuanganM::model()->findByPk(Yii::app()->user->getState('ruangan_id'));
            $namaRuangan = (!empty($modRuangan->ruangan_nama)) ? $modRuangan->ruangan_nama : '';
            $login = LoginpemakaiK::model()->findByPk(Yii::app()->user->id);
            $User = ((!empty($login->nama_pemakai)) ? $login->nama_pemakai : ' - ');
        ?>
        <td width="40%" align="center"><?php echo $namaRuangan.' - '.$User; ?></td>
        <td width="20%" align="center"></td>
        <td width="40%" align="center">( <?php echo CHtml::encode($modPendaftaran->pegawai->nama_pegawai); ?> )</td>
    <tr>
</table>