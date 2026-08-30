<?php
	$row = '';	
	$tgl = $tgl_awal;
	for ($i=0;$i<=$jumlah_hari;$i++)
	{
		// menghitung jumlah hari dalam bulan tertentu
		$tgl1 = explode('-', $tgl);
		$tahun = $tgl1[0];
		$bulan = $tgl1[1];
		$tanggal = $tgl1[2];
		// end menghitung jumlah hari dalam bulan tertentu
		$jmlhari = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
		
		if($tanggal > $jmlhari){
			$tgl = date('Y-m-01', strtotime($tgl_akhir));
		}
		
		if (isset($modHariLibur[$tgl])){
				$bg = 'red';
				$style = "color:#fff !important;'";
			}else{
				$bg = '';
				$style = "";
			}
		
		$row .= "<th class='".$bg."' style='text-align:center;".$style."'>".MyFormatter::formatDateTimeForUser($tgl)."</th>";
		$tgl++;
	}
	echo $row;
?>