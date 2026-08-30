<?php

/**
 * This is the model class for table "kelrem_m".
 *
 * The followings are the available columns in table 'kelrem_m':
 * @property integer $kelrem_id
 * @property integer $kelrem_urutan
 * @property string $kelrem_kode
 * @property string $kelrem_nama
 * @property string $kelrem_desc
 * @property string $kelrem_singkatan
 * @property integer $kelrem_rate
 * @property boolean $kelrem_aktif
 */
class KelremM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KelremM the static model class
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
		return 'kelrem_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kelrem_urutan, kelrem_kode, kelrem_nama, kelrem_desc, kelrem_singkatan, kelrem_rate', 'required'),
			array('kelrem_urutan, kelrem_rate', 'numerical', 'integerOnly'=>true),
			array('kelrem_kode', 'length', 'max'=>50),
			array('kelrem_nama', 'length', 'max'=>100),
			array('kelrem_desc', 'length', 'max'=>200),
			array('kelrem_singkatan', 'length', 'max'=>20),
			array('kelrem_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('kelrem_id, kelrem_urutan, kelrem_kode, kelrem_nama, kelrem_desc, kelrem_singkatan, kelrem_rate, kelrem_aktif', 'safe', 'on'=>'search'),
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
			'kelrem_id' => 'ID',
			'kelrem_urutan' => 'Urutan',
			'kelrem_kode' => 'Kode',
			'kelrem_nama' => 'Kelompok Remunerasi',
			'kelrem_desc' => 'Deskripsi',
			'kelrem_singkatan' => 'Singkatan',
			'kelrem_rate' => 'Rating',
			'kelrem_aktif' => 'Aktif',
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

		$criteria->compare('kelrem_id',$this->kelrem_id);
		$criteria->compare('kelrem_urutan',$this->kelrem_urutan);
		$criteria->compare('LOWER(kelrem_kode)',strtolower($this->kelrem_kode),true);
		$criteria->compare('LOWER(kelrem_nama)',strtolower($this->kelrem_nama),true);
		$criteria->compare('LOWER(kelrem_desc)',strtolower($this->kelrem_desc),true);
		$criteria->compare('LOWER(kelrem_singkatan)',strtolower($this->kelrem_singkatan),true);
		$criteria->compare('kelrem_rate',$this->kelrem_rate);
		$criteria->compare('kelrem_aktif',isset($this->kelrem_aktif)?$this->kelrem_aktif:true);
                //$criteria->addCondition('kelrem_aktif is true');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('kelrem_id',$this->kelrem_id);
		$criteria->compare('kelrem_urutan',$this->kelrem_urutan);
		$criteria->compare('LOWER(kelrem_kode)',strtolower($this->kelrem_kode),true);
		$criteria->compare('LOWER(kelrem_nama)',strtolower($this->kelrem_nama),true);
		$criteria->compare('LOWER(kelrem_desc)',strtolower($this->kelrem_desc),true);
		$criteria->compare('LOWER(kelrem_singkatan)',strtolower($this->kelrem_singkatan),true);
		$criteria->compare('kelrem_rate',$this->kelrem_rate);
		$criteria->compare('kelrem_aktif',$this->kelrem_aktif);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}