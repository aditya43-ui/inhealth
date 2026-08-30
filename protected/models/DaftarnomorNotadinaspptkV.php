<?php

/**
 * This is the model class for table "daftarnomor_notadinaspptk_v".
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @package application.modules.pengadaan
 * @subpackage models
 * @category model
 * The followings are the available columns in table 'daftarnomor_notadinaspptk_v':
 * @property integer $nomor_id
 * @property string $kategori_pengadaan
 * @property string $nomor_dokumen
 * @property string $tanggal_dokumen
 * @property integer $periodeanggaran_id
 * @property string $tahun
 * @property integer $unitkerja_id
 * @property string $namaunitkerja
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 * @property integer $subkegiatanprogram_id
 * @property string $programkerja_kode
 * @property string $programkerja_nama
 * @property string $subprogramkerja_kode
 * @property string $subprogramkerja_nama
 * @property string $subkegiatanprogram_kode
 * @property string $subkegiatanprogram_nama
 * @property string $kode_rekening
 * @property string $paket_pekerjaan
 * @property double $nilai_pekerjaan
 * @property integer $pegawaippk_id
 * @property string $nama_ppk
 * @property string $nomor_kontrak
 * @property integer $supplier_id
 * @property string $supplier_nama
 * @property string $supplier_alamat
 * @property boolean $istermin
 */
class DaftarnomorNotadinaspptkV extends CActiveRecord {

