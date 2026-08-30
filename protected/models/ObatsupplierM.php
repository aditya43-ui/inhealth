<?php

/**
 * This is the model class for table "obatsupplier_m".
 *
 * The followings are the available columns in table 'obatsupplier_m':
 * @property integer $obatalkes_id
 * @property integer $supplier_id
 * @property double $belinonppn
 * @property double $disc1
 * @property double $disc2
 * @property double $beliplusdisc
 * @property double $ppn
 * @property double $othercost
 * @property double $totalbeliplusppn
 */
class ObatsupplierM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ObatsupplierM the static model class
	 */
        public $supplier_nama, $supplier_kode, $supplier_telp, $supplier_fax, $supplier_alamat, $obatAlkes;
        public $supplier_propinsi, $supplier_kabupaten,$belinonppn,$disc1,$disc2,$beliplusdisc,$ppn,$othercost, $supplier_aktif, $totalbeliplusppn,$obatalkes_nama,$obatalkes_kodeobat, $obatalkes_sumberdana;
        public $obatalkes_golongan, $obatalkes_kategori, $jenisobatalkes_nama, $jenisobatalkes_id;
        public $tglkadaluarsa, $satuankecil_nama, $stok;
        public $sumberdana_id;
        
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'obatsupplier_m';
	}
        
        
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('obatalkes_id, supplier_id', 'required'),
                        array('obatalkes_id, supplier_id', 'cekdata'),
			array('obatalkes_id, supplier_id, satuankecil_id, satuanbesar_id,obatsupplier_id,', 'numerical', 'integerOnly'=>true),
                        array('obatalkes_id, supplier_id, obatsupplier_id, obatAlkes,ppn_persen, hargabelikecil, hargabelibesar, diskon_persen' , 'safe'),
                        array('obatalkes_kodeobat, obatsupplier_id, obatalkes_sumberdana, obatalkes_nama, obatalkes_id, supplier_id,obatAlkes, 
                                    satuankecil_id, satuanbesar_id, hargabelibesar, diskon_persen, hargabelikecil, ppn_persen,supplier_kode,supplier_nama,supplier_alamat,obatalkes_nama', 
                                    'safe', 'on'=>'search'),
                    
