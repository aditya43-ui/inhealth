<?php

/**
 * This is the model class for table "pasienujk_r".
 *
 * The followings are the available columns in table 'pasienujk_r':
 * @property integer $pasienujk_id
 * @property string $tanggal
 * @property string $golonganumur
 * @property integer $lakilaki
 * @property integer $perempuan
 */
class PasienujkR extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PasienujkR the static model class
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
		return 'pasienujk_r';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lakilaki, perempuan', 'numerical', 'integerOnly'=>true),
			array('golonganumur', 'length', 'max'=>25),
			array('tanggal', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pasienujk_id, tanggal, golonganumur, lakilaki, perempuan', 'safe', 'on'=>'search'),
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
			'pasienujk_id' => 'Pasienujk',
			'tanggal' => 'Tanggal',
			'golonganumur' => 'Golonganumur',
			'lakilaki' => 'Lakilaki',
			'perempuan' => 'Perempuan',
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

		if(!empty($this->pasienujk_id)){
			$criteria->addCondition('pasienujk_id = '.$this->pasienujk_id);
		}
		$criteria->compare('LOWER(tanggal)',strtolower($this->tanggal),true);
		$criteria->compare('LOWER(golonganumur)',strtolower($this->golonganumur),true);
		if(!empty($this->lakilaki)){
			$criteria->addCondition('lakilaki = '.$this->lakilaki);
		}
		if(!empty($this->perempuan)){
			$criteria->addCondition('perempuan = '.$this->perempuan);
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