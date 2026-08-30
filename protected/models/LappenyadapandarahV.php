<?php

/**
 * This is the model class for table "lappenyadapandarah_v".
 *
 * The followings are the available columns in table 'lappenyadapandarah_v':
 * @property integer $profilrs_id
 * @property string $nama_rumahsakit
 * @property integer $pendonor_id
 * @property string $no_pendonor
 * @property string $jenisidentitas
 * @property string $no_identitas
 * @property string $nama_lengkap
 * @property string $tempat_lahir
 * @property string $tgllahir
 * @property string $jenis_kelamin
 * @property string $alamat_lengkap
 * @property double $beratbadan_kg
 * @property double $tinggibadan_cm
 * @property string $notelp_pendonor
 * @property string $nomobile_pendonor
 * @property integer $pekerjaan_id
 * @property string $statusperkawinan
 * @property string $gol_darah
 * @property string $rhesus
 * @property boolean $is_pernah_donor
 * @property integer $donasi_ke_sblm
 * @property string $tgl_donor_terakhir
 * @property string $tempat_donor_terakhir
 * @property integer $daftardonasi_id
 * @property string $no_formulir
 * @property string $waktu_pendaftaran
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $pegawaidaftar_id
 * @property string $pegawaidaftar_nip
 * @property string $pegawaidaftar_gelardepan
 * @property string $pegawaidaftar_nama
 * @property integer $gelarpendaftar_id
 * @property string $gelarpendaftar_nama
 * @property integer $jabatanpendaftar_id
 * @property string $jabatanpendaftar_nama
 * @property string $keterangan_donasi
 * @property integer $donasi_ke
 * @property integer $observasipendonor_id
 * @property string $tglmulaiobservasi
 * @property string $sd_observasi
 * @property string $kelancarandarah
 * @property integer $nadi_observasi
 * @property string $keluhan_pendonor
 * @property string $ket_observasi
 * @property double $suhu_observasi
 * @property integer $td_systolic
 * @property integer $td_diastolic
 * @property string $pernapasan
 * @property string $kesadaran
 * @property boolean $is_batalpenyadapan
 * @property string $alasanbatal_penyadapan
 * @property string $waktu_observasi
 * @property integer $pegawai_id
 * @property string $nomorindukpegawai
 * @property string $gelardepan
 * @property string $nama_pegawai
 * @property integer $gelarbelakang_id
 * @property string $gelarbelakang_nama
 * @property integer $jabatan_id
 * @property string $jabatan_nama
 */
class LappenyadapandarahV extends CActiveRecord {

