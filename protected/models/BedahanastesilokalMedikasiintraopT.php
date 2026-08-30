<?php

/**
 * This is the model class for table "bedahanastesilokal_medikasiintraop_t".
 *
 * The followings are the available columns in table 'bedahanastesilokal_medikasiintraop_t':
 * @property integer $bedahanastesilokal_medikasiintraop_id
 * @property integer $bedahanastesilokal_intraop_id
 * @property integer $obatalkes_id
 * @property string $obatalkes_dosis
 *
 * The followings are the available model relations:
 * @property BedahanastesilokalIntraopT $bedahanastesilokalIntraop
 * @property ObatalkesM $obatalkes
 */
class BedahanastesilokalMedikasiintraopT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BedahanastesilokalMedikasiintraopT the static model class
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
		return 'bedahanastesilokal_medikasiintraop_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('bedahanastesilokal_intraop_id', 'required'),
			array('bedahanastesilokal_intraop_id, obatalkes_id', 'numerical', 'integerOnly'=>true),
			array('obatalkes_dosis', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('bedahanastesilokal_medikasiintraop_id, bedahanastesilokal_intraop_id, obatalkes_id, obatalkes_dosis', 'safe', 'on'=>'search'),
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
			'bedahanastesilokalIntraop' => array(self::BELONGS_TO, 'BedahanastesilokalIntraopT', 'bedahanastesilokal_intraop_id'),
			'obatalkes' => array(self::BELONGS_TO, 'ObatalkesM', 'obatalkes_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'bedahanastesilokal_medikasiintraop_id' => 'Bedahanastesilokal Medikasiintraop',
			'bedahanastesilokal_intraop_id' => 'Bedahanastesilokal Intraop',
			'obatalkes_id' => 'Obat',
			'obatalkes_dosis' => 'Dosis',
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

		if(!empty($this->bedahanastesilokal_medikasiintraop_id)){
			$criteria->addCondition('bedahanastesilokal_medikasiintraop_id = '.$this->bedahanastesilokal_medikasiintraop_id);
		}
		if(!empty($this->bedahanastesilokal_intraop_id)){
			$criteria->addCondition('bedahanastesilokal_intraop_id = '.$this->bedahanastesilokal_intraop_id);
		}
		if(!empty($this->obatalkes_id)){
			$criteria->addCondition('obatalkes_id = '.$this->obatalkes_id);
		}
		$criteria->compare('LOWER(obatalkes_dosis)',strtolower($this->obatalkes_dosis),true);

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