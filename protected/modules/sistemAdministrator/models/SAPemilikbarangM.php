<?php

class SAPemilikbarangM extends PemilikbarangM
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return AgamaM the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
	
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		//$criteria->compare('pemilikbarang_id',$this->pemilikbarang_id);
		if(!empty($this->pemilikbarang_id)){
			$criteria->addCondition('pemilikbarang_id = '.$this->pemilikbarang_id);
		}
		$criteria->compare('LOWER(pemilikbarang_kode)',strtolower($this->pemilikbarang_kode),true);
		$criteria->compare('LOWER(pemilikbarang_nama)',strtolower($this->pemilikbarang_nama),true);
		$criteria->compare('LOWER(pemilikbarang_namalainnya)',strtolower($this->pemilikbarang_namalainnya),true);
		$criteria->compare('pemilikbarang_aktif',isset($this->pemilikbarang_aktif)?$this->pemilikbarang_aktif:true);
//                $criteria->addCondition('pemilikbarang_aktif is true');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.
$criteria=new CDbCriteria;

		//$criteria->compare('pemilikbarang_id',$this->pemilikbarang_id);
		if(!empty($this->pemilikbarang_id)){
			$criteria->addCondition('pemilikbarang_id = '.$this->pemilikbarang_id);
		}
		$criteria->compare('LOWER(pemilikbarang_kode)',strtolower($this->pemilikbarang_kode),true);
		$criteria->compare('LOWER(pemilikbarang_nama)',strtolower($this->pemilikbarang_nama),true);
		$criteria->compare('LOWER(pemilikbarang_namalainnya)',strtolower($this->pemilikbarang_namalainnya),true);
		$criteria->compare('pemilikbarang_aktif',isset($this->pemilikbarang_aktif)?$this->pemilikbarang_aktif:true);
		//$criteria->compare('pemilikbarang_aktif',$this->pemilikbarang_aktif);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}
?>