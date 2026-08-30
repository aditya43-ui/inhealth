<?php

/**
 * This is the model class for table "penerimaandetail_t".
 *
 * The followings are the available columns in table 'penerimaandetail_t':
 * @property integer $penerimaandetail_id
 * @property integer $penerimaanbarang_id
 * @property integer $satuankecil_id
 * @property integer $satuanbesar_id
 * @property integer $fakturdetail_id
 * @property integer $returdetail_id
 * @property integer $obatalkes_id
 * @property integer $stokobatalkes_id
 * @property integer $sumberdana_id
 * @property double $jmlpermintaan
 * @property double $jmlterima
 * @property double $persendiscount
 * @property double $jmldiscount
 * @property double $harganettoper
 * @property double $persenppn
 * @property double $persenpph
 * @property double $hargasatuanper
 * @property string $tglkadaluarsa
 * @property double $kemasanbesar
 * @property double $biaya_lainlain
 *
 * The followings are the available model relations:
 * @property StokobatalkesT[] $stokobatalkesTs
 * @property FakturdetailT $fakturdetail
 * @property ObatalkesM $obatalkes
 * @property PenerimaanbarangT $penerimaanbarang
 * @property ReturdetailT $returdetail
 * @property SatuanbesarM $satuanbesar
 * @property SatuankecilM $satuankecil
 * @property SumberdanaM $sumberdana
 * @property ReturdetailT[] $returdetailTs
 * @property FakturdetailT[] $fakturdetailTs
 */
class PenerimaandetailT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PenerimaandetailT the static model class
	 */
	public $checklist,$subtotal;
	public $isikemasan;
	public $jmlppn;
	public $jmlpph;
	public $satuankecil_nama;
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'penerimaandetail_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('penerimaanbarang_id, jmlpermintaan, jmlterima, persendiscount, jmldiscount, harganettoper, persenppn, persenpph, hargasatuanper, tglkadaluarsa, kemasanbesar, biaya_lainlain', 'required'),
			array('penerimaanbarang_id, satuankecil_id, satuanbesar_id, fakturdetail_id, returdetail_id, obatalkes_id, stokobatalkes_id, sumberdana_id', 'numerical', 'integerOnly'=>true),
			array('jmlpermintaan, jmlterima, persendiscount, jmldiscount, harganettoper, persenppn, persenpph, hargasatuanper, kemasanbesar, biaya_lainlain', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('penerimaandetail_id, penerimaanbarang_id, satuankecil_id, satuanbesar_id, fakturdetail_id, returdetail_id, obatalkes_id, stokobatalkes_id, sumberdana_id, jmlpermintaan, jmlterima, persendiscount, jmldiscount, harganettoper, persenppn, persenpph, hargasatuanper, tglkadaluarsa, kemasanbesar, biaya_lainlain', 'safe', 'on'=>'search'),
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
			'stokobatalkesTs' => array(self::HAS_MANY, 'StokobatalkesT', 'penerimaandetail_id'),
			'fakturdetail' => array(self::BELONGS_TO, 'FakturdetailT', 'fakturdetail_id'),
			'obatalkes' => array(self::BELONGS_TO, 'ObatalkesM', 'obatalkes_id'),
			'penerimaanbarang' => array(self::BELONGS_TO, 'PenerimaanbarangT', 'penerimaanbarang_id'),
			'returdetail' => array(self::BELONGS_TO, 'ReturdetailT', 'returdetail_id'),
			'satuanbesar' => array(self::BELONGS_TO, 'SatuanbesarM', 'satuanbesar_id'),
			'satuankecil' => array(self::BELONGS_TO, 'SatuankecilM', 'satuankecil_id'),
			'sumberdana' => array(self::BELONGS_TO, 'SumberdanaM', 'sumberdana_id'),
			'returdetailTs' => array(self::HAS_MANY, 'ReturdetailT', 'penerimaandetail_id'),
			'fakturdetailTs' => array(self::HAS_MANY, 'FakturdetailT', 'penerimaandetail_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'penerimaandetail_id' => 'Penerimaandetail',
			'penerimaanbarang_id' => 'Penerimaanbarang',
			'satuankecil_id' => 'Satuankecil',
			'satuanbesar_id' => 'Satuanbesar',
			'fakturdetail_id' => 'Fakturdetail',
			'returdetail_id' => 'Returdetail',
			'obatalkes_id' => 'Obatalkes',
			'stokobatalkes_id' => 'Stokobatalkes',
			'sumberdana_id' => 'Sumberdana',
			'jmlpermintaan' => 'Jmlpermintaan',
			'jmlterima' => 'Jmlterima',
			'persendiscount' => 'Persen Keringanan',
			'jmldiscount' => 'Jumlah Keringanan',
			'harganettoper' => 'Harganettoper',
			'persenppn' => 'Persenppn',
			'persenpph' => 'Persenpph',
			'hargasatuanper' => 'Hargasatuanper',
			'tglkadaluarsa' => 'Tglkadaluarsa',
			'kemasanbesar' => 'Kemasanbesar',
			'biaya_lainlain' => 'Biaya Lainlain',
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

		$criteria->compare('penerimaandetail_id',$this->penerimaandetail_id);
		$criteria->compare('penerimaanbarang_id',$this->penerimaanbarang_id);
		$criteria->compare('satuankecil_id',$this->satuankecil_id);
		$criteria->compare('satuanbesar_id',$this->satuanbesar_id);
		$criteria->compare('fakturdetail_id',$this->fakturdetail_id);
		$criteria->compare('returdetail_id',$this->returdetail_id);
		$criteria->compare('obatalkes_id',$this->obatalkes_id);
		$criteria->compare('stokobatalkes_id',$this->stokobatalkes_id);
		$criteria->compare('sumberdana_id',$this->sumberdana_id);
		$criteria->compare('jmlpermintaan',$this->jmlpermintaan);
		$criteria->compare('jmlterima',$this->jmlterima);
		$criteria->compare('persendiscount',$this->persendiscount);
		$criteria->compare('jmldiscount',$this->jmldiscount);
		$criteria->compare('harganettoper',$this->harganettoper);
		$criteria->compare('persenppn',$this->persenppn);
		$criteria->compare('persenpph',$this->persenpph);
		$criteria->compare('hargasatuanper',$this->hargasatuanper);
		$criteria->compare('tglkadaluarsa',$this->tglkadaluarsa,true);
		$criteria->compare('kemasanbesar',$this->kemasanbesar);
		$criteria->compare('biaya_lainlain',$this->biaya_lainlain);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}