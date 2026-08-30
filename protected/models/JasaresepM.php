<?php

/**
 * This is the model class for table "jasaresep_m".
 *
 * The followings are the available columns in table 'jasaresep_m':
 * @property integer $jasaresep_id
 * @property double $minharga
 * @property double $maxharga
 * @property double $persenjasa
 * @property boolean $isspesialis
 * @property boolean $jasaresep_aktif
 */
class JasaresepM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JasaresepM the static model class
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
		return 'jasaresep_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('minharga, maxharga, persenjasa', 'required'),
			array('minharga, maxharga, persenjasa', 'numerical'),
			array('isspesialis, jasaresep_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('jasaresep_id, minharga, maxharga, persenjasa, isspesialis, jasaresep_aktif', 'safe', 'on'=>'search'),
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
			'jasaresep_id' => 'Jasaresep',
			'minharga' => 'Minharga',
			'maxharga' => 'Maxharga',
			'persenjasa' => 'Persenjasa',
			'isspesialis' => 'Isspesialis',
			'jasaresep_aktif' => 'Jasaresep Aktif',
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

		$criteria->compare('jasaresep_id',$this->jasaresep_id);
		$criteria->compare('minharga',$this->minharga);
		$criteria->compare('maxharga',$this->maxharga);
		$criteria->compare('persenjasa',$this->persenjasa);
		$criteria->compare('isspesialis',$this->isspesialis);
		$criteria->compare('jasaresep_aktif',$this->jasaresep_aktif);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('jasaresep_id',$this->jasaresep_id);
		$criteria->compare('minharga',$this->minharga);
		$criteria->compare('maxharga',$this->maxharga);
		$criteria->compare('persenjasa',$this->persenjasa);
		$criteria->compare('isspesialis',$this->isspesialis);
		$criteria->compare('jasaresep_aktif',$this->jasaresep_aktif);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}