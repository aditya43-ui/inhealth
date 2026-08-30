<?php

/**
 * This is the model class for table "informasisepinternal_v".
 *
 * The followings are the available columns in table 'informasisepinternal_v':
 * @property integer $konsulpoli_id
 * @property integer $pendaftaran_id
 * @property integer $pasienadmisi_id
 * @property string $no_pendaftaran
 * @property integer $pasien_id
 * @property string $jenisidentitas
 * @property string $no_identitas_pasien
 * @property string $namadepan
 * @property string $nama_pasien
 * @property string $alias
 * @property string $jeniskelamin
 * @property string $tempat_lahir
 * @property string $tanggal_lahir
 * @property string $alamat_pasien
 * @property integer $rt
 * @property integer $rw
 * @property string $alamatemail
 * @property string $no_rekam_medik
 * @property integer $carabayar_id
 * @property string $carabayar_nama
 * @property string $penjamin_nama
 * @property integer $seputama_id
 * @property integer $ruangantujuan_id
 * @property string $ruangantujuan_nama
 * @property string $kodebpjs_ruangantujuan
 * @property integer $instalasitujuan_id
 * @property string $instalasitujuan_nama
 * @property string $tglkonsulpoli
 * @property integer $pegawai_id
 * @property string $kodedokter_bpjs
 * @property string $gelardepan
 * @property string $nama_pegawai
 * @property string $gelarbelakang_nama
 * @property integer $ruanganasal_id
 * @property string $ruanganasal_nama
 * @property string $kodebpjs_ruanganasal
 * @property string $tglsep_utama
 * @property string $nosep_utama
 * @property string $nokartuasuransi
 * @property string $tglrujukan_utama
 * @property string $norujukan_utama
 * @property string $ppkrujukan_utama
 * @property string $ppkpelayanan_utama
 * @property integer $jnspelayanan_utama
 * @property string $no_telpon_pesertautama
 * @property integer $sep_id
 * @property string $tglsep
 * @property string $nosep
 * @property string $tglrujukan
 * @property string $norujukan
 * @property string $ppkrujukan
 * @property string $ppkpelayanan
 * @property integer $jnspelayanan
 * @property string $catatansep
 * @property string $diagnosaawal
 * @property string $nama_diagnosaawal
 * @property string $politujuan
 * @property integer $klsrawat
 * @property string $no_telpon_peserta
 * @property integer $lakalantas
 * @property integer $penjamin_lakalantas
 * @property string $lokasi_lakalantas
 * @property integer $poli_eksekutif
 * @property integer $cob
 * @property string $nosurat_kontrolspri
 * @property string $kodedpjp_skdpkontrol
 * @property string $namadpjp_skdpkontrol
 * @property string $dpjpygmelayani_kode
 * @property string $dpjpygmelayani_nama
 * @property string $jenis_kunjungan
 * @property string $flag_procedure
 * @property string $kode_penunjang
 * @property string $asesmen_pelayanan
 * @property string $statuskecelakaan_kode
 * @property integer $penanggungjwb_naikkls_id
 * @property integer $print_ke
 * @property string $polirujukan
 * @property string $nosepref
 * @property string $nosurat_rujukaninternal
 * @property string $tglrujukinternal
 * @property integer $flaginternal
 * @property integer $opsikonsul
 * @property boolean $flagsep
 */
