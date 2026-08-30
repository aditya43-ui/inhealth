<?php

/**
 * Model untuk tabel "informasirencanaumumpengadaan_v" pada module pengadaan
 * 
 * @author Elham Budianto <elhambudianto@.com>
 * @package application.modules.pengadaan
 * @subpackage models
 */
class ADInformasirencanaumumpengadaanV extends InformasirencanaumumpengadaanV {
    
    public $tgl_awal , $tgl_akhir , $instalasi_nama,$jenispengadaan_id, $pegawaipembuat_id;
    
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return InformasirencanaumumpengadaanV the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    /**
     * Set data dropdown periode anggaran
     * @return array $data option untuk dropdown
     */
    public function getPeriodeAnggaran(){
        $data = array();
        $criteria = new CDbCriteria();
        $criteria->order = "tahunanggaran DESC";
        $models = PeriodeanggaranK::model()->findAll($criteria);
        if(count($models) > 0){
            foreach($models as $model)
                $data[$model->periodeanggaran_id]= ($model->tahunanggaran." - ".$model->anggaran_nama);
        }

        return $data;
    }
    
    /**
     * Set data dropdown rekening MAK
     * @return array $data option untuk dropdown
     */
    public static function getRekeningMAK(){
        $data = array();
        $criteria = new CDbCriteria();
        $criteria->order = "nmrekening5 DESC";
        $criteria->addCondition('rekening5_aktif IS TRUE');
        $models = RekeningakuntansiV::model()->findAll($criteria);
        if(count($models) > 0){
            foreach($models as $model)
                $data[$model->rekening5_id]= ($model->kdrekening5." - ".$model->nmrekening5);
        }

        return $data;
    }
    
