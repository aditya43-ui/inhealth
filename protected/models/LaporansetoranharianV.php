<?php

/**
 * This is the model class for table "laporansetoranharian_v".
 *
 * The followings are the available columns in table 'laporansetoranharian_v':
 * @property integer $pasien_id
 * @property string $jenisidentitas
 * @property string $no_identitas_pasien
 * @property string $namadepan
 * @property string $nama_pasien
 * @property string $nama_bin
 * @property string $jeniskelamin
 * @property string $tempat_lahir
 * @property string $tanggal_lahir
 * @property string $alamat_pasien
 * @property integer $rt
 * @property integer $rw
 * @property string $agama
 * @property string $golongandarah
 * @property string $photopasien
 * @property string $alamatemail
 * @property string $statusrekammedis
 * @property string $statusperkawinan
 * @property string $no_rekam_medik
 * @property string $tgl_rekam_medik
 * @property integer $kelurahan_id
 * @property string $kelurahan_nama
 * @property integer $kecamatan_id
 * @property string $kecamatan_nama
 * @property integer $kabupaten_id
 * @property string $kabupaten_nama
 * @property integer $propinsi_id
 * @property string $propinsi_nama
 * @property integer $pendaftaran_id
 * @property integer $pekerjaan_id
 * @property string $pekerjaan_nama
 * @property integer $pendidikan_id
 * @property string $pendidikan_nama
 * @property integer $suku_id
 * @property string $suku_nama
 * @property string $no_pendaftaran
 * @property string $tgl_pendaftaran
 * @property string $no_urutantri
 * @property string $transportasi
 * @property string $keadaanmasuk
 * @property string $statusperiksa
 * @property string $statuspasien
 * @property string $kunjungan
 * @property boolean $alihstatus
 * @property boolean $byphone
 * @property boolean $kunjunganrumah
 * @property string $statusmasuk
 * @property string $umur
 * @property integer $pembayaranpelayanan_id
 * @property integer $tandabuktibayar_id
 * @property string $nobuktibayar
 * @property string $tgl_pembayaran
 * @property double $totalbiayapelayanan
 * @property double $totalsubsidiasuransi
 * @property double $totalsubsidipemerintah
 * @property double $totalsubsidirs
 * @property double $totaliurbiaya
 * @property double $totaldiscount
 * @property double $totalpembebasan
 * @property double $totalbayartindakan
 * @property string $tgl_closingkasir
 * @property string $closingdari
 * @property string $sampaidengan
 * @property string $keterangan_closing
 * @property integer $bayaruangmuka_id
 * @property integer $tandabuktibayaruangmuka_id
 * @property string $tandabuktibayaruangmuka_nobuktibayar
 * @property string $tgluangmuka
 * @property double $jumlahuangmuka
 * @property string $tglpemakaianuangmuka
 * @property double $pemakaianuangmuka
 * @property integer $shift_id
 * @property string $shift_nama
 * @property integer $pegawai_id
 * @property string $nama_pegawai
 * @property integer $instalasiakhir_id
 * @property string $instalasiakhir_nama
 * @property integer $ruanganakhir_id
 * @property string $ruanganakhir_nama
 * @property integer $ruangankasir_id
 * @property string $ruangankasir_nama
 * @property integer $kasir_id
 * @property string $kasir_nama
 * @property integer $kelaspelayanan_id
 * @property string $kelaspelayanan_nama
 * @property integer $carabayar_id
 * @property string $carabayar_nama
 * @property integer $penjamin_id
 * @property string $penjamin_nama
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 */
class LaporansetoranharianV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporansetoranharianV the static model class
	 */
	public $tgl_awal,$tgl_akhir, $bln_awal, $bln_akhir, $thn_awal, $thn_akhir, $jns_periode;
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'laporansetoranharian_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasien_id, rt, rw, kelurahan_id, kecamatan_id, kabupaten_id, propinsi_id, pendaftaran_id, pekerjaan_id, pendidikan_id, suku_id, pembayaranpelayanan_id, tandabuktibayar_id, bayaruangmuka_id, tandabuktibayaruangmuka_id, shift_id, pegawai_id, instalasiakhir_id, ruanganakhir_id, ruangankasir_id, kasir_id, kelaspelayanan_id, carabayar_id, penjamin_id, ruangan_id', 'numerical', 'integerOnly'=>true),
			array('totalbiayapelayanan, totalsubsidiasuransi, totalsubsidipemerintah, totalsubsidirs, totaliurbiaya, totaldiscount, totalpembebasan, totalbayartindakan, jumlahuangmuka, pemakaianuangmuka', 'numerical'),
			array('jenisidentitas, namadepan, jeniskelamin, agama, statusperkawinan, no_pendaftaran', 'length', 'max'=>20),
			array('no_identitas_pasien, nama_bin, umur', 'length', 'max'=>30),
			array('nama_pasien, kelurahan_nama, kecamatan_nama, kabupaten_nama, propinsi_nama, pekerjaan_nama, pendidikan_nama, suku_nama, transportasi, keadaanmasuk, statusperiksa, statuspasien, kunjungan, statusmasuk, nobuktibayar, tandabuktibayaruangmuka_nobuktibayar, shift_nama, nama_pegawai, instalasiakhir_nama, ruanganakhir_nama, ruangankasir_nama, kasir_nama, kelaspelayanan_nama, carabayar_nama, penjamin_nama, ruangan_nama', 'length', 'max'=>50),
			array('tempat_lahir', 'length', 'max'=>25),
			array('golongandarah', 'length', 'max'=>2),
			array('photopasien', 'length', 'max'=>200),
			array('alamatemail', 'length', 'max'=>100),
			array('statusrekammedis, no_rekam_medik', 'length', 'max'=>10),
			array('no_urutantri', 'length', 'max'=>6),
			array('tanggal_lahir, alamat_pasien, tgl_rekam_medik, tgl_pendaftaran, alihstatus, byphone, kunjunganrumah, tgl_pembayaran, tgl_closingkasir, closingdari, sampaidengan, keterangan_closing, tgluangmuka, tglpemakaianuangmuka', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pasien_id, jenisidentitas, no_identitas_pasien, namadepan, nama_pasien, nama_bin, jeniskelamin, tempat_lahir, tanggal_lahir, alamat_pasien, rt, rw, agama, golongandarah, photopasien, alamatemail, statusrekammedis, statusperkawinan, no_rekam_medik, tgl_rekam_medik, kelurahan_id, kelurahan_nama, kecamatan_id, kecamatan_nama, kabupaten_id, kabupaten_nama, propinsi_id, propinsi_nama, pendaftaran_id, pekerjaan_id, pekerjaan_nama, pendidikan_id, pendidikan_nama, suku_id, suku_nama, no_pendaftaran, tgl_pendaftaran, no_urutantri, transportasi, keadaanmasuk, statusperiksa, statuspasien, kunjungan, alihstatus, byphone, kunjunganrumah, statusmasuk, umur, pembayaranpelayanan_id, tandabuktibayar_id, nobuktibayar, tgl_pembayaran, totalbiayapelayanan, totalsubsidiasuransi, totalsubsidipemerintah, totalsubsidirs, totaliurbiaya, totaldiscount, totalpembebasan, totalbayartindakan, tgl_closingkasir, closingdari, sampaidengan, keterangan_closing, bayaruangmuka_id, tandabuktibayaruangmuka_id, tandabuktibayaruangmuka_nobuktibayar, tgluangmuka, jumlahuangmuka, tglpemakaianuangmuka, pemakaianuangmuka, shift_id, shift_nama, pegawai_id, nama_pegawai, instalasiakhir_id, instalasiakhir_nama, ruanganakhir_id, ruanganakhir_nama, ruangankasir_id, ruangankasir_nama, kasir_id, kasir_nama, kelaspelayanan_id, kelaspelayanan_nama, carabayar_id, carabayar_nama, penjamin_id, penjamin_nama, ruangan_id, ruangan_nama', 'safe', 'on'=>'search'),
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
			'pasien_id' => 'Pasien',
			'jenisidentitas' => 'Jenisidentitas',
			'no_identitas_pasien' => 'No. Identitas Pasien',
			'namadepan' => 'Namadepan',
			'nama_pasien' => 'Nama Pasien',
			'nama_bin' => 'Nama Bin',
			'jeniskelamin' => 'Jenis Kelamin',
			'tempat_lahir' => 'Tempat Lahir',
			'tanggal_lahir' => 'Tanggal Lahir',
			'alamat_pasien' => 'Alamat Pasien',
			'rt' => 'RT',
			'rw' => 'RW',
			'agama' => 'Agama',
			'golongandarah' => 'Golongandarah',
			'photopasien' => 'Photopasien',
			'alamatemail' => 'Alamatemail',
			'statusrekammedis' => 'Statusrekammedis',
			'statusperkawinan' => 'Statusperkawinan',
			'no_rekam_medik' => 'No. Rekam Medik',
			'tgl_rekam_medik' => 'Tgl. Rekam Medik',
			'kelurahan_id' => 'Kelurahan',
			'kelurahan_nama' => 'Kelurahan Nama',
			'kecamatan_id' => 'Kecamatan',
			'kecamatan_nama' => 'Kecamatan Nama',
			'kabupaten_id' => 'Kabupaten',
			'kabupaten_nama' => 'Kabupaten Nama',
			'propinsi_id' => 'Provinsi',
			'propinsi_nama' => 'Propinsi Nama',
			'pendaftaran_id' => 'Pendaftaran',
			'pekerjaan_id' => 'Pekerjaan',
			'pekerjaan_nama' => 'Pekerjaan Nama',
			'pendidikan_id' => 'Pendidikan',
			'pendidikan_nama' => 'Pendidikan Nama',
			'suku_id' => 'Suku',
			'suku_nama' => 'Suku Nama',
			'no_pendaftaran' => 'No. Pendaftaran',
			'tgl_pendaftaran' => 'Tgl. Pendaftaran',
			'no_urutantri' => 'No. Urutantri',
			'transportasi' => 'Transportasi',
			'keadaanmasuk' => 'Keadaanmasuk',
			'statusperiksa' => 'Statusperiksa',
			'statuspasien' => 'Statuspasien',
			'kunjungan' => 'Kunjungan',
			'alihstatus' => 'Alihstatus',
			'byphone' => 'Byphone',
			'kunjunganrumah' => 'Kunjunganrumah',
			'statusmasuk' => 'Statusmasuk',
			'umur' => 'Umur',
			'pembayaranpelayanan_id' => 'Pembayaranpelayanan',
			'tandabuktibayar_id' => 'Tandabuktibayar',
			'nobuktibayar' => 'Nobuktibayar',
			'tgl_pembayaran' => 'Tgl. Pembayaran',
			'totalbiayapelayanan' => 'Totalbiayapelayanan',
			'totalsubsidiasuransi' => 'Totalsubsidiasuransi',
			'totalsubsidipemerintah' => 'Totalsubsidipemerintah',
			'totalsubsidirs' => 'Totalsubsidirs',
			'totaliurbiaya' => 'Totaliurbiaya',
			'totaldiscount' => 'Total Keringanan',
			'totalpembebasan' => 'Totalpembebasan',
			'totalbayartindakan' => 'Totalbayartindakan',
			'tgl_closingkasir' => 'Tgl. Closingkasir',
			'closingdari' => 'Closingdari',
			'sampaidengan' => 'Sampaidengan',
			'keterangan_closing' => 'Keterangan Closing',
			'bayaruangmuka_id' => 'Bayaruangmuka',
			'tandabuktibayaruangmuka_id' => 'Tandabuktibayaruangmuka',
			'tandabuktibayaruangmuka_nobuktibayar' => 'Tandabuktibayaruangmuka Nobuktibayar',
			'tgluangmuka' => 'Tgluangmuka',
			'jumlahuangmuka' => 'Jumlahuangmuka',
			'tglpemakaianuangmuka' => 'Tglpemakaianuangmuka',
			'pemakaianuangmuka' => 'Pemakaianuangmuka',
			'shift_id' => 'Shift',
			'shift_nama' => 'Shift Nama',
			'pegawai_id' => 'Pegawai',
			'nama_pegawai' => 'Nama Pegawai',
			'instalasiakhir_id' => 'Instalasiakhir',
			'instalasiakhir_nama' => 'Instalasiakhir Nama',
			'ruanganakhir_id' => 'Ruanganakhir',
			'ruanganakhir_nama' => 'Ruanganakhir Nama',
			'ruangankasir_id' => 'Ruangankasir',
			'ruangankasir_nama' => 'Ruangankasir Nama',
			'kasir_id' => 'Kasir',
			'kasir_nama' => 'Kasir Nama',
			'kelaspelayanan_id' => 'Kelaspelayanan',
			'kelaspelayanan_nama' => 'Kelaspelayanan Nama',
			'carabayar_id' => 'Jenis Penjamin',
			'carabayar_nama' => 'Carabayar Nama',
			'penjamin_id' => 'Penjamin',
			'penjamin_nama' => 'Penjamin Nama',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
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

		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('jenisidentitas',$this->jenisidentitas,true);
		$criteria->compare('no_identitas_pasien',$this->no_identitas_pasien,true);
		$criteria->compare('namadepan',$this->namadepan,true);
		$criteria->compare('nama_pasien',$this->nama_pasien,true);
		$criteria->compare('nama_bin',$this->nama_bin,true);
		$criteria->compare('jeniskelamin',$this->jeniskelamin,true);
		$criteria->compare('tempat_lahir',$this->tempat_lahir,true);
		$criteria->compare('tanggal_lahir',$this->tanggal_lahir,true);
		$criteria->compare('alamat_pasien',$this->alamat_pasien,true);
		$criteria->compare('rt',$this->rt);
		$criteria->compare('rw',$this->rw);
		$criteria->compare('agama',$this->agama,true);
		$criteria->compare('golongandarah',$this->golongandarah,true);
		$criteria->compare('photopasien',$this->photopasien,true);
		$criteria->compare('alamatemail',$this->alamatemail,true);
		$criteria->compare('statusrekammedis',$this->statusrekammedis,true);
		$criteria->compare('statusperkawinan',$this->statusperkawinan,true);
		$criteria->compare('no_rekam_medik',$this->no_rekam_medik,true);
		$criteria->compare('tgl_rekam_medik',$this->tgl_rekam_medik,true);
		$criteria->compare('kelurahan_id',$this->kelurahan_id);
		$criteria->compare('kelurahan_nama',$this->kelurahan_nama,true);
		$criteria->compare('kecamatan_id',$this->kecamatan_id);
		$criteria->compare('kecamatan_nama',$this->kecamatan_nama,true);
		$criteria->compare('kabupaten_id',$this->kabupaten_id);
		$criteria->compare('kabupaten_nama',$this->kabupaten_nama,true);
		$criteria->compare('propinsi_id',$this->propinsi_id);
		$criteria->compare('propinsi_nama',$this->propinsi_nama,true);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pekerjaan_id',$this->pekerjaan_id);
		$criteria->compare('pekerjaan_nama',$this->pekerjaan_nama,true);
		$criteria->compare('pendidikan_id',$this->pendidikan_id);
		$criteria->compare('pendidikan_nama',$this->pendidikan_nama,true);
		$criteria->compare('suku_id',$this->suku_id);
		$criteria->compare('suku_nama',$this->suku_nama,true);
		$criteria->compare('no_pendaftaran',$this->no_pendaftaran,true);
		$criteria->compare('tgl_pendaftaran',$this->tgl_pendaftaran,true);
		$criteria->compare('no_urutantri',$this->no_urutantri,true);
		$criteria->compare('transportasi',$this->transportasi,true);
		$criteria->compare('keadaanmasuk',$this->keadaanmasuk,true);
		$criteria->compare('statusperiksa',$this->statusperiksa,true);
		$criteria->compare('statuspasien',$this->statuspasien,true);
		$criteria->compare('kunjungan',$this->kunjungan,true);
		$criteria->compare('alihstatus',$this->alihstatus);
		$criteria->compare('byphone',$this->byphone);
		$criteria->compare('kunjunganrumah',$this->kunjunganrumah);
		$criteria->compare('statusmasuk',$this->statusmasuk,true);
		$criteria->compare('umur',$this->umur,true);
		$criteria->compare('pembayaranpelayanan_id',$this->pembayaranpelayanan_id);
		$criteria->compare('tandabuktibayar_id',$this->tandabuktibayar_id);
		$criteria->compare('nobuktibayar',$this->nobuktibayar,true);
		$criteria->compare('tgl_pembayaran',$this->tgl_pembayaran,true);
		$criteria->compare('totalbiayapelayanan',$this->totalbiayapelayanan);
		$criteria->compare('totalsubsidiasuransi',$this->totalsubsidiasuransi);
		$criteria->compare('totalsubsidipemerintah',$this->totalsubsidipemerintah);
		$criteria->compare('totalsubsidirs',$this->totalsubsidirs);
		$criteria->compare('totaliurbiaya',$this->totaliurbiaya);
		$criteria->compare('totaldiscount',$this->totaldiscount);
		$criteria->compare('totalpembebasan',$this->totalpembebasan);
		$criteria->compare('totalbayartindakan',$this->totalbayartindakan);
		$criteria->compare('tgl_closingkasir',$this->tgl_closingkasir,true);
		$criteria->compare('closingdari',$this->closingdari,true);
		$criteria->compare('sampaidengan',$this->sampaidengan,true);
		$criteria->compare('keterangan_closing',$this->keterangan_closing,true);
		$criteria->compare('bayaruangmuka_id',$this->bayaruangmuka_id);
		$criteria->compare('tandabuktibayaruangmuka_id',$this->tandabuktibayaruangmuka_id);
		$criteria->compare('tandabuktibayaruangmuka_nobuktibayar',$this->tandabuktibayaruangmuka_nobuktibayar,true);
		$criteria->compare('tgluangmuka',$this->tgluangmuka,true);
		$criteria->compare('jumlahuangmuka',$this->jumlahuangmuka);
		$criteria->compare('tglpemakaianuangmuka',$this->tglpemakaianuangmuka,true);
		$criteria->compare('pemakaianuangmuka',$this->pemakaianuangmuka);
		$criteria->compare('shift_id',$this->shift_id);
		$criteria->compare('shift_nama',$this->shift_nama,true);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('nama_pegawai',$this->nama_pegawai,true);
		$criteria->compare('instalasiakhir_id',$this->instalasiakhir_id);
		$criteria->compare('instalasiakhir_nama',$this->instalasiakhir_nama,true);
		$criteria->compare('ruanganakhir_id',$this->ruanganakhir_id);
		$criteria->compare('ruanganakhir_nama',$this->ruanganakhir_nama,true);
		$criteria->compare('ruangankasir_id',$this->ruangankasir_id);
		$criteria->compare('ruangankasir_nama',$this->ruangankasir_nama,true);
		$criteria->compare('kasir_id',$this->kasir_id);
		$criteria->compare('kasir_nama',$this->kasir_nama,true);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('kelaspelayanan_nama',$this->kelaspelayanan_nama,true);
		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('carabayar_nama',$this->carabayar_nama,true);
		$criteria->compare('penjamin_id',$this->penjamin_id);
		$criteria->compare('penjamin_nama',$this->penjamin_nama,true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
       
}