<?php

/**
 * This is the model class for table "kelompok_m".
 *
 * The followings are the available columns in table 'kelompok_m':
 * @property integer $kelompok_id
 * @property integer $bidang_id
 * @property string $kelompok_kode
 * @property string $kelompok_nama
 * @property string $kelompok_namalainnya
 * @property boolean $kelompok_aktif
 */
class KelompokM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KelompokM the static model class
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
		return 'kelompok_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('bidang_id, kelompok_kode, kelompok_nama', 'required'),
			array('bidang_id', 'numerical', 'integerOnly'=>true),
			array('kelompok_kode', 'length', 'max'=>50),
			array('kelompok_nama, kelompok_namalainnya', 'length', 'max'=>100),
			array('kelompok_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('kelompok_id, bidang_id, kelompok_kode, kelompok_nama, kelompok_namalainnya, kelompok_aktif', 'safe', 'on'=>'search'),
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
                    'bidang' => array(self::BELONGS_TO, 'BidangM', 'bidang_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'kelompok_id' => 'ID',
			'bidang_id' => 'Bidang',
			'kelompok_kode' => 'Kode Kelompok',
			'kelompok_nama' => 'Nama Kelompok',
			'kelompok_namalainnya' => 'Nama Lainnya',
			'kelompok_aktif' => 'Aktif',
                        'golongan_id' => 'Golongan',
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

		$criteria->compare('kelompok_id',$this->kelompok_id);
		$criteria->compare('bidang_id',$this->bidang_id);
		$criteria->compare('LOWER(kelompok_kode)',strtolower($this->kelompok_kode),true);
		$criteria->compare('LOWER(kelompok_nama)',strtolower($this->kelompok_nama),true);
		$criteria->compare('LOWER(kelompok_namalainnya)',strtolower($this->kelompok_namalainnya),true);
		$criteria->compare('kelompok_aktif',isset($this->kelompok_aktif)?$this->kelompok_aktif:true);
//                $criteria->addCondition('kelompok_aktif is true');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('kelompok_id',$this->kelompok_id);
		$criteria->compare('bidang_id',$this->bidang_id);
		$criteria->compare('LOWER(kelompok_kode)',strtolower($this->kelompok_kode),true);
		$criteria->compare('LOWER(kelompok_nama)',strtolower($this->kelompok_nama),true);
		$criteria->compare('LOWER(kelompok_namalainnya)',strtolower($this->kelompok_namalainnya),true);
		$criteria->compare('kelompok_aktif',isset($this->kelompok_aktif)?$this->kelompok_aktif:true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        public function getBidangItems()
        {
            return BidangM::model()->findAll('bidang_aktif=true ORDER BY bidang_kode');
        }
        
        public function getDataKelompokItems($bidang_id)
        {
            return $this->findAllByAttributes(array('bidang_id'=>$bidang_id, 'kelompok_aktif' => TRUE),array('order'=>'kelompok_kode ASC'));
        }
        
        public function getGolonganItems()
        {
            return GolonganM::model()->findAll('golongan_aktif=true ORDER BY golongan_kode');
        }
        public function getKelompokItems()
        {
            return KelompokM::model()->findAll('kelompok_aktif=true ORDER BY kelompok_kode');
        }
        public function getSubKelompokItems()
        {
            return SubkelompokM::model()->findAll('subkelompok_aktif=true ORDER BY subkelompok_kode');
        }
}