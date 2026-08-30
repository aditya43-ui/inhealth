<?php

/**
 * This is the model class for table "informasirujukanpenunjangkeluar_v".
 *
 * The followings are the available columns in table 'informasirujukanpenunjangkeluar_v':
 * @property integer $kirimsamplelab_id
 * @property string $nokirimsample
 * @property string $tglkirimsample
 * @property string $tglterimahasilsample
 * @property string $keterangan_kirim
 * @property integer $pengambilansample_id
 * @property string $tglpengambilansample
 * @property string $no_pengambilansample
 * @property integer $jmlpengambilansample
 * @property string $tempatsimpansample
 * @property integer $pasienmasukpenunjang_id
 * @property integer $kelaspelayanan_id
 * @property integer $jeniskasuspenyakit_id
 * @property integer $ruangan_id
 * @property integer $pasien_id
 * @property integer $pendaftaran_id
 * @property integer $ruanganasal_id
 * @property string $no_rekam_medik
 * @property string $namadepan
 * @property string $nama_pasien
 * @property string $nama_bin
 * @property string $jeniskelamin
 * @property string $tempat_lahir
 * @property string $tanggal_lahir
 * @property string $golongandarah
 * @property integer $labklinikrujukan_id
 * @property string $labklinikrujukan_nama
 * @property string $labklinikrujukan_alamat
 * @property string $labklinikrujukan_telp
 * @property integer $samplelab_id
 * @property string $samplelab_nama
 * @property string $samplelab_namalainnya
 */
