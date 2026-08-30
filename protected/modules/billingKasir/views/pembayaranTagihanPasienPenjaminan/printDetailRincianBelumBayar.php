<style>
    .table-rincian td, th{
        border: solid #000 1px;
    }
</style>
<?php
//if(!$modRincians){
//    echo "Data tidak ditemukan"; exit;
//}
$format = new MyFormatter;
if (!isset($_GET['frame'])){
    echo $this->renderPartial($this->path_view.'_headerPrint'); 
}
?>
<div style='width:100%; text-align: center; font-weight: bold;'>  DETAIL RINCIAN TAGIHAN PASIEN </div>
<table width="100%">
    <tr>
        <td>No. Urut</td><td>: <?php echo "-"?></td>
        <td>No. Rekam Medik</td><td>: <?php echo $modPendaftaran->pasien->no_rekam_medik; ?></td>
    </tr>
    <tr>
        <td>No. Pendaftaran</td><td>: <?php echo $modPendaftaran->no_pendaftaran; ?></td>
        <td>Tanggal Masuk RS</td><td>: <?php echo $format->formatDateTimeForUser($modPendaftaran->tgl_pendaftaran);?></td>
    </tr>
    <tr>
        <td>Nama/Umur</td><td>: <?php echo $modPendaftaran->pasien->namadepan." ".$modPendaftaran->pasien->nama_pasien."/".$modPendaftaran->umur;?></td>
        <td>Tanggal Keluar</td><td>: <?php 
			if (count((array)$modRincians) > 0){
				echo $format->formatDateTimeForUser($modRincians[count((array)$modRincians)-1]->tgl_tindakan);
			}
			?></td>
    </tr>
    <tr>
        <td>Alamat</td><td>: <?php echo $modPendaftaran->pasien->alamat_pasien;?></td>
        <td></td><td></td>
    </tr>
</table>
<table width='100%' cellpadding='2px' class='table-rincian'>
    <thead>
        <th>Tanggal</th>
        <th>Uraian</th>
        <th>Banyaknya</th>
        <th>Harga Satuan</th>
        <th>Jumlah</th>
    </thead>
    <tbody>
        <?php 
        $totalbiaya = 0;
		if (count((array)$modRincians) > 0 ){
			foreach($modRincians AS $i => $rincian) {
				$totalbiaya += ($rincian->qty_tindakan*$rincian->tarif_satuan);
				$tampilruangan = true;
				if($i > 0){
					if($modRincians[$i]->ruangantindakan_id == $modRincians[$i-1]->ruangantindakan_id){
						$tampilruangan = false;
					}else{
						$tampilruangan = true;
					}
				}
				if($tampilruangan){
        ?>
					<tr>
						<td></td>
						<td colspan='4'><b><?php echo $rincian->ruangantindakan_nama; ?></b></td>
					</tr>
        <?php 
				}
        ?>
				<tr>
					<td align='right'><?php echo $format->formatDateTimeForUser($rincian->tgl_tindakan); ?></td>
					<td><?php echo $rincian->daftartindakan_nama; ?></td>
					<td align='right'><?php echo str_replace(".",",",$rincian->qty_tindakan); ?></td>
					<td align='right'><?php echo $format->formatNumberForPrint($rincian->tarif_satuan); ?></td>
					<td align='right'><?php echo $format->formatNumberForPrint($rincian->qty_tindakan*$rincian->tarif_satuan); ?></td>
				</tr>
        <?php } ?>
		<?php } ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan='4' align='right' style="font-weight:bold;">Jumlah Biaya</td>
            <td align='right' style="font-weight:bold;"><?php echo $format->formatNumberForPrint($totalbiaya); ?></td>
        </tr>
        <tr>
            <td colspan='5' align='center' style="font-style:italic;">(<?php echo $format->formatNumberTerbilang($totalbiaya); ?> rupiah)</td>
        </tr>
    </tfoot>
</table>
<?php
if (isset($_GET['frame'])){
    echo CHtml::link(Yii::t('mds', '{icon} Print Rincian', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"print();"));
?>
    <script type='text/javascript'>
    /**
     * print
     */    
    function print(){
        window.open("<?php echo Yii::app()->createUrl("billingKasir/PembayaranTagihanPasien/PrintDetailRincianBelumBayar", array("instalasi_id"=>$_GET['instalasi_id'], "pendaftaran_id"=>$_GET['pendaftaran_id'], "pasienadmisi_id"=>(isset($_GET['pasienadmisi_id']) ? $_GET['pasienadmisi_id'] : null))) ?>","",'location=_new, width=1024px');
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

