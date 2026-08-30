<?php

/**
 * This is the model class for table "formstokopname_r".
 *
 * The followings are the available columns in table 'formstokopname_r':
 * @property integer $formstokopname_id
 * @property integer $stokopnamedet_id
 * @property integer $obatalkes_id
 * @property integer $formuliropname_id
 * @property double $volume_stok
 *
 * The followings are the available model relations:
 * @property StokopnamedetT[] $stokopnamedetTs
 * @property FormuliropnameR $formuliropname
 * @property ObatalkesM $obatalkes
 * @property StokopnamedetT $stokopnamedet
 */
class FormstokopnameR extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return FormstokopnameR the static model class
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
		return 'formstokopname_r';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('obatalkes_id, formuliropname_id, volume_stok', 'required'),
			array('penyimpananobat_id, rakobat_id, stokopnamedet_id, obatalkes_id, formuliropname_id', 'numerical', 'integerOnly'=>true),
			array('volume_stok', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('formstokopname_id, stokopnamedet_id, obatalkes_id, formuliropname_id, volume_stok', 'safe', 'on'=>'search'),
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
			'stokopnamedetTs' => array(self::HAS_MANY, 'StokopnamedetT', 'formstokopname_id'),
			'formuliropname' => array(self::BELONGS_TO, 'FormuliropnameR', 'formuliropname_id'),
			'obatalkes' => array(self::BELONGS_TO, 'ObatalkesM', 'obatalkes_id'),
			'stokopnamedet' => array(self::BELONGS_TO, 'StokopnamedetT', 'stokopnamedet_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'formstokopname_id' => 'Formstokopname',
			'stokopnamedet_id' => 'Stokopnamedet',
			'obatalkes_id' => 'Obatalkes',
			'formuliropname_id' => 'Formuliropname',
			'volume_stok' => 'Volume Stok',
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

		$criteria->compare('formstokopname_id',$this->formstokopname_id);
		$criteria->compare('stokopnamedet_id',$this->stokopnamedet_id);
		$criteria->compare('obatalkes_id',$this->obatalkes_id);
		$criteria->compare('formuliropname_id',$this->formuliropname_id);
		$criteria->compare('volume_stok',$this->volume_stok);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}