<?php

/**
 * This is the model class for table "pasienkirimkeunitlaindetail_v".
 *
 * The followings are the available columns in table 'pasienkirimkeunitlaindetail_v':
 * @property integer $pasienkirimkeunitlain_id
 * @property string $no_rekam_medik
 * @property string $namadepan
 * @property string $nama_pasien
 * @property string $nama_bin
 * @property string $jeniskelamin
 * @property string $tempat_lahir
 * @property string $tanggal_lahir
 * @property string $alamat_pasien
 * @property string $agama
 * @property string $golongandarah
 * @property string $rhesus
 * @property string $tgl_kirimpasien
 * @property string $nourut
 * @property integer $pendaftaran_id
 * @property string $no_pendaftaran
 * @property string $tgl_pendaftaran
 * @property integer $jeniskasuspenyakit_id
 * @property string $jeniskasuspenyakit_nama
 * @property integer $carabayar_id
 * @property string $carabayar_nama
 * @property integer $penjamin_id
 * @property string $penjamin_nama
 * @property integer $kelaspelayanan_id
 * @property string $kelaspelayanan_nama
 * @property integer $pegawai_id
 * @property string $gelardepan
 * @property string $nama_pegawai
 * @property integer $gelarbelakang_id
 * @property string $gelarbelakang_nama
 * @property string $catatandokterpengirim
 * @property integer $ruanganasal_m
 * @property string $ruanganasal_nama
 * @property integer $instalasiasal_id
 * @property string $instalasiasal_nama
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $instalasi_id
 * @property integer $pasienmasukpenunjang_id
 * @property string $create_time
 * @property string $create_loginpemakai_id
 * @property integer $permintaankepenunjang_id
 * @property integer $pemeriksaanlab_id
 * @property string $pemeriksaanlab_nama
 * @property integer $daftartindakanlab_id
 * @property integer $pemeriksaanrad_id
 * @property string $pemeriksaanrad_nama
 * @property integer $daftartindakanrad_id
 * @property integer $qtypermintaan
 * @property string $noperminatanpenujang
 * @property string $tglpermintaankepenunjang
 */
