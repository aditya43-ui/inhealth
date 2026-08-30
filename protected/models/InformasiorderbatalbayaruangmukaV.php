<?php

/**
 * This is the model class for table "informasiorderbatalbayaruangmuka_v".
 *
 * The followings are the available columns in table 'informasiorderbatalbayaruangmuka_v':
 * @property integer $bayaruangmuka_id
 * @property integer $closingkasir_id
 * @property integer $pasienadmisi_id
 * @property integer $pasien_id
 * @property integer $pendaftaran_id
 * @property integer $ruangan_id
 * @property integer $pemakaianuangmuka_id
 * @property integer $tandabuktibayar_id
 * @property integer $instalasi_id
 * @property string $tgluangmuka
 * @property string $nouangmuka
 * @property double $jumlahuangmuka
 * @property string $keteranganuangmuka
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property string $tglperjanjian
 * @property string $keterangan_perjanjian
 * @property double $uangmukadipakai
 * @property string $namadepan
 * @property string $nama_pasien
 * @property string $no_identitas_pasien
 * @property string $jenisidentitas
 * @property string $jeniskelamin
 * @property string $tempat_lahir
 * @property string $tanggal_lahir
 * @property string $alamat_pasien
 * @property integer $rt
 * @property integer $rw
 * @property string $no_telepon_pasien
 * @property string $no_mobile_pasien
 * @property string $statusperkawinan
 * @property integer $kabupaten_id
 * @property integer $kelurahan_id
 * @property string $kabupaten_nama
 * @property string $kelurahan_nama
 * @property integer $kecamatan_id
 * @property string $kecamatan_nama
 * @property integer $propinsi_id
 * @property string $propinsi_nama
 * @property string $no_rekam_medik
 * @property integer $carabayar_id
 * @property integer $penjamin_id
 * @property string $carabayar_nama
 * @property string $penjamin_nama
 * @property string $tgladmisi
 * @property string $tgl_pendaftaran
 * @property string $nobuktibayar
 * @property string $tglbuktibayar
 * @property string $carapembayaran
 * @property string $dengankartu
 * @property string $bankkartu
 * @property string $nokartu
 * @property string $nostrukkartu
 * @property string $darinama_bkm
 * @property double $jmlpembulatan
 * @property double $jmlpembayaran
 * @property double $biayaadministrasi
 * @property double $biayamaterai
 * @property double $uangditerima
 * @property double $uangkembalian
 * @property double $bank_nominal
 * @property string $tglpemakaian
 * @property double $totaluangmuka
 * @property double $pemakaianuangmuka
 * @property double $sisauangmuka
 * @property string $ruangan_nama
 * @property string $instalasi_nama
 * @property string $no_pendaftaran
 * @property integer $jnspembayar_id
 * @property string $jnspembayar_nama
 * @property integer $bankpembayaran_id
 * @property string $namabankpembayaran
 * @property integer $jenispembayaran_id
 * @property string $nostruk
 * @property string $tgltransaksi
 * @property string $tgljatuhtempo
 * @property double $jumlahpembayaran
 * @property boolean $is_verifikasiorderbatal
 */
