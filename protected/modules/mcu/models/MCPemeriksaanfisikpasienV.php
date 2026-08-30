<?php
/**
 * digunakan untuk extends model modul mcu laporan pemeriksaan fisik pasien
 * @author     Andyka Putra <andykaputra@.com>
 * @package    application.modules.mcu
 * @subpackage models
 */
class MCPemeriksaanfisikpasienV extends PemeriksaanfisikpasienV {

    public $tgl_awal, $tgl_akhir;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PemeriksaanfisikpasienV the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * menampilkan filter Laporan Pemeriksaan Fisik
     * @return \CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function searchLaporan() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        $criteria = new CDbCriteria;
        $criteria->addBetweenCondition("date(t.tgl_pendaftaran)", $this->tgl_awal, $this->tgl_akhir);
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * menampilkan filter cetak 
     * @return \CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function searchPrint() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        $criteria = new CDbCriteria;
        
        $criteria->addBetweenCondition("date(t.tgl_pendaftaran)", $this->tgl_awal, $this->tgl_akhir);
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false
        ));
    }

}
