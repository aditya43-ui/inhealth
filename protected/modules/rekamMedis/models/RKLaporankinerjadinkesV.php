<?php
/**
* - digunakan untuk memanggil view laporankinerjadinkes_v, hanya untuk modul rekam medis
* 
* @author       M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @website      <piindonesia.co.id>
 *@wiki         <https://piiproject.atlassian.net/wiki/display/MDO>
*/

class RKLaporankinerjadinkesV extends LaporankinerjadinkesV
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
		$criteria->select = "(SELECT count(kamarruangan_id) FROM kamarruangan_m WHERE kamarruangan_aktif = TRUE) as jumlah_kamar, namars , sum(pasien_keluar) as pasien_keluar, sum(hariperawatan) as hariperawatan, sum(lamadirawat) as lamadirawat";
		$criteria->group = " namars";
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
		$criteria->select = "(SELECT count(kamarruangan_id) FROM kamarruangan_m WHERE kamarruangan_aktif = TRUE) as jumlah_kamar, namars , sum(pasien_keluar) as pasien_keluar, sum(hariperawatan) as hariperawatan, sum(lamadirawat) as lamadirawat";
		$criteria->group = " namars";
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
		$criteria->addCondition( "bulan = ".$this->bulan);
		//$criteria->compare('LOWER(alatmedis_nama)', strtolower($this->nama_pasien),true);
		

		return $criteria;
	}
	
	public function getFooter($tipe){
		
		$criteria = $this->searchCriteria();
		$criteria->select = "(SELECT count(kamarruangan_id) FROM kamarruangan_m WHERE kamarruangan_aktif = TRUE) as jumlah_kamar, namars , sum(pasien_keluar) as pasien_keluar, sum(hariperawatan) as hariperawatan, sum(lamadirawat) as lamadirawat";		
		$criteria->group = " namars ";
		$bor = RKLaporankinerjadinkesV::model()->findAll($criteria);
		
		if (count((array)$bor)>0){		
			$harirawat = 0;
			$jmlkamar = 0;
			$jumlah_keluar = 0;
			foreach($bor as $dt){
				$harirawat = $harirawat + $dt->hariperawatan;
				$jumlah_keluar = $jumlah_keluar + $dt->pasien_keluar;
				$jmlkamar = $dt->jumlah_kamar;
			}

			if ($tipe == 'bor'){
				if ($jmlkamar != 0){
					return number_format((($harirawat / ($jmlkamar*365)) * 100),2,",","");
				}else{
					return 0;
				}
			}elseif($tipe == 'bto'){
				if ($jmlkamar != 0){
					return number_format(($jumlah_keluar / $jmlkamar),2,",","");
				}else{
					return 0;
				}
			}elseif($tipe == 'toi'){
				if ($jumlah_keluar != 0){
					return number_format(((($jmlkamar*365)-$harirawat)/$jumlah_keluar),2,",","");
				}else{
					return 0;
				}
			}elseif($tipe == 'alos'){
				if ($jumlah_keluar != 0){
					return number_format(($harirawat/$jumlah_keluar),2,",","");
				}else{
					return 0;
				}
			}						
		}else{
			return 0;
		}
	}
	
}

?>