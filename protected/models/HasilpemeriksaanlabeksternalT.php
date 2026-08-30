<?php

/**
 * This is the model class for table "hasilpemeriksaanlabeksternal_t".
 *
 * The followings are the available columns in table 'hasilpemeriksaanlabeksternal_t':
 * @property integer $hasilpemeriksaanlabeksternal_id
 * @property integer $pendaftaran_id
 * @property integer $pasien_id
 * @property integer $pasienadmisi_id
 * @property integer $monitoring_pre_hd_id
 * @property string $nama_pemeriksaan
 * @property string $tgl_pemeriksaan
 * @property string $hasil_pemeriskaan
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property integer $asesmen_awal_medis_id
 *
 * The followings are the available model relations:
 * @property PasienM $pasien
 * @property PasienadmisiT $pasienadmisi
 * @property PendaftaranT $pendaftaran
 * @property MonitoringPreHdT $monitoringPreHd
 */
class HasilpemeriksaanlabeksternalT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return HasilpemeriksaanlabeksternalT the static model class
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
		return 'hasilpemeriksaanlabeksternal_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendaftaran_id, pasien_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pendaftaran_id, pasien_id, pasienadmisi_id, monitoring_pre_hd_id, asesmen_awal_medis_id', 'numerical', 'integerOnly'=>true),
			array('nama_pemeriksaan', 'length', 'max'=>50),
			array('tgl_pemeriksaan, hasil_pemeriskaan, update_time, update_loginpemakai_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('hasilpemeriksaanlabeksternal_id, pendaftaran_id, pasien_id, pasienadmisi_id, monitoring_pre_hd_id, nama_pemeriksaan, tgl_pemeriksaan, hasil_pemeriskaan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, asesmen_awal_medis_id', 'safe', 'on'=>'search'),
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
			'pasienadmisi' => array(self::BELONGS_TO, 'PasienadmisiT', 'pasienadmisi_id'),
			'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
			'monitoringPreHd' => array(self::BELONGS_TO, 'MonitoringPreHdT', 'monitoring_pre_hd_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'hasilpemeriksaanlabeksternal_id' => 'Hasilpemeriksaanlabeksternal',
			'pendaftaran_id' => 'Pendaftaran',
			'pasien_id' => 'Pasien',
			'pasienadmisi_id' => 'Pasienadmisi',
			'monitoring_pre_hd_id' => 'Monitoring Pre Hd',
			'nama_pemeriksaan' => 'Nama Pemeriksaan',
			'tgl_pemeriksaan' => 'Tgl Pemeriksaan',
			'hasil_pemeriskaan' => 'Hasil Pemeriskaan',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
			'asesmen_awal_medis_id' => 'Asesmen Awal Medis',
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

		$criteria->compare('hasilpemeriksaanlabeksternal_id',$this->hasilpemeriksaanlabeksternal_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('monitoring_pre_hd_id',$this->monitoring_pre_hd_id);
		$criteria->compare('nama_pemeriksaan',$this->nama_pemeriksaan,true);
		$criteria->compare('tgl_pemeriksaan',$this->tgl_pemeriksaan,true);
		$criteria->compare('hasil_pemeriskaan',$this->hasil_pemeriskaan,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id,true);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id,true);
		$criteria->compare('create_ruangan',$this->create_ruangan,true);
		$criteria->compare('asesmen_awal_medis_id',$this->asesmen_awal_medis_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}