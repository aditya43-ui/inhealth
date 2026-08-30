<?php

/**
 * This is the model class for table "kelompokumurjk_m".
 *
 * The followings are the available columns in table 'kelompokumurjk_m':
 * @property integer $kelompokumurjk_id
 * @property string $kelompokumurjk_nama
 * @property integer $kelompokumurjk_min
 * @property integer $kelompokumurjk_max
 * @property boolean $kelompokumurjk_aktif
 */
class KelompokumurjkM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KelompokumurjkM the static model class
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
		return 'kelompokumurjk_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kelompokumurjk_nama, kelompokumurjk_min, kelompokumurjk_max', 'required'),
			array('kelompokumurjk_min, kelompokumurjk_max', 'numerical', 'integerOnly'=>true),
			array('kelompokumurjk_nama', 'length', 'max'=>20),
			array('kelompokumurjk_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('kelompokumurjk_id, kelompokumurjk_nama, kelompokumurjk_min, kelompokumurjk_max, kelompokumurjk_aktif', 'safe', 'on'=>'search'),
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
			'kelompokumurjk_id' => 'Kelompokumurjk',
			'kelompokumurjk_nama' => 'Kelompokumurjk Nama',
			'kelompokumurjk_min' => 'Kelompokumurjk Min',
			'kelompokumurjk_max' => 'Kelompokumurjk Max',
			'kelompokumurjk_aktif' => 'Kelompokumurjk Aktif',
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

		if(!empty($this->kelompokumurjk_id)){
			$criteria->addCondition('kelompokumurjk_id = '.$this->kelompokumurjk_id);
		}
		$criteria->compare('LOWER(kelompokumurjk_nama)',strtolower($this->kelompokumurjk_nama),true);
		if(!empty($this->kelompokumurjk_min)){
			$criteria->addCondition('kelompokumurjk_min = '.$this->kelompokumurjk_min);
		}
		if(!empty($this->kelompokumurjk_max)){
			$criteria->addCondition('kelompokumurjk_max = '.$this->kelompokumurjk_max);
		}
		$criteria->compare('kelompokumurjk_aktif',$this->kelompokumurjk_aktif);

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