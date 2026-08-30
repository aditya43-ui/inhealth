<?php

/**
 * This is the model class for table "berkaselektronikrm_v".
 *
 * The followings are the available columns in table 'berkaselektronikrm_v':
 * @property string $nama_pasien
 * @property string $no_rekam_medik
 * @property integer $dokfilerm_nourut
 * @property string $dokfilerm_tgl
 * @property string $dokfilerm_filepath
 * @property string $dokfilerm_keterangan
 * @property string $scan_tgl
 * @property string $upload_tgl
 * @property string $namafolder
 * @property string $nama_pegawai
 */
class BerkaselektronikrmV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BerkaselektronikrmV the static model class
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
		return 'berkaselektronikrm_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('dokfilerm_nourut', 'numerical', 'integerOnly'=>true),
			array('nama_pasien, nama_pegawai', 'length', 'max'=>50),
			array('no_rekam_medik', 'length', 'max'=>10),
			array('namafolder', 'length', 'max'=>100),
			array('dokfilerm_tgl, dokfilerm_filepath, dokfilerm_keterangan, scan_tgl, upload_tgl', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('nama_pasien, no_rekam_medik, dokfilerm_nourut, dokfilerm_tgl, dokfilerm_filepath, dokfilerm_keterangan, scan_tgl, upload_tgl, namafolder, nama_pegawai', 'safe', 'on'=>'search'),
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
			'nama_pasien' => 'Nama Pasien',
			'no_rekam_medik' => 'No. Rekam Medik',
			'dokfilerm_nourut' => 'Dokfilerm Nourut',
			'dokfilerm_tgl' => 'Dokfilerm Tgl',
			'dokfilerm_filepath' => 'Dokfilerm Filepath',
			'dokfilerm_keterangan' => 'Dokfilerm Keterangan',
			'scan_tgl' => 'Scan Tgl',
			'upload_tgl' => 'Upload Tgl',
			'namafolder' => 'Namafolder',
			'nama_pegawai' => 'Nama Pegawai',
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

		$criteria->compare('nama_pasien',$this->nama_pasien,true);
		$criteria->compare('no_rekam_medik',$this->no_rekam_medik,true);
		$criteria->compare('dokfilerm_nourut',$this->dokfilerm_nourut);
		$criteria->compare('dokfilerm_tgl',$this->dokfilerm_tgl,true);
		$criteria->compare('dokfilerm_filepath',$this->dokfilerm_filepath,true);
		$criteria->compare('dokfilerm_keterangan',$this->dokfilerm_keterangan,true);
		$criteria->compare('scan_tgl',$this->scan_tgl,true);
		$criteria->compare('upload_tgl',$this->upload_tgl,true);
		$criteria->compare('namafolder',$this->namafolder,true);
		$criteria->compare('nama_pegawai',$this->nama_pegawai,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}