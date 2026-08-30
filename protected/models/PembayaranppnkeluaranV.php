<?php

/**
 * This is the model class for table "pembayaranppnkeluaran_v".
 *
 * The followings are the available columns in table 'pembayaranppnkeluaran_v':
 * @property integer $oasudahbayar_id
 * @property integer $pembayaranpelayanan_id
 * @property string $nopembayaran
 * @property string $tglpembayaran
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 * @property integer $obatalkespasien_id
 * @property double $jumlahppn
 * @property integer $pendaftaran_id
 * @property string $tgl_pendaftaran
 * @property string $no_pendaftaran
 * @property integer $pasien_id
 * @property string $nama_pasien
 * @property string $namadepan
 * @property string $no_rekam_medik
 */
class PembayaranppnkeluaranV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PembayaranppnkeluaranV the static model class
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
		return 'pembayaranppnkeluaran_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('oasudahbayar_id, pembayaranpelayanan_id, ruangan_id, instalasi_id, obatalkespasien_id, pendaftaran_id, pasien_id, carabayar_id, penjamin_id, pajak_id', 'numerical', 'integerOnly'=>true),
			array('jumlahppn', 'numerical'),
			array('nopembayaran, ruangan_nama, instalasi_nama, nama_pasien', 'length', 'max'=>50),
			array('no_pendaftaran, namadepan', 'length', 'max'=>20),
			array('no_rekam_medik', 'length', 'max'=>10),
			array('pajak_nama', 'length', 'max'=>100),
			array('tglpembayaran, tgl_pendaftaran', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('oasudahbayar_id, pembayaranpelayanan_id, nopembayaran, tglpembayaran, ruangan_id, ruangan_nama, instalasi_id, instalasi_nama, obatalkespasien_id, jumlahppn, pendaftaran_id, tgl_pendaftaran, no_pendaftaran, pasien_id, nama_pasien, namadepan, no_rekam_medik, carabayar_id, penjamin_id, pajak_id, pajak_nama', 'safe', 'on'=>'search'),
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
			'oasudahbayar_id' => 'Oasudahbayar',
			'pembayaranpelayanan_id' => 'Pembayaranpelayanan',
			'nopembayaran' => 'No. Pembayaran',
			'tglpembayaran' => 'Tgl. Pembayaran',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
			'instalasi_id' => 'Instalasi',
			'instalasi_nama' => 'Instalasi Nama',
			'obatalkespasien_id' => 'Obatalkespasien',
			'jumlahppn' => 'Jumlahppn',
			'pendaftaran_id' => 'Pendaftaran',
			'tgl_pendaftaran' => 'Tgl. Pendaftaran',
			'no_pendaftaran' => 'No. Pendaftaran',
			'pasien_id' => 'Pasien',
			'nama_pasien' => 'Nama Pasien',
			'namadepan' => 'Namadepan',
			'no_rekam_medik' => 'No. Rekam Medik',
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

		$criteria->compare('oasudahbayar_id',$this->oasudahbayar_id);
		$criteria->compare('pembayaranpelayanan_id',$this->pembayaranpelayanan_id);
		$criteria->compare('nopembayaran',$this->nopembayaran,true);
		$criteria->compare('tglpembayaran',$this->tglpembayaran,true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('instalasi_nama',$this->instalasi_nama,true);
		$criteria->compare('obatalkespasien_id',$this->obatalkespasien_id);
		$criteria->compare('jumlahppn',$this->jumlahppn);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('tgl_pendaftaran',$this->tgl_pendaftaran,true);
		$criteria->compare('no_pendaftaran',$this->no_pendaftaran,true);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('nama_pasien',$this->nama_pasien,true);
		$criteria->compare('namadepan',$this->namadepan,true);
		$criteria->compare('no_rekam_medik',$this->no_rekam_medik,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
