<?php

/**
 * This is the model class for table "pemeriksaanlabalat_m".
 *
 * The followings are the available columns in table 'pemeriksaanlabalat_m':
 * @property integer $pemeriksaanlabalat_id
 * @property integer $alatmedis_id
 * @property string $pemeriksaanlabalat_kode
 * @property string $pemeriksaanlabalat_nama
 * @property string $pemeriksaanlabalat_namalain
 * @property boolean $pemeriksaanlabalat_aktif
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $createruangan
 */
class PemeriksaanlabalatM extends CActiveRecord
{
        public $alatmedis_nama;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PemeriksaanlabalatM the static model class
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
		return 'pemeriksaanlabalat_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('alatmedis_id, pemeriksaanlabalat_kode, pemeriksaanlabalat_nama, pemeriksaanlabalat_namalain, create_time, create_loginpemakai_id, createruangan', 'required'),
			array('alatmedis_id, create_loginpemakai_id, update_loginpemakai_id, createruangan', 'numerical', 'integerOnly'=>true),
			array('pemeriksaanlabalat_kode', 'length', 'max'=>50),
			array('pemeriksaanlabalat_nama, pemeriksaanlabalat_namalain', 'length', 'max'=>200),
			array('pemeriksaanlabalat_aktif, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pemeriksaanlabalat_id, alatmedis_id, pemeriksaanlabalat_kode, pemeriksaanlabalat_nama, pemeriksaanlabalat_namalain, pemeriksaanlabalat_aktif, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, createruangan', 'safe', 'on'=>'search'),
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
			'alatmedis' => array(self::BELONGS_TO, 'AlatmedisM', 'alatmedis_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pemeriksaanlabalat_id' => 'Pemeriksaanlabalat',
			'alatmedis_id' => 'Alatmedis',
			'pemeriksaanlabalat_kode' => 'Pemeriksaanlabalat Kode',
			'pemeriksaanlabalat_nama' => 'Pemeriksaanlabalat Nama',
			'pemeriksaanlabalat_namalain' => 'Pemeriksaanlabalat Namalain',
			'pemeriksaanlabalat_aktif' => 'Pemeriksaanlabalat Aktif',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'createruangan' => 'Createruangan',
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

		if(!empty($this->pemeriksaanlabalat_id)){
			$criteria->addCondition('pemeriksaanlabalat_id = '.$this->pemeriksaanlabalat_id);
		}
		if(!empty($this->alatmedis_id)){
			$criteria->addCondition('alatmedis_id = '.$this->alatmedis_id);
		}
		$criteria->compare('LOWER(pemeriksaanlabalat_kode)',strtolower($this->pemeriksaanlabalat_kode),true);
		$criteria->compare('LOWER(pemeriksaanlabalat_nama)',strtolower($this->pemeriksaanlabalat_nama),true);
		$criteria->compare('LOWER(pemeriksaanlabalat_namalain)',strtolower($this->pemeriksaanlabalat_namalain),true);
		$criteria->compare('pemeriksaanlabalat_aktif',$this->pemeriksaanlabalat_aktif);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		if(!empty($this->create_loginpemakai_id)){
			$criteria->addCondition('create_loginpemakai_id = '.$this->create_loginpemakai_id);
		}
		if(!empty($this->update_loginpemakai_id)){
			$criteria->addCondition('update_loginpemakai_id = '.$this->update_loginpemakai_id);
		}
		if(!empty($this->createruangan)){
			$criteria->addCondition('createruangan = '.$this->createruangan);
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