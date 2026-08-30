<?php

/**
 * This is the model class for table "resephd_m".
 *
 * The followings are the available columns in table 'resephd_m':
 * @property integer $resephd_id
 * @property string $resephd_nama
 * @property string $resephd_desc
 * @property boolean $resephd_aktif
 */
class ResephdM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ResephdM the static model class
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
		return 'resephd_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('resephd_nama, resephd_desc', 'required'),
			array('resephd_nama', 'length', 'max'=>50),
			array('resephd_desc', 'length', 'max'=>200),
			array('resephd_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('resephd_id, resephd_nama, resephd_desc, resephd_aktif', 'safe', 'on'=>'search'),
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
			'resephd_id' => 'ID Resep HD',
			'resephd_nama' => 'Nama Resep HD',
			'resephd_desc' => 'Deskripsi',
			'resephd_aktif' => 'Aktif',
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

		if(!empty($this->resephd_id)){
			$criteria->addCondition('resephd_id = '.$this->resephd_id);
		}
		$criteria->compare('LOWER(resephd_nama)',strtolower($this->resephd_nama),true);
		$criteria->compare('LOWER(resephd_desc)',strtolower($this->resephd_desc),true);
		$criteria->compare('resephd_aktif',isset($this->resephd_aktif)?$this->resephd_aktif:true);

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