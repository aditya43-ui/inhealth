<?php

/**
 * This is the model class for table "kesejahteraanibusuhu_t".
 *
 * The followings are the available columns in table 'kesejahteraanibusuhu_t':
 * @property integer $kesejahteraanibusuhu_id
 * @property integer $kesejahteraanibu_id
 * @property double $suhutubuh
 *
 * The followings are the available model relations:
 * @property KesejahteraanibuT $kesejahteraanibu
 */
class KesejahteraanibusuhuT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KesejahteraanibusuhuT the static model class
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
		return 'kesejahteraanibusuhu_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kesejahteraanibu_id', 'required'),
			array('kesejahteraanibu_id', 'numerical', 'integerOnly'=>true),
			array('suhutubuh', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('kesejahteraanibusuhu_id, kesejahteraanibu_id, suhutubuh', 'safe', 'on'=>'search'),
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
			'kesejahteraanibu' => array(self::BELONGS_TO, 'KesejahteraanibuT', 'kesejahteraanibu_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'kesejahteraanibusuhu_id' => 'Kesejahteraanibusuhu',
			'kesejahteraanibu_id' => 'Kesejahteraanibu',
			'suhutubuh' => 'Suhu',
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

		$criteria->compare('kesejahteraanibusuhu_id',$this->kesejahteraanibusuhu_id);
		$criteria->compare('kesejahteraanibu_id',$this->kesejahteraanibu_id);
		$criteria->compare('suhutubuh',$this->suhutubuh);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}