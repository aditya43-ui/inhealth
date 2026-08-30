<?php

/**
 * This is the model class for table "bahanlinen_m".
 *
 * The followings are the available columns in table 'bahanlinen_m':
 * @property integer $bahanlinen_id
 * @property string $bahanlinen_nama
 * @property string $bahanlinen_namalain
 * @property string $suhurekomendasi
 * @property boolean $bahanlinen_aktif
 */
class BahanlinenM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BahanlinenM the static model class
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
		return 'bahanlinen_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('bahanlinen_nama', 'required'),
			array('bahanlinen_nama, bahanlinen_namalain', 'length', 'max'=>200),
			array('suhurekomendasi', 'length', 'max'=>10),
			array('bahanlinen_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('bahanlinen_id, bahanlinen_nama, bahanlinen_namalain, suhurekomendasi, bahanlinen_aktif', 'safe', 'on'=>'search'),
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
			'bahanlinen_id' => 'ID',
			'bahanlinen_nama' => 'Bahan Linen',
			'bahanlinen_namalain' => 'Nama Lain',
			'suhurekomendasi' => 'Suhu Rekomendasi',
			'bahanlinen_aktif' => 'Aktif',
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

		if(!empty($this->bahanlinen_id)){
			$criteria->addCondition('bahanlinen_id = '.$this->bahanlinen_id);
		}
		$criteria->compare('LOWER(bahanlinen_nama)',strtolower($this->bahanlinen_nama),true);
		$criteria->compare('LOWER(bahanlinen_namalain)',strtolower($this->bahanlinen_namalain),true);
		$criteria->compare('LOWER(suhurekomendasi)',strtolower($this->suhurekomendasi),true);
		$criteria->compare('bahanlinen_aktif', isset($this->bahanlinen_aktif)?$this->bahanlinen_aktif:true);

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