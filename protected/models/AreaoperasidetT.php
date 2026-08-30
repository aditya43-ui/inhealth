<?php

/**
 * This is the model class for table "areaoperasidet_t".
 *
 * The followings are the available columns in table 'areaoperasidet_t':
 * @property integer $areaoperasidet_id
 * @property integer $areaoperasi_id
 * @property integer $gambartubuh_id
 * @property integer $bagiantubuh_id
 * @property double $kordinat_tubuh_x
 * @property double $kordinat_tubuh_y
 * @property string $areaoperasidet_ket
 *
 * The followings are the available model relations:
 * @property AreaoperasiT $areaoperasi
 */
class AreaoperasidetT extends CActiveRecord
{
	public $namabagtubuh;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AreaoperasidetT the static model class
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
		return 'areaoperasidet_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('areaoperasi_id, gambartubuh_id, bagiantubuh_id, kordinat_tubuh_x, kordinat_tubuh_y', 'required'),
			array('areaoperasi_id, gambartubuh_id, bagiantubuh_id', 'numerical', 'integerOnly'=>true),
			array('kordinat_tubuh_x, kordinat_tubuh_y', 'numerical'),
			array('areaoperasidet_ket', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('areaoperasidet_id, areaoperasi_id, gambartubuh_id, bagiantubuh_id, kordinat_tubuh_x, kordinat_tubuh_y, areaoperasidet_ket', 'safe', 'on'=>'search'),
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
			'areaoperasi' => array(self::BELONGS_TO, 'AreaoperasiT', 'areaoperasi_id'),
			'bagiantubuh' => array(self::BELONGS_TO, 'BagiantubuhM', 'bagiantubuh_id'),
			'gambartubuh' => array(self::BELONGS_TO, 'GambartubuhM', 'gambartubuh_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'areaoperasidet_id' => 'Areaoperasidet',
			'areaoperasi_id' => 'Areaoperasi',
			'gambartubuh_id' => 'Gambartubuh',
			'bagiantubuh_id' => 'Bagiantubuh',
			'kordinat_tubuh_x' => 'Koordinat Tubuh X',
			'kordinat_tubuh_y' => 'Koordinat Tubuh Y',
			'areaoperasidet_ket' => 'Areaoperasidet Ket',
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

		$criteria->compare('areaoperasidet_id',$this->areaoperasidet_id);
		$criteria->compare('areaoperasi_id',$this->areaoperasi_id);
		$criteria->compare('gambartubuh_id',$this->gambartubuh_id);
		$criteria->compare('bagiantubuh_id',$this->bagiantubuh_id);
		$criteria->compare('kordinat_tubuh_x',$this->kordinat_tubuh_x);
		$criteria->compare('kordinat_tubuh_y',$this->kordinat_tubuh_y);
		$criteria->compare('areaoperasidet_ket',$this->areaoperasidet_ket,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}