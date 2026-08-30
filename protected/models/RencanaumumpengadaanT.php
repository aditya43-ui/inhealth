<?php

/**
 * This is the model class for table "rencanaumumpengadaan_t".
 *
 * @author Tantowi J <tantowijaya@.com>
 * @package application.models
 * 
 * The followings are the available columns in table 'rencanaumumpengadaan_t':
 * @property integer $rencanaumumpengadaan_id
 * @property integer $unitkerja_id
 * @property integer $instalasi_id
 * @property integer $pegawaipembuat_id
 * @property string $rencanaumumpengadaan_nomor
 * @property string $rencanaumumpengadaan_tanggal
 * @property string $rencanaumumpengadaan_kategori
 * @property integer $periodeanggaran_id
 * @property string $rencanaumumpengadaan_tahun
 * @property integer $subprogram_id
 * @property string $nama_pekerjaan
 * @property string $volume_pekerjaan
 * @property string $uraian_pekerjaan
 * @property string $spesifikasi_pekerjaan
 * @property boolean $isprodukdalamnegeri
 * @property boolean $isusahakecil
 * @property boolean $ispradpa
 * @property string $nomor_kppuas
 * @property string $nomorizin_tahunjamak
 * @property integer $metodepengadaan_id
 * @property string $metode_pengadaan
 * @property string $pemanfaatanbarang_tglawal
 * @property string $pemanfaatanbarang_tglakhir
 * @property string $pelaksanaankontrak_tglawal
 * @property string $pelaksanaankontrak_tglakhir
 * @property string $pemilihanpenyedia_tglawal
 * @property string $pemilihanpenyedia_tglakhir
 * @property string $swakelola_tipe
 * @property string $swakelola_penyelenggara
 * @property string $swakelola_satker
 * @property double $total_pagu
 * @property string $kode_rup
 * @property string $rencanaumumpengadaan_status
 * @property integer $pegawaippk_id
 * @property integer $pegawaipa_id
 * @property integer $pegawaikpa_id
 * @property integer $usulanpengadaan_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property PengadaandokumenpendukungT[] $pengadaandokumenpendukungTs
 * @property PengadaanjenisT[] $pengadaanjenisTs
 * @property PengadaanlokasiT[] $pengadaanlokasiTs
 * @property PengadaansumberdanaT[] $pengadaansumberdanaTs
 * @property RencanaumumpengadaandetT[] $rencanaumumpengadaandetTs
 * @property UnitkerjaM $unitkerja
 * @property MetodepengadaanM $metodepengadaan
 * @property PegawaiM $pegawaipembuat
 * @property InstalasiM $instalasi
 * @property PegawaiM $pegawaikpa
 * @property PegawaiM $pegawaipa
 * @property PegawaiM $pegawaippk
 * @property SubprogramkerjaM $subprogram
 * @property PeriodeanggaranK $periodeanggaran
 * @property PersiapanpengadaanT[] $persiapanpengadaanTs
 */
class RencanaumumpengadaanT extends CActiveRecord {

