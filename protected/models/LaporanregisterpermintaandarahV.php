<?php

/**
 * This is the model class for table "laporanregisterpermintaandarah_v".
 * 
 * @author Andyka Putra <andykaputra@.com>
 * @package application.models
 * 
 * The followings are the available columns in table 'laporanregisterpermintaandarah_v':
 * @property integer $permintaandarah_id
 * @property string $tglpermintaan
 * @property string $no_permintaandarah
 * @property string $jenispermintaan
 * @property integer $pegpemesan_id
 * @property string $gelardepan
 * @property string $nama_pegawai
 * @property integer $pasien_id
 * @property string $gejala_transfusi
 * @property integer $ruanganpemesan_id
 * @property string $ruanganpemesan_nama
 * @property integer $instalasipemesan_id
 * @property string $instalasipemesan_nama
 * @property string $jenisidentitas
 * @property string $no_identitas_pasien
 * @property string $jeniskelamin
 * @property string $tempat_lahir
 * @property string $tanggal_lahir
 * @property string $alamat_pasien
 * @property integer $rt
 * @property integer $rw
 * @property string $statusperkawinan
 * @property string $agama
 * @property string $golongandarah
 * @property string $rhesus
 * @property string $no_mobile_pasien
 * @property string $no_rekam_medik
 * @property string $namadepan
 * @property string $nama_pasien
 * @property string $gelarbelakang_nama
 * @property integer $propinsi_id
 * @property string $propinsi_nama
 * @property integer $kabupaten_id
 * @property string $kabupaten_nama
 * @property integer $pendaftaran_id
 * @property string $no_pendaftaran
 * @property string $tgl_pendaftaran
 * @property string $statusperiksa
 * @property string $statuspasien
 * @property string $kunjungan
 * @property string $umur
 * @property string $tglselesaiperiksa
 * @property integer $instalasikunjungan_id
 * @property string $instalasikunjungan_nama
 * @property integer $ruangankunjunggan_id
 * @property string $ruangankunjunggan_nama
 * @property integer $carabayar_id
 * @property string $carabayar_nama
 * @property integer $penjamin_id
 * @property string $penjamin_nama
 * @property string $tglpenyiapandarah
 * @property double $lamapenyiapan_detik
 * @property string $ket_penyiapan
 */
