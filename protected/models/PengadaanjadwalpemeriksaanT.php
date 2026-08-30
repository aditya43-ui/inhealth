<?php

/**
 * This is the model class for table "pengadaanjadwalpemeriksaan_t".
 *
 * The followings are the available columns in table 'pengadaanjadwalpemeriksaan_t':
 * @property integer $pengadaanjadwalpemeriksaan_id
 * @property integer $suratperjanjiankerja_id
 * @property string $pengadaanjadwalpemeriksaan_tanggal
 * @property string $pengadaanjadwalpemeriksaan_nomor
 * @property string $tanggal_pemeriksaan
 * @property integer $supplier_id
 * @property string $pengadaanjadwalpemeriksaan_status
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 * 
 * @package models
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @author Aida Rahmawati<aidarahmawati@.com>
 * @version     2.0.0
 * @link    <http://172.9.1.15/simpp/docs/>
 * @link    <http://piindonesia.co.id>
 *
 * The followings are the available model relations:
 * @property PengadaanjadwalpemeriksaandetT[] $pengadaanjadwalpemeriksaandetTs
 * @property SuratperjanjiankerjaT $suratperjanjiankerja
 * @property SupplierM $supplier
 */
class PengadaanjadwalpemeriksaanT extends CActiveRecord
{
        public $nama_pekerjaan;
        public $default;
        public $nosuratperjanjiankerja; 
        public $nama_lemgkap;
        public $pegpemeriksa_id;
        public $pegpemeriksa_nama;
        public $nama_lengkap;
        
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PengadaanjadwalpemeriksaanT the static model class
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
		return 'pengadaanjadwalpemeriksaan_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pengadaanjadwalpemeriksaan_tanggal, pengadaanjadwalpemeriksaan_nomor, tanggal_pemeriksaan, supplier_id, create_time, create_loginpemakai_id', 'required'),
			array('suratperjanjiankerja_id, supplier_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('pengadaanjadwalpemeriksaan_nomor, pengadaanjadwalpemeriksaan_status', 'length', 'max'=>50),
			array('alasan_tolak, verifikasi_waktu, pegverifikasi_id, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pengadaanjadwalpemeriksaan_id, suratperjanjiankerja_id, pengadaanjadwalpemeriksaan_tanggal, pengadaanjadwalpemeriksaan_nomor, tanggal_pemeriksaan, supplier_id, pengadaanjadwalpemeriksaan_status, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'pengadaanjadwalpemeriksaandetTs' => array(self::HAS_MANY, 'PengadaanjadwalpemeriksaandetT', 'pengadaanjadwalpemeriksaan_id'),
			'suratperjanjiankerja' => array(self::BELONGS_TO, 'SuratperjanjiankerjaT', 'suratperjanjiankerja_id'),
			'supplier' => array(self::BELONGS_TO, 'SupplierM', 'supplier_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pengadaanjadwalpemeriksaan_id' => 'Pengadaanjadwalpemeriksaan',
			'suratperjanjiankerja_id' => 'Suratperjanjiankerja',
			'pengadaanjadwalpemeriksaan_tanggal' => 'Pengadaanjadwalpemeriksaan Tanggal',
			'pengadaanjadwalpemeriksaan_nomor' => 'Nomor Penjadwalan Pemeriksaan',
			'tanggal_pemeriksaan' => 'Tanggal Pemeriksaan',
			'supplier_id' => 'Supplier',
			'pengadaanjadwalpemeriksaan_status' => 'Pengadaanjadwalpemeriksaan Status',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
			'alasan_tolak' => 'Alasan Menolak',
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

		$criteria->compare('pengadaanjadwalpemeriksaan_id',$this->pengadaanjadwalpemeriksaan_id);
		$criteria->compare('suratperjanjiankerja_id',$this->suratperjanjiankerja_id);
		$criteria->compare('pengadaanjadwalpemeriksaan_tanggal',$this->pengadaanjadwalpemeriksaan_tanggal,true);
		$criteria->compare('pengadaanjadwalpemeriksaan_nomor',$this->pengadaanjadwalpemeriksaan_nomor,true);
		$criteria->compare('tanggal_pemeriksaan',$this->tanggal_pemeriksaan,true);
		$criteria->compare('supplier_id',$this->supplier_id);
		$criteria->compare('pengadaanjadwalpemeriksaan_status',$this->pengadaanjadwalpemeriksaan_status,true);
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