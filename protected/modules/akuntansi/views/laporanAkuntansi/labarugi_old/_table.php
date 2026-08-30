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
				$nominal_detail = 0;
				
				// nominal untuk jumlah laba rugi
				$nominal_labasebelumpajak = 0;
				$nominal_pajak = 0;
				$nominal_labarugi = 0;
				
				// nominal untuk jumlah pendapatan operasional & nonoperasional				
				$jumlah_pendapatan_operasional = 0;
				$jumlah_pendapatan_nonoperasional = 0;
				$jumlah_pendapatan = 0;
				
				
				// nominal untuk jumlah pendapatan operasional & nonoperasional
				$jumlah_beban_operasional = 0;
				$jumlah_beban_nonoperasional = 0;
				$jumlah_beban = 0;
				
				/**
					* UNTUK PERHITUNGAN
					* 1. PENDAPATAN OPERASIONAL
					* 2. PENDAPATAN NON OPERASIONAL
					* 3. BEBAN OPERASIONAL
					* 4. BEBAN NON OPERASIONAL
				*/
					// deklarasi rekening2_id
					$pendapatan_rek		= 13;
					$pendapatannon_rek	= 15;
					$beban_rek			= 14;
					$bebannon_rek		= 16;
					
					$pendapatan_operasional = AKLaporanlabarugiV::model()->getSaldoPosting($pendapatan_rek,'rekening2',$periodeposting_id,'pendapatanoperasional');
					$pendapatan_nonoperasional = AKLaporanlabarugiV::model()->getSaldoPosting($pendapatannon_rek,'rekening2',$periodeposting_id,'pendapatannonoperasional');
					$beban_operasional = AKLaporanlabarugiV::model()->getSaldoPosting($beban_rek,'rekening2',$periodeposting_id,'bebanoperasional');
					$beban_nonoperasional = AKLaporanlabarugiV::model()->getSaldoPosting($bebannon_rek,'rekening2',$periodeposting_id,'bebannonoperasional');
				/*
					* END PERHITUNGAN 
				*/
			?>
			<tr>
				<td><b>PENDAPATAN OPERASIONAL</b></td>
				<td style="text-align: right;"><?php echo isset($pendapatan_operasional) ? number_format($pendapatan_operasional) : 0; ?></td>
			</tr>
			<?php		
				$criteria2 = new CDbCriteria;
				$criteria2->compare('LOWER(nmrekening2)',  strtolower('pendapatan operasional'));
				if(!empty($periodeposting_id)){
					$criteria2->addCondition('periodeposting_id ='.$periodeposting_id);
				}
				$criteria2->order='rekening5_id asc';
				$criteria2->order='rekening4_id asc';
				$criteria2->order='rekening3_id asc';
				$modelLaporanDetail = AKLaporanlabarugiV::model()->findAll($criteria2);
				$rekening_sebelumnya = '';
				foreach($modelLaporanDetail as $a=>$laporan_detail){
					$rekening_selanjutnya = isset($modelLaporanDetail[$a+1]) ? $modelLaporanDetail[$a+1]->rekening3_id  : $modelLaporanDetail[$a]->rekening3_id ;
					$nominal_detail = $laporan_detail->getSaldoPostingDetail($laporan_detail->rekening2_id,$laporan_detail->rekening3_id,'rekening3',$periodeposting_id,'saldoakhirberjalan');
					if($laporan_detail->rekening3_id != $rekening_sebelumnya){
						$jumlah_pendapatan_operasional += $nominal_detail;
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
				<td style="text-align: right;"><b><i>Jumlah Pendapatan Operasional</i></b></td>
				<td style="text-align: right;"><?php echo isset($jumlah_pendapatan_operasional) ? number_format($jumlah_pendapatan_operasional) : 0; ?></td>
			</tr>			
			<tr>
				<td><b>PENDAPATAN NON OPERASIONAL</b></td>
				<td style="text-align: right;"><?php echo isset($pendapatan_nonoperasional) ? number_format($pendapatan_nonoperasional) : 0; ?></td>
			</tr>
			<?php		
				$criteria3 = new CDbCriteria;
				$criteria3->compare('LOWER(nmrekening2)',  strtolower('pendapatan non operasional'));
				if(!empty($periodeposting_id)){
					$criteria3->addCondition('periodeposting_id ='.$periodeposting_id);
				}
				$criteria3->order='rekening5_id asc';
				$criteria3->order='rekening4_id asc';
				$criteria3->order='rekening3_id asc';
				$modelLaporanDetail = AKLaporanlabarugiV::model()->findAll($criteria3);
				$rekening_sebelumnya = '';
				foreach($modelLaporanDetail as $a=>$laporan_detail){
					$rekening_selanjutnya = isset($modelLaporanDetail[$a+1]) ? $modelLaporanDetail[$a+1]->rekening3_id  : $modelLaporanDetail[$a]->rekening3_id ;
					$nominal_detail = $laporan_detail->getSaldoPostingDetail($laporan_detail->rekening2_id,$laporan_detail->rekening3_id,'rekening3',$periodeposting_id,'saldoakhirberjalan');
					if($laporan_detail->rekening3_id != $rekening_sebelumnya){
						$jumlah_pendapatan_nonoperasional += $nominal_detail;
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
				<td style="text-align: right;"><b><i>Jumlah Pendapatan Non Operasional</i></b></td>
				<td style="text-align: right;"><?php echo isset($jumlah_pendapatan_nonoperasional) ? number_format($jumlah_pendapatan_nonoperasional) : 0; ?></td>
			</tr>
			<?php
				$jumlah_pendapatan = $jumlah_pendapatan_operasional + $jumlah_pendapatan_nonoperasional;						
			?>
			<tr>
				<td style="text-align: right;"><b>JUMLAH PENDAPATAN</b></td>
				<td style="text-align: right;"><?php echo isset($jumlah_pendapatan) ? number_format($jumlah_pendapatan) : 0; ?></td>
			</tr>
			<thead>
				<tr>
				  <th id="tableLaporan_c0"></th>
				  <th style='text-align:right' id="tableLaporan_c2"></th>
				</tr>
			</thead>
			<tr>
				<td><b>BEBAN OPERASIONAL</b></td>
				<td style="text-align: right;"><?php echo isset($beban_operasional) ? number_format($beban_operasional) : 0; ?></td>
			</tr>
			<?php		
				$criteria4 = new CDbCriteria;
				$criteria4->compare('LOWER(nmrekening2)',  strtolower('beban operasional'));
				if(!empty($periodeposting_id)){
					$criteria3->addCondition('periodeposting_id ='.$periodeposting_id);
				}
				$criteria4->order='rekening5_id asc';
				$criteria4->order='rekening4_id asc';
				$criteria4->order='rekening3_id asc';
				$modelLaporanDetail = AKLaporanlabarugiV::model()->findAll($criteria4);
				$rekening_sebelumnya = '';
				foreach($modelLaporanDetail as $a=>$laporan_detail){
					$rekening_selanjutnya = isset($modelLaporanDetail[$a+1]) ? $modelLaporanDetail[$a+1]->rekening3_id  : $modelLaporanDetail[$a]->rekening3_id ;
					$nominal_detail = $laporan_detail->getSaldoPostingDetail($laporan_detail->rekening2_id,$laporan_detail->rekening3_id,'rekening3',$periodeposting_id,'saldoakhirberjalan');
					if($laporan_detail->rekening3_id != $rekening_sebelumnya){
						$jumlah_beban_operasional += $nominal_detail;
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
				<td style="text-align: right;"><b><i>Jumlah Beban Operasional</i></b></td>
				<td style="text-align: right;"><?php echo isset($jumlah_beban_operasional) ? number_format($jumlah_beban_operasional) : 0; ?></td>
			</tr>
			<tr>
				<td><b>BEBAN NON OPERASIONAL</b></td>
				<td style="text-align: right;"><?php echo isset($beban_nonoperasional) ? number_format($beban_nonoperasional) : 0; ?></td>
			</tr>
			<?php		
				$criteria5 = new CDbCriteria;
				$criteria5->compare('LOWER(nmrekening2)',  strtolower('beban non operasional'));
				if(!empty($periodeposting_id)){
					$criteria5->addCondition('periodeposting_id ='.$periodeposting_id);
				}
				$criteria5->order='rekening5_id asc';
				$criteria5->order='rekening4_id asc';
				$criteria5->order='rekening3_id asc';
				$modelLaporanDetail = AKLaporanlabarugiV::model()->findAll($criteria5);
				$rekening_sebelumnya = '';
				foreach($modelLaporanDetail as $a=>$laporan_detail){
					$rekening_selanjutnya = isset($modelLaporanDetail[$a+1]) ? $modelLaporanDetail[$a+1]->rekening3_id  : $modelLaporanDetail[$a]->rekening3_id ;
					$nominal_detail = $laporan_detail->getSaldoPostingDetail($laporan_detail->rekening2_id,$laporan_detail->rekening3_id,'rekening3',$periodeposting_id,'saldoakhirberjalan');
					if($laporan_detail->rekening3_id != $rekening_sebelumnya){
						$jumlah_beban_nonoperasional += $nominal_detail;
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
				<td style="text-align: right;"><b><i>Beban Pendapatan Operasional</i></b></td>
				<td style="text-align: right;"><?php echo isset($jumlah_beban_nonoperasional) ? number_format($jumlah_beban_nonoperasional) : 0; ?></td>
			</tr>
			<?php
				$jumlah_beban = $jumlah_beban_operasional + $jumlah_beban_nonoperasional;						
			?>
			<tr>
				<td style="text-align: right;"><b>JUMLAH BEBAN</b></td>
				<td style="text-align: right;"><?php echo isset($jumlah_beban) ? number_format($jumlah_beban) : 0; ?></td>
			</tr>
			<thead>
				<tr>
				  <th id="tableLaporan_c0"></th>
				  <th style='text-align:right' id="tableLaporan_c2"></th>
				</tr>
			</thead>
			<?php
			/**
				* UNTUK PERHITUNGAN
				* 1. LABA SEBELUM PAJAK
				* 2. PAJAK PENGHASILAN
				* 3. LABA SETELAH PAJAK
			*/
				$nominal_labasebelumpajak = AKLaporanlabarugiV::model()->getLabaRugi($periodeposting_id,'labarugisebelumpajak');
				$nominal_pajak = AKLaporanlabarugiV::model()->getLabaRugi($periodeposting_id,'pajak');
				$nominal_labarugi = AKLaporanlabarugiV::model()->getLabaRugi($periodeposting_id,'labarugi');
			/*
				* END PERHITUNGAN 
			*/
			?>
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