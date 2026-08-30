<?php

/**
 * This is the model class for table "infokantongdarah_v".
 *
 * The followings are the available columns in table 'infokantongdarah_v':  
 * 
 * @package models
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @author Rusdiyanto <rusdiyanto@.com>
 * @author Elham Budianto <elhambudianto@.com>
 * @version     2.0.0
 * @link    <http://172.9.1.15/simpp/docs/>
 * @link    <http://piindonesia.co.id> 
 * @category model
 * @property integer $pendonor_id
 * @property string $no_pendonor
 * @property string $jenisidentitas
 * @property string $no_identitas
 * @property string $nama_lengkap
 * @property string $tempat_lahir
 * @property string $tgllahir
 * @property string $jenis_kelamin
 * @property string $alamat_lengkap
 * @property double $beratbadan_kg
 * @property double $tinggibadan_cm
 * @property string $notelp_pendonor
 * @property string $nomobile_pendonor
 * @property string $statusperkawinan
 * @property string $gol_darah
 * @property string $rhesus
 * @property integer $daftardonasi_id
 * @property string $no_formulir
 * @property string $waktu_pendaftaran
 * @property string $keterangan_donasi
 * @property integer $donasi_ke
 * @property integer $ruangandaftar_id
 * @property string $ruangandaftar_nama
 * @property integer $petugasdaftar_id
 * @property string $petugasdaftar_nip
 * @property string $petugasdaftar_gelardepan
 * @property string $petugasdaftar_nama
 * @property integer $gelarpendaftar_id
 * @property string $gelarpendaftar_nama
 * @property integer $jabatanpendaftar_id
 * @property string $jabatanpendaftar_nama
 * @property integer $ruangancatat_id
 * @property integer $kantongdarah_id
 * @property string $tglpencatatan
 * @property string $no_kantongdarah
 * @property string $ruangancatat_nama
 * @property integer $petugascatat_id
 * @property string $petugascatat_nip
 * @property string $petugascatat_gelardepan
 * @property string $petugascatat_nama
 * @property integer $gelarpencatat_id
 * @property string $gelarpencatat_nama
 * @property integer $jabatanpencatat_id
 * @property string $jabatanpencatat_nama
 * @property integer $jeniskantongdarah_id
 * @property string $nama_jenis
 * @property string $nama_jenis_sngkt
 * @property integer $komponendarah_id
 * @property string $namakomponendrh
 * @property string $singkatan_komp  
 * @property integer $jmlprint_barcode
 * @property string $nomorbarcode_sample
 * @property integer $terimakantongdarah_id
 * @property integer $skriningimltd_id
 * @property string $tglskrining
 * @property boolean $hbsag
 * @property boolean $antihiv
 * @property boolean $antihvc
 * @property boolean $sifilis
 * @property string $ket_skrining
 * @property integer $petugasskrining_id
 * @property string $petugasskrining_nip
 * @property string $petugasskrining_gelardepan
 * @property string $petugasskrining_nama
 * @property integer $gelarskrining_id
 * @property string $gelarskrining_nama
 * @property integer $jabatanskrining_id
 * @property string $jabatanskrining_nama
 * @property integer $pengujiandarah_id
 * @property string $tglpengujian
 * @property integer $petugaspengujian_id
 * @property string $petugaspengujian_nip
 * @property string $petugaspengujian_gelardepan
 * @property string $petugaspengujian_nama
 * @property integer $gelarpengujian_id
 * @property string $gelarpengujian_nama
 * @property integer $jabatanpengujian_id
 * @property string $jabatanpengujian_nama
 * @property string $anti_a
 * @property string $anti_b
 * @property string $anti_d
 * @property string $anti_ab
 * @property string $sel_a
 * @property string $sel_b
 * @property string $sel_o
 * @property string $hasil_uji
 * @property string $ket_hasiluji
 * @property string $periksakomponendarah_id
 * @property string $tglperiksakompdarah
 * @property integer $petugasperiksa_id
 * @property string $petugasperiksa_nip
 * @property string $petugasperiksa_gelardepan
 * @property string $petugasperiksa_nama
 * @property integer $gelarperiksa_id
 * @property string $gelarperiksa_nama
 * @property integer $jabatanperiksa_id
 * @property string $jabatanperiksa_nama
 * @property string $komponen_wb
 * @property string $komponen_prc
 * @property string $komponen_tc
 * @property string $komponen_ffp
 * @property string $periksakomp_ket
 * @property integer $luluskomponendarah_id
 * @property string $tglpelulusan
 * @property string $statuspelulusan
 * @property integer $koordinatormutu_id
 * @property string $koordinatormutu_nip
 * @property string $koordinatormutu_gelardepan
 * @property string $koordinatormutu_nama
 * @property integer $gelarkoordinator_id
 * @property string $gelarkoordinator_nama
 * @property integer $jabatankoordinator_id
 * @property string $jabatankoordinator_nama
 * @property integer $kepalainstalasi_id
 * @property string $kepalainstalasi_nip
 * @property string $kepalainstalasi_gelardepan
 * @property string $kepalainstalasi_nama
 * @property integer $gelarkasi_id
 * @property string $gelarkasi_nama
 * @property integer $jabatankasi_id
 * @property string $jabatankasi_nama
 * @property string $keteranganpelulusan
 */
