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
// else{
//     echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan, 'colspan'=>10)); 
// }
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
			<div class="judulcontent"><?php  echo $judulLaporan ?></div>
                        <table width="100%" <?php echo $style; ?> >
                        <br>

        <tr>
            <td width="30%"><label class='control-label'><?php echo CHtml::encode($modPendaftaran->pasien->getAttributeLabel('nama_pasien')); ?></label></td>
            <td width="60%"><?php echo CHtml::encode($modPendaftaran->pasien->nama_pasien); ?></td>
        </tr>
        <tr>
            <td width="30%"><label class='control-label'>Umur</label></td>
            <td width="60%"><?php echo CHtml::encode($modPendaftaran->umur); ?></td>
        </tr>
        <tr>
            <td width="30%"><label class='control-label'>No Pendaftaran</label></td>
            <td width="60%"><?php echo CHtml::encode($modPendaftaran->no_pendaftaran); ?></td>
        </tr>
        <tr>
            <td width="30%"><label class='control-label'>No Rekam Medik</label></td>
            <td width="60%"><?php echo CHtml::encode($modPendaftaran->pasien->no_rekam_medik); ?></td>
        </tr>
        <tr>
        <td width="30%"><label class='control-label'>Jenis Kelamin</label></td>
        <td width="60%"><?php echo CHtml::encode($modPendaftaran->pasien->jeniskelamin); ?></td>
        </tr>
        
        <tr>
            <td width="30%"><label class='control-label'>Alamat</label></td>
            <td width="60%"><?php echo CHtml::encode($modPendaftaran->pasien->alamat_pasien); ?></td>
        </tr>
        <tr>
            <td width="30%"><label class='control-label'>Diagnosa</label></td>
            <td width="60%"><?php echo CHtml::encode(!empty($morbid->kelompokdiagnosa_id)?$morbid->diagnosa->diagnosa_nama:'-'); ?></td>
        </tr>
        <tr>
            <td width="30%"><label class='control-label'>DPJP</label></td>
            <td width="60%"><?php echo CHtml::encode(!empty($modRiwayatKirimKeUnitLain->pegawai_id)?$modRiwayatKirimKeUnitLain->pegawai->NamaLengkap:'-'); ?></td>
        </tr>
        <tr>
            <td width="30%"><label class='control-label'>Indikasi Operasi</label></td>
            <td width="60%"><?php echo !empty($modRiwayatKirimKeUnitLain->indikasioperasi) ?CHtml::encode($modRiwayatKirimKeUnitLain->indikasioperasi): " - "; ?></td>
        </tr>
        <tr>
            <td width="30%"><label class='control-label'>Sifat Operasi</label></td>
            <td width="60%"><?php echo !empty($modRiwayatKirimKeUnitLain->sifatoperasi) ? CHtml::encode($modRiwayatKirimKeUnitLain->sifatoperasi):" - "; ?></td>
        </tr>
        <tr>
            <td width="30%"><label class='control-label'>Ruangan yang Meminta</label></td>
            <td width="60%"><?php echo CHtml::encode($modRiwayatKirimKeUnitLain->createruangan->ruangan_nama); ?></td>
        </tr>
        <tr>
            <td width="30%"><label class='control-label'>Vital Sign Terakhir</label></td>
            <td width="60%"><?php echo CHtml::encode($modRiwayatKirimKeUnitLain->vitalsignterakhir); ?></td>
        </tr>
        <tr>
            <td width="30%"><label class='control-label'>PPDS</label></td>
            <td width="60%"><?php echo CHtml::encode($modRencanaOp->ppds->ppds_nama ?? ""); ?></td>
        </tr>
        <tr>
            <td width="30%"><label class='control-label'>Operator</label></td>
            <td width="60%"><?php echo CHtml::encode($modRencanaOp->dokter1->NamaLengkap ?? ""); ?></td>
        </tr>
        <tr>
            <td width="30%"><label class='control-label'>Asisten Operator</label></td>
            <td width="60%"><?php echo CHtml::encode($modRencanaOp->dokter2->NamaLengkap ?? ""); ?></td>
        </tr>
        <tr>
            <td width="30%"><label class='control-label'>Dokter Anestesi</label></td>
            <td width="60%"><?php echo CHtml::encode($modRencanaOp->dokteranastesi->NamaLengkap ?? ""); ?></td>
        </tr>
        <tr>
            <td width="30%"><label class='control-label'>Dokter Resusitasi</label></td>
            <td width="60%"><?php echo CHtml::encode($modRencanaOp->dokterresusitasi->NamaLengkap ?? ""); ?></td>
        </tr>
        <tr>
            <td width="30%"><label class='control-label'>Perawat Anestesi</label></td>
            <td width="60%"><?php echo CHtml::encode($modRencanaOp->paramedis->NamaLengkap ?? ""); ?></td>
        </tr>
        <tr>
            <td width="30%"><label class='control-label'>Petugas RR</label></td>
            <td width="60%"><?php echo CHtml::encode($modRencanaOp->suster->NamaLengkap ?? ""); ?></td>
        </tr>
        <tr>
            <td width="30%"><label class='control-label'>Perawat Instrumen</label></td>
            <td width="60%"><?php echo CHtml::encode($modRencanaOp->bidan->NamaLengkap ?? ""); ?></td>
        </tr>
        <tr>
            <td width="30%"><label class='control-label'>Perawat Sirkuler</label></td>
            <td width="60%"><?php echo CHtml::encode($modRencanaOp->perawatsirkuler->NamaLengkap ?? ""); ?></td>
        </tr>
        <tr>
            <td width="30%"><label class='control-label'>Petugas OK</label></td>
            <td width="60%"><?php echo CHtml::encode($modRiwayatKirimKeUnitLain->petugasok->NamaLengkap ?? ""); ?></td>
        </tr>
        <tr>
            <td width="30%"><label class='control-label'>Estimasi Lama OP</label></td>
            <td width="60%"><?php echo CHtml::encode($modRiwayatKirimKeUnitLain->estimasioperasi ?? "").' Jam'; ?></td>
        </tr>
        <tr>
            <td width="30%"><label class='control-label'>Catatan Permintaan</label></td>
            <td width="60%"><?php echo CHtml::encode($modRiwayatKirimKeUnitLain->catatandokterpengirim ?? ""); ?></td>
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
<table style="width: 100%; border: none;">
    <tr>
        <td width="30%" align="center">Petugas Kamar Operasi</td>
        <td width="40%" align="center"></td>
        <td width="30%" align="center">Dokter Penanggungjawab</td>
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
            $namaRuangan = (!empty($modRuangan->ruangan_nama)) ? $modRuangan->ruangan_nama : ' - ';
            $login = LoginpemakaiK::model()->findByPk(Yii::app()->user->id);
            $User = ((!empty($login->nama_pemakai)) ? $login->nama_pemakai : ' - ');
        ?>
        <td width="30%" align="center"><?php echo !empty($modRiwayatKirimKeUnitLain->petugasruangan_id)?$modRiwayatKirimKeUnitLain->petugasruangan->NamaLengkap:'-'; ?></td>
        <td width="40%" align="center"></td>
        <td width="30%" align="center">( <?php echo CHtml::encode($modPendaftaran->pegawai->namaLengkap); ?> )</td>
    <tr>
</table>
<div class="">
</div>
<div class="footer">
    <?php   if (isset($caraPrint) && $caraPrint!="PDF"){  ?>
    <?php echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
    <?php  }  ?>
</div>
