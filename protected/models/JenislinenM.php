<?php

/**
 * This is the model class for table "jenislinen_m".
 *
 * The followings are the available columns in table 'jenislinen_m':
 * @property integer $jenislinen_id
 * @property string $jenislinen_no
 * @property string $jenislinen_nama
 * @property string $tgldiedarkan
 * @property string $ukuranitem
 * @property double $beratitem
 * @property integer $qtyitem
 * @property string $warnalinen
 * @property boolean $isberwarna
 */
class JenislinenM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JenislinenM the static model class
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
		return 'jenislinen_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jenislinen_no, jenislinen_nama, warnalinen, isberwarna', 'required'),
			array('qtyitem', 'numerical', 'integerOnly'=>true),
			array('beratitem', 'numerical'),
			array('jenislinen_no, warnalinen', 'length', 'max'=>50),
			array('jenislinen_nama', 'length', 'max'=>200),
			array('ukuranitem', 'length', 'max'=>30),
			array('tgldiedarkan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('jenislinen_id, jenislinen_no, jenislinen_nama, tgldiedarkan, ukuranitem, beratitem, qtyitem, warnalinen, isberwarna', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'jenislinen_id' => 'Jenislinen',
			'jenislinen_no' => 'Jenislinen No',
			'jenislinen_nama' => 'Jenislinen Nama',
			'tgldiedarkan' => 'Tgldiedarkan',
			'ukuranitem' => 'Ukuranitem',
			'beratitem' => 'Beratitem',
			'qtyitem' => 'Qtyitem',
			'warnalinen' => 'Warnalinen',
			'isberwarna' => 'Isberwarna',
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

		if(!empty($this->jenislinen_id)){
			$criteria->addCondition('jenislinen_id = '.$this->jenislinen_id);
		}
		$criteria->compare('LOWER(jenislinen_no)',strtolower($this->jenislinen_no),true);
		$criteria->compare('LOWER(jenislinen_nama)',strtolower($this->jenislinen_nama),true);
		$criteria->compare('LOWER(tgldiedarkan)',strtolower($this->tgldiedarkan),true);
		$criteria->compare('LOWER(ukuranitem)',strtolower($this->ukuranitem),true);
		$criteria->compare('beratitem',$this->beratitem);
		if(!empty($this->qtyitem)){
			$criteria->addCondition('qtyitem = '.$this->qtyitem);
		}
		$criteria->compare('LOWER(warnalinen)',strtolower($this->warnalinen),true);
		$criteria->compare('isberwarna',isset($this->isberwarna)?$this->isberwarna:true);

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