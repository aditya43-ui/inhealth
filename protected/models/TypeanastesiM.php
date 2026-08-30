<?php

/**
 * This is the model class for table "typeanastesi_m".
 *
 * The followings are the available columns in table 'typeanastesi_m':
 * @property integer $typeanastesi_id
 * @property integer $anastesi_id
 * @property string $typeanastesi_nama
 * @property string $typeanastesi_namalain
 * @property boolean $typeanastesi_aktif
 *
 * The followings are the available model relations:
 * @property PasienanastesiT[] $pasienanastesiTs
 * @property AnastesiM $anastesi
 */
class TypeanastesiM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TypeanastesiM the static model class
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
		return 'typeanastesi_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('typeanastesi_nama', 'required'),
			array('anastesi_id', 'numerical', 'integerOnly'=>true),
			array('typeanastesi_nama', 'length', 'max'=>500),
			array('typeanastesi_namalain', 'length', 'max'=>30),
			array('typeanastesi_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('typeanastesi_id, anastesi_id, typeanastesi_nama, typeanastesi_namalain, typeanastesi_aktif', 'safe', 'on'=>'search'),
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
			'pasienanastesiTs' => array(self::HAS_MANY, 'PasienanastesiT', 'typeanastesi_id'),
			'anastesi' => array(self::BELONGS_TO, 'AnastesiM', 'anastesi_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'typeanastesi_id' => 'Tipe Anestesi',
			'anastesi_id' => 'Teknik Anestesi',
			'typeanastesi_nama' => 'Tipe Anestesi',
			'typeanastesi_namalain' => 'Nama Lainnya',
			'typeanastesi_aktif' => 'Aktif',
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

		if(!empty($this->typeanastesi_id)){
			$criteria->addCondition('typeanastesi_id = '.$this->typeanastesi_id);
		}
		if(!empty($this->anastesi_id)){
			$criteria->addCondition('anastesi_id = '.$this->anastesi_id);
		}
		$criteria->compare('LOWER(typeanastesi_nama)',strtolower($this->typeanastesi_nama),true);
		$criteria->compare('LOWER(typeanastesi_namalain)',strtolower($this->typeanastesi_namalain),true);
		$criteria->compare('typeanastesi_aktif',$this->typeanastesi_aktif);

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