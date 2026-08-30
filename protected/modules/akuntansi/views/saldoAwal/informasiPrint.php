


<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/prinout.css');
	$this->breadcrumbs=array(
		'Informasi Saldo Awal'=>array('informasi'),		
	);

	Yii::app()->clientScript->registerScript('search', "
	$('.search-button').click(function(){
		$('.search-form').toggle();
		return false;
	});
	$('.search-form form').submit(function(){
		$.fn.yiiGridView.update('aksaldoawal-t-grid', {
			data: $(this).serialize()
		});
		return false;
	});
	");

	$this->widget('bootstrap.widgets.BootAlert'); 
	
	$period = '';
	if (!empty($model->periodeposting_id)){
		var_dump($model->periodeposting_id);
		$period = PeriodepostingM::model()->findByPk($model->periodeposting_id)->periodeposting_nama;
	}

	if ($caraPrint != 'PDF'){
		echo "<div id='headers'>";
		echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksiPDF',array('judulLaporan'=>$judulLaporan,  'periode'=> ucwords($period), 'colspan'=>10));  
		echo '</div>';
	}else{
		//echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksiPDF',array('judulLaporan'=>$judulLaporan,  'periode'=> ucwords($period), 'colspan'=>10));  
	}
?>
<?php
$spasi = "&emsp;";
$detail = array();

foreach ($saldoawal as $item) {
	if (empty($detail[$item->kdrekening1])) {
		$detail[$item->kdrekening1] = array(
			'nama'=>$item->nmrekening1,
			'debit'=>0,
			'kredit'=>0,
			'rek2'=>array(),
		);
	}
	$detail[$item->kdrekening1]['debit'] += $item->jmlsaldoawald;
	$detail[$item->kdrekening1]['kredit'] += $item->jmlsaldoawalk;
	
	
	if (empty($detail[$item->kdrekening1]['rek2'][$item->kdrekening2])) {
		$detail[$item->kdrekening1]['rek2'][$item->kdrekening2] = array(
			'nama'=>$item->nmrekening2,
			'debit'=>0,
			'kredit'=>0,
			'rek3'=>array(),
		);
	}
	
	$detail[$item->kdrekening1]['rek2'][$item->kdrekening2]['debit'] += $item->jmlsaldoawald;
	$detail[$item->kdrekening1]['rek2'][$item->kdrekening2]['kredit'] += $item->jmlsaldoawalk;
	
	
	if (empty($detail[$item->kdrekening1]['rek2'][$item->kdrekening2]['rek3'][$item->kdrekening3])) {
		$detail[$item->kdrekening1]['rek2'][$item->kdrekening2]['rek3'][$item->kdrekening3] = array(
			'nama'=>$item->nmrekening3,
			'debit'=>0,
			'kredit'=>0,
			'rek4'=>array(),
		);
	}
	
	$detail[$item->kdrekening1]['rek2'][$item->kdrekening2]['rek3'][$item->kdrekening3]['debit'] += $item->jmlsaldoawald;
	$detail[$item->kdrekening1]['rek2'][$item->kdrekening2]['rek3'][$item->kdrekening3]['kredit'] += $item->jmlsaldoawalk;
	
	
	if (empty($detail[$item->kdrekening1]['rek2'][$item->kdrekening2]['rek3'][$item->kdrekening3]['rek4'][$item->kdrekening4])) {
		$detail[$item->kdrekening1]['rek2'][$item->kdrekening2]['rek3'][$item->kdrekening3]['rek4'][$item->kdrekening4] = array(
			'nama'=>$item->nmrekening4,
			'debit'=>0,
			'kredit'=>0,
			'rek5'=>array(),
		);
	}
	
	$detail[$item->kdrekening1]['rek2'][$item->kdrekening2]['rek3'][$item->kdrekening3]['rek4'][$item->kdrekening4]['debit'] += $item->jmlsaldoawald;
	$detail[$item->kdrekening1]['rek2'][$item->kdrekening2]['rek3'][$item->kdrekening3]['rek4'][$item->kdrekening4]['kredit'] += $item->jmlsaldoawalk;
	
	
	
	if (empty($detail[$item->kdrekening1]['rek2'][$item->kdrekening2]['rek3'][$item->kdrekening3]['rek4'][$item->kdrekening4]['rek5'][$item->kdrekening5])) {
		$detail[$item->kdrekening1]['rek2'][$item->kdrekening2]['rek3'][$item->kdrekening3]['rek4'][$item->kdrekening4]['rek5'][$item->kdrekening5] = array(
			'nama'=>$item->nmrekening5,
			'debit'=>0,
			'kredit'=>0,
		);
	}
	
	$detail[$item->kdrekening1]['rek2'][$item->kdrekening2]['rek3'][$item->kdrekening3]['rek4'][$item->kdrekening4]['rek5'][$item->kdrekening5]['debit'] += $item->jmlsaldoawald;
	$detail[$item->kdrekening1]['rek2'][$item->kdrekening2]['rek3'][$item->kdrekening3]['rek4'][$item->kdrekening4]['rek5'][$item->kdrekening5]['kredit'] += $item->jmlsaldoawalk;
}

// var_dump($detail);

?>

    <table class="table border">
		<thead>
			<tr>
			  <!-- <th id="tableLaporan_c0" width="25px">
				No.
			  </th> -->
				<th id="tableLaporan_c0">
					Kode Akun
				</th>
				<th id="tableLaporan_c0">
					Nama Akun
				</th>
				<th id="tableLaporan_c0">
					Debit
				</th>      
				<th id="tableLaporan_c0">
					Kredit
				</th>
			</tr>
		</thead>  
		<tbody>
			<?php 
			$totDebit = 0;
			$totKredit = 0;
			if (!empty($detail)){
				
				foreach ($detail as $kd1=>$rek1) : ?>
			<!--<tr>
				<td><?php echo $kd1; ?></td>
				<td><strong><?php echo $rek1['nama']; ?></strong></td>
				<td style = "text-align:right;"><?php //echo MyFormatter::formatNumberForPrint($rek1['debit']); ?></td>
				<td style = "text-align:right;"><?php //echo MyFormatter::formatNumberForPrint($rek1['kredit']); ?></td>
			</tr>-->
			
				<?php foreach ($rek1['rek2'] as $kd2=>$rek2) : ?>
				<!--<tr>
					<td><?php echo $kd2; ?></td>
					<td><?php echo $spasi.$rek2['nama']; ?></td>
					<td style = "text-align:right;"><?php //echo MyFormatter::formatNumberForPrint($rek2['debit']); ?></td>
					<td style = "text-align:right;"><?php //echo MyFormatter::formatNumberForPrint($rek2['kredit']); ?></td>
				</tr>-->
				
					<?php foreach ($rek2['rek3'] as $kd3=>$rek3) : ?>
					<!--<tr>
						<td><?php echo $spasi.$spasi.$kd3; ?></td>
						<td><?php echo $spasi.$spasi.$rek3['nama']; ?></td>
						<td style = "text-align:right;"><?php //echo MyFormatter::formatNumberForPrint($rek3['debit']); ?></td>
						<td style = "text-align:right;"><?php //echo MyFormatter::formatNumberForPrint($rek3['kredit']); ?></td>
					</tr>-->
					
						<?php foreach ($rek3['rek4'] as $kd4=>$rek4) : ?>
						<!--<tr>
							<td><?php echo $spasi.$spasi.$spasi.$kd4; ?></td>
							<td><?php echo $spasi.$spasi.$spasi.$rek4['nama']; ?></td>
							<td style = "text-align:right;"><?php //echo MyFormatter::formatNumberForPrint($rek4['debit']); ?></td>
							<td style = "text-align:right;"><?php //echo MyFormatter::formatNumberForPrint($rek4['kredit']); ?></td>
						</tr>-->
						
							<?php foreach ($rek4['rek5'] as $kd5=>$rek5) : 
								$kodeakun_5 =	"<b>".$kd1."</b> ".$rek1['nama']."<br/>".
												"<b>".$kd2."</b> ".$rek2['nama']."<br/>".
												"<b>".$kd3."</b> ".$rek3['nama']."<br/>".
												"<b>".$kd4."</b> ".$rek4['nama']."<br/>".
												"<b>".$kd5."</b> ".$rek5['nama']."<br/>";
							
								$totDebit += $rek5['debit'];
								$totKredit += $rek5['kredit'];
								?>
							<tr>
								<td><?php echo $kd5; ?></td><!-- <i class="entypo-info" data-html="true" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="<?php //echo $kodeakun_5; ?>" data-original-title="Informasi Kode Akun"></i>-->
								<td><?php echo $rek5['nama']; ?></td>
								<td style = "text-align:right;"><?php echo MyFormatter::formatNumberForPrint($rek5['debit'], 2); ?></td>
								<td style = "text-align:right;"><?php echo MyFormatter::formatNumberForPrint($rek5['kredit'], 2); ?></td>
							</tr>
							<?php endforeach; ?>
						
						
						<?php endforeach; ?>
					<?php endforeach; ?>
				<?php endforeach; ?>
			<?php endforeach; 
			}else{
			?>
				<tr>
					<td colspan="4">Data Tidak Ditemukan</td>
				</tr>
			<?php	
			}?>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="2" style="text-align:right;"><b>Total</b></td>
				<td style="text-align:right;"><?php echo MyFormatter::formatNumberForPrint($totDebit,2); ?></td>
				<td style="text-align:right;"><?php echo MyFormatter::formatNumberForPrint($totKredit,2); ?></td>
			</tr>
		</tfoot>
	</table>