class InformasisepinternalV extends CActiveRecord
{
	public $tgl_awal, $tgl_akhir;
	public $tgl_awal_utama, $tgl_akhir_utama;
	public $is_sep;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'informasisepinternal_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('konsulpoli_id, pendaftaran_id, pasienadmisi_id, pasien_id, rt, rw, carabayar_id, seputama_id, ruangantujuan_id, instalasitujuan_id, pegawai_id, ruanganasal_id, jnspelayanan_utama, sep_id, jnspelayanan, klsrawat, lakalantas, penjamin_lakalantas, poli_eksekutif, cob, penanggungjwb_naikkls_id, print_ke, flaginternal, opsikonsul', 'numerical', 'integerOnly'=>true),
			array('no_pendaftaran, jenisidentitas, namadepan, jeniskelamin', 'length', 'max'=>20),
			array('no_identitas_pasien', 'length', 'max'=>30),
			array('nama_pasien, alias, carabayar_nama, penjamin_nama, ruangantujuan_nama, instalasitujuan_nama, kodedokter_bpjs, nama_pegawai, ruanganasal_nama, nokartuasuransi, norujukan_utama, ppkrujukan_utama, ppkpelayanan_utama, norujukan, ppkrujukan, ppkpelayanan, jenis_kunjungan, flag_procedure, kode_penunjang, asesmen_pelayanan, statuskecelakaan_kode', 'length', 'max'=>50),
			array('tempat_lahir', 'length', 'max'=>25),
			array('alamatemail, nosep_utama, nosep, politujuan, nosurat_kontrolspri, kodedpjp_skdpkontrol, namadpjp_skdpkontrol, polirujukan, nosepref, nosurat_rujukaninternal', 'length', 'max'=>100),
			array('no_rekam_medik, kodebpjs_ruangantujuan, gelardepan, kodebpjs_ruanganasal', 'length', 'max'=>10),
			array('gelarbelakang_nama, no_telpon_pesertautama, no_telpon_peserta', 'length', 'max'=>15),
			array('nama_diagnosaawal', 'length', 'max'=>500),
			array('lokasi_lakalantas', 'length', 'max'=>250),
			array('tgl_awal, tgl_akhir', 'safe'),
			array('tanggal_lahir, alamat_pasien, tglkonsulpoli, tglsep_utama, tglrujukan_utama, tglsep, tglrujukan, catatansep, diagnosaawal, dpjpygmelayani_kode, dpjpygmelayani_nama, tglrujukinternal, flagsep', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('konsulpoli_id, pendaftaran_id, pasienadmisi_id, no_pendaftaran, pasien_id, jenisidentitas, no_identitas_pasien, namadepan, nama_pasien, alias, jeniskelamin, tempat_lahir, tanggal_lahir, alamat_pasien, rt, rw, alamatemail, no_rekam_medik, carabayar_id, carabayar_nama, penjamin_nama, seputama_id, ruangantujuan_id, ruangantujuan_nama, kodebpjs_ruangantujuan, instalasitujuan_id, instalasitujuan_nama, tglkonsulpoli, pegawai_id, kodedokter_bpjs, gelardepan, nama_pegawai, gelarbelakang_nama, ruanganasal_id, ruanganasal_nama, kodebpjs_ruanganasal, tglsep_utama, nosep_utama, nokartuasuransi, tglrujukan_utama, norujukan_utama, ppkrujukan_utama, ppkpelayanan_utama, jnspelayanan_utama, no_telpon_pesertautama, sep_id, tglsep, nosep, tglrujukan, norujukan, ppkrujukan, ppkpelayanan, jnspelayanan, catatansep, diagnosaawal, nama_diagnosaawal, politujuan, klsrawat, no_telpon_peserta, lakalantas, penjamin_lakalantas, lokasi_lakalantas, poli_eksekutif, cob, nosurat_kontrolspri, kodedpjp_skdpkontrol, namadpjp_skdpkontrol, dpjpygmelayani_kode, dpjpygmelayani_nama, jenis_kunjungan, flag_procedure, kode_penunjang, asesmen_pelayanan, statuskecelakaan_kode, penanggungjwb_naikkls_id, print_ke, polirujukan, nosepref, nosurat_rujukaninternal, tglrujukinternal, flaginternal, opsikonsul, flagsep', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'konsulpoli_id' => 'Konsulpoli',
			'pendaftaran_id' => 'Pendaftaran',
			'pasienadmisi_id' => 'Pasienadmisi',
			'no_pendaftaran' => 'No Pendaftaran',
			'pasien_id' => 'Pasien',
			'jenisidentitas' => 'Jenisidentitas',
			'no_identitas_pasien' => 'No Identitas Pasien',
			'namadepan' => 'Namadepan',
			'nama_pasien' => 'Nama Pasien',
			'alias' => 'Alias',
			'jeniskelamin' => 'Jeniskelamin',
			'tempat_lahir' => 'Tempat Lahir',
			'tanggal_lahir' => 'Tanggal Lahir',
			'alamat_pasien' => 'Alamat Pasien',
			'rt' => 'Rt',
			'rw' => 'Rw',
			'alamatemail' => 'Alamatemail',
			'no_rekam_medik' => 'No Rekam Medik',
			'carabayar_id' => 'Carabayar',
			'carabayar_nama' => 'Carabayar Nama',
			'penjamin_nama' => 'Penjamin Nama',
			'seputama_id' => 'Seputama',
			'ruangantujuan_id' => 'Ruangantujuan',
			'ruangantujuan_nama' => 'Ruangantujuan Nama',
			'kodebpjs_ruangantujuan' => 'Kodebpjs Ruangantujuan',
			'instalasitujuan_id' => 'Instalasitujuan',
			'instalasitujuan_nama' => 'Instalasitujuan Nama',
			'tglkonsulpoli' => 'Tglkonsulpoli',
			'pegawai_id' => 'Pegawai',
			'kodedokter_bpjs' => 'Kodedokter Bpjs',
			'gelardepan' => 'Gelardepan',
			'nama_pegawai' => 'Nama Pegawai',
			'gelarbelakang_nama' => 'Gelarbelakang Nama',
			'ruanganasal_id' => 'Ruanganasal',
			'ruanganasal_nama' => 'Ruanganasal Nama',
			'kodebpjs_ruanganasal' => 'Kodebpjs Ruanganasal',
			'tglsep_utama' => 'Tglsep Utama',
			'nosep_utama' => 'Nosep Utama',
			'nokartuasuransi' => 'Nokartuasuransi',
			'tglrujukan_utama' => 'Tglrujukan Utama',
			'norujukan_utama' => 'Norujukan Utama',
			'ppkrujukan_utama' => 'Ppkrujukan Utama',
			'ppkpelayanan_utama' => 'Ppkpelayanan Utama',
			'jnspelayanan_utama' => 'Jnspelayanan Utama',
			'no_telpon_pesertautama' => 'No Telpon Pesertautama',
			'sep_id' => 'Sep',
			'tglsep' => 'Tanggal SEP',
			'nosep' => 'No. SEP',
			'tglrujukan' => 'Tglrujukan',
			'norujukan' => 'Norujukan',
			'ppkrujukan' => 'Ppkrujukan',
			'ppkpelayanan' => 'Ppkpelayanan',
			'jnspelayanan' => 'Jnspelayanan',
			'catatansep' => 'Catatansep',
			'diagnosaawal' => 'Diagnosaawal',
			'nama_diagnosaawal' => 'Nama Diagnosaawal',
			'politujuan' => 'Politujuan',
			'klsrawat' => 'Klsrawat',
			'no_telpon_peserta' => 'No Telpon Peserta',
			'lakalantas' => 'Lakalantas',
			'penjamin_lakalantas' => 'Penjamin Lakalantas',
			'lokasi_lakalantas' => 'Lokasi Lakalantas',
			'poli_eksekutif' => 'Poli Eksekutif',
			'cob' => 'Cob',
			'nosurat_kontrolspri' => 'Nosurat Kontrolspri',
			'kodedpjp_skdpkontrol' => 'Kodedpjp Skdpkontrol',
			'namadpjp_skdpkontrol' => 'Namadpjp Skdpkontrol',
			'dpjpygmelayani_kode' => 'Dpjpygmelayani Kode',
			'dpjpygmelayani_nama' => 'Dpjpygmelayani Nama',
			'jenis_kunjungan' => 'Jenis Kunjungan',
			'flag_procedure' => 'Flag Procedure',
			'kode_penunjang' => 'Kode Penunjang',
			'asesmen_pelayanan' => 'Asesmen Pelayanan',
			'statuskecelakaan_kode' => 'Statuskecelakaan Kode',
			'penanggungjwb_naikkls_id' => 'Penanggungjwb Naikkls',
			'print_ke' => 'Print Ke',
			'polirujukan' => 'Polirujukan',
			'nosepref' => 'Nosepref',
			'nosurat_rujukaninternal' => 'No. Rujukan Internal',
			'tglrujukinternal' => 'Tglrujukinternal',
			'flaginternal' => 'Flaginternal',
			'opsikonsul' => 'Opsikonsul',
			'flagsep' => 'Flagsep',
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

		if (!empty($this->tgl_awal) && !empty($this->tgl_akhir)) {
			$criteria->addBetweenCondition('tglkonsulpoli::date', $this->tgl_awal, $this->tgl_akhir);
		}

		if (!empty($this->tgl_awal_utama) && !empty($this->tgl_akhir_utama) && $this->is_sep == 1) {
			$criteria->addBetweenCondition('tglsep_utama::date', $this->tgl_awal_utama, $this->tgl_akhir_utama);
		}

		// var_dump($criteria); die;
		$criteria->compare('konsulpoli_id',$this->konsulpoli_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('lower(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('jenisidentitas',$this->jenisidentitas,true);
		$criteria->compare('no_identitas_pasien',$this->no_identitas_pasien,true);
		$criteria->compare('namadepan',$this->namadepan,true);
		$criteria->compare('lower(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('alias',$this->alias,true);
		$criteria->compare('jeniskelamin',$this->jeniskelamin,true);
		$criteria->compare('tempat_lahir',$this->tempat_lahir,true);
		$criteria->compare('tanggal_lahir',$this->tanggal_lahir,true);
		$criteria->compare('alamat_pasien',$this->alamat_pasien,true);
		$criteria->compare('rt',$this->rt);
		$criteria->compare('rw',$this->rw);
		$criteria->compare('alamatemail',$this->alamatemail,true);
		$criteria->compare('lower(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('carabayar_nama',$this->carabayar_nama,true);
		$criteria->compare('penjamin_nama',$this->penjamin_nama,true);
		$criteria->compare('seputama_id',$this->seputama_id);
		$criteria->compare('ruangantujuan_id',$this->ruangantujuan_id);
		$criteria->compare('ruangantujuan_nama',$this->ruangantujuan_nama,true);
		$criteria->compare('kodebpjs_ruangantujuan',$this->kodebpjs_ruangantujuan,true);
		$criteria->compare('instalasitujuan_id',$this->instalasitujuan_id);
		$criteria->compare('instalasitujuan_nama',$this->instalasitujuan_nama,true);
		// $criteria->compare('tglkonsulpoli',$this->tglkonsulpoli,true);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('kodedokter_bpjs',$this->kodedokter_bpjs,true);
		$criteria->compare('gelardepan',$this->gelardepan,true);
		$criteria->compare('nama_pegawai',$this->nama_pegawai,true);
		$criteria->compare('gelarbelakang_nama',$this->gelarbelakang_nama,true);
		$criteria->compare('ruanganasal_id',$this->ruanganasal_id);
		$criteria->compare('ruanganasal_nama',$this->ruanganasal_nama,true);
		$criteria->compare('kodebpjs_ruanganasal',$this->kodebpjs_ruanganasal,true);
		$criteria->compare('tglsep_utama',$this->tglsep_utama,true);
		$criteria->compare('nosep_utama',$this->nosep_utama,true);
		$criteria->compare('nokartuasuransi',$this->nokartuasuransi,true);
		$criteria->compare('tglrujukan_utama',$this->tglrujukan_utama,true);
		$criteria->compare('norujukan_utama',$this->norujukan_utama,true);
		$criteria->compare('ppkrujukan_utama',$this->ppkrujukan_utama,true);
		$criteria->compare('ppkpelayanan_utama',$this->ppkpelayanan_utama,true);
		$criteria->compare('jnspelayanan_utama',$this->jnspelayanan_utama);
		$criteria->compare('no_telpon_pesertautama',$this->no_telpon_pesertautama,true);
		$criteria->compare('sep_id',$this->sep_id);
		$criteria->compare('tglsep',$this->tglsep,true);
		$criteria->compare('nosep',$this->nosep,true);
		$criteria->compare('tglrujukan',$this->tglrujukan,true);
		$criteria->compare('norujukan',$this->norujukan,true);
		$criteria->compare('ppkrujukan',$this->ppkrujukan,true);
		$criteria->compare('ppkpelayanan',$this->ppkpelayanan,true);
		$criteria->compare('jnspelayanan',$this->jnspelayanan);
		$criteria->compare('catatansep',$this->catatansep,true);
		$criteria->compare('diagnosaawal',$this->diagnosaawal,true);
		$criteria->compare('nama_diagnosaawal',$this->nama_diagnosaawal,true);
		$criteria->compare('politujuan',$this->politujuan,true);
		$criteria->compare('klsrawat',$this->klsrawat);
		$criteria->compare('no_telpon_peserta',$this->no_telpon_peserta,true);
		$criteria->compare('lakalantas',$this->lakalantas);
		$criteria->compare('penjamin_lakalantas',$this->penjamin_lakalantas);
		$criteria->compare('lokasi_lakalantas',$this->lokasi_lakalantas,true);
		$criteria->compare('poli_eksekutif',$this->poli_eksekutif);
		$criteria->compare('cob',$this->cob);
		$criteria->compare('nosurat_kontrolspri',$this->nosurat_kontrolspri,true);
		$criteria->compare('kodedpjp_skdpkontrol',$this->kodedpjp_skdpkontrol,true);
		$criteria->compare('namadpjp_skdpkontrol',$this->namadpjp_skdpkontrol,true);
		$criteria->compare('dpjpygmelayani_kode',$this->dpjpygmelayani_kode,true);
		$criteria->compare('dpjpygmelayani_nama',$this->dpjpygmelayani_nama,true);
		$criteria->compare('jenis_kunjungan',$this->jenis_kunjungan,true);
		$criteria->compare('flag_procedure',$this->flag_procedure,true);
		$criteria->compare('kode_penunjang',$this->kode_penunjang,true);
		$criteria->compare('asesmen_pelayanan',$this->asesmen_pelayanan,true);
		$criteria->compare('statuskecelakaan_kode',$this->statuskecelakaan_kode,true);
		$criteria->compare('penanggungjwb_naikkls_id',$this->penanggungjwb_naikkls_id);
		$criteria->compare('print_ke',$this->print_ke);
		$criteria->compare('polirujukan',$this->polirujukan,true);
		$criteria->compare('nosepref',$this->nosepref,true);
		$criteria->compare('lower(nosurat_rujukaninternal)',strtolower($this->nosurat_rujukaninternal),true);
		$criteria->compare('tglrujukinternal',$this->tglrujukinternal,true);
		$criteria->compare('flaginternal',$this->flaginternal);
		$criteria->compare('opsikonsul',$this->opsikonsul);
		$criteria->compare('flagsep',$this->flagsep);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchPrint() {
		$prov = $this->search();
		$prov->pagination = false;

		return $prov;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return InformasisepinternalV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
