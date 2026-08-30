<?php

/**
 * This is the model class for table "informasipasientriage_v".
 *
 * The followings are the available columns in table 'informasipasientriage_v':
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
 * @property integer $pengambilanobat_triage_id
 */
class InformasipasientriageV extends CActiveRecord
{    public $tgl_awal, $tgl_akhir;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'informasipasientriage_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('notriage_pasien_id, bed_triage_id, asesmentriagewpss_id, pendaftaran_id, pasien_id, pengambilanobat_triage_id', 'numerical', 'integerOnly'=>true),
			array('no_bed_triage, no_rekam_medik', 'length', 'max'=>10),
			array('no_triage_pasien, no_pendaftaran', 'length', 'max'=>20),
			array('warnatriage, nama_pasien, statusperiksa', 'length', 'max'=>50),
			array('tanggal, keterangan, warna', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('tanggal, notriage_pasien_id, bed_triage_id, no_bed_triage, no_triage_pasien, keterangan, asesmentriagewpss_id, warnatriage, warna, pendaftaran_id, no_pendaftaran, pasien_id, nama_pasien, no_rekam_medik, statusperiksa, pengambilanobat_triage_id', 'safe', 'on'=>'search'),
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
			'no_bed_triage' => 'No Bed Triage',
			'no_triage_pasien' => 'No Triage Pasien',
			'keterangan' => 'Keterangan',
			'asesmentriagewpss_id' => 'Asesmen Triage WPSS',
			'warnatriage' => 'Warna Triage',
			'warna' => 'Warna',
			'pendaftaran_id' => 'Pendaftaran',
			'no_pendaftaran' => 'No Pendaftaran',
			'pasien_id' => 'Pasien',
			'nama_pasien' => 'Nama Pasien',
			'no_rekam_medik' => 'No Rekam Medik',
			'statusperiksa' => 'Status Periksa',
			'pengambilanobat_triage_id' => 'Pengambilanobat Triage',
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
		$criteria->compare('notriage_pasien_id',$this->notriage_pasien_id);
		$criteria->compare('bed_triage_id',$this->bed_triage_id);
		$criteria->compare('no_bed_triage',$this->no_bed_triage,true);
		$criteria->compare('no_triage_pasien',$this->no_triage_pasien,true);
		$criteria->compare('keterangan',$this->keterangan,true);
		$criteria->compare('asesmentriagewpss_id',$this->asesmentriagewpss_id);
		$criteria->compare('warnatriage',$this->warnatriage,true);
		$criteria->compare('warna',$this->warna,true);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('no_pendaftaran',$this->no_pendaftaran,true);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('nama_pasien',$this->nama_pasien,true);
		$criteria->compare('no_rekam_medik',$this->no_rekam_medik,true);
		$criteria->compare('statusperiksa',$this->statusperiksa,true);
		$criteria->compare('pengambilanobat_triage_id',$this->pengambilanobat_triage_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


	public function search2()
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

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return InformasipasientriageV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
