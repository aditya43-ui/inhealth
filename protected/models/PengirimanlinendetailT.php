<?php

/**
 * This is the model class for table "pengirimanlinendetail_t".
 *
 * The followings are the available columns in table 'pengirimanlinendetail_t':
 * @property integer $pengirimanlinendetail_id
 * @property integer $linen_id
 * @property integer $pengirimanlinen_id
 * @property string $keterangan_linen
 */
class PengirimanlinendetailT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PengirimanlinendetailT the static model class
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
		return 'pengirimanlinendetail_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('linen_id, pengirimanlinen_id', 'required'),
			array('linen_id, pengirimanlinen_id', 'numerical', 'integerOnly'=>true),
			array('keterangan_linen', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pengirimanlinendetail_id, linen_id, pengirimanlinen_id, keterangan_linen', 'safe', 'on'=>'search'),
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
			'pengirimanlinen'=>array(self::BELONGS_TO,'PengirimanlinenT','pengirimanlinen_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pengirimanlinendetail_id' => 'Pengiriman Linen Detail',
			'linen_id' => 'Linen',
			'pengirimanlinen_id' => 'Pengiriman Linen',
			'keterangan_linen' => 'Keterangan',
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

		if(!empty($this->pengirimanlinendetail_id)){
			$criteria->addCondition('pengirimanlinendetail_id = '.$this->pengirimanlinendetail_id);
		}
		if(!empty($this->linen_id)){
			$criteria->addCondition('linen_id = '.$this->linen_id);
		}
		if(!empty($this->pengirimanlinen_id)){
			$criteria->addCondition('pengirimanlinen_id = '.$this->pengirimanlinen_id);
		}
		$criteria->compare('LOWER(keterangan_linen)',strtolower($this->keterangan_linen),true);

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