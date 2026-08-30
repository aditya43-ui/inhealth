<?php
class PPKelurahanM extends KelurahanM {

	public $propinsi_id,$kabupaten_id;
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function search()
    {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=new CDbCriteria;

			if(!empty($this->kelurahan_id)){
				$criteria->addCondition("kelurahan_id = ".$this->kelurahan_id);			
			}
			if(!empty($this->kecamatan_id)){
				$criteria->addCondition("t.kecamatan_id = ".$this->kecamatan_id);			
			}
            $criteria->compare('LOWER(kelurahan_nama)',strtolower($this->kelurahan_nama),true);
            $criteria->compare('LOWER(kelurahan_namalainnya)',strtolower($this->kelurahan_namalainnya),true);
            $criteria->compare('LOWER(kode_pos)',strtolower($this->kode_pos),true);
            $criteria->compare('kelurahan_aktif',isset($this->kelurahan_aktif)?$this->kelurahan_aktif:true);
            $criteria->with = array('kecamatan');

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
    }
	
	public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->compare('kelurahan_id',$this->kelurahan_id);
		$criteria->compare('kecamatan_id',$this->kecamatan_id);
		$criteria->compare('LOWER(kelurahan_nama)',strtolower($this->kelurahan_nama),true);
		$criteria->compare('LOWER(kelurahan_namalainnya)',strtolower($this->kelurahan_namalainnya),true);
		$criteria->compare('LOWER(kode_pos)',strtolower($this->kode_pos),true);		
		//$criteria->with=array('kecamatan');
		$criteria->compare('kelurahan_aktif',isset($this->kelurahan_aktif)?$this->kelurahan_aktif:true);
                $criteria->order = 'kelurahan_id';
		$criteria->limit=-1; 

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				 'pagination'=>false,
		));
}
	
}