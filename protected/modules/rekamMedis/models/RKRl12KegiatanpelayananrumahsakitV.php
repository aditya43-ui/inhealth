<?php
class RKRl12KegiatanpelayananrumahsakitV extends Rl12KegiatanpelayananrumahsakitV
{
    public $ndr,$gdr;
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }

    public function searchRL()
    {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=new CDbCriteria;
            
            $criteria->select = 'tahun, nokode_rumahsakit,nama_rumahsakit,sum(bor) as bor,sum(los) as los,sum(bto) as bto,
                                sum(toi) as toi,sum(jumlahpasienmati48jam)/sum(jumlahpasienkeluar) as ndr,sum(jumlahpasienmati)/sum(jumlahpasienkeluar) as gdr,sum(kunjunganperhari) as kunjunganperhari';
            $criteria->group = 'tahun,nokode_rumahsakit,nama_rumahsakit';
            $criteria->compare('tahun',$this->tahun);
            $criteria->compare('nokode_rumahsakit',$this->nokode_rumahsakit,true);
            $criteria->compare('nama_rumahsakit',$this->nama_rumahsakit,true);
            $criteria->compare('hariperawatan',$this->hariperawatan);
            $criteria->compare('jumlahtt',$this->jumlahtt);
            $criteria->compare('pembagi',$this->pembagi);
            $criteria->compare('jumlahpasienkeluar',$this->jumlahpasienkeluar);
            $criteria->compare('jumlahpasienmati',$this->jumlahpasienmati);
            $criteria->compare('jumlahpasienmati48jam',$this->jumlahpasienmati48jam);
            $criteria->compare('bor',$this->bor);
            $criteria->compare('los',$this->los);
            $criteria->compare('bto',$this->bto);
            $criteria->compare('toi',$this->toi);
            $criteria->compare('kunjunganperhari',$this->kunjunganperhari);

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
    }
}