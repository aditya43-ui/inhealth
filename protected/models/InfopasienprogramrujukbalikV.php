<?php

/**
 * This is the model class for table "infopasienprogramrujukbalik_v".
 *
 * The followings are the available columns in table 'infopasienprogramrujukbalik_v':
 * @property integer $programrujukbalikpasien_id
 * @property integer $dpjp_id
 * @property string $gelardepan
 * @property string $nama_pegawai
 * @property string $gelarbelakang_nama
 * @property string $kodedokter_bpjs
 * @property string $tglbuat_prb
 * @property string $programprb_kode
 * @property string $programprb_nama
 * @property string $saran
 * @property string $keterangan
 * @property string $user_pembuat
 * @property string $nosrb
 * @property string $tglsrb
 * @property string $no_telepon_peserta
 * @property integer $sep_id
 * @property string $tglsep
 * @property string $nosep
 * @property string $nokartuasuransi
 * @property integer $klsrawat
 * @property integer $jnspelayanan
 * @property string $ppkrujukan
 * @property string $namaperujuk
 * @property string $no_rekam_medik
 * @property string $nama_pasien
 * @property string $tanggal_lahir
 * @property string $jeniskelamin
 * @property string $alamat_pasien
 * @property string $no_mobile_pasien
 * @property string $alamatemail
 * @property string $no_pendaftaran
 * @property string $tgl_pendaftaran
 * @property integer $pendaftaran_id
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 */
class InfopasienprogramrujukbalikV extends CActiveRecord
{
        public $tgl_awal, $tgl_akhir;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'infopasienprogramrujukbalik_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('programrujukbalikpasien_id, dpjp_id, sep_id, klsrawat, jnspelayanan, pendaftaran_id, ruangan_id', 'numerical', 'integerOnly'=>true),
			array('gelardepan, no_rekam_medik', 'length', 'max'=>10),
			array('nama_pegawai, nokartuasuransi, ppkrujukan, nama_pasien, ruangan_nama', 'length', 'max'=>50),
			array('gelarbelakang_nama', 'length', 'max'=>15),
			array('kodedokter_bpjs', 'length', 'max'=>30),
			array('programprb_kode, jeniskelamin, no_mobile_pasien, no_pendaftaran', 'length', 'max'=>20),
			array('programprb_nama, user_pembuat, nosrb', 'length', 'max'=>200),
			array('nosep, namaperujuk, alamatemail', 'length', 'max'=>100),
			array('tglbuat_prb, saran, keterangan, tglsrb, no_telepon_peserta, tglsep, tanggal_lahir, alamat_pasien, tgl_pendaftaran', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('programrujukbalikpasien_id, dpjp_id, gelardepan, nama_pegawai, gelarbelakang_nama, kodedokter_bpjs, tglbuat_prb, programprb_kode, programprb_nama, saran, keterangan, user_pembuat, nosrb, tglsrb, no_telepon_peserta, sep_id, tglsep, nosep, nokartuasuransi, klsrawat, jnspelayanan, ppkrujukan, namaperujuk, no_rekam_medik, nama_pasien, tanggal_lahir, jeniskelamin, alamat_pasien, no_mobile_pasien, alamatemail, no_pendaftaran, tgl_pendaftaran, pendaftaran_id, ruangan_id, ruangan_nama', 'safe', 'on'=>'search'),
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
			'programrujukbalikpasien_id' => 'Programrujukbalikpasien',
			'dpjp_id' => 'Dpjp',
			'gelardepan' => 'Gelardepan',
			'nama_pegawai' => 'Nama Pegawai',
			'gelarbelakang_nama' => 'Gelarbelakang Nama',
			'kodedokter_bpjs' => 'Kodedokter Bpjs',
			'tglbuat_prb' => 'Tglbuat Prb',
			'programprb_kode' => 'Programprb Kode',
			'programprb_nama' => 'Programprb Nama',
			'saran' => 'Saran',
			'keterangan' => 'Keterangan',
			'user_pembuat' => 'User Pembuat',
			'nosrb' => 'Nosrb',
			'tglsrb' => 'Tglsrb',
			'no_telepon_peserta' => 'No Telepon Peserta',
			'sep_id' => 'Sep',
			'tglsep' => 'Tglsep',
			'nosep' => 'No SEP',
			'nokartuasuransi' => 'No Peserta',
			'klsrawat' => 'Klsrawat',
			'jnspelayanan' => 'Jnspelayanan',
			'ppkrujukan' => 'Ppkrujukan',
			'namaperujuk' => 'Namaperujuk',
			'no_rekam_medik' => 'No Rekam Medik',
			'nama_pasien' => 'Nama Pasien/Peserta',
			'tanggal_lahir' => 'Tanggal Lahir',
			'jeniskelamin' => 'Jeniskelamin',
			'alamat_pasien' => 'Alamat Pasien',
			'no_mobile_pasien' => 'No Mobile Pasien',
			'alamatemail' => 'Alamatemail',
			'no_pendaftaran' => 'No Pendaftaran',
			'tgl_pendaftaran' => 'Tgl Pendaftaran',
			'pendaftaran_id' => 'Pendaftaran',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
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
                
                $criteria->addBetweenCondition('DATE(tglbuat_prb)', $this->tgl_awal, $this->tgl_akhir);
		$criteria->compare('LOWER(nama_pegawai)', strtolower($this->nama_pegawai), true);
		$criteria->compare('LOWER(nosrb)', strtolower($this->nosrb), true);				
		$criteria->compare('LOWER(nosep)', strtolower($this->nosep), true);
		$criteria->compare('LOWER(nokartuasuransi)', strtolower($this->nokartuasuransi), true);
		$criteria->compare('LOWER(no_rekam_medik)', strtolower($this->no_rekam_medik), true);
		$criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien), true);
		$criteria->compare('LOWER(no_pendaftaran)', strtolower($this->no_pendaftaran), true);		

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return InfopasienprogramrujukbalikV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
