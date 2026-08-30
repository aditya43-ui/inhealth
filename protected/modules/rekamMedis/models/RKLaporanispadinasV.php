<?php
/**
* - digunakan untuk memanggil view Laporanispadinas_v, hanya untuk modul rekam medis
* 
* @author       M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @website      <piindonesia.co.id>
 *@wiki         <https://piiproject.atlassian.net/wiki/display/MDO>
*/

class RKLaporanispadinasV extends LaporanispadinasV
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
		$criteria->select = ""
			. "	SUM( CASE WHEN (left(umur,2)::integer >=  1) AND (left(umur,2)::integer <  5) AND (is_mneumonia = TRUE) AND (jeniskelamin = '".Params::JENIS_KELAMIN_LAKI_LAKI."') THEN 1 ELSE 0 END ) as pneumonia_1_4_lk, 
				SUM( CASE WHEN (left(umur,2)::integer <  1) AND (is_mneumonia = TRUE) AND (jeniskelamin = '".Params::JENIS_KELAMIN_LAKI_LAKI."') THEN 1 ELSE 0 END ) as pneumonia_0_lk,
				SUM( CASE WHEN (left(umur,2)::integer >=  1) AND (left(umur,2)::integer <  5) AND (is_mneumonia = TRUE) AND (jeniskelamin = '".Params::JENIS_KELAMIN_PEREMPUAN."') THEN 1 ELSE 0 END ) as pneumonia_1_4_pr,
				SUM( CASE WHEN (left(umur,2)::integer <  1) AND (is_mneumonia = TRUE) AND (jeniskelamin = '".Params::JENIS_KELAMIN_PEREMPUAN."') THEN 1 ELSE 0 END ) as pneumonia_0_pr,
				SUM( CASE WHEN (left(umur,2)::integer <  5) AND (is_mneumonia = TRUE)  THEN 1 ELSE 0 END ) as pneumonia_5_sub,

				SUM( CASE WHEN (left(umur,2)::integer >=  1) AND (left(umur,2)::integer <  5) AND (is_mneumonia = FALSE) AND (jeniskelamin = '".Params::JENIS_KELAMIN_LAKI_LAKI."') THEN 1 ELSE 0 END ) as notpneumonia_1_4_lk, 
				SUM( CASE WHEN (left(umur,2)::integer <  1) AND (is_mneumonia = FALSE) AND (jeniskelamin = '".Params::JENIS_KELAMIN_LAKI_LAKI."') THEN 1 ELSE 0 END ) as notpneumonia_0_lk,
				SUM( CASE WHEN (left(umur,2)::integer >=  1) AND (left(umur,2)::integer <  5) AND (is_mneumonia = FALSE) AND (jeniskelamin = '".Params::JENIS_KELAMIN_PEREMPUAN."') THEN 1 ELSE 0 END ) as notpneumonia_1_4_pr,
				SUM( CASE WHEN (left(umur,2)::integer <  1) AND (is_mneumonia = FALSE) AND (jeniskelamin = '".Params::JENIS_KELAMIN_PEREMPUAN."') THEN 1 ELSE 0 END ) as notpneumonia_0_pr,
				SUM( CASE WHEN (left(umur,2)::integer <  5) AND (is_mneumonia = FALSE)  THEN 1 ELSE 0 END ) as notpneumonia_5_sub,

				SUM( CASE WHEN (left(umur,2)::integer >=  1) AND (left(umur,2)::integer <  5) AND (is_mneumonia = TRUE) AND (jeniskelamin = '".Params::JENIS_KELAMIN_LAKI_LAKI."') AND (ismeninggal = TRUE) THEN 1 ELSE 0 END ) as matipneumonia_1_4_lk, 
				SUM( CASE WHEN (left(umur,2)::integer <  1) AND (is_mneumonia = TRUE) AND (jeniskelamin = '".Params::JENIS_KELAMIN_LAKI_LAKI."') AND (ismeninggal = TRUE) THEN 1 ELSE 0 END ) as matipneumonia_0_lk,
				SUM( CASE WHEN (left(umur,2)::integer >=  1) AND (left(umur,2)::integer <  5) AND (is_mneumonia = TRUE) AND (jeniskelamin = '".Params::JENIS_KELAMIN_PEREMPUAN."') AND (ismeninggal = TRUE) THEN 1 ELSE 0 END ) as matipneumonia_1_4_pr,
				SUM( CASE WHEN (left(umur,2)::integer <  1) AND (is_mneumonia = TRUE) AND (jeniskelamin = '".Params::JENIS_KELAMIN_PEREMPUAN."') AND (ismeninggal = TRUE) THEN 1 ELSE 0 END ) as matipneumonia_0_pr,
				SUM( CASE WHEN (left(umur,2)::integer <  5) AND (is_mneumonia = TRUE) AND (ismeninggal = TRUE)  THEN 1 ELSE 0 END ) as matipneumonia_5_sub,

				SUM( CASE WHEN (left(umur,2)::integer >=  5) AND (is_mneumonia = TRUE) AND (jeniskelamin = '".Params::JENIS_KELAMIN_LAKI_LAKI."') THEN 1 ELSE 0 END ) as pneumonia_5_lk,     
				SUM( CASE WHEN (left(umur,2)::integer >=  5) AND (is_mneumonia = TRUE) AND (jeniskelamin = '".Params::JENIS_KELAMIN_PEREMPUAN."') THEN 1 ELSE 0 END ) as pneumonia_5_pr, 
				SUM( CASE WHEN (left(umur,2)::integer >=  5) AND (is_mneumonia = FALSE) AND (jeniskelamin = '".Params::JENIS_KELAMIN_LAKI_LAKI."') THEN 1 ELSE 0 END ) as notpneumonia_5_lk,     
				SUM( CASE WHEN (left(umur,2)::integer >=  5) AND (is_mneumonia = FALSE) AND (jeniskelamin = '".Params::JENIS_KELAMIN_PEREMPUAN."') THEN 1 ELSE 0 END ) as notpneumonia_5_pr, 
				SUM( CASE WHEN (left(umur,2)::integer >=  5) THEN 1 ELSE 0 END ) as subpneumonia_5"
			. "";
		//$criteria->group = " namars";
		//$criteria->order = " namars ASC ";
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
		$criteria->select = ""
			. "	SUM( CASE WHEN (left(umur,2)::integer >=  1) AND (left(umur,2)::integer <  5) AND (is_mneumonia = TRUE) AND (jeniskelamin = '".Params::JENIS_KELAMIN_LAKI_LAKI."') THEN 1 ELSE 0 END ) as pneumonia_1_4_lk, 
				SUM( CASE WHEN (left(umur,2)::integer <  1) AND (is_mneumonia = TRUE) AND (jeniskelamin = '".Params::JENIS_KELAMIN_LAKI_LAKI."') THEN 1 ELSE 0 END ) as pneumonia_0_lk,
				SUM( CASE WHEN (left(umur,2)::integer >=  1) AND (left(umur,2)::integer <  5) AND (is_mneumonia = TRUE) AND (jeniskelamin = '".Params::JENIS_KELAMIN_PEREMPUAN."') THEN 1 ELSE 0 END ) as pneumonia_1_4_pr,
				SUM( CASE WHEN (left(umur,2)::integer <  1) AND (is_mneumonia = TRUE) AND (jeniskelamin = '".Params::JENIS_KELAMIN_PEREMPUAN."') THEN 1 ELSE 0 END ) as pneumonia_0_pr,
				SUM( CASE WHEN (left(umur,2)::integer <  5) AND (is_mneumonia = TRUE)  THEN 1 ELSE 0 END ) as pneumonia_5_sub,

				SUM( CASE WHEN (left(umur,2)::integer >=  1) AND (left(umur,2)::integer <  5) AND (is_mneumonia = FALSE) AND (jeniskelamin = '".Params::JENIS_KELAMIN_LAKI_LAKI."') THEN 1 ELSE 0 END ) as notpneumonia_1_4_lk, 
				SUM( CASE WHEN (left(umur,2)::integer <  1) AND (is_mneumonia = FALSE) AND (jeniskelamin = '".Params::JENIS_KELAMIN_LAKI_LAKI."') THEN 1 ELSE 0 END ) as notpneumonia_0_lk,
				SUM( CASE WHEN (left(umur,2)::integer >=  1) AND (left(umur,2)::integer <  5) AND (is_mneumonia = FALSE) AND (jeniskelamin = '".Params::JENIS_KELAMIN_PEREMPUAN."') THEN 1 ELSE 0 END ) as notpneumonia_1_4_pr,
				SUM( CASE WHEN (left(umur,2)::integer <  1) AND (is_mneumonia = FALSE) AND (jeniskelamin = '".Params::JENIS_KELAMIN_PEREMPUAN."') THEN 1 ELSE 0 END ) as notpneumonia_0_pr,
				SUM( CASE WHEN (left(umur,2)::integer <  5) AND (is_mneumonia = FALSE)  THEN 1 ELSE 0 END ) as notpneumonia_5_sub,

				SUM( CASE WHEN (left(umur,2)::integer >=  1) AND (left(umur,2)::integer <  5) AND (is_mneumonia = TRUE) AND (jeniskelamin = '".Params::JENIS_KELAMIN_LAKI_LAKI."') AND (ismeninggal = TRUE) THEN 1 ELSE 0 END ) as matipneumonia_1_4_lk, 
				SUM( CASE WHEN (left(umur,2)::integer <  1) AND (is_mneumonia = TRUE) AND (jeniskelamin = '".Params::JENIS_KELAMIN_LAKI_LAKI."') AND (ismeninggal = TRUE) THEN 1 ELSE 0 END ) as matipneumonia_0_lk,
				SUM( CASE WHEN (left(umur,2)::integer >=  1) AND (left(umur,2)::integer <  5) AND (is_mneumonia = TRUE) AND (jeniskelamin = '".Params::JENIS_KELAMIN_PEREMPUAN."') AND (ismeninggal = TRUE) THEN 1 ELSE 0 END ) as matipneumonia_1_4_pr,
				SUM( CASE WHEN (left(umur,2)::integer <  1) AND (is_mneumonia = TRUE) AND (jeniskelamin = '".Params::JENIS_KELAMIN_PEREMPUAN."') AND (ismeninggal = TRUE) THEN 1 ELSE 0 END ) as matipneumonia_0_pr,
				SUM( CASE WHEN (left(umur,2)::integer <  5) AND (is_mneumonia = TRUE) AND (ismeninggal = TRUE)  THEN 1 ELSE 0 END ) as matipneumonia_5_sub,

				SUM( CASE WHEN (left(umur,2)::integer >=  5) AND (is_mneumonia = TRUE) AND (jeniskelamin = '".Params::JENIS_KELAMIN_LAKI_LAKI."') THEN 1 ELSE 0 END ) as pneumonia_5_lk,     
				SUM( CASE WHEN (left(umur,2)::integer >=  5) AND (is_mneumonia = TRUE) AND (jeniskelamin = '".Params::JENIS_KELAMIN_PEREMPUAN."') THEN 1 ELSE 0 END ) as pneumonia_5_pr, 
				SUM( CASE WHEN (left(umur,2)::integer >=  5) AND (is_mneumonia = FALSE) AND (jeniskelamin = '".Params::JENIS_KELAMIN_LAKI_LAKI."') THEN 1 ELSE 0 END ) as notpneumonia_5_lk,     
				SUM( CASE WHEN (left(umur,2)::integer >=  5) AND (is_mneumonia = FALSE) AND (jeniskelamin = '".Params::JENIS_KELAMIN_PEREMPUAN."') THEN 1 ELSE 0 END ) as notpneumonia_5_pr, 
				SUM( CASE WHEN (left(umur,2)::integer >=  5) THEN 1 ELSE 0 END ) as subpneumonia_5"
			. "";
		//$criteria->group = " namars";
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
		
		$criteria->addCondition(" tahun = ".$this->tahun);
		$criteria->addCondition(" bulan = ".$this->bulan);
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