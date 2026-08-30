<?php

/**
 * This is the model class for table "syaratkhususkontrak_t".
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @author Yudhit Widy Wicaksono <yudhitwicaksono@.com>
 * @package application.models
 * @category model
 * The followings are the available columns in table 'syaratkhususkontrak_t':
 * @property integer $syaratkhususkontrak_id
 * @property string $syaratkhususkontrak_nomor
 * @property string $syaratkhususkontrak_tanggal
 * @property integer $suratperjanjiankerja_id
 * @property integer $pegppk_id
 * @property string $pegppk_nama
 * @property integer $supplier_id
 * @property string $wakilpenyedia_nama
 * @property integer $pegpengawas_id
 * @property string $pegpengawas_nama
 * @property string $cara_pembayaran
 * @property string $pembebanan_tahunanggaran
 * @property string $sumber_pendanaan
 * @property string $jenis_pekerjaan
 * @property string $tanggal_awal
 * @property string $tanggal_akhir
 * @property integer $jangk_waktu
 * @property integer $pemeliharaan_masa
 * @property string $pemeliharaan_satuan
 * @property string $tindakan_accppk
 * @property string $kepemilikan_dokumen
 * @property string $fasilitas
 * @property double $nilai_kontrak
 * @property string $indeks_dikeluarkan
 * @property string $indeks_digunakan
 * @property double $jumlah_indeks
 * @property double $koefisien_tetap
 * @property double $koefisien_kontrak
 * @property boolean $isuangmuka
 * @property double $jumlah_uangmuka
 * @property integer $batas_spp
 * @property string $pencairan_jaminan
 * @property string $dokumen_tagihan
 * @property string $sumber_pembiayan
 * @property string $pembayaran_pekerjaan
 * @property string $jenis_denda
 * @property string $dasar_denda
 * @property string $ketentuan_denda
 * @property string $ganti_rugi
 * @property string $kompensasi
 * @property string $kahar
 * @property integer $umur_konstruksi
 * @property integer $batas_pedoman
 * @property string $standard
 * @property string $pengiriman
 * @property string $asuransi
 * @property string $transportasi
 * @property string $serah_terima
 * @property string $pemeriksaan_pengujian
 * @property string $incoterms
 * @property string $garansi
 * @property string $layanan_tambahan
 * @property string $pelaporan
 * @property string $laporan_akhir
 * @property string $pembatasan_dokumen
 * @property string $tanggungjawab_profesi
 * @property integer $konfigtemplatesurat_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property PegawaiM $pegpengawas
 * @property PegawaiM $pegppk
 * @property SupplierM $supplier
 * @property KonfigtemplatesuratK $konfigtemplatesurat
 * @property SuratperjanjiankerjaT $suratperjanjiankerja
 */
