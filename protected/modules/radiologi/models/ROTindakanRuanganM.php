<?php

class ROTindakanRuanganM extends TindakanruanganM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TindakankomponenT the static model class
	 */
         public $daftartindakan_kode;
         public $daftartindakan_nama;
    
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
        public function searchTindakanRuangan(){
            
            $criteria = new CDbCriteria();
            $criteria->with = array('daftartindakan');
            $criteria->addCondition("ruangan_id =".Yii::app()->user->getState('ruangan_id'));
            $criteria->compare('LOWER(daftartindakan.daftartindakan_kode)',strtolower($this->daftartindakan_kode), true);
            $criteria->compare('LOWER(daftartindakan.daftartindakan_nama)',strtolower($this->daftartindakan_nama), true);
            $criteria->limit = 10;
            return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
        }
}