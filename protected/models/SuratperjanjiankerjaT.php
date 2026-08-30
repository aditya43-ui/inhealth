<?php

/**
 * This is the model class for table "suratperjanjiankerja_t".
 * The followings are the available columns in table 'suratperjanjiankerja_t':
 * @property integer $suratperjanjiankerja_id
 * @property string $nosuratperjanjiankerja
 * @property string $tglsuratperjanjian
 * @property string $namapekerjaan
 * @property string $tglawal_pekerjaan
 * @property string $tglakhir_pekerjaan
 * @property string $no_putusanpenggunaanggaran
 * @property string $tglputusanpenggunaanggaran
 * @property string $namapembuatkomitmen
 * @property string $noindukpegawai
 * @property string $jabatan
 * @property string $alamat
 * @property integer $supplier_id
 * @property string $nopenawaran
 * @property string $tglpenawaran
 * @property integer $nilaikontrak
 * @property string $tahunanggaran
 * @property string $tgl_dpa
 * @property string $no_dpa
 * @property integer $kegiatanprogram_id
 * @property integer $subkegiatanprogram_id
 * @property integer $rekening5_id
 * @property string $dasarpengerjaan
 * @property integer $pejabatpenggunaanggaran_id
 * @property integer $kuasapenggunaanggaran_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 * 
 * @author   Deni Hamdani <denihamdani@piindonesia.co.id>
 * @author   Andyka Putra <andykaputra@.com>
 * @author   Aida Rahmawati <aidarahmawati@.com>
 * @author   Yusuf Putra Anugrah <yusufputra@.com>
 * @package  application.models
 * @category model
 */
class SuratperjanjiankerjaT extends CActiveRecord
{
    public $supplier_master_nama, $dasar, $total_pagu;
    public $statusnya;
    
    public $nama_supplier;
    public $jabatan_supplier;
    public $alamat_supplier;
    public $nomor_rekening;
    public $cekpenawaran;
    public $supplier_nama;
    public $program_nama;
    public $kegiatan_nama;
    public $nmrekening5;
    public $temp_file;
    public $fileimport, $statusfile;
    

    public $supplier_alamat;
    public $direktursupplier,$waktuselesai;
    

    public $kegiatanprogram_nama;
    public $programkerja_nama;
    public $subprogramkerja_nama;
    public $total_harga,$total_pajak, $total_hargaseluruhnya, $isi_surat;

