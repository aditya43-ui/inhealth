<?php

/**
 * This is the model class for table "evaluasipenawaran_t".
 *
 * @author  Andyka Putra <andykaputra@.com>
 * @package application.models
 * 
 * The followings are the available columns in table 'evaluasipenawaran_t':
 * @property integer $evaluasipenawaran_id
 * @property integer $supplier_id
 * @property integer $persiapanpengadaan_id
 * @property integer $pejabatpengadaan_id
 * @property string $evaluasipenawaran_nomor
 * @property string $evaluasipenawaran_tanggal
 * @property string $nomor_dokumen
 * @property string $personalia_rapat
 * @property string $sk_nomor
 * @property string $sk_tanggal
 * @property string $dokumen_pendukung
 * @property boolean $evaluasi_administrasi
 * @property boolean $evaluasi_teknis
 * @property boolean $evaluasi_harga
 * @property boolean $evaluasi_kualifikasi
 * @property double $harga_penawaran
 * @property double $harga_terkoreksi
 * @property string $keterangan
 * @property boolean $isbatal
 * @property boolean $isaddendum
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property PegawaiM $pejabatpengadaan
 * @property PersiapanpengadaanT $persiapanpengadaan
 * @property SupplierM $supplier
 * @property EvaluasipenawarandetT[] $evaluasipenawarandetTs
 */
class EvaluasipenawaranT extends CActiveRecord {

    public $supplier_nama, $alamat_supplier, $pejabat_pengadaan, $pejabat_pengadaan_nip, $jabatan_pengadaan, $isi_surat;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return EvaluasipenawaranT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'evaluasipenawaran_t';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('nomor_dokumen,evaluasipenawaran_nomor, evaluasipenawaran_tanggal, create_time, create_loginpemakai_id, create_ruangan', 'required'),
            array('supplier_id, persiapanpengadaan_id, pejabatpengadaan_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly' => true),
            array('harga_penawaran, harga_terkoreksi', 'numerical'),
            array('evaluasipenawaran_nomor, nomor_dokumen, sk_nomor', 'length', 'max' => 50),
            array('personalia_rapat', 'length', 'max' => 225),
            array('dokumen_pendukung', 'length', 'max' => 255),
            array('sk_tanggal, evaluasi_administrasi, evaluasi_teknis, evaluasi_harga, evaluasi_kualifikasi, keterangan, isbatal, isaddendum, update_time', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('evaluasipenawaran_id, supplier_id, persiapanpengadaan_id, pejabatpengadaan_id, evaluasipenawaran_nomor, evaluasipenawaran_tanggal, nomor_dokumen, personalia_rapat, sk_nomor, sk_tanggal, dokumen_pendukung, evaluasi_administrasi, evaluasi_teknis, evaluasi_harga, evaluasi_kualifikasi, harga_penawaran, harga_terkoreksi, keterangan, isbatal, isaddendum, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'pejabatpengadaan' => array(self::BELONGS_TO, 'PegawaiM', 'pejabatpengadaan_id'),
            'persiapanpengadaan' => array(self::BELONGS_TO, 'PersiapanpengadaanT', 'persiapanpengadaan_id'),
            'supplier' => array(self::BELONGS_TO, 'SupplierM', 'supplier_id'),
            'evaluasipenawarandetTs' => array(self::HAS_MANY, 'EvaluasipenawarandetT', 'evaluasipenawaran_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'evaluasipenawaran_id' => 'Evaluasipenawaran',
            'supplier_id' => 'Supplier',
            'persiapanpengadaan_id' => 'Persiapanpengadaan',
            'pejabatpengadaan_id' => 'Pejabatpengadaan',
            'evaluasipenawaran_nomor' => 'Nomor Transaksi',
            'evaluasipenawaran_tanggal' => 'Tanggal Surat',
            'nomor_dokumen' => 'Nomor Surat',
            'personalia_rapat' => 'Personalia dan Organisasi Rapat',
            'sk_nomor' => 'Nomor SK',
            'sk_tanggal' => 'Tanggal SK',
            'dokumen_pendukung' => 'Dokumen Pendukung',
            'evaluasi_administrasi' => 'Evaluasi Administrasi',
            'evaluasi_teknis' => 'Evaluasi Teknis',
            'evaluasi_harga' => 'Evaluasi Harga',
            'evaluasi_kualifikasi' => 'Evaluasi Kualifikasi',
            'harga_penawaran' => 'Harga Penawaran',
            'harga_terkoreksi' => 'Harga Penawaran Terkoreksi',
            'keterangan' => 'Keterangan',
            'isbatal' => 'Isbatal',
            'isaddendum' => 'Isaddendum',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'create_loginpemakai_id' => 'Create Loginpemakai',
            'update_loginpemakai_id' => 'Update Loginpemakai',
            'create_ruangan' => 'Create Ruangan',
            'konfigtemplatesurat_id' => 'Template Surat',
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

        $criteria->compare('evaluasipenawaran_id', $this->evaluasipenawaran_id);
        $criteria->compare('supplier_id', $this->supplier_id);
        $criteria->compare('persiapanpengadaan_id', $this->persiapanpengadaan_id);
        $criteria->compare('pejabatpengadaan_id', $this->pejabatpengadaan_id);
        $criteria->compare('evaluasipenawaran_nomor', $this->evaluasipenawaran_nomor, true);
        $criteria->compare('evaluasipenawaran_tanggal', $this->evaluasipenawaran_tanggal, true);
        $criteria->compare('nomor_dokumen', $this->nomor_dokumen, true);
        $criteria->compare('personalia_rapat', $this->personalia_rapat, true);
        $criteria->compare('sk_nomor', $this->sk_nomor, true);
        $criteria->compare('sk_tanggal', $this->sk_tanggal, true);
        $criteria->compare('dokumen_pendukung', $this->dokumen_pendukung, true);
        $criteria->compare('evaluasi_administrasi', $this->evaluasi_administrasi);
        $criteria->compare('evaluasi_teknis', $this->evaluasi_teknis);
        $criteria->compare('evaluasi_harga', $this->evaluasi_harga);
        $criteria->compare('evaluasi_kualifikasi', $this->evaluasi_kualifikasi);
        $criteria->compare('harga_penawaran', $this->harga_penawaran);
        $criteria->compare('harga_terkoreksi', $this->harga_terkoreksi);
        $criteria->compare('keterangan', $this->keterangan, true);
        $criteria->compare('isbatal', $this->isbatal);
        $criteria->compare('isaddendum', $this->isaddendum);
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
