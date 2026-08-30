<?php

/**
 * This is the model class for table "uskenpangkat_r".
 *
 * The followings are the available columns in table 'uskenpangkat_r':
 * @property integer $uskenpangkat_id
 * @property integer $kenaikanpangkat_id
 * @property string $uskenpangkat_tglsk
 * @property string $uskenpangkat_nosk
 * @property integer $uskenpangkat_masakerjatahun
 * @property integer $uskenpangkat_masakerjabulan
 * @property double $uskenpangkat_gajipokok
 * @property string $uskenpangkat_pejabatygberwenang
 */
class UskenpangkatR extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UskenpangkatR the static model class
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
		return 'uskenpangkat_r';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('uskenpangkat_tglsk, uskenpangkat_nosk, uskenpangkat_masakerjatahun, uskenpangkat_masakerjabulan, uskenpangkat_pejabatygberwenang', 'required'),
			array('kenaikanpangkat_id, uskenpangkat_masakerjatahun, uskenpangkat_masakerjabulan', 'numerical', 'integerOnly'=>true),
			array('uskenpangkat_gajipokok', 'numerical'),
			array('uskenpangkat_nosk, uskenpangkat_pejabatygberwenang', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('uskenpangkat_id, kenaikanpangkat_id, uskenpangkat_tglsk, uskenpangkat_nosk, uskenpangkat_masakerjatahun, uskenpangkat_masakerjabulan, uskenpangkat_gajipokok, uskenpangkat_pejabatygberwenang', 'safe', 'on'=>'search'),
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
			'uskenpangkat_id' => 'Uskenpangkat',
			'kenaikanpangkat_id' => 'Kenaikanpangkat',
			'uskenpangkat_tglsk' => 'Uskenpangkat Tglsk',
			'uskenpangkat_nosk' => 'Uskenpangkat Nosk',
			'uskenpangkat_masakerjatahun' => 'Uskenpangkat Masakerjatahun',
			'uskenpangkat_masakerjabulan' => 'Uskenpangkat Masakerjabulan',
			'uskenpangkat_gajipokok' => 'Uskenpangkat Gajipokok',
			'uskenpangkat_pejabatygberwenang' => 'Uskenpangkat Pejabatygberwenang',
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

		$criteria->compare('uskenpangkat_id',$this->uskenpangkat_id);
		$criteria->compare('kenaikanpangkat_id',$this->kenaikanpangkat_id);
		$criteria->compare('LOWER(uskenpangkat_tglsk)',strtolower($this->uskenpangkat_tglsk),true);
		$criteria->compare('LOWER(uskenpangkat_nosk)',strtolower($this->uskenpangkat_nosk),true);
		$criteria->compare('uskenpangkat_masakerjatahun',$this->uskenpangkat_masakerjatahun);
		$criteria->compare('uskenpangkat_masakerjabulan',$this->uskenpangkat_masakerjabulan);
		$criteria->compare('uskenpangkat_gajipokok',$this->uskenpangkat_gajipokok);
		$criteria->compare('LOWER(uskenpangkat_pejabatygberwenang)',strtolower($this->uskenpangkat_pejabatygberwenang),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('uskenpangkat_id',$this->uskenpangkat_id);
		$criteria->compare('kenaikanpangkat_id',$this->kenaikanpangkat_id);
		$criteria->compare('LOWER(uskenpangkat_tglsk)',strtolower($this->uskenpangkat_tglsk),true);
		$criteria->compare('LOWER(uskenpangkat_nosk)',strtolower($this->uskenpangkat_nosk),true);
		$criteria->compare('uskenpangkat_masakerjatahun',$this->uskenpangkat_masakerjatahun);
		$criteria->compare('uskenpangkat_masakerjabulan',$this->uskenpangkat_masakerjabulan);
		$criteria->compare('uskenpangkat_gajipokok',$this->uskenpangkat_gajipokok);
		$criteria->compare('LOWER(uskenpangkat_pejabatygberwenang)',strtolower($this->uskenpangkat_pejabatygberwenang),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}