<?php

/**
 * This is the model class for table "cairanimduranteop_t".
 *
 * The followings are the available columns in table 'cairanimduranteop_t':
 * @property integer $cairanimduranteop_id
 * @property integer $anastesiduranteoperasi_id
 * @property integer $obatalkes_id
 * @property double $jumlah_cairanim
 *
 * The followings are the available model relations:
 * @property AnastesiduranteoperasiT $anastesiduranteoperasi
 * @property ObatalkesM $obatalkes
 */
class CairanimduranteopT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CairanimduranteopT the static model class
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
		return 'cairanimduranteop_t';
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
			array('jumlah_cairanim', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('cairanimduranteop_id, anastesiduranteoperasi_id, obatalkes_id, jumlah_cairanim', 'safe', 'on'=>'search'),
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
			'cairanimduranteop_id' => 'Cairanimduranteop',
			'anastesiduranteoperasi_id' => 'Anastesiduranteoperasi',
			'obatalkes_id' => 'Obatalkes',
			'jumlah_cairanim' => 'Jumlah Cairanim',
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

		if(!empty($this->cairanimduranteop_id)){
			$criteria->addCondition('cairanimduranteop_id = '.$this->cairanimduranteop_id);
		}
		if(!empty($this->anastesiduranteoperasi_id)){
			$criteria->addCondition('anastesiduranteoperasi_id = '.$this->anastesiduranteoperasi_id);
		}
		if(!empty($this->obatalkes_id)){
			$criteria->addCondition('obatalkes_id = '.$this->obatalkes_id);
		}
		$criteria->compare('jumlah_cairanim',$this->jumlah_cairanim);

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