<?php

/**
 * This is the model class for table "asesmentnyerianakdet_t".
 *
 * The followings are the available columns in table 'asesmentnyerianakdet_t':
 * @property integer $asesmentnyerianakdet_id
 * @property integer $asesmentnyeri_id
 * @property integer $kat_skalanyeri_id
 * @property integer $skalanyeriflaccs_param
 * @property integer $skalanyeriflaccs_nilai
 * @property string $tgl_asesmentnyerianakdet
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan_id
 * @property integer $update_ruangan_id
 */
class AsesmentnyerianakdetT extends CActiveRecord
{
    public $ispilih;
    public $skalanyeriflaccs_id;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return AsesmentnyerianakdetT the static model class
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
        return 'asesmentnyerianakdet_t';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('asesmentnyeri_id, create_loginpemakai_id, create_ruangan_id', 'required'),
            array('asesmentnyeri_id, kat_skalanyeri_id, skalanyeriflaccs_param, skalanyeriflaccs_nilai, create_loginpemakai_id, update_loginpemakai_id, create_ruangan_id, update_ruangan_id', 'numerical', 'integerOnly' => true),
            array('tgl_asesmentnyerianakdet, create_time, update_time', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('asesmentnyerianakdet_id, asesmentnyeri_id, kat_skalanyeri_id, skalanyeriflaccs_param, skalanyeriflaccs_nilai, tgl_asesmentnyerianakdet, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan_id, update_ruangan_id', 'safe', 'on' => 'search'),
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
            'asesmentnyerianakdet_id' => 'Asesmentnyerianakdet',
            'asesmentnyeri_id' => 'Asesmentnyeri',
            'kat_skalanyeri_id' => 'Kat Skalanyeri',
            'skalanyeriflaccs_param' => 'Skalanyeriflaccs Param',
            'skalanyeriflaccs_nilai' => 'Skalanyeriflaccs Nilai',
            'tgl_asesmentnyerianakdet' => 'Tgl. Asesment Nyeri Anak',
            'create_time' => 'Waktu Create',
            'update_time' => 'Waktu Update',
            'create_loginpemakai_id' => 'Create Login Pemakai',
            'update_loginpemakai_id' => 'Update Login Pemakai',
            'create_ruangan_id' => 'Create Ruangan',
            'update_ruangan_id' => 'Update Ruangan',
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

        $criteria->compare('asesmentnyerianakdet_id', $this->asesmentnyerianakdet_id);
        $criteria->compare('asesmentnyeri_id', $this->asesmentnyeri_id);
        $criteria->compare('kat_skalanyeri_id', $this->kat_skalanyeri_id);
        $criteria->compare('skalanyeriflaccs_param', $this->skalanyeriflaccs_param);
        $criteria->compare('skalanyeriflaccs_nilai', $this->skalanyeriflaccs_nilai);
        $criteria->compare('tgl_asesmentnyerianakdet', $this->tgl_asesmentnyerianakdet, true);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('update_time', $this->update_time, true);
        $criteria->compare('create_loginpemakai_id', $this->create_loginpemakai_id);
        $criteria->compare('update_loginpemakai_id', $this->update_loginpemakai_id);
        $criteria->compare('create_ruangan_id', $this->create_ruangan_id);
        $criteria->compare('update_ruangan_id', $this->update_ruangan_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
}
