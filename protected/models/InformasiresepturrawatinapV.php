<?php

/**
 * This is the model class for table "informasiresepturrawatinap_v".
 *
 * The followings are the available columns in table 'informasiresepturrawatinap_v':
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $reseptur_id
 * @property string $tglreseptur
 * @property string $noreseptur
 * @property integer $instalasireseptur_id
 * @property string $instalasireseptur_nama
 * @property integer $ruanganreseptur_id
 * @property string $ruanganreseptur_nama
 * @property string $fileresep
 * @property integer $pasien_id
 * @property string $no_rekam_medik
 * @property string $pasien_jenisidentitas
 * @property string $pasien_noidentitas
 * @property string $namadepan
 * @property string $nama_pasien
 * @property string $nama_bin
 * @property string $jeniskelamin
 * @property string $tempat_lahir
 * @property string $tanggal_lahir
 * @property string $alamat_pasien
 * @property integer $rt
 * @property integer $rw
 * @property integer $kelurahan_id
 * @property string $kelurahan_nama
 * @property integer $kecamatan_id
 * @property string $kecamatan_nama
 * @property integer $kabupaten_id
 * @property string $kabupaten_nama
 * @property integer $propinsi_id
 * @property string $propinsi_nama
 * @property string $statusperkawinan
 * @property string $agama
 * @property string $golongandarah
 * @property string $rhesus
 * @property integer $anakke
 * @property integer $jumlah_bersaudara
 * @property string $no_telepon_pasien
 * @property string $no_mobile_pasien
 * @property string $warga_negara
 * @property string $alamatemail
 * @property string $nama_ibu
 * @property string $nama_ayah
 * @property integer $pendaftaran_id
 * @property string $tgl_pendaftaran
 * @property string $no_pendaftaran
 * @property integer $pasienadmisi_id
 * @property string $tgladmisi
 * @property integer $pegawai_id
 * @property string $nomorindukpegawai
 * @property string $pegawai_jenisidentitas
 * @property string $pegawai_noidentitas
 * @property string $gelardepan
 * @property string $nama_pegawai
 * @property string $gelarbelakang_nama
 * @property integer $penjualanresep_id
 * @property string $tglresep
 * @property string $noresep
 * @property string $tglpenjualan
 * @property integer $unitdosis_id
 * @property integer $instalasiunitdosis_id
 * @property string $instalasiunitdosis_nama
 * @property integer $ruanganunitdosis_id
 * @property string $ruanganunitdosis_nama
 * @property string $tgluntidosis
 * @property string $nounitdosis
 * @property double $beratbadan_kg
 * @property double $tinggibadan_cm
 * @property string $alergiobat
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property integer $carabayar_id
 * @property string $carabayar_nama
 * @property integer $penjamin_id
 * @property string $penjamin_nama
 * @property integer $jeniskasuspenyakit_id
 * @property string $jeniskasuspenyakit_nama
 * @property string $umur
 * @property boolean $isclose
 * @property string $status_terpenuhi
 * @property string $status_hariini
 */
