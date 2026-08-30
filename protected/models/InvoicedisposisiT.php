<?php

/**
 * This is the model class for table "invoicedisposisi_t".
 *
 * The followings are the available columns in table 'invoicedisposisi_t':
 * @property integer $invoicedisposisi_id
 * @property integer $invoicetagihan_id
 * @property string $uraian_disoposisi
 * @property double $total_disposisi
 * @property string $ket_disposisi
 */
class InvoicedisposisiT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InvoicedisposisiT the static model class
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
		return 'invoicedisposisi_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('uraian_disoposisi, total_disposisi', 'required'),
			array('invoicetagihan_id', 'numerical', 'integerOnly'=>true),
			array('total_disposisi', 'numerical'),
			array('uraian_disoposisi', 'length', 'max'=>200),
			array('ket_disposisi', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('invoicedisposisi_id, invoicetagihan_id, uraian_disoposisi, total_disposisi, ket_disposisi', 'safe', 'on'=>'search'),
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
			'invoicedisposisi_id' => 'Invoicedisposisi',
			'invoicetagihan_id' => 'Invoicetagihan',
			'uraian_disoposisi' => 'Uraian Disoposisi',
			'total_disposisi' => 'Total Disposisi',
			'ket_disposisi' => 'Ket Disposisi',
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

		if(!empty($this->invoicedisposisi_id)){
			$criteria->addCondition('invoicedisposisi_id = '.$this->invoicedisposisi_id);
		}
		if(!empty($this->invoicetagihan_id)){
			$criteria->addCondition('invoicetagihan_id = '.$this->invoicetagihan_id);
		}
		$criteria->compare('LOWER(uraian_disoposisi)',strtolower($this->uraian_disoposisi),true);
		$criteria->compare('total_disposisi',$this->total_disposisi);
		$criteria->compare('LOWER(ket_disposisi)',strtolower($this->ket_disposisi),true);

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