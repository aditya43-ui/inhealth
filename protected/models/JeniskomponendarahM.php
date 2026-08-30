<?php

/**
 * This is the model class for table "jeniskomponendarah_m".
 *
 * @author Tantowi J <tantowijaya@.com>
 * The followings are the available columns in table 'jeniskomponendarah_m':
 * @property integer $jeniskomponendarah_id
 * @property string $jeniskomponenedarah_nama
 * @property string $jeniskantongdarah_singkatan
 * @property boolean $jeniskantongdarah_aktif
 *
 * The followings are the available model relations:
 * @property PermintaandarahpmidetT[] $permintaandarahpmidetTs
 * 
 * @package application.models
 */
class JeniskomponendarahM extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return JeniskomponendarahM the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'jeniskomponendarah_m';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('jeniskomponenedarah_nama, jeniskantongdarah_singkatan', 'required'),
            array('jeniskomponenedarah_nama', 'length', 'max' => 100),
            array('jeniskantongdarah_singkatan', 'length', 'max' => 10),
            array('jeniskantongdarah_aktif', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('jeniskomponendarah_id, jeniskomponenedarah_nama, jeniskantongdarah_singkatan, jeniskantongdarah_aktif', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'permintaandarahpmidetTs' => array(self::HAS_MANY, 'PermintaandarahpmidetT', 'jeniskomponendarah_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'jeniskomponendarah_id' => 'Jeniskomponendarah',
            'jeniskomponenedarah_nama' => 'Jeniskomponenedarah Nama',
            'jeniskantongdarah_singkatan' => 'Jeniskantongdarah Singkatan',
            'jeniskantongdarah_aktif' => 'Jeniskantongdarah Aktif',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CdbCriteria that can return criterias.
     */
    public function criteriaSearch() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        if (!empty($this->jeniskomponendarah_id)) {
            $criteria->addCondition('jeniskomponendarah_id = ' . $this->jeniskomponendarah_id);
        }
        $criteria->compare('LOWER(jeniskomponenedarah_nama)', strtolower($this->jeniskomponenedarah_nama), true);
        $criteria->compare('LOWER(jeniskantongdarah_singkatan)', strtolower($this->jeniskantongdarah_singkatan), true);
        $criteria->compare('jeniskantongdarah_aktif', $this->jeniskantongdarah_aktif);

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
        $criteria->limit = 10;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function searchPrint() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = $this->criteriaSearch();
        $criteria->limit = -1;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false,
        ));
    }
    public static function getItems(){
		$criteria = new CDbCriteria();
		$criteria->addCondition("jeniskantongdarah_aktif = TRUE");
		$criteria->order = " jeniskomponenedarah_nama";
		return self::model()->findAll($criteria);
	}

}
