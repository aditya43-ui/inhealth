<?php

/**
 * This is the model class for table "masalah_keperawatan_pre_hd_t".
 *
 * The followings are the available columns in table 'masalah_keperawatan_pre_hd_t':
 * @property integer $masalah_keperawatan_pre_hd_id
 * @property integer $monitoring_pre_hd_id
 * @property integer $pendaftaran_id
 * @property integer $pasien_id
 * @property string $nama_masalah_keperawatan
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $ruangan_id
 *
 * The followings are the available model relations:
 * @property MonitoringPreHdT $monitoringPreHd
 * @property PasienM $pasien
 * @property PendaftaranT $pendaftaran
 */
class MasalahKeperawatanPreHdT extends CActiveRecord {

    public $nama_masalah_keperawatan_lainnya, $is_ceklis;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return MasalahKeperawatanPreHdT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'masalah_keperawatan_pre_hd_t';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('monitoring_pre_hd_id, create_time, create_loginpemakai_id, ruangan_id', 'required'),
            array('masalah_keperawatan_pre_hd_id, monitoring_pre_hd_id, pendaftaran_id, pasien_id, create_loginpemakai_id, update_loginpemakai_id, ruangan_id', 'numerical', 'integerOnly' => true),
            array('nama_masalah_keperawatan', 'length', 'max' => 100),
            array('update_time', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('masalah_keperawatan_pre_hd_id, monitoring_pre_hd_id, pendaftaran_id, pasien_id, nama_masalah_keperawatan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, ruangan_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'monitoringPreHd' => array(self::BELONGS_TO, 'MonitoringPreHdT', 'monitoring_pre_hd_id'),
            'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
            'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'masalah_keperawatan_pre_hd_id' => 'Masalah Keperawatan Pre Hd',
            'monitoring_pre_hd_id' => 'Monitoring Pre Hd',
            'pendaftaran_id' => 'Pendaftaran',
            'pasien_id' => 'Pasien',
            'nama_masalah_keperawatan' => 'Nama Masalah Keperawatan',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'create_loginpemakai_id' => 'Creale Login',
            'update_loginpemakai_id' => 'Update Loginpemakai',
            'ruangan_id' => 'Ruangan',
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

        $criteria->compare('masalah_keperawatan_pre_hd_id', $this->masalah_keperawatan_pre_hd_id);
        $criteria->compare('monitoring_pre_hd_id', $this->monitoring_pre_hd_id);
        $criteria->compare('pendaftaran_id', $this->pendaftaran_id);
        $criteria->compare('pasien_id', $this->pasien_id);
        $criteria->compare('nama_masalah_keperawatan', $this->nama_masalah_keperawatan, true);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('update_time', $this->update_time, true);
        $criteria->compare('create_loginpemakai_id', $this->create_loginpemakai_id);
        $criteria->compare('update_loginpemakai_id', $this->update_loginpemakai_id);
        $criteria->compare('ruangan_id', $this->ruangan_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
