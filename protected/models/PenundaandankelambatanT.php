<?php

/**
 * This is the model class for table "penundaandankelambatan_t".
 *
 * The followings are the available columns in table 'penundaandankelambatan_t':
 * @property integer $penundaandankelambatan_id
 * @property integer $pendaftaran_id
 * @property integer $pasienadmisi_id
 * @property string $tanggal_pengisian
 * @property string $pukul
 * @property string $unit
 * @property string $pelayanantindakan
 * @property string $alasanpenundaan
 * @property string $solusialternatif
 * @property string $pemberi_informasi
 * @property string $petugas_id
 * @property string $penerima_informasi
 * @property string $nama_penerima
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai
 * @property integer $update_loginpemakai
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property PasienadmisiT $pasienadmisi
 * @property PendaftaranT $pendaftaran
 */
class PenundaandankelambatanT extends CActiveRecord
{
	public $petugas_nama;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PenundaandankelambatanT the static model class
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
		return 'penundaandankelambatan_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendaftaran_id, tanggal_pengisian, pukul, unit, pemberi_informasi, petugas_id, create_time, create_loginpemakai, create_ruangan', 'required'),
			array('pendaftaran_id, pasienadmisi_id, create_loginpemakai, update_loginpemakai, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('unit', 'length', 'max'=>50),
			array('pemberi_informasi, penerima_informasi', 'length', 'max'=>100),
			array('petugas_id, nama_penerima', 'length', 'max'=>200),
			array('pelayanantindakan, alasanpenundaan, solusialternatif, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('penundaandankelambatan_id, pendaftaran_id, pasienadmisi_id, tanggal_pengisian, pukul, unit, pelayanantindakan, alasanpenundaan, solusialternatif, pemberi_informasi, petugas_id, penerima_informasi, nama_penerima, create_time, update_time, create_loginpemakai, update_loginpemakai, create_ruangan', 'safe', 'on'=>'search'),
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
			'pasienadmisi' => array(self::BELONGS_TO, 'PasienadmisiT', 'pasienadmisi_id'),
			'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
			'petugas' => array(self::BELONGS_TO, 'PegawaiM', 'petugas_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'penundaandankelambatan_id' => 'Penundaandankelambatan',
			'pendaftaran_id' => 'Pendaftaran',
			'pasienadmisi_id' => 'Pasienadmisi',
			'tanggal_pengisian' => 'Tanggal Pengisian',
			'pukul' => 'Pukul',
			'unit' => 'Unit',
			'pelayanantindakan' => 'Pelayanantindakan',
			'alasanpenundaan' => 'Alasanpenundaan',
			'solusialternatif' => 'Solusialternatif',
			'pemberi_informasi' => 'Pemberi Informasi',
			'petugas_id' => 'Nama',
			'penerima_informasi' => 'Penerima Informasi',
			'nama_penerima' => 'Nama',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai' => 'Create Loginpemakai',
			'update_loginpemakai' => 'Update Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
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

		$criteria->compare('penundaandankelambatan_id',$this->penundaandankelambatan_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('tanggal_pengisian',$this->tanggal_pengisian,true);
		$criteria->compare('pukul',$this->pukul,true);
		$criteria->compare('unit',$this->unit,true);
		$criteria->compare('pelayanantindakan',$this->pelayanantindakan,true);
		$criteria->compare('alasanpenundaan',$this->alasanpenundaan,true);
		$criteria->compare('solusialternatif',$this->solusialternatif,true);
		$criteria->compare('pemberi_informasi',$this->pemberi_informasi,true);
		$criteria->compare('petugas_id',$this->petugas_id,true);
		$criteria->compare('penerima_informasi',$this->penerima_informasi,true);
		$criteria->compare('nama_penerima',$this->nama_penerima,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai',$this->create_loginpemakai);
		$criteria->compare('update_loginpemakai',$this->update_loginpemakai);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchPasien()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}