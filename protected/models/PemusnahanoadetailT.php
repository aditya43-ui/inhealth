<?php

/**
 * This is the model class for table "pemusnahanoadetail_t".
 *
 * The followings are the available columns in table 'pemusnahanoadetail_t':
 * @property integer $pemusnahanoadetail_id
 * @property integer $pemusnahanobatalkes_id
 * @property integer $obatalkes_id
 * @property double $jmlbarang
 * @property string $tglkadaluarsa
 * @property string $nobatch
 * @property string $kondisibarang
 * @property double $harganetto
 *
 * The followings are the available model relations:
 * @property PemusnahanobatalkesT $pemusnahanobatalkes
 * @property ObatalkesM $obatalkes
 * @property StokobatalkesT[] $stokobatalkesTs
 */
class PemusnahanoadetailT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PemusnahanoadetailT the static model class
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
		return 'pemusnahanoadetail_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pemusnahanobatalkes_id, obatalkes_id, tglkadaluarsa', 'required'),
			array('pemusnahanobatalkes_id, obatalkes_id', 'numerical', 'integerOnly'=>true),
			array('jmlbarang, harganetto', 'numerical'),
			array('nobatch', 'length', 'max'=>200),
			array('kondisibarang', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pemusnahanoadetail_id, pemusnahanobatalkes_id, obatalkes_id, jmlbarang, tglkadaluarsa, nobatch, kondisibarang, harganetto', 'safe', 'on'=>'search'),
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
			'pemusnahanobatalkes' => array(self::BELONGS_TO, 'PemusnahanobatalkesT', 'pemusnahanobatalkes_id'),
			'obatalkes' => array(self::BELONGS_TO, 'ObatalkesM', 'obatalkes_id'),
			'stokobatalkesTs' => array(self::HAS_MANY, 'StokobatalkesT', 'pemusnahanoadet_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pemusnahanoadetail_id' => 'Pemusnahanoadetail',
			'pemusnahanobatalkes_id' => 'Pemusnahanobatalkes',
			'obatalkes_id' => 'Obatalkes',
			'jmlbarang' => 'Jmlbarang',
			'tglkadaluarsa' => 'Tglkadaluarsa',
			'nobatch' => 'Nobatch',
			'kondisibarang' => 'Kondisibarang',
			'harganetto' => 'Harganetto',
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

		$criteria->compare('pemusnahanoadetail_id',$this->pemusnahanoadetail_id);
		$criteria->compare('pemusnahanobatalkes_id',$this->pemusnahanobatalkes_id);
		$criteria->compare('obatalkes_id',$this->obatalkes_id);
		$criteria->compare('jmlbarang',$this->jmlbarang);
		$criteria->compare('tglkadaluarsa',$this->tglkadaluarsa,true);
		$criteria->compare('nobatch',$this->nobatch,true);
		$criteria->compare('kondisibarang',$this->kondisibarang,true);
		$criteria->compare('harganetto',$this->harganetto);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}