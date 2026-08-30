<?php

/**
 * This is the model class for table "luarankeperawatan_m".
 *
 * @author  Andyka Putra <andykaputra@.com>
 * @package application.models
 * 
 * The followings are the available columns in table 'luarankeperawatan_m':
 * @property integer $luarankeperawatan_id
 * @property string $luarankeperawatan_kode
 * @property string $luarankeperawatan_nama
 * @property string $luarankeperawatan_deskripsi
 * @property boolean $luarankeperawatan_aktif
 *
 * The followings are the available model relations:
 * @property TautansdkiSlkiDetM[] $tautansdkiSlkiDetMs
 */
class LuarankeperawatanM extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return LuarankeperawatanM the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'luarankeperawatan_m';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('luarankeperawatan_nama, luarankeperawatan_kode', 'required'),
            array('luarankeperawatan_kode', 'length', 'max' => 10),
            array('luarankeperawatan_nama', 'length', 'max' => 100),
            array('luarankeperawatan_deskripsi, luarankeperawatan_aktif', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('luarankeperawatan_id, luarankeperawatan_kode, luarankeperawatan_nama, luarankeperawatan_deskripsi, luarankeperawatan_aktif', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'tautansdkiSlkiDetMs' => array(self::HAS_MANY, 'TautansdkiSlkiDetM', 'luarankeperawatan_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'luarankeperawatan_id' => 'Luarankeperawatan',
            'luarankeperawatan_kode' => 'Kode Luaran Keperawatan',
            'luarankeperawatan_nama' => 'Nama Luaran Keperawatan',
            'luarankeperawatan_deskripsi' => 'Deskripsi',
            'luarankeperawatan_aktif' => '',
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

        $criteria->compare('luarankeperawatan_id', $this->luarankeperawatan_id);
        $criteria->compare('LOWER(luarankeperawatan_kode)', strtolower($this->luarankeperawatan_kode), true);
        $criteria->compare('LOWER(luarankeperawatan_nama)', strtolower($this->luarankeperawatan_nama), true);
        $criteria->compare('LOWER(luarankeperawatan_deskripsi)', strtolower($this->luarankeperawatan_deskripsi), true);
        $criteria->compare('luarankeperawatan_aktif', isset($this->luarankeperawatan_aktif) ? $this->luarankeperawatan_aktif : true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
