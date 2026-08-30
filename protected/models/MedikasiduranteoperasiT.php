<?php

/**
 * This is the model class for table "medikasiduranteoperasi_t".
 *
 * The followings are the available columns in table 'medikasiduranteoperasi_t':
 * @property integer $medikasiduranteoperasi_id
 * @property integer $anastesiduranteoperasi_id
 * @property integer $obatalkes_id
 *
 * The followings are the available model relations:
 * @property AnastesiduranteoperasiT $anastesiduranteoperasi
 * @property ObatalkesM $obatalkes
 */
class MedikasiduranteoperasiT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MedikasiduranteoperasiT the static model class
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
		return 'medikasiduranteoperasi_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('anastesiduranteoperasi_id, obatalkes_id', 'required'),
			array('anastesiduranteoperasi_id, obatalkes_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('medikasiduranteoperasi_id, anastesiduranteoperasi_id, obatalkes_id', 'safe', 'on'=>'search'),
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
			'anastesiduranteoperasi' => array(self::BELONGS_TO, 'AnastesiduranteoperasiT', 'anastesiduranteoperasi_id'),
			'obatalkes' => array(self::BELONGS_TO, 'ObatalkesM', 'obatalkes_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'medikasiduranteoperasi_id' => 'Medikasiduranteoperasi',
			'anastesiduranteoperasi_id' => 'Anastesiduranteoperasi',
			'obatalkes_id' => 'Obatalkes',
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

		if(!empty($this->medikasiduranteoperasi_id)){
			$criteria->addCondition('medikasiduranteoperasi_id = '.$this->medikasiduranteoperasi_id);
		}
		if(!empty($this->anastesiduranteoperasi_id)){
			$criteria->addCondition('anastesiduranteoperasi_id = '.$this->anastesiduranteoperasi_id);
		}
		if(!empty($this->obatalkes_id)){
			$criteria->addCondition('obatalkes_id = '.$this->obatalkes_id);
		}

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