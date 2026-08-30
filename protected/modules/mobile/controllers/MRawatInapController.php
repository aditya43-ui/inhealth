<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MRawatJalanController
 *
 * @author programer
 */
ini_set('memory_limit', '128M');
class MRawatInapController extends Controller {
	
	
	/**
	 * action untuk mendapatkan list pasien RI
	 * 
	 * @param q, status, sort date, sort name
	 * @return array list pasien
	 * 
	 */
	public function actionGetDaftarPasien() {
		header("content-type:application/json");
        $format = new MyFormatter();
        $data = array();
        $data['is_found'] = 0;
        $data['pesan'] = "Data tidak ditemukan!";
        $data['data'] = '';
        $statusPasien = '';
		$tglPendaftaran = '';
		if (isset($_GET['q'])&&isset($_GET['status'])&&isset($_GET['tgl_pendaftaran'])) {            
            $q = strtolower($_GET['q']);
			$statusPasien = strtolower($_GET['status']);
			$tglPendaftaran =$_GET['tgl_pendaftaran'];			
			if ($statusPasien=="") 
				$statusStr='';
			else 
				$statusStr = "AND statuspasien='".$statusPasien."'";
			
			if ($tglPendaftaran=='')
				$tglPendaftaran='NOW()';
			
			$sql = "SELECT * from infokunjunganri_v 
					WHERE EXTRACT(YEAR FROM tgl_pendaftaran)=EXTRACT(YEAR FROM TIMESTAMP '$tglPendaftaran') 
					AND EXTRACT(MONTH FROM tgl_pendaftaran)=EXTRACT(MONTH FROM TIMESTAMP '$tglPendaftaran')
					AND EXTRACT(DAY FROM tgl_pendaftaran)=EXTRACT(DAY FROM TIMESTAMP '$tglPendaftaran') ".$statusStr." 
					ORDER BY tgl_pendaftaran ASC LIMIT 8";
            $loadData = Yii::app()->db->createCommand($sql)->queryAll();
            $data['data'] = $loadData;
            $n = sizeof($loadData);
            if ($n>0) {
                $data['is_found'] = 1;
                $data['pesan'] = "Data ditemukan!";    
            }
        }
        $encode = CJSON::encode($data);
        echo "jsonCallback(".$encode.")";
	} 
}
