<style type="text/css">
body{
    width: 100%;
}
.table {
    box-shadow: none;
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

<table width="100%" <?php echo $style; ?> >
    <tr>
        <td><?php echo CHtml::encode($modPendaftaran->getAttributeLabel('tgl_pendaftaran')); ?></td>
        <td>:</td>
        <td width="100% "><?php echo CHtml::encode(MyFormatter::formatDateTimeForUser($modPendaftaran->tgl_pendaftaran)); ?></td>
    </tr>
    <tr>
        <td><?php echo CHtml::encode($modPendaftaran->getAttributeLabel('no_pendaftaran')); ?></td>
        <td>:</td>
        <td><?php echo CHtml::encode($modPendaftaran->no_pendaftaran); ?></td>
    </tr>
    <tr>
        <td>No. Permintaan</td>
        <td>:</td>
        <td><?php echo $_GET['idPasienKirimKeUnitLain']; ?></td>
    </tr>
    <tr>
        <td nowrap>No. Rekam Medik</td>
        <td>:</td>
        <td><?php echo CHtml::encode($modPendaftaran->pasien->no_rekam_medik); ?></td>
    </tr>
    <tr>
        <td><?php echo CHtml::encode($modPendaftaran->pasien->getAttributeLabel('nama_pasien')); ?></td>
        <td>:</td>
        <td><?php echo CHtml::encode($modPendaftaran->pasien->nama_pasien); ?></td>
    </tr>
    <tr>
        <td>Tgl. Lahir / Umur</td>
        <td>:</td>
        <td><?php echo CHtml::encode(MyFormatter::formatDateTimeForUser($modPendaftaran->pasien->tanggal_lahir)." / ".$modPendaftaran->umur); ?></td>
        
    </tr>
    <tr>
        <td>Jenis Kelamin</td>
        <td>:</td>
        <td><?php echo CHtml::encode($modPendaftaran->pasien->jeniskelamin); ?></td>
    </tr>
    <tr>
        <td>Kasus Penyakit</td>
        <td>:</td>
        <td><?php echo CHtml::encode($modPendaftaran->jeniskasuspenyakit->jeniskasuspenyakit_nama);?></td>
    </tr>
    <tr>
        <td>Kelas Pelayanan</td>
        <td>:</td>
        <td><?php echo CHtml::encode($modPendaftaran->pasienadmisiTs[0]->kelaspelayanan->kelaspelayanan_nama); ?></td>
    </tr>
</table>
<br>
<table id="tblListPemeriksaanLab" class="table" border="1">
   <thead>
        <tr>
            <th>Tanggal Permintaan Konsul</th>
            <th>Permintaan Konsul Gizi</th>
            <th>Tarif</th>
        </tr>
    </thead>
<?php
$catatandokterpengirim = "";
foreach ($modRiwayatKirimKeUnitLain as $i => $riwayat) {
    $catatandokterpengirim = $riwayat->catatandokterpengirim;
    $modPermintaan = RIPermintaanPenunjangT::model()->with('daftartindakan')->findAllByAttributes(array('pasienkirimkeunitlain_id'=>$riwayat->pasienkirimkeunitlain_id));
    ?>
    <tr>
        <td>
            <?php
            foreach($modPermintaan as $j => $permintaan){
                echo $permintaan->tglpermintaankepenunjang.'<br>';
            } ?>
        </td>
        <td>
            <?php
            foreach($modPermintaan as $j => $permintaan){
                echo $permintaan->daftartindakan->daftartindakan_nama.'<br>';
            } ?>
        </td>
        <td style="text-align: right">
            <?php
            foreach($modPermintaan as $j => $permintaan){
                $modTarif = TariftindakanM::model()->findByAttributes(array('kelaspelayanan_id'=>$riwayat->kelaspelayanan_id,
                                                                            'daftartindakan_id'=>$permintaan->daftartindakan_id,
                                                                            'komponentarif_id'=>Params::KOMPONENTARIF_ID_TOTAL));
                if(isset($caraPrint) && $caraPrint == "EXCEL"){
                    echo (!empty($modTarif->harga_tariftindakan))? $modTarif->harga_tariftindakan.'<br>':'0 <br>';
                }else{
                    echo (!empty($modTarif->harga_tariftindakan))? MyFormatter::formatNumberForPrint($modTarif->harga_tariftindakan).'<br>':'0 <br>';
                }
            } ?>
        </td>
    </tr>
    <?php
}
?>
    
</table>
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
        <td></td>
        <?php 
            $modRuangan = RuanganM::model()->findByPk(Yii::app()->user->getState('ruangan_id'));
            $namaRuangan = (!empty($modRuangan->ruangan_nama)) ? $modRuangan->ruangan_nama : '';
            $login = LoginpemakaiK::model()->findByPk(Yii::app()->user->id);
            $User = ((!empty($login->nama_pemakai)) ? $login->nama_pemakai : ' - ');
        ?>
        <td width="100%" align="center"></td>
        <td width="40%" align="center" nowrap>( <?php echo CHtml::encode($modPendaftaran->pasienadmisiTs[0]->pegawai->namaLengkap); ?> )</td>
    <tr>
    <?php /*
    <tr>
        <td colspan="3">-</td>
    </tr>
    <tr>
        <td colspan="3" style="text-align: center;">
        <?php echo $namaRuangan.' - '.$User; ?></td>
    </tr>
     * 
     */ ?>
</table>
