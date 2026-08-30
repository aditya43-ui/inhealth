<?php

/**
 * Class model tabel "distribusidarah_t" pada module Bank Darah
 * 
 * @author  Yusuf Putra Anugrah <yusufputra@.com>
 * @package application.modules.bankDarah
 * @subpackage models
 */
class BDDistribusidarahT extends DistribusidarahT {

    public $tgl_awal, $tgl_akhir, $nama_pegawai;
    public $status, $gelardepan, $gelarbelakang_nama, $trimadistribusidarah_id;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PermintaandarahpmiT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * Load data Informasi distribusi darah
     * @return \CActiveDataProvider
     */
    public function searchInformasi() {
        $criteria = new CDbCriteria;
        $criteria->join = 'left join pegawai_v p on p.pegawai_id=t.petugasdistribusi_id 
                           left join  distribusidarahdet_t pd on pd.distribusidarah_id=t.distribusidarah_id';
        $criteria->select = 't.nomor_pengiriman,t.tgl_distribusi,t.shift_distribusi,t.distribusidarah_id,p.nama_pegawai,p.gelardepan,p.gelarbelakang_nama,pd.terimadistribusidarah_id';
        $criteria->group = "t.nomor_pengiriman,t.tgl_distribusi,t.shift_distribusi,t.distribusidarah_id,p.nama_pegawai,p.gelardepan,p.gelarbelakang_nama,pd.terimadistribusidarah_id";
        $criteria->order = 't.tgl_distribusi ASC ';


        if ($this->status == 'Sudah') {
            $criteria->addCondition('pd.terimadistribusidarah_id IS NOT NULL');
        } else if ($this->status == 'Belum') {
            $criteria->addCondition('pd.terimadistribusidarah_id IS NULL');
        }

        $criteria->addBetweenCondition('DATE(tgl_distribusi)', $this->tgl_awal, $this->tgl_akhir);
        $criteria->compare('LOWER(t.nomor_pengiriman)', strtolower($this->nomor_pengiriman), true);
        $criteria->compare('LOWER(p.nama_pegawai)', strtolower($this->nama_pegawai), true);
        $criteria->compare('LOWER(t.shift_distribusi)', strtolower($this->shift_distribusi), true);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }


}
