<?php

/**
 * This is the model class for table "ringkasanmasukdankeluar_t".
 *
 * The followings are the available columns in table 'ringkasanmasukdankeluar_t':
 * @property integer $ringkasanmasukdankeluar_id
 * @property integer $pendaftaran_id
 * @property integer $pasienadmisi_id
 * @property integer $ruangan_id
 * @property string $diagnosamasuk
 * @property string $tanggal_penginputan
 * @property string $dokter_yangmerawat_id
 * @property string $carapenerimaan
 * @property string $caramasuk
 * @property string $komplikasi
 * @property string $patologi
 * @property string $infeksinosokomial
 * @property string $penyebabinfeksi
 * @property string $imunisasididapat
 * @property string $imunisasidirawatinap
 * @property string $pengobatanradioterapi
 * @property string $transfusidarah
 * @property string $golongandarah
 * @property integer $carakeluar_id
 * @property string $alergipasien
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai
 * @property string $update_loginpemakai
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property PasienadmisiT $pasienadmisi
 * @property PendaftaranT $pendaftaran
 * @property RuanganM $ruangan
 */
class RingkasanmasukdankeluarT extends CActiveRecord
{
	public $pekerjaan_nama, $pendidikan_nama, $alamat_pj, $nama_pj, $lamarawat, $diagnosa_masuk, $hubungankeluarga, $catatankeluar;
        public $dokter_yangmerawat_nama;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RingkasanmasukdankeluarT the static model class
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
		return 'ringkasanmasukdankeluar_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendaftaran_id, ruangan_id, tanggal_penginputan, dokter_yangmerawat_id, create_time, create_loginpemakai, create_ruangan', 'required'),
			array('pendaftaran_id, pasienadmisi_id, ruangan_id, carakeluar_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('dokter_yangmerawat_id, carapenerimaan, caramasuk, create_loginpemakai, update_loginpemakai', 'length', 'max'=>100),
			array('infeksinosokomial, penyebabinfeksi, transfusidarah, pemeriksaan_fisik, tandavitalkeluar,diagnosisprimer,terapiselamadirs,diagnosamasuk, komplikasi, patologi, imunisasidirawatinap, pengobatanradioterapi, alergipasien, update_time, imunisasididapat, tindakanyangdipilih', 'length', 'max'=>1500),
			array('golongandarah', 'length', 'max'=>50),
			array('diagnosamasuk, komplikasi, patologi, imunisasidirawatinap, pengobatanradioterapi, alergipasien, update_time, imunisasididapat, tindakanyangdipilih', 'safe'),
                        ['indikasiri, ringkasanriwayatpenyakit, keadaanumum, tandavital, td_systolic, td_diastolic, suhu, nadi, frekuensipernapasan, obatalkes_id, terapipulang, hasilkonsultasi, diagnosissekunder, icd10, icd9, diagnosasekunder, jumlah, pemeriksaanpenunjang, diet, instruksi, kondisiibadah, kondisipsiko, carakeluar, lainlain, tindakanjut, tglkontrol,tglkeluar, obatalkespulang_id','safe'],
                        ['pemeriksaanpennunjang_blm, kondisikeluar, dosispulang, jumlahpulang, frekuensipulang, sudahmendapatpenjelasan, akseslink','safe'],
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ringkasanmasukdankeluar_id, pendaftaran_id, pasienadmisi_id, ruangan_id, diagnosamasuk, tanggal_penginputan, dokter_yangmerawat_id, carapenerimaan, caramasuk, komplikasi, patologi, infeksinosokomial, penyebabinfeksi, imunisasididapat, imunisasidirawatinap, pengobatanradioterapi, transfusidarah, golongandarah, carakeluar_id, alergipasien, create_time, update_time, create_loginpemakai, update_loginpemakai, create_ruangan,tglkeluar,pemeriksaan_fisik, tandavitalkeluar,diagnosisprimer,terapiselamadirs', 'safe', 'on'=>'search'),
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
			'pasienadmisi' => array(self::BELONGS_TO, 'PasienadmisiT', 'pasienadmisi_id'),
			'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
			'ruangan' => array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
			'dokteryangmerawat' => array(self::BELONGS_TO, 'PegawaiM', 'dokter_yangmerawat_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
                    'ringkasanmasukdankeluar_id' => 'Ringkasanmasukdankeluar',
                    'pendaftaran_id' => 'Pendaftaran',
                    'pasienadmisi_id' => 'Pasienadmisi',
                    'ruangan_id' => 'Ruangan',
                    'diagnosamasuk' => 'Diagnosamasuk',
                    'tanggal_penginputan' => 'Tanggal Penginputan',
                    'dokter_yangmerawat_id' => 'Dokter yang Merawat',
                    'carapenerimaan' => 'Cara Penerimaan Melalui',
                    'caramasuk' => 'Cara Masuk dikirim Oleh',
                    'komplikasi' => 'Komplikasi',
                    'patologi' => 'Patologi',
                    'infeksinosokomial' => 'Infeksi Nosokomial',
                    'penyebabinfeksi' => 'Penyebab Infeksi',
                    'imunisasididapat' => 'Imunisasididapat',
                    'imunisasidirawatinap' => 'Imunisasidirawatinap',
                    'pengobatanradioterapi' => 'Pengobatanradioterapi',
                    'transfusidarah' => 'Transfusi Darah',
                    'golongandarah' => 'Golongan Darah',
                    'carakeluar_id' => 'Keadaan Keluar',
                    'alergipasien' => 'Alergi (reaksi obat)',
                    'create_time' => 'Create Time',
                    'update_time' => 'Update Time',
                    'create_loginpemakai' => 'Create Loginpemakai',
                    'update_loginpemakai' => 'Update Loginpemakai',
                    'create_ruangan' => 'Create Ruangan',
                    'indikasiri' => 'Indikasi Rawat Inap',
                    'ringkasanriwayatpenyakit' => 'Ringkasan Riwayat Penyakit',
                    'keadaanumum' => 'Keadaan Umum',
                    'tandavital' => 'Tanda Vital',
                    'frekuensipernapasan' => 'Frekuensi Napas',
                    'pemeriksaanpennunjang_blm' => 'Pemeriksaan penunjang (belum keluar hasil)',
                    'instruksi' => 'Instruksi/ Anjuran dan Edukasi',
					'tandavitalkeluar' => 'Tanda Vital Keluar',
					'diagnosisprimer' => 'Diagnosis Primer',
					'terapipulang' => 'Terapi Pulang',
					'tindakanyangdipilih' => 'Tindakan yang Dipilih',
					'diagnosissekunder' => 'Diagnosis Sekunder',
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

		$criteria->compare('ringkasanmasukdankeluar_id',$this->ringkasanmasukdankeluar_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('diagnosamasuk',$this->diagnosamasuk,true);
		$criteria->compare('tanggal_penginputan',$this->tanggal_penginputan,true);
		$criteria->compare('dokter_yangmerawat_id',$this->dokter_yangmerawat_id,true);
		$criteria->compare('carapenerimaan',$this->carapenerimaan,true);
		$criteria->compare('caramasuk',$this->caramasuk,true);
		$criteria->compare('komplikasi',$this->komplikasi,true);
		$criteria->compare('patologi',$this->patologi,true);
		$criteria->compare('infeksinosokomial',$this->infeksinosokomial,true);
		$criteria->compare('penyebabinfeksi',$this->penyebabinfeksi,true);
		$criteria->compare('imunisasididapat',$this->imunisasididapat,true);
		$criteria->compare('imunisasidirawatinap',$this->imunisasidirawatinap,true);
		$criteria->compare('pengobatanradioterapi',$this->pengobatanradioterapi,true);
		$criteria->compare('transfusidarah',$this->transfusidarah,true);
		$criteria->compare('golongandarah',$this->golongandarah,true);
		$criteria->compare('carakeluar_id',$this->carakeluar_id);
		$criteria->compare('alergipasien',$this->alergipasien,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai',$this->create_loginpemakai,true);
		$criteria->compare('update_loginpemakai',$this->update_loginpemakai,true);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
