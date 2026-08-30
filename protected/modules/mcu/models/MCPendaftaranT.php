<?php

/**
 * model pendaftaran_t digunakan pada transaksi pendaftaran
 * @author rusdiyanto <rusdiyanto@.com>
 * @author Andyka Putra <andykaputra@.com>
 * @package application.models
 */
class MCPendaftaranT extends PendaftaranT {

    public $is_adapjpasien = 0;
    public $is_pasienrujukan = 0;
    public $is_adakarcis = 0;
    public $is_bayarkarcis = 0;
    public $is_pasienkecelakaan = 0;
    public $is_adasample = 0;
    public $is_bpjs = 0;
    public $tgl_awal, $tgl_akhir;
    public $no_rekam_medik, $nama_pasien, $alamat_pasien, $dokter, $kecamatan_nama, $jumlahpasien, $longitude, $latitude;
    public $instalasi_nama, $ruangan_nama, $gelardepan, $gelarbelakang_nama, $carabayar_nama, $penjamin_nama;
    public $jumlah, $tahun, $bulan, $hari;
    public $buatjanjipoli_id;
    public $is_vaksinasi = 0;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PendaftaranT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return array validation rules for model attributes.
     * penambahan required
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('kelompokumur_id, no_pendaftaran, tgl_pendaftaran, no_urutantri, statuspasien, kunjungan, statusmasuk, umur, create_time, create_loginpemakai_id, pegawai_id, ruangan_id, jeniskasuspenyakit_id, kelaspelayanan_id, carabayar_id, penjamin_id', 'required'),
            array('pasienpulang_id, pasienbatalperiksa_id, penanggungjawab_id, penjamin_id, shift_id, pasien_id, persalinan_id, pegawai_id, instalasi_id, caramasuk_id, pengirimanrm_id, peminjamanrm_id, jeniskasuspenyakit_id, pembayaranpelayanan_id, kelaspelayanan_id, carabayar_id, pasienadmisi_id, kelompokumur_id, golonganumur_id, rujukan_id, antrian_id, karcis_id, ruangan_id', 'numerical', 'integerOnly' => true),
            array('no_pendaftaran', 'length', 'max' => 20),
            array('no_urutantri', 'length', 'max' => 6),
            array('transportasi, keadaanmasuk, statusperiksa, statuspasien, kunjungan, statusmasuk, status_konfirmasi', 'length', 'max' => 50),
            array('umur', 'length', 'max' => 30),
            array('alihstatus, byphone, kunjunganrumah, tglselesaiperiksa, keterangan_reg, update_time, update_loginpemakai_id, create_ruangan, nopendaftaran_aktif, tgl_konfirmasi, tglrenkontrol, statusfarmasi', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('pendaftaran_id, pasienpulang_id, pasienbatalperiksa_id, penanggungjawab_id, penjamin_id, shift_id, pasien_id, persalinan_id, pegawai_id, instalasi_id, caramasuk_id, pengirimanrm_id, peminjamanrm_id, jeniskasuspenyakit_id, pembayaranpelayanan_id, kelaspelayanan_id, carabayar_id, pasienadmisi_id, kelompokumur_id, golonganumur_id, rujukan_id, antrian_id, karcis_id, ruangan_id, no_pendaftaran, tgl_pendaftaran, no_urutantri, transportasi, keadaanmasuk, statusperiksa, statuspasien, kunjungan, alihstatus, byphone, kunjunganrumah, statusmasuk, umur, tglselesaiperiksa, keterangan_reg, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, nopendaftaran_aktif, status_konfirmasi, tgl_konfirmasi, tglrenkontrol, statusfarmasi', 'safe', 'on' => 'search'),
        );
    }

    /**
     * Mengambil daftar semua ruangan
     * @param type $instalasi_id
     * @return type
     */
    public function getRuanganItems($instalasi_id = null) {
        $criteria = new CDbCriteria();
        if (!empty($instalasi_id)) {
            $criteria->addCondition("instalasi_id= " . $instalasi_id);
        }
        $criteria->addCondition('ruangan_aktif = true');
        $criteria->order = "ruangan_nama";
        return RuanganM::model()->findAll($criteria);
    }

    /**
     * Mengambil daftar semua ruangan
     * @return CActiveDataProvider 
     */
    public function getRuanganPenunjangItems() {
        $criteria = new CDbCriteria();
        $criteria->addCondition('ruangan_aktif = true');
        $criteria->order = "ruangan_nama";
        return RuanganpenunjangV::model()->findAll($criteria);
    }

    /**
     * mengambil data jenis kasus penyakit berdasarkan ruangan
     * @param type $ruangan_id
     */
    public function getJenisKasusPenyakitItems($ruangan_id = null) {
        if ($ruangan_id == '') {
            $ruangan_id = Yii::app()->user->getState('ruangan_id');
        }
        $criteria = new CdbCriteria();
        $criteria->addCondition('kasuspenyakitruangan_m.ruangan_id = ' . $ruangan_id);
        $criteria->addCondition('t.jeniskasuspenyakit_aktif = true');
        $criteria->order = "t.jeniskasuspenyakit_nama";
        $criteria->join = "JOIN kasuspenyakitruangan_m ON t.jeniskasuspenyakit_id = kasuspenyakitruangan_m.jeniskasuspenyakit_id";
        return JeniskasuspenyakitM::model()->findAll($criteria);
    }

    public function getJenisKasusPenyakitMCU($ruangan_id = null, $jenis_penyakit = null) {
        if ($ruangan_id == '') {
            $ruangan_id = Yii::app()->user->getState('ruangan_id');
        }
        $criteria = new CdbCriteria();
        $criteria->addCondition('kasuspenyakitruangan_m.ruangan_id = ' . $ruangan_id);
        // $criteria->addCondition('kasuspenyakitruangan_m.jeniskasuspenyakit_id = ' . $jenis_penyakit);
        $criteria->addCondition('t.jeniskasuspenyakit_aktif = true');
        $criteria->order = "t.jeniskasuspenyakit_nama";
        $criteria->join = "JOIN kasuspenyakitruangan_m ON t.jeniskasuspenyakit_id = kasuspenyakitruangan_m.jeniskasuspenyakit_id";
        // var_dump($criteria);die;
        return JeniskasuspenyakitM::model()->findAll($criteria);
    }

    /**
     * Mengambil daftar semua kelaspelayanan berdasarkan ruangan_id
     * @param type $ruangan_id
     * @return type
     */
    public static function getKelasPelayananItems($ruangan_id = null) {
        if ($ruangan_id == null) {
            return array();
        } else {
            $criteria = new CdbCriteria();
            $criteria->join = "JOIN kelasruangan_m on t.kelaspelayanan_id = kelasruangan_m.kelaspelayanan_id";
            $criteria->addCondition('t.kelaspelayanan_aktif = true');
            $criteria->addCondition('kelasruangan_m.ruangan_id =' . $ruangan_id);
            $criteria->order = "t.urutankelas";
            return KelaspelayananM::model()->findAll($criteria);
        }
    }

    /**
     * Mengambil daftar semua kelaspelayanan
     * @return CActiveDataProvider 
     */
    public static function getKelasPelayananItemsMCU() {
        $criteria = new CdbCriteria();
        $criteria->addCondition('t.kelaspelayanan_aktif = true');
        $criteria->addInCondition('t.kelaspelayanan_id', array(Params::KELASPELAYANAN_ID_TANPA_KELAS_MCU, Params::KELASPELAYANAN_ID_VVIP));
        $criteria->order = "t.urutankelas";
        return KelaspelayananM::model()->findAll($criteria);
    }

    /**
     * Mengambil daftar semua kelaspelayanan
     * @return CActiveDataProvider 
     */
    public function getKelasTanggunganItems() {
        return KelaspelayananM::model()->findAllByAttributes(array('kelaspelayanan_aktif' => true), array('order' => 'urutankelas'));
    }

    /**
     * Mengambil daftar semua carabayar
     * @return CActiveDataProvider 
     */
    public function getCaraBayarItems() {
        return CarabayarM::model()->findAllByAttributes(array('carabayar_aktif' => true), array('order' => 'carabayar_nourut'));
    }

    /**
     * Mengambil daftar semua penjamin
     * @param type $carabayar_id
     * @return type
     */
    public function getPenjaminItems($carabayar_id = null) {
        if (!empty($carabayar_id))
            return PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id' => $carabayar_id, 'penjamin_aktif' => true), array('order' => 'penjamin_nama'));
        else
            return array();
    }

    /**
     * menampilkan dokter 
     * @param type $ruangan_id
     * @return type
     */
    public function getDokterItems($ruangan_id = '') {
        $criteria = new CdbCriteria();
        if (!empty($ruangan_id)) {
            $criteria->addCondition("ruangan_id= " . $ruangan_id);
        }
        $criteria->addCondition('pegawai_aktif = true');
        $criteria->order = "nama_pegawai, gelardepan";
        $modDokter = DokterV::model()->findAll($criteria);
        return $modDokter;
    }

    /**
     * @return array validation rules for model attributes.
     * penambahan required
     */
    public function criteriaSearch() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->with = array('pasien');

        $criteria->addBetweenCondition('DATE(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);

        if (!empty($this->pendaftaran_id)) {
            $criteria->addCondition("pendaftaran_id= " . $this->pendaftaran_id);
        }
        if (!empty($this->pasienpulang_id)) {
            $criteria->addCondition("pasienpulang_id= " . $this->pasienpulang_id);
        }
        if (!empty($this->pasienbatalperiksa_id)) {
            $criteria->addCondition("pasienbatalperiksa_id= " . $this->pasienbatalperiksa_id);
        }
        if (!empty($this->penanggungjawab_id)) {
            $criteria->addCondition("penanggungjawab_id= " . $this->penanggungjawab_id);
        }
        if (!empty($this->penjamin_id)) {
            $criteria->addCondition("penjamin_id= " . $this->penjamin_id);
        }
        if (!empty($this->shift_id)) {
            $criteria->addCondition("shift_id= " . $this->shift_id);
        }
        if (!empty($this->pasien_id)) {
            $criteria->addCondition("pasien_id= " . $this->pasien_id);
        }
        if (!empty($this->persalinan_id)) {
            $criteria->addCondition("persalinan_id= " . $this->persalinan_id);
        }
        if (!empty($this->pegawai_id)) {
            $criteria->addCondition("pegawai_id= " . $this->pegawai_id);
        }
        if (!empty($this->instalasi_id)) {
            $criteria->addCondition("instalasi_id= " . $this->instalasi_id);
        }
        if (!empty($this->caramasuk_id)) {
            $criteria->addCondition("caramasuk_id= " . $this->caramasuk_id);
        }
        if (!empty($this->pengirimanrm_id)) {
            $criteria->addCondition("pengirimanrm_id= " . $this->pengirimanrm_id);
        }
        if (!empty($this->peminjamanrm_id)) {
            $criteria->addCondition("peminjamanrm_id= " . $this->peminjamanrm_id);
        }
        if (!empty($this->jeniskasuspenyakit_id)) {
            $criteria->addCondition("jeniskasuspenyakit_id= " . $this->jeniskasuspenyakit_id);
        }
        if (!empty($this->pembayaranpelayanan_id)) {
            $criteria->addCondition("pembayaranpelayanan_id= " . $this->pembayaranpelayanan_id);
        }
        if (!empty($this->kelaspelayanan_id)) {
            $criteria->addCondition("kelaspelayanan_id= " . $this->kelaspelayanan_id);
        }
        if (!empty($this->carabayar_id)) {
            $criteria->addCondition("carabayar_id= " . $this->carabayar_id);
        }
        if (!empty($this->pasienadmisi_id)) {
            $criteria->addCondition("pasienadmisi_id= " . $this->pasienadmisi_id);
        }
        if (!empty($this->kelompokumur_id)) {
            $criteria->addCondition("kelompokumur_id= " . $this->kelompokumur_id);
        }
        if (!empty($this->golonganumur_id)) {
            $criteria->addCondition("golonganumur_id= " . $this->golonganumur_id);
        }
        if (!empty($this->rujukan_id)) {
            $criteria->addCondition("rujukan_id= " . $this->rujukan_id);
        }
        if (!empty($this->antrian_id)) {
            $criteria->addCondition("antrian_id= " . $this->antrian_id);
        }
        if (!empty($this->karcis_id)) {
            $criteria->addCondition("karcis_id= " . $this->karcis_id);
        }
        if (!empty($this->ruangan_id)) {
            $criteria->addCondition("ruangan_id= " . $this->ruangan_id);
        }
        $criteria->compare('LOWER(no_pendaftaran)', strtolower($this->no_pendaftaran), true);
        $criteria->compare('LOWER(tgl_pendaftaran)', strtolower($this->tgl_pendaftaran), true);
        $criteria->compare('LOWER(no_urutantri)', strtolower($this->no_urutantri), true);
        $criteria->compare('LOWER(transportasi)', strtolower($this->transportasi), true);
        $criteria->compare('LOWER(keadaanmasuk)', strtolower($this->keadaanmasuk), true);
        $criteria->compare('LOWER(statusperiksa)', strtolower($this->statusperiksa), true);
        $criteria->compare('LOWER(statuspasien)', strtolower($this->statuspasien), true);
        $criteria->compare('LOWER(kunjungan)', strtolower($this->kunjungan), true);
        $criteria->compare('alihstatus', $this->alihstatus);
        $criteria->compare('byphone', $this->byphone);
        $criteria->compare('kunjunganrumah', $this->kunjunganrumah);
        $criteria->compare('LOWER(statusmasuk)', strtolower($this->statusmasuk), true);
        $criteria->compare('LOWER(umur)', strtolower($this->umur), true);
        $criteria->compare('LOWER(tglselesaiperiksa)', strtolower($this->tglselesaiperiksa), true);
        $criteria->compare('LOWER(keterangan_reg)', strtolower($this->keterangan_reg), true);
        $criteria->compare('LOWER(create_time)', strtolower($this->create_time), true);
        $criteria->compare('LOWER(update_time)', strtolower($this->update_time), true);
        $criteria->compare('LOWER(create_loginpemakai_id)', strtolower($this->create_loginpemakai_id), true);
        $criteria->compare('LOWER(update_loginpemakai_id)', strtolower($this->update_loginpemakai_id), true);
        $criteria->compare('LOWER(create_ruangan)', strtolower($this->create_ruangan), true);
        $criteria->compare('nopendaftaran_aktif', $this->nopendaftaran_aktif);
        $criteria->compare('LOWER(status_konfirmasi)', strtolower($this->status_konfirmasi), true);
        $criteria->compare('LOWER(tgl_konfirmasi)', strtolower($this->tgl_konfirmasi), true);
        $criteria->compare('LOWER(tglrenkontrol)', strtolower($this->tglrenkontrol), true);
        $criteria->compare('LOWER(pasien.no_rekam_medik)', strtolower($this->no_rekam_medik), true);
        $criteria->compare('LOWER(pasien.nama_pasien)', strtolower($this->nama_pasien), true);
        $criteria->compare('LOWER(pasien.alamat_pasien)', strtolower($this->alamat_pasien), true);
        $criteria->compare('statusfarmasi', $this->statusfarmasi);

        return $criteria;
    }

    /**
     * menampilkan riwayat pendaftaran pasien di:
     * - pendaftaran RJ
     * - pendaftaran RD
     * - pendaftaran RI
     * @param type $pasien_id
     * @return type
     */
    public function searchRiwayatPasien($pasien_id) {
        if (!empty($pasien_id)) {
            $condition = " AND pasien_m.pasien_id = " . $pasien_id;
        } else {
            $condition = " ";
        }

        $startDate = date('Y-m-d', strtotime('today - 6 months'));
        $endDate = date('Y-m-d');

        $model = CActiveRecord::findAllBySql("SELECT * FROM (SELECT pasien_m.pasien_id, pasien_m.jenisidentitas, pasien_m.no_identitas_pasien, pasien_m.namadepan, pasien_m.nama_pasien, pasien_m.nama_bin AS alias, pasien_m.jeniskelamin, pasien_m.tempat_lahir, pasien_m.tanggal_lahir, pasien_m.alamat_pasien, pasien_m.rt, pasien_m.rw, pasien_m.agama, pasien_m.golongandarah, pasien_m.photopasien, pasien_m.alamatemail, pasien_m.statusrekammedis, pasien_m.statusperkawinan, pasien_m.no_rekam_medik, pasien_m.tgl_rekam_medik, pendaftaran_t.pendaftaran_id, pendaftaran_t.no_pendaftaran, pendaftaran_t.tgl_pendaftaran, pendaftaran_t.no_urutantri, pendaftaran_t.transportasi, pendaftaran_t.keadaanmasuk, pendaftaran_t.statusperiksa, pendaftaran_t.statuspasien, pendaftaran_t.kunjungan, pendaftaran_t.alihstatus, pendaftaran_t.byphone, pendaftaran_t.kunjunganrumah, pendaftaran_t.statusmasuk, pendaftaran_t.umur, asuransipasien_m.nokartuasuransi AS no_asuransi, asuransipasien_m.namapemilikasuransi AS namapemilik_asuransi, asuransipasien_m.nomorpokokperusahaan AS nopokokperusahaan, pendaftaran_t.create_time, pendaftaran_t.create_loginpemakai_id, pendaftaran_t.create_ruangan, carabayar_m.carabayar_id, carabayar_m.carabayar_nama, penjaminpasien_m.penjamin_id, penjaminpasien_m.penjamin_nama, caramasuk_m.caramasuk_id, caramasuk_m.caramasuk_nama, pendaftaran_t.shift_id, golonganumur_m.golonganumur_id, golonganumur_m.golonganumur_nama, rujukan_t.no_rujukan, rujukan_t.nama_perujuk, rujukan_t.tanggal_rujukan, rujukan_t.diagnosa_rujukan, asalrujukan_m.asalrujukan_id, asalrujukan_m.asalrujukan_nama, penanggungjawab_m.penanggungjawab_id, penanggungjawab_m.pengantar, penanggungjawab_m.hubungankeluarga, penanggungjawab_m.nama_pj, ruangan_m.ruangan_id, ruangan_m.ruangan_nama, ruangan_m.ruangan_singkatan, instalasi_m.instalasi_id, instalasi_m.instalasi_nama, jeniskasuspenyakit_m.jeniskasuspenyakit_id, jeniskasuspenyakit_m.jeniskasuspenyakit_nama, kelaspelayanan_m.kelaspelayanan_id, kelaspelayanan_m.kelaspelayanan_nama, pegawai_m.gelardepan, pegawai_m.nama_pegawai, gelarbelakang_m.gelarbelakang_nama, NULL::integer AS pasienadmisi_id, NULL::integer AS masukkamar_id, NULL::character varying AS kamarruangan_nokamar, asuransipasien_m.tglcetakkartuasuransi, asuransipasien_m.kodefeskestk1, asuransipasien_m.nama_feskestk1, asuransipasien_m.masaberlakukartu, asuransipasien_m.nokartukeluarga, asuransipasien_m.nopassport, asuransipasien_m.status_konfirmasi, asuransipasien_m.tgl_konfirmasi, asuransipasien_m.asuransipasien_aktif, pendaftaran_t.keterangan_pendaftaran
           FROM pasien_m
      JOIN pendaftaran_t ON pasien_m.pasien_id = pendaftaran_t.pasien_id
   JOIN kelaspelayanan_m ON pendaftaran_t.kelaspelayanan_id = kelaspelayanan_m.kelaspelayanan_id
   JOIN carabayar_m ON pendaftaran_t.carabayar_id = carabayar_m.carabayar_id
   JOIN penjaminpasien_m ON pendaftaran_t.penjamin_id = penjaminpasien_m.penjamin_id
   LEFT JOIN caramasuk_m ON pendaftaran_t.caramasuk_id = caramasuk_m.caramasuk_id
   JOIN golonganumur_m ON pendaftaran_t.golonganumur_id = golonganumur_m.golonganumur_id
   LEFT JOIN rujukan_t ON pendaftaran_t.rujukan_id = rujukan_t.rujukan_id
   LEFT JOIN asalrujukan_m ON rujukan_t.asalrujukan_id = asalrujukan_m.asalrujukan_id
   LEFT JOIN penanggungjawab_m ON pendaftaran_t.penanggungjawab_id = penanggungjawab_m.penanggungjawab_id
   JOIN ruangan_m ON pendaftaran_t.ruangan_id = ruangan_m.ruangan_id
   JOIN instalasi_m ON pendaftaran_t.instalasi_id = instalasi_m.instalasi_id
   JOIN jeniskasuspenyakit_m ON pendaftaran_t.jeniskasuspenyakit_id = jeniskasuspenyakit_m.jeniskasuspenyakit_id
   LEFT JOIN pegawai_m ON pendaftaran_t.pegawai_id = pegawai_m.pegawai_id
   LEFT JOIN gelarbelakang_m ON pegawai_m.gelarbelakang_id = gelarbelakang_m.gelarbelakang_id
   LEFT JOIN asuransipasien_m ON pendaftaran_t.asuransipasien_id = asuransipasien_m.asuransipasien_id
  WHERE pendaftaran_t.pasienbatalperiksa_id IS NULL AND pendaftaran_t.alihstatus = false" . $condition . "
UNION ALL 
         SELECT pasien_m.pasien_id, pasien_m.jenisidentitas, pasien_m.no_identitas_pasien, pasien_m.namadepan, pasien_m.nama_pasien, pasien_m.nama_bin AS alias, pasien_m.jeniskelamin, pasien_m.tempat_lahir, pasien_m.tanggal_lahir, pasien_m.alamat_pasien, pasien_m.rt, pasien_m.rw, pasien_m.agama, pasien_m.golongandarah, pasien_m.photopasien, pasien_m.alamatemail, pasien_m.statusrekammedis, pasien_m.statusperkawinan, pasien_m.no_rekam_medik, pasien_m.tgl_rekam_medik, pendaftaran_t.pendaftaran_id, pendaftaran_t.no_pendaftaran, pendaftaran_t.tgl_pendaftaran, pendaftaran_t.no_urutantri, pendaftaran_t.transportasi, pendaftaran_t.keadaanmasuk, 'SEDANG DIRAWAT'::character varying(50) AS statusperiksa, pendaftaran_t.statuspasien, pendaftaran_t.kunjungan, pendaftaran_t.alihstatus, pendaftaran_t.byphone, pendaftaran_t.kunjunganrumah, pendaftaran_t.statusmasuk, pendaftaran_t.umur, asuransipasien_m.nokartuasuransi AS no_asuransi, asuransipasien_m.namapemilikasuransi AS namapemilik_asuransi, asuransipasien_m.nomorpokokperusahaan AS nopokokperusahaan, pendaftaran_t.create_time, pendaftaran_t.create_loginpemakai_id, pendaftaran_t.create_ruangan, carabayar_m.carabayar_id, carabayar_m.carabayar_nama, penjaminpasien_m.penjamin_id, penjaminpasien_m.penjamin_nama, caramasuk_m.caramasuk_id, caramasuk_m.caramasuk_nama, pendaftaran_t.shift_id, golonganumur_m.golonganumur_id, golonganumur_m.golonganumur_nama, rujukan_t.no_rujukan, rujukan_t.nama_perujuk, rujukan_t.tanggal_rujukan, rujukan_t.diagnosa_rujukan, asalrujukan_m.asalrujukan_id, asalrujukan_m.asalrujukan_nama, penanggungjawab_m.penanggungjawab_id, penanggungjawab_m.pengantar, penanggungjawab_m.hubungankeluarga, penanggungjawab_m.nama_pj, ruangan_m.ruangan_id, ruangan_m.ruangan_nama, ruangan_m.ruangan_singkatan, instalasi_m.instalasi_id, instalasi_m.instalasi_nama, jeniskasuspenyakit_m.jeniskasuspenyakit_id, jeniskasuspenyakit_m.jeniskasuspenyakit_nama, kelaspelayanan_m.kelaspelayanan_id, kelaspelayanan_m.kelaspelayanan_nama, pegawai_m.gelardepan, pegawai_m.nama_pegawai, gelarbelakang_m.gelarbelakang_nama, pasienadmisi_t.pasienadmisi_id, masukkamar_t.masukkamar_id, kamarruangan_m.kamarruangan_nokamar, asuransipasien_m.tglcetakkartuasuransi, asuransipasien_m.kodefeskestk1, asuransipasien_m.nama_feskestk1, asuransipasien_m.masaberlakukartu, asuransipasien_m.nokartukeluarga, asuransipasien_m.nopassport, asuransipasien_m.status_konfirmasi, asuransipasien_m.tgl_konfirmasi, asuransipasien_m.asuransipasien_aktif, pendaftaran_t.keterangan_pendaftaran
           FROM pasien_m
      JOIN pendaftaran_t ON pasien_m.pasien_id = pendaftaran_t.pasien_id
   JOIN golonganumur_m ON pendaftaran_t.golonganumur_id = golonganumur_m.golonganumur_id
   LEFT JOIN rujukan_t ON pendaftaran_t.rujukan_id = rujukan_t.rujukan_id
   LEFT JOIN asalrujukan_m ON rujukan_t.asalrujukan_id = asalrujukan_m.asalrujukan_id
   LEFT JOIN penanggungjawab_m ON pendaftaran_t.penanggungjawab_id = penanggungjawab_m.penanggungjawab_id
   JOIN jeniskasuspenyakit_m ON pendaftaran_t.jeniskasuspenyakit_id = jeniskasuspenyakit_m.jeniskasuspenyakit_id
   JOIN pasienadmisi_t ON pendaftaran_t.pendaftaran_id = pasienadmisi_t.pendaftaran_id AND pendaftaran_t.pasienadmisi_id = pasienadmisi_t.pasienadmisi_id
   JOIN carabayar_m ON pasienadmisi_t.carabayar_id = carabayar_m.carabayar_id
   JOIN penjaminpasien_m ON pasienadmisi_t.penjamin_id = penjaminpasien_m.penjamin_id
   JOIN caramasuk_m ON pasienadmisi_t.caramasuk_id = caramasuk_m.caramasuk_id
   JOIN ruangan_m ON ruangan_m.ruangan_id = pasienadmisi_t.ruangan_id
   JOIN instalasi_m ON ruangan_m.instalasi_id = instalasi_m.instalasi_id
   LEFT JOIN masukkamar_t ON masukkamar_t.ruangan_id = ruangan_m.ruangan_id AND pasienadmisi_t.pasienadmisi_id = masukkamar_t.pasienadmisi_id
   LEFT JOIN kamarruangan_m ON masukkamar_t.kamarruangan_id = kamarruangan_m.kamarruangan_id
   JOIN kelaspelayanan_m ON masukkamar_t.kelaspelayanan_id = kelaspelayanan_m.kelaspelayanan_id
   LEFT JOIN pegawai_m ON masukkamar_t.pegawai_id = pegawai_m.pegawai_id
   LEFT JOIN gelarbelakang_m ON pegawai_m.gelarbelakang_id = gelarbelakang_m.gelarbelakang_id
   LEFT JOIN asuransipasien_m ON pendaftaran_t.asuransipasien_id = asuransipasien_m.asuransipasien_id
  WHERE masukkamar_t.pindahkamar_id IS NULL " . $condition . ") t WHERE DATE(t.tgl_pendaftaran) BETWEEN '" . $startDate . "' AND '" . $endDate . "' ORDER BY t.tgl_pendaftaran DESC LIMIT 5");
        return $model;
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function searchKontrolPasien() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = $this->criteriaSearch();
        $criteria->addCondition('tglrenkontrol IS NOT NULL');
        $criteria->limit = 10;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * @return array validation rules for model attributes.
     * penambahan required
     */
    public function searchListKunjungan() {
        $criteria = new CDBCriteria();
        if (!empty($this->pasien_id)) {
            $criteria->addCondition("pasien_id= " . $this->pasien_id);
        }
        $criteria->order = 'tgl_pendaftaran DESC';
        $criteria->limit = 10;
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * @return array validation rules for model attributes.
     * penambahan required
     */
    public function getJumlahKunjungan() {
        $criteria = new CDBCriteria();
        $criteria->select = 'count(pasien_id) as jumlah';
        $criteria->group = 'pasien_id';
        if (!empty($this->pasien_id)) {
            $criteria->addCondition("pasien_id= " . $this->pasien_id);
        }
        return MCPendaftaranT::model()->find($criteria)->jumlah;
    }

    /**
     * @return array validation rules for model attributes.
     * penambahan required
     */
    public function getJumlahPasienRI() {
        $criteria = new CDBCriteria();
        $criteria->select = 'count(pasien_id) as jumlah';
        $criteria->group = 'pasien_id';
        $criteria->addCondition('pasienadmisi_id is not null');
        if (!empty($this->pasien_id)) {
            $criteria->addCondition("pasien_id= " . $this->pasien_id);
        }
        return isset(MCPendaftaranT::model()->find($criteria)->jumlah) ? MCPendaftaranT::model()->find($criteria)->jumlah : 0;
    }

    /**
     * @return array validation rules for model attributes.
     * penambahan required
     */
    public function getJumlahPasienRJ() {
        $criteria = new CDBCriteria();
        $criteria->select = 'count(pasien_id) as jumlah';
        $criteria->group = 'pasien_id';
        $criteria->addCondition('instalasi_id =' . Params::INSTALASI_ID_RJ);
        if (!empty($this->pasien_id)) {
            $criteria->addCondition("pasien_id= " . $this->pasien_id);
        }
        return isset(MCPendaftaranT::model()->find($criteria)->jumlah) ? MCPendaftaranT::model()->find($criteria)->jumlah : 0;
    }

    /**
     * @return array validation rules for model attributes.
     * penambahan required
     */
    public function getJumlahPasienRD() {
        $criteria = new CDBCriteria();
        $criteria->select = 'count(pasien_id) as jumlah';
        $criteria->group = 'pasien_id';
        $criteria->addCondition('instalasi_id =' . Params::INSTALASI_ID_RD);
        if (!empty($this->pasien_id)) {
            $criteria->addCondition("pasien_id= " . $this->pasien_id);
        }
        return isset(MCPendaftaranT::model()->find($criteria)->jumlah) ? MCPendaftaranT::model()->find($criteria)->jumlah : 0;
    }

    /**
     * Mengambil daftar ruangan MCU
     * @param type $instalasi_id
     * @return type
     */
    public function getRuanganMcuItems($instalasi_id = null) {
        $criteria = new CDbCriteria();
        if (!empty($instalasi_id)) {
            $criteria->addCondition("instalasi_id= " . $instalasi_id);
        }
        $criteria->addCondition('ruangan_aktif = true');
		// $criteria->addCondition('ruangan_id = '.Params::RUANGAN_ID_KLINIK_MCU);
        $criteria->order = "ruangan_nama";
        return RuanganM::model()->findAll($criteria);
    }

    /**
     * Mengambil daftar ruangan MCU
     * @return CActiveDataProvider 
     */
    public function getRuanganMCU() {
        $criteria = new CDbCriteria();
        $criteria->order = "ruangan_nama";
        return RuanganklinikmcuV::model()->findAll($criteria);
    }

    /**
     * Kriteria Pencarian untuk menampilkan data pada halaman laporan TAT
     * @author Andyka Putra <andykaputra@.com>
     * @return CActiveDataProvider
     */
    public function searchLaporanTAT() {
        $criteria = new CDbCriteria;

        $criteria->select = 't.*, pasienm.nama_pasien, pasienm.no_rekam_medik';
        $criteria->join = "LEFT JOIN pasien_m pasienm on t.pasien_id = pasienm.pasien_id ";
        $criteria->addCondition('t.pasienbatalperiksa_id IS NULL');
        $criteria->addCondition("t.instalasi_id = " . Params::INSTALASI_ID_MCU);
        $criteria->addBetweenCondition('DATE(t.tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array('defaultOrder' => 'tgl_pendaftaran ASC')
        ));
    }

    /**
     * Kriteria Pencarian untuk menampilkan data pada cetak laporan TAT
     * @author Andyka Putra <andykaputra@.com>
     * @return CActiveDataProvider
     */
    public function searchPrintLaporanTAT() {
        $criteria = new CDbCriteria;

        $criteria->select = 't.*, pasienm.nama_pasien, pasienm.no_rekam_medik';
        $criteria->join = "LEFT JOIN pasien_m pasienm on t.pasien_id = pasienm.pasien_id ";
        $criteria->addCondition('t.pasienbatalperiksa_id IS NULL');
        $criteria->addCondition("t.instalasi_id = " . Params::INSTALASI_ID_MCU);
        $criteria->addBetweenCondition('DATE(t.tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
        $criteria->limit = -1;
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array('defaultOrder' => 'tgl_pendaftaran ASC')
        ));
    }

}
