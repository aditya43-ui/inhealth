<?php

/**
 * This is the model class for table "rekonobatalergi_t".
 *
 * The followings are the available columns in table 'rekonobatalergi_t':
 * @property integer $rekonobatalergi_id
 * @property integer $pendaftaran_id
 * @property integer $pasien_id
 * @property string $tanggal_pengisian
 * @property integer $petugas_id
 * @property string $nama_obat
 * @property string $reaksialergi
 * @property string $bentukreaksi
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai
 * @property string $update_loginpemakai
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property PegawaiM $petugas
 * @property PasienM $pasien
 * @property PendaftaranT $pendaftaran
 */
class RekonobatalergiT extends CActiveRecord
{
	public $petugas_nama;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RekonobatalergiT the static model class
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
		return 'rekonobatalergi_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendaftaran_id, pasien_id, tanggal_pengisian, petugas_id, create_time, create_loginpemakai', 'required'),
			array('pendaftaran_id, pasien_id, petugas_id, create_ruangan, pasienadmisi_id', 'numerical', 'integerOnly'=>true),
			array('nama_obat, create_loginpemakai, update_loginpemakai', 'length', 'max'=>100),
			array('reaksialergi', 'length', 'max'=>50),
			array('bentukreaksi', 'length', 'max'=>200),
			array('update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('rekonobatalergi_id, pendaftaran_id, pasien_id, tanggal_pengisian, petugas_id, nama_obat, reaksialergi, bentukreaksi, create_time, update_time, create_loginpemakai, update_loginpemakai, create_ruangan, pasienadmisi_id', 'safe', 'on'=>'search'),
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
			'petugas' => array(self::BELONGS_TO, 'PegawaiM', 'petugas_id'),
			'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
			'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'rekonobatalergi_id' => 'Rekonobatalergi',
			'pendaftaran_id' => 'Pendaftaran',
			'pasien_id' => 'Pasien',
			'tanggal_pengisian' => 'Tanggal Pengisian',
			'petugas_id' => 'Petugas Pengisi',
			'nama_obat' => 'Nama Obat',
			'reaksialergi' => 'Reaksi Alergi',
			'bentukreaksi' => 'Bentuk Reaksi',
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

		$criteria->compare('rekonobatalergi_id',$this->rekonobatalergi_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('tanggal_pengisian',$this->tanggal_pengisian,true);
		$criteria->compare('petugas_id',$this->petugas_id);
		$criteria->compare('nama_obat',$this->nama_obat,true);
		$criteria->compare('reaksialergi',$this->reaksialergi,true);
		$criteria->compare('bentukreaksi',$this->bentukreaksi,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai',$this->create_loginpemakai,true);
		$criteria->compare('update_loginpemakai',$this->update_loginpemakai,true);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchRiwayat()
	{
		$criteria = new CDbCriteria;

		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}

		if(!empty($this->pasienadmisi_id)){
			$criteria->addCondition('pasienadmisi_id = '.$this->pasienadmisi_id);
		}

		if(!empty($this->create_ruangan)){
			$criteria->addCondition('create_ruangan = '.$this->create_ruangan);
		}

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