class InformasiorderbatalbayaruangmukaV extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'informasiorderbatalbayaruangmuka_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('bayaruangmuka_id, closingkasir_id, pasienadmisi_id, pasien_id, pendaftaran_id, ruangan_id, pemakaianuangmuka_id, tandabuktibayar_id, instalasi_id, rt, rw, kabupaten_id, kelurahan_id, kecamatan_id, propinsi_id, carabayar_id, penjamin_id, jnspembayar_id, bankpembayaran_id, jenispembayaran_id', 'numerical', 'integerOnly'=>true),
			array('jumlahuangmuka, uangmukadipakai, jmlpembulatan, jmlpembayaran, biayaadministrasi, biayamaterai, uangditerima, uangkembalian, bank_nominal, totaluangmuka, pemakaianuangmuka, sisauangmuka, jumlahpembayaran', 'numerical'),
			array('nouangmuka, namadepan, jenisidentitas, jeniskelamin, no_mobile_pasien, statusperkawinan, no_pendaftaran', 'length', 'max'=>20),
			array('keterangan_perjanjian', 'length', 'max'=>200),
			array('nama_pasien, penjamin_nama, bankkartu, nokartu, nostrukkartu, darinama_bkm, ruangan_nama, instalasi_nama, jnspembayar_nama, namabankpembayaran', 'length', 'max'=>100),
			array('no_identitas_pasien', 'length', 'max'=>30),
			array('tempat_lahir', 'length', 'max'=>25),
			array('no_telepon_pasien', 'length', 'max'=>15),
			array('kabupaten_nama, kelurahan_nama, kecamatan_nama, propinsi_nama, carabayar_nama, nobuktibayar, carapembayaran, dengankartu, nostruk', 'length', 'max'=>50),
			array('no_rekam_medik', 'length', 'max'=>10),
			array('tgluangmuka, keteranganuangmuka, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, tglperjanjian, tanggal_lahir, alamat_pasien, tgladmisi, tgl_pendaftaran, tglbuktibayar, tglpemakaian, tgltransaksi, tgljatuhtempo, is_verifikasiorderbatal', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('bayaruangmuka_id, closingkasir_id, pasienadmisi_id, pasien_id, pendaftaran_id, ruangan_id, pemakaianuangmuka_id, tandabuktibayar_id, instalasi_id, tgluangmuka, nouangmuka, jumlahuangmuka, keteranganuangmuka, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, tglperjanjian, keterangan_perjanjian, uangmukadipakai, namadepan, nama_pasien, no_identitas_pasien, jenisidentitas, jeniskelamin, tempat_lahir, tanggal_lahir, alamat_pasien, rt, rw, no_telepon_pasien, no_mobile_pasien, statusperkawinan, kabupaten_id, kelurahan_id, kabupaten_nama, kelurahan_nama, kecamatan_id, kecamatan_nama, propinsi_id, propinsi_nama, no_rekam_medik, carabayar_id, penjamin_id, carabayar_nama, penjamin_nama, tgladmisi, tgl_pendaftaran, nobuktibayar, tglbuktibayar, carapembayaran, dengankartu, bankkartu, nokartu, nostrukkartu, darinama_bkm, jmlpembulatan, jmlpembayaran, biayaadministrasi, biayamaterai, uangditerima, uangkembalian, bank_nominal, tglpemakaian, totaluangmuka, pemakaianuangmuka, sisauangmuka, ruangan_nama, instalasi_nama, no_pendaftaran, jnspembayar_id, jnspembayar_nama, bankpembayaran_id, namabankpembayaran, jenispembayaran_id, nostruk, tgltransaksi, tgljatuhtempo, jumlahpembayaran, is_verifikasiorderbatal', 'safe', 'on'=>'search'),
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
			'bayaruangmuka_id' => 'Bayaruangmuka',
			'closingkasir_id' => 'Closingkasir',
			'pasienadmisi_id' => 'Pasienadmisi',
			'pasien_id' => 'Pasien',
			'pendaftaran_id' => 'Pendaftaran',
			'ruangan_id' => 'Ruangan',
			'pemakaianuangmuka_id' => 'Pemakaianuangmuka',
			'tandabuktibayar_id' => 'Tandabuktibayar',
			'instalasi_id' => 'Instalasi',
			'tgluangmuka' => 'Tgluangmuka',
			'nouangmuka' => 'Nouangmuka',
			'jumlahuangmuka' => 'Jumlahuangmuka',
			'keteranganuangmuka' => 'Keteranganuangmuka',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
			'tglperjanjian' => 'Tglperjanjian',
			'keterangan_perjanjian' => 'Keterangan Perjanjian',
			'uangmukadipakai' => 'Uangmukadipakai',
			'namadepan' => 'Namadepan',
			'nama_pasien' => 'Nama Pasien',
			'no_identitas_pasien' => 'No Identitas Pasien',
			'jenisidentitas' => 'Jenisidentitas',
			'jeniskelamin' => 'Jeniskelamin',
			'tempat_lahir' => 'Tempat Lahir',
			'tanggal_lahir' => 'Tanggal Lahir',
			'alamat_pasien' => 'Alamat Pasien',
			'rt' => 'Rt',
			'rw' => 'Rw',
			'no_telepon_pasien' => 'No Telepon Pasien',
			'no_mobile_pasien' => 'No Mobile Pasien',
			'statusperkawinan' => 'Statusperkawinan',
			'kabupaten_id' => 'Kabupaten',
			'kelurahan_id' => 'Kelurahan',
			'kabupaten_nama' => 'Kabupaten Nama',
			'kelurahan_nama' => 'Kelurahan Nama',
			'kecamatan_id' => 'Kecamatan',
			'kecamatan_nama' => 'Kecamatan Nama',
			'propinsi_id' => 'Propinsi',
			'propinsi_nama' => 'Propinsi Nama',
			'no_rekam_medik' => 'No Rekam Medik',
			'carabayar_id' => 'Carabayar',
			'penjamin_id' => 'Penjamin',
			'carabayar_nama' => 'Carabayar Nama',
			'penjamin_nama' => 'Penjamin Nama',
			'tgladmisi' => 'Tgladmisi',
			'tgl_pendaftaran' => 'Tgl Pendaftaran',
			'nobuktibayar' => 'Nobuktibayar',
			'tglbuktibayar' => 'Tglbuktibayar',
			'carapembayaran' => 'Carapembayaran',
			'dengankartu' => 'Dengankartu',
			'bankkartu' => 'Bankkartu',
			'nokartu' => 'Nokartu',
			'nostrukkartu' => 'Nostrukkartu',
			'darinama_bkm' => 'Darinama Bkm',
			'jmlpembulatan' => 'Jmlpembulatan',
			'jmlpembayaran' => 'Jmlpembayaran',
			'biayaadministrasi' => 'Biayaadministrasi',
			'biayamaterai' => 'Biayamaterai',
			'uangditerima' => 'Uangditerima',
			'uangkembalian' => 'Uangkembalian',
			'bank_nominal' => 'Bank Nominal',
			'tglpemakaian' => 'Tglpemakaian',
			'totaluangmuka' => 'Totaluangmuka',
			'pemakaianuangmuka' => 'Pemakaianuangmuka',
			'sisauangmuka' => 'Sisauangmuka',
			'ruangan_nama' => 'Ruangan Nama',
			'instalasi_nama' => 'Instalasi Nama',
			'no_pendaftaran' => 'No Pendaftaran',
			'jnspembayar_id' => 'Jnspembayar',
			'jnspembayar_nama' => 'Jnspembayar Nama',
			'bankpembayaran_id' => 'Bankpembayaran',
			'namabankpembayaran' => 'Namabankpembayaran',
			'jenispembayaran_id' => 'Jenispembayaran',
			'nostruk' => 'Nostruk',
			'tgltransaksi' => 'Tgltransaksi',
			'tgljatuhtempo' => 'Tgljatuhtempo',
			'jumlahpembayaran' => 'Jumlahpembayaran',
			'is_verifikasiorderbatal' => 'Is Verifikasiorderbatal',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('bayaruangmuka_id',$this->bayaruangmuka_id);
		$criteria->compare('closingkasir_id',$this->closingkasir_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('pemakaianuangmuka_id',$this->pemakaianuangmuka_id);
		$criteria->compare('tandabuktibayar_id',$this->tandabuktibayar_id);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('tgluangmuka',$this->tgluangmuka,true);
		$criteria->compare('nouangmuka',$this->nouangmuka,true);
		$criteria->compare('jumlahuangmuka',$this->jumlahuangmuka);
		$criteria->compare('keteranganuangmuka',$this->keteranganuangmuka,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id,true);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id,true);
		$criteria->compare('create_ruangan',$this->create_ruangan,true);
		$criteria->compare('tglperjanjian',$this->tglperjanjian,true);
		$criteria->compare('keterangan_perjanjian',$this->keterangan_perjanjian,true);
		$criteria->compare('uangmukadipakai',$this->uangmukadipakai);
		$criteria->compare('namadepan',$this->namadepan,true);
		$criteria->compare('lower(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('no_identitas_pasien',$this->no_identitas_pasien,true);
		$criteria->compare('jenisidentitas',$this->jenisidentitas,true);
		$criteria->compare('jeniskelamin',$this->jeniskelamin,true);
		$criteria->compare('tempat_lahir',$this->tempat_lahir,true);
		$criteria->compare('tanggal_lahir',$this->tanggal_lahir,true);
		$criteria->compare('alamat_pasien',$this->alamat_pasien,true);
		$criteria->compare('rt',$this->rt);
		$criteria->compare('rw',$this->rw);
		$criteria->compare('no_telepon_pasien',$this->no_telepon_pasien,true);
		$criteria->compare('no_mobile_pasien',$this->no_mobile_pasien,true);
		$criteria->compare('statusperkawinan',$this->statusperkawinan,true);
		$criteria->compare('kabupaten_id',$this->kabupaten_id);
		$criteria->compare('kelurahan_id',$this->kelurahan_id);
		$criteria->compare('kabupaten_nama',$this->kabupaten_nama,true);
		$criteria->compare('kelurahan_nama',$this->kelurahan_nama,true);
		$criteria->compare('kecamatan_id',$this->kecamatan_id);
		$criteria->compare('kecamatan_nama',$this->kecamatan_nama,true);
		$criteria->compare('propinsi_id',$this->propinsi_id);
		$criteria->compare('propinsi_nama',$this->propinsi_nama,true);
		$criteria->compare('lower(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('penjamin_id',$this->penjamin_id);
		$criteria->compare('carabayar_nama',$this->carabayar_nama,true);
		$criteria->compare('penjamin_nama',$this->penjamin_nama,true);
		$criteria->compare('tgladmisi',$this->tgladmisi,true);
		$criteria->compare('tgl_pendaftaran',$this->tgl_pendaftaran,true);
		$criteria->compare('nobuktibayar',$this->nobuktibayar,true);
		$criteria->compare('tglbuktibayar',$this->tglbuktibayar,true);
		$criteria->compare('carapembayaran',$this->carapembayaran,true);
		$criteria->compare('dengankartu',$this->dengankartu,true);
		$criteria->compare('bankkartu',$this->bankkartu,true);
		$criteria->compare('nokartu',$this->nokartu,true);
		$criteria->compare('nostrukkartu',$this->nostrukkartu,true);
		$criteria->compare('darinama_bkm',$this->darinama_bkm,true);
		$criteria->compare('jmlpembulatan',$this->jmlpembulatan);
		$criteria->compare('jmlpembayaran',$this->jmlpembayaran);
		$criteria->compare('biayaadministrasi',$this->biayaadministrasi);
		$criteria->compare('biayamaterai',$this->biayamaterai);
		$criteria->compare('uangditerima',$this->uangditerima);
		$criteria->compare('uangkembalian',$this->uangkembalian);
		$criteria->compare('bank_nominal',$this->bank_nominal);
		$criteria->compare('tglpemakaian',$this->tglpemakaian,true);
		$criteria->compare('totaluangmuka',$this->totaluangmuka);
		$criteria->compare('pemakaianuangmuka',$this->pemakaianuangmuka);
		$criteria->compare('sisauangmuka',$this->sisauangmuka);
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);
		$criteria->compare('instalasi_nama',$this->instalasi_nama,true);
		$criteria->compare('lower(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('jnspembayar_id',$this->jnspembayar_id);
		$criteria->compare('jnspembayar_nama',$this->jnspembayar_nama,true);
		$criteria->compare('bankpembayaran_id',$this->bankpembayaran_id);
		$criteria->compare('namabankpembayaran',$this->namabankpembayaran,true);
		$criteria->compare('jenispembayaran_id',$this->jenispembayaran_id);
		$criteria->compare('nostruk',$this->nostruk,true);
		$criteria->compare('tgltransaksi',$this->tgltransaksi,true);
		$criteria->compare('tgljatuhtempo',$this->tgljatuhtempo,true);
		$criteria->compare('jumlahpembayaran',$this->jumlahpembayaran);
		$criteria->compare('is_verifikasiorderbatal',$this->is_verifikasiorderbatal);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return InformasiorderbatalbayaruangmukaV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
