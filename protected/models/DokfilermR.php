<?php

/**
 * This is the model class for table "dokfilerm_r".
 *
 * The followings are the available columns in table 'dokfilerm_r':
 * @property integer $dokfilerm_id
 * @property integer $pasien_id
 * @property integer $dokfilerm_nourut
 * @property string $dokfilerm_tgl
 * @property string $dokfilerm_filepath
 * @property string $dokfilerm_keterangan
 * @property string $scan_tgl
 * @property string $upload_tgl
 * @property string $namafolder
 * @property integer $pegawaiscan_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property PasienM $pasien
 * 
 * @author Deni Hamdani <denihamdani@piindonesia.co.id>
 * @package application.models
 */
class DokfilermR extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DokfilermR the static model class
	 */
	public $tgl_pendaftaran;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'dokfilerm_r';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasien_id, dokfilerm_nourut, dokfilerm_tgl, dokfilerm_filepath, create_time, create_loginpemakai_id', 'required'),
			array('pasien_id, dokfilerm_nourut, pegawaiscan_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('dokfilerm_keterangan,instalasi_ids, scan_tgl, upload_tgl, namafolder, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('dokfilerm_id, pasien_id, dokfilerm_nourut, dokfilerm_tgl, dokfilerm_filepath, dokfilerm_keterangan, scan_tgl, upload_tgl, namafolder, pegawaiscan_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'dokfilerm_id' => 'Dokfilerm',
			'pasien_id' => 'Pasien',
			'dokfilerm_nourut' => 'Dokfilerm Nourut',
			'dokfilerm_tgl' => 'Dokfilerm Tgl',
			'dokfilerm_filepath' => 'Dokfilerm Filepath',
			'dokfilerm_keterangan' => 'Dokfilerm Keterangan',
			'scan_tgl' => 'Scan Tgl',
			'upload_tgl' => 'Upload Tgl',
			'namafolder' => 'Namafolder',
			'pegawaiscan_id' => 'Pegawaiscan',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'dokfilerm_nama' => 'Nama Dokumen'
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

		$criteria->compare('dokfilerm_id',$this->dokfilerm_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('dokfilerm_nourut',$this->dokfilerm_nourut);
		$criteria->compare('dokfilerm_tgl',$this->dokfilerm_tgl,true);
		$criteria->compare('dokfilerm_filepath',$this->dokfilerm_filepath,true);
		$criteria->compare('dokfilerm_keterangan',$this->dokfilerm_keterangan,true);
		$criteria->compare('scan_tgl',$this->scan_tgl,true);
		$criteria->compare('upload_tgl',$this->upload_tgl,true);
		$criteria->compare('namafolder',$this->namafolder,true);
		$criteria->compare('pegawaiscan_id',$this->pegawaiscan_id);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}