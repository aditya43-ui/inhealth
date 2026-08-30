<?php
class PPPendidikanM extends PendidikanM {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
	
	public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('pendidikan_id',$this->pendidikan_id);
		$criteria->compare('LOWER(pendidikan_nama)',strtolower($this->pendidikan_nama),true);
		$criteria->compare('LOWER(pendidikan_namalainnya)',strtolower($this->pendidikan_namalainnya),true);
		$criteria->compare('pendidikan_urutan',$this->pendidikan_urutan);
		$criteria->compare('pendidikan_aktif',isset($this->pendidikan_aktif)?$this->pendidikan_aktif:true);
		$criteria->order='pendidikan_id';
		$criteria->limit=-1;        

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>false,
		));
	}

}