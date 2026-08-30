<?php
class PPPropinsiM extends PropinsiM {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
	
	public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->compare('propinsi_id',$this->propinsi_id);
		$criteria->compare('LOWER(propinsi_nama)',strtolower($this->propinsi_nama),true);
		$criteria->compare('LOWER(propinsi_namalainnya)',strtolower($this->propinsi_namalainnya),true);
		$criteria->compare('propinsi_aktif',isset($this->propinsi_aktif)?$this->propinsi_aktif:true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>false,
		));
	}

}