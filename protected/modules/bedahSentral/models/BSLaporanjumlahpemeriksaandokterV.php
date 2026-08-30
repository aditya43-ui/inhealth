<?php
/**
*       - digunakan untuk menyimpaan fungsi model dan memanggil view laporanjumlahpemeriksaandokter_v, yang digunakan hanya untuk modul bedah sentral saja saja
*       @author		M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
*       @category	model 
*       @website	<piindonesia.co.id>
*       @wiki	        <https://piiproject.atlassian.net/wiki/display/MDO>
*/

class BSLaporanjumlahpemeriksaandokterV extends LaporanjumlahpemeriksaandokterV
{      
	public $data;
	public $jumlah;
	public $tgl_awal;
	public $tgl_akhir;
	public $operasi_nama;
	public $dokterpelaksana1_id;
	public $dokteranastesi_id;
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/**
	 * - digunakan untuk menampilkan data pada tabel jumlah tindakan operasi
	 * @return \CActiveDataProvider
	 */
	public function searchTableTindakan() {
		
        $criteria = $this->functionCriteriaLapTindakan();       
		//$criteria->select = " t.tgl_tindakan, t.statusdokter, o.operasi_nama, ro.dokterpelaksana1_id, ro.dokteranastesi_id ";
		$criteria->select = " count(o.operasi_id) as jumlah, o.operasi_nama";
		$criteria->compare('LOWER(statusdokter)', strtolower(Params::STATUS_DOKTER));
		$criteria->group = "  o.operasi_nama ";
		$criteria->order = "  o.operasi_nama ASC ";
		
        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
	}
	 
