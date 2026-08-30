<?php

/**
 * This is the model class for table "informasiorderbatalalokasi_v".
 *
 * The followings are the available columns in table 'informasiorderbatalalokasi_v':
 * @property integer $orderbatalalokasi_id
 * @property integer $alokasidana_id
 * @property integer $pendaftaran_id
 * @property string $no_pendaftaran
 * @property string $tgl_pendaftaran
 * @property integer $pasien_id
 * @property string $nama_pasien
 * @property string $no_rekam_medik
 * @property string $tanggal_lahir
 * @property string $jeniskelamin
 * @property string $alamat_pasien
 * @property integer $carabayar_id
 * @property string $carabayar_nama
 * @property integer $penjamin_id
 * @property string $penjamin_nama
 * @property string $create_time
 * @property string $create_loginpemakai
 * @property integer $petugas_id
 * @property string $nama_petugas
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $pegawai_id
 * @property string $gelardepan
 * @property string $nama_pegawai
 * @property string $gelarbelakang_nama
 */
class InformasiorderbatalalokasiV extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'informasiorderbatalalokasi_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('orderbatalalokasi_id, alokasidana_id, pendaftaran_id, pasien_id, carabayar_id, penjamin_id, petugas_id, instalasi_id, ruangan_id, pegawai_id', 'numerical', 'integerOnly'=>true),
			array('no_pendaftaran, jeniskelamin', 'length', 'max'=>20),
			array('nama_pasien, penjamin_nama, instalasi_nama, ruangan_nama', 'length', 'max'=>100),
			array('no_rekam_medik, gelardepan', 'length', 'max'=>10),
			array('carabayar_nama, nama_petugas, nama_pegawai', 'length', 'max'=>50),
			array('create_loginpemakai', 'length', 'max'=>255),
			array('gelarbelakang_nama', 'length', 'max'=>15),
			array('tgl_pendaftaran, tanggal_lahir, alamat_pasien, create_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('orderbatalalokasi_id, alokasidana_id, pendaftaran_id, no_pendaftaran, tgl_pendaftaran, pasien_id, nama_pasien, no_rekam_medik, tanggal_lahir, jeniskelamin, alamat_pasien, carabayar_id, carabayar_nama, penjamin_id, penjamin_nama, create_time, create_loginpemakai, petugas_id, nama_petugas, instalasi_id, instalasi_nama, ruangan_id, ruangan_nama, pegawai_id, gelardepan, nama_pegawai, gelarbelakang_nama', 'safe', 'on'=>'search'),
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
			'orderbatalalokasi_id' => 'Orderbatalalokasi',
			'alokasidana_id' => 'Alokasidana',
			'pendaftaran_id' => 'Pendaftaran',
			'no_pendaftaran' => 'No Pendaftaran',
			'tgl_pendaftaran' => 'Tgl Pendaftaran',
			'pasien_id' => 'Pasien',
			'nama_pasien' => 'Nama Pasien',
			'no_rekam_medik' => 'No Rekam Medik',
			'tanggal_lahir' => 'Tanggal Lahir',
			'jeniskelamin' => 'Jeniskelamin',
			'alamat_pasien' => 'Alamat Pasien',
			'carabayar_id' => 'Jenis Penjamin',
			'carabayar_nama' => 'Carabayar Nama',
			'penjamin_id' => 'Penjamin',
			'penjamin_nama' => 'Penjamin Nama',
			'create_time' => 'Create Time',
			'create_loginpemakai' => 'Create Loginpemakai',
			'petugas_id' => 'Petugas',
			'nama_petugas' => 'Petugas',
			'instalasi_id' => 'Instalasi',
			'instalasi_nama' => 'Instalasi Nama',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
			'pegawai_id' => 'Pegawai',
			'gelardepan' => 'Gelardepan',
			'nama_pegawai' => 'Nama Pegawai',
			'gelarbelakang_nama' => 'Gelarbelakang Nama',
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

		$criteria->compare('orderbatalalokasi_id',$this->orderbatalalokasi_id);
		$criteria->compare('alokasidana_id',$this->alokasidana_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('no_pendaftaran',$this->no_pendaftaran,true);
		$criteria->compare('tgl_pendaftaran',$this->tgl_pendaftaran,true);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('nama_pasien',$this->nama_pasien,true);
		$criteria->compare('no_rekam_medik',$this->no_rekam_medik,true);
		$criteria->compare('tanggal_lahir',$this->tanggal_lahir,true);
		$criteria->compare('jeniskelamin',$this->jeniskelamin,true);
		$criteria->compare('alamat_pasien',$this->alamat_pasien,true);
		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('carabayar_nama',$this->carabayar_nama,true);
		$criteria->compare('penjamin_id',$this->penjamin_id);
		$criteria->compare('penjamin_nama',$this->penjamin_nama,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('create_loginpemakai',$this->create_loginpemakai,true);
		$criteria->compare('petugas_id',$this->petugas_id);
		$criteria->compare('nama_petugas',$this->nama_petugas,true);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('instalasi_nama',$this->instalasi_nama,true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('gelardepan',$this->gelardepan,true);
		$criteria->compare('nama_pegawai',$this->nama_pegawai,true);
		$criteria->compare('gelarbelakang_nama',$this->gelarbelakang_nama,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return InformasiorderbatalalokasiV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
