<?php

/**
 * This is the model class for table "keluhananamnesis_m".
 *
 * The followings are the available columns in table 'keluhananamnesis_m':
 * @property integer $keluhananamnesis_id
 * @property string $keluhananamnesis_nama
 */
class KeluhananamnesisM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KeluhananamnesisM the static model class
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
		return 'keluhananamnesis_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('keluhananamnesis_nama', 'required'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('keluhananamnesis_id, keluhananamnesis_nama', 'safe', 'on'=>'search'),
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
			'keluhananamnesis_id' => 'Id',
			'keluhananamnesis_nama' => 'Nama Keluhan Anamnesis',
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

		$criteria->compare('keluhananamnesis_id',$this->keluhananamnesis_id);
		$criteria->compare('LOWER(keluhananamnesis_nama)',strtolower($this->keluhananamnesis_nama),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('keluhananamnesis_id',$this->keluhananamnesis_id);
		$criteria->compare('LOWER(keluhananamnesis_nama)',strtolower($this->keluhananamnesis_nama),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}