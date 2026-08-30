<?php

/**
 * This is the model class for table "profilrumahsakit_m".
 *
 * The followings are the available columns in table 'profilrumahsakit_m':
 * @property integer $profilrs_id
 * @property string $tahunprofilrs
 * @property string $kodejenisrs_profilrs
 * @property string $jenisrs_profilrs
 * @property string $statusrsswasta
 * @property string $namakepemilikanrs
 * @property integer $kodestatuskepemilikanrs
 * @property string $statuskepemilikanrs
 * @property string $pentahapanakreditasrs
 * @property string $statusakreditasrs
 * @property string $nokode_rumahsakit
 * @property string $nama_rumahsakit
 * @property string $kelas_rumahsakit
 * @property string $namadirektur_rumahsakit
 * @property string $alamatlokasi_rumahsakit
 * @property string $nomor_suratizin
 * @property string $tgl_suratizin
 * @property string $oleh_suratizin
 * @property string $sifat_suratizin
 * @property string $masaberlakutahun_suratizin
 * @property string $motto
 * @property string $visi
 * @property string $no_faksimili
 * @property string $logo_rumahsakit
 * @property string $path_logorumahsakit
 * @property string $npwp
 * @property string $tahun_diresmikan
 * @property string $nama_kepemilikanrs
 * @property string $status_kepemilikanrs
 * @property string $khususuntukswasta
 * @property string $website
 * @property string $email
 * @property string $no_telp_profilrs
 */
class SAProfilRumahSakitM extends ProfilrumahsakitM
{

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ProfilrumahsakitM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	
        /**
         * Mengambil daftar semua propinsi
         * @return CActiveDataProvider 
         */
        public function getPropinsiItems()
        {
            return PropinsiM::model()->findAllByAttributes(array('propinsi_aktif'=>true),array('order'=>'propinsi_nama'));
        }
        /**
         * Mengambil daftar semua kabupaten berdasarkan propinsi
         * @return CActiveDataProvider 
         */
        public function getKabupatenItems($propinsi_id=null)
        {
            $criteria = new CDbCriteria();
			if(!empty($propinsi_id)){
				$criteria->addCondition("propinsi_id = ".$propinsi_id); 			
			}
            $criteria->compare('kabupaten_aktif', true);
            $criteria->order='kabupaten_nama';
            $models = KabupatenM::model()->findAll($criteria);
            return $models;
        }
        /**
         * Mengambil daftar semua kecamatan berdasarkan kabupaten
         * @return CActiveDataProvider 
         */
        public function getKecamatanItems($kabupaten_id=null)
        {
            $criteria = new CDbCriteria();
			if(!empty($kabupaten_id)){
				$criteria->addCondition("kabupaten_id = ".$kabupaten_id); 			
			}
            $criteria->compare('kecamatan_aktif', true);
            $criteria->order='kecamatan_nama';
            $models = KecamatanM::model()->findAll($criteria);
            return $models;
        }
        /**
         * Mengambil daftar semua kelurahan berdasarkan kecamatan
         * @return CActiveDataProvider 
         */
        public function getKelurahanItems($kecamatan_id=null)
        {
            $criteria = new CDbCriteria();
			if(!empty($kecamatan_id)){
				$criteria->addCondition("kecamatan_id = ".$kecamatan_id); 			
			}
            $criteria->compare('kelurahan_aktif', true);
            $criteria->order='kelurahan_nama';
            $models = KelurahanM::model()->findAll($criteria);
            return $models;
        }

}