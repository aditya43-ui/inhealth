<?php

/**
 * Digunakan untuk pembuatan master kelompok jenis waktu
 * @author  Andyka Putra <andykaputra@.com>
 * @package application.modules.gizi
 * 
 */
class GZKelompokjeniswaktuM extends KelompokjeniswaktuM {

    public $status;
    public $jeniswaktu_nama, $default;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * get model jenis waktu
     * @return object mengambil data
     */
    public function getJeniswaktuItems() {
        return JeniswaktuM::Model()->findAll('jeniswaktu_aktif=TRUE ORDER BY jeniswaktu_nama');
    }

    /**
     * get model jenis makanan
     * @return object mengambil data
     */
    public function getJenisMakananItems() {
        return JenismakananM::Model()->findAll('jenismakanan_aktif=TRUE ORDER BY jenismakanan_nama');
    }

    /**
     * dialog untuk load jenis waktu
     * @return \CActiveDataProvider
     */
    public function searchJenisWaktu() {
        $criteria = new CDbCriteria;
        $criteria->select = 't.*, jeniswaktu_m.jeniswaktu_nama';
        $criteria->join = 'JOIN jeniswaktu_m ON jeniswaktu_m.jeniswaktu_id = t.jeniswaktu_id';
        if (!empty($this->default)) {
            $criteria->addCondition("t.jeniswaktu_id is null ");
        }

        if (!empty($this->jenismakanan_id)) {
            $criteria->addCondition('t.jenismakanan_id =' . $this->jenismakanan_id);
        }
        $criteria->compare('LOWER(jeniswaktu_m.jeniswaktu_nama)', strtolower($this->jeniswaktu_nama), true);
        $criteria->order = 'jeniswaktu_m.jeniswaktu_nama ASC';
        $criteria->limit = -1;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false
        ));
    }

}

?>