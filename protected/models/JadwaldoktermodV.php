<?php

/**
 * This is the model class for table "jadwaldoktermod_v".
 *
 * The followings are the available columns in table 'jadwaldoktermod_v':
 * @property integer $pegawai_id
 * @property string $nomorindukpegawai
 * @property string $nama_pegawai
 * @property integer $jabatan_id
 * @property string $jabatan_nama
 * @property string $tanggaljaga
 * @property boolean $is_mod
 * @property boolean $is_spvcadangan
 */
class JadwaldoktermodV extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'jadwaldoktermod_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pegawai_id, jabatan_id', 'numerical', 'integerOnly'=>true),
			array('nomorindukpegawai', 'length', 'max'=>30),
			array('nama_pegawai', 'length', 'max'=>50),
			array('jabatan_nama', 'length', 'max'=>100),
			array('tanggaljaga, is_mod, is_spvcadangan', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('pegawai_id, nomorindukpegawai, nama_pegawai, jabatan_id, jabatan_nama, tanggaljaga, is_mod, is_spvcadangan', 'safe', 'on'=>'search'),
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
			'pegawai_id' => 'Pegawai',
			'nomorindukpegawai' => 'Nomorindukpegawai',
			'nama_pegawai' => 'Nama Pegawai',
			'jabatan_id' => 'Jabatan',
			'jabatan_nama' => 'Jabatan Nama',
			'tanggaljaga' => 'Tanggaljaga',
			'is_mod' => 'Is Mod',
			'is_spvcadangan' => 'Is Spvcadangan',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('nomorindukpegawai',$this->nomorindukpegawai,true);
		$criteria->compare('nama_pegawai',$this->nama_pegawai,true);
		$criteria->compare('jabatan_id',$this->jabatan_id);
		$criteria->compare('jabatan_nama',$this->jabatan_nama,true);
		$criteria->compare('tanggaljaga',$this->tanggaljaga,true);
		$criteria->compare('is_mod',$this->is_mod);
		$criteria->compare('is_spvcadangan',$this->is_spvcadangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchDialog()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('nomorindukpegawai',$this->nomorindukpegawai,true);
		$criteria->compare('nama_pegawai',$this->nama_pegawai,true);
		$criteria->compare('jabatan_id',$this->jabatan_id);
		$criteria->compare('jabatan_nama',$this->jabatan_nama,true);
		$criteria->addCondition("tanggaljaga ='" . date('Y-m-d') . "'");
		$criteria->compare('is_mod',$this->is_mod);
		$criteria->compare('is_spvcadangan',$this->is_spvcadangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return JadwaldoktermodV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