    public $kegiatanprogram_nama, $perintahpengiriman;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return DaftarnomorNotadinaspptkV the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'daftarnomor_notadinaspptk_v';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('nomor_id, periodeanggaran_id, unitkerja_id, instalasi_id, subkegiatanprogram_id, pegawaippk_id, supplier_id', 'numerical', 'integerOnly' => true),
            array('nilai_pekerjaan', 'numerical'),
            array('tahun', 'length', 'max' => 4),
            array('namaunitkerja', 'length', 'max' => 200),
            array('instalasi_nama, nama_ppk', 'length', 'max' => 50),
            array('programkerja_kode, subprogramkerja_kode, subkegiatanprogram_kode', 'length', 'max' => 5),
            array('programkerja_nama, subprogramkerja_nama, subkegiatanprogram_nama', 'length', 'max' => 500),
            array('kategori_pengadaan, nomor_dokumen, tanggal_dokumen, kode_rekening, paket_pekerjaan, nomor_kontrak, supplier_nama, supplier_alamat, istermin', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('nomor_id, kategori_pengadaan, nomor_dokumen, tanggal_dokumen, periodeanggaran_id, tahun, unitkerja_id, namaunitkerja, instalasi_id, instalasi_nama, subkegiatanprogram_id, programkerja_kode, programkerja_nama, subprogramkerja_kode, subprogramkerja_nama, subkegiatanprogram_kode, subkegiatanprogram_nama, kode_rekening, paket_pekerjaan, nilai_pekerjaan, pegawaippk_id, nama_ppk, nomor_kontrak, supplier_id, supplier_nama, supplier_alamat, istermin', 'safe', 'on' => 'search'),
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
            'nomor_id' => 'Nomor',
            'kategori_pengadaan' => 'Kategori Pengadaan',
            'nomor_dokumen' => 'Nomor Dokumen',
            'tanggal_dokumen' => 'Tanggal Dokumen',
            'periodeanggaran_id' => 'Periodeanggaran',
            'tahun' => 'Tahun',
            'unitkerja_id' => 'Unitkerja',
            'namaunitkerja' => 'Namaunitkerja',
            'instalasi_id' => 'Instalasi',
            'instalasi_nama' => 'Instalasi Nama',
            'subkegiatanprogram_id' => 'Subkegiatanprogram',
            'programkerja_kode' => 'Programkerja Kode',
            'programkerja_nama' => 'Programkerja Nama',
            'subprogramkerja_kode' => 'Subprogramkerja Kode',
            'subprogramkerja_nama' => 'Subprogramkerja Nama',
            'subkegiatanprogram_kode' => 'Subkegiatanprogram Kode',
            'subkegiatanprogram_nama' => 'Subkegiatanprogram Nama',
            'kode_rekening' => 'Kode Rekening',
            'paket_pekerjaan' => 'Paket Pekerjaan',
            'nilai_pekerjaan' => 'Nilai Pekerjaan',
            'pegawaippk_id' => 'Pegawaippk',
            'nama_ppk' => 'Nama Ppk',
            'nomor_kontrak' => 'Nomor Kontrak',
            'supplier_id' => 'Supplier',
            'supplier_nama' => 'Supplier Nama',
            'supplier_alamat' => 'Supplier Alamat',
            'istermin' => 'Istermin',
        );
    }

    /**
     * Load data yang dicari 
     * @return \CDbCriteria
     */
    public function criteriaSearch() {
        $criteria = new CDbCriteria;
        $criteria->compare('nomor_id', $this->nomor_id);
        $criteria->compare('kategori_pengadaan', $this->kategori_pengadaan, true);
        $criteria->compare('lower(nomor_dokumen)', strtolower($this->nomor_dokumen), true);
        if (!empty($this->periodeanggaran_id)) {
            $criteria->compare('periodeanggaran_id', $this->periodeanggaran_id);
        }
        $criteria->compare('tahun', $this->tahun, true);
        if (!empty($this->unitkerja_id)) {
            $criteria->compare('unitkerja_id', $this->unitkerja_id);
        }
        $criteria->compare('lower(namaunitkerja)', strtolower($this->namaunitkerja), true);
        if (!empty($this->instalasi_id)) {
            $criteria->compare('instalasi_id', $this->instalasi_id);
        }
        $criteria->compare('lower(instalasi_nama)', strtolower($this->instalasi_nama), true);

        if (!empty($this->subkegiatanprogram_id)) {
            $criteria->compare('subkegiatanprogram_id', $this->subkegiatanprogram_id);
        }

        $criteria->compare('lower(programkerja_kode)', strtolower($this->programkerja_kode), true);
        $criteria->compare('lower(programkerja_nama)', strtolower($this->programkerja_nama), true);
        $criteria->compare('lower(subprogramkerja_kode)', strtolower($this->subprogramkerja_kode), true);
        $criteria->compare('lower(subprogramkerja_nama)', strtolower($this->subprogramkerja_nama), true);
        $criteria->compare('lower(subkegiatanprogram_kode)', strtolower($this->subkegiatanprogram_kode), true);
        $criteria->compare('lower(subkegiatanprogram_nama)', strtolower($this->subkegiatanprogram_nama), true);
        $criteria->compare('lower(kode_rekening)', strtolower($this->kode_rekening), true);
        $criteria->compare('lower(paket_pekerjaan)', strtolower($this->paket_pekerjaan), true);
        $criteria->compare('lower(nomor_kontrak)', strtolower($this->nomor_kontrak), true);
        $criteria->compare('nilai_pekerjaan', $this->nilai_pekerjaan);
        $criteria->compare('pegawaippk_id', $this->pegawaippk_id);
        $criteria->compare('nama_ppk', $this->nama_ppk, true);
        $criteria->compare('nomor_kontrak', $this->nomor_kontrak, true);
        $criteria->compare('supplier_id', $this->supplier_id);
        $criteria->compare('supplier_nama', $this->supplier_nama, true);
        $criteria->compare('supplier_alamat', $this->supplier_alamat, true);
        $criteria->compare('istermin', $this->istermin);
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
     * Load dialog untuk transaksi nota dinas PPTK 
     * @return \CActiveDataProvider
     */
    public function searchDialog() {
        $criteria = $this->criteriaSearch();
        
        if (!empty($this->kategori_pengadaan)) {
            $criteria->addCondition("kategori_pengadaan = '" . $this->kategori_pengadaan . "'");
        } 
        
        if (!empty($this->tanggal_dokumen)) {
            $criteria->addCondition("DATE(tanggal_dokumen) = '" . MyFormatter::formatDateTimeForDb($this->tanggal_dokumen) . "'");
        }
        
        $criteria->addCondition('load_data is true');
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
