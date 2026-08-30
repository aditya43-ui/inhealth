<?php

/**
 * This is the model class for table "  ".
 *
 * The followings are the available columns in table 'pasienmasukpenunjang_v': 
 * digunakan untuk menyimpan fung - fungsi javascript unyuk tabulasi menu asesmen awal kebidanan
 * 
 * @package models
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     1.0.0 
 * @link    <http://piindonesia.co.id> 
 * @property integer $pasien_id
 * @property string $jenisidentitas
 * @property string $no_identitas_pasien
 * @property string $namadepan
 * @property string $nama_pasien
 * @property string $nama_bin
 * @property string $jeniskelamin
 * @property string $tempat_lahir
 * @property string $tanggal_lahir
 * @property string $alamat_pasien
 * @property integer $rt
 * @property integer $rw
 * @property string $agama
 * @property string $golongandarah
 * @property string $photopasien
 * @property string $alamatemail
 * @property string $statusrekammedis
 * @property string $statusperkawinan
 * @property string $no_rekam_medik
 * @property string $tgl_rekam_medik
 * @property integer $propinsi_id
 * @property string $propinsi_nama
 * @property integer $kabupaten_id
 * @property string $kabupaten_nama
 * @property integer $kelurahan_id
 * @property string $kelurahan_nama
 * @property integer $kecamatan_id
 * @property string $kecamatan_nama
 * @property integer $pendaftaran_id
 * @property integer $pekerjaan_id
 * @property string $pekerjaan_nama
 * @property string $no_pendaftaran
 * @property string $tgl_pendaftaran
 * @property string $keadaanmasuk
 * @property string $statuspasien
 * @property boolean $alihstatus
 * @property string $statusmasuk
 * @property string $umur
 * @property string $no_asuransi
 * @property string $namapemilik_asuransi
 * @property string $nopokokperusahaan
 * @property integer $carabayar_id
 * @property string $carabayar_nama
 * @property integer $penjamin_id
 * @property string $penjamin_nama
 * @property integer $caramasuk_id
 * @property string $caramasuk_nama
 * @property integer $shift_id
 * @property integer $golonganumur_id
 * @property string $golonganumur_nama
 * @property string $no_rujukan
 * @property string $nama_perujuk
 * @property string $tanggal_rujukan
 * @property string $diagnosa_rujukan
 * @property integer $asalrujukan_id
 * @property string $asalrujukan_nama
 * @property integer $penanggungjawab_id
 * @property string $pengantar
 * @property string $hubungankeluarga
 * @property string $nama_pj
 * @property integer $ruanganasal_id
 * @property string $ruanganasal_nama
 * @property integer $instalasiasal_id
 * @property string $instalasiasal_nama
 * @property integer $jeniskasuspenyakit_id
 * @property string $jeniskasuspenyakit_nama
 * @property integer $kelaspelayanan_id
 * @property string $kelaspelayanan_nama
 * @property string $gelardokterasal
 * @property string $nama_dokterasal
 * @property string $gelarbelakang_nama
 * @property string $no_masukpenunjang
 * @property string $tglmasukpenunjang
 * @property string $no_urutperiksa
 * @property string $kunjungan
 * @property string $statusperiksa
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $pasienadmisi_id
 * @property integer $pasienmasukpenunjang_id
 * @property string $create_time
 * @property string $create_loginpemakai_id
 * @property string $create_ruangan
 * @property string $gelardepan
 * @property string $nama_pegawai
 * @property integer $pegawai_id
 */
class PasienmasukpenunjangV extends CActiveRecord {

