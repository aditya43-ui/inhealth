<?php

/**
 * This is the model class for table "supplierrek_m".
 *
 * The followings are the available columns in table 'supplierrek_m':
 * @property integer $supplierrek_id
 * @property integer $rekening2_id
 * @property integer $supplier_id
 * @property integer $rekening3_id
 * @property integer $rekening1_id
 * @property integer $rekening5_id
 * @property integer $rekening4_id
 * @property string $saldonormal
 */
class SupplierrekM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SupplierrekM the static model class
	 */
	public $rekDebit, $rekKredit, $supplier_nama;
	public $is_pilihan;	
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'supplierrek_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('supplier_id', 'required'),
			array('supplier_id, rekening5_id', 'numerical', 'integerOnly'=>true),
			array('is_pilihan, isfakturpembelian, isbayarkesupplier','safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('supplierrek_id, supplier_id, supplier_nama, rekening5_id, rekDebit, rekKredit', 'safe', 'on'=>'search'),
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
			'supplier' => array(self::BELONGS_TO,'SupplierM','supplier_id'),
			'rekening5' => array(self::BELONGS_TO,'Rekening5M','rekening5_id'),
 		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'supplierrek_id' => 'Supplierrek',
			'supplier_id' => 'Supplier',
			'rekening5_id' => 'Rekening5',
		);
	}
	
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($print)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('t.supplier_id',$this->supplier_id);
		$criteria->compare('LOWER(supplier_m.supplier_nama)',strtolower($this->supplier_nama),true);
		$criteria->select = 't.supplier_id, supplier_m.supplier_nama';
		$criteria->join = "JOIN supplier_m ON t.supplier_id = supplier_m.supplier_id";
		$criteria->group = 't.supplier_id, supplier_m.supplier_nama';
        $criteria->order = 'supplier_m.supplier_nama';

        if(isset($this->rekDebit)){
            $debit = "D";
            $criteria_satu = new CDbCriteria;
            $criteria_satu->compare('LOWER(rekening5.nmrekening5)', strtolower($this->rekDebit),true);
            
            $record = SupplierrekM::model()->with("rekening5")->findAll($criteria_satu);
            //var_dump($record->attributes);
            $data = array();
            foreach($record as $value)
            {
                $data[] = $value->supplier_id;
            }
            if(count((array)$data)>0){
                   $condition = 't.supplier_id IN ('. implode(',', $data) .')';
                   $criteria->addCondition($condition);
            }
        }

        if(isset($this->rekKredit)){
            $debit = "K";
            $criteria_satu = new CDbCriteria;
            $criteria_satu->compare('LOWER(rekening5.nmrekening5)', strtolower($this->rekKredit),true);
            
            $record = SupplierrekM::model()->with("rekening5")->findAll($criteria_satu);
            //var_dump($record->attributes);
            $data = array();
            foreach($record as $value)
            {
                $data[] = $value->supplier_id;
            }
            if(count((array)$data)>0){
                   $condition = 't.supplier_id IN ('. implode(',', $data) .')';
                   $criteria->addCondition($condition);
            }
        }

        if($print=='print'){
        	return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
                'pagination'=>false,
        	));
        }else{
			return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
			));
		}
	}

	public function searchGroup()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->select = 'supplier_id';
        $criteria->group = 'supplier_id';
        $criteria->order = 'supplier_id';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('supplierrek_id',$this->supplierrek_id);
		$criteria->compare('supplier_id',$this->supplier_id);
		$criteria->compare('rekening5_id',$this->rekening5_id);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}