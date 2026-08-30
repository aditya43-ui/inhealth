<style type="text/css">
body{
/*    width: 10.5cm;*/
}
</style>

<?php 
if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
//echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan, 'colspan'=>10)); 

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
<table style="width: 100%; border: none;">
    <thead>
        <tr>
             <td>
                <div class="header"><?php
                    echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array());
                    ?></div>  
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <div class="content">
			<div class="judulcontent"> <?php echo $judulLaporan  ?> </div>
                        <?php
$ruangan_id = null;
$idTindakan = null;
foreach ($modRiwayatPasienKeunitLain as $i => $val) {
    $ruangan_id = $val->ruangan_id;
}

if($ruangan_id != Params::RUANGAN_ID_HEMODIALISA){
    if(Yii::app()->user->getState('modul_id') == Params::MODUL_ID_RJ){
?>
<table width="100%" <?php echo $style; ?>>
    <tr>
        <td>Tanggal Pendaftaran</td><td>:</td><td><?php echo CHtml::encode(MyFormatter::formatDateTimeForUser($modPendaftaran->tgl_pendaftaran)); ?></td>
    </tr>
    <tr>
        <td>Nomor Pendaftaran</td><td>:</td><td><?php echo CHtml::encode($modPendaftaran->no_pendaftaran); ?></td>
    </tr>
    <tr>
        <td>No. Rekam Medik</td><td>:</td><td><?php echo CHtml::encode($modPendaftaran->pasien->no_rekam_medik); ?></td>
    </tr>
    <tr>
        <td>Nama Pasien</td><td>:</td><td><?php echo CHtml::encode($modPendaftaran->pasien->nama_pasien); ?></td>
    </tr>
    <tr>
        <td>Tgl. Lahir/Umur</td><td>:</td><td><?php echo CHtml::encode(MyFormatter::formatDateTimeForUser($modPendaftaran->pasien->tanggal_lahir)); ?> / <?php echo CHtml::encode($modPendaftaran->umur); ?></td>
    </tr>
    <tr>
        <td>Jenis Kelamin</td><td>:</td><td><?php echo CHtml::encode($modPendaftaran->pasien->jeniskelamin); ?></td>
    </tr>
    <tr>
        <td>Kasus Penyakit</td><td>:</td><td><?php echo CHtml::encode($modPendaftaran->jeniskasuspenyakit->jeniskasuspenyakit_nama);?></td>
    </tr>
    <tr>
        <td>Kelas Pelayanan</td><td>:</td><td><?php echo CHtml::encode($modPendaftaran->kelaspelayanan->kelaspelayanan_nama); ?></td>
    </tr>
</table>
<br>
<table id="tblListPemeriksaanRad" class="table table-bordered table-condensed" border="1">
    <thead>
        <tr>
            <th>Tanggal Kirim Ke Ruang Tindakan</th>
            <th>No. Permintaan</th>
            <th>Ruangan Asal</th>
            <th>Ruangan Tujuan</th>
            <th>Dokter Perujuk</th>
            <th>PPDS</th>
            <th>Catatan Permintaan</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($modRiwayatPasienKeunitLain as $i => $permintaan) { ?>
        <?php 
            $dokterPerujuk = '';
            $operator = '';
            $nopermintaan = '';
            if(!empty($permintaan)) {
                $dokterPerujuk = $permintaan->pegawai->nama_pegawai ?? '';
                $operator = $permintaan->ppds->ppds_nama ?? '';
            }  
        ?>
        <tr>
            <td><?php echo $permintaan->tgl_kirimpasien ?></td>
            <td><?php echo $permintaan->no_permintaan ?></td>
            <td><?php echo  $permintaan->createruangan->ruangan_nama ?></td>
            <td><?php echo $permintaan->ruangan->ruangan_nama ?></td>
            <td><?= $dokterPerujuk ?></td>
            <td><?= $operator ?></td>
            <td><?= $permintaan->catatandokterpengirim ?? '' ?></td>
        </tr>
    <?php } ?>
    </tbody>
</table>
<table style="width: 100%; border: none;display: none;">
    <tr>
        <td width="20%" align="center">Subjective</td>
        <td width="40%" align="center"><?php
            
        ?></td>
        <td width="20%" align="center">Objective</td>
        <td width="40%" align="center"><?php
            
        ?></td>
    </tr>
    <tr>
        <td width="20%" align="center">Assessment</td>
        <td width="40%" align="center"><?php
            
        ?></td>
        <td width="20%" align="center">Planning</td>
        <td width="40%" align="center"><?php
            
        ?></td>
    </tr>
</table>
<?php }else{
    ?>
    <table width="100%" <?php echo $style; ?>>
        <tr>
            <td>Tgl. Pendaftaran</td><td>:</td><td><?php echo CHtml::encode(MyFormatter::formatDateTimeForUser($modPendaftaran->tgl_pendaftaran)); ?></td>
        </tr>
        <tr>
            <td>No. Pendaftaran</td><td>:</td><td><?php echo CHtml::encode($modPendaftaran->no_pendaftaran); ?></td>
        </tr>
        <tr>
            <td>No. Rekam Medik</td><td>:</td><td><?php echo CHtml::encode($modPendaftaran->pasien->no_rekam_medik); ?></td>
        </tr>
        <tr>
            <td>Nama Pasien</td><td>:</td><td><?php echo CHtml::encode($modPendaftaran->pasien->nama_pasien); ?></td>
        </tr>
        <tr>
            <td>Tgl. Lahir/Umur</td><td>:</td><td><?php echo CHtml::encode(MyFormatter::formatDateTimeForUser($modPendaftaran->pasien->tanggal_lahir)); ?> / <?php echo CHtml::encode($modPendaftaran->umur); ?></td>
        </tr>
        <tr>
            <td>Jenis Kelamin</td><td>:</td><td><?php echo CHtml::encode($modPendaftaran->pasien->jeniskelamin); ?></td>
        </tr>
        <tr>
            <td>Kasus Penyakit</td><td>:</td><td><?php echo CHtml::encode($modPendaftaran->jeniskasuspenyakit->jeniskasuspenyakit_nama);?></td>
        </tr>
        <tr>
            <td>Kelas Pelayanan</td><td>:</td><td><?php echo CHtml::encode($modPendaftaran->kelaspelayanan->kelaspelayanan_nama); ?></td>
        </tr>
    </table>
    <br>
    <table id="tblListPemeriksaanRad" class="table table-bordered table-condensed" border="1">
        <thead>
            <tr>
                <th>Tanggal Konsul</th>
                <?php /* <th>No. Pendaftaran</th> */ ?>
                <th>Poliklinik Asal</th>
                <th>Poliklinik Tujuan</th>
                <!-- <th>Catatan Dokter</th> -->
            </tr>
        </thead>
        <tbody>
        <?php foreach ($modRiwayatKonsul as $i => $konsul) { ?>
            <tr>
                <td><?php echo $konsul->tglordertindakan ?></td>
                <?php /* <td><?php echo $konsul->pendaftaran->no_pendaftaran ?></td> */ ?>
                <td><?php echo $konsul->ruangasal->ruangan_nama ?></td>
                <td><?php echo $konsul->ruangtujuan->ruangan_nama ?></td>
            </tr>
        <?php } ?>
        </tbody>
        
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
    <?php
} ?>

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
        <td width="40%" align="center"><?php // echo $namaRuangan.' - '.$User; ?></td>
        <td width="20%" align="center"></td>
        <td width="40%" align="center">( <?php echo CHtml::encode($modPendaftaran->pegawai->namaLengkap); ?> )</td>
    <tr>
</table>
		</div>		
            </td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td>
                <div class="footer-space">&nbsp;</div>
            </td>
        </tr>
    </tfoot>
</table>
<div class="">
</div>
<div class="footer">
    <?php   if (isset($caraPrint) && $caraPrint!="PDF"){  ?>
    <?php echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
    <?php  }  ?>
</div>
