<?php

/**
 * This is the model class for table "pegawaiberdasarkanklp_r".
 *
 * The followings are the available columns in table 'pegawaiberdasarkanklp_r':
 * @property integer $pegawaiberdasarkanklp_id
 * @property string $tanggal
 * @property integer $kelompokpegawai_id
 * @property string $kelompokpegawai_nama
 * @property integer $jumlah
 */
class PegawaiberdasarkanklpR extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PegawaiberdasarkanklpR the static model class
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
		return 'pegawaiberdasarkanklp_r';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kelompokpegawai_id, jumlah', 'numerical', 'integerOnly'=>true),
			array('kelompokpegawai_nama', 'length', 'max'=>30),
			array('tanggal', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pegawaiberdasarkanklp_id, tanggal, kelompokpegawai_id, kelompokpegawai_nama, jumlah', 'safe', 'on'=>'search'),
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
			'pegawaiberdasarkanklp_id' => 'Pegawaiberdasarkanklp',
			'tanggal' => 'Tanggal',
			'kelompokpegawai_id' => 'Kelompokpegawai',
			'kelompokpegawai_nama' => 'Kelompokpegawai Nama',
			'jumlah' => 'Jumlah',
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

		if(!empty($this->pegawaiberdasarkanklp_id)){
			$criteria->addCondition('pegawaiberdasarkanklp_id = '.$this->pegawaiberdasarkanklp_id);
		}
		$criteria->compare('LOWER(tanggal)',strtolower($this->tanggal),true);
		if(!empty($this->kelompokpegawai_id)){
			$criteria->addCondition('kelompokpegawai_id = '.$this->kelompokpegawai_id);
		}
		$criteria->compare('LOWER(kelompokpegawai_nama)',strtolower($this->kelompokpegawai_nama),true);
		if(!empty($this->jumlah)){
			$criteria->addCondition('jumlah = '.$this->jumlah);
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