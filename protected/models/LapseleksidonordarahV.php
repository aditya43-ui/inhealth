<?php

/**
 * This is the model class for table "lapseleksidonordarah_v".
 *
 * The followings are the available columns in table 'lapseleksidonordarah_v':
 * @property integer $profilrs_id
 * @property string $nama_rumahsakit
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
 * @property integer $pekerjaan_id
 * @property string $statusperkawinan
 * @property string $gol_darah
 * @property string $rhesus
 * @property boolean $is_pernah_donor
 * @property integer $donasi_ke_sblm
 * @property string $tgl_donor_terakhir
 * @property string $tempat_donor_terakhir
 * @property integer $daftardonasi_id
 * @property string $no_formulir
 * @property string $waktu_pendaftaran
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $pegawaidaftar_id
 * @property string $pegawaidaftar_nip
 * @property string $pegawaidaftar_gelardepan
 * @property string $pegawaidaftar_nama
 * @property integer $gelarpendaftar_id
 * @property string $gelarpendaftar_nama
 * @property integer $jabatanpendaftar_id
 * @property string $jabatanpendaftar_nama
 * @property string $keterangan_donasi
 * @property integer $donasi_ke
 * @property integer $seleksidonor_id
 * @property string $tglseleksidonor
 * @property integer $pegawaiseleksi_id
 * @property string $pegawaiseleksi_nip
 * @property string $pegawaiseleksi_gelardepan
 * @property string $pegawaiseleksi_nama
 * @property integer $gelarseleksi_id
 * @property string $gelarseleksi_nama
 * @property integer $jabatanseleksi_id
 * @property string $jabatanseleksi_nama
 * @property string $seleksi_umur
 * @property string $jenisdonor
 * @property string $tekanandarah
 * @property integer $td_systolic
 * @property integer $td_diastoliic
 * @property integer $kadar_hb
 * @property double $suhu_tubuh
 * @property integer $detaknadi
 * @property boolean $is_gagalseleksi
 * @property boolean $hb_rendah
 * @property boolean $hb_tinggi
 * @property boolean $medis_hb_17
 * @property boolean $medis_td_rendah
 * @property boolean $medis_tk_tinggi
 * @property boolean $medis_bb_lebih
 * @property boolean $medis_vaksin
 * @property boolean $perilakuberesiko
 * @property boolean $riwberpergian
 * @property boolean $lain_lain
 * @property string $catatan_dokter
 * @property string $status_pendonor
 * @property integer $pegawaidokter_id
 * @property string $pegawaidokter_nip
 * @property string $pegawaidokter_gelardepan
 * @property string $pegawaidokter_nama
 * @property integer $gelardokter_id
 * @property string $gelardokter_nama
 * @property integer $jabatandokter_id
 * @property string $jabatandokter_nama
 */
