<?php

/**
 * This is the model class for table "referensihasildet_m".
 *
 * The followings are the available columns in table 'referensihasildet_m':
 * @property integer $refhasildet_id
 * @property integer $refhasilrad_id
 * @property string $refhasildet_jk
 * @property string $refhasildet_nama
 * @property string $refhasildet_isian
 *
 * The followings are the available model relations:
 * @property ReferensihasilradM $refhasilrad
 */
class ReferensihasildetM extends CActiveRecord
{
	public $hasperiksaraddet_id;
	public $hasperiksaraddet_expertise;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ReferensihasildetM the static model class
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
		return 'referensihasildet_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('refhasilrad_id', 'required'),
			array('refhasilrad_id', 'numerical', 'integerOnly'=>true),
			array('refhasildet_jk', 'length', 'max'=>25),
			array('refhasildet_nama', 'length', 'max'=>50),
			array('refhasildet_urut, refhasildet_aktif, refhasildet_isian', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('refhasildet_id, refhasilrad_id, refhasildet_jk, refhasildet_nama, refhasildet_isian', 'safe', 'on'=>'search'),
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
			'refhasilrad' => array(self::BELONGS_TO, 'ReferensihasilradM', 'refhasilrad_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'refhasildet_id' => 'ID',
			'refhasilrad_id' => 'Referensi Hasil Rad',
			'refhasildet_jk' => 'Jenis Kelamin',
			'refhasildet_nama' => 'Nama Hasil Pemeriksaan',
			'refhasildet_isian' => 'Isian',
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

		$criteria->compare('refhasildet_id',$this->refhasildet_id);
		$criteria->compare('refhasilrad_id',$this->refhasilrad_id);
		$criteria->compare('refhasildet_jk',$this->refhasildet_jk,true);
		$criteria->compare('refhasildet_nama',$this->refhasildet_nama,true);
		$criteria->compare('refhasildet_isian',$this->refhasildet_isian,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	
}