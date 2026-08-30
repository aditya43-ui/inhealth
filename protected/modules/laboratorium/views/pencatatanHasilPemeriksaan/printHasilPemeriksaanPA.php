<?php
if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan, 'colspan'=>7)); 
$no_urut = 1;
$class='';
if(isset($_GET['frame']) ){
    $class="table table-bordered";
}
?>

<table style="width: 100%; border: none;">
    <tr>
        <td><?php echo $modKunjungan->getAttributeLabel('no_pendaftaran') ?></td><td>: <?php echo $modKunjungan->no_pendaftaran ?></td>
        <td><?php echo $modKunjungan->getAttributeLabel('no_rekam_medik') ?></td><td>: <?php echo $modKunjungan->no_rekam_medik ?></td>
    </tr>
    <tr>
        <td><?php echo $modKunjungan->getAttributeLabel('tgl_pendaftaran') ?></td><td>: <?php echo $modKunjungan->tgl_pendaftaran ?></td>
        <td><?php echo $modKunjungan->getAttributeLabel('nama_pasien') ?></td><td>: <?php echo $modKunjungan->namadepan." ".$modKunjungan->nama_pasien ?></td>
    </tr>
    <tr>
        <td><?php echo $modKunjungan->getAttributeLabel('no_masukpenunjang') ?></td><td>: <?php echo $modKunjungan->no_masukpenunjang ?></td>
        <td><?php echo $modKunjungan->getAttributeLabel('tanggal_lahir') ?></td><td>: <?php echo $modKunjungan->tanggal_lahir ?></td>
    </tr>
    <tr>
        <td><?php echo $modKunjungan->getAttributeLabel('tglmasukpenunjang') ?></td><td>: <?php echo $modKunjungan->tglmasukpenunjang ?></td>
        <td><?php echo $modKunjungan->getAttributeLabel('jeniskelamin') ?></td><td>: <?php echo $modKunjungan->jeniskelamin ?></td>
    </tr>
    <tr>
        <td><?php echo $modKunjungan->getAttributeLabel('ruangan_nama') ?></td><td>: <?php echo $modKunjungan->ruangan_nama ?></td>
        <td><?php echo $modKunjungan->getAttributeLabel('alamat_pasien') ?></td><td>: <?php echo $modKunjungan->alamat_pasien ?></td>
    </tr>
</table>
<table width="100%" border="1" class='<?php echo $class; ?>'>
    <thead>
        <th>No.</th>
        <th>No. Sediaan PA</th>
        <th>Tanggal Periksa</th>
        <th width="200">Pemeriksaan</th>
        <th>Diagnosa Keterangan/Klinik</th>
        <th>Edukasi Sediaan</th>
        <th>Kategori Umum</th>
        <th>Diagnosa Deskriptif</th>
        <th>Makroskopis</th>
        <th>Mikroskopis</th>
        <th>Kesimpulan</th>
        <th>Saran</th>
        <th>Catatan</th>
    </thead>
    <tbody>
        <?php
        if(count((array)$modHasilPemeriksaanPAs) > 0){
            foreach($modHasilPemeriksaanPAs AS $i => $pemeriksaan){
//                $trpemeriksaan = false;
//                if($i == 0){
//                    echo "<tr><td colspan='6' style='font-weight:bold; text-align:center;'>".$modHasilPemeriksaanPAs[$i]->pemeriksaanlab->pemeriksaanlab_nama."</td></tr>";
//                }else if(($i) < count((array)$modHasilPemeriksaanPAs)){
//                    if($modHasilPemeriksaanPAs[$i]->pemeriksaanlab_id != $modHasilPemeriksaanPAs[$i-1]->pemeriksaanlab_id){
//                        echo "<tr><td colspan='6' style='font-weight:bold; text-align:center;'>".$modHasilPemeriksaanPAs[$i]->pemeriksaanlab->pemeriksaanlab_nama."</td></tr>";
//                        $no_urut--;
//                    }
//                }
        ?>   
            <tr>
                <td><?php echo $no_urut; ?></td>
                <td><?php echo $pemeriksaan->nosediaanpa?></td>
                <td><?php echo $pemeriksaan->tglperiksapa ?></td>
                <td><?php echo $pemeriksaan->pemeriksaanlab->pemeriksaanlab_nama; ?></td>
                <td><?php echo $pemeriksaan->diagnosaklinis; ?></td>
                <td><?php echo $pemeriksaan->adekuasisediaan; ?></td>
                <td><?php echo $pemeriksaan->kategoriumum; ?></td>
                <td><?php echo $pemeriksaan->diagnosadeskriptif; ?></td>
                <td><?php echo $pemeriksaan->makroskopis ?></td>
                <td><?php echo $pemeriksaan->mikroskopis ?></td>
                <td><?php echo $pemeriksaan->kesimpulanpa ?></td>
                <td><?php echo $pemeriksaan->saranpa ?></td>
                <td><?php echo $pemeriksaan->catatanpa ?></td>
            </tr>
        <?php 
            $no_urut++;
            }
        }
        ?>
    </tbody>
</table>
<div>
<?php
if(isset($_GET['frame']) && $_GET['frame'] == 1){    
    echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'printHasil();'));     
}else{
?> 
    <table style="width: 100%; border: none;">
    <tr>
        <td></td>
        <td></td>
        <td><?php echo Yii::app()->user->getState('kabupaten_nama') ?>, <?php echo date('d/m/Y') ?></td>
    </tr>
    <tr>
        <td>Dokter Pemeriksa,</td>
        <td>Petugas Laboratorium,</td>
        <td>Pasien,</td>
    </tr>
    <tr height="200px;">
        <td style="text-decoration: underline;"><?php echo $modKunjungan->gelardepan." ".$modKunjungan->nama_pegawai." ".$modKunjungan->gelarbelakang_nama; ?></td>
        <td style="text-decoration: underline;"><?php echo Yii::app()->user->getState("nama_pegawai"); ?></td>
        <td style="text-decoration: underline;"><?php echo $modKunjungan->nama_pasien; ?></td>
    </tr>
    
</table>
<?php } ?>
</div>
<script>
/**
 * print hasil pemeriksaan 
 */
function printHasil()
{
    var pasienmasukpenunjang_id = <?php echo $_GET['pasienmasukpenunjang_id']; ?>;
    if(pasienmasukpenunjang_id != ""){
        <?php if($modKunjungan->ruangan_id == Params::RUANGAN_ID_LAB_KLINIK){ ?>
                    window.open('<?php echo $this->createUrl('/laboratorium/pencatatanHasilPemeriksaan/print'); ?>&pasienmasukpenunjang_id='+pasienmasukpenunjang_id,'printwin','left=100,top=0,width=768,height=640');
        <?php }else if($modKunjungan->ruangan_id == Params::RUANGAN_ID_LAB_ANATOMI){ ?>
                    window.open('<?php echo $this->createUrl('/laboratorium/pencatatanHasilPemeriksaan/printPA'); ?>&pasienmasukpenunjang_id='+pasienmasukpenunjang_id,'printwin','left=100,top=0,width=1024,height=640');
        <?php } ?>
    }else{
        myAlert("Silakan pilih data kunjungan pasien!");
    }
}    
</script>