    public $pejabatpenggunaanggaran_nama, $kuasapenggunaanggaran_nama;
    public $termin;
    public $jumlah_termin;
    public $nama_pekerjaan,$penawaranpenyedia_harga,$persiapanpengadaan_nomor, $penawaranpenyedia_nomor;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SuratperjanjiankerjaT the static model class
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
		return 'suratperjanjiankerja_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nomor_dokumen,tglsuratperjanjian, nosuratperjanjiankerja, namapekerjaan, tglawal_pekerjaan, tglakhir_pekerjaan, no_putusanpenggunaanggaran, tglputusanpenggunaanggaran, namapembuatkomitmen, noindukpegawai, jabatan, alamat, supplier_id, nopenawaran, tglpenawaran, nilaikontrak, tgl_dpa, no_dpa, kegiatanprogram_id, subkegiatanprogram_id, pejabatpenggunaanggaran_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('supplier_id, kegiatanprogram_id, subkegiatanprogram_id, rekening5_id, pejabatpenggunaanggaran_id, kuasapenggunaanggaran_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('nosuratperjanjiankerja, namapembuatkomitmen, noindukpegawai, jabatan, nopenawaran, no_dpa', 'length', 'max'=>100),
			array('namapekerjaan', 'length', 'max'=>500),
			array('no_putusanpenggunaanggaran, alamat', 'length', 'max'=>250),
			array('tahunanggaran', 'length', 'max'=>4),
			array('alasan_perubahan, tanggal_perubahan, pegawai_perubahan, bahasilpl_nomor, suratundanganpl_nomor, pejabatpembuatkomitmen_id, instalasi_id, periodeanggaran_id, persiapanpengadaan_id, penawaranpenyedia_id, konfigtemplatesurat_id, jangka_waktu, mappingrekeninganggaran_id, unitkerja_id, suratperjanjiankerja_catatan, isuangmuka, uangmuka_persen, uangmuka_jumlah, kontrakcarapembayaran, total_pembulatan, nilaikontrak, istermin, jenis_termin, dasarpengerjaan, jumlah_pajak, jumlah_harga, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('suratperjanjiankerja_id, nosuratperjanjiankerja, tglsuratperjanjian, namapekerjaan, tglawal_pekerjaan, tglakhir_pekerjaan, no_putusanpenggunaanggaran, tglputusanpenggunaanggaran, namapembuatkomitmen, noindukpegawai, jabatan, alamat, supplier_id, nopenawaran, tglpenawaran, nilaikontrak, tahunanggaran, tgl_dpa, no_dpa, kegiatanprogram_id, subkegiatanprogram_id, rekening5_id, dasarpengerjaan, pejabatpenggunaanggaran_id, kuasapenggunaanggaran_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
                    'supplier' => array(self::BELONGS_TO, 'SupplierM', 'supplier_id'),
                    'persiapanpengadaan' => array(self::BELONGS_TO, 'PersiapanpengadaanT', 'persiapanpengadaan_id'),
                    'pejabatpembuatkomitmen'=>array(self::BELONGS_TO,'PegawaiM','pejabatpembuatkomitmen_id'),
                    'kuasapenggunaanggaran'=>array(self::BELONGS_TO,'PegawaiM','kuasapenggunaanggaran_id'),
                    'instalasi'=>array(self::BELONGS_TO,'InstalasiM','instalasi_id'),
                    'rekening5'=>array(self::BELONGS_TO,'Rekening5M','rekening5_id'),
                    'unitkerja'=>array(self::BELONGS_TO,'UnitkerjaM','unitkerja_id'),
                    'subkegiatanprogram' => array(self::BELONGS_TO, 'SubkegiatanprogramM', 'subkegiatanprogram_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'suratperjanjiankerja_id' => 'Surat Perjanjian Kerja',
			'nosuratperjanjiankerja' => 'Nomor Transaksi',
			'tglsuratperjanjian' => 'Tanggal Surat',
			'namapekerjaan' => 'Nama Pekerjaan',
			'tglawal_pekerjaan' => 'Tglawal Pekerjaan',
			'tglakhir_pekerjaan' => 'Tglakhir Pekerjaan',
			'no_putusanpenggunaanggaran' => 'No. Putusan PA',
			'tglputusanpenggunaanggaran' => 'Tanggal Putusan',
			'namapembuatkomitmen' => 'PPK',
			'noindukpegawai' => 'Nomor Induk Pegawai',
			'jabatan' => 'Jabatan',
			'alamat' => 'Alamat',
			'supplier_id' => 'Penyedia',
			'nopenawaran' => 'Nomor Penawaran',
			'tglpenawaran' => 'Tanggal Penawaran',
			'nilaikontrak' => 'Nilai Kontrak',
			'tahunanggaran' => 'Tahun Anggaran',
			'tgl_dpa' => 'Tanggal DPA',
			'no_dpa' => 'Nomor DPA',
			'kegiatanprogram_id' => 'Kegiatan',
			'subkegiatanprogram_id' => 'Sub Kegiatan',
			'rekening5_id' => 'Kode Rekening',
			'dasarpengerjaan' => 'Dasarpengerjaan',
			'pejabatpenggunaanggaran_id' => 'Pejabat Pengguna Anggaran',
			'kuasapenggunaanggaran_id' => 'Kuasa Pengguna Anggaran',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
			'penawaranpenyedia_id' => 'Nomor Penawaran',
                        'konfigtemplatesurat_id' => 'Template Surat',
                        'kontrakcarapembayaran' => 'Jenis Kontrak',
                        'alasan_perubahan'=>'Alasan Perubahan',                     
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

		$criteria->compare('suratperjanjiankerja_id',$this->suratperjanjiankerja_id);
		$criteria->compare('nosuratperjanjiankerja',$this->nosuratperjanjiankerja,true);
		$criteria->compare('tglsuratperjanjian',$this->tglsuratperjanjian,true);
		$criteria->compare('namapekerjaan',$this->namapekerjaan,true);
		$criteria->compare('tglawal_pekerjaan',$this->tglawal_pekerjaan,true);
		$criteria->compare('tglakhir_pekerjaan',$this->tglakhir_pekerjaan,true);
		$criteria->compare('no_putusanpenggunaanggaran',$this->no_putusanpenggunaanggaran,true);
		$criteria->compare('tglputusanpenggunaanggaran',$this->tglputusanpenggunaanggaran,true);
		$criteria->compare('namapembuatkomitmen',$this->namapembuatkomitmen,true);
		$criteria->compare('noindukpegawai',$this->noindukpegawai,true);
		$criteria->compare('jabatan',$this->jabatan,true);
        $criteria->compare('alamat',$this->alamat,true);
        $criteria->compare('nomor_dokumen',$this->nomor_dokumen,true);
		$criteria->compare('supplier_id',$this->supplier_id);
		$criteria->compare('nopenawaran',$this->nopenawaran,true);
		$criteria->compare('tglpenawaran',$this->tglpenawaran,true);
		$criteria->compare('nilaikontrak',$this->nilaikontrak);
		$criteria->compare('tahunanggaran',$this->tahunanggaran,true);
		$criteria->compare('tgl_dpa',$this->tgl_dpa,true);
		$criteria->compare('no_dpa',$this->no_dpa,true);
		$criteria->compare('kegiatanprogram_id',$this->kegiatanprogram_id);
		$criteria->compare('subkegiatanprogram_id',$this->subkegiatanprogram_id);
		$criteria->compare('rekening5_id',$this->rekening5_id);
		$criteria->compare('dasarpengerjaan',$this->dasarpengerjaan,true);
		$criteria->compare('pejabatpenggunaanggaran_id',$this->pejabatpenggunaanggaran_id);
		$criteria->compare('kuasapenggunaanggaran_id',$this->kuasapenggunaanggaran_id);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    /**
     * Set nilai awal sebelum form transaksi ditampilkan.
     */
    public function setDefaultData() {
        $cr = new CDbCriteria();
        $cr->addCondition("'".date('Y-m-d')."'::date between tglanggaran and sd_tglanggaran");
        $cr->addCondition('isclosing_closinganggaran = false');
        
        $periode = PeriodeanggaranK::model()->find($cr);
        
        if (!empty($periode)) {
            
            $this->no_putusanpenggunaanggaran = $periode->no_putusanpenggunaanggaran;
            $this->tglputusanpenggunaanggaran = MyFormatter::formatDateTimeForUser($periode->tgl_putusanpenggunaanggaran);
            
            /*if (!empty($periode->pejabatpembuatkomitmen_id)) {
                $peg = PegawaiM::model()->findByPk($periode->pejabatpembuatkomitmen_id);
                $this->namapembuatkomitmen = $peg->namaLengkap;
                $this->noindukpegawai = $peg->nomorindukpegawai;
                $this->alamat = $peg->alamat_pegawai;
                
                if (!empty($peg->jabatan_id)) {
                    $jabatan = JabatanM::model()->findByPk($peg->jabatan_id);
                    $this->jabatan = $jabatan->jabatan_nama;
                }
            }
            
            $this->pejabatpenggunaanggaran_id = $periode->pejabatpenggunaanggaran_id;
            $this->kuasapenggunaanggaran_id = $periode->kuasapenggunaanggaran_id;
            
            $this->tglsuratperjanjian = $this->tglpenawaran 
                = $this->tgl_dpa = MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s'));
            
            $this->tglawal_pekerjaan = date('Y-m-d');
            $this->tglakhir_pekerjaan = date('Y-m-d');
            */
        }
        
    }
    
    /**
     * Simpan data post ke tabel suratperjanjiankerja_t
     * 
     * @param mixed    $post data $_POST transaksi Surat Perjanjian Kerja
     * @return boolean transaksi berhasil dilakukan, false jika gagal.
     */
    public function saveSuratPerjanjian($post) {
        
        $ok = true;
        
        $this->attributes = $post['SuratperjanjiankerjaT'];
        $this->persiapanpengadaan_id = $post['SuratperjanjiankerjaT']['persiapanpengadaan_id'];
        $this->instalasi_id = $post['PersiapanpengadaanT']['instalasi_id'];
        $this->nomor_dokumen = $post['SuratperjanjiankerjaT']['nomor_dokumen'];
        $this->konfigtemplatesurat_id = $post['SuratperjanjiankerjaT']['konfigtemplatesurat_id'];
        if ($post['SuratperjanjiankerjaT']['nosuratperjanjiankerja'] == '--Otomatis--'){
            $this->nosuratperjanjiankerja = MyGenerator::NoSuratPerjanjianKerja();
        }else{
            $this->nosuratperjanjiankerja = $post['SuratperjanjiankerjaT']['nosuratperjanjiankerja'];
        }
        $this->tglputusanpenggunaanggaran = MyFormatter::formatDateTimeForDB($this->tglputusanpenggunaanggaran);
        $this->tgl_dpa = MyFormatter::formatDateTimeForDB($this->tgl_dpa);
        $this->tglpenawaran = MyFormatter::formatDateTimeForDB($this->tglpenawaran);
        $this->tglsuratperjanjian = MyFormatter::formatDateTimeForDB($this->tglsuratperjanjian);
        $this->tglawal_pekerjaan = MyFormatter::formatDateTimeForDB($post['PersiapanpengadaanT']['pelaksanaankontrak_tglawal']);
        $this->tglakhir_pekerjaan = MyFormatter::formatDateTimeForDB($post['PersiapanpengadaanT']['pelaksanaankontrak_tglakhir']);
        $this->suratundanganpl_tanggal = MyFormatter::formatDateTimeForDB($post['SuratperjanjiankerjaT']['suratundanganpl_tanggal']);
        $this->bahasilpl_tanggal = MyFormatter::formatDateTimeForDB($post['SuratperjanjiankerjaT']['bahasilpl_tanggal']);
        $this->suratundanganpl_nomor = $post['SuratperjanjiankerjaT']['suratundanganpl_nomor'];
        $this->bahasilpl_nomor = $post['SuratperjanjiankerjaT']['bahasilpl_nomor'];
        $this->unitkerja_id = $post['PersiapanpengadaanT']['unitkerja_id'];
        $this->suratperjanjiankerja_status = 'SPK Diterbitkan';
        $this->jangka_waktu = $post['SuratperjanjiankerjaT']['jangka_waktu'];
        $this->mappingrekeninganggaran_id = $post['SuratperjanjiankerjaT']['mappingrekeninganggaran_id'];
        
        if (empty($this->suratperjanjiankerja_id)){
            $this->create_time = date('Y-m-d H:i:s');
            $this->create_loginpemakai_id = Yii::app()->user->id;
            $this->create_ruangan = Yii::app()->user->getState('ruangan_id');
        }else{
            $this->update_time = date('Y-m-d H:i:s');
            $this->update_loginpemakai_id = Yii::app()->user->id;
            
            if (isset($_GET['ubah'])){
                $this->tanggal_perubahan = MyFormatter::formatDateTimeForDb($this->tanggal_perubahan);
                $this->pegawai_perubahan = Yii::app()->user->getState('pegawai_id');
            }
            
        }
        
        if ($this->validate()) {
            $ok = $ok && $this->save();
            
            /* Simpan rencana umum pengadaan */
            if (isset($post['PenawaranpenyediadetT'])) {
                foreach ($post['PenawaranpenyediadetT']['detail'] as $key => $value) {
                    $modDet = new SuratperjanjiankerjarincianT;
                    $modDet->attributes = $value;
                    $modDet->suratperjanjiankerja_id = $this->suratperjanjiankerja_id;
                    $modDet->dokumenpelaksanaananggarandet_id = $value['dokumenpelaksanaananggarandet_id'];
                    $modDet->jenis_barang = $value['jenis_barang'];
                    $modDet->barang_id = $value['barang_id'];
                    $modDet->barang_nama = $value['nama_barang'];
                    $modDet->barang_satuan = $value['satuan_barang'];
                    $modDet->barang_jumlah = $value['jumlah_barang'];
                    $modDet->barang_harga = $value['harga_negosiasi'];
                    $modDet->barang_total = $value['jumlah_negosiasi'];
                    $modDet->pajak_jumlah = $value['jumlah_pajak'];
                    $modDet->pajak_persen = $value['pajak_negosiasi'];
                    $modDet->ongkos_kirim = $value['ongkos_kirim'];
                    $modDet->merk = $value['merk'];
                    $modDet->nama_dpa = $value['nama_dpa'];
                    $modDPA = DokumenpelaksanaananggarandetT::model()->findByPk($modDet->dokumenpelaksanaananggarandet_id);
                    $modDPA->sisapagu_pengadaan = $modDPA->sisapagu_pengadaan - ($modDet->barang_total - $value['jumlah_awal']);
                    $modDPA->sisavolume_pengadaan = $modDPA->sisavolume_pengadaan - ($modDet->barang_jumlah - $value['volume_awal']);
                    if ($modDPA->sisapagu_pengadaan > 0){
                        $modDPA->pengadaan_status = false;
                    }
                    $modDet->save() && $modDPA->update(); 
                }
            }
            
            /* Simpan rencana umum pengadaan */
            if (isset($post['ADPersiapanpengadaandetT'])) {
                foreach ($post['ADPersiapanpengadaandetT']['detail'] as $key => $value) {
                    $modDet = new SuratperjanjiankerjarincianT;
                    $modDet->attributes = $value;
                    $modDet->suratperjanjiankerja_id = $this->suratperjanjiankerja_id;
                    $modDet->dokumenpelaksanaananggarandet_id = $value['dokumenpelaksanaananggarandet_id'];
                    $modDet->jenis_barang = $value['jenis_barang'];
                    $modDet->barang_id = $value['barang_id'];
                    $modDet->barang_nama = $value['persiapanpengadaandet_nama'];
                    $modDet->barang_satuan = $value['persiapanpengadaandet_satuan'];
                    $modDet->barang_jumlah = $value['persiapanpengadaandet_volume'];
                    $modDet->barang_harga = $value['harga_estimasi'];
                    $modDet->barang_total = $value['jumlah_harga'];
                    $modDet->pajak_jumlah = $value['jumlah_pajak'];
                    $modDet->pajak_persen = $value['pajak_persen'];
                    $modDet->ongkos_kirim = $value['ongkos_kirim'];
                    $modDet->merk = $value['merk'];
                    $modDet->obatalkes_id = !empty($value['obatalkes_id']) ? $value['obatalkes_id'] : "";
                    $modDet->nama_dpa = $value['nama_dpa'];
                    $modDPA = DokumenpelaksanaananggarandetT::model()->findByPk($modDet->dokumenpelaksanaananggarandet_id);
                    $modDPA->sisapagu_pengadaan = $modDPA->sisapagu_pengadaan - ($modDet->barang_total - $value['jumlah_awal']); 
                    $modDPA->sisavolume_pengadaan = $modDPA->sisavolume_pengadaan - ($modDet->barang_jumlah - $value['volume_awal']);
                    if ($modDPA->sisapagu_pengadaan > 0){
                        $modDPA->pengadaan_status = false;
                    }
                    $modDet->save() && $modDPA->update();                    
                }
            }
            
            /* Simpan rencana umum pengadaan */
            if (isset($post['SuratperjanjiankerjarincianT'])) {
                SuratperjanjiankerjarincianT::model()->deleteAllByAttributes(array('suratperjanjiankerja_id' => $this->suratperjanjiankerja_id));
                foreach ($post['SuratperjanjiankerjarincianT']['detail'] as $key => $value) {
                    $modDet = new SuratperjanjiankerjarincianT;
                    $modDet->attributes = $value;
                    $modDet->suratperjanjiankerja_id = $this->suratperjanjiankerja_id;
                    $modDet->jenis_barang = $value['jenis_barang'];
                    $modDet->barang_id = $value['barang_id'];
                    $modDet->barang_nama = $value['barang_nama'];
                    $modDet->barang_satuan = $value['barang_satuan'];
                    $modDet->barang_jumlah = $value['barang_jumlah'];
                    $modDet->barang_harga = $value['barang_harga'];
                    $modDet->barang_total = $value['barang_total'];
                    $modDet->pajak_jumlah = $value['pajak_jumlah'];
                    $modDet->pajak_persen = $value['pajak_persen'];
                    $modDet->ongkos_kirim = $value['ongkos_kirim'];
                    $modDet->dokumenpelaksanaananggarandet_id = $value['dokumenpelaksanaananggarandet_id'];
                    $modDPA = DokumenpelaksanaananggarandetT::model()->findByPk($modDet->dokumenpelaksanaananggarandet_id);
                    $modDPA->sisapagu_pengadaan = $modDPA->sisapagu_pengadaan - ($modDet->barang_total - $value['jumlah_awal']); 
                    $modDPA->sisavolume_pengadaan = $modDPA->sisavolume_pengadaan - ($modDet->barang_jumlah - $value['volume_awal']);
                    if ($modDPA->sisapagu_pengadaan > 0){
                        $modDPA->pengadaan_status = false;
                    }
                    $modDet->save() && $modDPA->update();
                }
            }
            
            /**
             * Simpan Termin
             * Saat save termin, termin yang lama akan dihapus dan diganti dengan yang baru.
             * Berlaku ketika istermin false maupun istermin true 
             */
            if ($post['SuratperjanjiankerjaT']['istermin'] == 1) {
                $modTerminLoad = SuratperjanjiankerjaterminT::model()->findByAttributes(array('suratperjanjiankerja_id' => $this->suratperjanjiankerja_id));
                if (!empty($modTerminLoad)) {
                    SuratperjanjiankerjaterminT::model()->deleteAllByAttributes(array('suratperjanjiankerja_id' => $this->suratperjanjiankerja_id));
                }
                foreach ($post['SuratperjanjiankerjaterminT'] as $i => $mod) {
                    $modTermin = new SuratperjanjiankerjaterminT();
                    $modTermin->attributes = $mod;
                    $modTermin->suratperjanjiankerja_id = $this->suratperjanjiankerja_id;
                    if($mod['termintanggal_awal'] == ""){
                        $modTermin->termintanggal_awal = null;
                    }else{
                        $modTermin->termintanggal_awal = MyFormatter::formatDateTimeForDB($mod['termintanggal_awal']);
                    }
                    if($mod['termintanggal_akhir'] == ""){
                        $modTermin->termintanggal_akhir = null;
                    }else{
                        $modTermin->termintanggal_akhir = MyFormatter::formatDateTimeForDB($mod['termintanggal_akhir']);
                    }
                    $modTermin->save();
                }
            } else {
                $modTerminLoad = SuratperjanjiankerjaterminT::model()->findByAttributes(array('suratperjanjiankerja_id' => $this->suratperjanjiankerja_id));
                if (!empty($modTerminLoad)) {
                    SuratperjanjiankerjaterminT::model()->deleteAllByAttributes(array('suratperjanjiankerja_id' => $this->suratperjanjiankerja_id));
                }
                $modTermin = new SuratperjanjiankerjaterminT();
                $modTermin->suratperjanjiankerja_id = $this->suratperjanjiankerja_id;
                $modTermin->terminke = 'I';
                $modTermin->jumlah_persen = '100';
                $modTermin->jumlah_harga = $this->total_pembulatan;
                $modTermin->urutan = '1';
                $modTermin->termintanggal_awal = MyFormatter::formatDateTimeForDB($post['PersiapanpengadaanT']['pelaksanaankontrak_tglawal']);
                $modTermin->termintanggal_akhir = MyFormatter::formatDateTimeForDB($post['PersiapanpengadaanT']['pelaksanaankontrak_tglakhir']);
                $modTermin->save();
            }
            
            $modSupplier = SupplierM::model()->findByPk($this->supplier_id);
            $modSupplier->supplier_norekening = $this->nomor_rekening;
            $modSupplier->save(); 
        } else {
            $ok = false;
        }
        
        return $ok;
    }
    
    /**
     * Simpan data pasal untuk surat perjanjian.
     * 
     * @param mixed    $post data $_POST transaksi Pasal Surat Perjanjian
     * @return boolean transaksi berhasil dilakukan, false jika gagal.
     */
    public function savePasalPerjanjian($post) {
        $ok = true;
        foreach ($post as $pasalperjanjian_id => $item) {
            $pasal = new SuratperjanjiankerjadetT;
            
            $pasal->suratperjanjiankerja_id = $this->suratperjanjiankerja_id;
            $pasal->pasalperjanjian_id = $pasalperjanjian_id;
            $pasal->pasalperjanjian_isi = $item['isi'];
            
            $pasal->create_time = date('Y-m-d H:i:s');
            $pasal->create_loginpemakai_id = Yii::app()->user->id;
            $pasal->create_ruangan = Yii::app()->user->getState('ruangan_id');
            
            if ($pasal->validate()) {
                $ok = $ok && $pasal->save();
            } else {
                $ok = false;
            }
        }
        
        return $ok;
    }
    
    /**
     * digunakan untuk pencarian berdasarkan no spk
     * @return \CActiveDataProvider filter search dialog
     */
    public function searchSPK()
    {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=new CDbCriteria;
            $criteria->select="t.*,to_char(t.tglawal_pekerjaan, 'DD MON YYYY') as tglawal_pekerjaan,to_char(t.tglakhir_pekerjaan, 'DD MON YYYY') as tglakhir_pekerjaan,to_char(t.tglsuratperjanjian, 'DD MON YYYY') as tglsuratperjanjian,sp.* as waktuselesai,to_char((t.tglakhir_pekerjaan - t.tglawal_pekerjaan),'DD') as waktuselesai";
            $criteria->join="left join supplier_m sp on t.supplier_id=sp.supplier_id";
            $criteria->compare('LOWER(t.nosuratperjanjiankerja)',strtolower($this->namapekerjaan),true);
            $criteria->compare('LOWER(t.namapekerjaan)',strtolower($this->namapekerjaan),true);
            $criteria->compare('t.persiapanpengadaan_id',$this->persiapanpengadaan_id);

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
    }
    
    /**
     * Search Dialog verifikasi keuangan
     * @return \CActiveDataProvider
     */
    public function searchDialogForVerikasiKeuangan(){
        $criteria=new CDbCriteria;
        if (!empty($this->periodeanggaran_id)) {
            $criteria->addCondition("t.periodeanggaran_id = ".$this->periodeanggaran_id); 
        } else {
            $criteria->addCondition("t.suratperjanjiankerja_id is null");
        }
        $criteria->compare("LOWER(t.nosuratperjanjiankerja)", strtolower($this->nosuratperjanjiankerja),true);
        $criteria->compare("LOWER(t.nomor_dokumen)", strtolower($this->nomor_dokumen),true);
        $criteria->compare("LOWER(t.namapekerjaan)", strtolower($this->namapekerjaan),true);
        $criteria->addCondition(" (t.suratperjanjiankerja_status NOT IN ('".Params::STATUS_SPK_TERBAYAR."'))");
        $criteria->order = " t.tglsuratperjanjian ASC";
        
        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
        ));
    }
    
