<?php

/**
 * This is the model class for table "rinciansetoranbdhara_t".
 *
 * The followings are the available columns in table 'rinciansetoranbdhara_t':
 * @property integer $rinciansetoranbdhara_id
 * @property integer $rekening5_id
 * @property integer $setoranbdhara_id
 * @property integer $setorankasir_id
 * @property double $jmlsetoranbdhara
 */
class RinciansetoranbdharaT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RinciansetoranbdharaT the static model class
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
		return 'rinciansetoranbdhara_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('rekening5_id, setoranbdhara_id, jmlsetoranbdhara', 'required'),
			array('rekening5_id, setoranbdhara_id, setorankasir_id', 'numerical', 'integerOnly'=>true),
			array('kelompoktindakan_id, jmlsetoranbdhara', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('rinciansetoranbdhara_id, rekening5_id, setoranbdhara_id, setorankasir_id, jmlsetoranbdhara', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'rinciansetoranbdhara_id' => 'Rinciansetoranbdhara',
			'rekening5_id' => 'Rekening5',
			'setoranbdhara_id' => 'Setoranbdhara',
			'setorankasir_id' => 'Setorankasir',
			'jmlsetoranbdhara' => 'Jmlsetoranbdhara',
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

		$criteria->compare('rinciansetoranbdhara_id',$this->rinciansetoranbdhara_id);
		$criteria->compare('rekening5_id',$this->rekening5_id);
		$criteria->compare('setoranbdhara_id',$this->setoranbdhara_id);
		$criteria->compare('setorankasir_id',$this->setorankasir_id);
		$criteria->compare('jmlsetoranbdhara',$this->jmlsetoranbdhara);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}