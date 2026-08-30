<?php

class GZPegawaiM extends PegawaiM
{
    
    public $nama_pemakai;
    public $new_password;
    public $new_password_repeat;  
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PegawaiM the static model class
	 */
    public $tempPhoto;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    
    public static function getNamaPegawai($id){
        if (isset($id)){
            return PegawaiM::model()->findByPk($id)->nama_pegawai;
        } else {
            return "-";
        }
    }
    
    public function searchPegawaiRuanganLogin() {
        $prov = $this->searchPegawai();
        
        $prov->criteria->join = 'join ruanganpegawai_m r on r.pegawai_id = t.pegawai_id';
        $prov->criteria->compare('r.ruangan_id', Yii::app()->user->getState('ruangan_id'));
        
        
        return $prov;
    }
    
    public function PegawaiRuangan()
    {
        $criteria = new CDbCriteria;
        $criteria->with = array('ruanganpegawai');
        $criteria->addCondition("ruanganpegawai.ruangan_id = ".Yii::app()->user->getState('ruangan_id'));
        $criteria->addCondition("t.pegawai_aktif = TRUE");
        $criteria->addCondition("t.loginpemakai_id IS NOT NULL");
        $criteria->order = "nama_pegawai ASC";
        
        return PegawaiM::model()->findAll($criteria);
    }

}