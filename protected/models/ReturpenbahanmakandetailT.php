<?php

/**
 * This is the model class for table "returpenbahanmakandetail_t".
 *
 * The followings are the available columns in table 'returpenbahanmakandetail_t':
 * @property integer $returpenbahanmakandetail_id
 * @property integer $returbahanmakan_id
 * @property integer $terimabahandetail_id
 * @property double $jmlretur
 * @property double $hargasatuan
 * @property string $satuanbeli
 * @property string $kondisibahanmakan
 *
 * The followings are the available model relations:
 * @property TerimabahandetailT $terimabahandetail
 * @property ReturpenbahanmakanT $returpenbahanmakandetail
 */
class ReturpenbahanmakandetailT extends CActiveRecord
{
    public $persendiscount, $persenppn, $persenpph, $harganetto, $jmldiscount, $jmlppn, $jmlpph, $jmlterima, $subtotal;
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ReturpenbahanmakandetailT the static model class
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
		return 'returpenbahanmakandetail_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('returbahanmakan_id, jmlretur, hargasatuan, satuanbeli, kondisibahanmakan', 'required'),
			array('returbahanmakan_id, terimabahandetail_id', 'numerical', 'integerOnly'=>true),
			array('jmlretur, hargasatuan', 'numerical'),
			array('satuanbeli, kondisibahanmakan', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('returpenbahanmakandetail_id, returbahanmakan_id, terimabahandetail_id, jmlretur, hargasatuan, satuanbeli, kondisibahanmakan', 'safe', 'on'=>'search'),
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
			'terimabahandetail' => array(self::BELONGS_TO, 'TerimabahandetailT', 'terimabahandetail_id'),
			'returpenbahanmakandetail' => array(self::BELONGS_TO, 'ReturpenbahanmakanT', 'returpenbahanmakandetail_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'returpenbahanmakandetail_id' => 'Returpenbahanmakandetail',
			'returbahanmakan_id' => 'Returbahanmakan',
			'terimabahandetail_id' => 'Terimabahandetail',
			'jmlretur' => 'Jmlretur',
			'hargasatuan' => 'Hargasatuan',
			'satuanbeli' => 'Satuanbeli',
			'kondisibahanmakan' => 'Kondisi bahan Makan',
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

		$criteria->compare('returpenbahanmakandetail_id',$this->returpenbahanmakandetail_id);
		$criteria->compare('returbahanmakan_id',$this->returbahanmakan_id);
		$criteria->compare('terimabahandetail_id',$this->terimabahandetail_id);
		$criteria->compare('jmlretur',$this->jmlretur);
		$criteria->compare('hargasatuan',$this->hargasatuan);
		$criteria->compare('satuanbeli',$this->satuanbeli,true);
		$criteria->compare('kondisibahanmakan',$this->kondisibahanmakan,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}