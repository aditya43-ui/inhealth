<?php

/**
 * This is the model class for table "riwayatpengadaan_r".
 * The followings are the available columns in table 'riwayatpengadaan_r':
 * 
 * @package     application.models 
 * @category    model 
 * @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @author      Elham Budianto <elhambudianto@.com>
 * @version     2.0.0
 * @link      <http://piindonesia.co.id>
 * @link      <http://172.9.1.15/simpp/docs/>
 * 
 * @property integer $riwayatpengadaan_id
 * @property integer $pegawai_id
 * @property string $nama_pegawai
 * @property string $tanggal_update
 * @property string $status_berkas
 * @property string $riwayatpengadaan_catatan
 * @property string $riwayatpengadaan_lampiran
 * @property string $jabatan_pengadaan
 * @property integer $rencanaumumpengadaan_id
 * @property integer $persiapanpengadaan_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property PegawaiM $pegawai
 */
class RiwayatpengadaanR extends CActiveRecord {
    
    public $lampiran, $temp_file, $statusnya;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return RiwayatpengadaanR the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'riwayatpengadaan_r';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('nama_pegawai, tanggal_update, create_time, create_loginpemakai_id, create_ruangan', 'required'),
            array('pegawai_id, rencanaumumpengadaan_id, persiapanpengadaan_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly' => true),
            array('nama_pegawai, status_berkas, jabatan_pengadaan', 'length', 'max' => 100),
            array('riwayatpengadaan_catatan', 'length', 'max' => 250),
            array('riwayatpengadaan_lampiran', 'length', 'max' => 255),
            array('update_time', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('riwayatpengadaan_id, pegawai_id, nama_pegawai, tanggal_update, status_berkas, riwayatpengadaan_catatan, riwayatpengadaan_lampiran, jabatan_pengadaan, rencanaumumpengadaan_id, persiapanpengadaan_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'riwayatpengadaan_id' => 'Riwayatpengadaan',
            'pegawai_id' => 'Pegawai',
            'nama_pegawai' => 'Nama Pegawai',
            'tanggal_update' => 'Tanggal Update',
            'status_berkas' => 'Status Berkas',
            'riwayatpengadaan_catatan' => 'Catatan',
            'riwayatpengadaan_lampiran' => 'Lampiran',
            'jabatan_pengadaan' => 'Jabatan',
            'rencanaumumpengadaan_id' => 'Rencanaumumpengadaan',
            'persiapanpengadaan_id' => 'Persiapanpengadaan',
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

        $criteria->compare('riwayatpengadaan_id', $this->riwayatpengadaan_id);
        $criteria->compare('pegawai_id', $this->pegawai_id);
        $criteria->compare('nama_pegawai', $this->nama_pegawai, true);
        $criteria->compare('tanggal_update', $this->tanggal_update, true);
        $criteria->compare('status_berkas', $this->status_berkas, true);
        $criteria->compare('riwayatpengadaan_catatan', $this->riwayatpengadaan_catatan, true);
        $criteria->compare('riwayatpengadaan_lampiran', $this->riwayatpengadaan_lampiran, true);
        $criteria->compare('jabatan_pengadaan', $this->jabatan_pengadaan, true);
        $criteria->compare('rencanaumumpengadaan_id', $this->rencanaumumpengadaan_id);
        $criteria->compare('persiapanpengadaan_id', $this->persiapanpengadaan_id);
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
