<?php

/**
 * This is the model class for table "sterilisasibahan_t".
 *
 * The followings are the available columns in table 'sterilisasibahan_t':
 * @property integer $sterilisasibahan_id
 * @property integer $bahansterilisasi_id
 * @property integer $sterilisasidetail_id
 * @property integer $jmlbahanygdigunakan
 * @property string $satuanbahan
 */
class SterilisasibahanT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SterilisasibahanT the static model class
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
		return 'sterilisasibahan_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('bahansterilisasi_id, sterilisasidetail_id, jmlbahanygdigunakan', 'required'),
			array('bahansterilisasi_id, sterilisasidetail_id, jmlbahanygdigunakan', 'numerical', 'integerOnly'=>true),
			array('satuanbahan', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('sterilisasibahan_id, bahansterilisasi_id, sterilisasidetail_id, jmlbahanygdigunakan, satuanbahan', 'safe', 'on'=>'search'),
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
			'bahansterilisasi'=>array(self::BELONGS_TO,'BahansterilisasiM','bahansterilisasi_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'sterilisasibahan_id' => 'ID Sterilisasi Bahan',
			'bahansterilisasi_id' => 'Bahan Sterilisasi',
			'sterilisasidetail_id' => 'ID Sterilisasi Detail',
			'jmlbahanygdigunakan' => 'Jumlah',
			'satuanbahan' => 'Satuan Bahan',
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

		if(!empty($this->sterilisasibahan_id)){
			$criteria->addCondition('sterilisasibahan_id = '.$this->sterilisasibahan_id);
		}
		if(!empty($this->bahansterilisasi_id)){
			$criteria->addCondition('bahansterilisasi_id = '.$this->bahansterilisasi_id);
		}
		if(!empty($this->sterilisasidetail_id)){
			$criteria->addCondition('sterilisasidetail_id = '.$this->sterilisasidetail_id);
		}
		if(!empty($this->jmlbahanygdigunakan)){
			$criteria->addCondition('jmlbahanygdigunakan = '.$this->jmlbahanygdigunakan);
		}
		$criteria->compare('LOWER(satuanbahan)',strtolower($this->satuanbahan),true);

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