<?php

/**
 * This is the model class for table "labklinikrujukan_m".
 *
 * The followings are the available columns in table 'labklinikrujukan_m':
 * @property integer $labklinikrujukan_id
 * @property string $labklinikrujukan_nama
 * @property string $labklinikrujukan_alamat
 * @property string $labklinikrujukan_telp
 * @property string $labklinikrujukan_mobile
 * @property string $labklinikrujukan_dokterpj
 * @property boolean $labklinikrujukan_aktif
 */
class LabklinikrujukanM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LabklinikrujukanM the static model class
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
		return 'labklinikrujukan_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('labklinikrujukan_nama, labklinikrujukan_alamat', 'required'),
			array('labklinikrujukan_nama, labklinikrujukan_mobile, labklinikrujukan_dokterpj', 'length', 'max'=>30),
			array('labklinikrujukan_telp', 'length', 'max'=>20),
			array('labklinikrujukan_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('labklinikrujukan_id, labklinikrujukan_nama, labklinikrujukan_alamat, labklinikrujukan_telp, labklinikrujukan_mobile, labklinikrujukan_dokterpj, labklinikrujukan_aktif', 'safe', 'on'=>'search'),
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
			'labklinikrujukan_id' => 'Lab Klinik Rujukan',
			'labklinikrujukan_nama' => 'Nama Lab Rujukan',
			'labklinikrujukan_alamat' => 'Alamat Lab Rujukan',
			'labklinikrujukan_telp' => 'Telp Lab Rujukan',
			'labklinikrujukan_mobile' => 'Mobile Lab Rujukan',
			'labklinikrujukan_dokterpj' => 'Dokter Lab Rujukan',
			'labklinikrujukan_aktif' => 'Aktif',
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

		$criteria->compare('labklinikrujukan_id',$this->labklinikrujukan_id);
		$criteria->compare('LOWER(labklinikrujukan_nama)',strtolower($this->labklinikrujukan_nama),true);
		$criteria->compare('LOWER(labklinikrujukan_alamat)',strtolower($this->labklinikrujukan_alamat),true);
		$criteria->compare('LOWER(labklinikrujukan_telp)',strtolower($this->labklinikrujukan_telp),true);
		$criteria->compare('LOWER(labklinikrujukan_mobile)',strtolower($this->labklinikrujukan_mobile),true);
		$criteria->compare('LOWER(labklinikrujukan_dokterpj)',strtolower($this->labklinikrujukan_dokterpj),true);
		$criteria->compare('labklinikrujukan_aktif',$this->labklinikrujukan_aktif);
                $criteria->addCondition('labklinikrujukan_aktif is true');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('labklinikrujukan_id',$this->labklinikrujukan_id);
		$criteria->compare('LOWER(labklinikrujukan_nama)',strtolower($this->labklinikrujukan_nama),true);
		$criteria->compare('LOWER(labklinikrujukan_alamat)',strtolower($this->labklinikrujukan_alamat),true);
		$criteria->compare('LOWER(labklinikrujukan_telp)',strtolower($this->labklinikrujukan_telp),true);
		$criteria->compare('LOWER(labklinikrujukan_mobile)',strtolower($this->labklinikrujukan_mobile),true);
		$criteria->compare('LOWER(labklinikrujukan_dokterpj)',strtolower($this->labklinikrujukan_dokterpj),true);
		$criteria->compare('labklinikrujukan_aktif',$this->labklinikrujukan_aktif);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
        public function beforeSave() 
        {
            $this->labklinikrujukan_nama = ucwords(strtolower($this->labklinikrujukan_nama));
            $this->labklinikrujukan_namalainnya = strtoupper($this->labklinikrujukan_namalainnya);
            return parent::beforeSave();
        }
        
        public static function getDropDataAktif(){
            $cri = new CDbCriteria();
            $cri->addCondition("labklinikrujukan_aktif = TRUE");
            $cri->order = "labklinikrujukan_nama ASC";
            
            return CHtml::listData(self::model()->findAll($cri), 'labklinikrujukan_id', 'labklinikrujukan_nama');
        }
}