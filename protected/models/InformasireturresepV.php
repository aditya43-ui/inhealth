<?php

/**
 * This is the model class for table "informasireturresep_v".
 *
 * The followings are the available columns in table 'informasireturresep_v':
 * @property integer $returresep_id
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $penjualanresep_id
 * @property string $tglpenjualan
 * @property string $jenispenjualan
 * @property string $tglresep
 * @property string $noresep
 * @property integer $pendaftaran_id
 * @property string $tgl_pendaftaran
 * @property string $no_pendaftaran
 * @property integer $pasien_id
 * @property string $no_rekam_medik
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
 * @property integer $kelurahan_id
 * @property string $kelurahan_nama
 * @property integer $kecamatan_id
 * @property string $kecamatan_nama
 * @property integer $kabupaten_id
 * @property string $kabupaten_nama
 * @property integer $propinsi_id
 * @property string $propinsi_nama
 * @property string $statusperkawinan
 * @property string $agama
 * @property string $golongandarah
 * @property string $rhesus
 * @property string $no_telepon_pasien
 * @property string $no_mobile_pasien
 * @property string $warga_negara
 * @property string $alamatemail
 * @property string $nama_ibu
 * @property string $nama_ayah
 * @property integer $pasienadmisi_id
 * @property string $tgladmisi
 * @property string $tglretur
 * @property string $noreturresep
 * @property string $alasanretur
 * @property string $keteranganretur
 * @property double $totalretur
 * @property integer $pegawaimengetahui_id
 * @property string $pegawaimengetahui_nip
 * @property string $pegawaimengetahui_jenisidentitas
 * @property string $pegawaimengetahui_noidentitas
 * @property string $pegawaimengetahui_gelardepan
 * @property string $pegawaimengetahui_nama
 * @property string $pegawaimengetahui_gelarbelakang
 * @property integer $pegawairetur_id
 * @property string $pegawairetur_nip
 * @property string $pegawairetur_jenisidentitas
 * @property string $pegawairetur_noidentitas
 * @property string $pegawairetur_gelardepan
 * @property string $pegawairetur_nama
 * @property string $pegawairetur_gelarbelakang
 * @property integer $returbayarpelayanan_id
 * @property string $tglreturpelayanan
 * @property string $noreturbayar
 * @property double $totaloaretur
 * @property integer $tandabuktibayar_id
 * @property string $tglbuktibayar
 * @property string $nobuktibayar
 * @property integer $tandabuktikeluar_id
 * @property string $tglkaskeluar
 * @property string $nokaskeluar
 */
