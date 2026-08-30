<?php

/**
 * This is the model class for table "pembjasadetail_t".
 *
 * The followings are the available columns in table 'pembjasadetail_t':
 * @property integer $pembjasadetail_id
 * @property integer $pendaftaran_id
 * @property integer $pembayaranjasa_id
 * @property integer $pasienmasukpenunjang_id
 * @property integer $pasienadmisi_id
 * @property integer $pasien_id
 * @property double $jumahtarif
 * @property double $jumlahjasa
 * @property double $jumlahbayar
 * @property double $sisajasa
 */
class PembjasadetailT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PembjasadetailT the static model class
	 */

	public $penjaminId; 
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'pembjasadetail_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendaftaran_id, pembayaranjasa_id, pasien_id', 'required'),
			array('pendaftaran_id, pembayaranjasa_id, pasienmasukpenunjang_id, pasienadmisi_id, pasien_id', 'numerical', 'integerOnly'=>true),
			array('jumahtarif, jumlahjasa, jumlahbayar, sisajasa, jumlahpajak', 'numerical'),
			array('tindakanpelayanan_id, daftartindakan_id, komponentarif_id, obatalkespasien_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pembjasadetail_id, pendaftaran_id, pembayaranjasa_id, pasienmasukpenunjang_id, pasienadmisi_id, pasien_id, jumahtarif, jumlahjasa, jumlahbayar, sisajasa', 'safe', 'on'=>'search'),
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
                    'pembayaranjasa'=>array(self::BELONGS_TO,'PembayaranjasaT','pembayaranjasa_id'),
                    'pasien'=>array(self::BELONGS_TO,'PasienM','pasien_id'),
                    'pendaftaran'=>array(self::BELONGS_TO,'PendaftaranT','pendaftaran_id'),
                    'pasienmasukpenunjang'=>array(self::BELONGS_TO,'PasienmasukpenunjangT','pasienmasukpenunjang_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pembjasadetail_id' => 'Pembayaran jasa detail',
			'pendaftaran_id' => 'Pendaftaran',
			'pembayaranjasa_id' => 'Pembayaran Jasa',
			'pasienmasukpenunjang_id' => 'Pasien Masuk Penunjang',
			'pasienadmisi_id' => 'Pasien Admisi',
			'pasien_id' => 'Pasien',
			'jumahtarif' => 'Jumah Tarif',
			'jumlahjasa' => 'Jumlah Jasa',
			'jumlahbayar' => 'Jumlah Bayar',
			'sisajasa' => 'Sisa Jasa',
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

		$criteria->compare('pembjasadetail_id',$this->pembjasadetail_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pembayaranjasa_id',$this->pembayaranjasa_id);
		$criteria->compare('pasienmasukpenunjang_id',$this->pasienmasukpenunjang_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('jumahtarif',$this->jumahtarif);
		$criteria->compare('jumlahjasa',$this->jumlahjasa);
		$criteria->compare('jumlahbayar',$this->jumlahbayar);
		$criteria->compare('sisajasa',$this->sisajasa);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('pembjasadetail_id',$this->pembjasadetail_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pembayaranjasa_id',$this->pembayaranjasa_id);
		$criteria->compare('pasienmasukpenunjang_id',$this->pasienmasukpenunjang_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('jumahtarif',$this->jumahtarif);
		$criteria->compare('jumlahjasa',$this->jumlahjasa);
		$criteria->compare('jumlahbayar',$this->jumlahbayar);
		$criteria->compare('sisajasa',$this->sisajasa);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}