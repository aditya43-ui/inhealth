<?php

/**
 * This is the model class for table "rl3_5_kegiatanperinatologi_v".
 *
 * The followings are the available columns in table 'rl3_5_kegiatanperinatologi_v':
 * @property double $tahun
 * @property integer $profilrs_id
 * @property string $nokode_rumahsakit
 * @property string $nama_rumahsakit
 * @property integer $daftartindakan_id
 * @property string $daftartindakan_nama
 * @property double $rujukanrs
 * @property double $rujukanbidan
 * @property double $rujukanpuskesmas
 * @property double $rujukanfaskeslain
 * @property double $rujukanmedismati
 * @property double $totalrujukanmedis
 * @property double $rujukannonmedismati
 * @property double $totalrujukannonmedis
 * @property double $nonrujukanmati
 * @property double $totalnonrujukan
 * @property double $dirujukkeluar
 */
class Rl35KegiatanperinatologiV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Rl35KegiatanperinatologiV the static model class
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
		return 'rl3_5_kegiatanperinatologi_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('profilrs_id, daftartindakan_id', 'numerical', 'integerOnly'=>true),
			array('tahun, rujukanrs, rujukanbidan, rujukanpuskesmas, rujukanfaskeslain, rujukanmedismati, totalrujukanmedis, rujukannonmedismati, totalrujukannonmedis, nonrujukanmati, totalnonrujukan, dirujukkeluar', 'numerical'),
			array('nokode_rumahsakit', 'length', 'max'=>10),
			array('nama_rumahsakit', 'length', 'max'=>100),
			array('daftartindakan_nama', 'length', 'max'=>200),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tahun, profilrs_id, nokode_rumahsakit, nama_rumahsakit, daftartindakan_id, daftartindakan_nama, rujukanrs, rujukanbidan, rujukanpuskesmas, rujukanfaskeslain, rujukanmedismati, totalrujukanmedis, rujukannonmedismati, totalrujukannonmedis, nonrujukanmati, totalnonrujukan, dirujukkeluar', 'safe', 'on'=>'search'),
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
			'daftartindakan_id' => 'Daftartindakan',
			'daftartindakan_nama' => 'Nama Daftar Tindakan',
			'rujukanrs' => 'Rujukanrs',
			'rujukanbidan' => 'Rujukanbidan',
			'rujukanpuskesmas' => 'Rujukanpuskesmas',
			'rujukanfaskeslain' => 'Rujukanfaskeslain',
			'rujukanmedismati' => 'Rujukanmedismati',
			'totalrujukanmedis' => 'Totalrujukanmedis',
			'rujukannonmedismati' => 'Rujukannonmedismati',
			'totalrujukannonmedis' => 'Totalrujukannonmedis',
			'nonrujukanmati' => 'Nonrujukanmati',
			'totalnonrujukan' => 'Totalnonrujukan',
			'dirujukkeluar' => 'Dirujukkeluar',
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
		$criteria->compare('daftartindakan_id',$this->daftartindakan_id);
		$criteria->compare('daftartindakan_nama',$this->daftartindakan_nama,true);
		$criteria->compare('rujukanrs',$this->rujukanrs);
		$criteria->compare('rujukanbidan',$this->rujukanbidan);
		$criteria->compare('rujukanpuskesmas',$this->rujukanpuskesmas);
		$criteria->compare('rujukanfaskeslain',$this->rujukanfaskeslain);
		$criteria->compare('rujukanmedismati',$this->rujukanmedismati);
		$criteria->compare('totalrujukanmedis',$this->totalrujukanmedis);
		$criteria->compare('rujukannonmedismati',$this->rujukannonmedismati);
		$criteria->compare('totalrujukannonmedis',$this->totalrujukannonmedis);
		$criteria->compare('nonrujukanmati',$this->nonrujukanmati);
		$criteria->compare('totalnonrujukan',$this->totalnonrujukan);
		$criteria->compare('dirujukkeluar',$this->dirujukkeluar);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}