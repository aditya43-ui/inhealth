<?php

/**
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @package application.models
 * 
 * This is the model class for table "rincianbayartindakan_v".
 *
 * The followings are the available columns in table 'rincianbayartindakan_v':
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
 * @property integer $konsulpoli_id
 * @property integer $pasienmasukpenunjang_id
 * @property integer $hasilpemeriksaanpa_id
 * @property integer $penjamin_id
 * @property integer $pasienadmisi_id
 * @property string $tgl_tindakan
 * @property double $tarif_rsakomodasi
 * @property double $tarif_medis
 * @property double $tarif_paramedis
 * @property double $tarif_bhp
 * @property double $tarif_satuan
 * @property double $tarif_tindakan
 * @property string $satuantindakan
 * @property integer $qty_tindakan
 * @property boolean $cyto_tindakan
 * @property double $tarifcyto_tindakan
 * @property integer $dokterpemeriksa1_id
 * @property integer $dokterpemeriksa2_id
 * @property integer $dokterpendamping_id
 * @property integer $dokteranastesi_id
 * @property integer $dokterdelegasi_id
 * @property integer $bidan_id
 * @property integer $suster_id
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
 * @property string $no_rekam_medik
 * @property string $namadepan
 * @property string $nama_pasien
 * @property string $jeniskelamin
 * @property string $tempat_lahir
 * @property string $tanggal_lahir
 * @property string $alamat_pasien
 * @property string $umur
 * @property string $no_pendaftaran
 * @property string $tgl_pendaftaran
 * @property string $instalasi_nama
 * @property string $ruangan_nama
 * @property string $kelaspelayanan_nama
 * @property integer $jeniskelas_id
 * @property string $penjamin_nama
 * @property string $daftartindakan_kode
 * @property string $daftartindakan_nama
 * @property string $tindakanmedis_nama
 * @property string $tipepaket_nama
 * @property double $jmlbiaya_tindakan
 * @property double $jmlsubsidi_asuransi
 * @property double $jmlsubsidi_pemerintah
 * @property double $jmlsubsidi_rs
 * @property double $jmliurbiaya
 * @property double $jmlpembebasan
 * @property double $jmlbayar_tindakan
 * @property double $jmlsisabayar_tindakan
 * @property string $carabayar_nama
 * @property integer $pembayaranpelayanan_id
 */
