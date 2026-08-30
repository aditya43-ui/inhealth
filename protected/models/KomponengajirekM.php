<?php

/**
 * This is the model class for table "komponengajirek_m".
 *
 * The followings are the available columns in table 'komponengajirek_m':
 * @property integer $komponengajirek_id
 * @property integer $komponengaji_id
 * @property integer $rekening5_id
 * @property boolean $ispenggajian
 * @property boolean $ispembayarangaji
 * @property string $debitkredit
 *
 * The followings are the available model relations:
 * @property KomponengajiM $komponengaji
 * @property Rekening5M $rekening5
 */
class KomponengajirekM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KomponengajirekM the static model class
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
		return 'komponengajirek_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('komponengaji_id, rekening5_id', 'required'),
			array('komponengaji_id, rekening5_id', 'numerical', 'integerOnly'=>true),
			array('debitkredit', 'length', 'max'=>1),
			array('ispenggajian, ispembayarangaji', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('komponengajirek_id, komponengaji_id, rekening5_id, ispenggajian, ispembayarangaji, debitkredit', 'safe', 'on'=>'search'),
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
			'komponengaji' => array(self::BELONGS_TO, 'KomponengajiM', 'komponengaji_id'),
			'rekening5' => array(self::BELONGS_TO, 'Rekening5M', 'rekening5_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'komponengajirek_id' => 'Komponengajirek',
			'komponengaji_id' => 'Komponengaji',
			'rekening5_id' => 'Rekening5',
			'ispenggajian' => 'Ispenggajian',
			'ispembayarangaji' => 'Ispembayarangaji',
			'debitkredit' => 'Debitkredit',
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

		$criteria->compare('komponengajirek_id',$this->komponengajirek_id);
		$criteria->compare('komponengaji_id',$this->komponengaji_id);
		$criteria->compare('rekening5_id',$this->rekening5_id);
		$criteria->compare('ispenggajian',$this->ispenggajian);
		$criteria->compare('ispembayarangaji',$this->ispembayarangaji);
		$criteria->compare('debitkredit',$this->debitkredit,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}