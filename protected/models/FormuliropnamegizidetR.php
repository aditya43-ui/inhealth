<?php

/**
 * This is the model class for table "formuliropnamegizidet_r".
 *
 * The followings are the available columns in table 'formuliropnamegizidet_r':
 * @property integer $formuliropnamegizidet_id
 * @property integer $stokopnamegizidet_id
 * @property integer $bahanmakanan_id
 * @property integer $formuliropnamegizi_id
 * @property double $volume_stok
 *
 * The followings are the available model relations:
 * @property StokopnamegizidetT $stokopnamegizidet
 * @property BahanmakananM $bahanmakanan
 * @property FormuliropnamegiziR $formuliropnamegizi
 * @property StokopnamegizidetT[] $stokopnamegizidetTs
 */
class FormuliropnamegizidetR extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return FormuliropnamegizidetR the static model class
	 */
    public $jenisbahanmakanan;
    public $namabahanmakanan;
    public $golbahanmakanan_nama;
    public $qtystok;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'formuliropnamegizidet_r';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('bahanmakanan_id, formuliropnamegizi_id, volume_stok', 'required'),
			array('stokopnamegizidet_id, bahanmakanan_id, formuliropnamegizi_id', 'numerical', 'integerOnly'=>true),
			array('volume_stok', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('formuliropnamegizidet_id, stokopnamegizidet_id, bahanmakanan_id, formuliropnamegizi_id, volume_stok', 'safe', 'on'=>'search'),
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
			'stokopnamegizidet' => array(self::BELONGS_TO, 'StokopnamegizidetT', 'stokopnamegizidet_id'),
			'bahanmakanan' => array(self::BELONGS_TO, 'BahanmakananM', 'bahanmakanan_id'),
			'formuliropnamegizi' => array(self::BELONGS_TO, 'FormuliropnamegiziR', 'formuliropnamegizi_id'),
			'stokopnamegizidetTs' => array(self::HAS_MANY, 'StokopnamegizidetT', 'formuliropnamegizidet_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'formuliropnamegizidet_id' => 'Formuliropnamegizidet',
			'stokopnamegizidet_id' => 'Stokopnamegizidet',
			'bahanmakanan_id' => 'Bahanmakanan',
			'formuliropnamegizi_id' => 'Formuliropnamegizi',
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

		$criteria->compare('formuliropnamegizidet_id',$this->formuliropnamegizidet_id);
		$criteria->compare('stokopnamegizidet_id',$this->stokopnamegizidet_id);
		$criteria->compare('bahanmakanan_id',$this->bahanmakanan_id);
		$criteria->compare('formuliropnamegizi_id',$this->formuliropnamegizi_id);
		$criteria->compare('volume_stok',$this->volume_stok);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}