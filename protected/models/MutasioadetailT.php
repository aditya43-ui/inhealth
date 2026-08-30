<?php

/**
 * This is the model class for table "mutasioadetail_t".
 *
 * The followings are the available columns in table 'mutasioadetail_t':
 * @property integer $mutasioadetail_id
 * @property integer $obatalkes_id
 * @property integer $satuankecil_id
 * @property integer $sumberdana_id
 * @property integer $mutasioaruangan_id
 * @property double $jmlmutasi
 * @property double $jmlpesan
 * @property double $harganetto
 * @property double $hargajualsatuan
 * @property double $persendiscount
 * @property double $totalharga
 * @property string $tglkadaluarsa
 * @property integer $pesanoadetail_id
 *
 * The followings are the available model relations:
 * @property MutasioaruanganT $mutasioaruangan
 * @property ObatalkesM $obatalkes
 * @property SatuankecilM $satuankecil
 * @property SumberdanaM $sumberdana
 * @property StokobatalkesT[] $stokobatalkesTs
 * @property TerimamutasidetailT[] $terimamutasidetailTs
 */
class MutasioadetailT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MutasioadetailT the static model class
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
		return 'mutasioadetail_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('obatalkes_id, satuankecil_id, sumberdana_id, mutasioaruangan_id, jmlmutasi, jmlpesan, harganetto, hargajualsatuan, persendiscount', 'required'),
			array('obatalkes_id, satuankecil_id, sumberdana_id, mutasioaruangan_id,pesanoadetail_id', 'numerical', 'integerOnly'=>true),
			array('jmlmutasi, jmlpesan, harganetto, hargajualsatuan, persendiscount, totalharga', 'numerical'),
			array('tglkadaluarsa,pesanoadetail_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('mutasioadetail_id, obatalkes_id, satuankecil_id, sumberdana_id, mutasioaruangan_id, jmlmutasi, jmlpesan, harganetto, hargajualsatuan, persendiscount, totalharga, tglkadaluarsa,pesanoadetail_id', 'safe', 'on'=>'search'),
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
			'mutasioaruangan' => array(self::BELONGS_TO, 'MutasioaruanganT', 'mutasioaruangan_id'),
			'obatalkes' => array(self::BELONGS_TO, 'ObatalkesM', 'obatalkes_id'),
			'satuankecil' => array(self::BELONGS_TO, 'SatuankecilM', 'satuankecil_id'),
			'sumberdana' => array(self::BELONGS_TO, 'SumberdanaM', 'sumberdana_id'),
			'stokobatalkesTs' => array(self::HAS_MANY, 'StokobatalkesT', 'mutasioadetail_id'),
			'terimamutasidetailTs' => array(self::HAS_MANY, 'TerimamutasidetailT', 'mutasioadetail_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'mutasioadetail_id' => 'Mutasioadetail',
			'obatalkes_id' => 'Obatalkes',
			'satuankecil_id' => 'Satuankecil',
			'sumberdana_id' => 'Sumberdana',
			'mutasioaruangan_id' => 'Mutasioaruangan',
			'jmlmutasi' => 'Jmlmutasi',
			'jmlpesan' => 'Jmlpesan',
			'harganetto' => 'Harganetto',
			'hargajualsatuan' => 'Hargajualsatuan',
			'persendiscount' => 'Persen Keringanan',
			'totalharga' => 'Totalharga',
			'tglkadaluarsa' => 'Tglkadaluarsa',
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

		$criteria->compare('mutasioadetail_id',$this->mutasioadetail_id);
		$criteria->compare('obatalkes_id',$this->obatalkes_id);
		$criteria->compare('satuankecil_id',$this->satuankecil_id);
		$criteria->compare('sumberdana_id',$this->sumberdana_id);
		$criteria->compare('mutasioaruangan_id',$this->mutasioaruangan_id);
		$criteria->compare('jmlmutasi',$this->jmlmutasi);
		$criteria->compare('jmlpesan',$this->jmlpesan);
		$criteria->compare('harganetto',$this->harganetto);
		$criteria->compare('hargajualsatuan',$this->hargajualsatuan);
		$criteria->compare('persendiscount',$this->persendiscount);
		$criteria->compare('totalharga',$this->totalharga);
		$criteria->compare('LOWER(tglkadaluarsa)',strtolower($this->tglkadaluarsa),true);

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