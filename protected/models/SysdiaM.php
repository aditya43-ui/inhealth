<?php

/**
 * This is the model class for table "sysdia_m".
 *
 * The followings are the available columns in table 'sysdia_m':
 * @property integer $sysdia_id
 * @property integer $kelompokumur_id
 * @property double $systolic_min
 * @property double $systolic_max
 * @property double $diastolic_min
 * @property double $diastolic_max
 * @property string $sysdia_range
 * @property string $sysdia_nama
 * @property string $sysdia_desc
 * @property boolean $sysdia_aktif
 */
class SysdiaM extends CActiveRecord
{
        public $sys_max;
        public $dias_max;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SysdiaM the static model class
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
		return 'sysdia_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('systolic_min, systolic_max, diastolic_min, diastolic_max, sysdia_range, sysdia_nama', 'required'),
			array('kelompokumur_id', 'numerical', 'integerOnly'=>true),
			array('systolic_min, systolic_max, diastolic_min, diastolic_max', 'numerical'),
			array('sysdia_range, sysdia_nama', 'length', 'max'=>100),
			array('sysdia_desc, sysdia_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('sysdia_id, kelompokumur_id, systolic_min, systolic_max, diastolic_min, diastolic_max, sysdia_range, sysdia_nama, sysdia_desc, sysdia_aktif', 'safe', 'on'=>'search'),
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
			'kelompokumur' => array(self::BELONGS_TO, 'KelompokumurM', 'kelompokumur_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'sysdia_id' => 'Id',
			'kelompokumur_id' => 'Kelompok Umur',
			'systolic_min' => 'Systolic Min',
			'systolic_max' => 'Systolic Max',
			'diastolic_min' => 'Diastolic Min',
			'diastolic_max' => 'Diastolic Max',
			'sysdia_range' => 'Sysdia Range',
			'sysdia_nama' => 'Sysdia Nama',
			'sysdia_desc' => 'Sysdia Desc',
			'sysdia_aktif' => 'Sysdia Aktif',
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

		if(!empty($this->kelompokumur_id)){
			$criteria->addCondition('t.kelompokumur_id = '.$this->kelompokumur_id);
		}

		$criteria->compare('sysdia_id',$this->sysdia_id);
		// $criteria->compare('kelompokumur_id',$this->kelompokumur_id);
		$criteria->compare('systolic_min',$this->systolic_min);
		$criteria->compare('systolic_max',$this->systolic_max);
		$criteria->compare('diastolic_min',$this->diastolic_min);
		$criteria->compare('diastolic_max',$this->diastolic_max);
		$criteria->compare('LOWER(sysdia_range)',strtolower($this->sysdia_range),true);
		$criteria->compare('LOWER(sysdia_nama)',strtolower($this->sysdia_nama),true);
		$criteria->compare('LOWER(sysdia_desc)',strtolower($this->sysdia_desc),true);
		$criteria->compare('sysdia_aktif',isset($this->sysdia_aktif)?$this->sysdia_aktif:true);
                //$criteria->addCondition('sysdia_aktif is true');
        $criteria->with=array('kelompokumur');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('sysdia_id',$this->sysdia_id);
		$criteria->compare('kelompokumur_id',$this->kelompokumur_id);
		$criteria->compare('systolic_min',$this->systolic_min);
		$criteria->compare('systolic_max',$this->systolic_max);
		$criteria->compare('diastolic_min',$this->diastolic_min);
		$criteria->compare('diastolic_max',$this->diastolic_max);
		$criteria->compare('LOWER(sysdia_range)',strtolower($this->sysdia_range),true);
		$criteria->compare('LOWER(sysdia_nama)',strtolower($this->sysdia_nama),true);
		$criteria->compare('LOWER(sysdia_desc)',strtolower($this->sysdia_desc),true);
		$criteria->compare('sysdia_aktif',$this->sysdia_aktif);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }

        public function getKelompokUmurItems()
        {
            return KelompokumurM::model()->findAll('kelompokumur_aktif=true ORDER BY kelompokumur_nama');
        }
}