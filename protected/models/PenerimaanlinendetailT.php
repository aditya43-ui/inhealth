<?php

/**
 * This is the model class for table "penerimaanlinendetail_t".
 *
 * The followings are the available columns in table 'penerimaanlinendetail_t':
 * @property integer $penerimaanlinendetail_id
 * @property integer $linen_id
 * @property integer $penerimaanlinen_id
 * @property string $jenisperawatanlinen
 * @property string $keterangan_penerimaanlinen
 */
class PenerimaanlinendetailT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PenerimaanlinendetailT the static model class
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
		return 'penerimaanlinendetail_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('linen_id, jenisperawatanlinen', 'required'),
			array('linen_id, penerimaanlinen_id', 'numerical', 'integerOnly'=>true),
			array('jenisperawatanlinen', 'length', 'max'=>50),
			array('keterangan_penerimaanlinen', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('penerimaanlinendetail_id, linen_id, penerimaanlinen_id, jenisperawatanlinen, keterangan_penerimaanlinen', 'safe', 'on'=>'search'),
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
                    'linen' => array(self::BELONGS_TO, 'LinenM', 'linen_id'),                    
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'penerimaanlinendetail_id' => 'Penerimaan Linen Detail',
			'linen_id' => 'Linen',
			'penerimaanlinen_id' => 'Penerimaan Linen',
			'jenisperawatanlinen' => 'Jenis Perawatan',
			'keterangan_penerimaanlinen' => 'Keterangan',
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

		if(!empty($this->penerimaanlinendetail_id)){
			$criteria->addCondition('penerimaanlinendetail_id = '.$this->penerimaanlinendetail_id);
		}
		if(!empty($this->linen_id)){
			$criteria->addCondition('linen_id = '.$this->linen_id);
		}
		if(!empty($this->penerimaanlinen_id)){
			$criteria->addCondition('penerimaanlinen_id = '.$this->penerimaanlinen_id);
		}
		$criteria->compare('LOWER(jenisperawatanlinen)',strtolower($this->jenisperawatanlinen),true);
		$criteria->compare('LOWER(keterangan_penerimaanlinen)',strtolower($this->keterangan_penerimaanlinen),true);

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