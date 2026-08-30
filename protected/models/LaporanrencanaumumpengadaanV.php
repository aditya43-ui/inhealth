<?php

/**
 * This is the model class for table "laporanrencanaumumpengadaan_v".
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @package application.models
 * @category model
 * The followings are the available columns in table 'laporanrencanaumumpengadaan_v':
 * @property string $kode_kegiatan
 * @property string $subkegiatanprogram_nama
 * @property integer $unitkerja_id
 * @property string $namaunitkerja
 * @property integer $pegawaippk_id
 * @property string $nama_ppk
 * @property integer $pegawaikpa_id
 * @property string $nama_kpa
 * @property string $rencanaumumpengadaan_kategori
 * @property string $jumlah_paket
 * @property double $total_paket
 * @property string $rencanaumumpengadaan_status
 */
class LaporanrencanaumumpengadaanV extends CActiveRecord {

    public $tgl_awal, $tgl_akhir;
    public $jns_periode, $bln_awal, $bln_akhir, $thn_awal, $thn_akhir;
    public $tick;
    public $data;
    public $jumlah;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return LaporanrencanaumumpengadaanV the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'laporanrencanaumumpengadaan_v';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('unitkerja_id, pegawaippk_id, pegawaikpa_id', 'numerical', 'integerOnly' => true),
            array('total_paket', 'numerical'),
            array('subkegiatanprogram_nama', 'length', 'max' => 500),
            array('namaunitkerja', 'length', 'max' => 200),
            array('nama_ppk, nama_kpa', 'length', 'max' => 50),
            array('rencanaumumpengadaan_kategori', 'length', 'max' => 20),
            array('rencanaumumpengadaan_status', 'length', 'max' => 100),
            array('periodeanggaran_id, kode_kegiatan, jumlah_paket', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('kode_kegiatan, subkegiatanprogram_nama, unitkerja_id, namaunitkerja, pegawaippk_id, nama_ppk, pegawaikpa_id, nama_kpa, rencanaumumpengadaan_kategori, jumlah_paket, total_paket, rencanaumumpengadaan_status', 'safe', 'on' => 'search'),
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
            'kode_kegiatan' => 'Kode Kegiatan',
            'subkegiatanprogram_nama' => 'Subkegiatanprogram Nama',
            'unitkerja_id' => 'Unitkerja',
            'namaunitkerja' => 'Namaunitkerja',
            'pegawaippk_id' => 'Pegawaippk',
            'nama_ppk' => 'Nama Ppk',
            'pegawaikpa_id' => 'Pegawaikpa',
            'nama_kpa' => 'Nama Kpa',
            'rencanaumumpengadaan_kategori' => 'Rencanaumumpengadaan Kategori',
            'jumlah_paket' => 'Jumlah Paket',
            'total_paket' => 'Total Paket',
            'rencanaumumpengadaan_status' => 'Rencanaumumpengadaan Status',
        );
    }

    /**
     * Load data yang dicari
     * @return \CDbCriteria
     */
    public function criteriaSearch() {
        $criteria = new CDbCriteria;

        $criteria->compare('lower(kode_kegiatan)', strtolower($this->kode_kegiatan), true);
        $criteria->compare('lower(subkegiatanprogram_nama)', strtolower($this->subkegiatanprogram_nama), true);
        if (!empty($this->periodeanggaran_id)) {
            $criteria->compare('periodeanggaran_id', $this->periodeanggaran_id);
        }
        if (!empty($this->unitkerja_id)) {
            $criteria->compare('unitkerja_id', $this->unitkerja_id);
        }
        $criteria->compare('lower(namaunitkerja)', strtolower($this->namaunitkerja), true);
        if (!empty($this->pegawaippk_id)) {
            $criteria->compare('pegawaippk_id', $this->pegawaippk_id);
        }
        $criteria->compare('lower(nama_ppk)', strtolower($this->nama_ppk), true);
        if (!empty($this->pegawaikpa_id)) {
            $criteria->compare('pegawaikpa_id', $this->pegawaikpa_id);
        }
        $criteria->compare('lower(nama_kpa)', strtolower($this->nama_kpa), true);
        $criteria->compare('rencanaumumpengadaan_kategori', $this->rencanaumumpengadaan_kategori, true);
        $criteria->compare('jumlah_paket', $this->jumlah_paket, true);
        $criteria->compare('total_paket', $this->total_paket);
        $criteria->compare('rencanaumumpengadaan_status', $this->rencanaumumpengadaan_status, true);
        $criteria->order = "namaunitkerja asc, kode_kegiatan asc, nama_kpa asc, nama_ppk asc";
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

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Load Halaman Laporan 
     * @return \CActiveDataProvider
     */
    public function searchLaporan() {
        $criteria = $this->criteriaSearch();

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Cetak Laporan 
     * @return \CActiveDataProvider
     */
    public function searchLaporanPrint() {
        $criteria = $this->criteriaSearch();

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false
        ));
    }

    /**
     * Set data dropdown periode anggaran
     * @return array $data option untuk dropdown
     */
    public function getPeriodeAnggaran() {
        $data = array();
        $criteria = new CDbCriteria();
        $criteria->order = "tahunanggaran DESC";
        $models = PeriodeanggaranK::model()->findAll($criteria);
        if (count($models) > 0) {
            foreach ($models as $model)
                $data[$model->periodeanggaran_id] = ($model->tahunanggaran . " - " . $model->anggaran_nama);
        }

        return $data;
    }

}
