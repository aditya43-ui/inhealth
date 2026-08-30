<?php

/**
 * This is the model class for table "kemampuanpelamar_r".
 *
 * The followings are the available columns in table 'kemampuanpelamar_r':
 * @property integer $pelamar_id
 * @property string $kemampuan_nama
 * @property string $kemampuan_tingkat
 */
class KemampuanpelamarR extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KemampuanpelamarR the static model class
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
		return 'kemampuanpelamar_r';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pelamar_id, kemampuan_nama, kemampuan_tingkat', 'required'),
			array('pelamar_id, sertifikasipegawai_id', 'numerical', 'integerOnly'=>true),
			array('kemampuan_nama', 'length', 'max'=>200),
			array('kemampuan_tingkat', 'length', 'max'=>50),
			array('masaberlaku_sertifikasi', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pelamar_id, kemampuan_nama, kemampuan_tingkat, sertifikasipegawai_id, masaberlaku_sertifikasi', 'safe', 'on'=>'search'),
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
			'pelamar_id' => 'Pelamar',
			'kemampuan_nama' => 'Kemampuan Nama',
			'kemampuan_tingkat' => 'Kemampuan Tingkat',
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

		if(!empty($this->pelamar_id)){
			$criteria->addCondition('pelamar_id = '.$this->pelamar_id);
		}
		$criteria->compare('LOWER(kemampuan_nama)',strtolower($this->kemampuan_nama),true);
		$criteria->compare('LOWER(kemampuan_tingkat)',strtolower($this->kemampuan_tingkat),true);

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