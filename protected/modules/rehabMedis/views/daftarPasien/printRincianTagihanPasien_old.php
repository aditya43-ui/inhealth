<style>
	.col-judul{
		width:10%;
	}
	.col-titik{
		width:1%;
	}
	.col-isi{
		width:50%;
	}
	.text-center-bold{
		text-align:center;
		font-weight: bold;
	}
	.text-left-bold{
		text-align:left;
		font-weight: bold;
	}
	.text-right{
		text-align: right;
	}
	.text-right-bold{
		text-align: right;
		font-weight: bold;
	}
	.border-tr-td{
		border:1px solid;
	}
</style>
<?php
$format = new MyFormatter;
echo $this->renderPartial('application.views.headerReport.headerRincianBaru');
?>
<table style="width: 100%; border: none;">
	<tr>
		<td colspan="6" class="text-center-bold">RINCIAN TAGIHAN PASIEN</td>
	</tr>
    <tr>
        <td class="col-judul"><b>No. RM</b></td>
		<td class="col-titik">:</td>
		<td class="col-isi"><?php echo $modInfo->no_rekam_medik; ?></td>
		
		<td class="col-judul"><b>No. Pendaftaran</b></td>
		<td class="col-titik">:</td>
		<td class="col-isi"><?php echo $modInfo->no_pendaftaran; ?></td>
    </tr>
	<tr>
        <td class="col-judul"><b>Nama Pasien</b></td>
		<td class="col-titik">:</td>
		<td class="col-isi"><?php echo $modInfo->namadepan." ".$modInfo->nama_pasien;?></td>
		
		<td class="col-judul"><b>Tanggal Pendaftaran</b></td>
		<td class="col-titik">:</td>
		<td class="col-isi"><?php echo $format->formatDateTimeForUser($modInfo->tgl_pendaftaran); ?></td>
    </tr>
	<tr>
        <td class="col-judul"><b>Tanggal Lahir</b></td>
		<td class="col-titik">:</td>
		<td class="col-isi"><?php echo $format->formatDateTimeForUser($modInfo->tanggal_lahir); ?></td>
		
		<td class="col-judul"><b>Ruangan Terakhir</b></td>
		<td class="col-titik">:</td>
		<td class="col-isi"><?php echo $modInfo->ruangan_nama; ?></td>
    </tr>
	<tr>
        <td class="col-judul"><b>Jenis Kelamin</b></td>
		<td class="col-titik">:</td>
		<td class="col-isi"><?php echo $modInfo->jeniskelamin; ?></td>
		
		<td class="col-judul"><b>Penjamin</b></td>
		<td class="col-titik">:</td>
		<td class="col-isi"><?php echo $modInfo->penjamin_nama; ?></td>
    </tr>
