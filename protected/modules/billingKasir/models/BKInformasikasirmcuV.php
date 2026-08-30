<?php

class BKInformasikasirmcuV extends InformasikasirmcuV {

    public $tgl_awal, $tgl_akhir;
    public $instalasi_id;
    public $statusBayar;
    public $total_belum;
    public $total_oa_belum;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function searchDialogKunjungan() {
        $format = new MyFormatter();
        $criteria = new CDbCriteria();


        $ruangan = CHtml::listData(RuanganM::model()->findAllByAttributes(array(
                            'instalasi_id' => $this->instalasi_id
                        )), 'ruangan_id', 'ruangan_id');

        if (!in_array($this->ruangan_id, $ruangan)) {
            $this->ruangan_id = null;
        }

        $criteria->compare('pendaftaran_id', $this->pendaftaran_id);
        $criteria->compare('LOWER(no_pendaftaran)', strtolower($this->no_pendaftaran), true);
        $criteria->compare('LOWER(no_rekam_medik)', strtolower($this->no_rekam_medik), true);
        $criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien), true);
        $criteria->compare('LOWER(ruangan_nama)', strtolower($this->ruangan_nama), true);
        $criteria->compare('LOWER(jeniskelamin)', strtolower($this->jeniskelamin), true);
        $criteria->compare('LOWER(no_identitas_pasien)', strtolower($this->no_identitas_pasien), true);
        if(!empty($this->statusperiksa)){
            $criteria->compare('LOWER(statusperiksa)', strtolower($this->statusperiksa), true);
        }else{
            $criteria->addCondition("statusperiksa = '" . Params::STATUSPERIKSA_SUDAH_DIPERIKSA . "'");
        }
        
        $criteria->compare('(ruangan_id)', ($this->ruangan_id));

        $criteria->addCondition("statusperiksa <> '" . Params::STATUSPERIKSA_BATAL_PERIKSA . "'");
        if (!empty($this->carabayar_id)) {
            $criteria->addCondition('carabayar_id = ' . $this->carabayar_id);
        }
        $criteria->order = 'tgl_pendaftaran DESC';

        if (!empty($this->tgl_awal) && !empty($this->tgl_akhir)) {
            $criteria->addBetweenCondition('tgl_pendaftaran::date', $this->tgl_awal, $this->tgl_akhir);
        }

        //var_dump($criteria); die;
        // $criteria->limit = 5;
//        if ($this->instalasi_id == Params::INSTALASI_ID_RJ) {
//            $model = new BKInformasikasirrawatjalanV;
//            $criteria->addCondition('alihstatus = false');
//        } else if ($this->instalasi_id == Params::INSTALASI_ID_RD) {
//            $model = new BKInformasikasirrdpulangV;
//            $criteria->addCondition('alihstatus = false');
//            $criteria->addCondition('pasienadmisi_id is null');
//        } else if ($this->instalasi_id == Params::INSTALASI_ID_RI) {
//            $model = new BKInformasikasirinappulangV;
//            $criteria->addCondition('(tglpasienpulang is null or carakeluar_id = 4)');
//        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
                // 'pagination'=>false,
        ));
    }
    
     public function getTanggal()
        {
            $format = new MyFormatter(); 
            return $format->formatDateTimeForUser($this->tgl_pendaftaran);
        }

}
