<?php

/**
 * This is the model class for table "maplinensterilisasi_m".
 *
 * The followings are the available columns in table 'maplinensterilisasi_m':
 * @property integer $peralatansterilisasi_id
 * @property integer $linen_id
 */
class MaplinensterilisasiM extends CActiveRecord
{
        public $peralatansterilisasi_nama;
        public $linennama;
        public $nama;
        public $jml;
        public $map_id;
        public $jenisperalatan,$oldId,$oldLinen;
        public $item_id, $item_nama;
        
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MaplinensterilisasiM the static model class
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
		return 'maplinensterilisasi_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('peralatansterilisasi_id, linen_id', 'required'),
			array('peralatansterilisasi_id, linen_id', 'checkUniqueness'),
			array('peralatansterilisasi_id, linen_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('peralatansterilisasi_id, linen_id', 'safe', 'on'=>'search'),
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
                    'linen' => array(self::BELONGS_TO, 'LinenM', 'linen_id')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'peralatansterilisasi_id' => 'Peralatansterilisasi',
			'linen_id' => 'Linen',
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

		if(!empty($this->peralatansterilisasi_id)){
			$criteria->addCondition('peralatansterilisasi_id = '.$this->peralatansterilisasi_id);
		}
		if(!empty($this->linen_id)){
			$criteria->addCondition('linen_id = '.$this->linen_id);
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



		public function checkUniqueness($attribute,$params)
		{
			if($this->peralatansterilisasi_id !== $this->oldId || $this->linen_id !== $this->oldCategory)
			{
				$model = MaplinensterilisasiM::model()->find('peralatansterilisasi_id = ? AND linen_id = ? ', array($this->peralatansterilisasi_id, $this->linen_id));
				if($model != null)
					$this->addError('peralatansterilisasi_id','Peralatansterilisasi dan Linen  already exist');
			}   
		}
	 
		protected function afterFind()
		{
			parent::afterFind();
			$this->oldId = $this->peralatansterilisasi_id;
			$this->oldLinen = $this->linen_id;
		}
}