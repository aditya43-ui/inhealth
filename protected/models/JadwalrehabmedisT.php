<?php

/**
 * This is the model class for table "jadwalrehabmedis_t".
 *
 * The followings are the available columns in table 'jadwalrehabmedis_t':
 * @property integer $jadwalrehabmedis_id
 * @property integer $gantijadwalrh_id
 * @property integer $shift_id
 * @property integer $pasien_id
 * @property integer $jadwalhari_id
 * @property integer $kamarruangan_id
 * @property integer $bataljadwalrh_id
 * @property integer $pegawai_id
 * @property integer $ruangan_id
 * @property integer $pendaftaran_id
 * @property integer $jadwalrehabmedis_ke
 * @property string $jadwalrehabmedis_tgl_ke
 * @property string $jadwalrehabmedis_hari
 * @property string $jadwalrehabmedis_remark
 * @property integer $jadwalrehabmedis_lama_pel_jam
 * @property boolean $jadwalrehabmedis_status
 * @property integer $membuat_id
 * @property integer $mengetahui_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 * @property string $create_iphost
 */
class JadwalrehabmedisT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JadwalrehabmedisT the static model class
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
		return 'jadwalrehabmedis_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasien_id, ruangan_id, membuat_id, mengetahui_id, create_time, create_loginpemakai_id, create_ruangan, create_iphost', 'required'), 
			array('slotbed_id, gantijadwalrh_id, pasien_id, jadwalhari_id, bataljadwalrh_id, pegawai_id, ruangan_id, pendaftaran_id, jadwalrehabmedis_ke, jadwalrehabmedis_lama_pel_jam, membuat_id, mengetahui_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, nourutjadwal, lamaterapikunjungan', 'numerical', 'integerOnly'=>true),
			array('jadwalrehabmedis_hari, nojadwal', 'length', 'max'=>20),
			array('jadwalrehabmedis_remark, create_iphost', 'length', 'max'=>100),
			array('update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('slotbed_id, jadwalrehabmedis_id, gantijadwalrh_id, pasien_id, jadwalhari_id, bataljadwalrh_id, pegawai_id, ruangan_id, pendaftaran_id, jadwalrehabmedis_ke, jadwalrehabmedis_tgl_ke, jadwalrehabmedis_hari, jadwalrehabmedis_remark, jadwalrehabmedis_lama_pel_jam, jadwalrehabmedis_status, membuat_id, mengetahui_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, create_iphost, nourutjadwal, nojadwal, statusterapi, lamaterapikunjungan, paramedis1_id, paramedis2_id', 'safe', 'on'=>'search'), 
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
			'shift'=>array(self::BELONGS_TO, 'ShiftM','shift_id'),
			'slotbed_id'=>array(self::BELONGS_TO, 'SlotbedM','slotbed_id'),
			'pasienrl'=>array(self::BELONGS_TO, 'PasienM','pasien_id'),
			'ruanganrl'=>array(self::BELONGS_TO, 'RuanganM','ruangan_id'),
		);
	}
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'jadwalrehabmedis_id' => 'Jadwalrehabmedis',
			'gantijadwalrh_id' => 'Gantijadwalrh',
			// 'shift_id' => 'Shift',
			'slotbed_id' => 'Slot Bed',
			'pasien_id' => 'Pasien',
			'jadwalhari_id' => 'Jadwalhari',
			'kamarruangan_id' => 'Kamarruangan',
			'bataljadwalrh_id' => 'Bataljadwalrh',
			'pegawai_id' => 'Pegawai',
			'ruangan_id' => 'Ruangan',
			'pendaftaran_id' => 'Pendaftaran',
			'jadwalrehabmedis_ke' => 'Jadwalrehabmedis Ke',
			'jadwalrehabmedis_tgl_ke' => 'Tanggal Jadwal',
			'jadwalrehabmedis_hari' => 'Jadwalrehabmedis Hari',
			'jadwalrehabmedis_remark' => 'Jadwalrehabmedis Remark',
			'jadwalrehabmedis_lama_pel_jam' => 'Jadwalrehabmedis Lama Pel Jam',
			'jadwalrehabmedis_status' => 'Jadwalrehabmedis Status',
			'membuat_id' => 'Membuat',
			'mengetahui_id' => 'Mengetahui',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'create_iphost' => 'Create Iphost',
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

		$criteria->compare('jadwalrehabmedis_id',$this->jadwalrehabmedis_id);
		$criteria->compare('gantijadwalrh_id',$this->gantijadwalrh_id);
		$criteria->compare('shift_id',$this->shift_id);
		$criteria->compare('slotbed_id',$this->slotbed_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('jadwalhari_id',$this->jadwalhari_id);
		$criteria->compare('kamarruangan_id',$this->kamarruangan_id);
		$criteria->compare('bataljadwalrh_id',$this->bataljadwalrh_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('jadwalrehabmedis_ke',$this->jadwalrehabmedis_ke);
		$criteria->compare('jadwalrehabmedis_tgl_ke',$this->jadwalrehabmedis_tgl_ke,true);
		$criteria->compare('jadwalrehabmedis_hari',$this->jadwalrehabmedis_hari,true);
		$criteria->compare('jadwalrehabmedis_remark',$this->jadwalrehabmedis_remark,true);
		$criteria->compare('jadwalrehabmedis_lama_pel_jam',$this->jadwalrehabmedis_lama_pel_jam);
		$criteria->compare('jadwalrehabmedis_status',$this->jadwalrehabmedis_status);
		$criteria->compare('membuat_id',$this->membuat_id);
		$criteria->compare('mengetahui_id',$this->mengetahui_id);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);
		$criteria->compare('create_iphost',$this->create_iphost,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}