class LaporanregisterpermintaandarahV extends CActiveRecord
{
    public $instalasi_id, $instalasi_nama, $ruangan_id, $ruangan_nama;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return LaporanregisterpermintaandarahV the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'laporanregisterpermintaandarah_v';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('permintaandarah_id, pegpemesan_id, pasien_id, ruanganpemesan_id, instalasipemesan_id, rt, rw, propinsi_id, kabupaten_id, pendaftaran_id, instalasikunjungan_id, ruangankunjunggan_id, carabayar_id, penjamin_id', 'numerical', 'integerOnly' => true),
            array('lamapenyiapan_detik', 'numerical'),
            array('no_permintaandarah, nama_pegawai, gejala_transfusi, ruanganpemesan_nama, instalasipemesan_nama, nama_pasien, propinsi_nama, kabupaten_nama, statusperiksa, statuspasien, kunjungan, instalasikunjungan_nama, ruangankunjunggan_nama, carabayar_nama, penjamin_nama', 'length', 'max' => 50),
            array('jenispermintaan, gelardepan, no_rekam_medik', 'length', 'max' => 10),
            array('jenisidentitas, jeniskelamin, statusperkawinan, agama, rhesus, no_mobile_pasien, namadepan, no_pendaftaran', 'length', 'max' => 20),
            array('no_identitas_pasien, umur', 'length', 'max' => 30),
            array('tempat_lahir, gelarbelakang_nama', 'length', 'max' => 25),
            array('golongandarah', 'length', 'max' => 2),
            array('tglpermintaan, tanggal_lahir, alamat_pasien, tgl_pendaftaran, tglselesaiperiksa, tglpenyiapandarah, ket_penyiapan', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('permintaandarah_id, tglpermintaan, no_permintaandarah, jenispermintaan, pegpemesan_id, gelardepan, nama_pegawai, pasien_id, gejala_transfusi, ruanganpemesan_id, ruanganpemesan_nama, instalasipemesan_id, instalasipemesan_nama, jenisidentitas, no_identitas_pasien, jeniskelamin, tempat_lahir, tanggal_lahir, alamat_pasien, rt, rw, statusperkawinan, agama, golongandarah, rhesus, no_mobile_pasien, no_rekam_medik, namadepan, nama_pasien, gelarbelakang_nama, propinsi_id, propinsi_nama, kabupaten_id, kabupaten_nama, pendaftaran_id, no_pendaftaran, tgl_pendaftaran, statusperiksa, statuspasien, kunjungan, umur, tglselesaiperiksa, instalasikunjungan_id, instalasikunjungan_nama, ruangankunjunggan_id, ruangankunjunggan_nama, carabayar_id, carabayar_nama, penjamin_id, penjamin_nama, tglpenyiapandarah, lamapenyiapan_detik, ket_penyiapan', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'permintaandarah_id' => 'Permintaandarah',
            'tglpermintaan' => 'Tglpermintaan',
            'no_permintaandarah' => 'No Permintaandarah',
            'jenispermintaan' => 'Jenispermintaan',
            'pegpemesan_id' => 'Pegpemesan',
            'gelardepan' => 'Gelardepan',
            'nama_pegawai' => 'Nama Pegawai',
            'pasien_id' => 'Pasien',
            'gejala_transfusi' => 'Gejala Transfusi',
            'ruanganpemesan_id' => 'Ruanganpemesan',
            'ruanganpemesan_nama' => 'Ruanganpemesan Nama',
            'instalasipemesan_id' => 'Instalasipemesan',
            'instalasipemesan_nama' => 'Instalasipemesan Nama',
            'jenisidentitas' => 'Jenisidentitas',
            'no_identitas_pasien' => 'No Identitas Pasien',
            'jeniskelamin' => 'Jenis Kelamin',
            'tempat_lahir' => 'Tempat Lahir',
            'tanggal_lahir' => 'Tanggal Lahir',
            'alamat_pasien' => 'Alamat Pasien',
            'rt' => 'RT',
            'rw' => 'RW',
            'statusperkawinan' => 'Statusperkawinan',
            'agama' => 'Agama',
            'golongandarah' => 'Golongandarah',
            'rhesus' => 'Rhesus',
            'no_mobile_pasien' => 'No. Handphone Pasien',
            'no_rekam_medik' => 'No. Rekam Medik',
            'namadepan' => 'Namadepan',
            'nama_pasien' => 'Nama Pasien',
            'gelarbelakang_nama' => 'Gelarbelakang Nama',
            'propinsi_id' => 'Provinsi',
            'propinsi_nama' => 'Propinsi Nama',
            'kabupaten_id' => 'Kabupaten',
            'kabupaten_nama' => 'Kabupaten Nama',
            'pendaftaran_id' => 'Pendaftaran',
            'no_pendaftaran' => 'No. Pendaftaran',
            'tgl_pendaftaran' => 'Tgl. Pendaftaran',
            'statusperiksa' => 'Statusperiksa',
            'statuspasien' => 'Statuspasien',
            'kunjungan' => 'Kunjungan',
            'umur' => 'Umur',
            'tglselesaiperiksa' => 'Tglselesaiperiksa',
            'instalasikunjungan_id' => 'Instalasikunjungan',
            'instalasikunjungan_nama' => 'Instalasikunjungan Nama',
            'ruangankunjunggan_id' => 'Ruangankunjunggan',
            'ruangankunjunggan_nama' => 'Ruangankunjunggan Nama',
            'carabayar_id' => 'Jenis Penjamin',
            'carabayar_nama' => 'Carabayar Nama',
            'penjamin_id' => 'Penjamin',
            'penjamin_nama' => 'Penjamin Nama',
            'tglpenyiapandarah' => 'Tglpenyiapandarah',
            'lamapenyiapan_detik' => 'Lamapenyiapan Detik',
            'ket_penyiapan' => 'Ket Penyiapan',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('permintaandarah_id', $this->permintaandarah_id);
        $criteria->compare('tglpermintaan', $this->tglpermintaan, true);
        $criteria->compare('no_permintaandarah', $this->no_permintaandarah, true);
        $criteria->compare('jenispermintaan', $this->jenispermintaan, true);
        $criteria->compare('pegpemesan_id', $this->pegpemesan_id);
        $criteria->compare('gelardepan', $this->gelardepan, true);
        $criteria->compare('nama_pegawai', $this->nama_pegawai, true);
        $criteria->compare('pasien_id', $this->pasien_id);
        $criteria->compare('gejala_transfusi', $this->gejala_transfusi, true);
        $criteria->compare('ruanganpemesan_id', $this->ruanganpemesan_id);
        $criteria->compare('ruanganpemesan_nama', $this->ruanganpemesan_nama, true);
        $criteria->compare('instalasipemesan_id', $this->instalasipemesan_id);
        $criteria->compare('instalasipemesan_nama', $this->instalasipemesan_nama, true);
        $criteria->compare('jenisidentitas', $this->jenisidentitas, true);
        $criteria->compare('no_identitas_pasien', $this->no_identitas_pasien, true);
        $criteria->compare('jeniskelamin', $this->jeniskelamin, true);
        $criteria->compare('tempat_lahir', $this->tempat_lahir, true);
        $criteria->compare('tanggal_lahir', $this->tanggal_lahir, true);
        $criteria->compare('alamat_pasien', $this->alamat_pasien, true);
        $criteria->compare('rt', $this->rt);
        $criteria->compare('rw', $this->rw);
        $criteria->compare('statusperkawinan', $this->statusperkawinan, true);
        $criteria->compare('agama', $this->agama, true);
        $criteria->compare('golongandarah', $this->golongandarah, true);
        $criteria->compare('rhesus', $this->rhesus, true);
        $criteria->compare('no_mobile_pasien', $this->no_mobile_pasien, true);
        $criteria->compare('no_rekam_medik', $this->no_rekam_medik, true);
        $criteria->compare('namadepan', $this->namadepan, true);
        $criteria->compare('nama_pasien', $this->nama_pasien, true);
        $criteria->compare('gelarbelakang_nama', $this->gelarbelakang_nama, true);
        $criteria->compare('propinsi_id', $this->propinsi_id);
        $criteria->compare('propinsi_nama', $this->propinsi_nama, true);
        $criteria->compare('kabupaten_id', $this->kabupaten_id);
        $criteria->compare('kabupaten_nama', $this->kabupaten_nama, true);
        $criteria->compare('pendaftaran_id', $this->pendaftaran_id);
        $criteria->compare('no_pendaftaran', $this->no_pendaftaran, true);
        $criteria->compare('tgl_pendaftaran', $this->tgl_pendaftaran, true);
        $criteria->compare('statusperiksa', $this->statusperiksa, true);
        $criteria->compare('statuspasien', $this->statuspasien, true);
        $criteria->compare('kunjungan', $this->kunjungan, true);
        $criteria->compare('umur', $this->umur, true);
        $criteria->compare('tglselesaiperiksa', $this->tglselesaiperiksa, true);
        $criteria->compare('instalasikunjungan_id', $this->instalasikunjungan_id);
        $criteria->compare('instalasikunjungan_nama', $this->instalasikunjungan_nama, true);
        $criteria->compare('ruangankunjunggan_id', $this->ruangankunjunggan_id);
        $criteria->compare('ruangankunjunggan_nama', $this->ruangankunjunggan_nama, true);
        $criteria->compare('carabayar_id', $this->carabayar_id);
        $criteria->compare('carabayar_nama', $this->carabayar_nama, true);
        $criteria->compare('penjamin_id', $this->penjamin_id);
        $criteria->compare('penjamin_nama', $this->penjamin_nama, true);
        $criteria->compare('tglpenyiapandarah', $this->tglpenyiapandarah, true);
        $criteria->compare('lamapenyiapan_detik', $this->lamapenyiapan_detik);
        $criteria->compare('ket_penyiapan', $this->ket_penyiapan, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Digunakan untuk mendapatkan semua data propinsi yang aktif
     * @return type
     */
    public function getPropinsiItems()
    {
        return PropinsiM::model()->findAll('propinsi_aktif=TRUE ORDER BY propinsi_nama');
    }

    /**
     * Digunakan untuk mendapatkan semua data instalasi
     * @return type
     */
    public function getInstalasiItems()
    {
        return LaporanregisterpermintaandarahV::model()->findAll();
    }

    /**
     * Digunakan untuk mendapatkan data semua cara bayar yang aktif
     * @return type
     */
    public function getCaraBayarItems()
    {
        return CarabayarM::model()->findAll('carabayar_aktif=TRUE');
    }

    /**
     * Digunakan untuk mendapatkan custom data dengan format "tanggal pendaftaran / no_pendaftaran"
     * @return type
     */
    public function getTglPendNoPend()
    {
        return MyFormatter::formatDateTimeForUser(date("d/m/Y", strtotime($this->tgl_pendaftaran))) . ' / <br/> ' . $this->no_pendaftaran;
    }

    /**
     * Digunakan untuk mendapatkan custom data dengan format 'tanggal permintaan / no permintaan darah'
     * @return type
     */
    public function getTglPerNoPer()
    {
        return MyFormatter::formatDateTimeForUser(date("d/m/Y", strtotime($this->tglpermintaan))) . '/ <br>' . PHP_EOL . $this->no_permintaandarah;
    }

    /**
     * Digunakan untuk mendapatkan custom data dengan format 'jenis kelamin / umur'
     * @return type
     */
    public function getJenisKelaminUmur()
    {
        return $this->jeniskelamin . '/ <br>' . $this->umur;
    }

    /**
     * Digunakan untuk mendapatkan custom data dengan format 'instalasi pemesan / ruangan pemesan'
     * @return type
     */
    public function getInstalasiRuangan()
    {
        return $this->instalasipemesan_nama . '/ <br>' . $this->ruanganpemesan_nama;
    }

    /**
     * Digunakan untuk mendapatkan custom data dengan format 'carabayar / penjamin'
     * @return type
     */
    public function getCaraBayarPenjamin()
    {
        return $this->carabayar_nama . ' / ' . $this->penjamin_nama;
    }
}
