<style>
	.col-judul{
		width:120px;
	}
	.col-titik{
		width:5px;
	}
	.col-isi{
		width:250px;
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
	td.headerCenter{
		text-align: center;
	}
</style>
<?php
$format = new MyFormatter;
echo $this->renderPartial('application.views.headerReport.headerRincianBaru');
?>
<table width="100%">
	<tr>
		<td colspan="6" class="text-center-bold">RINCIAN PEMBAYARAN PASIEN</td>
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
		
		<td class="col-judul"><b>Nurse Station</b></td>
		<td class="col-titik">:</td>
		<td class="col-isi">
                    <?php 
                    if(isset($modInfo->ruangan_id)){
                        $modNurseRuangan = NursestationruanganM::model()->findByAttributes(array('ruangan_id'=>$modInfo->ruangan_id));
                        if(!empty($modNurseRuangan)){
                            echo $modNurseRuangan->nursestationrl->nursestation_nama ?? '';
                        }
                        else{
                            echo '-';
                        }
                    }
                    ?>
                </td>
    </tr>
    <tr>
        <td class="col-judul"><b>No.Kuitansi</b></td>
		<td class="col-titik">:</td>
		<td class="col-isi"><?php echo (isset($modTandaBuktiBayar->nobuktibayar))? $modTandaBuktiBayar->nobuktibayar : '';?></td>
		
		<td class="col-judul"><b>Penjamin</b></td>
		<td class="col-titik">:</td>
		<td class="col-isi"><?php echo $modInfo->penjamin_nama; ?></td>
    </tr>
</table>
<br>
<table width="100%">
    <thead class="border-tr-td">
		<tr>
			<th style='text-align: center;'>No.</th>
			<th style='text-align: center;'>Tanggal Pelayanan</th>
			<th style='text-align: center;'>Deskripsi</th>
			<th style='text-align: center;'>Harga</th>
			<th style='text-align: center;'>Biaya Pelayanan Farmasi</th>
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
//				$biaya_lain = $tarif_rsakomodasi + $tarif_medis + $tarif_bhp + $tarif_paramedis + $tarifcyto_tindakan; //RND-13614				
				$biaya_lain = $tarif_rsakomodasi + $tarif_medis + $tarif_paramedis + $tarifcyto_tindakan; 
				$totalTindakan += $biaya_lain + $tindakan->tarif_tindakan; 
		?>
		<tr style='border:1px solid;'>
			<td style='text-align:center;'><?php echo ($i+1); ?></td>
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
				$hargajual_oa = $obatalkes->qty_oa * $obatalkes->hargasatuan_oa;

//				$totalObatAlkes += $biaya_lain + $obatalkes->hargajual_oa; //RND-13614
				$totalObatAlkes += $biaya_lain + $hargajual_oa; //RND-13614
		?>
		<tr class="border-tr-td">
			<td style='text-align:center;'><?php echo $no; ?></td>
			<td style='text-align:left;'><?php echo date("d/m/Y H:i:s",strtotime($obatalkes->tglpelayanan)); ?></td>
			<td class="text-left-bold"><?php echo $obatalkes->ruangan_nama." - ".$obatalkes->noresep; ?></td>
			<td style='text-align: right;'><?php echo $format->formatNumberForPrint($hargajual_oa); ?></td>
			<td style='text-align: right;'><?php echo $format->formatNumberForPrint($biaya_lain); ?></td>
			<td style='text-align: right;'><?php echo $format->formatNumberForPrint($biaya_lain + $hargajual_oa); ?></td>
		</tr>
		<?php $no = $no;}  ?>
		<tr class="border-tr-td">
			<td colspan="5" class="text-right-bold">Total Obat / Alkes</td>
			<td class="text-right"><?php echo $format->formatNumberForPrint($totalObatAlkes); ?></td>
		</tr>
		<?php } ?>
    </tbody>
	<?php 
		$sisakembali = 0;
		$uangterima = isset($modTandaBuktiBayar->uangditerima) ? $modTandaBuktiBayar->uangditerima : 0;
		$uangkembali = isset($modTandaBuktiBayar->uangkembalian) ? $modTandaBuktiBayar->uangkembalian : 0;
		$pembulatan = isset($modTandaBuktiBayar->jmlpembulatan) ? $modTandaBuktiBayar->jmlpembulatan : 0;
		$totaldiscounts = isset($modPembayaranPelayanan->totaldiscount) ? $modPembayaranPelayanan->totaldiscount : 0;
//                $jmlpembayarans = isset($modTandaBuktiBayar->jmlpembayaran) ? $modTandaBuktiBayar->jmlpembayaran : 0;
//                $sisakembali = (($totalTindakan + $totalObatAlkes) + $pembulatan - $totaldiscounts) - $jmlpembayarans;
		$jmlpembayarans = isset($modTandaBuktiBayar->uangditerima) ? $modTandaBuktiBayar->uangditerima : 0; //RSSP-765
		$sisakembali = ($modTandaBuktiBayar->jmlpembayaran <= $jmlpembayarans)? ($jmlpembayarans - $modTandaBuktiBayar->jmlpembayaran) : 0; //RSSP-765
		
		if($sisakembali < 0){
			$sisakembali = 0;
		}
	?>
    <tfoot>
		 <tr class="border-tr-td">
            <td colspan='5' class="text-right-bold">Biaya Administrasi</td>
            <td class="text-right-bold"><?php echo $format->formatNumberForPrint(isset($modTandaBuktiBayar->biayaadministrasi) ? $modTandaBuktiBayar->biayaadministrasi : 0); ?></td>
        </tr> 
