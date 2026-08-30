<?php

/**
 * This is the model class for table "kelengkapandokumenkontrak_v".
 * @author Yudhit Widy Wicaksono <yudhitwicaksono@.com>
 * @package application.models
 * The followings are the available columns in table 'kelengkapandokumenkontrak_v':
 * @property integer $periodeanggaran_id
 * @property integer $rencanaumumpengadaan_id
 * @property string $nama_pekerjaan
 * @property string $rencanaumumpengadaan_kategori
 * @property string $metodepengadaan_nama
 * @property string $nomor_rup
 * @property string $nomor_sirup
 * @property string $tanggal_rup
 * @property double $nominal_rup
 * @property integer $pegawaikpa_id
 * @property string $nama_kpa
 * @property integer $pegawaippk_id
 * @property string $nama_ppk
 * @property integer $pptk_id
 * @property string $nama_pptk
 * @property integer $persiapanpengadaan_id
 * @property string $persiapanpengadaan_nomor
 * @property string $persiapanpengadaan_tanggal
 * @property integer $pembukaanpenawaran_id
 * @property string $pembukaanpenawaran_nomor
 * @property string $pembukaanpenawaran_nodok
 * @property string $pembukaanpenawaran_tanggal
 * @property string $pembukaanpenawaran_perbaruanuser
 * @property string $pembukaanpenawaran_perbaruanwaktu
 * @property integer $evaluasipenawaran_id
 * @property string $evaluasipenawaran_nomor
 * @property string $evaluasipenawaran_nodok
 * @property string $evaluasipenawaran_tanggal
 * @property string $evaluasipenawaran_perbaruanuser
 * @property string $evaluasipenawaran_perbaruanwaktu
 * @property integer $banegosiasi_id
 * @property string $banegosiasi_nomor
 * @property string $banegosiasi_nodok
 * @property string $banegosiasi_tanggal
 * @property string $banegosiasi_perbaruanuser
 * @property string $banegosiasi_perbaruanwaktu
 * @property integer $bapengadaanlangsung_id
 * @property string $bapengadaanlangsung_nomor
 * @property string $bapengadaanlangsung_nodok
 * @property string $bapengadaanlangsung_tanggal
 * @property string $bapengadaanlangsung_perbaruanuser
 * @property string $bapengadaanlangsung_perbaruanwaktu
 * @property integer $penetapanpemenang_id
 * @property string $penetapanpemenang_nomor
 * @property string $penetapanpemenang_nodok
 * @property string $penetapanpemenang_tanggal
 * @property string $penetapanpemenang_perbaruanuser
 * @property string $penetapanpemenang_perbaruanwaktu
 * @property integer $pengumumanpemenang_id
 * @property string $pengumumanpemenang_nomor
 * @property string $pengumumanpemenang_nodok
 * @property string $pengumumanpemenang_tanggal
 * @property string $pengumumanpemenang_perbaruanuser
 * @property string $pengumumanpemenang_perbaruanwaktu
 * @property integer $penunjukanpenyedia_id
 * @property string $penunjukanpenyedia_nomor
 * @property string $penunjukanpenyedia_nodok
 * @property string $penunjukanpenyedia_tanggal
 * @property string $penunjukanpenyedia_perbaruanuser
 * @property string $penunjukanpenyedia_perbaruanwaktu
 * @property integer $suratperjanjiankerja_id
 * @property string $nosuratperjanjiankerja
 * @property string $kontrak_nodok
 * @property string $kontrak_kontrak
 * @property double $kontrak_nominal
 * @property string $kontrak_perbaruanuser
 * @property string $kontrak_perbaruanwaktu
 * @property integer $syaratkhususkontrak_id
 * @property string $syaratkhusukontrak_nodok
 * @property string $syaratkhususkontrak_tanggal
 * @property string $syaratkhususkontrak_perbaruanuser
 * @property string $syaratkhususkontrak_perbaruanwaktu
 * @property integer $perintahmulaikerja_id
 * @property string $perintahmulaikerja_nomor
 * @property string $perintahmulaikerja_nodok
 * @property string $perintahmulaikerja_tanggal
 * @property string $perintahmulaikerja_perbaruanuser
 * @property string $perintahmulaikerja_perbaruanwaktu
 * @property integer $perintahpengiriman_id
 * @property string $perintahpengiriman_nomor
 * @property string $perintahpengiriman_nodok
 * @property string $perintahpengiriman_tanggal
 * @property string $perintahpengiriman_perbaruanuser
 * @property string $perintahpengiriman_perbaruanwaktu
 */
