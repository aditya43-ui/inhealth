<?php

/**
 * This is the model class for table "tindakanpelayanan_t".
 *
 * The followings are the available columns in table 'tindakanpelayanan_t':
 * @property integer $tindakanpelayanan_id
 * @property integer $penjamin_id
 * @property integer $pasienadmisi_id
 * @property integer $pasien_id
 * @property integer $kelaspelayanan_id
 * @property integer $tipepaket_id
 * @property integer $instalasi_id
 * @property integer $pendaftaran_id
 * @property integer $shift_id
 * @property integer $pasienmasukpenunjang_id
 * @property integer $daftartindakan_id
 * @property integer $carabayar_id
 * @property integer $jeniskasuspenyakit_id
 * @property string $tgl_tindakan
 * @property double $tarif_tindakan
 * @property string $satuantindakan
 * @property string $qty_tindakan
 * @property boolean $cyto_tindakan
 * @property double $tarifcyto_tindakan
 * @property string $dokterpemeriksa1_id
 * @property string $dokterpemeriksa2_id
 * @property string $dokterpendamping_id
 * @property string $dokteranastesi_id
 * @property string $dokterdelegasi_id
 * @property string $bidan_id
 * @property string $suster_id
 * @property string $perawat_id
 * @property integer $kelastanggungan_id
 * @property double $discount_tindakan
 * @property double $subsidiasuransi_tindakan
 * @property double $subsidipemerintah_tindakan
 * @property double $subsisidirumahsakit_tindakan
 * @property double $iurbiaya_tindakan
 * @property string $tm
 *
 * @property string $kategoriTindakanNama
 * @property string $daftartindakanNama
 * @property double $jumlahTarif
 * @property double $persenCyto
 *
 * @property double $tarif_satuan
 * @property integer $rencanaoperasi_id
 * @property integer $hasilpemeriksaanpa_id
 * @property integer $hasilpemeriksaanrm_id
 * @property integer $konsulpoli_id
 * @property integer $hasilpemeriksaanrad_id
 * @property integer $detailhasilpemeriksaanlab_id
 *
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property integer $rencanatindakan_id
 */
