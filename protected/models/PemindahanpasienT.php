<?php

/**
 * This is the model class for table "pemindahanpasien_t".
 *
 * The followings are the available columns in table 'pemindahanpasien_t':
 * @property integer $pemindahanpasien_id
 * @property integer $pendaftaran_id
 * @property integer $pasienadmisi_id
 * @property integer $ruangantujuan_id
 * @property integer $ruanganasal_id
 * @property integer $instalasitujuan_id
 * @property string $jenispemindahan
 * @property string $tanggal_pemindahan
 * @property string $jam_pemindahan
 * @property integer $dokterperegawat_id
 * @property string $diagnosa
 * @property boolean $ispemberitahudiagnosa
 * @property string $prosedurinvasif
 * @property string $tanggal_prosedur
 * @property string $masalahkeperawatan
 * @property boolean $isriwayatalergi
 * @property string $riwayatreaksi
 * @property string $intervensimedik
 * @property string $investigasiabnormal
 * @property string $observasiterakhir
 * @property string $gcs_eye
 * @property string $gcs_verbal
 * @property string $gcs_motorik
 * @property string $reflekpupilkanan
 * @property string $reflekpupilkiri
 * @property string $pemindahan_bab
 * @property boolean $isbak
 * @property string $jeniskateter
 * @property integer $no_kateter
 * @property string $tglpemasangan_kateter
 * @property string $mobilisasi
 * @property string $transfermobilisasi
 * @property string $gangguanindra
 * @property string $alatabantudiapakai
 * @property string $tindakankebutuhan_khusus
 * @property string $halistimewa
 * @property boolean $islukaperawatan
 * @property string $kondisiperawatan
 * @property string $lokasiperawatan
 * @property integer $ukuranperawatan
 * @property boolean $isinfus
 * @property string $infuscvc
 * @property boolean $isvasscore
 * @property string $vasscore
 * @property string $tglpemasangan_perawatan
 * @property string $peralatanyangdigunakan
 * @property double $td_systolic
 * @property double $td_diastolic
 * @property double $suhutubuh
 * @property double $nadi
 * @property double $pernapasan
 * @property double $tandavital_spo2
 * @property integer $skala_wongbaker_nrs
 * @property string $konsultasi
 * @property string $rencanapemeriksaan
 * @property string $terapioral
 * @property string $terapiparental
 * @property string $fisioterapi_mobilisasi
 * @property string $rencanatindakan
 * @property string $kelengkapan_dokumen
 * @property boolean $ispasienditerima
 * @property string $tipedisetujui
 * @property integer $disetujui_oleh
 * @property string $tipepenerima
 * @property integer $perawatpenerima_id
 * @property integer $pegawai_mengetahui
 * @property string $tanggal_penerimaan
 * @property string $tipediserahkan
 * @property integer $perawatpengirim_id
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai
 * @property string $update_loginpemakai
 * @property integer $create_petugaspengisi_id
 * @property integer $create_ruangan_id
 *
 * The followings are the available model relations:
 * @property PendaftaranT $pendaftaran
 * @property PasienadmisiT $pasienadmisi
 * @property PegawaiM $dokterperegawat
 * @property DiagnosakeperawatanT[] $diagnosakeperawatanTs
 */
