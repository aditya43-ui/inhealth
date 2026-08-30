<?php

/**
 * This is the model class for table "triase_m".
 *
 * The followings are the available columns in table 'triase_m':
 * @property integer $triase_id
 * @property string $triase_nama
 * @property string $triase_namalainnya
 * @property string $warna_triase
 * @property string $kode_warnatriase
 * @property string $keterangan_triase
 * @property boolean $triase_aktif
 */
class Triase extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Triase the static model class
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
		return 'triase_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('triase_nama, triase_namalainnya', 'length', 'max'=>50),
			array('warna_triase', 'length', 'max'=>10),
			array('kode_warnatriase', 'length', 'max'=>12),
			array('keterangan_triase', 'length', 'max'=>100),
			array('triase_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('triase_id, triase_nama, triase_namalainnya, warna_triase, kode_warnatriase, keterangan_triase, triase_aktif', 'safe', 'on'=>'search'),
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
			'triase_id' => 'ID',
			'triase_nama' => 'Nama Triase',
			'triase_namalainnya' => 'Nama Lain Triase',
			'warna_triase' => 'Warna Triase',
			'kode_warnatriase' => 'Kode Warna Triase',
			'keterangan_triase' => 'Keterangan Triase',
			'triase_aktif' => 'Status Aktif',
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

		$criteria->compare('triase_id',$this->triase_id);
		$criteria->compare('LOWER(triase_nama)',strtolower($this->triase_nama),true);
		$criteria->compare('LOWER(triase_namalainnya)',strtolower($this->triase_namalainnya),true);
		$criteria->compare('LOWER(warna_triase)',strtolower($this->warna_triase),true);
		$criteria->compare('LOWER(kode_warnatriase)',strtolower($this->kode_warnatriase),true);
		$criteria->compare('LOWER(keterangan_triase)',strtolower($this->keterangan_triase),true);
		$criteria->compare('triase_aktif',isset($this->triase_aktif)?$this->triase_aktif:true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('triase_id',$this->triase_id);
		$criteria->compare('LOWER(triase_nama)',strtolower($this->triase_nama),true);
		$criteria->compare('LOWER(triase_namalainnya)',strtolower($this->triase_namalainnya),true);
		$criteria->compare('LOWER(warna_triase)',strtolower($this->warna_triase),true);
		$criteria->compare('LOWER(kode_warnatriase)',strtolower($this->kode_warnatriase),true);
		$criteria->compare('LOWER(keterangan_triase)',strtolower($this->keterangan_triase),true);
//		$criteria->compare('triase_aktif',$this->triase_aktif);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}