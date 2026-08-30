<?php

/**
 * This is the model class for table "kesejahteraanibuurine_t".
 *
 * The followings are the available columns in table 'kesejahteraanibuurine_t':
 * @property integer $kesejahteraanibuurine_id
 * @property integer $kesejahteraanibu_id
 * @property string $urine_protein
 * @property string $urine_aseton
 * @property double $urine_volume
 *
 * The followings are the available model relations:
 * @property KesejahteraanibuT $kesejahteraanibu
 */
class KesejahteraanibuurineT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KesejahteraanibuurineT the static model class
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
		return 'kesejahteraanibuurine_t';
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
			array('urine_volume', 'numerical'),
			array('urine_protein, urine_aseton', 'length', 'max'=>200),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('kesejahteraanibuurine_id, kesejahteraanibu_id, urine_protein, urine_aseton, urine_volume', 'safe', 'on'=>'search'),
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
			'kesejahteraanibuurine_id' => 'Kesejahteraanibuurine',
			'kesejahteraanibu_id' => 'Kesejahteraanibu',
			'urine_protein' => 'Protein',
			'urine_aseton' => 'Aseton',
			'urine_volume' => 'Volume',
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

		$criteria->compare('kesejahteraanibuurine_id',$this->kesejahteraanibuurine_id);
		$criteria->compare('kesejahteraanibu_id',$this->kesejahteraanibu_id);
		$criteria->compare('urine_protein',$this->urine_protein,true);
		$criteria->compare('urine_aseton',$this->urine_aseton,true);
		$criteria->compare('urine_volume',$this->urine_volume);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}