<?php
/**
 * Digunakan untuk mengekstend model suratketerangan_r
 * @author  Andyka <andykaputra@.com>
 * @website	   <.com>
 * @package application.modules.rekamMedis
 * @subpackage models
 */
class EKSuratketeranganR extends SuratketeranganR
{
        public $lama_istirahat,$lab_rad,$pukul_lahir,$lahir_propinsi, $tinggibadan, $beratbadan, $tekanandarah_sistolok, 
                $tekanandarah_diastolik, $dokter, $jabatan, $sip, $pekerjaan, $tempat;
        
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        /**
         * Mengambil daftar semua dokter ruangan
         * @return CActiveDataProvider 
         */
        public function getDokterItems()
        {
            return DokterV::model()->findAllByAttributes(array('ruangan_id'=>Yii::app()->user->getState('ruangan_id')),array('order'=>'nama_pegawai DESC'));
        }
}
?>