<?php

/**
 * This is the model class for table "penggunaan_coolbox_t".
 * 
 * @author  Andyka Putra <andykaputra@.com>
 * @author Yusuf Putra Anugrah <yusufputra@.com>
 * @package application.models
 *
 * The followings are the available columns in table 'penggunaan_coolbox_t':
 * @property integer $penggunaan_coolbox_id
 * @property integer $ruangan_id
 * @property integer $pegawai_id
 * @property integer $coolboxdarah_id
 * @property string $tgl_penggunaan_coolbox
 * @property string $no_penggunaan_coolbox
 * @property integer $jumlah_icepack
 * @property string $jam_kosongtanpalistrik
 * @property double $suhu_kosongtanpalistrik
 * @property string $jam_kosongdenganlistrik
 * @property double $suhu_kosongdenganlistrik
 * @property string $jam_listrikdanicepack
 * @property double $suhu_listrikdanicepack
 * @property string $keterangan
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property RuanganM $ruangan
 * @property PegawaiM $pegawai
 * @property CoolboxdarahM $coolboxdarah
 */
class PenggunaanCoolboxT extends CActiveRecord
{      
        public $ukuran_coolbox, $jenis_kantong, $standar_suhu, $jam_monitoring, $pegawai_nama;
        public $coolboxdarah_nama;
        public $no_pendonor,$no_identitas,$nomorbarcode_utama,$nomorbarcode_sample,$gol_darah,$rhesus;        
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PenggunaanCoolboxT the static model class
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
		return 'penggunaan_coolbox_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('ruangan_id, pegawai_id, coolboxdarah_id, jumlah_icepack, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('suhu_kosongtanpalistrik, suhu_kosongdenganlistrik, suhu_listrikdanicepack', 'numerical'),
			array('no_penggunaan_coolbox', 'length', 'max'=>50),
			array('tgl_penggunaan_coolbox, jam_kosongtanpalistrik, jam_kosongdenganlistrik, jam_listrikdanicepack, keterangan, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('penggunaan_coolbox_id, ruangan_id, pegawai_id, coolboxdarah_id, tgl_penggunaan_coolbox, no_penggunaan_coolbox, jumlah_icepack, jam_kosongtanpalistrik, suhu_kosongtanpalistrik, jam_kosongdenganlistrik, suhu_kosongdenganlistrik, jam_listrikdanicepack, suhu_listrikdanicepack, keterangan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'ruangan' => array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
			'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
			'coolboxdarah' => array(self::BELONGS_TO, 'CoolboxdarahM', 'coolboxdarah_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'penggunaan_coolbox_id' => 'Penggunaan Coolbox',
			'ruangan_id' => 'Ruangan',
			'pegawai_id' => 'Pegawai',
			'coolboxdarah_id' => 'Coolboxdarah',
			'tgl_penggunaan_coolbox' => 'Tgl Penggunaan Coolbox',
			'no_penggunaan_coolbox' => 'No Penggunaan Coolbox',
			'jumlah_icepack' => 'Jumlah Icepack',
			'jam_kosongtanpalistrik' => 'Jam Kosongtanpalistrik',
			'suhu_kosongtanpalistrik' => 'Suhu Kosongtanpalistrik',
			'jam_kosongdenganlistrik' => 'Jam Kosongdenganlistrik',
			'suhu_kosongdenganlistrik' => 'Suhu Kosongdenganlistrik',
			'jam_listrikdanicepack' => 'Jam Listrikdanicepack',
			'suhu_listrikdanicepack' => 'Suhu Listrikdanicepack',
			'keterangan' => 'Keterangan',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
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

		$criteria->compare('penggunaan_coolbox_id',$this->penggunaan_coolbox_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('coolboxdarah_id',$this->coolboxdarah_id);
		$criteria->compare('tgl_penggunaan_coolbox',$this->tgl_penggunaan_coolbox,true);
		$criteria->compare('no_penggunaan_coolbox',$this->no_penggunaan_coolbox,true);
		$criteria->compare('jumlah_icepack',$this->jumlah_icepack);
		$criteria->compare('jam_kosongtanpalistrik',$this->jam_kosongtanpalistrik,true);
		$criteria->compare('suhu_kosongtanpalistrik',$this->suhu_kosongtanpalistrik);
		$criteria->compare('jam_kosongdenganlistrik',$this->jam_kosongdenganlistrik,true);
		$criteria->compare('suhu_kosongdenganlistrik',$this->suhu_kosongdenganlistrik);
		$criteria->compare('jam_listrikdanicepack',$this->jam_listrikdanicepack,true);
		$criteria->compare('suhu_listrikdanicepack',$this->suhu_listrikdanicepack);
		$criteria->compare('keterangan',$this->keterangan,true);
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