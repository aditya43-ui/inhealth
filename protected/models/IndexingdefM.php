<?php

/**
 * This is the model class for table "indexingdef_m".
 *
 * The followings are the available columns in table 'indexingdef_m':
 * @property integer $indexingdef_id
 * @property integer $indexing_id
 * @property string $indexingdef_nama
 * @property integer $bobot
 *
 * The followings are the available model relations:
 * @property IndexingM $indexing
 */
class IndexingdefM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return IndexingdefM the static model class
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
		return 'indexingdef_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('indexing_id, indexingdef_nama', 'required'),
			array('indexing_id, bobot', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('indexingdef_id, indexing_id, indexingdef_nama, bobot', 'safe', 'on'=>'search'),
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
			'indexing' => array(self::BELONGS_TO, 'IndexingM', 'indexing_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'indexingdef_id' => 'Indexingdef',
			'indexing_id' => 'Indexing',
			'indexingdef_nama' => 'Indexingdef Nama',
			'bobot' => 'Bobot',
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

		$criteria->compare('indexingdef_id',$this->indexingdef_id);
		$criteria->compare('indexing_id',$this->indexing_id);
		$criteria->compare('indexingdef_nama',$this->indexingdef_nama,true);
		$criteria->compare('bobot',$this->bobot);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}