    public $tgl_awal, $tgl_akhir;
    public $curProvider, $curProvDat, $pagination;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return LappenyadapandarahV the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'lappenyadapandarah_v';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('profilrs_id, pendonor_id, pekerjaan_id, donasi_ke_sblm, daftardonasi_id, instalasi_id, ruangan_id, pegawaidaftar_id, gelarpendaftar_id, jabatanpendaftar_id, donasi_ke, observasipendonor_id, nadi_observasi, td_systolic, td_diastolic, pegawai_id, gelarbelakang_id, jabatan_id', 'numerical', 'integerOnly' => true),
            array('beratbadan_kg, tinggibadan_cm, suhu_observasi', 'numerical'),
            array('nama_rumahsakit, nama_lengkap, tempat_lahir, notelp_pendonor, tempat_donor_terakhir, jabatanpendaftar_nama, pernapasan, kesadaran, jabatan_nama', 'length', 'max' => 100),
            array('no_pendonor, no_identitas, no_formulir, instalasi_nama, ruangan_nama, pegawaidaftar_nama, nama_pegawai', 'length', 'max' => 50),
            array('jenisidentitas, pegawaidaftar_nip, nomorindukpegawai', 'length', 'max' => 30),
            array('jenis_kelamin, statusperkawinan, rhesus, kelancarandarah', 'length', 'max' => 20),
            array('alamat_lengkap, nomobile_pendonor', 'length', 'max' => 255),
            array('gol_darah', 'length', 'max' => 2),
            array('pegawaidaftar_gelardepan, gelardepan', 'length', 'max' => 10),
            array('gelarpendaftar_nama, gelarbelakang_nama', 'length', 'max' => 25),
            array('alasanbatal_penyadapan', 'length', 'max' => 200),
            array('tgllahir, is_pernah_donor, tgl_donor_terakhir, waktu_pendaftaran, keterangan_donasi, tglmulaiobservasi, sd_observasi, keluhan_pendonor, ket_observasi, is_batalpenyadapan, waktu_observasi', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('profilrs_id, nama_rumahsakit, pendonor_id, no_pendonor, jenisidentitas, no_identitas, nama_lengkap, tempat_lahir, tgllahir, jenis_kelamin, alamat_lengkap, beratbadan_kg, tinggibadan_cm, notelp_pendonor, nomobile_pendonor, pekerjaan_id, statusperkawinan, gol_darah, rhesus, is_pernah_donor, donasi_ke_sblm, tgl_donor_terakhir, tempat_donor_terakhir, daftardonasi_id, no_formulir, waktu_pendaftaran, instalasi_id, instalasi_nama, ruangan_id, ruangan_nama, pegawaidaftar_id, pegawaidaftar_nip, pegawaidaftar_gelardepan, pegawaidaftar_nama, gelarpendaftar_id, gelarpendaftar_nama, jabatanpendaftar_id, jabatanpendaftar_nama, keterangan_donasi, donasi_ke, observasipendonor_id, tglmulaiobservasi, sd_observasi, kelancarandarah, nadi_observasi, keluhan_pendonor, ket_observasi, suhu_observasi, td_systolic, td_diastolic, pernapasan, kesadaran, is_batalpenyadapan, alasanbatal_penyadapan, waktu_observasi, pegawai_id, nomorindukpegawai, gelardepan, nama_pegawai, gelarbelakang_id, gelarbelakang_nama, jabatan_id, jabatan_nama', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'profilrs_id' => 'Profilrs',
            'nama_rumahsakit' => 'Nama Rumahsakit',
            'pendonor_id' => 'Pendonor',
            'no_pendonor' => 'No Pendonor',
            'jenisidentitas' => 'Jenisidentitas',
            'no_identitas' => 'No Identitas',
            'nama_lengkap' => 'Nama Lengkap',
            'tempat_lahir' => 'Tempat Lahir',
            'tgllahir' => 'Tgllahir',
            'jenis_kelamin' => 'Jenis Kelamin',
            'alamat_lengkap' => 'Alamat Lengkap',
            'beratbadan_kg' => 'Beratbadan Kg',
            'tinggibadan_cm' => 'Tinggibadan Cm',
            'notelp_pendonor' => 'Notelp Pendonor',
            'nomobile_pendonor' => 'Nomobile Pendonor',
            'pekerjaan_id' => 'Pekerjaan',
            'statusperkawinan' => 'Statusperkawinan',
            'gol_darah' => 'Gol Darah',
            'rhesus' => 'Rhesus',
            'is_pernah_donor' => 'Is Pernah Donor',
            'donasi_ke_sblm' => 'Donasi Ke Sblm',
            'tgl_donor_terakhir' => 'Tgl Donor Terakhir',
            'tempat_donor_terakhir' => 'Tempat Donor Terakhir',
            'daftardonasi_id' => 'Daftardonasi',
            'no_formulir' => 'No Formulir',
            'waktu_pendaftaran' => 'Waktu Pendaftaran',
            'instalasi_id' => 'Instalasi',
            'instalasi_nama' => 'Instalasi Nama',
            'ruangan_id' => 'Ruangan',
            'ruangan_nama' => 'Ruangan Nama',
            'pegawaidaftar_id' => 'Pegawaidaftar',
            'pegawaidaftar_nip' => 'Pegawaidaftar Nip',
            'pegawaidaftar_gelardepan' => 'Pegawaidaftar Gelardepan',
            'pegawaidaftar_nama' => 'Pegawaidaftar Nama',
            'gelarpendaftar_id' => 'Gelarpendaftar',
            'gelarpendaftar_nama' => 'Gelarpendaftar Nama',
            'jabatanpendaftar_id' => 'Jabatanpendaftar',
            'jabatanpendaftar_nama' => 'Jabatanpendaftar Nama',
            'keterangan_donasi' => 'Keterangan Donasi',
            'donasi_ke' => 'Donasi Ke',
            'observasipendonor_id' => 'Observasipendonor',
            'tglmulaiobservasi' => 'Tglmulaiobservasi',
            'sd_observasi' => 'Sd Observasi',
            'kelancarandarah' => 'Kelancarandarah',
            'nadi_observasi' => 'Nadi Observasi',
            'keluhan_pendonor' => 'Keluhan Pendonor',
            'ket_observasi' => 'Ket Observasi',
            'suhu_observasi' => 'Suhu Observasi',
            'td_systolic' => 'Td Systolic',
            'td_diastolic' => 'Td Diastolic',
            'pernapasan' => 'Pernapasan',
            'kesadaran' => 'Kesadaran',
            'is_batalpenyadapan' => '',
            'alasanbatal_penyadapan' => 'Alasanbatal Penyadapan',
            'waktu_observasi' => 'Waktu Observasi',
            'pegawai_id' => 'Pegawai',
            'nomorindukpegawai' => 'Nomorindukpegawai',
            'gelardepan' => 'Gelardepan',
            'nama_pegawai' => 'Nama Pegawai',
            'gelarbelakang_id' => 'Gelarbelakang',
            'gelarbelakang_nama' => 'Gelarbelakang Nama',
            'jabatan_id' => 'Jabatan',
            'jabatan_nama' => 'Jabatan Nama',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('profilrs_id', $this->profilrs_id);
        $criteria->compare('nama_rumahsakit', $this->nama_rumahsakit, true);
        $criteria->compare('pendonor_id', $this->pendonor_id);
        $criteria->compare('no_pendonor', $this->no_pendonor, true);
        $criteria->compare('jenisidentitas', $this->jenisidentitas, true);
        $criteria->compare('no_identitas', $this->no_identitas, true);
        $criteria->compare('nama_lengkap', $this->nama_lengkap, true);
        $criteria->compare('tempat_lahir', $this->tempat_lahir, true);
        $criteria->compare('tgllahir', $this->tgllahir, true);
        $criteria->compare('jenis_kelamin', $this->jenis_kelamin, true);
        $criteria->compare('alamat_lengkap', $this->alamat_lengkap, true);
        $criteria->compare('beratbadan_kg', $this->beratbadan_kg);
        $criteria->compare('tinggibadan_cm', $this->tinggibadan_cm);
        $criteria->compare('notelp_pendonor', $this->notelp_pendonor, true);
        $criteria->compare('nomobile_pendonor', $this->nomobile_pendonor, true);
        $criteria->compare('pekerjaan_id', $this->pekerjaan_id);
        $criteria->compare('statusperkawinan', $this->statusperkawinan, true);
        $criteria->compare('gol_darah', $this->gol_darah, true);
        $criteria->compare('rhesus', $this->rhesus, true);
        $criteria->compare('is_pernah_donor', $this->is_pernah_donor);
        $criteria->compare('donasi_ke_sblm', $this->donasi_ke_sblm);
        $criteria->compare('tgl_donor_terakhir', $this->tgl_donor_terakhir, true);
        $criteria->compare('tempat_donor_terakhir', $this->tempat_donor_terakhir, true);
        $criteria->compare('daftardonasi_id', $this->daftardonasi_id);
        $criteria->compare('no_formulir', $this->no_formulir, true);
        $criteria->compare('waktu_pendaftaran', $this->waktu_pendaftaran, true);
        $criteria->compare('instalasi_id', $this->instalasi_id);
        $criteria->compare('instalasi_nama', $this->instalasi_nama, true);
        $criteria->compare('ruangan_id', $this->ruangan_id);
        $criteria->compare('ruangan_nama', $this->ruangan_nama, true);
        $criteria->compare('pegawaidaftar_id', $this->pegawaidaftar_id);
        $criteria->compare('pegawaidaftar_nip', $this->pegawaidaftar_nip, true);
        $criteria->compare('pegawaidaftar_gelardepan', $this->pegawaidaftar_gelardepan, true);
        $criteria->compare('pegawaidaftar_nama', $this->pegawaidaftar_nama, true);
        $criteria->compare('gelarpendaftar_id', $this->gelarpendaftar_id);
        $criteria->compare('gelarpendaftar_nama', $this->gelarpendaftar_nama, true);
        $criteria->compare('jabatanpendaftar_id', $this->jabatanpendaftar_id);
        $criteria->compare('jabatanpendaftar_nama', $this->jabatanpendaftar_nama, true);
        $criteria->compare('keterangan_donasi', $this->keterangan_donasi, true);
        $criteria->compare('donasi_ke', $this->donasi_ke);
        $criteria->compare('observasipendonor_id', $this->observasipendonor_id);
        $criteria->compare('tglmulaiobservasi', $this->tglmulaiobservasi, true);
        $criteria->compare('sd_observasi', $this->sd_observasi, true);
        $criteria->compare('kelancarandarah', $this->kelancarandarah, true);
        $criteria->compare('nadi_observasi', $this->nadi_observasi);
        $criteria->compare('keluhan_pendonor', $this->keluhan_pendonor, true);
        $criteria->compare('ket_observasi', $this->ket_observasi, true);
        $criteria->compare('suhu_observasi', $this->suhu_observasi);
        $criteria->compare('td_systolic', $this->td_systolic);
        $criteria->compare('td_diastolic', $this->td_diastolic);
        $criteria->compare('pernapasan', $this->pernapasan, true);
        $criteria->compare('kesadaran', $this->kesadaran, true);
        $criteria->compare('is_batalpenyadapan', $this->is_batalpenyadapan);
        $criteria->compare('alasanbatal_penyadapan', $this->alasanbatal_penyadapan, true);
        $criteria->compare('waktu_observasi', $this->waktu_observasi, true);
        $criteria->compare('pegawai_id', $this->pegawai_id);
        $criteria->compare('nomorindukpegawai', $this->nomorindukpegawai, true);
        $criteria->compare('gelardepan', $this->gelardepan, true);
        $criteria->compare('nama_pegawai', $this->nama_pegawai, true);
        $criteria->compare('gelarbelakang_id', $this->gelarbelakang_id);
        $criteria->compare('gelarbelakang_nama', $this->gelarbelakang_nama, true);
        $criteria->compare('jabatan_id', $this->jabatan_id);
        $criteria->compare('jabatan_nama', $this->jabatan_nama, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Digunakan untuk pencarian pada tabel
     * @return \CActiveDataProvider
     */
    public function searchTable() {
        $criteria = new CDbCriteria();

        $criteria->select = 'waktu_observasi,nama_lengkap,tgllahir,umur,kelompok_umur,jenis_kelamin,donasi_ke,jenisdonor,gol_darah,rhesus,nama_jenis,nomorbarcode_utama,nama_pegawai,is_batalpenyadapan,ket_observasi';
        $criteria->addBetweenCondition('DATE(waktu_observasi)', $this->tgl_awal, $this->tgl_akhir);
        $criteria->group = $criteria->select;
        $criteria->order = "DATE(waktu_observasi) ASC";
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Digunakan untuk pencarian pada tabel (print)
     * @return \CActiveDataProvider
     */
    public function searchPrint() {
        $criteria = new CDbCriteria();

        $criteria->select = 'waktu_observasi,nama_lengkap,tgllahir,umur,kelompok_umur,jenis_kelamin,donasi_ke,jenisdonor,gol_darah,rhesus,nama_jenis,nomorbarcode_utama,nama_pegawai,is_batalpenyadapan,ket_observasi';
        $criteria->addBetweenCondition('DATE(waktu_observasi)', $this->tgl_awal, $this->tgl_akhir);
        $criteria->group = $criteria->select;
        $criteria->order = "DATE(waktu_observasi) ASC";
        $criteria->limit = -1;
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false
        ));
    }

    /**
     * Digunakan untuk mencari total kelompok umur 1
     * @param type $col
     * @param type $prov
     * @return string|int
     */
    public function getTotalKelumur1($col, $prov = null) {
        if (empty($this->curProvDat)) {
            if (empty($prov))
                return 0;
            $this->curProvider = clone $prov;
            $this->curProvider->pagination = false;
            $this->curProvider->criteria->limit = -1;
            $this->curProvDat = $this->curProvider->data;
        }
        $total = 0;
        foreach ($this->curProvDat as $item) {
            if ($item[$col] == 1) {
                $total += 1;
            }
        }
        if ($total == 0) {
            return " ";
        } else {
            return $total;
        }
    }

    /**
     * Digunakan untuk mencari total kelompok umur 2
     * @param type $col
     * @param type $prov
     * @return string|int
     */
    public function getTotalKelumur2($col, $prov = null) {
        if (empty($this->curProvDat)) {
            if (empty($prov))
                return 0;
            $this->curProvider = clone $prov;
            $this->curProvider->pagination = false;
            $this->curProvider->criteria->limit = -1;
            $this->curProvDat = $this->curProvider->data;
        }
        $total = 0;
        foreach ($this->curProvDat as $item) {
            if ($item[$col] == 2) {
                $total += 1;
            }
        }
        if ($total == 0) {
            return " ";
        } else {
            return $total;
        }
    }

    /**
     * Digunakan untuk mencari total kelompok umur 3
     * @param type $col
     * @param type $prov
     * @return string|int
     */
    public function getTotalKelumur3($col, $prov = null) {
        if (empty($this->curProvDat)) {
            if (empty($prov))
                return 0;
            $this->curProvider = clone $prov;
            $this->curProvider->pagination = false;
            $this->curProvider->criteria->limit = -1;
            $this->curProvDat = $this->curProvider->data;
        }
        $total = 0;
        foreach ($this->curProvDat as $item) {
            if ($item[$col] == 3) {
                $total += 1;
            }
        }
        if ($total == 0) {
            return " ";
        } else {
            return $total;
        }
    }

    /**
     * Digunakan untuk mencari total kelompok umur 4
     * @param type $col
     * @param type $prov
     * @return string|int
     */
    public function getTotalKelumur4($col, $prov = null) {
        if (empty($this->curProvDat)) {
            if (empty($prov))
                return 0;
            $this->curProvider = clone $prov;
            $this->curProvider->pagination = false;
            $this->curProvider->criteria->limit = -1;
            $this->curProvDat = $this->curProvider->data;
        }
        $total = 0;
        foreach ($this->curProvDat as $item) {
            if ($item[$col] == 4) {
                $total += 1;
            }
        }
        if ($total == 0) {
            return " ";
        } else {
            return $total;
        }
    }

    /**
     * Digunakan untuk mencari total kelompok umur 5
     * @param type $col
     * @param type $prov
     * @return string|int
     */
    public function getTotalKelumur5($col, $prov = null) {
        if (empty($this->curProvDat)) {
            if (empty($prov))
                return 0;
            $this->curProvider = clone $prov;
            $this->curProvider->pagination = false;
            $this->curProvider->criteria->limit = -1;
            $this->curProvDat = $this->curProvider->data;
        }
        $total = 0;
        foreach ($this->curProvDat as $item) {
            if ($item[$col] == 5) {
                $total += 1;
            }
        }
        if ($total == 0) {
            return " ";
        } else {
            return $total;
        }
    }

    /**
     * Digunakan untuk mencari total jenis kelamin laki-laki
     * @param type $col
     * @param type $prov
     * @return string|int
     */
    public function getTotalJKL($col, $prov = null) {
        if (empty($this->curProvDat)) {
            if (empty($prov))
                return 0;
            $this->curProvider = clone $prov;
            $this->curProvider->pagination = false;
            $this->curProvider->criteria->limit = -1;
            $this->curProvDat = $this->curProvider->data;
        }
        $total = 0;
        foreach ($this->curProvDat as $item) {
            if ($item[$col] == Params::JENIS_KELAMIN_LAKI_LAKI) {
                $total += 1;
            }
        }
        if ($total == 0) {
            return " ";
        } else {
            return $total;
        }
    }

    /**
     * Digunakan untuk mencari total jenis kelamin perempuan
     * @param type $col
     * @param type $prov
     * @return string|int
     */
    public function getTotalJKP($col, $prov = null) {
        if (empty($this->curProvDat)) {
            if (empty($prov))
                return 0;
            $this->curProvider = clone $prov;
            $this->curProvider->pagination = false;
            $this->curProvider->criteria->limit = -1;
            $this->curProvDat = $this->curProvider->data;
        }
        $total = 0;
        foreach ($this->curProvDat as $item) {
            if ($item[$col] == Params::JENIS_KELAMIN_PEREMPUAN) {
                $total += 1;
            }
        }
        if ($total == 0) {
            return " ";
        } else {
            return $total;
        }
    }

    /**
     * Digunakan untuk mencari total donasi baru
     * @param type $col
     * @param type $prov
     * @return string|int
     */
    public function getTotalDonasiBaru($col, $prov = null) {
        if (empty($this->curProvDat)) {
            if (empty($prov))
                return 0;
            $this->curProvider = clone $prov;
            $this->curProvider->pagination = false;
            $this->curProvider->criteria->limit = -1;
            $this->curProvDat = $this->curProvider->data;
        }
        $total = 0;
        foreach ($this->curProvDat as $item) {
            if ($item[$col] == 1) {
                $total += 1;
            }
        }
        if ($total == 0) {
            return " ";
        } else {
            return $total;
        }
    }
    
    /**
     * Digunakan untuk mencari total donasi baru
     * @param type $col
     * @param type $prov
     * @return string|int
     */
    public function getTotalDonasiLama($col, $prov = null) {
        if (empty($this->curProvDat)) {
            if (empty($prov))
                return 0;
            $this->curProvider = clone $prov;
            $this->curProvider->pagination = false;
            $this->curProvider->criteria->limit = -1;
            $this->curProvDat = $this->curProvider->data;
        }
        $total = 0;
        foreach ($this->curProvDat as $item) {
            if ($item[$col] > 1) {
                $total += 1;
            }
        }
        if ($total == 0) {
            return " ";
        } else {
            return $total;
        }
    }
    
    /**
     * Digunakan untuk mencari total sukarela
     * @param type $col
     * @param type $prov
     * @return string|int
     */
    public function getTotalSkrl($col, $prov = null) {
        if (empty($this->curProvDat)) {
            if (empty($prov))
                return 0;
            $this->curProvider = clone $prov;
            $this->curProvider->pagination = false;
            $this->curProvider->criteria->limit = -1;
            $this->curProvDat = $this->curProvider->data;
        }
        $total = 0;
        foreach ($this->curProvDat as $item) {
            if ($item[$col] == "Sukarela") {
                $total += 1;
            }
        }
        if ($total == 0) {
            return " ";
        } else {
            return $total;
        }
    }
    
    /**
     * Digunakan untuk mencari total pengganti
     * @param type $col
     * @param type $prov
     * @return string|int
     */
    public function getTotalPggt($col, $prov = null) {
        if (empty($this->curProvDat)) {
            if (empty($prov))
                return 0;
            $this->curProvider = clone $prov;
            $this->curProvider->pagination = false;
            $this->curProvider->criteria->limit = -1;
            $this->curProvDat = $this->curProvider->data;
        }
        $total = 0;
        foreach ($this->curProvDat as $item) {
            if ($item[$col] == "Pengganti") {
                $total += 1;
            }
        }
        if ($total == 0) {
            return " ";
        } else {
            return $total;
        }
    }
    
    /**
     * Digunakan untuk mencari total autologus
     * @param type $col
     * @param type $prov
     * @return string|int
     */
    public function getTotalAuto($col, $prov = null) {
        if (empty($this->curProvDat)) {
            if (empty($prov))
                return 0;
            $this->curProvider = clone $prov;
            $this->curProvider->pagination = false;
            $this->curProvider->criteria->limit = -1;
            $this->curProvDat = $this->curProvider->data;
        }
        $total = 0;
        foreach ($this->curProvDat as $item) {
            if ($item[$col] == "Autologus") {
                $total += 1;
            }
        }
        if ($total == 0) {
            return " ";
        } else {
            return $total;
        }
    }
    
    /**
     * Digunakan untuk mencari total goldar A
     * @param type $col
     * @param type $prov
     * @return string|int
     */
    public function getTotalGolA($col, $prov = null) {
        if (empty($this->curProvDat)) {
            if (empty($prov))
                return 0;
            $this->curProvider = clone $prov;
            $this->curProvider->pagination = false;
            $this->curProvider->criteria->limit = -1;
            $this->curProvDat = $this->curProvider->data;
        }
        $total = 0;
        foreach ($this->curProvDat as $item) {
            if ($item[$col] == "A") {
                $total += 1;
            }
        }
        if ($total == 0) {
            return " ";
        } else {
            return $total;
        }
    }
    
    /**
     * Digunakan untuk mencari total goldar B
     * @param type $col
     * @param type $prov
     * @return string|int
     */
    public function getTotalGolB($col, $prov = null) {
        if (empty($this->curProvDat)) {
            if (empty($prov))
                return 0;
            $this->curProvider = clone $prov;
            $this->curProvider->pagination = false;
            $this->curProvider->criteria->limit = -1;
            $this->curProvDat = $this->curProvider->data;
        }
        $total = 0;
        foreach ($this->curProvDat as $item) {
            if ($item[$col] == "B") {
                $total += 1;
            }
        }
        if ($total == 0) {
            return " ";
        } else {
            return $total;
        }
    }
    
    /**
     * Digunakan untuk mencari total goldar AB
     * @param type $col
     * @param type $prov
     * @return string|int
     */
    public function getTotalGolAB($col, $prov = null) {
        if (empty($this->curProvDat)) {
            if (empty($prov))
                return 0;
            $this->curProvider = clone $prov;
            $this->curProvider->pagination = false;
            $this->curProvider->criteria->limit = -1;
            $this->curProvDat = $this->curProvider->data;
        }
        $total = 0;
        foreach ($this->curProvDat as $item) {
            if ($item[$col] == "AB") {
                $total += 1;
            }
        }
        if ($total == 0) {
            return " ";
        } else {
            return $total;
        }
    }
    
    /**
     * Digunakan untuk mencari total goldar O
     * @param type $col
     * @param type $prov
     * @return string|int
     */
    public function getTotalGolO($col, $prov = null) {
        if (empty($this->curProvDat)) {
            if (empty($prov))
                return 0;
            $this->curProvider = clone $prov;
            $this->curProvider->pagination = false;
            $this->curProvider->criteria->limit = -1;
            $this->curProvDat = $this->curProvider->data;
        }
        $total = 0;
        foreach ($this->curProvDat as $item) {
            if ($item[$col] == "O") {
                $total += 1;
            }
        }
        if ($total == 0) {
            return " ";
        } else {
            return $total;
        }
    }
    
    /**
     * Digunakan untuk mencari total rhesus Positif
     * @param type $col
     * @param type $prov
     * @return string|int
     */
    public function getTotalPos($col, $prov = null) {
        if (empty($this->curProvDat)) {
            if (empty($prov))
                return 0;
            $this->curProvider = clone $prov;
            $this->curProvider->pagination = false;
            $this->curProvider->criteria->limit = -1;
            $this->curProvDat = $this->curProvider->data;
        }
        $total = 0;
        foreach ($this->curProvDat as $item) {
            if (strtoupper($item[$col]) == "POSITIF" || strtoupper($item[$col]) == "RH+") {
                $total += 1;
            }
        }
        if ($total == 0) {
            return " ";
        } else {
            return $total;
        }
    }
    
    /**
     * Digunakan untuk mencari total rhesus Negatif
     * @param type $col
     * @param type $prov
     * @return string|int
     */
    public function getTotalNeg($col, $prov = null) {
        if (empty($this->curProvDat)) {
            if (empty($prov))
                return 0;
            $this->curProvider = clone $prov;
            $this->curProvider->pagination = false;
            $this->curProvider->criteria->limit = -1;
            $this->curProvDat = $this->curProvider->data;
        }
        $total = 0;
        foreach ($this->curProvDat as $item) {
            if (strtoupper($item[$col]) == "NEGATIF" || strtoupper($item[$col]) == "RH-") {
                $total += 1;
            }
        }
        if ($total == 0) {
            return " ";
        } else {
            return $total;
        }
    }
    
    /**
     * Digunakan untuk mencari total Single
     * @param type $col
     * @param type $prov
     * @return string|int
     */
    public function getTotalSG($col, $prov = null) {
        if (empty($this->curProvDat)) {
            if (empty($prov))
                return 0;
            $this->curProvider = clone $prov;
            $this->curProvider->pagination = false;
            $this->curProvider->criteria->limit = -1;
            $this->curProvDat = $this->curProvider->data;
        }
        $total = 0;
        foreach ($this->curProvDat as $item) {
            if ($item[$col] == "Single") {
                $total += 1;
            }
        }
        if ($total == 0) {
            return " ";
        } else {
            return $total;
        }
    }
    
    /**
     * Digunakan untuk mencari total Double
     * @param type $col
     * @param type $prov
     * @return string|int
     */
    public function getTotalDB($col, $prov = null) {
        if (empty($this->curProvDat)) {
            if (empty($prov))
                return 0;
            $this->curProvider = clone $prov;
            $this->curProvider->pagination = false;
            $this->curProvider->criteria->limit = -1;
            $this->curProvDat = $this->curProvider->data;
        }
        $total = 0;
        foreach ($this->curProvDat as $item) {
            if ($item[$col] == "Double") {
                $total += 1;
            }
        }
        if ($total == 0) {
            return " ";
        } else {
            return $total;
        }
    }
    
    /**
     * Digunakan untuk mencari total Triple
     * @param type $col
     * @param type $prov
     * @return string|int
     */
    public function getTotalTR($col, $prov = null) {
        if (empty($this->curProvDat)) {
            if (empty($prov))
                return 0;
            $this->curProvider = clone $prov;
            $this->curProvider->pagination = false;
            $this->curProvider->criteria->limit = -1;
            $this->curProvDat = $this->curProvider->data;
        }
        $total = 0;
        foreach ($this->curProvDat as $item) {
            if ($item[$col] == "Triple") {
                $total += 1;
            }
        }
        if ($total == 0) {
            return " ";
        } else {
            return $total;
        }
    }
    
    /**
     * Digunakan untuk mencari total Quadruple
     * @param type $col
     * @param type $prov
     * @return string|int
     */
    public function getTotalQD($col, $prov = null) {
        if (empty($this->curProvDat)) {
            if (empty($prov))
                return 0;
            $this->curProvider = clone $prov;
            $this->curProvider->pagination = false;
            $this->curProvider->criteria->limit = -1;
            $this->curProvDat = $this->curProvider->data;
        }
        $total = 0;
        foreach ($this->curProvDat as $item) {
            if ($item[$col] == "Quadruple") {
                $total += 1;
            }
        }
        if ($total == 0) {
            return " ";
        } else {
            return $total;
        }
    }
    
    /**
     * Digunakan untuk mencari total pegawai ROSA RUSDIANA
     * @param type $col
     * @param type $prov
     * @return string|int
     */
    public function getTotalRs($col, $prov = null) {
        if (empty($this->curProvDat)) {
            if (empty($prov))
                return 0;
            $this->curProvider = clone $prov;
            $this->curProvider->pagination = false;
            $this->curProvider->criteria->limit = -1;
            $this->curProvDat = $this->curProvider->data;
        }
        $total = 0;
        foreach ($this->curProvDat as $item) {
            if ($item[$col] == "ROSA RUSDIANA") {
                $total += 1;
            }
        }
        if ($total == 0) {
            return " ";
        } else {
            return $total;
        }
    }
    
    /**
     * Digunakan untuk mencari total pegawai EMMY ROHAYATI
     * @param type $col
     * @param type $prov
     * @return string|int
     */
    public function getTotalEmy($col, $prov = null) {
        if (empty($this->curProvDat)) {
            if (empty($prov))
                return 0;
            $this->curProvider = clone $prov;
            $this->curProvider->pagination = false;
            $this->curProvider->criteria->limit = -1;
            $this->curProvDat = $this->curProvider->data;
        }
        $total = 0;
        foreach ($this->curProvDat as $item) {
            if ($item[$col] == "EMMY ROHAYATI") {
                $total += 1;
            }
        }
        if ($total == 0) {
            return " ";
        } else {
            return $total;
        }
    }
    
    /**
     * Digunakan untuk mencari total pegawai DWI RATNA OKTAVIA
     * @param type $col
     * @param type $prov
     * @return string|int
     */
    public function getTotalRtn($col, $prov = null) {
        if (empty($this->curProvDat)) {
            if (empty($prov))
                return 0;
            $this->curProvider = clone $prov;
            $this->curProvider->pagination = false;
            $this->curProvider->criteria->limit = -1;
            $this->curProvDat = $this->curProvider->data;
        }
        $total = 0;
        foreach ($this->curProvDat as $item) {
            if ($item[$col] == "DWI RATNA OKTAVIA") {
                $total += 1;
            }
        }
        if ($total == 0) {
            return " ";
        } else {
            return $total;
        }
    }
    
    /**
     * Digunakan untuk mencari total is_batalpenyadapan == true
     * @param type $col
     * @param type $prov
     * @return string|int
     */
    public function getTotalGagal($col, $prov = null) {
        if (empty($this->curProvDat)) {
            if (empty($prov))
                return 0;
            $this->curProvider = clone $prov;
            $this->curProvider->pagination = false;
            $this->curProvider->criteria->limit = -1;
            $this->curProvDat = $this->curProvider->data;
        }
        $total = 0;
        foreach ($this->curProvDat as $item) {
            if ($item[$col] == true) {
                $total += 1;
            }
        }
        if ($total == 0) {
            return " ";
        } else {
            return $total;
        }
    }
    
}
