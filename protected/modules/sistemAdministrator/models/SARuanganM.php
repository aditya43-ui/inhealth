<?php

/**
 * This is the model class for table "ruangan_m".
 *
 * The followings are the available columns in table 'ruangan_m':
 * @property integer $ruangan_id
 * @property integer $instalasi_id
 * @property string $ruangan_nama
 * @property string $ruangan_namalainnya
 * @property string $ruangan_lokasi
 * @property boolean $ruangan_aktif
 */
class SARuanganM extends RuanganM {

    public $is_tindakan,$daftartindakan_id,$daftartindakan_nama,$pegawai_id,$nama_pegawai;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return RuanganM the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * Untuk menampilkan lokasi dari lookup_m
     */
    public function getLokasiItems() {
        return LookupM::model()->findAllByAttributes(array('lookup_type' => 'ruangan_lokasi', 'lookup_aktif' => true), array('order' => 'lookup_urutan'));
    }
    
    /**
     * Menampulkan ruangan (instalasi)
     * @return string
     */
    public function getRuanganInstalasi() {
        $instalasi = InstalasiM::model()->findByPk($this->instalasi_id);
        return $this->ruangan_nama." (".$instalasi->instalasi_nama.")";
    }

    /**
     * Untuk menampilkan ruangan di pemeriksaan pasien
     */
    public function getRuanganTindakan() {
        $criteria = new CDbCriteria();
        $criteria->addCondition('ruangan_aktif = TRUE');
        $criteria->addInCondition('instalasi_id', array(
            Params::INSTALASI_ID_RI,
            Params::INSTALASI_ID_RJ,
            Params::INSTALASI_ID_RD,
        ));
        $criteria->order = "instalasi_id, ruangan_nama ASC";
        $models = $this->findAll($criteria);
        if (count((array)$models) > 0) {
            return $models;
        } else {
            return array();
        }
    }

    /**
     * static agar bisa menerima nilai dari parameter
     * @param type $instalasi_id
     * @return type
     */
    public static function getItems($instalasi_id = null) {
        $criteria = new CDbCriteria();
        $criteria->addCondition("ruangan_aktif = TRUE");
        $criteria->order = 'ruangan_nama ASC';
        if (!empty($instalasi_id)) {
            $criteria->addCondition("instalasi_id = " . $instalasi_id);
            return self::model()->findAll($criteria);
        } else {
            return array();
        }
    }

    public static function getItemsList() {
        $criteria = new CDbCriteria();
        $criteria->addCondition("ruangan_aktif = TRUE");
        $criteria->order = "ruangan_nama";

        return self::model()->findAll($criteria);
    }
	
	public static function getRuanganByInstalasi($instalasi_id = null){
		$ruanganlogin_id = Yii::app()->user->getState('ruangan_id');
		$criteria = new CDbCriteria();
		if(!empty($instalasi_id)){
			$criteria->addCondition('instalasi_id = '.$instalasi_id);
		}
		$criteria->addCondition("ruangan_aktif = TRUE");
		$criteria->order = "ruangan_nama";
		return self::model()->findAll($criteria);
	}
	
	public static function getRuangan(){
		$criteria = new CDbCriteria();
		$criteria->addCondition("ruangan_aktif = TRUE");
		$criteria->order = "ruangan_nama";
		return self::model()->findAll($criteria);
	}
    
    public static function getFileSuaraAntrian() {
        $konfig = KonfigsystemK::model()->find();
        
        $files = array_diff(scandir(Yii::getPathOfAlias('webroot').'/data/sounds/antrian/mp3/'.$konfig->jenissuaraantrian), array('.', '..'));
        $res = array();
        
        foreach ($files as $file) {
            $file = explode(".", $file)[0];
            $res[$file] = $file;
        }
        
        return $res;
        
    }

}
