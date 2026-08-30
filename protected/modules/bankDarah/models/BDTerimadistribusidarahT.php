<?php

/**
 * digunakan untuk transaksi dan informasi distribusi penerimaan darah
 * @author Yusuf Putra Anugrah <yusufputra@.com>
 * @author Rusdiyanto <rusdiyanto@.com>
 * @package application.modules.bankDarah
 * @subpackage models
 */
class BDTerimadistribusidarahT extends TerimadistribusidarahT {
    public $tgl_awal,$tgl_akhir, $petugas_nama;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return TerimadistribusidarahT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * digunakan untuk pencarian informasi
     * @return \CActiveDataProvider he data provider that can return the models based on the search/filter conditions.
     */
    public function searchInformasi() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        $criteria = new CDbCriteria();
        $criteria->select="t.*,p.nama_pegawai";
        $criteria->join="left join pegawai_m p on p.pegawai_id=t.petugasdistribusi_pelayanandarah";
      
        $criteria->addBetweenCondition("DATE(t.tgl_terima) ", $this->tgl_awal, $this->tgl_akhir);
        $criteria->compare('LOWER(t.nomor_terima)', strtolower($this->nomor_terima), true);
        $criteria->compare('LOWER(p.nama_pegawai)', strtolower($this->petugasdistribusi_pelayanandarah),true);


        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
