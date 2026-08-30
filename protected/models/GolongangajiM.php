<?php

/**
 * This is the model class for table "golongangaji_m".
 *
 * The followings are the available columns in table 'golongangaji_m':
 * @property integer $golongangaji_id
 * @property integer $golonganpegawai_id
 * @property integer $masakerja
 * @property double $jmlgaji
 * @property string $jenisgolongan
 * @property boolean $golongangaji_aktif
 */
class GolongangajiM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return GolongangajiM the static model class
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
		return 'golongangaji_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('golonganpegawai_id, masakerja, jmlgaji, jenisgolongan', 'required'),
			array('golonganpegawai_id, masakerja', 'numerical', 'integerOnly'=>true),
			array('jmlgaji', 'numerical'),
			array('jenisgolongan', 'length', 'max'=>50),
			array('golongangaji_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('golongangaji_id, golonganpegawai_id, masakerja, jmlgaji, jenisgolongan, golongangaji_aktif', 'safe', 'on'=>'search'),
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
			'golonganpegawai'=>array(self::BELONGS_TO,'GolonganpegawaiM','golonganpegawai_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'golongangaji_id' => 'Id',
			'golonganpegawai_id' => 'Golongan Pegawai',
			'masakerja' => 'Masa Kerja',
			'jmlgaji' => 'Jumlah Gaji',
			'jenisgolongan' => 'Jenis Golongan',
			'golongangaji_aktif' => 'Aktif',
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

		$criteria->compare('golongangaji_id',$this->golongangaji_id);
		$criteria->compare('golonganpegawai_id',$this->golonganpegawai_id);
		$criteria->compare('masakerja',$this->masakerja);
		$criteria->compare('jmlgaji',$this->jmlgaji);
		$criteria->compare('LOWER(jenisgolongan)',strtolower($this->jenisgolongan),true);
		$criteria->compare('golongangaji_aktif',isset($this->golongangaji_aktif)?$this->golongangaji_aktif:true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('golongangaji_id',$this->golongangaji_id);
		$criteria->compare('golonganpegawai_id',$this->golonganpegawai_id);
		$criteria->compare('masakerja',$this->masakerja);
		$criteria->compare('jmlgaji',$this->jmlgaji);
		$criteria->compare('LOWER(jenisgolongan)',strtolower($this->jenisgolongan),true);
		$criteria->compare('golongangaji_aktif',$this->golongangaji_aktif);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}