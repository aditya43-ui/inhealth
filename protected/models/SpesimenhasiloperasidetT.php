<?php

/**
 * This is the model class for table "spesimenhasiloperasidet_t".
 *
 * The followings are the available columns in table 'spesimenhasiloperasidet_t':
 * @property integer $spesimenhasiloperasidet_id
 * @property integer $spesimenhasiloperasi_id
 * @property integer $pemeriksaanlab_id
 * @property integer $daftartindakan_id
 *
 * The followings are the available model relations:
 * @property SpesimenhasiloperasiT $spesimenhasiloperasi
 * @property PemeriksaanlabM $pemeriksaanlab
 * @property DaftartindakanM $daftartindakan
 */
class SpesimenhasiloperasidetT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SpesimenhasiloperasidetT the static model class
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
		return 'spesimenhasiloperasidet_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('spesimenhasiloperasi_id, pemeriksaanlab_id, daftartindakan_id', 'required'),
			array('spesimenhasiloperasi_id, pemeriksaanlab_id, daftartindakan_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('spesimenhasiloperasidet_id, spesimenhasiloperasi_id, pemeriksaanlab_id, daftartindakan_id', 'safe', 'on'=>'search'),
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
			'spesimenhasiloperasi' => array(self::BELONGS_TO, 'SpesimenhasiloperasiT', 'spesimenhasiloperasi_id'),
			'pemeriksaanlab' => array(self::BELONGS_TO, 'PemeriksaanlabM', 'pemeriksaanlab_id'),
			'daftartindakan' => array(self::BELONGS_TO, 'DaftartindakanM', 'daftartindakan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'spesimenhasiloperasidet_id' => 'Spesimenhasiloperasidet',
			'spesimenhasiloperasi_id' => 'Spesimenhasiloperasi',
			'pemeriksaanlab_id' => 'Pemeriksaanlab',
			'daftartindakan_id' => 'Daftartindakan',
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

		if(!empty($this->spesimenhasiloperasidet_id)){
			$criteria->addCondition('spesimenhasiloperasidet_id = '.$this->spesimenhasiloperasidet_id);
		}
		if(!empty($this->spesimenhasiloperasi_id)){
			$criteria->addCondition('spesimenhasiloperasi_id = '.$this->spesimenhasiloperasi_id);
		}
		if(!empty($this->pemeriksaanlab_id)){
			$criteria->addCondition('pemeriksaanlab_id = '.$this->pemeriksaanlab_id);
		}
		if(!empty($this->daftartindakan_id)){
			$criteria->addCondition('daftartindakan_id = '.$this->daftartindakan_id);
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
}