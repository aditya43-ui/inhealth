<?php

/**
 * This is the model class for table "surveykepuasanrs_t".
 *
 **
 * digunakan untuk menambah survey kepuasan ekios
 * 
 * @author          Yusuf Putra Anugrah <yusufputra@.com>
 * @version         2.0.0
 * @link            http://172.9.1.15/simpp/docs/
 * @issue           RSST-8671
 * @package application.models
 * The followings are the available columns in table 'surveykepuasanrs_t':
 * @property integer $surveykepuasanrs_id
 * @property string $tanggal_survey
 * @property integer $unitkerja_id
 * @property integer $ruangan_id
 * @property integer $jenisformsurvey_id
 * @property string $jenispelayanan
 * @property integer $tingkatkepuasan_id
 * @property string $kritikdansaran
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 *
 * The followings are the available model relations:
 * @property TingkatkepuasanM $tingkatkepuasan
 * @property JenisformsurveyM $jenisformsurvey
 */
class SurveykepuasanrsT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SurveykepuasanrsT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'surveykepuasanrs_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
        public $nilaiKepuasan;
        public $tingkatkepuasan_nama;
        public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tanggal_survey, jenisformsurvey_id, tingkatkepuasan_id, create_time, create_loginpemakai_id', 'required'),
			array('unitkerja_id, ruangan_id, jenisformsurvey_id, tingkatkepuasan_id, create_loginpemakai_id, update_loginpemakai_id', 'numerical', 'integerOnly'=>true),
			array('jenispelayanan', 'length', 'max'=>200),
			array('kritikdansaran, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('nilaiKepuasan, surveykepuasanrs_id, tanggal_survey, unitkerja_id, ruangan_id, jenisformsurvey_id, jenispelayanan, tingkatkepuasan_id, kritikdansaran, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'tingkatkepuasan' => array(self::BELONGS_TO, 'TingkatkepuasanM', 'tingkatkepuasan_id'),
			'jenisformsurvey' => array(self::BELONGS_TO, 'JenisformsurveyM', 'jenisformsurvey_id'),
                        'unitkerja' => array(self::BELONGS_TO, 'UnitkerjaM', 'unitkerja_id')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'surveykepuasanrs_id' => 'Surveykepuasanrs',
			'tanggal_survey' => 'Tanggal Survey',
			'unitkerja_id' => 'Unitkerja',
			'ruangan_id' => 'Ruangan',
			'jenisformsurvey_id' => 'Jenisformsurvey',
			'jenispelayanan' => 'Jenispelayanan',
			'tingkatkepuasan_id' => 'Tingkatkepuasan',
			'kritikdansaran' => 'Kritikdansaran',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
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
            $criteria->select = "t.*"
                    . ", u.namaunitkerja"
                    . ", p.tingkatkepuasan_nama";
            $criteria->join = "LEFT JOIN unitkerja_m u ON t.unitkerja_id = u.unitkerja_id "
                    . "LEFT JOIN tingkatkepuasan_m p ON p.tingkatkepuasan_id = t.tingkatkepuasan_id ";

            $criteria->compare('t.unitkerja_id',$this->unitkerja_id);
            $criteria->compare('LOWER(t.jenispelayanan)',strtolower($this->jenispelayanan),true);
            $criteria->compare('LOWER(p.tingkatkepuasan_nama)',strtolower($this->nilaiKepuasan),true);
            $criteria->addBetweenCondition('DATE(t.tanggal_survey)', $this->tanggal_awal, $this->tanggal_akhir);

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
	}
}