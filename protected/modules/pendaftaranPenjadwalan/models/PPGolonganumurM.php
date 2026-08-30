<?php
class PPGolonganumurM extends GolonganumurM {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
	
	public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('golonganumur_id',$this->golonganumur_id);
		$criteria->compare('LOWER(golonganumur_nama)',strtolower($this->golonganumur_nama),true);
		$criteria->compare('LOWER(golonganumur_namalainnya)',strtolower($this->golonganumur_namalainnya),true);
		$criteria->compare('golonganumur_minimal',$this->golonganumur_minimal);
		$criteria->compare('golonganumur_maksimal',$this->golonganumur_maksimal);
		$criteria->compare('golonganumur_aktif',isset($this->golonganumur_aktif)?$this->golonganumur_aktif:true);
		$criteria->limit = -1;
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>false,                    
		));
	}

}