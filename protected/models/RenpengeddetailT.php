<?php

/**
 * This is the model class for table "renpengeddetail_t".
 *
 * The followings are the available columns in table 'renpengeddetail_t':
 * @property integer $obatalkes_id
 * @property integer $supplier_id
 * @property integer $renpengembalianed_id
 * @property integer $storeeddetail_id
 * @property integer $satuankecil_id
 * @property integer $qty_renpenged
 * @property string $tglkadaluarsa_renpeng
 */
class RenpengeddetailT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RenpengeddetailT the static model class
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
		return 'renpengeddetail_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('obatalkes_id, supplier_id, renpengembalianed_id, satuankecil_id, qty_renpenged, tglkadaluarsa_renpeng', 'required'),
			array('obatalkes_id, supplier_id, renpengembalianed_id, storeeddetail_id, satuankecil_id, qty_renpenged', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('obatalkes_id, supplier_id, renpengembalianed_id, storeeddetail_id, satuankecil_id, qty_renpenged, tglkadaluarsa_renpeng', 'safe', 'on'=>'search'),
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
			'obatalkes' => array(self::BELONGS_TO, 'ObatalkesM', 'obatalkes_id'),
			'supplier' => array(self::BELONGS_TO, 'SupplierM', 'supplier_id'),
			'satuankecil' => array(self::BELONGS_TO, 'SatuankecilM', 'satuankecil_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'obatalkes_id' => 'Obatalkes',
			'supplier_id' => 'Supplier',
			'renpengembalianed_id' => 'Renpengembalianed',
			'storeeddetail_id' => 'Storeeddetail',
			'satuankecil_id' => 'Satuankecil',
			'qty_renpenged' => 'Qty Renpenged',
			'tglkadaluarsa_renpeng' => 'Tglkadaluarsa Renpeng',
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

		if(!empty($this->obatalkes_id)){
			$criteria->addCondition('obatalkes_id = '.$this->obatalkes_id);
		}
		if(!empty($this->supplier_id)){
			$criteria->addCondition('supplier_id = '.$this->supplier_id);
		}
		if(!empty($this->renpengembalianed_id)){
			$criteria->addCondition('renpengembalianed_id = '.$this->renpengembalianed_id);
		}
		if(!empty($this->storeeddetail_id)){
			$criteria->addCondition('storeeddetail_id = '.$this->storeeddetail_id);
		}
		if(!empty($this->satuankecil_id)){
			$criteria->addCondition('satuankecil_id = '.$this->satuankecil_id);
		}
		if(!empty($this->qty_renpenged)){
			$criteria->addCondition('qty_renpenged = '.$this->qty_renpenged);
		}
		$criteria->compare('LOWER(tglkadaluarsa_renpeng)',strtolower($this->tglkadaluarsa_renpeng),true);

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