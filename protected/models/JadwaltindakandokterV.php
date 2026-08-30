<?php

/**
 * This is the model class for table "jadwaltindakandokter_v".
 *
 * The followings are the available columns in table 'jadwaltindakandokter_v':
 * @property integer $tindakandokter_id
 * @property integer $daftartindakan_id
 * @property string $daftartindakan_kode
 * @property string $daftartindakan_nama
 * @property string $waktutindakan
 * @property integer $pegawai_id
 * @property integer $profilrs_id
 * @property string $gelardepan
 * @property string $nama_pegawai
 * @property integer $gelarbelakang_id
 * @property integer $instalasi_id
 * @property integer $ruangan_id
 * @property string $jadwaldokter_tgl
 * @property string $jadwaldokter_hari
 * @property string $jadwaldokter_buka
 * @property string $jadwaldokter_mulai
 * @property string $jadwaldokter_tutup
 * @property integer $maximumantrian
 * @property integer $maksbuatjanji
 */
class JadwaltindakandokterV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JadwaltindakandokterV the static model class
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
		return 'jadwaltindakandokter_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tindakandokter_id, daftartindakan_id, pegawai_id, profilrs_id, gelarbelakang_id, instalasi_id, ruangan_id, maximumantrian, maksbuatjanji', 'numerical', 'integerOnly'=>true),
			array('daftartindakan_kode, jadwaldokter_hari', 'length', 'max'=>20),
			array('daftartindakan_nama', 'length', 'max'=>200),
			array('waktutindakan', 'length', 'max'=>30),
			array('gelardepan', 'length', 'max'=>10),
			array('nama_pegawai, jadwaldokter_buka', 'length', 'max'=>50),
			array('jadwaldokter_tgl, jadwaldokter_mulai, jadwaldokter_tutup', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tindakandokter_id, daftartindakan_id, daftartindakan_kode, daftartindakan_nama, waktutindakan, pegawai_id, profilrs_id, gelardepan, nama_pegawai, gelarbelakang_id, instalasi_id, ruangan_id, jadwaldokter_tgl, jadwaldokter_hari, jadwaldokter_buka, jadwaldokter_mulai, jadwaldokter_tutup, maximumantrian, maksbuatjanji', 'safe', 'on'=>'search'),
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
			'tindakandokter_id' => 'Tindakandokter',
			'daftartindakan_id' => 'Daftartindakan',
			'daftartindakan_kode' => 'Daftartindakan Kode',
			'daftartindakan_nama' => 'Daftartindakan Nama',
			'waktutindakan' => 'Waktutindakan',
			'pegawai_id' => 'Pegawai',
			'profilrs_id' => 'Profilrs',
			'gelardepan' => 'Gelardepan',
			'nama_pegawai' => 'Nama Pegawai',
			'gelarbelakang_id' => 'Gelarbelakang',
			'instalasi_id' => 'Instalasi',
			'ruangan_id' => 'Ruangan',
			'jadwaldokter_tgl' => 'Jadwaldokter Tgl',
			'jadwaldokter_hari' => 'Jadwaldokter Hari',
			'jadwaldokter_buka' => 'Jadwaldokter Buka',
			'jadwaldokter_mulai' => 'Jadwaldokter Mulai',
			'jadwaldokter_tutup' => 'Jadwaldokter Tutup',
			'maximumantrian' => 'Maximumantrian',
			'maksbuatjanji' => 'Maksbuatjanji',
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

		$criteria->compare('tindakandokter_id',$this->tindakandokter_id);
		$criteria->compare('daftartindakan_id',$this->daftartindakan_id);
		$criteria->compare('daftartindakan_kode',$this->daftartindakan_kode,true);
		$criteria->compare('daftartindakan_nama',$this->daftartindakan_nama,true);
		$criteria->compare('waktutindakan',$this->waktutindakan,true);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('profilrs_id',$this->profilrs_id);
		$criteria->compare('gelardepan',$this->gelardepan,true);
		$criteria->compare('nama_pegawai',$this->nama_pegawai,true);
		$criteria->compare('gelarbelakang_id',$this->gelarbelakang_id);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('jadwaldokter_tgl',$this->jadwaldokter_tgl,true);
		$criteria->compare('jadwaldokter_hari',$this->jadwaldokter_hari,true);
		$criteria->compare('jadwaldokter_buka',$this->jadwaldokter_buka,true);
		$criteria->compare('jadwaldokter_mulai',$this->jadwaldokter_mulai,true);
		$criteria->compare('jadwaldokter_tutup',$this->jadwaldokter_tutup,true);
		$criteria->compare('maximumantrian',$this->maximumantrian);
		$criteria->compare('maksbuatjanji',$this->maksbuatjanji);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}