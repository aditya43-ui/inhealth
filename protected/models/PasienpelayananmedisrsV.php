<?php

/**
 * This is the model class for table "pasienpelayananmedisrs_v".
 *
 * The followings are the available columns in table 'pasienpelayananmedisrs_v':
 * @property integer $pasien_id
 * @property integer $profilrs_id
 * @property string $no_rekam_medik
 * @property string $tgl_rekam_medik
 * @property string $namadepan
 * @property string $nama_pasien
 * @property string $nama_bin
 * @property string $jeniskelamin
 * @property string $tempat_lahir
 * @property string $tanggal_lahir
 * @property string $alamat_pasien
 * @property integer $rt
 * @property integer $rw
 * @property integer $pendaftaran_id
 * @property string $no_pendaftaran
 * @property string $tgl_pendaftaran
 * @property string $umur
 * @property integer $kelaspelayanan_id
 * @property string $kelaspelayanan_nama
 * @property integer $tindakanpelayanan_id
 * @property string $tgl_tindakan
 * @property double $tarif_satuan
 * @property double $tarif_tindakan
 * @property integer $qty_tindakan
 * @property string $satuantindakan
 * @property boolean $cyto_tindakan
 * @property double $tarifcyto_tindakan
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 * @property integer $penjamin_id
 * @property string $penjamin_nama
 * @property integer $daftartindakan_id
 * @property string $daftartindakan_kode
 * @property string $daftartindakan_nama
 * @property integer $kategoritindakan_id
 * @property string $kategoritindakan_nama
 * @property integer $tindakankomponen_id
 * @property integer $komponentarif_id
 * @property string $komponentarif_nama
 * @property double $iurbiayakomp
 * @property double $tarif_tindakankomp
 * @property double $tarifcyto_tindakankomp
 * @property double $tarif_kompsatuan
 * @property string $dokter1_id
 * @property string $dokter1_gelardepan
 * @property string $dokter1_nama_pegawai
 * @property string $dokter1_gelarbelakang
 * @property string $dokter2_id
 * @property string $dokter2_gelardepan
 * @property string $dokter2_nama_pegawai
 * @property string $dokter2_gelarbelakang
 * @property string $bidan_id
 * @property string $bidan_gelardepan
 * @property string $nama_bidan
 * @property string $suster_id
 * @property string $suster_gelardepan
 * @property string $nama_suster
 * @property integer $perawat_id
 * @property string $nama_perawat1
 * @property integer $perawat2_id
 * @property string $nama_perawat2
 */
