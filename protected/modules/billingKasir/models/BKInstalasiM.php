<?php

class BKInstalasiM extends InstalasiM
{

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InstalasiM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        /**
         * menampilkan instalasi pelayanan RS
         * @return array
         */
        public function getInstalasiPelayanans(){
            $criteria = new CDbCriteria();
            $criteria->addInCondition('instalasi_id',array(
                        Params::INSTALASI_ID_RJ, 
                        Params::INSTALASI_ID_RD, 
                        Params::INSTALASI_ID_RI, 
                        Params::INSTALASI_ID_PERSALINAN, 
                        Params::INSTALASI_ID_ICU,
                        Params::INSTALASI_ID_REHAB, 
                        Params::INSTALASI_ID_MCU,
                        Params::INSTALASI_ID_LAB,
                        Params::INSTALASI_ID_RAD,
                        Params::INSTALASI_ID_MCU2,
                        Params::INSTALASI_ID_HEMODIALISA) 
                    );
            $criteria->addCondition('instalasi_aktif = true');
            $criteria->order = 'instalasi_id';
            $modInstalasis = InstalasiM::model()->findAll($criteria);
            if (count((array)$modInstalasis) > 0)
                return $modInstalasis;
            else
                return array();
        }

        public function getInstalasiPelayananRawat(){
            $criteria = new CDbCriteria();
            $criteria->addInCondition('instalasi_id',array(
                        Params::INSTALASI_ID_RJ, 
                        Params::INSTALASI_ID_RD, 
                        Params::INSTALASI_ID_RI, 
                        // 79, 38, 14, 85, 100
                        ) 
                    );
            $criteria->addCondition('instalasi_aktif = true');
            $criteria->order = 'instalasi_id';
            $modInstalasis = InstalasiM::model()->findAll($criteria);

            foreach ($modInstalasis as $item) {
                if ($item->instalasi_id == Params::INSTALASI_ID_RI) {
                    $item->instalasi_nama = "INSTALASI RAWAT INAP";
                }
            }

            if (count((array)$modInstalasis) > 0)
                return $modInstalasis;
            else
                return array();
        }
	/**
         * menampilkan instalasi penunjang 
         * @return array
         */
        public function getInstalasiPenunjangs(){
            $criteria = new CDbCriteria();
            $criteria->addCondition('instalasirujukaninternal = true');
            $criteria->addCondition('instalasi_aktif = true');
            $criteria->order = 'instalasi_id';
            $modInstalasis = $this->model()->findAll($criteria);
            if (count((array)$modInstalasis) > 0)
                return $modInstalasis;
            else
                return array();
        }
		
		public static function getItems(){
		$criteria = new CDbCriteria();
		$criteria->addCondition("instalasi_aktif = TRUE");
		$criteria->order = 'instalasi_nama ASC';
		return self::model()->findAll($criteria);
	}

}