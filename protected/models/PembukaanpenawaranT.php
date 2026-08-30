<?php

/**
 * This is the model class for table "pembukaanpenawaran_t".
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @package application.models
 * @category model
 *
 * The followings are the available columns in table 'pembukaanpenawaran_t':
 * @property integer $pembukaanpenawaran_id
 * @property integer $supplier_id
 * @property integer $persiapanpengadaan_id
 * @property integer $pejabatpengadaan_id
 * @property string $pembukaanpenawaran_nomor
 * @property string $pembukaanpenawaran_tanggal
 * @property string $nomor_dokumen
 * @property string $personalia_rapat
 * @property string $sk_nomor
 * @property string $sk_tanggal
 * @property string $dokumen_pendukung
 * @property boolean $penawaran_administrasi
 * @property boolean $penawaran_teknis
 * @property boolean $penawaran_harga
 * @property boolean $kualifikasi_pakta
 * @property boolean $kualifikasi_form
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
 */
class PembukaanpenawaranT extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PembukaanpenawaranT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'pembukaanpenawaran_t';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('nomor_dokumen, konfigtemplatesurat_id, pembukaanpenawaran_nomor, pembukaanpenawaran_tanggal, create_time, create_loginpemakai_id, create_ruangan', 'required'),
            array('supplier_id, persiapanpengadaan_id, pejabatpengadaan_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly' => true),
            array('pembukaanpenawaran_nomor, nomor_dokumen, sk_nomor', 'length', 'max' => 50),
            array('personalia_rapat', 'length', 'max' => 225),
            array('dokumen_pendukung', 'length', 'max' => 255),
            array('sk_tanggal, penawaran_administrasi, penawaran_teknis, penawaran_harga, kualifikasi_pakta, kualifikasi_form, isbatal, isaddendum, update_time', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('pembukaanpenawaran_id, supplier_id, persiapanpengadaan_id, pejabatpengadaan_id, pembukaanpenawaran_nomor, pembukaanpenawaran_tanggal, nomor_dokumen, personalia_rapat, sk_nomor, sk_tanggal, dokumen_pendukung, penawaran_administrasi, penawaran_teknis, penawaran_harga, kualifikasi_pakta, kualifikasi_form, isbatal, isaddendum, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on' => 'search'),
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
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'pembukaanpenawaran_id' => 'Pembukaanpenawaran',
            'supplier_id' => 'Supplier',
            'persiapanpengadaan_id' => 'Persiapanpengadaan',
            'pejabatpengadaan_id' => 'Pejabatpengadaan',
            'pembukaanpenawaran_nomor' => 'Nomor Transaksi',
            'pembukaanpenawaran_tanggal' => 'Pembukaanpenawaran Tanggal',
            'nomor_dokumen' => 'Nomor Surat',
            'personalia_rapat' => 'Personalia Rapat',
            'sk_nomor' => 'Sk Nomor',
            'sk_tanggal' => 'Sk Tanggal',
            'dokumen_pendukung' => 'Dokumen Pendukung',
            'penawaran_administrasi' => 'Penawaran Administrasi',
            'penawaran_teknis' => 'Penawaran Teknis',
            'penawaran_harga' => 'Penawaran Harga',
            'kualifikasi_pakta' => 'Kualifikasi Pakta',
            'kualifikasi_form' => 'Kualifikasi Form',
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

        $criteria->compare('pembukaanpenawaran_id', $this->pembukaanpenawaran_id);
        $criteria->compare('supplier_id', $this->supplier_id);
        $criteria->compare('persiapanpengadaan_id', $this->persiapanpengadaan_id);
        $criteria->compare('pejabatpengadaan_id', $this->pejabatpengadaan_id);
        $criteria->compare('pembukaanpenawaran_nomor', $this->pembukaanpenawaran_nomor, true);
        $criteria->compare('pembukaanpenawaran_tanggal', $this->pembukaanpenawaran_tanggal, true);
        $criteria->compare('nomor_dokumen', $this->nomor_dokumen, true);
        $criteria->compare('personalia_rapat', $this->personalia_rapat, true);
        $criteria->compare('sk_nomor', $this->sk_nomor, true);
        $criteria->compare('sk_tanggal', $this->sk_tanggal, true);
        $criteria->compare('dokumen_pendukung', $this->dokumen_pendukung, true);
        $criteria->compare('penawaran_administrasi', $this->penawaran_administrasi);
        $criteria->compare('penawaran_teknis', $this->penawaran_teknis);
        $criteria->compare('penawaran_harga', $this->penawaran_harga);
        $criteria->compare('kualifikasi_pakta', $this->kualifikasi_pakta);
        $criteria->compare('kualifikasi_form', $this->kualifikasi_form);
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
