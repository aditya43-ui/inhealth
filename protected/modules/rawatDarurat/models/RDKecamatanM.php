<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class RDKecamatanM extends KecamatanM
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return JeniskasuspenyakitM the static model class
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

			if(!empty($this->kecamatan_id)){
				$criteria->addCondition("kecamatan_id = ".$this->kecamatan_id);				
			}
			if(!empty($this->kabupaten_id)){
				$criteria->addCondition("t.kabupaten_id = ".$this->kabupaten_id);				
			}
            $criteria->compare('LOWER(kecamatan_nama)',strtolower($this->kecamatan_nama),true);
            $criteria->compare('LOWER(kecamatan_namalainnya)',strtolower($this->kecamatan_namalainnya),true);
            $criteria->compare('kecamatan_aktif',isset($this->kecamatan_aktif)?$this->kecamatan_aktif:true);
            $criteria->with = array('kabupaten');
            
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
    }
}
?>
