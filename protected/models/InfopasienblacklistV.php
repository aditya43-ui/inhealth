<?php

/**
 * This is the model class for table "infopasienblacklist_v".
 *
 * The followings are the available columns in table 'infopasienblacklist_v':
 * @property integer $pasienblacklist_id
 * @property string $pasienblacklist_no
 * @property string $pasienblacklist_tgl
 * @property string $pasienblacklist_karenakasus
 * @property string $pasienblacklist_ket
 * @property boolean $isblacklist
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property integer $pendaftaran_id
 * @property string $no_pendaftaran
 * @property string $tgl_pendaftaran
 * @property integer $pasien_id
 * @property string $no_rekam_medik
 * @property string $nama_pasien
 * @property integer $pembayaranpelayanan_id
 * @property double $totalsisatagihan
 * @property integer $pegawai_id
 * @property string $nama_pegawai
 */
class InfopasienblacklistV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InfopasienblacklistV the static model class
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
		return 'infopasienblacklist_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasienblacklist_id, pendaftaran_id, pasien_id, pembayaranpelayanan_id, pegawai_id', 'numerical', 'integerOnly'=>true),
			array('totalsisatagihan', 'numerical'),
			array('pasienblacklist_no, no_pendaftaran', 'length', 'max'=>20),
			array('pasienblacklist_karenakasus', 'length', 'max'=>200),
			array('no_rekam_medik', 'length', 'max'=>10),
			array('nama_pasien, nama_pegawai', 'length', 'max'=>50),
			array('pasienblacklist_tgl, pasienblacklist_ket, isblacklist, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, tgl_pendaftaran', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pasienblacklist_id, pasienblacklist_no, pasienblacklist_tgl, pasienblacklist_karenakasus, pasienblacklist_ket, isblacklist, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, pendaftaran_id, no_pendaftaran, tgl_pendaftaran, pasien_id, no_rekam_medik, nama_pasien, pembayaranpelayanan_id, totalsisatagihan, pegawai_id, nama_pegawai', 'safe', 'on'=>'search'),
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
			'pasienblacklist_id' => 'Pasienblacklist',
			'pasienblacklist_no' => 'Pasienblacklist No',
			'pasienblacklist_tgl' => 'Pasienblacklist Tgl',
			'pasienblacklist_karenakasus' => 'Pasienblacklist Karenakasus',
			'pasienblacklist_ket' => 'Pasienblacklist Ket',
			'isblacklist' => 'Isblacklist',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'pendaftaran_id' => 'Pendaftaran',
			'no_pendaftaran' => 'No. Pendaftaran',
			'tgl_pendaftaran' => 'Tgl. Pendaftaran',
			'pasien_id' => 'Pasien',
			'no_rekam_medik' => 'No. Rekam Medik',
			'nama_pasien' => 'Nama Pasien',
			'pembayaranpelayanan_id' => 'Pembayaranpelayanan',
			'totalsisatagihan' => 'Totalsisatagihan',
			'pegawai_id' => 'Pegawai',
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

		$criteria->compare('pasienblacklist_id',$this->pasienblacklist_id);
		$criteria->compare('pasienblacklist_no',$this->pasienblacklist_no,true);
		$criteria->compare('pasienblacklist_tgl',$this->pasienblacklist_tgl,true);
		$criteria->compare('pasienblacklist_karenakasus',$this->pasienblacklist_karenakasus,true);
		$criteria->compare('pasienblacklist_ket',$this->pasienblacklist_ket,true);
		$criteria->compare('isblacklist',$this->isblacklist);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id,true);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id,true);
		$criteria->compare('create_ruangan',$this->create_ruangan,true);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('no_pendaftaran',$this->no_pendaftaran,true);
		$criteria->compare('tgl_pendaftaran',$this->tgl_pendaftaran,true);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('no_rekam_medik',$this->no_rekam_medik,true);
		$criteria->compare('nama_pasien',$this->nama_pasien,true);
		$criteria->compare('pembayaranpelayanan_id',$this->pembayaranpelayanan_id);
		$criteria->compare('totalsisatagihan',$this->totalsisatagihan);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('nama_pegawai',$this->nama_pegawai,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}