class SyaratkhususkontrakT extends CActiveRecord
{
        public $nosuratperjanjiankerja, $nama_supplier, $alamat_supplier, $notadinasppk_tanggal, $pejabatpembuatkomitmen, $dasar; 
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SyaratkhususkontrakT the static model class
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
		return 'syaratkhususkontrak_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('syaratkhususkontrak_nomor, syaratkhususkontrak_tanggal, suratperjanjiankerja_id, pegppk_id, pegppk_nama, supplier_id, wakilpenyedia_nama, tanggal_awal, tanggal_akhir, jangk_waktu, nilai_kontrak, konfigtemplatesurat_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('suratperjanjiankerja_id, pegppk_id, supplier_id, pegpengawas_id, jangk_waktu, pemeliharaan_masa, batas_spp, umur_konstruksi, batas_pedoman, konfigtemplatesurat_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('nilai_kontrak, jumlah_indeks, koefisien_tetap, koefisien_kontrak, jumlah_uangmuka', 'numerical'),
			array('syaratkhususkontrak_nomor', 'length', 'max'=>20),
			array('pegppk_nama, wakilpenyedia_nama, pegpengawas_nama', 'length', 'max'=>225),
			array('cara_pembayaran, pembebanan_tahunanggaran, sumber_pendanaan, jenis_pekerjaan, indeks_dikeluarkan, indeks_digunakan, pencairan_jaminan', 'length', 'max'=>100),
			array('pemeliharaan_satuan', 'length', 'max'=>10),
			array('jenis_denda, dasar_denda', 'length', 'max'=>50),
			array('sanksi, penyelesaian_perselisihan, tindakan_accppk, kepemilikan_dokumen, fasilitas, isuangmuka, dokumen_tagihan, sumber_pembiayan, pembayaran_pekerjaan, ketentuan_denda, ganti_rugi, kompensasi, kahar, standard, pengiriman, asuransi, transportasi, serah_terima, pemeriksaan_pengujian, incoterms, garansi, layanan_tambahan, pelaporan, laporan_akhir, pembatasan_dokumen, tanggungjawab_profesi, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('syaratkhususkontrak_id, syaratkhususkontrak_nomor, syaratkhususkontrak_tanggal, suratperjanjiankerja_id, pegppk_id, pegppk_nama, supplier_id, wakilpenyedia_nama, pegpengawas_id, pegpengawas_nama, cara_pembayaran, pembebanan_tahunanggaran, sumber_pendanaan, jenis_pekerjaan, tanggal_awal, tanggal_akhir, jangk_waktu, pemeliharaan_masa, pemeliharaan_satuan, tindakan_accppk, kepemilikan_dokumen, fasilitas, nilai_kontrak, indeks_dikeluarkan, indeks_digunakan, jumlah_indeks, koefisien_tetap, koefisien_kontrak, isuangmuka, jumlah_uangmuka, batas_spp, pencairan_jaminan, dokumen_tagihan, sumber_pembiayan, pembayaran_pekerjaan, jenis_denda, dasar_denda, ketentuan_denda, ganti_rugi, kompensasi, kahar, umur_konstruksi, batas_pedoman, standard, pengiriman, asuransi, transportasi, serah_terima, pemeriksaan_pengujian, incoterms, garansi, layanan_tambahan, pelaporan, laporan_akhir, pembatasan_dokumen, tanggungjawab_profesi, konfigtemplatesurat_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'pegpengawas' => array(self::BELONGS_TO, 'PegawaiM', 'pegpengawas_id'),
			'pegppk' => array(self::BELONGS_TO, 'PegawaiM', 'pegppk_id'),
			'supplier' => array(self::BELONGS_TO, 'SupplierM', 'supplier_id'),
			'konfigtemplatesurat' => array(self::BELONGS_TO, 'KonfigtemplatesuratK', 'konfigtemplatesurat_id'),
			'suratperjanjiankerja' => array(self::BELONGS_TO, 'SuratperjanjiankerjaT', 'suratperjanjiankerja_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'syaratkhususkontrak_id' => 'Syaratkhususkontrak',
			'syaratkhususkontrak_nomor' => 'Nomor Transaksi',
			'syaratkhususkontrak_tanggal' => 'Tanggal Transaksi',
			'suratperjanjiankerja_id' => 'Suratperjanjiankerja',
			'pegppk_id' => 'Wakil Sah (PPK)',
			'pegppk_nama' => 'Wakil Sah (PPK)',
			'supplier_id' => 'Supplier',
			'wakilpenyedia_nama' => 'Wakil Sah (Penyedia)',
			'pegpengawas_id' => 'Pengawas Pekerjaan',
			'pegpengawas_nama' => 'Pengawas Pekerjaan',
			'cara_pembayaran' => 'Cara Pembayaran',
			'pembebanan_tahunanggaran' => 'Pembebanan Tahun Anggaran',
			'sumber_pendanaan' => 'Sumber Pendanaan',
			'jenis_pekerjaan' => 'Jenis Pekerjaan',
			'tanggal_awal' => 'Tanggal Awal Kontrak',
			'tanggal_akhir' => 'Tanggal Akhir Kontrak',
			'jangk_waktu' => 'Jangka Waktu Penyelesaian',
			'pemeliharaan_masa' => 'Pemeliharaan Masa',
			'pemeliharaan_satuan' => 'Pemeliharaan Satuan',
			'tindakan_accppk' => 'Tindakan Accppk',
			'kepemilikan_dokumen' => 'Kepemilikan Dokumen',
			'fasilitas' => 'Fasilitas',
			'nilai_kontrak' => 'Nilai Kontrak',
			'indeks_dikeluarkan' => 'Indeks dikeluarkan oleh',
			'indeks_digunakan' => 'Indeks yang dipergunakan oleh',
			'jumlah_indeks' => 'Jumlah Indeks',
			'koefisien_tetap' => 'Jumlah Koefisien Tetap',
			'koefisien_kontrak' => 'Jumlah Koefisien Komponen Kontrak',
			'isuangmuka' => 'Isuangmuka',
			'jumlah_uangmuka' => 'Jumlah Uang Muka',
			'batas_spp' => 'Batas Spp',
			'pencairan_jaminan' => 'Pencairan Jaminan',
			'dokumen_tagihan' => 'Dokumen Tagihan',
			'sumber_pembiayan' => 'Sumber Pembiayan',
			'pembayaran_pekerjaan' => 'Pembayaran Pekerjaan',
			'jenis_denda' => 'Jenis Denda',
			'dasar_denda' => 'Dasar Denda',
			'ketentuan_denda' => 'Ketentuan Denda',
			'ganti_rugi' => 'Ganti Rugi',
			'kompensasi' => 'Kompensasi',
			'kahar' => 'Kahar',
			'umur_konstruksi' => 'Umur Konstruksi',
			'batas_pedoman' => 'Batas Pedoman',
			'standard' => 'Standard',
			'pengiriman' => 'Pengiriman',
			'asuransi' => 'Asuransi',
			'transportasi' => 'Transportasi',
			'serah_terima' => 'Serah Terima',
			'pemeriksaan_pengujian' => 'Pemeriksaan Pengujian',
			'incoterms' => 'Incoterms',
			'garansi' => 'Garansi',
			'layanan_tambahan' => 'Layanan Tambahan',
			'pelaporan' => 'Pelaporan',
			'laporan_akhir' => 'Laporan Akhir',
			'pembatasan_dokumen' => 'Pembatasan Dokumen',
			'tanggungjawab_profesi' => 'Tanggungjawab Profesi',
			'konfigtemplatesurat_id' => 'Template Surat',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
			'nosuratperjanjiankerja' => 'Nomor SPK',
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

		$criteria->compare('syaratkhususkontrak_id',$this->syaratkhususkontrak_id);
		$criteria->compare('syaratkhususkontrak_nomor',$this->syaratkhususkontrak_nomor,true);
		$criteria->compare('syaratkhususkontrak_tanggal',$this->syaratkhususkontrak_tanggal,true);
		$criteria->compare('suratperjanjiankerja_id',$this->suratperjanjiankerja_id);
		$criteria->compare('pegppk_id',$this->pegppk_id);
		$criteria->compare('pegppk_nama',$this->pegppk_nama,true);
		$criteria->compare('supplier_id',$this->supplier_id);
		$criteria->compare('wakilpenyedia_nama',$this->wakilpenyedia_nama,true);
		$criteria->compare('pegpengawas_id',$this->pegpengawas_id);
		$criteria->compare('pegpengawas_nama',$this->pegpengawas_nama,true);
		$criteria->compare('cara_pembayaran',$this->cara_pembayaran,true);
		$criteria->compare('pembebanan_tahunanggaran',$this->pembebanan_tahunanggaran,true);
		$criteria->compare('sumber_pendanaan',$this->sumber_pendanaan,true);
		$criteria->compare('jenis_pekerjaan',$this->jenis_pekerjaan,true);
		$criteria->compare('tanggal_awal',$this->tanggal_awal,true);
		$criteria->compare('tanggal_akhir',$this->tanggal_akhir,true);
		$criteria->compare('jangk_waktu',$this->jangk_waktu);
		$criteria->compare('pemeliharaan_masa',$this->pemeliharaan_masa);
		$criteria->compare('pemeliharaan_satuan',$this->pemeliharaan_satuan,true);
		$criteria->compare('tindakan_accppk',$this->tindakan_accppk,true);
		$criteria->compare('kepemilikan_dokumen',$this->kepemilikan_dokumen,true);
		$criteria->compare('fasilitas',$this->fasilitas,true);
		$criteria->compare('nilai_kontrak',$this->nilai_kontrak);
		$criteria->compare('indeks_dikeluarkan',$this->indeks_dikeluarkan,true);
		$criteria->compare('indeks_digunakan',$this->indeks_digunakan,true);
		$criteria->compare('jumlah_indeks',$this->jumlah_indeks);
		$criteria->compare('koefisien_tetap',$this->koefisien_tetap);
		$criteria->compare('koefisien_kontrak',$this->koefisien_kontrak);
		$criteria->compare('isuangmuka',$this->isuangmuka);
		$criteria->compare('jumlah_uangmuka',$this->jumlah_uangmuka);
		$criteria->compare('batas_spp',$this->batas_spp);
		$criteria->compare('pencairan_jaminan',$this->pencairan_jaminan,true);
		$criteria->compare('dokumen_tagihan',$this->dokumen_tagihan,true);
		$criteria->compare('sumber_pembiayan',$this->sumber_pembiayan,true);
		$criteria->compare('pembayaran_pekerjaan',$this->pembayaran_pekerjaan,true);
		$criteria->compare('jenis_denda',$this->jenis_denda,true);
		$criteria->compare('dasar_denda',$this->dasar_denda,true);
		$criteria->compare('ketentuan_denda',$this->ketentuan_denda,true);
		$criteria->compare('ganti_rugi',$this->ganti_rugi,true);
		$criteria->compare('kompensasi',$this->kompensasi,true);
		$criteria->compare('kahar',$this->kahar,true);
		$criteria->compare('umur_konstruksi',$this->umur_konstruksi);
		$criteria->compare('batas_pedoman',$this->batas_pedoman);
		$criteria->compare('standard',$this->standard,true);
		$criteria->compare('pengiriman',$this->pengiriman,true);
		$criteria->compare('asuransi',$this->asuransi,true);
		$criteria->compare('transportasi',$this->transportasi,true);
		$criteria->compare('serah_terima',$this->serah_terima,true);
		$criteria->compare('pemeriksaan_pengujian',$this->pemeriksaan_pengujian,true);
		$criteria->compare('incoterms',$this->incoterms,true);
		$criteria->compare('garansi',$this->garansi,true);
		$criteria->compare('layanan_tambahan',$this->layanan_tambahan,true);
		$criteria->compare('pelaporan',$this->pelaporan,true);
		$criteria->compare('laporan_akhir',$this->laporan_akhir,true);
		$criteria->compare('pembatasan_dokumen',$this->pembatasan_dokumen,true);
		$criteria->compare('tanggungjawab_profesi',$this->tanggungjawab_profesi,true);
		$criteria->compare('konfigtemplatesurat_id',$this->konfigtemplatesurat_id);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}