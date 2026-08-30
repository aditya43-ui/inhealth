<?php

/**
 * This is the model class for table "pesanmenudetail_t".
 *
 * The followings are the available columns in table 'pesanmenudetail_t':
 * @property integer $pesanmenudetail_id
 * @property integer $pesanmenudiet_id
 * @property integer $pendaftaran_id
 * @property integer $pasienadmisi_id
 * @property integer $jeniswaktu_id
 * @property integer $kirimmenupasien_id
 * @property integer $menudiet_id
 * @property integer $pasien_id
 * @property double $jml_pesan_porsi
 * @property string $satuanjml_urt
 */
class PesanmenudetailT extends CActiveRecord
{

	public $ruangan_nama;
	public $instalasi_nama;
	public $no_pendaftaran;
	public $no_rekam_medik;
	public $nama_pasien;
	public $jeniskelamin;
	public $umur;
	public $jenismakanan_nama;
	public $menudiet_nama;
	public $jeniswaktu_nama;
	public $jenisdiet_nama;
	public $alatmakanan_nama;
	public $checkList;
	public $kelaspelayanan_id;
	public $pesanmenudiet_riwayat_id;
	public $jenismenudiet_nama;
	public $ceklis_baris;
	public $adaalergimakanan;
	public $keterangan;
	public $jenisdiet_id;
	public $jenismakanan_id;
	public $alatmakanan_id; 
	public $tipediet_id, $tipediet_nama;
	public $jenismenudiet_id;
        public $ruangan_id, $penjamin_id, $carabayar_id, $kamarruangan_id;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PesanmenudetailT the static model class
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'pesanmenudetail_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pesanmenudiet_id, pendaftaran_id, jeniswaktu_id, pasien_id, kelaspelayanan_id, jenisdiet_id, jml_pesan_porsi', 'required'),
			array('pesanmenudiet_id, alatmakanan_id, jenismakanan_id, pendaftaran_id, pasienadmisi_id, jeniswaktu_id, kirimmenupasien_id, menudiet_id, pasien_id', 'numerical', 'integerOnly' => true),
			array('jml_pesan_porsi', 'numerical'),
			array('satuanjml_urt', 'length', 'max' => 50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pesanmenudetail_id, pesanmenudiet_id, pendaftaran_id, pasienadmisi_id, jeniswaktu_id, kirimmenupasien_id, menudiet_id, pasien_id, jml_pesan_porsi, satuanjml_urt', 'safe', 'on' => 'search'),
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
			'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
			'menudiet' => array(self::BELONGS_TO, 'MenuDietM', 'menudiet_id'),
			'jeniswaktu' => array(self::BELONGS_TO, 'JeniswaktuM', 'jeniswaktu_id'),
			'pasienadmisi' => array(self::BELONGS_TO, 'PasienadmisiT', 'pasienadmisi_id'),
			'jenismakanan' => array(self::BELONGS_TO, 'JenismakananM', 'jenismakanan_id'),
			'jenisdiet' => array(self::BELONGS_TO, 'JenisdietM', 'jenisdiet_id'),
			'alatmakanan' => array(self::BELONGS_TO, 'AlatmakananM', 'alatmakanan_id'),
			'tipediet' => array(self::BELONGS_TO, 'TipeDietM', 'tipediet_id'),
			'pegawaiverif'=>array(self::BELONGS_TO, 'PegawaiM', 'verifikasi_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pesanmenudetail_id' => 'Pesan Menu Detail',
			'pesanmenudiet_id' => 'Pesan Menu Diet',
			'pendaftaran_id' => 'Pendaftaran',
			'pasienadmisi_id' => 'Pasien Admisi',
			'jeniswaktu_id' => 'Jenis Waktu',
			'kirimmenupasien_id' => 'Kirim Menu Pasien',
			'menudiet_id' => 'Menu Diet',
			'pasien_id' => 'Pasien',
			'jml_pesan_porsi' => 'Jumlah Pesan Porsi',
			'satuanjml_urt' => 'Satuan Jumlah Urt',
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

		$criteria = new CDbCriteria;

		$criteria->compare('pesanmenudetail_id', $this->pesanmenudetail_id);
		$criteria->compare('pesanmenudiet_id', $this->pesanmenudiet_id);
		$criteria->compare('pendaftaran_id', $this->pendaftaran_id);
		$criteria->compare('pasienadmisi_id', $this->pasienadmisi_id);
		$criteria->compare('jeniswaktu_id', $this->jeniswaktu_id);
		$criteria->compare('kirimmenupasien_id', $this->kirimmenupasien_id);
		$criteria->compare('menudiet_id', $this->menudiet_id);
		$criteria->compare('pasien_id', $this->pasien_id);
		$criteria->compare('jml_pesan_porsi', $this->jml_pesan_porsi);
		$criteria->compare('LOWER(satuanjml_urt)', strtolower($this->satuanjml_urt), true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}


	public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = new CDbCriteria;
		$criteria->compare('pesanmenudetail_id', $this->pesanmenudetail_id);
		$criteria->compare('pesanmenudiet_id', $this->pesanmenudiet_id);
		$criteria->compare('pendaftaran_id', $this->pendaftaran_id);
		$criteria->compare('pasienadmisi_id', $this->pasienadmisi_id);
		$criteria->compare('jeniswaktu_id', $this->jeniswaktu_id);
		$criteria->compare('kirimmenupasien_id', $this->kirimmenupasien_id);
		$criteria->compare('menudiet_id', $this->menudiet_id);
		$criteria->compare('pasien_id', $this->pasien_id);
		$criteria->compare('jml_pesan_porsi', $this->jml_pesan_porsi);
		$criteria->compare('LOWER(satuanjml_urt)', strtolower($this->satuanjml_urt), true);
		// Klo limit lebih kecil dari nol itu berarti ga ada limit 
		$criteria->limit = -1;

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'pagination' => false,
		));
	}
}
