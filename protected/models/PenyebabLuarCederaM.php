<?php

/**
 * This is the model class for table "penyebabluarcedera_m".
 *
 * The followings are the available columns in table 'penyebabluarcedera_m':
 * @property integer $penyebabluarcedera_id
 * @property string $penyebabluarcedera_nama
 * @property string $penyebabluarcedera_namalainnya
 * @property string $penyebabluarcedera_aktif
 */
class PenyebabLuarCederaM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PenyebabLuarCederaM the static model class
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
		return 'penyebabluarcedera_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('penyebabluarcedera_nama', 'required'),
			array('penyebabluarcedera_nama, penyebabluarcedera_namalainnya, penyebabluarcedera_aktif', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('penyebabluarcedera_id, penyebabluarcedera_nama, penyebabluarcedera_namalainnya, penyebabluarcedera_aktif', 'safe', 'on'=>'search'),
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
			'penyebabluarcedera_id' => 'ID',
			'penyebabluarcedera_nama' => 'Nama Penyebab Luar Cedera',
			'penyebabluarcedera_namalainnya' => 'Nama Lainnya',
			'penyebabluarcedera_aktif' => 'Aktif',
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

		$criteria->compare('penyebabluarcedera_id',$this->penyebabluarcedera_id);
		$criteria->compare('LOWER(penyebabluarcedera_nama)',strtolower($this->penyebabluarcedera_nama),true);
		$criteria->compare('LOWER(penyebabluarcedera_namalainnya)',strtolower($this->penyebabluarcedera_namalainnya),true);
                $criteria->compare('LOWER(penyebabluarcedera_aktif)',strtolower($this->penyebabluarcedera_aktif),true);
		

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('penyebabluarcedera_id',$this->penyebabluarcedera_id);
		$criteria->compare('LOWER(penyebabluarcedera_nama)',strtolower($this->penyebabluarcedera_nama),true);
		$criteria->compare('LOWER(penyebabluarcedera_namalainnya)',strtolower($this->penyebabluarcedera_namalainnya),true);
		$criteria->compare('LOWER(penyebabluarcedera_aktif)',strtolower($this->penyebabluarcedera_aktif),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}