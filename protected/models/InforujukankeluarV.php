<?php

/**
 * This is the model class for table "inforujukankeluar_v".
 *
 * The followings are the available columns in table 'inforujukankeluar_v':
 * @property integer $pemeriksaankeluar_id
 * @property string $labklinikrujukan_nama
 * @property string $pemeriksaankeluar_tgl
 * @property string $pemeriksaankeluar_alasan
 * @property string $pemeriksaankeluar_ket
 * @property string $namadepan
 * @property string $nama_pasien
 * @property string $no_rekam_medik
 * @property string $no_masukpenunjang
 * @property string $no_pendaftaran
 * @property integer $dokterpengirim_id
 * @property string $gelardepan
 * @property string $nama_pegawai
 * @property string $gelarbelakang_nama
 * @property string $jabatan_nama
 * @property integer $daftartindakan_id
 * @property string $daftartindakan_nama
 * @property integer $ruanganpengirim_id
 * @property string $ruangan_nama
 * @property integer $tindakanpelayanan_id
 */
class InforujukankeluarV extends CActiveRecord
{
	public $tgl_awal;
	public $tgl_akhir;
	public $data, $tick, $jumlah;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InforujukankeluarV the static model class
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
		return 'inforujukankeluar_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pemeriksaankeluar_id, dokterpengirim_id, daftartindakan_id, ruanganpengirim_id, tindakanpelayanan_id', 'numerical', 'integerOnly'=>true),
			array('labklinikrujukan_nama', 'length', 'max'=>30),
			array('pemeriksaankeluar_alasan, daftartindakan_nama', 'length', 'max'=>200),
			array('namadepan, no_masukpenunjang, no_pendaftaran', 'length', 'max'=>20),
			array('nama_pasien, nama_pegawai, ruangan_nama', 'length', 'max'=>50),
			array('no_rekam_medik, gelardepan', 'length', 'max'=>10),
			array('gelarbelakang_nama', 'length', 'max'=>15),
			array('jabatan_nama', 'length', 'max'=>100),
			array('pasienmasukpenunjang_id, labklinikrujukan_id, pemeriksaankeluar_tgl, pemeriksaankeluar_ket', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pemeriksaankeluar_id, labklinikrujukan_nama, pemeriksaankeluar_tgl, pemeriksaankeluar_alasan, pemeriksaankeluar_ket, namadepan, nama_pasien, no_rekam_medik, no_masukpenunjang, no_pendaftaran, dokterpengirim_id, gelardepan, nama_pegawai, gelarbelakang_nama, jabatan_nama, daftartindakan_id, daftartindakan_nama, ruanganpengirim_id, ruangan_nama, tindakanpelayanan_id', 'safe', 'on'=>'search'),
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
			'pemeriksaankeluar_id' => 'Pemeriksaankeluar',
			'labklinikrujukan_id' => 'Klinik Rujukan',
			'labklinikrujukan_nama' => 'Klinik Rujukan',
			'pemeriksaankeluar_tgl' => 'Tanggal Rujukan',
			'pemeriksaankeluar_alasan' => 'Alasan',
			'pemeriksaankeluar_ket' => 'Keterangan',
			'namadepan' => 'Nama Depan',
			'nama_pasien' => 'Nama Pasien',
			'no_rekam_medik' => 'No. Rekam Medik',
			'no_masukpenunjang' => 'No Masuk Penunjang',
			'no_pendaftaran' => 'No. Pendaftaran',
			'dokterpengirim_id' => 'Dokter Pengirim',
			'gelardepan' => 'Gelar Depan',
			'nama_pegawai' => 'Dokter Pengirim',
			'gelarbelakang_nama' => 'Gelar Belakang',
			'jabatan_nama' => 'Jabatan',
			'daftartindakan_id' => 'Daftartindakan',
			'daftartindakan_nama' => 'Daftar Tindakan',
			'ruanganpengirim_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
			'tindakanpelayanan_id' => 'Tindakanpelayanan',
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

		$criteria->compare('pemeriksaankeluar_id',$this->pemeriksaankeluar_id);
		$criteria->compare('labklinikrujukan_nama',$this->labklinikrujukan_nama,true);
		$criteria->compare('pemeriksaankeluar_tgl',$this->pemeriksaankeluar_tgl,true);
		$criteria->compare('pemeriksaankeluar_alasan',$this->pemeriksaankeluar_alasan,true);
		$criteria->compare('pemeriksaankeluar_ket',$this->pemeriksaankeluar_ket,true);
		$criteria->compare('namadepan',$this->namadepan,true);
		$criteria->compare('nama_pasien',$this->nama_pasien,true);
		$criteria->compare('no_rekam_medik',$this->no_rekam_medik,true);
		$criteria->compare('no_masukpenunjang',$this->no_masukpenunjang,true);
		$criteria->compare('no_pendaftaran',$this->no_pendaftaran,true);
		$criteria->compare('dokterpengirim_id',$this->dokterpengirim_id);
		$criteria->compare('gelardepan',$this->gelardepan,true);
		$criteria->compare('nama_pegawai',$this->nama_pegawai,true);
		$criteria->compare('gelarbelakang_nama',$this->gelarbelakang_nama,true);
		$criteria->compare('jabatan_nama',$this->jabatan_nama,true);
		$criteria->compare('daftartindakan_id',$this->daftartindakan_id);
		$criteria->compare('daftartindakan_nama',$this->daftartindakan_nama,true);
		$criteria->compare('ruanganpengirim_id',$this->ruanganpengirim_id);
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);
		$criteria->compare('tindakanpelayanan_id',$this->tindakanpelayanan_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function getNamaLengkap(){
		return $this->gelardepan.' '.$this->nama_pegawai.' '.$this->gelarbelakang_nama;
	}
}