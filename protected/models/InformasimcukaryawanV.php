<?php

/**
 * This is the model class for table "informasimcukaryawan_v".
 *
 * The followings are the available columns in table 'informasimcukaryawan_v':
 * @property double $periodemcu
 * @property integer $pegawai_id
 * @property string $nomorindukpegawai
 * @property string $nama_pegawai
 * @property integer $unitkerja_id
 * @property string $namaunitkerja
 * @property string $tglhasilpemeriksaanmcu
 * @property string $statuspemeriksaan
 * @property integer $kesimpulanmcu_id
 */
class InformasimcukaryawanV extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'informasimcukaryawan_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pegawai_id, unitkerja_id, kesimpulanmcu_id', 'numerical', 'integerOnly'=>true),
			array('periodemcu', 'numerical'),
			array('nomorindukpegawai', 'length', 'max'=>30),
			array('nama_pegawai', 'length', 'max'=>50),
			array('namaunitkerja', 'length', 'max'=>200),
			array('tglhasilpemeriksaanmcu, statuspemeriksaan', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('periodemcu, pegawai_id, nomorindukpegawai, nama_pegawai, unitkerja_id, namaunitkerja, tglhasilpemeriksaanmcu, statuspemeriksaan, kesimpulanmcu_id', 'safe', 'on'=>'search'),
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
			'periodemcu' => 'Periodemcu',
			'pegawai_id' => 'Pegawai',
			'nomorindukpegawai' => 'Nomorindukpegawai',
			'nama_pegawai' => 'Nama Pegawai',
			'unitkerja_id' => 'Unitkerja',
			'namaunitkerja' => 'Namaunitkerja',
			'tglhasilpemeriksaanmcu' => 'Tglhasilpemeriksaanmcu',
			'statuspemeriksaan' => 'Statuspemeriksaan',
			'kesimpulanmcu_id' => 'Kesimpulanmcu',
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

		$criteria->compare('periodemcu',$this->periodemcu);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('nomorindukpegawai',$this->nomorindukpegawai,true);
		$criteria->compare('nama_pegawai',$this->nama_pegawai,true);
		$criteria->compare('unitkerja_id',$this->unitkerja_id);
		$criteria->compare('namaunitkerja',$this->namaunitkerja,true);
		$criteria->compare('tglhasilpemeriksaanmcu',$this->tglhasilpemeriksaanmcu,true);
		$criteria->compare('statuspemeriksaan',$this->statuspemeriksaan,true);
		$criteria->compare('kesimpulanmcu_id',$this->kesimpulanmcu_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return InformasimcukaryawanV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function searchInformasi()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('periodemcu',$this->periodemcu);
		$criteria->compare('lower(nomorindukpegawai)',strtolower($this->nomorindukpegawai),true);
		$criteria->compare('lower(nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('statuspemeriksaan',$this->statuspemeriksaan);
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
