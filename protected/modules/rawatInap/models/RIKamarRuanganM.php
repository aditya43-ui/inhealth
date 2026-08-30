<?php

/**
 * This is the model class for table "kamarruangan_m".
 *
 * The followings are the available columns in table 'kamarruangan_m':
 * @property integer $kamarruangan_id
 * @property integer $kelaspelayanan_id
 * @property integer $ruangan_id
 * @property string $kamarruangan_nokamar
 * @property integer $kamarruangan_jmlbed
 * @property string $kamarruangan_nobed
 * @property boolean $kamarruangan_status
 * @property boolean $kamarruangan_aktif
 * @property integer $riwayatruangan_id
 * @property string $kamarruangan_image
 */
class RIKamarRuanganM extends KamarruanganM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KamarruanganM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getKelasPelayananRuanganItems()
        {
            return RIKamarRuanganM::model()->with('kelaspelayanan')->findAll('t.ruangan_id='.Yii::app()->user->getState('ruangan_id').'');
        }
        
        public function getKamarNoKamarItems()
        {
            return RIKamarRuanganM::model()->with('ruangan')->findAll('t.ruangan_id='.Yii::app()->user->getState('ruangan_id').'');
          
        }  
}