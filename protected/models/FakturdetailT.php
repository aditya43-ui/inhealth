<?php

/**
 * This is the model class for table "fakturdetail_t".
 *
 * The followings are the available columns in table 'fakturdetail_t':
 * @property integer $fakturdetail_id
 * @property integer $satuankecil_id
 * @property integer $penerimaandetail_id
 * @property integer $fakturpembelian_id
 * @property integer $satuanbesar_id
 * @property integer $obatalkes_id
 * @property integer $sumberdana_id
 * @property integer $returdetail_id
 * @property double $jmlterima
 * @property double $harganettofaktur
 * @property double $persenppnfaktur
 * @property double $persenpphfaktur
 * @property double $persendiscount
 * @property double $jmldiscount
 * @property double $hargasatuan
 * @property string $tglkadaluarsa
 * @property double $kemasanbesar
 *
 * The followings are the available model relations:
 * @property PenerimaandetailT[] $penerimaandetailTs
 * @property ReturdetailT[] $returdetailTs
 * @property FakturpembelianT $fakturpembelian
 * @property ObatalkesM $obatalkes
 * @property PenerimaandetailT $penerimaandetail
 * @property ReturdetailT $returdetail
 * @property SatuanbesarM $satuanbesar
 * @property SatuankecilM $satuankecil
 * @property SumberdanaM $sumberdana
 */
class FakturdetailT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return FakturdetailT the static model class
	 */
        public $total_bruto,$total_netto,$total_discount,$total_ppn,$total_bayar,$total_tagihan,$total_sisa,$persendiscount,$ppn;
        public $totalpajakppn,$hargabelibesar,$jmlterima,$kemasanbesar;
        public $obatalkes_kode,$obatalkes_nama,$satuanbesar_nama,$persenppnfaktur,$persenpphfaktur;
		public $harganettoubah;
        public $harganettopermaster, $hppcheck, $namaobatmaster, $jmlppn, $jmlpph;
        
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'fakturdetail_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('fakturpembelian_id', 'required'),
			array('satuankecil_id, penerimaandetail_id, fakturpembelian_id, satuanbesar_id, obatalkes_id, sumberdana_id, returdetail_id', 'numerical', 'integerOnly'=>true),
			array('jmlterima, harganettofaktur, persenppnfaktur, persenpphfaktur, persendiscount, jmldiscount, hargasatuan, kemasanbesar', 'numerical'),
			array('tglkadaluarsa', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('fakturdetail_id, satuankecil_id, penerimaandetail_id, fakturpembelian_id, satuanbesar_id, obatalkes_id, sumberdana_id, returdetail_id, jmlterima, harganettofaktur, persenppnfaktur, persenpphfaktur, persendiscount, jmldiscount, hargasatuan, tglkadaluarsa, kemasanbesar', 'safe', 'on'=>'search'),
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
			'penerimaandetailTs' => array(self::HAS_MANY, 'PenerimaandetailT', 'fakturdetail_id'),
			'returdetailTs' => array(self::HAS_MANY, 'ReturdetailT', 'fakturdetail_id'),
			'fakturpembelian' => array(self::BELONGS_TO, 'FakturpembelianT', 'fakturpembelian_id'),
			'obatalkes' => array(self::BELONGS_TO, 'ObatalkesM', 'obatalkes_id'),
			'penerimaandetail' => array(self::BELONGS_TO, 'PenerimaandetailT', 'penerimaandetail_id'),
			'returdetail' => array(self::BELONGS_TO, 'ReturdetailT', 'returdetail_id'),
			'satuanbesar' => array(self::BELONGS_TO, 'SatuanbesarM', 'satuanbesar_id'),
			'satuankecil' => array(self::BELONGS_TO, 'SatuankecilM', 'satuankecil_id'),
			'sumberdana' => array(self::BELONGS_TO, 'SumberdanaM', 'sumberdana_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'fakturdetail_id' => 'Fakturdetail',
			'satuankecil_id' => 'Satuankecil',
			'penerimaandetail_id' => 'Penerimaandetail',
			'fakturpembelian_id' => 'Faktur Pembelian',
			'satuanbesar_id' => 'Satuanbesar',
			'obatalkes_id' => 'Obatalkes',
			'sumberdana_id' => 'Sumberdana',
			'returdetail_id' => 'Returdetail',
			'jmlterima' => 'Jmlterima',
			'harganettofaktur' => 'Harganettofaktur',
			'persenppnfaktur' => 'Persenppnfaktur',
			'persenpphfaktur' => 'Persenpphfaktur',
			'persendiscount' => 'Persen Keringanan',
			'jmldiscount' => 'Jumlah Keringanan',
			'hargasatuan' => 'Hargasatuan',
			'tglkadaluarsa' => 'Tglkadaluarsa',
			'kemasanbesar' => 'Kemasanbesar',
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

		$criteria->compare('fakturdetail_id',$this->fakturdetail_id);
		$criteria->compare('satuankecil_id',$this->satuankecil_id);
		$criteria->compare('penerimaandetail_id',$this->penerimaandetail_id);
		$criteria->compare('fakturpembelian_id',$this->fakturpembelian_id);
		$criteria->compare('satuanbesar_id',$this->satuanbesar_id);
		$criteria->compare('obatalkes_id',$this->obatalkes_id);
		$criteria->compare('sumberdana_id',$this->sumberdana_id);
		$criteria->compare('returdetail_id',$this->returdetail_id);
		$criteria->compare('jmlterima',$this->jmlterima);
		$criteria->compare('harganettofaktur',$this->harganettofaktur);
		$criteria->compare('persenppnfaktur',$this->persenppnfaktur);
		$criteria->compare('persenpphfaktur',$this->persenpphfaktur);
		$criteria->compare('persendiscount',$this->persendiscount);
		$criteria->compare('jmldiscount',$this->jmldiscount);
		$criteria->compare('hargasatuan',$this->hargasatuan);
		$criteria->compare('tglkadaluarsa',$this->tglkadaluarsa,true);
		$criteria->compare('kemasanbesar',$this->kemasanbesar);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}