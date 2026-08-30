<?php

/**
 * This is the model class for table "terimapersdetail_t".
 *
 * The followings are the available columns in table 'terimapersdetail_t':
 * @property integer $terimapersdetail_id
 * @property integer $inventarisasi_id
 * @property integer $terimapersediaan_id
 * @property integer $retpendetail_id
 * @property integer $barang_id
 * @property double $hargabeli
 * @property double $hargasatuan
 * @property double $jmlterima
 * @property string $satuanbeli
 * @property integer $jmldalamkemasan
 * @property string $kondisibarang
 */
class TerimapersdetailT extends CActiveRecord
{
        public $jmlbeli, $total, $jmlppn, $jmlpph;
        public $hargasatuanmaster, $namabarangmaster, $hppcheck;
        
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TerimapersdetailT the static model class
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
		return 'terimapersdetail_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('terimapersediaan_id, barang_id, hargabeli, hargasatuan, jmlterima, satuanbeli, jmldalamkemasan, kondisibarang', 'required'),
			array('inventarisasi_id, terimapersediaan_id, retpendetail_id, barang_id, jmldalamkemasan', 'numerical', 'integerOnly'=>true),
			array('hargabeli, hargasatuan, jmlterima, persendiscount, jmldiscount, persenppn, persenpph', 'numerical'),
			array('satuanbeli, kondisibarang', 'length', 'max'=>50),
                        array('jmlbeli, persendiscount, jmldiscount, persenppn, persenpph', 'safe'),
                        array('jmlterima','cekTerima'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('terimapersdetail_id, inventarisasi_id, terimapersediaan_id, retpendetail_id, barang_id, hargabeli, hargasatuan, jmlterima, satuanbeli, jmldalamkemasan, kondisibarang, persendiscount, jmldiscount, persenppn, persenpph', 'safe', 'on'=>'search'),
		);
	}
        
        public function cekTerima($attribute,$params){
            if (!$this->hasErrors()){
                if (!empty($this->jmlbeli)){
                    if ($this->jmlterima > $this->jmlbeli){
                        $this->addError('jmlretur','Jumlah terima tidak boleh lebih dari '.$this->jmlbeli);
                    }
                }
            }
        }

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
                    'barang'=>array(self::BELONGS_TO, 'BarangM', 'barang_id'),
                    'inventaris'=>array(self::BELONGS_TO, 'InventarisasiruanganT', 'inventarisasi_id'),
                    'terimapersediaan'=>array(self::BELONGS_TO, 'TerimapersediaanT', 'terimapersediaan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'terimapersdetail_id' => 'Terima Persediaan Detail',
			'inventarisasi_id' => 'Inventarisasi',
			'terimapersediaan_id' => 'Terima Persediaan',
			'retpendetail_id' => 'Retur Penerimaan Detail',
			'barang_id' => 'Barang',
			'hargabeli' => 'Harga Beli',
			'hargasatuan' => 'Harga Satuan',
			'jmlterima' => 'Jumlah Terima',
			'satuanbeli' => 'Satuan Beli',
			'jmldalamkemasan' => 'Jumlah Dalam Kemasan',
			'kondisibarang' => 'Kondisi Barang',
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

		$criteria->compare('terimapersdetail_id',$this->terimapersdetail_id);
		$criteria->compare('inventarisasi_id',$this->inventarisasi_id);
		$criteria->compare('terimapersediaan_id',$this->terimapersediaan_id);
		$criteria->compare('retpendetail_id',$this->retpendetail_id);
		$criteria->compare('barang_id',$this->barang_id);
		$criteria->compare('hargabeli',$this->hargabeli);
		$criteria->compare('hargasatuan',$this->hargasatuan);
		$criteria->compare('jmlterima',$this->jmlterima);
		$criteria->compare('LOWER(satuanbeli)',strtolower($this->satuanbeli),true);
		$criteria->compare('jmldalamkemasan',$this->jmldalamkemasan);
		$criteria->compare('LOWER(kondisibarang)',strtolower($this->kondisibarang),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('terimapersdetail_id',$this->terimapersdetail_id);
		$criteria->compare('inventarisasi_id',$this->inventarisasi_id);
		$criteria->compare('terimapersediaan_id',$this->terimapersediaan_id);
		$criteria->compare('retpendetail_id',$this->retpendetail_id);
		$criteria->compare('barang_id',$this->barang_id);
		$criteria->compare('hargabeli',$this->hargabeli);
		$criteria->compare('hargasatuan',$this->hargasatuan);
		$criteria->compare('jmlterima',$this->jmlterima);
		$criteria->compare('LOWER(satuanbeli)',strtolower($this->satuanbeli),true);
		$criteria->compare('jmldalamkemasan',$this->jmldalamkemasan);
		$criteria->compare('LOWER(kondisibarang)',strtolower($this->kondisibarang),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}