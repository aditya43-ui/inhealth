<?php

/**
 * This is the model class for table "belibrgdetail_t".
 *
 * The followings are the available columns in table 'belibrgdetail_t':
 * @property integer $belibrgdetail_id
 * @property integer $pembelianbarang_id
 * @property integer $barang_id
 * @property double $hargabeli
 * @property double $hargasatuan
 * @property double $jmlbeli
 * @property integer $jmldlmkemasan
 * @property string $satuanbeli
 */
class BelibrgdetailT extends CActiveRecord
{
    public $jmldiscount, $persenppn, $jmlpph;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BelibrgdetailT the static model class
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
		return 'belibrgdetail_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pembelianbarang_id, barang_id, hargabeli, hargasatuan, jmlbeli, satuanbeli', 'required'),
			array('pembelianbarang_id, barang_id, jmldlmkemasan', 'numerical', 'integerOnly'=>true),
			array('hargabeli, hargasatuan, jmlbeli, persendiscount, persenpph, persen_ppn, hpp, ppn', 'numerical'),
			array('satuanbeli', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('belibrgdetail_id, pembelianbarang_id, barang_id, hargabeli, hargasatuan, jmlbeli, jmldlmkemasan, satuanbeli, persendiscount, persenpph, persen_ppn, hpp, ppn', 'safe', 'on'=>'search'),
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
                    'barang'=>array(self::BELONGS_TO, 'BarangM', 'barang_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'belibrgdetail_id' => 'ID',
			'pembelianbarang_id' => 'Pembelian Barang',
			'barang_id' => 'Barang',
			'hargabeli' => 'Harga Beli',
			'hargasatuan' => 'Harga Satuan',
			'jmlbeli' => 'Jumlah Beli',
			'jmldlmkemasan' => 'Jumlah dalam Kemasan',
			'satuanbeli' => 'Satuan Beli',
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

		$criteria->compare('belibrgdetail_id',$this->belibrgdetail_id);
		$criteria->compare('pembelianbarang_id',$this->pembelianbarang_id);
		$criteria->compare('barang_id',$this->barang_id);
		$criteria->compare('hargabeli',$this->hargabeli);
		$criteria->compare('hargasatuan',$this->hargasatuan);
		$criteria->compare('jmlbeli',$this->jmlbeli);
		$criteria->compare('jmldlmkemasan',$this->jmldlmkemasan);
		$criteria->compare('LOWER(satuanbeli)',strtolower($this->satuanbeli),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('belibrgdetail_id',$this->belibrgdetail_id);
		$criteria->compare('pembelianbarang_id',$this->pembelianbarang_id);
		$criteria->compare('barang_id',$this->barang_id);
		$criteria->compare('hargabeli',$this->hargabeli);
		$criteria->compare('hargasatuan',$this->hargasatuan);
		$criteria->compare('jmlbeli',$this->jmlbeli);
		$criteria->compare('jmldlmkemasan',$this->jmldlmkemasan);
		$criteria->compare('LOWER(satuanbeli)',strtolower($this->satuanbeli),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}