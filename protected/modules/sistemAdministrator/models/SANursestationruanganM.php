<?php

/**
 * This is the model class for table "nursestationruangan_m".
 *
 * The followings are the available columns in table 'nursestationruangan_m':
 * @property integer $ruangan_id
 * @property integer $nursestation_id
 */
class SANursestationruanganM extends NursestationruanganM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return NursestationruanganM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('nursestation_id',$this->nursestation_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}