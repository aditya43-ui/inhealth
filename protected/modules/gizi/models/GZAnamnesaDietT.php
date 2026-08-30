<?php

class GZAnamnesaDietT extends AnamesadietT {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function getDokterItemsKonsul()
    {
            return DokterV::model()->findAll();
    }
   

    public function searchAnamesaDiet($pendaftaran_id)
    {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=new CDbCriteria;

            $criteria->compare('anamesadiet_id',$this->anamesadiet_id);
            $criteria->compare('pasien_id',$this->pasien_id);
            $criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
            $criteria->compare('ruangan_id',$this->ruangan_id);
            $criteria->compare('jeniswaktu_id',$this->jeniswaktu_id);
            $criteria->compare('bahanmakanan_id',$this->bahanmakanan_id);
            $criteria->compare('pegawai_id',$this->pegawai_id);
            $criteria->addCondition('pendaftaran_id = '.$pendaftaran_id);
            $criteria->compare('pekerjaan_id',$this->pekerjaan_id);
            $criteria->compare('menudiet_id',$this->menudiet_id);
            $criteria->compare('LOWER(tglanamesadiet)',strtolower($this->tglanamesadiet),true);
            $criteria->compare('LOWER(keterangan)',strtolower($this->keterangan),true);
            $criteria->compare('LOWER(katpekerjaan)',strtolower($this->katpekerjaan),true);
            $criteria->compare('beratbahan',$this->beratbahan);
            $criteria->compare('LOWER(urt)',strtolower($this->urt),true);
            $criteria->compare('energikalori',$this->energikalori);
            $criteria->compare('protein',$this->protein);
            $criteria->compare('lemak',$this->lemak);
            $criteria->compare('hidratarang',$this->hidratarang);
            $criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
            $criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
            $criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
            $criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
            $criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
            $criteria->compare('ahligizi',$this->ahligizi);

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
    }
}
