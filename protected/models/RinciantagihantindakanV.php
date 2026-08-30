<?php

/**
 * This is the model class for table "rinciantagihantindakan_v".
 *
 * The followings are the available columns in table 'rinciantagihantindakan_v':
 * @property integer $tindakanpelayanan_id
 * @property integer $detailhasilpemeriksaanlab_id
 * @property integer $shift_id
 * @property integer $kelaspelayanan_id
 * @property integer $pasien_id
 * @property integer $rencanaoperasi_id
 * @property integer $instalasi_id
 * @property integer $daftartindakan_id
 * @property integer $alatmedis_id
 * @property integer $tipepaket_id
 * @property integer $tindakansudahbayar_id
 * @property integer $karcis_id
 * @property integer $carabayar_id
 * @property integer $pendaftaran_id
 * @property integer $hasilpemeriksaanrad_id
 * @property integer $jeniskasuspenyakit_id
 * @property integer $hasilpemeriksaanrm_id
 * @property integer $ruangan_id
 * @property integer $pasienmasukpenunjang_id
 * @property integer $konsulpoli_id
 * @property integer $hasilpemeriksaanpa_id
 * @property integer $penjamin_id
 * @property integer $pasienadmisi_id
 * @property string $tgl_tindakan
 * @property double $tarif_rsakomodasi
 * @property double $tarif_medis
 * @property double $tarif_bhp
 * @property double $tarif_paramedis
 * @property double $tarif_satuan
 * @property double $tarif_tindakan
 * @property string $satuantindakan
 * @property integer $qty_tindakan
 * @property boolean $cyto_tindakan
 * @property double $tarifcyto_tindakan
 * @property string $dokterpemeriksa1_id
 * @property string $dokterpemeriksa2_id
 * @property string $dokterpendamping_id
 * @property string $dokteranastesi_id
 * @property string $bidan_id
 * @property string $dokterdelegasi_id
 * @property string $suster_id
 * @property integer $perawat_id
 * @property integer $kelastanggungan_id
 * @property double $discount_tindakan
 * @property double $pembebasan_tindakan
 * @property double $subsidiasuransi_tindakan
 * @property double $subsidipemerintah_tindakan
 * @property double $subsisidirumahsakit_tindakan
 * @property double $iurbiaya_tindakan
 * @property string $tm
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property integer $verifikasitagihan_id
 * @property integer $jurnalrekening_id
 * @property string $keterangantindakan
 * @property integer $rencanatindakan_id
 * @property string $namadepan
 * @property string $nama_pasien
 * @property string $tempat_lahir
 * @property string $tanggal_lahir
 * @property string $no_rekam_medik
 * @property string $jeniskelamin
 * @property string $alamat_pasien
 * @property string $umur
 * @property string $no_pendaftaran
 * @property string $tgl_pendaftaran
 * @property string $ruangan_nama
 * @property string $penjamin_nama
 * @property string $kelaspelayanan_nama
 * @property integer $jeniskelas_id
 * @property string $instalasi_nama
 * @property string $daftartindakan_nama
 * @property string $tindakanmedis_nama
 */
