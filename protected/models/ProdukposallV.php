<?php

/**
 * This is the model class for table "produkposall_v".
 *
 * The followings are the available columns in table 'produkposall_v':
 * @property integer $brg_id
 * @property integer $category_id
 * @property string $category_name
 * @property integer $subcategory_id
 * @property string $subcategory_code
 * @property string $subcategory_name
 * @property string $stock_code
 * @property integer $satuanbesar_id
 * @property string $satuanbesar_nama
 * @property integer $satuankecil_id
 * @property string $satuankecil_nama
 * @property string $stock_name
 * @property integer $jmldalamkemasan
 * @property integer $jmlisi
 * @property string $satuanisi
 * @property double $harganetto
 * @property double $hargajual
 * @property double $discount
 * @property integer $minimalstok
 * @property string $barang_barcode
 * @property double $ppn_persen
 * @property string $activedate
 * @property boolean $mintransaksi
 * @property string $price_name
 * @property double $margin
 * @property double $gp_persen
 * @property integer $sumberdana_id
 * @property double $movingavarage
 */
class ProdukposallV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ProdukposallV the static model class
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
		return 'produkposall_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('brg_id, category_id, subcategory_id, satuanbesar_id, satuankecil_id, jmldalamkemasan, jmlisi, minimalstok, sumberdana_id', 'numerical', 'integerOnly'=>true),
			array('harganetto, hargajual, discount, ppn_persen, margin, gp_persen, movingavarage', 'numerical'),
			array('category_name, stock_code, satuanbesar_nama, satuankecil_nama, price_name', 'length', 'max'=>50),
			array('subcategory_code', 'length', 'max'=>10),
			array('subcategory_name', 'length', 'max'=>100),
			array('stock_name, barang_barcode', 'length', 'max'=>200),
			array('satuanisi', 'length', 'max'=>20),
			array('activedate, mintransaksi', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('brg_id, category_id, category_name, subcategory_id, subcategory_code, subcategory_name, stock_code, satuanbesar_id, satuanbesar_nama, satuankecil_id, satuankecil_nama, stock_name, jmldalamkemasan, jmlisi, satuanisi, harganetto, hargajual, discount, minimalstok, barang_barcode, ppn_persen, activedate, mintransaksi, price_name, margin, gp_persen, sumberdana_id, movingavarage', 'safe', 'on'=>'search'),
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
			'brg_id' => 'Brg',
			'category_id' => 'Category',
			'category_name' => 'Category Name',
			'subcategory_id' => 'Subcategory',
			'subcategory_code' => 'Subcategory Code',
			'subcategory_name' => 'Subcategory Name',
			'stock_code' => 'Stock Code',
			'satuanbesar_id' => 'Satuanbesar',
			'satuanbesar_nama' => 'Satuanbesar Nama',
			'satuankecil_id' => 'Satuankecil',
			'satuankecil_nama' => 'Satuankecil Nama',
			'stock_name' => 'Stock Name',
			'jmldalamkemasan' => 'Jmldalamkemasan',
			'jmlisi' => 'Jmlisi',
			'satuanisi' => 'Satuanisi',
			'harganetto' => 'Harganetto',
			'hargajual' => 'Hargajual',
			'discount' => 'Keringanan',
			'minimalstok' => 'Minimalstok',
			'barang_barcode' => 'Barang Barcode',
			'ppn_persen' => 'Ppn Persen',
			'activedate' => 'Activedate',
			'mintransaksi' => 'Mintransaksi',
			'price_name' => 'Price Name',
			'margin' => 'Margin',
			'gp_persen' => 'Gp Persen',
			'sumberdana_id' => 'Sumberdana',
			'movingavarage' => 'Movingavarage',
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

		$criteria->compare('brg_id',$this->brg_id);
		$criteria->compare('category_id',$this->category_id);
		$criteria->compare('LOWER(category_name)',strtolower($this->category_name),true);
		$criteria->compare('subcategory_id',$this->subcategory_id);
		$criteria->compare('LOWER(subcategory_code)',strtolower($this->subcategory_code),true);
		$criteria->compare('LOWER(subcategory_name)',strtolower($this->subcategory_name),true);
		$criteria->compare('LOWER(stock_code)',strtolower($this->stock_code),true);
		$criteria->compare('satuanbesar_id',$this->satuanbesar_id);
		$criteria->compare('LOWER(satuanbesar_nama)',strtolower($this->satuanbesar_nama),true);
		$criteria->compare('satuankecil_id',$this->satuankecil_id);
		$criteria->compare('LOWER(satuankecil_nama)',strtolower($this->satuankecil_nama),true);
		$criteria->compare('LOWER(stock_name)',strtolower($this->stock_name),true);
		$criteria->compare('jmldalamkemasan',$this->jmldalamkemasan);
		$criteria->compare('jmlisi',$this->jmlisi);
		$criteria->compare('LOWER(satuanisi)',strtolower($this->satuanisi),true);
		$criteria->compare('harganetto',$this->harganetto);
		$criteria->compare('hargajual',$this->hargajual);
		$criteria->compare('discount',$this->discount);
		$criteria->compare('minimalstok',$this->minimalstok);
		$criteria->compare('LOWER(barang_barcode)',strtolower($this->barang_barcode),true);
		$criteria->compare('ppn_persen',$this->ppn_persen);
		$criteria->compare('LOWER(activedate)',strtolower($this->activedate),true);
		$criteria->compare('mintransaksi',$this->mintransaksi);
		$criteria->compare('LOWER(price_name)',strtolower($this->price_name),true);
		$criteria->compare('margin',$this->margin);
		$criteria->compare('gp_persen',$this->gp_persen);
		$criteria->compare('sumberdana_id',$this->sumberdana_id);
		$criteria->compare('movingavarage',$this->movingavarage);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('brg_id',$this->brg_id);
		$criteria->compare('category_id',$this->category_id);
		$criteria->compare('LOWER(category_name)',strtolower($this->category_name),true);
		$criteria->compare('subcategory_id',$this->subcategory_id);
		$criteria->compare('LOWER(subcategory_code)',strtolower($this->subcategory_code),true);
		$criteria->compare('LOWER(subcategory_name)',strtolower($this->subcategory_name),true);
		$criteria->compare('LOWER(stock_code)',strtolower($this->stock_code),true);
		$criteria->compare('satuanbesar_id',$this->satuanbesar_id);
		$criteria->compare('LOWER(satuanbesar_nama)',strtolower($this->satuanbesar_nama),true);
		$criteria->compare('satuankecil_id',$this->satuankecil_id);
		$criteria->compare('LOWER(satuankecil_nama)',strtolower($this->satuankecil_nama),true);
		$criteria->compare('LOWER(stock_name)',strtolower($this->stock_name),true);
		$criteria->compare('jmldalamkemasan',$this->jmldalamkemasan);
		$criteria->compare('jmlisi',$this->jmlisi);
		$criteria->compare('LOWER(satuanisi)',strtolower($this->satuanisi),true);
		$criteria->compare('harganetto',$this->harganetto);
		$criteria->compare('hargajual',$this->hargajual);
		$criteria->compare('discount',$this->discount);
		$criteria->compare('minimalstok',$this->minimalstok);
		$criteria->compare('LOWER(barang_barcode)',strtolower($this->barang_barcode),true);
		$criteria->compare('ppn_persen',$this->ppn_persen);
		$criteria->compare('LOWER(activedate)',strtolower($this->activedate),true);
		$criteria->compare('mintransaksi',$this->mintransaksi);
		$criteria->compare('LOWER(price_name)',strtolower($this->price_name),true);
		$criteria->compare('margin',$this->margin);
		$criteria->compare('gp_persen',$this->gp_persen);
		$criteria->compare('sumberdana_id',$this->sumberdana_id);
		$criteria->compare('movingavarage',$this->movingavarage);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}