<?php
/**
*       - digunakan untuk menyimpaan fungsi model dan memanggil view laporanrealisasidiklatinternal_v, yang digunakan hanya untuk modul kepegawaian saja
*       @author		M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
*       @website	<piindonesia.co.id>
*/


class KPLaporanrealisasidiklatinternalV extends LaporanrealisasidiklatinternalV {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
	
	/**
	 * - digunakan untuk mengenerate data di tabel  realisasi diklat internal
	 * @return \CActiveDataProvider
	 */
	public function searchTable(){
		$criteria = $this->searchCriteria();
		$criteria->select = " t.*, rd.pemateri ";
		
		 return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}

	/**
	 * - digunakan untuk mengenerate data di tabel  realisasi diklat internal
	 * @return \CActiveDataProvider
	 */
	public function searchPrint(){
		$criteria = $this->searchCriteria();
		$criteria->select = " t.*, rd.pemateri ";

		
		$criteria->limit = -1;

		 return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				'pagination' => false
		));
	}

	/**
	 * - digunakan untuk mengenerate data  realisasi diklat internal dalam bentuk grafik
	 * @return \CActiveDataProvider
	 */
	public function searchGrafik(){
		$criteria = $this->searchCriteria();
		$criteria->select = " count(t.realisasidiklat_id) as jumlah, namapelatihan as data ";
		$criteria->group = " data ";
		$criteria->order = " jumlah DESC ";
		//if ($_GET['tampilGrafik'] == 'wilayah'){

		 return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,                    
		));
	}

	/**
	 * - digunakan untuk memfilter datanya berdasarkan pencarian yang ada
	 * @return \CActiveDataProvider
	 */
	public function searchCriteria(){
		$criteria = new CDbCriteria();
		$criteria->addBetweenCondition('DATE(t.tglrealisasi)', $this->tgl_awal, $this->tgl_akhir);				
		$criteria->join = " JOIN realisasidiklat_t rd ON rd.realisasidiklat_id = t.realisasidiklat_id ";		

		return $criteria;
	}

}

?>
