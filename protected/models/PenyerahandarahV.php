<?php

/**
 * This is the model class for table "penyerahandarah_v".
 *
 * The followings are the available columns in table 'penyerahandarah_v':
 * @property integer $penyerahandarah_id
 * @property integer $pendaftaran_id
 * @property string $no_pendaftaran
 * @property string $no_rekam_medik
 * @property string $nama_pasien
 * @property integer $penyiapandarah_id
 * @property integer $ujikompatibilitas_id
 * @property string $rilis
 * @property integer $stokkantongdarah_id
 * @property string $nama_jenis
 * @property string $namakomponendrh
 * @property string $singkatan_komp
 * @property integer $kantongdarah_id
 * @property string $no_kantongdarah
 * @property string $periksakomponendarah_id
 * @property integer $volume
 */
class PenyerahandarahV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PenyerahandarahV the static model class
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
		return 'penyerahandarah_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('penyerahandarah_id, pendaftaran_id, penyiapandarah_id, ujikompatibilitas_id, stokkantongdarah_id, kantongdarah_id, volume', 'numerical', 'integerOnly'=>true),
			array('no_pendaftaran', 'length', 'max'=>20),
			array('no_rekam_medik', 'length', 'max'=>10),
			array('nama_pasien, rilis', 'length', 'max'=>50),
			array('nama_jenis', 'length', 'max'=>255),
			array('namakomponendrh, no_kantongdarah', 'length', 'max'=>100),
			array('singkatan_komp', 'length', 'max'=>5),
			array('periksakomponendarah_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('penyerahandarah_id, pendaftaran_id, no_pendaftaran, no_rekam_medik, nama_pasien, penyiapandarah_id, ujikompatibilitas_id, rilis, stokkantongdarah_id, nama_jenis, namakomponendrh, singkatan_komp, kantongdarah_id, no_kantongdarah, periksakomponendarah_id, volume', 'safe', 'on'=>'search'),
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
			'penyerahandarah_id' => 'Penyerahandarah',
			'pendaftaran_id' => 'Pendaftaran',
			'no_pendaftaran' => 'No Pendaftaran',
			'no_rekam_medik' => 'No Rekam Medik',
			'nama_pasien' => 'Nama Pasien',
			'penyiapandarah_id' => 'Penyiapandarah',
			'ujikompatibilitas_id' => 'Ujikompatibilitas',
			'rilis' => 'Rilis',
			'stokkantongdarah_id' => 'Stokkantongdarah',
			'nama_jenis' => 'Nama Jenis',
			'namakomponendrh' => 'Namakomponendrh',
			'singkatan_komp' => 'Singkatan Komp',
			'kantongdarah_id' => 'Kantongdarah',
			'no_kantongdarah' => 'No Kantongdarah',
			'periksakomponendarah_id' => 'Periksakomponendarah',
			'volume' => 'Volume',
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

		$criteria->compare('penyerahandarah_id',$this->penyerahandarah_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('no_pendaftaran',$this->no_pendaftaran,true);
		$criteria->compare('no_rekam_medik',$this->no_rekam_medik,true);
		$criteria->compare('nama_pasien',$this->nama_pasien,true);
		$criteria->compare('penyiapandarah_id',$this->penyiapandarah_id);
		$criteria->compare('ujikompatibilitas_id',$this->ujikompatibilitas_id);
		$criteria->compare('rilis',$this->rilis,true);
		$criteria->compare('stokkantongdarah_id',$this->stokkantongdarah_id);
		$criteria->compare('nama_jenis',$this->nama_jenis,true);
		$criteria->compare('namakomponendrh',$this->namakomponendrh,true);
		$criteria->compare('singkatan_komp',$this->singkatan_komp,true);
		$criteria->compare('kantongdarah_id',$this->kantongdarah_id);
		$criteria->compare('no_kantongdarah',$this->no_kantongdarah,true);
		$criteria->compare('periksakomponendarah_id',$this->periksakomponendarah_id,true);
		$criteria->compare('volume',$this->volume);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}