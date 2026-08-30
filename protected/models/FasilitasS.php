<?php

/**
 * This is the model class for table "fasilitas_s".
 *
 * The followings are the available columns in table 'fasilitas_s':
 * @property integer $fasilitas_id
 * @property string $jenisfasilitas
 * @property string $namafasilitas
 * @property string $descfasilitas
 * @property boolean $fasilitasaktif
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class FasilitasS extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return FasilitasS the static model class
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
		return 'fasilitas_s';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jenisfasilitas, namafasilitas, descfasilitas, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('jenisfasilitas', 'length', 'max'=>50),
			array('namafasilitas', 'length', 'max'=>200),
			array('fasilitasaktif, update_time, update_loginpemakai_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('fasilitas_id, jenisfasilitas, namafasilitas, descfasilitas, fasilitasaktif, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'fasilitas_id' => 'Fasilitas',
			'jenisfasilitas' => 'Jenisfasilitas',
			'namafasilitas' => 'Namafasilitas',
			'descfasilitas' => 'Descfasilitas',
			'fasilitasaktif' => 'Fasilitasaktif',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
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

		$criteria->compare('fasilitas_id',$this->fasilitas_id);
		$criteria->compare('LOWER(jenisfasilitas)',strtolower($this->jenisfasilitas),true);
		$criteria->compare('LOWER(namafasilitas)',strtolower($this->namafasilitas),true);
		$criteria->compare('LOWER(descfasilitas)',strtolower($this->descfasilitas),true);
		$criteria->compare('fasilitasaktif',$this->fasilitasaktif);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('fasilitas_id',$this->fasilitas_id);
		$criteria->compare('LOWER(jenisfasilitas)',strtolower($this->jenisfasilitas),true);
		$criteria->compare('LOWER(namafasilitas)',strtolower($this->namafasilitas),true);
		$criteria->compare('LOWER(descfasilitas)',strtolower($this->descfasilitas),true);
		$criteria->compare('fasilitasaktif',$this->fasilitasaktif);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}