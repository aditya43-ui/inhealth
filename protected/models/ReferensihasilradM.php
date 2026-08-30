<?php

/**
 * This is the model class for table "referensihasilrad_m".
 *
 * The followings are the available columns in table 'referensihasilrad_m':
 * @property integer $refhasilrad_id
 * @property integer $pemeriksaanrad_id
 * @property string $refhasilrad_kode
 * @property string $refhasilrad_hasil
 * @property string $refhasilrad_kesan
 * @property string $refhasilrad_kesimpulan
 * @property string $refhasilrad_keterangan
 * @property boolean $refhasilrad_aktif
 */
class ReferensihasilradM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ReferensihasilradM the static model class
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
		return 'referensihasilrad_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('refhasilrad_kode', 'required'),
			array('pemeriksaanrad_id', 'numerical', 'integerOnly'=>true),
			array('refhasilrad_kode', 'length', 'max'=>10),
			array('refhasilrad_banyak, refhasilrad_hasil, refhasilrad_kesan, refhasilrad_kesimpulan, refhasilrad_keterangan, refhasilrad_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('refhasilrad_id, pemeriksaanrad_id, refhasilrad_kode, refhasilrad_hasil, refhasilrad_kesan, refhasilrad_kesimpulan, refhasilrad_keterangan, refhasilrad_aktif', 'safe', 'on'=>'search'),
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
			'refhasilrad_id' => 'Refhasilrad',
			'pemeriksaanrad_id' => 'Pemeriksaanrad',
			'refhasilrad_kode' => 'Kode Referensi',
			'refhasilrad_hasil' => 'Hasil',
			'refhasilrad_kesan' => 'Kesan',
			'refhasilrad_kesimpulan' => 'Kesimpulan',
			'refhasilrad_keterangan' => 'Keterangan',
			'refhasilrad_aktif' => 'Aktif',
			'refhasilrad_banyak' => 'Banyak Pemeriksaan'
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

		$criteria->compare('refhasilrad_id',$this->refhasilrad_id);
		$criteria->compare('pemeriksaanrad_id',$this->pemeriksaanrad_id);
		$criteria->compare('LOWER(refhasilrad_kode)',strtolower($this->refhasilrad_kode),true);
		$criteria->compare('LOWER(refhasilrad_hasil)',strtolower($this->refhasilrad_hasil),true);
		$criteria->compare('LOWER(refhasilrad_kesan)',strtolower($this->refhasilrad_kesan),true);
		$criteria->compare('LOWER(refhasilrad_kesimpulan)',strtolower($this->refhasilrad_kesimpulan),true);
		$criteria->compare('LOWER(refhasilrad_keterangan)',strtolower($this->refhasilrad_keterangan),true);
		$criteria->compare('refhasilrad_aktif',$this->refhasilrad_aktif);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('refhasilrad_id',$this->refhasilrad_id);
		$criteria->compare('pemeriksaanrad_id',$this->pemeriksaanrad_id);
		$criteria->compare('LOWER(refhasilrad_kode)',strtolower($this->refhasilrad_kode),true);
		$criteria->compare('LOWER(refhasilrad_hasil)',strtolower($this->refhasilrad_hasil),true);
		$criteria->compare('LOWER(refhasilrad_kesan)',strtolower($this->refhasilrad_kesan),true);
		$criteria->compare('LOWER(refhasilrad_kesimpulan)',strtolower($this->refhasilrad_kesimpulan),true);
		$criteria->compare('LOWER(refhasilrad_keterangan)',strtolower($this->refhasilrad_keterangan),true);
		$criteria->compare('refhasilrad_aktif',$this->refhasilrad_aktif);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}