<?php

/**
 * This is the model class for table "obatalkeszataktif_m".
 *
 * The followings are the available columns in table 'obatalkeszataktif_m':
 * @property integer $obatalkeszataktif_id
 * @property integer $obatalkes_id
 * @property string $obatalkeszataktif_nama
 *
 * The followings are the available model relations:
 * @property ObatalkesM $obatalkes
 */
class ObatalkeszataktifM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ObatalkeszataktifM the static model class
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
		return 'obatalkeszataktif_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('obatalkes_id, obatalkeszataktif_nama', 'required'),
			array('obatalkes_id', 'numerical', 'integerOnly'=>true),
			array('obatalkeszataktif_nama', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('obatalkeszataktif_id, obatalkes_id, obatalkeszataktif_nama', 'safe', 'on'=>'search'),
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
			'obatalkes' => array(self::BELONGS_TO, 'ObatalkesM', 'obatalkes_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'obatalkeszataktif_id' => 'Obatalkeszataktif',
			'obatalkes_id' => 'Obatalkes',
			'obatalkeszataktif_nama' => 'Obatalkeszataktif Nama',
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

		$criteria->compare('obatalkeszataktif_id',$this->obatalkeszataktif_id);
		$criteria->compare('obatalkes_id',$this->obatalkes_id);
		$criteria->compare('obatalkeszataktif_nama',$this->obatalkeszataktif_nama,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}