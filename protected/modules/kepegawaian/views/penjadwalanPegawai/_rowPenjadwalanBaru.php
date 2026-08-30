<?php
	// MEMISAHKAN TAHUN - BULAN - TGL (TGL_AWAL)
	$tgl1 = explode('-',$tgl_awal);			
	$tahunawal	= $tgl1[0];
	$bulanawal	= $tgl1[1];
	$tglawal	= $tgl1[2];
	// MEMISAHKAN TAHUN - BULAN - TGL (TGL_AKHIR)
	$tgl2 = explode('-',$tgl_akhir);			
	$tahunakhir	= $tgl2[0];
	$bulanakhir	= $tgl2[1];
	$tglakhir	= $tgl2[2];
?>
<tr>
	<td>
		<?php echo CHtml::activeCheckBox($modPenjadwalanDetail,'[ii]checklist', array('class'=>'checklist','onclick'=>'setNolPegawai(this);')); ?>
	</td>
	<td>
		<?php 
			echo CHtml::activeHiddenField($modPenjadwalanDetail, '[ii]kelompokpegawai_id', array('readonly'=>true,'class'=>'inputFormTabel'));
			echo $modPenjadwalanDetail->kelompokpegawai_nama;
		?>
	</td>
	<td>
		<?php echo CHtml::activeHiddenField($modPenjadwalanDetail, '[ii]pegawai_id', array('readonly'=>true,'class'=>'inputFormTabel')); ?>
		<?php echo CHtml::activeHiddenField($modPenjadwalanDetail, '[ii]ruangan_id', array('readonly'=>true,'class'=>'inputFormTabel')); ?>		
		<?php echo $modPenjadwalanDetail->nama_pegawai;?>
		<?php
		
		?>
	</td>
	<!--perulangan untuk menampilkan shift-->
	<?php
		$row = '';		
		$a = 0;
		$j = 0;
		$tgl = $tgl_awal;
		for ($i=0;$i<= $jml_hari;$i++)
		{				
			// menghitung jumlah hari dalam bulan tertentu
			$tgl3 = explode('-', $tgl);
			$tahun = $tgl3[0];
			$bulan = $tgl3[1];
			$tanggal = $tgl3[2];
			// end menghitung jumlah hari dalam bulan tertentu
			$jmlhari = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);

			if($tanggal > $jmlhari){
				$tgl = date('Y-m-01', strtotime($tgl_akhir));
			}
			
			if (isset($modHariLibur[$tgl])){
				$bg = 'red';
				$style = "style='color:#fff !important;'";
			}else{
				$bg = '';
				$style = "";
			}
					
			$row .= "<td class='".$bg."' ".$style.">";
				$row .= CHtml::activeHiddenField($modPenjadwalanDetail, '[i][shift][iii]tgljadwalpegawai', array('readonly'=>true,'class'=>'inputFormTabel','value'=>$tgl));
				//if (isset($modDropDownShift[$modPenjadwalanDetail->pegawai_id])){
				//	echo 'asd';
				//	print_r($modDropDownShift[$modPenjadwalanDetail->pegawai_id]);
				//}
				//echo 'asd';
				//$row .= CHtml::activeHiddenField($modPenjadwalanDetail, '[i][shift][iii]jamkerjamasuk', array('class'=>'span2'));
				//$row .= CHtml::activeHiddenField($modPenjadwalanDetail, '[i][shift][iii]jamkerjapulang',array('class'=>'span2'));
				
				$row .= CHtml::activeDropDownList($modPenjadwalanDetail, '[i][shift][iii]shift_id', isset($modDropDownShift[$modPenjadwalanDetail->pegawai_id])?$modDropDownShift[$modPenjadwalanDetail->pegawai_id]:array(),array('empty'=>'-- Pilih --','class'=>'span2'));//'onchange'=>'getShiftJam(this);',
				$row .= "</td>";								
			$tgl++;
			$a++;
			$j++;
			//isset($modDropDownShift[$modPenjadwalanDetail->pegawai_id])?$modDropDownShift[$modPenjadwalanDetail->pegawai_id]:null
			
		}
		echo $row;
	?>
	<!--akhir perulangan untuk menampilkan shift-->
</tr>
<?php // $this->renderPartial($this->path_view.'_jsFunctions',array('model'=>$model,'modPenjadwalanDetail'=>$modPenjadwalanDetail)); ?>