</table>
<br>
<table style="width: 100%; border: none;">
    <thead class="border-tr-td">
		<tr>
			<th style='text-align: center;'>No.</th>
			<th style='text-align: center;'>Tanggal Pelayanan</th>
			<th style='text-align: center;'>Deskripsi</th>
			<th style='text-align: center;'>Harga</th>
			<th style='text-align: center;'>Biaya Lain</th>
			<th style='text-align: center;'>Subtotal</th>
		</tr>        
    </thead>
    <tbody>
        <?php
        $no=0;
        $totalTindakan = 0;	
		$total_biayalain = 0;
		if (count((array)$modRincianTindakan) > 0 ){
			foreach($modRincianTindakan AS $i => $tindakan){		
				
				$tarif_rsakomodasi = $tindakan->tarif_rsakomodasi;
				$tarif_medis = $tindakan->tarif_medis;
				$tarif_bhp = $tindakan->tarif_bhp;
				$tarif_paramedis = $tindakan->tarif_paramedis;
				$tarifcyto_tindakan = $tindakan->tarifcyto_tindakan;
				$biaya_lain = $tarif_rsakomodasi + $tarif_medis + $tarif_bhp + $tarif_paramedis + $tarifcyto_tindakan;
				$totalTindakan += $biaya_lain + $tindakan->tarif_tindakan; 
		?>
		<tr style='border:1px solid;'>
			<td><?php echo ($i+1); ?></td>
			<td style='text-align:left;'><?php echo date("d/m/Y H:i:s",strtotime($tindakan->tgl_tindakan)); ?></td>
			<td class="text-left-bold"><?php echo $tindakan->instalasi_nama." - ".$tindakan->ruangan_nama." - ".$tindakan->kelaspelayanan_nama; ?></td>
			<td style='text-align: right;'><?php echo $format->formatNumberForPrint($tindakan->tarif_tindakan); ?></td>
			<td style='text-align: right;'><?php echo $format->formatNumberForPrint($biaya_lain); ?></td>
			<td style='text-align: right;'><?php echo $format->formatNumberForPrint($biaya_lain + $tindakan->tarif_tindakan); ?></td>
		</tr>
		<?php 
			$no = ($i+1); }
		?>
		<tr class="border-tr-td">
			<td colspan="5" class="text-right-bold">Total Tindakan</td>
			<td style="text-align: right;"><?php echo $format->formatNumberForPrint($totalTindakan); ?></td>
		</tr>
		<?php } ?>
		
		<?php
        $no=$no;
        $totalObatAlkes = 0;
		if (count((array)$modRincianObatAlkes) > 0 ){
			foreach($modRincianObatAlkes AS $i => $obatalkes){
				$no = $no+1;
				 
				$tarifcyto_oa = $obatalkes->tarifcyto;
				$biayaadministrasi = $obatalkes->biayaadministrasi;
				$biayakemasan = $obatalkes->biayakemasan;
				$biayakonseling = $obatalkes->biayakonseling;
				$biayaservice = $obatalkes->biayaservice;
				$biaya_lain = $tarifcyto_oa + $biayaadministrasi + $biayakemasan + $biayakonseling + $biayaservice;
				
				$totalObatAlkes += $biaya_lain + $obatalkes->hargajual_oa;
		?>
		<tr class="border-tr-td">
			<td><?php echo $no; ?></td>
			<td style='text-align:left;'><?php echo date("d/m/Y H:i:s",strtotime($obatalkes->tglpelayanan)); ?></td>
			<td class="text-left-bold"><?php echo $obatalkes->ruangan_nama." - ".$obatalkes->noresep; ?></td>
			<td style='text-align: right;'><?php echo $format->formatNumberForPrint($obatalkes->hargajual_oa); ?></td>
			<td style='text-align: right;'><?php echo $format->formatNumberForPrint($biaya_lain); ?></td>
			<td style='text-align: right;'><?php echo $format->formatNumberForPrint($biaya_lain + $obatalkes->hargajual_oa); ?></td>
		</tr>
		<?php $no = $no;} ?>
		<tr class="border-tr-td">
			<td colspan="5" class="text-right-bold">Total Obat / Alkes</td>
			<td class="text-right"><?php echo $format->formatNumberForPrint($totalObatAlkes); ?></td>
		</tr>
		<?php } ?>
    </tbody>
    <tfoot>
        <tr class="border-tr-td">
            <td colspan=5' class="text-right-bold">Total</td>
            <td class="text-right-bold"><?php echo $format->formatNumberForPrint($totalTindakan + $totalObatAlkes); ?></td>
        </tr>  
    </tfoot>
</table>
<br>
<br>
<table style="width: 100%; border: none;">
    <tr align="left">
         <td colspan="5"></td>
         <td colspan="2"></td>
         <td colspan="2"></td>
         <td colspan="2"></td>
         <td colspan="2"></td>
         <td colspan="2"></td>
         <td colspan="2"></td>
         <td colspan="2"></td>
         <td colspan="2"></td>
         <td class="tandatangan">Petugas</td>
    </tr><tr><td>&nbsp;</td><td>&nbsp;</td></tr>
    <tr align="left">
         <td colspan="5"></td>
         <td colspan="2"></td>
         <td colspan="2"></td>
         <td colspan="2"></td>
         <td colspan="2"></td>
         <td colspan="2"></td>
         <td colspan="2"></td>
         <td colspan="2"></td>
         <td colspan="2"></td>
         <td class="tandatangan" style="height: 50px;">.........................</td>
    </tr>
</table>
<?php
if (isset($_GET['frame'])){
    echo CHtml::link(Yii::t('mds', '{icon} Print Tagihan', array('{icon}'=>'<i class="entypo-print"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"print();"));
?>
    <script type='text/javascript'> 
    function print(){
        window.open("<?php echo Yii::app()->createUrl("rehabMedis/DaftarPasien/RincianTagihanPasien", array("pendaftaran_id"=>$_GET['pendaftaran_id'], "pasienadmisi_id"=>(isset($_GET['pasienadmisi_id']) ? $_GET['pasienadmisi_id'] : null))) ?>","",'location=_new, width=1024px');
    }
    </script>
<?php
}
?>