<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PPTindakanruanganM
 *
 * @author sujana
 */
class PPTindakanruanganM extends TindakanruanganM {

    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    
    public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
                    'ruangan'=>array(self::BELONGS_TO,'PPRuanganM','ruangan_id'),
                    'daftartindakan' => array(self::BELONGS_TO, 'PPDaftartindakanM', 'daftartindakan_id'),
                    'tariftindakan' => array(self::HAS_MANY, 'PPTariftindakanM', array('daftartindakan_id'=>'daftartindakan_id'),'through'=>'daftartindakan'),

		);
	}
    
        public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('LOWER(ruangan.ruangan_nama)', strtolower($this->ruangan_id),true);
        $criteria->compare('LOWER(daftartindakan.daftartindakan_nama)', strtolower($this->daftartindakan_id), true);
        
        $criteria->with = array('ruangan','daftartindakan');

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }
    
     public function searchInfoTarif() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('LOWER(ruangan.ruangan_nama)', strtolower($this->ruangan_id),true);
        $criteria->compare('LOWER(daftartindakan.daftartindakan_nama)', strtolower($this->daftartindakan_id), true);
        
        $criteria->with = array('ruangan','daftartindakan');

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

}

?>
