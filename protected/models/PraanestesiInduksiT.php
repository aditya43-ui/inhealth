<?php

/**
 * This is the model class for table "praanestesi_induksi_t".
 *
 * The followings are the available columns in table 'praanestesi_induksi_t':
 * 
 * @package application.models 
 * @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link    <http://172.9.1.15/simpp/docs/>
 * @link    <http://piindonesia.co.id>
 * 
 * @property integer $praanestesi_induksi_id
 * @property integer $pendaftaran_id
 * @property integer $pasien_id
 * @property boolean $teknikinduksi_master_o2
 * @property string $teknikinduksi_master_o2_keterangan
 * @property boolean $teknikinduksi_nasal_o2
 * @property string $teknikinduksi_nasal_o2_keterangan
 * @property boolean $teknikinduksi_preoksigenasi
 * @property boolean $teknikinduksi_intravena
 * @property boolean $teknikinduksi_inhalasi
 * @property string $teknikinduksi_catatan
 * @property boolean $airway_masker
 * @property boolean $airway_sad
 * @property boolean $airway_sad_lma
 * @property boolean $airway_sad_igel
 * @property boolean $airway_sad_lainnya
 * @property string $airway_sad_lainnya_keterangan
 * @property string $airway_ukuran
 * @property string $airway_cuff
 * @property boolean $airway_intubasi
 * @property boolean $airway_intubasi_sleep
 * @property boolean $airway_intubasi_apnae
 * @property boolean $airway_intubasi_oral
 * @property boolean $airway_intubasi_direct
 * @property boolean $airway_intubasi_rsi
 * @property boolean $airway_intubasi_awake
 * @property boolean $airway_intubasi_non_apnae
 * @property boolean $airway_intubasi_nasal
 * @property boolean $airway_intubasi_blind
 * @property boolean $airway_intubasi_croidpres
 * @property boolean $alat_stylet
 * @property boolean $alat_magili
 * @property boolean $alat_laryscope
 * @property boolean $alat_videolaryngscope
 * @property boolean $jenis_alat_blade
 * @property boolean $jenis_alat_miler
 * @property boolean $jenis_alat_mcoy
 * @property boolean $jenis_alat_lainnya
 * @property string $jenis_alat_lainnya_keterangan
 * @property string $alat_ukuran
 * @property boolean $alat_fiberoptik
 * @property boolean $alat_bonfil
 * @property boolean $ett_regular
 * @property boolean $ett_reinforced
 * @property boolean $ett_preformed
 * @property boolean $ett_doublelumen
 * @property string $ett_ukuran
 * @property string $ett_cuff
 * @property boolean $ett_oral
 * @property boolean $ett_nasal
 * @property string $ett_upaya
 * @property boolean $ett_co2
 * @property boolean $ett_fixasi
 * @property integer $ett_fixasi_keterangan
 * @property boolean $ett_tampon
 * @property boolean $ett_ngtogt
 * @property string $lokasikateterarteri
 * @property boolean $posisi_induksi_supine
 * @property boolean $posisi_induksi_prone
 * @property boolean $posisi_induksi_tredelenburg
 * @property boolean $posisi_induksi_lithotomy
 * @property boolean $posisi_induksi_lateral
 * @property boolean $posisi_induksi_lainnya
 * @property boolean $posisi_induksi_lainnya_keterangan
 * @property integer $pasienanastesi_id
 * @property integer $pasienmasukpenunjang_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property PasienM $pasien
 * @property PendaftaranT $pendaftaran
 * @property PraanestesiInduksidetT[] $praanestesiInduksidetTs
 */
