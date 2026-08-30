<?php

/**
 * This is the model class for table "terimabahandetail_t".
 *
 * The followings are the available columns in table 'terimabahandetail_t':
 * @property integer $terimabahandetail_id
 * @property integer $bahanmakanan_id
 * @property integer $pengajuanbahandetail_id
 * @property integer $terimabahanmakan_id
 * @property integer $golbahanmakanan_id
 * @property integer $nourutbahan
 * @property string $ukuran_bahanterima
 * @property string $merk_bahanterima
 * @property double $jmlkemasan
 * @property double $qty_terima
 * @property string $satuanbahan
 * @property double $harganettobhn
 * @property double $hargajualbhn
 */
class TerimabahandetailT extends CActiveRecord
{
    public $harganettobahan;
    public $hargajualbahan;
    public $discount;
    public $harganettomaster, $namabahanmaster, $hppcheck;
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TerimabahandetailT the static model class
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
		return 'terimabahandetail_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('bahanmakanan_id, terimabahanmakan_id, golbahanmakanan_id, nourutbahan, qty_terima, satuanbahan, harganettobhn, hargajualbhn', 'required'),
			array('bahanmakanan_id, pengajuanbahandetail_id, terimabahanmakan_id, golbahanmakanan_id, nourutbahan', 'numerical', 'integerOnly'=>true),
			array('jmlkemasan, qty_terima, harganettobhn, hargajualbhn, persendiscount, jmldiscount, persenppn, persenpph', 'numerical'),
			array('ukuran_bahanterima, merk_bahanterima, satuanbahan', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('terimabahandetail_id, bahanmakanan_id, pengajuanbahandetail_id, terimabahanmakan_id, golbahanmakanan_id, nourutbahan, ukuran_bahanterima, merk_bahanterima, jmlkemasan, qty_terima, satuanbahan, harganettobhn, hargajualbhn, persendiscount, jmldiscount, persenppn, persenpph', 'safe', 'on'=>'search'),
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
                    'bahanmakanan'=>array(self::BELONGS_TO, 'BahanmakananM', 'bahanmakanan_id'),
                    'golbahanmakanan'=>array(self::BELONGS_TO, 'GolbahanmakananM', 'golbahanmakanan_id'),
                    'terimabahanmakan'=>array(self::BELONGS_TO, 'TerimabahanmakanT', 'terimabahanmakan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'terimabahandetail_id' => 'Terima Bahan Detail',
			'bahanmakanan_id' => 'Bahan Makanan',
			'pengajuanbahandetail_id' => 'Pengajuan Bahan Detail',
			'terimabahanmakan_id' => 'Terima Bahan Makan',
			'golbahanmakanan_id' => 'Golongan Bahan Makanan',
			'nourutbahan' => 'No. Urut Bahan',
			'ukuran_bahanterima' => 'Ukuran Bahan Terima',
			'merk_bahanterima' => 'Merk Bahan Terima',
			'jmlkemasan' => 'Jumlah Kemasan',
			'qty_terima' => 'Jumlah Terima',
			'satuanbahan' => 'Satuan Bahan',
			'harganettobhn' => 'Harga Netto Bahan',
			'hargajualbhn' => 'Harga Jual Bahan',
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

		$criteria->compare('terimabahandetail_id',$this->terimabahandetail_id);
		$criteria->compare('bahanmakanan_id',$this->bahanmakanan_id);
		$criteria->compare('pengajuanbahandetail_id',$this->pengajuanbahandetail_id);
		$criteria->compare('terimabahanmakan_id',$this->terimabahanmakan_id);
		$criteria->compare('golbahanmakanan_id',$this->golbahanmakanan_id);
		$criteria->compare('nourutbahan',$this->nourutbahan);
		$criteria->compare('LOWER(ukuran_bahanterima)',strtolower($this->ukuran_bahanterima),true);
		$criteria->compare('LOWER(merk_bahanterima)',strtolower($this->merk_bahanterima),true);
		$criteria->compare('jmlkemasan',$this->jmlkemasan);
		$criteria->compare('qty_terima',$this->qty_terima);
		$criteria->compare('LOWER(satuanbahan)',strtolower($this->satuanbahan),true);
		$criteria->compare('harganettobhn',$this->harganettobhn);
		$criteria->compare('hargajualbhn',$this->hargajualbhn);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('terimabahandetail_id',$this->terimabahandetail_id);
		$criteria->compare('bahanmakanan_id',$this->bahanmakanan_id);
		$criteria->compare('pengajuanbahandetail_id',$this->pengajuanbahandetail_id);
		$criteria->compare('terimabahanmakan_id',$this->terimabahanmakan_id);
		$criteria->compare('golbahanmakanan_id',$this->golbahanmakanan_id);
		$criteria->compare('nourutbahan',$this->nourutbahan);
		$criteria->compare('LOWER(ukuran_bahanterima)',strtolower($this->ukuran_bahanterima),true);
		$criteria->compare('LOWER(merk_bahanterima)',strtolower($this->merk_bahanterima),true);
		$criteria->compare('jmlkemasan',$this->jmlkemasan);
		$criteria->compare('qty_terima',$this->qty_terima);
		$criteria->compare('LOWER(satuanbahan)',strtolower($this->satuanbahan),true);
		$criteria->compare('harganettobhn',$this->harganettobhn);
		$criteria->compare('hargajualbhn',$this->hargajualbhn);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}