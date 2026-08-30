<?php

/**
 * This is the model class for table "rincianfakturhutangsupplier_v".
 *
 * The followings are the available columns in table 'rincianfakturhutangsupplier_v':
 * @property string $nofaktur
 * @property string $tglfaktur
 * @property string $tgljatuhtempo
 * @property string $keteranganfaktur
 * @property integer $fakturpembelian_id
 * @property integer $supplier_id
 * @property string $supplier_kode
 * @property string $supplier_nama
 * @property double $saldotransaksi
 * @property integer $struktur_id
 * @property string $kdstruktur
 * @property string $nmstruktur
 * @property integer $kelompok_id
 * @property string $kdkelompok
 * @property string $nmkelompok
 * @property integer $jenis_id
 * @property string $kdjenis
 * @property string $nmjenis
 * @property integer $obyek_id
 * @property string $kdobyek
 * @property string $nmobyek
 * @property integer $rincianobyek_id
 * @property string $kdrincianobyek
 * @property string $nmrincianobyek
 * @property string $saldonormal
 */
class RincianfakturhutangsupplierV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RincianfakturhutangsupplierV the static model class
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
		return 'rincianfakturhutangsupplier_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('fakturpembelian_id, supplier_id, struktur_id, kelompok_id, jenis_id, obyek_id, rincianobyek_id', 'numerical', 'integerOnly'=>true),
			array('saldotransaksi', 'numerical'),
			array('nofaktur', 'length', 'max'=>50),
			array('supplier_kode, saldonormal', 'length', 'max'=>10),
			array('supplier_nama, nmstruktur', 'length', 'max'=>100),
			array('kdstruktur, kdkelompok, kdjenis, kdobyek, kdrincianobyek', 'length', 'max'=>5),
			array('nmkelompok', 'length', 'max'=>200),
			array('nmjenis', 'length', 'max'=>300),
			array('nmobyek', 'length', 'max'=>400),
			array('nmrincianobyek', 'length', 'max'=>500),
			array('tglfaktur, tgljatuhtempo, keteranganfaktur', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('nofaktur, tglfaktur, tgljatuhtempo, keteranganfaktur, fakturpembelian_id, supplier_id, supplier_kode, supplier_nama, saldotransaksi, struktur_id, kdstruktur, nmstruktur, kelompok_id, kdkelompok, nmkelompok, jenis_id, kdjenis, nmjenis, obyek_id, kdobyek, nmobyek, rincianobyek_id, kdrincianobyek, nmrincianobyek, saldonormal', 'safe', 'on'=>'search'),
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
			'nofaktur' => 'No. Faktur',
			'tglfaktur' => 'Tgl. Faktur',
			'tgljatuhtempo' => 'Tgl. Jatuh Tempo',
			'keteranganfaktur' => 'Keterangan Faktur',
			'fakturpembelian_id' => 'Faktur Pembelian',
			'supplier_id' => 'Supplier',
			'supplier_kode' => 'Kode Supplier',
			'supplier_nama' => 'Nama Supplier',
			'saldotransaksi' => 'Saldotransaksi',
			'struktur_id' => 'Struktur',
			'kdstruktur' => 'Kdstruktur',
			'nmstruktur' => 'Nmstruktur',
			'kelompok_id' => 'Kelompok',
			'kdkelompok' => 'Kdkelompok',
			'nmkelompok' => 'Nmkelompok',
			'jenis_id' => 'Jenis',
			'kdjenis' => 'Kdjenis',
			'nmjenis' => 'Nmjenis',
			'obyek_id' => 'Obyek',
			'kdobyek' => 'Kdobyek',
			'nmobyek' => 'Nmobyek',
			'rincianobyek_id' => 'Rincianobyek',
			'kdrincianobyek' => 'Kdrincianobyek',
			'nmrincianobyek' => 'Nmrincianobyek',
			'saldonormal' => 'Saldo Normal',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CdbCriteria that can return criterias.
	 */
	public function criteriaSearch()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('LOWER(nofaktur)',strtolower($this->nofaktur),true);
		$criteria->compare('LOWER(tglfaktur)',strtolower($this->tglfaktur),true);
		$criteria->compare('LOWER(tgljatuhtempo)',strtolower($this->tgljatuhtempo),true);
		$criteria->compare('LOWER(keteranganfaktur)',strtolower($this->keteranganfaktur),true);
		if(!empty($this->fakturpembelian_id)){
			$criteria->addCondition('fakturpembelian_id = '.$this->fakturpembelian_id);
		}
		if(!empty($this->supplier_id)){
			$criteria->addCondition('supplier_id = '.$this->supplier_id);
		}
		$criteria->compare('LOWER(supplier_kode)',strtolower($this->supplier_kode),true);
		$criteria->compare('LOWER(supplier_nama)',strtolower($this->supplier_nama),true);
		$criteria->compare('saldotransaksi',$this->saldotransaksi);
		if(!empty($this->struktur_id)){
			$criteria->addCondition('struktur_id = '.$this->struktur_id);
		}
		$criteria->compare('LOWER(kdstruktur)',strtolower($this->kdstruktur),true);
		$criteria->compare('LOWER(nmstruktur)',strtolower($this->nmstruktur),true);
		if(!empty($this->kelompok_id)){
			$criteria->addCondition('kelompok_id = '.$this->kelompok_id);
		}
		$criteria->compare('LOWER(kdkelompok)',strtolower($this->kdkelompok),true);
		$criteria->compare('LOWER(nmkelompok)',strtolower($this->nmkelompok),true);
		if(!empty($this->jenis_id)){
			$criteria->addCondition('jenis_id = '.$this->jenis_id);
		}
		$criteria->compare('LOWER(kdjenis)',strtolower($this->kdjenis),true);
		$criteria->compare('LOWER(nmjenis)',strtolower($this->nmjenis),true);
		if(!empty($this->obyek_id)){
			$criteria->addCondition('obyek_id = '.$this->obyek_id);
		}
		$criteria->compare('LOWER(kdobyek)',strtolower($this->kdobyek),true);
		$criteria->compare('LOWER(nmobyek)',strtolower($this->nmobyek),true);
		if(!empty($this->rincianobyek_id)){
			$criteria->addCondition('rincianobyek_id = '.$this->rincianobyek_id);
		}
		$criteria->compare('LOWER(kdrincianobyek)',strtolower($this->kdrincianobyek),true);
		$criteria->compare('LOWER(nmrincianobyek)',strtolower($this->nmrincianobyek),true);
		$criteria->compare('LOWER(saldonormal)',strtolower($this->saldonormal),true);

		return $criteria;
	}
        
        
        /**
         * Retrieves a list of models based on the current search/filter conditions.
         * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
         */
        public function search()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            $criteria->limit=10;

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }


        public function searchPrint()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            $criteria->limit=-1; 

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false,
            ));
        }
}