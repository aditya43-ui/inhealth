<?php

class ARPasienM extends PasienM {

    public $no_pendaftaran;
    public $tgl_pendaftaran;
    public $tgl_admisi;
    public $tgl_rm_awal;
    public $tgl_rm_akhir;
    public $jeniskasuspenyakit_nama;
    public $ceklis;
    public $umur, $thn, $bln, $hr; //untuk pendaftaran.umur
    public $isPasienLama = false;
    public $propinsiNama, $kabupatenNama, $kecamatanNama, $kelurahanNama;
    public $cari_kelurahan_nama, $cari_kecamatan_nama; //filter pencarian
    public $nomorindukpegawai, $nama_pegawai, $pegawai_aktif;
    public $instalasi_nama, $instalasi_id, $ruangan_nama, $carabayar_nama;
    public $dari = 'dialog';

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PasienM the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * untuk menampilkan data pada grid dialog pasien
     * @return \CActiveDataProvider
     */
    public function searchDialog() {
        $criteria = $this->criteriaSearch();
        $criteria->join = " LEFT JOIN kecamatan_m ON t.kecamatan_id = kecamatan_m.kecamatan_id
							LEFT JOIN kelurahan_m ON t.kelurahan_id = kelurahan_m.kelurahan_id ";
        $criteria->compare('LOWER(kecamatan_m.kecamatan_nama)', strtolower($this->cari_kecamatan_nama), true);
        $criteria->compare('LOWER(kelurahan_m.kelurahan_nama)', strtolower($this->cari_kelurahan_nama), true);
        if ($this->ispasienluar) {
            $criteria->addCondition('ispasienluar = TRUE');
        } else {
            $criteria->addCondition('ispasienluar = FALSE');
        }
        $criteria->limit = 5;
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false,
        ));
    }

    /**
     * searchDialogKunjungan menampilkan pasien rumah sakit dari view database
     * @return \CActiveDataProvider
     */
    public function searchDialogKunjungan() {
        $format = new MyFormatter;
        $model = null;
        $criteria = new CDbCriteria();
        $criteria->compare('LOWER(no_pendaftaran)', strtolower($this->no_pendaftaran), true);
//        $this->tgl_pendaftaran = !empty($this->tgl_pendaftaran) ? $format->formatDateTimeForDb($this->tgl_pendaftaran) : date("Y-m-d");
        $tgl_pendaftaran = array(date('Y-m-d'),date('Y-m-d'));
        if (!empty($this->tgl_pendaftaran)) {
            $tgl_pendaftaran = $this->getKonverviDateRange($this->tgl_pendaftaran);
        }

        // var_dump($this->tgl_pendaftaran, $tgl_pendaftaran); die;
        
        $criteria->compare('LOWER(no_rekam_medik)', strtolower($this->no_rekam_medik), true);
        $criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien), true);
        $criteria->compare('LOWER(jeniskelamin)', strtolower($this->jeniskelamin), true);
        if (!empty($this->instalasi_id)) {
            $criteria->addCondition("instalasi_id = " . $this->instalasi_id);
        }
        $criteria->compare('LOWER(ruangan_nama)', strtolower($this->ruangan_nama), true);
        $criteria->compare('LOWER(instalasi_nama)', strtolower($this->instalasi_nama), true);
        $criteria->compare('LOWER(carabayar_nama)', strtolower($this->carabayar_nama), true);
        $criteria->compare('LOWER(alamat_pasien)', strtolower($this->alamat_pasien), true);
        $criteria->addCondition('carabayar_id = '.Params::CARABAYAR_ID_BPJS);
        $criteria->limit = 5;
        if ($this->instalasi_id == Params::INSTALASI_ID_RD) {
            if ($this->dari == 'dialog'){
                $criteria->addBetweenCondition('DATE(tgl_pendaftaran)', $tgl_pendaftaran[0], $tgl_pendaftaran[1]);
            }
            $model = new InfokunjunganrdV;
        } else if ($this->instalasi_id == Params::INSTALASI_ID_RJ) {
            if ($this->dari == 'dialog'){
                $criteria->addBetweenCondition('DATE(tgl_pendaftaran)', $tgl_pendaftaran[0], $tgl_pendaftaran[1]);
            }
            $model = new InfokunjunganrjV;
        } else if ($this->instalasi_id == Params::INSTALASI_ID_FISIOTERAPI) {
            if ($this->dari == 'dialog'){
                $criteria->addBetweenCondition('DATE(tgl_pendaftaran)', $tgl_pendaftaran[0], $tgl_pendaftaran[1]);
            }
            $criteria->compare('lower(no_pendaftaran)', 'rm', true);
            $model = new PasienmasukpenunjangV;
        } else if ($this->instalasi_id == Params::INSTALASI_ID_HD) {
            if ($this->dari == 'dialog'){
                $criteria->addBetweenCondition('DATE(tgl_pendaftaran)', $tgl_pendaftaran[0], $tgl_pendaftaran[1]);
            }
            $criteria->compare('lower(no_pendaftaran)', 'rm', true);
            $model = new InfokunjunganhdV;
        } else {
            if ($this->dari == 'dialog'){
                $criteria->addBetweenCondition('DATE(tgl_pendaftaran)', $tgl_pendaftaran[0], $tgl_pendaftaran[1]);
            }
            $model = new InfokunjunganriV;
        }
        // echo '<pre>';
        // var_dump($criteria, $model, $this->instalasi_id, $this->dari);
        // die;
//        $this->tgl_pendaftaran = $format->formatDateTimeForUser($this->tgl_pendaftaran);
        return new CActiveDataProvider($model, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSIze'=>5
            ),
        ));
    }
    
    public function getKonverviDateRange($tgl){
       
        $Tgl = (explode(" - ",$tgl));

        $Tgl[0] = DateTime::createFromFormat('m/d/Y', $Tgl[0]);
        $Tgl[0] = $Tgl[0]->format('Y-m-d');
        $Tgl[1] = DateTime::createFromFormat('m/d/Y', $Tgl[1]);
        $Tgl[1] = $Tgl[1]->format('Y-m-d');

        
        return array($Tgl[0],$Tgl[1]);
    }

}
