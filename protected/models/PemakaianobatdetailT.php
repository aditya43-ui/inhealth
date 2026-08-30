<?php

/**
 * This is the model class for table "pemakaianobatdetail_t".
 *
 * The followings are the available columns in table 'pemakaianobatdetail_t':
 * @property integer $pemakaianobatdetail_id
 * @property integer $satuankecil_id
 * @property integer $pemakaianobat_id
 * @property integer $obatalkes_id
 * @property string $qty_satuanpakai
 * @property double $harga_satuanpakai
 * @property double $harganetto_satuanpakai
 * @property string $ket_obatpakai
 *
 * The followings are the available model relations:
 * @property StokobatalkesT[] $stokobatalkesTs
 */
class PemakaianobatdetailT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PemakaianobatdetailT the static model class
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
		return 'pemakaianobatdetail_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('satuankecil_id, pemakaianobat_id, obatalkes_id, qty_satuanpakai, harga_satuanpakai, harganetto_satuanpakai', 'required'),
			array('satuankecil_id, pemakaianobat_id, obatalkes_id', 'numerical', 'integerOnly'=>true),
			array('harga_satuanpakai, harganetto_satuanpakai', 'numerical'),
			array('ket_obatpakai', 'length', 'max'=>200),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pemakaianobatdetail_id, satuankecil_id, pemakaianobat_id, obatalkes_id, qty_satuanpakai, harga_satuanpakai, harganetto_satuanpakai, ket_obatpakai', 'safe', 'on'=>'search'),
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
			'stokobatalkesTs' => array(self::HAS_MANY, 'StokobatalkesT', 'pemakaianobatdetail_id'),
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
			'pemakaianobatdetail_id' => 'Pemakaianobatdetail',
			'satuankecil_id' => 'Satuankecil',
			'pemakaianobat_id' => 'Pemakaianobat',
			'obatalkes_id' => 'Obatalkes',
			'qty_satuanpakai' => 'Qty Satuanpakai',
			'harga_satuanpakai' => 'Harga Satuanpakai',
			'harganetto_satuanpakai' => 'Harganetto Satuanpakai',
			'ket_obatpakai' => 'Ket Obatpakai',
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

		if(!empty($this->pemakaianobatdetail_id)){
			$criteria->addCondition('pemakaianobatdetail_id = '.$this->pemakaianobatdetail_id);
		}
		if(!empty($this->satuankecil_id)){
			$criteria->addCondition('satuankecil_id = '.$this->satuankecil_id);
		}
		if(!empty($this->pemakaianobat_id)){
			$criteria->addCondition('pemakaianobat_id = '.$this->pemakaianobat_id);
		}
		if(!empty($this->obatalkes_id)){
			$criteria->addCondition('obatalkes_id = '.$this->obatalkes_id);
		}
		$criteria->compare('LOWER(qty_satuanpakai)',strtolower($this->qty_satuanpakai),true);
		$criteria->compare('harga_satuanpakai',$this->harga_satuanpakai);
		$criteria->compare('harganetto_satuanpakai',$this->harganetto_satuanpakai);
		$criteria->compare('LOWER(ket_obatpakai)',strtolower($this->ket_obatpakai),true);

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