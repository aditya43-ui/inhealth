<?php

/**
 * This is the model class for table "informasibedtriage_v".
 *
 * The followings are the available columns in table 'informasibedtriage_v':
 * @property string $tanggal
 * @property integer $notriage_pasien_id
 * @property integer $bed_triage_id
 * @property string $no_bed_triage
 * @property string $no_triage_pasien
 * @property string $keterangan
 * @property integer $asesmentriagewpss_id
 * @property string $warnatriage
 * @property string $warna
 * @property integer $pendaftaran_id
 * @property string $no_pendaftaran
 * @property integer $pasien_id
 * @property string $nama_pasien
 * @property string $no_rekam_medik
 * @property string $statusperiksa
 */
class InformasibedtriageV extends CActiveRecord
{
        public $tgl_awal, $tgl_akhir;
        
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'informasibedtriage_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('notriage_pasien_id, bed_triage_id, asesmentriagewpss_id, pendaftaran_id, pasien_id', 'numerical', 'integerOnly'=>true),
			array('no_bed_triage, no_rekam_medik', 'length', 'max'=>10),
			array('no_triage_pasien, no_pendaftaran', 'length', 'max'=>20),
			array('warnatriage, nama_pasien, statusperiksa', 'length', 'max'=>50),
			array('tanggal, keterangan, warna', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('tanggal, notriage_pasien_id, bed_triage_id, no_bed_triage, no_triage_pasien, keterangan, asesmentriagewpss_id, warnatriage, warna, pendaftaran_id, no_pendaftaran, pasien_id, nama_pasien, no_rekam_medik, statusperiksa', 'safe', 'on'=>'search'),
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
			'tanggal' => 'Tanggal',
			'notriage_pasien_id' => 'Notriage Pasien',
			'bed_triage_id' => 'Bed Triage',
			'no_bed_triage' => 'Nomor Bed',
			'no_triage_pasien' => 'Nomor Triage',
			'keterangan' => 'Keterangan',
			'asesmentriagewpss_id' => 'Asesmentriagewpss',
			'warnatriage' => 'Warnatriage',
			'warna' => 'Warna',
			'pendaftaran_id' => 'Pendaftaran',
			'no_pendaftaran' => 'Nomor Pendaftaran',
			'pasien_id' => 'Pasien',
			'nama_pasien' => 'Nama Pasien',
			'no_rekam_medik' => 'Nomor RM',
			'statusperiksa' => 'Status',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
                if (!empty($this->tgl_awal) && !empty($this->tgl_akhir)){
                    $criteria->addBetweenCondition('DATE(tanggal)',$this->tgl_awal,$this->tgl_akhir);
                }				
		$criteria->compare('LOWER(no_bed_triage)', strtolower($this->no_bed_triage),true);
		$criteria->compare('LOWER(no_triage_pasien)', strtolower($this->no_triage_pasien),true);						
		$criteria->compare('LOWER(no_pendaftaran)', strtolower($this->no_pendaftaran), true);
		$criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien), true);
		$criteria->compare('LOWER(no_rekam_medik)', strtolower($this->no_rekam_medik), true);
		$criteria->order = 'create_time DESC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function searchInfoPasienTriage()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
                if (!empty($this->tgl_awal) && !empty($this->tgl_akhir)){
                    $criteria->addBetweenCondition('DATE(tanggal)',$this->tgl_awal,$this->tgl_akhir);
                }				
		$criteria->compare('LOWER(no_bed_triage)', strtolower($this->no_bed_triage),true);
		$criteria->compare('LOWER(no_triage_pasien)', strtolower($this->no_triage_pasien),true);						
		$criteria->compare('LOWER(no_pendaftaran)', strtolower($this->no_pendaftaran), true);
		$criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien), true);
		$criteria->compare('LOWER(no_rekam_medik)', strtolower($this->no_rekam_medik), true);
		// $criteria->addCondition("statusperiksa = 'ANTRIAN' OR statusperiksa = 'SEDANG PERIKSA'");
		$criteria->order = 'create_time DESC';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return InformasibedtriageV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
