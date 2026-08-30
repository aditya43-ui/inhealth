<?php

class INPasienM extends PasienM {

//        TIDAK DIGUNAKAN LAGI ?
//        public $noRekamMedik;
//        public $propinsiNama;
//        public $kabupatenNama;
//        public $kecamatanNama;
//        public $kelurahanNama;

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
    public $cekinap = '';
    public $norm_lama_temp;
	public $tgl_awall,$tgl_akhirl;
    public $pasienibu_id;
    public $pendaftaran_id;
    public $carabayar_id, $penjamin_id;
    public $carabayar_nama;
    public $namabayi;
    public $kelahiranbayi_id;
    public $is_domisili_ktp;

    public $pegawai_penanggungjawab_id;
    
    public $diagnosa_nama, $diagnosa_kode;


    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PasienM the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return array validation rules for model attributes.
     * rule dibuat baru karena ada request baru (tidak beradasarkan database) RND-2828
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('kelompokumur_id, kecamatan_id, kabupaten_id, propinsi_id, no_rekam_medik, tgl_rekam_medik, nama_pasien, pekerjaan_id, kelurahan_id, jeniskelamin, tanggal_lahir, alamat_pasien, agama, warga_negara, statusrekammedis, create_time, create_loginpemakai_id', 'required'),
            array('kelompokumur_id, kecamatan_id, kecamatan_domisili_id, pendidikan_id, profilrs_id, kelurahan_id, kelurahan_domisili_id, loginpemakai_id, suku_id, pekerjaan_id, kabupaten_id, kabupaten_domisili_id, propinsi_id, propinsi_domisili_id, dokrekammedis_id, rt, rt_domisili, rw, rw_domisili, anakke, jumlah_bersaudara, pegawai_id', 'numerical', 'integerOnly' => true),
            array('no_rekam_medik, statusrekammedis, norm_lama', 'length', 'max' => 10),
            array('nama_ayah', 'required', 'on' => 'daftar_bayi'),
            array('jenisidentitas, namadepan, jeniskelamin, statusperkawinan, agama, rhesus, no_mobile_pasien', 'length', 'max' => 20),
            array('no_identitas_pasien', 'length', 'max' => 30),
            array('nama_pasien, nama_ibu, nama_ayah', 'length', 'max' => 50),
            array('tempat_lahir, warga_negara', 'length', 'max' => 25),
            array('golongandarah', 'length', 'max' => 2),
            array('no_telepon_pasien', 'length', 'max' => 15),
            array('photopasien', 'length', 'max' => 200),
            array('alamatemail', 'length', 'max' => 100),
            array('update_time, update_loginpemakai_id, tgl_meninggal, ispasienluar, create_ruangan', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('pasien_id, kelompokumur_id, kecamatan_id, kecamatan_domisili_id, pendidikan_id, profilrs_id, kelurahan_id, kelurahan_domisili_id, loginpemakai_id, suku_id, pekerjaan_id, kabupaten_id, kabupaten_domisili_id, propinsi_id, propinsi_domisili_id, dokrekammedis_id, no_rekam_medik, tgl_rekam_medik, jenisidentitas, no_identitas_pasien, namadepan, nama_pasien, nama_bin, jeniskelamin, tempat_lahir, tanggal_lahir, alamat_pasien, alamat_domisili_pasien, rt, rt_domisili, rw, rw_domisili, statusperkawinan, agama, golongandarah, rhesus, anakke, jumlah_bersaudara, no_telepon_pasien, no_mobile_pasien, warga_negara, photopasien, alamatemail, statusrekammedis, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, tgl_meninggal, ispasienluar, create_ruangan, nama_ibu, nama_ayah, norm_lama, pegawai_id', 'safe', 'on' => 'search'),
        );
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
        //$criteria->limit=5;
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            //'pagination'=>false,
        ));
    }

    public function searchDialogBadak() {
        $criteria = $this->criteriaSearch();
        $criteria->join = " LEFT JOIN kecamatan_m ON t.kecamatan_id = kecamatan_m.kecamatan_id
                                             JOIN pegawai_m ON t.pegawai_id = pegawai_m.pegawai_id
                                             LEFT JOIN kelurahan_m ON t.kelurahan_id = kelurahan_m.kelurahan_id ";
        $criteria->compare('LOWER(kecamatan_m.kecamatan_nama)', strtolower($this->cari_kecamatan_nama), true);
        $criteria->compare('LOWER(kelurahan_m.kelurahan_nama)', strtolower($this->cari_kelurahan_nama), true);
        $criteria->compare('LOWER(pegawai_m.nomorindukpegawai)', strtolower($this->nomorindukpegawai), true);
        $criteria->compare('LOWER(t.nama_pasien)', strtolower($this->nama_pasien), true);
        $criteria->compare('LOWER(t.nama_bin)', strtolower($this->nama_bin), true);
        //if(!empty($this->jeniskelamin)){
        $criteria->compare('LOWER(t.jeniskelamin)', strtolower($this->jeniskelamin), true);
        //}
        if ($this->ispasienluar) {
            $criteria->addCondition('ispasienluar = TRUE');
        } else {
            $criteria->addCondition('ispasienluar = FALSE');
        }
        // $criteria->limit=5;
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            //'pagination'=>false,
        ));
    }
    
    public function searchDialogIbu() {
        $criteria=new CDbCriteria;

		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('kelompokumur_id',$this->kelompokumur_id);
		$criteria->compare('kecamatan_id',$this->kecamatan_id);
		$criteria->compare('pendidikan_id',$this->pendidikan_id);
		$criteria->compare('profilrs_id',$this->profilrs_id);
		$criteria->compare('kelurahan_id',$this->kelurahan_id);
		$criteria->compare('loginpemakai_id',$this->loginpemakai_id);
		$criteria->compare('suku_id',$this->suku_id);
		$criteria->compare('pekerjaan_id',$this->pekerjaan_id);
		$criteria->compare('kabupaten_id',$this->kabupaten_id);
		$criteria->compare('propinsi_id',$this->propinsi_id);
		$criteria->compare('dokrekammedis_id',$this->dokrekammedis_id);
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(tgl_rekam_medik)',strtolower($this->tgl_rekam_medik),true);
		$criteria->compare('LOWER(jenisidentitas)',strtolower($this->jenisidentitas),true);
		$criteria->compare('LOWER(no_identitas_pasien)',strtolower($this->no_identitas_pasien),true);
		$criteria->compare('LOWER(namadepan)',strtolower($this->namadepan),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(t.nama_bin)',strtolower($this->nama_bin),true);
		$criteria->compare('LOWER(tempat_lahir)',strtolower($this->tempat_lahir),true);
		//$criteria->compare('DATE(tanggal_lahir)',$format->formatDateTimeForDb($this->tanggal_lahir));
                
                if (!empty($this->tanggal_lahir)){
                    $criteria->addCondition("DATE(tanggal_lahir) = '".$this->tanggal_lahir."' ");
                }
		$criteria->compare('LOWER(alamat_pasien)',strtolower($this->alamat_pasien),true);
		$criteria->compare('t.rt',$this->rt);
		$criteria->compare('t.rw',$this->rw);
		$criteria->compare('LOWER(statusperkawinan)',strtolower($this->statusperkawinan),true);
		$criteria->compare('LOWER(agama)',strtolower($this->agama),true);
		$criteria->compare('LOWER(golongandarah)',strtolower($this->golongandarah),true);
		$criteria->compare('LOWER(rhesus)',strtolower($this->rhesus),true);
		$criteria->compare('anakke',$this->anakke);
		$criteria->compare('jumlah_bersaudara',$this->jumlah_bersaudara);
		$criteria->compare('LOWER(no_telepon_pasien)',strtolower($this->no_telepon_pasien),true);
		$criteria->compare('LOWER(no_mobile_pasien)',strtolower($this->no_mobile_pasien),true);
		$criteria->compare('LOWER(warga_negara)',strtolower($this->warga_negara),true);
		$criteria->compare('LOWER(photopasien)',strtolower($this->photopasien),true);
		$criteria->compare('LOWER(alamatemail)',strtolower($this->alamatemail),true);
		$criteria->compare('LOWER(statusrekammedis)',strtolower($this->statusrekammedis));
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(tgl_meninggal)',strtolower($this->tgl_meninggal),true);
		$criteria->compare('ispasienluar',$this->ispasienluar);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		$criteria->compare('LOWER(nama_ibu)',strtolower($this->nama_ibu),true);
		$criteria->compare('LOWER(nama_ayah)',strtolower($this->nama_ayah),true);
		$criteria->compare('LOWER(norm_lama)',strtolower($this->norm_lama),true);
        
        $criteria->join = " 
            join pendaftaran_t p on p.pasien_id = t.pasien_id
            join carabayar_m cb on cb.carabayar_id = p.carabayar_id
            join persalinan_t ps on ps.pendaftaran_id = p.pendaftaran_id
            join kelahiranbayi_t kl on kl.persalinan_id = ps.persalinan_id
            LEFT JOIN kecamatan_m ON t.kecamatan_id = kecamatan_m.kecamatan_id
                                             LEFT JOIN kelurahan_m ON t.kelurahan_id = kelurahan_m.kelurahan_id ";
        $criteria->compare('LOWER(kecamatan_m.kecamatan_nama)', strtolower($this->cari_kecamatan_nama), true);
        $criteria->compare('LOWER(kelurahan_m.kelurahan_nama)', strtolower($this->cari_kelurahan_nama), true);
        $criteria->compare('LOWER(pegawai_m.nomorindukpegawai)', strtolower($this->nomorindukpegawai), true);
        $criteria->compare('LOWER(t.nama_pasien)', strtolower($this->nama_pasien), true);
        $criteria->compare('LOWER(kl.namabayi)', strtolower($this->namabayi), true);
        $criteria->compare('LOWER(t.nama_bin)', strtolower($this->nama_bin), true);
        $criteria->compare('LOWER(p.no_pendaftaran)', strtolower($this->no_pendaftaran), true);
        $criteria->compare('cb.carabayar_id', $this->carabayar_id);
        //if(!empty($this->jeniskelamin)){
        $criteria->compare('LOWER(kl.jeniskelamin)', strtolower($this->jeniskelamin), true);
        
        $criteria->select = 't.*, ps.tglmelahirkan as tanggal_lahir, p.pendaftaran_id, cb.carabayar_nama, p.no_pendaftaran, '
                . 'kl.kelahiranbayi_id, kl.namabayi, kl.jeniskelamin as jeniskelamin';
        
        // $criteria->compare('p.ruangan_id', Params::RUANGAN_ID_VK);
        $criteria->addCondition('ps.tglmelahirkan is not null');
        $criteria->addCondition('kl.pasien_id is null');
        
        if ($this->ispasienluar) {
            $criteria->addCondition('ispasienluar = TRUE');
        } else {
            $criteria->addCondition('ispasienluar = FALSE');
        }
        
        
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort'=>array(
                'defaultOrder'=>'ps.tglmelahirkan desc',
            )
            //'pagination'=>false,
        ));
    }

    /**
     * menampilkan data informasi pasien
     * @param type $cek mixed array
     * @return CActiveDataProvider 
     */
    //    public function attributeLabels()
	// {
    //        return array(
    //            'tgl_rm_akhir' => 'Tanggal Akhir',
    //            'nama_bin' => 'Nama Panggilan',
    //            'tgl_rekam_medik' => 'Tanggal Rekam Medik'
    //        );
    //    }

    public function searchPasien() {

        $criteria = new CDbCriteria;
        if ($this->tgl_rekam_medik == 1) {
            $criteria->addBetweenCondition('date(tgl_rekam_medik)', $this->tgl_rm_awal, $this->tgl_rm_akhir);
        }
        //            $criteria->addCondition('tgl_rekam_medik BETWEEN \''.$this->tgl_rm_awal.'\' AND \''.$this->tgl_rm_akhir.'\'');
        $criteria->select = 't.tgl_rekam_medik, t.no_rekam_medik, t.pasien_id, t.namadepan, t.nama_pasien, t.tanggal_lahir, t.jeniskelamin, t.alamat_pasien,'
                . ' t.pekerjaan_id, t.agama, t.statusrekammedis';
        
        //RSPMC-969
        if(!empty($this->diagnosa_nama) OR !empty($this->diagnosa_kode)){
            $criteria->join = " JOIN pasienmorbiditas_t AS m ON t.pasien_id = m.pasien_id"
                . " JOIN diagnosa_m AS d ON m.diagnosa_id = d.diagnosa_id";
            $criteria->group = $criteria->select;
            $criteria->compare('LOWER(d.diagnosa_nama)', strtolower($this->diagnosa_nama), true);
            $criteria->compare('LOWER(d.diagnosa_kode)', strtolower($this->diagnosa_kode), true);
        }
        
        if ($this->ceklis) {
			$criteria->addBetweenCondition('DATE(t.tanggal_lahir)', $this->tgl_awall, $this->tgl_akhirl);
		}
		
		$criteria->compare('TRIM(t.no_rekam_medik)', trim($this->no_rekam_medik), true);
        $criteria->compare('LOWER(t.nama_pasien)', strtolower($this->nama_pasien), true);
        $criteria->compare('LOWER(t.nama_bin)', strtolower($this->nama_bin), true);
        if (!empty($this->propinsi_id)) {
            $criteria->addCondition("t.propinsi_id = " . $this->propinsi_id);
        }
        if (!empty($this->kabupaten_id)) {
            $criteria->addCondition("t.kabupaten_id = " . $this->kabupaten_id);
        }
        if (!empty($this->kecamatan_id)) {
            $criteria->addCondition("t.kecamatan_id = " . $this->kecamatan_id);
        }
        if (!empty($this->kelurahan_id)) {
            $criteria->addCondition("t.kelurahan_id = " . $this->kelurahan_id);
        }
        $criteria->compare('LOWER(t.alamat_pasien)', strtolower($this->alamat_pasien), true);
        $criteria->compare('t.statusrekammedis', $this->statusrekammedis);
        $criteria->compare('t.rt', $this->rt);
        $criteria->compare('t.rw', $this->rw);
//        $criteria->with = array('propinsi', 'kabupaten', 'kecamatan', 'kelurahan');
        $criteria->order = 't.tgl_rekam_medik DESC';
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Mengambil daftar semua propinsi
     * @return CActiveDataProvider 
     */
    public function setNip($pegawai_id) {
        $return = PegawaiM::model()->findByPk($pegawai_id);
        return $return->nomorindukpegawai;
    }

    /**
     * Mengambil daftar semua propinsi
     * @return CActiveDataProvider 
     */
    public function getPropinsiItems() {
        return PropinsiM::model()->findAllByAttributes(array('propinsi_aktif' => true), array('order' => 'propinsi_nama'));
    }

    /**
     * Mengambil daftar semua kabupaten berdasarkan propinsi
     * @return CActiveDataProvider 
     */
    public function getKabupatenItems($propinsi_id = null) {
        $criteria = new CDbCriteria();
        if (!empty($propinsi_id)) {
            $criteria->addCondition("propinsi_id = " . $propinsi_id);
        }
        $criteria->compare('kabupaten_aktif', true);
        $criteria->order = 'kabupaten_nama';
        $models = KabupatenM::model()->findAll($criteria);
        return $models;
    }

    /**
     * Mengambil daftar semua kecamatan berdasarkan kabupaten
     * @return CActiveDataProvider 
     */
    public function getKecamatanItems($kabupaten_id = null) {
        $criteria = new CDbCriteria();
        if (!empty($kabupaten_id)) {
            $criteria->addCondition("kabupaten_id = " . $kabupaten_id);
        }
        $criteria->compare('kecamatan_aktif', true);
        $criteria->order = 'kecamatan_nama';
        $models = KecamatanM::model()->findAll($criteria);
        return $models;
    }

    /**
     * Mengambil daftar semua kelurahan berdasarkan kecamatan
     * @return CActiveDataProvider 
     */
    public function getKelurahanItems($kecamatan_id = null) {
        $criteria = new CDbCriteria();
        if (!empty($kecamatan_id)) {
            $criteria->addCondition("kecamatan_id = " . $kecamatan_id);
        }
        $criteria->compare('kelurahan_aktif', true);
        $criteria->order = 'kelurahan_nama';
        $models = KelurahanM::model()->findAll($criteria);
        return $models;
    }

    /**
     * Mengambil daftar semua pendidikan
     * @return CActiveDataProvider 
     */
    public function getPendidikanItems() {
        return PendidikanM::model()->findAllByAttributes(array('pendidikan_aktif' => true), array('order' => 'pendidikan_nama'));
    }

    /**
     * Mengambil daftar semua pekerjaan
     * @return CActiveDataProvider 
     */
    public function getPekerjaanItems() {
        return PekerjaanM::model()->findAllByAttributes(array('pekerjaan_aktif' => true), array('order' => 'pekerjaan_nama'));
    }

    /**
     * Mengambil daftar semua propinsi
     * @return CActiveDataProvider 
     */
    public function getSukuItems() {
        return SukuM::model()->findAllByAttributes(array('suku_aktif' => true), array('order' => 'suku_nama'));
    }

    /**
     * cek umur untuk field (form) umur yang di pisah Thn, Bln, Hr
     * @return boolean
     */
    public function getCekUmurValid() {
        $format = new MyFormatter;
        $tglLahir = $format->formatDateTimeForDb($this->tanggal_lahir);
        $timeLahir = strtotime($tglLahir);
        $now = time();
        $datediff = $now - $timeLahir;
        $umur = floor($datediff / 86400);
        if ($umur > 0)
            return true;
        else
            return false;
    }

    public function searchWithDaerah() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        if (!empty($this->pasien_id)) {
            $criteria->addCondition("pasien_id = " . $this->pasien_id);
        }
        if (!empty($this->pekerjaan_id)) {
            $criteria->addCondition("pekerjaan_id = " . $this->pekerjaan_id);
        }
        if (!empty($this->pendidikan_id)) {
            $criteria->addCondition("pendidikan_id = " . $this->pendidikan_id);
        }
        if (!empty($this->propinsi_id)) {
            $criteria->addCondition("t.propinsi_id = " . $this->propinsi_id);
        }
        if (!empty($this->kabupaten_id)) {
            $criteria->addCondition("t.kabupaten_id = " . $this->kabupaten_id);
        }
        if (!empty($this->kecamatan_id)) {
            $criteria->addCondition("t.kecamatan_id = " . $this->kecamatan_id);
        }
        if (!empty($this->kelurahan_id)) {
            $criteria->addCondition("t.kelurahan_id = " . $this->kelurahan_id);
        }
        $criteria->compare('LOWER(propinsi.propinsi_nama)', strtolower($this->propinsiNama), true);
        $criteria->compare('LOWER(kabupaten.kabupaten_nama)', strtolower($this->kabupatenNama), true);
        $criteria->compare('LOWER(kecamatan.kecamatan_nama)', strtolower($this->kecamatanNama), true);
        $criteria->compare('LOWER(kelurahan.kelurahan_nama)', strtolower($this->kelurahanNama), true);
        if (!empty($this->suku_id)) {
            $criteria->addCondition("suku_id = " . $this->suku_id);
        }
        if (!empty($this->profilrs_id)) {
            $criteria->addCondition("profilrs_id = " . $this->profilrs_id);
        }
        $criteria->compare('LOWER(no_rekam_medik)', strtolower($this->no_rekam_medik), true);
        $criteria->compare('LOWER(tgl_rekam_medik)', strtolower($this->tgl_rekam_medik), true);
        $criteria->compare('LOWER(jenisidentitas)', strtolower($this->jenisidentitas), true);
        $criteria->compare('LOWER(no_identitas_pasien)', strtolower($this->no_identitas_pasien), true);
        $criteria->compare('LOWER(namadepan)', strtolower($this->namadepan), true);
        $criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien), true);
        $criteria->compare('LOWER(nama_bin)', strtolower($this->nama_bin), true);
        $criteria->compare('LOWER(jeniskelamin)', strtolower($this->jeniskelamin), true);
        if (!empty($this->kelompokumur_id)) {
            $criteria->addCondition("kelompokumur_id = " . $this->kelompokumur_id);
        }
        $criteria->compare('LOWER(tempat_lahir)', strtolower($this->tempat_lahir), true);

        if (!empty($this->tanggal_lahir)) {
            $criteria->addCondition("DATE(tanggal_lahir) = '" . MyFormatter::formatDateTimeForDb($this->tanggal_lahir) . "' ");
        }

        $criteria->compare('LOWER(alamat_pasien)', strtolower($this->alamat_pasien), true);
        $criteria->compare('rt', $this->rt);
        $criteria->compare('rw', $this->rw);
        $criteria->compare('LOWER(statusperkawinan)', strtolower($this->statusperkawinan), true);
        $criteria->compare('LOWER(agama)', strtolower($this->agama), true);
        $criteria->compare('LOWER(golongandarah)', strtolower($this->golongandarah), true);
        $criteria->compare('LOWER(rhesus)', strtolower($this->rhesus), true);
        $criteria->compare('anakke', $this->anakke);
        $criteria->compare('jumlah_bersaudara', $this->jumlah_bersaudara);
        $criteria->compare('LOWER(no_telepon_pasien)', strtolower($this->no_telepon_pasien), true);
        $criteria->compare('LOWER(no_mobile_pasien)', strtolower($this->no_mobile_pasien), true);
        $criteria->compare('LOWER(warga_negara)', strtolower($this->warga_negara), true);
        $criteria->compare('LOWER(alamatemail)', strtolower($this->alamatemail), true);
        $criteria->compare('LOWER(statusrekammedis)', strtolower(Params::STATUSREKAMMEDIS_AKTIF), true);
        $criteria->compare('LOWER(tgl_meninggal)', strtolower($this->tgl_meninggal), true);
        $criteria->compare('ispasienluar', 'false');
        $criteria->with = array('propinsi', 'kabupaten', 'kecamatan', 'kelurahan');
        $criteria->order = 'pasien_id DESC';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

        /**
         * pencarian pasien hemodialisa
         * @return \CActiveDataProvider
         */
        public function searchDialogPasienHD()
        {
            $criteria=$this->criteriaSearch();
            $criteria->addCondition('ispasienluar = FALSE'); //agar pasien dengan RM "AP" tidak muncul karen pasien luar RSKG-1478

            $criteria->limit=10;

            return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
                'pagination'=>false,
            ));
        }
    
    /**
     * pencarian data pasien
     * @return \CActiveDataProvider
     */
    public function searchDialog1() {

        $criteria = $this->criteriaSearch();
        // $criteria->limit = 10;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            //'pagination' => false,
        ));
    }

            /**
         * pencarian data pegawai
         * @return \CActiveDataProvider
         */
        public function searchDialogPegawai()
	{
		$criteria=$this->criteriaSearch();
		$criteria->join = " LEFT JOIN kecamatan_m ON t.kecamatan_id = kecamatan_m.kecamatan_id
						JOIN pegawai_m ON t.pegawai_id = pegawai_m.pegawai_id
						LEFT JOIN kelurahan_m ON t.kelurahan_id = kelurahan_m.kelurahan_id ";
		$criteria->compare('LOWER(kecamatan_m.kecamatan_nama)',  strtolower($this->cari_kecamatan_nama), true);
		$criteria->compare('LOWER(kelurahan_m.kelurahan_nama)',  strtolower($this->cari_kelurahan_nama), true);
		$criteria->compare('LOWER(pegawai_m.nomorindukpegawai)',  strtolower($this->nomorindukpegawai), true);
		$criteria->compare('LOWER(t.no_rekam_medik)',  strtolower($this->no_rekam_medik), true);
		$criteria->compare('LOWER(t.nama_pasien)',  strtolower($this->nama_pasien), true);
		$criteria->compare('LOWER(t.nama_bin)',  strtolower($this->nama_bin), true);
		$criteria->compare('LOWER(t.alamat_pasien)',  strtolower($this->alamat_pasien), true);
		if(isset($this->statusrekammedis)){
			$criteria->compare('t.statusrekammedis', $this->statusrekammedis);
		}
		if(isset($this->norm_lama)){
			$criteria->compare('t.norm_lama', $this->norm_lama);
		}
		if(isset($this->rt)){
			$criteria->compare('t.rt', $this->rt);
		}
		if(isset($this->rw)){
			$criteria->compare('t.rw', $this->rw);
		}
		if(!empty($this->jeniskelamin)){
			$criteria->compare('LOWER(t.jeniskelamin)',  strtolower($this->jeniskelamin), true);
		}
		if($this->ispasienluar){
			$criteria->addCondition('ispasienluar = TRUE');
		}else{
			$criteria->addCondition('ispasienluar = FALSE');
		}
		$criteria->limit=5;
		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				'pagination'=>false,
		));
	}
    
        public function getCaraBayarItems()
        {
            return CarabayarM::model()->findAllByAttributes(array('carabayar_aktif'=>true),array('order'=>'carabayar_nama'));
        }
        
        public function getPenjaminItems($carabayar_id=null)
        {
            if(!empty($carabayar_id))
                    return PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id'=>$carabayar_id,'penjamin_aktif'=>true),array('order'=>'penjamin_nama'));
            else
                    return array();
        }
}