class PraanestesiInduksiT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PraanestesiInduksiT the static model class
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
		return 'praanestesi_induksi_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendaftaran_id, pasien_id, create_time, create_loginpemakai_id', 'required'),
			array('pendaftaran_id, pasien_id, ett_fixasi_keterangan, pasienanastesi_id, pasienmasukpenunjang_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('teknikinduksi_master_o2_keterangan, teknikinduksi_nasal_o2_keterangan, airway_ukuran, airway_cuff, alat_ukuran', 'length', 'max'=>50),
			array('teknikinduksi_catatan', 'length', 'max'=>250),
			array('airway_sad_lainnya_keterangan, jenis_alat_lainnya_keterangan, ett_ukuran, ett_cuff, ett_upaya, lokasikateterarteri', 'length', 'max'=>100),
			array('teknikinduksi_master_o2, teknikinduksi_nasal_o2, teknikinduksi_preoksigenasi, teknikinduksi_intravena, teknikinduksi_inhalasi, airway_masker, airway_sad, airway_sad_lma, airway_sad_igel, airway_sad_lainnya, airway_intubasi, airway_intubasi_sleep, airway_intubasi_apnae, airway_intubasi_oral, airway_intubasi_direct, airway_intubasi_rsi, airway_intubasi_awake, airway_intubasi_non_apnae, airway_intubasi_nasal, airway_intubasi_blind, airway_intubasi_croidpres, alat_stylet, alat_magili, alat_laryscope, alat_videolaryngscope, jenis_alat_blade, jenis_alat_miler, jenis_alat_mcoy, jenis_alat_lainnya, alat_fiberoptik, alat_bonfil, ett_regular, ett_reinforced, ett_preformed, ett_doublelumen, ett_oral, ett_nasal, ett_co2, ett_fixasi, ett_tampon, ett_ngtogt, posisi_induksi_supine, posisi_induksi_prone, posisi_induksi_tredelenburg, posisi_induksi_lithotomy, posisi_induksi_lateral, posisi_induksi_lainnya, posisi_induksi_lainnya_keterangan, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('praanestesi_induksi_id, pendaftaran_id, pasien_id, teknikinduksi_master_o2, teknikinduksi_master_o2_keterangan, teknikinduksi_nasal_o2, teknikinduksi_nasal_o2_keterangan, teknikinduksi_preoksigenasi, teknikinduksi_intravena, teknikinduksi_inhalasi, teknikinduksi_catatan, airway_masker, airway_sad, airway_sad_lma, airway_sad_igel, airway_sad_lainnya, airway_sad_lainnya_keterangan, airway_ukuran, airway_cuff, airway_intubasi, airway_intubasi_sleep, airway_intubasi_apnae, airway_intubasi_oral, airway_intubasi_direct, airway_intubasi_rsi, airway_intubasi_awake, airway_intubasi_non_apnae, airway_intubasi_nasal, airway_intubasi_blind, airway_intubasi_croidpres, alat_stylet, alat_magili, alat_laryscope, alat_videolaryngscope, jenis_alat_blade, jenis_alat_miler, jenis_alat_mcoy, jenis_alat_lainnya, jenis_alat_lainnya_keterangan, alat_ukuran, alat_fiberoptik, alat_bonfil, ett_regular, ett_reinforced, ett_preformed, ett_doublelumen, ett_ukuran, ett_cuff, ett_oral, ett_nasal, ett_upaya, ett_co2, ett_fixasi, ett_fixasi_keterangan, ett_tampon, ett_ngtogt, lokasikateterarteri, posisi_induksi_supine, posisi_induksi_prone, posisi_induksi_tredelenburg, posisi_induksi_lithotomy, posisi_induksi_lateral, posisi_induksi_lainnya, posisi_induksi_lainnya_keterangan, pasienanastesi_id, pasienmasukpenunjang_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
			'praanestesiInduksidetTs' => array(self::HAS_MANY, 'PraanestesiInduksidetT', 'praanestesi_induksi_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'praanestesi_induksi_id' => 'Praanestesi Induksi',
			'pendaftaran_id' => 'Pendaftaran',
			'pasien_id' => 'Pasien',
			'teknikinduksi_master_o2' => 'Teknikinduksi Master O2',
			'teknikinduksi_master_o2_keterangan' => 'Teknikinduksi Master O2 Keterangan',
			'teknikinduksi_nasal_o2' => 'Teknikinduksi Nasal O2',
			'teknikinduksi_nasal_o2_keterangan' => 'Teknikinduksi Nasal O2 Keterangan',
			'teknikinduksi_preoksigenasi' => 'Teknikinduksi Preoksigenasi',
			'teknikinduksi_intravena' => 'Teknikinduksi Intravena',
			'teknikinduksi_inhalasi' => 'Teknikinduksi Inhalasi',
			'teknikinduksi_catatan' => 'Teknikinduksi Catatan',
			'airway_masker' => 'Airway Masker',
			'airway_sad' => 'Airway Sad',
			'airway_sad_lma' => 'Airway Sad Lma',
			'airway_sad_igel' => 'Airway Sad Igel',
			'airway_sad_lainnya' => 'Airway Sad Lainnya',
			'airway_sad_lainnya_keterangan' => 'Airway Sad Lainnya Keterangan',
			'airway_ukuran' => 'Airway Ukuran',
			'airway_cuff' => 'Airway Cuff',
			'airway_intubasi' => 'Airway Intubasi',
			'airway_intubasi_sleep' => 'Airway Intubasi Sleep',
			'airway_intubasi_apnae' => 'Airway Intubasi Apnae',
			'airway_intubasi_oral' => 'Airway Intubasi Oral',
			'airway_intubasi_direct' => 'Airway Intubasi Direct',
			'airway_intubasi_rsi' => 'Airway Intubasi Rsi',
			'airway_intubasi_awake' => 'Airway Intubasi Awake',
			'airway_intubasi_non_apnae' => 'Airway Intubasi Non Apnae',
			'airway_intubasi_nasal' => 'Airway Intubasi Nasal',
			'airway_intubasi_blind' => 'Airway Intubasi Blind',
			'airway_intubasi_croidpres' => 'Airway Intubasi Croidpres',
			'alat_stylet' => 'Alat Stylet',
			'alat_magili' => 'Alat Magili',
			'alat_laryscope' => 'Alat Laryscope',
			'alat_videolaryngscope' => 'Alat Videolaryngscope',
			'jenis_alat_blade' => 'Jenis Alat Blade',
			'jenis_alat_miler' => 'Jenis Alat Miler',
			'jenis_alat_mcoy' => 'Jenis Alat Mcoy',
			'jenis_alat_lainnya' => 'Jenis Alat Lainnya',
			'jenis_alat_lainnya_keterangan' => 'Jenis Alat Lainnya Keterangan',
			'alat_ukuran' => 'Alat Ukuran',
			'alat_fiberoptik' => 'Alat Fiberoptik',
			'alat_bonfil' => 'Alat Bonfil',
			'ett_regular' => 'Ett Regular',
			'ett_reinforced' => 'Ett Reinforced',
			'ett_preformed' => 'Ett Preformed',
			'ett_doublelumen' => 'Ett Doublelumen',
			'ett_ukuran' => 'Ett Ukuran',
			'ett_cuff' => 'Ett Cuff',
			'ett_oral' => 'Ett Oral',
			'ett_nasal' => 'Ett Nasal',
			'ett_upaya' => 'Ett Upaya',
			'ett_co2' => 'Ett Co2',
			'ett_fixasi' => 'Ett Fixasi',
			'ett_fixasi_keterangan' => 'Ett Fixasi Keterangan',
			'ett_tampon' => 'Ett Tampon',
			'ett_ngtogt' => 'Ett Ngtogt',
			'lokasikateterarteri' => 'Lokasikateterarteri',
			'posisi_induksi_supine' => 'Posisi Induksi Supine',
			'posisi_induksi_prone' => 'Posisi Induksi Prone',
			'posisi_induksi_tredelenburg' => 'Posisi Induksi Tredelenburg',
			'posisi_induksi_lithotomy' => 'Posisi Induksi Lithotomy',
			'posisi_induksi_lateral' => 'Posisi Induksi Lateral',
			'posisi_induksi_lainnya' => 'Posisi Induksi Lainnya',
			'posisi_induksi_lainnya_keterangan' => 'Posisi Induksi Lainnya Keterangan',
			'pasienanastesi_id' => 'Pasienanastesi',
			'pasienmasukpenunjang_id' => 'Pasienmasukpenunjang',
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

		$criteria->compare('praanestesi_induksi_id',$this->praanestesi_induksi_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('teknikinduksi_master_o2',$this->teknikinduksi_master_o2);
		$criteria->compare('teknikinduksi_master_o2_keterangan',$this->teknikinduksi_master_o2_keterangan,true);
		$criteria->compare('teknikinduksi_nasal_o2',$this->teknikinduksi_nasal_o2);
		$criteria->compare('teknikinduksi_nasal_o2_keterangan',$this->teknikinduksi_nasal_o2_keterangan,true);
		$criteria->compare('teknikinduksi_preoksigenasi',$this->teknikinduksi_preoksigenasi);
		$criteria->compare('teknikinduksi_intravena',$this->teknikinduksi_intravena);
		$criteria->compare('teknikinduksi_inhalasi',$this->teknikinduksi_inhalasi);
		$criteria->compare('teknikinduksi_catatan',$this->teknikinduksi_catatan,true);
		$criteria->compare('airway_masker',$this->airway_masker);
		$criteria->compare('airway_sad',$this->airway_sad);
		$criteria->compare('airway_sad_lma',$this->airway_sad_lma);
		$criteria->compare('airway_sad_igel',$this->airway_sad_igel);
		$criteria->compare('airway_sad_lainnya',$this->airway_sad_lainnya);
		$criteria->compare('airway_sad_lainnya_keterangan',$this->airway_sad_lainnya_keterangan,true);
		$criteria->compare('airway_ukuran',$this->airway_ukuran,true);
		$criteria->compare('airway_cuff',$this->airway_cuff,true);
		$criteria->compare('airway_intubasi',$this->airway_intubasi);
		$criteria->compare('airway_intubasi_sleep',$this->airway_intubasi_sleep);
		$criteria->compare('airway_intubasi_apnae',$this->airway_intubasi_apnae);
		$criteria->compare('airway_intubasi_oral',$this->airway_intubasi_oral);
		$criteria->compare('airway_intubasi_direct',$this->airway_intubasi_direct);
		$criteria->compare('airway_intubasi_rsi',$this->airway_intubasi_rsi);
		$criteria->compare('airway_intubasi_awake',$this->airway_intubasi_awake);
		$criteria->compare('airway_intubasi_non_apnae',$this->airway_intubasi_non_apnae);
		$criteria->compare('airway_intubasi_nasal',$this->airway_intubasi_nasal);
		$criteria->compare('airway_intubasi_blind',$this->airway_intubasi_blind);
		$criteria->compare('airway_intubasi_croidpres',$this->airway_intubasi_croidpres);
		$criteria->compare('alat_stylet',$this->alat_stylet);
		$criteria->compare('alat_magili',$this->alat_magili);
		$criteria->compare('alat_laryscope',$this->alat_laryscope);
		$criteria->compare('alat_videolaryngscope',$this->alat_videolaryngscope);
		$criteria->compare('jenis_alat_blade',$this->jenis_alat_blade);
		$criteria->compare('jenis_alat_miler',$this->jenis_alat_miler);
		$criteria->compare('jenis_alat_mcoy',$this->jenis_alat_mcoy);
		$criteria->compare('jenis_alat_lainnya',$this->jenis_alat_lainnya);
		$criteria->compare('jenis_alat_lainnya_keterangan',$this->jenis_alat_lainnya_keterangan,true);
		$criteria->compare('alat_ukuran',$this->alat_ukuran,true);
		$criteria->compare('alat_fiberoptik',$this->alat_fiberoptik);
		$criteria->compare('alat_bonfil',$this->alat_bonfil);
		$criteria->compare('ett_regular',$this->ett_regular);
		$criteria->compare('ett_reinforced',$this->ett_reinforced);
		$criteria->compare('ett_preformed',$this->ett_preformed);
		$criteria->compare('ett_doublelumen',$this->ett_doublelumen);
		$criteria->compare('ett_ukuran',$this->ett_ukuran,true);
		$criteria->compare('ett_cuff',$this->ett_cuff,true);
		$criteria->compare('ett_oral',$this->ett_oral);
		$criteria->compare('ett_nasal',$this->ett_nasal);
		$criteria->compare('ett_upaya',$this->ett_upaya,true);
		$criteria->compare('ett_co2',$this->ett_co2);
		$criteria->compare('ett_fixasi',$this->ett_fixasi);
		$criteria->compare('ett_fixasi_keterangan',$this->ett_fixasi_keterangan);
		$criteria->compare('ett_tampon',$this->ett_tampon);
		$criteria->compare('ett_ngtogt',$this->ett_ngtogt);
		$criteria->compare('lokasikateterarteri',$this->lokasikateterarteri,true);
		$criteria->compare('posisi_induksi_supine',$this->posisi_induksi_supine);
		$criteria->compare('posisi_induksi_prone',$this->posisi_induksi_prone);
		$criteria->compare('posisi_induksi_tredelenburg',$this->posisi_induksi_tredelenburg);
		$criteria->compare('posisi_induksi_lithotomy',$this->posisi_induksi_lithotomy);
		$criteria->compare('posisi_induksi_lateral',$this->posisi_induksi_lateral);
		$criteria->compare('posisi_induksi_lainnya',$this->posisi_induksi_lainnya);
		$criteria->compare('posisi_induksi_lainnya_keterangan',$this->posisi_induksi_lainnya_keterangan);
		$criteria->compare('pasienanastesi_id',$this->pasienanastesi_id);
		$criteria->compare('pasienmasukpenunjang_id',$this->pasienmasukpenunjang_id);
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