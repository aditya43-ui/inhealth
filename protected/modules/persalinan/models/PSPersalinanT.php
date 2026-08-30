<?php
class PSPersalinanT extends PersalinanT {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function getDokterItems($ruangan_id='')
        {
            $ruangan_id = Yii::app()->user->getState('ruangan_id');
            if(!empty($ruangan_id))
                return DokterV::model()->findAllByAttributes(array('ruangan_id'=>$ruangan_id));
            else
                return array();
        }
        
    public function getBidanItems($ruangan_id='')
        {
            $ruangan_id = Yii::app()->user->getState('ruangan_id');
            if(!empty($ruangan_id)):
                $pegawai = new CDbCriteria();
                $pegawai->with = array('ruanganpegawai');
                $pegawai->addCondition("t.pegawai_aktif = TRUE ");
                $pegawai->addCondition("ruanganpegawai.ruangan_id = ".$ruangan_id); 
                $pegawai->addCondition('t.kelompokpegawai_id IN ('.Params::KELOMPOKPEGAWAI_ID_BIDAN.') ');
                $pegawai->order = 't.nama_pegawai ASC';
                return PSPegawaiM::model()->findAll($pegawai);
            else:
                return array();
            endif;
        }
        
    public function getParamedisItems($ruangan_id='')
        {
            $ruangan_id = Yii::app()->user->getState('ruangan_id');
            if(!empty($ruangan_id)):
                 $pegawai = new CDbCriteria();
                $pegawai->with = array('ruanganpegawai');
                $pegawai->addCondition("t.pegawai_aktif = TRUE ");
                $pegawai->addCondition("ruanganpegawai.ruangan_id = ".$ruangan_id); 
                $pegawai->addCondition('t.kelompokpegawai_id IN ('.Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN.', '.Params::KELOMPOKPEGAWAI_ID_BIDAN.') ');
                $pegawai->order = 't.nama_pegawai ASC';
                return PSPegawaiM::model()->findAll($pegawai);
                //return PegawaiM::model()->findAll("ruangan_id = '$ruangan_id' AND kelompokpegawai_id IN (20,2) AND pegawai_aktif = TRUE ORDER BY nama_pegawai ASC");
            else:
                return array();
            endif;
        }

    public function search10Terakhir()
    {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=new CDbCriteria;
            $criteria->order = "tglmelahirkan";
            $criteria->limit=10; 
            

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false,
            ));
    }

}