<?php
/**
* - digunakan untuk memanggil view tariftindakanruangandetail_v, hanya untuk modul keuangan
* 
* @author       M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @website      <piindonesia.co.id>
 *@wiki         <https://piiproject.atlassian.net/wiki/display/MDO>
*/

class KUTariftindakanruangandetailV extends TariftindakanruangandetailV
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
		$criteria->limit = -1;

		 return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				'pagination' => false
		));
	}

	/**
	 * - digunakan untuk mengenerate data targer bep dalam bentuk grafik
	 * @return \CActiveDataProvider
	 */
	public function searchGrafik(){
		$criteria = $this->searchCriteria();
		$criteria->select = " count(kirimsamplelab_id) as jumlah, labklinikrujukan_nama as data ";
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
		$criteria->addBetweenCondition('DATE(tglkirimsample)', $this->tgl_awal, $this->tgl_akhir);
		$criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(no_rekam_medik)', strtolower($this->no_rekam_medik),true);
		if (!empty($this->labklinikrujukan_id)){
			if (is_array($this->labklinikrujukan_id)){
				$criteria->addInCondition("labklinikrujukan_id",$this->labklinikrujukan_id);
			}else{
				$criteria->addCondition("labklinikrujukan_id = '".$this->labklinikrujukan_id."' ");
			}
		}



		return $criteria;
	}
	
}

?>