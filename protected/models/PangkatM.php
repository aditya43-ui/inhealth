<?php

/**
 * This is the model class for table "pangkat_m".
 *
 * The followings are the available columns in table 'pangkat_m':
 * @property integer $pangkat_id
 * @property integer $golonganpegawai_id
 * @property string $pangkat_nama
 * @property string $pangkat_namalainnya
 * @property boolean $pangkat_aktif
 */
class PangkatM extends CActiveRecord
{
        public $golonganpegawai_nama;
        public $pangkat_urutan;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PangkatM the static model class
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
		return 'pangkat_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('golonganpegawai_id, pangkat_nama, pangkat_urutan', 'required'),
			array('golonganpegawai_id', 'numerical', 'integerOnly'=>true),
			array('pangkat_nama, pangkat_namalainnya', 'length', 'max'=>50),
			array('pangkat_aktif, pangkat_urutan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pangkat_id, golonganpegawai_id, pangkat_nama, pangkat_namalainnya, pangkat_aktif', 'safe', 'on'=>'search'),
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
                    'golonganpegawai'=>array(self::BELONGS_TO, 'GolonganpegawaiM', 'golonganpegawai_id'),

		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pangkat_id' => 'ID',
			'golonganpegawai_id' => 'Golongan Pegawai',
                        'golonganpegawai_nama'=>'Golongan Pegawai',
			'pangkat_nama' => 'Pangkat',
			'pangkat_namalainnya' => 'Nama Lain',
			'pangkat_aktif' => 'Aktif',
                        'pangkat_urutan' => 'Urutan'
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

		$criteria->compare('pangkat_id',$this->pangkat_id);
		$criteria->compare('golonganpegawai.golonganpegawai_id',$this->golonganpegawai_id);
		$criteria->compare('LOWER(pangkat_nama)',strtolower($this->pangkat_nama),true);
                $criteria->compare('LOWER(golonganpegawai.golonganpegawai_nama)',strtolower($this->golonganpegawai_nama),true);
		$criteria->compare('LOWER(pangkat_namalainnya)',strtolower($this->pangkat_namalainnya),true);
		$criteria->compare('pangkat_aktif',$this->pangkat_aktif);
                $criteria->with='golonganpegawai';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('pangkat_id',$this->pangkat_id);
		$criteria->compare('golonganpegawai_id',$this->golonganpegawai_id);
		$criteria->compare('LOWER(pangkat_nama)',strtolower($this->pangkat_nama),true);
		$criteria->compare('LOWER(pangkat_namalainnya)',strtolower($this->pangkat_namalainnya),true);
//		$criteria->compare('pangkat_aktif',$this->pangkat_aktif);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
        public function getGolonganPegawaiItems()
        {
            return GolonganpegawaiM::model()->findAll(array('condition'=>'golonganpegawai_aktif = TRUE ','order'=>'golonganpegawai_nama'));
        }
        
}