class KelengkapandokumenkontrakV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KelengkapandokumenkontrakV the static model class
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
		return 'kelengkapandokumenkontrak_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('periodeanggaran_id, rencanaumumpengadaan_id, pegawaikpa_id, pegawaippk_id, pptk_id, persiapanpengadaan_id, pembukaanpenawaran_id, evaluasipenawaran_id, banegosiasi_id, bapengadaanlangsung_id, penetapanpemenang_id, pengumumanpemenang_id, penunjukanpenyedia_id, suratperjanjiankerja_id, syaratkhususkontrak_id, perintahmulaikerja_id, perintahpengiriman_id', 'numerical', 'integerOnly'=>true),
			array('nominal_rup, kontrak_nominal', 'numerical'),
			array('nama_pekerjaan', 'length', 'max'=>300),
			array('rencanaumumpengadaan_kategori, nomor_rup, persiapanpengadaan_nomor, syaratkhusukontrak_nodok', 'length', 'max'=>20),
			array('metodepengadaan_nama, nosuratperjanjiankerja, kontrak_nodok', 'length', 'max'=>100),
			array('nomor_sirup, nama_kpa, nama_ppk, nama_pptk, pembukaanpenawaran_nomor, pembukaanpenawaran_nodok, pembukaanpenawaran_perbaruanuser, evaluasipenawaran_nomor, evaluasipenawaran_nodok, evaluasipenawaran_perbaruanuser, banegosiasi_nomor, banegosiasi_nodok, banegosiasi_perbaruanuser, bapengadaanlangsung_nomor, bapengadaanlangsung_nodok, bapengadaanlangsung_perbaruanuser, penetapanpemenang_nomor, penetapanpemenang_nodok, penetapanpemenang_perbaruanuser, pengumumanpemenang_nomor, pengumumanpemenang_nodok, pengumumanpemenang_perbaruanuser, penunjukanpenyedia_nomor, penunjukanpenyedia_nodok, penunjukanpenyedia_perbaruanuser, kontrak_perbaruanuser, syaratkhususkontrak_perbaruanuser, perintahmulaikerja_nomor, perintahmulaikerja_nodok, perintahmulaikerja_perbaruanuser, perintahpengiriman_nomor, perintahpengiriman_nodok, perintahpengiriman_perbaruanuser', 'length', 'max'=>50),
			array('tanggal_rup, persiapanpengadaan_tanggal, pembukaanpenawaran_tanggal, pembukaanpenawaran_perbaruanwaktu, evaluasipenawaran_tanggal, evaluasipenawaran_perbaruanwaktu, banegosiasi_tanggal, banegosiasi_perbaruanwaktu, bapengadaanlangsung_tanggal, bapengadaanlangsung_perbaruanwaktu, penetapanpemenang_tanggal, penetapanpemenang_perbaruanwaktu, pengumumanpemenang_tanggal, pengumumanpemenang_perbaruanwaktu, penunjukanpenyedia_tanggal, penunjukanpenyedia_perbaruanwaktu, kontrak_kontrak, kontrak_perbaruanwaktu, syaratkhususkontrak_tanggal, syaratkhususkontrak_perbaruanwaktu, perintahmulaikerja_tanggal, perintahmulaikerja_perbaruanwaktu, perintahpengiriman_tanggal, perintahpengiriman_perbaruanwaktu', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('periodeanggaran_id, rencanaumumpengadaan_id, nama_pekerjaan, rencanaumumpengadaan_kategori, metodepengadaan_nama, nomor_rup, nomor_sirup, tanggal_rup, nominal_rup, pegawaikpa_id, nama_kpa, pegawaippk_id, nama_ppk, pptk_id, nama_pptk, persiapanpengadaan_id, persiapanpengadaan_nomor, persiapanpengadaan_tanggal, pembukaanpenawaran_id, pembukaanpenawaran_nomor, pembukaanpenawaran_nodok, pembukaanpenawaran_tanggal, pembukaanpenawaran_perbaruanuser, pembukaanpenawaran_perbaruanwaktu, evaluasipenawaran_id, evaluasipenawaran_nomor, evaluasipenawaran_nodok, evaluasipenawaran_tanggal, evaluasipenawaran_perbaruanuser, evaluasipenawaran_perbaruanwaktu, banegosiasi_id, banegosiasi_nomor, banegosiasi_nodok, banegosiasi_tanggal, banegosiasi_perbaruanuser, banegosiasi_perbaruanwaktu, bapengadaanlangsung_id, bapengadaanlangsung_nomor, bapengadaanlangsung_nodok, bapengadaanlangsung_tanggal, bapengadaanlangsung_perbaruanuser, bapengadaanlangsung_perbaruanwaktu, penetapanpemenang_id, penetapanpemenang_nomor, penetapanpemenang_nodok, penetapanpemenang_tanggal, penetapanpemenang_perbaruanuser, penetapanpemenang_perbaruanwaktu, pengumumanpemenang_id, pengumumanpemenang_nomor, pengumumanpemenang_nodok, pengumumanpemenang_tanggal, pengumumanpemenang_perbaruanuser, pengumumanpemenang_perbaruanwaktu, penunjukanpenyedia_id, penunjukanpenyedia_nomor, penunjukanpenyedia_nodok, penunjukanpenyedia_tanggal, penunjukanpenyedia_perbaruanuser, penunjukanpenyedia_perbaruanwaktu, suratperjanjiankerja_id, nosuratperjanjiankerja, kontrak_nodok, kontrak_kontrak, kontrak_nominal, kontrak_perbaruanuser, kontrak_perbaruanwaktu, syaratkhususkontrak_id, syaratkhusukontrak_nodok, syaratkhususkontrak_tanggal, syaratkhususkontrak_perbaruanuser, syaratkhususkontrak_perbaruanwaktu, perintahmulaikerja_id, perintahmulaikerja_nomor, perintahmulaikerja_nodok, perintahmulaikerja_tanggal, perintahmulaikerja_perbaruanuser, perintahmulaikerja_perbaruanwaktu, perintahpengiriman_id, perintahpengiriman_nomor, perintahpengiriman_nodok, perintahpengiriman_tanggal, perintahpengiriman_perbaruanuser, perintahpengiriman_perbaruanwaktu', 'safe', 'on'=>'search'),
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
			'periodeanggaran_id' => 'Periodeanggaran',
			'rencanaumumpengadaan_id' => 'Rencanaumumpengadaan',
			'nama_pekerjaan' => 'Nama Pekerjaan',
			'rencanaumumpengadaan_kategori' => 'Rencanaumumpengadaan Kategori',
			'metodepengadaan_nama' => 'Metodepengadaan Nama',
			'nomor_rup' => 'Nomor Rup',
			'nomor_sirup' => 'Nomor Sirup',
			'tanggal_rup' => 'Tanggal Rup',
			'nominal_rup' => 'Nominal Rup',
			'pegawaikpa_id' => 'Pegawaikpa',
			'nama_kpa' => 'Nama Kpa',
			'pegawaippk_id' => 'Pegawaippk',
			'nama_ppk' => 'Nama Ppk',
			'pptk_id' => 'Pptk',
			'nama_pptk' => 'Nama Pptk',
			'persiapanpengadaan_id' => 'Persiapanpengadaan',
			'persiapanpengadaan_nomor' => 'Persiapanpengadaan Nomor',
			'persiapanpengadaan_tanggal' => 'Persiapanpengadaan Tanggal',
			'pembukaanpenawaran_id' => 'Pembukaanpenawaran',
			'pembukaanpenawaran_nomor' => 'Pembukaanpenawaran Nomor',
			'pembukaanpenawaran_nodok' => 'Pembukaanpenawaran Nodok',
			'pembukaanpenawaran_tanggal' => 'Pembukaanpenawaran Tanggal',
			'pembukaanpenawaran_perbaruanuser' => 'Pembukaanpenawaran Perbaruanuser',
			'pembukaanpenawaran_perbaruanwaktu' => 'Pembukaanpenawaran Perbaruanwaktu',
			'evaluasipenawaran_id' => 'Evaluasipenawaran',
			'evaluasipenawaran_nomor' => 'Evaluasipenawaran Nomor',
			'evaluasipenawaran_nodok' => 'Evaluasipenawaran Nodok',
			'evaluasipenawaran_tanggal' => 'Evaluasipenawaran Tanggal',
			'evaluasipenawaran_perbaruanuser' => 'Evaluasipenawaran Perbaruanuser',
			'evaluasipenawaran_perbaruanwaktu' => 'Evaluasipenawaran Perbaruanwaktu',
			'banegosiasi_id' => 'Banegosiasi',
			'banegosiasi_nomor' => 'Banegosiasi Nomor',
			'banegosiasi_nodok' => 'Banegosiasi Nodok',
			'banegosiasi_tanggal' => 'Banegosiasi Tanggal',
			'banegosiasi_perbaruanuser' => 'Banegosiasi Perbaruanuser',
			'banegosiasi_perbaruanwaktu' => 'Banegosiasi Perbaruanwaktu',
			'bapengadaanlangsung_id' => 'Bapengadaanlangsung',
			'bapengadaanlangsung_nomor' => 'Bapengadaanlangsung Nomor',
			'bapengadaanlangsung_nodok' => 'Bapengadaanlangsung Nodok',
			'bapengadaanlangsung_tanggal' => 'Bapengadaanlangsung Tanggal',
			'bapengadaanlangsung_perbaruanuser' => 'Bapengadaanlangsung Perbaruanuser',
			'bapengadaanlangsung_perbaruanwaktu' => 'Bapengadaanlangsung Perbaruanwaktu',
			'penetapanpemenang_id' => 'Penetapanpemenang',
			'penetapanpemenang_nomor' => 'Penetapanpemenang Nomor',
			'penetapanpemenang_nodok' => 'Penetapanpemenang Nodok',
			'penetapanpemenang_tanggal' => 'Penetapanpemenang Tanggal',
			'penetapanpemenang_perbaruanuser' => 'Penetapanpemenang Perbaruanuser',
			'penetapanpemenang_perbaruanwaktu' => 'Penetapanpemenang Perbaruanwaktu',
			'pengumumanpemenang_id' => 'Pengumumanpemenang',
			'pengumumanpemenang_nomor' => 'Pengumumanpemenang Nomor',
			'pengumumanpemenang_nodok' => 'Pengumumanpemenang Nodok',
			'pengumumanpemenang_tanggal' => 'Pengumumanpemenang Tanggal',
			'pengumumanpemenang_perbaruanuser' => 'Pengumumanpemenang Perbaruanuser',
			'pengumumanpemenang_perbaruanwaktu' => 'Pengumumanpemenang Perbaruanwaktu',
			'penunjukanpenyedia_id' => 'Penunjukanpenyedia',
			'penunjukanpenyedia_nomor' => 'Penunjukanpenyedia Nomor',
			'penunjukanpenyedia_nodok' => 'Penunjukanpenyedia Nodok',
			'penunjukanpenyedia_tanggal' => 'Penunjukanpenyedia Tanggal',
			'penunjukanpenyedia_perbaruanuser' => 'Penunjukanpenyedia Perbaruanuser',
			'penunjukanpenyedia_perbaruanwaktu' => 'Penunjukanpenyedia Perbaruanwaktu',
			'suratperjanjiankerja_id' => 'Suratperjanjiankerja',
			'nosuratperjanjiankerja' => 'Nosuratperjanjiankerja',
			'kontrak_nodok' => 'Kontrak Nodok',
			'kontrak_kontrak' => 'Kontrak Kontrak',
			'kontrak_nominal' => 'Kontrak Nominal',
			'kontrak_perbaruanuser' => 'Kontrak Perbaruanuser',
			'kontrak_perbaruanwaktu' => 'Kontrak Perbaruanwaktu',
			'syaratkhususkontrak_id' => 'Syaratkhususkontrak',
			'syaratkhusukontrak_nodok' => 'Syaratkhusukontrak Nodok',
			'syaratkhususkontrak_tanggal' => 'Syaratkhususkontrak Tanggal',
			'syaratkhususkontrak_perbaruanuser' => 'Syaratkhususkontrak Perbaruanuser',
			'syaratkhususkontrak_perbaruanwaktu' => 'Syaratkhususkontrak Perbaruanwaktu',
			'perintahmulaikerja_id' => 'Perintahmulaikerja',
			'perintahmulaikerja_nomor' => 'Perintahmulaikerja Nomor',
			'perintahmulaikerja_nodok' => 'Perintahmulaikerja Nodok',
			'perintahmulaikerja_tanggal' => 'Perintahmulaikerja Tanggal',
			'perintahmulaikerja_perbaruanuser' => 'Perintahmulaikerja Perbaruanuser',
			'perintahmulaikerja_perbaruanwaktu' => 'Perintahmulaikerja Perbaruanwaktu',
			'perintahpengiriman_id' => 'Perintahpengiriman',
			'perintahpengiriman_nomor' => 'Perintahpengiriman Nomor',
			'perintahpengiriman_nodok' => 'Perintahpengiriman Nodok',
			'perintahpengiriman_tanggal' => 'Perintahpengiriman Tanggal',
			'perintahpengiriman_perbaruanuser' => 'Perintahpengiriman Perbaruanuser',
			'perintahpengiriman_perbaruanwaktu' => 'Perintahpengiriman Perbaruanwaktu',
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

		$criteria->compare('periodeanggaran_id',$this->periodeanggaran_id);
		$criteria->compare('rencanaumumpengadaan_id',$this->rencanaumumpengadaan_id);
		$criteria->compare('nama_pekerjaan',$this->nama_pekerjaan,true);
		$criteria->compare('rencanaumumpengadaan_kategori',$this->rencanaumumpengadaan_kategori,true);
		$criteria->compare('metodepengadaan_nama',$this->metodepengadaan_nama,true);
		$criteria->compare('nomor_rup',$this->nomor_rup,true);
		$criteria->compare('nomor_sirup',$this->nomor_sirup,true);
		$criteria->compare('tanggal_rup',$this->tanggal_rup,true);
		$criteria->compare('nominal_rup',$this->nominal_rup);
		$criteria->compare('pegawaikpa_id',$this->pegawaikpa_id);
		$criteria->compare('nama_kpa',$this->nama_kpa,true);
		$criteria->compare('pegawaippk_id',$this->pegawaippk_id);
		$criteria->compare('nama_ppk',$this->nama_ppk,true);
		$criteria->compare('pptk_id',$this->pptk_id);
		$criteria->compare('nama_pptk',$this->nama_pptk,true);
		$criteria->compare('persiapanpengadaan_id',$this->persiapanpengadaan_id);
		$criteria->compare('persiapanpengadaan_nomor',$this->persiapanpengadaan_nomor,true);
		$criteria->compare('persiapanpengadaan_tanggal',$this->persiapanpengadaan_tanggal,true);
		$criteria->compare('pembukaanpenawaran_id',$this->pembukaanpenawaran_id);
		$criteria->compare('pembukaanpenawaran_nomor',$this->pembukaanpenawaran_nomor,true);
		$criteria->compare('pembukaanpenawaran_nodok',$this->pembukaanpenawaran_nodok,true);
		$criteria->compare('pembukaanpenawaran_tanggal',$this->pembukaanpenawaran_tanggal,true);
		$criteria->compare('pembukaanpenawaran_perbaruanuser',$this->pembukaanpenawaran_perbaruanuser,true);
		$criteria->compare('pembukaanpenawaran_perbaruanwaktu',$this->pembukaanpenawaran_perbaruanwaktu,true);
		$criteria->compare('evaluasipenawaran_id',$this->evaluasipenawaran_id);
		$criteria->compare('evaluasipenawaran_nomor',$this->evaluasipenawaran_nomor,true);
		$criteria->compare('evaluasipenawaran_nodok',$this->evaluasipenawaran_nodok,true);
		$criteria->compare('evaluasipenawaran_tanggal',$this->evaluasipenawaran_tanggal,true);
		$criteria->compare('evaluasipenawaran_perbaruanuser',$this->evaluasipenawaran_perbaruanuser,true);
		$criteria->compare('evaluasipenawaran_perbaruanwaktu',$this->evaluasipenawaran_perbaruanwaktu,true);
		$criteria->compare('banegosiasi_id',$this->banegosiasi_id);
		$criteria->compare('banegosiasi_nomor',$this->banegosiasi_nomor,true);
		$criteria->compare('banegosiasi_nodok',$this->banegosiasi_nodok,true);
		$criteria->compare('banegosiasi_tanggal',$this->banegosiasi_tanggal,true);
		$criteria->compare('banegosiasi_perbaruanuser',$this->banegosiasi_perbaruanuser,true);
		$criteria->compare('banegosiasi_perbaruanwaktu',$this->banegosiasi_perbaruanwaktu,true);
		$criteria->compare('bapengadaanlangsung_id',$this->bapengadaanlangsung_id);
		$criteria->compare('bapengadaanlangsung_nomor',$this->bapengadaanlangsung_nomor,true);
		$criteria->compare('bapengadaanlangsung_nodok',$this->bapengadaanlangsung_nodok,true);
		$criteria->compare('bapengadaanlangsung_tanggal',$this->bapengadaanlangsung_tanggal,true);
		$criteria->compare('bapengadaanlangsung_perbaruanuser',$this->bapengadaanlangsung_perbaruanuser,true);
		$criteria->compare('bapengadaanlangsung_perbaruanwaktu',$this->bapengadaanlangsung_perbaruanwaktu,true);
		$criteria->compare('penetapanpemenang_id',$this->penetapanpemenang_id);
		$criteria->compare('penetapanpemenang_nomor',$this->penetapanpemenang_nomor,true);
		$criteria->compare('penetapanpemenang_nodok',$this->penetapanpemenang_nodok,true);
		$criteria->compare('penetapanpemenang_tanggal',$this->penetapanpemenang_tanggal,true);
		$criteria->compare('penetapanpemenang_perbaruanuser',$this->penetapanpemenang_perbaruanuser,true);
		$criteria->compare('penetapanpemenang_perbaruanwaktu',$this->penetapanpemenang_perbaruanwaktu,true);
		$criteria->compare('pengumumanpemenang_id',$this->pengumumanpemenang_id);
		$criteria->compare('pengumumanpemenang_nomor',$this->pengumumanpemenang_nomor,true);
		$criteria->compare('pengumumanpemenang_nodok',$this->pengumumanpemenang_nodok,true);
		$criteria->compare('pengumumanpemenang_tanggal',$this->pengumumanpemenang_tanggal,true);
		$criteria->compare('pengumumanpemenang_perbaruanuser',$this->pengumumanpemenang_perbaruanuser,true);
		$criteria->compare('pengumumanpemenang_perbaruanwaktu',$this->pengumumanpemenang_perbaruanwaktu,true);
		$criteria->compare('penunjukanpenyedia_id',$this->penunjukanpenyedia_id);
		$criteria->compare('penunjukanpenyedia_nomor',$this->penunjukanpenyedia_nomor,true);
		$criteria->compare('penunjukanpenyedia_nodok',$this->penunjukanpenyedia_nodok,true);
		$criteria->compare('penunjukanpenyedia_tanggal',$this->penunjukanpenyedia_tanggal,true);
		$criteria->compare('penunjukanpenyedia_perbaruanuser',$this->penunjukanpenyedia_perbaruanuser,true);
		$criteria->compare('penunjukanpenyedia_perbaruanwaktu',$this->penunjukanpenyedia_perbaruanwaktu,true);
		$criteria->compare('suratperjanjiankerja_id',$this->suratperjanjiankerja_id);
		$criteria->compare('nosuratperjanjiankerja',$this->nosuratperjanjiankerja,true);
		$criteria->compare('kontrak_nodok',$this->kontrak_nodok,true);
		$criteria->compare('kontrak_kontrak',$this->kontrak_kontrak,true);
		$criteria->compare('kontrak_nominal',$this->kontrak_nominal);
		$criteria->compare('kontrak_perbaruanuser',$this->kontrak_perbaruanuser,true);
		$criteria->compare('kontrak_perbaruanwaktu',$this->kontrak_perbaruanwaktu,true);
		$criteria->compare('syaratkhususkontrak_id',$this->syaratkhususkontrak_id);
		$criteria->compare('syaratkhusukontrak_nodok',$this->syaratkhusukontrak_nodok,true);
		$criteria->compare('syaratkhususkontrak_tanggal',$this->syaratkhususkontrak_tanggal,true);
		$criteria->compare('syaratkhususkontrak_perbaruanuser',$this->syaratkhususkontrak_perbaruanuser,true);
		$criteria->compare('syaratkhususkontrak_perbaruanwaktu',$this->syaratkhususkontrak_perbaruanwaktu,true);
		$criteria->compare('perintahmulaikerja_id',$this->perintahmulaikerja_id);
		$criteria->compare('perintahmulaikerja_nomor',$this->perintahmulaikerja_nomor,true);
		$criteria->compare('perintahmulaikerja_nodok',$this->perintahmulaikerja_nodok,true);
		$criteria->compare('perintahmulaikerja_tanggal',$this->perintahmulaikerja_tanggal,true);
		$criteria->compare('perintahmulaikerja_perbaruanuser',$this->perintahmulaikerja_perbaruanuser,true);
		$criteria->compare('perintahmulaikerja_perbaruanwaktu',$this->perintahmulaikerja_perbaruanwaktu,true);
		$criteria->compare('perintahpengiriman_id',$this->perintahpengiriman_id);
		$criteria->compare('perintahpengiriman_nomor',$this->perintahpengiriman_nomor,true);
		$criteria->compare('perintahpengiriman_nodok',$this->perintahpengiriman_nodok,true);
		$criteria->compare('perintahpengiriman_tanggal',$this->perintahpengiriman_tanggal,true);
		$criteria->compare('perintahpengiriman_perbaruanuser',$this->perintahpengiriman_perbaruanuser,true);
		$criteria->compare('perintahpengiriman_perbaruanwaktu',$this->perintahpengiriman_perbaruanwaktu,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}