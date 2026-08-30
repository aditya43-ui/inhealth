<?php
/**
* - digunakan untuk memanggil view Laporanbayarankesupplier_v, hanya untuk modul keuangan
* 
* @author       M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @website      <piindonesia.co.id>
 *@wiki         <https://piiproject.atlassian.net/wiki/display/MDO>
*/

class KULaporanbayarankesupplierV extends LaporanbayarankesupplierV
{
	public $sisatagihan;
	public $data;
	public $jumlah;
	public $tgl_awal;
	public $tgl_akhir;
	public $sisahutang;
	public $supplier_jenis;


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
		$criteria->select =  " t.*, ( (CASE WHEN (totaltagihan-jmldibayarkan) < 0 THEN 0 ELSE totaltagihan-jmldibayarkan END ) )as sisahutang ";
		//$criteria->select = " count(alatmedis_id) as jumlah, alatmedis_nama, alatmedis_harga, alatmedis_trgtbep, alatmedis_trgtbep_sat, alatmedis_hppperhari, alatmedis_id";
		//$criteria->group = " alatmedis_nama, alatmedis_harga, alatmedis_trgtbep, alatmedis_trgtbep_sat, alatmedis_hppperhari, alatmedis_id";
		$criteria->order = " tglkaskeluar ASC ";
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
		$criteria->select =  " t.*, ( (CASE WHEN (totaltagihan-jmldibayarkan) < 0 THEN 0 ELSE totaltagihan-jmldibayarkan END ) )as sisahutang ";
		//$criteria->select = " count(alatmedis_id) as jumlah, alatmedis_nama, alatmedis_harga, alatmedis_trgtbep, alatmedis_trgtbep_sat, alatmedis_hppperhari, alatmedis_id";
		//$criteria->group = " alatmedis_nama, alatmedis_harga, alatmedis_trgtbep, alatmedis_trgtbep_sat, alatmedis_hppperhari, alatmedis_id";
		$criteria->order = " tglkaskeluar ASC ";
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
		$criteria->select = " sum(jmldibayarkan) as jumlah, supplier_nama as data ";
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
		$criteria->addBetweenCondition('DATE(tglkaskeluar)', $this->tgl_awal, $this->tgl_akhir);
		//$criteria->compare('LOWER(alatmedis_nama)', strtolower($this->nama_pasien),true);
		
		if (!empty($this->supplier_id)){
			if (is_array($this->supplier_id)){
				$criteria->addInCondition("supplier_id", $this->supplier_id);
			}else{
				$criteria->addCondition("supplier_id =".$this->supplier_id);
			}
		}
		
		if (!empty($this->supplier_jenis)){
			if (is_array($this->supplier_jenis)){
				$criteria->addInCondition("LOWER(is_bahanmakan)", $this->supplier_jenis);
			}else{
				$criteria->addCondition("LOWER(is_bahanmakan) =".strtolower($this->supplier_jenis));
			}
		}
		

		return $criteria;
	}
	
}

?>