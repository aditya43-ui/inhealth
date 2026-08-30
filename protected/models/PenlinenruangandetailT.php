<?php

/**
 * This is the model class for table "penlinenruangandetail_t".
 *
 * The followings are the available columns in table 'penlinenruangandetail_t':
 * @property integer $penlinenruangandetail_id
 * @property integer $penlinenruangan_id
 * @property integer $linen_id
 * @property string $keterangan
 */
class PenlinenruangandetailT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PenlinenruangandetailT the static model class
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
		return 'penlinenruangandetail_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('linen_id', 'required'),
			array('penlinenruangan_id, linen_id', 'numerical', 'integerOnly'=>true),
			array('keterangan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('penlinenruangandetail_id, penlinenruangan_id, linen_id, keterangan', 'safe', 'on'=>'search'),
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
			'linen'=>array(self::BELONGS_TO,'LinenM','linen_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'penlinenruangandetail_id' => 'Penlinenruangandetail',
			'penlinenruangan_id' => 'Penlinenruangan',
			'linen_id' => 'Linen',
			'keterangan' => 'Keterangan',
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

		if(!empty($this->penlinenruangandetail_id)){
			$criteria->addCondition('penlinenruangandetail_id = '.$this->penlinenruangandetail_id);
		}
		if(!empty($this->penlinenruangan_id)){
			$criteria->addCondition('penlinenruangan_id = '.$this->penlinenruangan_id);
		}
		if(!empty($this->linen_id)){
			$criteria->addCondition('linen_id = '.$this->linen_id);
		}
		$criteria->compare('LOWER(keterangan)',strtolower($this->keterangan),true);

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