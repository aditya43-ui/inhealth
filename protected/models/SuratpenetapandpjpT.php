<?php

/**
 * This is the model class for table "suratpenetapandpjp_t".
 *
 * The followings are the available columns in table 'suratpenetapandpjp_t':
 * @property integer $suratperintahdpjp_id
 * @property integer $pasien_id
 * @property integer $pendaftaran_id
 * @property integer $penanggungjawab_id
 * @property string $nama_pj
 * @property string $tempatlahir_pj
 * @property string $tgllahir_pj
 * @property string $hubungankeluarga
 * @property integer $dokter_dpjp1
 * @property string $nama_depan
 * @property string $nama_pasien
 * @property string $tempat_lahir
 * @property string $tanggal_lahir
 * @property string $umur_pasien
 * @property string $jeniskelamin
 * @property string $alamat_pasien
 * @property string $tgl_masuk
 * @property string $no_rekam_medik
 * @property integer $kamarruangan_id
 * @property integer $kelaspelayanan_id
 * @property string $tgl_pendaftaran
 * @property string $kebutuhanprivasi
 * @property string $saksi_pasien
 * @property integer $petugasadmisi_id
 * @property string $kebutuhanrohani
 * @property string $permintaankhusus
 * @property string $permintaan_ruqyah
 * @property string $permintaan_terapidzikir
 * @property string $permintaan_terapitahajud
 * @property string $permintaan_talqin
 * @property string $permintaan_konsulkeagamaan
 * @property string $permintaan_pendampingannonmus
 * @property string $permintaan_pemulasaran
 * @property string $permintaan_pengantaran
 * @property string $permintaan_pengawetan
 * @property string $permintaan_mensholatkan
 * @property string $permintaan_lainnya
 *
 * The followings are the available model relations:
 * @property PendaftaranT $pendaftaran
 * @property KamarruanganM $kamarruangan
 * @property PenanggungjawabM $penanggungjawab
 * @property KelaspelayananM $kelaspelayanan
 * @property PegawaiM $petugasadmisi
 */
