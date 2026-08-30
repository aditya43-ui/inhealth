<?php

/**
 * This is the model class for table "subsubkelompok_m".
 *
 * The followings are the available columns in table 'subsubkelompok_m':
 * @property integer $subsubkelompok_id
 * @property integer $subkelompok_id
 * @property string $subsubkelompok_kode
 * @property string $subsubkelompok_nama
 * @property string $subsubkelompok_namalainnya
 * @property boolean $subsubkelompok_aktif
 *
 * The followings are the available model relations:
 * @property SubkelompokM $subkelompok
 */
class SubsubkelompokM extends CActiveRecord
{  
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SubsubkelompokM the static model class
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
		return 'subsubkelompok_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('subkelompok_id, subsubkelompok_kode, subsubkelompok_nama', 'required'),
			array('subkelompok_id', 'numerical', 'integerOnly'=>true),
			array('subsubkelompok_kode', 'length', 'max'=>50),
			array('subsubkelompok_nama, subsubkelompok_namalainnya', 'length', 'max'=>100),
			array('subsubkelompok_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('subsubkelompok_id, subkelompok_id, subsubkelompok_kode, subsubkelompok_nama, subsubkelompok_namalainnya, subsubkelompok_aktif', 'safe', 'on'=>'search'),
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
			'subkelompok' => array(self::BELONGS_TO, 'SubkelompokM', 'subkelompok_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'subsubkelompok_id' => 'ID',
			'subkelompok_id' => 'Sub Kelompok',
			'subsubkelompok_kode' => 'Sub Sub Kelompok Kode',
			'subsubkelompok_nama' => 'Sub Sub Kelompok Nama',
			'subsubkelompok_namalainnya' => 'Sub Sub Kelompok Nama Lain',
			'subsubkelompok_aktif' => 'Sub Sub Kelompok Aktif',
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

		$criteria->compare('subsubkelompok_id',$this->subsubkelompok_id);
		$criteria->compare('subkelompok_id',$this->subkelompok_id);
		$criteria->compare('LOWER(subsubkelompok_kode)',  strtolower($this->subsubkelompok_kode),true);
		$criteria->compare('LOWER(subsubkelompok_nama)',  strtolower($this->subsubkelompok_nama),true);
		$criteria->compare('LOWER(subsubkelompok_namalainnya)',  strtolower($this->subsubkelompok_namalainnya),true);
		$criteria->compare('subsubkelompok_aktif',isset($this->subsubkelompok_aktif)?$this->subsubkelompok_aktif:true);
                
               // $criteria->limit = -1;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                       // 'pagination' => false,
		));
	}
        
        public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('subsubkelompok_id',$this->subsubkelompok_id);
		$criteria->compare('subkelompok_id',$this->subkelompok_id);
		$criteria->compare('LOWER(subsubkelompok_kode)',  strtolower($this->subsubkelompok_kode),true);
		$criteria->compare('LOWER(subsubkelompok_nama)',  strtolower($this->subsubkelompok_nama),true);
		$criteria->compare('LOWER(subsubkelompok_namalainnya)',  strtolower($this->subsubkelompok_namalainnya),true);
		$criteria->compare('subsubkelompok_aktif',isset($this->subsubkelompok_aktif)?$this->subsubkelompok_aktif:true);
                $criteria->limit = -1;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination' => false,
		));
	}
        
        public function getGolonganItems()
        {
            return GolonganM::model()->findAll('golongan_aktif=true ORDER BY golongan_kode ASC');
        }
        
        public function getBidangItems()
        {
            return BidangM::model()->findAll('bidang_aktif=true ORDER BY bidang_kode');
        }
        
        public function getKelompokItems()
        {
            return KelompokM::model()->findAll('kelompok_aktif=true ORDER BY kelompok_kode ASC');
        }
        public function getSubKelompokItems()
        {
            return SubkelompokM::model()->findAll('subkelompok_aktif=true ORDER BY subkelompok_kode ASC');
        }
        
        public function getSubSubKelompokItems()
        {
            return SubsubkelompokM::model()->findAll('subsubkelompok_aktif=true ORDER BY subsubkelompok_kode ASC');
        }
        
       public function getDataSubSubKelompokItems($subkelompok_id)
        {
            return $this->findAllByAttributes(array('subkelompok_id'=>$subkelompok_id, 'subsubkelompok_aktif' => TRUE),array('order'=>'subsubkelompok_kode ASC'));
        }
        
         public function getDataKodeSSKItems($subsubkelompok_id)
        {
            return $this->findAllByAttributes(array('subsubkelompok_id'=>$subsubkelompok_id, 'subsubkelompok_aktif' => TRUE),array('order'=>'subsubkelompok_kode ASC'));
        }
}