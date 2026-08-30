<?php

/**
 * This is the model class for table "pemeriksaanginekologi_t".
 *
 * The followings are the available columns in table 'pemeriksaanginekologi_t':
 * @property integer $pemeriksaanginekologi_id
 * @property string $tglperiksaobgyn
 * @property integer $pegawai_id
 * @property integer $pasien_id
 * @property integer $pendaftaran_id
 * @property integer $ppds_id
 * @property integer $pasienadmisi_id
 * @property string $gin_keluhan
 * @property integer $gin_jmlkawin_kali
 * @property string $gin_statuskawin
 * @property integer $gin_usiakawin_thn
 * @property string $gin_menarche_thn
 * @property integer $gin_siklushaid_hari
 * @property integer $gin_lamahaid_hari
 * @property string $gin_darahhaid
 * @property boolean $gin_darahhaid_tambahkurang
 * @property string $gin_nafsumakan
 * @property boolean $gin_nafsumakan_kurusgemuk
 * @property string $gin_mictio
 * @property string $gin_defecatio
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property PasienM $pasien
 * @property PasienadmisiT $pasienadmisi
 * @property PegawaiM $pegawai
 * @property PendaftaranT $pendaftaran
 */
class PemeriksaanginekologiT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PemeriksaanginekologiT the static model class
	 */
	public $tekanandarah, $periksadalam_pemeriksa_nama;
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'pemeriksaanginekologi_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tglperiksaobgyn, pegawai_id, pasien_id, pendaftaran_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pegawai_id, pasien_id, ppds_id, pendaftaran_id, pasienadmisi_id, gin_jmlkawin_kali, gin_usiakawin_thn, gin_siklushaid_hari, gin_lamahaid_hari, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, ruanganpoli_asalpasien, usia_menopause, td_systolic, td_diastolic, detaknadi, respiratoryrate, periksadalam_pemeriksa', 'numerical', 'integerOnly'=>true),
			array('map, suhutubuh', 'numerical'),
			array('gin_keluhan, gin_statuskawin, gin_menarche_thn, gin_darahhaid, gin_nafsumakan, gin_mictio, gin_defecatio, asal_pasien, polakeputihan_lama, polakeputihan_warna, edema_lokasi, periksadalam_vulva, periksadalam_vagina,skor_pelvis', 'length', 'max'=>100),
			array('ismenopause, polakeputihan_isberbau', 'length', 'max'=>10),
			array('statusumum, isedema', 'length', 'max'=>50),
			array('gin_darahhaid_tambahkurang, ppds_id, gin_nafsumakan_kurusgemuk, update_time, gin_tglpertamahaid, periksadalam_portio,periksadalam_adneksakanan, periksadalam_adneksakiri, periksadalam_cu, periksadalam_cd, periksadalam_inspeculo, periksadalam_rectaltoucher, statuslokalis_abdomen, rencanapengobatan_ginekologis, rencanapengobatan_medikamentosa, keterangan_tambahan, riwayatpengobatan_sebelumnya, polakeputihan_cairanvagina, cor, pulmo', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pemeriksaanginekologi_id, tglperiksaobgyn, ppds_id, pegawai_id, pasien_id, pendaftaran_id, pasienadmisi_id, gin_keluhan, gin_jmlkawin_kali, gin_statuskawin, gin_usiakawin_thn, gin_menarche_thn, gin_siklushaid_hari, gin_lamahaid_hari, gin_darahhaid, gin_darahhaid_tambahkurang, gin_nafsumakan, gin_nafsumakan_kurusgemuk, gin_mictio, gin_defecatio, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, gin_tglpertamahaid, asal_pasien, polakeputihan_lama, polakeputihan_warna, edema_lokasi, periksadalam_vulva, periksadalam_vagina,skor_pelvis, periksadalam_portio,periksadalam_adneksakanan, periksadalam_adneksakiri, periksadalam_cu, periksadalam_cd, periksadalam_inspeculo, periksadalam_rectaltoucher, statuslokalis_abdomen, rencanapengobatan_ginekologis, rencanapengobatan_medikamentosa, keterangan_tambahan, ruanganpoli_asalpasien, usia_menopause, td_systolic, td_diastolic, detaknadi, respiratoryrate, periksadalam_pemeriksa, riwayatpengobatan_sebelumnya, polakeputihan_cairanvagina, cor, pulmo, ismenopause, polakeputihan_isberbau, statusumum, isedema, map, suhutubuh', 'safe', 'on'=>'search'),
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
			'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
			'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
			'ppds'=> array(self::BELONGS_TO, 'PpdsM', 'ppds_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pemeriksaanginekologi_id' => 'ID',
			'tglperiksaobgyn' => 'Tanggal Pemeriksa',
			'pegawai_id' => 'Pemeriksa',
			'pasien_id' => 'Pasien',
			'ppds_id' => 'PPDS',
			'pendaftaran_id' => 'Pendaftaran',
			'pasienadmisi_id' => 'Pasienadmisi',
			'gin_keluhan' => 'Keluhan',
			'gin_jmlkawin_kali' => 'Jumlah Kawin',
			'gin_statuskawin' => 'Status Perkawinan',
			'gin_usiakawin_thn' => 'Usia Perkawinan',
			'gin_menarche_thn' => 'Menarche',
			'gin_siklushaid_hari' => 'Siklus Haid',
			'gin_lamahaid_hari' => 'Lama Haid',
			'gin_darahhaid' => 'Darah Haid',
			'gin_darahhaid_tambahkurang' => 'Gin Darahhaid Tambahkurang',
			'gin_nafsumakan' => 'Nafsu Makan',
			'gin_nafsumakan_kurusgemuk' => 'Gin Nafsumakan Kurusgemuk',
			'gin_mictio' => 'Mictio',
			'gin_defecatio' => 'Defecatio',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
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

		$criteria->compare('pemeriksaanginekologi_id',$this->pemeriksaanginekologi_id);
		$criteria->compare('tglperiksaobgyn',$this->tglperiksaobgyn,true);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('ppds_id',$this->ppds_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('gin_keluhan',$this->gin_keluhan,true);
		$criteria->compare('gin_jmlkawin_kali',$this->gin_jmlkawin_kali);
		$criteria->compare('gin_statuskawin',$this->gin_statuskawin,true);
		$criteria->compare('gin_usiakawin_thn',$this->gin_usiakawin_thn);
		$criteria->compare('gin_menarche_thn',$this->gin_menarche_thn,true);
		$criteria->compare('gin_siklushaid_hari',$this->gin_siklushaid_hari);
		$criteria->compare('gin_lamahaid_hari',$this->gin_lamahaid_hari);
		$criteria->compare('gin_darahhaid',$this->gin_darahhaid,true);
		$criteria->compare('gin_darahhaid_tambahkurang',$this->gin_darahhaid_tambahkurang);
		$criteria->compare('gin_nafsumakan',$this->gin_nafsumakan,true);
		$criteria->compare('gin_nafsumakan_kurusgemuk',$this->gin_nafsumakan_kurusgemuk);
		$criteria->compare('gin_mictio',$this->gin_mictio,true);
		$criteria->compare('gin_defecatio',$this->gin_defecatio,true);
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