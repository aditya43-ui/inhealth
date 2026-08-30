<?php

/**
 * This is the model class for table "kunjunganrs_r".
 *
 * The followings are the available columns in table 'kunjunganrs_r':
 * @property integer $kunjunganrs_id
 * @property string $tanggal
 * @property integer $kunjungan_ri
 * @property integer $kunjungan_rd
 * @property integer $kunjungan_rj
 */
class KunjunganrsR extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KunjunganrsR the static model class
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
		return 'kunjunganrs_r';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kunjungan_ri, kunjungan_rd, kunjungan_rj', 'numerical', 'integerOnly'=>true),
			array('tanggal', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('kunjunganrs_id, tanggal, kunjungan_ri, kunjungan_rd, kunjungan_rj', 'safe', 'on'=>'search'),
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
			'kunjunganrs_id' => 'Kunjunganrs',
			'tanggal' => 'Tanggal',
			'kunjungan_ri' => 'Kunjungan Ri',
			'kunjungan_rd' => 'Kunjungan Rd',
			'kunjungan_rj' => 'Kunjungan Rj',
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

		if(!empty($this->kunjunganrs_id)){
			$criteria->addCondition('kunjunganrs_id = '.$this->kunjunganrs_id);
		}
		$criteria->compare('LOWER(tanggal)',strtolower($this->tanggal),true);
		if(!empty($this->kunjungan_ri)){
			$criteria->addCondition('kunjungan_ri = '.$this->kunjungan_ri);
		}
		if(!empty($this->kunjungan_rd)){
			$criteria->addCondition('kunjungan_rd = '.$this->kunjungan_rd);
		}
		if(!empty($this->kunjungan_rj)){
			$criteria->addCondition('kunjungan_rj = '.$this->kunjungan_rj);
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