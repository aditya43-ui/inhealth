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
	$table = "table table-striped table-condensed";
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
		$criteria = new CDbCriteria();
		$criteria->compare('periodeposting_id', $_GET['AKLaporanneracaV']['periodeposting_id']);
		
		if (isset($_GET['AKLaporanneracaV']['ruangan_id'])) {
			$criteria->compare('periodeposting_id', $_GET['AKLaporanneracaV']['ruangan_id']);
		}
		
		$dat = AKLaporanneracaV::model()->findAll($criteria);
		
		foreach ($dat as $item) {
			if ($item->rekening1_nb == 'D') {
				$saldo = $item->saldodebit - $item->saldokredit;
				$tipe = 'aktiva';
			} else {
				$saldo = $item->saldokredit - $item->saldodebit;
				$tipe = 'passiva';
			}
			
			if (empty($detail[$tipe]['det'][$item->kdrekening1])) {
				$detail[$tipe]['det'][$item->kdrekening1] = array(
					'nama'=>$item->nmrekening1,
					'total'=>0,
					'det'=>array(),
				);
			}
			
			if (empty($detail[$tipe]['det'][$item->kdrekening1]['det'][$item->kdrekening5])) {
				$detail[$tipe]['det'][$item->kdrekening1]['det'][$item->kdrekening5] = array(
					'nama'=>$item->nmrekening5,
					'total'=>0,
				);
			}
			
			$detail[$tipe]['det'][$item->kdrekening1]['det'][$item->kdrekening5]['total'] += $saldo;
			$detail[$tipe]['det'][$item->kdrekening1]['total'] += $saldo;
			$detail[$tipe]['total'] += $saldo;
		}
	}
	
	
	
	
