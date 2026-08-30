<?php

/**
 * This is the model class for table "pencucianbahan_t".
 *
 * The followings are the available columns in table 'pencucianbahan_t':
 * @property integer $pencucianbahan_id
 * @property integer $pencucianlinen_id
 * @property integer $bahanperawatan_id
 * @property integer $jmlpemakaian
 * @property string $satuanpemakaian
 */
class PencucianbahanT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PencucianbahanT the static model class
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
		return 'pencucianbahan_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pencucianlinen_id, bahanperawatan_id, jmlpemakaian, satuanpemakaian', 'required'),
			array('pencucianlinen_id, bahanperawatan_id, jmlpemakaian', 'numerical', 'integerOnly'=>true),
			array('satuanpemakaian', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pencucianbahan_id, pencucianlinen_id, bahanperawatan_id, jmlpemakaian, satuanpemakaian', 'safe', 'on'=>'search'),
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
			'bahanperawatan'=>array(self::BELONGS_TO,'BahanperawatanM','bahanperawatan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pencucianbahan_id' => 'Pencucianbahan',
			'pencucianlinen_id' => 'Pencucianlinen',
			'bahanperawatan_id' => 'Bahanperawatan',
			'jmlpemakaian' => 'Jmlpemakaian',
			'satuanpemakaian' => 'Satuanpemakaian',
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

		if(!empty($this->pencucianbahan_id)){
			$criteria->addCondition('pencucianbahan_id = '.$this->pencucianbahan_id);
		}
		if(!empty($this->pencucianlinen_id)){
			$criteria->addCondition('pencucianlinen_id = '.$this->pencucianlinen_id);
		}
		if(!empty($this->bahanperawatan_id)){
			$criteria->addCondition('bahanperawatan_id = '.$this->bahanperawatan_id);
		}
		if(!empty($this->jmlpemakaian)){
			$criteria->addCondition('jmlpemakaian = '.$this->jmlpemakaian);
		}
		$criteria->compare('LOWER(satuanpemakaian)',strtolower($this->satuanpemakaian),true);

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