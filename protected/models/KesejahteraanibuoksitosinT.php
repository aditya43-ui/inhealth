<?php

/**
 * This is the model class for table "kesejahteraanibuoksitosin_t".
 *
 * The followings are the available columns in table 'kesejahteraanibuoksitosin_t':
 * @property integer $kesejahteraanibuoksitosin_id
 * @property integer $kesejahteraanibu_id
 * @property string $oksitosin_ul
 * @property string $oksitosin_lolos
 *
 * The followings are the available model relations:
 * @property KesejahteraanibuT $kesejahteraanibu
 */
class KesejahteraanibuoksitosinT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KesejahteraanibuoksitosinT the static model class
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
		return 'kesejahteraanibuoksitosin_t';
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
			array('oksitosin_ul, oksitosin_lolos', 'length', 'max'=>200),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('kesejahteraanibuoksitosin_id, kesejahteraanibu_id, oksitosin_ul, oksitosin_lolos', 'safe', 'on'=>'search'),
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
			'kesejahteraanibuoksitosin_id' => 'Kesejahteraanibuoksitosin',
			'kesejahteraanibu_id' => 'Kesejahteraanibu',
			'oksitosin_ul' => 'Oksitosin U/L',
			'oksitosin_lolos' => 'Lolos/Menit',
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

		$criteria->compare('kesejahteraanibuoksitosin_id',$this->kesejahteraanibuoksitosin_id);
		$criteria->compare('kesejahteraanibu_id',$this->kesejahteraanibu_id);
		$criteria->compare('oksitosin_ul',$this->oksitosin_ul,true);
		$criteria->compare('oksitosin_lolos',$this->oksitosin_lolos,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}