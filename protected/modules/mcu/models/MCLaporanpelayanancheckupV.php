<?php
/**
 * digunakan untuk extends model modul mcu lapaoran pelayanan checkup
 * RSST-3651
 * @author          Yusuf Putra Anugrah <yusufputra@.com>
 * @version         2.0.0
 * @link            http://172.9.1.15/simpp/docs/
 * @package         application.modules.mcu
 * @subpackage models
 * 
 */
class MCLaporanpelayanancheckupV extends LaporanpelayanancheckupV {

    public $tanggalawal, $tanggalakhir, $tipe;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return KarcisV the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * menampilkan filter Laporan Pelayanan Checkup
     * @return \CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function searchLaporan() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        $criteria = new CDbCriteria;
        $criteria->select = "t.*";
        $criteria->join = "left join  jenissurat_m j on j.jenissurat_id=t.jenissurat_id";
        if ($this->tipe == "PC") {
            $criteria->addBetweenCondition("date(t.tgl_pendaftaran)", $this->tanggalawal, $this->tanggalakhir);
            $criteria->compare('tipepaket_id', $this->tipepaket_id);
            $criteria->addCondition('t.jenissurat_id = 9 OR t.jenissurat_id = 10');
        } else {
            $criteria->addBetweenCondition("date(t.tgl_pendaftaran)", $this->tanggalawal, $this->tanggalakhir);
            $criteria->compare('tipepaket_id', $this->tipepaket_id);
            $criteria->addCondition('t.jenissurat_id = 11 OR t.jenissurat_id = 12');
        }
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * menampilkan filter cetak 
     * @return \CActiveDataProvider * @return \CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function searchPrint() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        $criteria = new CDbCriteria;
        $criteria->select = "t.*";
        $criteria->join = "left join  jenissurat_m j on j.jenissurat_id=t.jenissurat_id";
        if ($this->tipe == "PC") {
            $criteria->addBetweenCondition("date(t.tgl_pendaftaran)", $this->tanggalawal, $this->tanggalakhir);
            $criteria->compare('tipepaket_id', $this->tipepaket_id);
            $criteria->addCondition('t.jenissurat_id = 9 OR t.jenissurat_id = 10');
        } else {
            $criteria->addBetweenCondition("date(t.tgl_pendaftaran)", $this->tanggalawal, $this->tanggalakhir);
            $criteria->compare('tipepaket_id', $this->tipepaket_id);
            $criteria->addCondition('t.jenissurat_id = 11 OR t.jenissurat_id = 12');
        }
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false
        ));
    }

}
