<?php
/**
* - digunakan untuk memanggil view laporanpakaialatmedis_v, hanya untuk modul keuangan
* 
* @author       M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @website      <piindonesia.co.id>
 *@wiki         <https://piiproject.atlassian.net/wiki/display/MDO>
*/

class KULaporanpakaialatmedisV extends LaporanpakaialatmedisV
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BankM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * - digunakan untuk mengenerate data di tabel  target bep
	 * @return \CActiveDataProvider
	 */
	public function searchTable(){
		$criteria = $this->searchCriteria();
		$criteria->select = " count(alatmedis_id) as jumlah, alatmedis_nama, alatmedis_harga, alatmedis_trgtbep, alatmedis_trgtbep_sat, alatmedis_hppperhari, alatmedis_id";
		$criteria->group = " alatmedis_nama, alatmedis_harga, alatmedis_trgtbep, alatmedis_trgtbep_sat, alatmedis_hppperhari, alatmedis_id";
		$criteria->order = " alatmedis_nama ASC ";
		 return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}

	/**
	 * - digunakan untuk mengenerate data di tabel  target bep  pada prinout
	 * @return \CActiveDataProvider
	 */
	public function searchPrint(){
		$criteria = $this->searchCriteria();
		$criteria->select = " count(alatmedis_id) as jumlah, alatmedis_nama, alatmedis_harga, alatmedis_trgtbep, alatmedis_trgtbep_sat, alatmedis_hppperhari, alatmedis_id";
		$criteria->group = " alatmedis_nama, alatmedis_harga, alatmedis_trgtbep, alatmedis_trgtbep_sat, alatmedis_hppperhari, alatmedis_id";
		$criteria->order = " alatmedis_nama ASC ";
		$criteria->limit = -1;

		 return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				'pagination' => false
		));
	}

	/**
	 * - digunakan untuk mengenerate data target bep dalam bentuk grafik
	 * @return \CActiveDataProvider
	 */
	public function searchGrafik(){
		$criteria = $this->searchCriteria();
		$criteria->select = " count(alatmedis_id) as jumlah, alatmedis_nama as data ";
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
		$criteria->addBetweenCondition('DATE(tgl_tindakan)', $this->tgl_awal, $this->tgl_akhir);
		$criteria->compare('LOWER(alatmedis_nama)', strtolower($this->nama_pasien),true);
		

		return $criteria;
	}
	
}

?>