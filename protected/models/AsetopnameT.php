<?php

/**
 * This is the model class for table "asetopname_t".
 *
 * The followings are the available columns in table 'asetopname_t':
 * @property integer $asetopname_id
 * @property integer $periodeasetopname_id
 * @property string $asetopname_tanggal
 * @property integer $invperalatan_id
 * @property integer $pegawai_id
 * @property integer $lokasi_id
 * @property integer $lokasiawal_id
 * @property string $kondisi_awal
 * @property string $kondisi
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property PeriodeasetopnameK $periodeasetopname
 * @property PegawaiM $pegawai
 * @property LokasiasetM $lokasiawal
 * @property LokasiasetM $lokasi
 * @property InvperalatanT $invperalatan
 */
class AsetopnameT extends CActiveRecord {

    public $pegawai_nama;
    public $invperalatan_namabrg;
    public $invperalatan_kode, $kode_internal;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return AsetopnameT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'asetopname_t';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('invperalatan_id, pegawai_id, lokasi_id, lokasiawal_id, kondisi_awal, kondisi, create_time, create_loginpemakai_id, create_ruangan', 'required'),
            array('periodeasetopname_id, invperalatan_id, pegawai_id, lokasi_id, lokasiawal_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly' => true),
            array('kondisi_awal, kondisi', 'length', 'max' => 50),
            array('lokasiopname_id, asetopname_tanggal, update_time', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('asetopname_id, periodeasetopname_id, asetopname_tanggal, invperalatan_id, pegawai_id, lokasi_id, lokasiawal_id, kondisi_awal, kondisi, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'periodeasetopname' => array(self::BELONGS_TO, 'PeriodeasetopnameK', 'periodeasetopname_id'),
            'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
            'lokasiawal' => array(self::BELONGS_TO, 'LokasiasetM', 'lokasiawal_id'),
            'lokasi' => array(self::BELONGS_TO, 'LokasiasetM', 'lokasi_id'),
            'lokasiopname' => array(self::BELONGS_TO, 'LokasiasetM', 'lokasiopname_id'),
            'invperalatan' => array(self::BELONGS_TO, 'InvperalatanT', 'invperalatan_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'asetopname_id' => 'Asetopname',
            'periodeasetopname_id' => 'Periode Opname',
            'asetopname_tanggal' => 'Tanggal',
            'invperalatan_id' => 'Nomor Aset',
            'pegawai_id' => 'Pegawai',
            'lokasi_id' => 'Perlengkapan dan Aset',
            'lokasiawal_id' => 'Lokasiawal',
            'kondisi_awal' => 'Kondisi Awal',
            'kondisi' => 'Kondisi',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'create_loginpemakai_id' => 'Create Loginpemakai',
            'update_loginpemakai_id' => 'Update Loginpemakai',
            'create_ruangan' => 'Create Ruangan',
            'pegawai_nama' => 'Pegawai'
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

        $criteria->compare('asetopname_id', $this->asetopname_id);
        $criteria->compare('periodeasetopname_id', $this->periodeasetopname_id);
        $criteria->compare('asetopname_tanggal', $this->asetopname_tanggal, true);
        $criteria->compare('invperalatan_id', $this->invperalatan_id);
        $criteria->compare('pegawai_id', $this->pegawai_id);
        $criteria->compare('lokasi_id', $this->lokasi_id);
        $criteria->compare('lokasiawal_id', $this->lokasiawal_id);
        $criteria->compare('kondisi_awal', $this->kondisi_awal, true);
        $criteria->compare('kondisi', $this->kondisi, true);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('update_time', $this->update_time, true);
        $criteria->compare('create_loginpemakai_id', $this->create_loginpemakai_id);
        $criteria->compare('update_loginpemakai_id', $this->update_loginpemakai_id);
        $criteria->compare('create_ruangan', $this->create_ruangan);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * 
     * @param type $model
     * @param type $post
     * @return type
     */
    public static function simpan_data($model, $post) {
        $ok = true;
        $format = new MyFormatter();

        $model->attributes = $post;
        $model->asetopname_tanggal = !empty($model->asetopname_tanggal) ? $format->formatDateTimeForDb($model->asetopname_tanggal) : null;

        if (empty($model->pencucianbj_id)) {
            $model->create_time = date('Y-m-d H:i:s');
            $model->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
            $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
        } else {
            $model->update_time = date('Y-m-d H:i:s');
            $model->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
        }

        $ok &= $model->save();

        $data['sukses'] = $ok;
        $data['model'] = $model;

        return $data;
    }

}
