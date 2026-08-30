<?php 
    $table = 'ext.bootstrap.widgets.HeaderGroupGridView';
    $sort = true;
    if (isset($caraPrint)){
        $data = $model->search();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL")
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
    } else{
    }
    $criteria = new CDbCriteria;
    $criteria->group = 'rekening2_id, nmrekening2';
    $criteria->select = $criteria->group;
    $criteria->order = 'rekening2_id';
	if(!empty($_GET['AKLaporanlabarugiV']['periodeposting_id']) || $model->periodeposting_id){
		$periodeposting_id = isset($_GET['AKLaporanlabarugiV']['periodeposting_id']) ? $_GET['AKLaporanlabarugiV']['periodeposting_id'] : isset($model->periodeposting_id) ? $model->periodeposting_id : null;
		$criteria->addCondition('periodeposting_id = '.$periodeposting_id);
	}
    $modelLaporan = AKLaporanlabarugiV::model()->findAll($criteria);
?>

<div id="tableLaporan" class="grid-view">
  	<table class="table table-striped table-condensed">
	    <thead>
	      <tr>
	        <th id="tableLaporan_c0">
	          Rincian
	        </th>
	        <th style='text-align:right' id="tableLaporan_c1">
	          Total Nominal
	        </th>
	      </tr>
	    </thead>
	    <tbody> 
			<?php
				$spasi = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				$rekening2_sebelumnya = '';
				$nilai_nominal = 0;
				$nominal_labasebelumpajak = 0;
				$nominal_pajak = 0;
				$nominal_labarugi = 0;
			if(count((array)$modelLaporan) > 0){
				foreach($modelLaporan as $i=>$laporan){
					/**
					 * UNTUK PERHITUNGAN
					 * 1. LABA SEBELUM PAJAK
					 * 2. PAJAK PENGHASILAN
					 * 3. LABA SETELAH PAJAK
					 */
					$nominal_labasebelumpajak = $laporan->getLabaRugi($periodeposting_id,'labarugisebelumpajak');
					$nominal_pajak = $laporan->getLabaRugi($periodeposting_id,'pajak');
					$nominal_labarugi = $laporan->getLabaRugi($periodeposting_id,'labarugi');
					/*
					 * END PERHITUNGAN 
					 */
					
					$rekening2_selanjutnya = isset($modelLaporan[$i+1]) ? $modelLaporan[$i+1]->rekening2_id : $modelLaporan[$i]->rekening2_id;					
					$nama_rek = explode(' ',$laporan->nmrekening2);
					$nama_rek = strtolower($nama_rek[0].$nama_rek[1]);
					if($laporan->rekening2_id != $rekening2_sebelumnya){
						$nilai_nominal = $laporan->getSaldoPosting($laporan->rekening2_id,'rekening2',$periodeposting_id,$nama_rek);
			?>
			<tr>
				<td><b><?php echo strtoupper($laporan->nmrekening2); ?></b></td>
				<td style='text-align:right;'><?php echo number_format($nilai_nominal); ?></td>
			<?php } 
					if($laporan->rekening2_id != $rekening2_selanjutnya){ ?>
			</tr>
			<?php			
					}
				$criteria2 = new CDbCriteria;
				$criteria2->addCondition('rekening2_id = '.$laporan->rekening2_id);
				$criteria2->order='rekening5_id asc';
				$criteria2->order='rekening4_id asc';
				$criteria2->order='rekening3_id asc';
				$modelLaporanDetail = AKLaporanlabarugiV::model()->findAll($criteria2);
				$rekening_sebelumnya = '';
				$nominal_detail = 0;
				$jumlah_pendapatan = 0;
				foreach($modelLaporanDetail as $a=>$laporan_detail){
					$rekening_selanjutnya = isset($modelLaporanDetail[$a+1]) ? $modelLaporanDetail[$a+1]->rekening3_id  : $modelLaporanDetail[$a]->rekening3_id ;
					$nominal_detail = $laporan_detail->getSaldoPostingDetail($laporan->rekening2_id,$laporan_detail->rekening3_id,'rekening3',$periodeposting_id,'saldoakhirberjalan');
					if($laporan_detail->rekening3_id != $rekening_sebelumnya){
						$jumlah_pendapatan += $nominal_detail;
			?>
			<tr>
				<td><b><?php echo $spasi.$laporan_detail->nmrekening3; ?></b></td>
				<td style='text-align:right;'><?php echo number_format($nominal_detail); ?></td>
			
			<?php } 
				if($laporan_detail->rekening3_id != $rekening_selanjutnya){ ?>
			</tr>
			<?php 			
				}
				$rekening_sebelumnya =  $laporan_detail->rekening3_id;
			?>
			<?php } ?>
			<tr>
				<td style='text-align: right;'><b>Jumlah <?php echo $laporan->nmrekening2; ?></b></td>
				<td style='text-align: right;'><?php echo number_format($jumlah_pendapatan); ?></td>
			</tr>
			<?php				
				$nama_rek = explode(' ',$laporan->nmrekening2);
				if($nama_rek[0] == 'Pendapatan'){
			?>
				<tr>
					<td style='text-align: right;'><b>Jumlah PENDAPATAN</b></td>
					<td style='text-align: right;'><?php echo number_format($jumlah_pendapatan); ?></td>
				</tr>
			<?php }else if($nama_rek[0] == 'Beban'){ ?>
				<tr>
					<td style='text-align: right;'><b>Jumlah BEBAN</b></td>
					<td style='text-align: right;'><?php echo number_format($jumlah_pendapatan); ?></td>
				</tr>
			<?php } ?>
			<thead>
				<tr>
				  <th id="tableLaporan_c0"></th>
				  <th style='text-align:right' id="tableLaporan_c2"></th>
				</tr>
			</thead>
			<?php
					$rekening2_sebelumnya = $laporan->rekening2_id;
				}
			}else{
			?>
			<tr>
				<td><b>Pendapatan Operasional</b></td>
				<td style="text-align: right;">0</td>
			</tr>			
			<tr>
				<td><b>Pendapatan Non Operasional</b></td>
				<td style="text-align: right;">0</td>
			</tr>			
			<tr>
				<td><b>Beban Operasional</b></td>
				<td style="text-align: right;">0</td>
			</tr>			
			<tr>
				<td><b>Beban Non Operasional</b></td>
				<td style="text-align: right;">0</td>
			</tr>			
			<?php } ?>
			<tr>
				<td><b>LABA SEBELUM PAJAK</b></td>
				<td style='text-align:right'>
					<?php echo number_format($nominal_labasebelumpajak); ?>
				</td>
			</tr>
			<tr>
				<td><b><?php echo $spasi; ?>Pajak Penghasilan</b></td>
				<td style='text-align:right'>
					<?php echo number_format($nominal_pajak); ?>			
				</td>
			</tr>
			<tr>
				<td><b>LABA SETELAH PAJAK</b></td>
				<td style='text-align:right'>
					<?php echo number_format($nominal_labarugi); ?>					
				</td>
			</tr>
	    </tbody>
    </table>
</div>