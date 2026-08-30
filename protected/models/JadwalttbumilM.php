<?php

/**
 * This is the model class for table "jadwalttbumil_m".
 *
 * The followings are the available columns in table 'jadwalttbumil_m':
 * @property integer $jadwalttbumil_id
 * @property integer $diagnosa_id
 * @property string $jadwalttbumil_kode
 * @property string $jadwalttbumil_nama
 * @property string $jadwalttbumil_desc
 * @property string $jadwalttbumil_periode
 * @property string $jadwalttbumil_pemberian
 * @property string $jadwalttbumil_dosis
 * @property boolean $jadwalttbumil_aktif
 */
class JadwalttbumilM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JadwalttbumilM the static model class
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
		return 'jadwalttbumil_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jadwalttbumil_kode, jadwalttbumil_nama', 'required'),
			array('diagnosa_id', 'numerical', 'integerOnly'=>true),
			array('jadwalttbumil_kode', 'length', 'max'=>10),
			array('jadwalttbumil_nama, jadwalttbumil_pemberian', 'length', 'max'=>100),
			array('jadwalttbumil_periode', 'length', 'max'=>50),
			array('jadwalttbumil_dosis', 'length', 'max'=>20),
			array('jadwalttbumil_desc, jadwalttbumil_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('jadwalttbumil_id, diagnosa_id, jadwalttbumil_kode, jadwalttbumil_nama, jadwalttbumil_desc, jadwalttbumil_periode, jadwalttbumil_pemberian, jadwalttbumil_dosis, jadwalttbumil_aktif', 'safe', 'on'=>'search'),
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
                    'diagnosa'=>array(self::BELONGS_TO ,'DiagnosaM','diagnosa_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'jadwalttbumil_id' => 'Jadwalttbumil',
			'diagnosa_id' => 'Diagnosa',
			'jadwalttbumil_kode' => 'Jadwalttbumil Kode',
			'jadwalttbumil_nama' => 'Jadwalttbumil Nama',
			'jadwalttbumil_desc' => 'Jadwalttbumil Desc',
			'jadwalttbumil_periode' => 'Jadwalttbumil Periode',
			'jadwalttbumil_pemberian' => 'Jadwalttbumil Pemberian',
			'jadwalttbumil_dosis' => 'Jadwalttbumil Dosis',
			'jadwalttbumil_aktif' => 'Jadwalttbumil Aktif',
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

		$criteria->compare('jadwalttbumil_id',$this->jadwalttbumil_id);
		$criteria->compare('diagnosa_id',$this->diagnosa_id);
		$criteria->compare('LOWER(jadwalttbumil_kode)',strtolower($this->jadwalttbumil_kode),true);
		$criteria->compare('LOWER(jadwalttbumil_nama)',strtolower($this->jadwalttbumil_nama),true);
		$criteria->compare('LOWER(jadwalttbumil_desc)',strtolower($this->jadwalttbumil_desc),true);
		$criteria->compare('LOWER(jadwalttbumil_periode)',strtolower($this->jadwalttbumil_periode),true);
		$criteria->compare('LOWER(jadwalttbumil_pemberian)',strtolower($this->jadwalttbumil_pemberian),true);
		$criteria->compare('LOWER(jadwalttbumil_dosis)',strtolower($this->jadwalttbumil_dosis),true);
		$criteria->compare('jadwalttbumil_aktif',$this->jadwalttbumil_aktif);
                $criteria->addCondition('jadwalttbumil_aktif is true');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('jadwalttbumil_id',$this->jadwalttbumil_id);
		$criteria->compare('diagnosa_id',$this->diagnosa_id);
		$criteria->compare('LOWER(jadwalttbumil_kode)',strtolower($this->jadwalttbumil_kode),true);
		$criteria->compare('LOWER(jadwalttbumil_nama)',strtolower($this->jadwalttbumil_nama),true);
		$criteria->compare('LOWER(jadwalttbumil_desc)',strtolower($this->jadwalttbumil_desc),true);
		$criteria->compare('LOWER(jadwalttbumil_periode)',strtolower($this->jadwalttbumil_periode),true);
		$criteria->compare('LOWER(jadwalttbumil_pemberian)',strtolower($this->jadwalttbumil_pemberian),true);
		$criteria->compare('LOWER(jadwalttbumil_dosis)',strtolower($this->jadwalttbumil_dosis),true);
		$criteria->compare('jadwalttbumil_aktif',$this->jadwalttbumil_aktif);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}