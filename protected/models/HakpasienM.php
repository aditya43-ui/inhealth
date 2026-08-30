<?php

/**
 * This is the model class for table "hakpasien_m".
 *
 * The followings are the available columns in table 'hakpasien_m':
 * @property string $hakpasien_id
 * @property string $hakpasien_nama
 * @property integer $hakpasien_urutan
 * @property boolean $hakpasien_aktif
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property LoginpemakaiK $createLoginpemakai
 * @property LoginpemakaiK $updateLoginpemakai
 * @property RuanganM $createRuangan
 */
class HakpasienM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return HakpasienM the static model class
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
		return 'hakpasien_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('hakpasien_nama, hakpasien_urutan, kelompok, create_time', 'required'),
			array('create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('hakpasien_aktif, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('kelompok, hakpasien_id, hakpasien_nama, hakpasien_urutan, hakpasien_aktif, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'createLoginpemakai' => array(self::BELONGS_TO, 'LoginpemakaiK', 'create_loginpemakai_id'),
			'updateLoginpemakai' => array(self::BELONGS_TO, 'LoginpemakaiK', 'update_loginpemakai_id'),
			'createRuangan' => array(self::BELONGS_TO, 'RuanganM', 'create_ruangan'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'hakpasien_id' => 'Hak Pasien',
			'hakpasien_nama' => 'Nama',
			'hakpasien_urutan' => 'Urutan',
			'hakpasien_aktif' => 'Aktif',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
            'kelompok' => 'Kelompok',
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

		$criteria->compare('hakpasien_id',$this->hakpasien_id,true);
		$criteria->compare('hakpasien_nama',$this->hakpasien_nama,true);
		$criteria->compare('hakpasien_urutan',$this->hakpasien_urutan);
		$criteria->compare('hakpasien_aktif',$this->hakpasien_aktif);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('lower(kelompok)',strtolower($this->kelompok),true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

        
	public function searchPrint()
	{
			// Warning: Please modify the following code to remove attributes that
			// should not be searched.

	$criteria=new CDbCriteria;
	$criteria->compare('hakpasien_id',$this->hakpasien_id);
	$criteria->compare('LOWER(hakpasien_nama)',strtolower($this->hakpasien_nama),true);
	$criteria->compare('LOWER(hakpasien_urutan)',strtolower($this->hakpasien_urutan),true);
	$criteria->compare('hakpasien_aktif',isset($this->hakpasien_aktif)?$this->hakpasien_aktif:true);
			// Klo limit lebih kecil dari nol itu berarti ga ada limit 
			$criteria->limit=-1; 

			return new CActiveDataProvider($this, array(
					'criteria'=>$criteria,
					 'pagination'=>false,
			));
	}

}