	/**
	 * - digunakan untuk menampilkan data pada tabel jumlah tindakan operasi di prinout
	 * @return \CActiveDataProvider
	 */
	public function searchTableTindakanPrint()
	{
		$criteria = $this->functionCriteriaLapTindakan();       
		$criteria->select = " count(o.operasi_id) as jumlah, o.operasi_nama";
		$criteria->compare('LOWER(statusdokter)', strtolower(Params::STATUS_DOKTER));
		$criteria->group = "  o.operasi_nama ";
		$criteria->order = "  o.operasi_nama ASC ";
		$criteria->limit=-1; 

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				'pagination'=>false,
		));
	}
	
	/**
	 * - digunakan untuk menampilkan  data pada grafik
	 * @return \CActiveDataProvider
	 */
	public function searchGrafikTindakan()
	{
		$criteria = $this->functionCriteriaLapTindakan();   
		$criteria->select = " count(o.operasi_id) as jumlah, o.operasi_nama as data";
		$criteria->compare('LOWER(statusdokter)', strtolower(Params::STATUS_DOKTER));
		$criteria->group = "  data ";
		$criteria->order = "  jumlah ASC ";
		
		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
     
	/**
	 * - digunakan sebagai fungsi utama untuk melakukan pencarian
	 * @return \CDbCriteria
	 */
	protected function functionCriteriaLapTindakan() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->addBetweenCondition('tgl_tindakan', $this->tgl_awal, $this->tgl_akhir);		
		$criteria->join =	" JOIN pendaftaran_t p ON p.no_pendaftaran = t.no_pendaftaran "
						.	" JOIN rencanaoperasi_t ro ON ro.pendaftaran_id = p.pendaftaran_id "
						.	" JOIN operasi_m o ON o.operasi_id = ro.operasi_id ";
		$criteria->addCondition(" t.ruangan_id = ".Yii::app()->user->getState('ruangan_id')." ");
		
		if (!empty($this->dokterpelaksana1_id)){
			if (is_array($this->dokterpelaksana1_id)){
				$criteria->addInCondition(" ro.dokterpelaksana1_id ",$this->dokterpelaksana1_id);
			}else{
				$criteria->addCondition(" ro.dokterpelaksana1_id = '".$this->dokterpelaksana1_id."' ");
			}
		}
		
		if (!empty($this->dokteranastesi_id)){
			if (is_array($this->dokteranastesi_id)){
				$criteria->addInCondition(" ro.dokteranastesi_id ",$this->dokteranastesi_id);
			}else{
				$criteria->addCondition(" ro.dokteranastesi_id = '".$this->dokteranastesi_id."' ");
			}
		}
		
        return $criteria;
    }
	
	
	/**
	 * - digunakan untuk menampilkan data pada tabel jumlah tindakan operasi
	 * @return \CActiveDataProvider
	 */
	public function searchTableTindakanOperator() {
		
        $criteria = $this->functionCriteriaLapTindakan();       
		//$criteria->select = " t.tgl_tindakan, t.statusdokter, o.operasi_nama, ro.dokterpelaksana1_id, ro.dokteranastesi_id ";
		$criteria->select = " count(o.operasi_id) as jumlah, CONCAT(peg.gelardepan,' ',peg.nama_pegawai,' ',gb.gelarbelakang_nama) as data ";
		$criteria->join .= " LEFT JOIN  pegawai_m peg ON ro.dokterpelaksana1_id = peg.pegawai_id "
						. " LEFT JOIN gelarbelakang_m gb ON gb.gelarbelakang_id = peg.gelarbelakang_id ";		
		$criteria->addCondition(" ro.dokterpelaksana1_id IS NOT NULL ");
		$criteria->compare('LOWER(statusdokter)', strtolower(Params::STATUS_DOKTER));
		$criteria->group = "  peg.gelardepan, peg.nama_pegawai, gb.gelarbelakang_nama ";
		$criteria->order = "  data ASC ";
		
        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
	}
	 
	/**
	 * - digunakan untuk menampilkan data pada tabel jumlah tindakan operasi di prinout
	 * @return \CActiveDataProvider
	 */
	public function searchTableTindakanOperatorPrint()
	{
		$criteria = $this->functionCriteriaLapTindakan();       
		$criteria->select = " count(o.operasi_id) as jumlah, CONCAT(peg.gelardepan,' ',peg.nama_pegawai,' ',gb.gelarbelakang_nama) as data ";
		$criteria->join .= " LEFT JOIN  pegawai_m peg ON ro.dokterpelaksana1_id = peg.pegawai_id "
						. " LEFT JOIN gelarbelakang_m gb ON gb.gelarbelakang_id = peg.gelarbelakang_id ";		
		$criteria->addCondition(" ro.dokterpelaksana1_id IS NOT NULL ");
		$criteria->compare('LOWER(statusdokter)', strtolower(Params::STATUS_DOKTER));
		$criteria->group = "  peg.gelardepan, peg.nama_pegawai, gb.gelarbelakang_nama ";
		$criteria->order = "  data ASC ";
		$criteria->limit=-1; 

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				'pagination'=>false,
		));
	}
	
	/**
	 * - digunakan untuk menampilkan  data pada grafik
	 * @return \CActiveDataProvider
	 */
	public function searchGrafikTindakanOperator()
	{
		$criteria = $this->functionCriteriaLapTindakan();   
		$criteria->select = " count(o.operasi_id) as jumlah, CONCAT(peg.gelardepan,' ',peg.nama_pegawai,' ',gb.gelarbelakang_nama) as data ";
		$criteria->join .= " LEFT JOIN  pegawai_m peg ON ro.dokterpelaksana1_id = peg.pegawai_id "
						. " LEFT JOIN gelarbelakang_m gb ON gb.gelarbelakang_id = peg.gelarbelakang_id ";
		$criteria->compare('LOWER(statusdokter)', strtolower(Params::STATUS_DOKTER));
		$criteria->addCondition(" ro.dokterpelaksana1_id IS NOT NULL ");
		$criteria->group = "  peg.gelardepan, peg.nama_pegawai, gb.gelarbelakang_nama ";
		$criteria->order = "  jumlah ASC ";
		
		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
		
     
    
    /**
	 * - digunakan untuk menampilkan data pada tabel jumlah tindakan operasi anastesi
	 * @return \CActiveDataProvider
	 */
	public function searchTableTindakanAnestesi() {
		
        $criteria = $this->functionCriteriaLapTindakan();       
		//$criteria->select = " t.tgl_tindakan, t.statusdokter, o.operasi_nama, ro.dokterpelaksana1_id, ro.dokteranastesi_id ";
		$criteria->select = " count(o.operasi_id) as jumlah, CONCAT(peg.gelardepan,' ',peg.nama_pegawai,' ',gb.gelarbelakang_nama) as data ";
		$criteria->join .= " LEFT JOIN  pegawai_m peg ON ro.dokteranastesi_id = peg.pegawai_id "
						. " LEFT JOIN gelarbelakang_m gb ON gb.gelarbelakang_id = peg.gelarbelakang_id ";		
		$criteria->addCondition(" ro.dokteranastesi_id IS NOT NULL ");
		$criteria->compare('LOWER(statusdokter)', strtolower(Params::STATUS_DOKTER));
		$criteria->group = "  peg.gelardepan, peg.nama_pegawai, gb.gelarbelakang_nama ";
		$criteria->order = "  data ASC ";
		
        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
	}
	 
	/**
	 * - digunakan untuk menampilkan data pada tabel jumlah tindakan operasi di prinout
	 * @return \CActiveDataProvider
	 */
	public function searchTableTindakanAnestesiPrint()
	{
		$criteria = $this->functionCriteriaLapTindakan();       
		$criteria->select = " count(o.operasi_id) as jumlah, CONCAT(peg.gelardepan,' ',peg.nama_pegawai,' ',gb.gelarbelakang_nama) as data ";
		$criteria->join .= " LEFT JOIN  pegawai_m peg ON ro.dokteranastesi_id = peg.pegawai_id "
						. " LEFT JOIN gelarbelakang_m gb ON gb.gelarbelakang_id = peg.gelarbelakang_id ";		
		$criteria->addCondition(" ro.dokteranastesi_id IS NOT NULL ");
		$criteria->compare('LOWER(statusdokter)', strtolower(Params::STATUS_DOKTER));
		$criteria->group = "  peg.gelardepan, peg.nama_pegawai, gb.gelarbelakang_nama ";
		$criteria->order = "  data ASC ";
		$criteria->limit=-1; 

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				'pagination'=>false,
		));
	}
	
	/**
	 * - digunakan untuk menampilkan  data pada grafik
	 * @return \CActiveDataProvider
	 */
	public function searchGrafikTindakanAnestesi()
	{
		$criteria = $this->functionCriteriaLapTindakan();   
		$criteria->select = " count(o.operasi_id) as jumlah, CONCAT(peg.gelardepan,' ',peg.nama_pegawai,' ',gb.gelarbelakang_nama) as data ";
		$criteria->join .= " LEFT JOIN  pegawai_m peg ON ro.dokteranastesi_id = peg.pegawai_id "
						. " LEFT JOIN gelarbelakang_m gb ON gb.gelarbelakang_id = peg.gelarbelakang_id ";
		$criteria->compare('LOWER(statusdokter)', strtolower(Params::STATUS_DOKTER));
		$criteria->addCondition(" ro.dokteranastesi_id IS NOT NULL ");
		$criteria->group = "  peg.gelardepan, peg.nama_pegawai, gb.gelarbelakang_nama ";
		$criteria->order = "  jumlah ASC ";
		
		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}    
	
        
        
	

}