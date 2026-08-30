<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/prinout.css');

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
	$spasi2 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	
    $table = 'ext.bootstrap.widgets.HeaderGroupGridView';
    $sort = true;
	$imp = ' !important ';
    if (isset($caraPrint)){
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL"){
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
		}
		if ($caraPrint == "PDF"){
			$imp = "";
		}
	}else{

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
    <table class="table noborder paddingtext">      	        
		<tr>
			<td colspan="3">
				<b>Aktifitas Operasi</b>
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
			<td><?php echo $spasi.$item->kdrekening5.' '.$item->nmrekening5; ?></td>
			<td style="width:50px;">&nbsp;</td>
			<td style='text-align:right;width:120px;'>
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
			<td style="text-align: left;"><?php echo $spasi2; ?><b>Total Aktifitas Operasi </b></td>
			<td style="border-top: 1px solid #333 <?php echo $imp; ?>;">&nbsp;</td>
			<td style='text-align:right;border-top: 1px solid #333 <?php echo $imp; ?>;'><b>
				<?php 
					if ($granTotal < 0){
						echo "(".MyFormatter::formatNumberForPrint(abs($granTotal), 2).")";
					}else{
						echo MyFormatter::formatNumberForPrint($granTotal, 2); 
					}
				?>
					</b></td>
		</tr>
        
        <tr><th colspan="3"></th></tr>        
            <tr>
				<td colspan="3">
					<b>Aktifitas Investasi</b>
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
				<td><?php echo $spasi.$item->kdrekening5.' '.$item->nmrekening5; ?></td>
				<td>&nbsp;</td>
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
                <td style="text-align: left;"><?php echo $spasi2; ?><b>Total Aktifitas Investasi </b></td>
				<td style="border-top: 1px solid #333 <?php echo $imp; ?>;">&nbsp;</td>
                <td style='text-align:right;border-top:1px solid #333 <?php echo $imp ?>;'><b>
					<?php 
					if ($granTotal < 0)
						echo "(".MyFormatter::formatNumberForPrint(abs($granTotal), 2).")";
					else
						echo MyFormatter::formatNumberForPrint($granTotal, 2);
					
				?>
				</b></td>
            </tr>
			<tr><th colspan="3"></th></tr>        
            <tr>
				<td colspan="3">
					<b>Aktifitas Pendanaan</b>
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
				<td><?php echo $spasi.$item->kdrekening5.' '.$item->nmrekening5; ?></td>
				<td>&nbsp;</td>
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
                <td style="text-align: left;"><?php echo $spasi2; ?><b>Total Aktifitas Pendanaan</b></td>
				<td style="border-top: 1px solid #333 <?php echo $imp; ?>;">&nbsp;</td>
                <td style='text-align:right;border-top:1px solid #333 <?php echo $imp ?>;'><b>
					<?php 
					if ($granTotal < 0)
						echo "(".MyFormatter::formatNumberForPrint(abs($granTotal), 2).")";
					else
						echo MyFormatter::formatNumberForPrint($granTotal, 2);										
					?>
				</b></td>                
            </tr>
       <tr><th colspan="3"></th></tr>
        <tr>
			<td style="text-alignn:left;"><?php echo $spasi2; ?><b>Total Keluar/Masuk Kas</b></td>
			<td style="border-bottom: 1px solid #333 <?php echo $imp; ?>;border-top:1px solid #333 <?php echo $imp ?>;"><b>Rp</b></td>
			<td style='text-align:right;border-bottom:1px solid #333 <?php echo $imp ?>;border-top:1px solid #333 <?php echo $imp ?>;'><b>
				<?php 
				if ($greatTotal < 0)
					echo "(".MyFormatter::formatNumberForPrint(abs($greatTotal), 2).")";
				else
					echo MyFormatter::formatNumberForPrint($greatTotal, 2);
				
				?>
			</b></td>                    
		</tr>
	
		<tr>
			<td><?php echo $spasi2 ?><b>Saldo Awal</b></td>
			<td style="border-bottom: 1px solid #333 <?php echo $imp; ?>;"><b>Rp</b></td>
			<td style='text-align:right;border-bottom: 1px solid #333 <?php echo $imp; ?>;'><b>
					<?php 
						$salAwal = $modelLaporan->getSaldoAwalPeriode($periodeposting_id, $ruangan_id);
						
						if ($salAwal < 0){
							echo "(".MyFormatter::formatNumberForPrint(abs($salAwal), 2).")";
						}else{
							echo MyFormatter::formatNumberForPrint($salAwal,2);
						}
					?>					
			</b></td>
		</tr>
		<?php //for($i=1;$i<=100;$i++){ ?>
		<tr>
			<td><?php echo $spasi2 ?><b>Saldo Akhir</b></td>
			<td style="border-bottom: 1px solid #333 <?php echo $imp; ?>;"><b>Rp</b></td>
			<td style='text-align:right;border-bottom: 1px solid #333 <?php echo $imp; ?>;'><b>
				<?php 
					$salAkhir = $modelLaporan->getSaldoAkhirPeriode($periodeposting_id, $ruangan_id);
						
						if ($salAkhir < 0){
							echo "(".MyFormatter::formatNumberForPrint(abs($salAkhir), 2).")";
						}else{
							echo MyFormatter::formatNumberForPrint($salAkhir,2) ;
						}
					
				?>
			</b></td>
		</tr>
		<?php //} ?>
    </table>
</div>