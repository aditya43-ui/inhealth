<style type="text/css">
body {
    /*    width: 10.5cm;*/
}

td {
    vertical-align: top;
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

$header = $this->renderPartial('application.views.headerReport.headerDefaultNew', array());

 $style = 'margin-left:auto; margin-right:auto;';
    if (isset($caraPrint)){
        if ($caraPrint == "EXCEL")
            $style = "cellpadding='10',cellspasing='6', width='100%'";

        // if($caraPrint == 'PDF')
        //     $header = $this->renderPartial('application.views.headerReport.headerDefaultNewPDF', array());
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
                  //  echo $header;
                    ?></div>
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <div class="content">
                    <div class="judulcontent"><?php echo $judulLaporan  ?></div>
                    <table width="100%" <?php echo $style; ?>>
            </td>
        </tr>
        <tr>
            <td width="30%"><label
                    class='control-label'><?php echo CHtml::encode($modPendaftaran->getAttributeLabel('tgl_pendaftaran')); ?></label>
            </td>
            <td width="60%"><?php echo CHtml::encode($modPendaftaran->tgl_pendaftaran); ?></td>
        </tr>
        <tr>
            <td width="30%"><label
                    class='control-label'><?php echo CHtml::encode($modPendaftaran->getAttributeLabel('no_pendaftaran')); ?>
                    / No. Permintaan</label></td>
            <td width="60%"><?php echo CHtml::encode($modPendaftaran->no_pendaftaran); ?> /
                <?php echo $_GET['idPasienKirimKeUnitLain']; ?></td>
        </tr>
        <tr>
            <td width="30%"><label class='control-label'>No. Rekam Medik</label></td>
            <td width="60%"><?php echo CHtml::encode($modPendaftaran->pasien->no_rekam_medik); ?></td>
        </tr>
        <tr>
            <td width="30%"><label
                    class='control-label'><?php echo CHtml::encode($modPendaftaran->pasien->getAttributeLabel('nama_pasien')); ?></label>
            </td>
            <td width="60%"><?php echo CHtml::encode($modPendaftaran->pasien->nama_pasien); ?></td>
        </tr>
        <tr>
            <td width="30%"><label class='control-label'>Tgl. Lahir / Umur</label></td>
            <td width="60%">
                <?php echo CHtml::encode(MyFormatter::formatDateTimeId($modPendaftaran->pasien->tanggal_lahir)); ?> /
                <?php echo CHtml::encode($modPendaftaran->umur); ?></td>
        </tr>
        <tr>
            <td width="30%"><label
                    class='control-label'><?php echo CHtml::encode($modPendaftaran->pasien->getAttributeLabel('jeniskelamin')); ?></label>
            </td>
            <td width="60%"><?php echo CHtml::encode($modPendaftaran->pasien->jeniskelamin); ?></td>
        </tr>
        <tr>
            <td width="30%"><label class='control-label'>Kasus Penyakit</label></td>
            <td width="60%"><?php echo CHtml::encode($modPendaftaran->jeniskasuspenyakit->jeniskasuspenyakit_nama);?>
            </td>
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
            <th>Jenis Pemeriksaan</th>
            <th>Permintaan Pemeriksaan</th>
            <th>Jumlah</th>
            <th>Tarif</th>
        </tr>
    </thead>
    <tbody>
        <?php
$totalTarif = 0;
foreach ($modRiwayatKirimKeUnitLain as $i => $riwayat) {
    $modPermintaan = RJPermintaanPenunjangT::model()->with('daftartindakan','tindakanrm')->findAllByAttributes(array('pasienkirimkeunitlain_id'=>$riwayat->pasienkirimkeunitlain_id));
    ?>
        <tr>
            <td><?php
            foreach($modPermintaan as $j => $permintaan){
                echo strip_tags($permintaan->tindakanrm->jenistindakanrm->jenistindakanrm_nama).'<br>';
            } ?></td>
            <td>
                <?php
            foreach($modPermintaan as $j => $permintaan){
                echo strip_tags($permintaan->tindakanrm->tindakanrm_nama).'<br>';
            } ?>
            </td>
            <td>
                <?php
            foreach($modPermintaan as $j => $permintaan){
                echo $permintaan->qtypermintaan.'<br>';
            } ?>
            </td>
            <td>
                <?php
            $temp_datartind = '';
            foreach($modPermintaan as $j => $permintaan){
                $daftartindakan_id = $permintaan->tindakanrm->daftartindakan_id;
                if($temp_datartind != $daftartindakan_id) {
                    $modTarif = TariftindakanM::model()->findByAttributes(array('kelaspelayanan_id'=>$riwayat->kelaspelayanan_id,
                                                                                'daftartindakan_id'=>$daftartindakan_id,
                                                                                'komponentarif_id'=>Params::KOMPONENTARIF_ID_TOTAL));
                    echo (!empty($modTarif->harga_tariftindakan))? MyFormatter::formatNumberForPrint($modTarif->harga_tariftindakan).'<br>':'Belum ada tarif <br>';
                
                    $totalTarif += ((!empty($modTarif->harga_tariftindakan))?$modTarif->harga_tariftindakan:0);
                }
                $temp_datartind = $daftartindakan_id;
            } ?>
            </td>
        </tr>
        <?php
}
?>
    </tbody>
    <tbody>
        <tr>
            <td colspan="3">Total</td>
            <td><?php echo MyFormatter::formatNumberForPrint($totalTarif); ?></td>
        </tr>
    </tbody>
</table>
<table style="width: 100%; border: none;">
    <tr>
        <td colspan="2" width="40%" align="left" valign="">Catatan Dokter :
            <?php echo (isset($riwayat->catatandokterpengirim) ? CHtml::encode($riwayat->catatandokterpengirim) : " - "); ?>
        </td>
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