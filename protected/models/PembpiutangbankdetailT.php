<?php

/**
 * This is the model class for table "pembpiutangbankdetail_t".
 *
 * The followings are the available columns in table 'pembpiutangbankdetail_t':
 * @property integer $pembpiutangbankdetail_id
 * @property integer $pembpiutangbank_id
 * @property integer $pendaftaran_id
 * @property integer $pasien_id
 * @property integer $pembayaranpelayanan_id
 * @property integer $tandabuktibayar_id
 * @property integer $jnspembayar_id
 * @property integer $bank_id
 * @property double $jmlpiutang
 * @property double $jmlbayar
 * @property double $jmlsisapiutang
 * @property string $keterangan
 *
 * The followings are the available model relations:
 * @property PembpiutangbankT $pembpiutangbank
 * @property PendaftaranT $pendaftaran
 * @property PasienM $pasien
 * @property PembayaranpelayananT $pembayaranpelayanan
 * @property TandabuktibayarT $tandabuktibayar
 * @property JnspembayarM $jnspembayar
 * @property BankM $bank
 */
class PembpiutangbankdetailT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PembpiutangbankdetailT the static model class
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
		return 'pembpiutangbankdetail_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pembpiutangbank_id, pendaftaran_id, pasien_id, pembayaranpelayanan_id, tandabuktibayar_id, jnspembayar_id, bank_id, jmlpiutang, jmlbayar, jmlsisapiutang, bayarke', 'required'),
			array('pembpiutangbank_id, pendaftaran_id, pasien_id, pembayaranpelayanan_id, tandabuktibayar_id, jnspembayar_id, bank_id, bayarke', 'numerical', 'integerOnly'=>true),
			array('jmlpiutang, jmlbayar, jmlsisapiutang, biayaadministrasi, biaya_materai, jmlpenerimaan', 'numerical'),
			array('keterangan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pembpiutangbankdetail_id, pembpiutangbank_id, pendaftaran_id, pasien_id, pembayaranpelayanan_id, tandabuktibayar_id, jnspembayar_id, bank_id, jmlpiutang, jmlbayar, jmlsisapiutang, keterangan, bayarke, biayaadministrasi, biaya_materai, jmlpenerimaan', 'safe', 'on'=>'search'),
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
			'pembpiutangbank' => array(self::BELONGS_TO, 'PembpiutangbankT', 'pembpiutangbank_id'),
			'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
			'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
			'pembayaranpelayanan' => array(self::BELONGS_TO, 'PembayaranpelayananT', 'pembayaranpelayanan_id'),
			'tandabuktibayar' => array(self::BELONGS_TO, 'TandabuktibayarT', 'tandabuktibayar_id'),
			'jnspembayar' => array(self::BELONGS_TO, 'JnspembayarM', 'jnspembayar_id'),
			'bank' => array(self::BELONGS_TO, 'BankM', 'bank_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pembpiutangbankdetail_id' => 'Pembpiutangbankdetail',
			'pembpiutangbank_id' => 'Pembpiutangbank',
			'pendaftaran_id' => 'Pendaftaran',
			'pasien_id' => 'Pasien',
			'pembayaranpelayanan_id' => 'Pembayaranpelayanan',
			'tandabuktibayar_id' => 'Tandabuktibayar',
			'jnspembayar_id' => 'Jnspembayar',
			'bank_id' => 'Bank',
			'jmlpiutang' => 'Jmlpiutang',
			'jmlbayar' => 'Jmlbayar',
			'jmlsisapiutang' => 'Jmlsisapiutang',
			'keterangan' => 'Keterangan',
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
		$criteria->compare('pembpiutangbank_id',$this->pembpiutangbank_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pembayaranpelayanan_id',$this->pembayaranpelayanan_id);
		$criteria->compare('tandabuktibayar_id',$this->tandabuktibayar_id);
		$criteria->compare('jnspembayar_id',$this->jnspembayar_id);
		$criteria->compare('bank_id',$this->bank_id);
		$criteria->compare('jmlpiutang',$this->jmlpiutang);
		$criteria->compare('jmlbayar',$this->jmlbayar);
		$criteria->compare('jmlsisapiutang',$this->jmlsisapiutang);
		$criteria->compare('keterangan',$this->keterangan,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
