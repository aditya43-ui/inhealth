<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class SAJenisKegiatanM extends JeniskegiatanM
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return KabupatenM the static model class
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

            $criteria->compare('jeniskegiatan_id',$this->jeniskegiatan_id);
            $criteria->compare('LOWER(jeniskegiatan_kode)',  strtolower($this->jeniskegiatan_kode),true);
            $criteria->compare('LOWER(jeniskegiatan_nama)',strtolower($this->jeniskegiatan_nama),true);
            $criteria->compare('jeniskegiatan_aktif',isset($this->jeniskegiatan_aktif)?$this->jeniskegiatan_aktif:true);
            $criteria->compare('LOWER(jeniskegiatan_ruangan)',strtolower($this->jeniskegiatan_ruangan),true);
            $criteria->limit = 10;

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
    }

    public function searchPrint()
    {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=new CDbCriteria;

            $criteria->compare('jeniskegiatan_id',$this->jeniskegiatan_id);
            $criteria->compare('LOWER(jeniskegiatan_kode)',  strtolower($this->jeniskegiatan_kode),true);
            $criteria->compare('LOWER(jeniskegiatan_nama)',strtolower($this->jeniskegiatan_nama),true);
            $criteria->compare('jeniskegiatan_aktif',isset($this->jeniskegiatan_aktif)?$this->jeniskegiatan_aktif:true);
            $criteria->compare('LOWER(jeniskegiatan_ruangan)',strtolower($this->jeniskegiatan_ruangan),true);
            $criteria->limit = -1;

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination' => false
            ));
    }
    
    public function searchDialog()
    {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=new CDbCriteria;

            $criteria->compare('jeniskegiatan_id',$this->jeniskegiatan_id);
            $criteria->compare('LOWER(jeniskegiatan_kode)',  strtolower($this->jeniskegiatan_kode),true);
            $criteria->compare('LOWER(jeniskegiatan_nama)',strtolower($this->jeniskegiatan_nama),true);
            //$criteria->compare('jeniskegiatan_aktif',isset($this->jeniskegiatan_aktif)?$this->jeniskegiatan_aktif:true);
            $criteria->addCondition(" jeniskegiatan_aktif = TRUE ");
            $criteria->compare('LOWER(jeniskegiatan_ruangan)',  strtolower($this->jeniskegiatan_ruangan),true);
            $criteria->limit = 10;

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
    }
}
?>
