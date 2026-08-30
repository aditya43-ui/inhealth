<?php

/**
 * This is the model class for table "laporanpakaialatmedis_v".
 *
 * The followings are the available columns in table 'laporanpakaialatmedis_v':
 * @property integer $jenisalatmedis_id
 * @property string $jenisalatmedis_nama
 * @property integer $alatmedis_id
 * @property string $alatmedis_kode
 * @property string $alatmedis_format
 * @property string $alatmedis_nama
 * @property string $alatmedis_merk
 * @property string $no_pendaftaran
 * @property string $tgl_pendaftaran
 * @property integer $carabayar_id
 * @property string $carabayar_nama
 * @property integer $penjamin_id
 * @property string $penjamin_nama
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $kelaspelayanan_id
 * @property string $kelaspelayanan_nama
 * @property integer $kelastanggungan_id
 * @property integer $pasien_id
 * @property string $namadepan
 * @property string $nama_pasien
 * @property string $tempat_lahir
 * @property string $tanggal_lahir
 * @property string $no_rekam_medik
 * @property string $jeniskelamin
 * @property string $alamat_pasien
 * @property integer $tindakanpelayanan_id
 * @property integer $tindakansudahbayar_id
 * @property integer $daftartindakan_id
 * @property string $daftartindakan_nama
 * @property string $tgl_tindakan
 * @property double $tarif_satuan
 * @property double $tarif_tindakan
 * @property string $satuantindakan
 * @property integer $qty_tindakan
 * @property boolean $cyto_tindakan
 * @property double $tarifcyto_tindakan
 * @property double $alatmedis_harga
 * @property double $alatmedis_hppperhari
 * @property integer $alatmedis_trgtbep
 * @property string $alatmedis_trgtbep_sat
 * @property string $dokterpemeriksa1_id
 * @property string $dokterpemeriksa2_id
 * @property string $dokterpendamping_id
 * @property string $dokteranastesi_id
 * @property string $bidan_id
 * @property string $dokterdelegasi_id
 * @property string $suster_id
 * @property integer $perawat_id
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
 * @property string $keterangantindakan
 */
