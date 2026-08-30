<?php

/**
 * This is the model class for table "perawatanbahan_t".
 *
 * The followings are the available columns in table 'perawatanbahan_t':
 * @property integer $perawatanbahan_id
 * @property integer $perawatanlinen_id
 * @property integer $bahanperawatan_id
 * @property integer $jmlbahanpemakaian
 * @property string $satuanpemakaian
 */
class PerawatanbahanT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PerawatanbahanT the static model class
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
		return 'perawatanbahan_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('bahanperawatan_id, jmlbahanpemakaian, satuanpemakaian', 'required'),
			array('perawatanlinen_id, bahanperawatan_id, jmlbahanpemakaian', 'numerical', 'integerOnly'=>true),
			array('satuanpemakaian', 'length', 'max'=>20),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('perawatanbahan_id, perawatanlinen_id, bahanperawatan_id, jmlbahanpemakaian, satuanpemakaian', 'safe', 'on'=>'search'),
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
			'bahanperawatan'=>array(self::BELONGS_TO,'BahanperawatanM','bahanperawatan_id')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'perawatanbahan_id' => 'Perawatanbahan',
			'perawatanlinen_id' => 'Perawatanlinen',
			'bahanperawatan_id' => 'Bahanperawatan',
			'jmlbahanpemakaian' => 'Jmlbahanpemakaian',
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

		if(!empty($this->perawatanbahan_id)){
			$criteria->addCondition('perawatanbahan_id = '.$this->perawatanbahan_id);
		}
		if(!empty($this->perawatanlinen_id)){
			$criteria->addCondition('perawatanlinen_id = '.$this->perawatanlinen_id);
		}
		if(!empty($this->bahanperawatan_id)){
			$criteria->addCondition('bahanperawatan_id = '.$this->bahanperawatan_id);
		}
		if(!empty($this->jmlbahanpemakaian)){
			$criteria->addCondition('jmlbahanpemakaian = '.$this->jmlbahanpemakaian);
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