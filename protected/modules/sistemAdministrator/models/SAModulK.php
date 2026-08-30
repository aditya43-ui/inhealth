<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class SAModulK extends ModulK
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return LookupM the static model class
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
			
			if (!empty($this->modul_id)){
				$criteria->addCondition('modul_id ='.$this->modul_id);
			}
			if (!empty($this->kelompokmodul_id)){
				$criteria->addCondition('t.kelompokmodul_id ='.$this->kelompokmodul_id);
			}
            $criteria->compare('LOWER(kelompokmodul.kelompokmodul_nama)',strtolower($this->kelompokmodul_nama),true);
            $criteria->compare('LOWER(modul_nama)',strtolower($this->modul_nama),true);
            $criteria->compare('LOWER(modul_namalainnya)',strtolower($this->modul_namalainnya),true);
            $criteria->compare('LOWER(modul_fungsi)',strtolower($this->modul_fungsi),true);
            $criteria->compare('LOWER(tglrevisimodul)',strtolower($this->tglrevisimodul),true);
            $criteria->compare('LOWER(tglupdatemodul)',strtolower($this->tglupdatemodul),true);
            $criteria->compare('LOWER(url_modul)',strtolower($this->url_modul),true);
            $criteria->compare('LOWER(icon_modul)',strtolower($this->icon_modul),true);
            $criteria->compare('LOWER(modul_key)',strtolower($this->modul_key),true);
            $criteria->compare('modul_urutan',$this->modul_urutan);
            $criteria->compare('modul_aktif',isset($this->modul_aktif)?$this->modul_aktif:true);
            $criteria->compare('LOWER(modul_kategori)',strtolower($this->modul_kategori),true);
            $criteria->with = array('kelompokmodul');

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
    }

    public static function getModuls()
    {
            
            $criteria = new CDbCriteria();
            $criteria->order = "modul_urutan";
            $criteria->addCondition("modul_aktif IS TRUE");
            $models=self::model()->findAll($criteria);
            if(count((array)$models) > 0){
                foreach($models as $model)
                    $data[$model->modul_id]= ucwords(strtolower($model->modul_nama));
            }else{
                $data[""] = null;
            }
            
            return $data;
    }
}
?>