class InfokantongdarahV extends CActiveRecord
{
        public $tgl_awal, $tgl_akhir, $terimakantongdet_id;
        public $tglterimakantong, $komponen_pcr;
        public $ruangankirim_nama, $ruangankirim_id;
        public $ruanganterima_nama, $ruanganterima_id;
        public $hasilskrining, $hasilkomponen, $daftarpendonor_id;        
        public $volume, $no_penggunaan_coolbox, $coolboxdarah_nama, $coolboxdarah_id;
        public $tglmulaiobservasi, $durasi_penyadapan, $is_batalpenyadapan, $hasil_pembuatan; 
        public $nomorbarcode_sample_imltd, $tgl_skrining;
        public $sampel_konfirmasi, $sampel_imltd, $hasil_pengujian, $tanggal_pengujian, $no_kantongpabrik;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InfokantongdarahV the static model class
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
		return 'infokantongdarah_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendonor_id, daftardonasi_id, donasi_ke, ruangandaftar_id, petugasdaftar_id, gelarpendaftar_id, jabatanpendaftar_id, ruangancatat_id, kantongdarah_id, petugascatat_id, gelarpencatat_id, jabatanpencatat_id, jeniskantongdarah_id, komponendarah_id, jmlprint_barcode, terimakantongdarah_id, skriningimltd_id, petugasskrining_id, gelarskrining_id, jabatanskrining_id, pengujiandarah_id, petugaspengujian_id, gelarpengujian_id, jabatanpengujian_id, petugasperiksa_id, gelarperiksa_id, jabatanperiksa_id, luluskomponendarah_id, koordinatormutu_id, gelarkoordinator_id, jabatankoordinator_id, kepalainstalasi_id, gelarkasi_id, jabatankasi_id', 'numerical', 'integerOnly'=>true),
			array('beratbadan_kg, tinggibadan_cm', 'numerical'),
			array('no_pendonor, no_identitas, no_formulir, ruangandaftar_nama, petugasdaftar_nama, ruangancatat_nama, petugascatat_nama, petugasskrining_nama, petugaspengujian_nama, anti_a, anti_b, anti_d, anti_ab, sel_a, sel_b, sel_o, hasil_uji, petugasperiksa_nama, komponen_wb, komponen_prc, komponen_tc, komponen_ffp,komponen_pcr, koordinatormutu_nama, kepalainstalasi_nama', 'length', 'max'=>50),
			array('jenisidentitas, petugasdaftar_nip, petugascatat_nip, nomorbarcode_sample, petugasskrining_nip, petugaspengujian_nip, petugasperiksa_nip, koordinatormutu_nip, kepalainstalasi_nip', 'length', 'max'=>30),
			array('nama_lengkap, tempat_lahir, notelp_pendonor, jabatanpendaftar_nama, no_kantongdarah, jabatanpencatat_nama, namakomponendrh, jabatanskrining_nama, jabatanpengujian_nama, jabatanperiksa_nama, jabatankoordinator_nama, jabatankasi_nama', 'length', 'max'=>100),
			array('jenis_kelamin, statusperkawinan, rhesus', 'length', 'max'=>20),
			array('alamat_lengkap, nomobile_pendonor, nama_jenis, ket_hasiluji', 'length', 'max'=>255),
			array('gol_darah', 'length', 'max'=>2),
			array('petugasdaftar_gelardepan, petugascatat_gelardepan, petugasskrining_gelardepan, petugaspengujian_gelardepan, petugasperiksa_gelardepan, koordinatormutu_gelardepan, kepalainstalasi_gelardepan', 'length', 'max'=>10),
			array('gelarpendaftar_nama, gelarpencatat_nama, gelarskrining_nama, gelarpengujian_nama, gelarperiksa_nama, statuspelulusan, gelarkoordinator_nama, gelarkasi_nama', 'length', 'max'=>25),
			array('nama_jenis_sngkt, singkatan_komp', 'length', 'max'=>5),
			array('tgllahir, waktu_pendaftaran, keterangan_donasi, tglpencatatan, tglskrining, hbsag, antihiv, antihvc, sifilis, ket_skrining, tglpengujian, periksakomponendarah_id, tglperiksakompdarah, periksakomp_ket, tglpelulusan, keteranganpelulusan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pendonor_id, no_pendonor, jenisidentitas, no_identitas, nama_lengkap, tempat_lahir, tgllahir, jenis_kelamin, alamat_lengkap, beratbadan_kg, tinggibadan_cm, notelp_pendonor, nomobile_pendonor, statusperkawinan, gol_darah, rhesus, daftardonasi_id, no_formulir, waktu_pendaftaran, keterangan_donasi, donasi_ke, ruangandaftar_id, ruangandaftar_nama, petugasdaftar_id, petugasdaftar_nip, petugasdaftar_gelardepan, petugasdaftar_nama, gelarpendaftar_id, gelarpendaftar_nama, jabatanpendaftar_id, jabatanpendaftar_nama, ruangancatat_id, kantongdarah_id, tglpencatatan, no_kantongdarah, ruangancatat_nama, petugascatat_id, petugascatat_nip, petugascatat_gelardepan, petugascatat_nama, gelarpencatat_id, gelarpencatat_nama, jabatanpencatat_id, jabatanpencatat_nama, jeniskantongdarah_id, nama_jenis, nama_jenis_sngkt, komponendarah_id, namakomponendrh, singkatan_komp, jmlprint_barcode, nomorbarcode_sample, terimakantongdarah_id, skriningimltd_id, tglskrining, hbsag, antihiv, antihvc, sifilis, ket_skrining, petugasskrining_id, petugasskrining_nip, petugasskrining_gelardepan, petugasskrining_nama, gelarskrining_id, gelarskrining_nama, jabatanskrining_id, jabatanskrining_nama, pengujiandarah_id, tglpengujian, petugaspengujian_id, petugaspengujian_nip, petugaspengujian_gelardepan, petugaspengujian_nama, gelarpengujian_id, gelarpengujian_nama, jabatanpengujian_id, jabatanpengujian_nama, anti_a, anti_b, anti_d, anti_ab, sel_a, sel_b, sel_o, hasil_uji, ket_hasiluji, periksakomponendarah_id, tglperiksakompdarah, petugasperiksa_id, petugasperiksa_nip, petugasperiksa_gelardepan, petugasperiksa_nama, gelarperiksa_id, gelarperiksa_nama, jabatanperiksa_id, jabatanperiksa_nama, komponen_wb, komponen_prc, komponen_tc, komponen_ffp, periksakomp_ket, luluskomponendarah_id, tglpelulusan, statuspelulusan, koordinatormutu_id, koordinatormutu_nip, koordinatormutu_gelardepan, koordinatormutu_nama, gelarkoordinator_id, gelarkoordinator_nama, jabatankoordinator_id, jabatankoordinator_nama, kepalainstalasi_id, kepalainstalasi_nip, kepalainstalasi_gelardepan, kepalainstalasi_nama, gelarkasi_id, gelarkasi_nama, jabatankasi_id, jabatankasi_nama, keteranganpelulusan', 'safe', 'on'=>'search'),
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
//                    'terimakantong' => array(self::BELONGS_TO, 'TerimakantongdarahT', 'terimakantongdarah_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pendonor_id' => 'Pendonor',
			'no_pendonor' => 'No Pendonor',
			'jenisidentitas' => 'Jenisidentitas',
			'no_identitas' => 'No Identitas',
			'nama_lengkap' => 'Nama Lengkap',
			'tempat_lahir' => 'Tempat Lahir',
			'tgllahir' => 'Tgllahir',
			'jenis_kelamin' => 'Jenis Kelamin',
			'alamat_lengkap' => 'Alamat Lengkap',
			'beratbadan_kg' => 'Beratbadan Kg',
			'tinggibadan_cm' => 'Tinggibadan Cm',
			'notelp_pendonor' => 'Notelp Pendonor',
			'nomobile_pendonor' => 'Nomobile Pendonor',
			'statusperkawinan' => 'Statusperkawinan',
			'gol_darah' => 'Gol Darah',
			'rhesus' => 'Rhesus',
			'daftardonasi_id' => 'Daftardonasi',
			'no_formulir' => 'No Formulir',
			'waktu_pendaftaran' => 'Waktu Pendaftaran',
			'keterangan_donasi' => 'Keterangan Donasi',
			'donasi_ke' => 'Donasi Ke',
			'ruangandaftar_id' => 'Ruangandaftar',
			'ruangandaftar_nama' => 'Ruangandaftar Nama',
			'petugasdaftar_id' => 'Petugasdaftar',
			'petugasdaftar_nip' => 'Petugasdaftar Nip',
			'petugasdaftar_gelardepan' => 'Petugasdaftar Gelardepan',
			'petugasdaftar_nama' => 'Petugasdaftar Nama',
			'gelarpendaftar_id' => 'Gelarpendaftar',
			'gelarpendaftar_nama' => 'Gelarpendaftar Nama',
			'jabatanpendaftar_id' => 'Jabatanpendaftar',
			'jabatanpendaftar_nama' => 'Jabatanpendaftar Nama',
			'ruangancatat_id' => 'Ruangancatat',
			'kantongdarah_id' => 'Kantongdarah',
			'tglpencatatan' => 'Tglpencatatan',
			'no_kantongdarah' => 'No Kantongdarah',
			'ruangancatat_nama' => 'Ruangancatat Nama',
			'petugascatat_id' => 'Petugascatat',
			'petugascatat_nip' => 'Petugascatat Nip',
			'petugascatat_gelardepan' => 'Petugascatat Gelardepan',
			'petugascatat_nama' => 'Petugascatat Nama',
			'gelarpencatat_id' => 'Gelarpencatat',
			'gelarpencatat_nama' => 'Gelarpencatat Nama',
			'jabatanpencatat_id' => 'Jabatanpencatat',
			'jabatanpencatat_nama' => 'Jabatanpencatat Nama',
			'jeniskantongdarah_id' => 'Jeniskantongdarah',
			'nama_jenis' => 'Nama Jenis',
			'nama_jenis_sngkt' => 'Nama Jenis Sngkt',
			'komponendarah_id' => 'Komponendarah',
			'namakomponendrh' => 'Namakomponendrh',
			'singkatan_komp' => 'Singkatan Komp',						
			'jmlprint_barcode' => 'Jmlprint Barcode',
			'nomorbarcode_sample' => 'Nomorbarcode Sample',
			'terimakantongdarah_id' => 'Terimakantongdarah',
			'skriningimltd_id' => 'Skriningimltd',
			'tglskrining' => 'Tglskrining',
			'hbsag' => 'Hbsag',
			'antihiv' => 'Antihiv',
			'antihvc' => 'Antihvc',
			'sifilis' => 'Sifilis',
			'ket_skrining' => 'Ket Skrining',
			'petugasskrining_id' => 'Petugasskrining',
			'petugasskrining_nip' => 'Petugasskrining Nip',
			'petugasskrining_gelardepan' => 'Petugasskrining Gelardepan',
			'petugasskrining_nama' => 'Petugasskrining Nama',
			'gelarskrining_id' => 'Gelarskrining',
			'gelarskrining_nama' => 'Gelarskrining Nama',
			'jabatanskrining_id' => 'Jabatanskrining',
			'jabatanskrining_nama' => 'Jabatanskrining Nama',
			'pengujiandarah_id' => 'Pengujiandarah',
			'tglpengujian' => 'Tglpengujian',
			'petugaspengujian_id' => 'Petugaspengujian',
			'petugaspengujian_nip' => 'Petugaspengujian Nip',
			'petugaspengujian_gelardepan' => 'Petugaspengujian Gelardepan',
			'petugaspengujian_nama' => 'Petugaspengujian Nama',
			'gelarpengujian_id' => 'Gelarpengujian',
			'gelarpengujian_nama' => 'Gelarpengujian Nama',
			'jabatanpengujian_id' => 'Jabatanpengujian',
			'jabatanpengujian_nama' => 'Jabatanpengujian Nama',
			'anti_a' => 'Anti A',
			'anti_b' => 'Anti B',
			'anti_d' => 'Anti D',
			'anti_ab' => 'Anti Ab',
			'sel_a' => 'Sel A',
			'sel_b' => 'Sel B',
			'sel_o' => 'Sel O',
			'hasil_uji' => 'Hasil Uji',
			'ket_hasiluji' => 'Ket Hasiluji',
			'periksakomponendarah_id' => 'Periksakomponendarah',
			'tglperiksakompdarah' => 'Tglperiksakompdarah',
			'petugasperiksa_id' => 'Petugasperiksa',
			'petugasperiksa_nip' => 'Petugasperiksa Nip',
			'petugasperiksa_gelardepan' => 'Petugasperiksa Gelardepan',
			'petugasperiksa_nama' => 'Petugasperiksa Nama',
			'gelarperiksa_id' => 'Gelarperiksa',
			'gelarperiksa_nama' => 'Gelarperiksa Nama',
			'jabatanperiksa_id' => 'Jabatanperiksa',
			'jabatanperiksa_nama' => 'Jabatanperiksa Nama',
			'komponen_wb' => 'Komponen Wb',
			'komponen_prc' => 'Komponen Prc',
			'komponen_tc' => 'Komponen Tc',
			'komponen_ffp' => 'Komponen Ffp',
			'periksakomp_ket' => 'Periksakomp Ket',
			'luluskomponendarah_id' => 'Luluskomponendarah',
			'tglpelulusan' => 'Tglpelulusan',
			'statuspelulusan' => 'Statuspelulusan',
			'koordinatormutu_id' => 'Koordinatormutu',
			'koordinatormutu_nip' => 'Koordinatormutu Nip',
			'koordinatormutu_gelardepan' => 'Koordinatormutu Gelardepan',
			'koordinatormutu_nama' => 'Koordinatormutu Nama',
			'gelarkoordinator_id' => 'Gelarkoordinator',
			'gelarkoordinator_nama' => 'Gelarkoordinator Nama',
			'jabatankoordinator_id' => 'Jabatankoordinator',
			'jabatankoordinator_nama' => 'Jabatankoordinator Nama',
			'kepalainstalasi_id' => 'Kepalainstalasi',
			'kepalainstalasi_nip' => 'Kepalainstalasi Nip',
			'kepalainstalasi_gelardepan' => 'Kepalainstalasi Gelardepan',
			'kepalainstalasi_nama' => 'Kepalainstalasi Nama',
			'gelarkasi_id' => 'Gelarkasi',
			'gelarkasi_nama' => 'Gelarkasi Nama',
			'jabatankasi_id' => 'Jabatankasi',
			'jabatankasi_nama' => 'Jabatankasi Nama',
			'keteranganpelulusan' => 'Keteranganpelulusan',
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
                // menampilkan kantong darah berdasarkan kantong darah yang sudah diterima
                $criteria->addBetweenCondition('DATE(t.tglpencatatan)', $this->tgl_awal, $this->tgl_akhir);
                $criteria->addCondition('k.penerimaandarahpmidet_id IS NULL');
                $criteria->addCondition('k.terimakantongdarah_id IS NOT NULL');
                $criteria->join = 'LEFT JOIN kantongdarah_t k on t.kantongdarah_id = k.kantongdarah_id '
                                . 'LEFT JOIN periksakomponendarah_t p on t.periksakomponendarah_id = p.periksakomponendarah_id ';
                $criteria->select = 't.*, k.penerimaandarahpmidet_id, p.komponen_pcr';
		$criteria->compare('pendonor_id',$this->pendonor_id);
		$criteria->compare('no_pendonor',$this->no_pendonor,true);
		$criteria->compare('jenisidentitas',$this->jenisidentitas,true);
		$criteria->compare('no_identitas',$this->no_identitas,true);
		$criteria->compare('nama_lengkap',$this->nama_lengkap,true);
		$criteria->compare('tempat_lahir',$this->tempat_lahir,true);
		$criteria->compare('tgllahir',$this->tgllahir,true);
		$criteria->compare('jenis_kelamin',$this->jenis_kelamin,true);
		$criteria->compare('alamat_lengkap',$this->alamat_lengkap,true);
		$criteria->compare('beratbadan_kg',$this->beratbadan_kg);
		$criteria->compare('tinggibadan_cm',$this->tinggibadan_cm);
		$criteria->compare('notelp_pendonor',$this->notelp_pendonor,true);
		$criteria->compare('nomobile_pendonor',$this->nomobile_pendonor,true);
		$criteria->compare('statusperkawinan',$this->statusperkawinan,true);
		$criteria->compare('gol_darah',$this->gol_darah,true);
		$criteria->compare('rhesus',$this->rhesus,true);
		$criteria->compare('daftardonasi_id',$this->daftardonasi_id);
		$criteria->compare('no_formulir',$this->no_formulir,true);
		$criteria->compare('waktu_pendaftaran',$this->waktu_pendaftaran,true);
		$criteria->compare('keterangan_donasi',$this->keterangan_donasi,true);
		$criteria->compare('donasi_ke',$this->donasi_ke);
		$criteria->compare('ruangandaftar_id',$this->ruangandaftar_id);
		$criteria->compare('ruangandaftar_nama',$this->ruangandaftar_nama,true);
		$criteria->compare('petugasdaftar_id',$this->petugasdaftar_id);
		$criteria->compare('petugasdaftar_nip',$this->petugasdaftar_nip,true);
		$criteria->compare('petugasdaftar_gelardepan',$this->petugasdaftar_gelardepan,true);
		$criteria->compare('petugasdaftar_nama',$this->petugasdaftar_nama,true);
		$criteria->compare('gelarpendaftar_id',$this->gelarpendaftar_id);
		$criteria->compare('gelarpendaftar_nama',$this->gelarpendaftar_nama,true);
		$criteria->compare('jabatanpendaftar_id',$this->jabatanpendaftar_id);
		$criteria->compare('jabatanpendaftar_nama',$this->jabatanpendaftar_nama,true);
		$criteria->compare('ruangancatat_id',$this->ruangancatat_id);
		$criteria->compare('kantongdarah_id',$this->kantongdarah_id);
		$criteria->compare('tglpencatatan',$this->tglpencatatan,true);
		$criteria->compare('ruangancatat_nama',$this->ruangancatat_nama,true);
		$criteria->compare('petugascatat_id',$this->petugascatat_id);
		$criteria->compare('petugascatat_nip',$this->petugascatat_nip,true);
		$criteria->compare('petugascatat_gelardepan',$this->petugascatat_gelardepan,true);
		$criteria->compare('petugascatat_nama',$this->petugascatat_nama,true);
		$criteria->compare('gelarpencatat_id',$this->gelarpencatat_id);
		$criteria->compare('gelarpencatat_nama',$this->gelarpencatat_nama,true);
		$criteria->compare('jabatanpencatat_id',$this->jabatanpencatat_id);
		$criteria->compare('jabatanpencatat_nama',$this->jabatanpencatat_nama,true);
		$criteria->compare('t.jeniskantongdarah_id',$this->jeniskantongdarah_id);
		$criteria->compare('nama_jenis',$this->nama_jenis,true);
		$criteria->compare('nama_jenis_sngkt',$this->nama_jenis_sngkt,true);
		$criteria->compare('komponendarah_id',$this->komponendarah_id);
		$criteria->compare('namakomponendrh',$this->namakomponendrh,true);
		$criteria->compare('singkatan_komp',$this->singkatan_komp,true);				
		$criteria->compare('jmlprint_barcode',$this->jmlprint_barcode);
		$criteria->compare('nomorbarcode_sample',$this->nomorbarcode_sample,true);
		$criteria->compare('terimakantongdarah_id',$this->terimakantongdarah_id);
		$criteria->compare('skriningimltd_id',$this->skriningimltd_id);
		$criteria->compare('tglskrining',$this->tglskrining,true);
		$criteria->compare('hbsag',$this->hbsag);
		$criteria->compare('antihiv',$this->antihiv);
		$criteria->compare('antihvc',$this->antihvc);
		$criteria->compare('sifilis',$this->sifilis);
		$criteria->compare('ket_skrining',$this->ket_skrining,true);
		$criteria->compare('petugasskrining_id',$this->petugasskrining_id);
		$criteria->compare('petugasskrining_nip',$this->petugasskrining_nip,true);
		$criteria->compare('petugasskrining_gelardepan',$this->petugasskrining_gelardepan,true);
		$criteria->compare('petugasskrining_nama',$this->petugasskrining_nama,true);
		$criteria->compare('gelarskrining_id',$this->gelarskrining_id);
		$criteria->compare('gelarskrining_nama',$this->gelarskrining_nama,true);
		$criteria->compare('jabatanskrining_id',$this->jabatanskrining_id);
		$criteria->compare('jabatanskrining_nama',$this->jabatanskrining_nama,true);
		$criteria->compare('pengujiandarah_id',$this->pengujiandarah_id);
		$criteria->compare('tglpengujian',$this->tglpengujian,true);
		$criteria->compare('petugaspengujian_id',$this->petugaspengujian_id);
		$criteria->compare('petugaspengujian_nip',$this->petugaspengujian_nip,true);
		$criteria->compare('petugaspengujian_gelardepan',$this->petugaspengujian_gelardepan,true);
		$criteria->compare('petugaspengujian_nama',$this->petugaspengujian_nama,true);
		$criteria->compare('gelarpengujian_id',$this->gelarpengujian_id);
		$criteria->compare('gelarpengujian_nama',$this->gelarpengujian_nama,true);
		$criteria->compare('jabatanpengujian_id',$this->jabatanpengujian_id);
		$criteria->compare('jabatanpengujian_nama',$this->jabatanpengujian_nama,true);
		$criteria->compare('anti_a',$this->anti_a,true);
		$criteria->compare('anti_b',$this->anti_b,true);
		$criteria->compare('anti_d',$this->anti_d,true);
		$criteria->compare('anti_ab',$this->anti_ab,true);
		$criteria->compare('sel_a',$this->sel_a,true);
		$criteria->compare('sel_b',$this->sel_b,true);
		$criteria->compare('sel_o',$this->sel_o,true);
		$criteria->compare('hasil_uji',$this->hasil_uji,true);
		$criteria->compare('ket_hasiluji',$this->ket_hasiluji,true);
		$criteria->compare('periksakomponendarah_id',$this->periksakomponendarah_id,true);
		$criteria->compare('tglperiksakompdarah',$this->tglperiksakompdarah,true);
		$criteria->compare('petugasperiksa_id',$this->petugasperiksa_id);
		$criteria->compare('petugasperiksa_nip',$this->petugasperiksa_nip,true);
		$criteria->compare('petugasperiksa_gelardepan',$this->petugasperiksa_gelardepan,true);
		$criteria->compare('petugasperiksa_nama',$this->petugasperiksa_nama,true);
		$criteria->compare('gelarperiksa_id',$this->gelarperiksa_id);
		$criteria->compare('gelarperiksa_nama',$this->gelarperiksa_nama,true);
		$criteria->compare('jabatanperiksa_id',$this->jabatanperiksa_id);
		$criteria->compare('jabatanperiksa_nama',$this->jabatanperiksa_nama,true);
		$criteria->compare('komponen_wb',$this->komponen_wb,true);
		$criteria->compare('komponen_prc',$this->komponen_prc,true);
		$criteria->compare('komponen_tc',$this->komponen_tc,true);
		$criteria->compare('komponen_ffp',$this->komponen_ffp,true);
		$criteria->compare('periksakomp_ket',$this->periksakomp_ket,true);
		$criteria->compare('luluskomponendarah_id',$this->luluskomponendarah_id);
		$criteria->compare('LOWER(t.no_kantongdarah)', strtolower($this->no_kantongdarah),true);
		$criteria->compare('tglpelulusan',$this->tglpelulusan,true);
		$criteria->compare('statuspelulusan',$this->statuspelulusan,true);
		$criteria->compare('koordinatormutu_id',$this->koordinatormutu_id);
		$criteria->compare('koordinatormutu_nip',$this->koordinatormutu_nip,true);
		$criteria->compare('koordinatormutu_gelardepan',$this->koordinatormutu_gelardepan,true);
		$criteria->compare('koordinatormutu_nama',$this->koordinatormutu_nama,true);
		$criteria->compare('gelarkoordinator_id',$this->gelarkoordinator_id);
		$criteria->compare('gelarkoordinator_nama',$this->gelarkoordinator_nama,true);
		$criteria->compare('jabatankoordinator_id',$this->jabatankoordinator_id);
		$criteria->compare('jabatankoordinator_nama',$this->jabatankoordinator_nama,true);
		$criteria->compare('kepalainstalasi_id',$this->kepalainstalasi_id);
		$criteria->compare('kepalainstalasi_nip',$this->kepalainstalasi_nip,true);
		$criteria->compare('kepalainstalasi_gelardepan',$this->kepalainstalasi_gelardepan,true);
		$criteria->compare('kepalainstalasi_nama',$this->kepalainstalasi_nama,true);
		$criteria->compare('gelarkasi_id',$this->gelarkasi_id);
		$criteria->compare('gelarkasi_nama',$this->gelarkasi_nama,true);
		$criteria->compare('jabatankasi_id',$this->jabatankasi_id);
		$criteria->compare('jabatankasi_nama',$this->jabatankasi_nama,true);
		$criteria->compare('keteranganpelulusan',$this->keteranganpelulusan,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        /**
         * pencarian dialog
         * @return \CActiveDataProvider
         */
        public function searchDialog()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                // menampilkan kantong darah berdasarkan kantong darah yang sudah diterima
                $criteria->condition = "terimakantongdarah_id IS NOT NULL";
		$criteria->compare('pendonor_id',$this->pendonor_id);
		$criteria->compare('no_pendonor',$this->no_pendonor,true);
		$criteria->compare('jenisidentitas',$this->jenisidentitas,true);
		$criteria->compare('no_identitas',$this->no_identitas,true);
		$criteria->compare('nama_lengkap',$this->nama_lengkap,true);
		$criteria->compare('tempat_lahir',$this->tempat_lahir,true);
		$criteria->compare('tgllahir',$this->tgllahir,true);
		$criteria->compare('jenis_kelamin',$this->jenis_kelamin,true);
		$criteria->compare('alamat_lengkap',$this->alamat_lengkap,true);
		$criteria->compare('beratbadan_kg',$this->beratbadan_kg);
		$criteria->compare('tinggibadan_cm',$this->tinggibadan_cm);
		$criteria->compare('notelp_pendonor',$this->notelp_pendonor,true);
		$criteria->compare('nomobile_pendonor',$this->nomobile_pendonor,true);
		$criteria->compare('statusperkawinan',$this->statusperkawinan,true);
		$criteria->compare('gol_darah',$this->gol_darah,true);
		$criteria->compare('rhesus',$this->rhesus,true);
		$criteria->compare('daftardonasi_id',$this->daftardonasi_id);
		$criteria->compare('no_formulir',$this->no_formulir,true);
		$criteria->compare('waktu_pendaftaran',$this->waktu_pendaftaran,true);
		$criteria->compare('keterangan_donasi',$this->keterangan_donasi,true);
		$criteria->compare('donasi_ke',$this->donasi_ke);
		$criteria->compare('ruangandaftar_id',$this->ruangandaftar_id);
		$criteria->compare('ruangandaftar_nama',$this->ruangandaftar_nama,true);
		$criteria->compare('petugasdaftar_id',$this->petugasdaftar_id);
		$criteria->compare('petugasdaftar_nip',$this->petugasdaftar_nip,true);
		$criteria->compare('petugasdaftar_gelardepan',$this->petugasdaftar_gelardepan,true);
		$criteria->compare('petugasdaftar_nama',$this->petugasdaftar_nama,true);
		$criteria->compare('gelarpendaftar_id',$this->gelarpendaftar_id);
		$criteria->compare('gelarpendaftar_nama',$this->gelarpendaftar_nama,true);
		$criteria->compare('jabatanpendaftar_id',$this->jabatanpendaftar_id);
		$criteria->compare('jabatanpendaftar_nama',$this->jabatanpendaftar_nama,true);
		$criteria->compare('ruangancatat_id',$this->ruangancatat_id);
		$criteria->compare('kantongdarah_id',$this->kantongdarah_id);
		$criteria->compare('tglpencatatan',$this->tglpencatatan,true);
		$criteria->compare('LOWER(t.no_kantongdarah)', strtolower($this->no_kantongdarah),true);
		$criteria->compare('ruangancatat_nama',$this->ruangancatat_nama,true);
		$criteria->compare('petugascatat_id',$this->petugascatat_id);
		$criteria->compare('petugascatat_nip',$this->petugascatat_nip,true);
		$criteria->compare('petugascatat_gelardepan',$this->petugascatat_gelardepan,true);
		$criteria->compare('petugascatat_nama',$this->petugascatat_nama,true);
		$criteria->compare('gelarpencatat_id',$this->gelarpencatat_id);
		$criteria->compare('gelarpencatat_nama',$this->gelarpencatat_nama,true);
		$criteria->compare('jabatanpencatat_id',$this->jabatanpencatat_id);
		$criteria->compare('jabatanpencatat_nama',$this->jabatanpencatat_nama,true);
		$criteria->compare('jeniskantongdarah_id',$this->jeniskantongdarah_id);
		$criteria->compare('nama_jenis',$this->nama_jenis,true);
		$criteria->compare('nama_jenis_sngkt',$this->nama_jenis_sngkt,true);
		$criteria->compare('komponendarah_id',$this->komponendarah_id);
		$criteria->compare('namakomponendrh',$this->namakomponendrh,true);
		$criteria->compare('singkatan_komp',$this->singkatan_komp,true);				
		$criteria->compare('jmlprint_barcode',$this->jmlprint_barcode);
		$criteria->compare('nomorbarcode_sample',$this->nomorbarcode_sample,true);
		$criteria->compare('terimakantongdarah_id',$this->terimakantongdarah_id);
		$criteria->compare('skriningimltd_id',$this->skriningimltd_id);
		$criteria->compare('tglskrining',$this->tglskrining,true);
		$criteria->compare('hbsag',$this->hbsag);
		$criteria->compare('antihiv',$this->antihiv);
		$criteria->compare('antihvc',$this->antihvc);
		$criteria->compare('sifilis',$this->sifilis);
		$criteria->compare('ket_skrining',$this->ket_skrining,true);
		$criteria->compare('petugasskrining_id',$this->petugasskrining_id);
		$criteria->compare('petugasskrining_nip',$this->petugasskrining_nip,true);
		$criteria->compare('petugasskrining_gelardepan',$this->petugasskrining_gelardepan,true);
		$criteria->compare('petugasskrining_nama',$this->petugasskrining_nama,true);
		$criteria->compare('gelarskrining_id',$this->gelarskrining_id);
		$criteria->compare('gelarskrining_nama',$this->gelarskrining_nama,true);
		$criteria->compare('jabatanskrining_id',$this->jabatanskrining_id);
		$criteria->compare('jabatanskrining_nama',$this->jabatanskrining_nama,true);
		$criteria->compare('pengujiandarah_id',$this->pengujiandarah_id);
		$criteria->compare('tglpengujian',$this->tglpengujian,true);
		$criteria->compare('petugaspengujian_id',$this->petugaspengujian_id);
		$criteria->compare('petugaspengujian_nip',$this->petugaspengujian_nip,true);
		$criteria->compare('petugaspengujian_gelardepan',$this->petugaspengujian_gelardepan,true);
		$criteria->compare('petugaspengujian_nama',$this->petugaspengujian_nama,true);
		$criteria->compare('gelarpengujian_id',$this->gelarpengujian_id);
		$criteria->compare('gelarpengujian_nama',$this->gelarpengujian_nama,true);
		$criteria->compare('jabatanpengujian_id',$this->jabatanpengujian_id);
		$criteria->compare('jabatanpengujian_nama',$this->jabatanpengujian_nama,true);
		$criteria->compare('anti_a',$this->anti_a,true);
		$criteria->compare('anti_b',$this->anti_b,true);
		$criteria->compare('anti_d',$this->anti_d,true);
		$criteria->compare('anti_ab',$this->anti_ab,true);
		$criteria->compare('sel_a',$this->sel_a,true);
		$criteria->compare('sel_b',$this->sel_b,true);
		$criteria->compare('sel_o',$this->sel_o,true);
		$criteria->compare('hasil_uji',$this->hasil_uji,true);
		$criteria->compare('ket_hasiluji',$this->ket_hasiluji,true);
		$criteria->compare('periksakomponendarah_id',$this->periksakomponendarah_id,true);
		$criteria->compare('tglperiksakompdarah',$this->tglperiksakompdarah,true);
		$criteria->compare('petugasperiksa_id',$this->petugasperiksa_id);
		$criteria->compare('petugasperiksa_nip',$this->petugasperiksa_nip,true);
		$criteria->compare('petugasperiksa_gelardepan',$this->petugasperiksa_gelardepan,true);
		$criteria->compare('petugasperiksa_nama',$this->petugasperiksa_nama,true);
		$criteria->compare('gelarperiksa_id',$this->gelarperiksa_id);
		$criteria->compare('gelarperiksa_nama',$this->gelarperiksa_nama,true);
		$criteria->compare('jabatanperiksa_id',$this->jabatanperiksa_id);
		$criteria->compare('jabatanperiksa_nama',$this->jabatanperiksa_nama,true);
		$criteria->compare('komponen_wb',$this->komponen_wb,true);
		$criteria->compare('komponen_prc',$this->komponen_prc,true);
		$criteria->compare('komponen_tc',$this->komponen_tc,true);
		$criteria->compare('komponen_ffp',$this->komponen_ffp,true);
		$criteria->compare('periksakomp_ket',$this->periksakomp_ket,true);
		$criteria->compare('luluskomponendarah_id',$this->luluskomponendarah_id);
		$criteria->compare('tglpelulusan',$this->tglpelulusan,true);
		$criteria->compare('statuspelulusan',$this->statuspelulusan,true);
		$criteria->compare('koordinatormutu_id',$this->koordinatormutu_id);
		$criteria->compare('koordinatormutu_nip',$this->koordinatormutu_nip,true);
		$criteria->compare('koordinatormutu_gelardepan',$this->koordinatormutu_gelardepan,true);
		$criteria->compare('koordinatormutu_nama',$this->koordinatormutu_nama,true);
		$criteria->compare('gelarkoordinator_id',$this->gelarkoordinator_id);
		$criteria->compare('gelarkoordinator_nama',$this->gelarkoordinator_nama,true);
		$criteria->compare('jabatankoordinator_id',$this->jabatankoordinator_id);
		$criteria->compare('jabatankoordinator_nama',$this->jabatankoordinator_nama,true);
		$criteria->compare('kepalainstalasi_id',$this->kepalainstalasi_id);
		$criteria->compare('kepalainstalasi_nip',$this->kepalainstalasi_nip,true);
		$criteria->compare('kepalainstalasi_gelardepan',$this->kepalainstalasi_gelardepan,true);
		$criteria->compare('kepalainstalasi_nama',$this->kepalainstalasi_nama,true);
		$criteria->compare('gelarkasi_id',$this->gelarkasi_id);
		$criteria->compare('gelarkasi_nama',$this->gelarkasi_nama,true);
		$criteria->compare('jabatankasi_id',$this->jabatankasi_id);
		$criteria->compare('jabatankasi_nama',$this->jabatankasi_nama,true);
		$criteria->compare('keteranganpelulusan',$this->keteranganpelulusan,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        /**
         * Pencarian untuk Transaksi Pembuatan Komponen Darah
         * @return \CActiveDataProvider
         */
        public function searchTransaksi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                // menampilkan kantong darah berdasarkan kantong darah yang sudah diterima
                $criteria->join = "LEFT JOIN kantongdarah_t k ON t.kantongdarah_id = k.kantongdarah_id";
                $criteria->select = "t.*, k.daftarpendonor_id, k.penerimaandarahpmidet_id";
                $criteria->addCondition('t.terimakantongdarah_id IS NOT NULL');
                $criteria->addCondition('t.periksakomponendarah_id IS NULL');
                $criteria->addCondition('k.penerimaandarahpmidet_id IS NULL');
                $criteria->compare('LOWER(t.gol_darah)',strtolower($this->gol_darah),true);
                $criteria->compare('LOWER(t.rhesus)',strtolower($this->rhesus),true);
                $criteria->compare('LOWER(t.nomorbarcode)',strtolower($this->nomorbarcode),true);
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        /**
         * pencarian data untuk pelulusan komponen darah 
         * @return \CActiveDataProvider
         */
        public function searchTransaksiLulus()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                // menampilkan kantong darah berdasarkan kantong darah yang sudah diterima
                $criteria->addCondition('terimakantongdarah_id IS NOT NULL');
                $criteria->addCondition('pengujiandarah_id IS NOT NULL');
                $criteria->addCondition('skriningimltd_id IS NOT NULL');
                $criteria->addCondition('periksakomponendarah_id IS NOT NULL');
                $criteria->addCondition('luluskomponendarah_id IS NULL');
                $criteria->compare('LOWER(gol_darah)',strtolower($this->gol_darah),true);
                $criteria->compare('LOWER(rhesus)',strtolower($this->rhesus),true);
                $criteria->compare('LOWER(nomorbarcode)',strtolower($this->nomorbarcode),true);
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        /**
         * pencarian kantong darah di transaksi pengiriman kantong
         * @return \CActiveDataProvider
         */
        public function searchDialogKirim()
	{		
			$cri = new CDbCriteria;                
			$cri->select = " t.*, cool.no_penggunaan_coolbox, jns_cool.coolboxdarah_nama, jns_kantong.nama_jenis, cooldet.no_kantongpabrik";
			$cri->join = " LEFT JOIN kirimkantongdet_t kirimdet ON kirimdet.kantongdarah_id = t.kantongdarah_id "
						. 'LEFT JOIN penggunaan_coolboxdet_t cooldet ON cooldet.kantongdarah_id = t.kantongdarah_id '
						. ' JOIN penggunaan_coolbox_t cool ON cool.penggunaan_coolbox_id = cooldet.penggunaan_coolbox_id '
						. 'LEFT JOIN coolboxdarah_m jns_cool ON jns_cool.coolboxdarah_id = cool.coolboxdarah_id '
						. 'LEFT JOIN jeniskantongdarah_m jns_kantong on jns_kantong.jeniskantongdarah_id = t.jeniskantongdarah_id';
			$cri->addCondition(" t.terimakantongdarah_id is null AND kirimdet.kirimkantongdarah_id IS NULL ");
			$cri->addCondition(" t.nomorbarcode_utama IS NOT NULL ");
			if (!empty($this->coolboxdarah_id)){
				$cri->addCondition(" jns_cool.coolboxdarah_id =  ".$this->coolboxdarah_id." ");
			}else{
				$cri->addCondition(" t.kantongdarah_id is null ");
			}
			$cri->compare("LOWER(cool.no_penggunaan_coolbox)", strtolower($this->no_penggunaan_coolbox),true);
			$cri->compare("LOWER(jns_cool.coolboxdarah_nama)", strtolower($this->coolboxdarah_nama),true);
			$cri->compare("LOWER(t.nomorbarcode_utama)", strtolower($this->nomorbarcode_utama),true);
			$cri->compare("LOWER(t.nomorbarcode_sample)", strtolower($this->nomorbarcode_sample),true);
			// $cri->addCondition("t.daftarpendonor_id is not null");
			
			if (!empty($this->nama_jenis)){
				$cri->addCondition(" t.nama_jenis = '".$this->nama_jenis."' ");
			}
			
			$cri->order = " t.tglpencatatan DESC ";
			$kantong = BDKantongdarahT::model()->findAll($cri);
			
			$res = array();

			$awal = '';
			foreach ($kantong as $det){                
	//                $res[$det->no_penggunaan_coolbox]['no_penggunaan_coolbox'] = $det->no_penggunaan_coolbox;
	//                $res[$det->no_penggunaan_coolbox]['coolboxdarah_nama'] = $det->coolboxdarah_nama;
	//                $res[$det->no_penggunaan_coolbox]['sampel'][$det->nomorbarcode_utama]['no_identitas'] = $det->no_identitas;
	//                $res[$det->no_penggunaan_coolbox]['sampel'][$det->nomorbarcode_utama]['no_formulir'] = $det->no_formulir;
	//                $res[$det->no_penggunaan_coolbox]['sampel'][$det->nomorbarcode_utama]['nomorbarcode_utama'] = $det->nomorbarcode_utama;
	//                $res[$det->no_penggunaan_coolbox]['sampel'][$det->nomorbarcode_utama]['nomorbarcode_sample'] = $det->nomorbarcode_sample;
	//                $res[$det->no_penggunaan_coolbox]['sampel'][$det->nomorbarcode_utama]['gol_darah'] = $det->gol_darah;
	//                $res[$det->no_penggunaan_coolbox]['sampel'][$det->nomorbarcode_utama]['rhesus'] = $det->rhesus;
	//                $res[$det->no_penggunaan_coolbox]['sampel'][$det->nomorbarcode_utama]['nama_jenis'] = $det->nama_jenis;
	//                $res[$det->no_penggunaan_coolbox]['sampel'][$det->nomorbarcode_utama]['jeniskantongdarah_id'] = $det->jeniskantongdarah_id;                
	//                $res[$det->no_penggunaan_coolbox]['sampel'][$det->nomorbarcode_utama]['det'][$det->kantongdarah_id]['komponendarah_id'] = $det->komponendarah_id;
	//                $res[$det->no_penggunaan_coolbox]['sampel'][$det->nomorbarcode_utama]['det'][$det->kantongdarah_id]['no_kantongdarah'] = $det->no_kantongdarah;
	//                $res[$det->no_penggunaan_coolbox]['sampel'][$det->nomorbarcode_utama]['det'][$det->kantongdarah_id]['no_kantongdarah'] = $det->no_kantongdarah; 
				$res[$det->nomorbarcode_utama]['no_penggunaan_coolbox'] = $det->no_penggunaan_coolbox;
				$res[$det->nomorbarcode_utama]['nomorbarcode_utama'] = $det->nomorbarcode_utama;
				$res[$det->nomorbarcode_utama]['coolboxdarah_nama'] = $det->coolboxdarah_nama;
				$res[$det->nomorbarcode_utama]['no_kantongpabrik'] = $det->no_kantongpabrik;
				$res[$det->nomorbarcode_utama]['sampel'][$det->nomorbarcode_utama]['nomorbarcode_utama'] = $det->nomorbarcode_utama;
				$res[$det->nomorbarcode_utama]['sampel'][$det->nomorbarcode_utama]['nomorbarcode_sample'] = $det->nomorbarcode_sample;
				$res[$det->nomorbarcode_utama]['sampel'][$det->nomorbarcode_utama]['gol_darah'] = $det->gol_darah;
				$res[$det->nomorbarcode_utama]['sampel'][$det->nomorbarcode_utama]['rhesus'] = $det->rhesus;
				$res[$det->nomorbarcode_utama]['sampel'][$det->nomorbarcode_utama]['nama_jenis'] = $det->nama_jenis;
				$res[$det->nomorbarcode_utama]['sampel'][$det->nomorbarcode_utama]['jeniskantongdarah_id'] = $det->jeniskantongdarah_id;                
				$res[$det->nomorbarcode_utama]['sampel'][$det->nomorbarcode_utama]['det'][$det->kantongdarah_id]['komponendarah_id'] = $det->komponendarah_id;
				$res[$det->nomorbarcode_utama]['sampel'][$det->nomorbarcode_utama]['det'][$det->kantongdarah_id]['no_kantongdarah'] = $det->no_kantongdarah;
				$res[$det->nomorbarcode_utama]['sampel'][$det->nomorbarcode_utama]['det'][$det->kantongdarah_id]['no_kantongdarah'] = $det->no_kantongdarah; 
			}
			
			$data = array();
			
			$i = 0;
			foreach($res as $a => $val){
				$data[$i] = $val;
				$data[$i] = $val;
				$i++;
			}

			return new CArrayDataProvider($data, array(
				'keyField'=>'no_penggunaan_coolbox',			
				'id'=>'data_laporan',
					'totalItemCount'=>count($data),
					'pagination' => array(
						'pageSize' => 10,
						'pageVar' => 'page'
					),			
			));       
	}
}