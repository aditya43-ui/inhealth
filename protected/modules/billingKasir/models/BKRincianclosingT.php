<?php

class BKRincianclosingT extends RincianclosingT
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RincianclosingT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function searchInformasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->rincianclosing_id)){
			$criteria->addCondition("rincianclosing_id = ".$this->rincianclosing_id);					
		}
		if(!empty($this->closingkasir_id)){
			$criteria->addCondition("closingkasir_id = ".$this->closingkasir_id);					
		}
		$criteria->compare('nourutrincian',$this->nourutrincian);
		$criteria->compare('nilaiuang',$this->nilaiuang);
		$criteria->compare('banyakuang',$this->banyakuang);
		$criteria->compare('jumlahuang',$this->jumlahuang);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
}