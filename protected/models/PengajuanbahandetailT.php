<?php

/**
 * This is the model class for table "pengajuanbahandetail_t".
 *
 * The followings are the available columns in table 'pengajuanbahandetail_t':
 * @property integer $pengajuanbahandetail_id
 * @property integer $golbahanmakanan_id
 * @property integer $bahanmakanan_id
 * @property integer $pengajuanbahanmkn_id
 * @property integer $terimabahandetail_id
 * @property integer $nourutbahan
 * @property string $ukuranbahan
 * @property string $merkbahan
 * @property double $jmlkemasan
 * @property double $qty_pengajuan
 * @property string $satuanbahan
 * @property double $harganettobhn
 */
class PengajuanbahandetailT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PengajuanbahandetailT the static model class
	 */
        public $checkList, $satuanbahan,$subNetto, $jmldiscount, $jmlppn, $jmlpph;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'pengajuanbahandetail_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('golbahanmakanan_id, bahanmakanan_id, pengajuanbahanmkn_id, nourutbahan, qty_pengajuan, satuanbahan, harganettobhn', 'required'),
			array('golbahanmakanan_id, bahanmakanan_id, pengajuanbahanmkn_id, terimabahandetail_id, nourutbahan', 'numerical', 'integerOnly'=>true),
			array('jmlkemasan, qty_pengajuan, harganettobhn, persendiscount, persenppn, persenpph', 'numerical'),
			array('ukuranbahan, merkbahan, satuanbahan', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pengajuanbahandetail_id, golbahanmakanan_id, satuanbahan, bahanmakanan_id, pengajuanbahanmkn_id, terimabahandetail_id, nourutbahan, ukuranbahan, merkbahan, jmlkemasan, qty_pengajuan, satuanbahan, harganettobhn, , persendiscount, persenppn, persenpph', 'safe', 'on'=>'search'),
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
                    'golbahanmakanan'=>array(self::BELONGS_TO, 'GolbahanmakananM', 'golbahanmakanan_id'),
                    'bahanmakanan'=>array(self::BELONGS_TO,'BahanmakananM','bahanmakanan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pengajuanbahandetail_id' => 'Pengajuan Bahan Detail',
			'golbahanmakanan_id' => 'Golongan Bahan Makanan',
			'bahanmakanan_id' => 'Bahan Makanan',
			'pengajuanbahanmkn_id' => 'Pengajuan Bahan Makan',
			'terimabahandetail_id' => 'Terima Bahan Detail',
			'nourutbahan' => 'No. Urut Bahan',
			'ukuranbahan' => 'Ukuran Bahan',
			'merkbahan' => 'Merk Bahan',
			'jmlkemasan' => 'Jumlah Kemasan',
			'qty_pengajuan' => 'Jumlah Pengajuan',
			'satuanbahan' => 'Satuan Bahan',
			'harganettobhn' => 'Harga Netto Bahan',
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

		$criteria->compare('pengajuanbahandetail_id',$this->pengajuanbahandetail_id);
		$criteria->compare('golbahanmakanan_id',$this->golbahanmakanan_id);
		$criteria->compare('bahanmakanan_id',$this->bahanmakanan_id);
		$criteria->compare('pengajuanbahanmkn_id',$this->pengajuanbahanmkn_id);
		$criteria->compare('terimabahandetail_id',$this->terimabahandetail_id);
		$criteria->compare('nourutbahan',$this->nourutbahan);
		$criteria->compare('LOWER(ukuranbahan)',strtolower($this->ukuranbahan),true);
		$criteria->compare('LOWER(merkbahan)',strtolower($this->merkbahan),true);
		$criteria->compare('jmlkemasan',$this->jmlkemasan);
		$criteria->compare('qty_pengajuan',$this->qty_pengajuan);
		$criteria->compare('LOWER(satuanbahan)',strtolower($this->satuanbahan),true);
		$criteria->compare('harganettobhn',$this->harganettobhn);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('pengajuanbahandetail_id',$this->pengajuanbahandetail_id);
		$criteria->compare('golbahanmakanan_id',$this->golbahanmakanan_id);
		$criteria->compare('bahanmakanan_id',$this->bahanmakanan_id);
		$criteria->compare('pengajuanbahanmkn_id',$this->pengajuanbahanmkn_id);
		$criteria->compare('terimabahandetail_id',$this->terimabahandetail_id);
		$criteria->compare('nourutbahan',$this->nourutbahan);
		$criteria->compare('LOWER(ukuranbahan)',strtolower($this->ukuranbahan),true);
		$criteria->compare('LOWER(merkbahan)',strtolower($this->merkbahan),true);
		$criteria->compare('jmlkemasan',$this->jmlkemasan);
		$criteria->compare('qty_pengajuan',$this->qty_pengajuan);
		$criteria->compare('LOWER(satuanbahan)',strtolower($this->satuanbahan),true);
		$criteria->compare('harganettobhn',$this->harganettobhn);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}