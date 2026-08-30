<?php
class BKLaporanKeseluruhan extends LaporankunjunganrsV {
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function searchPasien()
    {
        $criteria = new CDbCriteria();
        $criteria = $this->functionCriteria();
        $criteria->order = 't.instalasi_nama, t.ruangan_nama';
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria
        ));
    }

    public function searchPasienBelumBayar() {
        $criteria = new CDbCriteria();
        $criteria = $this->functionCriteria(2);
        $criteria->order = 't.instalasi_nama, t.ruangan_nama';
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria
        ));
    }
    
    public function searchPrintLaporan()
    {
        $criteria = new CDbCriteria();
        $criteria = $this->functionCriteria();
        $criteria->order = 't.instalasi_nama, t.ruangan_nama';
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination'=>false,
        ));
    }  

    public function searchPrintLaporanBelumBayar()
    {
        $criteria = new CDbCriteria();
        $criteria = $this->functionCriteria(2);
        $criteria->order = 't.instalasi_nama, t.ruangan_nama';
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination'=>false,
        ));
    }  
    
    protected function functionCriteria($status_bayar = null){
        // $status_bayar -> 1 : Sudah Bayar, 2 : Belum Bayar
        $criteria = new CDbCriteria;
        $criteria->addBetweenCondition('t.tgl_pendaftaran', $this->tgl_awal, $this->tgl_akhir);
        
        if (!empty($status_bayar)) {
            $criteria->join = "left join (
                select r.pendaftaran_id, sum(case when r.tindakansudahbayar_id is null then 1 else 0 end) as totalbelumbayar 
                from rinciantagihapasien_v r 
                group by r.pendaftaran_id
            ) a on a.pendaftaran_id = t.pendaftaran_id";
            
            if ($status_bayar == 1) {
                $criteria->addCondition('a.totalbelumbayar = 0');
            } else if ($status_bayar == 2) {
                $criteria->addCondition('a.totalbelumbayar <> 0');
            }
        }


        if (is_array($this->instalasi_id) && count($this->instalasi_id)) {
            $criteria->addInCondition('t.instalasi_id', $this->instalasi_id);
        }

        if (is_array($this->ruangan_id) && count($this->ruangan_id) > 0) {
            $criteria->addInCondition('t.ruangan_id', $this->ruangan_id);
        }

        return $criteria;
    }
    
    public function getNamaModel() {
        return __CLASS__;
    }
    
    public function getNamaDokter()
    {
        $query = "SELECT pegawai_m.nama_pegawai FROM pegawai_m
        JOIN pendaftaran_t ON pendaftaran_t.pegawai_id = pegawai_m.pegawai_id
        WHERE pendaftaran_id = '". $this->pendaftaran_id ."'
        ";
        $result = YII::app()->db->createCommand($query)->queryRow();
        return empty($result['nama_pegawai']) ? "-" : $result['nama_pegawai'];
    }
    public function getTglKeluar()
    {
        if(!is_null($this->pasienpulang_id))
        {
            $pulang = PasienpulangT::model()->findByPk($this->pasienpulang_id);
        }
        return (isset($pulang['tglpasienpulang']) ? $pulang['tglpasienpulang'] : '-') ;
    }

    public function getNamaPerujuk()
    {
        if($this->statusmasuk == 'RUJUKAN')
        {
            $rujukan = RujukanT::model()->findByPk($this->rujukan_id);
        }
        return (isset($rujukan['nama_perujuk']) ? $rujukan['nama_perujuk'] : '-') ;
    }
    
    public function getDiagnosa()
    {
        $sql = "SELECT * FROM diagnosa_m
            JOIN pasienmorbiditas_t ON pasienmorbiditas_t.diagnosa_id = diagnosa_m.diagnosa_id
            WHERE pasienmorbiditas_t.pendaftaran_id = '". $this->pendaftaran_id ."'
        ";
        $result = YII::app()->db->createCommand($sql)->queryAll();
        $diagnosa = array();
        foreach($result as $val)
        {
            $diagnosa[] = $val['diagnosa_nama'];
        }
        return (count((array)$diagnosa) > 0 ? implode('<br>', $diagnosa) : '-');
    }
}
/*
class BKLaporanKeseluruhan extends PembayaranpelayananT {
    public $tgl_awal;
    public $tgl_akhir;
    public $no_rekam_medik;
    public $no_pendaftaran;
    public $nama_pasien;
    public $nama_bin;
    public $instalasi_id;
    
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function searchPasien()
    {
        $criteria = new CDbCriteria();
        $criteria = $this->functionCriteria();
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false,
        ));
    }
    
    protected function functionCriteria(){
        $criteria = new CDbCriteria;
        $criteria->with = array('pendaftaran');
        $criteria->addBetweenCondition('pendaftaran.tgl_pendaftaran', $this->tgl_awal, $this->tgl_akhir);
        return $criteria;
    }
    
    public function getNamaModel(){
        return __CLASS__;
    }
    
    public function getNamaDokter()
    {
        $query = "SELECT pegawai_m.nama_pegawai FROM pegawai_m
        JOIN pendaftaran_t ON pendaftaran_t.pegawai_id = pegawai_m.pegawai_id
        WHERE pendaftaran_id = '". $this->pendaftaran_id ."'
        ";
        $result = YII::app()->db->createCommand($query)->queryRow();
        return $result['nama_pegawai'];
    }
    
    public function getRuanganPasien()
    {
        $ruangan = RuanganM::model()->findByPk($this->pendaftaran->ruangan_id);
        return $ruangan['ruangan_nama'];
    }
    
    public function getInstalasiPasien()
    {
        $ruangan = RuanganM::model()->findByPk($this->pendaftaran->ruangan_id);
        $instalasi = InstalasiM::model()->findByPk($ruangan['instalasi_id']);
        return $instalasi['instalasi_nama'];
    }

    public function getKelasPasien()
    {
        $kelas = KelaspelayananM::model()->findByPk($this->pendaftaran->kelaspelayanan_id);
        return $kelas['kelaspelayanan_nama'];
    }
    
    public function getTglKeluar()
    {
        if(!is_null($this->pendaftaran->pasienpulang_id))
        {
            $pulang = PasienpulangT::model()->findByPk($this->pendaftaran->pasienpulang_id);
        }
        return (isset($pulang['tglpasienpulang']) ? $pulang['tglpasienpulang'] : '-') ;
    }
    
    public function getNamaPenjamin()
    {
        if(!is_null($this->pendaftaran->penjamin_id))
        {
            $penjamin = PenjaminpasienM::model()->findByPk($this->pendaftaran->penjamin_id);
        }
        return (isset($penjamin['penjamin_nama']) ? $penjamin['penjamin_nama'] : '-') ;
    }
    
    public function getNamaPerujuk()
    {
        if($this->pendaftaran->statusmasuk == 'RUJUKAN')
        {
            $rujukan = RujukanT::model()->findByPk($this->pendaftaran->rujukan_id);
        }
        return (isset($rujukan['nama_perujuk']) ? $rujukan['nama_perujuk'] : '-') ;
    }
    
    public function getDiagnosa()
    {
        $sql = "SELECT * FROM diagnosa_m
            JOIN pasienmorbiditas_t ON pasienmorbiditas_t.diagnosa_id = diagnosa_m.diagnosa_id
            WHERE pasienmorbiditas_t.pendaftaran_id = '". $this->pendaftaran_id ."'
        ";
        $result = YII::app()->db->createCommand($sql)->queryAll();
        $diagnosa = array();
        foreach($result as $val)
        {
            $diagnosa[] = $val['diagnosa_nama'];
        }
        return (count((array)$diagnosa) > 0 ? implode('<br>', $diagnosa) : '-');
    }
}
 * 
 */
