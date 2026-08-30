<?php

/**
 * This is the model class for table "penerimaanbayarpiutang_v".
 *
 * The followings are the available columns in table 'penerimaanbayarpiutang_v':
 * @property integer $jenispembayaran_id
 * @property double $jumlahpembayaran
 * @property string $tgljatuhtempo
 * @property integer $jnspembayar_id
 * @property string $jnspembayar_nama
 * @property integer $tandabuktibayar_id
 * @property integer $pembayaranpelayanan_id
 * @property string $nopembayaran
 * @property string $tglpembayaran
 * @property integer $pendaftaran_id
 * @property string $tgl_pendaftaran
 * @property string $no_pendaftaran
 * @property integer $pasien_id
 * @property string $nama_pasien
 * @property string $no_rekam_medik
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 */
class PenerimaanbayarpiutangV extends CActiveRecord
{
	public $checklist, $jmldibayarkan, $sisahutang, $keterangan, $bayarke, $biayaadministrasi, $biaya_materai, $jmlpenerimaan;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PenerimaanbayarpiutangV the static model class
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
		return 'penerimaanbayarpiutang_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jenispembayaran_id, jnspembayar_id, tandabuktibayar_id, pembayaranpelayanan_id, pendaftaran_id, pasien_id, ruangan_id, instalasi_id, bankpenerima_id', 'numerical', 'integerOnly'=>true),
			array('jumlahpembayaran', 'numerical'),
			array('jnspembayar_nama, namabank', 'length', 'max'=>100),
			array('nopembayaran, nama_pasien, ruangan_nama, instalasi_nama', 'length', 'max'=>50),
			array('no_pendaftaran', 'length', 'max'=>20),
			array('no_rekam_medik', 'length', 'max'=>10),
			array('tgljatuhtempo, tglpembayaran, tgl_pendaftaran', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('jenispembayaran_id, jumlahpembayaran, tgljatuhtempo, jnspembayar_id, jnspembayar_nama, tandabuktibayar_id, pembayaranpelayanan_id, nopembayaran, tglpembayaran, pendaftaran_id, tgl_pendaftaran, no_pendaftaran, pasien_id, nama_pasien, no_rekam_medik, ruangan_id, ruangan_nama, instalasi_id, instalasi_nama, bankpenerima_id, namabank', 'safe', 'on'=>'search'),
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
			'jenispembayaran_id' => 'Jenispembayaran',
			'jumlahpembayaran' => 'Jumlahpembayaran',
			'tgljatuhtempo' => 'Tgl. Jatuh Tempo',
			'jnspembayar_id' => 'Jnspembayar',
			'jnspembayar_nama' => 'Jnspembayar Nama',
			'tandabuktibayar_id' => 'Tandabuktibayar',
			'pembayaranpelayanan_id' => 'Pembayaranpelayanan',
			'nopembayaran' => 'No. Pembayaran',
			'tglpembayaran' => 'Tgl. Pembayaran',
			'pendaftaran_id' => 'Pendaftaran',
			'tgl_pendaftaran' => 'Tgl. Pendaftaran',
			'no_pendaftaran' => 'No. Pendaftaran',
			'pasien_id' => 'Pasien',
			'nama_pasien' => 'Nama Pasien',
			'no_rekam_medik' => 'No. Rekam Medik',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
			'instalasi_id' => 'Instalasi',
			'instalasi_nama' => 'Instalasi Nama',
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

		$criteria->compare('jenispembayaran_id',$this->jenispembayaran_id);
		$criteria->compare('jumlahpembayaran',$this->jumlahpembayaran);
		$criteria->compare('tgljatuhtempo',$this->tgljatuhtempo,true);
		$criteria->compare('jnspembayar_id',$this->jnspembayar_id);
		$criteria->compare('jnspembayar_nama',$this->jnspembayar_nama,true);
		$criteria->compare('tandabuktibayar_id',$this->tandabuktibayar_id);
		$criteria->compare('pembayaranpelayanan_id',$this->pembayaranpelayanan_id);
		$criteria->compare('nopembayaran',$this->nopembayaran,true);
		$criteria->compare('tglpembayaran',$this->tglpembayaran,true);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('tgl_pendaftaran',$this->tgl_pendaftaran,true);
		$criteria->compare('no_pendaftaran',$this->no_pendaftaran,true);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('nama_pasien',$this->nama_pasien,true);
		$criteria->compare('no_rekam_medik',$this->no_rekam_medik,true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('instalasi_nama',$this->instalasi_nama,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
