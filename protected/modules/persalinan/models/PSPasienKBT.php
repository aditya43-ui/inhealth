<?php

class PSPasienKBT extends PasienkbT
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PasienkbT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function searchRiwayat()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id ='.$this->pasien_id);
		}
		$criteria->order='tglpelayanankb DESC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}