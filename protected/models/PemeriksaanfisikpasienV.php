<?php

/**
 * This is the model class for table "pemeriksaanfisikpasien_v".
 * 
 * @author     Andyka Putra <andykaputra@.com>
 * @package application.models
 * 
 * The followings are the available columns in table 'pemeriksaanfisikpasien_v':
 * @property string $nama_pasien
 * @property string $jeniskelamin
 * @property string $tempat_lahir
 * @property string $tanggal_lahir
 * @property string $alamat_pasien
 * @property string $no_rekam_medik
 * @property string $tgl_rekam_medik
 * @property integer $pendaftaran_id
 * @property string $no_pendaftaran
 * @property string $tgl_pendaftaran
 * @property string $umur
 * @property string $diagnosis
 * @property integer $tekanandarah_sistolik
 * @property integer $tekanandarah_diastolik
 * @property integer $nadi
 * @property integer $beratbadan
 * @property integer $tinggibadan
 * @property integer $suratketerangan_id
 * @property string $status_fisik
 * @property string $lampiransuratsehat_nama
 */
class PemeriksaanfisikpasienV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PemeriksaanfisikpasienV the static model class
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
		return 'pemeriksaanfisikpasien_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendaftaran_id, tekanandarah_sistolik, tekanandarah_diastolik, nadi, beratbadan, tinggibadan, suratketerangan_id', 'numerical', 'integerOnly'=>true),
			array('nama_pasien, status_fisik', 'length', 'max'=>50),
			array('jeniskelamin, no_pendaftaran', 'length', 'max'=>20),
			array('tempat_lahir', 'length', 'max'=>25),
			array('no_rekam_medik', 'length', 'max'=>10),
			array('umur', 'length', 'max'=>30),
			array('lampiransuratsehat_nama', 'length', 'max'=>255),
			array('tanggal_lahir, alamat_pasien, tgl_rekam_medik, tgl_pendaftaran, diagnosis', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('nama_pasien, jeniskelamin, tempat_lahir, tanggal_lahir, alamat_pasien, no_rekam_medik, tgl_rekam_medik, pendaftaran_id, no_pendaftaran, tgl_pendaftaran, umur, diagnosis, tekanandarah_sistolik, tekanandarah_diastolik, nadi, beratbadan, tinggibadan, suratketerangan_id, status_fisik, lampiransuratsehat_nama', 'safe', 'on'=>'search'),
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
			'jeniskelamin' => 'Jenis Kelamin',
			'tempat_lahir' => 'Tempat Lahir',
			'tanggal_lahir' => 'Tanggal Lahir',
			'alamat_pasien' => 'Alamat Pasien',
			'no_rekam_medik' => 'No. Rekam Medik',
			'tgl_rekam_medik' => 'Tgl. Rekam Medik',
			'pendaftaran_id' => 'Pendaftaran',
			'no_pendaftaran' => 'No. Pendaftaran',
			'tgl_pendaftaran' => 'Tgl. Pendaftaran',
			'umur' => 'Umur',
			'diagnosis' => 'Diagnosis',
			'tekanandarah_sistolik' => 'Tekanandarah Sistolik',
			'tekanandarah_diastolik' => 'Tekanandarah Diastolik',
			'nadi' => 'Nadi',
			'beratbadan' => 'Beratbadan',
			'tinggibadan' => 'Tinggibadan',
			'suratketerangan_id' => 'Suratketerangan',
			'status_fisik' => 'Status Fisik',
			'lampiransuratsehat_nama' => 'Lampiransuratsehat Nama',
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
		$criteria->compare('jeniskelamin',$this->jeniskelamin,true);
		$criteria->compare('tempat_lahir',$this->tempat_lahir,true);
		$criteria->compare('tanggal_lahir',$this->tanggal_lahir,true);
		$criteria->compare('alamat_pasien',$this->alamat_pasien,true);
		$criteria->compare('no_rekam_medik',$this->no_rekam_medik,true);
		$criteria->compare('tgl_rekam_medik',$this->tgl_rekam_medik,true);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('no_pendaftaran',$this->no_pendaftaran,true);
		$criteria->compare('tgl_pendaftaran',$this->tgl_pendaftaran,true);
		$criteria->compare('umur',$this->umur,true);
		$criteria->compare('diagnosis',$this->diagnosis,true);
		$criteria->compare('tekanandarah_sistolik',$this->tekanandarah_sistolik);
		$criteria->compare('tekanandarah_diastolik',$this->tekanandarah_diastolik);
		$criteria->compare('nadi',$this->nadi);
		$criteria->compare('beratbadan',$this->beratbadan);
		$criteria->compare('tinggibadan',$this->tinggibadan);
		$criteria->compare('suratketerangan_id',$this->suratketerangan_id);
		$criteria->compare('status_fisik',$this->status_fisik,true);
		$criteria->compare('lampiransuratsehat_nama',$this->lampiransuratsehat_nama,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}