<?php

/**
 * This is the model class for table "kartuangsuran_v".
 *
 * The followings are the available columns in table 'kartuangsuran_v':
 * @property integer $pegawai_id
 * @property string $nomorindukpegawai
 * @property string $gelardepan
 * @property string $nama_pegawai
 * @property integer $gelarbelakang_id
 * @property string $gelarbelakang_nama
 * @property string $tempatlahir_pegawai
 * @property string $tgl_lahirpegawai
 * @property string $jeniskelamin
 * @property string $alamat_pegawai
 * @property string $kategoripegawai
 * @property integer $golonganpegawai_id
 * @property string $golonganpegawai_nama
 * @property integer $jabatan_id
 * @property string $jabatan_nama
 * @property integer $pangkat_id
 * @property string $pangkat_nama
 * @property integer $keanggotaan_id
 * @property string $nokeanggotaan
 * @property integer $pinjaman_id
 * @property string $tglpinjaman
 * @property string $jenispinjaman
 * @property string $no_pinjaman
 * @property double $jml_pinjaman
 * @property double $jasa_pinjaman
 * @property string $jatuh_tempo
 * @property integer $jangka_waktu_bln
 * @property integer $jml_kali_angsur
 * @property double $persen_jasa_pinjaman
 * @property string $untuk_keperluan
 * @property boolean $statuspinjaman
 * @property integer $jmlangsuran_id
 * @property integer $angsuran_ke
 * @property string $tglangsuran
 * @property string $tgljatuhtempoangs
 * @property double $jmlpokok_angsuran
 * @property double $jmljasa_angsuran
 * @property double $totalangsuran
 * @property double $jmldenda_angsuran
 * @property boolean $status_bayar
 * @property boolean $status_pengajuan
 * @property double $jmlpembayaran
 */