    public $pegawaipembuat_nama, $unitkerja_nama, $subprogram_nama, $labels, $data, $total, $total_sisapagu, $total_serapan;
    public $filter, $programkerja_nama, $subprogramkerja_nama, $subprogramkerja_id, $jenispengadaan_nama, $jenispengadaan_id;
    public $instalasi_nama, $namaunitkerja, $programkerja_id ;
    public $subkegiatanprogram_nama, $pegawaipa_nama, $pegawaikpa_nama, $pegawaippk_nama;
    public $programkerja_kode,$subprogramkerja_kode,$subkegiatanprogram_kode, $temp_file;    
    
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return RencanaumumpengadaanT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'rencanaumumpengadaan_t';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('pegawaipa_id, pegawaikpa_id, pegawaippk_id, rencanaumumpengadaan_nomor, rencanaumumpengadaan_tanggal, rencanaumumpengadaan_kategori, rencanaumumpengadaan_tahun, nama_pekerjaan, create_time, create_loginpemakai_id, create_ruangan, instalasi_id, volume_pekerjaan, uraian_pekerjaan, subprogram_id', 'required'),
            array('unitkerja_id, instalasi_id, pegawaipembuat_id, periodeanggaran_id, subprogram_id, metodepengadaan_id, pegawaippk_id, pegawaipa_id, pegawaikpa_id, usulanpengadaan_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly' => true),
            array('total_pagu', 'numerical'),
            array('rencanaumumpengadaan_nomor, rencanaumumpengadaan_kategori', 'length', 'max' => 20),
            array('rencanaumumpengadaan_tahun', 'length', 'max' => 4),
            array('nama_pekerjaan', 'length', 'max' => 300),
            array('volume_pekerjaan, metode_pengadaan, swakelola_tipe, rencanaumumpengadaan_status', 'length', 'max' => 100),
            array('uraian_pekerjaan, spesifikasi_pekerjaan', 'length', 'max' => 2000),
            array('nomor_kppuas, nomorizin_tahunjamak, kode_rup', 'length', 'max' => 50),
            array('swakelola_penyelenggara, swakelola_satker', 'length', 'max' => 200),
            array('is_hutang, isdikecualikan, ispaket, total_harga, total_pajak, spesifikasi_pekerjaan, isprodukdalamnegeri, isusahakecil, ispradpa, pemanfaatanbarang_tglawal, pemanfaatanbarang_tglakhir, pelaksanaankontrak_tglawal, pelaksanaankontrak_tglakhir, pemilihanpenyedia_tglawal, pemilihanpenyedia_tglakhir, update_time', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('rencanaumumpengadaan_id, unitkerja_id, instalasi_id, pegawaipembuat_id, rencanaumumpengadaan_nomor, rencanaumumpengadaan_tanggal, rencanaumumpengadaan_kategori, periodeanggaran_id, rencanaumumpengadaan_tahun, subprogram_id, nama_pekerjaan, volume_pekerjaan, uraian_pekerjaan, spesifikasi_pekerjaan, isprodukdalamnegeri, isusahakecil, ispradpa, nomor_kppuas, nomorizin_tahunjamak, metodepengadaan_id, metode_pengadaan, pemanfaatanbarang_tglawal, pemanfaatanbarang_tglakhir, pelaksanaankontrak_tglawal, pelaksanaankontrak_tglakhir, pemilihanpenyedia_tglawal, pemilihanpenyedia_tglakhir, swakelola_tipe, swakelola_penyelenggara, swakelola_satker, total_pagu, kode_rup, rencanaumumpengadaan_status, pegawaippk_id, pegawaipa_id, pegawaikpa_id, usulanpengadaan_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'pengadaandokumenpendukungTs' => array(self::HAS_MANY, 'PengadaandokumenpendukungT', 'rencanaumumpengadaan_id'),
            'pengadaanjenisTs' => array(self::HAS_MANY, 'PengadaanjenisT', 'rencanaumumpengadaan_id'),
            'pengadaanlokasiTs' => array(self::HAS_MANY, 'PengadaanlokasiT', 'rencanaumumpengadaan_id'),
            'pengadaansumberdanaTs' => array(self::HAS_MANY, 'PengadaansumberdanaT', 'rencanaumumpengadaan_id'),
            'rencanaumumpengadaandetTs' => array(self::HAS_MANY, 'RencanaumumpengadaandetT', 'rencanaumumpengadaan_id'),
            'unitkerja' => array(self::BELONGS_TO, 'UnitkerjaM', 'unitkerja_id'),
            'metodepengadaan' => array(self::BELONGS_TO, 'MetodepengadaanM', 'metodepengadaan_id'),
            'pegawaipembuat' => array(self::BELONGS_TO, 'PegawaiM', 'pegawaipembuat_id'),
            'instalasi' => array(self::BELONGS_TO, 'InstalasiM', 'instalasi_id'),
            'pegawaikpa' => array(self::BELONGS_TO, 'PegawaiM', 'pegawaikpa_id'),
            'pegawaipa' => array(self::BELONGS_TO, 'PegawaiM', 'pegawaipa_id'),
            'pegawaippk' => array(self::BELONGS_TO, 'PegawaiM', 'pegawaippk_id'),
            'subprogram' => array(self::BELONGS_TO, 'SubprogramkerjaM', 'subprogram_id'),
            'periodeanggaran' => array(self::BELONGS_TO, 'PeriodeanggaranK', 'periodeanggaran_id'),
            'persiapanpengadaanTs' => array(self::HAS_MANY, 'PersiapanpengadaanT', 'rencanaumumpengadaan_id'),
            'subkegiatanprogram' => array(self::BELONGS_TO, 'SubkegiatanprogramM', 'subkegiatanprogram_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'rencanaumumpengadaan_id' => 'Rencanaumumpengadaan',
            'unitkerja_id' => 'Unit Kerja',
            'instalasi_id' => 'Bidang/ Bagian/ Instalasi',
            'pegawaipembuat_id' => 'Pejabat Pembuat',
            'rencanaumumpengadaan_nomor' => 'Nomor Transaksi',
            'rencanaumumpengadaan_tanggal' => 'Tanggal Pembuatan RUP',
            'rencanaumumpengadaan_kategori' => 'Kategori Pengadaan',
            'periodeanggaran_id' => 'Periode Anggaran',
            'rencanaumumpengadaan_tahun' => 'Tahun Anggaran',
            'subprogram_id' => 'Kegiatan',
            'nama_pekerjaan' => 'Nama Paket Pekerjaan',
            'volume_pekerjaan' => 'Volume',
            'uraian_pekerjaan' => 'Uraian',
            'spesifikasi_pekerjaan' => 'Spesifikasi',
            'isprodukdalamnegeri' => 'Produk Dalam Negeri',
            'isusahakecil' => 'Usaha Kecil',
            'ispradpa' => 'Pra DIPA/DPA',
            'is_hutang' => 'Pengadaan Hutang',
            'nomor_kppuas' => 'Nomor KUA-PPAS',
            'nomorizin_tahunjamak' => 'Izin Tahun Jamak',
            'metodepengadaan_id' => 'Rencana Metode Pengadaan',
            'metode_pengadaan' => 'Rencana Metode Pengadaan',
            'pemanfaatanbarang_tglawal' => 'Pemanfaatanbarang Tglawal',
            'pemanfaatanbarang_tglakhir' => 'Pemanfaatanbarang Tglakhir',
            'pelaksanaankontrak_tglawal' => 'Pelaksanaankontrak Tglawal',
            'pelaksanaankontrak_tglakhir' => 'Pelaksanaankontrak Tglakhir',
            'pemilihanpenyedia_tglawal' => 'Pemilihanpenyedia Tglawal',
            'pemilihanpenyedia_tglakhir' => 'Pemilihanpenyedia Tglakhir',
            'swakelola_tipe' => 'Tipe Swakelola',
            'swakelola_penyelenggara' => 'Penyelenggara Swakelola',
            'swakelola_satker' => 'Swakelola Satker',
            'total_pagu' => 'Total Pagu',
            'kode_rup' => 'Nomor SIRUP',
            'rencanaumumpengadaan_status' => 'Rencanaumumpengadaan Status',
            'pegawaippk_id' => 'PPK',
            'pegawaipa_id' => 'PA',
            'pegawaikpa_id' => 'KPA',
            'usulanpengadaan_id' => 'Usulanpengadaan',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'create_loginpemakai_id' => 'Create Loginpemakai',
            'update_loginpemakai_id' => 'Update Loginpemakai',
            'create_ruangan' => 'Create Ruangan',
            'dpa_pagu'=>'Pagu pada DPA'
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CdbCriteria that can return criterias.
     */
    public function criteriaSearch() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        if (!empty($this->rencanaumumpengadaan_id)) {
            $criteria->addCondition('rencanaumumpengadaan_id = ' . $this->rencanaumumpengadaan_id);
        }
        if (!empty($this->unitkerja_id)) {
            $criteria->addCondition('unitkerja_id = ' . $this->unitkerja_id);
        }
        if (!empty($this->instalasi_id)) {
            $criteria->addCondition('instalasi_id = ' . $this->instalasi_id);
        }
        if (!empty($this->pegawaipembuat_id)) {
            $criteria->addCondition('pegawaipembuat_id = ' . $this->pegawaipembuat_id);
        }
        $criteria->compare('LOWER(rencanaumumpengadaan_nomor)', strtolower($this->rencanaumumpengadaan_nomor), true);
        $criteria->compare('LOWER(rencanaumumpengadaan_tanggal)', strtolower($this->rencanaumumpengadaan_tanggal), true);
        $criteria->compare('LOWER(rencanaumumpengadaan_kategori)', strtolower($this->rencanaumumpengadaan_kategori), true);
        if (!empty($this->periodeanggaran_id)) {
            $criteria->addCondition('periodeanggaran_id = ' . $this->periodeanggaran_id);
        }
        $criteria->compare('LOWER(rencanaumumpengadaan_tahun)', strtolower($this->rencanaumumpengadaan_tahun), true);
        if (!empty($this->subprogram_id)) {
            $criteria->addCondition('subprogram_id = ' . $this->subprogram_id);
        }
        $criteria->compare('LOWER(nama_pekerjaan)', strtolower($this->nama_pekerjaan), true);
        $criteria->compare('LOWER(volume_pekerjaan)', strtolower($this->volume_pekerjaan), true);
        $criteria->compare('LOWER(uraian_pekerjaan)', strtolower($this->uraian_pekerjaan), true);
        $criteria->compare('LOWER(spesifikasi_pekerjaan)', strtolower($this->spesifikasi_pekerjaan), true);
        $criteria->compare('isprodukdalamnegeri', $this->isprodukdalamnegeri);
        $criteria->compare('isusahakecil', $this->isusahakecil);
        $criteria->compare('ispradpa', $this->ispradpa);
        $criteria->compare('LOWER(nomor_kppuas)', strtolower($this->nomor_kppuas), true);
        $criteria->compare('LOWER(nomorizin_tahunjamak)', strtolower($this->nomorizin_tahunjamak), true);
        if (!empty($this->metodepengadaan_id)) {
            $criteria->addCondition('metodepengadaan_id = ' . $this->metodepengadaan_id);
        }
        $criteria->compare('LOWER(metode_pengadaan)', strtolower($this->metode_pengadaan), true);
        $criteria->compare('LOWER(pemanfaatanbarang_tglawal)', strtolower($this->pemanfaatanbarang_tglawal), true);
        $criteria->compare('LOWER(pemanfaatanbarang_tglakhir)', strtolower($this->pemanfaatanbarang_tglakhir), true);
        $criteria->compare('LOWER(pelaksanaankontrak_tglawal)', strtolower($this->pelaksanaankontrak_tglawal), true);
        $criteria->compare('LOWER(pelaksanaankontrak_tglakhir)', strtolower($this->pelaksanaankontrak_tglakhir), true);
        $criteria->compare('LOWER(pemilihanpenyedia_tglawal)', strtolower($this->pemilihanpenyedia_tglawal), true);
        $criteria->compare('LOWER(pemilihanpenyedia_tglakhir)', strtolower($this->pemilihanpenyedia_tglakhir), true);
        $criteria->compare('LOWER(swakelola_tipe)', strtolower($this->swakelola_tipe), true);
        $criteria->compare('LOWER(swakelola_penyelenggara)', strtolower($this->swakelola_penyelenggara), true);
        $criteria->compare('LOWER(swakelola_satker)', strtolower($this->swakelola_satker), true);
        $criteria->compare('total_pagu', $this->total_pagu);
        $criteria->compare('LOWER(kode_rup)', strtolower($this->kode_rup), true);
        $criteria->compare('LOWER(rencanaumumpengadaan_status)', strtolower($this->rencanaumumpengadaan_status), true);
        if (!empty($this->pegawaippk_id)) {
            $criteria->addCondition('pegawaippk_id = ' . $this->pegawaippk_id);
        }
        if (!empty($this->pegawaipa_id)) {
            $criteria->addCondition('pegawaipa_id = ' . $this->pegawaipa_id);
        }
        if (!empty($this->pegawaikpa_id)) {
            $criteria->addCondition('pegawaikpa_id = ' . $this->pegawaikpa_id);
        }
        if (!empty($this->usulanpengadaan_id)) {
            $criteria->addCondition('usulanpengadaan_id = ' . $this->usulanpengadaan_id);
        }
        $criteria->compare('LOWER(create_time)', strtolower($this->create_time), true);
        $criteria->compare('LOWER(update_time)', strtolower($this->update_time), true);
        if (!empty($this->create_loginpemakai_id)) {
            $criteria->addCondition('create_loginpemakai_id = ' . $this->create_loginpemakai_id);
        }
        if (!empty($this->update_loginpemakai_id)) {
            $criteria->addCondition('update_loginpemakai_id = ' . $this->update_loginpemakai_id);
        }
        if (!empty($this->create_ruangan)) {
            $criteria->addCondition('create_ruangan = ' . $this->create_ruangan);
        }

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

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function searchPrint() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = $this->criteriaSearch();
        $criteria->limit = -1;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false,
        ));
    }
    
    /**
     * Validasi konversi tanggal/kolom type date,timestamp ketika simpan, agar format menyesuaikan format DataBase
     * @return /beforeValidate function
     */
    protected function beforeValidate ()
    {
        $format = new MyFormatter();
        foreach($this->metadata->tableSchema->columns as $columnName => $column)
        {
            if($column->dbType == 'date')
            {
                $this->$columnName = $format->formatDateTimeForDb($this->$columnName);
            }elseif ($column->dbType == 'timestamp without time zone'){
                $this->$columnName = $format->formatDateTimeForDb($this->$columnName);
            }
        }
        return parent::beforeValidate();
    }
    
    

}
