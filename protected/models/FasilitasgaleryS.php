<?php

/**
 * This is the model class for table "fasilitasgalery_s".
 *
 * The followings are the available columns in table 'fasilitasgalery_s':
 * @property integer $fasilitasgalery_id
 * @property integer $fasilitas_id
 * @property string $galeryimage
 * @property string $galery_thumbs
 */
class FasilitasgaleryS extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return FasilitasgaleryS the static model class
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
		return 'fasilitasgalery_s';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('fasilitas_id, galeryimage', 'required'),
			array('fasilitas_id', 'numerical', 'integerOnly'=>true),
			array('galery_thumbs', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('fasilitasgalery_id, fasilitas_id, galeryimage, galery_thumbs', 'safe', 'on'=>'search'),
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
			'fasilitas' => array(self::BELONGS_TO, 'FasilitasS', 'fasilitas_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'fasilitasgalery_id' => 'Fasilitasgalery',
			'fasilitas_id' => 'Fasilitas',
			'galeryimage' => 'Galeryimage',
			'galery_thumbs' => 'Galery Thumbs',
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

		$criteria->compare('fasilitasgalery_id',$this->fasilitasgalery_id);
		$criteria->compare('fasilitas_id',$this->fasilitas_id);
		$criteria->compare('LOWER(galeryimage)',strtolower($this->galeryimage),true);
		$criteria->compare('LOWER(galery_thumbs)',strtolower($this->galery_thumbs),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('fasilitasgalery_id',$this->fasilitasgalery_id);
		$criteria->compare('fasilitas_id',$this->fasilitas_id);
		$criteria->compare('LOWER(galeryimage)',strtolower($this->galeryimage),true);
		$criteria->compare('LOWER(galery_thumbs)',strtolower($this->galery_thumbs),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}