class RincianbayartindakanV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RincianbayartindakanV the static model class
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
		return 'rincianbayartindakan_v';
	}
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tindakanpelayanan_id, detailhasilpemeriksaanlab_id, shift_id, kelaspelayanan_id, pasien_id, rencanaoperasi_id, instalasi_id, daftartindakan_id, alatmedis_id, tipepaket_id, tindakansudahbayar_id, karcis_id, carabayar_id, pendaftaran_id, hasilpemeriksaanrad_id, jeniskasuspenyakit_id, hasilpemeriksaanrm_id, ruangan_id, konsulpoli_id, pasienmasukpenunjang_id, hasilpemeriksaanpa_id, penjamin_id, pasienadmisi_id, qty_tindakan, dokterpemeriksa1_id, dokterpemeriksa2_id, dokterpendamping_id, dokteranastesi_id, dokterdelegasi_id, bidan_id, suster_id, perawat_id, kelastanggungan_id, verifikasitagihan_id, jurnalrekening_id, rencanatindakan_id, jeniskelas_id, pembayaranpelayanan_id', 'numerical', 'integerOnly' => true),
			array('tarif_rsakomodasi, tarif_medis, tarif_paramedis, tarif_bhp, tarif_satuan, tarif_tindakan, tarifcyto_tindakan, discount_tindakan, pembebasan_tindakan, subsidiasuransi_tindakan, subsidipemerintah_tindakan, subsisidirumahsakit_tindakan, iurbiaya_tindakan, jmlbiaya_tindakan, jmlsubsidi_asuransi, jmlsubsidi_pemerintah, jmlsubsidi_rs, jmliurbiaya, jmlpembebasan, jmlbayar_tindakan, jmlsisabayar_tindakan', 'numerical'),
			array('satuantindakan, no_rekam_medik', 'length', 'max' => 10),
			array('tm', 'length', 'max' => 2),
			array('keterangantindakan, daftartindakan_nama, tindakanmedis_nama', 'length', 'max' => 200),
			array('namadepan, jeniskelamin, no_pendaftaran, daftartindakan_kode', 'length', 'max' => 20),
			array('nama_pasien, instalasi_nama, ruangan_nama, kelaspelayanan_nama, penjamin_nama, tipepaket_nama, carabayar_nama', 'length', 'max' => 50),
			array('tempat_lahir', 'length', 'max' => 25),
			array('umur', 'length', 'max' => 30),
			array('tgl_tindakan, cyto_tindakan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, tanggal_lahir, alamat_pasien, tgl_pendaftaran', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tindakanpelayanan_id, detailhasilpemeriksaanlab_id, shift_id, kelaspelayanan_id, pasien_id, rencanaoperasi_id, instalasi_id, daftartindakan_id, alatmedis_id, tipepaket_id, tindakansudahbayar_id, karcis_id, carabayar_id, pendaftaran_id, hasilpemeriksaanrad_id, jeniskasuspenyakit_id, hasilpemeriksaanrm_id, ruangan_id, konsulpoli_id, pasienmasukpenunjang_id, hasilpemeriksaanpa_id, penjamin_id, pasienadmisi_id, tgl_tindakan, tarif_rsakomodasi, tarif_medis, tarif_paramedis, tarif_bhp, tarif_satuan, tarif_tindakan, satuantindakan, qty_tindakan, cyto_tindakan, tarifcyto_tindakan, dokterpemeriksa1_id, dokterpemeriksa2_id, dokterpendamping_id, dokteranastesi_id, dokterdelegasi_id, bidan_id, suster_id, perawat_id, kelastanggungan_id, discount_tindakan, pembebasan_tindakan, subsidiasuransi_tindakan, subsidipemerintah_tindakan, subsisidirumahsakit_tindakan, iurbiaya_tindakan, tm, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, verifikasitagihan_id, jurnalrekening_id, keterangantindakan, rencanatindakan_id, no_rekam_medik, namadepan, nama_pasien, jeniskelamin, tempat_lahir, tanggal_lahir, alamat_pasien, umur, no_pendaftaran, tgl_pendaftaran, instalasi_nama, ruangan_nama, kelaspelayanan_nama, jeniskelas_id, penjamin_nama, daftartindakan_kode, daftartindakan_nama, tindakanmedis_nama, tipepaket_nama, jmlbiaya_tindakan, jmlsubsidi_asuransi, jmlsubsidi_pemerintah, jmlsubsidi_rs, jmliurbiaya, jmlpembebasan, jmlbayar_tindakan, jmlsisabayar_tindakan, carabayar_nama, pembayaranpelayanan_id', 'safe', 'on' => 'search'),
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
			'tindakanpelayanan_id' => 'Tindakanpelayanan',
			'detailhasilpemeriksaanlab_id' => 'Detailhasilpemeriksaanlab',
			'shift_id' => 'Shift',
			'kelaspelayanan_id' => 'Kelaspelayanan',
			'pasien_id' => 'Pasien',
			'rencanaoperasi_id' => 'Rencanaoperasi',
			'instalasi_id' => 'Instalasi',
			'daftartindakan_id' => 'Daftartindakan',
			'alatmedis_id' => 'Alatmedis',
			'tipepaket_id' => 'Tipepaket',
			'tindakansudahbayar_id' => 'Tindakansudahbayar',
			'karcis_id' => 'Karcis',
			'carabayar_id' => 'Jenis Penjamin',
			'pendaftaran_id' => 'Pendaftaran',
			'hasilpemeriksaanrad_id' => 'Hasilpemeriksaanrad',
			'jeniskasuspenyakit_id' => 'Jeniskasuspenyakit',
			'hasilpemeriksaanrm_id' => 'Hasilpemeriksaanrm',
			'ruangan_id' => 'Ruangan',
			'konsulpoli_id' => 'Konsulpoli',
			'pasienmasukpenunjang_id' => 'Pasienmasukpenunjang',
			'hasilpemeriksaanpa_id' => 'Hasilpemeriksaanpa',
			'penjamin_id' => 'Penjamin',
			'pasienadmisi_id' => 'Pasienadmisi',
			'tgl_tindakan' => 'Tgl. Tindakan',
			'tarif_rsakomodasi' => 'Tarif Rsakomodasi',
			'tarif_medis' => 'Tarif Medis',
			'tarif_paramedis' => 'Tarif Paramedis',
			'tarif_bhp' => 'Tarif Bhp',
			'tarif_satuan' => 'Tarif Satuan',
			'tarif_tindakan' => 'Nominal Tarif',
			'satuantindakan' => 'Satuantindakan',
			'qty_tindakan' => 'Qty Tindakan',
			'cyto_tindakan' => 'Cyto Tindakan',
			'tarifcyto_tindakan' => 'Tarifcyto Tindakan',
			'dokterpemeriksa1_id' => 'Dokterpemeriksa1',
			'dokterpemeriksa2_id' => 'Dokterpemeriksa2',
			'dokterpendamping_id' => 'Dokterpendamping',
			'dokteranastesi_id' => 'Dokteranastesi',
			'dokterdelegasi_id' => 'Dokterdelegasi',
			'bidan_id' => 'Bidan',
			'suster_id' => 'Suster',
			'perawat_id' => 'Perawat',
			'kelastanggungan_id' => 'Kelastanggungan',
			'discount_tindakan' => 'Keringanan Tindakan',
			'pembebasan_tindakan' => 'Pembebasan Tindakan',
			'subsidiasuransi_tindakan' => 'Tanggungan Asuransi Tindakan',
			'subsidipemerintah_tindakan' => 'Tanggungan Pemerintah Tindakan',
			'subsisidirumahsakit_tindakan' => 'Tanggungan Rumah Sakit Tindakan',
			'iurbiaya_tindakan' => 'Iurbiaya Tindakan',
			'tm' => 'Tm',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'verifikasitagihan_id' => 'Verifikasitagihan',
			'jurnalrekening_id' => 'Jurnalrekening',
			'keterangantindakan' => 'Keterangantindakan',
			'rencanatindakan_id' => 'Rencanatindakan',
			'no_rekam_medik' => 'No. Rekam Medik',
			'namadepan' => 'Namadepan',
			'nama_pasien' => 'Nama Pasien',
			'jeniskelamin' => 'Jenis Kelamin',
			'tempat_lahir' => 'Tempat Lahir',
			'tanggal_lahir' => 'Tanggal Lahir',
			'alamat_pasien' => 'Alamat Pasien',
			'umur' => 'Umur',
			'no_pendaftaran' => 'No. Pendaftaran',
			'tgl_pendaftaran' => 'Tgl. Pendaftaran',
			'instalasi_nama' => 'Instalasi Nama',
			'ruangan_nama' => 'Ruangan Nama',
			'kelaspelayanan_nama' => 'Kelaspelayanan Nama',
			'jeniskelas_id' => 'Jeniskelas',
			'penjamin_nama' => 'Penjamin Nama',
			'daftartindakan_kode' => 'Daftartindakan Kode',
			'daftartindakan_nama' => 'Nama Daftar Tindakan',
			'tindakanmedis_nama' => 'Tindakanmedis Nama',
			'tipepaket_nama' => 'Tipepaket Nama',
			'jmlbiaya_tindakan' => 'Jmlbiaya Tindakan',
			'jmlsubsidi_asuransi' => 'Jmlsubsidi Asuransi',
			'jmlsubsidi_pemerintah' => 'Jmlsubsidi Pemerintah',
			'jmlsubsidi_rs' => 'Jmlsubsidi Rs',
			'jmliurbiaya' => 'Jmliurbiaya',
			'jmlpembebasan' => 'Jmlpembebasan',
			'jmlbayar_tindakan' => 'Jmlbayar Tindakan',
			'jmlsisabayar_tindakan' => 'Jmlsisabayar Tindakan',
			'carabayar_nama' => 'Carabayar Nama',
			'pembayaranpelayanan_id' => 'Pembayaranpelayanan',
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
		$criteria->compare('detailhasilpemeriksaanlab_id', $this->detailhasilpemeriksaanlab_id);
		$criteria->compare('shift_id', $this->shift_id);
		$criteria->compare('kelaspelayanan_id', $this->kelaspelayanan_id);
		$criteria->compare('pasien_id', $this->pasien_id);
		$criteria->compare('rencanaoperasi_id', $this->rencanaoperasi_id);
		$criteria->compare('instalasi_id', $this->instalasi_id);
		$criteria->compare('daftartindakan_id', $this->daftartindakan_id);
		$criteria->compare('alatmedis_id', $this->alatmedis_id);
		$criteria->compare('tipepaket_id', $this->tipepaket_id);
		$criteria->compare('tindakansudahbayar_id', $this->tindakansudahbayar_id);
		$criteria->compare('karcis_id', $this->karcis_id);
		$criteria->compare('carabayar_id', $this->carabayar_id);
		$criteria->compare('pendaftaran_id', $this->pendaftaran_id);
		$criteria->compare('hasilpemeriksaanrad_id', $this->hasilpemeriksaanrad_id);
		$criteria->compare('jeniskasuspenyakit_id', $this->jeniskasuspenyakit_id);
		$criteria->compare('hasilpemeriksaanrm_id', $this->hasilpemeriksaanrm_id);
		$criteria->compare('ruangan_id', $this->ruangan_id);
		$criteria->compare('konsulpoli_id', $this->konsulpoli_id);
		$criteria->compare('pasienmasukpenunjang_id', $this->pasienmasukpenunjang_id);
		$criteria->compare('hasilpemeriksaanpa_id', $this->hasilpemeriksaanpa_id);
		$criteria->compare('penjamin_id', $this->penjamin_id);
		$criteria->compare('pasienadmisi_id', $this->pasienadmisi_id);
		$criteria->compare('tgl_tindakan', $this->tgl_tindakan, true);
		$criteria->compare('tarif_rsakomodasi', $this->tarif_rsakomodasi);
		$criteria->compare('tarif_medis', $this->tarif_medis);
		$criteria->compare('tarif_paramedis', $this->tarif_paramedis);
		$criteria->compare('tarif_bhp', $this->tarif_bhp);
		$criteria->compare('tarif_satuan', $this->tarif_satuan);
		$criteria->compare('tarif_tindakan', $this->tarif_tindakan);
		$criteria->compare('satuantindakan', $this->satuantindakan, true);
		$criteria->compare('qty_tindakan', $this->qty_tindakan);
		$criteria->compare('cyto_tindakan', $this->cyto_tindakan);
		$criteria->compare('tarifcyto_tindakan', $this->tarifcyto_tindakan);
		$criteria->compare('dokterpemeriksa1_id', $this->dokterpemeriksa1_id);
		$criteria->compare('dokterpemeriksa2_id', $this->dokterpemeriksa2_id);
		$criteria->compare('dokterpendamping_id', $this->dokterpendamping_id);
		$criteria->compare('dokteranastesi_id', $this->dokteranastesi_id);
		$criteria->compare('dokterdelegasi_id', $this->dokterdelegasi_id);
		$criteria->compare('bidan_id', $this->bidan_id);
		$criteria->compare('suster_id', $this->suster_id);
		$criteria->compare('perawat_id', $this->perawat_id);
		$criteria->compare('kelastanggungan_id', $this->kelastanggungan_id);
		$criteria->compare('discount_tindakan', $this->discount_tindakan);
		$criteria->compare('pembebasan_tindakan', $this->pembebasan_tindakan);
		$criteria->compare('subsidiasuransi_tindakan', $this->subsidiasuransi_tindakan);
		$criteria->compare('subsidipemerintah_tindakan', $this->subsidipemerintah_tindakan);
		$criteria->compare('subsisidirumahsakit_tindakan', $this->subsisidirumahsakit_tindakan);
		$criteria->compare('iurbiaya_tindakan', $this->iurbiaya_tindakan);
		$criteria->compare('tm', $this->tm, true);
		$criteria->compare('create_time', $this->create_time, true);
		$criteria->compare('update_time', $this->update_time, true);
		$criteria->compare('create_loginpemakai_id', $this->create_loginpemakai_id, true);
		$criteria->compare('update_loginpemakai_id', $this->update_loginpemakai_id, true);
		$criteria->compare('create_ruangan', $this->create_ruangan, true);
		$criteria->compare('verifikasitagihan_id', $this->verifikasitagihan_id);
		$criteria->compare('jurnalrekening_id', $this->jurnalrekening_id);
		$criteria->compare('keterangantindakan', $this->keterangantindakan, true);
		$criteria->compare('rencanatindakan_id', $this->rencanatindakan_id);
		$criteria->compare('no_rekam_medik', $this->no_rekam_medik, true);
		$criteria->compare('namadepan', $this->namadepan, true);
		$criteria->compare('nama_pasien', $this->nama_pasien, true);
		$criteria->compare('jeniskelamin', $this->jeniskelamin, true);
		$criteria->compare('tempat_lahir', $this->tempat_lahir, true);
		$criteria->compare('tanggal_lahir', $this->tanggal_lahir, true);
		$criteria->compare('alamat_pasien', $this->alamat_pasien, true);
		$criteria->compare('umur', $this->umur, true);
		$criteria->compare('no_pendaftaran', $this->no_pendaftaran, true);
		$criteria->compare('tgl_pendaftaran', $this->tgl_pendaftaran, true);
		$criteria->compare('instalasi_nama', $this->instalasi_nama, true);
		$criteria->compare('ruangan_nama', $this->ruangan_nama, true);
		$criteria->compare('kelaspelayanan_nama', $this->kelaspelayanan_nama, true);
		$criteria->compare('jeniskelas_id', $this->jeniskelas_id);
		$criteria->compare('penjamin_nama', $this->penjamin_nama, true);
		$criteria->compare('daftartindakan_kode', $this->daftartindakan_kode, true);
		$criteria->compare('daftartindakan_nama', $this->daftartindakan_nama, true);
		$criteria->compare('tindakanmedis_nama', $this->tindakanmedis_nama, true);
		$criteria->compare('tipepaket_nama', $this->tipepaket_nama, true);
		$criteria->compare('jmlbiaya_tindakan', $this->jmlbiaya_tindakan);
		$criteria->compare('jmlsubsidi_asuransi', $this->jmlsubsidi_asuransi);
		$criteria->compare('jmlsubsidi_pemerintah', $this->jmlsubsidi_pemerintah);
		$criteria->compare('jmlsubsidi_rs', $this->jmlsubsidi_rs);
		$criteria->compare('jmliurbiaya', $this->jmliurbiaya);
		$criteria->compare('jmlpembebasan', $this->jmlpembebasan);
		$criteria->compare('jmlbayar_tindakan', $this->jmlbayar_tindakan);
		$criteria->compare('jmlsisabayar_tindakan', $this->jmlsisabayar_tindakan);
		$criteria->compare('carabayar_nama', $this->carabayar_nama, true);
		$criteria->compare('pembayaranpelayanan_id', $this->pembayaranpelayanan_id);
		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}
