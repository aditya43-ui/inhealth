<?php

/**
 * This is the model class for table "ricaramasuk_r".
 *
 * The followings are the available columns in table 'ricaramasuk_r':
 * @property integer $ricaramasuk_id
 * @property string $tanggal
 * @property integer $langsung
 * @property integer $darird
 * @property integer $darirj
 */
class RicaramasukR extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RicaramasukR the static model class
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
		return 'ricaramasuk_r';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('langsung, darird, darirj', 'numerical', 'integerOnly'=>true),
			array('tanggal', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ricaramasuk_id, tanggal, langsung, darird, darirj', 'safe', 'on'=>'search'),
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
			'ricaramasuk_id' => 'Ricaramasuk',
			'tanggal' => 'Tanggal',
			'langsung' => 'Langsung',
			'darird' => 'Darird',
			'darirj' => 'Darirj',
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

		if(!empty($this->ricaramasuk_id)){
			$criteria->addCondition('ricaramasuk_id = '.$this->ricaramasuk_id);
		}
		$criteria->compare('LOWER(tanggal)',strtolower($this->tanggal),true);
		if(!empty($this->langsung)){
			$criteria->addCondition('langsung = '.$this->langsung);
		}
		if(!empty($this->darird)){
			$criteria->addCondition('darird = '.$this->darird);
		}
		if(!empty($this->darirj)){
			$criteria->addCondition('darirj = '.$this->darirj);
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