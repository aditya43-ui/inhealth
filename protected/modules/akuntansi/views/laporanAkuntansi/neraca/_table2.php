<?php
    Yii::app()->clientScript->registerScript('cari cari', "
        $('#search-form').submit(function(){
                $('#tableLaporan').addClass('srbacLoading');
            $.fn.yiiGridView.update('tableLaporan', {
                data: $(this).serialize()
            });
            return false;
        });
    ");
?>

<?php 
    $table = 'ext.bootstrap.widgets.HeaderGroupGridView';
    $sort = true;	
	$caraPrint = isset($_GET['caraPrint']) ? $_GET['caraPrint'] : null;
	$table = "table table-striped table-bordered table-condensed";
    if (isset($caraPrint)){
		$layout = '';
		$table = 'table table-striped';
//        $data = $modelLaporan->searchNeraca();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL")
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
    } else{
		$layout = 'max-width:1250px;overflow-x:scroll;';
    }
	
	$detail = array(
		'aktiva'=>array(
			'total'=>0,
			'det'=>array(),
		),
		'passiva'=>array(
			'total'=>0,
			'det'=>array(),
		),
	);
	
	if (isset($_GET['AKLaporanneracaV']['periodeposting_id'])) {
		$periode = PeriodepostingM::model()->findByPk($_GET['AKLaporanneracaV']['periodeposting_id']);
		
		$cperiode = new CDbCriteria();
		if (!empty($periode->tglperiodeposting_akhir)){
			$cperiode->addCondition("tglperiodeposting_akhir::date <= '".$periode->tglperiodeposting_akhir."'");
		}else{
			$cperiode->addCondition("tglperiodeposting_akhir = NULL ");
		}
		$periodes = PeriodepostingM::model()->findAll($cperiode);
		
		$criteria = new CDbCriteria();
		
		$criteria->join = "right join rekeningakuntansi_v r on r.rekening5_id = t.rekening5_id";
		
		$criteria->select = "r.*, "
			. "case when t.saldodebit is null then 0 else t.saldodebit end as saldodebit, "
			. "case when t.saldokredit is null then 0 else t.saldokredit end as saldokredit, "
			. "r.struktur_nb as rekening1_nb";
		
		// $con = "periodeposting_id is null ";
		
		
		if (isset($_GET['AKLaporanneracaV']['periodeposting_id'])) {
			/*
			$par = array();
			foreach($periodes as $items) {
				array_push($par, $items->periodeposting_id);
			}
			$con .= 'or periodeposting_id in ('.implode(",", $par).') ';
			 * 
			 */
			$criteria->compare('periodeposting_id', $_GET['AKLaporanneracaV']['periodeposting_id']);
		}
		
		if (isset($_GET['AKLaporanneracaV']['ruangan_id'])) {
			$criteria->compare('ruangan_id', $_GET['AKLaporanneracaV']['ruangan_id']);
		}
		// $criteria->addCondition($con);
		$criteria->addCondition('r.rekening5_aktif = true');
		$criteria->addCondition("r.kdrekening1 in ('1', '2', '3')");
		$criteria->order = 'r.kdrekening1, r.kdrekening2, r.kdrekening3, r.kdrekening4, r.kdrekening5';
		
		// var_dump($criteria);
		
		$dat = AKLaporanneracaV::model()->findAll($criteria);
		
		// var_dump(count((array)$dat)); die;
		
		foreach ($dat as $item) {
			if ($item->rekening1_nb == 'D') {
				$saldo = $item->saldodebit - $item->saldokredit;
				$tipe = 'aktiva';
			} else {
				$saldo = $item->saldokredit - $item->saldodebit;
				$tipe = 'passiva';
			}
			
			if (empty($detail[$tipe]['det'][$item->rekening2_id])) {
				$detail[$tipe]['det'][$item->rekening2_id] = array(
					'nama'=>$item->nmrekening2,
					'total'=>0,
					'det'=>array(),
				);
			}
			
			if (empty($detail[$tipe]['det'][$item->rekening2_id]['det'][$item->rekening5_id])) {
				$detail[$tipe]['det'][$item->rekening2_id]['det'][$item->rekening5_id] = array(
					'nama'=>$item->nmrekening5,
					'total'=>0,
				);
			}
			
			$detail[$tipe]['det'][$item->rekening2_id]['det'][$item->rekening5_id]['total'] += $saldo;
			$detail[$tipe]['det'][$item->rekening2_id]['total'] += $saldo;
			$detail[$tipe]['total'] += $saldo;
		}
	}
	
	// var_dump($detail);
	
?>
<?php if (isset($_GET['caraPrint'])): 
        $per = $periode = PeriodepostingM::model()->findByPk($_GET['AKLaporanneracaV']['periodeposting_id']);
        if (!empty($per)){
            $period = $per->tglperiodeposting_akhir;
        }else{
            $period ='';
        }
        
	echo $this->renderPartial('neraca/_tablePrint', array('periode'=>$period, 'detail'=>$detail, 'table'=>$table), true);
else : ?>
<div id="tableLaporan" class="grid-view col-sm-6" style="<?php echo ""; //$layout; ?>">
  <table class="<?php echo $table; ?>">
    <thead>
      <tr>
        <th id="tableLaporan_c0">
            Nama Rekening
        </th>
        <th id="tableLaporan_c0" class="span3">
            Total Saldo
        </th>
      </tr>
    </thead>
    <tbody>
		<tr>
			<td colspan="2" style="font-weight: bold; font-style: italic;">AKTIVA</td>
		</tr>
		<?php foreach ($detail['aktiva']['det'] as $item): ?>
		<tr>
			<td style="font-weight:bold;" colspan="2">&emsp;<?php echo strtoupper($item['nama']); ?></td>
		</tr>
			<?php foreach ($item['det'] as $item2): 
				$v2 = MyFormatter::formatNumberForPrint($item2['total'], 2);
				if ($item2['total'] < 0) {
					$v2 = "(".MyFormatter::formatNumberForPrint(abs($item2['total']), 2).")";
				} ?>
		<tr>
			<td>&emsp;&emsp;<?php echo $item2['nama']; ?></td>
			<td style="text-align: right; padding-right: 80px;"><?php echo $v2; ?></td>
		</tr>
			<?php endforeach; ?>
		<tr>
			<?php 
			$v2 = MyFormatter::formatNumberForPrint($item['total'], 2);
			if ($item['total'] < 0) {
				$v2 = "(".MyFormatter::formatNumberForPrint(abs($item['total']), 2).")";
			}
			?>
			<td style="font-weight: bold;">&emsp;&emsp;TOTAL <?php echo strtoupper($item['nama']); ?></td>
			<td style="font-weight: bold; text-align: right;"><?php echo $v2; ?></td>
		</tr>
		<?php endforeach; ?>
		<tr>
			<?php 
			$v2 = MyFormatter::formatNumberForPrint($detail['aktiva']['total'], 2);
			if ($detail['aktiva']['total'] < 0) {
				$v2 = "(".MyFormatter::formatNumberForPrint(abs($detail['aktiva']['total']), 2).")";
			}
			?>
			<td style="font-weight: bold; font-style: italic; text-align: center;">TOTAL AKTIVA</td>
			<td style="font-weight: bold; font-style: italic; text-align: right;"><?php echo $v2; ?></td>
		</tr>
		
		
	</tbody>
  </table>
</div>
<div id="tableLaporan2" class="grid-view col-sm-6" style="<?php echo ""; //$layout; ?>">
  <table class="<?php echo $table; ?>">
    <thead>
      <tr>
        <th id="tableLaporan_c0">
            Nama Rekening
        </th>
        <th id="tableLaporan_c0" class="span3">
            Total Saldo
        </th>
      </tr>
    </thead>
    <tbody>
		
		<tr>
			<td colspan="2" style="font-weight: bold; font-style: italic;">PASSIVA</td>
		</tr>
		<?php foreach ($detail['passiva']['det'] as $item): ?>
		<tr>
			<td style="font-weight:bold;" colspan="2">&emsp;<?php echo strtoupper($item['nama']); ?></td>
		</tr>
			<?php foreach ($item['det'] as $item2): ?>
		<tr>
			
			<?php 
			$v2 = MyFormatter::formatNumberForPrint($item2['total'], 2);
			if ($item2['total'] < 0) {
				$v2 = "(".MyFormatter::formatNumberForPrint(abs($item2['total']), 2).")";
			}
			?>
			
			<td>&emsp;&emsp;<?php echo $item2['nama']; ?></td>
			<td style="text-align: right; padding-right: 80px;"><?php echo $v2; ?></td>
		</tr>
			<?php endforeach; ?>
		<tr>
			
			<?php 
			$v2 = MyFormatter::formatNumberForPrint($item['total'], 2);
			if ($item['total'] < 0) {
				$v2 = "(".MyFormatter::formatNumberForPrint(abs($item['total']), 2).")";
			}
			?>
			
			<td style="font-weight: bold;">&emsp;&emsp;TOTAL <?php echo strtoupper($item['nama']); ?></td>
			<td style="font-weight: bold; text-align: right;"><?php echo $v2; ?></td>
		</tr>
		<?php endforeach; ?>
		<tr>
			
			<?php 
			$v2 = MyFormatter::formatNumberForPrint($detail['passiva']['total'], 2);
			if ($detail['passiva']['total'] < 0) {
				$v2 = "(".MyFormatter::formatNumberForPrint(abs($detail['passiva']['total']), 2).")";
			}
			?>
			
			<td style="font-weight: bold; font-style: italic; text-align: center;">TOTAL PASSIVA</td>
			<td style="font-weight: bold; font-style: italic; text-align: right;"><?php echo $v2; ?></td>
		</tr>
    </tbody>
  </table>
</div>

<?php endif; ?>
