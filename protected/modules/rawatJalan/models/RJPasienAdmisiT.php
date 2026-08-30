<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class RJPasienAdmisiT extends PasienadmisiT
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PPPasienAdmisiT the static model class
     */
    public $carabayar_nama;
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pegawai_id, penjamin_id, kelaspelayanan_id, caramasuk_id, pasien_id, ruangan_id, carabayar_id, tgladmisi, tglpendaftaran, kunjungan', 'required'),
			array('penjamin_id, kelaspelayanan_id, caramasuk_id, pendaftaran_id, kamarruangan_id, pegawai_id, pasien_id, ruangan_id, carabayar_id, bookingkamar_id', 'numerical', 'integerOnly'=>true),
			array('kunjungan', 'length', 'max'=>50),
			array('tglpulang, statuskeluar, rawatgabung', 'safe'),
                    
                        array('create_time','default','value'=>date( 'Y-m-d H:i:s', time()),'setOnEmpty'=>false,'on'=>'insert'),
                        array('update_time','default','value'=>date( 'Y-m-d H:i:s', time()),'setOnEmpty'=>false,'on'=>'update,insert'),
                        array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
                        array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'update,insert'),
                        array('shift_id','default','value'=>Yii::app()->user->getState('shift_id'),'on'=>'insert'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pasienadmisi_id, penjamin_id, kelaspelayanan_id, caramasuk_id, pendaftaran_id, kamarruangan_id, pegawai_id, pasien_id, ruangan_id, carabayar_id, bookingkamar_id, tgladmisi, tglpendaftaran, tglpulang, kunjungan, statuskeluar, rawatgabung, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
		);
	}

//    protected function beforeValidate (){
//        return parent::beforeValidate ();
//    }
//        
//    protected function beforeSave() {  
//        return parent::beforeSave();
//    }
    
    public function getKamarKosongItems($ruangan_id=null)
    {
        if(!empty($ruangan_id))
            return KamarruanganM::model()->findAllByAttributes(array('ruangan_id'=>$ruangan_id,'kamarruangan_status'=>true));
        else {
            return array();
        }
    }

    public function getDokterItems($ruangan_id='')
    {
        if(!empty($ruangan_id))
            return DokterV::model()->findAllByAttributes(array('ruangan_id'=>$ruangan_id));
        else
            return array();
    }

    /**
     * Mengambil daftar semua ruangan
     * @return CActiveDataProvider 
     */
    public function getRuanganItems($instalasiId='')
    {
        if($instalasiId!='')
            return RuanganM::model()->findAllByAttributes(array('instalasi_id'=>$instalasiId,'ruangan_aktif'=>true),array('order'=>'ruangan_nama'));
        else
            return RuanganM::model()->findAllByAttributes(array('ruangan_aktif'=>true),array('order'=>'ruangan_nama'));
    }

    /**
     * Mengambil daftar semua caramasuk
     * @return CActiveDataProvider 
     */
    public function getCaraMasukItems()
    {
        return CaramasukM::model()->findAllByAttributes(array('caramasuk_aktif'=>true),array('order'=>'caramasuk_nama'));
    }
        
    /**
     * menampilkan instalasi untuk pendaftaran rawat inap dari RJ / RD
     * @return array
     */
    public function getInstalasis(){
        $criteria = new CDbCriteria();
        $criteria->addInCondition('instalasi_id',array(
                    Params::INSTALASI_ID_RJ, 
                    Params::INSTALASI_ID_RD) 
                );
        $criteria->addCondition('instalasi_aktif = true');
        $modInstalasis = InstalasiM::model()->findAll($criteria);
        if(count((array)$modInstalasis) > 0)
            return $modInstalasis;
        else
            return array();
    }
}
?>
