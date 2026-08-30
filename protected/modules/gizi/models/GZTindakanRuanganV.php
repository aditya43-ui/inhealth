<?php

class GZTindakanRuanganV extends TindakanruanganV
{
    public $daftartindakan_kode;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return TindakanpelayananT the static model class
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

            $criteria->compare('daftartindakan_id',$this->daftartindakan_id);
            $criteria->compare('LOWER(daftartindakan_nama)',strtolower($this->daftartindakan_nama),true);
            $criteria->compare('kategoritindakan_id',$this->kategoritindakan_id);
            $criteria->compare('LOWER(kategoritindakan_nama)',strtolower($this->kategoritindakan_nama),true);
            $criteria->compare('harga_tariftindakan',$this->harga_tariftindakan);
            $criteria->compare('persendiskon_tind',$this->persendiskon_tind);
            $criteria->compare('hargadiskon_tind',$this->hargadiskon_tind);
            $criteria->compare('persencyto_tind',$this->persencyto_tind);
            $criteria->compare('kelompoktindakan_id',$this->kelompoktindakan_id);
            $criteria->compare('LOWER(kelompoktindakan_nama)',strtolower($this->kelompoktindakan_nama),true);
            $criteria->compare('komponentarif_id',$this->komponentarif_id);
            $criteria->compare('LOWER(komponentarif_nama)',strtolower($this->komponentarif_nama),true);
            $criteria->compare('ruangan_id',$this->ruangan_id);
            $criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
            $criteria->compare('instalasi_id',$this->instalasi_id);
            $criteria->compare('LOWER(tindakanmedis_nama)',strtolower($this->tindakanmedis_nama),true);
            $criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
    }
}
?>
