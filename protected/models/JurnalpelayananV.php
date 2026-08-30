<?php

/**
 * This is the model class for table "jurnalpelayanan_v".
 *
 * The followings are the available columns in table 'jurnalpelayanan_v':
 * @property integer $pendaftaran_id
 * @property string $no_pendaftaran
 * @property integer $pasien_id
 * @property string $nama_pasien
 * @property string $no_rekam_medik
 * @property integer $tindpelayanan_id
 * @property string $tglpelayanan
 * @property integer $tindakan_id
 * @property integer $instalasi_id
 * @property integer $ruangan_id
 * @property double $totaltagihan
 * @property double $jumlahppn
 * @property string $tindakan_kode
 * @property string $tindakan_nama
 * @property string $instalasi_nama
 * @property string $ruangan_nama
 * @property integer $jurnalrekening_id
 * @property string $tglbuktijurnal
 * @property string $nobuktijurnal
 * @property string $kodejurnal
 * @property string $noreferensi
 * @property integer $jenisjurnal_id
 * @property string $jenisjurnal_nama
 */
class JurnalpelayananV extends CActiveRecord
{
	public $tgl_awal, $tgl_akhir, $checklist, $uraian, $daftar_tindakan, $saldodebit, $saldokredit, $nourut;
	public $kdrekening5, $nmrekening5, $rekening1_id, $rekening2_id, $rekening3_id, $rekening4_id, $rekening5_id;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JurnalpelayananV the static model class
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
		return 'jurnalpelayanan_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendaftaran_id, pasien_id, tindpelayanan_id, tindakan_id, instalasi_id, ruangan_id, jurnalrekening_id, jenisjurnal_id', 'numerical', 'integerOnly'=>true),
			array('totaltagihan, jumlahppn', 'numerical'),
			array('no_pendaftaran, kodejurnal', 'length', 'max'=>20),
			array('nama_pasien, instalasi_nama, ruangan_nama, nobuktijurnal', 'length', 'max'=>50),
			array('no_rekam_medik', 'length', 'max'=>10),
			array('tindakan_nama', 'length', 'max'=>200),
			array('jenisjurnal_nama', 'length', 'max'=>100),
			array('tglpelayanan, tindakan_kode, tglbuktijurnal, noreferensi, jenistransaksi', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pendaftaran_id, no_pendaftaran, pasien_id, nama_pasien, no_rekam_medik, tindpelayanan_id, tglpelayanan, tindakan_id, instalasi_id, ruangan_id, totaltagihan, jumlahppn, tindakan_kode, tindakan_nama, instalasi_nama, ruangan_nama, jurnalrekening_id, tglbuktijurnal, nobuktijurnal, kodejurnal, noreferensi, jenisjurnal_id, jenisjurnal_nama, jenistransaksi', 'safe', 'on'=>'search'),
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
			'pendaftaran_id' => 'Pendaftaran',
			'no_pendaftaran' => 'No. Pendaftaran',
			'pasien_id' => 'Pasien',
			'nama_pasien' => 'Nama Pasien',
			'no_rekam_medik' => 'No. Rekam Medik',
			'tindpelayanan_id' => 'Tindpelayanan',
			'tglpelayanan' => 'Tglpelayanan',
			'tindakan_id' => 'Tindakan',
			'instalasi_id' => 'Instalasi',
			'ruangan_id' => 'Ruangan',
			'totaltagihan' => 'Total Tagihan',
			'jumlahppn' => 'Jumlahppn',
			'tindakan_kode' => 'Tindakan Kode',
			'tindakan_nama' => 'Tindakan Nama',
			'instalasi_nama' => 'Instalasi Nama',
			'ruangan_nama' => 'Ruangan Nama',
			'jurnalrekening_id' => 'Jurnalrekening',
			'tglbuktijurnal' => 'Tglbuktijurnal',
			'nobuktijurnal' => 'Nobuktijurnal',
			'kodejurnal' => 'Kodejurnal',
			'noreferensi' => 'Noreferensi',
			'jenisjurnal_id' => 'Jenisjurnal',
			'jenisjurnal_nama' => 'Jenisjurnal Nama',
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

		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('no_pendaftaran',$this->no_pendaftaran,true);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('nama_pasien',$this->nama_pasien,true);
		$criteria->compare('no_rekam_medik',$this->no_rekam_medik,true);
		$criteria->compare('tindpelayanan_id',$this->tindpelayanan_id);
		$criteria->compare('tglpelayanan',$this->tglpelayanan,true);
		$criteria->compare('tindakan_id',$this->tindakan_id);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('totaltagihan',$this->totaltagihan);
		$criteria->compare('jumlahppn',$this->jumlahppn);
		$criteria->compare('tindakan_kode',$this->tindakan_kode,true);
		$criteria->compare('tindakan_nama',$this->tindakan_nama,true);
		$criteria->compare('instalasi_nama',$this->instalasi_nama,true);
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);
		$criteria->compare('jurnalrekening_id',$this->jurnalrekening_id);
		$criteria->compare('tglbuktijurnal',$this->tglbuktijurnal,true);
		$criteria->compare('nobuktijurnal',$this->nobuktijurnal,true);
		$criteria->compare('kodejurnal',$this->kodejurnal,true);
		$criteria->compare('noreferensi',$this->noreferensi,true);
		$criteria->compare('jenisjurnal_id',$this->jenisjurnal_id);
		$criteria->compare('jenisjurnal_nama',$this->jenisjurnal_nama,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
