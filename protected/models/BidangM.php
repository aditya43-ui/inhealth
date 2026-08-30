<?php

/**
 * This is the model class for table "bidang_m".
 *
 * The followings are the available columns in table 'bidang_m':
 * @property integer $bidang_id
 * @property integer $golongan_id
 * @property string $bidang_kode
 * @property string $bidang_nama
 * @property string $bidang_namalainnya
 * @property boolean $bidang_aktif
 */
class BidangM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BidangM the static model class
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
		return 'bidang_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('golongan_id, bidang_kode, bidang_nama', 'required'),
			array('golongan_id', 'numerical', 'integerOnly'=>true),
			array('bidang_kode', 'length', 'max'=>50),
			array('bidang_nama, bidang_namalainnya', 'length', 'max'=>100),
			array('bidang_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('bidang_id, golongan_id, bidang_kode, bidang_nama, bidang_namalainnya, bidang_aktif', 'safe', 'on'=>'search'),
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
        	'golongan' => array(self::BELONGS_TO, 'GolonganM', 'golongan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'bidang_id' => 'ID',
			'golongan_id' => 'Golongan',
			'bidang_kode' => 'Kode Bidang',
			'bidang_nama' => 'Nama Bidang',
			'bidang_namalainnya' => 'Nama Lainnya',
			'bidang_aktif' => 'Bidang Aktif',
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

		$criteria->compare('bidang_id',$this->bidang_id);
		$criteria->compare('golongan_id',$this->golongan_id);
		$criteria->compare('LOWER(bidang_kode)',strtolower($this->bidang_kode),true);
		$criteria->compare('LOWER(bidang_nama)',strtolower($this->bidang_nama),true);
		$criteria->compare('LOWER(bidang_namalainnya)',strtolower($this->bidang_namalainnya),true);
		$criteria->compare('bidang_aktif',isset($this->bidang_aktif)?$this->bidang_aktif:true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('bidang_id',$this->bidang_id);
		$criteria->compare('golongan_id',$this->golongan_id);
		$criteria->compare('LOWER(bidang_kode)',strtolower($this->bidang_kode),true);
		$criteria->compare('LOWER(bidang_nama)',strtolower($this->bidang_nama),true);
		$criteria->compare('LOWER(bidang_namalainnya)',strtolower($this->bidang_namalainnya),true);
		//$criteria->compare('bidang_aktif',isset($this->bidang_aktif)?$this->bidang_aktif:true);
		//$criteria->compare('bidang_aktif',$this->bidang_aktif);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
         public function getSubKelompokItems()
        {
            return SubkelompokM::model()->findAll('subkelompok_aktif=true ORDER BY subkelompok_kode');
        }
         public function getKelompokItems()
        {
            return KelompokM::model()->findAll('kelompok_aktif=true ORDER BY kelompok_kode');
        }
        
         public function getGolonganItems()
        {
            return GolonganM::model()->findAll('golongan_aktif=true ORDER BY golongan_kode');
        }
        
         public function getBidangItems()
        {
            return BidangM::model()->findAll('bidang_aktif=true ORDER BY bidang_kode');
        }
        
         public function getDataBidangItems($golongan_id)
        {
            return BidangM::model()->findAllByAttributes(array('golongan_id'=>$golongan_id, 'bidang_aktif' => TRUE),array('order'=>'bidang_kode ASC'));
        }
}