class LapseleksidonordarahV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LapseleksidonordarahV the static model class
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
		return 'lapseleksidonordarah_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('profilrs_id, pendonor_id, pekerjaan_id, donasi_ke_sblm, daftardonasi_id, instalasi_id, ruangan_id, pegawaidaftar_id, gelarpendaftar_id, jabatanpendaftar_id, donasi_ke, seleksidonor_id, pegawaiseleksi_id, gelarseleksi_id, jabatanseleksi_id, td_systolic, td_diastoliic, kadar_hb, detaknadi, pegawaidokter_id, gelardokter_id, jabatandokter_id', 'numerical', 'integerOnly'=>true),
			array('beratbadan_kg, tinggibadan_cm, suhu_tubuh', 'numerical'),
			array('nama_rumahsakit, nama_lengkap, tempat_lahir, notelp_pendonor, tempat_donor_terakhir, jabatanpendaftar_nama, jabatanseleksi_nama, jabatandokter_nama', 'length', 'max'=>100),
			array('no_pendonor, no_identitas, no_formulir, instalasi_nama, ruangan_nama, pegawaidaftar_nama, pegawaiseleksi_nama, pegawaidokter_nama', 'length', 'max'=>50),
			array('jenisidentitas, pegawaidaftar_nip, pegawaiseleksi_nip, pegawaidokter_nip', 'length', 'max'=>30),
			array('jenis_kelamin, statusperkawinan, rhesus, tekanandarah', 'length', 'max'=>20),
			array('alamat_lengkap, nomobile_pendonor, jenisdonor', 'length', 'max'=>255),
			array('gol_darah', 'length', 'max'=>2),
			array('pegawaidaftar_gelardepan, pegawaiseleksi_gelardepan, status_pendonor, pegawaidokter_gelardepan', 'length', 'max'=>10),
			array('gelarpendaftar_nama, gelarseleksi_nama, gelardokter_nama', 'length', 'max'=>25),
			array('tgllahir, is_pernah_donor, tgl_donor_terakhir, waktu_pendaftaran, keterangan_donasi, tglseleksidonor, seleksi_umur, is_gagalseleksi, hb_rendah, hb_tinggi, medis_hb_17, medis_td_rendah, medis_tk_tinggi, medis_bb_lebih, medis_vaksin, perilakuberesiko, riwberpergian, lain_lain, catatan_dokter', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('profilrs_id, nama_rumahsakit, pendonor_id, no_pendonor, jenisidentitas, no_identitas, nama_lengkap, tempat_lahir, tgllahir, jenis_kelamin, alamat_lengkap, beratbadan_kg, tinggibadan_cm, notelp_pendonor, nomobile_pendonor, pekerjaan_id, statusperkawinan, gol_darah, rhesus, is_pernah_donor, donasi_ke_sblm, tgl_donor_terakhir, tempat_donor_terakhir, daftardonasi_id, no_formulir, waktu_pendaftaran, instalasi_id, instalasi_nama, ruangan_id, ruangan_nama, pegawaidaftar_id, pegawaidaftar_nip, pegawaidaftar_gelardepan, pegawaidaftar_nama, gelarpendaftar_id, gelarpendaftar_nama, jabatanpendaftar_id, jabatanpendaftar_nama, keterangan_donasi, donasi_ke, seleksidonor_id, tglseleksidonor, pegawaiseleksi_id, pegawaiseleksi_nip, pegawaiseleksi_gelardepan, pegawaiseleksi_nama, gelarseleksi_id, gelarseleksi_nama, jabatanseleksi_id, jabatanseleksi_nama, seleksi_umur, jenisdonor, tekanandarah, td_systolic, td_diastoliic, kadar_hb, suhu_tubuh, detaknadi, is_gagalseleksi, hb_rendah, hb_tinggi, medis_hb_17, medis_td_rendah, medis_tk_tinggi, medis_bb_lebih, medis_vaksin, perilakuberesiko, riwberpergian, lain_lain, catatan_dokter, status_pendonor, pegawaidokter_id, pegawaidokter_nip, pegawaidokter_gelardepan, pegawaidokter_nama, gelardokter_id, gelardokter_nama, jabatandokter_id, jabatandokter_nama', 'safe', 'on'=>'search'),
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
			'profilrs_id' => 'Profilrs',
			'nama_rumahsakit' => 'Nama Rumahsakit',
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
			'pekerjaan_id' => 'Pekerjaan',
			'statusperkawinan' => 'Statusperkawinan',
			'gol_darah' => 'Gol Darah',
			'rhesus' => 'Rhesus',
			'is_pernah_donor' => 'Is Pernah Donor',
			'donasi_ke_sblm' => 'Donasi Ke Sblm',
			'tgl_donor_terakhir' => 'Tgl. Donor Terakhir',
			'tempat_donor_terakhir' => 'Tempat Donor Terakhir',
			'daftardonasi_id' => 'Daftardonasi',
			'no_formulir' => 'No Formulir',
			'waktu_pendaftaran' => 'Waktu Pendaftaran',
			'instalasi_id' => 'Instalasi',
			'instalasi_nama' => 'Instalasi Nama',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
			'pegawaidaftar_id' => 'Pegawaidaftar',
			'pegawaidaftar_nip' => 'Pegawaidaftar Nip',
			'pegawaidaftar_gelardepan' => 'Pegawaidaftar Gelardepan',
			'pegawaidaftar_nama' => 'Pegawaidaftar Nama',
			'gelarpendaftar_id' => 'Gelarpendaftar',
			'gelarpendaftar_nama' => 'Gelarpendaftar Nama',
			'jabatanpendaftar_id' => 'Jabatanpendaftar',
			'jabatanpendaftar_nama' => 'Jabatanpendaftar Nama',
			'keterangan_donasi' => 'Keterangan Donasi',
			'donasi_ke' => 'Donasi Ke',
			'seleksidonor_id' => 'Seleksidonor',
			'tglseleksidonor' => 'Tglseleksidonor',
			'pegawaiseleksi_id' => 'Pegawaiseleksi',
			'pegawaiseleksi_nip' => 'Pegawaiseleksi Nip',
			'pegawaiseleksi_gelardepan' => 'Pegawaiseleksi Gelardepan',
			'pegawaiseleksi_nama' => 'Pegawaiseleksi Nama',
			'gelarseleksi_id' => 'Gelarseleksi',
			'gelarseleksi_nama' => 'Gelarseleksi Nama',
			'jabatanseleksi_id' => 'Jabatanseleksi',
			'jabatanseleksi_nama' => 'Jabatanseleksi Nama',
			'seleksi_umur' => 'Seleksi Umur',
			'jenisdonor' => 'Jenisdonor',
			'tekanandarah' => 'Tekanandarah',
			'td_systolic' => 'Td Systolic',
			'td_diastoliic' => 'Td Diastoliic',
			'kadar_hb' => 'Kadar Hb',
			'suhu_tubuh' => 'Suhu Tubuh',
			'detaknadi' => 'Detaknadi',
			'is_gagalseleksi' => '',
			'hb_rendah' => 'Hb Rendah',
			'hb_tinggi' => 'Hb Tinggi',
			'medis_hb_17' => 'Medis Hb 17',
			'medis_td_rendah' => 'Medis Td Rendah',
			'medis_tk_tinggi' => 'Medis Tk Tinggi',
			'medis_bb_lebih' => 'Medis Bb Lebih',
			'medis_vaksin' => 'Medis Vaksin',
			'perilakuberesiko' => 'Perilakuberesiko',
			'riwberpergian' => 'Riwberpergian',
			'lain_lain' => 'Lain Lain',
			'catatan_dokter' => 'Catatan Dokter',
			'status_pendonor' => 'Status Pendonor',
			'pegawaidokter_id' => 'Pegawaidokter',
			'pegawaidokter_nip' => 'Pegawaidokter Nip',
			'pegawaidokter_gelardepan' => 'Pegawaidokter Gelardepan',
			'pegawaidokter_nama' => 'Pegawaidokter Nama',
			'gelardokter_id' => 'Gelardokter',
			'gelardokter_nama' => 'Gelardokter Nama',
			'jabatandokter_id' => 'Jabatandokter',
			'jabatandokter_nama' => 'Jabatandokter Nama',
                        'status' => ''
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

		$criteria->compare('profilrs_id',$this->profilrs_id);
		$criteria->compare('nama_rumahsakit',$this->nama_rumahsakit,true);
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
		$criteria->compare('pekerjaan_id',$this->pekerjaan_id);
		$criteria->compare('statusperkawinan',$this->statusperkawinan,true);
		$criteria->compare('gol_darah',$this->gol_darah,true);
		$criteria->compare('rhesus',$this->rhesus,true);
		$criteria->compare('is_pernah_donor',$this->is_pernah_donor);
		$criteria->compare('donasi_ke_sblm',$this->donasi_ke_sblm);
		$criteria->compare('tgl_donor_terakhir',$this->tgl_donor_terakhir,true);
		$criteria->compare('tempat_donor_terakhir',$this->tempat_donor_terakhir,true);
		$criteria->compare('daftardonasi_id',$this->daftardonasi_id);
		$criteria->compare('no_formulir',$this->no_formulir,true);
		$criteria->compare('waktu_pendaftaran',$this->waktu_pendaftaran,true);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('instalasi_nama',$this->instalasi_nama,true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);
		$criteria->compare('pegawaidaftar_id',$this->pegawaidaftar_id);
		$criteria->compare('pegawaidaftar_nip',$this->pegawaidaftar_nip,true);
		$criteria->compare('pegawaidaftar_gelardepan',$this->pegawaidaftar_gelardepan,true);
		$criteria->compare('pegawaidaftar_nama',$this->pegawaidaftar_nama,true);
		$criteria->compare('gelarpendaftar_id',$this->gelarpendaftar_id);
		$criteria->compare('gelarpendaftar_nama',$this->gelarpendaftar_nama,true);
		$criteria->compare('jabatanpendaftar_id',$this->jabatanpendaftar_id);
		$criteria->compare('jabatanpendaftar_nama',$this->jabatanpendaftar_nama,true);
		$criteria->compare('keterangan_donasi',$this->keterangan_donasi,true);
		$criteria->compare('donasi_ke',$this->donasi_ke);
		$criteria->compare('seleksidonor_id',$this->seleksidonor_id);
		$criteria->compare('tglseleksidonor',$this->tglseleksidonor,true);
		$criteria->compare('pegawaiseleksi_id',$this->pegawaiseleksi_id);
		$criteria->compare('pegawaiseleksi_nip',$this->pegawaiseleksi_nip,true);
		$criteria->compare('pegawaiseleksi_gelardepan',$this->pegawaiseleksi_gelardepan,true);
		$criteria->compare('pegawaiseleksi_nama',$this->pegawaiseleksi_nama,true);
		$criteria->compare('gelarseleksi_id',$this->gelarseleksi_id);
		$criteria->compare('gelarseleksi_nama',$this->gelarseleksi_nama,true);
		$criteria->compare('jabatanseleksi_id',$this->jabatanseleksi_id);
		$criteria->compare('jabatanseleksi_nama',$this->jabatanseleksi_nama,true);
		$criteria->compare('seleksi_umur',$this->seleksi_umur,true);
		$criteria->compare('jenisdonor',$this->jenisdonor,true);
		$criteria->compare('tekanandarah',$this->tekanandarah,true);
		$criteria->compare('td_systolic',$this->td_systolic);
		$criteria->compare('td_diastoliic',$this->td_diastoliic);
		$criteria->compare('kadar_hb',$this->kadar_hb);
		$criteria->compare('suhu_tubuh',$this->suhu_tubuh);
		$criteria->compare('detaknadi',$this->detaknadi);
		$criteria->compare('is_gagalseleksi',$this->is_gagalseleksi);
		$criteria->compare('hb_rendah',$this->hb_rendah);
		$criteria->compare('hb_tinggi',$this->hb_tinggi);
		$criteria->compare('medis_hb_17',$this->medis_hb_17);
		$criteria->compare('medis_td_rendah',$this->medis_td_rendah);
		$criteria->compare('medis_tk_tinggi',$this->medis_tk_tinggi);
		$criteria->compare('medis_bb_lebih',$this->medis_bb_lebih);
		$criteria->compare('medis_vaksin',$this->medis_vaksin);
		$criteria->compare('perilakuberesiko',$this->perilakuberesiko);
		$criteria->compare('riwberpergian',$this->riwberpergian);
		$criteria->compare('lain_lain',$this->lain_lain);
		$criteria->compare('catatan_dokter',$this->catatan_dokter,true);
		$criteria->compare('status_pendonor',$this->status_pendonor,true);
		$criteria->compare('pegawaidokter_id',$this->pegawaidokter_id);
		$criteria->compare('pegawaidokter_nip',$this->pegawaidokter_nip,true);
		$criteria->compare('pegawaidokter_gelardepan',$this->pegawaidokter_gelardepan,true);
		$criteria->compare('pegawaidokter_nama',$this->pegawaidokter_nama,true);
		$criteria->compare('gelardokter_id',$this->gelardokter_id);
		$criteria->compare('gelardokter_nama',$this->gelardokter_nama,true);
		$criteria->compare('jabatandokter_id',$this->jabatandokter_id);
		$criteria->compare('jabatandokter_nama',$this->jabatandokter_nama,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}