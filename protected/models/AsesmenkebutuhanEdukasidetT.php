<?php

/**
 * This is the model class for table "asesmenkebutuhan_edukasidet_t".
 *
 * The followings are the available columns in table 'asesmenkebutuhan_edukasidet_t':
 * @property integer $asesmenkebutuhan_edukasidet_id
 * @property integer $asesmenkebutuhan_edukasi_id
 * @property string $edukasipasien
 * @property string $edukasipasien_lainnya
 *
 * The followings are the available model relations:
 * @property AsesmenkebutuhanEdukasiT $asesmenkebutuhanEdukasi
 */
class AsesmenkebutuhanEdukasidetT extends CActiveRecord {

    public $isedukasipasien;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return AsesmenkebutuhanEdukasidetT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'asesmenkebutuhan_edukasidet_t';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('asesmenkebutuhan_edukasi_id', 'required'),
            array('asesmenkebutuhan_edukasi_id', 'numerical', 'integerOnly' => true),
            array('edukasipasien, edukasipasien_lainnya', 'length', 'max' => 200),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('asesmenkebutuhan_edukasidet_id, asesmenkebutuhan_edukasi_id, edukasipasien, edukasipasien_lainnya', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'asesmenkebutuhanEdukasi' => array(self::BELONGS_TO, 'AsesmenkebutuhanEdukasiT', 'asesmenkebutuhan_edukasi_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'asesmenkebutuhan_edukasidet_id' => 'Asesmenkebutuhan Edukasidet',
            'asesmenkebutuhan_edukasi_id' => 'Asesmenkebutuhan Edukasi',
            'edukasipasien' => 'Edukasipasien',
            'edukasipasien_lainnya' => 'Edukasipasien Lainnya',
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

        $criteria->compare('asesmenkebutuhan_edukasidet_id', $this->asesmenkebutuhan_edukasidet_id);
        $criteria->compare('asesmenkebutuhan_edukasi_id', $this->asesmenkebutuhan_edukasi_id);
        $criteria->compare('edukasipasien', $this->edukasipasien, true);
        $criteria->compare('edukasipasien_lainnya', $this->edukasipasien_lainnya, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
