<?php

/**
 * This is the model class for table "kemampuanpegawai_r".
 *
 * The followings are the available columns in table 'kemampuanpegawai_r':
 * @property integer $pegawai_id
 * @property string $kemampuanpegawai_nama
 * @property string $kemampuanpegawai_tingkat
 */
class KemampuanpegawaiR extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KemampuanpegawaiR the static model class
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
		return 'kemampuanpegawai_r';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pegawai_id, kemampuanpegawai_nama, kemampuanpegawai_tingkat', 'required'),
			array('pegawai_id', 'numerical', 'integerOnly'=>true),
			array('kemampuanpegawai_nama', 'length', 'max'=>200),
			array('kemampuanpegawai_tingkat', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pegawai_id, kemampuanpegawai_nama, kemampuanpegawai_tingkat', 'safe', 'on'=>'search'),
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
			'pegawai_id' => 'Pegawai',
			'kemampuanpegawai_nama' => 'Kemampuanpegawai Nama',
			'kemampuanpegawai_tingkat' => 'Kemampuanpegawai Tingkat',
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

		if(!empty($this->pegawai_id)){
			$criteria->addCondition('pegawai_id = '.$this->pegawai_id);
		}
		$criteria->compare('LOWER(kemampuanpegawai_nama)',strtolower($this->kemampuanpegawai_nama),true);
		$criteria->compare('LOWER(kemampuanpegawai_tingkat)',strtolower($this->kemampuanpegawai_tingkat),true);

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