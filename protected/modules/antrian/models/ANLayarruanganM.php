<?php

/**
 * This is the model class for table "layarruangan_m".
 *
 * The followings are the available columns in table 'layarruangan_m':
 * @property integer $ruangan_id
 * @property integer $layarantrian_id
 */
class ANLayarruanganM extends LayarruanganM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LayarruanganM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function getRuanganAntrian($modLayar){
            $criteria = new CDbCriteria();
            $criteria->compare('layarantrian_id',$modLayar->layarantrian_id);
            $criteria->limit = $modLayar->layarantrian_maksitem;
            $ruangans = LayarruanganM::model()->findAll($criteria);

            return $ruangans;
        }
        
}