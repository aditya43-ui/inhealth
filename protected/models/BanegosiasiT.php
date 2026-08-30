<?php

/**
 * This is the model class for table "banegosiasi_t".
 *
 * @author  Andyka Putra <andykaputra@.com>
 * @package application.models
 * 
 * The followings are the available columns in table 'banegosiasi_t':
 * @property integer $banegosiasi_id
 * @property integer $penawaranpenyedia_id
 * @property integer $persiapanpengadaan_id
 * @property string $banegosiasi_tanggal
 * @property string $banegosiasi_nomor
 * @property string $nama_pekerjaan
 * @property string $nomor_beritaacara
 * @property integer $supplier_id
 * @property string $direktur_supplier
 * @property integer $pegpengadaan_id
 * @property string $jabatan_pengadaan
 * @property string $nomor_sk
 * @property string $tanggal_sk
 * @property double $jumlah_penawaran
 * @property double $pajak_penawaran
 * @property double $total_penawaran
 * @property double $pembulatan_penawaran
 * @property double $jumlah_negosiasi
 * @property double $pajak_negosiasi
 * @property double $total_negosiasi
 * @property double $pembulatan_negosiasi
 * @property double $selisih_harga
 * @property integer $konfigtemplatesurat_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class BanegosiasiT extends CActiveRecord {

    public $supplier_nama, $nama_direktur, $alamat_supplier, $penawaranpenyedia_nomor, $pejabat_pengadaan, $pejabat_pengadaan_nip, $harga_setelah_negosiasi, $isi_surat;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return BanegosiasiT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'banegosiasi_t';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('penawaranpenyedia_id, persiapanpengadaan_id, banegosiasi_nomor, nomor_beritaacara, create_time, create_loginpemakai_id, create_ruangan', 'required'),
            array('penawaranpenyedia_id, persiapanpengadaan_id, supplier_id, pegpengadaan_id, konfigtemplatesurat_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly' => true),
            array('jumlah_penawaran, pajak_penawaran, total_penawaran, pembulatan_penawaran, jumlah_negosiasi, pajak_negosiasi, total_negosiasi, pembulatan_negosiasi, selisih_harga', 'numerical'),
            array('banegosiasi_nomor, nomor_beritaacara', 'length', 'max' => 50),
            array('nama_pekerjaan', 'length', 'max' => 500),
            array('direktur_supplier, jabatan_pengadaan, nomor_sk', 'length', 'max' => 100),
            array('tanggal_sk, update_time', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('banegosiasi_id, penawaranpenyedia_id, persiapanpengadaan_id, banegosiasi_tanggal, banegosiasi_nomor, nama_pekerjaan, nomor_beritaacara, supplier_id, direktur_supplier, pegpengadaan_id, jabatan_pengadaan, nomor_sk, tanggal_sk, jumlah_penawaran, pajak_penawaran, total_penawaran, pembulatan_penawaran, jumlah_negosiasi, pajak_negosiasi, total_negosiasi, pembulatan_negosiasi, selisih_harga, konfigtemplatesurat_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'supplier' => array(self::BELONGS_TO, 'SupplierM', 'supplier_id'),
            'pegpengadaan' => array(self::BELONGS_TO, 'PegawaiM', 'pegpengadaan_id'),
            'penawaranpenyedia' => array(self::BELONGS_TO, 'PenawaranpenyediaT', 'penawaranpenyedia_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'banegosiasi_id' => 'BA Negosiasi',
            'penawaranpenyedia_id' => 'Penawaran Penyedia',
            'persiapanpengadaan_id' => 'Persiapan Pengadaan',
            'banegosiasi_tanggal' => 'Tanggal Surat',
            'banegosiasi_nomor' => 'Nomor Transaksi',
            'nama_pekerjaan' => 'Nama Pekerjaan',
            'nomor_beritaacara' => 'Nomor Surat',
            'supplier_id' => 'Supplier',
            'direktur_supplier' => 'Direktur Supplier',
            'pegpengadaan_id' => 'Pegpengadaan',
            'jabatan_pengadaan' => 'Jabatan Pengadaan',
            'nomor_sk' => 'Nomor SK',
            'tanggal_sk' => 'Tanggal SK',
            'jumlah_penawaran' => 'Jumlah Penawaran',
            'pajak_penawaran' => 'Pajak Penawaran',
            'total_penawaran' => 'Total Penawaran',
            'pembulatan_penawaran' => 'Pembulatan Penawaran',
            'jumlah_negosiasi' => 'Jumlah Negosiasi',
            'pajak_negosiasi' => 'Pajak Negosiasi',
            'total_negosiasi' => 'Harga Setelah Negosiasi',
            'pembulatan_negosiasi' => 'Pembulatan Negosiasi',
            'selisih_harga' => 'Selisih Harga',
            'konfigtemplatesurat_id' => 'Template Surat',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'create_loginpemakai_id' => 'Create Loginpemakai',
            'update_loginpemakai_id' => 'Update Loginpemakai',
            'create_ruangan' => 'Create Ruangan',
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

        $criteria->compare('banegosiasi_id', $this->banegosiasi_id);
        $criteria->compare('penawaranpenyedia_id', $this->penawaranpenyedia_id);
        $criteria->compare('persiapanpengadaan_id', $this->persiapanpengadaan_id);
        $criteria->compare('banegosiasi_tanggal', $this->banegosiasi_tanggal, true);
        $criteria->compare('banegosiasi_nomor', $this->banegosiasi_nomor, true);
        $criteria->compare('nama_pekerjaan', $this->nama_pekerjaan, true);
        $criteria->compare('nomor_beritaacara', $this->nomor_beritaacara, true);
        $criteria->compare('supplier_id', $this->supplier_id);
        $criteria->compare('direktur_supplier', $this->direktur_supplier, true);
        $criteria->compare('pegpengadaan_id', $this->pegpengadaan_id);
        $criteria->compare('jabatan_pengadaan', $this->jabatan_pengadaan, true);
        $criteria->compare('nomor_sk', $this->nomor_sk, true);
        $criteria->compare('tanggal_sk', $this->tanggal_sk, true);
        $criteria->compare('jumlah_penawaran', $this->jumlah_penawaran);
        $criteria->compare('pajak_penawaran', $this->pajak_penawaran);
        $criteria->compare('total_penawaran', $this->total_penawaran);
        $criteria->compare('pembulatan_penawaran', $this->pembulatan_penawaran);
        $criteria->compare('jumlah_negosiasi', $this->jumlah_negosiasi);
        $criteria->compare('pajak_negosiasi', $this->pajak_negosiasi);
        $criteria->compare('total_negosiasi', $this->total_negosiasi);
        $criteria->compare('pembulatan_negosiasi', $this->pembulatan_negosiasi);
        $criteria->compare('selisih_harga', $this->selisih_harga);
        $criteria->compare('konfigtemplatesurat_id', $this->konfigtemplatesurat_id);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('update_time', $this->update_time, true);
        $criteria->compare('create_loginpemakai_id', $this->create_loginpemakai_id);
        $criteria->compare('update_loginpemakai_id', $this->update_loginpemakai_id);
        $criteria->compare('create_ruangan', $this->create_ruangan);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
