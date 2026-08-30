<?php

class SATherapimapobatM extends TherapimapobatM{
	public $therapiobat_nama,$obatalkes_nama,$no_urut,$kosong;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TherapimapobatM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function searchMapping()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->with = array('obatalkes','therapiobat');
		if(!empty($this->therapiobat_id)){
			$criteria->addCondition('therapiobat.therapiobat_id = '.$this->therapiobat_id);
		}
		if(!empty($this->obatalkes_id)){
			$criteria->addCondition('obatalkes.obatalkes_id = '.$this->obatalkes_id);
		}
		$criteria->compare('LOWER(obatalkes.obatalkes_nama)',  strtolower($this->obatalkes_nama),true);
		$criteria->compare('LOWER(therapiobat.therapiobat_nama)',  strtolower($this->therapiobat_nama),true); 		
		$criteria->addCondition('therapiobat.therapiobat_aktif is TRUE');
		$criteria->addCondition('obatalkes.obatalkes_aktif is TRUE');
		
		return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
	}
}
