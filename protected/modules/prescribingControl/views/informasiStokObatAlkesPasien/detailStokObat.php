<style>
    .table-rincian td, th{
        border: solid #000 1px;
    }
</style>
<?php
//if(!$modRincians){
//    echo "Data tidak ditemukan."; exit;
//}
$format = new MyFormatter;
//if (!isset($_GET['frame'])){
//    echo $this->renderPartial($this->path_view.'_headerPrint'); 
//}
?>
<div style='width:100%; text-align: center; font-weight: bold; text-decoration: underline;'>  DETAIL STOK OBAT ALKES PASIEN </div>
<br>
<legend class="rim">Data Pasien</legend>
<table style="width: 100%; border: none;">
    <tr>
        <td>Instalasi</td><td>: <?php echo $modPendaftaran->instalasi->instalasi_nama; ?></td>
        <td>No. Rekam Medik</td><td>: <?php echo $modPendaftaran->pasien->no_rekam_medik; ?></td>
    </tr>
    <tr>
        <td>No. Pendaftaran</td><td>: <?php echo $modPendaftaran->no_pendaftaran; ?></td>
        <td>Nama Pasien</td><td>: <?php echo (($modPendaftaran->pasien->namadepan)?$modPendaftaran->pasien->namadepan.$modPendaftaran->pasien->nama_pasien : $modPendaftaran->pasien->nama_pasien); ?></td>
    </tr>
    <tr>
        <td>Tanggal Pendaftaran</td><td>: <?php echo date("d-m-Y",strtotime($modPendaftaran->tgl_pendaftaran));?></td>
        <td>Alias</td><td>: <?php echo (($modPendaftaran->pasien->nama_bin)?$modPendaftaran->pasien->nama_bin : "-");?></td>
    </tr>
    <tr>
        <td>Poliklinik / Ruangan</td><td>: <?php echo $modPendaftaran->ruangan->ruangan_nama; ?></td>
        <td>Tanggal Lahir</td><td>: <?php echo $format->formatDateTimeForUser(date("d-m-Y",strtotime($modPendaftaran->pasien->tanggal_lahir)));?></td>
    </tr>
    <tr>
        <td>Kelas Pelayanan</td><td>: <?php echo $modPendaftaran->kelaspelayanan->kelaspelayanan_nama; ?></td>
        <td>Umur</td><td>: <?php echo $modPendaftaran->umur; ?></td>
    </tr>
    <tr>
        <td>Jenis Kasus Penyakit</td><td>: <?php echo $modPendaftaran->jeniskasuspenyakit->jeniskasuspenyakit_nama; ?></td>
        <td>Jenis Kelamin</td><td>: <?php echo $modPendaftaran->pasien->jeniskelamin;;?></td>
    </tr>
    <tr>
        <td>Alamat</td><td>: <?php echo $modPendaftaran->pasien->alamat_pasien; ?></td>
	</tr>
</table>
<hr>


<legend class="rim">Daftar Obat</legend>
<table width='100%' cellpadding='2px' class='table-rincian'>
    <thead>
        <th>No.</th>
        <th>Nama Obat</th>
        <th>Tanggal Transaksi</th>
        <th>Stok In</th>
        <th>Stok Out</th>
        <th>Current</th>
    </thead>
    <tbody>
        <?php 
		// data belum ada 
		?>
    </tbody>
</table>
<?php
if (isset($_GET['frame'])){
    echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="entypo-print"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"print();"));
    echo CHtml::link(Yii::t('mds', '{icon} Export', array('{icon}'=>'<i class="icon-book icon-white"></i>')), 'javascript:void(0);', array('class' => 'btn btn-danger','onclick'=>'#'));
    echo CHtml::link(Yii::t('mds','{icon} Close', array('{icon}'=>'<i class="entypo-cancel"></i>')), 'javascript:void(0);', array('class' => 'btn btn-default', 'onclick'=>'$("#dialogDetailStok").attr("src",$(this).attr("href")); window.parent.$("#dialogDetailStok").dialog("close"); return false;'));
?>
    <script type='text/javascript'>
    /**
     * print
     */    
    function print(){
        window.open("<?php echo Yii::app()->createUrl("prescribingControl/InformasiStokObatAlkesPasien/DetailStok", array("pendaftaran_id"=>$_GET['pendaftaran_id'])); ?>","",'location=_new, width=1024px');
    }
	</script>
<?php
}else{
?>    
    <table width='100%'>
        <tr>
            <td></td>
            <td></td>
            <td align='center'><?php echo Yii::app()->user->getState('kabupaten_nama').", ".$format->formatDateTimeId(date('Y-m-d')); ?></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td align='center'>Dicetak oleh</td>
        </tr>
        <tr height='100px'>
            <td></td>
            <td></td>
            <td align='center'><?php echo Yii::app()->user->getState('gelardepan')." ".Yii::app()->user->getState('nama_pegawai')." ".Yii::app()->user->getState('gelarbelakang_nama'); ?></td>
        </tr>
    </table>
<?php
}
?>

