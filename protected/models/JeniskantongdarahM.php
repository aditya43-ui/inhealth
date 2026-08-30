<?php

/**
 * This is the model class for table "jeniskantongdarah_m".
 *
 * The followings are the available columns in table 'jeniskantongdarah_m':
 * @property integer $jeniskantongdarah_id
 * @property string $nama_jenis
 * @property string $nama_jenis_sngkt
 * @property boolean $jeniskantongdarah_aktif
 *
 * The followings are the available model relations:
 * @property KomponendarahM[] $komponendarahMs
 * @property KantongdarahT[] $kantongdarahTs
 * @property KantongdarahdetT[] $kantongdarahdetTs
 */
class JeniskantongdarahM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JeniskantongdarahM the static model class
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
		return 'jeniskantongdarah_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nama_jenis, nama_jenis_sngkt', 'required'),
			array('nama_jenis', 'length', 'max'=>255),
			array('nama_jenis_sngkt', 'length', 'max'=>5),
			array('jeniskantongdarah_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('jeniskantongdarah_id, nama_jenis, nama_jenis_sngkt, jeniskantongdarah_aktif', 'safe', 'on'=>'search'),
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
			'komponendarahMs' => array(self::HAS_MANY, 'KomponendarahM', 'jeniskantongdarah_id'),
			'kantongdarahTs' => array(self::HAS_MANY, 'KantongdarahT', 'jeniskantongdarah_id'),
			'kantongdarahdetTs' => array(self::HAS_MANY, 'KantongdarahdetT', 'jeniskantongdarah_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'jeniskantongdarah_id' => 'Jenis Kantong Darah',
			'nama_jenis' => 'Nama Jenis Kantong Darah',
			'nama_jenis_sngkt' => 'Singkatan',
			'jeniskantongdarah_aktif' => 'Status',
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

		$criteria->compare('jeniskantongdarah_id',$this->jeniskantongdarah_id);
		$criteria->compare('nama_jenis',$this->nama_jenis,true);
		$criteria->compare('nama_jenis_sngkt',$this->nama_jenis_sngkt,true);
                $criteria->compare('jeniskantongdarah_aktif',isset($this->jeniskantongdarah_aktif)?$this->jeniskantongdarah_aktif:true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}