<?php

class PSPasienAdmisiT  extends PasienadmisiT
{
        public $masukkamar;
		public $kelaspelayanan_nama;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PasienadmisiT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        /**
         * Mengambil daftar semua ruangan
         * @return CActiveDataProvider 
         */
        public function getRuanganItems($instalasi_id=null)
        {
            $criteria = new CDbCriteria();
			if(!empty($instalasi_id)){
				$criteria->addCondition("instalasi_id = ".$instalasi_id); 	
			}
            $criteria->addCondition('ruangan_aktif = true');
            $criteria->order = "ruangan_nama";
            return RuanganM::model()->findAll($criteria);
        }
}