class PasienpelayananmedisrsV extends CActiveRecord
{
    public $tglpembayaran, $nopembayaran, $carabayar_nama, $discount_tindakan, $jmlpembebasan;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PasienpelayananmedisrsV the static model class
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
		return 'pasienpelayananmedisrs_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasien_id, profilrs_id, rt, rw, pendaftaran_id, kelaspelayanan_id, tindakanpelayanan_id, qty_tindakan, instalasi_id, penjamin_id, daftartindakan_id, kategoritindakan_id, tindakankomponen_id, komponentarif_id, perawat_id, perawat2_id', 'numerical', 'integerOnly'=>true),
			array('tarif_satuan, tarif_tindakan, tarifcyto_tindakan, iurbiayakomp, tarif_tindakankomp, tarifcyto_tindakankomp, tarif_kompsatuan', 'numerical'),
			array('no_rekam_medik, satuantindakan, dokter1_gelardepan, dokter2_gelardepan, bidan_gelardepan, suster_gelardepan', 'length', 'max'=>10),
			array('namadepan, jeniskelamin, no_pendaftaran, daftartindakan_kode', 'length', 'max'=>20),
			array('nama_pasien, nama_bin, kelaspelayanan_nama, instalasi_nama, penjamin_nama, dokter1_nama_pegawai, dokter2_nama_pegawai, nama_bidan, nama_suster, nama_perawat1, nama_perawat2', 'length', 'max'=>50),
			array('tempat_lahir, komponentarif_nama', 'length', 'max'=>25),
			array('umur', 'length', 'max'=>30),
			array('daftartindakan_nama', 'length', 'max'=>200),
			array('kategoritindakan_nama', 'length', 'max'=>150),
			array('dokter1_gelarbelakang, dokter2_gelarbelakang', 'length', 'max'=>15),
			array('tgl_rekam_medik, tanggal_lahir, alamat_pasien, tgl_pendaftaran, tgl_tindakan, cyto_tindakan, dokter1_id, dokter2_id, bidan_id, suster_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pasien_id, profilrs_id, no_rekam_medik, tgl_rekam_medik, namadepan, nama_pasien, nama_bin, jeniskelamin, tempat_lahir, tanggal_lahir, alamat_pasien, rt, rw, pendaftaran_id, no_pendaftaran, tgl_pendaftaran, umur, kelaspelayanan_id, kelaspelayanan_nama, tindakanpelayanan_id, tgl_tindakan, tarif_satuan, tarif_tindakan, qty_tindakan, satuantindakan, cyto_tindakan, tarifcyto_tindakan, instalasi_id, instalasi_nama, penjamin_id, penjamin_nama, daftartindakan_id, daftartindakan_kode, daftartindakan_nama, kategoritindakan_id, kategoritindakan_nama, tindakankomponen_id, komponentarif_id, komponentarif_nama, iurbiayakomp, tarif_tindakankomp, tarifcyto_tindakankomp, tarif_kompsatuan, dokter1_id, dokter1_gelardepan, dokter1_nama_pegawai, dokter1_gelarbelakang, dokter2_id, dokter2_gelardepan, dokter2_nama_pegawai, dokter2_gelarbelakang, bidan_id, bidan_gelardepan, nama_bidan, suster_id, suster_gelardepan, nama_suster, perawat_id, nama_perawat1, perawat2_id, nama_perawat2', 'safe', 'on'=>'search'),
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
			'profilrs_id' => 'Profilrs',
			'no_rekam_medik' => 'No. Rekam Medik',
			'tgl_rekam_medik' => 'Tgl. Rekam Medik',
			'namadepan' => 'Namadepan',
			'nama_pasien' => 'Nama Pasien',
			'nama_bin' => 'Nama Bin',
			'jeniskelamin' => 'Jenis Kelamin',
			'tempat_lahir' => 'Tempat Lahir',
			'tanggal_lahir' => 'Tanggal Lahir',
			'alamat_pasien' => 'Alamat Pasien',
			'rt' => 'RT',
			'rw' => 'RW',
			'pendaftaran_id' => 'Pendaftaran',
			'no_pendaftaran' => 'No. Pendaftaran',
			'tgl_pendaftaran' => 'Tgl. Pendaftaran',
			'umur' => 'Umur',
			'kelaspelayanan_id' => 'Kelaspelayanan',
			'kelaspelayanan_nama' => 'Kelaspelayanan Nama',
			'tindakanpelayanan_id' => 'Tindakanpelayanan',
			'tgl_tindakan' => 'Tgl. Tindakan',
			'tarif_satuan' => 'Tarif Satuan',
			'tarif_tindakan' => 'Nominal Tarif',
			'qty_tindakan' => 'Qty Tindakan',
			'satuantindakan' => 'Satuantindakan',
			'cyto_tindakan' => 'Cyto Tindakan',
			'tarifcyto_tindakan' => 'Tarifcyto Tindakan',
			'instalasi_id' => 'Instalasi',
			'instalasi_nama' => 'Instalasi Nama',
			'penjamin_id' => 'Penjamin',
			'penjamin_nama' => 'Penjamin Nama',
			'daftartindakan_id' => 'Daftartindakan',
			'daftartindakan_kode' => 'Daftartindakan Kode',
			'daftartindakan_nama' => 'Nama Daftar Tindakan',
			'kategoritindakan_id' => 'Kategoritindakan',
			'kategoritindakan_nama' => 'Kategoritindakan Nama',
			'tindakankomponen_id' => 'Tindakankomponen',
			'komponentarif_id' => 'Komponentarif',
			'komponentarif_nama' => 'Komponentarif Nama',
			'iurbiayakomp' => 'Iurbiayakomp',
			'tarif_tindakankomp' => 'Nominal Tarif komp',
			'tarifcyto_tindakankomp' => 'Tarifcyto Tindakankomp',
			'tarif_kompsatuan' => 'Tarif Kompsatuan',
			'dokter1_id' => 'Dokter1',
			'dokter1_gelardepan' => 'Dokter1 Gelardepan',
			'dokter1_nama_pegawai' => 'Dokter1 Nama Pegawai',
			'dokter1_gelarbelakang' => 'Dokter1 Gelarbelakang',
			'dokter2_id' => 'Dokter2',
			'dokter2_gelardepan' => 'Dokter2 Gelardepan',
			'dokter2_nama_pegawai' => 'Dokter2 Nama Pegawai',
			'dokter2_gelarbelakang' => 'Dokter2 Gelarbelakang',
			'bidan_id' => 'Bidan',
			'bidan_gelardepan' => 'Bidan Gelardepan',
			'nama_bidan' => 'Nama Bidan',
			'suster_id' => 'Suster',
			'suster_gelardepan' => 'Suster Gelardepan',
			'nama_suster' => 'Nama Suster',
			'perawat_id' => 'Perawat',
			'nama_perawat1' => 'Nama Perawat1',
			'perawat2_id' => 'Perawat2',
			'nama_perawat2' => 'Nama Perawat2',
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
		$criteria->compare('profilrs_id',$this->profilrs_id);
		$criteria->compare('no_rekam_medik',$this->no_rekam_medik,true);
		$criteria->compare('tgl_rekam_medik',$this->tgl_rekam_medik,true);
		$criteria->compare('namadepan',$this->namadepan,true);
		$criteria->compare('nama_pasien',$this->nama_pasien,true);
		$criteria->compare('nama_bin',$this->nama_bin,true);
		$criteria->compare('jeniskelamin',$this->jeniskelamin,true);
		$criteria->compare('tempat_lahir',$this->tempat_lahir,true);
		$criteria->compare('tanggal_lahir',$this->tanggal_lahir,true);
		$criteria->compare('alamat_pasien',$this->alamat_pasien,true);
		$criteria->compare('rt',$this->rt);
		$criteria->compare('rw',$this->rw);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('no_pendaftaran',$this->no_pendaftaran,true);
		$criteria->compare('tgl_pendaftaran',$this->tgl_pendaftaran,true);
		$criteria->compare('umur',$this->umur,true);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('kelaspelayanan_nama',$this->kelaspelayanan_nama,true);
		$criteria->compare('tindakanpelayanan_id',$this->tindakanpelayanan_id);
		$criteria->compare('tgl_tindakan',$this->tgl_tindakan,true);
		$criteria->compare('tarif_satuan',$this->tarif_satuan);
		$criteria->compare('tarif_tindakan',$this->tarif_tindakan);
		$criteria->compare('qty_tindakan',$this->qty_tindakan);
		$criteria->compare('satuantindakan',$this->satuantindakan,true);
		$criteria->compare('cyto_tindakan',$this->cyto_tindakan);
		$criteria->compare('tarifcyto_tindakan',$this->tarifcyto_tindakan);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('instalasi_nama',$this->instalasi_nama,true);
		$criteria->compare('penjamin_id',$this->penjamin_id);
		$criteria->compare('penjamin_nama',$this->penjamin_nama,true);
		$criteria->compare('daftartindakan_id',$this->daftartindakan_id);
		$criteria->compare('daftartindakan_kode',$this->daftartindakan_kode,true);
		$criteria->compare('daftartindakan_nama',$this->daftartindakan_nama,true);
		$criteria->compare('kategoritindakan_id',$this->kategoritindakan_id);
		$criteria->compare('kategoritindakan_nama',$this->kategoritindakan_nama,true);
		$criteria->compare('tindakankomponen_id',$this->tindakankomponen_id);
		$criteria->compare('komponentarif_id',$this->komponentarif_id);
		$criteria->compare('komponentarif_nama',$this->komponentarif_nama,true);
		$criteria->compare('iurbiayakomp',$this->iurbiayakomp);
		$criteria->compare('tarif_tindakankomp',$this->tarif_tindakankomp);
		$criteria->compare('tarifcyto_tindakankomp',$this->tarifcyto_tindakankomp);
		$criteria->compare('tarif_kompsatuan',$this->tarif_kompsatuan);
		$criteria->compare('dokter1_id',$this->dokter1_id,true);
		$criteria->compare('dokter1_gelardepan',$this->dokter1_gelardepan,true);
		$criteria->compare('dokter1_nama_pegawai',$this->dokter1_nama_pegawai,true);
		$criteria->compare('dokter1_gelarbelakang',$this->dokter1_gelarbelakang,true);
		$criteria->compare('dokter2_id',$this->dokter2_id,true);
		$criteria->compare('dokter2_gelardepan',$this->dokter2_gelardepan,true);
		$criteria->compare('dokter2_nama_pegawai',$this->dokter2_nama_pegawai,true);
		$criteria->compare('dokter2_gelarbelakang',$this->dokter2_gelarbelakang,true);
		$criteria->compare('bidan_id',$this->bidan_id,true);
		$criteria->compare('bidan_gelardepan',$this->bidan_gelardepan,true);
		$criteria->compare('nama_bidan',$this->nama_bidan,true);
		$criteria->compare('suster_id',$this->suster_id,true);
		$criteria->compare('suster_gelardepan',$this->suster_gelardepan,true);
		$criteria->compare('nama_suster',$this->nama_suster,true);
		$criteria->compare('perawat_id',$this->perawat_id);
		$criteria->compare('nama_perawat1',$this->nama_perawat1,true);
		$criteria->compare('perawat2_id',$this->perawat2_id);
		$criteria->compare('nama_perawat2',$this->nama_perawat2,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}