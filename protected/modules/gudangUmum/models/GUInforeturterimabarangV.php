<?php
/**
* - digunakan untuk memanggil view Inforeturterimabarang_v, hanya untuk modul gudang umum
* 
* @author       M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @website      <piindonesia.co.id>
 *@wiki         <https://piiproject.atlassian.net/wiki/display/MDO>
*/

class GUInforeturterimabarangV extends InforeturterimabarangV
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
	public function searchInformasi(){
		$criteria = $this->searchCriteria();
		$criteria->order = " tglreturterima ASC ";		
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
		$criteria->addBetweenCondition('DATE(tglreturterima)', $this->tgl_awal, $this->tgl_akhir);
		$criteria->compare('LOWER(noreturterima)', strtolower($this->noreturterima),true);
		$criteria->compare('LOWER(nopenerimaan)', strtolower($this->nopenerimaan),true);
		if (!empty($this->supplier_id)){
			$criteria->addCondition(" supplier_id = ".$this->supplier_id." ");
		}
		if (!empty($this->pegretur_id)){
			$criteria->addCondition(" pegretur_id = ".$this->pegretur_id." ");
		}
		

		return $criteria;
	}
	
}

?>