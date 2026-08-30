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
		<span>
			<?php //echo isset($modPenjadwalanDetail->instalasi_nama) ? $modPenjadwalanDetail->instalasi_nama : ""; ?>/<br>
			<?php //echo isset($modPenjadwalanDetail->ruangan_nama) ? $modPenjadwalanDetail->ruangan_nama : ""; ?>
		</span>
	</td>
	<td>
		<?php echo CHtml::activeHiddenField($modPenjadwalanDetail, '[ii]pegawai_id', array('readonly'=>true,'class'=>'inputFormTabel')) ?>
		<?php echo CHtml::activeHiddenField($modPenjadwalanDetail, '[ii]ruangan_id', array('readonly'=>true,'class'=>'inputFormTabel')) ?>		
		<?php echo isset($modPenjadwalanDetail->nama_pegawai) ? $modPenjadwalanDetail->nama_pegawai : ""; ?>
	</td>
	<!--perulangan untuk menampilkan shift-->
	<?php
		$row = '';
		$shift_id = '';
		$a = 0;
		$j = 0;
		$tgl = $tgl_awal;
		for ($i=0;$i<= $jml_hari;$i++)
		{	
			if($a >= count((array)$shift)){
				$a = 0;
				$j = 0;
			}else{
				$a = $j;
			}
			
			// menghitung jumlah hari dalam bulan tertentu
			$tgl3 = explode('-', $tgl);
			$tahun = $tgl3[0];
			$bulan = $tgl3[1];
			$tanggal = $tgl3[2];
			// end menghitung jumlah hari dalam bulan tertentu
			$jmlhari = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);

			if($tanggal > $jmlhari){
				$tgl = date('Y-m-01', strtotime($tgl_akhir));;
			}
		
			$shiftkode = $shift[$a];
			$criteria = new CDbCriteria();
			$criteria->select ='t.*,shift_m.*';
			$criteria->compare('LOWER(shift_m.shift_kode)',strtolower($shiftkode));
			$criteria->join = 'JOIN shift_m ON shift_m.shift_id = t.shift_id';
			$shift_id = KPFormasishiftM::model()->find($criteria)->shift_id;
			$options = array();
			if($selectedoptions){
				$options = array($shift_id=>array('selected'=>true));
			}
			$row .= "<td>".CHtml::activeHiddenField($modPenjadwalanDetail, '[i][shift][iii]tgljadwalpegawai', array('readonly'=>true,'class'=>'inputFormTabel','value'=>$tgl)).CHtml::activeDropDownList($modPenjadwalanDetail, '[i][shift][iii]shift_id', CHtml::listData($modFormasiShift,'shift_id','shift_kode'),array('empty'=>'-- Pilih --','class'=>'span2','style'=>'width:50px;','options' => $options))."</td>";								
			$tgl++;
			$a++;
			$j++;
		}
		echo $row;
	?>
	<!--akhir perulangan untuk menampilkan shift-->
</tr>
<?php // $this->renderPartial($this->path_view.'_jsFunctions',array('model'=>$model,'modPenjadwalanDetail'=>$modPenjadwalanDetail)); ?>