<?php

/**
 * This is the model class for table "golonganumur_m".
 *
 * The followings are the available columns in table 'golonganumur_m':
 * @property integer $golonganumur_id
 * @property string $golonganumur_nama
 * @property string $golonganumur_namalainnya
 * @property string $golonganumur_minimal
 * @property string $golonganumur_maksimal
 * @property boolean $golonganumur_aktif
 */
class GolonganumurM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return GolonganumurM the static model class
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
		return 'golonganumur_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('golonganumur_nama, golonganumur_namalainnya', 'required'),
			array('golonganumur_nama, golonganumur_namalainnya', 'length', 'max'=>25),
			array('golonganumur_minimal, golonganumur_maksimal', 'numerical'),
			array('golonganumur_minimal, golonganumur_maksimal, golonganumur_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('golonganumur_id, golonganumur_nama, golonganumur_namalainnya, golonganumur_minimal, golonganumur_maksimal, golonganumur_aktif', 'safe', 'on'=>'search'),
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
			'golonganumur_id' => 'ID',
			'golonganumur_nama' => 'Jenis Golongan Umur ',
			'golonganumur_namalainnya' => 'Usia',
			'golonganumur_minimal' => 'Umur Minimal',
			'golonganumur_maksimal' => 'Umur Maksimal',
			'golonganumur_aktif' => 'Aktif',
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

		$criteria->compare('golonganumur_id',$this->golonganumur_id);
		$criteria->compare('LOWER(golonganumur_nama)',strtolower($this->golonganumur_nama),true);
		$criteria->compare('LOWER(golonganumur_namalainnya)',strtolower($this->golonganumur_namalainnya),true);
		$criteria->compare('golonganumur_minimal',$this->golonganumur_minimal);
		$criteria->compare('golonganumur_maksimal',$this->golonganumur_maksimal);
		$criteria->compare('golonganumur_aktif',isset($this->golonganumur_aktif)?$this->golonganumur_aktif:true);
//                $criteria->addCondition('golonganumur_aktif is true');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('golonganumur_id',$this->golonganumur_id);
		$criteria->compare('LOWER(golonganumur_nama)',strtolower($this->golonganumur_nama),true);
		$criteria->compare('LOWER(golonganumur_namalainnya)',strtolower($this->golonganumur_namalainnya),true);
		$criteria->compare('golonganumur_minimal',$this->golonganumur_minimal);
		$criteria->compare('golonganumur_maksimal',$this->golonganumur_maksimal);
//		$criteria->compare('golonganumur_aktif',$this->golonganumur_aktif);
                $criteria->limit = -1;
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>false,                    
		));
	}
        
        public function beforeSave() {
            $this->golonganumur_nama = ucwords(strtolower($this->golonganumur_nama));
             if($this->golonganumur_minimal===null || trim($this->golonganumur_minimal)=='')
            {
                $this->setAttribute('golonganumur_minimal', null);
            } 
             if($this->golonganumur_maksimal===null || trim($this->golonganumur_maksimal)=='')
            {
                $this->setAttribute('golonganumur_maksimal', null);
            } 
            return parent::beforeSave();
        }
}