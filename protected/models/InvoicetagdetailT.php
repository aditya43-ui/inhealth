<?php

/**
 * This is the model class for table "invoicetagdetail_t".
 *
 * The followings are the available columns in table 'invoicetagdetail_t':
 * @property integer $invoicetagdetail_id
 * @property integer $invoicetagihan_id
 * @property string $uraian_tagdetail
 * @property double $total_tagdetail
 * @property string $ket_tagdetail
 */
class InvoicetagdetailT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InvoicetagdetailT the static model class
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
		return 'invoicetagdetail_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('uraian_tagdetail, total_tagdetail', 'required'),
			array('invoicetagihan_id', 'numerical', 'integerOnly'=>true),
			array('total_tagdetail', 'numerical'),
			array('uraian_tagdetail', 'length', 'max'=>200),
			array('ket_tagdetail', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('invoicetagdetail_id, invoicetagihan_id, uraian_tagdetail, total_tagdetail, ket_tagdetail', 'safe', 'on'=>'search'),
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
			'invoicetagihan'=>array(self::BELONGS_TO,'InvoicetagihanT','invoicetagihan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'invoicetagdetail_id' => 'Invoicetagdetail',
			'invoicetagihan_id' => 'Invoicetagihan',
			'uraian_tagdetail' => 'Uraian Tagdetail',
			'total_tagdetail' => 'Total Tagdetail',
			'ket_tagdetail' => 'Ket Tagdetail',
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

		if(!empty($this->invoicetagdetail_id)){
			$criteria->addCondition('invoicetagdetail_id = '.$this->invoicetagdetail_id);
		}
		if(!empty($this->invoicetagihan_id)){
			$criteria->addCondition('invoicetagihan_id = '.$this->invoicetagihan_id);
		}
		$criteria->compare('LOWER(uraian_tagdetail)',strtolower($this->uraian_tagdetail),true);
		$criteria->compare('total_tagdetail',$this->total_tagdetail);
		$criteria->compare('LOWER(ket_tagdetail)',strtolower($this->ket_tagdetail),true);

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