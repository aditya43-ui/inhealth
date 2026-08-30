<?php

/**
 * This is the model class for table "instalasirevenuecost_v".
 *
 * The followings are the available columns in table 'instalasirevenuecost_v':
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 * @property string $instalasi_namalainnya
 * @property string $instalasi_singkatan
 * @property string $instalasi_lokasi
 */
class InstalasirevenuecostV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InstalasirevenuecostV the static model class
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
		return 'instalasirevenuecost_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('instalasi_id', 'numerical', 'integerOnly'=>true),
			array('instalasi_nama, instalasi_namalainnya, instalasi_lokasi', 'length', 'max'=>50),
			array('instalasi_singkatan', 'length', 'max'=>2),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('instalasi_id, instalasi_nama, instalasi_namalainnya, instalasi_singkatan, instalasi_lokasi', 'safe', 'on'=>'search'),
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
			'instalasi_id' => 'Instalasi',
			'instalasi_nama' => 'Instalasi Nama',
			'instalasi_namalainnya' => 'Instalasi Namalainnya',
			'instalasi_singkatan' => 'Instalasi Singkatan',
			'instalasi_lokasi' => 'Instalasi Lokasi',
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

		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
		$criteria->compare('LOWER(instalasi_namalainnya)',strtolower($this->instalasi_namalainnya),true);
		$criteria->compare('LOWER(instalasi_singkatan)',strtolower($this->instalasi_singkatan),true);
		$criteria->compare('LOWER(instalasi_lokasi)',strtolower($this->instalasi_lokasi),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
		$criteria->compare('LOWER(instalasi_namalainnya)',strtolower($this->instalasi_namalainnya),true);
		$criteria->compare('LOWER(instalasi_singkatan)',strtolower($this->instalasi_singkatan),true);
		$criteria->compare('LOWER(instalasi_lokasi)',strtolower($this->instalasi_lokasi),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}