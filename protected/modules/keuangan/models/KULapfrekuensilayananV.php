<?php
/**
* - digunakan untuk memanggil view lapfrekuensilayanan_v, hanya untuk modul keuangan
* 
* @author       M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @website      <piindonesia.co.id>
 *@wiki         <https://piiproject.atlassian.net/wiki/display/MDO>
*/

class KULapfrekuensilayananV extends LapfrekuensilayananV
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
		$criteria->select = " sum(sum) as jumlah,  (ROW_NUMBER () OVER (
	PARTITION BY ruangan_nama
	ORDER BY
	daftartindakan_nama
	)) as no, instalasi_nama, ruangan_nama, daftartindakan_nama";
		$criteria->group = "  instalasi_nama, ruangan_nama, daftartindakan_nama";
		$criteria->order = " instalasi_nama, ruangan_nama ASC, daftartindakan_nama ASC ";
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
		$criteria->select = " sum(sum) as jumlah,  (ROW_NUMBER () OVER (
		PARTITION BY ruangan_nama
		ORDER BY
		daftartindakan_nama
		)) as no, instalasi_nama, ruangan_nama, daftartindakan_nama";
			$criteria->group = "  instalasi_nama, ruangan_nama, daftartindakan_nama";
			$criteria->order = " instalasi_nama, ruangan_nama ASC, daftartindakan_nama ASC ";
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
		$criteria->select = " count(daftartindakan_id) as jumlah, instalasi_nama as data ";
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
		$criteria->addBetweenCondition('DATE(tglpembayaran)', $this->tgl_awal, $this->tgl_akhir);
		
		if (!empty($this->instalasi_id)){
			if (is_array($this->instalasi_id)){
				$criteria->addInCondition(" instalasi_id ", $this->instalasi_id);
			}else{
				$criteria->addCondition(" instalasi_id = ".$this->instalasi_id." ");
			}			
		}
		
		if (!empty($this->ruangan_id)){
			if (is_array($this->ruangan_id)){
				$criteria->addInCondition(" ruangan_id ", $this->ruangan_id);
			}else{
				$criteria->addCondition(" ruangan_id = ".$this->ruangan_id." ");
			}
			
		}
		
		$criteria->compare("LOWER(daftartindakan_nama)", strtolower($this->daftartindakan_nama), true);

		return $criteria;
	}
	
}

?>