class TindakanpelayananT extends CActiveRecord
{
	public $jumlahTarif;
	public $persenCyto;
	public $kategoriTindakanNama;
	public $daftartindakanNama;
	public $tgl_awal;
	public $tgl_akhir;
	public $total_biaya;
	public $jmlbayar_tindakan, $bayartindakan;
	public $jmlsisabayar_tindakan, $sisatindakan;
	public $no_pendaftaran, $nama_pasien, $alamat_pasien;
	public $Poliklinik;
	public $nama_pegawai;
	public $keltindakanid;
	public $supir_nama;
	public $perawat2_nama;
	public $jmlselisihbpjs, $iurbiaya_tindakan_temporary, $jmlbayar_iurtindakan;
    public $daftartindakan_nama, $is_verifikasi, $komponentarif_id, $harga_tariftindakan, $jenistindakanrm_id, $tindakanrm_id, $diambil, $dititip, $ppds_id;
	public $total_tarif;
	public $no_nota, $pendaftaran_id;
	public $is_setengah = false;
		
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TindakanpelayananT the static model class
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tindakanpelayanan_t';
	}
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('penjamin_id, pasien_id, kelaspelayanan_id, instalasi_id, pendaftaran_id, shift_id, daftartindakan_id, carabayar_id, jeniskasuspenyakit_id, tgl_tindakan, tarif_tindakan, satuantindakan, qty_tindakan, discount_tindakan, subsidiasuransi_tindakan, subsidipemerintah_tindakan, subsisidirumahsakit_tindakan, iurbiaya_tindakan', 'required'),
			array('penjamin_id, pasienadmisi_id, pasien_id, kelaspelayanan_id, tipepaket_id, instalasi_id, pendaftaran_id, shift_id, pasienmasukpenunjang_id, daftartindakan_id, carabayar_id, jeniskasuspenyakit_id, kelastanggungan_id,
                               dokterpemeriksa1_id, dokterpemeriksa2_id, dokterpendamping_id, dokteranastesi_id, dokterdelegasi_id, bidan_id, bidan2_id, suster_id, perawat_id,ppds1_id,ppds2_id,ppds3_id,ppds4_id,ppds5_id, rencanatindakan_id', 'numerical', 'integerOnly' => true),
			array('discount_tindakan, subsidiasuransi_tindakan, subsidipemerintah_tindakan, subsisidirumahsakit_tindakan, iurbiaya_tindakan', 'numerical'),
			array('satuantindakan', 'length', 'max' => 10),
			array('tm', 'length', 'max' => 2),
			array('masukkamar_id', 'safe'),
			array('cyto_tindakan, tarifcyto_tindakan,supir_id, ruangan_id, kategoriTindakanNama, daftartindakanNama, tarif_satuan, tarif_tindakan, persenCyto, jumlahTarif, dokterpemeriksa1_id, dokterpemeriksa2_id, dokterpendamping_id, dokteranastesi_id, dokterdelegasi_id, jeniskasuspenyakit_id, bidan_id, bidan2_id, suster_id, perawat_id, perawat2_id, bidan3_id, perawat3_id, keterangantindakan, okupasiterapi_id, terapiwicara_id, fisioterapi_id, tindakanluar_nama, dokter6_id, dokter7_id, dokter8_id, dokter9_id, dokter10_id', 'safe'),
			array('create_time', 'default', 'value' => date('Y-m-d H:i:s'), 'setOnEmpty' => false, 'on' => 'insert'),
			array('update_time', 'default', 'value' => date('Y-m-d H:i:s'), 'setOnEmpty' => false, 'on' => 'update,insert'),
			array('create_loginpemakai_id', 'default', 'value' => empty(Yii::app()->user) ? 1 : Yii::app()->user->id, 'on' => 'insert'),
			array('update_loginpemakai_id', 'default', 'value' => empty(Yii::app()->user) ? 1 : Yii::app()->user->id, 'on' => 'update,insert'),
			array('create_ruangan', 'default', 'value' => empty(Yii::app()->user) ? 1 : Yii::app()->user->getState('ruangan_id'), 'on' => 'insert'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tindakanpelayanan_id, Poliklinik, penjamin_id, pasienadmisi_id, pasien_id, kelaspelayanan_id, tipepaket_id, instalasi_id, pendaftaran_id, shift_id, pasienmasukpenunjang_id, daftartindakan_id, carabayar_id, jeniskasuspenyakit_id, tgl_tindakan, tarif_tindakan, satuantindakan, qty_tindakan, cyto_tindakan, tarifcyto_tindakan, dokterpemeriksa1_id, dokterpemeriksa2_id, dokterpendamping_id, dokteranastesi_id, dokterdelegasi_id, bidan_id, bidan2_id, suster_id, perawat_id, kelastanggungan_id, discount_tindakan, subsidiasuransi_tindakan, subsidipemerintah_tindakan, subsisidirumahsakit_tindakan, iurbiaya_tindakan, tm, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, keterangantindakan, rencanatindakan_id, okupasiterapi_id, terapiwicara_id, fisioterapi_id, tindakanluar_nama', 'safe', 'on' => 'search'),
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
			'daftartindakan' => array(self::BELONGS_TO, 'DaftartindakanM', 'daftartindakan_id'),
			'dokter1' => array(self::BELONGS_TO, 'PegawaiM', 'dokterpemeriksa1_id'),
			'dokter2' => array(self::BELONGS_TO, 'PegawaiM', 'dokterpemeriksa2_id'),
			'dokterPendamping' => array(self::BELONGS_TO, 'PegawaiM', 'dokterpendamping_id'),
			'dokterAnastesi' => array(self::BELONGS_TO, 'PegawaiM', 'dokteranastesi_id'),
			'dokterDelegasi' => array(self::BELONGS_TO, 'PegawaiM', 'dokterdelegasi_id'),
			'bidan' => array(self::BELONGS_TO, 'PegawaiM', 'bidan_id'),
			'bidan2' => array(self::BELONGS_TO, 'PegawaiM', 'bidan2_id'),
			'bidan3' => array(self::BELONGS_TO, 'PegawaiM', 'bidan3_id'),
			'suster' => array(self::BELONGS_TO, 'PegawaiM', 'suster_id'),
			'perawat' => array(self::BELONGS_TO, 'PegawaiM', 'perawat_id'),
			'perawat2' => array(self::BELONGS_TO, 'PegawaiM', 'perawat2_id'),
			'perawat3' => array(self::BELONGS_TO, 'PegawaiM', 'perawat3_id'),
			'supir' => array(self::BELONGS_TO, 'PegawaiM', 'supir_id'),
			'tipePaket' => array(self::BELONGS_TO, 'TipepaketM', 'tipepaket_id'),
			'tipepaket' => array(self::BELONGS_TO, 'TipepaketM', 'tipepaket_id'),
			'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
			'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
			'alatmedis' => array(self::BELONGS_TO, 'AlatmedisM', 'alatmedis_id'),
			'tindakansudahbayar' => array(self::BELONGS_TO, 'TindakansudahbayarT', 'tindakansudahbayar_id'),
			'hasilpemeriksaanrad' => array(self::BELONGS_TO, 'HasilpemeriksaanradT', 'hasilpemeriksaanrad_id'),
			'karcis' => array(self::BELONGS_TO, 'KarcisM', 'karcis_id'),
			'instalasi' => array(self::BELONGS_TO, 'InstalasiM', 'instalasi_id'),
			'ruangan' => array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
			'pasienmasukpenunjang' => array(self::HAS_MANY, 'PasienmasukpenunjangT', 'pasienmasukpenunjang_id'),
			'jeniskasuspenyakit' => array(self::BELONGS_TO, 'JeniskasuspenyakitM', 'jeniskasuspenyakit_id'),
			'detailhasilpemeriksaanlab' => array(self::BELONGS_TO, 'DetailhasilpemeriksaanlabT', 'detailhasilpemeriksaanlab_id'),
			'rencanatindakan' => array(self::BELONGS_TO, 'RencanatindakanT', 'rencanatindakan_id'),
			'carabayar' => array(self::BELONGS_TO, 'CarabayarM', 'carabayar_id'),
			'kelaspelayanan' => array(self::BELONGS_TO, 'KelaspelayananM', 'kelaspelayanan_id'),
			'penjamin' => array(self::BELONGS_TO, 'PenjaminpasienM', 'penjamin_id'),
			'samplelab' => array(self::BELONGS_TO, 'SamplelabM', 'samplelab_id'),
			'caraambilsampel' => array(self::BELONGS_TO, 'CaraambilsampelM', 'caraambilsampel_id'),
			'konsulpoli' => array(self::BELONGS_TO, 'KonsulpoliT', 'konsulpoli_id'),
			'pemeriksaanrad' => array(self::BELONGS_TO, 'PemeriksaanradM', 'pemeriksaanrad_id'),
			'pemeriksaanlab' => array(self::BELONGS_TO, 'PemeriksaanlabM', 'pemeriksaanlab_id'),
			'create_ruangan' => array(self::BELONGS_TO, 'RuanganM', 'create_ruangan'),
			'jenispemeriksaanlab' => array(self::BELONGS_TO, 'JenispemeriksaanlabM', 'jenispemeriksaanlab_id'),

		);
	}
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'tindakanpelayanan_id' => 'ID Tindakan Pelayanan',
			'penjamin_id' => 'Penjamin',
			'pasienadmisi_id' => 'Pasien Admisi',
			'pasien_id' => 'Pasien',
			'kelaspelayanan_id' => 'Kelas Pelayanan',
			'tipepaket_id' => 'Tipe Paket',
			'instalasi_id' => 'Instalasi',
			'pendaftaran_id' => 'Pendaftaran',
			'shift_id' => 'Shift',
			'pasienmasukpenunjang_id' => 'Pasien Masuk Penunjang',
			'daftartindakan_id' => 'Daftar Tindakan',
			'carabayar_id' => 'Jenis Penjamin',
			'jeniskasuspenyakit_id' => 'Kasus Penyakit',
			'tgl_tindakan' => 'Tanggal Tindakan',
			'tarif_tindakan' => 'Tarif',
			'satuantindakan' => 'Satuan',
			'qty_tindakan' => 'Jumlah',
			'cyto_tindakan' => 'Cyto',
			'tarifcyto_tindakan' => 'Tarifcyto',
			'dokterpemeriksa1_id' => 'Dokter Pemeriksa 1',
			'dokterpemeriksa2_id' => 'Dokter Pemeriksa 2',
			'dokterpendamping_id' => 'Dokter Pendamping',
			'dokteranastesi_id' => 'Dokter Anastesi',
			'dokterdelegasi_id' => 'Dokter Delegasi',
			'bidan_id' => 'Bidan',
			'bidan2_id' => 'Bidan 2',
			'ppds1_id'=>'PPDS 1',
			'ppds2_id'=>'PPDS 2',
			'ppds3_id'=>'PPDS 3',
			'ppds4_id'=>'PPDS 4',
			'ppds5_id'=>'PPDS 5',
	       	'suster_id' => 'Suster',
			'perawat_id' => 'Perawat',
			'perawat2_id' => 'Perawat 2',
			'kelastanggungan_id' => 'Kelas Tanggungan',
			'discount_tindakan' => 'Keringanan',
			'subsidiasuransi_tindakan' => 'Tanggungan Asuransi',
			'subsidipemerintah_tindakan' => 'Tanggungan Pemerintah',
			'subsisidirumahsakit_tindakan' => 'Tanggungan Rumah Sakit',
			'iurbiaya_tindakan' => 'Iur Biaya',
			'tm' => 'Tm',
			'jumlahTarif' => 'Jumlah Tarif',
			'persenCyto' => 'Persen Cyto',
			'kategoriTindakanNama' => 'Kategori Tindakan',
			'ruangan_id' => 'Ruangan',
			'hasilpemeriksaanrm_id' => 'Hasil Pemeriksaan',
			'konsulpoli_id' => 'Konsulpoli',
			'hasilpemeriksaanrad_id' => 'Hasil Pemeriksaan Rad',
			'detailhasilpemeriksaanlab_id' => 'Detail Hasil Pemeriksaan Lab',
			'rencanaoperasi_id' => 'Rencana Operasi',
			'hasilpemeriksaanpa_id' => 'Hasil Pemeriksaan Pa',
			'tarif_satuan' => 'Tarif Satuan',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'karcis_id' => 'Karcis',
			'keterangantindakan' => 'Keterangan Tindakan',
			'rencanatindakan_id' => 'Rencana Tindakan',
			'supir_id' => 'Supir',
			'okupasiterapi_id' => 'Okupasi Terapi',
			'terapiwicara_id' => 'Terapi Wicara',
			'fisioterapi_id' => 'Fisioterapi',
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
		$criteria = new CDbCriteria;
		$criteria->compare('tindakanpelayanan_id', $this->tindakanpelayanan_id);
		$criteria->compare('penjamin_id', $this->penjamin_id);
		$criteria->compare('pasienadmisi_id', $this->pasienadmisi_id);
		$criteria->compare('pasien_id', $this->pasien_id);
		$criteria->compare('kelaspelayanan_id', $this->kelaspelayanan_id);
		$criteria->compare('tipepaket_id', $this->tipepaket_id);
		$criteria->compare('instalasi_id', $this->instalasi_id);
		$criteria->compare('pendaftaran_id', $this->pendaftaran_id);
		$criteria->compare('shift_id', $this->shift_id);
		$criteria->compare('pasienmasukpenunjang_id', $this->pasienmasukpenunjang_id);
		$criteria->compare('daftartindakan_id', $this->daftartindakan_id);
		$criteria->compare('carabayar_id', $this->carabayar_id);
		$criteria->compare('jeniskasuspenyakit_id', $this->jeniskasuspenyakit_id);
		$criteria->compare('LOWER(tgl_tindakan)', strtolower($this->tgl_tindakan), true);
		$criteria->compare('tarif_tindakan', $this->tarif_tindakan);
		$criteria->compare('LOWER(satuantindakan)', strtolower($this->satuantindakan), true);
		$criteria->compare('LOWER(qty_tindakan)', strtolower($this->qty_tindakan), true);
		$criteria->compare('cyto_tindakan', $this->cyto_tindakan);
		$criteria->compare('tarifcyto_tindakan', $this->tarifcyto_tindakan);
		$criteria->compare('LOWER(dokterpemeriksa1_id)', strtolower($this->dokterpemeriksa1_id), true);
		$criteria->compare('LOWER(dokterpemeriksa2_id)', strtolower($this->dokterpemeriksa2_id), true);
		$criteria->compare('LOWER(dokterpendamping_id)', strtolower($this->dokterpendamping_id), true);
		$criteria->compare('LOWER(dokteranastesi_id)', strtolower($this->dokteranastesi_id), true);
		$criteria->compare('LOWER(dokterdelegasi_id)', strtolower($this->dokterdelegasi_id), true);
		$criteria->compare('LOWER(bidan_id)', strtolower($this->bidan_id), true);
		$criteria->compare('LOWER(suster_id)', strtolower($this->suster_id), true);
		$criteria->compare('LOWER(perawat_id)', strtolower($this->perawat_id), true);
		$criteria->compare('kelastanggungan_id', $this->kelastanggungan_id);
		$criteria->compare('discount_tindakan', $this->discount_tindakan);
		$criteria->compare('subsidiasuransi_tindakan', $this->subsidiasuransi_tindakan);
		$criteria->compare('subsidipemerintah_tindakan', $this->subsidipemerintah_tindakan);
		$criteria->compare('subsisidirumahsakit_tindakan', $this->subsisidirumahsakit_tindakan);
		$criteria->compare('iurbiaya_tindakan', $this->iurbiaya_tindakan);
		$criteria->compare('LOWER(tm)', strtolower($this->tm), true);
		$criteria->compare('LOWER(create_time)', strtolower($this->create_time), true);
		$criteria->compare('LOWER(update_time)', strtolower($this->update_time), true);
		$criteria->compare('LOWER(create_loginpemakai_id)', strtolower($this->create_loginpemakai_id), true);
		$criteria->compare('LOWER(update_loginpemakai_id)', strtolower($this->update_loginpemakai_id), true);
		$criteria->compare('LOWER(create_ruangan)', strtolower($this->create_ruangan), true);
		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}

	public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$criteria = new CDbCriteria;
		$criteria->compare('tindakanpelayanan_id', $this->tindakanpelayanan_id);
		$criteria->compare('penjamin_id', $this->penjamin_id);
		$criteria->compare('pasienadmisi_id', $this->pasienadmisi_id);
		$criteria->compare('pasien_id', $this->pasien_id);
		$criteria->compare('kelaspelayanan_id', $this->kelaspelayanan_id);
		$criteria->compare('tipepaket_id', $this->tipepaket_id);
		$criteria->compare('instalasi_id', $this->instalasi_id);
		$criteria->compare('pendaftaran_id', $this->pendaftaran_id);
		$criteria->compare('shift_id', $this->shift_id);
		$criteria->compare('pasienmasukpenunjang_id', $this->pasienmasukpenunjang_id);
		$criteria->compare('daftartindakan_id', $this->daftartindakan_id);
		$criteria->compare('carabayar_id', $this->carabayar_id);
		$criteria->compare('jeniskasuspenyakit_id', $this->jeniskasuspenyakit_id);
		$criteria->compare('LOWER(tgl_tindakan)', strtolower($this->tgl_tindakan), true);
		$criteria->compare('tarif_tindakan', $this->tarif_tindakan);
		$criteria->compare('LOWER(satuantindakan)', strtolower($this->satuantindakan), true);
		$criteria->compare('LOWER(qty_tindakan)', strtolower($this->qty_tindakan), true);
		$criteria->compare('cyto_tindakan', $this->cyto_tindakan);
		$criteria->compare('tarifcyto_tindakan', $this->tarifcyto_tindakan);
		$criteria->compare('LOWER(dokterpemeriksa1_id)', strtolower($this->dokterpemeriksa1_id), true);
		$criteria->compare('LOWER(dokterpemeriksa2_id)', strtolower($this->dokterpemeriksa2_id), true);
		$criteria->compare('LOWER(dokterpendamping_id)', strtolower($this->dokterpendamping_id), true);
		$criteria->compare('LOWER(dokteranastesi_id)', strtolower($this->dokteranastesi_id), true);
		$criteria->compare('LOWER(dokterdelegasi_id)', strtolower($this->dokterdelegasi_id), true);
		$criteria->compare('LOWER(bidan_id)', strtolower($this->bidan_id), true);
		$criteria->compare('LOWER(suster_id)', strtolower($this->suster_id), true);
		$criteria->compare('LOWER(perawat_id)', strtolower($this->perawat_id), true);
		$criteria->compare('kelastanggungan_id', $this->kelastanggungan_id);
		$criteria->compare('discount_tindakan', $this->discount_tindakan);
		$criteria->compare('subsidiasuransi_tindakan', $this->subsidiasuransi_tindakan);
		$criteria->compare('subsidipemerintah_tindakan', $this->subsidipemerintah_tindakan);
		$criteria->compare('subsisidirumahsakit_tindakan', $this->subsisidirumahsakit_tindakan);
		$criteria->compare('iurbiaya_tindakan', $this->iurbiaya_tindakan);
		$criteria->compare('LOWER(tm)', strtolower($this->tm), true);
		$criteria->compare('LOWER(create_time)', strtolower($this->create_time), true);
		$criteria->compare('LOWER(update_time)', strtolower($this->update_time), true);
		$criteria->compare('LOWER(create_loginpemakai_id)', strtolower($this->create_loginpemakai_id), true);
		$criteria->compare('LOWER(update_loginpemakai_id)', strtolower($this->update_loginpemakai_id), true);
		$criteria->compare('LOWER(create_ruangan)', strtolower($this->create_ruangan), true);
		// Klo limit lebih kecil dari nol itu berarti ga ada limit
		$criteria->limit = -1;
		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'pagination' => false,
		));
	}

	public function searchNoPelayanan()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$criteria = new CDbCriteria;

		$instalasi_ri = Params::grupInstalasiRIID();
		$col_daftar_search = "(case when 
			t.pasienadmisi_id is not null 
			or t.instalasi_id in (".implode(", ", $instalasi_ri).") 
			or (ad.pasienadmisi_id is not null and t.tgl_tindakan > ad.tgladmisi)
			then replace(p.no_pendaftaran, substring(p.no_pendaftaran, 1, 2), 'RI') else p.no_pendaftaran end)";
		
		$col_nota_search = "(case when t.nopelayanan is null then concat($col_daftar_search, '001')
		else concat($col_daftar_search, t.nopelayanan) end)";

        $criteria->select = "p.no_pendaftaran, t.nopelayanan, $col_nota_search as no_nota";
        $criteria->group = "p.no_pendaftaran, t.nopelayanan, t.pasienadmisi_id, t.instalasi_id, $col_daftar_search";
        $criteria->join = 'join pendaftaran_t p on t.pendaftaran_id = p.pendaftaran_id 
		left join pasienadmisi_t ad on ad.pasienadmisi_id = p.pasienadmisi_id
		LEFT join verifbataltindakan_t vt on vt.verifbataltindakan_id = t.verifbataltindakan_id';

        // $criteria->compare('LOWER(t.nopelayanan)', strtolower($_GET['term']), true);

		$criteria->compare("LOWER($col_nota_search)", strtolower($this->no_nota), true);
		$criteria->compare('p.pendaftaran_id', $this->pendaftaran_id);
		$criteria->compare('t.ruangan_id', $this->ruangan_id);
		$criteria->addCondition('vt.isverif is not true');
        $criteria->order = 'nopelayanan';

		// echo '<pre>'; var_dump($criteria); die; 


		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}

	public function searchNoPelayananAkomodasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$criteria = new CDbCriteria;

		$instalasi_ri = Params::grupInstalasiRIID();
		$col_daftar_search = "(case when 
			t.pasienadmisi_id is not null 
			or t.instalasi_id in (".implode(", ", $instalasi_ri).") 
			or (ad.pasienadmisi_id is not null and t.tgl_tindakan > ad.tgladmisi)
			then replace(p.no_pendaftaran, substring(p.no_pendaftaran, 1, 2), 'RI') else p.no_pendaftaran end)";
		
		$col_nota_search = "(case when t.nopelayanan is null then concat($col_daftar_search, '001')
		else concat($col_daftar_search, t.nopelayanan) end)";

        $criteria->select = "p.no_pendaftaran, t.nopelayanan, $col_nota_search as no_nota";
        $criteria->group = "p.no_pendaftaran, t.nopelayanan, t.pasienadmisi_id, $col_daftar_search";
        $criteria->join = 'join pendaftaran_t p on t.pendaftaran_id = p.pendaftaran_id 
		left join pasienadmisi_t ad on ad.pasienadmisi_id = p.pasienadmisi_id';

        // $criteria->compare('LOWER(t.nopelayanan)', strtolower($_GET['term']), true);

		$criteria->compare("LOWER($col_nota_search)", strtolower($this->no_nota), true);
		$criteria->compare('p.pendaftaran_id', $this->pendaftaran_id);

		$criteria->addCondition('t.masukkamar_id is not null');

        $criteria->order = 'nopelayanan';

		// echo '<pre>'; var_dump($criteria); die; 


		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}

	public function searchNoPelayananPenunjang()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$criteria = new CDbCriteria;

		$instalasi_ri = Params::grupInstalasiRIID();
		$col_daftar_search = "(case when 
			t.pasienadmisi_id is not null 
			or t.instalasi_id in (".implode(", ", $instalasi_ri).") 
			or (ad.pasienadmisi_id is not null and t.tgl_tindakan > ad.tgladmisi)
			then replace(p.no_pendaftaran, substring(p.no_pendaftaran, 1, 2), 'RI') else p.no_pendaftaran end)";
		
		$col_nota_search = "(case when t.nopelayanan is null then concat($col_daftar_search, '001')
		else concat($col_daftar_search, t.nopelayanan) end)";

        $criteria->select = "p.no_pendaftaran, t.nopelayanan, $col_nota_search as no_nota, t.pasienmasukpenunjang_id";
        $criteria->group = "p.no_pendaftaran, t.nopelayanan, t.pasienmasukpenunjang_id, $col_nota_search";
        $criteria->join = 'join pendaftaran_t p on t.pendaftaran_id = p.pendaftaran_id 
		left join pasienadmisi_t ad on ad.pasienadmisi_id = p.pasienadmisi_id';

        // $criteria->compare('LOWER(t.nopelayanan)', strtolower($_GET['term']), true);

		// $criteria->compare('LOWER(p.no_pendaftaran)', strtolower($this->no_nota), true);
		$criteria->compare("LOWER($col_nota_search)", strtolower($this->no_nota), true, 'OR');
		$criteria->compare('p.pendaftaran_id', $this->pendaftaran_id);
		$criteria->compare('t.ruangan_id', $this->ruangan_id);

        $criteria->order = 'nopelayanan';

		// echo '<pre>'; var_dump($criteria); die; 


		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}

	protected function beforeSave()
	{
		if (trim($this->dokterpemeriksa1_id == "")) $this->setAttribute('dokterpemeriksa1_id', null);
		if (trim($this->dokterpemeriksa2_id == "")) $this->setAttribute('dokterpemeriksa2_id', null);
		if (trim($this->ppds1_id == "")) $this->setAttribute('ppds1_id', null);
		if (trim($this->ppds2_id == "")) $this->setAttribute('ppds2_id', null);
		if (trim($this->ppds3_id == "")) $this->setAttribute('ppds3_id', null);
		if (trim($this->ppds4_id == "")) $this->setAttribute('ppds4_id', null);
		if (trim($this->ppds5_id == "")) $this->setAttribute('ppds5_id', null);
		if (trim($this->dokterpendamping_id == "")) $this->setAttribute('dokterpendamping_id', null);
		if (trim($this->dokteranastesi_id == "")) $this->setAttribute('dokteranastesi_id', null);
		if (trim($this->dokterdelegasi_id == "")) $this->setAttribute('dokterdelegasi_id', null);
		if (trim($this->bidan_id == "")) $this->setAttribute('bidan_id', null);
		if (trim($this->suster_id == "")) $this->setAttribute('suster_id', null);
		if (trim($this->perawat_id == "")) $this->setAttribute('perawat_id', null);
		return parent::beforeSave();
	}
	protected function afterSave()
	{
		parent::afterSave();
		$this->checkSudahbayar();
	}
	function checkSudahBayar()
	{
		$pendaftaran = PendaftaranT::model()->findByPk($this->pendaftaran_id);
		$adm = PasienadmisiT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran->pendaftaran_id));
		if ($this->cekTindakanOa()) {
			// echo $this->pendaftaran_id; die;
			PendaftaranT::model()->updateByPk($this->pendaftaran_id, array(
				'pembayaranpelayanan_id' => null,
			));
			if (!empty($adm)) {
				PasienadmisiT::model()->updateByPk($adm->pasienadmisi_id, array(
					'pembayaranpelayanan_id' => null,
				));
			}
		}
	}
	function cekTindakanOa()
	{
		$tindakan = self::model()->findAllByAttributes(array(
			'pendaftaran_id' => $this->pendaftaran_id,
		), array(
			'condition' => 'tindakansudahbayar_id is null',
		));
		$oa = ObatalkespasienT::model()->findAllByAttributes(array(
			'pendaftaran_id' => $this->pendaftaran_id,
		), array(
			'condition' => 'oasudahbayar_id is null',
		));
		return (count((array)$tindakan) + count((array)$oa)) > 0;
	}
	//        FUNGSI INI JANGAN DIGUNAKAN LAGI (BERLAKU DI SEMUA MODEL) KARENA SERING TERJADI ERROR KETIKA UPDATE
	//        protected function afterFind(){
	//            foreach($this->metadata->tableSchema->columns as $columnName => $column){
	//
	//                if (!strlen($this->$columnName)) continue;
	//
	//                if ($column->dbType == 'date'){
	//                        $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
	//                                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd'),'medium',null);
	//                }else if ($column->dbType == 'timestamp without time zone'){
	//                        $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
	//                                CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd hh:mm:ss','medium',null));
	//                }
	//            }
	//            return true;
	//        }
	protected function beforeValidate()
	{
		$format = new MyFormatter();
		foreach ($this->metadata->tableSchema->columns as $columnName => $column) {
			if ($column->dbType == 'date') {
				$this->$columnName = $format->formatDateTimeForDb($this->$columnName);
			} elseif ($column->dbType == 'timestamp without time zone') {
				$this->$columnName = $format->formatDateTimeForDb($this->$columnName);
			}
		}
		return parent::beforeValidate();
	}
	public function getTipePaketItems($carabayar_id = '', $penjamin_id = null)
	{
		if (!empty($carabayar_id)) {
			$tipePaket = TipepaketM::model()->findAllByAttributes(array('tipepaket_id' => (int)Params::TIPEPAKET_ID_NONPAKET));
			$cr = new CDbCriteria();
			$cr->compare('carabayar_id', $carabayar_id);
			$cr->compare('penjamin_id', $penjamin_id);
			$cr->addCondition('tipepaket_aktif = true and tipepaket_id <> ' . Params::TIPEPAKET_ID_NONPAKET);
			$cr->order = 'tipepaket_nama';
			$tipePaket = array_merge($tipePaket, TipepaketM::model()->findAll($cr));
			return $tipePaket;
		} else
			return TipepaketM::model()->findAllByAttributes(array('tipepaket_aktif' => true));
	}
	/**
	 * untuk menyimpan tindakankomponen_t
	 * RND-6249
	 * untuk function proses simpan seharusnya di controller (function ini pengecualian)
	 */
	public function saveTindakanKomponen()
	{
		$tindakankomponentersimpan = true;
		return $tindakankomponentersimpan;
	}
	/**
	 * menampilkan tarif satuan terupdate RND-7248
	 */
	public function getTarifSatuan()
	{
		$tarif_satuan = 0;
		//recheck tarif  menggunakan DAO agar lebih cepat
		$sql = "SELECT tariftindakan_m.*, daftartindakan_m.daftartindakan_nama
					FROM tariftindakan_m
					JOIN daftartindakan_m ON daftartindakan_m.daftartindakan_id = tariftindakan_m.daftartindakan_id
					JOIN jenistarifpenjamin_m ON jenistarifpenjamin_m.jenistarif_id = tariftindakan_m.jenistarif_id
					WHERE tariftindakan_m.komponentarif_id = " . Params::KOMPONENTARIF_ID_TOTAL . "
						AND tariftindakan_m.daftartindakan_id = " . $this->daftartindakan_id . "
						AND tariftindakan_m.kelaspelayanan_id = " . $this->kelaspelayanan_id . "
						AND jenistarifpenjamin_m.penjamin_id = " . $this->penjamin_id . "
					";
		$loadData = Yii::app()->db->createCommand($sql)->queryRow();
		if (isset($loadData['harga_tariftindakan'])) {
			$tarif_satuan = $loadData['harga_tariftindakan'];
		}
		return $tarif_satuan;
	}

	public function getKomponenTindakan()
	{
		//recheck tarif  menggunakan DAO agar lebih cepat
		$crit = new CDbCriteria;
		$crit->select = "kt.komponentarif_id, t.tarif_tindakan, t.daftartindakan_id, t.tindakanpelayanan_id";
		$crit->join = "JOIN daftartindakan_m dt on dt.daftartindakan_id = t.daftartindakan_id
						JOIN tariftindakan_m tt on tt.daftartindakan_id = dt.daftartindakan_id
						JOIN komponentarif_m kt on kt.komponentarif_id = tt.komponentarif_id";
		$crit->group = $crit->select;
						
		$crit->addCondition("t.tindakanpelayanan_id = $this->tindakanpelayanan_id and kt.komponentarif_id <> 6");
		// $crit->addCondition("tt.kelaspelayanan_id = $this->kelaspelayanan_id");


		$model = self::model()->findAll($crit);
		return $model;
	}

	public function getKomponenTindakanTotal()
	{
		//recheck tarif  menggunakan DAO agar lebih cepat
		$crit = new CDbCriteria;
		$crit->select = "kt.komponentarif_id, t.tarif_tindakan, t.daftartindakan_id, t.tindakanpelayanan_id";
		$crit->join = "JOIN daftartindakan_m dt on dt.daftartindakan_id = t.daftartindakan_id
						JOIN tariftindakan_m tt on tt.daftartindakan_id = dt.daftartindakan_id
						JOIN komponentarif_m kt on kt.komponentarif_id = tt.komponentarif_id";
		$crit->group = $crit->select;
						
		$crit->addCondition("t.tindakanpelayanan_id = $this->tindakanpelayanan_id and kt.komponentarif_id <> 6");
		// $crit->addCondition("tt.kelaspelayanan_id = $this->kelaspelayanan_id");


		$model = self::model()->find($crit);
		return $model;
	}


	/**
	 * @author Deni Hamdani <denihamdani@piindonesia.co.id>
	 *
	 * menampilkan nilai yang disubsidi, $attr:
	 * - subsidiasuransitind
	 * - subsidipemerintahtind
	 * - subsidirumahsakittind
	 */
	public function getSubsidiPenjamin($attr)
	{
		// Load data asuransi dari pendaftaran pasien.
		$modAsuransipasien = AsuransipasienM::model()->findByPk($this->pendaftaran->asuransipasien_id);
		$pendaftaran = PendaftaranT::model()->findByPk($this->pendaftaran_id);
		$admisi = PasienadmisiT::model()->findByAttributes(array(
			'pendaftaran_id' => $this->pendaftaran_id,
		));
		$penjamin_old = $pendaftaran->penjamin_id;
		if (!empty($admisi)) {
			$penjamin_old  = $admisi->penjamin_id;
		}
		// print_r($modAsuransipasien->attributes);
		// print_r($this->attributes);
		// die;
		/**
		 * - Cek kelas tanggungan-nya pada tindakan, jika ada maka gunakan
		 *   kelas tanggungan dari tindakan itu sendiri.
		 * - Jika tidak ada, cek Data Asuransi Pasien-nya, jika ada maka
		 *   gunakan kelas pelayanan dan penjamin dari data pasien asuransi.
		 * - Tika tidak ada, maka gunakan kelas pelayanan dan penjamin dari
		 *   tindakan itu sendiri.
		 */
		$is_bpjs_naikkelas = false;
		if (!empty($admisi)) {
			if (in_array($admisi->carabayar_id, array(Params::CARABAYAR_ID_BPJS, Params::CARABAYAR_ID_BPJS_TENAGAKERJA))) {
				// return 0;
				$is_bpjs_naikkelas = true;
			}
		} else {
			$pendaftaran = PendaftaranT::model()->findByPk($this->pendaftaran_id);
			if (in_array($pendaftaran->carabayar_id, array(Params::CARABAYAR_ID_BPJS, Params::CARABAYAR_ID_BPJS_TENAGAKERJA))) {
				// return 0;
				$is_bpjs_naikkelas = true;
			}
		}
		if (!empty($this->kelastanggungan_id)) {
			$kelaspelayanan_id = $this->kelastanggungan_id;
			$penjamin_id = $penjamin_old; //$this->penjamin_id;
		} else {
			if (empty($modAsuransipasien)) {
				$kelaspelayanan_id = $this->kelaspelayanan_id;
				$penjamin_id = $penjamin_old; //$this->penjamin_id;
			} else {
				$kelaspelayanan_id = $modAsuransipasien->kelastanggunganasuransi_id;
				$penjamin_id = $modAsuransipasien->penjamin_id;
			}
		}
		$modTanggungan = TanggunganpenjaminM::model()->findByAttributes(array('kelaspelayanan_id' => $kelaspelayanan_id, 'penjamin_id' => $penjamin_id));
		$penjamin = PenjaminpasienM::model()->findByPk($penjamin_id);
		$cbayar = CarabayarM::model()->findByPk($penjamin->penjamin_id);
		$cr = new CDbCriteria();
		$cr->select = 't.*';
		$cr->join = 'JOIN jenistarifpenjamin_m ON jenistarifpenjamin_m.jenistarif_id = t.jenistarif_id';
		$cr->compare('t.daftartindakan_id', $this->daftartindakan_id);
		$cr->compare('jenistarifpenjamin_m.penjamin_id', $penjamin_id);
		$cr->compare('t.komponentarif_id', Params::KOMPONENTARIF_ID_TOTAL);
		// Jika tindakan-nya 'tanpa kelas', maka gunakan tarif tanpa kelas.
		if ($this->kelaspelayanan_id == Params::KELASPELAYANAN_ID_TANPA_KELAS) {
			$cr->compare('t.kelaspelayanan_id', Params::KELASPELAYANAN_ID_TANPA_KELAS);
		} else {
			$cr->compare('t.kelaspelayanan_id', $kelaspelayanan_id);
		}
		$dataTarif = TariftindakanM::model()->find($cr);

		
		if (empty($dataTarif)) {
			$cr = new CDbCriteria();
			$cr->select = 't.*';
			$cr->join = 'JOIN jenistarifpenjamin_m ON jenistarifpenjamin_m.jenistarif_id = t.jenistarif_id';
			$cr->compare('t.daftartindakan_id', $this->daftartindakan_id);
			$cr->compare('jenistarifpenjamin_m.penjamin_id', $penjamin_id);
			$cr->compare('t.komponentarif_id', Params::KOMPONENTARIF_ID_TOTAL);
			$cr->compare('t.kelaspelayanan_id', $this->kelaspelayanan_id);
			$dataTarif = TariftindakanM::model()->find($cr);
		}


		if (!empty($dataTarif)) {
			$subsidi = 0;
			// Jika tanggungan-nya ada, maka subsidi-nya adalah persentase
			// tanggungan penjamin dengan total tarif tanggugnan yang didapat.
			if (!empty($modTanggungan)) {
				if ($is_bpjs_naikkelas) {
					$subsidi = ((($this->tarif_satuan * $this->qty_tindakan) - $this->discount_tindakan) * $modTanggungan->$attr / 100);
				} else {
					$subsidi = (($this->cyto_tindakan ? $dataTarif['totaltarifakhir_cyto'] : $dataTarif['harga_tariftindakan']) * $modTanggungan->$attr / 100);
				}
			}
			// Triming total tarif subsidi yang melebihi total tarif tindakan
			if ($this->tarif_satuan >= $subsidi) {
				return $subsidi * $this->qty_tindakan;
			} else {
				return $this->tarif_satuan * $this->qty_tindakan;
			}
		} else {
			return 0;
		}
	}
	public function getPeriksaLab($daftartindakan_id)
	{
		$cri = new CDbCriteria();
		$cri->addCondition(" daftartindakan_id = '" . $daftartindakan_id . "' ");
		return PemeriksaanlabM::model()->find($cri);
	}
	public function getPeriksaRad($daftartindakan_id)
	{
		$cri = new CDbCriteria();
		$cri->addCondition(" daftartindakan_id = '" . $daftartindakan_id . "' ");
		return PemeriksaanradM::model()->find($cri);
	}
	public function getTotalTindakanAsuhanKeperawatan($date, $pegawai_id)
	{
		$time = strtotime($date);
		$qty = 0;
		$cr = new CDbCriteria();
		$cr->compare('daftartindakan_id', Params::DAFTARTINDAKAN_ID_ASUHAN_KEPERAWATAN);
		$cr->addBetweenCondition('tgl_tindakan', date('Y-m-1', $time), date('Y-m-t', $time));
		$dat = self::model()->findAll($cr);
		$peg = PegawaiM::model()->findByPk($pegawai_id);
		if ($peg->kelompokpegawai_id != Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN) {
			return 0;
		}
		// print_r(count((array)$dat)); die;
		foreach ($dat as $item) {
			$qty += $item->qty_tindakan;
		}
		return $qty;
	}
	public function searchDetailTindakan($pendaftaran_id)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$criteria = new CDbCriteria;
		if (!empty($this->tindakanpelayanan_id)) {
			$criteria->addCondition("tindakanpelayanan_id = " . $this->tindakanpelayanan_id);
		}
		if (!empty($this->penjamin_id)) {
			$criteria->addCondition("penjamin_id = " . $this->penjamin_id);
		}
		if (!empty($this->pasienadmisi_id)) {
			$criteria->addCondition("pasienadmisi_id = " . $this->pasienadmisi_id);
		}
		if (!empty($this->pasien_id)) {
			$criteria->addCondition("pasien_id = " . $this->pasien_id);
		}
		if (!empty($this->kelaspelayanan_id)) {
			$criteria->addCondition("kelaspelayanan_id = " . $this->kelaspelayanan_id);
		}
		if (!empty($this->instalasi_id)) {
			$criteria->addCondition("instalasi_id = " . $this->instalasi_id);
		}
		if (!empty($this->pendaftaran_id)) {
			$criteria->addCondition("pendaftaran_id = " . $this->pendaftaran_id);
		}
		if (!empty($this->shift_id)) {
			$criteria->addCondition("shift_id = " . $this->shift_id);
		}
		if (!empty($this->pasienmasukpenunjang_id)) {
			$criteria->addCondition("pasienmasukpenunjang_id = " . $this->pasienmasukpenunjang_id);
		}
		if (!empty($this->daftartindakan_id)) {
			$criteria->addCondition("daftartindakan_id = " . $this->daftartindakan_id);
		}
		$criteria->addCondition('pendaftaran_id = ' . $pendaftaran_id);
		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
	public function getPemeriksaanRad()
	{
		return PemeriksaanradM::model()->findByAttributes(array('daftartindakan_id' => $this->daftartindakan_id));
	}

	public function searchTindakanNamaPasien()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

        $criteria->join = 'left join daftartindakan_m d on d.daftartindakan_id = t.daftartindakan_id';
        
		$criteria->compare('t.tindakanpelayanan_id',$this->tindakanpelayanan_id);
		$criteria->compare('t.penjamin_id',$this->penjamin_id);
		$criteria->compare('t.pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('t.pasien_id',$this->pasien_id);
		$criteria->compare('t.kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('t.tipepaket_id',$this->tipepaket_id);
		$criteria->compare('t.instalasi_id',$this->instalasi_id);
		$criteria->compare('t.pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('t.shift_id',$this->shift_id);
		$criteria->compare('t.pasienmasukpenunjang_id',$this->pasienmasukpenunjang_id);
		$criteria->compare('t.daftartindakan_id',$this->daftartindakan_id);
		$criteria->compare('t.carabayar_id',$this->carabayar_id);
		$criteria->compare('t.jeniskasuspenyakit_id',$this->jeniskasuspenyakit_id);
		$criteria->compare('LOWER(t.tgl_tindakan)',strtolower($this->tgl_tindakan),true);
		$criteria->compare('t.tarif_tindakan',$this->tarif_tindakan);
		$criteria->compare('LOWER(t.satuantindakan)',strtolower($this->satuantindakan),true);
		$criteria->compare('LOWER(t.qty_tindakan)',strtolower($this->qty_tindakan),true);
		$criteria->compare('LOWER(d.daftartindakan_nama)',strtolower($this->daftartindakanNama),true);
		$criteria->compare('t.cyto_tindakan',$this->cyto_tindakan);
		$criteria->compare('t.tarifcyto_tindakan',$this->tarifcyto_tindakan);
		$criteria->compare('t.dokterpemeriksa1_id',$this->dokterpemeriksa1_id);
		$criteria->compare('t.dokterpemeriksa2_id',$this->dokterpemeriksa2_id);
		$criteria->compare('t.dokterpendamping_id',$this->dokterpendamping_id);
		$criteria->compare('t.dokteranastesi_id',$this->dokteranastesi_id);
		$criteria->compare('t.dokterdelegasi_id',$this->dokterdelegasi_id);
		$criteria->compare('t.bidan_id',strtolower($this->bidan_id),true);
		$criteria->compare('t.suster_id',strtolower($this->suster_id),true);
		$criteria->compare('t.perawat_id',strtolower($this->perawat_id),true);
		$criteria->compare('t.kelastanggungan_id',$this->kelastanggungan_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function getNoNota() {
		if (empty($this->nopelayanan)) {
			return "-";
		}

		$sql = "select t.no_pendaftaran, t.pasienadmisi_id 
		from pendaftaran_t t where t.pendaftaran_id = ".$this->pendaftaran_id;
		$res = Yii::app()->db->createCommand($sql)->queryRow();

		$sqlTindakan = "select pr.instalasi_id as instalasi_id_pr, kr.instalasi_id as instalasi_id_kr, 
		k.pasienadmisi_id as pasienadmisi_id_k, kk.pasienadmisi_id as pasienadmisi_id_kk, 
		k.pasienkirimkeunitlain_id 
		from tindakanpelayanan_t t 
		left join pasienmasukpenunjang_t p on p.pasienmasukpenunjang_id = t.pasienmasukpenunjang_id
		left join pasienkirimkeunitlain_t k on k.pasienkirimkeunitlain_id = p.pasienkirimkeunitlain_id
		left join permintaankepenunjang_t pp on pp.tindakanpelayanan_id = t.tindakanpelayanan_id
		left join pasienkirimkeunitlain_t kk on kk.pasienkirimkeunitlain_id = pp.pasienkirimkeunitlain_id
		left join ruangan_m pr on pr.ruangan_id = p.ruanganasal_id
		left join ruangan_m kr on kr.ruangan_id = k.create_ruangan
		where t.tindakanpelayanan_id = ".$this->tindakanpelayanan_id;
		$resTindakan = Yii::app()->db->createCommand($sql)->queryRow();

		$no_pendaftaran = $res['no_pendaftaran'];

		if (
			!empty($this->pasienadmisi_id) 
			|| in_array($this->instalasi_id, Params::grupInstalasiRIID())
			|| (!empty($resTindakan['instalasi_id_pr']) && in_array($resTindakan['instalasi_id_pr'], Params::grupInstalasiRIID()))
			|| (!empty($resTindakan['instalasi_id_kr']) && in_array($resTindakan['instalasi_id_kr'], Params::grupInstalasiRIID()))
			|| !empty($resTindakan['pasienadmisi_id_k'])
			|| !empty($resTindakan['pasienadmisi_id_kk'])

		) {
			$no_pendaftaran = str_replace(["RD", 'RJ'], "RI", $no_pendaftaran);
		}

		return $no_pendaftaran.$this->nopelayanan;

		//$pasienadmisi_id = $res['pasienadmisi_id'];
	}
}
