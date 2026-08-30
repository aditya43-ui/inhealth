<?php

/**
 * This is the model class for table "prevmaintendet_t".
 *
 * The followings are the available columns in table 'prevmaintendet_t':
 * @property integer $prevmaintendet_id
 * @property integer $prevmainten_id
 * @property integer $ipmchecklist_id
 * @property boolean $ipmchecklist_status
 *
 * The followings are the available model relations:
 * @property IpmchecklistM $ipmchecklist
 * @property PrevmaintenT $prevmainten
 */
class PrevmaintendetT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PrevmaintendetT the static model class
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
		return 'prevmaintendet_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('prevmainten_id, ipmchecklist_id', 'required'),
			array('prevmainten_id, ipmchecklist_id', 'numerical', 'integerOnly'=>true),
			array('ipmchecklist_status', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('prevmaintendet_id, prevmainten_id, ipmchecklist_id, ipmchecklist_status', 'safe', 'on'=>'search'),
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
			'ipmchecklist' => array(self::BELONGS_TO, 'IpmchecklistM', 'ipmchecklist_id'),
			'prevmainten' => array(self::BELONGS_TO, 'PrevmaintenT', 'prevmainten_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'prevmaintendet_id' => 'Prevmaintendet',
			'prevmainten_id' => 'Prevmainten',
			'ipmchecklist_id' => 'Ipmchecklist',
			'ipmchecklist_status' => 'Ipmchecklist Status',
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

		$criteria->compare('prevmaintendet_id',$this->prevmaintendet_id);
		$criteria->compare('prevmainten_id',$this->prevmainten_id);
		$criteria->compare('ipmchecklist_id',$this->ipmchecklist_id);
		$criteria->compare('ipmchecklist_status',$this->ipmchecklist_status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}