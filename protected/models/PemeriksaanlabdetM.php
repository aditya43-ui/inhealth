<?php

/**
 * This is the model class for table "pemeriksaanlabdet_m".
 *
 * The followings are the available columns in table 'pemeriksaanlabdet_m':
 * @property integer $pemeriksaanlabdet_id
 * @property integer $nilairujukan_id
 * @property integer $pemeriksaanlab_id
 * @property integer $pemeriksaanlabdet_nourut
 *
 * The followings are the available model relations:
 * @property PemeriksaanlabM $pemeriksaanlab
 * @property NilairujukanM $nilairujukan
 * @property DetailhasilpemeriksaanlabT[] $detailhasilpemeriksaanlabTs
 */
class PemeriksaanlabdetM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PemeriksaanlabdetM the static model class
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
		return 'pemeriksaanlabdet_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nilairujukan_id, pemeriksaanlab_id, pemeriksaanlabdet_nourut', 'required'),
			array('nilairujukan_id, pemeriksaanlab_id, pemeriksaanlabdet_nourut', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pemeriksaanlabdet_id, nilairujukan_id, pemeriksaanlab_id, pemeriksaanlabdet_nourut', 'safe', 'on'=>'search'),
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
			'pemeriksaanlab' => array(self::BELONGS_TO, 'PemeriksaanlabM', 'pemeriksaanlab_id'),
			'nilairujukan' => array(self::BELONGS_TO, 'NilairujukanM', 'nilairujukan_id'),
			'detailhasilpemeriksaanlabTs' => array(self::HAS_MANY, 'DetailhasilpemeriksaanlabT', 'pemeriksaanlabdet_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pemeriksaanlabdet_id' => 'Detail Pemeriksaan Id',
			'nilairujukan_id' => 'Nilai Rujukan',
			'pemeriksaanlab_id' => 'Pemeriksaan Lab',
			'pemeriksaanlabdet_nourut' => 'No. Urut',
                        'nilairujukan_jeniskelamin' => 'Jenis Kelamin'
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

		if(!empty($this->pemeriksaanlabdet_id)){
			$criteria->addCondition('pemeriksaanlabdet_id = '.$this->pemeriksaanlabdet_id);
		}
		if(!empty($this->nilairujukan_id)){
			$criteria->addCondition('nilairujukan_id = '.$this->nilairujukan_id);
		}
		if(!empty($this->pemeriksaanlab_id)){
			$criteria->addCondition('pemeriksaanlab_id = '.$this->pemeriksaanlab_id);
		}
		if(!empty($this->pemeriksaanlabdet_nourut)){
			$criteria->addCondition('pemeriksaanlabdet_nourut = '.$this->pemeriksaanlabdet_nourut);
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