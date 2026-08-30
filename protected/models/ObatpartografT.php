<?php

/**
 * This is the model class for table "obatpartograf_t".
 *
 * The followings are the available columns in table 'obatpartograf_t':
 * @property integer $obatpartograf_id
 * @property integer $kesejahteraanibu_id
 * @property integer $obatalkes_id
 * @property double $qty_obat
 *
 * The followings are the available model relations:
 * @property KesejahteraanibuT $kesejahteraanibu
 */
class ObatpartografT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ObatpartografT the static model class
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
		return 'obatpartograf_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kesejahteraanibu_id, obatalkes_id, qty_obat', 'required'),
			array('kesejahteraanibu_id, obatalkes_id', 'numerical', 'integerOnly'=>true),
			array('qty_obat', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('obatpartograf_id, kesejahteraanibu_id, obatalkes_id, qty_obat', 'safe', 'on'=>'search'),
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
            'obatalkes' => array(self::BELONGS_TO, 'ObatalkesM', 'obatalkes_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'obatpartograf_id' => 'Obatpartograf',
			'kesejahteraanibu_id' => 'Kesejahteraanibu',
			'obatalkes_id' => 'Obatalkes',
			'qty_obat' => 'Qty Obat',
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

		$criteria->compare('obatpartograf_id',$this->obatpartograf_id);
		$criteria->compare('kesejahteraanibu_id',$this->kesejahteraanibu_id);
		$criteria->compare('obatalkes_id',$this->obatalkes_id);
		$criteria->compare('qty_obat',$this->qty_obat);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}