class LaporanpakaialatmedisV extends CActiveRecord
{
	public $tgl_awal;
	public $tgl_akhir;
	public $bln_awal;
	public $bln_akhir;
	public $thn_awal;
	public $thn_akhir;
	public $jns_periode;
	public $jumlah;
	public $data;
	public $tick;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporanpakaialatmedisV the static model class
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
		return 'laporanpakaialatmedis_v';
	}
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jenisalatmedis_id, alatmedis_id, carabayar_id, penjamin_id, instalasi_id, ruangan_id, kelaspelayanan_id, kelastanggungan_id, pasien_id, tindakanpelayanan_id, tindakansudahbayar_id, daftartindakan_id, qty_tindakan, alatmedis_trgtbep, perawat_id', 'numerical', 'integerOnly' => true),
			array('tarif_satuan, tarif_tindakan, tarifcyto_tindakan, alatmedis_harga, alatmedis_hppperhari, discount_tindakan, pembebasan_tindakan, subsidiasuransi_tindakan, subsidipemerintah_tindakan, subsisidirumahsakit_tindakan, iurbiaya_tindakan', 'numerical'),
			array('jenisalatmedis_nama, alatmedis_nama', 'length', 'max' => 100),
			array('alatmedis_kode, tm', 'length', 'max' => 2),
			array('alatmedis_format, no_rekam_medik, satuantindakan, alatmedis_trgtbep_sat', 'length', 'max' => 10),
			array('alatmedis_merk, carabayar_nama, penjamin_nama, instalasi_nama, ruangan_nama, kelaspelayanan_nama, nama_pasien', 'length', 'max' => 50),
			array('no_pendaftaran, namadepan, jeniskelamin', 'length', 'max' => 20),
			array('tempat_lahir', 'length', 'max' => 25),
			array('daftartindakan_nama, keterangantindakan', 'length', 'max' => 200),
			array('tgl_pendaftaran, tanggal_lahir, alamat_pasien, tgl_tindakan, cyto_tindakan, dokterpemeriksa1_id, dokterpemeriksa2_id, dokterpendamping_id, dokteranastesi_id, bidan_id, dokterdelegasi_id, suster_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('jenisalatmedis_id, jenisalatmedis_nama, alatmedis_id, alatmedis_kode, alatmedis_format, alatmedis_nama, alatmedis_merk, no_pendaftaran, tgl_pendaftaran, carabayar_id, carabayar_nama, penjamin_id, penjamin_nama, instalasi_id, instalasi_nama, ruangan_id, ruangan_nama, kelaspelayanan_id, kelaspelayanan_nama, kelastanggungan_id, pasien_id, namadepan, nama_pasien, tempat_lahir, tanggal_lahir, no_rekam_medik, jeniskelamin, alamat_pasien, tindakanpelayanan_id, tindakansudahbayar_id, daftartindakan_id, daftartindakan_nama, tgl_tindakan, tarif_satuan, tarif_tindakan, satuantindakan, qty_tindakan, cyto_tindakan, tarifcyto_tindakan, alatmedis_harga, alatmedis_hppperhari, alatmedis_trgtbep, alatmedis_trgtbep_sat, dokterpemeriksa1_id, dokterpemeriksa2_id, dokterpendamping_id, dokteranastesi_id, bidan_id, dokterdelegasi_id, suster_id, perawat_id, discount_tindakan, pembebasan_tindakan, subsidiasuransi_tindakan, subsidipemerintah_tindakan, subsisidirumahsakit_tindakan, iurbiaya_tindakan, tm, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, keterangantindakan', 'safe', 'on' => 'search'),
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
			'jenisalatmedis_id' => 'Jenisalatmedis',
			'jenisalatmedis_nama' => 'Jenisalatmedis Nama',
			'alatmedis_id' => 'Alatmedis',
			'alatmedis_kode' => 'Alatmedis Kode',
			'alatmedis_format' => 'Alatmedis Format',
			'alatmedis_nama' => 'Alat Medis',
			'alatmedis_merk' => 'Alatmedis Merk',
			'no_pendaftaran' => 'No. Pendaftaran',
			'tgl_pendaftaran' => 'Tgl. Pendaftaran',
			'carabayar_id' => 'Jenis Penjamin',
			'carabayar_nama' => 'Carabayar Nama',
			'penjamin_id' => 'Penjamin',
			'penjamin_nama' => 'Penjamin Nama',
			'instalasi_id' => 'Instalasi',
			'instalasi_nama' => 'Instalasi Nama',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
			'kelaspelayanan_id' => 'Kelaspelayanan',
			'kelaspelayanan_nama' => 'Kelaspelayanan Nama',
			'kelastanggungan_id' => 'Kelastanggungan',
			'pasien_id' => 'Pasien',
			'namadepan' => 'Namadepan',
			'nama_pasien' => 'Nama Pasien',
			'tempat_lahir' => 'Tempat Lahir',
			'tanggal_lahir' => 'Tanggal Lahir',
			'no_rekam_medik' => 'No. Rekam Medik',
			'jeniskelamin' => 'Jenis Kelamin',
			'alamat_pasien' => 'Alamat Pasien',
			'tindakanpelayanan_id' => 'Tindakanpelayanan',
			'tindakansudahbayar_id' => 'Tindakansudahbayar',
			'daftartindakan_id' => 'Daftartindakan',
			'daftartindakan_nama' => 'Nama Daftar Tindakan',
			'tgl_tindakan' => 'Tgl. Tindakan',
			'tarif_satuan' => 'Tarif Satuan',
			'tarif_tindakan' => 'Nominal Tarif',
			'satuantindakan' => 'Satuantindakan',
			'qty_tindakan' => 'Qty Tindakan',
			'cyto_tindakan' => 'Cyto Tindakan',
			'tarifcyto_tindakan' => 'Tarifcyto Tindakan',
			'alatmedis_harga' => 'Alatmedis Harga',
			'alatmedis_hppperhari' => 'Alatmedis Hppperhari',
			'alatmedis_trgtbep' => 'Alatmedis Trgtbep',
			'alatmedis_trgtbep_sat' => 'Alatmedis Trgtbep Sat',
			'dokterpemeriksa1_id' => 'Dokterpemeriksa1',
			'dokterpemeriksa2_id' => 'Dokterpemeriksa2',
			'dokterpendamping_id' => 'Dokterpendamping',
			'dokteranastesi_id' => 'Dokteranastesi',
			'bidan_id' => 'Bidan',
			'dokterdelegasi_id' => 'Dokterdelegasi',
			'suster_id' => 'Suster',
			'perawat_id' => 'Perawat',
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
			'keterangantindakan' => 'Keterangantindakan',
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
		$criteria->compare('jenisalatmedis_id', $this->jenisalatmedis_id);
		$criteria->compare('jenisalatmedis_nama', $this->jenisalatmedis_nama, true);
		$criteria->compare('alatmedis_id', $this->alatmedis_id);
		$criteria->compare('alatmedis_kode', $this->alatmedis_kode, true);
		$criteria->compare('alatmedis_format', $this->alatmedis_format, true);
		$criteria->compare('alatmedis_nama', $this->alatmedis_nama, true);
		$criteria->compare('alatmedis_merk', $this->alatmedis_merk, true);
		$criteria->compare('no_pendaftaran', $this->no_pendaftaran, true);
		$criteria->compare('tgl_pendaftaran', $this->tgl_pendaftaran, true);
		$criteria->compare('carabayar_id', $this->carabayar_id);
		$criteria->compare('carabayar_nama', $this->carabayar_nama, true);
		$criteria->compare('penjamin_id', $this->penjamin_id);
		$criteria->compare('penjamin_nama', $this->penjamin_nama, true);
		$criteria->compare('instalasi_id', $this->instalasi_id);
		$criteria->compare('instalasi_nama', $this->instalasi_nama, true);
		$criteria->compare('ruangan_id', $this->ruangan_id);
		$criteria->compare('ruangan_nama', $this->ruangan_nama, true);
		$criteria->compare('kelaspelayanan_id', $this->kelaspelayanan_id);
		$criteria->compare('kelaspelayanan_nama', $this->kelaspelayanan_nama, true);
		$criteria->compare('kelastanggungan_id', $this->kelastanggungan_id);
		$criteria->compare('pasien_id', $this->pasien_id);
		$criteria->compare('namadepan', $this->namadepan, true);
		$criteria->compare('nama_pasien', $this->nama_pasien, true);
		$criteria->compare('tempat_lahir', $this->tempat_lahir, true);
		$criteria->compare('tanggal_lahir', $this->tanggal_lahir, true);
		$criteria->compare('no_rekam_medik', $this->no_rekam_medik, true);
		$criteria->compare('jeniskelamin', $this->jeniskelamin, true);
		$criteria->compare('alamat_pasien', $this->alamat_pasien, true);
		$criteria->compare('tindakanpelayanan_id', $this->tindakanpelayanan_id);
		$criteria->compare('tindakansudahbayar_id', $this->tindakansudahbayar_id);
		$criteria->compare('daftartindakan_id', $this->daftartindakan_id);
		$criteria->compare('daftartindakan_nama', $this->daftartindakan_nama, true);
		$criteria->compare('tgl_tindakan', $this->tgl_tindakan, true);
		$criteria->compare('tarif_satuan', $this->tarif_satuan);
		$criteria->compare('tarif_tindakan', $this->tarif_tindakan);
		$criteria->compare('satuantindakan', $this->satuantindakan, true);
		$criteria->compare('qty_tindakan', $this->qty_tindakan);
		$criteria->compare('cyto_tindakan', $this->cyto_tindakan);
		$criteria->compare('tarifcyto_tindakan', $this->tarifcyto_tindakan);
		$criteria->compare('alatmedis_harga', $this->alatmedis_harga);
		$criteria->compare('alatmedis_hppperhari', $this->alatmedis_hppperhari);
		$criteria->compare('alatmedis_trgtbep', $this->alatmedis_trgtbep);
		$criteria->compare('alatmedis_trgtbep_sat', $this->alatmedis_trgtbep_sat, true);
		$criteria->compare('dokterpemeriksa1_id', $this->dokterpemeriksa1_id, true);
		$criteria->compare('dokterpemeriksa2_id', $this->dokterpemeriksa2_id, true);
		$criteria->compare('dokterpendamping_id', $this->dokterpendamping_id, true);
		$criteria->compare('dokteranastesi_id', $this->dokteranastesi_id, true);
		$criteria->compare('bidan_id', $this->bidan_id, true);
		$criteria->compare('dokterdelegasi_id', $this->dokterdelegasi_id, true);
		$criteria->compare('suster_id', $this->suster_id, true);
		$criteria->compare('perawat_id', $this->perawat_id);
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
		$criteria->compare('keterangantindakan', $this->keterangantindakan, true);
		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}
