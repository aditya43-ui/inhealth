<?php

/**
 * This is the model class for table "golonganoperasi_m".
 *
 * The followings are the available columns in table 'golonganoperasi_m':
 * @property integer $golonganoperasi_id
 * @property string $golonganoperasi_nama
 * @property string $golonganoperasi_namalainnya
 * @property boolean $golonganoperasi_aktif
 */
class GolonganoperasiM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return GolonganoperasiM the static model class
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
		return 'golonganoperasi_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('golonganoperasi_nama', 'required'),
			array('golonganoperasi_nama, golonganoperasi_namalainnya', 'length', 'max'=>50),
			array('golonganoperasi_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('golonganoperasi_id, golonganoperasi_nama, golonganoperasi_namalainnya, golonganoperasi_aktif', 'safe', 'on'=>'search'),
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
			'golonganoperasi_id' => 'Golonganoperasi',
			'golonganoperasi_nama' => 'Golonganoperasi Nama',
			'golonganoperasi_namalainnya' => 'Golonganoperasi Namalainnya',
			'golonganoperasi_aktif' => 'Golonganoperasi Aktif',
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

		$criteria->compare('golonganoperasi_id',$this->golonganoperasi_id);
		$criteria->compare('LOWER(golonganoperasi_nama)',strtolower($this->golonganoperasi_nama),true);
		$criteria->compare('LOWER(golonganoperasi_namalainnya)',strtolower($this->golonganoperasi_namalainnya),true);
		$criteria->compare('golonganoperasi_aktif',$this->golonganoperasi_aktif);
                $criteria->addCondition('golonganoperasi_aktif is true');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('golonganoperasi_id',$this->golonganoperasi_id);
		$criteria->compare('LOWER(golonganoperasi_nama)',strtolower($this->golonganoperasi_nama),true);
		$criteria->compare('LOWER(golonganoperasi_namalainnya)',strtolower($this->golonganoperasi_namalainnya),true);
		$criteria->compare('golonganoperasi_aktif',$this->golonganoperasi_aktif);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
        /*
         *  Fungsi untuk mengembalikan nilai yg berupa objek GolonganoperasiM yang sudah di sortir berdasarkan nama dan aktif
         */
        public function getAll()
        {
            return $this->findAll('golonganoperasi_aktif = true order by golonganoperasi_nama');
        }
}