<?php

/**
 * This is the model class for table "informasipembayaranpesangon_v".
 *
 * The followings are the available columns in table 'informasipembayaranpesangon_v':
 * @property integer $jenispengeluaran_id
 * @property string $jenispengeluaran_kode
 * @property string $jenispengeluaran_nama
 * @property integer $pengeluaranumum_id
 * @property string $kelompoktransaksi
 * @property string $nopengeluaran
 * @property string $tglpengeluaran
 * @property integer $tandabuktikeluar_id
 * @property string $tglkaskeluar
 * @property string $nokaskeluar
 * @property integer $pesangonpeg_id
 * @property string $tglpesangon
 * @property string $nopesangon
 * @property integer $pegawai_id
 * @property string $pegawai_nip
 * @property string $pegawai_jenisidentitas
 * @property string $pegawai_noidentitas
 * @property string $pegawai_gelardepan
 * @property string $pegawai_nama
 * @property string $pegawai_gelarbelakang
 * @property string $keterangan
 * @property double $totalterima
 * @property double $totalpajak
 * @property double $totalpotongan
 * @property double $penerimaanbersih
 * @property string $periodegaji
 * @property double $gajipertahun
 * @property double $biayajabatan
 * @property double $potonganpensiun
 * @property string $kodeptkp
 * @property double $ptkppertahun
 * @property double $penerimaanbersihpertahun
 * @property double $pkp
 * @property integer $persentasepph21
 * @property double $pph21pertahun
 * @property double $pph21perbulan
 * @property double $volume
 * @property string $satuanvol
 * @property double $hargasatuan
 * @property double $totalharga
 * @property double $biayaadministrasi
 * @property string $keterangankeluar
 * @property boolean $isurainkeluarumum
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class InformasipembayaranpesangonV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasipembayaranpesangonV the static model class
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
		return 'informasipembayaranpesangon_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jenispengeluaran_id, pengeluaranumum_id, tandabuktikeluar_id, pesangonpeg_id, pegawai_id, persentasepph21', 'numerical', 'integerOnly'=>true),
			array('totalterima, totalpajak, totalpotongan, penerimaanbersih, gajipertahun, biayajabatan, potonganpensiun, ptkppertahun, penerimaanbersihpertahun, pkp, pph21pertahun, pph21perbulan, volume, hargasatuan, totalharga, biayaadministrasi', 'numerical'),
			array('jenispengeluaran_kode, pegawai_jenisidentitas', 'length', 'max'=>20),
			array('jenispengeluaran_nama, pegawai_noidentitas', 'length', 'max'=>100),
			array('kelompoktransaksi, nopengeluaran, nokaskeluar, nopesangon, pegawai_nama, satuanvol', 'length', 'max'=>50),
			array('pegawai_nip', 'length', 'max'=>30),
			array('pegawai_gelardepan', 'length', 'max'=>10),
			array('pegawai_gelarbelakang', 'length', 'max'=>15),
			array('kodeptkp', 'length', 'max'=>5),
			array('tglpengeluaran, tglkaskeluar, tglpesangon, keterangan, periodegaji, keterangankeluar, isurainkeluarumum, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('jenispengeluaran_id, jenispengeluaran_kode, jenispengeluaran_nama, pengeluaranumum_id, kelompoktransaksi, nopengeluaran, tglpengeluaran, tandabuktikeluar_id, tglkaskeluar, nokaskeluar, pesangonpeg_id, tglpesangon, nopesangon, pegawai_id, pegawai_nip, pegawai_jenisidentitas, pegawai_noidentitas, pegawai_gelardepan, pegawai_nama, pegawai_gelarbelakang, keterangan, totalterima, totalpajak, totalpotongan, penerimaanbersih, periodegaji, gajipertahun, biayajabatan, potonganpensiun, kodeptkp, ptkppertahun, penerimaanbersihpertahun, pkp, persentasepph21, pph21pertahun, pph21perbulan, volume, satuanvol, hargasatuan, totalharga, biayaadministrasi, keterangankeluar, isurainkeluarumum, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'jenispengeluaran_id' => 'Jenispengeluaran',
			'jenispengeluaran_kode' => 'Jenispengeluaran Kode',
			'jenispengeluaran_nama' => 'Jenispengeluaran Nama',
			'pengeluaranumum_id' => 'Pengeluaranumum',
			'kelompoktransaksi' => 'Kelompoktransaksi',
			'nopengeluaran' => 'No Pengeluaran',
			'tglpengeluaran' => 'Tglpengeluaran',
			'tandabuktikeluar_id' => 'Tanda Bukti Keluar',
			'tglkaskeluar' => 'Tgl. Kas Keluar',
			'nokaskeluar' => 'No. Kas Keluar',
			'pesangonpeg_id' => 'Pesangonpeg',
			'tglpesangon' => 'Tglpesangon',
			'nopesangon' => 'No Pesangon',
			'pegawai_id' => 'Pegawai',
			'pegawai_nip' => 'Pegawai Nip',
			'pegawai_jenisidentitas' => 'Pegawai Jenisidentitas',
			'pegawai_noidentitas' => 'Pegawai Noidentitas',
			'pegawai_gelardepan' => 'Pegawai Gelardepan',
			'pegawai_nama' => 'Pegawai Nama',
			'pegawai_gelarbelakang' => 'Pegawai Gelarbelakang',
			'keterangan' => 'Keterangan',
			'totalterima' => 'Totalterima',
			'totalpajak' => 'Totalpajak',
			'totalpotongan' => 'Totalpotongan',
			'penerimaanbersih' => 'Penerimaanbersih',
			'periodegaji' => 'Periodegaji',
			'gajipertahun' => 'Gajipertahun',
			'biayajabatan' => 'Biayajabatan',
			'potonganpensiun' => 'Potonganpensiun',
			'kodeptkp' => 'Kodeptkp',
			'ptkppertahun' => 'Ptkppertahun',
			'penerimaanbersihpertahun' => 'Penerimaanbersihpertahun',
			'pkp' => 'Pkp',
			'persentasepph21' => 'Persentasepph21',
			'pph21pertahun' => 'Pph21pertahun',
			'pph21perbulan' => 'Pph21perbulan',
			'volume' => 'Volume',
			'satuanvol' => 'Satuanvol',
			'hargasatuan' => 'Hargasatuan',
			'totalharga' => 'Totalharga',
			'biayaadministrasi' => 'Biaya Administrasi',
			'keterangankeluar' => 'Keterangankeluar',
			'isurainkeluarumum' => 'Isurainkeluarumum',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
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

		$criteria->compare('jenispengeluaran_id',$this->jenispengeluaran_id);
		$criteria->compare('jenispengeluaran_kode',$this->jenispengeluaran_kode,true);
		$criteria->compare('jenispengeluaran_nama',$this->jenispengeluaran_nama,true);
		$criteria->compare('pengeluaranumum_id',$this->pengeluaranumum_id);
		$criteria->compare('kelompoktransaksi',$this->kelompoktransaksi,true);
		$criteria->compare('nopengeluaran',$this->nopengeluaran,true);
		$criteria->compare('tglpengeluaran',$this->tglpengeluaran,true);
		$criteria->compare('tandabuktikeluar_id',$this->tandabuktikeluar_id);
		$criteria->compare('tglkaskeluar',$this->tglkaskeluar,true);
		$criteria->compare('nokaskeluar',$this->nokaskeluar,true);
		$criteria->compare('pesangonpeg_id',$this->pesangonpeg_id);
		$criteria->compare('tglpesangon',$this->tglpesangon,true);
		$criteria->compare('nopesangon',$this->nopesangon,true);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('pegawai_nip',$this->pegawai_nip,true);
		$criteria->compare('pegawai_jenisidentitas',$this->pegawai_jenisidentitas,true);
		$criteria->compare('pegawai_noidentitas',$this->pegawai_noidentitas,true);
		$criteria->compare('pegawai_gelardepan',$this->pegawai_gelardepan,true);
		$criteria->compare('pegawai_nama',$this->pegawai_nama,true);
		$criteria->compare('pegawai_gelarbelakang',$this->pegawai_gelarbelakang,true);
		$criteria->compare('keterangan',$this->keterangan,true);
		$criteria->compare('totalterima',$this->totalterima);
		$criteria->compare('totalpajak',$this->totalpajak);
		$criteria->compare('totalpotongan',$this->totalpotongan);
		$criteria->compare('penerimaanbersih',$this->penerimaanbersih);
		$criteria->compare('periodegaji',$this->periodegaji,true);
		$criteria->compare('gajipertahun',$this->gajipertahun);
		$criteria->compare('biayajabatan',$this->biayajabatan);
		$criteria->compare('potonganpensiun',$this->potonganpensiun);
		$criteria->compare('kodeptkp',$this->kodeptkp,true);
		$criteria->compare('ptkppertahun',$this->ptkppertahun);
		$criteria->compare('penerimaanbersihpertahun',$this->penerimaanbersihpertahun);
		$criteria->compare('pkp',$this->pkp);
		$criteria->compare('persentasepph21',$this->persentasepph21);
		$criteria->compare('pph21pertahun',$this->pph21pertahun);
		$criteria->compare('pph21perbulan',$this->pph21perbulan);
		$criteria->compare('volume',$this->volume);
		$criteria->compare('satuanvol',$this->satuanvol,true);
		$criteria->compare('hargasatuan',$this->hargasatuan);
		$criteria->compare('totalharga',$this->totalharga);
		$criteria->compare('biayaadministrasi',$this->biayaadministrasi);
		$criteria->compare('keterangankeluar',$this->keterangankeluar,true);
		$criteria->compare('isurainkeluarumum',$this->isurainkeluarumum);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id,true);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id,true);
		$criteria->compare('create_ruangan',$this->create_ruangan,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}