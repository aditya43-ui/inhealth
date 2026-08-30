<?php

/**
 * This is the model class for table "tujuan_m".
 *
 * The followings are the available columns in table 'tujuan_m':
 * @property integer $tujuan_id
 * @property integer $diagnosakep_id
 * @property string $tujuan_nama
 * @property boolean $tujuan_aktif
 *
 * The followings are the available model relations:
 * @property RencanaaskepdetT[] $rencanaaskepdetTs
 * @property DiagnosakepM $diagnosakep
 */
class TujuanM extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return TujuanM the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'tujuan_m';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('luarankeperawatan_id, tujuan_nama', 'required'),
            array('diagnosakep_id', 'numerical', 'integerOnly' => true),
            array('tujuan_nama', 'length', 'max' => 100),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('tujuan_id, diagnosakep_id, tujuan_nama, tujuan_aktif', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'rencanaaskepdetTs' => array(self::HAS_MANY, 'RencanaaskepdetT', 'tujuan_id'),
            'diagnosakep' => array(self::BELONGS_TO, 'DiagnosakepM', 'diagnosakep_id'),
            'luarankeperawatan' => array(self::BELONGS_TO, 'LuarankeperawatanM', 'luarankeperawatan_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'tujuan_id' => 'Tujuan',
            'diagnosakep_id' => 'Diagnosakep',
            'tujuan_nama' => 'Tujuan Nama',
            'tujuan_aktif' => 'Tujuan Aktif',
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

        $criteria->compare('tujuan_id', $this->tujuan_id);
        $criteria->compare('diagnosakep_id', $this->diagnosakep_id);
        $criteria->compare('tujuan_nama', $this->tujuan_nama, true);
        $criteria->compare('tujuan_aktif', $this->tujuan_aktif);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
