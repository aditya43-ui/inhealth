<?php

/**
 * This is the model class for table "laporanpasienanestesi_v".
 *
 * The followings are the available columns in table 'laporanpasienanestesi_v':
 * @property integer $pasienanastesi_id
 * @property string $tglanastesi
 * @property string $noanestesi
 * @property integer $pasien_id
 * @property string $no_rekam_medik
 * @property string $nama_pasien
 * @property string $jeniskelamin
 * @property string $alamat_pasien
 * @property integer $pendaftaran_id
 * @property string $no_pendaftaran
 * @property string $umur
 * @property integer $typeanastesi_id
 * @property string $typeanastesi_nama
 * @property string $statusanestesi
 */
class LaporanpasienanestesiV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporanpasienanestesiV the static model class
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
		return 'laporanpasienanestesi_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasienanastesi_id, pasien_id, pendaftaran_id, typeanastesi_id', 'numerical', 'integerOnly'=>true),
			array('noanestesi, jeniskelamin, no_pendaftaran, statusanestesi', 'length', 'max'=>20),
			array('no_rekam_medik', 'length', 'max'=>10),
			array('nama_pasien', 'length', 'max'=>50),
			array('umur', 'length', 'max'=>30),
			array('typeanastesi_nama', 'length', 'max'=>500),
			array('tglanastesi, alamat_pasien', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pasienanastesi_id, tglanastesi, noanestesi, pasien_id, no_rekam_medik, nama_pasien, jeniskelamin, alamat_pasien, pendaftaran_id, no_pendaftaran, umur, typeanastesi_id, typeanastesi_nama, statusanestesi', 'safe', 'on'=>'search'),
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
			'pasienanastesi_id' => 'Pasienanastesi',
			'tglanastesi' => 'Tglanastesi',
			'noanestesi' => 'Noanestesi',
			'pasien_id' => 'Pasien',
			'no_rekam_medik' => 'No Rekam Medik',
			'nama_pasien' => 'Nama Pasien',
			'jeniskelamin' => 'Jeniskelamin',
			'alamat_pasien' => 'Alamat Pasien',
			'pendaftaran_id' => 'Pendaftaran',
			'no_pendaftaran' => 'No Pendaftaran',
			'umur' => 'Umur',
			'typeanastesi_id' => 'Typeanastesi',
			'typeanastesi_nama' => 'Typeanastesi Nama',
			'statusanestesi' => 'Statusanestesi',
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

		$criteria->compare('pasienanastesi_id',$this->pasienanastesi_id);
		$criteria->compare('tglanastesi',$this->tglanastesi,true);
		$criteria->compare('noanestesi',$this->noanestesi,true);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('no_rekam_medik',$this->no_rekam_medik,true);
		$criteria->compare('nama_pasien',$this->nama_pasien,true);
		$criteria->compare('jeniskelamin',$this->jeniskelamin,true);
		$criteria->compare('alamat_pasien',$this->alamat_pasien,true);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('no_pendaftaran',$this->no_pendaftaran,true);
		$criteria->compare('umur',$this->umur,true);
		$criteria->compare('typeanastesi_id',$this->typeanastesi_id);
		$criteria->compare('typeanastesi_nama',$this->typeanastesi_nama,true);
		$criteria->compare('statusanestesi',$this->statusanestesi,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}