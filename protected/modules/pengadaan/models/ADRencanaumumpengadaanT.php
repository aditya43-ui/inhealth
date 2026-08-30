<?php

/**
 * Model untuk tabel "rencanaumumpengadaan_t" pada module pengadaan
 * 
 * @author Tantowi J <tantowijaya@.com>
 * @author Elham Budianto <elhambudianto@.com>
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @package application.modules.pengadaan
 * @subpackage models
 */
class ADRencanaumumpengadaanT extends RencanaumumpengadaanT {
    
    public $tgl_awal , $tgl_akhir , $instalasi_nama,$jenispengadaan_id,$subkegiatanprogram_nama, $pegawaipa_nama, $pegawaikpa_nama, $pegawaippk_nama, $statusnya;
    public $dpa_pagu_temp, $metodepengadaan_id_awal;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return RencanaumumpengadaanT the static model class
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
        //$criteria->addCondition('tahunanggaran = EXTRACT(YEAR FROM NOW())::text');
        $criteria->addCondition('isclosing_rencanaanggaran IS TRUE');
        $criteria->addCondition('isclosing_closinganggaran IS FALSE');
        $models = PeriodeanggaranK::model()->findAll($criteria);
        if(count((array)$models) > 0){
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
        if(count((array)$models) > 0){
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
        $criteria->addCondition(" kode_rup is not null ");
        $criteria->addCondition(" LOWER(rencanaumumpengadaan_status) ilike '".strtolower(Params::STATUS_RENCANA_UMUM_RUP_DIUMUMKAN)."' ");
        $criteria->addCondition(" lower(rencanaumumpengadaan_kategori) = '".strtolower(Params::KATEGORI_PENGADAAN_PENYEDIA)."' ");
        $criteria->compare(" LOWER(instalasi_nama) ", strtolower($this->instalasi_nama), true);
        $criteria->compare(" LOWER(u.namaunitkerja) ", strtolower($this->namaunitkerja), true);
        $criteria->compare(" LOWER(t.nama_pekerjaan) ", strtolower($this->nama_pekerjaan), true);        
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
            
            if (!empty($this->unitkerja_id)) {
                $criteria->addCondition(" t.unitkerja_id = '" . $this->unitkerja_id . "' ");
            } else {
                $criteria->addCondition(" t.unitkerja_id IS NULL ");
            }
            
            if (!empty($this->pegawaippk_id)) {
                $criteria->addCondition(" pegawaippk_id = '" . $this->pegawaippk_id . "' ");
            } else {
                $criteria->addCondition(" pegawaippk_id IS NULL ");
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
        $criteria->addBetweenCondition('DATE(t.rencanaumumpengadaan_tanggal)',$this->tgl_awal,$this->tgl_akhir);
        $criteria->compare('LOWER(instalasi.instalasi_nama)',strtolower($this->instalasi_nama),true);
        $criteria->compare('LOWER(t.rencanaumumpengadaan_nomor)',strtolower($this->rencanaumumpengadaan_nomor),true);
        $criteria->compare('LOWER(t.nama_pekerjaan)',strtolower($this->nama_pekerjaan),true);
        $criteria->compare('LOWER(t.rencanaumumpengadaan_kategori)',strtolower($this->rencanaumumpengadaan_kategori),true);
        $criteria->compare('LOWER(t.swakelola_tipe)',strtolower($this->swakelola_tipe),true);
        $criteria->compare('LOWER(t.rencanaumumpengadaan_status)',strtolower($this->rencanaumumpengadaan_status),true);
        if(!empty($this->jenispengadaan_id)){
            $criteria->addCondition('jenis.jenispengadaan_id ='.$this->jenispengadaan_id);
        }
        if(!empty($this->periodeanggaran_id)){
            $criteria->addCondition('t.periodeanggaran_id ='.$this->periodeanggaran_id);
        }
        if(!empty($this->metodepengadaan_id)){
            $criteria->addCondition('t.metodepengadaan_id ='.$this->metodepengadaan_id);
        }
        $criteria->select = 't.*,t.rencanaumumpengadaan_id,'
                            .'jenis.jenispengadaan_id,'
                            . 'instalasi.instalasi_nama';
        $criteria->join = ' LEFT JOIN instalasi_m as instalasi ON t.instalasi_id=instalasi.instalasi_id '
                        . ' LEFT JOIN pengadaanjenis_t as pengadaanjenis ON t.rencanaumumpengadaan_id=pengadaanjenis.rencanaumumpengadaan_id '
                        . ' LEFT JOIN jenispengadaan_m as jenis ON pengadaanjenis.jenispengadaan_id=jenis.jenispengadaan_id ';
        $criteria->group = $criteria->select;
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
        $criteria->addBetweenCondition('DATE(t.rencanaumumpengadaan_tanggal)',$this->tgl_awal,$this->tgl_akhir);
        $criteria->compare('LOWER(instalasi.instalasi_nama)',strtolower($this->instalasi_nama),true);
        $criteria->compare('LOWER(t.rencanaumumpengadaan_nomor)',strtolower($this->rencanaumumpengadaan_nomor),true);
        $criteria->compare('LOWER(t.nama_pekerjaan)',strtolower($this->nama_pekerjaan),true);
        $criteria->compare('LOWER(t.rencanaumumpengadaan_kategori)',strtolower($this->rencanaumumpengadaan_kategori),true);
        $criteria->compare('LOWER(t.swakelola_tipe)',strtolower($this->swakelola_tipe),true);
        $criteria->compare('LOWER(t.rencanaumumpengadaan_status)',strtolower($this->rencanaumumpengadaan_status),true);
        if(!empty($this->jenispengadaan_id)){
            $criteria->addCondition('jenis.jenispengadaan_id ='.$this->jenispengadaan_id);
        }
        if(!empty($this->periodeanggaran_id)){
            $criteria->addCondition('t.periodeanggaran_id ='.$this->periodeanggaran_id);
        }
        if(!empty($this->metodepengadaan_id)){
            $criteria->addCondition('t.metodepengadaan_id ='.$this->metodepengadaan_id);
        }
        $criteria->select = 't.*,t.rencanaumumpengadaan_id,'
                            .'jenis.jenispengadaan_id,'
                            . 'instalasi.instalasi_nama';
        $criteria->join = ' LEFT JOIN instalasi_m as instalasi ON t.instalasi_id=instalasi.instalasi_id '
                        . ' LEFT JOIN pengadaanjenis_t as pengadaanjenis ON t.rencanaumumpengadaan_id=pengadaanjenis.rencanaumumpengadaan_id '
                        . ' LEFT JOIN jenispengadaan_m as jenis ON pengadaanjenis.jenispengadaan_id=jenis.jenispengadaan_id ';
        $criteria->group = $criteria->select;
        $criteria->limit=-1;
        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
                'pagination'=>false,
        ));
    }
    
    public function cekPerubahanDPA($postRenDet){
        $getDokPelaksanaan = RencanaumumpengadaandetT::model()->findByAttributes(array('rencanaumumpengadaan_id'=>$this->rencanaumumpengadaan_id));        
        $dokAnggaran = DokumenpelaksanaananggarandetT::model()->findAllByAttributes(array('dokumenpelaksanaananggaran_id'=>$getDokPelaksanaan->dokumenpelaksanaananggarandet->dokumenpelaksanaananggaran_id));
        
        if (count((array)$postRenDet) != count((array)$dokAnggaran)){
            return true;
        }else{
            return false;
        }
    }
}