<?php

class SAKabupatenM extends KabupatenM
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
    
    
    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=new CDbCriteria;
			
			if (!empty($this->kabupaten_id)){
				$criteria->addCondition('kabupaten_id ='.$this->kabupaten_id);
			}
			if (!empty($this->propinsi_id)){
				$criteria->addCondition('t.propinsi_id ='.$this->propinsi_id);
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
    
}
?>
