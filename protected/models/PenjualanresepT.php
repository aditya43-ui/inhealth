<?php

/**
 * This is the model class for table "penjualanresep_t".
 *
 * The followings are the available columns in table 'penjualanresep_t':
 * @property integer $penjualanresep_id
 * @property integer $reseptur_id
 * @property integer $pasienadmisi_id
 * @property integer $penjamin_id
 * @property integer $carabayar_id
 * @property integer $pendaftaran_id
 * @property integer $ruangan_id
 * @property integer $pegawai_id
 * @property integer $kelaspelayanan_id
 * @property integer $pasien_id
 * @property string $tglpenjualan
 * @property string $jenispenjualan
 * @property string $tglresep
 * @property string $noresep
 * @property double $totharganetto
 * @property double $totalhargajual
 * @property double $totaltarifservice
 * @property double $biayaadministrasi
 * @property double $biayakonseling
 * @property double $pembulatanharga
 * @property double $jasadokterresep
 * @property string $instalasiasal_nama
 * @property string $ruanganasal_nama
 * @property double $discount
 * @property double $subsidiasuransi
 * @property double $subsidipemerintah
 * @property double $subsidirs
 * @property double $iurbiaya
 * @property integer $lamapelayanan
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property integer $permohonanoa_id
 */
class PenjualanresepT extends CActiveRecord
{
	// variabel attrributes ini digunakan pada _search laporan jasa services di (Farmasi Apotek)
	public $tgl_awal, $tgl_akhir, $bln_awal, $bln_akhir, $thn_awal, $thn_akhir, $jns_periode, $no_rekam_medik, $nama_pasien, $no_pendaftaran, $jumlah, $data, $tick;
	public $noFaktur, $tandaBuktiBayar, $ppds_id, $ppds_nama, $is_sendiri;
	public $isdiserahkan_ke_petugas_ruangan;
	// ======
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PenjualanresepT the static model class
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
		return 'penjualanresep_t';
	}
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('penjamin_id, carabayar_id, ruangan_id, pasien_id, tglpenjualan, totharganetto, totalhargajual, totaltarifservice, biayaadministrasi, biayakonseling, pembulatanharga, ruanganasal_nama, discount, subsidiasuransi, subsidipemerintah, subsidirs, iurbiaya, carabayarpegawai', 'required'),
			array('pasienprofilrs_id, pasieninstalasiunit_id, pasienpegawai_id, reseptur_id, pasienadmisi_id, penjamin_id, carabayar_id, pendaftaran_id, ruangan_id, pegawai_id, kelaspelayanan_id, pasien_id, lamapelayanan, antrianfarmasi_id, permohonanoa_id', 'numerical', 'integerOnly' => true),
			array('totharganetto, totalhargajual, totaltarifservice, biayaadministrasi, biayakonseling, pembulatanharga, jasadokterresep, discount, subsidiasuransi, subsidipemerintah, subsidirs, iurbiaya, takaranresep, totalppn, jasapelayanan_farmasi', 'numerical'),
			array('jenispenjualan, instalasiasal_nama, ruanganasal_nama', 'length', 'max' => 100),
			array('noresep', 'length', 'max' => 50),
			array('tglresep, update_time, update_loginpemakai_id,isresepperawatan, statusobat, tglsedangdisiapkan, tglselesaidisiapkan, tglpenyerahan, namapenerimaobat, notelppenerimaobat, namaygmenyerahkan, ketpenyerahan, keterangan, carabayarpegawai, keterangancarabayar, harga_id, teknik_id, kemas_id, pegawaibelum_id, pegawaisedang_id, kiepenyerahan, ttdpenyerahan, pegpenyerahan_id, kodepetugas_inv', 'safe'),
			array('create_time', 'default', 'value' => date('Y-m-d H:i:s'), 'setOnEmpty' => false, 'on' => 'insert'),
			array('update_time', 'default', 'value' => date('Y-m-d H:i:s'), 'setOnEmpty' => false, 'on' => 'update,insert'),
			array('create_loginpemakai_id', 'default', 'value' => Yii::app()->user->id, 'on' => 'insert'),
			array('update_loginpemakai_id', 'default', 'value' => Yii::app()->user->id, 'on' => 'update,insert'),
			array('create_ruangan', 'default', 'value' => Yii::app()->user->getState('ruangan_id'), 'on' => 'insert'),
			array('jenislayanan_inv, tempatlayanan_inv, kodedokter_inventory', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('antrianfarmasi_id,penjualanresep_id, reseptur_id, pasienadmisi_id, penjamin_id, carabayar_id, pendaftaran_id, ruangan_id, pegawai_id, kelaspelayanan_id, pasien_id, tglpenjualan, jenispenjualan, tglresep, noresep, totharganetto, totalhargajual, totaltarifservice, biayaadministrasi, biayakonseling, pembulatanharga, jasadokterresep, instalasiasal_nama, ruanganasal_nama, discount, subsidiasuransi, subsidipemerintah, subsidirs, iurbiaya, lamapelayanan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, permohonanoa_id, takaranresep, isresepperawatan, statusobat, tglsedangdisiapkan, tglselesaidisiapkan, tglpenyerahan, namapenerimaobat, notelppenerimaobat, namaygmenyerahkan, ketpenyerahan, totalppn, jasapelayanan_farmasi, harga_id, teknik_id, kemas_id, pegawaibelum_id, pegawaisedang_id, kiepenyerahan, ttdpenyerahan', 'safe', 'on' => 'search'),
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
			'reseptur' => array(self::BELONGS_TO, 'ResepturT', 'reseptur_id'),
			'detailresep' => array(self::HAS_MANY, 'ResepturdetailT', array('reseptur_id' => 'reseptur_id'), 'through' => 'reseptur'),
			'obatalkes' => array(self::HAS_MANY, 'ObatalkesM', array('obatalkes_id', 'obatalkes_id'), 'through' => 'detailresep'),
			'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
			'pasienpegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pasienpegawai_id'),
			'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
			'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
			'ruangan' => array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
			'createruangan' => array(self::BELONGS_TO, 'RuanganM', 'create_ruangan'),
			'carabayar' => array(self::BELONGS_TO, 'CarabayarM', 'carabayar_id'),
			'penjamin' => array(self::BELONGS_TO, 'PenjaminpasienM', 'penjamin_id'),
			'antrianfarmasi' => array(self::BELONGS_TO, 'AntrianfarmasiT', 'antrianfarmasi_id'),
			'dokterpeg' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
			'kelaspelayanan' => array(self::BELONGS_TO, 'KelaspelayananM', 'kelaspelayanan_id'),
			'createlogin' => array(self::BELONGS_TO, 'PegawaiM', 'create_loginpemakai_id'),
			'loginpemakai' => array(self::BELONGS_TO, 'LoginpemakaiK', 'create_loginpemakai_id'),
		);
	}
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'penjualanresep_id' => 'Penjualan Resep',
			'reseptur_id' => 'Reseptur',
			'pasienadmisi_id' => 'Pasienadmisi',
			'penjamin_id' => 'Penjamin',
			'carabayar_id' => 'Jenis Pasien',
			'pendaftaran_id' => 'Pendaftaran',
			'ruangan_id' => 'Ruangan',
			'pegawai_id' => 'Dokter Resep',
			'kelaspelayanan_id' => 'Kelas Pelayanan',
			'pasien_id' => 'Pasien',
			'tglpenjualan' => 'Tanggal Penjualan',
			'jenispenjualan' => 'Jenis Penjualan',
			'tglresep' => 'Tanggal Resep',
			'noresep' => 'No. Resep',
			'totharganetto' => 'Total Harga Netto',
			'totalhargajual' => 'Total Harga Jual',
			'totaltarifservice' => 'Total Tarif Service',
			'biayaadministrasi' => 'Biaya Administrasi',
			'biayakonseling' => 'Biaya Konseling',
			'pembulatanharga' => 'Pembulatan Harga',
			'jasadokterresep' => 'Jasa Dokter Resep',
			'instalasiasal_nama' => 'Instalasi Asal',
			'ruanganasal_nama' => 'Ruangan Asal',
			'discount' => 'Keringanan',
			'subsidiasuransi' => 'Tanggungan Asuransi',
			'subsidipemerintah' => 'Tanggungan Pemerintah',
			'subsidirs' => 'Tanggungan Rumah Sakit',
			'iurbiaya' => 'Iur Biaya',
			'lamapelayanan' => 'Lama Pelayanan',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'pasienprofilrs_id' => 'Profil RS',
			'pasieninstalasiunit_id' => 'Instalasi',
			'takaranresep' => 'Takaran Resep',
			'isresepperawatan' => 'Resep Perawatan',
			'tglpenyerahan' => 'Tangal Penyerahan',
			'namapenerimaobat' => 'Nama Penerima Obat',
			'notelppenerimaobat' => 'No Telp Penerima Obat',
			'namaygmenyerahkan' => 'Nama Yang Menyerahkan',
			'ketpenyerahan' => 'Keterangan Penyerahan',
			'keterangancarabayar' => 'Keterangan Cara Bayar',
			'kiepenyerahan' => 'Penyerahan Obat + KIE',
			'penelaahanobat' => 'Penelaahan Obat',
			'menerimaobatinformasi' => 'Menerima Obat Beserta Informasi',
			'petugasfarmasi' => 'Petugas Farmasi',
			'disetuju' => 'Disetujui',
			'is_cito'=> 'ResepCITO',
			'pegpenyerahan_id' => 'Petugas Menyerahkan',
			'jenislayanan_inv' => "Jenis Layanan",
			'tempatlayanan_inv' => 'Tempat Layanan',
			'kodedokter_inventory' => 'Dokter',
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
		$criteria->compare('penjualanresep_id', $this->penjualanresep_id);
		$criteria->compare('reseptur_id', $this->reseptur_id);
		$criteria->compare('pasienadmisi_id', $this->pasienadmisi_id);
		$criteria->compare('penjamin_id', $this->penjamin_id);
		$criteria->compare('carabayar_id', $this->carabayar_id);
		$criteria->compare('pendaftaran_id', $this->pendaftaran_id);
		$criteria->compare('ruangan_id', $this->ruangan_id);
		$criteria->compare('pegawai_id', $this->pegawai_id);
		$criteria->compare('kelaspelayanan_id', $this->kelaspelayanan_id);
		$criteria->compare('pasien_id', $this->pasien_id);
		$criteria->compare('LOWER(tglpenjualan)', strtolower($this->tglpenjualan), true);
		$criteria->compare('LOWER(jenispenjualan)', strtolower($this->jenispenjualan), true);
		$criteria->compare('LOWER(tglresep)', strtolower($this->tglresep), true);
		$criteria->compare('LOWER(noresep)', strtolower($this->noresep), true);
		$criteria->compare('totharganetto', $this->totharganetto);
		$criteria->compare('totalhargajual', $this->totalhargajual);
		$criteria->compare('totaltarifservice', $this->totaltarifservice);
		$criteria->compare('biayaadministrasi', $this->biayaadministrasi);
		$criteria->compare('biayakonseling', $this->biayakonseling);
		$criteria->compare('pembulatanharga', $this->pembulatanharga);
		$criteria->compare('jasadokterresep', $this->jasadokterresep);
		$criteria->compare('LOWER(instalasiasal_nama)', strtolower($this->instalasiasal_nama), true);
		$criteria->compare('LOWER(ruanganasal_nama)', strtolower($this->ruanganasal_nama), true);
		$criteria->compare('discount', $this->discount);
		$criteria->compare('subsidiasuransi', $this->subsidiasuransi);
		$criteria->compare('subsidipemerintah', $this->subsidipemerintah);
		$criteria->compare('subsidirs', $this->subsidirs);
		$criteria->compare('iurbiaya', $this->iurbiaya);
		$criteria->compare('lamapelayanan', $this->lamapelayanan);
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
		$criteria->compare('penjualanresep_id', $this->penjualanresep_id);
		$criteria->compare('reseptur_id', $this->reseptur_id);
		$criteria->compare('pasienadmisi_id', $this->pasienadmisi_id);
		$criteria->compare('penjamin_id', $this->penjamin_id);
		$criteria->compare('carabayar_id', $this->carabayar_id);
		$criteria->compare('pendaftaran_id', $this->pendaftaran_id);
		$criteria->compare('ruangan_id', $this->ruangan_id);
		$criteria->compare('pegawai_id', $this->pegawai_id);
		$criteria->compare('kelaspelayanan_id', $this->kelaspelayanan_id);
		$criteria->compare('pasien_id', $this->pasien_id);
		$criteria->compare('LOWER(tglpenjualan)', strtolower($this->tglpenjualan), true);
		$criteria->compare('LOWER(jenispenjualan)', strtolower($this->jenispenjualan), true);
		$criteria->compare('LOWER(tglresep)', strtolower($this->tglresep), true);
		$criteria->compare('LOWER(noresep)', strtolower($this->noresep), true);
		$criteria->compare('totharganetto', $this->totharganetto);
		$criteria->compare('totalhargajual', $this->totalhargajual);
		$criteria->compare('totaltarifservice', $this->totaltarifservice);
		$criteria->compare('biayaadministrasi', $this->biayaadministrasi);
		$criteria->compare('biayakonseling', $this->biayakonseling);
		$criteria->compare('pembulatanharga', $this->pembulatanharga);
		$criteria->compare('jasadokterresep', $this->jasadokterresep);
		$criteria->compare('LOWER(instalasiasal_nama)', strtolower($this->instalasiasal_nama), true);
		$criteria->compare('LOWER(ruanganasal_nama)', strtolower($this->ruanganasal_nama), true);
		$criteria->compare('discount', $this->discount);
		$criteria->compare('subsidiasuransi', $this->subsidiasuransi);
		$criteria->compare('subsidipemerintah', $this->subsidipemerintah);
		$criteria->compare('subsidirs', $this->subsidirs);
		$criteria->compare('iurbiaya', $this->iurbiaya);
		$criteria->compare('lamapelayanan', $this->lamapelayanan);
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
	//        beforeValidate() dan afterFind() jangan digunakan lagi disemua module
	//        protected function beforeValidate ()
	//        {
	//            // convert to storage format
	//            //$this->tglrevisimodul = date ('Y-m-d', strtotime($this->tglrevisimodul));
	//            $format = new MyFormatter();
	//            //$this->tglrevisimodul = $format->formatDateTimeForDb($this->tglrevisimodul);
	//            foreach($this->metadata->tableSchema->columns as $columnName => $column){
	//                    if ($column->dbType == 'date'){
	//                            $this->$columnName = $format->formatDateTimeForDb($this->$columnName);
	//                    }elseif ($column->dbType == 'timestamp without time zone'){
	//                            //$this->$columnName = date('Y-m-d H:i:s', CDateTimeParser::parse($this->$columnName, Yii::app()->locale->dateFormat));
	//                            $this->$columnName = $format->formatDateTimeForDb($this->$columnName);
	//                    }
	//            }
	//
	//            return parent::beforeValidate ();
	//        }
	//
	//        protected function afterFind(){
	//            foreach($this->metadata->tableSchema->columns as $columnName => $column){
	//
	//                if (!strlen($this->$columnName)) continue;
	//
	//                if ($column->dbType == 'date'){
	//                        $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
	//                                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd'),'medium',null);
	//                        }elseif ($column->dbType == 'timestamp without time zone'){
	//                                $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
	//                                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd hh:mm:ss','medium',null));
	//                        }
	//            }
	//            return true;
	//        }
	public function getDokterReseps()
	{
		return DokterV::model()->findAll();
	}
	/**
	 * handling no faktur relasi penjualan resep di pakai d:
	 * 1. informasi penjualan bebas luar module biling kasir
	 * 2. Laporan Jasa Service
	 * @return string
	 */
	public function getNoFaktur()
	{
		$criteria = new CDbCriteria();
		$criteria->compare('penjualanresep_id', $this->penjualanresep_id);
		$criteria->addCondition('oasudahbayar_id is null');
		$jumlahObatAlkesPasien = ObatalkespasienT::model()->count($criteria);
		if (!(bool)$jumlahObatAlkesPasien) {
			$noFaktur = ObatalkespasienT::model()->findByAttributes(array('penjualanresep_id' => $this->penjualanresep_id))->oasudahbayar->pembayaranpelayanan;
			$this->tandaBuktiBayar = $noFaktur->tandabuktibayar_id;
			return $noFaktur->nopembayaran;
		}
	}
	/**
	 * handling tgl faktur relasi penjualan resep di pakai d :
	 * 1. informasi penjualan bebas luar module biling kasir
	 * 2. Laporan Jasa Service
	 * @return string
	 */
	public function getTglFaktur()
	{
		$criteria = new CDbCriteria();
		$criteria->compare('penjualanresep_id', $this->penjualanresep_id);
		$criteria->addCondition('oasudahbayar_id is null');
		$jumlahObatAlkesPasien = ObatalkespasienT::model()->count($criteria);
		if (!(bool)$jumlahObatAlkesPasien) {
			$noFaktur = ObatalkespasienT::model()->findByAttributes(array('penjualanresep_id' => $this->penjualanresep_id))->oasudahbayar->pembayaranpelayanan;
			$this->tandaBuktiBayar = $noFaktur->tandabuktibayar_id;
			return $noFaktur->tglpembayaran;
		}
	}
}
