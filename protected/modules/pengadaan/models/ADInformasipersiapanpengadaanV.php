<?php

/**
 * Model untuk tabel "informasipersiapanpengadaan_v" pada module pengadaan
 * 
 * @author Elham Budianto <elhambudianto@.com>
 * @author Andyka Putra <andykaputra@.com>
 * @package application.modules.pengadaan
 * @subpackage models
 */
class ADInformasipersiapanpengadaanV extends InformasipersiapanpengadaanV {
    
    public $tgl_awal,$tgl_akhir,$pegawaipembuat_nama,$namaunitkerja,$pegawaipembuat_id,$unitkerja_id,$subprogram_id;
    
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return InformasipersiapanpengadaanV the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    /**
     * digunakan untuk menampilkan data informasi persiapan pengadaan
     * @return \CActiveDataProvider
     */
    public function searchInformasi()
    {
        $criteria=new CDbCriteria;
        $criteria->select = " t.*, t.persiapanpengadaan_id, pp.pegawaipembuat_id, t.rencanaumumpengadaan_id, rup.pegawaippk_id, rup.pegawaipa_id, rup.pegawaikpa_id ";
        $criteria->join = " JOIN rencanaumumpengadaan_t rup ON rup.rencanaumumpengadaan_id = t.rencanaumumpengadaan_id "
                        . " JOIN persiapanpengadaan_t pp ON pp.persiapanpengadaan_id = t.persiapanpengadaan_id ";
        $criteria->addBetweenCondition('DATE(t.persiapanpengadaan_tanggal)',$this->tgl_awal,$this->tgl_akhir);
        $criteria->compare('LOWER(t.instalasi_nama)',strtolower($this->instalasi_nama),true);
        $criteria->compare('LOWER(t.persiapanpengadaan_nomor)',strtolower($this->persiapanpengadaan_nomor),true);
        $criteria->compare('LOWER(t.rencanaumumpengadaan_nomor)',strtolower($this->rencanaumumpengadaan_nomor),true);
        $criteria->compare('LOWER(t.kode_rup)',strtolower($this->kode_rup),true);
        $criteria->compare('LOWER(t.nama_pekerjaan)',strtolower($this->nama_pekerjaan),true);
        $criteria->compare('LOWER(t.rencanaumumpengadaan_kategori)',strtolower($this->rencanaumumpengadaan_kategori),true);
        $criteria->compare('LOWER(t.swakelola_tipe)',strtolower($this->swakelola_tipe),true);
        $criteria->compare('LOWER(t.persiapanpengadaan_status)',strtolower($this->persiapanpengadaan_status),true);
        $cekpegawailogin = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
        if($cekpegawailogin->unitkerja_id != Params::UNITKERJA_ID_PENGADAAN_DAN_JASA){
            $criteria->addCondition("t.pegawaipembuat_id = ".Yii::app()->user->getState('pegawai_id')." OR
                                    t.pegawaippk_id = ".Yii::app()->user->getState('pegawai_id')." OR
                                    t.pegawaipa_id = ".Yii::app()->user->getState('pegawai_id')." OR 
                                    t.pegawaikpa_id = ".Yii::app()->user->getState('pegawai_id'));
        }
        if(!empty($this->periodeanggaran_id)){
            $criteria->addCondition('t.periodeanggaran_id ='.$this->periodeanggaran_id);
        }
        if(!empty($this->metodepengadaan_nama)){
            $criteria->addCondition('t.metodepengadaan_nama ='.$this->metodepengadaan_nama);
        }
        if(!empty($this->daftarjenispengadaan)){
            $criteria->compare('LOWER(t.daftarjenispengadaan)',strtolower($this->daftarjenispengadaan),true);
        }
        $criteria->limit=10;
        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
        ));
    }
    
    /**
     * digunakan untuk mencetak data informasi persiapan pengadaan
     * @return \CActiveDataProvider
     */
    public function searchInformasiPrint()
    {
        $criteria=new CDbCriteria;
        $criteria->addBetweenCondition('DATE(t.persiapanpengadaan_tanggal)',$this->tgl_awal,$this->tgl_akhir);
        $criteria->compare('LOWER(t.instalasi_nama)',strtolower($this->instalasi_nama),true);
        $criteria->compare('LOWER(t.persiapanpengadaan_nomor)',strtolower($this->persiapanpengadaan_nomor),true);
        $criteria->compare('LOWER(t.rencanaumumpengadaan_nomor)',strtolower($this->rencanaumumpengadaan_nomor),true);
        $criteria->compare('LOWER(t.nama_pekerjaan)',strtolower($this->nama_pekerjaan),true);
        $criteria->compare('LOWER(t.rencanaumumpengadaan_kategori)',strtolower($this->rencanaumumpengadaan_kategori),true);
        $criteria->compare('LOWER(t.swakelola_tipe)',strtolower($this->swakelola_tipe),true);
        $criteria->compare('LOWER(t.kode_rup)',strtolower($this->kode_rup),true);
        $criteria->compare('LOWER(t.persiapanpengadaan_status)',strtolower($this->persiapanpengadaan_status),true);
        $cekpegawailogin = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
        if($cekpegawailogin->unitkerja_id != Params::UNITKERJA_ID_PENGADAAN_DAN_JASA){
            $criteria->addCondition("t.pegawaipembuat_id = ".Yii::app()->user->getState('pegawai_id')." OR
                                    t.pegawaippk_id = ".Yii::app()->user->getState('pegawai_id')." OR
                                    t.pegawaipa_id = ".Yii::app()->user->getState('pegawai_id')." OR 
                                    t.pegawaikpa_id = ".Yii::app()->user->getState('pegawai_id'));
        }
        if(!empty($this->periodeanggaran_id)){
            $criteria->addCondition('t.periodeanggaran_id ='.$this->periodeanggaran_id);
        }
        if(!empty($this->metodepengadaan_nama)){
            $criteria->addCondition('t.metodepengadaan_nama ='.$this->metodepengadaan_nama);
        }
        if(!empty($this->daftarjenispengadaan)){
            $criteria->compare('LOWER(t.daftarjenispengadaan)',strtolower($this->daftarjenispengadaan),true);
        }
        $criteria->limit=-1;
        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
                'pagination'=>false,
        ));
    }
}