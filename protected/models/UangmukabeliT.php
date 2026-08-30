<?php

/**
 * This is the model class for table "uangmukabeli_t".
 *
 * The followings are the available columns in table 'uangmukabeli_t':
 * @property integer $uangmukabeli_id
 * @property integer $supplier_id
 * @property integer $penerimaanbarang_id
 * @property string $namabank
 * @property string $norekening
 * @property string $rekatasnama
 * @property double $jumlahuang
 */
class UangmukabeliT extends CActiveRecord
{
    public $terimapersediaan_id;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UangmukabeliT the static model class
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
		return 'uangmukabeli_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('supplier_id, jumlahuang', 'required'),
			array('supplier_id, penerimaanbarang_id, pengajuanbahanmkn_id, pembelianbarang_id, permintaanpembelian_id', 'numerical', 'integerOnly'=>true),
			array('jumlahuang, jmlsisauangmuka, totalpo, totalsisahutangpo', 'numerical'),
			array('namabank, norekening, rekatasnama, nopembayaran', 'length', 'max'=>100),
                        array('tgluangmukabeli','safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('uangmukabeli_id, supplier_id, penerimaanbarang_id, namabank, norekening, rekatasnama, jumlahuang, nopembayaran, pengajuanbahanmkn_id, pembelianbarang_id, permintaanpembelian_id, jmlsisauangmuka, totalpo, totalsisahutangpo', 'safe', 'on'=>'search'),

			array('create_time','default','value'=>date('Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'insert'),
			array('update_time','default','value'=>date('Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'update,insert'),
			array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
			array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'update,insert'),
			array('create_ruangan','default','value'=>Yii::app()->user->getState('ruangan_id'),'on'=>'insert'),
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
                    'supplier'=>array(self::BELONGS_TO, 'SupplierM', 'supplier_id'),
                    'penerimaanbarang'=>array(self::BELONGS_TO, 'PenerimaanbarangT','penerimaanbarang_id'),
                    'tandabuktikeluar'=>array(self::HAS_ONE, 'TandabuktikeluarT', 'tandabuktikeluar_id'),
                    'permintaanpembelian'=>array(self::HAS_ONE, 'PermintaanpembelianT', 'permintaanpembelian_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'uangmukabeli_id' => 'Uang Muka Beli',
			'supplier_id' => 'Supplier',
			'penerimaanbarang_id' => 'Penerimaanbarang',
			'namabank' => 'Nama Bank',
			'norekening' => 'No. Rekening',
			'rekatasnama' => 'Atas Nama',
			'jumlahuang' => 'Jumlah Uang',
                        'nopembayaran' => 'No. Pembayaran',
                    'jmlsisauangmuka' => 'Jumlah Sisa Permintaan Uang Muka',
                    'totalsisahutangpo'=>'Total Sisa Hutang Permintaan Pembelian'


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

		$criteria->compare('uangmukabeli_id',$this->uangmukabeli_id);
		$criteria->compare('supplier_id',$this->supplier_id);
		$criteria->compare('penerimaanbarang_id',$this->penerimaanbarang_id);
		$criteria->compare('LOWER(namabank)',strtolower($this->namabank),true);
		$criteria->compare('LOWER(norekening)',strtolower($this->norekening),true);
		$criteria->compare('LOWER(rekatasnama)',strtolower($this->rekatasnama),true);
		$criteria->compare('jumlahuang',$this->jumlahuang);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('uangmukabeli_id',$this->uangmukabeli_id);
		$criteria->compare('supplier_id',$this->supplier_id);
		$criteria->compare('penerimaanbarang_id',$this->penerimaanbarang_id);
		$criteria->compare('LOWER(namabank)',strtolower($this->namabank),true);
		$criteria->compare('LOWER(norekening)',strtolower($this->norekening),true);
		$criteria->compare('LOWER(rekatasnama)',strtolower($this->rekatasnama),true);
		$criteria->compare('jumlahuang',$this->jumlahuang);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit
                $criteria->limit=-1;

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}