class PasienkirimkeunitlaindetailV extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'pasienkirimkeunitlaindetail_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasienkirimkeunitlain_id, pendaftaran_id, jeniskasuspenyakit_id, carabayar_id, penjamin_id, kelaspelayanan_id, pegawai_id, gelarbelakang_id, ruanganasal_m, instalasiasal_id, ruangan_id, instalasi_id, pasienmasukpenunjang_id, permintaankepenunjang_id, pemeriksaanlab_id, daftartindakanlab_id, pemeriksaanrad_id, daftartindakanrad_id, qtypermintaan', 'numerical', 'integerOnly'=>true),
			array('no_rekam_medik, gelardepan', 'length', 'max'=>10),
			array('namadepan, jeniskelamin, agama, rhesus, no_pendaftaran', 'length', 'max'=>20),
			array('nama_pasien, nama_bin, carabayar_nama, kelaspelayanan_nama, nama_pegawai, ruanganasal_nama, instalasiasal_nama, ruangan_nama, noperminatanpenujang', 'length', 'max'=>50),
			array('tempat_lahir', 'length', 'max'=>25),
			array('golongandarah', 'length', 'max'=>2),
			array('nourut', 'length', 'max'=>3),
			array('jeniskasuspenyakit_nama, penjamin_nama, pemeriksaanrad_nama', 'length', 'max'=>100),
			array('gelarbelakang_nama', 'length', 'max'=>15),
			array('pemeriksaanlab_nama', 'length', 'max'=>500),
			array('tanggal_lahir, alamat_pasien, tgl_kirimpasien, tgl_pendaftaran, catatandokterpengirim, create_time, create_loginpemakai_id, tglpermintaankepenunjang', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('pasienkirimkeunitlain_id, no_rekam_medik, namadepan, nama_pasien, nama_bin, jeniskelamin, tempat_lahir, tanggal_lahir, alamat_pasien, agama, golongandarah, rhesus, tgl_kirimpasien, nourut, pendaftaran_id, no_pendaftaran, tgl_pendaftaran, jeniskasuspenyakit_id, jeniskasuspenyakit_nama, carabayar_id, carabayar_nama, penjamin_id, penjamin_nama, kelaspelayanan_id, kelaspelayanan_nama, pegawai_id, gelardepan, nama_pegawai, gelarbelakang_id, gelarbelakang_nama, catatandokterpengirim, ruanganasal_m, ruanganasal_nama, instalasiasal_id, instalasiasal_nama, ruangan_id, ruangan_nama, instalasi_id, pasienmasukpenunjang_id, create_time, create_loginpemakai_id, permintaankepenunjang_id, pemeriksaanlab_id, pemeriksaanlab_nama, daftartindakanlab_id, pemeriksaanrad_id, pemeriksaanrad_nama, daftartindakanrad_id, qtypermintaan, noperminatanpenujang, tglpermintaankepenunjang', 'safe', 'on'=>'search'),
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
			'pasienkirimkeunitlain_id' => 'Pasienkirimkeunitlain',
			'no_rekam_medik' => 'No Rekam Medik',
			'namadepan' => 'Namadepan',
			'nama_pasien' => 'Nama Pasien',
			'nama_bin' => 'Nama Bin',
			'jeniskelamin' => 'Jeniskelamin',
			'tempat_lahir' => 'Tempat Lahir',
			'tanggal_lahir' => 'Tanggal Lahir',
			'alamat_pasien' => 'Alamat Pasien',
			'agama' => 'Agama',
			'golongandarah' => 'Golongandarah',
			'rhesus' => 'Rhesus',
			'tgl_kirimpasien' => 'Tgl Kirimpasien',
			'nourut' => 'Nourut',
			'pendaftaran_id' => 'Pendaftaran',
			'no_pendaftaran' => 'No Pendaftaran',
			'tgl_pendaftaran' => 'Tgl Pendaftaran',
			'jeniskasuspenyakit_id' => 'Jeniskasuspenyakit',
			'jeniskasuspenyakit_nama' => 'Jeniskasuspenyakit Nama',
			'carabayar_id' => 'Carabayar',
			'carabayar_nama' => 'Carabayar Nama',
			'penjamin_id' => 'Penjamin',
			'penjamin_nama' => 'Penjamin Nama',
			'kelaspelayanan_id' => 'Kelaspelayanan',
			'kelaspelayanan_nama' => 'Kelaspelayanan Nama',
			'pegawai_id' => 'Pegawai',
			'gelardepan' => 'Gelardepan',
			'nama_pegawai' => 'Nama Pegawai',
			'gelarbelakang_id' => 'Gelarbelakang',
			'gelarbelakang_nama' => 'Gelarbelakang Nama',
			'catatandokterpengirim' => 'Catatandokterpengirim',
			'ruanganasal_m' => 'Ruanganasal M',
			'ruanganasal_nama' => 'Ruanganasal Nama',
			'instalasiasal_id' => 'Instalasiasal',
			'instalasiasal_nama' => 'Instalasiasal Nama',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
			'instalasi_id' => 'Instalasi',
			'pasienmasukpenunjang_id' => 'Pasienmasukpenunjang',
			'create_time' => 'Create Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'permintaankepenunjang_id' => 'Permintaankepenunjang',
			'pemeriksaanlab_id' => 'Pemeriksaanlab',
			'pemeriksaanlab_nama' => 'Pemeriksaanlab Nama',
			'daftartindakanlab_id' => 'Daftartindakanlab',
			'pemeriksaanrad_id' => 'Pemeriksaanrad',
			'pemeriksaanrad_nama' => 'Pemeriksaanrad Nama',
			'daftartindakanrad_id' => 'Daftartindakanrad',
			'qtypermintaan' => 'Qtypermintaan',
			'noperminatanpenujang' => 'Noperminatanpenujang',
			'tglpermintaankepenunjang' => 'Tglpermintaankepenunjang',
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

		$criteria->compare('pasienkirimkeunitlain_id',$this->pasienkirimkeunitlain_id);
		$criteria->compare('no_rekam_medik',$this->no_rekam_medik,true);
		$criteria->compare('namadepan',$this->namadepan,true);
		$criteria->compare('nama_pasien',$this->nama_pasien,true);
		$criteria->compare('nama_bin',$this->nama_bin,true);
		$criteria->compare('jeniskelamin',$this->jeniskelamin,true);
		$criteria->compare('tempat_lahir',$this->tempat_lahir,true);
		$criteria->compare('tanggal_lahir',$this->tanggal_lahir,true);
		$criteria->compare('alamat_pasien',$this->alamat_pasien,true);
		$criteria->compare('agama',$this->agama,true);
		$criteria->compare('golongandarah',$this->golongandarah,true);
		$criteria->compare('rhesus',$this->rhesus,true);
		$criteria->compare('tgl_kirimpasien',$this->tgl_kirimpasien,true);
		$criteria->compare('nourut',$this->nourut,true);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('no_pendaftaran',$this->no_pendaftaran,true);
		$criteria->compare('tgl_pendaftaran',$this->tgl_pendaftaran,true);
		$criteria->compare('jeniskasuspenyakit_id',$this->jeniskasuspenyakit_id);
		$criteria->compare('jeniskasuspenyakit_nama',$this->jeniskasuspenyakit_nama,true);
		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('carabayar_nama',$this->carabayar_nama,true);
		$criteria->compare('penjamin_id',$this->penjamin_id);
		$criteria->compare('penjamin_nama',$this->penjamin_nama,true);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('kelaspelayanan_nama',$this->kelaspelayanan_nama,true);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('gelardepan',$this->gelardepan,true);
		$criteria->compare('nama_pegawai',$this->nama_pegawai,true);
		$criteria->compare('gelarbelakang_id',$this->gelarbelakang_id);
		$criteria->compare('gelarbelakang_nama',$this->gelarbelakang_nama,true);
		$criteria->compare('catatandokterpengirim',$this->catatandokterpengirim,true);
		$criteria->compare('ruanganasal_m',$this->ruanganasal_m);
		$criteria->compare('ruanganasal_nama',$this->ruanganasal_nama,true);
		$criteria->compare('instalasiasal_id',$this->instalasiasal_id);
		$criteria->compare('instalasiasal_nama',$this->instalasiasal_nama,true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('pasienmasukpenunjang_id',$this->pasienmasukpenunjang_id);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id,true);
		$criteria->compare('permintaankepenunjang_id',$this->permintaankepenunjang_id);
		$criteria->compare('pemeriksaanlab_id',$this->pemeriksaanlab_id);
		$criteria->compare('pemeriksaanlab_nama',$this->pemeriksaanlab_nama,true);
		$criteria->compare('daftartindakanlab_id',$this->daftartindakanlab_id);
		$criteria->compare('pemeriksaanrad_id',$this->pemeriksaanrad_id);
		$criteria->compare('pemeriksaanrad_nama',$this->pemeriksaanrad_nama,true);
		$criteria->compare('daftartindakanrad_id',$this->daftartindakanrad_id);
		$criteria->compare('qtypermintaan',$this->qtypermintaan);
		$criteria->compare('noperminatanpenujang',$this->noperminatanpenujang,true);
		$criteria->compare('tglpermintaankepenunjang',$this->tglpermintaankepenunjang,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PasienkirimkeunitlaindetailV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	function getNamaLengkap(){
		return $this->gelardepan.' '.$this->nama_pegawai.' '.$this->gelarbelakang_nama;
	}
}
