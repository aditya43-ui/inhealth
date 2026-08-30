<?php

/**
 * This is the model class for table "tandagejala_daftar_m".
 *
 * The followings are the available columns in table 'tandagejala_daftar_m':
 * @property integer $tandagejala_daftar_id
 * @property string $tandagejala_daftar_nama
 * @property string $tandagejala_daftar_namalain
 * @property boolean $tandagejala_daftar_aktif
 */
class TandagejalaDaftarM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TandagejalaDaftarM the static model class
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
		return 'tandagejala_daftar_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tandagejala_daftar_nama', 'required'),
			array('tandagejala_daftar_namalain, tandagejala_daftar_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tandagejala_daftar_id, tandagejala_daftar_nama, tandagejala_daftar_namalain, tandagejala_daftar_aktif', 'safe', 'on'=>'search'),
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
			'tandagejala_daftar_id' => 'ID',
			'tandagejala_daftar_nama' => 'Tanda dan Gejala',
			'tandagejala_daftar_namalain' => 'Nama Lain Tanda dan Gejala',
			'tandagejala_daftar_aktif' => 'Status',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('tandagejala_daftar_id',$this->tandagejala_daftar_id);
		$criteria->compare('LOWER(tandagejala_daftar_nama)', strtolower($this->tandagejala_daftar_nama),true);
		$criteria->compare('LOWER(tandagejala_daftar_namalain)', strtolower($this->tandagejala_daftar_namalain),true);
		$criteria->compare('tandagejala_daftar_aktif', isset($this->tandagejala_daftar_aktif)?$this->tandagejala_daftar_aktif:true);

		return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
		));
	}
        
        /**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('tandagejala_daftar_id',$this->tandagejala_daftar_id);
		$criteria->compare('LOWER(tandagejala_daftar_nama)', strtolower($this->tandagejala_daftar_nama),true);
		$criteria->compare('LOWER(tandagejala_daftar_namalain)', strtolower($this->tandagejala_daftar_namalain),true);
		$criteria->compare('tandagejala_daftar_aktif', isset($this->tandagejala_daftar_aktif)?$this->tandagejala_daftar_aktif:true);
                $criteria->limit = -1;
		return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false
		));
	}
        
        /**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function searchDialog()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		
		$criteria->compare('LOWER(tandagejala_daftar_nama)', strtolower($this->tandagejala_daftar_nama),true);
		$criteria->compare('LOWER(tandagejala_daftar_namalain)', strtolower($this->tandagejala_daftar_namalain),true);
		$criteria->addCondition(" tandagejala_daftar_aktif = TRUE ");

		return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
		));
	}
}