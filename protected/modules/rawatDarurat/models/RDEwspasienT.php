<?php

class RDEwspasienT extends EwspasienT
{
    public $is_jenisews;
    
    /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AnamnesaT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function searchRiwayat($pendaftaran_id)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                $criteria->addCondition('pendaftaran_id ='.$pendaftaran_id);
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function getPegawaiPengkajiItems(){
            
           $criteria = new CDbCriteria();
           $criteria->addCondition('ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
           return PegawairuanganV::model()->findAll($criteria);
        }

}