<?php

/**
 * This is the model class for table "pelayananpembedahan_t".
 *
 * The followings are the available columns in table 'pelayananpembedahan_t':
 * @property integer $pelayananpembedahan_id
 * @property integer $pasien_id
 * @property integer $pendaftaran_id
 * @property integer $pasienadmisi_id
 * @property integer $pasienmasukpenunjang_id
 * @property string $tanggal
 * @property integer $perawat_id
 * @property integer $areaoperasi_id
 * @property integer $obatalkespasien_id
 * @property boolean $is_ceklispreoperasi
 * @property string $persiapandarah
 * @property integer $jeniskomponendarah_id
 * @property integer $gcs_eye_id
 * @property integer $gcs_verbal_id
 * @property integer $gcs_motorik_id
 * @property integer $tensi_sistolik
 * @property integer $tensi_diastolik
 * @property integer $nadi
 * @property double $suhu
 * @property integer $rr
 * @property boolean $is_cukur
 * @property boolean $is_kompresdisinfektan
 * @property boolean $is_katetermenetap
 * @property boolean $is_gigipalsu
 * @property boolean $is_dekubitus
 * @property string $dekubitus_keterangan
 * @property boolean $is_kontraktur
 * @property string $kontraktur_keterangan
 * @property boolean $is_fraktur
 * @property string $fraktur_keterangan
 * @property boolean $is_lukaluka
 * @property string $lukaluka_keterangan
 * @property boolean $is_tracheostomy
 * @property string $traccheostomy_keterangan
 * @property string $pipalambung
 * @property string $infusperifer
 * @property string $pipanaso
 * @property string $pipaendotracheal
 * @property string $posisi
 * @property string $torniket
 * @property integer $torniket_tekanan
 * @property string $jam_pasang
 * @property string $jam_lepas
 * @property boolean $is_diatermi_monopolar
 * @property boolean $is_diatermi_bipolar
 * @property boolean $is_diatermi_tangankanan
 * @property boolean $is_diatermi_tangankiri
 * @property boolean $is_diatermi_kakikanan
 * @property boolean $is_diatermi_kakikiri
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property AreaoperasiT $areaoperasi
 * @property JeniskomponendarahM $jeniskomponendarah
 * @property MetodegcsM $gcsEye
 * @property MetodegcsM $gcsMotorik
 * @property MetodegcsM $gcsVerbal
 * @property ObatalkespasienT $obatalkespasien
 * @property PasienM $pasien
 * @property PasienadmisiT $pasienadmisi
 * @property PasienmasukpenunjangT $pasienmasukpenunjang
 * @property PendaftaranT $pendaftaran
 * @property PegawaiM $perawat
 */
