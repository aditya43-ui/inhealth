<?php
/**
* - digunakan untuk memanggil view infopengajuanpetty_v, hanya untuk modul keuangan
* 
* @author       M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @website      <piindonesia.co.id>
 *@wiki         <https://piiproject.atlassian.net/wiki/display/MDO>
*/

class KUInfopengajuanpettyV extends InfopengajuanpettyV
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
		$criteria = new CDbCriteria();
		$criteria->addBetweenCondition(" DATE(pengajuanpetty_tgl) ", $this->tgl_awal, $this->tgl_akhir);
		if (!empty($this->pengajuanpetty_status)){
			$criteria->addCondition(" pengajuanpetty_status = '".$this->pengajuanpetty_status."' ");
		}
		if (!empty($this->pengajuanpetty_kategori)){
			$criteria->addCondition(" pengajuanpetty_kategori = '".$this->pengajuanpetty_kategori."' ");
		}
		
		$criteria->compare(" LOWER(pengajuanpetty_no)  ", strtolower($this->pengajuanpetty_no),true);
		
		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
        
        public function printSearchInformasi(){
		$criteria = new CDbCriteria();
		$criteria->addBetweenCondition(" DATE(pengajuanpetty_tgl) ", $this->tgl_awal, $this->tgl_akhir);
		if (!empty($this->pengajuanpetty_status)){
			$criteria->addCondition(" pengajuanpetty_status = '".$this->pengajuanpetty_status."' ");
		}
		if (!empty($this->pengajuanpetty_kategori)){
			$criteria->addCondition(" pengajuanpetty_kategori = '".$this->pengajuanpetty_kategori."' ");
		}
		
		$criteria->compare(" LOWER(pengajuanpetty_no)  ", strtolower($this->pengajuanpetty_no),true);
		
		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
                                'pagination'=>false
		));
	}
	
	
	/**
	 * - digunakan untuk mengenerate data di tabel  pengajuan anggaran operasional
	 * @return \CActiveDataProvider
	 */
	public function searchTable(){
		$criteria = $this->searchCriteria();
		//$criteria->select = " SUM(pengajuanpetty_total) as jumlah";
		//$criteria->group = " alatmedis_nama, alatmedis_harga, alatmedis_trgtbep, alatmedis_trgtbep_sat, alatmedis_hppperhari, alatmedis_id";
		$criteria->order = " t.pengajuanpetty_tgl ASC ";
		 return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}

	/**
	 * - digunakan untuk mengenerate data di tabel  pengajuan anggaran operasional
	 * @return \CActiveDataProvider
	 */
	public function searchPrint(){
		$criteria = $this->searchCriteria();
		//$criteria->select = " count(alatmedis_id) as jumlah, alatmedis_nama, alatmedis_harga, alatmedis_trgtbep, alatmedis_trgtbep_sat, alatmedis_hppperhari, alatmedis_id";
		//$criteria->group = " alatmedis_nama, alatmedis_harga, alatmedis_trgtbep, alatmedis_trgtbep_sat, alatmedis_hppperhari, alatmedis_id";
		$criteria->order = " t.pengajuanpetty_tgl ASC ";
		$criteria->limit = -1;

		 return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				'pagination' => false
		));
	}

	/**
	 * - digunakan untuk mengenerate data pengajuan anggaran operasional dalam bentuk grafik
	 * @return \CActiveDataProvider
	 */
	public function searchGrafik(){
		$criteria = $this->searchCriteria();
		$criteria->select = " SUM(t.pengajuanpetty_total) as jumlah, CONCAT(pembuat_gelardepan,' ',pembuat_nama,' ',pembuat_gelarbelakang ) as data ";
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
		$criteria->addBetweenCondition('DATE(t.pengajuanpetty_tgl)', $this->tgl_awal, $this->tgl_akhir);				
		if (!empty($this->unitkerja_id)){
			$criteria->join = " JOIN pengajuanpetty_t pp ON pp.pengajuanpetty_id = t.pengajuanpetty_id ";
			if (is_array($this->unitkerja_id)){
				$criteria->addInCondition("unitkerja_id", $this->unitkerja_id);
			}else{
				$criteria->addCondition("unitkerja_id = ".$this->unitkerja_id);
			}
		}
		$criteria->addCondition(" pengajuanpetty_status = '".Params::STATUS_PETTY_CASH_DISETUJUI."' ");
		//$criteria->
		
		return $criteria;
	}
}

?>