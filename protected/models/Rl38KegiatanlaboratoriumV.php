<?php

/**
 * This is the model class for table "rl3_8_kegiatanlaboratorium_v".
 *
 * The followings are the available columns in table 'rl3_8_kegiatanlaboratorium_v':
 * @property double $tahun
 * @property integer $profilrs_id
 * @property string $nokode_rumahsakit
 * @property string $nama_rumahsakit
 * @property integer $jenispemeriksaanlab_id
 * @property string $jenispemeriksaanlab_kelompok
 * @property string $jenispemeriksaanlab_kode
 * @property string $jenispemeriksaanlab_nama
 * @property integer $jenispemeriksaanlab_urutan
 * @property integer $pemeriksaanlab_id
 * @property string $pemeriksaanlab_kode
 * @property string $pemeriksaanlab_nama
 * @property integer $pemeriksaanlab_urutan
 * @property integer $daftartindakan_id
 * @property string $daftartindakan_nama
 * @property string $jumlah
 */
class Rl38KegiatanlaboratoriumV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Rl38KegiatanlaboratoriumV the static model class
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
		return 'rl3_8_kegiatanlaboratorium_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('profilrs_id, jenispemeriksaanlab_id, jenispemeriksaanlab_urutan, pemeriksaanlab_id, pemeriksaanlab_urutan, daftartindakan_id', 'numerical', 'integerOnly'=>true),
			array('tahun', 'numerical'),
			array('nokode_rumahsakit, jenispemeriksaanlab_kode, pemeriksaanlab_kode', 'length', 'max'=>10),
			array('nama_rumahsakit, jenispemeriksaanlab_kelompok', 'length', 'max'=>100),
			array('jenispemeriksaanlab_nama', 'length', 'max'=>30),
			array('pemeriksaanlab_nama', 'length', 'max'=>500),
			array('daftartindakan_nama', 'length', 'max'=>200),
			array('jumlah', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tahun, profilrs_id, nokode_rumahsakit, nama_rumahsakit, jenispemeriksaanlab_id, jenispemeriksaanlab_kelompok, jenispemeriksaanlab_kode, jenispemeriksaanlab_nama, jenispemeriksaanlab_urutan, pemeriksaanlab_id, pemeriksaanlab_kode, pemeriksaanlab_nama, pemeriksaanlab_urutan, daftartindakan_id, daftartindakan_nama, jumlah', 'safe', 'on'=>'search'),
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
			'tahun' => 'Tahun',
			'profilrs_id' => 'Profilrs',
			'nokode_rumahsakit' => 'Nokode Rumahsakit',
			'nama_rumahsakit' => 'Nama Rumahsakit',
			'jenispemeriksaanlab_id' => 'Jenispemeriksaanlab',
			'jenispemeriksaanlab_kelompok' => 'Jenispemeriksaanlab Kelompok',
			'jenispemeriksaanlab_kode' => 'Jenispemeriksaanlab Kode',
			'jenispemeriksaanlab_nama' => 'Jenispemeriksaanlab Nama',
			'jenispemeriksaanlab_urutan' => 'Jenispemeriksaanlab Urutan',
			'pemeriksaanlab_id' => 'Pemeriksaanlab',
			'pemeriksaanlab_kode' => 'Pemeriksaanlab Kode',
			'pemeriksaanlab_nama' => 'Pemeriksaanlab Nama',
			'pemeriksaanlab_urutan' => 'Pemeriksaanlab Urutan',
			'daftartindakan_id' => 'Daftartindakan',
			'daftartindakan_nama' => 'Nama Daftar Tindakan',
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

		$criteria->compare('tahun',$this->tahun);
		$criteria->compare('profilrs_id',$this->profilrs_id);
		$criteria->compare('nokode_rumahsakit',$this->nokode_rumahsakit,true);
		$criteria->compare('nama_rumahsakit',$this->nama_rumahsakit,true);
		$criteria->compare('jenispemeriksaanlab_id',$this->jenispemeriksaanlab_id);
		$criteria->compare('jenispemeriksaanlab_kelompok',$this->jenispemeriksaanlab_kelompok,true);
		$criteria->compare('jenispemeriksaanlab_kode',$this->jenispemeriksaanlab_kode,true);
		$criteria->compare('jenispemeriksaanlab_nama',$this->jenispemeriksaanlab_nama,true);
		$criteria->compare('jenispemeriksaanlab_urutan',$this->jenispemeriksaanlab_urutan);
		$criteria->compare('pemeriksaanlab_id',$this->pemeriksaanlab_id);
		$criteria->compare('pemeriksaanlab_kode',$this->pemeriksaanlab_kode,true);
		$criteria->compare('pemeriksaanlab_nama',$this->pemeriksaanlab_nama,true);
		$criteria->compare('pemeriksaanlab_urutan',$this->pemeriksaanlab_urutan);
		$criteria->compare('daftartindakan_id',$this->daftartindakan_id);
		$criteria->compare('daftartindakan_nama',$this->daftartindakan_nama,true);
		$criteria->compare('jumlah',$this->jumlah,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}               
}