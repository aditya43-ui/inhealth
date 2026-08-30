<?php

/**
 * This is the model class for table "grafiktandavital_t".
 *
 * The followings are the available columns in table 'grafiktandavital_t':
 * @property integer $grafiktandavital_id
 * @property integer $pendaftaran_id
 * @property integer $pasienadmisi_id
 * @property string $tgl_monitoring
 * @property integer $jam_monitoring
 * @property integer $pernapasan
 * @property integer $suhu
 * @property integer $nadi
 * @property integer $td_systolic
 * @property integer $td_dyastolic
 * @property string $mosokomial
 * @property integer $berat_badan
 * @property integer $tinggi_badan
 * @property string $bab
 * @property string $cairan_masuk
 * @property string $cairan_keluar
 * @property integer $petugaspengisi_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property PendaftaranT $pendaftaran
 * @property PasienadmisiT $pasienadmisi
 * @property PegawaiM $petugaspengisi
 */
class GrafiktandavitalT extends CActiveRecord
{
    public $petugaspengisi_nama;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return GrafiktandavitalT the static model class
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
		return 'grafiktandavital_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendaftaran_id, tgl_monitoring, jam_monitoring, pernapasan, suhu, nadi, td_systolic, td_dyastolic, petugaspengisi_id', 'required'),
			array('pendaftaran_id, pasienadmisi_id, jam_monitoring, pernapasan, nadi, td_systolic, td_dyastolic, berat_badan, tinggi_badan, petugaspengisi_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('mosokomial, bab, cairan_masuk, cairan_keluar', 'length', 'max'=>100),
			array('create_time, update_time, pasienadmisi_id, keterangan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('grafiktandavital_id, pendaftaran_id, pasienadmisi_id, tgl_monitoring, jam_monitoring, pernapasan, suhu, nadi, td_systolic, td_dyastolic, mosokomial, berat_badan, tinggi_badan, bab, cairan_masuk, cairan_keluar, petugaspengisi_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, keterangan', 'safe', 'on'=>'search'),
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
			'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
			'pasienadmisi' => array(self::BELONGS_TO, 'PasienadmisiT', 'pasienadmisi_id'),
			'petugaspengisi' => array(self::BELONGS_TO, 'PegawaiM', 'petugaspengisi_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'grafiktandavital_id' => 'Grafiktandavital',
			'pendaftaran_id' => 'Pendaftaran',
			'pasienadmisi_id' => 'Pasienadmisi',
			'tgl_monitoring' => 'Tgl Monitoring',
			'jam_monitoring' => 'Jam Monitoring',
			'pernapasan' => 'Pernapasan',
			'suhu' => 'Suhu Tubuh',
			'nadi' => 'Nadi',
			'td_systolic' => 'Tekanan Darah',
			'td_dyastolic' => 'Td Dyastolic',
			'mosokomial' => 'Infeksi Nosokomial',
			'berat_badan' => 'Berat Badan',
			'tinggi_badan' => 'Tinggi Badan',
			'bab' => 'BAB',
			'cairan_masuk' => 'Cairan Masuk',
			'cairan_keluar' => 'Cairan Keluar',
			'petugaspengisi_id' => 'Petugas Pengisi',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
      		'keterangan'=>'keterangan'
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

		$criteria->compare('grafiktandavital_id',$this->grafiktandavital_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('tgl_monitoring',$this->tgl_monitoring,true);
		$criteria->compare('jam_monitoring',$this->jam_monitoring);
		$criteria->compare('pernapasan',$this->pernapasan);
		$criteria->compare('suhu',$this->suhu);
		$criteria->compare('nadi',$this->nadi);
		$criteria->compare('td_systolic',$this->td_systolic);
		$criteria->compare('td_dyastolic',$this->td_dyastolic);
		$criteria->compare('mosokomial',$this->mosokomial,true);
		$criteria->compare('berat_badan',$this->berat_badan);
		$criteria->compare('tinggi_badan',$this->tinggi_badan);
		$criteria->compare('bab',$this->bab,true);
		$criteria->compare('cairan_masuk',$this->cairan_masuk,true);
		$criteria->compare('cairan_keluar',$this->cairan_keluar,true);
		$criteria->compare('petugaspengisi_id',$this->petugaspengisi_id);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

  public function searchRiwayat()
	{
		$criteria=new CDbCriteria;

    if(!empty($this->pendaftaran_id)){
      $criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
    }

    if(!empty($this->pasienadmisi_id)){
      $criteria->addCondition('pasienadmisi_id = '.$this->pasienadmisi_id);
    }
    $criteria->order = "tgl_monitoring, jam_monitoring";

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
