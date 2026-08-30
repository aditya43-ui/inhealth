<?php
class RIUnitdosisT extends UnitdosisT
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

        public function getDokterItems($ruangan_id='')
        {
            $ruangan_id = Yii::app()->user->getState('ruangan_id');
            if(!empty($ruangan_id))
                return DokterV::model()->findAllByAttributes(array('ruangan_id'=>$ruangan_id));
            else
                return array();
        }
        
        public function getApotekRawatJalan()
        {
            return RuanganM::model()->findAllByAttributes(array('instalasi_id'=>Params::INSTALASI_ID_FARMASI));
        }
}
?>