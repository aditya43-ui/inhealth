<?php

/**
 * This is the model class for table "golongan_m".
 *
 * The followings are the available columns in table 'golongan_m':
 * @property integer $golongan_id
 * @property string $golongan_kode
 * @property string $golongan_nama
 * @property string $golongan_namalainnya
 * @property boolean $golongan_aktif
 */
class GolonganM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return GolonganM the static model class
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
		return 'golongan_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('golongan_kode, golongan_nama', 'required'),
			array('golongan_kode', 'length', 'max'=>50),
			array('golongan_nama, golongan_namalainnya', 'length', 'max'=>100),
			array('golongan_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('golongan_id, golongan_kode, golongan_nama, golongan_namalainnya, golongan_aktif', 'safe', 'on'=>'search'),
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
			'golongan_id' => 'ID',
			'golongan_kode' => 'Kode Golongan ',
			'golongan_nama' => 'Nama Golongan ',
			'golongan_namalainnya' => 'Nama Lainnya',
			'golongan_aktif' => 'Aktif',
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

		$criteria->compare('golongan_id',$this->golongan_id);
		$criteria->compare('LOWER(golongan_kode)',strtolower($this->golongan_kode),true);
		$criteria->compare('LOWER(golongan_nama)',strtolower($this->golongan_nama),true);
		$criteria->compare('LOWER(golongan_namalainnya)',strtolower($this->golongan_namalainnya),true);
		$criteria->compare('golongan_aktif',isset($this->golongan_aktif)?$this->golongan_aktif:true);
//                $criteria->compare('golongan_aktif is true');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('golongan_id',$this->golongan_id);
		$criteria->compare('LOWER(golongan_kode)',strtolower($this->golongan_kode),true);
		$criteria->compare('LOWER(golongan_nama)',strtolower($this->golongan_nama),true);
		$criteria->compare('LOWER(golongan_namalainnya)',strtolower($this->golongan_namalainnya),true);
		$criteria->compare('golongan_aktif',$this->golongan_aktif);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
}