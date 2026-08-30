<style type="text/css">
body{
    width: 10.5cm;
}

.tab-detail td, .tab-detail th {
    border: 1px solid black;
    padding: 3px;
}

.tab-detail th {
    font-weight: bold;
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
        <td width="30%">Tgl. Pendaftaran</td>
        <td width="5%" style="vertical-align: top"> : </td>
        <td width="60%"><?php echo CHtml::encode(MyFormatter::formatDateTimeForUser($modPendaftaran->tgl_pendaftaran)); ?></td>
    </tr>
    <tr>
        <td width="30%">No. Pendaftaran</td>
        <td width="5%" style="vertical-align: top"> : </td>
        <td width="60%"><?php echo CHtml::encode($modPendaftaran->no_pendaftaran); ?></td>
    </tr>
<!--    <tr>
        <td width="30%">No. Antrian</td>
        <td width="5%" style="vertical-align: top"> : </td>
        <td width="60%"><?php // echo $modRiwayatKirimKeUnitLain[0]->nourut; ?></td>
    </tr>-->
    <tr>
        <td width="30%">No. Rekam Medik</td>
        <td width="5%" style="vertical-align: top"> : </td>
        <td width="60%"><?php echo CHtml::encode($modPendaftaran->pasien->no_rekam_medik); ?></td>
    </tr>
    <tr>
        <td width="30%"><?php echo CHtml::encode($modPendaftaran->pasien->getAttributeLabel('nama_pasien')); ?></td>
        <td width="5%" style="vertical-align: top"> : </td>
        <td width="60%"><?php echo CHtml::encode($modPendaftaran->pasien->nama_pasien); ?></td>
    </tr>
    <tr>
        <td width="30%">Tgl. Lahir / Umur</td>
        <td width="5%" style="vertical-align: top"> : </td>
        <td width="60%"><?php echo CHtml::encode(MyFormatter::formatDateTimeId($modPendaftaran->pasien->tanggal_lahir)); ?> / <?php echo CHtml::encode($modPendaftaran->umur); ?></td>
    </tr>
    <tr>
        <td width="30%"><?php echo CHtml::encode($modPendaftaran->pasien->getAttributeLabel('jeniskelamin')); ?></td>
        <td width="5%" style="vertical-align: top"> : </td>
        <td width="60%"><?php echo CHtml::encode($modPendaftaran->pasien->jeniskelamin); ?></td>
    </tr>
    <tr>
        <td width="30%">Kasus Penyakit</td>
        <td width="5%" style="vertical-align: top"> : </td>
        <td width="60%"><?php echo CHtml::encode($modPendaftaran->jeniskasuspenyakit->jeniskasuspenyakit_nama);?></td>
    </tr>
    <tr>
        <td width="30%">Kelas Pelayanan</td>
        <td width="5%" style="vertical-align: top"> : </td>
        <td width="60%"><?php echo CHtml::encode($modPendaftaran->kelaspelayanan->kelaspelayanan_nama); ?></td>
    </tr>
</table>
<br>
<table id="tblListPemeriksaanLab" class="tab-detail" border="1" >
    <thead>
        <tr>
            <th>Jenis Pemeriksaan</th>
            <th>Permintaan Pemeriksaan</th>
            <th>Jumlah</th>
            <th hidden>Tarif</th>
        </tr>
    </thead>
    <tbody>
<?php
foreach ($modRiwayatKirimKeUnitLain as $i => $riwayat) {
    $modPermintaan = RJPermintaanPenunjangT::model()->with('daftartindakan','pemeriksaanlab')->findAllByAttributes(array('pasienkirimkeunitlain_id'=>$riwayat->pasienkirimkeunitlain_id));
    ?>
    <tr>
        <td><?php
            foreach($modPermintaan as $j => $permintaan){
                echo strip_tags($permintaan->pemeriksaanlab->jenispemeriksaan->jenispemeriksaanlab_nama).'<br/>';
            } ?></td>
        <td>
            <?php
            foreach($modPermintaan as $j => $permintaan){
                echo strip_tags($permintaan->pemeriksaanlab->pemeriksaanlab_nama).'<br/>';
            } ?>
        </td>
        <td>
            <?php
            foreach($modPermintaan as $j => $permintaan){
                echo $permintaan->qtypermintaan.'<br/>';
            } ?>
        </td>
        <td hidden>
            <?php
            foreach($modPermintaan as $j => $permintaan){
                echo MyFormatter::formatNumberForPrint($permintaan->tarif_pelayananan).'<br/>';
            } ?>
            <?php
//            RND-4909
//            $temp_datartind = '';
//            foreach($modPermintaan as $j => $permintaan){
//                $daftartindakan_id = $permintaan->pemeriksaanlab->daftartindakan_id;
//                if($temp_datartind != $daftartindakan_id) {
//                    $modTarif = TariftindakanM::model()->findByAttributes(array('kelaspelayanan_id'=>$riwayat->kelaspelayanan_id,
//                                                                                'daftartindakan_id'=>$daftartindakan_id,
//                                                                                'komponentarif_id'=>Params::KOMPONENTARIF_ID_TOTAL));
//                    echo (!empty($modTarif->harga_tariftindakan))? MyFormatter::formatNumberForPrint($modTarif->harga_tariftindakan).'<br/>':'Belum ada tarif <br/>';
//                }
//                $temp_datartind = $daftartindakan_id;
//            } ?>
        </td>
    </tr>
    <?php
}
?>
    </tbody>
    
</table>
<table width="100%">
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
        
            $operator = "";
            $createLogin = LoginpemakaiK::model()->findByPk($riwayat->create_loginpemakai_id);
            if (!empty($createLogin->pegawai_id)) {
                $pegLogin = PegawaiM::model()->findByPk($createLogin->pegawai_id);
                $operator =  $pegLogin->namaLengkap;
            } else {
                $operator = $createLogin->nama_pemakai;
            }
        
            $modRuangan = RuanganM::model()->findByPk($riwayat->create_ruangan);
            $namaRuangan = (!empty($modRuangan->ruangan_nama)) ? $modRuangan->ruangan_nama : '';
        ?>
        <td width="40%" align="center"><?php echo ' '; ?></td>
        <td width="20%" align="center"></td>
        <td width="40%" align="center">( <?php echo CHtml::encode($modPendaftaran->pegawai->namaLengkap); ?> )</td>
    <tr>
</table>