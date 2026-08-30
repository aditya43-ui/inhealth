<?php

/**
 * This is the model class for table "pelayanankerohanian_t".
 *
 * The followings are the available columns in table 'pelayanankerohanian_t':
 * @property integer $pelayanankerohanian_id
 * @property integer $pendaftaran_id
 * @property integer $pasienadmisi_id
 * @property integer $ruangan_id
 * @property string $agama
 * @property string $tgl_permintaan
 * @property string $bentuk_layanan
 * @property string $petugas_kerohanian
 * @property string $tgl_kedatangan_petugas
 * @property integer $no_hp
 * @property string $petugas_bertanggungjawab
 * @property integer $petugas_id
 * @property string $penerima_informasi
 * @property string $nama_penerima
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai
 * @property integer $update_loginpemakai
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property PendaftaranT $pendaftaran
 * @property PasienadmisiT $pasienadmisi
 */
class PelayanankerohanianT extends CActiveRecord
{
	public $petugas_nama, $petugas_kerohanian_id;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PelayanankerohanianT the static model class
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
		return 'pelayanankerohanian_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendaftaran_id, agama, tgl_permintaan, create_time, create_loginpemakai, create_ruangan', 'required'),
			array('pendaftaran_id, pasienadmisi_id, ruangan_id, no_hp, petugas_id, create_loginpemakai, update_loginpemakai, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('agama, petugas_bertanggungjawab, penerima_informasi', 'length', 'max'=>100),
			array('petugas_kerohanian, nama_penerima', 'length', 'max'=>200),
			array('bentuk_layanan, tgl_kedatangan_petugas, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pelayanankerohanian_id, pendaftaran_id, pasienadmisi_id, ruangan_id, agama, tgl_permintaan, bentuk_layanan, petugas_kerohanian, tgl_kedatangan_petugas, no_hp, petugas_bertanggungjawab, petugas_id, penerima_informasi, nama_penerima, create_time, update_time, create_loginpemakai, update_loginpemakai, create_ruangan', 'safe', 'on'=>'search'),
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
			'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
			'pasienadmisi' => array(self::BELONGS_TO, 'PasienadmisiT', 'pasienadmisi_id'),
			'ruangan' => array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
			'petugas' => array(self::BELONGS_TO, 'PegawaiM', 'petugas_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pelayanankerohanian_id' => 'Pelayanankerohanian',
			'pendaftaran_id' => 'Pendaftaran',
			'pasienadmisi_id' => 'Pasienadmisi',
			'ruangan_id' => 'Ruangan',
			'agama' => 'Agama',
			'tgl_permintaan' => 'Permintaan',
			'bentuk_layanan' => 'Bentuk Layanan',
			'petugas_kerohanian' => 'Nama Petugas Kerohanian',
			'tgl_kedatangan_petugas' => 'Tanggal Kedatangan Petugas',
			'no_hp' => 'No Telepon / Hp',
			'petugas_bertanggungjawab' => 'Petugas Yang Bertanggung Jawab',
			'petugas_id' => 'Nama Petugas',
			'penerima_informasi' => 'Penerima Informasi',
			'nama_penerima' => 'Nama Penerima',
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

		$criteria->compare('pelayanankerohanian_id',$this->pelayanankerohanian_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('agama',$this->agama,true);
		$criteria->compare('tgl_permintaan',$this->tgl_permintaan,true);
		$criteria->compare('bentuk_layanan',$this->bentuk_layanan,true);
		$criteria->compare('petugas_kerohanian',$this->petugas_kerohanian,true);
		$criteria->compare('tgl_kedatangan_petugas',$this->tgl_kedatangan_petugas,true);
		$criteria->compare('no_hp',$this->no_hp);
		$criteria->compare('petugas_bertanggungjawab',$this->petugas_bertanggungjawab,true);
		$criteria->compare('petugas_id',$this->petugas_id);
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

	public function searchRohani()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('pelayanankerohanian_id',$this->pelayanankerohanian_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('agama',$this->agama,true);
		if (isset($this->tgl_permintaan)){
			$criteria->addCondition("tgl_permintaan ='".$this->tgl_permintaan."'");
		}
		if (isset($this->tgl_kedatangan_petugas)){
			$criteria->addCondition("tgl_kedatangan_petugas ='".$this->tgl_kedatangan_petugas."'");
		}
		
		$criteria->compare('bentuk_layanan',$this->bentuk_layanan,true);
		$criteria->compare('petugas_kerohanian',$this->petugas_kerohanian,true);
		
		
		$criteria->compare('no_hp',$this->no_hp);
		$criteria->compare('petugas_bertanggungjawab',$this->petugas_bertanggungjawab,true);
		$criteria->compare('petugas_id',$this->petugas_id);
		$criteria->compare('penerima_informasi',$this->penerima_informasi,true);
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}