class KartuangsuranV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KartuangsuranV the static model class
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
		return 'kartuangsuran_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pegawai_id, gelarbelakang_id, golonganpegawai_id, jabatan_id, pangkat_id, keanggotaan_id, pinjaman_id, jangka_waktu_bln, jml_kali_angsur, jmlangsuran_id, angsuran_ke', 'numerical', 'integerOnly'=>true),
			array('jml_pinjaman, jasa_pinjaman, persen_jasa_pinjaman, jmlpokok_angsuran, jmljasa_angsuran, totalangsuran, jmldenda_angsuran, jmlpembayaran', 'numerical'),
			array('nomorindukpegawai, tempatlahir_pegawai', 'length', 'max'=>30),
			array('gelardepan', 'length', 'max'=>10),
			array('nama_pegawai, golonganpegawai_nama, pangkat_nama, nokeanggotaan, jenispinjaman, no_pinjaman', 'length', 'max'=>50),
			array('gelarbelakang_nama', 'length', 'max'=>15),
			array('jeniskelamin', 'length', 'max'=>20),
			array('kategoripegawai', 'length', 'max'=>128),
			array('jabatan_nama', 'length', 'max'=>100),
			array('tgl_lahirpegawai, alamat_pegawai, tglpinjaman, jatuh_tempo, untuk_keperluan, statuspinjaman, tglangsuran, tgljatuhtempoangs, status_bayar, status_pengajuan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pegawai_id, nomorindukpegawai, gelardepan, nama_pegawai, gelarbelakang_id, gelarbelakang_nama, tempatlahir_pegawai, tgl_lahirpegawai, jeniskelamin, alamat_pegawai, kategoripegawai, golonganpegawai_id, golonganpegawai_nama, jabatan_id, jabatan_nama, pangkat_id, pangkat_nama, keanggotaan_id, nokeanggotaan, pinjaman_id, tglpinjaman, jenispinjaman, no_pinjaman, jml_pinjaman, jasa_pinjaman, jatuh_tempo, jangka_waktu_bln, jml_kali_angsur, persen_jasa_pinjaman, untuk_keperluan, statuspinjaman, jmlangsuran_id, angsuran_ke, tglangsuran, tgljatuhtempoangs, jmlpokok_angsuran, jmljasa_angsuran, totalangsuran, jmldenda_angsuran, status_bayar, status_pengajuan, jmlpembayaran', 'safe', 'on'=>'search'),
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
			'pegawai_id' => 'Pegawai',
			'nomorindukpegawai' => 'Nomorindukpegawai',
			'gelardepan' => 'Gelardepan',
			'nama_pegawai' => 'Nama Pegawai',
			'gelarbelakang_id' => 'Gelarbelakang',
			'gelarbelakang_nama' => 'Gelarbelakang Nama',
			'tempatlahir_pegawai' => 'Tempatlahir Pegawai',
			'tgl_lahirpegawai' => 'Tgl. Lahir Pegawai',
			'jeniskelamin' => 'Jenis Kelamin',
			'alamat_pegawai' => 'Alamat Pegawai',
			'kategoripegawai' => 'Kategoripegawai',
			'golonganpegawai_id' => 'Golongan Pegawai',
			'golonganpegawai_nama' => 'Golonganpegawai Nama',
			'jabatan_id' => 'Jabatan',
			'jabatan_nama' => 'Jabatan Nama',
			'pangkat_id' => 'Pangkat',
			'pangkat_nama' => 'Pangkat Nama',
			'keanggotaan_id' => 'Keanggotaan',
			'nokeanggotaan' => 'No Keanggotaan',
			'pinjaman_id' => 'Pinjaman',
			'tglpinjaman' => 'Tglpinjaman',
			'jenispinjaman' => 'Jenispinjaman',
			'no_pinjaman' => 'No Pinjaman',
			'jml_pinjaman' => 'Jml Pinjaman',
			'jasa_pinjaman' => 'Jasa Pinjaman',
			'jatuh_tempo' => 'Jatuh Tempo',
			'jangka_waktu_bln' => 'Jangka Waktu Bln',
			'jml_kali_angsur' => 'Jml Kali Angsur',
			'persen_jasa_pinjaman' => 'Persen Jasa Pinjaman',
			'untuk_keperluan' => 'Untuk Keperluan',
			'statuspinjaman' => 'Status Pinjaman',
			'jmlangsuran_id' => 'Jmlangsuran',
			'angsuran_ke' => 'Angsuran Ke',
			'tglangsuran' => 'Tglangsuran',
			'tgljatuhtempoangs' => 'Tgljatuhtempoangs',
			'jmlpokok_angsuran' => 'Jmlpokok Angsuran',
			'jmljasa_angsuran' => 'Jmljasa Angsuran',
			'totalangsuran' => 'Totalangsuran',
			'jmldenda_angsuran' => 'Jmldenda Angsuran',
			'status_bayar' => 'Status Bayar',
			'status_pengajuan' => 'Status Pengajuan',
			'jmlpembayaran' => 'Jmlpembayaran',
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

		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('nomorindukpegawai',$this->nomorindukpegawai,true);
		$criteria->compare('gelardepan',$this->gelardepan,true);
		$criteria->compare('nama_pegawai',$this->nama_pegawai,true);
		$criteria->compare('gelarbelakang_id',$this->gelarbelakang_id);
		$criteria->compare('gelarbelakang_nama',$this->gelarbelakang_nama,true);
		$criteria->compare('tempatlahir_pegawai',$this->tempatlahir_pegawai,true);
		$criteria->compare('tgl_lahirpegawai',$this->tgl_lahirpegawai,true);
		$criteria->compare('jeniskelamin',$this->jeniskelamin,true);
		$criteria->compare('alamat_pegawai',$this->alamat_pegawai,true);
		$criteria->compare('kategoripegawai',$this->kategoripegawai,true);
		$criteria->compare('golonganpegawai_id',$this->golonganpegawai_id);
		$criteria->compare('golonganpegawai_nama',$this->golonganpegawai_nama,true);
		$criteria->compare('jabatan_id',$this->jabatan_id);
		$criteria->compare('jabatan_nama',$this->jabatan_nama,true);
		$criteria->compare('pangkat_id',$this->pangkat_id);
		$criteria->compare('pangkat_nama',$this->pangkat_nama,true);
		$criteria->compare('keanggotaan_id',$this->keanggotaan_id);
		$criteria->compare('nokeanggotaan',$this->nokeanggotaan,true);
		$criteria->compare('pinjaman_id',$this->pinjaman_id);
		$criteria->compare('tglpinjaman',$this->tglpinjaman,true);
		$criteria->compare('jenispinjaman',$this->jenispinjaman,true);
		$criteria->compare('no_pinjaman',$this->no_pinjaman,true);
		$criteria->compare('jml_pinjaman',$this->jml_pinjaman);
		$criteria->compare('jasa_pinjaman',$this->jasa_pinjaman);
		$criteria->compare('jatuh_tempo',$this->jatuh_tempo,true);
		$criteria->compare('jangka_waktu_bln',$this->jangka_waktu_bln);
		$criteria->compare('jml_kali_angsur',$this->jml_kali_angsur);
		$criteria->compare('persen_jasa_pinjaman',$this->persen_jasa_pinjaman);
		$criteria->compare('untuk_keperluan',$this->untuk_keperluan,true);
		$criteria->compare('statuspinjaman',$this->statuspinjaman);
		$criteria->compare('jmlangsuran_id',$this->jmlangsuran_id);
		$criteria->compare('angsuran_ke',$this->angsuran_ke);
		$criteria->compare('tglangsuran',$this->tglangsuran,true);
		$criteria->compare('tgljatuhtempoangs',$this->tgljatuhtempoangs,true);
		$criteria->compare('jmlpokok_angsuran',$this->jmlpokok_angsuran);
		$criteria->compare('jmljasa_angsuran',$this->jmljasa_angsuran);
		$criteria->compare('totalangsuran',$this->totalangsuran);
		$criteria->compare('jmldenda_angsuran',$this->jmldenda_angsuran);
		$criteria->compare('status_bayar',$this->status_bayar);
		$criteria->compare('status_pengajuan',$this->status_pengajuan);
		$criteria->compare('jmlpembayaran',$this->jmlpembayaran);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}