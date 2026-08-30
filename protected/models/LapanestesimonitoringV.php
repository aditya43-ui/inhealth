<?php

/**
 * This is the model class for table "lapanestesimonitoring_v".
 *
 * The followings are the available columns in table 'lapanestesimonitoring_v':
 * @property integer $intraanestesi_id
 * @property string $nointraanestesi
 * @property string $tglintraanestesi
 * @property string $monitoring
 * @property integer $pasien_id
 * @property string $no_rekam_medik
 * @property string $namadepan
 * @property string $nama_pasien
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 */
class LapanestesimonitoringV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LapanestesimonitoringV the static model class
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
		return 'lapanestesimonitoring_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('intraanestesi_id, pasien_id, ruangan_id', 'numerical', 'integerOnly'=>true),
			array('nointraanestesi, namadepan', 'length', 'max'=>20),
			array('monitoring', 'length', 'max'=>500),
			array('no_rekam_medik', 'length', 'max'=>10),
			array('nama_pasien, ruangan_nama', 'length', 'max'=>50),
			array('tglintraanestesi', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('intraanestesi_id, nointraanestesi, tglintraanestesi, monitoring, pasien_id, no_rekam_medik, namadepan, nama_pasien, ruangan_id, ruangan_nama', 'safe', 'on'=>'search'),
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
			'intraanestesi_id' => 'Intraanestesi',
			'nointraanestesi' => 'Nointraanestesi',
			'tglintraanestesi' => 'Tglintraanestesi',
			'monitoring' => 'Monitoring',
			'pasien_id' => 'Pasien',
			'no_rekam_medik' => 'No Rekam Medik',
			'namadepan' => 'Namadepan',
			'nama_pasien' => 'Nama Pasien',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
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

		$criteria->compare('intraanestesi_id',$this->intraanestesi_id);
		$criteria->compare('nointraanestesi',$this->nointraanestesi,true);
		$criteria->compare('tglintraanestesi',$this->tglintraanestesi,true);
		$criteria->compare('monitoring',$this->monitoring,true);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('no_rekam_medik',$this->no_rekam_medik,true);
		$criteria->compare('namadepan',$this->namadepan,true);
		$criteria->compare('nama_pasien',$this->nama_pasien,true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}