?>
<div id="tableLaporan" class="grid-view" style="<?php echo $layout; ?>">
  <table class="<?php echo $table; ?>">
    <thead>
      <tr>
        <th id="tableLaporan_c0">
            Nama Rekening
        </th>
        <th id="tableLaporan_c0">
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
			<?php foreach ($item['det'] as $item2): ?>
		<tr>
			<td>&emsp;&emsp;<?php echo $item2['nama']; ?></td>
			<td style="text-align: right; padding-right: 60px;"><?php echo MyFormatter::formatNumberForPrint($item2['total']); ?></td>
		</tr>
			<?php endforeach; ?>
		<tr>
			<td style="font-weight: bold;">&emsp;&emsp;TOTAL <?php echo strtoupper($item['nama']); ?></td>
			<td style="font-weight: bold; text-align: right;"><?php echo MyFormatter::formatNumberForPrint($item['total']); ?></td>
		</tr>
		<?php endforeach; ?>
		<tr>
			<td style="font-weight: bold; font-style: italic; text-align: center;">TOTAL AKTIVA</td>
			<td style="font-weight: bold; font-style: italic; text-align: right;"><?php echo MyFormatter::formatNumberForPrint($detail['aktiva']['total']); ?></td>
		</tr>
		
		
		
		
		
		<tr>
			<td colspan="2" style="font-weight: bold; font-style: italic;">PASSIVA</td>
		</tr>
		<?php foreach ($detail['passiva']['det'] as $item): ?>
		<tr>
			<td style="font-weight:bold;" colspan="2">&emsp;<?php echo strtoupper($item['nama']); ?></td>
		</tr>
			<?php foreach ($item['det'] as $item2): ?>
		<tr>
			<td>&emsp;&emsp;<?php echo $item2['nama']; ?></td>
			<td style="text-align: right; padding-right: 60px;"><?php echo MyFormatter::formatNumberForPrint($item2['total']); ?></td>
		</tr>
			<?php endforeach; ?>
		<tr>
			<td style="font-weight: bold;">&emsp;&emsp;TOTAL <?php echo strtoupper($item['nama']); ?></td>
			<td style="font-weight: bold; text-align: right;"><?php echo MyFormatter::formatNumberForPrint($item2['total']); ?></td>
		</tr>
		<?php endforeach; ?>
		<tr>
			<td style="font-weight: bold; font-style: italic; text-align: center;">TOTAL PASSIVA</td>
			<td style="font-weight: bold; font-style: italic; text-align: right;"><?php echo MyFormatter::formatNumberForPrint($detail['passiva']['total']); ?></td>
		</tr>
		<?php /*
        <?php
			$periodeposting_id = isset($_GET['AKLaporanneracaV']['periodeposting_id']) ? $_GET['AKLaporanneracaV']['periodeposting_id'] : isset($modelLaporan->periodeposting_id) ? $modelLaporan->periodeposting_id : null;
			$ruangan_id = isset($_GET['AKLaporanneracaV']['ruangan_id']) ? $_GET['AKLaporanneracaV']['ruangan_id'] : isset($modelLaporan->ruangan_id) ? $modelLaporan->ruangan_id : null;
			$spasi = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			$pendapatan_aktiva = 0; //AKLaporanneracaV::model()->getSaldoNeraca($periodeposting_id,$ruangan_id,'ACTIVA');
			$pendapatan_passiva = 0; //AKLaporanneracaV::model()->getSaldoNeraca($periodeposting_id,$ruangan_id,'PASSIVA');
//			if (count((array)$model)>0){				
        ?>

        <!----------------- BEGIN ACTIVA ---------------------------------------------->
        <tr>
			<td style="height: 30px; vertical-align: middle;"><b><i>AKTIVA</i></b></td>
			<td style="height: 30px; vertical-align: middle;text-align: right;font-weight: bold;"><?php // echo isset($pendapatan_aktiva) ? MyFormatter::formatNumberForPrint($pendapatan_aktiva,0) : 0; ?></td>
		</tr>
        <?php		
			$jml_aktiva = 0;
			if (count((array)$model)>0){	
			foreach($model as $a=>$laporan_detail){
                                //var_dump($laporan_detail->attributes); die;
                                $kelrek = KelrekeningM::model()->findByPk($laporan_detail->kelrekening_id);
				if($laporan_detail->saldoakhirberjalan != 0 && $kelrek->saldonormal == 'D'){
					$jml_aktiva += $laporan_detail->saldoakhirberjalan;
		?>
		<tr>
			<td><b><?php echo $spasi.$laporan_detail->getNamaRekening(); ?></b></td>
			<td style='text-align:right;'><?php echo MyFormatter::formatNumberForPrint($laporan_detail->saldoakhirberjalan); ?></td>

		<?php } 
			}
		?>
		</tr>
		<?php } ?>
        <tr>
            <td style="text-align: right; padding-right: 1em"><i><b>TOTAL AKTIVA &nbsp; &nbsp;</b></i></td>
            <?php
				echo "<td style='text-align:right;'><b><i>".MyFormatter::formatNumberForPrint($jml_aktiva,0)."</b></i></td>";
            ?>
        </tr>
        <thead><tr><th style="height: 20px; vertical-align: middle;" colspan="2"></th></tr></thead>
        <!----------------- END ACTIVA ---------------------------------------------->
        
        
        <!----------------- BEGIN PASSIVA ---------------------------------------------->
        <tr>
			<td style="height: 30px; vertical-align: middle;"><b><i>PASSIVA</i></b></td>
			<td style="height: 30px; vertical-align: middle;text-align: right;font-weight: bold;"><?php // echo isset($pendapatan_passiva) ? MyFormatter::formatNumberForPrint($pendapatan_passiva,0) : 0; ?></td>
		</tr>
        <?php		
			$jml_passiva = 0;
			if (count((array)$model)>0){	
			foreach($model as $a=>$laporan_detail){
                                $kelrek = KelrekeningM::model()->findByPk($laporan_detail->kelrekening_id);
                                $laporan_detail->saldoakhirberjalan = 0 - $laporan_detail->saldoakhirberjalan;
				if($laporan_detail->saldoakhirberjalan != 0 && $kelrek->saldonormal == 'K'){
					$jml_passiva += $laporan_detail->saldoakhirberjalan;
		?>
		<tr>
			<td><b><?php echo $spasi.$laporan_detail->getNamaRekening(); ?></b></td>
			<td style='text-align:right;'><?php echo MyFormatter::formatNumberForPrint($laporan_detail->saldoakhirberjalan); ?></td>

		<?php } 
			}
		?>
		</tr>
		<?php } ?>
        <tr>
            <td style="text-align: right; padding-right: 1em"><i><b>TOTAL PASSIVA &nbsp; &nbsp;</b></i></td>
            <?php
				echo "<td style='text-align:right;'><b><i>".MyFormatter::formatNumberForPrint($jml_passiva,0)."</b></i></td>";            
			?>
        </tr>
        <thead><tr><th style="height: 20px; vertical-align: middle;" colspan="2"></th></tr></thead>
        <!----------------- END PASIVVA ---------------------------------------------->        
      <?php
//      }
		 * 
		 */
      ?>
    </tbody>
  </table>
</div>