class InformasirujukanpenunjangkeluarV extends CActiveRecord
{
        public $jns_periode;
        public $tgl_awal;
        public $tgl_akhir;
        public $bln_awal;
        public $bln_akhir;
        public $thn_awal;
        public $thn_akhir;
        public $data, $tick, $jumlah;
        
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasirujukanpenunjangkeluarV the static model class
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
		return 'informasirujukanpenunjangkeluar_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kirimsamplelab_id, pengambilansample_id, jmlpengambilansample, pasienmasukpenunjang_id, kelaspelayanan_id, jeniskasuspenyakit_id, ruangan_id, pasien_id, pendaftaran_id, ruanganasal_id, labklinikrujukan_id, samplelab_id', 'numerical', 'integerOnly'=>true),
			array('nokirimsample, namadepan, jeniskelamin, labklinikrujukan_telp', 'length', 'max'=>20),
			array('no_pengambilansample, nama_pasien, nama_bin, samplelab_nama, samplelab_namalainnya', 'length', 'max'=>50),
			array('tempatsimpansample', 'length', 'max'=>100),
			array('no_rekam_medik', 'length', 'max'=>10),
			array('tempat_lahir', 'length', 'max'=>25),
			array('golongandarah', 'length', 'max'=>2),
			array('labklinikrujukan_nama', 'length', 'max'=>30),
			array('tglkirimsample, tglterimahasilsample, keterangan_kirim, tglpengambilansample, tanggal_lahir, labklinikrujukan_alamat', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('kirimsamplelab_id, nokirimsample, tglkirimsample, tglterimahasilsample, keterangan_kirim, pengambilansample_id, tglpengambilansample, no_pengambilansample, jmlpengambilansample, tempatsimpansample, pasienmasukpenunjang_id, kelaspelayanan_id, jeniskasuspenyakit_id, ruangan_id, pasien_id, pendaftaran_id, ruanganasal_id, no_rekam_medik, namadepan, nama_pasien, nama_bin, jeniskelamin, tempat_lahir, tanggal_lahir, golongandarah, labklinikrujukan_id, labklinikrujukan_nama, labklinikrujukan_alamat, labklinikrujukan_telp, samplelab_id, samplelab_nama, samplelab_namalainnya', 'safe', 'on'=>'search'),
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
			'kirimsamplelab_id' => 'Kirimsamplelab',
			'nokirimsample' => 'Nokirimsample',
			'tglkirimsample' => 'Tglkirimsample',
			'tglterimahasilsample' => 'Tglterimahasilsample',
			'keterangan_kirim' => 'Keterangan Kirim',
			'pengambilansample_id' => 'Pengambilansample',
			'tglpengambilansample' => 'Tglpengambilansample',
			'no_pengambilansample' => 'No Pengambilansample',
			'jmlpengambilansample' => 'Jmlpengambilansample',
			'tempatsimpansample' => 'Tempatsimpansample',
			'pasienmasukpenunjang_id' => 'Pasienmasukpenunjang',
			'kelaspelayanan_id' => 'Kelaspelayanan',
			'jeniskasuspenyakit_id' => 'Jeniskasuspenyakit',
			'ruangan_id' => 'Ruangan',
			'pasien_id' => 'Pasien',
			'pendaftaran_id' => 'Pendaftaran',
			'ruanganasal_id' => 'Ruanganasal',
			'no_rekam_medik' => 'No. Rekam Medik',
			'namadepan' => 'Namadepan',
			'nama_pasien' => 'Nama Pasien',
			'nama_bin' => 'Nama Bin',
			'jeniskelamin' => 'Jenis Kelamin',
			'tempat_lahir' => 'Tempat Lahir',
			'tanggal_lahir' => 'Tanggal Lahir',
			'golongandarah' => 'Golongandarah',
			'labklinikrujukan_id' => 'Labklinikrujukan',
			'labklinikrujukan_nama' => 'Labklinikrujukan Nama',
			'labklinikrujukan_alamat' => 'Labklinikrujukan Alamat',
			'labklinikrujukan_telp' => 'Labklinikrujukan Telp',
			'samplelab_id' => 'Samplelab',
			'samplelab_nama' => 'Samplelab Nama',
			'samplelab_namalainnya' => 'Samplelab Namalainnya',
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

		$criteria->compare('kirimsamplelab_id',$this->kirimsamplelab_id);
		$criteria->compare('nokirimsample',$this->nokirimsample,true);
		$criteria->compare('tglkirimsample',$this->tglkirimsample,true);
		$criteria->compare('tglterimahasilsample',$this->tglterimahasilsample,true);
		$criteria->compare('keterangan_kirim',$this->keterangan_kirim,true);
		$criteria->compare('pengambilansample_id',$this->pengambilansample_id);
		$criteria->compare('tglpengambilansample',$this->tglpengambilansample,true);
		$criteria->compare('no_pengambilansample',$this->no_pengambilansample,true);
		$criteria->compare('jmlpengambilansample',$this->jmlpengambilansample);
		$criteria->compare('tempatsimpansample',$this->tempatsimpansample,true);
		$criteria->compare('pasienmasukpenunjang_id',$this->pasienmasukpenunjang_id);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('jeniskasuspenyakit_id',$this->jeniskasuspenyakit_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('ruanganasal_id',$this->ruanganasal_id);
		$criteria->compare('no_rekam_medik',$this->no_rekam_medik,true);
		$criteria->compare('namadepan',$this->namadepan,true);
		$criteria->compare('nama_pasien',$this->nama_pasien,true);
		$criteria->compare('nama_bin',$this->nama_bin,true);
		$criteria->compare('jeniskelamin',$this->jeniskelamin,true);
		$criteria->compare('tempat_lahir',$this->tempat_lahir,true);
		$criteria->compare('tanggal_lahir',$this->tanggal_lahir,true);
		$criteria->compare('golongandarah',$this->golongandarah,true);
		$criteria->compare('labklinikrujukan_id',$this->labklinikrujukan_id);
		$criteria->compare('labklinikrujukan_nama',$this->labklinikrujukan_nama,true);
		$criteria->compare('labklinikrujukan_alamat',$this->labklinikrujukan_alamat,true);
		$criteria->compare('labklinikrujukan_telp',$this->labklinikrujukan_telp,true);
		$criteria->compare('samplelab_id',$this->samplelab_id);
		$criteria->compare('samplelab_nama',$this->samplelab_nama,true);
		$criteria->compare('samplelab_namalainnya',$this->samplelab_namalainnya,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}