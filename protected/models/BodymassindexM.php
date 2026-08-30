<?php

/**
 * This is the model class for table "bodymassindex_m".
 *
 * The followings are the available columns in table 'bodymassindex_m':
 * @property integer $bodymassindex_id
 * @property string $bmi_range
 * @property double $bmi_minimum
 * @property double $bmi_maksimum
 * @property string $bmi_sign
 * @property string $bmi_defenisi
 * @property string $bmi_pesan
 * @property boolean $bodymassindex_aktif
 */
class BodymassindexM extends CActiveRecord
{
        public $max_bmi;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BodymassindexM the static model class
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
		return 'bodymassindex_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('bmi_range, bmi_minimum, bmi_maksimum, bmi_defenisi', 'required'),
			array('bmi_minimum, bmi_maksimum', 'numerical'),
			array('bmi_range', 'length', 'max'=>50),
			array('bmi_sign', 'length', 'max'=>2),
			array('bmi_pesan', 'length', 'max'=>100),
			array('bodymassindex_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('bodymassindex_id, bmi_range, bmi_minimum, bmi_maksimum, bmi_sign, bmi_defenisi, bmi_pesan, bodymassindex_aktif', 'safe', 'on'=>'search'),
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
			'bodymassindex_id' => 'Id',
			'bmi_range' => 'Range BMI',
			'bmi_minimum' => 'Minimum BMI',
			'bmi_maksimum' => 'Maksimum BMI',
			'bmi_sign' => 'Tanda BMI',
			'bmi_defenisi' => 'Defenisi BMI',
			'bmi_pesan' => 'Pesan BMI',
			'bodymassindex_aktif' => 'Aktif',
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

		$criteria->compare('bodymassindex_id',$this->bodymassindex_id);
		$criteria->compare('LOWER(bmi_range)',strtolower($this->bmi_range),true);
		$criteria->compare('bmi_minimum',$this->bmi_minimum);
		$criteria->compare('bmi_maksimum',$this->bmi_maksimum);
		$criteria->compare('LOWER(bmi_sign)',strtolower($this->bmi_sign),true);
		$criteria->compare('LOWER(bmi_defenisi)',strtolower($this->bmi_defenisi),true);
		$criteria->compare('LOWER(bmi_pesan)',strtolower($this->bmi_pesan),true);
		$criteria->compare('bodymassindex_aktif',isset($this->bodymassindex_aktif)?$this->bodymassindex_aktif:true);
                //$criteria->addCondition('bodymassindex_aktif is true');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('bodymassindex_id',$this->bodymassindex_id);
		$criteria->compare('LOWER(bmi_range)',strtolower($this->bmi_range),true);
		$criteria->compare('bmi_minimum',$this->bmi_minimum);
		$criteria->compare('bmi_maksimum',$this->bmi_maksimum);
		$criteria->compare('LOWER(bmi_sign)',strtolower($this->bmi_sign),true);
		$criteria->compare('LOWER(bmi_defenisi)',strtolower($this->bmi_defenisi),true);
		$criteria->compare('LOWER(bmi_pesan)',strtolower($this->bmi_pesan),true);
		$criteria->compare('bodymassindex_aktif',$this->bodymassindex_aktif);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}