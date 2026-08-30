<?php

/**
 * This is the model class for table "verifikasiaskep_t".
 *
 * The followings are the available columns in table 'verifikasiaskep_t':
 * @property integer $verifikasiaskep_id
 * @property integer $pegawai_id
 * @property integer $ruangan_id
 * @property string $verifikasiaskep_tgl
 * @property string $verifikasiaskep_no
 * @property string $verifikasiaskep_ket
 * @property string $petugasverifikasi_nama
 * @property string $mengetahui_nama
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property string $verifikasiaskep_status
 * @property integer $pendaftaran_id
 * @property integer $pengkajianaskep_id
 * @property integer $rencanaaskep_id
 * @property integer $implementasiaskep_t
 * @property integer $evaluasiaskep_t
 *
 * The followings are the available model relations:
 * @property PegawaiM $pegawai
 * @property RuanganM $ruangan
 * @property PendaftaranT $pendaftaran
 */
class VerifikasiaskepT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return VerifikasiaskepT the static model class
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
		return 'verifikasiaskep_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ruangan_id, verifikasiaskep_tgl, verifikasiaskep_no, petugasverifikasi_nama, mengetahui_nama, create_time, create_loginpemakai_id, create_ruangan, verifikasiaskep_status, pendaftaran_id, pengkajianaskep_id', 'required'),
			array('pegawai_id, ruangan_id, pendaftaran_id, pengkajianaskep_id, rencanaaskep_id, implementasiaskep_id, evaluasiaskep_id', 'numerical', 'integerOnly'=>true),
			array('verifikasiaskep_no, verifikasiaskep_status', 'length', 'max'=>20),
			array('petugasverifikasi_nama, mengetahui_nama', 'length', 'max'=>50),
			array('verifikasiaskep_ket, update_time, update_loginpemakai_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('verifikasiaskep_id, pegawai_id, ruangan_id, verifikasiaskep_tgl, verifikasiaskep_no, verifikasiaskep_ket, petugasverifikasi_nama, mengetahui_nama, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, verifikasiaskep_status, pendaftaran_id, pengkajianaskep_id, rencanaaskep_id, implementasiaskep_id, evaluasiaskep_id', 'safe', 'on'=>'search'),
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
			'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
			'ruangan' => array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
			'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'verifikasiaskep_id' => 'Verifikasiaskep',
			'pegawai_id' => 'Pegawai',
			'ruangan_id' => 'Ruangan',
			'verifikasiaskep_tgl' => 'Verifikasiaskep Tgl',
			'verifikasiaskep_no' => 'Verifikasiaskep No',
			'verifikasiaskep_ket' => 'Verifikasiaskep Ket',
			'petugasverifikasi_nama' => 'Kepala Ruangan',
			'mengetahui_nama' => 'Mengetahui Nama',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'verifikasiaskep_status' => 'Verifikasiaskep Status',
			'pendaftaran_id' => 'Pendaftaran',
			'pengkajianaskep_id' => 'Pengkajianaskep',
			'rencanaaskep_id' => 'Rencanaaskep',
			'implementasiaskep_id' => 'Implementasiaskep',
			'evaluasiaskep_id' => 'Evaluasiaskep T',
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

		$criteria->compare('verifikasiaskep_id',$this->verifikasiaskep_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('verifikasiaskep_tgl',$this->verifikasiaskep_tgl,true);
		$criteria->compare('verifikasiaskep_no',$this->verifikasiaskep_no,true);
		$criteria->compare('verifikasiaskep_ket',$this->verifikasiaskep_ket,true);
		$criteria->compare('petugasverifikasi_nama',$this->petugasverifikasi_nama,true);
		$criteria->compare('mengetahui_nama',$this->mengetahui_nama,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id,true);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id,true);
		$criteria->compare('create_ruangan',$this->create_ruangan,true);
		$criteria->compare('verifikasiaskep_status',$this->verifikasiaskep_status,true);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pengkajianaskep_id',$this->pengkajianaskep_id);
		$criteria->compare('rencanaaskep_id',$this->rencanaaskep_id);
		$criteria->compare('implementasiaskep_id',$this->implementasiaskep_id);
		$criteria->compare('evaluasiaskep_id',$this->evaluasiaskep_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}