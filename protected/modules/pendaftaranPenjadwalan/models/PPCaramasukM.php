<?php
class PPCaramasukM extends CaramasukM {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
	
	public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('caramasuk_id',$this->caramasuk_id);
		$criteria->compare('LOWER(caramasuk_nama)',strtolower($this->caramasuk_nama),true);
		$criteria->compare('LOWER(caramasuk_namalainnya)',strtolower($this->caramasuk_namalainnya),true);
		$criteria->compare('caramasuk_aktif',isset($this->caramasuk_aktif)?$this->caramasuk_aktif:true);
		$criteria->limit = -1;
		$criteria->order = 'caramasuk_id';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                         'pagination'=>false,
		));
	}

}