<?php

/**
 * This is the model class for table "informasipenerimaanpembayaranpiutang_v".
 *
 * The followings are the available columns in table 'informasipenerimaanpembayaranpiutang_v':
 * @property integer $pembpiutangbankdetail_id
 * @property double $jmlpiutang
 * @property double $jmlbayar
 * @property double $jmlsisapiutang
 * @property integer $tandabuktibayar_id
 * @property string $nobuktibayar
 * @property string $tglbuktibayar
 * @property double $biayaadministrasi
 * @property double $uangditerima
 * @property integer $pembpiutangbank_id
 * @property string $tglpembayaran
 * @property string $nopembayaran
 * @property double $tglbatarbayar
 * @property integer $pegawaibatal_id
 * @property string $petugaspenyetor
 * @property integer $pegawai_id
 * @property integer $jnspembayar_id
 * @property string $jnspembayar_nama
 * @property integer $bank_id
 * @property string $namabank
 */
class InformasipenerimaanpembayaranpiutangV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasipenerimaanpembayaranpiutangV the static model class
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
		return 'informasipenerimaanpembayaranpiutang_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pembpiutangbankdetail_id, tandabuktibayar_id, pembpiutangbank_id, pegawaibatal_id, pegawai_id, jnspembayar_id, bank_id', 'numerical', 'integerOnly'=>true),
			array('jmlpiutang, jmlbayar, jmlsisapiutang, biayaadministrasi, uangditerima, biaya_materai, jmlpenerimaan', 'numerical'),
			array('nobuktibayar, nopembayaran', 'length', 'max'=>50),
			array('jnspembayar_nama, namabank', 'length', 'max'=>100),
			array('tglbuktibayar, tglpembayaran, petugaspenyetor, tglbatalbayar', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pembpiutangbankdetail_id, jmlpiutang, jmlbayar, jmlsisapiutang, tandabuktibayar_id, nobuktibayar, tglbuktibayar, biayaadministrasi, uangditerima, pembpiutangbank_id, tglpembayaran, nopembayaran, pegawaibatal_id, petugaspenyetor, pegawai_id, jnspembayar_id, jnspembayar_nama, bank_id, namabank, tglbatalbayar, biaya_materai, jmlpenerimaan', 'safe', 'on'=>'search'),
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
			'pembpiutangbankdetail_id' => 'Pembpiutangbankdetail',
			'jmlpiutang' => 'Jmlpiutang',
			'jmlbayar' => 'Jmlbayar',
			'jmlsisapiutang' => 'Jmlsisapiutang',
			'tandabuktibayar_id' => 'Tandabuktibayar',
			'nobuktibayar' => 'No. Kas Masuk',
			'tglbuktibayar' => 'Tgl. Bukti Bayar',
			'biayaadministrasi' => 'Biaya Administrasi',
			'uangditerima' => 'Uang Diterima',
			'pembpiutangbank_id' => 'Pembpiutangbank',
			'tglpembayaran' => 'Tgl. Pembayaran',
			'nopembayaran' => 'No. Pembayaran Piutang',
			'tglbatarbayar' => 'Tglbatarbayar',
			'pegawaibatal_id' => 'Pegawai Batal',
			'petugaspenyetor' => 'Petugas Penyetor',
			'pegawai_id' => 'Pegawai',
			'jnspembayar_id' => 'Jnspembayar',
			'jnspembayar_nama' => 'Jnspembayar Nama',
			'bank_id' => 'Bank',
			'namabank' => 'Namabank',
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

		$criteria->compare('pembpiutangbankdetail_id',$this->pembpiutangbankdetail_id);
		$criteria->compare('jmlpiutang',$this->jmlpiutang);
		$criteria->compare('jmlbayar',$this->jmlbayar);
		$criteria->compare('jmlsisapiutang',$this->jmlsisapiutang);
		$criteria->compare('tandabuktibayar_id',$this->tandabuktibayar_id);
		$criteria->compare('nobuktibayar',$this->nobuktibayar,true);
		$criteria->compare('tglbuktibayar',$this->tglbuktibayar,true);
		$criteria->compare('biayaadministrasi',$this->biayaadministrasi);
		$criteria->compare('uangditerima',$this->uangditerima);
		$criteria->compare('pembpiutangbank_id',$this->pembpiutangbank_id);
		$criteria->compare('tglpembayaran',$this->tglpembayaran,true);
		$criteria->compare('nopembayaran',$this->nopembayaran,true);
		$criteria->compare('tglbatarbayar',$this->tglbatarbayar);
		$criteria->compare('pegawaibatal_id',$this->pegawaibatal_id);
		$criteria->compare('petugaspenyetor',$this->petugaspenyetor,true);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('jnspembayar_id',$this->jnspembayar_id);
		$criteria->compare('jnspembayar_nama',$this->jnspembayar_nama,true);
		$criteria->compare('bank_id',$this->bank_id);
		$criteria->compare('namabank',$this->namabank,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