class PemindahanpasienT extends CActiveRecord
{
	public $ruanganasal_nama, $riwayat_ket, $nilai_gcs, $isalat1, $alat1_ket, $isalat2, $alat2_ket, $isalat3, $alat3_ket;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PemindahanpasienT the static model class
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
		return 'pemindahanpasien_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendaftaran_id, jenispemindahan, tanggal_pemindahan, jam_pemindahan, dokterperegawat_id, observasiterakhir, infuscvc, vasscore, tipedisetujui, disetujui_oleh, pegawai_mengetahui, tipediserahkan, perawatpengirim_id, create_time, create_loginpemakai', 'required'),
			array('pendaftaran_id, pasienadmisi_id, ruangantujuan_id, ruanganasal_id, instalasitujuan_id, dokterperegawat_id, no_kateter, ukuranperawatan, skala_wongbaker_nrs, perawatpenerima_id, pegawai_mengetahui, perawatpengirim_id, create_petugaspengisi_id, create_ruangan_id', 'numerical', 'integerOnly'=>true),
			array('td_systolic, td_diastolic, suhutubuh, nadi, pernapasan, tandavital_spo2', 'numerical'),
			array('jenispemindahan', 'length', 'max'=>20),
			array('prosedurinvasif, gcs_eye, gcs_verbal, gcs_motorik, reflekpupilkanan, reflekpupilkiri, peralatanyangdigunakan, konsultasi, rencanapemeriksaan, kewaspadaan', 'length', 'max'=>200),
			array('pemindahan_bab, jeniskateter, mobilisasi, transfermobilisasi, gangguanindra, alatabantudiapakai, tindakankebutuhan_khusus, kondisiperawatan, lokasiperawatan, infuscvc, vasscore, create_loginpemakai, update_loginpemakai, disetujui_oleh', 'length', 'max'=>100),
			array('tipedisetujui, tipepenerima, tipediserahkan, waktukeadaan, keadaanumum, kesadaran', 'length', 'max'=>50),
			array('diagnosa, ispemberitahudiagnosa, tanggal_prosedur, masalahkeperawatan, isriwayatalergi, riwayatreaksi, intervensimedik, investigasiabnormal, isbak, tglpemasangan_kateter, halistimewa, islukaperawatan, isinfus, isvasscore, tglpemasangan_perawatan, terapioral, terapiparental, fisioterapi_mobilisasi, rencanatindakan, kelengkapan_dokumen, ispasienditerima, update_time, catatan_penting', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pemindahanpasien_id, pendaftaran_id, pasienadmisi_id, ruangantujuan_id, ruanganasal_id, instalasitujuan_id, jenispemindahan, tanggal_pemindahan, jam_pemindahan, dokterperegawat_id, diagnosa, ispemberitahudiagnosa, prosedurinvasif, tanggal_prosedur, masalahkeperawatan, isriwayatalergi, riwayatreaksi, intervensimedik, investigasiabnormal, observasiterakhir, gcs_eye, gcs_verbal, gcs_motorik, reflekpupilkanan, reflekpupilkiri, pemindahan_bab, isbak, jeniskateter, no_kateter, tglpemasangan_kateter, mobilisasi, transfermobilisasi, gangguanindra, alatabantudiapakai, tindakankebutuhan_khusus, halistimewa, islukaperawatan, kondisiperawatan, lokasiperawatan, ukuranperawatan, isinfus, infuscvc, isvasscore, vasscore, tglpemasangan_perawatan, peralatanyangdigunakan, td_systolic, td_diastolic, suhutubuh, nadi, pernapasan, tandavital_spo2, skala_wongbaker_nrs, konsultasi, rencanapemeriksaan, terapioral, terapiparental, fisioterapi_mobilisasi, rencanatindakan, kelengkapan_dokumen, ispasienditerima, tipedisetujui, disetujui_oleh, tipepenerima, perawatpenerima_id, pegawai_mengetahui, tanggal_penerimaan, tipediserahkan, perawatpengirim_id, create_time, update_time, create_loginpemakai, update_loginpemakai, create_petugaspengisi_id, create_ruangan_id, kewaspadaan, waktukeadaan, keadaanumum, kesadaran, catatan_penting', 'safe', 'on'=>'search'),
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
			'pasienadmisi' => array(self::BELONGS_TO, 'PasienadmisiT', 'pasienadmisi_id'),
			'dokterperegawat' => array(self::BELONGS_TO, 'PegawaiM', 'dokterperegawat_id'),
			'diagnosakeperawatanTs' => array(self::HAS_MANY, 'DiagnosakeperawatanT', 'pemindahanpasien_id'),
			'ruanganasal' => array(self::BELONGS_TO, 'RuanganM', 'ruanganasal_id'),
			'ruangantujuan' => array(self::BELONGS_TO, 'RuanganM', 'ruangantujuan_id'),
			'instalasitujuan' => array(self::BELONGS_TO, 'InstalasiM', 'instalasitujuan_id'),
			'perawatpengirim' => array(self::BELONGS_TO, 'PegawaiM', 'perawatpengirim_id'),
			'pegawaimengetahui' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_mengetahui'),
			'perawatpenerima' => array(self::BELONGS_TO, 'PegawaiM', 'perawatpenerima_id'),

		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pemindahanpasien_id' => 'Pemindahanpasien',
			'pendaftaran_id' => 'Pendaftaran',
			'pasienadmisi_id' => 'Pasienadmisi',
			'ruangantujuan_id' => 'Ruangan Tujuan',
			'ruanganasal_id' => 'Ruangan Asal',
			'instalasitujuan_id' => 'Instalasi Tujuan',
			'jenispemindahan' => 'Jenis Pemindahan',
			'tanggal_pemindahan' => 'Tanggal Pemindahan',
			'jam_pemindahan' => 'Jam Pemindahan',
			'dokterperegawat_id' => 'Dokter yang merawat',
			'diagnosa' => 'Diagnosa Medis',
			'ispemberitahudiagnosa' => 'Pasien/keluarga sudah dijelaskan mengenai diagnosa',
			'prosedurinvasif' => 'Prosedur Invasif/ Pembedahan',
			'tanggal_prosedur' => 'Tanggal',
			'masalahkeperawatan' => 'Masalah Keperawatan',
			'isriwayatalergi' => 'Riwayat Alergi/ Riwayat Obat',
			'riwayatreaksi' => 'Riwayat Reaksi',
			'intervensimedik' => 'Intervensi Medik',
			'investigasiabnormal' => 'Hasil Inventigasi Abnormal',
			'observasiterakhir' => 'Observasi Terakhir pukul',
			'gcs_eye' => 'Gcs Eye',
			'gcs_verbal' => 'Gcs Verbal',
			'gcs_motorik' => 'Gcs Motorik',
			'reflekpupilkanan' => 'Kanan',
			'reflekpupilkiri' => 'Kiri',
			'pemindahan_bab' => 'Pemindahan Bab',
			'isbak' => 'BAK',
			'jeniskateter' => 'Jeniskateter',
			'no_kateter' => 'No Kateter',
			'tglpemasangan_kateter' => 'Tglpemasangan Kateter',
			'mobilisasi' => 'Mobilisasi',
			'transfermobilisasi' => 'Transfermobilisasi',
			'gangguanindra' => 'Gangguanindra',
			'alatabantudiapakai' => 'Alatabantudiapakai',
			'tindakankebutuhan_khusus' => 'Tindakankebutuhan Khusus',
			'halistimewa' => 'Halistimewa',
			'islukaperawatan' => 'Luka/ Perawatan Decubitus',
			'kondisiperawatan' => 'Kondisiperawatan',
			'lokasiperawatan' => 'Lokasiperawatan',
			'ukuranperawatan' => 'Ukuranperawatan',
			'isinfus' => 'Isinfus',
			'infuscvc' => 'Infuscvc',
			'isvasscore' => 'Isvasscore',
			'vasscore' => 'Vasscore',
			'tglpemasangan_perawatan' => 'Tglpemasangan Perawatan',
			'peralatanyangdigunakan' => 'Peralatanyangdigunakan',
			'td_systolic' => 'Td Systolic',
			'td_diastolic' => 'Td Diastolic',
			'suhutubuh' => 'Suhu',
			'nadi' => 'Nadi',
			'pernapasan' => 'Pernapasan',
			'tandavital_spo2' => 'Tandavital Spo2',
			'skala_wongbaker_nrs' => 'Skala Wongbaker Nrs',
			'konsultasi' => 'Konsultasi',
			'rencanapemeriksaan' => 'Rencanapemeriksaan',
			'terapioral' => 'Terapioral',
			'terapiparental' => 'Terapiparental',
			'fisioterapi_mobilisasi' => 'Fisioterapi Mobilisasi',
			'rencanatindakan' => 'Rencanatindakan',
			'kelengkapan_dokumen' => 'Kelengkapan Dokumen',
			'ispasienditerima' => 'Ispasienditerima',
			'tipedisetujui' => 'Tipedisetujui',
			'disetujui_oleh' => 'Disetujui Oleh',
			'tipepenerima' => 'Tipepenerima',
			'perawatpenerima_id' => 'Perawatpenerima',
			'pegawai_mengetahui' => 'Pegawai Mengetahui',
			'tanggal_penerimaan' => 'Tanggal Penerimaan',
			'tipediserahkan' => 'Tipediserahkan',
			'perawatpengirim_id' => 'Perawatpengirim',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai' => 'Create Loginpemakai',
			'update_loginpemakai' => 'Update Loginpemakai',
			'create_petugaspengisi_id' => 'Create Petugaspengisi',
			'create_ruangan_id' => 'Create Ruangan',
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

		$criteria->compare('pemindahanpasien_id',$this->pemindahanpasien_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('ruangantujuan_id',$this->ruangantujuan_id);
		$criteria->compare('ruanganasal_id',$this->ruanganasal_id);
		$criteria->compare('instalasitujuan_id',$this->instalasitujuan_id);
		$criteria->compare('jenispemindahan',$this->jenispemindahan,true);
		$criteria->compare('tanggal_pemindahan',$this->tanggal_pemindahan,true);
		$criteria->compare('jam_pemindahan',$this->jam_pemindahan,true);
		$criteria->compare('dokterperegawat_id',$this->dokterperegawat_id);
		$criteria->compare('diagnosa',$this->diagnosa,true);
		$criteria->compare('ispemberitahudiagnosa',$this->ispemberitahudiagnosa);
		$criteria->compare('prosedurinvasif',$this->prosedurinvasif,true);
		$criteria->compare('tanggal_prosedur',$this->tanggal_prosedur,true);
		$criteria->compare('masalahkeperawatan',$this->masalahkeperawatan,true);
		$criteria->compare('isriwayatalergi',$this->isriwayatalergi);
		$criteria->compare('riwayatreaksi',$this->riwayatreaksi,true);
		$criteria->compare('intervensimedik',$this->intervensimedik,true);
		$criteria->compare('investigasiabnormal',$this->investigasiabnormal,true);
		$criteria->compare('observasiterakhir',$this->observasiterakhir,true);
		$criteria->compare('gcs_eye',$this->gcs_eye,true);
		$criteria->compare('gcs_verbal',$this->gcs_verbal,true);
		$criteria->compare('gcs_motorik',$this->gcs_motorik,true);
		$criteria->compare('reflekpupilkanan',$this->reflekpupilkanan,true);
		$criteria->compare('reflekpupilkiri',$this->reflekpupilkiri,true);
		$criteria->compare('pemindahan_bab',$this->pemindahan_bab,true);
		$criteria->compare('isbak',$this->isbak);
		$criteria->compare('jeniskateter',$this->jeniskateter,true);
		$criteria->compare('no_kateter',$this->no_kateter);
		$criteria->compare('tglpemasangan_kateter',$this->tglpemasangan_kateter,true);
		$criteria->compare('mobilisasi',$this->mobilisasi,true);
		$criteria->compare('transfermobilisasi',$this->transfermobilisasi,true);
		$criteria->compare('gangguanindra',$this->gangguanindra,true);
		$criteria->compare('alatabantudiapakai',$this->alatabantudiapakai,true);
		$criteria->compare('tindakankebutuhan_khusus',$this->tindakankebutuhan_khusus,true);
		$criteria->compare('halistimewa',$this->halistimewa,true);
		$criteria->compare('islukaperawatan',$this->islukaperawatan);
		$criteria->compare('kondisiperawatan',$this->kondisiperawatan,true);
		$criteria->compare('lokasiperawatan',$this->lokasiperawatan,true);
		$criteria->compare('ukuranperawatan',$this->ukuranperawatan);
		$criteria->compare('isinfus',$this->isinfus);
		$criteria->compare('infuscvc',$this->infuscvc,true);
		$criteria->compare('isvasscore',$this->isvasscore);
		$criteria->compare('vasscore',$this->vasscore,true);
		$criteria->compare('tglpemasangan_perawatan',$this->tglpemasangan_perawatan,true);
		$criteria->compare('peralatanyangdigunakan',$this->peralatanyangdigunakan,true);
		$criteria->compare('td_systolic',$this->td_systolic);
		$criteria->compare('td_diastolic',$this->td_diastolic);
		$criteria->compare('suhutubuh',$this->suhutubuh);
		$criteria->compare('nadi',$this->nadi);
		$criteria->compare('pernapasan',$this->pernapasan);
		$criteria->compare('tandavital_spo2',$this->tandavital_spo2);
		$criteria->compare('skala_wongbaker_nrs',$this->skala_wongbaker_nrs);
		$criteria->compare('konsultasi',$this->konsultasi,true);
		$criteria->compare('rencanapemeriksaan',$this->rencanapemeriksaan,true);
		$criteria->compare('terapioral',$this->terapioral,true);
		$criteria->compare('terapiparental',$this->terapiparental,true);
		$criteria->compare('fisioterapi_mobilisasi',$this->fisioterapi_mobilisasi,true);
		$criteria->compare('rencanatindakan',$this->rencanatindakan,true);
		$criteria->compare('kelengkapan_dokumen',$this->kelengkapan_dokumen,true);
		$criteria->compare('ispasienditerima',$this->ispasienditerima);
		$criteria->compare('tipedisetujui',$this->tipedisetujui,true);
		$criteria->compare('disetujui_oleh',$this->disetujui_oleh);
		$criteria->compare('tipepenerima',$this->tipepenerima,true);
		$criteria->compare('perawatpenerima_id',$this->perawatpenerima_id);
		$criteria->compare('pegawai_mengetahui',$this->pegawai_mengetahui);
		$criteria->compare('tanggal_penerimaan',$this->tanggal_penerimaan,true);
		$criteria->compare('tipediserahkan',$this->tipediserahkan,true);
		$criteria->compare('perawatpengirim_id',$this->perawatpengirim_id);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai',$this->create_loginpemakai,true);
		$criteria->compare('update_loginpemakai',$this->update_loginpemakai,true);
		$criteria->compare('create_petugaspengisi_id',$this->create_petugaspengisi_id);
		$criteria->compare('create_ruangan_id',$this->create_ruangan_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchRiwayat()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}

		if(!empty($this->pasienadmisi_id)){
			$criteria->addCondition('pasienadmisi_id = '.$this->pasienadmisi_id);
		}

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
