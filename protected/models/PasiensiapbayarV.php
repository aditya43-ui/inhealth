<?php

/**
 * This is the model class for table "pasiensiapbayar_v".
 *
 * The followings are the available columns in table 'pasiensiapbayar_v':
 * @property integer $pendaftaran_idx
 * @property string $no_pendaftaran
 * @property string $tgl_pendaftaran
 * @property string $umur
 * @property string $ruangan_nama
 * @property integer $ruangan_id
 * @property string $instalasi_nama
 * @property integer $instalasi_id
 * @property string $nama_pasien
 * @property string $no_rekam_medik
 */
class PasiensiapbayarV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PasiensiapbayarV the static model class
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
		return 'pasiensiapbayar_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendaftaran_idx, ruangan_id, instalasi_id', 'numerical', 'integerOnly'=>true),
			array('no_pendaftaran', 'length', 'max'=>20),
			array('umur', 'length', 'max'=>30),
			array('ruangan_nama, instalasi_nama, nama_pasien', 'length', 'max'=>50),
			array('no_rekam_medik', 'length', 'max'=>10),
			array('tgl_pendaftaran', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pendaftaran_idx, no_pendaftaran, tgl_pendaftaran, umur, ruangan_nama, ruangan_id, instalasi_nama, instalasi_id, nama_pasien, no_rekam_medik', 'safe', 'on'=>'search'),
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
			'pendaftaran_idx' => 'Pendaftaran Idx',
			'no_pendaftaran' => 'No. Pendaftaran',
			'tgl_pendaftaran' => 'Tanggal Pendaftaran',
			'umur' => 'Umur',
			'ruangan_nama' => 'Ruangan Nama',
			'ruangan_id' => 'Ruangan',
			'instalasi_nama' => 'Instalasi Nama',
			'instalasi_id' => 'Instalasi',
			'nama_pasien' => 'Nama Pasien',
			'no_rekam_medik' => 'No. Rekam Medik',
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

		$criteria->compare('pendaftaran_idx',$this->pendaftaran_idx);
		$criteria->compare('no_pendaftaran',$this->no_pendaftaran,true);
		$criteria->compare('tgl_pendaftaran',$this->tgl_pendaftaran,true);
		$criteria->compare('umur',$this->umur,true);
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('instalasi_nama',$this->instalasi_nama,true);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('nama_pasien',$this->nama_pasien,true);
		$criteria->compare('no_rekam_medik',$this->no_rekam_medik,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}