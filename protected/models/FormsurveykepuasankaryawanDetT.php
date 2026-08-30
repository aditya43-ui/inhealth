<?php

/**
 * This is the model class for table "formsurveykepuasankaryawan_det_t".
 *
 * The followings are the available columns in table 'formsurveykepuasankaryawan_det_t':
 * @property integer $formsurveykepuasankaryawan_det_id
 * @property integer $formsurveykepuasan_id
 * @property integer $pertanyaanquisioner_id
 * @property integer $tingkatkepuasan_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property PertanyaanquisionerM $pertanyaanquisioner
 * @property FormsurveykepuasanT $formsurveykepuasan
 * 
 * @author Wahyu Wicaksono <wahyuwicaksono.@gmail.com>
 * @category Improvment RSST-8538
 * 
 */
class FormsurveykepuasankaryawanDetT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return FormsurveykepuasankaryawanDetT the static model class
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
		return 'formsurveykepuasankaryawan_det_t';
	}
        
        public $bobot_jawaban;

        /**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('formsurveykepuasan_id, pertanyaanquisioner_id, tingkatkepuasan_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('update_time, bobot_jawaban', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('formsurveykepuasankaryawan_det_id, formsurveykepuasan_id, pertanyaanquisioner_id, tingkatkepuasan_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'pertanyaanquisioner' => array(self::BELONGS_TO, 'PertanyaanquisionerM', 'pertanyaanquisioner_id'),
			'formsurveykepuasan' => array(self::BELONGS_TO, 'FormsurveykepuasanT', 'formsurveykepuasan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'formsurveykepuasankaryawan_det_id' => 'Formsurveykepuasankaryawan Det',
			'formsurveykepuasan_id' => 'Formsurveykepuasan',
			'pertanyaanquisioner_id' => 'Pertanyaanquisioner',
			'tingkatkepuasan_id' => 'Tingkatkepuasan',
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
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('formsurveykepuasankaryawan_det_id',$this->formsurveykepuasankaryawan_det_id);
		$criteria->compare('formsurveykepuasan_id',$this->formsurveykepuasan_id);
		$criteria->compare('pertanyaanquisioner_id',$this->pertanyaanquisioner_id);
		$criteria->compare('tingkatkepuasan_id',$this->tingkatkepuasan_id);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}