    /**
     * pencarian data untuk transaksi persiapan pengadaan
     * @return \CActiveDataProvider
     */
    public function searchForPersiapanPengadaan() {
        $criteria = new CDbCriteria();
        $criteria->select = " t.*, ins.instalasi_nama, u.namaunitkerja  ";
        $criteria->join = " JOIN instalasi_m ins ON ins.instalasi_id = t.instalasi_id "
                        . " JOIN unitkerja_m u ON u.unitkerja_id = t.unitkerja_id ";
        $criteria->addCondition(" kode_rup != '' OR kode_rup is not null ");
        $criteria->compare(" LOWER(instalasi_nama) ", strtolower($this->instalasi_nama), true);
        $criteria->compare(" LOWER(u.namaunitkerja) ", strtolower($this->namaunitkerja), true);
        if ($this->filter) {
            if (!empty($this->instalasi_id)) {
                $criteria->addCondition(" t.instalasi_id = '" . $this->instalasi_id . "' ");
            } else {
                $criteria->addCondition(" rencanaumumpengadaan_id IS NULL ");
            }
            
            if (!empty($this->periodeanggaran_id)) {
                $criteria->addCondition(" periodeanggaran_id = '" . $this->periodeanggaran_id . "' ");
            } else {
                $criteria->addCondition(" rencanaumumpengadaan_id IS NULL ");
            }

            if (!empty($this->rencanaumumpengadaan_kategori)) {
                $criteria->addCondition(" rencanaumumpengadaan_kategori = '" . $this->rencanaumumpengadaan_kategori . "' ");
            } else {
                $criteria->addCondition(" rencanaumumpengadaan_id IS NULL ");
            }
        } else {
            $criteria->addCondition(" rencanaumumpengadaan_id IS NULL ");
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'rencanaumumpengadaan_tanggal DESC'
            )
        ));
    }
    
    /**
     * digunakan untuk menampilkan data informasi rencana umum pengadaan
     * @return \CActiveDataProvider
     */
    public function searchInformasi()
    {
        $criteria=new CDbCriteria;
        
        $criteria->select = "t.*, rencanaumumpengadaan_t.pegawaipembuat_id";
        $criteria->addBetweenCondition('DATE(t.rencanaumumpengadaan_tanggal)',$this->tgl_awal,$this->tgl_akhir);
        $criteria->compare('LOWER(t.instalasi_nama)',strtolower($this->instalasi_nama),true);
        $criteria->compare('LOWER(t.rencanaumumpengadaan_nomor)',strtolower($this->rencanaumumpengadaan_nomor),true);
        $criteria->compare('LOWER(t.nama_pekerjaan)',strtolower($this->nama_pekerjaan),true);
        $criteria->compare('LOWER(t.rencanaumumpengadaan_kategori)',strtolower($this->rencanaumumpengadaan_kategori),true);
        $criteria->compare('LOWER(t.swakelola_tipe)',strtolower($this->swakelola_tipe),true);
        $criteria->compare('LOWER(t.rencanaumumpengadaan_status)',strtolower($this->rencanaumumpengadaan_status),true);
        $criteria->join = "LEFT JOIN rencanaumumpengadaan_t ON t.rencanaumumpengadaan_id = rencanaumumpengadaan_t.rencanaumumpengadaan_id ";
        $criteria->addCondition("t.pegawaipembuat_id = ".Yii::app()->user->getState('pegawai_id')." OR
                                t.pegawaippk_id = ".Yii::app()->user->getState('pegawai_id')." OR
                                t.pegawaipa_id = ".Yii::app()->user->getState('pegawai_id')." OR 
                                t.pegawaikpa_id = ".Yii::app()->user->getState('pegawai_id'));
        if(!empty($this->jenispengadaan_id)){
            $criteria->addCondition('jenis.jenispengadaan_id ='.$this->jenispengadaan_id);
        }
        if(!empty($this->periodeanggaran_id)){
            $criteria->addCondition('t.periodeanggaran_id ='.$this->periodeanggaran_id);
        }
        if(!empty($this->metode_pengadaan)){
            //$criteria->addCondition('t.metode_pengadaan ='.$this->metode_pengadaan);
            $criteria->compare('LOWER(t.metode_pengadaan)',strtolower($this->metode_pengadaan),true);
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
     * digunakan untuk mencetak data informasi rencana umum pengadaan
     * @return \CActiveDataProvider
     */
    public function searchInformasiPrint()
    {
        $criteria=new CDbCriteria;
        
        $criteria->select = "t.*, rencanaumumpengadaan_t.pegawaipembuat_id";
        $criteria->addBetweenCondition('DATE(t.rencanaumumpengadaan_tanggal)',$this->tgl_awal,$this->tgl_akhir);
        $criteria->compare('LOWER(t.instalasi_nama)',strtolower($this->instalasi_nama),true);
        $criteria->compare('LOWER(t.rencanaumumpengadaan_nomor)',strtolower($this->rencanaumumpengadaan_nomor),true);
        $criteria->compare('LOWER(t.nama_pekerjaan)',strtolower($this->nama_pekerjaan),true);
        $criteria->compare('LOWER(t.rencanaumumpengadaan_kategori)',strtolower($this->rencanaumumpengadaan_kategori),true);
        $criteria->compare('LOWER(t.swakelola_tipe)',strtolower($this->swakelola_tipe),true);
        $criteria->compare('LOWER(t.rencanaumumpengadaan_status)',strtolower($this->rencanaumumpengadaan_status),true);
        $criteria->join = "LEFT JOIN rencanaumumpengadaan_t ON t.rencanaumumpengadaan_id = rencanaumumpengadaan_t.rencanaumumpengadaan_id ";
        $criteria->addCondition("t.pegawaipembuat_id = ".Yii::app()->user->getState('pegawai_id')." OR
                                t.pegawaippk_id = ".Yii::app()->user->getState('pegawai_id')." OR
                                t.pegawaipa_id = ".Yii::app()->user->getState('pegawai_id')." OR 
                                t.pegawaikpa_id = ".Yii::app()->user->getState('pegawai_id'));
        if(!empty($this->jenispengadaan_id)){
            $criteria->addCondition('jenis.jenispengadaan_id ='.$this->jenispengadaan_id);
        }
        if(!empty($this->periodeanggaran_id)){
            $criteria->addCondition('t.periodeanggaran_id ='.$this->periodeanggaran_id);
        }
        if(!empty($this->metode_pengadaan)){
            //$criteria->addCondition('t.metode_pengadaan ='.$this->metode_pengadaan);
            $criteria->compare('LOWER(t.metode_pengadaan)',strtolower($this->metode_pengadaan),true);
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