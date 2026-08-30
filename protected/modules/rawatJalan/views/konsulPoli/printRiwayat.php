<style type="text/css">
body{
    width: 21cm;
}
</style>

<?php 
if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
echo $this->renderPartial('application.views.headerReport.headerDefaultNew',array('judulLaporan'=>$judulLaporan, 'colspan'=>10)); 

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

<table width="100%" <?php echo $style; ?> >
    <tr>
        <td width="30%"><label class='control-label'><?php echo CHtml::encode($modPendaftaran->getAttributeLabel('tgl_pendaftaran')); ?></label></td>
        <td width="60%"><?php echo CHtml::encode($modPendaftaran->tgl_pendaftaran); ?></td>
    </tr>
    <tr>
        <td width="30%"><label class='control-label'><?php echo CHtml::encode($modPendaftaran->getAttributeLabel('no_pendaftaran')); ?></label></td>
        <td width="60%"><?php echo CHtml::encode($modPendaftaran->no_pendaftaran); ?></td>
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
            <th>No. Permintaan</th>
            <th>No. Pendaftaran</th>
            <th>Poliklinik Asal</th>
            <th>Poliklinik Tujuan</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($modRiwayatKonsul as $i => $konsul) { ?>
        <tr>
            <td><?php echo $konsul->tglkonsulpoli ?></td>
            <td><?php echo $konsul->konsulpoli_id ?></td>
            <td><?php echo $konsul->pendaftaran->no_pendaftaran ?></td>
            <td><?php echo $konsul->poliasal->ruangan_nama ?></td>
            <td><?php echo $konsul->politujuan->ruangan_nama ?></td>
        </tr>
    <?php } ?>
    </tbody>
    
</table>
<?php 
    if(isset($_GET['idKonsulPoli'])) {
        $modKonsul = KonsulpoliT::model()->findByPk($_GET['idKonsulPoli']);
    }
?>
<tr>
    <td width="50%">
        <div class="control-group" style="padding: 20px;">
            <label class="control-label">Uraian Konsul</label>
            <div class="controls" style="width: 100% !important;border: 1px solid black; height:100px;">
                <?= $modKonsul->uraian_konsul ?? '' ?>
            </div>
        </div>
       
    </td>
</tr>
<tr>
    <td width="50%">
        <div class="control-group" style="padding: 20px;">
            <label class="control-label">Jawaban Konsul</label>
            <div class="controls" style="width: 100% !important;border: 1px solid black; height:100px;">
                <?= $modKonsul->uraian_konsuljawaban ?? '' ?>
            </div>
        </div>
    </td>
</tr>
<table style="width: 100%; border: none;" hidden>
    <tr>
        <td width="10%" align="center">Subjective</td>
        <td width="40%" align="center"><?php
            foreach ($modRiwayatKonsul as $i => $konsul) {
                echo (isset($konsul->objective) ? CHtml::encode(preg_replace('#</?p.*?>#is', '', $konsul->objective)) : " - ")."<br/>";
            }
        ?></td>
        <td width="10%" align="center">Objective</td>
        <td width="40%" align="center"><?php
            foreach ($modRiwayatKonsul as $i => $konsul) {
                echo (isset($konsul->subjective) ? CHtml::encode(preg_replace('#</?p.*?>#is', '', $konsul->subjective)) : " - ")."<br/>";
            }
        ?></td>
    </tr>
    <tr>
        <td width="10%" align="center">Assessment</td>
        <td width="40%" align="center"><?php
            foreach ($modRiwayatKonsul as $i => $konsul) {
                echo (isset($konsul->assessment) ? CHtml::encode(preg_replace('#</?p.*?>#is', '', $konsul->assessment)) : " - ")."<br/>";
            }
        ?></td>
        <td width="10%" align="center">Planning</td>
        <td width="40%" align="center"><?php
            foreach ($modRiwayatKonsul as $i => $konsul) {
                echo (isset($konsul->planning) ? CHtml::encode(preg_replace('#</?p.*?>#is', '', $konsul->planning)) : " - ")."<br/>";
            }
        ?></td>
    </tr>
</table>
<br/>
<br/>
<br/>
<table style="width: 100%; border: none;">
<?php
   // if(Yii::app()->user->getState('modul_id') == Params::MODUL_ID_RJ){
?>
    <?php //}else{ ?>
    <!-- <tr>
        <td colspan="2" width="40%" align="left" valign="">Catatan Dokter : <?php //echo (isset($riwayat->catatandokterpengirim) ? CHtml::encode($riwayat->catatandokterpengirim) : " - "); ?></td>
        <td width="60%" align="center"></td>
    </tr> -->
    <?php //} ?>
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
        <td width="40%" align="center"><?php $namaRuangan.' - '.$User; ?></td>
        <td width="20%" align="center"></td>
        <td width="40%" align="center">( <?php echo CHtml::encode($modPendaftaran->pegawai->nama_pegawai); ?> )</td>
    <tr>
</table>
<br>
<div class="footer">
    <?php echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
    
</div>