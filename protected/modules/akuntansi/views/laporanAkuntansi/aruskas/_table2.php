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
	
	
	$greatTotal = 0;
?>

<div id="tableLaporan">
    <table class="table table-striped table-bordered table-condensed">
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
		
		<?php 
		$crOp = new CDbCriteria;
		$crOp->addCondition("kdrekening1 in ('2', '4', '5') or kdrekening2 in ('11')");
		$crOp->order = "kdrekening5";
		$crOp->group = "kdrekening5, nmrekening5";
		$crOp->select = $crOp->group.', sum(saldodebit) as saldodebit, sum(saldokredit) as saldokredit';
		if (empty($periodeposting_id)) $periodeposting_id = '0';
		$crOp->compare('periodeposting_id', $periodeposting_id);
		$op = LaporanaruskasV::model()->findAll($crOp);
		
		$granTotal = 0;
		foreach ($op as $item):
			if ($item->saldodebit == $item->saldokredit) continue;
			$saldototal = $item->saldodebit - $item->saldokredit;
			$granTotal += $saldototal;
			$greatTotal += $saldototal;
		?>
		<tr>
			<td><b><?php echo $spasi.$item->nmrekening5; ?></b></td>
			<td style='text-align:right;'>
				<?php
					if ($saldototal < 0)
						echo "(".MyFormatter::formatNumberForPrint(abs($saldototal), 2).")";
					else
						echo MyFormatter::formatNumberForPrint($saldototal, 2);
				?>
			</td>
		</tr>
		
		<?php
		endforeach;
		?>
		
		<tr>
			<td style="text-align: right; padding-right: 1em"><i><b>Kas Bersih Dari Aktifitas Operasi </b></i></td>
			<td style='text-align:right'><i><b>
				<?php echo MyFormatter::formatNumberForPrint($granTotal, 2); ?>
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
			<?php 
			$crOp = new CDbCriteria;
			$crOp->addCondition("kdrekening2 in ('12', '13')");
			$crOp->order = "kdrekening5";
			$crOp->group = "kdrekening5, nmrekening5";
			$crOp->select = $crOp->group.', sum(saldodebit) as saldodebit, sum(saldokredit) as saldokredit';
			if (empty($periodeposting_id)) $periodeposting_id = '0';
			$crOp->compare('periodeposting_id', $periodeposting_id);
			$op = LaporanaruskasV::model()->findAll($crOp);
			
			$granTotal = 0;
			foreach ($op as $item):
				if ($item->saldodebit == $item->saldokredit) continue;
				$saldototal = $item->saldodebit - $item->saldokredit;
				$granTotal += $saldototal;
				$greatTotal += $saldototal;
			?>
			<tr>
				<td><b><?php echo $spasi.$item->nmrekening5; ?></b></td>
				<td style='text-align:right;'>
					<?php
						if ($saldototal < 0)
							echo "(".MyFormatter::formatNumberForPrint(abs($saldototal), 2).")";
						else
							echo MyFormatter::formatNumberForPrint($saldototal, 2);
					?>
				</td>
			</tr>

			<?php
			endforeach;
			?>
            <tr>
                <td style="text-align: right; padding-right: 1em"><i><b>Kas Bersih Dari Aktifitas Investasi </b></i></td>
                <td style='text-align:right'><i><b>
					<?php 
					if ($granTotal < 0)
						echo "(".MyFormatter::formatNumberForPrint(abs($granTotal), 2).")";
					else
						echo MyFormatter::formatNumberForPrint($granTotal, 2);
					
				?>
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
			<?php 
			$crOp = new CDbCriteria;
			$crOp->addCondition("kdrekening1 in ('3')");
			$crOp->order = "kdrekening5";
			$crOp->group = "kdrekening5, nmrekening5";
			$crOp->select = $crOp->group.', sum(saldodebit) as saldodebit, sum(saldokredit) as saldokredit';
			if (empty($periodeposting_id)) $periodeposting_id = '0';
			$crOp->compare('periodeposting_id', $periodeposting_id);
			$op = LaporanaruskasV::model()->findAll($crOp);
			
			$granTotal = 0;
			foreach ($op as $item):
				if ($item->saldodebit == $item->saldokredit) continue;
				$saldototal = $item->saldodebit - $item->saldokredit;
				$granTotal += $saldototal;
				$greatTotal += $saldototal;
			?>
			<tr>
				<td><b><?php echo $spasi.$item->nmrekening5; ?></b></td>
				<td style='text-align:right;'>
					<?php
						if ($saldototal < 0)
							echo "(".MyFormatter::formatNumberForPrint(abs($saldototal), 2).")";
						else
							echo MyFormatter::formatNumberForPrint($saldototal, 2);
					?>
				</td>
			</tr>

			<?php
			endforeach;
			?>
            <tr>
                <td style="text-align: right; padding-right: 1em"><i><b>Kas Bersih Dari Aktifitas Pendanaan </b></i></td>
                <td style='text-align:right'><i><b>
					<?php 
					if ($granTotal < 0)
						echo "(".MyFormatter::formatNumberForPrint(abs($granTotal), 2).")";
					else
						echo MyFormatter::formatNumberForPrint($granTotal, 2);
					
					
					?>
				</b></i></td>                
            </tr>
        </tbody>
        <thead><tr><th style="height: 20px; vertical-align: middle;" colspan="2"></th></tr></thead>                
        <tr>
			<td><b>KENAIKAN ( PENURUNAN ) KAS PERIODE INI</b></td>
			<td style='text-align:right'><b><i>
				<?php 
				if ($greatTotal < 0)
					echo "(".MyFormatter::formatNumberForPrint(abs($greatTotal), 2).")";
				else
					echo MyFormatter::formatNumberForPrint($greatTotal, 2);
				
				?>
			</i></b></td>                    
		</tr>
		<?php /*
		<tr>
			<td><b>SALDO KAS AWAL PERIODE</b></td>
			<td style='text-align:right'><b><i>
					<?php echo MyFormatter::formatNumberForPrint($modelLaporan->getSaldoAwalPeriode($periodeposting_id, $ruangan_id)) ?>
			</i></b></td>
		</tr>
		<tr>
			<td><b>SALDO KAS AKHIR PERIODE</b></td>
			<td style='text-align:right'><b><i>
				<?php echo MyFormatter::formatNumberForPrint($modelLaporan->getSaldoAkhirPeriode($periodeposting_id, $ruangan_id)) ?>
			</i></b></td>
		</tr>
		 * 
		 */ ?>
    </table>
</div>