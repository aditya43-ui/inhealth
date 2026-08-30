<?php

/**
 * This is the model class for table "jenisanastesi_m".
 *
 * The followings are the available columns in table 'jenisanastesi_m':
 * @property integer $jenisanastesi_id
 * @property string $jenisanastesi_nama
 * @property string $jenisanastesi_namalainnya
 * @property string $jenisanastesi_teknik
 * @property boolean $jenisanastesi_aktif
 */
class JenisanastesiM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JenisanastesiM the static model class
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
		return 'jenisanastesi_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jenisanastesi_nama, jenisanastesi_teknik', 'required'),
			array('jenisanastesi_nama, jenisanastesi_namalainnya, jenisanastesi_teknik', 'length', 'max'=>50),
			array('jenisanastesi_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('jenisanastesi_id, jenisanastesi_nama, jenisanastesi_namalainnya, jenisanastesi_teknik, jenisanastesi_aktif', 'safe', 'on'=>'search'),
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
			'jenisanastesi_id' => 'Jenis Anestesi',
			'jenisanastesi_nama' => 'Jenis Anestesi',
			'jenisanastesi_namalainnya' => 'Nama Lainnya',
			'jenisanastesi_teknik' => 'Teknik Jenis Anestesi',
			'jenisanastesi_aktif' => 'Aktif',
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

		$criteria->compare('jenisanastesi_id',$this->jenisanastesi_id);
		$criteria->compare('LOWER(jenisanastesi_nama)',strtolower($this->jenisanastesi_nama),true);
		$criteria->compare('LOWER(jenisanastesi_namalainnya)',strtolower($this->jenisanastesi_namalainnya),true);
		$criteria->compare('LOWER(jenisanastesi_teknik)',strtolower($this->jenisanastesi_teknik),true);
		$criteria->compare('jenisanastesi_aktif',isset($this->jenisanastesi_aktif)?$this->jenisanastesi_aktif:true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('jenisanastesi_id',$this->jenisanastesi_id);
		$criteria->compare('LOWER(jenisanastesi_nama)',strtolower($this->jenisanastesi_nama),true);
		$criteria->compare('LOWER(jenisanastesi_namalainnya)',strtolower($this->jenisanastesi_namalainnya),true);
		$criteria->compare('LOWER(jenisanastesi_teknik)',strtolower($this->jenisanastesi_teknik),true);
		$criteria->compare('jenisanastesi_aktif',isset($this->jenisanastesi_aktif)?$this->jenisanastesi_aktif:true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}