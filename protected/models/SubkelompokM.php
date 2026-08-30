<?php

/**
 * This is the model class for table "subkelompok_m".
 *
 * The followings are the available columns in table 'subkelompok_m':
 * @property integer $subkelompok_id
 * @property integer $kelompok_id
 * @property string $subkelompok_kode
 * @property string $subkelompok_nama
 * @property string $subkelompok_namalainnya
 * @property boolean $subkelompok_aktif
 */
class SubkelompokM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SubkelompokM the static model class
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
		return 'subkelompok_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kelompok_id, subkelompok_kode, subkelompok_nama', 'required'),
			array('kelompok_id', 'numerical', 'integerOnly'=>true),
			array('subkelompok_kode', 'length', 'max'=>50),
			array('subkelompok_nama, subkelompok_namalainnya', 'length', 'max'=>100),
			array('subkelompok_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('subkelompok_id, kelompok_id, subkelompok_kode, subkelompok_nama, subkelompok_namalainnya, subkelompok_aktif', 'safe', 'on'=>'search'),
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
                    'kelompok' => array(self::BELONGS_TO, 'KelompokM', 'kelompok_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'subkelompok_id' => 'ID',
			'kelompok_id' => 'Kelompok',
			'subkelompok_kode' => 'Kode Sub Kelompok',
			'subkelompok_nama' => 'Nama Sub Kelompok',
			'subkelompok_namalainnya' => 'Nama Lainnya',
			'subkelompok_aktif' => 'Aktif',
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

		$criteria->compare('subkelompok_id',$this->subkelompok_id);
		$criteria->compare('kelompok_id',$this->kelompok_id);
		$criteria->compare('LOWER(subkelompok_kode)',strtolower($this->subkelompok_kode),true);
		$criteria->compare('LOWER(subkelompok_nama)',strtolower($this->subkelompok_nama),true);
		$criteria->compare('LOWER(subkelompok_namalainnya)',strtolower($this->subkelompok_namalainnya),true);
		$criteria->compare('subkelompok_aktif',isset($this->subkelompok_aktif)?$this->subkelompok_aktif:true);
//                $criteria->addCondition('subkelompok_aktif is true');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('subkelompok_id',$this->subkelompok_id);
		$criteria->compare('kelompok_id',$this->kelompok_id);
		$criteria->compare('LOWER(subkelompok_kode)',strtolower($this->subkelompok_kode),true);
		$criteria->compare('LOWER(subkelompok_nama)',strtolower($this->subkelompok_nama),true);
		$criteria->compare('LOWER(subkelompok_namalainnya)',strtolower($this->subkelompok_namalainnya),true);
		$criteria->compare('subkelompok_aktif',isset($this->subkelompok_aktif)?$this->subkelompok_aktif:true);
        //$criteria->compare('subkelompok_aktif',$this->subkelompok_aktif);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        public function getGolonganItems()
        {
            return GolonganM::model()->findAll('golongan_aktif=true ORDER BY golongan_kode');
        }
        public function getBidangItems()
        {
            return BidangM::model()->findAll('bidang_aktif=true ORDER BY bidang_kode');
        }
        public function getKelompokItems()
        {
            return KelompokM::model()->findAll('kelompok_aktif=true ORDER BY kelompok_kode');
        }
        public function getSubKelompokItems()
        {
            return SubkelompokM::model()->findAll('subkelompok_aktif=true ORDER BY subkelompok_kode');
        }
        
        public function getDataSubKelompokItems($kelompok_id)
        {
            return $this->findAllByAttributes(array('kelompok_id'=>$kelompok_id, 'subkelompok_aktif' => TRUE),array('order'=>'subkelompok_kode ASC'));
        }
}