    /**
     * Search Dialog jadwal pemeriksaan pekerjaan
     * @return \CActiveDataProvider
     */
    public function searchDialog(){
        $criteria=new CDbCriteria;
        $criteria->select = " t.*, s.supplier_nama ";
        $criteria->join = " JOIN supplier_m s ON s.supplier_id = t.supplier_id ";
        $criteria->compare("LOWER(t.nosuratperjanjiankerja)", strtolower($this->nosuratperjanjiankerja),true);
        $criteria->compare("LOWER(t.nomor_dokumen)", strtolower($this->nomor_dokumen),true);
        $criteria->compare("LOWER(t.namapekerjaan)", strtolower($this->namapekerjaan),true);
        $criteria->compare("LOWER(t.supplier_nama)", strtolower($this->supplier_nama),true);
//        $criteria->addCondition(" (t.suratperjanjiankerja_status NOT IN ('".Params::STATUS_SPK_TERVERIFIKASI."','".Params::STATUS_SPK_TERBAYAR."') ) ");
        $criteria->order = " t.nosuratperjanjiankerja ASC, t.nomor_dokumen ASC ";
        
        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
        ));
    }
    
    
    public function searchRincianSuratDenda(){
        $cri = new CDbCriteria();
        $cri->addCondition(" suratperjanjiankerja_id =".$this->suratperjanjiankerja_id);
        $cri->order = " t.barang_nama ASC ";
        return new CActiveDataProvider($this, array(
            'criteria'=>$cri,
            'pagination'=>false
        ));
    }
    
    /**
     * Load data tabel riwayat penawaran pada halaman registrasi supplier
     * @return \CActiveDataProvider
     */
    public function searchRiwayatSupplier(){
        $criteria = new CDbCriteria;
        $criteria->addCondition("t.supplier_id = ".Yii::app()->user->getState('supplier_id'));
        $criteria->select = "info.nama_pekerjaan, info.persiapanpengadaan_nomor, t.nosuratperjanjiankerja, t.suratperjanjiankerja_status, "
                          . "penawaran.penawaranpenyedia_harga, penawaran.penawaranpenyedia_nomor";
        $criteria->join = " JOIN informasipersiapanpengadaan_v info ON t.persiapanpengadaan_id = info.persiapanpengadaan_id"
                        . " JOIN penawaranpenyedia_t penawaran ON t.penawaranpenyedia_id = penawaran.penawaranpenyedia_id";
        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
    
}