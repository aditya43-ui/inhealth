<?php

/**
 * This is the model class for table "jenistenagamedis_m".
 *
 * The followings are the available columns in table 'jenistenagamedis_m':
 * @property integer $jenistenagamedis_id
 * @property string $tenagamedis_nama
 * @property string $tenagamedis_namalain
 * @property boolean $jenistenagamedis_aktif
 *
 * The followings are the available model relations:
 * @property PegawaiM[] $pegawaiMs
 */
class JenistenagamedisM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JenistenagamedisM the static model class
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
		return 'jenistenagamedis_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tenagamedis_nama, tenagamedis_namalain, jenistenagamedis_aktif', 'required'),
			array('tenagamedis_nama, tenagamedis_namalain', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('jenistenagamedis_id, tenagamedis_nama, tenagamedis_namalain, jenistenagamedis_aktif', 'safe', 'on'=>'search'),
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
			'pegawaiMs' => array(self::HAS_MANY, 'PegawaiM', 'jenistenagamedis_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'jenistenagamedis_id' => 'Jenistenagamedis',
			'tenagamedis_nama' => 'Tenagamedis Nama',
			'tenagamedis_namalain' => 'Tenagamedis Namalain',
			'jenistenagamedis_aktif' => 'Jenistenagamedis Aktif',
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

		if(!empty($this->jenistenagamedis_id)){
			$criteria->addCondition('jenistenagamedis_id = '.$this->jenistenagamedis_id);
		}
		$criteria->compare('LOWER(tenagamedis_nama)',strtolower($this->tenagamedis_nama),true);
		$criteria->compare('LOWER(tenagamedis_namalain)',strtolower($this->tenagamedis_namalain),true);
		$criteria->compare('jenistenagamedis_aktif',$this->jenistenagamedis_aktif);

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