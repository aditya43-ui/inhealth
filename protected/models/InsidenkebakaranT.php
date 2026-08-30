<?php

/**
 * This is the model class for table "insidenkebakaran_t".
 * @author  Yusuf Putra Anugrah <yusufputra@.com>
 * @package application.models
 * The followings are the available columns in table 'insidenkebakaran_t':
 * @property integer $insidenkebakaran_id
 * @property string $tgl_pelaporan
 * @property string $no_dokumen
 * @property string $no_revisi
 * @property integer $mengetahuipegawai_id
 * @property integer $pelapor_id
 * @property string $nomorindukpegawai
 * @property string $saksi1
 * @property string $saksi2
 * @property string $saksi3
 * @property string $tgl_kejadian
 * @property integer $unitkeja_kejadian_id
 * @property string $lokasikejadian
 * @property string $kronologis_kebakaran
 * @property string $penyebab_kebakaran
 * @property string $kerugianakibatkebakaran
 * @property string $tindakanperbaikan
 * @property string $tglverifikasi_pelaporan
 * @property boolean $is_revisi
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property RevisiInsidenkebakaranR[] $revisiInsidenkebakaranRs
 */
class InsidenkebakaranT extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return InsidenkebakaranT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'insidenkebakaran_t';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('lokasikejadian,nomorindukpegawai,no_revisi,no_dokumen,tgl_pelaporan, mengetahuipegawai_id, pelapor_id, tgl_kejadian, create_time, create_loginpemakai_id, create_ruangan', 'required'),
            array('mengetahuipegawai_id, pelapor_id, unitkeja_kejadian_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly' => true),
            array('no_dokumen', 'length', 'max' => 25),
            array('no_revisi', 'length', 'max' => 10),
            array('nomorindukpegawai', 'length', 'max' => 30),
            array('saksi1, saksi2, saksi3', 'length', 'max' => 100),
            array('lokasikejadian', 'length', 'max' => 150),
            array('kronologis_kebakaran, penyebab_kebakaran, kerugianakibatkebakaran, tindakanperbaikan, tglverifikasi_pelaporan, is_revisi, update_time', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('insidenkebakaran_id, tgl_pelaporan, no_dokumen, no_revisi, mengetahuipegawai_id, pelapor_id, nomorindukpegawai, saksi1, saksi2, saksi3, tgl_kejadian, unitkeja_kejadian_id, lokasikejadian, kronologis_kebakaran, penyebab_kebakaran, kerugianakibatkebakaran, tindakanperbaikan, tglverifikasi_pelaporan, is_revisi, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'revisiInsidenkebakaranRs' => array(self::HAS_MANY, 'RevisiInsidenkebakaranR', 'insidenkebakaran_id'),
            'pegawai_pelapor' => array(self::BELONGS_TO, 'PegawaiM', 'pelapor_id'),
            'pegawai_mengetahui' => array(self::BELONGS_TO, 'PegawaiM', 'mengetahuipegawai_id'),
            'unitkerja' => array(self::BELONGS_TO, 'UnitkerjaM', 'unitkeja_kejadian_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'insidenkebakaran_id' => 'Insidenkebakaran',
            'tgl_pelaporan' => 'Tgl Pelaporan',
            'no_dokumen' => 'Nomor Pelaporan',
            'no_revisi' => 'Nomor Revisi',
            'mengetahuipegawai_id' => 'Mengetahui',
            'pelapor_id' => 'Nama Pelapor',
            'nomorindukpegawai' => 'NIP',
            'saksi1' => 'Saksi 1',
            'saksi2' => 'Saksi 2',
            'saksi3' => 'Saksi 3',
            'tgl_kejadian' => 'Tanggal Kejadian',
            'unitkeja_kejadian_id' => 'Unit kerja Kejadian',
            'lokasikejadian' => 'Lokasi kejadian',
            'kronologis_kebakaran' => 'Kronologis Kebakaran',
            'penyebab_kebakaran' => 'Penyebab Kebakaran',
            'kerugianakibatkebakaran' => 'Kerugian/Akibat dari Kebakaran',
            'tindakanperbaikan' => 'Tindakan Perbaikan',
            'tglverifikasi_pelaporan' => 'Tglverifikasi Pelaporan',
            'is_revisi' => 'Is Revisi',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'create_loginpemakai_id' => 'Create Loginpemakai',
            'update_loginpemakai_id' => 'Update Loginpemakai',
            'create_ruangan' => 'Create Ruangan',
        );
    }

    /**
     * Load cari
     * @return \CDbCriteria
     */
    public function criteriaSearch() {
        $criteria = new CDbCriteria;
        $criteria->compare('insidenkebakaran_id', $this->insidenkebakaran_id);
        $criteria->compare('tgl_pelaporan', $this->tgl_pelaporan, true);
        $criteria->compare('lower(no_dokumen)', strtolower($this->no_dokumen), true);
        $criteria->compare('lower(no_revisi)', strtolower($this->no_revisi), true);
        $criteria->compare('mengetahuipegawai_id', $this->mengetahuipegawai_id);
        $criteria->compare('pelapor_id', $this->pelapor_id);
        $criteria->compare('lower(nomorindukpegawai)', strtolower($this->nomorindukpegawai), true);
        $criteria->compare('lower(saksi1)', strtolower($this->saksi1), true);
        $criteria->compare('lower(saksi2)', strtolower($this->saksi2), true);
        $criteria->compare('lower(saksi3)', strtolower($this->saksi3), true);
        $criteria->compare('tgl_kejadian', $this->tgl_kejadian, true);
        $criteria->compare('unitkeja_kejadian_id', $this->unitkeja_kejadian_id);
        $criteria->compare('lower(lokasikejadian)', strtolower($this->lokasikejadian), true);
        $criteria->compare('lower(kronologis_kebakaran)', strtolower($this->kronologis_kebakaran), true);
        $criteria->compare('lower(penyebab_kebakaran)', strtolower($this->penyebab_kebakaran), true);
        $criteria->compare('kerugianakibatkebakaran', $this->kerugianakibatkebakaran, true);
        $criteria->compare('tindakanperbaikan', $this->tindakanperbaikan, true);
        $criteria->compare('tglverifikasi_pelaporan', $this->tglverifikasi_pelaporan, true);
        $criteria->compare('is_revisi', $this->is_revisi);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('update_time', $this->update_time, true);
        $criteria->compare('create_loginpemakai_id', $this->create_loginpemakai_id);
        $criteria->compare('update_loginpemakai_id', $this->update_loginpemakai_id);
        $criteria->compare('create_ruangan', $this->create_ruangan);

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
}