<?php

/**
 * This is the model class for table "rl2_ketenagaan_v".
 *
 * The followings are the available columns in table 'rl2_ketenagaan_v':
 * @property integer $kelompokpegawai_id
 * @property string $kelompokpegawai_nama
 * @property string $jeniskelamin
 * @property string $jmlkeadaanskrg
 * @property integer $pendkualifikasi_id
 * @property string $pendkualifikasi_nama
 * @property integer $jmlkeblaki
 * @property integer $jmlkebperempuan
 */
class Rl2KetenagaanV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Rl2KetenagaanV the static model class
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
		return 'rl2_ketenagaan_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kelompokpegawai_id, pendkualifikasi_id, jmlkeblaki, jmlkebperempuan', 'numerical', 'integerOnly'=>true),
			array('kelompokpegawai_nama', 'length', 'max'=>30),
			array('jeniskelamin', 'length', 'max'=>20),
			array('pendkualifikasi_nama', 'length', 'max'=>50),
			array('jmlkeadaanskrg', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('kelompokpegawai_id, kelompokpegawai_nama, jeniskelamin, jmlkeadaanskrg, pendkualifikasi_id, pendkualifikasi_nama, jmlkeblaki, jmlkebperempuan', 'safe', 'on'=>'search'),
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
			'kelompokpegawai_id' => 'Kelompokpegawai',
			'kelompokpegawai_nama' => 'Kelompokpegawai Nama',
			'jeniskelamin' => 'Jenis Kelamin',
			'jmlkeadaanskrg' => 'Jmlkeadaanskrg',
			'pendkualifikasi_id' => 'Pendkualifikasi',
			'pendkualifikasi_nama' => 'Pendkualifikasi Nama',
			'jmlkeblaki' => 'Jmlkeblaki',
			'jmlkebperempuan' => 'Jmlkebperempuan',
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

		$criteria->compare('kelompokpegawai_id',$this->kelompokpegawai_id);
		$criteria->compare('kelompokpegawai_nama',$this->kelompokpegawai_nama,true);
		$criteria->compare('jeniskelamin',$this->jeniskelamin,true);
		$criteria->compare('jmlkeadaanskrg',$this->jmlkeadaanskrg,true);
		$criteria->compare('pendkualifikasi_id',$this->pendkualifikasi_id);
		$criteria->compare('pendkualifikasi_nama',$this->pendkualifikasi_nama,true);
		$criteria->compare('jmlkeblaki',$this->jmlkeblaki);
		$criteria->compare('jmlkebperempuan',$this->jmlkebperempuan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}