<?php

/**
 * This is the model class for table "jenissterilisasi_m".
 *
 * The followings are the available columns in table 'jenissterilisasi_m':
 * @property integer $jenissterilisasi_id
 * @property string $jenissterilisasi_nama
 * @property string $jenissterilisasi_namalain
 * @property boolean $jenissterilisasi_aktif
 */
class JenissterilisasiM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JenissterilisasiM the static model class
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
		return 'jenissterilisasi_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jenissterilisasi_nama, jenissterilisasi_namalain, jenissterilisasi_aktif', 'required'),
			array('jenissterilisasi_nama, jenissterilisasi_namalain', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('jenissterilisasi_id, jenissterilisasi_nama, jenissterilisasi_namalain, jenissterilisasi_aktif', 'safe', 'on'=>'search'),
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
			'jenissterilisasi_id' => 'ID',
			'jenissterilisasi_nama' => 'Nama Jenis Sterilisasi',
			'jenissterilisasi_namalain' => 'Nama Lainnya',
			'jenissterilisasi_aktif' => 'Jenis Sterilisasi Aktif',
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

		if(!empty($this->jenissterilisasi_id)){
			$criteria->addCondition('jenissterilisasi_id = '.$this->jenissterilisasi_id);
		}
		$criteria->compare('LOWER(jenissterilisasi_nama)',strtolower($this->jenissterilisasi_nama),true);
		$criteria->compare('LOWER(jenissterilisasi_namalain)',strtolower($this->jenissterilisasi_namalain),true);
		$criteria->compare('jenissterilisasi_aktif',$this->jenissterilisasi_aktif);

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