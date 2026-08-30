<?php

/**
 * This is the model class for table "pesanbarangdetail_t".
 *
 * The followings are the available columns in table 'pesanbarangdetail_t':
 * @property integer $pesanbarangdetail_id
 * @property integer $barang_id
 * @property integer $pesanbarang_id
 * @property double $qty_pesan
 * @property string $satuanbarang
 */
class PesanbarangdetailT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PesanbarangdetailT the static model class
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
		return 'pesanbarangdetail_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('barang_id, pesanbarang_id, qty_pesan', 'required'),
			array('barang_id, pesanbarang_id', 'numerical', 'integerOnly'=>true),
			array('qty_pesan', 'numerical'),
			array('satuanbarang', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pesanbarangdetail_id, barang_id, pesanbarang_id, qty_pesan, satuanbarang', 'safe', 'on'=>'search'),
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
			'pesanbarangdetail_id' => 'Pesan Barang Detail',
			'barang_id' => 'Barang',
			'pesanbarang_id' => 'Pesan Barang',
			'qty_pesan' => 'Jumlah Pesan',
			'satuanbarang' => 'Satuan Barang',
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

		$criteria->compare('pesanbarangdetail_id',$this->pesanbarangdetail_id);
		$criteria->compare('barang_id',$this->barang_id);
		$criteria->compare('pesanbarang_id',$this->pesanbarang_id);
		$criteria->compare('qty_pesan',$this->qty_pesan);
		$criteria->compare('LOWER(satuanbarang)',strtolower($this->satuanbarang),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('pesanbarangdetail_id',$this->pesanbarangdetail_id);
		$criteria->compare('barang_id',$this->barang_id);
		$criteria->compare('pesanbarang_id',$this->pesanbarang_id);
		$criteria->compare('qty_pesan',$this->qty_pesan);
		$criteria->compare('LOWER(satuanbarang)',strtolower($this->satuanbarang),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
        public function getQty_mutasi() {
            $tot_mutasi = 0;
            $cr = new CDbCriteria();
            $cr->join = 'join mutasibrg_t m on m.mutasibrg_id = t.mutasibrg_id';
            $cr->compare('t.barang_id', $this->barang_id);
            $cr->compare('m.pesanbarang_id', $this->pesanbarang_id);
            
            $det = MutasibrgdetailT::model()->findAll($cr);
            
            foreach ($det as $item) {
                $tot_mutasi += $item->qty_mutasi;
            }
            
            return $tot_mutasi;
            
        }
}