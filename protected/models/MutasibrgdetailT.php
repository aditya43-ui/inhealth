<?php

/**
 * This is the model class for table "mutasibrgdetail_t".
 *
 * The followings are the available columns in table 'mutasibrgdetail_t':
 * @property integer $mutasibrgdetail_id
 * @property integer $inventarisasi_id
 * @property integer $barang_id
 * @property integer $batalmutasibrg_id
 * @property integer $mutasibrg_id
 * @property double $qty_mutasi
 * @property string $satuanbrg
 */
class MutasibrgdetailT extends CActiveRecord
{
        public $qty_pesan;
        public $barang_type, $barang_kode, $barang_nama, $barang_merk;
        public $barang_ukuran, $barang_ekonomis_thn, $satuanbarang;
		public $qty_stok;
		public $pesanbarangdetail_id;
        
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MutasibrgdetailT the static model class
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
		return 'mutasibrgdetail_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('barang_id, mutasibrg_id, qty_mutasi', 'required'),
			array('inventarisasi_id, barang_id, batalmutasibrg_id, mutasibrg_id', 'numerical', 'integerOnly'=>true),
			array('qty_mutasi', 'numerical'),
			array('satuanbrg', 'length', 'max'=>50),
                        array('qty_pesan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('mutasibrgdetail_id, inventarisasi_id, barang_id, batalmutasibrg_id, mutasibrg_id, qty_mutasi, satuanbrg', 'safe', 'on'=>'search'),
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
                    'inventarisasi'=>array(self::BELONGS_TO, 'InventarisasiruanganT', 'inventarisasi_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'mutasibrgdetail_id' => 'Mutasi Barang Detail',
			'inventarisasi_id' => 'Inventarisasi',
			'barang_id' => 'Barang',
			'batalmutasibrg_id' => 'Batal Mutasi Barang',
			'mutasibrg_id' => 'Mutasi Barang',
			'qty_mutasi' => 'Jumlah Mutasi',
			'satuanbrg' => 'Satuan Barang',
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

		$criteria->compare('mutasibrgdetail_id',$this->mutasibrgdetail_id);
		$criteria->compare('inventarisasi_id',$this->inventarisasi_id);
		$criteria->compare('barang_id',$this->barang_id);
		$criteria->compare('batalmutasibrg_id',$this->batalmutasibrg_id);
		$criteria->compare('mutasibrg_id',$this->mutasibrg_id);
		$criteria->compare('qty_mutasi',$this->qty_mutasi);
		$criteria->compare('LOWER(satuanbrg)',strtolower($this->satuanbrg),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('mutasibrgdetail_id',$this->mutasibrgdetail_id);
		$criteria->compare('inventarisasi_id',$this->inventarisasi_id);
		$criteria->compare('barang_id',$this->barang_id);
		$criteria->compare('batalmutasibrg_id',$this->batalmutasibrg_id);
		$criteria->compare('mutasibrg_id',$this->mutasibrg_id);
		$criteria->compare('qty_mutasi',$this->qty_mutasi);
		$criteria->compare('LOWER(satuanbrg)',strtolower($this->satuanbrg),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}