<?php

/**
 * This is the model class for table "ewspasiendet_t".
 *
 * The followings are the available columns in table 'ewspasiendet_t':
 * @property integer $ewspasiendet_id
 * @property integer $ewspasien_id
 * @property string $hasipenilaian
 * @property string $skorpenilaian
 *
 * The followings are the available model relations:
 * @property EwspasienT $ewspasien
 */
class EwspasiendetT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return EwspasiendetT the static model class
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
		return 'ewspasiendet_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ewspasien_id', 'required'),
			array('ewspasien_id, nourut', 'numerical', 'integerOnly'=>true),
			array('skorpenilaian', 'length', 'max'=>100),
			array('hasipenilaian', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ewspasiendet_id, ewspasien_id, hasipenilaian, skorpenilaian, nourut', 'safe', 'on'=>'search'),
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
			'ewspasien' => array(self::BELONGS_TO, 'EwspasienT', 'ewspasien_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ewspasiendet_id' => 'Ewspasiendet',
			'ewspasien_id' => 'Ewspasien',
			'hasipenilaian' => 'Hasipenilaian',
			'skorpenilaian' => 'Skorpenilaian',
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

		$criteria->compare('ewspasiendet_id',$this->ewspasiendet_id);
		$criteria->compare('ewspasien_id',$this->ewspasien_id);
		$criteria->compare('hasipenilaian',$this->hasipenilaian,true);
		$criteria->compare('skorpenilaian',$this->skorpenilaian,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}