//                        array('obatalkes_id, supplier_id', 'application.extensions.uniqueMultiColumnValidator'),
//                       array('obatalkes_id', 'unique', 'criteria'=>array(
//                            'condition'=>'supplier_id=:secondKey',
//                            'params'=>array(
//                                ':secondKey'=>$this->supplier_id
//                            )
//                        )),
//			array('belinonppn, disc1, disc2, beliplusdisc, ppn, othercost, totalbeliplusppn', 'numerical'),
			// The following rule is used by search().
			

			// Please remove those attributes that should not be searched.
			
		);
	}

          public function cekdata($attribute, $params)
                {
                    $querydata = ObatsupplierM::model()->findAllByAttributes(array('obatalkes_id'=>$this->obatalkes_id, 'supplier_id'=>$this->supplier_id));
                    if (!$this->hasErrors()) {
                        if (count((array)$querydata) > 0)
                        {
                            $this->addError('obatalkes_id, supplier_id', 'Barang '.$this->obatalkes->obatalkes_nama.' dengan Supplier '.$this->supplier->supplier_nama. ' telah tersedia di database');
                            return false;
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
                    'supplier'=>array(self::BELONGS_TO,'SupplierM','supplier_id'),
                    'obatalkes'=>array(self::BELONGS_TO,'ObatalkesM','obatalkes_id'),
                    'satuankecil'=>array(self::BELONGS_TO,'SatuankecilM','satuankecil_id'),
                    'satuanbesar'=>array(self::BELONGS_TO,'SatuanbesarM','satuanbesar_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'obatalkes_id' => 'Obat Alkes',
			'supplier_id' => 'Supplier',
                        'obatsupplier_id'=>'Obat Supplier',
                        'satuankecil_id'=>'Satuan Kecil',
                        'satuanbesar_id'=>'Satuan Besar',
                        'hargabelibesar'=>'Harga Beli Besar',
                        'diskon_persen'=>'Keringanan',
                        'hargabelikecil'=>'Harga Beli Kecil',
                        'ppn_persen'=>'Ppn',
                        'obatalkes_nama'=>'Nama Obat Alkes',
			
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

		$criteria->compare('obatalkes_id',$this->obatalkes_id);
		$criteria->compare('obatsupplier_id',$this->obatsupplier_id);
		$criteria->compare('supplier_id',$this->supplier_id);
		$criteria->compare('satuankecil_id',$this->satuankecil_id);
		$criteria->compare('satuanbesar_id',$this->satuanbesar_id);
		$criteria->compare('hargabelibesar',$this->hargabelibesar);
		$criteria->compare('diskon_persen',$this->diskon_persen);
		$criteria->compare('hargabelikecil',$this->hargabelikecil);
		$criteria->compare('ppn_persen',$this->ppn_persen);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        /**
         * method untuk mendapatkan obat supplier
         * digunakan pada gudangFarmasi/PermintaanPenawaran/index dialog obat alkes supplier
         * @return \CActiveDataProvider
         */
        public function searchObatSupplierGF()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;


                $criteria->with = array('obatalkes','supplier');
		$criteria->compare('LOWER(obatalkes.obatalkes_nama)',  strtolower($this->obatalkes_nama),true);
		$criteria->compare('LOWER(obatalkes.obatalkes_kode)',  strtolower($this->obatalkes_kodeobat),true);
                $criteria->compare('LOWER(supplier.supplier_nama)',strtolower($this->supplier_nama),true);
		$criteria->compare('LOWER(supplier.supplier_kode)',strtolower($this->supplier_kode),true);
		$criteria->compare('LOWER(supplier.supplier_alamat)',strtolower($this->supplier_alamat),true);
		$criteria->compare('t.obatalkes_id',$this->obatalkes_id);
		$criteria->compare('t.supplier_id',$this->supplier_id);
		$criteria->compare('t.obatsupplier_id',$this->obatsupplier_id);
		$criteria->compare('t.satuankecil_id',$this->satuankecil_id);
		$criteria->compare('t.satuanbesar_id',$this->satuanbesar_id);
		$criteria->compare('t.hargabelibesar',$this->hargabelibesar);
		$criteria->compare('t.diskon_persen',$this->diskon_persen);
		$criteria->compare('t.hargabelikecil',$this->hargabelikecil);
		$criteria->compare('t.ppn_persen',$this->ppn_persen);
                $criteria->order='supplier.supplier_kode ASC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function searchPOS()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

                $criteria->with = array('obatalkes','supplier');
		$criteria->compare('t.obatalkes_id',$this->obatalkes_id);
		$criteria->compare('t.supplier_id',$this->supplier_id);
		$criteria->compare('t.obatsupplier_id',$this->obatsupplier_id);
		$criteria->compare('satuankecil_id',$this->satuankecil_id);
		$criteria->compare('satuanbesar_id',$this->satuanbesar_id);
		$criteria->compare('hargabelibesar',$this->hargabelibesar);
		$criteria->compare('diskon_persen',$this->diskon_persen);
		$criteria->compare('hargabelikecil',$this->hargabelikecil);
		$criteria->compare('ppn_persen',$this->ppn_persen);
                $criteria->compare('obatalkes.obatalkes_farmasi','false');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('obatalkes_id',$this->obatalkes_id);
		$criteria->compare('supplier_id',$this->supplier_id);
		$criteria->compare('obatsupplier_id',$this->obatsupplier_id);
		$criteria->compare('satuankecil_id',$this->satuankecil_id);
		$criteria->compare('satuanbesar_id',$this->satuanbesar_id);
		$criteria->compare('hargabelibesar',$this->hargabelibesar);
		$criteria->compare('diskon_persen',$this->diskon_persen);
		$criteria->compare('hargabelikecil',$this->hargabelikecil);
		$criteria->compare('ppn_persen',$this->ppn_persen);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        public function searchObatSupplier()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

//                $criteria->with = array('obatalkes','supplier');
                $criteria->select=' supplier_m.supplier_kode, supplier_m.supplier_nama, supplier_m.supplier_aktif, supplier_m.supplier_id, obatalkes_m.obatalkes_nama,obatalkes_m.obatalkes_id';
                $criteria->join = 'LEFT JOIN supplier_m ON supplier_m.supplier_id=t.supplier_id LEFT JOIN obatalkes_m ON obatalkes_m.obatalkes_id=t.obatalkes_id';
                $criteria->compare('obatalkes_m.obatalkes_id',$this->obatalkes_id);
		$criteria->compare('supplier_m.supplier_id',$this->supplier_id);
                $criteria->compare('LOWER(obatalkes_m.obatalkes_nama)',strtolower('$this->obatalkes_nama'));
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function getObatNama(){
		return $this->obatalkes->obatalkes_nama;
	}
	
	public function getSatuanKecil(){
		return $this->obatalkes->satuankecil->satuankecil_nama;
	}
	
	public function getSatuanBesar(){
		return $this->obatalkes->satuanbesar->satuanbesar_nama;
	}
}