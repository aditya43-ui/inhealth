<?php

/**
 * This is the model class for table "jamkerja_m".
 *
 * The followings are the available columns in table 'jamkerja_m':
 * @property integer $jamkerja_id
 * @property integer $shift_id
 * @property string $jamkerja_nama
 * @property string $jammasuk
 * @property string $jampulang
 * @property string $jamisitrahat
 * @property string $jammasukistirahat
 * @property string $jammulaiscanmasuk
 * @property string $jamakhirscanmasuk
 * @property string $jammulaiscanplng
 * @property string $jamakhirscanplng
 * @property integer $toleransiterlambat
 * @property integer $toleransiplgcpt
 * @property boolean $jamkerja_aktif
 */
class JamkerjaM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JamkerjaM the static model class
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
		return 'jamkerja_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('shift_id, jamkerja_nama, jammasuk, jampulang, jamkerja_aktif', 'required'),
			array('shift_id, toleransiterlambat, toleransiplgcpt', 'numerical', 'integerOnly'=>true),
			array('jamkerja_nama', 'length', 'max'=>50),
			array('jamisitrahat, jammasukistirahat, jammulaiscanmasuk, jamakhirscanmasuk, jammulaiscanplng, jamakhirscanplng', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('jamkerja_id, shift_id, jamkerja_nama, jammasuk, jampulang, jamisitrahat, jammasukistirahat, jammulaiscanmasuk, jamakhirscanmasuk, jammulaiscanplng, jamakhirscanplng, toleransiterlambat, toleransiplgcpt, jamkerja_aktif', 'safe', 'on'=>'search'),
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
			'shift' => array(self::BELONGS_TO, 'ShiftM', 'shift_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'jamkerja_id' => 'Jamkerja',
			'shift_id' => 'Shift',
			'jamkerja_nama' => 'Nama Jam Kerja',
			'jammasuk' => 'Jam Masuk',
			'jampulang' => 'Jam Pulang',
			'jamisitrahat' => 'Jam Isitrahat',
			'jammasukistirahat' => 'Jam Masuk Istirahat',
			'jammulaiscanmasuk' => 'Jam Mulai Scan Masuk',
			'jamakhirscanmasuk' => 'Jam Akhir Scan Masuk',
			'jammulaiscanplng' => 'Jam Mulai Scan Pulang',
			'jamakhirscanplng' => 'Jam Akhir Scan Pulang',
			'toleransiterlambat' => 'Toleransi Terlambat',
			'toleransiplgcpt' => 'Toleransi Pulang Cepat',
			'jamkerja_aktif' => ' Aktif',
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

		$criteria->compare('jamkerja_id',$this->jamkerja_id);
		$criteria->compare('shift_id',$this->shift_id);
		$criteria->compare('LOWER(jamkerja_nama)',strtolower($this->jamkerja_nama),true);
		if((!empty($this->jammasuk))&&(strlen($this->jammasuk)>3)){
			$criteria->addCondition("jammasuk = '".$this->jammasuk."'");
		}
		if((!empty($this->jampulang))&&(strlen($this->jampulang)>3)){
			$criteria->addCondition("jampulang = '".$this->jampulang."'");
		}
		if((!empty($this->jamisitrahat))&&(strlen($this->jamisitrahat)>3)){
			$criteria->addCondition("jamisitrahat = '".$this->jamisitrahat."'");
		}
		$criteria->compare('LOWER(jammasukistirahat)',strtolower($this->jammasukistirahat),true);
		$criteria->compare('LOWER(jammulaiscanmasuk)',strtolower($this->jammulaiscanmasuk),true);
		$criteria->compare('LOWER(jamakhirscanmasuk)',strtolower($this->jamakhirscanmasuk),true);
		$criteria->compare('LOWER(jammulaiscanplng)',strtolower($this->jammulaiscanplng),true);
		$criteria->compare('LOWER(jamakhirscanplng)',strtolower($this->jamakhirscanplng),true);
		$criteria->compare('toleransiterlambat',$this->toleransiterlambat);
		$criteria->compare('toleransiplgcpt',$this->toleransiplgcpt);
		$criteria->compare('jamkerja_aktif',isset($this->jamkerja_aktif)?$this->jamkerja_aktif:true);
                //$criteria->addCondition('jamkerja_aktif is true');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('jamkerja_id',$this->jamkerja_id);
		$criteria->compare('shift_id',$this->shift_id);
		$criteria->compare('LOWER(jamkerja_nama)',strtolower($this->jamkerja_nama),true);
		$criteria->compare('LOWER(jammasuk)',strtolower($this->jammasuk),true);
		$criteria->compare('LOWER(jampulang)',strtolower($this->jampulang),true);
		$criteria->compare('LOWER(jamisitrahat)',strtolower($this->jamisitrahat),true);
		$criteria->compare('LOWER(jammasukistirahat)',strtolower($this->jammasukistirahat),true);
		$criteria->compare('LOWER(jammulaiscanmasuk)',strtolower($this->jammulaiscanmasuk),true);
		$criteria->compare('LOWER(jamakhirscanmasuk)',strtolower($this->jamakhirscanmasuk),true);
		$criteria->compare('LOWER(jammulaiscanplng)',strtolower($this->jammulaiscanplng),true);
		$criteria->compare('LOWER(jamakhirscanplng)',strtolower($this->jamakhirscanplng),true);
		$criteria->compare('toleransiterlambat',$this->toleransiterlambat);
		$criteria->compare('toleransiplgcpt',$this->toleransiplgcpt);
		$criteria->compare('jamkerja_aktif',$this->jamkerja_aktif);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}