<!--        <tr class="border-tr-td">
            <td colspan='5' class="text-right-bold">Biaya Materai</td>
            <td class="text-right-bold"><?php // echo $format->formatNumberForPrint(isset($modTandaBuktiBayar->biayamaterai) ? $modTandaBuktiBayar->biayamaterai : 0); ?></td>
        </tr>-->
		<tr class="border-tr-td">
            <td colspan='5' class="text-right-bold">Total Pembulatan</td>
            <td class="text-right-bold"><?php echo $format->formatNumberForPrint($pembulatan); ?></td>
        </tr> 
		<!-- RSSP-765
		<tr class="border-tr-td">
            <td colspan='5' class="text-right-bold">Total Diskon</td>
            <td class="text-right-bold"><?php // echo $format->formatNumberForPrint($totaldiscounts); ?></td>
        </tr> -->
        <tr class="border-tr-td">
            <td colspan='5' class="text-right-bold">Total</td>
			<td class="text-right-bold"><?php echo $format->formatNumberForPrint(($totalTindakan + $totalObatAlkes) + $pembulatan - $totaldiscounts + $modTandaBuktiBayar->biayaadministrasi); ?></td>
        </tr> 
		<!-- RSSP-765
		<tr class="border-tr-td">
            <td colspan='5' class="text-right-bold">Total Uang Muka</td>
            <td class="text-right-bold"><?php // echo $format->formatNumberForPrint(isset($modPemakaianUangMuka->pemakaianuangmuka) ? $modPemakaianUangMuka->pemakaianuangmuka : 0); ?></td>
        </tr> --> 
		<?php
		if($modInfo->carabayar_id == Params::CARABAYAR_ID_BPJS){ //RSSP-765
		?>
		<tr class="border-tr-td">
            <td colspan='5' class="text-right-bold">Total INACBG</td>
            <td class="text-right-bold"><?php echo $format->formatNumberForPrint(isset($modPembayaranPelayanan->totalinacbg) ? $modPembayaranPelayanan->totalinacbg : 0); ?></td>
        </tr>
		<?php
		}
		?>
		<tr class="border-tr-td">
            <td colspan='5' class="text-right-bold">Total Tanggungan</td>
            <td class="text-right-bold">
                <?php 
                    $totalsubsidiasuransis = isset($modPembayaranPelayanan->totalsubsidiasuransi) ? $modPembayaranPelayanan->totalsubsidiasuransi : 0;
                    $totalsubsidipemerintahs = isset($modPembayaranPelayanan->totalsubsidipemerintah) ? $modPembayaranPelayanan->totalsubsidipemerintah : 0;
                    $totalsubsidirss = isset($modPembayaranPelayanan->totalsubsidirs) ? $modPembayaranPelayanan->totalsubsidirs : 0;
                    $totalpembebasans = isset($modPembayaranPelayanan->totalpembebasan) ? $modPembayaranPelayanan->totalpembebasan : 0;
                    echo $format->formatNumberForPrint($totalsubsidiasuransis + $totalsubsidipemerintahs + $totalsubsidirss + $totalpembebasans); 
                ?>
            </td>
        </tr> 
		<tr class="border-tr-td">
            <td colspan='5' class="text-right-bold">Total Bayar</td>
            <td class="text-right-bold"><?php echo $format->formatNumberForPrint($jmlpembayarans); ?></td>
        </tr> 
		<?php 
		if($sisakembali>0){ //RSSP-765
		?>
		<tr class="border-tr-td">
            <td colspan='5' class="text-right-bold">Kembalian</td>
            <td class="text-right-bold"><?php echo $format->formatNumberForPrint($sisakembali); ?></td>
        </tr> 
		<?php
		}
		?>
		<tr class="border-tr-td">
            <td colspan='5' class="text-right-bold">Sisa Tagihan</td>
            <!-- <td class="text-right-bold"><?php // echo $format->formatNumberForPrint($sisakembali); ?></td> -->
			<td class="text-right-bold"><?php echo !empty($modPembayaranPelayanan->totalsisatagihan) ? $format->formatNumberForPrint($modPembayaranPelayanan->totalsisatagihan) : 0; ?></td> <!--RSSP-765-->
        </tr> 
    </tfoot>
</table>
<br/>
<br/>
<table width="100%">
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
         <td class="tandatangan" style="text-align: center;">Petugas</td>
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
         <!--<td class="tandatangan" style="height: 50px;">.........................</td>-->
         <td class="tandatangan" style="height: 50px;text-align: center;"><?php echo Yii::app()->user->getState('nama_pegawai');?></td>
    </tr>
</table>
<?php
if (isset($_GET['frame'])){
    echo CHtml::link(Yii::t('mds', '{icon} Print Pembayaran', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"print();"));
?>
    <script type='text/javascript'> 
    function print(){
//        window.open("<?php // echo Yii::app()->createUrl("billingKasir/PembayaranTagihanPasien/RincianPembayaranPasien", array("pendaftaran_id"=>$_GET['pendaftaran_id'], "pembayaranpelayanan_id"=>(isset($_GET['pembayaranpelayanan_id']) ? $_GET['pembayaranpelayanan_id'] : null))) ?>","",'location=_new, width=1024px');
        window.open("<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id."/".Yii::app()->controller->id."/RincianPembayaranPasien", array("pendaftaran_id"=>$_GET['pendaftaran_id'], "pembayaranpelayanan_id"=>(isset($_GET['pembayaranpelayanan_id']) ? $_GET['pembayaranpelayanan_id'] : null))) ?>","",'location=_new, width=1024px');
    }
    </script>
<?php
}
?>