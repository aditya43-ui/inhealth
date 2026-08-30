<?php

/**
 * This is the model class for table "rl3_6_kegpembedahan_v".
 *
 * The followings are the available columns in table 'rl3_6_kegpembedahan_v':
 * @property string $tglrencanaoperasi
 * @property integer $kegiatanoperasi_id
 * @property string $kegiatanoperasi_nama
 * @property integer $golonganoperasi_id
 * @property string $golonganoperasi_nama
 * @property string $jmloperasi
 */
class Rl36KegpembedahanV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Rl36KegpembedahanV the static model class
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
		return 'rl3_6_kegpembedahan_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kegiatanoperasi_id, golonganoperasi_id', 'numerical', 'integerOnly'=>true),
			array('kegiatanoperasi_nama', 'length', 'max'=>100),
			array('golonganoperasi_nama', 'length', 'max'=>50),
			array('tglrencanaoperasi, jmloperasi', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tglrencanaoperasi, kegiatanoperasi_id, kegiatanoperasi_nama, golonganoperasi_id, golonganoperasi_nama, jmloperasi', 'safe', 'on'=>'search'),
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
			'tglrencanaoperasi' => 'Tglrencanaoperasi',
			'kegiatanoperasi_id' => 'Kegiatanoperasi',
			'kegiatanoperasi_nama' => 'Kegiatanoperasi Nama',
			'golonganoperasi_id' => 'Golonganoperasi',
			'golonganoperasi_nama' => 'Golonganoperasi Nama',
			'jmloperasi' => 'Jmloperasi',
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

		$criteria->compare('tglrencanaoperasi',$this->tglrencanaoperasi,true);
		$criteria->compare('kegiatanoperasi_id',$this->kegiatanoperasi_id);
		$criteria->compare('kegiatanoperasi_nama',$this->kegiatanoperasi_nama,true);
		$criteria->compare('golonganoperasi_id',$this->golonganoperasi_id);
		$criteria->compare('golonganoperasi_nama',$this->golonganoperasi_nama,true);
		$criteria->compare('jmloperasi',$this->jmloperasi,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}