<?php

/**
 * This is the model class for table "riwayatkeluarga_r".
 *
 * The followings are the available columns in table 'riwayatkeluarga_r':
 * @property integer $riwayatkeluarga_id
 * @property integer $anamesa_id
 * @property string $nama_riwayat_keluarga
 * @property string $status_riwayat_keluarga
 */
class RiwayatkeluargaR extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RiwayatkeluargaR the static model class
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
		return 'riwayatkeluarga_r';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('anamesa_id, nama_riwayat_keluarga, status_riwayat_keluarga', 'required'),
			array('anamesa_id', 'numerical', 'integerOnly'=>true),
			array('nama_riwayat_keluarga', 'length', 'max'=>200),
			array('status_riwayat_keluarga', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('riwayatkeluarga_id, anamesa_id, nama_riwayat_keluarga, status_riwayat_keluarga', 'safe', 'on'=>'search'),
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
			'riwayatkeluarga_id' => 'Riwayatkeluarga',
			'anamesa_id' => 'Anamesa',
			'nama_riwayat_keluarga' => 'Nama Riwayat Keluarga',
			'status_riwayat_keluarga' => 'Status Riwayat Keluarga',
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

		if(!empty($this->riwayatkeluarga_id)){
			$criteria->addCondition('riwayatkeluarga_id = '.$this->riwayatkeluarga_id);
		}
		if(!empty($this->anamesa_id)){
			$criteria->addCondition('anamesa_id = '.$this->anamesa_id);
		}
		$criteria->compare('LOWER(nama_riwayat_keluarga)',strtolower($this->nama_riwayat_keluarga),true);
		$criteria->compare('LOWER(status_riwayat_keluarga)',strtolower($this->status_riwayat_keluarga),true);

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