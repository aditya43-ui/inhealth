<?php

class KPPenilaianpegawaiT extends PenilaianpegawaiT {
	public $pegawai_nama, $tingkatpenilaian;
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function searchInformasi()
    {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=new CDbCriteria;

            $criteria->with = 'pegawai';
//		$criteria->compare('tglpenilaian',$this->tglpenilaian);
                            $criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
            $criteria->addBetweenCondition('DATE(periodepenilaian)',$this->periodepenilaian,$this->sampaidengan);
            $criteria->addBetweenCondition('DATE(sampaidengan)',$this->periodepenilaian,$this->sampaidengan);

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
    }

}
