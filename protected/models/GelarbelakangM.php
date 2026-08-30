<?php

/**
 * This is the model class for table "gelarbelakang_m".
 *
 * The followings are the available columns in table 'gelarbelakang_m':
 * @property integer $gelarbelakang_id
 * @property string $gelarbelakang_nama
 * @property string $gelarbelakang_namalainnya
 * @property boolean $gelarbelakang_aktif
 */
class GelarbelakangM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return GelarbelakangM the static model class
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
		return 'gelarbelakang_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('gelarbelakang_nama', 'required'),
			array('gelarbelakang_nama, gelarbelakang_namalainnya', 'length', 'max'=>15),
			array('gelarbelakang_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('gelarbelakang_id, gelarbelakang_nama, gelarbelakang_namalainnya, gelarbelakang_aktif', 'safe', 'on'=>'search'),
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
			'gelarbelakang_id' => 'ID',
			'gelarbelakang_nama' => 'Gelar',
			'gelarbelakang_namalainnya' => 'Nama Lain',
			'gelarbelakang_aktif' => 'Aktif',
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

		$criteria->compare('gelarbelakang_id',$this->gelarbelakang_id);
		$criteria->compare('LOWER(gelarbelakang_nama)',strtolower($this->gelarbelakang_nama),true);
		$criteria->compare('LOWER(gelarbelakang_namalainnya)',strtolower($this->gelarbelakang_namalainnya),true);
		$criteria->compare('gelarbelakang_aktif',isset($this->gelarbelakang_aktif)?$this->gelarbelakang_aktif:true);
//                $criteria->addCondition('gelarbelakang_aktif is true');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('gelarbelakang_id',$this->gelarbelakang_id);
		$criteria->compare('LOWER(gelarbelakang_nama)',strtolower($this->gelarbelakang_nama),true);
		$criteria->compare('LOWER(gelarbelakang_namalainnya)',strtolower($this->gelarbelakang_namalainnya),true);
//		$criteria->compare('gelarbelakang_aktif',$this->gelarbelakang_aktif);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                    
                ));
        }
}