class PelayananpembedahanT extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public $rencanaoperasi_id, $ceklis_preoperasi, $jumlahdarah;
	public $waktu_operasi, $operator, $asisten_operator;
	public $dokter_anestesi, $perawat_anestesi, $perawat_sirkuler;
	public $lamanya, $kontras;
	public $alat_medis, $kamar_ruangan;
	public $image_intensifier, $foto;
        public $perawat_nama;
        public $setKruBedah;
        
	public function tableName()
	{
		return 'pelayananpembedahan_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasien_id, pendaftaran_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pasien_id, pendaftaran_id, pasienadmisi_id, pasienmasukpenunjang_id, perawat_id, areaoperasi_id, obatalkespasien_id, jeniskomponendarah_id, gcs_eye_id, gcs_verbal_id, gcs_motorik_id, tensi_sistolik, tensi_diastolik, nadi, rr, torniket_tekanan, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly' => true),
			array('suhu', 'numerical'),
			array('persiapandarah, dekubitus_keterangan, kontraktur_keterangan, fraktur_keterangan, lukaluka_keterangan, traccheostomy_keterangan, pipalambung, infusperifer, pipanaso, pipaendotracheal', 'length', 'max' => 100),
			array('posisi, torniket', 'length', 'max' => 50),
			array('tanggal, is_ceklispreoperasi, is_cukur, is_kompresdisinfektan, is_katetermenetap, is_gigipalsu, is_dekubitus, is_kontraktur, is_fraktur, is_lukaluka, is_tracheostomy, jam_pasang, jam_lepas, is_diatermi_monopolar, is_diatermi_bipolar, is_diatermi_tangankanan, is_diatermi_tangankiri, is_diatermi_kakikanan, is_diatermi_kakikiri, update_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('pelayananpembedahan_id, pasien_id, pendaftaran_id, pasienadmisi_id, pasienmasukpenunjang_id, tanggal, perawat_id, areaoperasi_id, obatalkespasien_id, is_ceklispreoperasi, persiapandarah, jeniskomponendarah_id, gcs_eye_id, gcs_verbal_id, gcs_motorik_id, tensi_sistolik, tensi_diastolik, nadi, suhu, rr, is_cukur, is_kompresdisinfektan, is_katetermenetap, is_gigipalsu, is_dekubitus, dekubitus_keterangan, is_kontraktur, kontraktur_keterangan, is_fraktur, fraktur_keterangan, is_lukaluka, lukaluka_keterangan, is_tracheostomy, traccheostomy_keterangan, pipalambung, infusperifer, pipanaso, pipaendotracheal, posisi, torniket, torniket_tekanan, jam_pasang, jam_lepas, is_diatermi_monopolar, is_diatermi_bipolar, is_diatermi_tangankanan, is_diatermi_tangankiri, is_diatermi_kakikanan, is_diatermi_kakikiri, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on' => 'search'),
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
			'areaoperasi' => array(self::BELONGS_TO, 'AreaoperasiT', 'areaoperasi_id'),
			'jeniskomponendarah' => array(self::BELONGS_TO, 'JeniskomponendarahM', 'jeniskomponendarah_id'),
			'gcsEye' => array(self::BELONGS_TO, 'MetodegcsM', 'gcs_eye_id'),
			'gcsMotorik' => array(self::BELONGS_TO, 'MetodegcsM', 'gcs_motorik_id'),
			'gcsVerbal' => array(self::BELONGS_TO, 'MetodegcsM', 'gcs_verbal_id'),
			'obatalkespasien' => array(self::BELONGS_TO, 'ObatalkespasienT', 'obatalkespasien_id'),
			'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
			'pasienadmisi' => array(self::BELONGS_TO, 'PasienadmisiT', 'pasienadmisi_id'),
			'pasienmasukpenunjang' => array(self::BELONGS_TO, 'PasienmasukpenunjangT', 'pasienmasukpenunjang_id'),
			'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
			'perawat' => array(self::BELONGS_TO, 'PegawaiM', 'perawat_id'),
			'pasienicd9cm' => array(self::BELONGS_TO, 'Pasienicd9cmT', 'pasienicd9cm_id'),
			'pasienkirimkeunitlain' => array(self::BELONGS_TO, 'PasienkirimkeunitlainT', 'pasienkirimkeunitlain_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pelayananpembedahan_id' => 'Pelayananpembedahan',
			'pasien_id' => 'Pasien',
			'pendaftaran_id' => 'Pendaftaran',
			'pasienadmisi_id' => 'Pasienadmisi',
			'pasienmasukpenunjang_id' => 'Pasienmasukpenunjang',
			'tanggal' => 'Tanggal',
			'perawat_id' => 'Perawat',
			'areaoperasi_id' => 'Areaoperasi',
			'obatalkespasien_id' => 'Obatalkespasien',
			'is_ceklispreoperasi' => 'Is Ceklispreoperasi',
			'persiapandarah' => 'Persiapan darah',
			'jeniskomponendarah_id' => 'Jenis darah',
			'gcs_eye_id' => 'GCS Eye',
			'gcs_verbal_id' => 'GCS Verbal',
			'gcs_motorik_id' => 'GCS Motorik',
			'tensi_sistolik' => 'Tensi Sistolik',
			'tensi_diastolik' => 'Tensi Diastolik',
			'nadi' => 'Nadi',
			'suhu' => 'Suhu',
			'rr' => 'Rr',
			'is_cukur' => 'Is Cukur',
			'is_kompresdisinfektan' => 'Is Kompresdisinfektan',
			'is_katetermenetap' => 'Is Katetermenetap',
			'is_gigipalsu' => 'Is Gigipalsu',
			'is_dekubitus' => 'Is Dekubitus',
			'dekubitus_keterangan' => 'Dekubitus Keterangan',
			'is_kontraktur' => 'Is Kontraktur',
			'kontraktur_keterangan' => 'Kontraktur Keterangan',
			'is_fraktur' => 'Is Fraktur',
			'fraktur_keterangan' => 'Fraktur Keterangan',
			'is_lukaluka' => 'Is Lukaluka',
			'lukaluka_keterangan' => 'Lukaluka Keterangan',
			'is_tracheostomy' => 'Is Tracheostomy',
			'traccheostomy_keterangan' => 'Traccheostomy Keterangan',
			'pipalambung' => 'Pipa Lambung',
			'infusperifer' => 'Infus Perifer',
			'pipanaso' => 'Pipa Naso',
			'pipaendotracheal' => 'Pipa Endotracheal',
			'posisi' => 'Posisi',
			'torniket' => 'Torniket',
			'torniket_tekanan' => 'Torniket Tekanan',
			'jam_pasang' => 'Jam Pasang',
			'jam_lepas' => 'Jam Lepas',
			'is_diatermi_monopolar' => 'Is Diatermi Monopolar',
			'is_diatermi_bipolar' => 'Is Diatermi Bipolar',
			'is_diatermi_tangankanan' => 'Is Diatermi Tangankanan',
			'is_diatermi_tangankiri' => 'Is Diatermi Tangankiri',
			'is_diatermi_kakikanan' => 'Is Diatermi Kakikanan',
			'is_diatermi_kakikiri' => 'Is Diatermi Kakikiri',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
			'rencanaoperasi_id' => 'Tindakan yang dilakukan',
			'jumlahdarah' => 'Jumlah darah'
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

		$criteria = new CDbCriteria;

		$criteria->compare('pelayananpembedahan_id', $this->pelayananpembedahan_id);
		$criteria->compare('pasien_id', $this->pasien_id);
		$criteria->compare('pendaftaran_id', $this->pendaftaran_id);
		$criteria->compare('pasienadmisi_id', $this->pasienadmisi_id);
		$criteria->compare('pasienmasukpenunjang_id', $this->pasienmasukpenunjang_id);
		$criteria->compare('tanggal', $this->tanggal, true);
		$criteria->compare('perawat_id', $this->perawat_id);
		$criteria->compare('areaoperasi_id', $this->areaoperasi_id);
		$criteria->compare('obatalkespasien_id', $this->obatalkespasien_id);
		$criteria->compare('is_ceklispreoperasi', $this->is_ceklispreoperasi);
		$criteria->compare('persiapandarah', $this->persiapandarah, true);
		$criteria->compare('jeniskomponendarah_id', $this->jeniskomponendarah_id);
		$criteria->compare('gcs_eye_id', $this->gcs_eye_id);
		$criteria->compare('gcs_verbal_id', $this->gcs_verbal_id);
		$criteria->compare('gcs_motorik_id', $this->gcs_motorik_id);
		$criteria->compare('tensi_sistolik', $this->tensi_sistolik);
		$criteria->compare('tensi_diastolik', $this->tensi_diastolik);
		$criteria->compare('nadi', $this->nadi);
		$criteria->compare('suhu', $this->suhu);
		$criteria->compare('rr', $this->rr);
		$criteria->compare('is_cukur', $this->is_cukur);
		$criteria->compare('is_kompresdisinfektan', $this->is_kompresdisinfektan);
		$criteria->compare('is_katetermenetap', $this->is_katetermenetap);
		$criteria->compare('is_gigipalsu', $this->is_gigipalsu);
		$criteria->compare('is_dekubitus', $this->is_dekubitus);
		$criteria->compare('dekubitus_keterangan', $this->dekubitus_keterangan, true);
		$criteria->compare('is_kontraktur', $this->is_kontraktur);
		$criteria->compare('kontraktur_keterangan', $this->kontraktur_keterangan, true);
		$criteria->compare('is_fraktur', $this->is_fraktur);
		$criteria->compare('fraktur_keterangan', $this->fraktur_keterangan, true);
		$criteria->compare('is_lukaluka', $this->is_lukaluka);
		$criteria->compare('lukaluka_keterangan', $this->lukaluka_keterangan, true);
		$criteria->compare('is_tracheostomy', $this->is_tracheostomy);
		$criteria->compare('traccheostomy_keterangan', $this->traccheostomy_keterangan, true);
		$criteria->compare('pipalambung', $this->pipalambung, true);
		$criteria->compare('infusperifer', $this->infusperifer, true);
		$criteria->compare('pipanaso', $this->pipanaso, true);
		$criteria->compare('pipaendotracheal', $this->pipaendotracheal, true);
		$criteria->compare('posisi', $this->posisi, true);
		$criteria->compare('torniket', $this->torniket, true);
		$criteria->compare('torniket_tekanan', $this->torniket_tekanan);
		$criteria->compare('jam_pasang', $this->jam_pasang, true);
		$criteria->compare('jam_lepas', $this->jam_lepas, true);
		$criteria->compare('is_diatermi_monopolar', $this->is_diatermi_monopolar);
		$criteria->compare('is_diatermi_bipolar', $this->is_diatermi_bipolar);
		$criteria->compare('is_diatermi_tangankanan', $this->is_diatermi_tangankanan);
		$criteria->compare('is_diatermi_tangankiri', $this->is_diatermi_tangankiri);
		$criteria->compare('is_diatermi_kakikanan', $this->is_diatermi_kakikanan);
		$criteria->compare('is_diatermi_kakikiri', $this->is_diatermi_kakikiri);
		$criteria->compare('create_time', $this->create_time, true);
		$criteria->compare('update_time', $this->update_time, true);
		$criteria->compare('create_loginpemakai_id', $this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id', $this->update_loginpemakai_id);
		$criteria->compare('create_ruangan', $this->create_ruangan);
        $criteria->compare('pasienicd9cm_id',$this->pasienicd9cm_id);
        $criteria->compare('pasienkirimkeunitlain_id',$this->pasienkirimkeunitlain_id);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PelayananpembedahanT the static model class
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	public function getPasienIcdItems($pendaftaran_id = null)
    {
		$criteria = new CDbCriteria();
		if (!empty($pendaftaran_id)) {
			$criteria->addCondition("pendaftaran_id = " . $pendaftaran_id);
		}
		
		$criteria->select = "t.*, CONCAT(diagnosaicdix_m.diagnosaicdix_kode,' - ',diagnosaicdix_m.diagnosaicdix_nama) as nama, diagnosaicdix_m.diagnosaicdix_kode, diagnosaicdix_m.diagnosaicdix_nama";
		$criteria->join = 'JOIN diagnosaicdix_m ON diagnosaicdix_m.diagnosaicdix_id = t.diagnosaicdix_id';
        $criteria->order = 'pasienicd9cm_id';

        $models = Pasienicd9cmT::model()->findAll($criteria);
		// echo '<pre>';var_dump('1', $models);die;
        return $models;
    }
}
