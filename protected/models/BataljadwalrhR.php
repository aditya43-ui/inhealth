<?php

/**
 * This is the model class for table "bataljadwalrh_r".
 *
 * The followings are the available columns in table 'bataljadwalrh_r':
 * @property integer $bataljadwalrh_id
 * @property integer $pasien_id
 * @property string $bataljadwalrh_tgl
 * @property string $bataljadwalrh_alasan
 * @property string $bataljadwalrh_desc
 * @property string $bjrh_create_time
 * @property string $bjrh_update_time
 * @property integer $bjrh_create_loginid
 * @property integer $bjrh_update_loginid
 * @property integer $bjrh_create_ruangan_id
 */
class BataljadwalrhR extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return BataljadwalrhR the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'bataljadwalrh_r';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('pasien_id, bataljadwalrh_tgl, bataljadwalrh_alasan, bjrh_create_time, bjrh_create_loginid, bjrh_create_ruangan_id', 'required'),
            array('pasien_id, bjrh_create_loginid, bjrh_update_loginid, bjrh_create_ruangan_id', 'numerical', 'integerOnly' => true),
            array('bataljadwalrh_alasan', 'length', 'max' => 200),
            array('bataljadwalrh_desc, bjrh_update_time', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('bataljadwalrh_id, pasien_id, bataljadwalrh_tgl, bataljadwalrh_alasan, bataljadwalrh_desc, bjrh_create_time, bjrh_update_time, bjrh_create_loginid, bjrh_update_loginid, bjrh_create_ruangan_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'bataljadwalrh_id' => 'Bataljadwalrh',
            'pasien_id' => 'Pasien',
            'bataljadwalrh_tgl' => 'Tgl. Batal',
            'bataljadwalrh_alasan' => 'Alasan',
            'bataljadwalrh_desc' => 'Deskripsi',
            'bjrh_create_time' => 'Bjrh Create Time',
            'bjrh_update_time' => 'Bjrh Update Time',
            'bjrh_create_loginid' => 'Bjrh Create Loginid',
            'bjrh_update_loginid' => 'Bjrh Update Loginid',
            'bjrh_create_ruangan_id' => 'Bjrh Create Ruangan',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('bataljadwalrh_id', $this->bataljadwalrh_id);
        $criteria->compare('pasien_id', $this->pasien_id);
        $criteria->compare('bataljadwalrh_tgl', $this->bataljadwalrh_tgl, true);
        $criteria->compare('bataljadwalrh_alasan', $this->bataljadwalrh_alasan, true);
        $criteria->compare('bataljadwalrh_desc', $this->bataljadwalrh_desc, true);
        $criteria->compare('bjrh_create_time', $this->bjrh_create_time, true);
        $criteria->compare('bjrh_update_time', $this->bjrh_update_time, true);
        $criteria->compare('bjrh_create_loginid', $this->bjrh_create_loginid);
        $criteria->compare('bjrh_update_loginid', $this->bjrh_update_loginid);
        $criteria->compare('bjrh_create_ruangan_id', $this->bjrh_create_ruangan_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
}
