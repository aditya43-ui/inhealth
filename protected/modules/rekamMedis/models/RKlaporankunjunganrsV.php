<?php
/**
* - digunakan untuk memanggil view Laporankunjunganrs_v, hanya untuk modul keuangan
* 
* @author       M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @website      <piindonesia.co.id>
 *@wiki         <https://piiproject.atlassian.net/wiki/display/MDO>
*/

class RKlaporankunjunganrsV extends LaporankunjunganrsV
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
		$criteria->select = " "			
			. "SUM(CASE WHEN instalasi_id = ".Params::INSTALASI_ID_RJ." AND jeniskelamin = '".Params::JENIS_KELAMIN_LAKI_LAKI."'  THEN 1 ELSE 0 END) as rj_l, "
			. "SUM(CASE WHEN (instalasi_id = ".Params::INSTALASI_ID_RJ." AND jeniskelamin = '".Params::JENIS_KELAMIN_PEREMPUAN."' ) THEN 1 ELSE 0 END) as rj_p, "
			. "SUM(CASE WHEN (instalasi_id = ".Params::INSTALASI_ID_RJ.") THEN 1 ELSE 0 END) as tot_rj, "
			. "SUM(CASE WHEN (instalasi_id = ".Params::INSTALASI_ID_RI." AND jeniskelamin = '".Params::JENIS_KELAMIN_LAKI_LAKI."' ) THEN 1 ELSE 0 END) as ri_l, "
			. "SUM(CASE WHEN (instalasi_id = ".Params::INSTALASI_ID_RI." AND jeniskelamin = '".Params::JENIS_KELAMIN_PEREMPUAN."' ) THEN 1 ELSE 0 END) as ri_p, "
			. "SUM(CASE WHEN (instalasi_id = ".Params::INSTALASI_ID_RI.") THEN 1 ELSE 0 END) as tot_ri ";
		//$criteria->group = " pendaftaran_id, instalasi_id, jeniskelamin";
		//$criteria->order = " tgl_pendaftaran ASC ";
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
		$criteria->select = " "			
			. "SUM(CASE WHEN instalasi_id = ".Params::INSTALASI_ID_RJ." AND jeniskelamin = '".Params::JENIS_KELAMIN_LAKI_LAKI."'  THEN 1 ELSE 0 END) as rj_l, "
			. "SUM(CASE WHEN (instalasi_id = ".Params::INSTALASI_ID_RJ." AND jeniskelamin = '".Params::JENIS_KELAMIN_PEREMPUAN."' ) THEN 1 ELSE 0 END) as rj_p, "
			. "SUM(CASE WHEN (instalasi_id = ".Params::INSTALASI_ID_RJ.") THEN 1 ELSE 0 END) as tot_rj, "
			. "SUM(CASE WHEN (instalasi_id = ".Params::INSTALASI_ID_RI." AND jeniskelamin = '".Params::JENIS_KELAMIN_LAKI_LAKI."' ) THEN 1 ELSE 0 END) as ri_l, "
			. "SUM(CASE WHEN (instalasi_id = ".Params::INSTALASI_ID_RI." AND jeniskelamin = '".Params::JENIS_KELAMIN_PEREMPUAN."' ) THEN 1 ELSE 0 END) as ri_p, "
			. "SUM(CASE WHEN (instalasi_id = ".Params::INSTALASI_ID_RI.") THEN 1 ELSE 0 END) as tot_ri ";
		//$criteria->group = " pendaftaran_id";
		//$criteria->order = " tgl_pendaftaran ASC ";
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
		$criteria->select = " count(alatmedis_id) as pendaftaran_id, '".$profil->nama_rumahsakit."' as data ";
		$criteria->group = " data ";
		$criteria->order = " jumlah DESC ";
		

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
		$criteria->addBetweenCondition('DATE(tgl_pendaftaran)', date('Y-m-01', strtotime($this->tahun.'-'.$this->bulan.'-01')), date('Y-m-t', strtotime($this->tahun.'-'.$this->bulan.'-01')));
		//$criteria->compare('LOWER(alatmedis_nama)', strtolower($this->nama_pasien),true);
		
		if (!empty($this->instalasi_id)){
			if (is_array($this->instalasi_id)){
				$criteria->addInCondition(" instalasi_id ", $this->instalasi_id);
			}else{
				$criteria->addCondition(" instalasi_id = ".$this->instalasi_id);
			}
		}
		
		if (!empty($this->ruangan_id)){
			if (is_array($this->ruangan_id)){
				$criteria->addInCondition(" ruangan_id ", $this->ruangan_id);
			}else{
				$criteria->addCondition(" ruangan_id = ".$this->ruangan_id);
			}
		}
		

		return $criteria;
	}
	
}

?>