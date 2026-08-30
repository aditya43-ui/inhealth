<?php

/**
 * This is the model class for table "obatcairanintraanastesi_t".
 * @author Elham Budianto <elhambudianto@.com>
 * @package application.models
 * @category model
 * 
 * The followings are the available columns in table 'obatcairanintraanastesi_t':
 * @property integer $obatcairanintraanastesi_id
 * @property integer $intraanastesi_id
 * @property string $jenis
 * @property string $sub_jenis
 * @property string $tipe
 * @property string $nama
 * @property integer $ukuran
 */
class ObatcairanintraanastesiT extends CActiveRecord
{
    public $kristaloid,$kolloid,$wb,$urin,$s_dan_i,$darah,$ebl;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ObatcairanintraanastesiT the static model class
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
		return 'obatcairanintraanastesi_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('intraanastesi_id, ukuran', 'numerical', 'integerOnly'=>true),
			array('jenis, sub_jenis, tipe, nama', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('obatcairanintraanastesi_id, intraanastesi_id, jenis, sub_jenis, tipe, nama, ukuran', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'obatcairanintraanastesi_id' => 'Obatcairanintraanastesi',
			'intraanastesi_id' => 'Intraanastesi',
			'jenis' => 'Jenis',
			'sub_jenis' => 'Sub Jenis',
			'tipe' => 'Tipe',
			'nama' => 'Nama',
			'ukuran' => 'Ukuran',
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

		$criteria->compare('obatcairanintraanastesi_id',$this->obatcairanintraanastesi_id);
		$criteria->compare('intraanastesi_id',$this->intraanastesi_id);
		$criteria->compare('jenis',$this->jenis,true);
		$criteria->compare('sub_jenis',$this->sub_jenis,true);
		$criteria->compare('tipe',$this->tipe,true);
		$criteria->compare('nama',$this->nama,true);
		$criteria->compare('ukuran',$this->ukuran);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}