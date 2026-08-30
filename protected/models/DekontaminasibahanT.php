<?php

/**
 * This is the model class for table "dekontaminasibahan_t".
 *
 * The followings are the available columns in table 'dekontaminasibahan_t':
 * @property integer $dekontaminasibahan_id
 * @property integer $dekontaminasidetail_id
 * @property integer $bahansterilisasi_id
 * @property integer $jmlpemakaianbahan
 * @property string $satuanpemakainbahan
 */
class DekontaminasibahanT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DekontaminasibahanT the static model class
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
		return 'dekontaminasibahan_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('dekontaminasidetail_id, bahansterilisasi_id, jmlpemakaianbahan, satuanpemakainbahan', 'required'),
			array('dekontaminasidetail_id, bahansterilisasi_id, jmlpemakaianbahan', 'numerical', 'integerOnly'=>true),
			array('satuanpemakainbahan', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('dekontaminasibahan_id, dekontaminasidetail_id, bahansterilisasi_id, jmlpemakaianbahan, satuanpemakainbahan', 'safe', 'on'=>'search'),
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
			'dekontaminasibahan_id' => 'Bahan Dekontaminasi',
			'dekontaminasidetail_id' => 'Dekontaminasi Detail ID',
			'bahansterilisasi_id' => 'Bahan Sterilisasi ID',
			'jmlpemakaianbahan' => 'Jumlah Pemakaian',
			'satuanpemakainbahan' => 'Satuan Pemakaian',
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

		if(!empty($this->dekontaminasibahan_id)){
			$criteria->addCondition('dekontaminasibahan_id = '.$this->dekontaminasibahan_id);
		}
		if(!empty($this->dekontaminasidetail_id)){
			$criteria->addCondition('dekontaminasidetail_id = '.$this->dekontaminasidetail_id);
		}
		if(!empty($this->bahansterilisasi_id)){
			$criteria->addCondition('bahansterilisasi_id = '.$this->bahansterilisasi_id);
		}
		if(!empty($this->jmlpemakaianbahan)){
			$criteria->addCondition('jmlpemakaianbahan = '.$this->jmlpemakaianbahan);
		}
		$criteria->compare('LOWER(satuanpemakainbahan)',strtolower($this->satuanpemakainbahan),true);

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