    public $noRM;
    public $noPendaftaran;
    public $tgl_awal;
    public $tgl_akhir;
    public $namaPasien;
    public $namaBinPasien;
    public $statusBayar;
    public $prefix_pendaftaran;
    public $dokterperujuk;
    public $statusperiksahasil;
    public $tglselesaiperiksa, $jeniskantongdarah_singkatan, $jumlahpermintaan, $jumlahdilayani, $plt, $jenis_permintaan, $kadarhb, $diagnosa_nama, $catatandokterpengirim;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PasienmasukpenunjangV the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'pasienmasukpenunjang_v';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('pasien_id, rt, rw, propinsi_id, kabupaten_id, kelurahan_id, kecamatan_id, pendaftaran_id, pekerjaan_id, carabayar_id, penjamin_id, caramasuk_id, shift_id, golonganumur_id, asalrujukan_id, penanggungjawab_id, ruanganasal_id, instalasiasal_id, jeniskasuspenyakit_id, kelaspelayanan_id, ruangan_id, pasienadmisi_id, pasienmasukpenunjang_id, pegawai_id', 'numerical', 'integerOnly' => true),
            array('jenisidentitas, namadepan, jeniskelamin, agama, statusperkawinan, no_pendaftaran, no_masukpenunjang', 'length', 'max' => 20),
            array('no_identitas_pasien, nama_bin, umur', 'length', 'max' => 30),
            array('nama_pasien, propinsi_nama, kabupaten_nama, kelurahan_nama, kecamatan_nama, pekerjaan_nama, keadaanmasuk, statuspasien, statusmasuk, no_asuransi, namapemilik_asuransi, nopokokperusahaan, carabayar_nama, penjamin_nama, caramasuk_nama, nama_perujuk, asalrujukan_nama, pengantar, hubungankeluarga, nama_pj, no_mobilepj, ruanganasal_nama, instalasiasal_nama, kelaspelayanan_nama, nama_dokterasal, kunjungan, statusperiksa, ruangan_nama, nama_pegawai', 'length', 'max' => 50),
            array('tempat_lahir, golonganumur_nama', 'length', 'max' => 25),
            array('golongandarah', 'length', 'max' => 2),
            array('photopasien', 'length', 'max' => 200),
            array('alamatemail, jeniskasuspenyakit_nama', 'length', 'max' => 100),
            array('statusrekammedis, no_rekam_medik, no_rujukan, gelardokterasal, gelardepan', 'length', 'max' => 10),
            array('gelarbelakang_nama', 'length', 'max' => 15),
            array('no_urutperiksa', 'length', 'max' => 3),
            array('rujukandari_id, namaperujuk, alamatlengkapperujuk, notelpperujuk,tanggal_lahir, alamat_pasien, tgl_rekam_medik, tgl_pendaftaran, alihstatus, tanggal_rujukan, diagnosa_rujukan, tglmasukpenunjang, create_time, create_loginpemakai_id, create_ruangan,ruangan_singkatan, respondtime', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('rujukandari_id,namaperujuk, alamatlengkapperujuk, notelpperujuk, statusBayar, tgl_awal, tgl_akhir, pasien_id, jenisidentitas, no_identitas_pasien, namadepan, nama_pasien, nama_bin, jeniskelamin, tempat_lahir, tanggal_lahir, alamat_pasien, rt, rw, agama, golongandarah, photopasien, alamatemail, statusrekammedis, statusperkawinan, no_rekam_medik, tgl_rekam_medik, propinsi_id, propinsi_nama, kabupaten_id, kabupaten_nama, kelurahan_id, kelurahan_nama, kecamatan_id, kecamatan_nama, pendaftaran_id, pekerjaan_id, pekerjaan_nama, no_pendaftaran, tgl_pendaftaran, keadaanmasuk, statuspasien, alihstatus, statusmasuk, umur, no_asuransi, namapemilik_asuransi, nopokokperusahaan, carabayar_id, carabayar_nama, penjamin_id, penjamin_nama, caramasuk_id, caramasuk_nama, shift_id, golonganumur_id, golonganumur_nama, no_rujukan, nama_perujuk, tanggal_rujukan, diagnosa_rujukan, asalrujukan_id, asalrujukan_nama, penanggungjawab_id, pengantar, hubungankeluarga, nama_pj, no_mobilepj, ruanganasal_id, ruanganasal_nama, instalasiasal_id, instalasiasal_nama, jeniskasuspenyakit_id, jeniskasuspenyakit_nama, kelaspelayanan_id, kelaspelayanan_nama, gelardokterasal, nama_dokterasal, gelarbelakang_nama, no_masukpenunjang, tglmasukpenunjang, no_urutperiksa, kunjungan, statusperiksa, ruangan_id, ruangan_nama, pasienadmisi_id, pasienmasukpenunjang_id, create_time, create_loginpemakai_id, create_ruangan, gelardepan, nama_pegawai, pegawai_id, ruangan_singkatan, respondtime, is_cyto, kamarruangan_nokamar, kamarruangan_nobed, respondtime', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
            'penanggungjawab' => array(self::BELONGS_TO, 'PenanggungjawabM', 'penanggungjawab_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            // 'tgl_awal' => 'Dari',
            'pasien_id' => 'Pasien',
            'jenisidentitas' => 'Jenis Identitas',
            'no_identitas_pasien' => 'No. Identitas',
            'namadepan' => 'Nama Depan',
            'nama_pasien' => 'Nama Pasien',
            'nama_bin' => 'Nama Panggilan',
            'jeniskelamin' => 'Jenis Kelamin',
            'tempat_lahir' => 'Tempat Lahir',
            'tanggal_lahir' => 'Tanggal Lahir',
            'alamat_pasien' => 'Alamat',
            'rt' => 'RT',
            'rw' => 'RW',
            'agama' => 'Agama',
            'golongandarah' => 'Golongan Darah',
            'photopasien' => 'Photo Pasien',
            'alamatemail' => 'Alamat Email',
            'statusrekammedis' => 'Status Rekam Medis',
            'statusperkawinan' => 'Status Perkawinan',
            'no_rekam_medik' => 'No. Rekam Medik',
            'tgl_rekam_medik' => 'Tanggal Rekam Medik',
            'propinsi_id' => 'Provinsi',
            'propinsi_nama' => 'Provinsi',
            'kabupaten_id' => 'Kabupaten',
            'kabupaten_nama' => 'Kabupaten',
            'kelurahan_id' => 'Kelurahan',
            'kelurahan_nama' => 'Kelurahan',
            'kecamatan_id' => 'Kecamatan',
            'kecamatan_nama' => 'Kecamatan',
            'pendaftaran_id' => 'Pendaftaran',
            'pekerjaan_id' => 'Pekerjaan',
            'pekerjaan_nama' => 'Pekerjaan',
            'no_pendaftaran' => 'No. Pendaftaran',
            'tgl_pendaftaran' => 'Tanggal Pendaftaran',
            'keadaanmasuk' => 'Keadaan Masuk',
            'statuspasien' => 'Status Pasien',
            'alihstatus' => 'Alih Status',
            'statusmasuk' => 'Status Masuk',
            'umur' => 'Umur',
            'no_asuransi' => 'No. Asuransi',
            'namapemilik_asuransi' => 'Nama Pemilik Asuransi',
            'nopokokperusahaan' => 'No. Pokok Perusahaan',
            'carabayar_id' => 'Jenis Penjamin',
            'carabayar_nama' => 'Jenis Penjamin',
            'penjamin_id' => 'Penjamin',
            'penjamin_nama' => 'Penjamin',
            'caramasuk_id' => 'Caramasuk',
            'caramasuk_nama' => 'Cara Masuk',
            'shift_id' => 'Shift',
            'golonganumur_id' => 'Golongan Umur',
            'golonganumur_nama' => 'Golongan Umur',
            'no_rujukan' => 'No. Rujukan',
            'nama_perujuk' => 'Nama Perujuk',
            'tanggal_rujukan' => 'Tanggal Rujukan',
            'diagnosa_rujukan' => 'Diagnosa Rujukan',
            'asalrujukan_id' => 'Asal Rujukan',
            'asalrujukan_nama' => 'Asal Rujukan',
            'penanggungjawab_id' => 'Penanggung Jawab',
            'pengantar' => 'Pengantar',
            'hubungankeluarga' => 'Hubungan Keluarga',
            'nama_pj' => 'Nama Pj',
            'no_mobilepj' => 'NO. Mobile Pj',
            'ruanganasal_id' => 'Ruangan Asal',
            'ruanganasal_nama' => 'Ruangan/Poliklinik Asal',
            'instalasiasal_id' => 'Instalasi Asal',
            'instalasiasal_nama' => 'Instalasi Asal',
            'jeniskasuspenyakit_id' => 'Jenis Kasus Penyakit',
            'jeniskasuspenyakit_nama' => 'Jenis Kasus Penyakit',
            'kelaspelayanan_id' => 'Kelas Pelayanan',
            'kelaspelayanan_nama' => 'Kelas Pelayanan',
            'gelardokterasal' => 'Gelar Dokter Asal',
            'nama_dokterasal' => 'Dokter Perujuk',
            'gelarbelakang_nama' => 'Gelar Belakang',
            'no_masukpenunjang' => 'No. Masuk Penunjang',
            'tglmasukpenunjang' => 'Tanggal Masuk Penunjang',
            'no_urutperiksa' => 'No. Urut Periksa',
            'kunjungan' => 'Kunjungan',
            'statusperiksa' => 'Status Periksa',
            'ruangan_id' => 'Ruangan',
            'ruangan_nama' => 'Ruangan',
            'pasienadmisi_id' => 'Pasien Admisi',
            'pasienmasukpenunjang_id' => 'Pasien Masuk Penunjang',
            'create_time' => 'Waktu Create',
            'create_loginpemakai_id' => 'Create Login Pemakai',
            'create_ruangan' => 'Create Ruangan',
            'gelardepan' => 'Gelar Depan',
            'nama_pegawai' => 'Dokter Pemeriksa',
            'pegawai_id' => 'Dokter Pemeriksa',
            'noRM' => 'No. Rekam Medik',
//                        'tglpengambilansample'=>'Tanggal Pengambilan Sample',
//                        'no_pengambilansample'=>'No. Pengambilan Sample',
            //Yang berelasi dengan rujukandari_m:
            'rujukandari_id' => 'ID Rujukan',
            'namaperujuk' => 'Dokter',
            'alamatlengkapperujuk' => 'Alamat',
            'notelpperujuk' => 'No. Telepon',
            'tgl_awal' => 'Tanggal Awal',
            'tgl_akhir' => 'Tanggal Akhir'
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


        $criteria->compare('pasien_id', $this->pasien_id);
        $criteria->addBetweenCondition('DATE(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
        $criteria->compare('LOWER(jenisidentitas)', strtolower($this->jenisidentitas), true);
        $criteria->compare('LOWER(no_identitas_pasien)', strtolower($this->no_identitas_pasien), true);
        $criteria->compare('LOWER(namadepan)', strtolower($this->namadepan), true);
        $criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien), true);
        $criteria->compare('LOWER(nama_bin)', strtolower($this->nama_bin), true);
        $criteria->compare('LOWER(jeniskelamin)', strtolower($this->jeniskelamin), true);
        $criteria->compare('LOWER(tempat_lahir)', strtolower($this->tempat_lahir), true);
        $criteria->compare('LOWER(tanggal_lahir)', strtolower($this->tanggal_lahir), true);
        $criteria->compare('LOWER(alamat_pasien)', strtolower($this->alamat_pasien), true);
        $criteria->compare('rt', $this->rt);
        $criteria->compare('rw', $this->rw);
        $criteria->compare('LOWER(agama)', strtolower($this->agama), true);
        $criteria->compare('LOWER(golongandarah)', strtolower($this->golongandarah), true);
        $criteria->compare('LOWER(photopasien)', strtolower($this->photopasien), true);
        $criteria->compare('LOWER(alamatemail)', strtolower($this->alamatemail), true);
        $criteria->compare('LOWER(statusrekammedis)', strtolower($this->statusrekammedis), true);
        $criteria->compare('LOWER(statusperkawinan)', strtolower($this->statusperkawinan), true);
        $criteria->compare('LOWER(no_rekam_medik)', strtolower($this->no_rekam_medik), true);
        $criteria->compare('LOWER(tgl_rekam_medik)', strtolower($this->tgl_rekam_medik), true);
        $criteria->compare('propinsi_id', $this->propinsi_id);
        $criteria->compare('LOWER(propinsi_nama)', strtolower($this->propinsi_nama), true);
        $criteria->compare('kabupaten_id', $this->kabupaten_id);
        $criteria->compare('LOWER(kabupaten_nama)', strtolower($this->kabupaten_nama), true);
        $criteria->compare('kelurahan_id', $this->kelurahan_id);
        $criteria->compare('LOWER(kelurahan_nama)', strtolower($this->kelurahan_nama), true);
        $criteria->compare('kecamatan_id', $this->kecamatan_id);
        $criteria->compare('LOWER(kecamatan_nama)', strtolower($this->kecamatan_nama), true);
        $criteria->compare('pendaftaran_id', $this->pendaftaran_id);
        $criteria->compare('pekerjaan_id', $this->pekerjaan_id);
        $criteria->compare('LOWER(pekerjaan_nama)', strtolower($this->pekerjaan_nama), true);
        $criteria->compare('LOWER(no_pendaftaran)', strtolower($this->no_pendaftaran), true);
        $criteria->compare('LOWER(tgl_pendaftaran)', strtolower($this->tgl_pendaftaran), true);
        $criteria->compare('LOWER(keadaanmasuk)', strtolower($this->keadaanmasuk), true);
        $criteria->compare('LOWER(statuspasien)', strtolower($this->statuspasien), true);
        $criteria->compare('alihstatus', $this->alihstatus);
        $criteria->compare('LOWER(statusmasuk)', strtolower($this->statusmasuk), true);
        $criteria->compare('LOWER(umur)', strtolower($this->umur), true);
        $criteria->compare('LOWER(no_asuransi)', strtolower($this->no_asuransi), true);
        $criteria->compare('LOWER(namapemilik_asuransi)', strtolower($this->namapemilik_asuransi), true);
        $criteria->compare('LOWER(nopokokperusahaan)', strtolower($this->nopokokperusahaan), true);
        $criteria->compare('carabayar_id', $this->carabayar_id);
        $criteria->compare('LOWER(carabayar_nama)', strtolower($this->carabayar_nama), true);
        $criteria->compare('penjamin_id', $this->penjamin_id);
        $criteria->compare('LOWER(penjamin_nama)', strtolower($this->penjamin_nama), true);
        $criteria->compare('caramasuk_id', $this->caramasuk_id);
        $criteria->compare('LOWER(caramasuk_nama)', strtolower($this->caramasuk_nama), true);
        $criteria->compare('shift_id', $this->shift_id);
        $criteria->compare('golonganumur_id', $this->golonganumur_id);
        $criteria->compare('LOWER(golonganumur_nama)', strtolower($this->golonganumur_nama), true);
        $criteria->compare('LOWER(no_rujukan)', strtolower($this->no_rujukan), true);
        $criteria->compare('LOWER(nama_perujuk)', strtolower($this->nama_perujuk), true);
        $criteria->compare('LOWER(tanggal_rujukan)', strtolower($this->tanggal_rujukan), true);
        $criteria->compare('LOWER(diagnosa_rujukan)', strtolower($this->diagnosa_rujukan), true);
        $criteria->compare('asalrujukan_id', $this->asalrujukan_id);
        $criteria->compare('LOWER(asalrujukan_nama)', strtolower($this->asalrujukan_nama), true);
        $criteria->compare('penanggungjawab_id', $this->penanggungjawab_id);
        $criteria->compare('LOWER(pengantar)', strtolower($this->pengantar), true);
        $criteria->compare('LOWER(hubungankeluarga)', strtolower($this->hubungankeluarga), true);
        $criteria->compare('LOWER(nama_pj)', strtolower($this->nama_pj), true);
        $criteria->compare('LOWER(no_mobilepj)', strtolower($this->no_mobilepj), true);
        $criteria->compare('ruanganasal_id', $this->ruanganasal_id);
        $criteria->compare('LOWER(ruanganasal_nama)', strtolower($this->ruanganasal_nama), true);
        $criteria->compare('instalasiasal_id', $this->instalasiasal_id);
        $criteria->compare('LOWER(instalasiasal_nama)', strtolower($this->instalasiasal_nama), true);
        $criteria->compare('jeniskasuspenyakit_id', $this->jeniskasuspenyakit_id);
        $criteria->compare('LOWER(jeniskasuspenyakit_nama)', strtolower($this->jeniskasuspenyakit_nama), true);
        $criteria->compare('kelaspelayanan_id', $this->kelaspelayanan_id);
        $criteria->compare('LOWER(kelaspelayanan_nama)', strtolower($this->kelaspelayanan_nama), true);
        $criteria->compare('LOWER(gelardokterasal)', strtolower($this->gelardokterasal), true);
        $criteria->compare('LOWER(nama_dokterasal)', strtolower($this->nama_dokterasal), true);
        $criteria->compare('LOWER(gelarbelakang_nama)', strtolower($this->gelarbelakang_nama), true);
        $criteria->compare('LOWER(no_masukpenunjang)', strtolower($this->no_masukpenunjang), true);
        $criteria->compare('LOWER(tglmasukpenunjang)', strtolower($this->tglmasukpenunjang), true);
        $criteria->compare('LOWER(no_urutperiksa)', strtolower($this->no_urutperiksa), true);
        $criteria->compare('LOWER(kunjungan)', strtolower($this->kunjungan), true);
        $criteria->compare('LOWER(statusperiksa)', strtolower($this->statusperiksa), true);

        if (Yii::app()->user->getState('ruangan_id') == 220) {
            $criteria->compare('ruangan_id', Yii::app()->user->getState('ruangan_id'));
        } else {
            $criteria->compare('ruangan_id', $this->ruangan_id);
        }

        $criteria->compare('LOWER(ruangan_nama)', strtolower($this->ruangan_nama), true);
        $criteria->compare('pasienadmisi_id', $this->pasienadmisi_id);
        $criteria->compare('pasienmasukpenunjang_id', $this->pasienmasukpenunjang_id);
        $criteria->compare('LOWER(create_time)', strtolower($this->create_time), true);
        $criteria->compare('LOWER(create_loginpemakai_id)', strtolower($this->create_loginpemakai_id), true);
        $criteria->compare('LOWER(create_ruangan)', strtolower($this->create_ruangan), true);
        $criteria->compare('LOWER(gelardepan)', strtolower($this->gelardepan), true);
        $criteria->compare('LOWER(nama_pegawai)', strtolower($this->nama_pegawai), true);
        $criteria->compare('pegawai_id', $this->pegawai_id);
        $criteria->compare('LOWER(kamarruangan_nokamar)', strtolower($this->kamarruangan_nokamar), true);
        $criteria->compare('LOWER(kamarruangan_nobed)', strtolower($this->kamarruangan_nobed), true);

        if ($this->statusBayar == 'LUNAS') {
            $criteria->addCondition('pembayaranpelayanan_id is not null');
        } else if ($this->statusBayar == 'BELUM LUNAS') {
            $criteria->addCondition('pembayaranpelayanan_id is null');
        }
        $criteria->order = 'tgl_pendaftaran DESC';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * generate fungsi prinout
     * @return \CActiveDataProvider
     */
    public function searchPrint() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria->compare('pasien_id', $this->pasien_id);
        $criteria->compare('LOWER(jenisidentitas)', strtolower($this->jenisidentitas), true);
        $criteria->compare('LOWER(no_identitas_pasien)', strtolower($this->no_identitas_pasien), true);
        $criteria->compare('LOWER(namadepan)', strtolower($this->namadepan), true);
        $criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien), true);
        $criteria->compare('LOWER(nama_bin)', strtolower($this->nama_bin), true);
        $criteria->compare('LOWER(jeniskelamin)', strtolower($this->jeniskelamin), true);
        $criteria->compare('LOWER(tempat_lahir)', strtolower($this->tempat_lahir), true);
        $criteria->compare('LOWER(tanggal_lahir)', strtolower($this->tanggal_lahir), true);
        $criteria->compare('LOWER(alamat_pasien)', strtolower($this->alamat_pasien), true);
        $criteria->compare('rt', $this->rt);
        $criteria->compare('rw', $this->rw);
        $criteria->compare('LOWER(agama)', strtolower($this->agama), true);
        $criteria->compare('LOWER(golongandarah)', strtolower($this->golongandarah), true);
        $criteria->compare('LOWER(photopasien)', strtolower($this->photopasien), true);
        $criteria->compare('LOWER(alamatemail)', strtolower($this->alamatemail), true);
        $criteria->compare('LOWER(statusrekammedis)', strtolower($this->statusrekammedis), true);
        $criteria->compare('LOWER(statusperkawinan)', strtolower($this->statusperkawinan), true);
        $criteria->compare('LOWER(no_rekam_medik)', strtolower($this->no_rekam_medik), true);
        $criteria->compare('LOWER(tgl_rekam_medik)', strtolower($this->tgl_rekam_medik), true);
        $criteria->compare('propinsi_id', $this->propinsi_id);
        $criteria->compare('LOWER(propinsi_nama)', strtolower($this->propinsi_nama), true);
        $criteria->compare('kabupaten_id', $this->kabupaten_id);
        $criteria->compare('LOWER(kabupaten_nama)', strtolower($this->kabupaten_nama), true);
        $criteria->compare('kelurahan_id', $this->kelurahan_id);
        $criteria->compare('LOWER(kelurahan_nama)', strtolower($this->kelurahan_nama), true);
        $criteria->compare('kecamatan_id', $this->kecamatan_id);
        $criteria->compare('LOWER(kecamatan_nama)', strtolower($this->kecamatan_nama), true);
        $criteria->compare('pendaftaran_id', $this->pendaftaran_id);
        $criteria->compare('pekerjaan_id', $this->pekerjaan_id);
        $criteria->compare('LOWER(pekerjaan_nama)', strtolower($this->pekerjaan_nama), true);
        $criteria->compare('LOWER(no_pendaftaran)', strtolower($this->no_pendaftaran), true);
        $criteria->compare('LOWER(tgl_pendaftaran)', strtolower($this->tgl_pendaftaran), true);
        $criteria->compare('LOWER(keadaanmasuk)', strtolower($this->keadaanmasuk), true);
        $criteria->compare('LOWER(statuspasien)', strtolower($this->statuspasien), true);
        $criteria->compare('alihstatus', $this->alihstatus);
        $criteria->compare('LOWER(statusmasuk)', strtolower($this->statusmasuk), true);
        $criteria->compare('LOWER(umur)', strtolower($this->umur), true);
        $criteria->compare('LOWER(no_asuransi)', strtolower($this->no_asuransi), true);
        $criteria->compare('LOWER(namapemilik_asuransi)', strtolower($this->namapemilik_asuransi), true);
        $criteria->compare('LOWER(nopokokperusahaan)', strtolower($this->nopokokperusahaan), true);
        $criteria->compare('carabayar_id', $this->carabayar_id);
        $criteria->compare('LOWER(carabayar_nama)', strtolower($this->carabayar_nama), true);
        $criteria->compare('penjamin_id', $this->penjamin_id);
        $criteria->compare('LOWER(penjamin_nama)', strtolower($this->penjamin_nama), true);
        $criteria->compare('caramasuk_id', $this->caramasuk_id);
        $criteria->compare('LOWER(caramasuk_nama)', strtolower($this->caramasuk_nama), true);
        $criteria->compare('shift_id', $this->shift_id);
        $criteria->compare('golonganumur_id', $this->golonganumur_id);
        $criteria->compare('LOWER(golonganumur_nama)', strtolower($this->golonganumur_nama), true);
        $criteria->compare('LOWER(no_rujukan)', strtolower($this->no_rujukan), true);
        $criteria->compare('LOWER(nama_perujuk)', strtolower($this->nama_perujuk), true);
        $criteria->compare('LOWER(tanggal_rujukan)', strtolower($this->tanggal_rujukan), true);
        $criteria->compare('LOWER(diagnosa_rujukan)', strtolower($this->diagnosa_rujukan), true);
        $criteria->compare('asalrujukan_id', $this->asalrujukan_id);
        $criteria->compare('LOWER(asalrujukan_nama)', strtolower($this->asalrujukan_nama), true);
        $criteria->compare('penanggungjawab_id', $this->penanggungjawab_id);
        $criteria->compare('LOWER(pengantar)', strtolower($this->pengantar), true);
        $criteria->compare('LOWER(hubungankeluarga)', strtolower($this->hubungankeluarga), true);
        $criteria->compare('LOWER(nama_pj)', strtolower($this->nama_pj), true);
        $criteria->compare('LOWER(no_mobilepj)', strtolower($this->no_mobilepj), true);
        $criteria->compare('ruanganasal_id', $this->ruanganasal_id);
        $criteria->compare('LOWER(ruanganasal_nama)', strtolower($this->ruanganasal_nama), true);
        $criteria->compare('instalasiasal_id', $this->instalasiasal_id);
        $criteria->compare('LOWER(instalasiasal_nama)', strtolower($this->instalasiasal_nama), true);
        $criteria->compare('jeniskasuspenyakit_id', $this->jeniskasuspenyakit_id);
        $criteria->compare('LOWER(jeniskasuspenyakit_nama)', strtolower($this->jeniskasuspenyakit_nama), true);
        $criteria->compare('kelaspelayanan_id', $this->kelaspelayanan_id);
        $criteria->compare('LOWER(kelaspelayanan_nama)', strtolower($this->kelaspelayanan_nama), true);
        $criteria->compare('LOWER(gelardokterasal)', strtolower($this->gelardokterasal), true);
        $criteria->compare('LOWER(nama_dokterasal)', strtolower($this->nama_dokterasal), true);
        $criteria->compare('LOWER(gelarbelakang_nama)', strtolower($this->gelarbelakang_nama), true);
        $criteria->compare('LOWER(no_masukpenunjang)', strtolower($this->no_masukpenunjang), true);
        $criteria->compare('LOWER(tglmasukpenunjang)', strtolower($this->tglmasukpenunjang), true);
        $criteria->compare('LOWER(no_urutperiksa)', strtolower($this->no_urutperiksa), true);
        $criteria->compare('LOWER(kunjungan)', strtolower($this->kunjungan), true);
        $criteria->compare('LOWER(statusperiksa)', strtolower($this->statusperiksa), true);
        $criteria->compare('ruangan_id', $this->ruangan_id);
        $criteria->compare('LOWER(ruangan_nama)', strtolower($this->ruangan_nama), true);
        $criteria->compare('pasienadmisi_id', $this->pasienadmisi_id);
        $criteria->compare('pasienmasukpenunjang_id', $this->pasienmasukpenunjang_id);
        $criteria->compare('LOWER(create_time)', strtolower($this->create_time), true);
        $criteria->compare('LOWER(create_loginpemakai_id)', strtolower($this->create_loginpemakai_id), true);
        $criteria->compare('LOWER(create_ruangan)', strtolower($this->create_ruangan), true);
        $criteria->compare('LOWER(gelardepan)', strtolower($this->gelardepan), true);
        $criteria->compare('LOWER(nama_pegawai)', strtolower($this->nama_pegawai), true);
        $criteria->compare('pegawai_id', $this->pegawai_id);
        $criteria->order = 'tgl_pendaftaran DESC';
        // Klo limit lebih kecil dari nol itu berarti ga ada limit 
        $criteria->limit = -1;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false,
        ));
    }

    /**
     * pencarian data jenazah
     * @return \CActiveDataProvider
     */
    public function searchJenazah() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        if (!empty($this->pasien_id)) {
            $criteria->addCondition('pasien_id = ' . $this->pasien_id);
        }
        $criteria->compare('LOWER(jenisidentitas)', strtolower($this->jenisidentitas), true);
        $criteria->compare('LOWER(no_identitas_pasien)', strtolower($this->no_identitas_pasien), true);
        $criteria->compare('LOWER(namadepan)', strtolower($this->namadepan), true);
        $criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien), true);
        $criteria->compare('LOWER(nama_bin)', strtolower($this->nama_bin), true);
        $criteria->compare('LOWER(jeniskelamin)', strtolower($this->jeniskelamin), true);
        $criteria->compare('LOWER(tempat_lahir)', strtolower($this->tempat_lahir), true);
        $criteria->compare('LOWER(tanggal_lahir)', strtolower($this->tanggal_lahir), true);
        $criteria->compare('LOWER(alamat_pasien)', strtolower($this->alamat_pasien), true);
        $criteria->compare('rt', $this->rt);
        $criteria->compare('rw', $this->rw);
        $criteria->compare('LOWER(agama)', strtolower($this->agama), true);
        $criteria->compare('LOWER(golongandarah)', strtolower($this->golongandarah), true);
        $criteria->compare('LOWER(photopasien)', strtolower($this->photopasien), true);
        $criteria->compare('LOWER(alamatemail)', strtolower($this->alamatemail), true);
        $criteria->compare('LOWER(statusrekammedis)', strtolower($this->statusrekammedis), true);
        $criteria->compare('LOWER(statusperkawinan)', strtolower($this->statusperkawinan), true);
        $criteria->compare('LOWER(no_rekam_medik)', strtolower($this->no_rekam_medik), true);
        $criteria->compare('LOWER(tgl_rekam_medik)', strtolower($this->tgl_rekam_medik), true);
        if (!empty($this->propinsi_id)) {
            $criteria->addCondition('propinsi_id = ' . $this->propinsi_id);
        }
        $criteria->compare('LOWER(propinsi_nama)', strtolower($this->propinsi_nama), true);
        if (!empty($this->kabupaten_id)) {
            $criteria->addCondition('kabupaten_id = ' . $this->kabupaten_id);
        }
        $criteria->compare('LOWER(kabupaten_nama)', strtolower($this->kabupaten_nama), true);
        if (!empty($this->kelurahan_id)) {
            $criteria->addCondition('kelurahan_id = ' . $this->kelurahan_id);
        }
        $criteria->compare('LOWER(kelurahan_nama)', strtolower($this->kelurahan_nama), true);
        if (!empty($this->kecamatan_id)) {
            $criteria->addCondition('kecamatan_id = ' . $this->kecamatan_id);
        }
        $criteria->compare('LOWER(kecamatan_nama)', strtolower($this->kecamatan_nama), true);
        if (!empty($this->pendaftaran_id)) {
            $criteria->addCondition('pendaftaran_id = ' . $this->pendaftaran_id);
        }
        if (!empty($this->pekerjaan_id)) {
            $criteria->addCondition('pekerjaan_id = ' . $this->pekerjaan_id);
        }
        $criteria->compare('LOWER(pekerjaan_nama)', strtolower($this->pekerjaan_nama), true);
        $criteria->compare('LOWER(no_pendaftaran)', strtolower($this->no_pendaftaran), true);
        $criteria->compare('LOWER(tgl_pendaftaran)', strtolower($this->tgl_pendaftaran), true);
        $criteria->compare('LOWER(keadaanmasuk)', strtolower($this->keadaanmasuk), true);
        $criteria->compare('LOWER(statuspasien)', strtolower($this->statuspasien), true);
        $criteria->compare('alihstatus', $this->alihstatus);
        $criteria->compare('LOWER(statusmasuk)', strtolower($this->statusmasuk), true);
        $criteria->compare('LOWER(umur)', strtolower($this->umur), true);
        $criteria->compare('LOWER(no_asuransi)', strtolower($this->no_asuransi), true);
        $criteria->compare('LOWER(namapemilik_asuransi)', strtolower($this->namapemilik_asuransi), true);
        $criteria->compare('LOWER(nopokokperusahaan)', strtolower($this->nopokokperusahaan), true);
        if (!empty($this->carabayar_id)) {
            $criteria->addCondition('carabayar_id = ' . $this->carabayar_id);
        }
        $criteria->compare('', $this->carabayar_id);
        $criteria->compare('LOWER(carabayar_nama)', strtolower($this->carabayar_nama), true);
        if (!empty($this->penjamin_id)) {
            $criteria->addCondition('penjamin_id = ' . $this->penjamin_id);
        }
        $criteria->compare('LOWER(penjamin_nama)', strtolower($this->penjamin_nama), true);
        if (!empty($this->caramasuk_id)) {
            $criteria->addCondition('caramasuk_id = ' . $this->caramasuk_id);
        }
        $criteria->compare('LOWER(caramasuk_nama)', strtolower($this->caramasuk_nama), true);
        if (!empty($this->shift_id)) {
            $criteria->addCondition('shift_id = ' . $this->shift_id);
        }
        if (!empty($this->golonganumur_id)) {
            $criteria->addCondition('golonganumur_id = ' . $this->golonganumur_id);
        }
        $criteria->compare('LOWER(golonganumur_nama)', strtolower($this->golonganumur_nama), true);
        $criteria->compare('LOWER(no_rujukan)', strtolower($this->no_rujukan), true);
        $criteria->compare('LOWER(nama_perujuk)', strtolower($this->nama_perujuk), true);
        $criteria->compare('LOWER(tanggal_rujukan)', strtolower($this->tanggal_rujukan), true);
        $criteria->compare('LOWER(diagnosa_rujukan)', strtolower($this->diagnosa_rujukan), true);
        if (!empty($this->asalrujukan_id)) {
            $criteria->addCondition('asalrujukan_id = ' . $this->asalrujukan_id);
        }
        $criteria->compare('LOWER(asalrujukan_nama)', strtolower($this->asalrujukan_nama), true);
        if (!empty($this->penanggungjawab_id)) {
            $criteria->addCondition('penanggungjawab_id = ' . $this->penanggungjawab_id);
        }
        $criteria->compare('LOWER(pengantar)', strtolower($this->pengantar), true);
        $criteria->compare('LOWER(hubungankeluarga)', strtolower($this->hubungankeluarga), true);
        $criteria->compare('LOWER(nama_pj)', strtolower($this->nama_pj), true);
        $criteria->compare('LOWER(no_mobilepj)', strtolower($this->no_mobilepj), true);
        if (!empty($this->ruanganasal_id)) {
            $criteria->addCondition('ruanganasal_id = ' . $this->ruanganasal_id);
        }
        $criteria->compare('LOWER(ruanganasal_nama)', strtolower($this->ruanganasal_nama), true);
        if (!empty($this->instalasiasal_id)) {
            $criteria->addCondition('instalasiasal_id = ' . $this->instalasiasal_id);
        }
        $criteria->compare('LOWER(instalasiasal_nama)', strtolower($this->instalasiasal_nama), true);
        if (!empty($this->jeniskasuspenyakit_id)) {
            $criteria->addCondition('jeniskasuspenyakit_id = ' . $this->jeniskasuspenyakit_id);
        }
        $criteria->compare('LOWER(jeniskasuspenyakit_nama)', strtolower($this->jeniskasuspenyakit_nama), true);
        if (!empty($this->kelaspelayanan_id)) {
            $criteria->addCondition('kelaspelayanan_id = ' . $this->kelaspelayanan_id);
        }
        $criteria->compare('LOWER(kelaspelayanan_nama)', strtolower($this->kelaspelayanan_nama), true);
        $criteria->compare('LOWER(gelardokterasal)', strtolower($this->gelardokterasal), true);
        $criteria->compare('LOWER(nama_dokterasal)', strtolower($this->nama_dokterasal), true);
        $criteria->compare('LOWER(gelarbelakang_nama)', strtolower($this->gelarbelakang_nama), true);
        $criteria->compare('LOWER(no_masukpenunjang)', strtolower($this->no_masukpenunjang), true);
        $criteria->compare('LOWER(tglmasukpenunjang)', strtolower($this->tglmasukpenunjang), true);
        $criteria->compare('LOWER(no_urutperiksa)', strtolower($this->no_urutperiksa), true);
        $criteria->compare('LOWER(kunjungan)', strtolower($this->kunjungan), true);
        $criteria->compare('LOWER(statusperiksa)', strtolower($this->statusperiksa), true);
        if (!empty($this->ruangan_id)) {
            $criteria->addCondition('ruangan_id = ' . Yii::app()->user->getState('ruangan_id'));
        }
        $criteria->compare('LOWER(ruangan_nama)', strtolower($this->ruangan_nama), true);
        if (!empty($this->pasienadmisi_id)) {
            $criteria->addCondition('pasienadmisi_id = ' . $this->pasienadmisi_id);
        }
        if (!empty($this->pasienmasukpenunjang_id)) {
            $criteria->addCondition('pasienmasukpenunjang_id = ' . $this->pasienmasukpenunjang_id);
        }
        $criteria->compare('LOWER(create_time)', strtolower($this->create_time), true);
        $criteria->compare('LOWER(create_loginpemakai_id)', strtolower($this->create_loginpemakai_id), true);
        $criteria->compare('LOWER(create_ruangan)', strtolower($this->create_ruangan), true);
        $criteria->compare('LOWER(gelardepan)', strtolower($this->gelardepan), true);
        $criteria->compare('LOWER(nama_pegawai)', strtolower($this->nama_pegawai), true);
        if (!empty($this->pegawai_id)) {
            $criteria->addCondition('pegawai_id = ' . $this->pegawai_id);
        }
        $criteria->order = 'tgl_pendaftaran DESC';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * generate cara bayar penjamin
     * @return type
     */
    public function getCaraBayarPenjamin() {

        return $this->carabayar_nama . ' / ' . $this->penjamin_nama;
    }

    
    /**
     * mengenerate format tanggal, ketika ditemukan pencarian data
     * @return boolean
     */
    protected function afterFind() {
        foreach ($this->metadata->tableSchema->columns as $columnName => $column) {

            if (!strlen($this->$columnName))
                continue;

            if ($column->dbType == 'date') {
                $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd'), 'medium', null);
            } elseif ($column->dbType == 'timestamp without time zone') {
                $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd hh:mm:ss', 'medium', null));
            }
        }
        return true;
    }

    /**
     * menampilkan nama pasien beserta nama panggilannya
     * @return type
     */
    function getNamaPasienNamaBin() {
        if (!empty($this->nama_bin)) {
            return $this->nama_pasien . ' alias ' . $this->nama_bin;
        } else {
            return $this->nama_pasien;
        }
    }

    /**
     * menmapilkan data instalasi dan ruangan asal
     * @return type
     */
    public function getInsatalasiRuanganAsal() {

        return $this->instalasiasal_nama . ' / ' . $this->ruanganasal_nama;
    }

    /**
     * mengenerate total tagihan
     * @return int
     */
    public function getTotaltagihan() {
        $criteria = new CDbCriteria();
        $criteria->select = 'sum(tarif_tindakan) as tarif_tindakan';
        $criteria->compare('pendaftaran_id', $this->pendaftaran_id);
        $criteria->compare('ruangan_id', Yii::app()->user->getState('ruangan_id'));
        $jumlah = RinciantagihanpasienV::model()->find($criteria)->tarif_tindakan;
        if (empty($jumlah)) {
            $jumlah = 0;
        }
        return $jumlah;
    }

    public function getNamaLengkap(){
        return (!empty($this->gelardepan)?$this->gelardepan.' ':'').$this->nama_pegawai.(!empty($this->gelarbelakang_nama)?', '.$this->gelarbelakang_nama:'');
    }

    /**
     * pencarian data rincian tagihan
     * @return \CActiveDataProvider
     */
    public function searchRincianTagihan() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;


        $criteria->compare('LOWER(no_rekam_medik)', strtolower($this->no_rekam_medik), true);
        $criteria->compare('LOWER(no_pendaftaran)', strtolower($this->no_pendaftaran), true);
        $criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien), true);
        $criteria->compare('LOWER(nama_bin)', strtolower($this->nama_bin), true);
        $criteria->compare('ruangan_id', Yii::app()->user->getState('ruangan_id'));
        $criteria->addBetweenCondition('DATE(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);


        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * menegenerate cara bayar 
     * @return type
     */
    public function getCaraBayarItems() {
        return CarabayarM::model()->findAll('carabayar_aktif=TRUE ORDER BY carabayar_nama ASC');
    }

    /**
     * mengenerate penjamin
     * @return type
     */
    public function getPenjaminItems() {
        return PenjaminpasienM::model()->findAll('penjamin_aktif=TRUE ORDER BY penjamin_nama ASC');
    }

    /**
     * mengenerate data propinsi
     * @return type
     */
    public function getPropinsiItems() {
        return PropinsiM::model()->findAll('propinsi_aktif=TRUE ORDER BY propinsi_nama');
    }

    /**
     * menampilkan nama depan, nama pasien dan nama panggilannya
     * @return type
     */
    public function getNamaNamaBIN() {
        if (!empty($this->nama_bin)) {
            return $this->namadepan . ' ' . $this->nama_pasien . ' alias ' . $this->nama_bin;
        } else {
            return $this->namadepan . ' ' . $this->nama_pasien;
        }
    }

    /**
     * menampilkan rt dan rw
     * @return type
     */
    public function getRTRW() {
        return $this->rt . ' / ' . $this->rw;
    }

    /**
     * mengenerate status periksa pasien
     * @param type $status
     * @param type $id
     * @return string
     */
    public function getStatus($status, $id = '') {

        $statusantara = Yii::app()->db->createCommand()->select('(barangjadi_stok) as barangjadi_stok, (barangjadi_id) as barangjadi_id')->from('barangjadi_m')->where("barangjadi_id = $id AND barangjadi_stok between barangjadi_stok and barangjadi_minimal")->queryAll();

        if ($status == strtolower('ANTRIAN')) {
            $status = '<span style="color:black;" id="yellow">' . $status . '</span>';
        } else if ($status == strtolower('SEDANG PERIKSA')) {
            $status = '<span style="color:black;" id="green">' . $status . '</span>';
        } else if ($status == strtolower('SUDAH PERIKSA')) {
            $status = '<span style="color:black; id="blue">' . $status . '</span>';
        } else {
            $status = '<span style="color:black;>' . $status . '</span>';
        }
        return $status;
    }

    /**
     * load data pekerjaan
     * @return type
     */
    public function getPekerjaanItems() {
        return PekerjaanM::model()->findAll('pekerjaan_aktif=TRUE ORDER BY pekerjaan_nama');
    }

    /**
     * load data pendidikan
     * @return type
     */
    public function getPendidikanItems() {
        return PendidikanM::model()->findAll('pendidikan_aktif=TRUE ORDER BY pendidikan_nama');
    }

    /**
     * load suku
     * @return type
     */
    public function getSukuItems() {
        return SukuM::model()->findAll('suku_aktif=TRUE ORDER BY suku_nama');
    }

    /**
     * - digunakan untuk menampilkan status periksa dan warnanya
     * @param type $status
     * @param type $pendaftaran_id
     * @return type
     */
    public function getStatusPeriksa($status, $pendaftaran_id = '') {
        if (!empty($pendaftaran_id)) {
            $p = PendaftaranT::model()->findByPk($pendaftaran_id);

            $status = $p->statusperiksa;
        }


        return Params::getWrStatusPeriksa($status);
    }

    /**
     * - digunakan untuk menampilkan status periksa hasil dan warnanya
     * @param type $status
     * @return string
     */
    public function getStatusHasil($status) {
        if ($status == Params::STATUSPERIKSAHASIL_BELUM) {
            $status = '<button class="btn btn-danger nohover">' . $status . '</button>';
        } else if ($status == Params::STATUSPERIKSAHASIL_SUDAH) {
            $status = '<button class="btn btn-blue nohover">' . $status . '</button>';
        }
        return $status;
    }

    /**
     * mengenerate status periksa, berdasarkan pendaftarannya
     * @return string
     */
    public function getStatusPeriksaDaftar() {
        if (!empty($this->pendaftaran_id)) {
            $p = PendaftaranT::model()->findByPk($this->pendaftaran_id);
            return $p->statusperiksa;
        } else {
            return '-';
        }
    }

    /**
     * - digunakan untuk mengambil data dokter pada tabel pendaftaran
     * @return string
     */
    public function getDokterPerujuk() {
        $pen = PendaftaranT::model()->findByPk($this->pendaftaran_id);

        if (!empty($pen)) {
            if(!empty($pen->pegawai->namaLengkap)){
                return $pen->pegawai->namaLengkap;
            }else if(!empty($pen->pegawai->nama_pegawai)){
                return $pen->pegawai->nama_pegawai;
            }else{
                return "-";
            }
        } else {
            return '';
        }
    }

    /**
     * load data tanggal meninggal
     * @return string
     */
    public function getTanggalMeninggal() {
        $tglMeninggal = PasienM::model()->findByPk($this->pasien_id);
        if (!empty($tglMeninggal->tgl_meninggal)) {
            return MyFormatter::formatDateTimeForUser($tglMeninggal->tgl_meninggal);
        } else {
            return '';
        }
    }
    
    /**
     * untuk mengenerate status periksa pennunjang
     * @param type $status
     * @param type $id
     * @param type $pasienmasukpenunjang_id
     * @return string
     */
    public function getPemeriksaanRad($status, $id, $pasienmasukpenunjang_id)
    {
        $pendaftaran = PendaftaranT::model()->findByPk($id);
        $pasienmasukpenunjang = PasienmasukpenunjangT::model()->findByPk($pasienmasukpenunjang_id);
        $modHasilPemeriksaan = HasilpemeriksaanlabT::model()->findByAttributes(array('pasienmasukpenunjang_id'=>$pasienmasukpenunjang_id));
        $selisih_periksa = 0;
        $selisih = time() - strtotime($pasienmasukpenunjang->tglmasukpenunjang);
     
        $pulang = PasienpulangT::model()->findByAttributes(
            array(
                    'pendaftaran_id'=>$id,
                    'pasienbatalpulang_id' => null,
            //                    'kondisikeluar_id'=>Params::KONDISIKELUAR_ID_RAWATINAP,
            )
        );


        if (!empty($pulang)) {
            $format = new MyFormatter();
            $tgl_pulang = $format->formatDateTimeForDb($pulang->tglpasienpulang);
            $selisih = time() - strtotime($tgl_pulang);
        }
                    
        if ($selisih < 60) {
            $selisih = $selisih."d";
        } elseif ($selisih < 3600) {
            $selisih = floor($selisih/60)."m";
        } elseif ($selisih < (3600 * 24)) {
            $selisih = floor($selisih/3600)."j";
        } else {
            $selisih = floor($selisih/(3600 * 24))."h";
        }
 
        if (empty($pasienmasukpenunjang->pasienkirimkeunitlain_id)) {
            //$selisih_periksa = time() - strtotime($pasienmasukpenunjang->waktumulaiperiksa);
            $selisih_periksa = 0;
            // untuk periksa pasien
            if ($selisih_periksa < 60) {
                $selisih_periksa = $selisih_periksa."d";
            } elseif ($selisih_periksa < 3600) {
                $selisih_periksa = floor($selisih_periksa/60)."m";
            } elseif ($selisih_periksa < (3600 * 24)) {
                $selisih_periksa = floor($selisih_periksa/3600)."j";
            } else {
                $selisih_periksa = floor($selisih_periksa/(3600 * 24))."h";
            }
            // end
        } else {
            //$selisih_periksa = time() - strtotime($pendaftaran->waktumulaiperiksa);
            $selisih_periksa = 0;
            // untuk periksa pasien di ambil dari pendaftaran_t karena pasien rujukan dari modul lain
            if ($selisih_periksa < 60) {
                $selisih_periksa = $selisih_periksa."d";
            } elseif ($selisih_periksa < 3600) {
                $selisih_periksa = floor($selisih_periksa/60)."m";
            } elseif ($selisih_periksa < (3600 * 24)) {
                $selisih_periksa = floor($selisih_periksa/3600)."j";
            } else {
                $selisih_periksa = floor($selisih_periksa/(3600 * 24))."h";
            }
            // end
        }
              
                    
        $status = $pasienmasukpenunjang->statusperiksa;
        if ($pasienmasukpenunjang->ruangan_id != $pendaftaran->ruangan_id) {
            $status = $pendaftaran->statusperiksa;
        }
        
        
        $status = trim($status);
        if ($status == "SEDANG PERIKSA") {
            //$badge = '<span class="badge badge-info pull-right badge-status">'.$selisih_periksa.'</span>';
            $badge = '';
            $status = '<button id="red" class="btn btn-gold nohover btn-status" name="yt1">'.$status.'</button>';
            $status = '<div class="button-status">'.$badge.$status.'</div>';
        } elseif ($status == "ANTRIAN") {
            //$badge = '<span class="badge badge-info pull-right badge-status">'.$selisih.'</span>';
            $badge = '';
            $status = '<button id="green" class="btn btn-black nohover btn-status" name="yt1">'.$status.'</button>';
            $status = '<div class="button-status">'.$badge.$status.'</div>';
        } elseif ($status == "SUDAH PULANG") {
            $status = '<button id="blue" class="btn btn-green nohover btn-status" name="yt1">'.$status.'</button>';
        } elseif ($status == "SUDAH DI PERIKSA") {
            $status = '<button id="orange" class="btn btn-blue nohover btn-status"  name="yt1">'.$status.'</button>';
        } elseif ($status == "SEDANG DIRAWAT INAP") {
            $admisi = PasienadmisiT::model()->findByAttributes(array('pendaftaran_id'=>$id));
            // $selisih = ceil((time() - strtotime($admisi->tgladmisi)) / (3600 * 24))."h";
        //    $badge = '<span class="badge badge-info pull-right badge-status">'.$selisih.'</span>';
            $badge = '';
            $status = '<button id="orange" class="btn btn-purple nohover btn-status"  name="yt1">'.$status.'</button>';
            $status = '<div class="button-status">'.$badge.$status.'</div>';
        } elseif ($status == "MENUNGGU ADMISI PASIEN") {
            //$badge = '<span class="badge badge-info pull-right badge-status">'.$selisih.'</span>';
            $badge = '';
            $status = '<button id="orange" class="btn btn-orange nohover btn-status"  name="yt1">'.$status.'</button>';
            $status = '<div class="button-status">'.$badge.$status.'</div>';
        } else {
            $status = '<button id="orange" class="btn btn-blue nohover btn-status"  name="yt1">'.$status.'</button>';
        }
        return $status;
    }
    
    public function getDokterItems($ruangan_id='')
    {
        if(!empty($ruangan_id)):
            return DokterV::model()->findAllByAttributes(array('ruangan_id'=>$ruangan_id), array(
                'order'=>'nama_pegawai',
            ));//, 'kelompokpegawai_id'=>Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK
        else:
            return array();
        endif;
    }
    
    public function getDokterParamedisItems($ruangan_id='')
    {
        if(!empty($ruangan_id)):
            $dokter = new CDbCriteria;
            $dokter->with = array('pegawai');
            $dokter->addCondition("t.ruangan_id = '$ruangan_id' ");
            //$dokter->addCondition("pegawai.kelompokpegawai_id IN (".Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK.", ".Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN.")");            
            $dokter->order = "kelompokpegawai_id ASC, pegawai.nama_pegawai ASC";
             
            return RuanganpegawaiM::model()->findAll($dokter);
            //return DokterV::model()->findAllByAttributes(array('ruangan_id'=>$ruangan_id), array(
              //  'order'=>'nama_pegawai',
            //));
        else:
            return array();
        endif;
    }
    
    public function getParamedisItems($ruangan_id='')
	{
		if(!empty($ruangan_id)):
			return ParamedisV::model()->findAllByAttributes(array('ruangan_id'=>$ruangan_id), array(
                            'order'=>'nama_pegawai',
                        ));//, 'kelompokpegawai_id'=>Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN
		else:
			return array();
                endif;
	}

    /**
     * - Menampilkan Status Kirim Hasil pemeriksaan Radiologi.
     * - Jika mencapai status SEDANG DIKIRIM, dan hasil tersebut sudah sampai ke
     * loket, maka pengguna dapat mengubah status tersebut.
     * 
     * 
     * @return string Tombol Status Kirim Hasil
     */
    public function getStatusHasilKirim() {
        $hasil = HasilpemeriksaanradT::model()->findByAttributes(
                array(
            'pasienmasukpenunjang_id' => $this->pasienmasukpenunjang_id,
                ), array(
            'condition' => 'tglpegambilanhasilrad is not null',
                )
        );

        if (empty($hasil)) {
            return CHtml::htmlButton('SIAP KIRIM', array(
                        'class' => 'btn btn-black',
                        'disabled' => true,
                        'onclick' => 'return false',
                        'rel' => null,
                        'title' => null,
                        'style' => 'width: 150px;',
            ));
        }

        if (empty($hasil)) {
            $col = CHtml::htmlButton('SIAP KIRIM', array(
                        'class' => 'btn btn-black',
                        'disabled' => true,
                        'style' => 'width: 150px;',
            ));
        } else if (!empty($hasil->tglverifikasi_dpjp) && $hasil->statuskirim_hasilrad == Params::STATUSKIRIM_HASILRAD_SIAP_KIRIM) {
            $col = CHtml::htmlButton(Params::STATUSKIRIM_HASILRAD_SIAP_KIRIM, array(
                        'class' => 'btn btn-black',
                        'onclick' => 'siapKirimRad(' . $this->pasienmasukpenunjang_id . ');',
                        'rel' => 'tooltip',
                        'title' => 'Klik untuk mengirimkan hasil radiologi ke loket foto',
                        'style' => 'width: 150px;'
            ));
        } else if ($hasil->statuskirim_hasilrad == Params::STATUSKIRIM_HASILRAD_SEDANG_KIRIM) {
            $col = CHtml::htmlButton(Params::STATUSKIRIM_HASILRAD_SEDANG_KIRIM, array(
                        'class' => 'btn btn-gold',
                        'onclick' => 'terimaHasilRad(' . $this->pasienmasukpenunjang_id . ');',
                        'rel' => 'tooltip',
                        'title' => 'Klik untuk mencatat waktu terima kirim hasil radiologi ke Loket Foto',
                        'style' => 'width: 150px;'
            ));
        } else if ($hasil->statuskirim_hasilrad == Params::STATUSKIRIM_HASILRAD_SUDAH_DITERIMA) {
            $col = CHtml::htmlButton(Params::STATUSKIRIM_HASILRAD_SUDAH_DITERIMA, array(
                        'class' => 'btn btn-green',
                        'onclick' => 'ambilHasilRad(' . $this->pasienmasukpenunjang_id . ');',
                        'rel' => 'tooltip',
                        'title' => 'Klik untuk mencatat waktu ambil kirim hasil radiologi dari Loket Foto',
                        'style' => 'width: 150px;'
            ));
        } else if ($hasil->statuskirim_hasilrad == Params::STATUSKIRIM_HASILRAD_SUDAH_DIAMBIL) {
            $col = CHtml::htmlButton(Params::STATUSKIRIM_HASILRAD_SUDAH_DIAMBIL, array(
                        'class' => 'btn btn-blue',
                        'onclick' => 'return false',
                        'rel' => null,
                        'title' => null,
                        'style' => 'width: 150px;'
            ));
        } else {
            $col = CHtml::htmlButton('SIAP KIRIM', array(
                        'class' => 'btn btn-black',
                        'disabled' => true,
                        'style' => 'width: 150px;',
            ));
        }


        return $col;
    }

    function validasiRekamMedis() {
        // jika diorder ke penunjang
        if(isset($_GET['pasienmasukpenunjang_id'])) {
            $modPenunjang = PasienmasukpenunjangT::model()->findByPk($_GET['pasienmasukpenunjang_id']);
            if(!empty($modPenunjang)) {
                // cek dia diorder dari rawat inap atau rj atau rd
                if(!empty($modPenunjang->pasienadmisi_id)) {
                    //jika pasien dari rawat inap maka cek tindak lanjutnya dari pasinadmisi_t.pasienpulang_id nya sudah terisi atau belum

                    if(!empty($modPenunjang->pasienadmisi->pasienpulang_id)) {
                        return true;
                    } else {
                        return false;
                    }
                }
            }
        }
        
        if ($this->statusperiksa == Params::STATUSPERIKSA_SUDAH_PULANG || $this->statusperiksa == Params::STATUSPERIKSA_SEDANG_DIRAWATINAP) {
            return true;
        }

        return false;
    }
}
