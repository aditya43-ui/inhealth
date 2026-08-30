<?php

/**
 * This is the model class for table "alatfinger_m".
 *
 * The followings are the available columns in table 'alatfinger_m':
 * @property integer $alatfinger_id
 * @property string $namaalat
 * @property string $ipfinger
 * @property string $keyfinger
 * @property string $lokasifinger
 * @property string $keterangan
 * @property boolean $alat_aktif
 */
class AlatfingerM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AlatfingerM the static model class
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
		return 'alatfinger_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ipfinger, keyfinger', 'required'),
			array('namaalat, ipfinger', 'length', 'max'=>100),
			array('keyfinger', 'length', 'max'=>50),
			array('lokasifinger, keterangan, alat_aktif', 'safe'),
                        array('is_fingerprint, is_facerecognition', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('alatfinger_id, namaalat, ipfinger, keyfinger, lokasifinger, keterangan, alat_aktif', 'safe', 'on'=>'search'),
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
			'alatfinger_id' => 'Alat Finger ID',
			'namaalat' => 'Nama Alat',
			'ipfinger' => 'IP Alat',
			'keyfinger' => 'Key Alat',
			'lokasifinger' => 'Lokasi Alat',
			'keterangan' => 'Keterangan',
                        'is_fingerprint' => 'Alat Finger Print',
                        'is_facerecognition' => 'Alat Face Recognition',
			'alat_aktif' => 'Aktif'
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
		$criteria->compare('alatfinger_id',$this->alatfinger_id);
		$criteria->compare('LOWER(namaalat)',strtolower($this->namaalat),true);
		$criteria->compare('LOWER(ipfinger)',strtolower($this->ipfinger),true);
		$criteria->compare('LOWER(keyfinger)',strtolower($this->keyfinger),true);
		$criteria->compare('LOWER(lokasifinger)',strtolower($this->lokasifinger),true);
		$criteria->compare('LOWER(keterangan)',strtolower($this->keterangan),true);
        $criteria->compare('alat_aktif',isset($this->alat_aktif)?$this->alat_aktif:true);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('alatfinger_id',$this->alatfinger_id);
		$criteria->compare('LOWER(namaalat)',strtolower($this->namaalat),true);
		$criteria->compare('LOWER(ipfinger)',strtolower($this->ipfinger),true);
		$criteria->compare('LOWER(keyfinger)',strtolower($this->keyfinger),true);
		$criteria->compare('LOWER(lokasifinger)',strtolower($this->lokasifinger),true);
		$criteria->compare('LOWER(keterangan)',strtolower($this->keterangan),true);
                $criteria->compare('alat_aktif',$this->alat_aktif);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1;
                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}