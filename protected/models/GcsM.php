<?php

/**
 * This is the model class for table "gcs_m".
 *
 * The followings are the available columns in table 'gcs_m':
 * @property integer $gcs_id
 * @property string $gcs_nama
 * @property string $gcs_namalainnya
 * @property integer $gcs_nilaimin
 * @property integer $gcs_nilaimax
 * @property boolean $gcs_aktif
 */
class GcsM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return GcsM the static model class
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
		return 'gcs_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('gcs_nama, gcs_nilaimin, gcs_nilaimax', 'required'),
			array('gcs_nilaimin, gcs_nilaimax', 'numerical', 'integerOnly'=>true),
			array('gcs_nama, gcs_namalainnya', 'length', 'max'=>50),
			array('gcs_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('gcs_id, gcs_nama, gcs_namalainnya, gcs_nilaimin, gcs_nilaimax, gcs_aktif', 'safe', 'on'=>'search'),
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
			'gcs_id' => 'Gcs',
			'gcs_nama' => 'Gcs Nama',
			'gcs_namalainnya' => 'Gcs Namalainnya',
			'gcs_nilaimin' => 'Gcs Nilaimin',
			'gcs_nilaimax' => 'Gcs Nilaimax',
			'gcs_aktif' => 'Gcs Aktif',
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

		$criteria->compare('gcs_id',$this->gcs_id);
		$criteria->compare('LOWER(gcs_nama)',strtolower($this->gcs_nama),true);
		$criteria->compare('LOWER(gcs_namalainnya)',strtolower($this->gcs_namalainnya),true);
		$criteria->compare('gcs_nilaimin',$this->gcs_nilaimin);
		$criteria->compare('gcs_nilaimax',$this->gcs_nilaimax);
		$criteria->compare('gcs_aktif',$this->gcs_aktif);
                $criteria->compare('gcs_aktif is true');
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('gcs_id',$this->gcs_id);
		$criteria->compare('LOWER(gcs_nama)',strtolower($this->gcs_nama),true);
		$criteria->compare('LOWER(gcs_namalainnya)',strtolower($this->gcs_namalainnya),true);
		$criteria->compare('gcs_nilaimin',$this->gcs_nilaimin);
		$criteria->compare('gcs_nilaimax',$this->gcs_nilaimax);
		$criteria->compare('gcs_aktif',$this->gcs_aktif);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}