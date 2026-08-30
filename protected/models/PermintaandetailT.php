<?php

/**
 * This is the model class for table "permintaandetail_t".
 *
 * The followings are the available columns in table 'permintaandetail_t':
 * @property integer $permintaandetail_id
 * @property integer $obatalkes_id
 * @property integer $sumberdana_id
 * @property integer $satuanbesar_id
 * @property integer $permintaanpembelian_id
 * @property integer $satuankecil_id
 * @property double $stokakhir
 * @property integer $maksimalstok
 * @property integer $minimalstok
 * @property double $jmlpermintaan
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
 * @property SumberdanaM $sumberdana
 * @property SatuanbesarM $satuanbesar
 * @property PermintaanpembelianT $permintaanpembelian
 * @property SatuankecilM $satuankecil
 * @property ObatalkesM $obatalkes
 */
class PermintaandetailT extends CActiveRecord
{
    public $jmlpph;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PermintaandetailT the static model class
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
		return 'permintaandetail_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('obatalkes_id, permintaanpembelian_id, jmlpermintaan, persendiscount, jmldiscount, harganettoper, persenppn, persenpph, hargasatuanper, biaya_lainlain', 'required'),
			array('obatalkes_id, sumberdana_id, satuanbesar_id, permintaanpembelian_id, satuankecil_id, maksimalstok, minimalstok', 'numerical', 'integerOnly'=>true),
			array('stokakhir, jmlpermintaan, persendiscount, jmldiscount, harganettoper, persenppn, persenpph, hargasatuanper, kemasanbesar, biaya_lainlain', 'numerical'),
			array('keterangan, tglkadaluarsa, hpp, ppn', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('keterangan, permintaandetail_id, obatalkes_id, sumberdana_id, satuanbesar_id, permintaanpembelian_id, satuankecil_id, stokakhir, maksimalstok, minimalstok, jmlpermintaan, persendiscount, jmldiscount, harganettoper, persenppn, persenpph, hargasatuanper, tglkadaluarsa, kemasanbesar, biaya_lainlain', 'safe', 'on'=>'search'),
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
			'sumberdana' => array(self::BELONGS_TO, 'SumberdanaM', 'sumberdana_id'),
			'satuanbesar' => array(self::BELONGS_TO, 'SatuanbesarM', 'satuanbesar_id'),
			'permintaanpembelian' => array(self::BELONGS_TO, 'PermintaanpembelianT', 'permintaanpembelian_id'),
			'satuankecil' => array(self::BELONGS_TO, 'SatuankecilM', 'satuankecil_id'),
			'obatalkes' => array(self::BELONGS_TO, 'ObatalkesM', 'obatalkes_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'permintaandetail_id' => 'Permintaandetail',
			'obatalkes_id' => 'Obatalkes',
			'sumberdana_id' => 'Sumberdana',
			'satuanbesar_id' => 'Satuanbesar',
			'permintaanpembelian_id' => 'Permintaanpembelian',
			'satuankecil_id' => 'Satuankecil',
			'stokakhir' => 'Stokakhir',
			'maksimalstok' => 'Maksimalstok',
			'minimalstok' => 'Minimalstok',
			'jmlpermintaan' => 'Jmlpermintaan',
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

		$criteria->compare('permintaandetail_id',$this->permintaandetail_id);
		$criteria->compare('obatalkes_id',$this->obatalkes_id);
		$criteria->compare('sumberdana_id',$this->sumberdana_id);
		$criteria->compare('satuanbesar_id',$this->satuanbesar_id);
		$criteria->compare('permintaanpembelian_id',$this->permintaanpembelian_id);
		$criteria->compare('satuankecil_id',$this->satuankecil_id);
		$criteria->compare('stokakhir',$this->stokakhir);
		$criteria->compare('maksimalstok',$this->maksimalstok);
		$criteria->compare('minimalstok',$this->minimalstok);
		$criteria->compare('jmlpermintaan',$this->jmlpermintaan);
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