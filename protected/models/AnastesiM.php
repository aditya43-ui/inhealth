<?php

/**
 * This is the model class for table "anastesi_m".
 *
 * The followings are the available columns in table 'anastesi_m':
 * @property integer $anastesi_id
 * @property integer $jenisanastesi_id
 * @property string $anastesi_nama
 * @property string $anastesi_namalainnya
 * @property boolean $anastesi_aktif
 */
class AnastesiM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AnastesiM the static model class
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
		return 'anastesi_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('anastesi_nama', 'required'),
			array('jenisanastesi_id', 'numerical', 'integerOnly'=>true),
			array('anastesi_nama, anastesi_namalainnya', 'length', 'max'=>50),
			array('daftartindakan_id, anastesi_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('anastesi_id, jenisanastesi_id, anastesi_nama, anastesi_namalainnya, anastesi_aktif', 'safe', 'on'=>'search'),
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
                    'jenisanastesi' => array(self::BELONGS_TO, 'JenisanastesiM', 'jenisanastesi_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'anastesi_id' => 'Anastesi',
			'jenisanastesi_id' => 'Jenis Anestesi',
			'anastesi_nama' => 'Nama',
			'anastesi_namalainnya' => 'nama lain',
			'anastesi_aktif' => 'Status',
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

		$criteria->compare('anastesi_id',$this->anastesi_id);
		$criteria->compare('jenisanastesi_id',$this->jenisanastesi_id);
		$criteria->compare('LOWER(anastesi_nama)',strtolower($this->anastesi_nama),true);
		$criteria->compare('LOWER(anastesi_namalainnya)',strtolower($this->anastesi_namalainnya),true);
		$criteria->compare('anastesi_aktif',$this->anastesi_aktif);
                $criteria->addCondition('anastesi_aktif is true');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('anastesi_id',$this->anastesi_id);
		$criteria->compare('jenisanastesi_id',$this->jenisanastesi_id);
		$criteria->compare('LOWER(anastesi_nama)',strtolower($this->anastesi_nama),true);
		$criteria->compare('LOWER(anastesi_namalainnya)',strtolower($this->anastesi_namalainnya),true);
		$criteria->compare('anastesi_aktif',$this->anastesi_aktif);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}