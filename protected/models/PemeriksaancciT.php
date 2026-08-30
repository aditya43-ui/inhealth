<?php

/**
 * This is the model class for table "pemeriksaancci_t".
 *
 * The followings are the available columns in table 'pemeriksaancci_t':
 * @property integer $pemeriksaancci_id
 * @property integer $pegawai_id
 * @property integer $dpjp_id
 * @property integer $perawat_id
 * @property string $tgl_pemeriksaan
 * @property integer $daftartindakan_id
 * @property integer $tindakanpelayanan_id
 * @property integer $pasien_id
 * @property integer $pasienmasukpenunjang_id
 * @property integer $pasienadmisi_id
 * @property integer $pendaftaran_id
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property string $daftartindakan_nama
 * @property string $no_lab
 * @property string $sputum
 * @property string $swab_tenggorok
 * @property string $urine
 * @property string $swab_perineum
 * @property string $cci_lain
 * @property string $interprestasi
 * @property string $saran
 */
class PemeriksaancciT extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public $jenis_pemeriksaan;
	
	public function tableName()
	{
		return 'pemeriksaancci_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pegawai_id, pasienmasukpenunjang_id, pendaftaran_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pegawai_id, dpjp_id, perawat_id, daftartindakan_id, pasien_id, pasienmasukpenunjang_id, pasienadmisi_id, pendaftaran_id', 'numerical', 'integerOnly'=>true),
			array('no_lab', 'length', 'max'=>30),
			array('sputum, swab_tenggorok, urine, swab_perineum, interprestasi', 'length', 'max'=>100),
			array('cci_lain, saran', 'length', 'max'=>255),
			array('tgl_pemeriksaan, update_time, update_loginpemakai_id, daftartindakan_nama', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('pemeriksaancci_id, pegawai_id, dpjp_id, perawat_id, tgl_pemeriksaan, daftartindakan_id, tindakanpelayanan_id, pasien_id, pasienmasukpenunjang_id, pasienadmisi_id, pendaftaran_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, daftartindakan_nama, no_lab, sputum, swab_tenggorok, urine, swab_perineum, cci_lain, interprestasi, saran', 'safe', 'on'=>'search'),
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
			'tindakanpelayanan'=>array(self::BELONGS_TO, 'TindakanpelayananT','tindakanpelayanan_id'),
			'daftartindakan'=>array(self::BELONGS_TO, 'DaftartindakanM','daftartindakan_id'),
			'pegawai'=>array(self::BELONGS_TO, 'PegawaiM','pegawai_id'),
			'perawat'=>array(self::BELONGS_TO, 'PegawaiM','perawat_id'),
			'dpjp'=>array(self::BELONGS_TO, 'PegawaiM','dpjp_id'),
			'pasienmasukpenunjang'=>array(self::BELONGS_TO, 'PasienmasukpenunjangT','pasienmasukpenunjang_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pemeriksaancci_id' => 'Pemeriksaancci',
			'pegawai_id' => 'Pegawai',
			'dpjp_id' => 'Dpjp',
			'perawat_id' => 'Perawat',
			'tgl_pemeriksaan' => 'Tgl Pemeriksaan',
			'daftartindakan_id' => 'Daftartindakan',
			'tindakanpelayanan_id' => 'Tindakanpelayanan',
			'pasien_id' => 'Pasien',
			'pasienmasukpenunjang_id' => 'Pasienmasukpenunjang',
			'pasienadmisi_id' => 'Pasienadmisi',
			'pendaftaran_id' => 'Pendaftaran',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
			'daftartindakan_nama' => 'Daftartindakan Nama',
			'no_lab' => 'No Lab',
			'sputum' => 'Sputum',
			'swab_tenggorok' => 'Swab Tenggorok',
			'urine' => 'Urine',
			'swab_perineum' => 'Swab Perineum',
			'cci_lain' => 'Cci Lain',
			'interprestasi' => 'Interprestasi',
			'saran' => 'Saran',
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

		$criteria->compare('pemeriksaancci_id',$this->pemeriksaancci_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('dpjp_id',$this->dpjp_id);
		$criteria->compare('perawat_id',$this->perawat_id);
		$criteria->compare('tgl_pemeriksaan',$this->tgl_pemeriksaan,true);
		$criteria->compare('daftartindakan_id',$this->daftartindakan_id);
		$criteria->compare('tindakanpelayanan_id',$this->tindakanpelayanan_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pasienmasukpenunjang_id',$this->pasienmasukpenunjang_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id,true);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id,true);
		$criteria->compare('create_ruangan',$this->create_ruangan,true);
		$criteria->compare('daftartindakan_nama',$this->daftartindakan_nama,true);
		$criteria->compare('no_lab',$this->no_lab,true);
		$criteria->compare('sputum',$this->sputum,true);
		$criteria->compare('swab_tenggorok',$this->swab_tenggorok,true);
		$criteria->compare('urine',$this->urine,true);
		$criteria->compare('swab_perineum',$this->swab_perineum,true);
		$criteria->compare('cci_lain',$this->cci_lain,true);
		$criteria->compare('interprestasi',$this->interprestasi,true);
		$criteria->compare('saran',$this->saran,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PemeriksaancciT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
