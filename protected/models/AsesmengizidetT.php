<?php

/**
 * This is the model class for table "asesmengizidet_t".
 *
 * The followings are the available columns in table 'asesmengizidet_t':
 * @property integer $asesmengizi_id
 * @property integer $asesmengiziitem_id
 * @property string $nilai
 *
 * The followings are the available model relations:
 * @property AsesmengiziT $asesmengizi
 * @property AsesmengiziitemM $asesmengiziitem
 */
class AsesmengizidetT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AsesmengizidetT the static model class
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
		return 'asesmengizidet_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('asesmengizi_id, asesmengiziitem_id', 'required'),
			array('asesmengizi_id, asesmengiziitem_id', 'numerical', 'integerOnly'=>true),
			array('nilai', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('asesmengizi_id, asesmengiziitem_id, nilai', 'safe', 'on'=>'search'),
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
			'asesmengizi' => array(self::BELONGS_TO, 'AsesmengiziT', 'asesmengizi_id'),
			'asesmengiziitem' => array(self::BELONGS_TO, 'AsesmengiziitemM', 'asesmengiziitem_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'asesmengizi_id' => 'Asesmengizi',
			'asesmengiziitem_id' => 'Asesmengiziitem',
			'nilai' => 'Nilai',
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

		$criteria->compare('asesmengizi_id',$this->asesmengizi_id);
		$criteria->compare('asesmengiziitem_id',$this->asesmengiziitem_id);
		$criteria->compare('nilai',$this->nilai,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}