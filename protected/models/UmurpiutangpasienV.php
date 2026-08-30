<?php

/**
 * This is the model class for table "umurpiutangpasien_v".
 *
 * The followings are the available columns in table 'umurpiutangpasien_v':
 * @property integer $pasien_id
 * @property string $namadepan
 * @property string $nama_pasien
 * @property integer $carabayar_id
 * @property string $carabayar_nama
 * @property integer $penjamin_id
 * @property string $penjamin_nama
 * @property integer $pendaftaran_id
 * @property string $no_pendaftaran
 * @property string $tgl_pendaftaran
 * @property integer $pembayaranpelayanan_id
 * @property string $tglpembayaran
 * @property string $nopembayaran
 * @property double $totalbiayapelayanan
 * @property double $totalsisatagihan
 * @property integer $lama_piutang
 * @property string $create_time
 * @property string $update_time
 * @property integer $loginpemakai_id
 * @property string $nama_pemakai
 * @property integer $pegawai_id
 * @property string $nomorindukpegawai
 * @property string $gelardepan
 * @property string $nama_pegawai
 * @property integer $gelarbelakang_id
 * @property string $gelarbelakang_nama
 * @property integer $jabatan_id
 * @property string $jabatan_nama
 */
class UmurpiutangpasienV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UmurpiutangpasienV the static model class
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
		return 'umurpiutangpasien_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasien_id, carabayar_id, penjamin_id, pendaftaran_id, pembayaranpelayanan_id, lama_piutang, loginpemakai_id, pegawai_id, gelarbelakang_id, jabatan_id', 'numerical', 'integerOnly'=>true),
			array('totalbiayapelayanan, totalsisatagihan, sisaangsuran, totaliurbiaya', 'numerical'),
			array('namadepan, no_pendaftaran, nama_pemakai', 'length', 'max'=>20),
			array('nama_pasien, carabayar_nama, penjamin_nama, nopembayaran, nama_pegawai', 'length', 'max'=>50),
			array('nomorindukpegawai', 'length', 'max'=>30),
			array('gelardepan', 'length', 'max'=>10),
			array('gelarbelakang_nama', 'length', 'max'=>15),
			array('jabatan_nama', 'length', 'max'=>100),
			array('tgl_pendaftaran, tglpembayaran, create_time, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pasien_id, namadepan, nama_pasien, carabayar_id, carabayar_nama, penjamin_id, penjamin_nama, pendaftaran_id, no_pendaftaran, tgl_pendaftaran, pembayaranpelayanan_id, tglpembayaran, nopembayaran, totalbiayapelayanan, totalsisatagihan, lama_piutang, create_time, update_time, loginpemakai_id, nama_pemakai, pegawai_id, nomorindukpegawai, gelardepan, nama_pegawai, gelarbelakang_id, gelarbelakang_nama, jabatan_id, jabatan_nama, sisaangsuran, totaliurbiaya', 'safe', 'on'=>'search'),
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
			'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pasien_id' => 'Pasien',
			'namadepan' => 'Namadepan',
			'nama_pasien' => 'Nama Pasien',
			'carabayar_id' => 'Jenis Penjamin',
			'carabayar_nama' => 'Carabayar Nama',
			'penjamin_id' => 'Penjamin',
			'penjamin_nama' => 'Penjamin Nama',
			'pendaftaran_id' => 'Pendaftaran',
			'no_pendaftaran' => 'No. Pendaftaran',
			'tgl_pendaftaran' => 'Tgl. Pendaftaran',
			'pembayaranpelayanan_id' => 'Pembayaranpelayanan',
			'tglpembayaran' => 'Tgl. Pembayaran',
			'nopembayaran' => 'No. Pembayaran',
			'totalbiayapelayanan' => 'Totalbiayapelayanan',
			'totalsisatagihan' => 'Totalsisatagihan',
			'lama_piutang' => 'Lama Piutang',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'loginpemakai_id' => 'Loginpemakai',
			'nama_pemakai' => 'Nama Pemakai',
			'pegawai_id' => 'Pegawai',
			'nomorindukpegawai' => 'Nomorindukpegawai',
			'gelardepan' => 'Gelardepan',
			'nama_pegawai' => 'Nama Pegawai',
			'gelarbelakang_id' => 'Gelarbelakang',
			'gelarbelakang_nama' => 'Gelarbelakang Nama',
			'jabatan_id' => 'Jabatan',
			'jabatan_nama' => 'Jabatan Nama',
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

		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('namadepan',$this->namadepan,true);
		$criteria->compare('nama_pasien',$this->nama_pasien,true);
		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('carabayar_nama',$this->carabayar_nama,true);
		$criteria->compare('penjamin_id',$this->penjamin_id);
		$criteria->compare('penjamin_nama',$this->penjamin_nama,true);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('no_pendaftaran',$this->no_pendaftaran,true);
		$criteria->compare('tgl_pendaftaran',$this->tgl_pendaftaran,true);
		$criteria->compare('pembayaranpelayanan_id',$this->pembayaranpelayanan_id);
		$criteria->compare('tglpembayaran',$this->tglpembayaran,true);
		$criteria->compare('nopembayaran',$this->nopembayaran,true);
		$criteria->compare('totalbiayapelayanan',$this->totalbiayapelayanan);
		$criteria->compare('totalsisatagihan',$this->totalsisatagihan);
		$criteria->compare('lama_piutang',$this->lama_piutang);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('loginpemakai_id',$this->loginpemakai_id);
		$criteria->compare('nama_pemakai',$this->nama_pemakai,true);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('nomorindukpegawai',$this->nomorindukpegawai,true);
		$criteria->compare('gelardepan',$this->gelardepan,true);
		$criteria->compare('nama_pegawai',$this->nama_pegawai,true);
		$criteria->compare('gelarbelakang_id',$this->gelarbelakang_id);
		$criteria->compare('gelarbelakang_nama',$this->gelarbelakang_nama,true);
		$criteria->compare('jabatan_id',$this->jabatan_id);
		$criteria->compare('jabatan_nama',$this->jabatan_nama,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}