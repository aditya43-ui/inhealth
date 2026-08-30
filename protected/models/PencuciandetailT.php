<?php

/**
 * This is the model class for table "pencuciandetail_t".
 *
 * The followings are the available columns in table 'pencuciandetail_t':
 * @property integer $pencuciandetail_id
 * @property integer $linen_id
 * @property integer $perawatanlinen_id
 * @property integer $penerimaanlinen_id
 * @property integer $pencucianlinen_id
 * @property string $statuspencucian
 */
class PencuciandetailT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PencuciandetailT the static model class
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
		return 'pencuciandetail_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('linen_id, statuspencucian', 'required'),
			array('linen_id, perawatanlinen_id, penerimaanlinen_id, pencucianlinen_id', 'numerical', 'integerOnly'=>true),
			array('statuspencucian', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pencuciandetail_id, linen_id, perawatanlinen_id, penerimaanlinen_id, pencucianlinen_id, statuspencucian', 'safe', 'on'=>'search'),
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
			'perawatanlinen'=>array(self::BELONGS_TO,'PerawatanlinenT','perawatanlinen_id'),
			'penerimaanlinen'=>array(self::BELONGS_TO,'PenerimaanlinenT','penerimaanlinen_id'),
			'pencucianlinen'=>array(self::BELONGS_TO,'PencucianlinenT','pencucianlinen_id'),
			'linen'=>array(self::BELONGS_TO,'LinenM','linen_id'),
                        'ruangan'=>array(self::BELONGS_TO,'RuanganM','ruangan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pencuciandetail_id' => 'Pencucian Detail',
			'linen_id' => 'Linen',
			'perawatanlinen_id' => 'Perawatan Linen',
			'penerimaanlinen_id' => 'Penerimaan Linen',
			'pencucianlinen_id' => 'Pencucian Linen',
			'statuspencucian' => 'Status Pencucian',
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

		if(!empty($this->pencuciandetail_id)){
			$criteria->addCondition('pencuciandetail_id = '.$this->pencuciandetail_id);
		}
		if(!empty($this->linen_id)){
			$criteria->addCondition('linen_id = '.$this->linen_id);
		}
		if(!empty($this->perawatanlinen_id)){
			$criteria->addCondition('perawatanlinen_id = '.$this->perawatanlinen_id);
		}
		if(!empty($this->penerimaanlinen_id)){
			$criteria->addCondition('penerimaanlinen_id = '.$this->penerimaanlinen_id);
		}
		if(!empty($this->pencucianlinen_id)){
			$criteria->addCondition('pencucianlinen_id = '.$this->pencucianlinen_id);
		}
		$criteria->compare('LOWER(statuspencucian)',strtolower($this->statuspencucian),true);

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