<?php

/**
 * This is the model class for table "nursestation_m".
 *
 * The followings are the available columns in table 'nursestation_m':
 * @property integer $nursestation_id
 * @property string $nursestation_nama
 * @property string $nursestation_namalain
 * @property string $nursestation_lokasi
 * @property string $nursestation_telp
 * @property integer $nursestation_pj_id
 * @property boolean $nursestation_akitf
 * @property string $nursestation_singkatan
 * @property string $nursestation_filesuara
 */
class NursestationM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return NursestationM the static model class
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
		return 'nursestation_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nursestation_nama, nursestation_namalain, nursestation_lokasi, nursestation_akitf, nursestation_singkatan', 'required'),
			array('nursestation_pj_id', 'numerical', 'integerOnly'=>true),
			array('nursestation_nama, nursestation_namalain, nursestation_lokasi', 'length', 'max'=>100),
			array('nursestation_telp', 'length', 'max'=>50),
			array('nursestation_filesuara', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('nursestation_id, nursestation_nama, nursestation_namalain, nursestation_lokasi, nursestation_telp, nursestation_pj_id, nursestation_akitf', 'safe', 'on'=>'search'),
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
			'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'nursestation_pj_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'nursestation_id' => 'Nursestation',
			'nursestation_nama' => 'Nama Nurse Station',
			'nursestation_namalain' => 'Nurse Station Nama lain',
			'nursestation_lokasi' => 'Lokasi Nurse Station ',
			'nursestation_telp' => 'Telp Nurse Station ',
			'nursestation_pj_id' => 'Penanggung Jawab Nurse Station',
			'nursestation_akitf' => 'Aktif',
			'nursestation_filesuara' => 'File Suara',
			'nursestation_singkatan' => 'Singkatan',
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

		$criteria->compare('nursestation_id',$this->nursestation_id);
		$criteria->compare('nursestation_nama',$this->nursestation_nama,true);
		$criteria->compare('nursestation_namalain',$this->nursestation_namalain,true);
		$criteria->compare('nursestation_lokasi',$this->nursestation_lokasi,true);
		$criteria->compare('nursestation_telp',$this->nursestation_telp,true);
		$criteria->compare('nursestation_pj_id',$this->nursestation_pj_id);
		$criteria->compare('nursestation_akitf',$this->nursestation_akitf);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}