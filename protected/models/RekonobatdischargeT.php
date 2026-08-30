<?php

/**
 * This is the model class for table "rekonobatdischarge_t".
 *
 * The followings are the available columns in table 'rekonobatdischarge_t':
 * @property integer $rekonobatdischarge_id
 * @property integer $pendaftaran_id
 * @property integer $pasienadmisi_id
 * @property integer $pasien_id
 * @property string $tanggal_pengisian
 * @property integer $petugas_id
 * @property string $rujukansebelumnya
 * @property string $rujukanke
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai
 * @property string $update_loginpemakai
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property PegawaiM $petugas
 * @property PasienM $pasien
 * @property PasienadmisiT $pasienadmisi
 * @property PendaftaranT $pendaftaran
 * @property RekonobatdischargedetT[] $rekonobatdischargedetTs
 */
class RekonobatdischargeT extends CActiveRecord
{
 public $nama_obat, $dosis, $frekuensi, $cara_pemberian, $waktu_pemberian, $jumlah_obat, $tindaklanjut, $keterangan, $petugas_nama;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RekonobatdischargeT the static model class
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
		return 'rekonobatdischarge_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendaftaran_id, pasien_id, tanggal_pengisian, petugas_id, rujukansebelumnya, rujukanke, create_time, create_loginpemakai', 'required'),
			array('pendaftaran_id, pasienadmisi_id, pasien_id, petugas_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('rujukansebelumnya, rujukanke, create_loginpemakai, update_loginpemakai', 'length', 'max'=>100),
			array('update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('rekonobatdischarge_id, pendaftaran_id, pasienadmisi_id, pasien_id, tanggal_pengisian, petugas_id, rujukansebelumnya, rujukanke, create_time, update_time, create_loginpemakai, update_loginpemakai, create_ruangan', 'safe', 'on'=>'search'),
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
			'petugas' => array(self::BELONGS_TO, 'PegawaiM', 'petugas_id'),
			'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
			'pasienadmisi' => array(self::BELONGS_TO, 'PasienadmisiT', 'pasienadmisi_id'),
			'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
			'rekonobatdischargedetTs' => array(self::HAS_MANY, 'RekonobatdischargedetT', 'rekonobatdischarge_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'rekonobatdischarge_id' => 'Rekonobatdischarge',
			'pendaftaran_id' => 'Pendaftaran',
			'pasienadmisi_id' => 'Pasienadmisi',
			'pasien_id' => 'Pasien',
			'tanggal_pengisian' => 'Tanggal Pengisian',
			'petugas_id' => 'Petugas',
			'rujukansebelumnya' => 'Dari Rujukan Sebelumnya',
			'rujukanke' => 'Rujukan ke',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai' => 'Create Loginpemakai',
			'update_loginpemakai' => 'Update Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
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

		$criteria->compare('rekonobatdischarge_id',$this->rekonobatdischarge_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('tanggal_pengisian',$this->tanggal_pengisian,true);
		$criteria->compare('petugas_id',$this->petugas_id);
		$criteria->compare('rujukansebelumnya',$this->rujukansebelumnya,true);
		$criteria->compare('rujukanke',$this->rujukanke,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai',$this->create_loginpemakai,true);
		$criteria->compare('update_loginpemakai',$this->update_loginpemakai,true);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchRiwayat()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->select = "t.tanggal_pengisian, t.rujukansebelumnya, t.rujukanke, det.nama_obat, det.dosis, det.frekuensi, det.cara_pemberian, det.waktu_pemberian, det.jumlah_obat, det.tindaklanjut, det.keterangan";
		$criteria->group = $criteria->select;

		$criteria->join = "JOIN rekonobatdischargedet_t det on det.rekonobatdischarge_id = t.rekonobatdischarge_id";

		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('t.pendaftaran_id = '.$this->pendaftaran_id);
		}

		if(!empty($this->pasienadmisi_id)){
			$criteria->addCondition('t.pasienadmisi_id = '.$this->pasienadmisi_id);
		}

		if(!empty($this->create_ruangan)){
			$criteria->addCondition('t.create_ruangan = '.$this->create_ruangan);
		}

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
