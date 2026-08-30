<?php

class GZObatAlkesM extends ObatalkesM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ObatalkesM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function searchData()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

                $criteria->with = array('sumberdana');

		$criteria->compare('lokasigudang_id',$this->lokasigudang_id);
		$criteria->compare('therapiobat_id',$this->therapiobat_id);
		$criteria->compare('generik_id',$this->generik_id);
		$criteria->compare('satuanbesar_id',$this->satuanbesar_id);
		
		$criteria->compare('discountinue',FALSE);
		$criteria->compare('obatalkes_aktif',TRUE);
		

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}