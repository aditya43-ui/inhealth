<?php

/**
 * This is the model class for table "pembklaimdetal_t".
 *
 * The followings are the available columns in table 'pembklaimdetal_t':
 * @property integer $pembklaimdetal_id
 * @property integer $pendaftaran_id
 * @property integer $pasien_id
 * @property integer $pembayarklaim_id
 * @property integer $pembayaranpelayanan_id
 * @property integer $tandabuktibayar_id
 * @property double $jmlpiutang
 * @property double $jumlahbayar
 * @property double $jmltelahbayar
 * @property double $jmlsisapiutang
 */
class PembklaimdetalT extends CActiveRecord
{

	public $tglpembayaranklaim;
	public $nopembayaranklaim, $jmltagihan;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PembklaimdetalT the static model class
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
		return 'pembklaimdetal_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendaftaran_id, pasien_id, pembayarklaim_id, jmlpiutang, jumlahbayar, jmltelahbayar, jmlsisapiutang', 'required'),
			array('pendaftaran_id, pasien_id, pembayarklaim_id, pembayaranpelayanan_id, tandabuktibayar_id', 'numerical', 'integerOnly'=>true),
			array('jmlpiutang, jumlahbayar, jmltelahbayar, jmlsisapiutang', 'numerical'),
                        array('pengajuanklaimdetail_id, diskonpersen, jmldiskon','safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pembklaimdetal_id, pendaftaran_id, pasien_id, pembayarklaim_id, pembayaranpelayanan_id, tandabuktibayar_id, jmlpiutang, jumlahbayar, jmltelahbayar, jmlsisapiutang', 'safe', 'on'=>'search'),
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
			'pendaftaran'=>array(self::BELONGS_TO,'PendaftaranT','pendaftaran_id'),
			'pasien'=>array(self::BELONGS_TO,'PasienM','pasien_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pembklaimdetal_id' => 'Detail Pembayaran Klaim ',
			'pendaftaran_id' => 'Pendaftaran',
			'pasien_id' => 'Pasien',
			'pembayarklaim_id' => 'Pembayaran Klaim',
			'pembayaranpelayanan_id' => 'Pembayaran Pelayanan',
			'tandabuktibayar_id' => 'Tanda Bukti Bayar',
			'jmlpiutang' => 'Jumlah Piutang',
			'jumlahbayar' => 'Jumlah Bayar',
			'jmltelahbayar' => 'Jumlah Telah Bayar',
			'jmlsisapiutang' => 'Jumlah Sisa Piutang',
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

		$criteria->compare('pembklaimdetal_id',$this->pembklaimdetal_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pembayarklaim_id',$this->pembayarklaim_id);
		$criteria->compare('pembayaranpelayanan_id',$this->pembayaranpelayanan_id);
		$criteria->compare('tandabuktibayar_id',$this->tandabuktibayar_id);
		$criteria->compare('jmlpiutang',$this->jmlpiutang);
		$criteria->compare('jumlahbayar',$this->jumlahbayar);
		$criteria->compare('jmltelahbayar',$this->jmltelahbayar);
		$criteria->compare('jmlsisapiutang',$this->jmlsisapiutang);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('pembklaimdetal_id',$this->pembklaimdetal_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pembayarklaim_id',$this->pembayarklaim_id);
		$criteria->compare('pembayaranpelayanan_id',$this->pembayaranpelayanan_id);
		$criteria->compare('tandabuktibayar_id',$this->tandabuktibayar_id);
		$criteria->compare('jmlpiutang',$this->jmlpiutang);
		$criteria->compare('jumlahbayar',$this->jumlahbayar);
		$criteria->compare('jmltelahbayar',$this->jmltelahbayar);
		$criteria->compare('jmlsisapiutang',$this->jmlsisapiutang);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit
                $criteria->limit=-1;

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}
