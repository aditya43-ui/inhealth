<?php

/**
 * This is the model class for table "rl3_7_kegradiologi".
 *
 * The followings are the available columns in table 'rl3_7_kegradiologi':
 * @property string $tgl_tindakan
 * @property string $jenispemeriksaanrad_nama
 * @property string $pemeriksaanrad_nama
 * @property string $jumlah
 */
class Rl37Kegradiologi extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Rl37Kegradiologi the static model class
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
		return 'rl3_7_kegradiologi';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jenispemeriksaanrad_nama, pemeriksaanrad_nama', 'length', 'max'=>100),
			array('tgl_tindakan, jumlah', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tgl_tindakan, jenispemeriksaanrad_nama, pemeriksaanrad_nama, jumlah', 'safe', 'on'=>'search'),
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
			'tgl_tindakan' => 'Tgl. Tindakan',
			'jenispemeriksaanrad_nama' => 'Pemeriksaanrad Jenis',
			'pemeriksaanrad_nama' => 'Pemeriksaanrad Nama',
			'jumlah' => 'Jumlah',
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

		$criteria->compare('tgl_tindakan',$this->tgl_tindakan,true);
		$criteria->compare('jenispemeriksaanrad_nama',$this->jenispemeriksaanrad_nama,true);
		$criteria->compare('pemeriksaanrad_nama',$this->pemeriksaanrad_nama,true);
		$criteria->compare('jumlah',$this->jumlah,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}