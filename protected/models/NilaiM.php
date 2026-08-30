<?php

/**
 * This is the model class for table "nilai_m".
 *
 * The followings are the available columns in table 'nilai_m':
 * @property integer $nilai_id
 * @property integer $nilai_angkamin
 * @property integer $nilai_angkamaks
 * @property string $nilai_sebutan
 * @property boolean $nilai_aktif
 */
class NilaiM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return NilaiM the static model class
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
		return 'nilai_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nilai_aktif', 'required'),
			array('nilai_angkamin, nilai_angkamaks', 'numerical', 'integerOnly'=>true),
			array('nilai_sebutan', 'length', 'max'=>15),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('nilai_id, nilai_angkamin, nilai_angkamaks, nilai_sebutan, nilai_aktif', 'safe', 'on'=>'search'),
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
			'nilai_id' => 'Nilai',
			'nilai_angkamin' => 'Nilai Min',
			'nilai_angkamaks' => 'Nilai Maks',
			'nilai_sebutan' => 'Sebutan',
			'nilai_aktif' => 'Aktif',
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

		$criteria->compare('nilai_id',$this->nilai_id);
		$criteria->compare('nilai_angkamin',$this->nilai_angkamin);
		$criteria->compare('nilai_angkamaks',$this->nilai_angkamaks);
		$criteria->compare('LOWER(nilai_sebutan)',strtolower($this->nilai_sebutan),true);
		$criteria->compare('nilai_aktif',isset($this->nilai_aktif)?$this->nilai_aktif:true);
                //$criteria->addCondition('nilai_aktif is true');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('nilai_id',$this->nilai_id);
		$criteria->compare('nilai_angkamin',$this->nilai_angkamin);
		$criteria->compare('nilai_angkamaks',$this->nilai_angkamaks);
		$criteria->compare('LOWER(nilai_sebutan)',strtolower($this->nilai_sebutan),true);
		$criteria->compare('nilai_aktif',$this->nilai_aktif);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}