class InformasireturresepV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasireturresepV the static model class
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
		return 'informasireturresep_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('returresep_id, instalasi_id, ruangan_id, penjualanresep_id, pendaftaran_id, pasien_id, rt, rw, kelurahan_id, kecamatan_id, kabupaten_id, propinsi_id, pasienadmisi_id, pegawaimengetahui_id, pegawairetur_id, returbayarpelayanan_id, tandabuktibayar_id, tandabuktikeluar_id', 'numerical', 'integerOnly'=>true),
			array('totalretur, totaloaretur', 'numerical'),
			array('instalasi_nama, ruangan_nama, noresep, nama_pasien, kelurahan_nama, kecamatan_nama, kabupaten_nama, propinsi_nama, nama_ibu, nama_ayah, noreturresep, pegawaimengetahui_nama, pegawairetur_nama, noreturbayar, nobuktibayar, nokaskeluar', 'length', 'max'=>50),
			array('jenispenjualan, alamatemail, pegawaimengetahui_noidentitas, pegawairetur_noidentitas', 'length', 'max'=>100),
			array('no_pendaftaran, jenisidentitas, namadepan, jeniskelamin, statusperkawinan, agama, rhesus, no_mobile_pasien, pegawaimengetahui_jenisidentitas, pegawairetur_jenisidentitas', 'length', 'max'=>20),
			array('no_rekam_medik, pegawaimengetahui_gelardepan, pegawairetur_gelardepan', 'length', 'max'=>10),
			array('no_identitas_pasien, nama_bin, pegawaimengetahui_nip, pegawairetur_nip', 'length', 'max'=>30),
			array('tempat_lahir, warga_negara', 'length', 'max'=>25),
			array('golongandarah', 'length', 'max'=>2),
			array('no_telepon_pasien, pegawaimengetahui_gelarbelakang, pegawairetur_gelarbelakang', 'length', 'max'=>15),
			array('alasanretur', 'length', 'max'=>200),
			array('tglpenjualan, tglresep, tgl_pendaftaran, tanggal_lahir, alamat_pasien, tgladmisi, tglretur, keteranganretur, tglreturpelayanan, tglbuktibayar, tglkaskeluar', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('returresep_id, instalasi_id, instalasi_nama, ruangan_id, ruangan_nama, penjualanresep_id, tglpenjualan, jenispenjualan, tglresep, noresep, pendaftaran_id, tgl_pendaftaran, no_pendaftaran, pasien_id, no_rekam_medik, jenisidentitas, no_identitas_pasien, namadepan, nama_pasien, nama_bin, jeniskelamin, tempat_lahir, tanggal_lahir, alamat_pasien, rt, rw, kelurahan_id, kelurahan_nama, kecamatan_id, kecamatan_nama, kabupaten_id, kabupaten_nama, propinsi_id, propinsi_nama, statusperkawinan, agama, golongandarah, rhesus, no_telepon_pasien, no_mobile_pasien, warga_negara, alamatemail, nama_ibu, nama_ayah, pasienadmisi_id, tgladmisi, tglretur, noreturresep, alasanretur, keteranganretur, totalretur, pegawaimengetahui_id, pegawaimengetahui_nip, pegawaimengetahui_jenisidentitas, pegawaimengetahui_noidentitas, pegawaimengetahui_gelardepan, pegawaimengetahui_nama, pegawaimengetahui_gelarbelakang, pegawairetur_id, pegawairetur_nip, pegawairetur_jenisidentitas, pegawairetur_noidentitas, pegawairetur_gelardepan, pegawairetur_nama, pegawairetur_gelarbelakang, returbayarpelayanan_id, tglreturpelayanan, noreturbayar, totaloaretur, tandabuktibayar_id, tglbuktibayar, nobuktibayar, tandabuktikeluar_id, tglkaskeluar, nokaskeluar', 'safe', 'on'=>'search'),
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
			'returresep_id' => 'Returresep',
			'instalasi_id' => 'Instalasi',
			'instalasi_nama' => 'Instalasi Nama',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
			'penjualanresep_id' => 'Penjualanresep',
			'tglpenjualan' => 'Tglpenjualan',
			'jenispenjualan' => 'Jenispenjualan',
			'tglresep' => 'Tglresep',
			'noresep' => 'Noresep',
			'pendaftaran_id' => 'Pendaftaran',
			'tgl_pendaftaran' => 'Tgl. Pendaftaran',
			'no_pendaftaran' => 'No. Pendaftaran',
			'pasien_id' => 'Pasien',
			'no_rekam_medik' => 'No. Rekam Medik',
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
			'kelurahan_id' => 'Kelurahan',
			'kelurahan_nama' => 'Kelurahan Nama',
			'kecamatan_id' => 'Kecamatan',
			'kecamatan_nama' => 'Kecamatan Nama',
			'kabupaten_id' => 'Kabupaten',
			'kabupaten_nama' => 'Kabupaten Nama',
			'propinsi_id' => 'Provinsi',
			'propinsi_nama' => 'Propinsi Nama',
			'statusperkawinan' => 'Statusperkawinan',
			'agama' => 'Agama',
			'golongandarah' => 'Golongandarah',
			'rhesus' => 'Rhesus',
			'no_telepon_pasien' => 'No. Telepon Pasien',
			'no_mobile_pasien' => 'No. Handphone Pasien',
			'warga_negara' => 'Warga Negara',
			'alamatemail' => 'Alamatemail',
			'nama_ibu' => 'Nama Ibu',
			'nama_ayah' => 'Nama Ayah',
			'pasienadmisi_id' => 'Pasienadmisi',
			'tgladmisi' => 'Tgladmisi',
			'tglretur' => 'Tglretur',
			'noreturresep' => 'Noreturresep',
			'alasanretur' => 'Alasanretur',
			'keteranganretur' => 'Keteranganretur',
			'totalretur' => 'Totalretur',
			'pegawaimengetahui_id' => 'Pegawaimengetahui',
			'pegawaimengetahui_nip' => 'Pegawaimengetahui Nip',
			'pegawaimengetahui_jenisidentitas' => 'Pegawaimengetahui Jenisidentitas',
			'pegawaimengetahui_noidentitas' => 'Pegawaimengetahui Noidentitas',
			'pegawaimengetahui_gelardepan' => 'Pegawaimengetahui Gelardepan',
			'pegawaimengetahui_nama' => 'Pegawaimengetahui Nama',
			'pegawaimengetahui_gelarbelakang' => 'Pegawaimengetahui Gelarbelakang',
			'pegawairetur_id' => 'Pegawairetur',
			'pegawairetur_nip' => 'Pegawairetur Nip',
			'pegawairetur_jenisidentitas' => 'Pegawairetur Jenisidentitas',
			'pegawairetur_noidentitas' => 'Pegawairetur Noidentitas',
			'pegawairetur_gelardepan' => 'Pegawairetur Gelardepan',
			'pegawairetur_nama' => 'Pegawairetur Nama',
			'pegawairetur_gelarbelakang' => 'Pegawairetur Gelarbelakang',
			'returbayarpelayanan_id' => 'Returbayarpelayanan',
			'tglreturpelayanan' => 'Tglreturpelayanan',
			'noreturbayar' => 'Noreturbayar',
			'totaloaretur' => 'Totaloaretur',
			'tandabuktibayar_id' => 'Tandabuktibayar',
			'tglbuktibayar' => 'Tglbuktibayar',
			'nobuktibayar' => 'Nobuktibayar',
			'tandabuktikeluar_id' => 'Tanda Bukti Keluar',
			'tglkaskeluar' => 'Tgl. Kas Keluar',
			'nokaskeluar' => 'No. Kas Keluar',
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

		$criteria->compare('returresep_id',$this->returresep_id);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('instalasi_nama',$this->instalasi_nama,true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);
		$criteria->compare('penjualanresep_id',$this->penjualanresep_id);
		$criteria->compare('tglpenjualan',$this->tglpenjualan,true);
		$criteria->compare('jenispenjualan',$this->jenispenjualan,true);
		$criteria->compare('tglresep',$this->tglresep,true);
		$criteria->compare('noresep',$this->noresep,true);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('tgl_pendaftaran',$this->tgl_pendaftaran,true);
		$criteria->compare('no_pendaftaran',$this->no_pendaftaran,true);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('no_rekam_medik',$this->no_rekam_medik,true);
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
		$criteria->compare('kelurahan_id',$this->kelurahan_id);
		$criteria->compare('kelurahan_nama',$this->kelurahan_nama,true);
		$criteria->compare('kecamatan_id',$this->kecamatan_id);
		$criteria->compare('kecamatan_nama',$this->kecamatan_nama,true);
		$criteria->compare('kabupaten_id',$this->kabupaten_id);
		$criteria->compare('kabupaten_nama',$this->kabupaten_nama,true);
		$criteria->compare('propinsi_id',$this->propinsi_id);
		$criteria->compare('propinsi_nama',$this->propinsi_nama,true);
		$criteria->compare('statusperkawinan',$this->statusperkawinan,true);
		$criteria->compare('agama',$this->agama,true);
		$criteria->compare('golongandarah',$this->golongandarah,true);
		$criteria->compare('rhesus',$this->rhesus,true);
		$criteria->compare('no_telepon_pasien',$this->no_telepon_pasien,true);
		$criteria->compare('no_mobile_pasien',$this->no_mobile_pasien,true);
		$criteria->compare('warga_negara',$this->warga_negara,true);
		$criteria->compare('alamatemail',$this->alamatemail,true);
		$criteria->compare('nama_ibu',$this->nama_ibu,true);
		$criteria->compare('nama_ayah',$this->nama_ayah,true);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('tgladmisi',$this->tgladmisi,true);
		$criteria->compare('tglretur',$this->tglretur,true);
		$criteria->compare('noreturresep',$this->noreturresep,true);
		$criteria->compare('alasanretur',$this->alasanretur,true);
		$criteria->compare('keteranganretur',$this->keteranganretur,true);
		$criteria->compare('totalretur',$this->totalretur);
		$criteria->compare('pegawaimengetahui_id',$this->pegawaimengetahui_id);
		$criteria->compare('pegawaimengetahui_nip',$this->pegawaimengetahui_nip,true);
		$criteria->compare('pegawaimengetahui_jenisidentitas',$this->pegawaimengetahui_jenisidentitas,true);
		$criteria->compare('pegawaimengetahui_noidentitas',$this->pegawaimengetahui_noidentitas,true);
		$criteria->compare('pegawaimengetahui_gelardepan',$this->pegawaimengetahui_gelardepan,true);
		$criteria->compare('pegawaimengetahui_nama',$this->pegawaimengetahui_nama,true);
		$criteria->compare('pegawaimengetahui_gelarbelakang',$this->pegawaimengetahui_gelarbelakang,true);
		$criteria->compare('pegawairetur_id',$this->pegawairetur_id);
		$criteria->compare('pegawairetur_nip',$this->pegawairetur_nip,true);
		$criteria->compare('pegawairetur_jenisidentitas',$this->pegawairetur_jenisidentitas,true);
		$criteria->compare('pegawairetur_noidentitas',$this->pegawairetur_noidentitas,true);
		$criteria->compare('pegawairetur_gelardepan',$this->pegawairetur_gelardepan,true);
		$criteria->compare('pegawairetur_nama',$this->pegawairetur_nama,true);
		$criteria->compare('pegawairetur_gelarbelakang',$this->pegawairetur_gelarbelakang,true);
		$criteria->compare('returbayarpelayanan_id',$this->returbayarpelayanan_id);
		$criteria->compare('tglreturpelayanan',$this->tglreturpelayanan,true);
		$criteria->compare('noreturbayar',$this->noreturbayar,true);
		$criteria->compare('totaloaretur',$this->totaloaretur);
		$criteria->compare('tandabuktibayar_id',$this->tandabuktibayar_id);
		$criteria->compare('tglbuktibayar',$this->tglbuktibayar,true);
		$criteria->compare('nobuktibayar',$this->nobuktibayar,true);
		$criteria->compare('tandabuktikeluar_id',$this->tandabuktikeluar_id);
		$criteria->compare('tglkaskeluar',$this->tglkaskeluar,true);
		$criteria->compare('nokaskeluar',$this->nokaskeluar,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}