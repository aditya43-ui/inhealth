<?php

/**
 * This is the model class for table "bapengadaanlangsung_t".
 *
 * @author  Andyka Putra <andykaputra@.com>
 * @package application.models
 * 
 * The followings are the available columns in table 'bapengadaanlangsung_t':
 * @property integer $bapengadaanlangsung_id
 * @property integer $persiapanpengadaan_id
 * @property string $bapengadaanlangsung_tanggal
 * @property string $bapengadaanlangsung_nomor
 * @property string $nomor_beritaacara
 * @property string $nama_pekerjaan
 * @property integer $supplier_id
 * @property string $direktur_supplier
 * @property string $waktu_pertemuan
 * @property string $lokasi_pertemuan
 * @property integer $pegpengadaan_id
 * @property string $jabatan_pengadaan
 * @property string $nomor_sk
 * @property string $tanggal_sk
 * @property integer $kehadiran_pejabat
 * @property integer $kehadiran_penyedia
 * @property integer $konfigtemplatesurat_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class BapengadaanlangsungT extends CActiveRecord {

    public $supplier_nama, $alamat_supplier, $nama_direktur, $pejabat_pengadaan, $pejabat_pengadaan_nip, $isi_surat;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return BapengadaanlangsungT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'bapengadaanlangsung_t';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('persiapanpengadaan_id, bapengadaanlangsung_tanggal, bapengadaanlangsung_nomor, supplier_id, direktur_supplier, konfigtemplatesurat_id, create_time, create_loginpemakai_id, create_ruangan, nomor_beritaacara', 'required'),
            array('persiapanpengadaan_id, supplier_id, pegpengadaan_id, kehadiran_pejabat, kehadiran_penyedia, konfigtemplatesurat_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly' => true),
            array('bapengadaanlangsung_nomor, nomor_beritaacara, direktur_supplier', 'length', 'max' => 50),
            array('nama_pekerjaan', 'length', 'max' => 500),
            array('lokasi_pertemuan', 'length', 'max' => 200),
            array('jabatan_pengadaan, nomor_sk', 'length', 'max' => 100),
            array('pejabat_pengadaan, jabatan_pengadaan, waktu_pertemuan, tanggal_sk, update_time', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('bapengadaanlangsung_id, persiapanpengadaan_id, bapengadaanlangsung_tanggal, bapengadaanlangsung_nomor, nomor_beritaacara, nama_pekerjaan, supplier_id, direktur_supplier, waktu_pertemuan, lokasi_pertemuan, pegpengadaan_id, jabatan_pengadaan, nomor_sk, tanggal_sk, kehadiran_pejabat, kehadiran_penyedia, konfigtemplatesurat_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on' => 'search'),
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
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'bapengadaanlangsung_id' => 'Bapengadaanlangsung',
            'persiapanpengadaan_id' => 'Persiapanpengadaan',
            'bapengadaanlangsung_tanggal' => 'Tanggal BA',
            'bapengadaanlangsung_nomor' => 'Nomor Transaksi',
            'nomor_beritaacara' => 'Nomor BA',
            'nama_pekerjaan' => 'Nama Pekerjaan',
            'supplier_id' => 'Supplier',
            'direktur_supplier' => 'Direktur Supplier',
            'waktu_pertemuan' => 'Waktu Pertemuan',
            'lokasi_pertemuan' => 'Lokasi Pertemuan',
            'pegpengadaan_id' => 'Pegpengadaan',
            'jabatan_pengadaan' => 'Jabatan Pengadaan',
            'nomor_sk' => 'Nomor SK',
            'tanggal_sk' => 'Tanggal SK',
            'kehadiran_pejabat' => 'Pejabat Pengadaan',
            'kehadiran_penyedia' => 'Wakil Peserta',
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

        $criteria->compare('bapengadaanlangsung_id', $this->bapengadaanlangsung_id);
        $criteria->compare('persiapanpengadaan_id', $this->persiapanpengadaan_id);
        $criteria->compare('bapengadaanlangsung_tanggal', $this->bapengadaanlangsung_tanggal, true);
        $criteria->compare('bapengadaanlangsung_nomor', $this->bapengadaanlangsung_nomor, true);
        $criteria->compare('nomor_beritaacara', $this->nomor_beritaacara, true);
        $criteria->compare('nama_pekerjaan', $this->nama_pekerjaan, true);
        $criteria->compare('supplier_id', $this->supplier_id);
        $criteria->compare('direktur_supplier', $this->direktur_supplier, true);
        $criteria->compare('waktu_pertemuan', $this->waktu_pertemuan, true);
        $criteria->compare('lokasi_pertemuan', $this->lokasi_pertemuan, true);
        $criteria->compare('pegpengadaan_id', $this->pegpengadaan_id);
        $criteria->compare('jabatan_pengadaan', $this->jabatan_pengadaan, true);
        $criteria->compare('nomor_sk', $this->nomor_sk, true);
        $criteria->compare('tanggal_sk', $this->tanggal_sk, true);
        $criteria->compare('kehadiran_pejabat', $this->kehadiran_pejabat);
        $criteria->compare('kehadiran_penyedia', $this->kehadiran_penyedia);
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