class SuratpenetapandpjpT extends CActiveRecord
{
        public $kelaspelayanan_nama, $kamarruangan_nama;
        public $petugasadmisi_nama;
        public $saksi_kebutuhanprivasi;
        public $dokter_dpjp1_nama;
        
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'suratpenetapandpjp_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('petugas_admisi, pasien_id, pendaftaran_id, penanggungjawab_id, tgllahir_pj, dokter_dpjp1, nama_pasien, tgl_masuk, no_rekam_medik, kamarruangan_id, kelaspelayanan_id, tgl_pendaftaran,  kebutuhanrohani', 'required'),
			array('pasien_id, pendaftaran_id, penanggungjawab_id, dokter_dpjp1, kamarruangan_id, kelaspelayanan_id', 'numerical', 'integerOnly'=>true),
			array('nama_pj, hubungankeluarga, nama_pasien', 'length', 'max'=>50),
			array('tempatlahir_pj, nama_depan, jeniskelamin', 'length', 'max'=>20),
			array('tempat_lahir', 'length', 'max'=>25),
			array('umur_pasien', 'length', 'max'=>30),
			array('no_rekam_medik', 'length', 'max'=>10),
			array('saksi_pasien, permintaankhusus, permintaan_ruqyah, permintaan_terapidzikir, permintaan_terapitahajud, permintaan_talqin, permintaan_konsulkeagamaan, permintaan_pendampingannonmus, permintaan_pemulasaran, permintaan_pengantaran, permintaan_pengawetan, permintaan_mensholatkan, permintaan_lainnya', 'length', 'max'=>100),
			array('tanggal_lahir, alamat_pasien, kebutuhanprivasi', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('suratperintahdpjp_id, pasien_id, pendaftaran_id, penanggungjawab_id, nama_pj, tempatlahir_pj, tgllahir_pj, hubungankeluarga, dokter_dpjp1, nama_depan, nama_pasien, tempat_lahir, tanggal_lahir, umur_pasien, jeniskelamin, alamat_pasien, tgl_masuk, no_rekam_medik, kamarruangan_id, kelaspelayanan_id, tgl_pendaftaran, kebutuhanprivasi, saksi_pasien,  kebutuhanrohani, permintaankhusus, permintaan_ruqyah, permintaan_terapidzikir, permintaan_terapitahajud, permintaan_talqin, permintaan_konsulkeagamaan, permintaan_pendampingannonmus, permintaan_pemulasaran, permintaan_pengantaran, permintaan_pengawetan, permintaan_mensholatkan, permintaan_lainnya', 'safe', 'on'=>'search'),
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
			'kamarruangan' => array(self::BELONGS_TO, 'KamarruanganM', 'kamarruangan_id'),
			'penanggungjawab' => array(self::BELONGS_TO, 'PenanggungjawabM', 'penanggungjawab_id'),
			'kelaspelayanan' => array(self::BELONGS_TO, 'KelaspelayananM', 'kelaspelayanan_id'),
                        'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'suratperintahdpjp_id' => 'Suratperintahdpjp',
			'pasien_id' => 'Pasien',
			'pendaftaran_id' => 'Pendaftaran',
			'penanggungjawab_id' => 'Penanggungjawab',
			'nama_pj' => 'Nama Pj',
			'tempatlahir_pj' => 'Tempatlahir Pj',
			'tgllahir_pj' => 'Tgllahir Pj',
			'hubungankeluarga' => 'Hubungankeluarga',
			'dokter_dpjp1' => 'Dokter Dpjp1',
			'nama_depan' => 'Nama Depan',
			'nama_pasien' => 'Nama Pasien',
			'tempat_lahir' => 'Tempat Lahir',
			'tanggal_lahir' => 'Tanggal Lahir',
			'umur_pasien' => 'Umur Pasien',
			'jeniskelamin' => 'Jeniskelamin',
			'alamat_pasien' => 'Alamat Pasien',
			'tgl_masuk' => 'Tgl Masuk',
			'no_rekam_medik' => 'No Rekam Medik',
			'kamarruangan_id' => 'Kamarruangan',
			'kelaspelayanan_id' => 'Kelaspelayanan',
			'tgl_pendaftaran' => 'Tgl Pendaftaran',
			'kebutuhanprivasi' => 'Kebutuhanprivasi',
			'saksi_pasien' => 'Saksi Pasien',
			'petugasadmisi_id' => 'Petugasadmisi',
			'kebutuhanrohani' => 'Kebutuhanrohani',
			'permintaankhusus' => 'Permintaankhusus',
			'permintaan_ruqyah' => 'Permintaan Ruqyah',
			'permintaan_terapidzikir' => 'Permintaan Terapidzikir',
			'permintaan_terapitahajud' => 'Permintaan Terapitahajud',
			'permintaan_talqin' => 'Permintaan Talqin',
			'permintaan_konsulkeagamaan' => 'Permintaan Konsulkeagamaan',
			'permintaan_pendampingannonmus' => 'Permintaan Pendampingannonmus',
			'permintaan_pemulasaran' => 'Permintaan Pemulasaran',
			'permintaan_pengantaran' => 'Permintaan Pengantaran',
			'permintaan_pengawetan' => 'Permintaan Pengawetan',
			'permintaan_mensholatkan' => 'Permintaan Mensholatkan',
			'permintaan_lainnya' => 'Permintaan Lainnya',
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

		$criteria->compare('suratperintahdpjp_id',$this->suratperintahdpjp_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('penanggungjawab_id',$this->penanggungjawab_id);
		$criteria->compare('nama_pj',$this->nama_pj,true);
		$criteria->compare('tempatlahir_pj',$this->tempatlahir_pj,true);
		$criteria->compare('tgllahir_pj',$this->tgllahir_pj,true);
		$criteria->compare('hubungankeluarga',$this->hubungankeluarga,true);
		$criteria->compare('dokter_dpjp1',$this->dokter_dpjp1);
		$criteria->compare('nama_depan',$this->nama_depan,true);
		$criteria->compare('nama_pasien',$this->nama_pasien,true);
		$criteria->compare('tempat_lahir',$this->tempat_lahir,true);
		$criteria->compare('tanggal_lahir',$this->tanggal_lahir,true);
		$criteria->compare('umur_pasien',$this->umur_pasien,true);
		$criteria->compare('jeniskelamin',$this->jeniskelamin,true);
		$criteria->compare('alamat_pasien',$this->alamat_pasien,true);
		$criteria->compare('tgl_masuk',$this->tgl_masuk,true);
		$criteria->compare('no_rekam_medik',$this->no_rekam_medik,true);
		$criteria->compare('kamarruangan_id',$this->kamarruangan_id);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('tgl_pendaftaran',$this->tgl_pendaftaran,true);
		$criteria->compare('kebutuhanprivasi',$this->kebutuhanprivasi,true);
		$criteria->compare('saksi_pasien',$this->saksi_pasien,true);
		$criteria->compare('petugasadmisi_id',$this->petugasadmisi_id);
		$criteria->compare('kebutuhanrohani',$this->kebutuhanrohani,true);
		$criteria->compare('permintaankhusus',$this->permintaankhusus,true);
		$criteria->compare('permintaan_ruqyah',$this->permintaan_ruqyah,true);
		$criteria->compare('permintaan_terapidzikir',$this->permintaan_terapidzikir,true);
		$criteria->compare('permintaan_terapitahajud',$this->permintaan_terapitahajud,true);
		$criteria->compare('permintaan_talqin',$this->permintaan_talqin,true);
		$criteria->compare('permintaan_konsulkeagamaan',$this->permintaan_konsulkeagamaan,true);
		$criteria->compare('permintaan_pendampingannonmus',$this->permintaan_pendampingannonmus,true);
		$criteria->compare('permintaan_pemulasaran',$this->permintaan_pemulasaran,true);
		$criteria->compare('permintaan_pengantaran',$this->permintaan_pengantaran,true);
		$criteria->compare('permintaan_pengawetan',$this->permintaan_pengawetan,true);
		$criteria->compare('permintaan_mensholatkan',$this->permintaan_mensholatkan,true);
		$criteria->compare('permintaan_lainnya',$this->permintaan_lainnya,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SuratpenetapandpjpT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public static function simpanData($model, $post){
            
            $format = new MyFormatter;
            $pesan = '';
            $ok = true;
            
            $model->attributes = $post;
            $model->petugas_admisi = !empty($model->petugas_admisi)?$model->petugas_admisi:'-';
            $model->tgllahir_pj = !empty($model->tgllahir_pj)?$format->formatDateTimeForDb($model->tgllahir_pj):null;
            $model->tanggal_lahir = !empty($model->tanggal_lahir)?$format->formatDateTimeForDb($model->tanggal_lahir):null;
            $model->tgl_masuk = !empty($model->tgl_masuk)?$format->formatDateTimeForDb($model->tgl_masuk):null;
            $model->tgl_pendaftaran = !empty($model->tgl_pendaftaran)?$format->formatDateTimeForDb($model->tgl_pendaftaran):null;
           
            $ok &= $model->save();
            
            if (!$ok){
                $pesan .= 'Data formulir penetapan dpjp gagal disimpan '.MyExceptionMessage::getErrorMessage($model);
            }
                        
            return [
                'model'=>$model,
                'pesan'=>$pesan,
                'sukses'=>$ok
            ];                        
        }
        
        public function loadInput(){
            $admisi = PasienadmisiT::model()->findByPk($this->pendaftaran->pasienadmisi_id);
            $this->kelaspelayanan_nama = $admisi->kelaspelayanan->kelaspelayanan_nama;
            
            $kamarruangan = KamarruanganM::model()->findByPk($admisi->kamarruangan_id);
            $this->kamarruangan_nama = !empty($admisi->kamarruangan_id)?$kamarruangan->kamarruangan_nokamar.' - '.$kamarruangan->kamarruangan_nobed:'-';
            $this->kelaspelayanan_nama = !empty($admisi->kelaspelayanan)?$admisi->kelaspelayanan->kelaspelayanan_nama:'';
            
            $suratpersetujuan = SuratpersetujuanumumT::model()->findByAttributes([
                'pendaftaran_id' => $admisi->pendaftaran_id 
            ]);
            $this->saksi_kebutuhanprivasi = !empty($suratpersetujuan)?$suratpersetujuan->saksi_pasien:'';;                        
        }
}
