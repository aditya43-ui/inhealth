<?php
    Yii::app()->clientScript->registerScript('search', "
		$('.search-button').click(function(){
			$('.search-form').toggle();
			return false;
		});
		$('#searchLaporan').submit(function(){
			$('#Grafik').attr('src','').css('height','0px');
			$.fn.yiiGridView.update('tableLaporan', {
					data: $(this).serialize()
			});
			return false;
		});
	");
?>
<?php
	$spasi = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    $table = 'ext.bootstrap.widgets.HeaderGroupGridView';
    $sort = true;
    if (isset($caraPrint)){
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL")
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
    } else{
		
    }
	$criteria = new CDbCriteria;
	$periodeposting_id = '';
	$ruangan_id = '';
	if(!empty($_GET['AKLaporanaruskasV']['periodeposting_id']) || $model->periodeposting_id){
		$periodeposting_id = isset($_GET['AKLaporanaruskasV']['periodeposting_id']) ? $_GET['AKLaporanaruskasV']['periodeposting_id'] : isset($model->periodeposting_id) ? $model->periodeposting_id : null;
		$criteria->addCondition('periodeposting_id = '.$periodeposting_id);
	}
	if(!empty($_GET['AKLaporanaruskasV']['ruangan_id']) || $model->ruangan_id){
		$ruangan_id = isset($_GET['AKLaporanaruskasV']['ruangan_id']) ? $_GET['AKLaporanaruskasV']['ruangan_id'] : isset($model->ruangan_id) ? $model->ruangan_id : null;
		$criteria->addCondition('ruangan_id = '.$ruangan_id);
	}
    $modelLaporan = AKLaporanaruskasV::model()->find($criteria);
	if(empty($modelLaporan)){
		$modelLaporan = new AKLaporanaruskasV();
		$modelLaporan->periodeposting_id = $periodeposting_id;
		$modelLaporan->ruangan_id = $ruangan_id;
	}
?>

<div id="tableLaporan" class="grid-view">
    <div style="max-width:1500px;overflow-x:scroll;">
    <table class="table table-striped table-condensed">
      	<thead>
        <tr>
			<th id="tableLaporan_c0" style="text-align:left;">Uraian Transaksi</th>
            <th id="tableLaporan_c0" style="text-align:right;">Nominal</th>            
        </tr>
        <tr>
        </tr>
        </thead>
        <tbody>
		<tr>
			<td style="height: 30px; vertical-align: middle;" colspan="2">
				<b><i>ARUS KAS DARI AKTIFITAS OPERASI</i></b>
			</td>
		</tr>	
		
		<tr>
			<td><b><?php echo $spasi; ?>Laba Rugi</b></td>
			<td style='text-align:right;'>
				<?php
					echo number_format($modelLaporan->getLabaRugi($periodeposting_id, $ruangan_id));
				?>
			</td>
		</tr>
		<tr>
			<td><b><?php echo $spasi; ?>Selisih Kewajiban Lancar</b></td>
			<td style='text-align:right;'>
				<?php
					echo number_format($modelLaporan->getSelisihKewajibanLancar($periodeposting_id, $ruangan_id));
				?>
			</td>
		</tr>
		<tr>
			<td><b><?php echo $spasi; ?>Selisih Aktiva Lancar Non Kas</b></td>
			<td style='text-align:right;'>
				<?php
					echo number_format($modelLaporan->getSelisihAktivaLancarNonKas($periodeposting_id, $ruangan_id));
				?>
			</td>
		</tr>
		<tr>
			<td><b><?php echo $spasi; ?>Penyusutan dan Amortisasi</b></td>
			<td style='text-align:right;'>
				<?php
					echo number_format($modelLaporan->getPenyusutanAmortisasi($periodeposting_id, $ruangan_id));
				?>
			</td>
		</tr>
		
		<tr>
			<td style="text-align: right; padding-right: 1em"><i><b>Kas Bersih Dari Aktifitas Operasi </b></i></td>
			<td style='text-align:right'><i><b>
				<?php echo number_format($modelLaporan->getTotalAktifasiOperasi($periodeposting_id, $ruangan_id)) ?>
					</b></i></td>
		</tr>
        </tbody>
        <thead><tr><th style="height: 20px; vertical-align: middle;" colspan="2"></th></tr></thead>        
        <tbody>
            <tr>
				<td style="height: 30px; vertical-align: middle;" colspan="2">
					<b><i>ARUS KAS DARI AKTIFITAS INVESTASI</i></b>
				</td>
			</tr>	
			<tr>
				<td><b><?php echo $spasi; ?>Beban</b></td>
				<td style='text-align:right;'>
					<?php
						echo number_format($modelLaporan->getBeban($periodeposting_id, $ruangan_id));
					?>
				</td>
			</tr>
			<tr>
				<td><b><?php echo $spasi; ?>Pendapatan</b></td>
				<td style='text-align:right;'>
					<?php
						echo number_format($modelLaporan->getPendapatan($periodeposting_id, $ruangan_id));
					?>
				</td>
			</tr>
            <tr>
                <td style="text-align: right; padding-right: 1em"><i><b>Kas Bersih Dari Aktifitas Investasi </b></i></td>
                <td style='text-align:right'><i><b>
					<?php echo number_format($modelLaporan->getTotalAktifasiInvestasi($periodeposting_id, $ruangan_id)) ?>
				</b></i></td>
            </tr>
        </tbody>
        <thead><tr><th style="height: 20px; vertical-align: middle;" colspan="2"></th></tr></thead>        
        <tbody>
            <tr>
				<td style="height: 30px; vertical-align: middle;" colspan="2">
					<b><i>ARUS KAS DARI AKTIFITAS PENDANAAN</i></b>
				</td>
			</tr>
			<tr>
				<td><b><?php echo $spasi; ?>Modal</b></td>
				<td style='text-align:right;'>
					<?php
						echo number_format($modelLaporan->getEkuitas($periodeposting_id, $ruangan_id));
					?>
				</td>
			</tr>
            <tr>
                <td style="text-align: right; padding-right: 1em"><i><b>Kas Bersih Dari Aktifitas Pendanaan </b></i></td>
                <td style='text-align:right'><i><b>
					<?php echo number_format($modelLaporan->getTotalAktifasiPendanaan($periodeposting_id, $ruangan_id)) ?>
				</b></i></td>                
            </tr>
        </tbody>
        <thead><tr><th style="height: 20px; vertical-align: middle;" colspan="2"></th></tr></thead>                
        <tr>
			<td><b>KENAIKAN ( PENURUNAN ) KAS PERIODE INI</b></td>
			<td style='text-align:right'><b><i>
				<?php echo number_format($modelLaporan->getTotalKenaikanPeriode($periodeposting_id, $ruangan_id)) ?>
			</i></b></td>                    
		</tr>
		<tr>
			<td><b>SALDO KAS AWAL PERIODE</b></td>
			<td style='text-align:right'><b><i>
					<?php echo number_format($modelLaporan->getSaldoAwalPeriode($periodeposting_id, $ruangan_id)) ?>
			</i></b></td>
		</tr>
		<tr>
			<td><b>SALDO KAS AKHIR PERIODE</b></td>
			<td style='text-align:right'><b><i>
				<?php echo number_format($modelLaporan->getSaldoAkhirPeriode($periodeposting_id, $ruangan_id)) ?>
			</i></b></td>
		</tr>
    </table>
    </div>
</div>