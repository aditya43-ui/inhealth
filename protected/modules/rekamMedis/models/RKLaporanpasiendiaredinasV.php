<?php
/**
* - digunakan untuk memanggil view Laporanpasiendiaredinas_v, hanya untuk modul rekam medis
* 
* @author       M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @website      <piindonesia.co.id>
 *@wiki         <https://piiproject.atlassian.net/wiki/display/MDO>
*/

class RKLaporanpasiendiaredinasV extends LaporanpasiendiaredinasV
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
			. "	SUM( CASE WHEN (left(umur,2)::integer <=  0) AND ((substr(umur,8,2)::integer >= 0 ) AND (substr(umur,8,2)::integer <= 5 ) )AND (jeniskelamin = '".Params::JENIS_KELAMIN_LAKI_LAKI."') THEN 1 ELSE 0 END ) as diare_0_5_bln_lk,
				SUM( CASE WHEN (left(umur,2)::integer <=  0) AND ((substr(umur,8,2)::integer >= 0 ) AND (substr(umur,8,2)::integer <= 5 ) )AND (jeniskelamin = '".Params::JENIS_KELAMIN_PEREMPUAN."') THEN 1 ELSE 0 END ) as diare_0_5_bln_pr,
				SUM( CASE WHEN 
					( (left(umur,2)::integer =  0) AND ((substr(umur,8,2)::integer >= 6 ) AND (substr(umur,8,2)::integer <= 12 ) )  AND (jeniskelamin = '".Params::JENIS_KELAMIN_LAKI_LAKI."') ) OR
					( (left(umur,2)::integer =  1) AND ((substr(umur,8,2)::integer >= 0 ) AND (substr(umur,8,2)::integer <= 12 ) ) AND (jeniskelamin = '".Params::JENIS_KELAMIN_LAKI_LAKI."' ) )
					THEN 1 ELSE 0 END ) as diare_6_12_bln_lk,
				SUM( CASE WHEN 
					( (left(umur,2)::integer =  0) AND ((substr(umur,8,2)::integer >= 6 ) AND (substr(umur,8,2)::integer <= 12 ) ) AND (jeniskelamin = '".Params::JENIS_KELAMIN_PEREMPUAN."') ) OR
					( (left(umur,2)::integer =  1) AND ((substr(umur,8,2)::integer >= 0 ) AND (substr(umur,8,2)::integer <= 12 ) ) AND (jeniskelamin = '".Params::JENIS_KELAMIN_PEREMPUAN."')) THEN 1 ELSE 0 END )
					 as diare_6_12_bln_pr,
				SUM( CASE WHEN ( ((left(umur,2)::integer >= 2 ) AND (left(umur,2)::integer <= 4 )) AND (jeniskelamin = '".Params::JENIS_KELAMIN_LAKI_LAKI."')) THEN 1 ELSE 0 END ) as diare_2_4_th_lk,
				SUM( CASE WHEN ( ((left(umur,2)::integer >= 2 ) AND (left(umur,2)::integer <= 4 )) AND (jeniskelamin = '".Params::JENIS_KELAMIN_PEREMPUAN."')) THEN 1 ELSE 0 END ) as diare_2_4_th_pr,
				SUM( CASE WHEN ( ((left(umur,2)::integer >= 5 ) AND (left(umur,2)::integer <= 9 )) AND (jeniskelamin = '".Params::JENIS_KELAMIN_LAKI_LAKI."')) THEN 1 ELSE 0 END ) as diare_5_9_th_lk,
				SUM( CASE WHEN ( ((left(umur,2)::integer >= 5 ) AND (left(umur,2)::integer <= 9 )) AND (jeniskelamin = '".Params::JENIS_KELAMIN_PEREMPUAN."')) THEN 1 ELSE 0 END ) as diare_5_9_th_pr,
				SUM( CASE WHEN ( ((left(umur,2)::integer >= 10 ) AND (left(umur,2)::integer <= 14 )) AND (jeniskelamin = '".Params::JENIS_KELAMIN_LAKI_LAKI."')) THEN 1 ELSE 0 END ) as diare_10_14_th_lk,
				SUM( CASE WHEN ( ((left(umur,2)::integer >= 10 ) AND (left(umur,2)::integer <= 14 )) AND (jeniskelamin = '".Params::JENIS_KELAMIN_PEREMPUAN."')) THEN 1 ELSE 0 END ) as diare_10_14_th_pr,
				SUM( CASE WHEN ( ((left(umur,2)::integer >= 15 ) AND (left(umur,2)::integer <= 19 )) AND (jeniskelamin = '".Params::JENIS_KELAMIN_LAKI_LAKI."')) THEN 1 ELSE 0 END ) as diare_15_19_th_lk,
				SUM( CASE WHEN ( ((left(umur,2)::integer >= 15 ) AND (left(umur,2)::integer <= 19 )) AND (jeniskelamin = '".Params::JENIS_KELAMIN_PEREMPUAN."')) THEN 1 ELSE 0 END ) as diare_15_19_th_pr,
				SUM( CASE WHEN ( ((left(umur,2)::integer >= 20 ) ) AND (jeniskelamin = '".Params::JENIS_KELAMIN_LAKI_LAKI."')) THEN 1 ELSE 0 END ) as diare_20_th_lk,
				SUM( CASE WHEN ( ((left(umur,2)::integer >= 20 ) ) AND (jeniskelamin = '".Params::JENIS_KELAMIN_PEREMPUAN."')) THEN 1 ELSE 0 END ) as diare_20_th_pr,
				SUM( CASE WHEN ( (jeniskelamin = '".Params::JENIS_KELAMIN_LAKI_LAKI."')) THEN 1 ELSE 0 END ) as diare_tot_lk,
				SUM( CASE WHEN ( (jeniskelamin = '".Params::JENIS_KELAMIN_PEREMPUAN."')) THEN 1 ELSE 0 END ) as diare_tot_pr"
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
			. "		SUM( CASE WHEN (left(umur,2)::integer <=  0) AND ((substr(umur,8,2)::integer >= 0 ) AND (substr(umur,8,2)::integer <= 5 ) )AND (jeniskelamin = '".Params::JENIS_KELAMIN_LAKI_LAKI."') THEN 1 ELSE 0 END ) as diare_0_5_bln_lk,
					SUM( CASE WHEN (left(umur,2)::integer <=  0) AND ((substr(umur,8,2)::integer >= 0 ) AND (substr(umur,8,2)::integer <= 5 ) )AND (jeniskelamin = '".Params::JENIS_KELAMIN_PEREMPUAN."') THEN 1 ELSE 0 END ) as diare_0_5_bln_pr,
					SUM( CASE WHEN 
						( (left(umur,2)::integer =  0) AND ((substr(umur,8,2)::integer >= 6 ) AND (substr(umur,8,2)::integer <= 12 ) )  AND (jeniskelamin = '".Params::JENIS_KELAMIN_LAKI_LAKI."') ) OR
						( (left(umur,2)::integer =  1) AND ((substr(umur,8,2)::integer >= 0 ) AND (substr(umur,8,2)::integer <= 12 ) ) AND (jeniskelamin = '".Params::JENIS_KELAMIN_LAKI_LAKI."' ) )
						THEN 1 ELSE 0 END ) as diare_6_12_bln_lk,
					SUM( CASE WHEN 
						( (left(umur,2)::integer =  0) AND ((substr(umur,8,2)::integer >= 6 ) AND (substr(umur,8,2)::integer <= 12 ) ) AND (jeniskelamin = '".Params::JENIS_KELAMIN_PEREMPUAN."') ) OR
						( (left(umur,2)::integer =  1) AND ((substr(umur,8,2)::integer >= 0 ) AND (substr(umur,8,2)::integer <= 12 ) ) AND (jeniskelamin = '".Params::JENIS_KELAMIN_PEREMPUAN."')) THEN 1 ELSE 0 END )
						 as diare_6_12_bln_pr,
					SUM( CASE WHEN ( ((left(umur,2)::integer >= 2 ) AND (left(umur,2)::integer <= 4 )) AND (jeniskelamin = '".Params::JENIS_KELAMIN_LAKI_LAKI."')) THEN 1 ELSE 0 END ) as diare_2_4_th_lk,
					SUM( CASE WHEN ( ((left(umur,2)::integer >= 2 ) AND (left(umur,2)::integer <= 4 )) AND (jeniskelamin = '".Params::JENIS_KELAMIN_PEREMPUAN."')) THEN 1 ELSE 0 END ) as diare_2_4_th_pr,
					SUM( CASE WHEN ( ((left(umur,2)::integer >= 5 ) AND (left(umur,2)::integer <= 9 )) AND (jeniskelamin = '".Params::JENIS_KELAMIN_LAKI_LAKI."')) THEN 1 ELSE 0 END ) as diare_5_9_th_lk,
					SUM( CASE WHEN ( ((left(umur,2)::integer >= 5 ) AND (left(umur,2)::integer <= 9 )) AND (jeniskelamin = '".Params::JENIS_KELAMIN_PEREMPUAN."')) THEN 1 ELSE 0 END ) as diare_5_9_th_pr,
					SUM( CASE WHEN ( ((left(umur,2)::integer >= 10 ) AND (left(umur,2)::integer <= 14 )) AND (jeniskelamin = '".Params::JENIS_KELAMIN_LAKI_LAKI."')) THEN 1 ELSE 0 END ) as diare_10_14_th_lk,
					SUM( CASE WHEN ( ((left(umur,2)::integer >= 10 ) AND (left(umur,2)::integer <= 14 )) AND (jeniskelamin = '".Params::JENIS_KELAMIN_PEREMPUAN."')) THEN 1 ELSE 0 END ) as diare_10_14_th_pr,
					SUM( CASE WHEN ( ((left(umur,2)::integer >= 15 ) AND (left(umur,2)::integer <= 19 )) AND (jeniskelamin = '".Params::JENIS_KELAMIN_LAKI_LAKI."')) THEN 1 ELSE 0 END ) as diare_15_19_th_lk,
					SUM( CASE WHEN ( ((left(umur,2)::integer >= 15 ) AND (left(umur,2)::integer <= 19 )) AND (jeniskelamin = '".Params::JENIS_KELAMIN_PEREMPUAN."')) THEN 1 ELSE 0 END ) as diare_15_19_th_pr,
					SUM( CASE WHEN ( ((left(umur,2)::integer >= 20 ) ) AND (jeniskelamin = '".Params::JENIS_KELAMIN_LAKI_LAKI."')) THEN 1 ELSE 0 END ) as diare_20_th_lk,
					SUM( CASE WHEN ( ((left(umur,2)::integer >= 20 ) ) AND (jeniskelamin = '".Params::JENIS_KELAMIN_PEREMPUAN."')) THEN 1 ELSE 0 END ) as diare_20_th_pr,
					SUM( CASE WHEN ( (jeniskelamin = '".Params::JENIS_KELAMIN_LAKI_LAKI."')) THEN 1 ELSE 0 END ) as diare_tot_lk,
					SUM( CASE WHEN ( (jeniskelamin = '".Params::JENIS_KELAMIN_PEREMPUAN."')) THEN 1 ELSE 0 END ) as diare_tot_pr"
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