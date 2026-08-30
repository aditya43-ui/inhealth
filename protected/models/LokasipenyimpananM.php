<?php

/**
 * This is the model class for table "lokasipenyimpanan_m".
 *
 * The followings are the available columns in table 'lokasipenyimpanan_m':
 * @property integer $lokasipenyimpanan_id
 * @property integer $instalasi_id
 * @property string $lokasipenyimpanan_kode
 * @property string $lokasipenyimpanan_nama
 * @property string $lokasipenyimpanan_namalain
 * @property boolean $lokasipenyimpanan_aktif
 */
class LokasipenyimpananM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LokasipenyimpananM the static model class
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
		return 'lokasipenyimpanan_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('instalasi_id, lokasipenyimpanan_kode, lokasipenyimpanan_nama, lokasipenyimpanan_namalain', 'required'),
			array('instalasi_id', 'numerical', 'integerOnly'=>true),
			array('lokasipenyimpanan_kode', 'length', 'max'=>10),
			array('lokasipenyimpanan_nama, lokasipenyimpanan_namalain', 'length', 'max'=>100),
			array('lokasipenyimpanan_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('lokasipenyimpanan_id, instalasi_id, lokasipenyimpanan_kode, lokasipenyimpanan_nama, lokasipenyimpanan_namalain, lokasipenyimpanan_aktif', 'safe', 'on'=>'search'),
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
			 'instalasi' => array(self::BELONGS_TO, 'InstalasiM', 'instalasi_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'lokasipenyimpanan_id' => 'ID',
			'instalasi_id' => 'Instalasi',
			'lokasipenyimpanan_kode' => 'Kode',
			'lokasipenyimpanan_nama' => 'Nama Lokasi Penyimpanan',
			'lokasipenyimpanan_namalain' => 'Nama Lain',
			'lokasipenyimpanan_aktif' => 'Aktif',
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

		if(!empty($this->lokasipenyimpanan_id)){
			$criteria->addCondition('lokasipenyimpanan_id = '.$this->lokasipenyimpanan_id);
		}
		if(!empty($this->instalasi_id)){
			$criteria->addCondition('instalasi_id = '.$this->instalasi_id);
		}
		$criteria->compare('LOWER(lokasipenyimpanan_kode)',strtolower($this->lokasipenyimpanan_kode),true);
		$criteria->compare('LOWER(lokasipenyimpanan_nama)',strtolower($this->lokasipenyimpanan_nama),true);
		$criteria->compare('LOWER(lokasipenyimpanan_namalain)',strtolower($this->lokasipenyimpanan_namalain),true);
		//$criteria->compare('lokasipenyimpanan_aktif',$this->lokasipenyimpanan_aktif);


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
		public function searchDialog()
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