<?php
class BKLaporanCaraBayar extends LaporankunjunganrsV {
    public $pilihan_tab;
    public $jml_rj, $jml_rd, $jml_ri, $jml_pi, $jml_hd, $jml_fisio, $jml_lab, $jml_rad, $jml_ambulans, $jml_pjenazah, $jml_apotek;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function searchPasienUmum()
    {
        $criteria = new CDbCriteria();
        $criteria = $this->functionCriteria();
        $criteria->addCondition('carabayar_id = 1');
        $criteria->order = 'penjamin_nama';
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria
        ));
    }

    public function searchPrintLaporanUmum()
    {
        $criteria = new CDbCriteria();
        $criteria = $this->functionCriteria();
        $criteria->addCondition('carabayar_id = 1');
        $criteria->order = 'penjamin_nama';
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination'=>false,
        ));
    }

    public function rekapPenjaminUmum()
    {
        $criteria = new CDbCriteria();
        $criteria = $this->functionCriteria();
        $criteria->addCondition('carabayar_id = 1');
        $criteria->select = "penjamin_nama, count(case when instalasi_id = 2 then penjamin_id end) as jml_rj,
                              count(case when instalasi_id = 3 then penjamin_id end) as jml_rd,
                              count(case when instalasi_id = 4 then penjamin_id end) as jml_ri,
                              count(case when instalasi_id = 76 then penjamin_id end) as jml_pi,
                              count(case when instalasi_id = 73 then penjamin_id end) as jml_hd,
                              count(case when instalasi_id = 74 then penjamin_id end) as jml_fisio,
                              count(case when instalasi_id = 5 then penjamin_id end) as jml_lab,
                              count(case when instalasi_id = 6 then penjamin_id end) as jml_rad,
                              count(case when instalasi_id = 40 then penjamin_id end) as jml_ambulans,
                              count(case when instalasi_id = 17 then penjamin_id end) as jml_pjenazah,
                              count(case when instalasi_id = 9 then penjamin_id end) as jml_apotek";
        $criteria->order = 'penjamin_nama';
        $criteria->group = 'penjamin_nama';
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria
        ));
    }

    public function printRekapPenjaminUmum()
    {
        $criteria = new CDbCriteria();
        $criteria = $this->functionCriteria();
        $criteria->addCondition('carabayar_id = 1');
        $criteria->select = "penjamin_nama, count(case when instalasi_id = 2 then penjamin_id end) as jml_rj,
                              count(case when instalasi_id = 3 then penjamin_id end) as jml_rd,
                              count(case when instalasi_id = 4 then penjamin_id end) as jml_ri,
                              count(case when instalasi_id = 76 then penjamin_id end) as jml_pi,
                              count(case when instalasi_id = 73 then penjamin_id end) as jml_hd,
                              count(case when instalasi_id = 74 then penjamin_id end) as jml_fisio,
                              count(case when instalasi_id = 5 then penjamin_id end) as jml_lab,
                              count(case when instalasi_id = 6 then penjamin_id end) as jml_rad,
                              count(case when instalasi_id = 40 then penjamin_id end) as jml_ambulans,
                              count(case when instalasi_id = 17 then penjamin_id end) as jml_pjenazah,
                              count(case when instalasi_id = 9 then penjamin_id end) as jml_apotek";
        $criteria->order = 'penjamin_nama';
        $criteria->group = 'penjamin_nama';
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination'=>false,
        ));
    }

    public function searchPasienP3()
    {
        $criteria = new CDbCriteria();
        $criteria = $this->functionCriteria();
        $criteria->addCondition('carabayar_id = 3');
        $criteria->order = 'penjamin_nama';
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria
        ));
    }

    public function rekapPenjaminP3()
    {
        $criteria = new CDbCriteria();
        $criteria = $this->functionCriteria();
        $criteria->addCondition('carabayar_id = 3');
        $criteria->select = "penjamin_nama, count(case when instalasi_id = 2 then penjamin_id end) as jml_rj,
                              count(case when instalasi_id = 3 then penjamin_id end) as jml_rd,
                              count(case when instalasi_id = 4 then penjamin_id end) as jml_ri,
                              count(case when instalasi_id = 76 then penjamin_id end) as jml_pi,
                              count(case when instalasi_id = 73 then penjamin_id end) as jml_hd,
                              count(case when instalasi_id = 74 then penjamin_id end) as jml_fisio,
                              count(case when instalasi_id = 5 then penjamin_id end) as jml_lab,
                              count(case when instalasi_id = 6 then penjamin_id end) as jml_rad,
                              count(case when instalasi_id = 40 then penjamin_id end) as jml_ambulans,
                              count(case when instalasi_id = 17 then penjamin_id end) as jml_pjenazah,
                              count(case when instalasi_id = 9 then penjamin_id end) as jml_apotek";
        $criteria->order = 'penjamin_nama';
        $criteria->group = 'penjamin_nama';
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria
        ));
    }

    public function printRekapPenjaminP3()
    {
        $criteria = new CDbCriteria();
        $criteria = $this->functionCriteria();
        $criteria->addCondition('carabayar_id = 3');
        $criteria->select = "penjamin_nama, count(case when instalasi_id = 2 then penjamin_id end) as jml_rj,
                              count(case when instalasi_id = 3 then penjamin_id end) as jml_rd,
                              count(case when instalasi_id = 4 then penjamin_id end) as jml_ri,
                              count(case when instalasi_id = 76 then penjamin_id end) as jml_pi,
                              count(case when instalasi_id = 73 then penjamin_id end) as jml_hd,
                              count(case when instalasi_id = 74 then penjamin_id end) as jml_fisio,
                              count(case when instalasi_id = 5 then penjamin_id end) as jml_lab,
                              count(case when instalasi_id = 6 then penjamin_id end) as jml_rad,
                              count(case when instalasi_id = 40 then penjamin_id end) as jml_ambulans,
                              count(case when instalasi_id = 17 then penjamin_id end) as jml_pjenazah,
                              count(case when instalasi_id = 9 then penjamin_id end) as jml_apotek";
        $criteria->order = 'penjamin_nama';
        $criteria->group = 'penjamin_nama';
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination'=>false,
        ));
    }

    public function searchPrintLaporanP3()
    {
        $criteria = new CDbCriteria();
        $criteria = $this->functionCriteria();
        $criteria->addCondition('carabayar_id = 3');
        $criteria->order = 'penjamin_nama';
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination'=>false,
        ));
    }

    public function searchPasienBpjs()
    {
        $criteria = new CDbCriteria();
        $criteria = $this->functionCriteria();
        $criteria->addCondition('carabayar_id in (2,20)');
        $criteria->order = 'penjamin_nama';
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria
        ));
    }

    public function searchPrintLaporanBpjs()
    {
        $criteria = new CDbCriteria();
        $criteria = $this->functionCriteria();
        $criteria->addCondition('carabayar_id in (2,20)');
        $criteria->order = 'penjamin_nama';
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination'=>false,
        ));
    }

    public function rekapPenjaminBpjs()
    {
        $criteria = new CDbCriteria();
        $criteria = $this->functionCriteria();
        $criteria->addCondition('carabayar_id in (2,20)');
        $criteria->select = "penjamin_nama, count(case when instalasi_id = 2 then penjamin_id end) as jml_rj,
                              count(case when instalasi_id = 3 then penjamin_id end) as jml_rd,
                              count(case when instalasi_id = 4 then penjamin_id end) as jml_ri,
                              count(case when instalasi_id = 76 then penjamin_id end) as jml_pi,
                              count(case when instalasi_id = 73 then penjamin_id end) as jml_hd,
                              count(case when instalasi_id = 74 then penjamin_id end) as jml_fisio,
                              count(case when instalasi_id = 5 then penjamin_id end) as jml_lab,
                              count(case when instalasi_id = 6 then penjamin_id end) as jml_rad,
                              count(case when instalasi_id = 40 then penjamin_id end) as jml_ambulans,
                              count(case when instalasi_id = 17 then penjamin_id end) as jml_pjenazah,
                              count(case when instalasi_id = 9 then penjamin_id end) as jml_apotek";
        $criteria->order = 'penjamin_nama';
        $criteria->group = 'penjamin_nama';
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria
        ));
    }

    public function printRekapPenjaminBpjs()
    {
        $criteria = new CDbCriteria();
        $criteria = $this->functionCriteria();
        $criteria->addCondition('carabayar_id in (2,20)');
        $criteria->select = "penjamin_nama, count(case when instalasi_id = 2 then penjamin_id end) as jml_rj,
                              count(case when instalasi_id = 3 then penjamin_id end) as jml_rd,
                              count(case when instalasi_id = 4 then penjamin_id end) as jml_ri,
                              count(case when instalasi_id = 76 then penjamin_id end) as jml_pi,
                              count(case when instalasi_id = 73 then penjamin_id end) as jml_hd,
                              count(case when instalasi_id = 74 then penjamin_id end) as jml_fisio,
                              count(case when instalasi_id = 5 then penjamin_id end) as jml_lab,
                              count(case when instalasi_id = 6 then penjamin_id end) as jml_rad,
                              count(case when instalasi_id = 40 then penjamin_id end) as jml_ambulans,
                              count(case when instalasi_id = 17 then penjamin_id end) as jml_pjenazah,
                              count(case when instalasi_id = 9 then penjamin_id end) as jml_apotek";
        $criteria->order = 'penjamin_nama';
        $criteria->group = 'penjamin_nama';
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination'=>false,
        ));
    }

    protected function functionCriteria(){
        $criteria = new CDbCriteria;
        $criteria->addBetweenCondition('date(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
        // $criteria->compare('ruangan_id', $this->ruangan_id);

        if(is_array($this->instalasi_id)){
          $criteria->addInCondition('instalasi_id',$this->instalasi_id);
        }else{
          if(!empty($this->instalasi_id)){
            $criteria->addCondition('instalasi_id = '.$this->instalasi_id);
          }
        }

        return $criteria;
    }

    public function getNamaModel() {
        return __CLASS__;
    }

    public function getNamaDokter()
    {
      $daftar = PendaftaranT::model()->findByPK($this->pendaftaran_id);

        return (isset($daftar)? (isset($daftar->pegawai)? $daftar->pegawai->namaLengkap: "") : "");
    }

    public function getTglKeluar()
    {

        if(!empty($this->pasienpulang_id))
        {
            $pulang = PasienpulangT::model()->findByPk($this->pasienpulang_id);
            return (isset($pulang) ? MyFormatter::formatDateTimeForUser($pulang->tglpasienpulang) : '-') ;
        }else{
          $daftar = PendaftaranT::model()->findByPK($this->pendaftaran_id);
          $pembyr = PembayaranpelayananT::model()->findByAttributes(array('pendaftaran_id'=>$daftar->pendaftaran_id, 'pasienadmisi_id'=>$daftar->pasienadmisi_id));
          return (isset($pembyr) ? MyFormatter::formatDateTimeForUser($pembyr->tglpembayaran) : '-') ;
        }
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
