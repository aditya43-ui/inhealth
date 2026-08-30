<?php

/**
 * This is the model class for table "perawatanlinendetail_t".
 *
 * The followings are the available columns in table 'perawatanlinendetail_t':
 * @property integer $perawatanlinendetail_id
 * @property integer $ruangan_id
 * @property integer $perawatanlinen_id
 * @property integer $penerimaanlinen_id
 * @property integer $linen_id
 * @property string $jenisperawatan
 * @property string $keteranganperawatan
 * @property string $statusperawatanlinen
 */
class PerawatanlinendetailT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PerawatanlinendetailT the static model class
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
		return 'perawatanlinendetail_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ruangan_id, perawatanlinen_id, penerimaanlinen_id, linen_id, jenisperawatan, statusperawatanlinen', 'required'),
			array('ruangan_id, perawatanlinen_id, penerimaanlinen_id, linen_id', 'numerical', 'integerOnly'=>true),
			array('jenisperawatan', 'length', 'max'=>50),
			array('keteranganperawatan', 'length', 'max'=>100),
			array('statusperawatanlinen', 'length', 'max'=>20),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('perawatanlinendetail_id, ruangan_id, perawatanlinen_id, penerimaanlinen_id, linen_id, jenisperawatan, keteranganperawatan, statusperawatanlinen', 'safe', 'on'=>'search'),
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
			'ruangan'=>array(self::BELONGS_TO,'RuanganM','ruangan_id'),
			'penerimaanlinen'=>array(self::BELONGS_TO,'PenerimaanlinenT','penerimaanlinen_id'),
			'linen'=>array(self::BELONGS_TO,'LinenM','linen_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'perawatanlinendetail_id' => 'Perawatanlinendetail',
			'ruangan_id' => 'Ruangan',
			'perawatanlinen_id' => 'Perawatanlinen',
			'penerimaanlinen_id' => 'Penerimaanlinen',
			'linen_id' => 'Linen',
			'jenisperawatan' => 'Jenisperawatan',
			'keteranganperawatan' => 'Keteranganperawatan',
			'statusperawatanlinen' => 'Statusperawatanlinen',
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

		if(!empty($this->perawatanlinendetail_id)){
			$criteria->addCondition('perawatanlinendetail_id = '.$this->perawatanlinendetail_id);
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		if(!empty($this->perawatanlinen_id)){
			$criteria->addCondition('perawatanlinen_id = '.$this->perawatanlinen_id);
		}
		if(!empty($this->penerimaanlinen_id)){
			$criteria->addCondition('penerimaanlinen_id = '.$this->penerimaanlinen_id);
		}
		if(!empty($this->linen_id)){
			$criteria->addCondition('linen_id = '.$this->linen_id);
		}
		$criteria->compare('LOWER(jenisperawatan)',strtolower($this->jenisperawatan),true);
		$criteria->compare('LOWER(keteranganperawatan)',strtolower($this->keteranganperawatan),true);
		$criteria->compare('LOWER(statusperawatanlinen)',strtolower($this->statusperawatanlinen),true);

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