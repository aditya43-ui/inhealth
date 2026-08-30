<?php
/**
 * model yang digunakan untuk mengakses tabel Riwayatpengadaan_r, pada modul pengadaan
 * @package     application.modules.pengadaan
 * @subpackage  models  
 * @category    model  
 * @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @author      Elham Budianto <elhambudianto@.com>
 * @author       Andyka Putra <andykaputra@.com>
 * @version     2.0.0
 * @link      <http://piindonesia.co.id>
 * @link      <http://172.9.1.15/simpp/docs/>
 */
class ADRiwayatpengadaanR extends RiwayatpengadaanR {

    public $persiapanpengadaan_tanggal;
    /**
     * untuk mengenerate fungsi - fungsi active provider yii
     * @param type $className
     * @return type
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * load riwayat berdasarkan persiapan pengadaan
     * @return \CActiveDataProvider
     */
    public function searchRiwayat() {
        $cri = new CDbCriteria();

        if (!empty($this->persiapanpengadaan_id)) {
            $cri->addCondition(" persiapanpengadaan_id = '" . $this->persiapanpengadaan_id . "' ");
        } else {
            $cri->addCondition(" riwayatpengadaan_id is null ");
        }

        $cri->order = " create_time ASC ";

        return new CActiveDataProvider($this, array(
            'criteria' => $cri,
        ));
    }
    
    /**
     * load detail riwayat berdasarkan rencanaumumpengadaan_id
     * @author Andyka Putra <andykaputra@.com>
     * @return \CActiveDataProvider
     */
    public function searchRiwayat2(){
        $cri = new CDbCriteria();
        
        $cri->addCondition("rencanaumumpengadaan_id = :rencanaumumpengadaan_id");
        $cri->params[':rencanaumumpengadaan_id'] = $_GET['id'];
        $cri->order = " create_time ASC ";
        $cri->limit=-1; 
        
        return new CActiveDataProvider($this, array(
            'criteria'=>$cri,
        ));
    }
}
