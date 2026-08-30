<?php
class PPPekerjaanM extends PekerjaanM{
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
	
	public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('pekerjaan_id',$this->pekerjaan_id);
		$criteria->compare('LOWER(pekerjaan_nama)',strtolower($this->pekerjaan_nama),true);
		$criteria->compare('LOWER(pekerjaan_namalainnya)',strtolower($this->pekerjaan_namalainnya),true);
		$criteria->compare('pekerjaan_aktif',isset($this->pekerjaan_aktif)?$this->pekerjaan_aktif:true);
		$criteria->order='pekerjaan_id';
		$criteria->limit=-1;
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>false,
		));
	}
}