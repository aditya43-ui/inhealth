<?php
class PPKabupatenM extends KabupatenM {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function search()
    {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=new CDbCriteria;

			if(!empty($this->kabupaten_id)){
				$criteria->addCondition('kabupaten_id = '.$this->kabupaten_id);			
			}
			if(!empty($this->propinsi_id)){
				$criteria->addCondition('t.propinsi_id = '.$this->propinsi_id);			
			}
            $criteria->compare('LOWER(propinsi.propinsi_nama)',strtolower($this->propinsi_nama),true);
            $criteria->compare('LOWER(kabupaten_nama)',strtolower($this->kabupaten_nama),true);
            $criteria->compare('LOWER(kabupaten_namalainnya)',strtolower($this->kabupaten_namalainnya),true);
            $criteria->compare('kabupaten_aktif',isset($this->kabupaten_aktif)?$this->kabupaten_aktif:true);
            $criteria->with = array('propinsi');

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
    }
	
	public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('kabupaten_id',$this->kabupaten_id);
		$criteria->compare('propinsi_id',$this->propinsi_id);
		$criteria->compare('LOWER(kabupaten_nama)',strtolower($this->kabupaten_nama),true);
		$criteria->compare('LOWER(kabupaten_namalainnya)',strtolower($this->kabupaten_namalainnya),true);
		$criteria->compare('kabupaten_aktif',isset($this->kabupaten_aktif)?$this->kabupaten_aktif:true);
		$criteria->limit=-1;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                         'pagination'=>false,
		));
	}

}