<?php

/**
 * This is the model class for table "unitkerjaruangan_m".
 *
 * The followings are the available columns in table 'unitkerjaruangan_m':
 * @property integer $ruangan_id
 * @property integer $unitkerja_id
 */
class UnitkerjaruanganM extends CActiveRecord
{
        public $namaunitkerja, $ruangan_nama, $instalasi_id;
        
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UnitkerjaruanganM the static model class
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
		return 'unitkerjaruangan_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ruangan_id, unitkerja_id', 'required'),
			array('ruangan_id, unitkerja_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ruangan_id, unitkerja_id', 'safe', 'on'=>'search'),
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
			'ruangan' => array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ruangan_id' => 'Ruangan',
			'unitkerja_id' => 'Unitkerja',
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

		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		if(!empty($this->unitkerja_id)){
			$criteria->addCondition('unitkerja_id = '.$this->unitkerja_id);
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
        
         /**
     * Load data unit kerja filter berdasarkan ruangan 
        * @return \CActiveDataProvider
        */
       public function searchUnitKerjaRuangan() {
           // Warning: Please modify the following code to remove attributes that
           // should not be searched.

           $criteria = $this->criteriaSearch();
           if (!empty($this->ruangan_id)) {
               $criteria->addCondition('t.ruangan_id = ' . $this->ruangan_id);
           } else {
               $criteria->addCondition('t.ruangan_id is null');
           }
           $criteria->limit = 10;

           return new CActiveDataProvider($this, array(
               'criteria' => $criteria,
           ));
       }
}