class InformasiresepturrawatinapV extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public $tgl_awal, $tgl_akhir, $statusJual, $statusperiksa, $is_tgl;

    public function tableName() {
        return 'informasiresepturrawatinap_v';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('instalasi_id, ruangan_id, reseptur_id, instalasireseptur_id, ruanganreseptur_id, pasien_id, rt, rw, kelurahan_id, kecamatan_id, kabupaten_id, propinsi_id, anakke, jumlah_bersaudara, pendaftaran_id, pasienadmisi_id, pegawai_id, penjualanresep_id, unitdosis_id, instalasiunitdosis_id, ruanganunitdosis_id, carabayar_id, penjamin_id, jeniskasuspenyakit_id', 'numerical', 'integerOnly' => true),
            array('beratbadan_kg, tinggibadan_cm', 'numerical'),
            array('instalasi_nama, ruangan_nama, noreseptur, instalasireseptur_nama, ruanganreseptur_nama, nama_pasien, nama_bin, kelurahan_nama, kecamatan_nama, kabupaten_nama, propinsi_nama, nama_ibu, nama_ayah, nama_pegawai, noresep, instalasiunitdosis_nama, ruanganunitdosis_nama, carabayar_nama, penjamin_nama', 'length', 'max' => 50),
            array('fileresep', 'length', 'max' => 200),
            array('no_rekam_medik, gelardepan', 'length', 'max' => 10),
            array('pasien_jenisidentitas, namadepan, jeniskelamin, statusperkawinan, agama, rhesus, no_mobile_pasien, no_pendaftaran, pegawai_jenisidentitas, nounitdosis', 'length', 'max' => 20),
            array('pasien_noidentitas, nomorindukpegawai, umur', 'length', 'max' => 30),
            array('tempat_lahir, warga_negara', 'length', 'max' => 25),
            array('golongandarah', 'length', 'max' => 2),
            array('no_telepon_pasien, gelarbelakang_nama', 'length', 'max' => 15),
            array('alamatemail, pegawai_noidentitas, jeniskasuspenyakit_nama', 'length', 'max' => 100),
            array('tglreseptur, tanggal_lahir, alamat_pasien, tgl_pendaftaran, tgladmisi, tglresep, tglpenjualan, tgluntidosis, alergiobat, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, isclose, status_terpenuhi, status_hariini', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('instalasi_id, instalasi_nama, ruangan_id, ruangan_nama, reseptur_id, tglreseptur, noreseptur, instalasireseptur_id, instalasireseptur_nama, ruanganreseptur_id, ruanganreseptur_nama, fileresep, pasien_id, no_rekam_medik, pasien_jenisidentitas, pasien_noidentitas, namadepan, nama_pasien, nama_bin, jeniskelamin, tempat_lahir, tanggal_lahir, alamat_pasien, rt, rw, kelurahan_id, kelurahan_nama, kecamatan_id, kecamatan_nama, kabupaten_id, kabupaten_nama, propinsi_id, propinsi_nama, statusperkawinan, agama, golongandarah, rhesus, anakke, jumlah_bersaudara, no_telepon_pasien, no_mobile_pasien, warga_negara, alamatemail, nama_ibu, nama_ayah, pendaftaran_id, tgl_pendaftaran, no_pendaftaran, pasienadmisi_id, tgladmisi, pegawai_id, nomorindukpegawai, pegawai_jenisidentitas, pegawai_noidentitas, gelardepan, nama_pegawai, gelarbelakang_nama, penjualanresep_id, tglresep, noresep, tglpenjualan, unitdosis_id, instalasiunitdosis_id, instalasiunitdosis_nama, ruanganunitdosis_id, ruanganunitdosis_nama, tgluntidosis, nounitdosis, beratbadan_kg, tinggibadan_cm, alergiobat, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, carabayar_id, carabayar_nama, penjamin_id, penjamin_nama, jeniskasuspenyakit_id, jeniskasuspenyakit_nama, umur, isclose, status_terpenuhi, status_hariini', 'safe', 'on' => 'search'),
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
            'instalasi_id' => 'Instalasi',
            'instalasi_nama' => 'Instalasi Nama',
            'ruangan_id' => 'Ruangan',
            'ruangan_nama' => 'Ruangan Nama',
            'reseptur_id' => 'Reseptur',
            'tglreseptur' => 'Tgl. Reseptur',
            'noreseptur' => 'No. Reseptur',
            'instalasireseptur_id' => 'Instalasi',
            'instalasireseptur_nama' => 'Instalasireseptur Nama',
            'ruanganreseptur_id' => 'Ruangan',
            'ruanganreseptur_nama' => 'Ruanganreseptur Nama',
            'fileresep' => 'Fileresep',
            'pasien_id' => 'Pasien',
            'no_rekam_medik' => 'No. Rekam Medik',
            'pasien_jenisidentitas' => 'Pasien Jenisidentitas',
            'pasien_noidentitas' => 'Pasien Noidentitas',
            'namadepan' => 'Namadepan',
            'nama_pasien' => 'Nama Pasien',
            'nama_bin' => 'Nama Bin',
            'jeniskelamin' => 'Jeniskelamin',
            'tempat_lahir' => 'Tempat Lahir',
            'tanggal_lahir' => 'Tanggal Lahir',
            'alamat_pasien' => 'Alamat Pasien',
            'rt' => 'Rt',
            'rw' => 'Rw',
            'kelurahan_id' => 'Kelurahan',
            'kelurahan_nama' => 'Kelurahan Nama',
            'kecamatan_id' => 'Kecamatan',
            'kecamatan_nama' => 'Kecamatan Nama',
            'kabupaten_id' => 'Kabupaten',
            'kabupaten_nama' => 'Kabupaten Nama',
            'propinsi_id' => 'Propinsi',
            'propinsi_nama' => 'Propinsi Nama',
            'statusperkawinan' => 'Statusperkawinan',
            'agama' => 'Agama',
            'golongandarah' => 'Golongandarah',
            'rhesus' => 'Rhesus',
            'anakke' => 'Anakke',
            'jumlah_bersaudara' => 'Jumlah Bersaudara',
            'no_telepon_pasien' => 'No Telepon Pasien',
            'no_mobile_pasien' => 'No Mobile Pasien',
            'warga_negara' => 'Warga Negara',
            'alamatemail' => 'Alamatemail',
            'nama_ibu' => 'Nama Ibu',
            'nama_ayah' => 'Nama Ayah',
            'pendaftaran_id' => 'Pendaftaran',
            'tgl_pendaftaran' => 'Tgl. Pendaftaran',
            'no_pendaftaran' => 'No. Pendaftaran',
            'pasienadmisi_id' => 'Pasienadmisi',
            'tgladmisi' => 'Tgladmisi',
            'pegawai_id' => 'Dokter',
            'nomorindukpegawai' => 'Nomorindukpegawai',
            'pegawai_jenisidentitas' => 'Pegawai Jenisidentitas',
            'pegawai_noidentitas' => 'Pegawai Noidentitas',
            'gelardepan' => 'Gelardepan',
            'nama_pegawai' => 'Nama Pegawai',
            'gelarbelakang_nama' => 'Gelarbelakang Nama',
            'penjualanresep_id' => 'Penjualanresep',
            'tglresep' => 'Tglresep',
            'noresep' => 'Noresep',
            'tglpenjualan' => 'Tglpenjualan',
            'unitdosis_id' => 'Unitdosis',
            'instalasiunitdosis_id' => 'Instalasiunitdosis',
            'instalasiunitdosis_nama' => 'Instalasiunitdosis Nama',
            'ruanganunitdosis_id' => 'Ruanganunitdosis',
            'ruanganunitdosis_nama' => 'Ruanganunitdosis Nama',
            'tgluntidosis' => 'Tgluntidosis',
            'nounitdosis' => 'Nounitdosis',
            'beratbadan_kg' => 'Beratbadan Kg',
            'tinggibadan_cm' => 'Tinggibadan Cm',
            'alergiobat' => 'Alergiobat',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'create_loginpemakai_id' => 'Create Loginpemakai',
            'update_loginpemakai_id' => 'Update Loginpemakai',
            'create_ruangan' => 'Create Ruangan',
            'carabayar_id' => 'Jenis Penjamin',
            'carabayar_nama' => 'Carabayar Nama',
            'penjamin_id' => 'Penjamin',
            'penjamin_nama' => 'Penjamin Nama',
            'jeniskasuspenyakit_id' => 'Jeniskasuspenyakit',
            'jeniskasuspenyakit_nama' => 'Jenis Kasus Penyakit',
            'umur' => 'Umur',
            'isclose' => 'Isclose',
            'status_terpenuhi' => 'Terpenuhi',
            'status_hariini' => 'Status Hariini',
            'statusperiksa' => 'Status Periksa',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function criteriaSearch() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('instalasi_id', $this->instalasi_id);
        $criteria->compare('instalasi_nama', $this->instalasi_nama, true);
        $criteria->compare('ruangan_id', $this->ruangan_id);
        $criteria->compare('ruangan_nama', $this->ruangan_nama, true);
        $criteria->compare('reseptur_id', $this->reseptur_id);
        $criteria->compare('noreseptur', $this->noreseptur, true);
        $criteria->compare('instalasireseptur_id', $this->instalasireseptur_id);
        $criteria->compare('instalasireseptur_nama', $this->instalasireseptur_nama, true);
        $criteria->compare('ruanganreseptur_id', $this->ruanganreseptur_id);
        $criteria->compare('ruanganreseptur_nama', $this->ruanganreseptur_nama, true);
        $criteria->compare('fileresep', $this->fileresep, true);
        $criteria->compare('pasien_id', $this->pasien_id);
        $criteria->compare('no_rekam_medik', $this->no_rekam_medik, true);
        $criteria->compare('pasien_jenisidentitas', $this->pasien_jenisidentitas, true);
        $criteria->compare('pasien_noidentitas', $this->pasien_noidentitas, true);
        $criteria->compare('namadepan', $this->namadepan, true);
        $criteria->compare('lower(nama_pasien)', strtolower($this->nama_pasien), true);
        $criteria->compare('nama_bin', $this->nama_bin, true);
        $criteria->compare('jeniskelamin', $this->jeniskelamin, true);
        $criteria->compare('tempat_lahir', $this->tempat_lahir, true);
        $criteria->compare('tanggal_lahir', $this->tanggal_lahir, true);
        $criteria->compare('alamat_pasien', $this->alamat_pasien, true);
        $criteria->compare('rt', $this->rt);
        $criteria->compare('rw', $this->rw);
        $criteria->compare('kelurahan_id', $this->kelurahan_id);
        $criteria->compare('kelurahan_nama', $this->kelurahan_nama, true);
        $criteria->compare('kecamatan_id', $this->kecamatan_id);
        $criteria->compare('kecamatan_nama', $this->kecamatan_nama, true);
        $criteria->compare('kabupaten_id', $this->kabupaten_id);
        $criteria->compare('kabupaten_nama', $this->kabupaten_nama, true);
        $criteria->compare('propinsi_id', $this->propinsi_id);
        $criteria->compare('propinsi_nama', $this->propinsi_nama, true);
        $criteria->compare('statusperkawinan', $this->statusperkawinan, true);
        $criteria->compare('agama', $this->agama, true);
        $criteria->compare('golongandarah', $this->golongandarah, true);
        $criteria->compare('rhesus', $this->rhesus, true);
        $criteria->compare('anakke', $this->anakke);
        $criteria->compare('jumlah_bersaudara', $this->jumlah_bersaudara);
        $criteria->compare('no_telepon_pasien', $this->no_telepon_pasien, true);
        $criteria->compare('no_mobile_pasien', $this->no_mobile_pasien, true);
        $criteria->compare('warga_negara', $this->warga_negara, true);
        $criteria->compare('alamatemail', $this->alamatemail, true);
        $criteria->compare('nama_ibu', $this->nama_ibu, true);
        $criteria->compare('nama_ayah', $this->nama_ayah, true);
        $criteria->compare('pendaftaran_id', $this->pendaftaran_id);
        $criteria->compare('tgl_pendaftaran', $this->tgl_pendaftaran, true);
        $criteria->compare('no_pendaftaran', $this->no_pendaftaran, true);
        $criteria->compare('pasienadmisi_id', $this->pasienadmisi_id);
        $criteria->compare('tgladmisi', $this->tgladmisi, true);
        $criteria->compare('t.pegawai_id', $this->pegawai_id);
        $criteria->compare('nomorindukpegawai', $this->nomorindukpegawai, true);
        $criteria->compare('pegawai_jenisidentitas', $this->pegawai_jenisidentitas, true);
        $criteria->compare('pegawai_noidentitas', $this->pegawai_noidentitas, true);
        $criteria->compare('gelardepan', $this->gelardepan, true);
        $criteria->compare('nama_pegawai', $this->nama_pegawai, true);
        $criteria->compare('gelarbelakang_nama', $this->gelarbelakang_nama, true);
        $criteria->compare('penjualanresep_id', $this->penjualanresep_id);
        $criteria->compare('tglresep', $this->tglresep, true);
        $criteria->compare('noresep', $this->noresep, true);
        $criteria->compare('tglpenjualan', $this->tglpenjualan, true);
        $criteria->compare('unitdosis_id', $this->unitdosis_id);
        $criteria->compare('instalasiunitdosis_id', $this->instalasiunitdosis_id);
        $criteria->compare('instalasiunitdosis_nama', $this->instalasiunitdosis_nama, true);
        $criteria->compare('ruanganunitdosis_id', $this->ruanganunitdosis_id);
        $criteria->compare('ruanganunitdosis_nama', $this->ruanganunitdosis_nama, true);
        $criteria->compare('tgluntidosis', $this->tgluntidosis, true);
        $criteria->compare('nounitdosis', $this->nounitdosis, true);
        $criteria->compare('beratbadan_kg', $this->beratbadan_kg);
        $criteria->compare('tinggibadan_cm', $this->tinggibadan_cm);
        $criteria->compare('alergiobat', $this->alergiobat, true);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('update_time', $this->update_time, true);
        $criteria->compare('create_loginpemakai_id', $this->create_loginpemakai_id, true);
        $criteria->compare('update_loginpemakai_id', $this->update_loginpemakai_id, true);
        $criteria->compare('create_ruangan', $this->create_ruangan, true);
        $criteria->compare('t.carabayar_id', $this->carabayar_id);
        $criteria->compare('carabayar_nama', $this->carabayar_nama, true);
        $criteria->compare('t.penjamin_id', $this->penjamin_id);
        $criteria->compare('penjamin_nama', $this->penjamin_nama, true);
        $criteria->compare('jeniskasuspenyakit_id', $this->jeniskasuspenyakit_id);
        $criteria->compare('jeniskasuspenyakit_nama', $this->jeniskasuspenyakit_nama, true);
        $criteria->compare('umur', $this->umur, true);
        $criteria->compare('isclose', $this->isclose);
        $criteria->compare('status_terpenuhi', $this->status_terpenuhi, true);
        $criteria->compare('status_hariini', $this->status_hariini, true);

        return $criteria;
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = $this->criteriaSearch();
        $criteria->limit = 10;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function searchInformasiPasienResepRI() {
        $criteria = $this->criteriaSearch();
        $criteria->addCondition("instalasireseptur_id IN (select lookup_value::integer from lookup_m where lookup_type = 'instalasipemberianobatrutin') ");
        if ($this->is_tgl) {
            $criteria->addBetweenCondition('date(t.tglreseptur)', $this->tgl_awal, $this->tgl_akhir);
        }
        $criteria->compare('noreseptur', $this->noreseptur, true);
        $criteria->compare('lower(no_rekam_medik)', strtolower($this->no_rekam_medik), true);
        $criteria->compare('lower(nama_pasien)', strtolower($this->nama_pasien), true);
        $criteria->compare('carabayar_id', $this->carabayar_id, true);
        $criteria->compare('penjamin_id', $this->penjamin_id, true);
        $criteria->compare('pegawai_id', $this->pegawai_id, true);
        $criteria->compare('instalasireseptur_id', $this->instalasireseptur_id, true);
        $criteria->compare('ruanganreseptur_id', $this->ruanganreseptur_id, true);

//        var_dump($this->tgl_awal, $this->tgl_akhir); 
        $criteria->order = 't.no_pendaftaran desc, t.tglreseptur DESC';
        $criteria->join = "join pendaftaran_t p on p.pendaftaran_id = t.pendaftaran_id";
        $criteria->compare('lower(p.statusperiksa)', strtolower($this->statusperiksa), true);
        if ($this->statusJual == 1) {
            $criteria->addCondition("status_hariini = 'Sudah Dijual'");
        } else if ($this->statusJual == 2) {
            $criteria->addCondition("status_hariini = 'Belum Dijual'");
        }
        // $criteria->limit=10;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function getAlergiObat() {
        $nama = '';
        $modAnamnesa = AnamnesaT::model()->findAllByAttributes(array('pendaftaran_id' => $this->pendaftaran_id));

        if (count((array) $modAnamnesa)) {
            $no = 1;
            $checkAlergi = 0;
            foreach ($modAnamnesa as $anamnesa => $val) {
                if (!empty(trim($val->riwayatalergiobat))) {
                    $val->riwayatalergiobat = preg_replace('/\s+/', '', $val->riwayatalergiobat);
                    $datatable = explode(',', trim($val->riwayatalergiobat));
                    if (!empty($datatable)) {
                        foreach ($datatable as $key => $value) {
                            $nama .= ' ' . $no . '.' . $value . '<br>';
                            $no++;
                        }
                    }
                    $checkAlergi++;
                } else {
                    if ($checkAlergi > 1) {
                        $checkAlergi--;
                    }
                }
            }
            if ($checkAlergi == 0) {
                $nama = 'TIDAK ADA';
            }
        } else {
            $nama = 'TIDAK ADA';
        }
        return $nama;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return InformasiresepturrawatinapV the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