class RinciantagihantindakanV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RinciantagihantindakanV the static model class
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
		return 'rinciantagihantindakan_v';
	}
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tindakanpelayanan_id, detailhasilpemeriksaanlab_id, shift_id, kelaspelayanan_id, pasien_id, rencanaoperasi_id, instalasi_id, daftartindakan_id, alatmedis_id, tipepaket_id, tindakansudahbayar_id, karcis_id, carabayar_id, pendaftaran_id, hasilpemeriksaanrad_id, jeniskasuspenyakit_id, hasilpemeriksaanrm_id, ruangan_id, pasienmasukpenunjang_id, konsulpoli_id, hasilpemeriksaanpa_id, penjamin_id, pasienadmisi_id, qty_tindakan, perawat_id, kelastanggungan_id, verifikasitagihan_id, jurnalrekening_id, rencanatindakan_id, jeniskelas_id', 'numerical', 'integerOnly' => true),
			array('tarif_rsakomodasi, tarif_medis, tarif_bhp, tarif_paramedis, tarif_satuan, tarif_tindakan, tarifcyto_tindakan, discount_tindakan, pembebasan_tindakan, subsidiasuransi_tindakan, subsidipemerintah_tindakan, subsisidirumahsakit_tindakan, iurbiaya_tindakan', 'numerical'),
			array('satuantindakan, no_rekam_medik', 'length', 'max' => 10),
			array('tm', 'length', 'max' => 2),
			array('keterangantindakan, daftartindakan_nama, tindakanmedis_nama', 'length', 'max' => 200),
			array('namadepan, jeniskelamin, no_pendaftaran', 'length', 'max' => 20),
			array('nama_pasien, ruangan_nama, penjamin_nama, kelaspelayanan_nama, instalasi_nama', 'length', 'max' => 50),
			array('tempat_lahir', 'length', 'max' => 25),
			array('umur', 'length', 'max' => 30),
			array('tgl_tindakan, cyto_tindakan, dokterpemeriksa1_id, dokterpemeriksa2_id, dokterpendamping_id, dokteranastesi_id, bidan_id, dokterdelegasi_id, suster_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, tanggal_lahir, alamat_pasien, tgl_pendaftaran', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tindakanpelayanan_id, detailhasilpemeriksaanlab_id, shift_id, kelaspelayanan_id, pasien_id, rencanaoperasi_id, instalasi_id, daftartindakan_id, alatmedis_id, tipepaket_id, tindakansudahbayar_id, karcis_id, carabayar_id, pendaftaran_id, hasilpemeriksaanrad_id, jeniskasuspenyakit_id, hasilpemeriksaanrm_id, ruangan_id, pasienmasukpenunjang_id, konsulpoli_id, hasilpemeriksaanpa_id, penjamin_id, pasienadmisi_id, tgl_tindakan, tarif_rsakomodasi, tarif_medis, tarif_bhp, tarif_paramedis, tarif_satuan, tarif_tindakan, satuantindakan, qty_tindakan, cyto_tindakan, tarifcyto_tindakan, dokterpemeriksa1_id, dokterpemeriksa2_id, dokterpendamping_id, dokteranastesi_id, bidan_id, dokterdelegasi_id, suster_id, perawat_id, kelastanggungan_id, discount_tindakan, pembebasan_tindakan, subsidiasuransi_tindakan, subsidipemerintah_tindakan, subsisidirumahsakit_tindakan, iurbiaya_tindakan, tm, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, verifikasitagihan_id, jurnalrekening_id, keterangantindakan, rencanatindakan_id, namadepan, nama_pasien, tempat_lahir, tanggal_lahir, no_rekam_medik, jeniskelamin, alamat_pasien, umur, no_pendaftaran, tgl_pendaftaran, ruangan_nama, penjamin_nama, kelaspelayanan_nama, jeniskelas_id, instalasi_nama, daftartindakan_nama, tindakanmedis_nama', 'safe', 'on' => 'search'),
		);
	}
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array();
	}
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'tindakanpelayanan_id' => 'Tindakan Pelayanan',
			'detailhasilpemeriksaanlab_id' => 'Detail Hasil Pemeriksaan Lab',
			'shift_id' => 'Shift',
			'kelaspelayanan_id' => 'Kelas Pelayanan',
			'pasien_id' => 'Pasien',
			'rencanaoperasi_id' => 'Rencana Operasi',
			'instalasi_id' => 'Instalasi',
			'daftartindakan_id' => 'Daftar Tindakan',
			'alatmedis_id' => 'Alat Medis',
			'tipepaket_id' => 'Tipe Paket',
			'tindakansudahbayar_id' => 'Tindakan Sudah Bayar',
			'karcis_id' => 'Karcis',
			'carabayar_id' => 'Jenis Penjamin',
			'pendaftaran_id' => 'Pendaftaran',
			'hasilpemeriksaanrad_id' => 'Hasil Pemeriksaan RAD',
			'jeniskasuspenyakit_id' => 'Jenis Kasus Penyakit',
			'hasilpemeriksaanrm_id' => 'Hasil Pemeriksaan RM',
			'ruangan_id' => 'Ruangan',
			'pasienmasukpenunjang_id' => 'Pasien Masuk Penunjang',
			'konsulpoli_id' => 'Konsul Poli',
			'hasilpemeriksaanpa_id' => 'Hasil Pemeriksaan PA',
			'penjamin_id' => 'Penjamin',
			'pasienadmisi_id' => 'Pasien Admisi',
			'tgl_tindakan' => 'Tgl. Tindakan',
			'tarif_rsakomodasi' => 'Tarif RS Akomodasi',
			'tarif_medis' => 'Tarif Medis',
			'tarif_bhp' => 'Tarif BHP',
			'tarif_paramedis' => 'Tarif Paramedis',
			'tarif_satuan' => 'Tarif Satuan',
			'tarif_tindakan' => 'Nominal Tarif',
			'satuantindakan' => 'Satuan TIndakan',
			'qty_tindakan' => 'Jumlah Tindakan',
			'cyto_tindakan' => 'Cyto Tindakan',
			'tarifcyto_tindakan' => 'Tarif Cyto',
			'dokterpemeriksa1_id' => 'Dokter Pemeriksa 1',
			'dokterpemeriksa2_id' => 'Dokter Pemeriksa 2',
			'dokterpendamping_id' => 'Dokter Pendamping',
			'dokteranastesi_id' => 'Dokter Anastesi',
			'bidan_id' => 'Bidan',
			'dokterdelegasi_id' => 'Dokter Delegasi',
			'suster_id' => 'Suster',
			'perawat_id' => 'Perawat',
			'kelastanggungan_id' => 'Kelas Tanggungan',
			'discount_tindakan' => 'Keringanan Tindakan',
			'pembebasan_tindakan' => 'Pembebasan Tindakan',
			'subsidiasuransi_tindakan' => 'Tanggungan Asuransi',
			'subsidipemerintah_tindakan' => 'Tanggungan Pemerintah',
			'subsisidirumahsakit_tindakan' => 'Tanggungan Rumah Sakit',
			'iurbiaya_tindakan' => 'Iur Biaya',
			'tm' => 'TM',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'verifikasitagihan_id' => 'Verifikasi Tagihan',
			'jurnalrekening_id' => 'Jurnal Rekening',
			'keterangantindakan' => 'Keterangan Tindakan',
			'rencanatindakan_id' => 'Rencana Tindakan',
			'namadepan' => 'Nama Depan',
			'nama_pasien' => 'Nama Pasien',
			'tempat_lahir' => 'Tempat Lahir',
			'tanggal_lahir' => 'Tanggal Lahir',
			'no_rekam_medik' => 'No. Rekam Medik',
			'jeniskelamin' => 'Jenis Kelamin',
			'alamat_pasien' => 'Alamat Pasien',
			'umur' => 'Umur',
			'no_pendaftaran' => 'No. Pendaftaran',
			'tgl_pendaftaran' => 'Tgl. Pendaftaran',
			'ruangan_nama' => 'Ruangan',
			'penjamin_nama' => 'Penjamin',
			'kelaspelayanan_nama' => 'Kelas Pelayanan',
			'jeniskelas_id' => 'Jenis Kelas',
			'instalasi_nama' => 'Instalasi',
			'daftartindakan_nama' => 'Nama Daftar Tindakan',
			'tindakanmedis_nama' => 'Uraian Tindakan Medis',
		);
	}
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CdbCriteria that can return criterias.
	 */
	public function criteriaSearch()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$criteria = new CDbCriteria;
		if (!empty($this->tindakanpelayanan_id)) {
			$criteria->addCondition('tindakanpelayanan_id = ' . $this->tindakanpelayanan_id);
		}
		if (!empty($this->detailhasilpemeriksaanlab_id)) {
			$criteria->addCondition('detailhasilpemeriksaanlab_id = ' . $this->detailhasilpemeriksaanlab_id);
		}
		if (!empty($this->shift_id)) {
			$criteria->addCondition('shift_id = ' . $this->shift_id);
		}
		if (!empty($this->kelaspelayanan_id)) {
			$criteria->addCondition('kelaspelayanan_id = ' . $this->kelaspelayanan_id);
		}
		if (!empty($this->pasien_id)) {
			$criteria->addCondition('pasien_id = ' . $this->pasien_id);
		}
		if (!empty($this->rencanaoperasi_id)) {
			$criteria->addCondition('rencanaoperasi_id = ' . $this->rencanaoperasi_id);
		}
		if (!empty($this->instalasi_id)) {
			$criteria->addCondition('instalasi_id = ' . $this->instalasi_id);
		}
		if (!empty($this->daftartindakan_id)) {
			$criteria->addCondition('daftartindakan_id = ' . $this->daftartindakan_id);
		}
		if (!empty($this->alatmedis_id)) {
			$criteria->addCondition('alatmedis_id = ' . $this->alatmedis_id);
		}
		if (!empty($this->tipepaket_id)) {
			$criteria->addCondition('tipepaket_id = ' . $this->tipepaket_id);
		}
		if (!empty($this->tindakansudahbayar_id)) {
			$criteria->addCondition('tindakansudahbayar_id = ' . $this->tindakansudahbayar_id);
		}
		if (!empty($this->karcis_id)) {
			$criteria->addCondition('karcis_id = ' . $this->karcis_id);
		}
		if (!empty($this->carabayar_id)) {
			$criteria->addCondition('carabayar_id = ' . $this->carabayar_id);
		}
		if (!empty($this->pendaftaran_id)) {
			$criteria->addCondition('pendaftaran_id = ' . $this->pendaftaran_id);
		}
		if (!empty($this->hasilpemeriksaanrad_id)) {
			$criteria->addCondition('hasilpemeriksaanrad_id = ' . $this->hasilpemeriksaanrad_id);
		}
		if (!empty($this->jeniskasuspenyakit_id)) {
			$criteria->addCondition('jeniskasuspenyakit_id = ' . $this->jeniskasuspenyakit_id);
		}
		if (!empty($this->hasilpemeriksaanrm_id)) {
			$criteria->addCondition('hasilpemeriksaanrm_id = ' . $this->hasilpemeriksaanrm_id);
		}
		if (!empty($this->ruangan_id)) {
			$criteria->addCondition('ruangan_id = ' . $this->ruangan_id);
		}
		if (!empty($this->pasienmasukpenunjang_id)) {
			$criteria->addCondition('pasienmasukpenunjang_id = ' . $this->pasienmasukpenunjang_id);
		}
		if (!empty($this->konsulpoli_id)) {
			$criteria->addCondition('konsulpoli_id = ' . $this->konsulpoli_id);
		}
		if (!empty($this->hasilpemeriksaanpa_id)) {
			$criteria->addCondition('hasilpemeriksaanpa_id = ' . $this->hasilpemeriksaanpa_id);
		}
		if (!empty($this->penjamin_id)) {
			$criteria->addCondition('penjamin_id = ' . $this->penjamin_id);
		}
		if (!empty($this->pasienadmisi_id)) {
			$criteria->addCondition('pasienadmisi_id = ' . $this->pasienadmisi_id);
		}
		$criteria->compare('LOWER(tgl_tindakan)', strtolower($this->tgl_tindakan), true);
		$criteria->compare('tarif_rsakomodasi', $this->tarif_rsakomodasi);
		$criteria->compare('tarif_medis', $this->tarif_medis);
		$criteria->compare('tarif_bhp', $this->tarif_bhp);
		$criteria->compare('tarif_paramedis', $this->tarif_paramedis);
		$criteria->compare('tarif_satuan', $this->tarif_satuan);
		$criteria->compare('tarif_tindakan', $this->tarif_tindakan);
		$criteria->compare('LOWER(satuantindakan)', strtolower($this->satuantindakan), true);
		if (!empty($this->qty_tindakan)) {
			$criteria->addCondition('qty_tindakan = ' . $this->qty_tindakan);
		}
		$criteria->compare('cyto_tindakan', $this->cyto_tindakan);
		$criteria->compare('tarifcyto_tindakan', $this->tarifcyto_tindakan);
		$criteria->compare('LOWER(dokterpemeriksa1_id)', strtolower($this->dokterpemeriksa1_id), true);
		$criteria->compare('LOWER(dokterpemeriksa2_id)', strtolower($this->dokterpemeriksa2_id), true);
		$criteria->compare('LOWER(dokterpendamping_id)', strtolower($this->dokterpendamping_id), true);
		$criteria->compare('LOWER(dokteranastesi_id)', strtolower($this->dokteranastesi_id), true);
		$criteria->compare('LOWER(bidan_id)', strtolower($this->bidan_id), true);
		$criteria->compare('LOWER(dokterdelegasi_id)', strtolower($this->dokterdelegasi_id), true);
		$criteria->compare('LOWER(suster_id)', strtolower($this->suster_id), true);
		if (!empty($this->perawat_id)) {
			$criteria->addCondition('perawat_id = ' . $this->perawat_id);
		}
		if (!empty($this->kelastanggungan_id)) {
			$criteria->addCondition('kelastanggungan_id = ' . $this->kelastanggungan_id);
		}
		$criteria->compare('discount_tindakan', $this->discount_tindakan);
		$criteria->compare('pembebasan_tindakan', $this->pembebasan_tindakan);
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
		if (!empty($this->verifikasitagihan_id)) {
			$criteria->addCondition('verifikasitagihan_id = ' . $this->verifikasitagihan_id);
		}
		if (!empty($this->jurnalrekening_id)) {
			$criteria->addCondition('jurnalrekening_id = ' . $this->jurnalrekening_id);
		}
		$criteria->compare('LOWER(keterangantindakan)', strtolower($this->keterangantindakan), true);
		if (!empty($this->rencanatindakan_id)) {
			$criteria->addCondition('rencanatindakan_id = ' . $this->rencanatindakan_id);
		}
		$criteria->compare('LOWER(namadepan)', strtolower($this->namadepan), true);
		$criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien), true);
		$criteria->compare('LOWER(tempat_lahir)', strtolower($this->tempat_lahir), true);
		$criteria->compare('LOWER(tanggal_lahir)', strtolower($this->tanggal_lahir), true);
		$criteria->compare('LOWER(no_rekam_medik)', strtolower($this->no_rekam_medik), true);
		$criteria->compare('LOWER(jeniskelamin)', strtolower($this->jeniskelamin), true);
		$criteria->compare('LOWER(alamat_pasien)', strtolower($this->alamat_pasien), true);
		$criteria->compare('LOWER(umur)', strtolower($this->umur), true);
		$criteria->compare('LOWER(no_pendaftaran)', strtolower($this->no_pendaftaran), true);
		$criteria->compare('LOWER(tgl_pendaftaran)', strtolower($this->tgl_pendaftaran), true);
		$criteria->compare('LOWER(ruangan_nama)', strtolower($this->ruangan_nama), true);
		$criteria->compare('LOWER(penjamin_nama)', strtolower($this->penjamin_nama), true);
		$criteria->compare('LOWER(kelaspelayanan_nama)', strtolower($this->kelaspelayanan_nama), true);
		if (!empty($this->jeniskelas_id)) {
			$criteria->addCondition('jeniskelas_id = ' . $this->jeniskelas_id);
		}
		$criteria->compare('LOWER(instalasi_nama)', strtolower($this->instalasi_nama), true);
		$criteria->compare('LOWER(daftartindakan_nama)', strtolower($this->daftartindakan_nama), true);
		$criteria->compare('LOWER(tindakanmedis_nama)', strtolower($this->tindakanmedis_nama), true);
		return $criteria;
	}
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$criteria = $this->criteriaSearch();
		$criteria->limit = 10;
		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
	public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$criteria = $this->criteriaSearch();
		$criteria->limit = -1;
		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'pagination' => false,
		));
	}
	public function TotalTindakanPerInstalasi($pendaftaran_id, $instalasi_id)
	{
		$criteria = new CDbCriteria();
		$criteria->select = "sum( tarif_rsakomodasi + tarif_medis + tarif_paramedis + tarifcyto_tindakan + (qty_tindakan*tarif_satuan) ) AS tarif_tindakan";
		$criteria->addCondition('pendaftaran_id = ' . $pendaftaran_id);
		$criteria->addCondition('instalasi_id = ' . $instalasi_id);
		$modRincianTindakan = self::model()->find($criteria);
		return $modRincianTindakan->tarif_tindakan;
	}
	public function TotalTindakanPerInstalasiJenazah($pendaftaran_id, $instalasi_id)
	{
		$criteria = new CDbCriteria();
		// $criteria->select = "sum( tarif_rsakomodasi + tarif_medis + tarif_paramedis + tarifcyto_tindakan + (qty_tindakan*tarif_satuan) ) AS tarif_tindakan";
		$criteria->select = "sum( tarifcyto_tindakan + (qty_tindakan*tarif_satuan) ) AS tarif_tindakan";
		$criteria->addCondition('pendaftaran_id = ' . $pendaftaran_id);
		$criteria->addCondition('instalasi_id = ' . $instalasi_id);
		$criteria->addCondition('ruangan_id = ' . Yii::app()->user->getState('ruangan_id'));
		$modRincianTindakan = self::model()->find($criteria);
		return $modRincianTindakan->tarif_tindakan;
	}
}
