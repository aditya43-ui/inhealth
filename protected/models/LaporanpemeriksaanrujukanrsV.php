<?php

/**
 * This is the model class for table "laporanpemeriksaanrujukanrs_v".
 *
 * The followings are the available columns in table 'laporanpemeriksaanrujukanrs_v':
 * @property integer $tindakanpelayanan_id
 * @property integer $daftartindakan_id
 * @property string $daftartindakan_kode
 * @property string $daftartindakan_nama
 * @property string $daftartindakan_katakunci
 * @property integer $pemeriksaanlab_id
 * @property integer $pemeriksaanrad_id
 * @property string $jenispemeriksaan
 * @property integer $pasienmasukpenunjang_id
 * @property string $no_masukpenunjang
 * @property double $tarif_satuan
 * @property integer $qty_tindakan
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property integer $tindakansudahbayar_id
 * @property string $tgl_tindakan
 * @property integer $carabayar_id
 * @property string $carabayar_nama
 * @property integer $penjamin_id
 * @property string $penjamin_nama
 * @property double $tarif_kompsatuan
 * @property double $tarif_tindakankomp
 * @property integer $pendaftaran_id
 * @property string $no_pendaftaran
 * @property integer $pasienkirimkeunitlain_id
 * @property string $tgl_kirimpasien
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property string $instalasi_nama
 * @property string $nourut
 * @property integer $pegawai_id
 * @property string $gelardepan
 * @property string $nama_pegawai
 * @property string $gelarbelakang_nama
 * @property integer $jabatan_id
 * @property string $jabatan_nama
 * @property integer $kelompokpegawai_id
 * @property string $kelompokpegawai_nama
 * @property string $tglmasukpenunjang
 * @property integer $pasien_id
 * @property string $namadepan
 * @property string $nama_pasien
 * @property string $nama_bin
 * @property string $jeniskelamin
 * @property string $alamat_pasien
 * @property integer $ruanganasal_id
 * @property string $ruanganasal_nama
 */
class LaporanpemeriksaanrujukanrsV extends CActiveRecord
{
	public $tgl_awal;
	public $tgl_akhir;
	public $bln_awal;
	public $bln_akhir;
	public $thn_awal;
	public $thn_akhir;
	public $jns_periode;
	public $jumlah;
	public $data;
	public $subtotal;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporanpemeriksaanrujukanrsV the static model class
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
		return 'laporanpemeriksaanrujukanrs_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tindakanpelayanan_id, daftartindakan_id, pemeriksaanlab_id, pemeriksaanrad_id, pasienmasukpenunjang_id, qty_tindakan, tindakansudahbayar_id, carabayar_id, penjamin_id, pendaftaran_id, pasienkirimkeunitlain_id, ruangan_id, pegawai_id, jabatan_id, kelompokpegawai_id, pasien_id, ruanganasal_id', 'numerical', 'integerOnly'=>true),
			array('tarif_satuan, tarif_kompsatuan, tarif_tindakankomp', 'numerical'),
			array('daftartindakan_kode, no_masukpenunjang, no_pendaftaran, namadepan, jeniskelamin', 'length', 'max'=>20),
			array('daftartindakan_nama', 'length', 'max'=>200),
			array('daftartindakan_katakunci, kelompokpegawai_nama', 'length', 'max'=>30),
			array('carabayar_nama, penjamin_nama, ruangan_nama, instalasi_nama, nama_pegawai, nama_pasien, nama_bin, ruanganasal_nama', 'length', 'max'=>50),
			array('nourut', 'length', 'max'=>3),
			array('gelardepan', 'length', 'max'=>10),
			array('gelarbelakang_nama', 'length', 'max'=>15),
			array('jabatan_nama', 'length', 'max'=>100),
			array('jenispemeriksaan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, tgl_tindakan, tgl_kirimpasien, tglmasukpenunjang, alamat_pasien', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tindakanpelayanan_id, daftartindakan_id, daftartindakan_kode, daftartindakan_nama, daftartindakan_katakunci, pemeriksaanlab_id, pemeriksaanrad_id, jenispemeriksaan, pasienmasukpenunjang_id, no_masukpenunjang, tarif_satuan, qty_tindakan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, tindakansudahbayar_id, tgl_tindakan, carabayar_id, carabayar_nama, penjamin_id, penjamin_nama, tarif_kompsatuan, tarif_tindakankomp, pendaftaran_id, no_pendaftaran, pasienkirimkeunitlain_id, tgl_kirimpasien, ruangan_id, ruangan_nama, instalasi_nama, nourut, pegawai_id, gelardepan, nama_pegawai, gelarbelakang_nama, jabatan_id, jabatan_nama, kelompokpegawai_id, kelompokpegawai_nama, tglmasukpenunjang, pasien_id, namadepan, nama_pasien, nama_bin, jeniskelamin, alamat_pasien, ruanganasal_id, ruanganasal_nama', 'safe', 'on'=>'search'),
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
			'tindakanpelayanan_id' => 'Tindakanpelayanan',
			'daftartindakan_id' => 'Daftartindakan',
			'daftartindakan_kode' => 'Daftartindakan Kode',
			'daftartindakan_nama' => 'Nama Daftar Tindakan',
			'daftartindakan_katakunci' => 'Daftartindakan Katakunci',
			'pemeriksaanlab_id' => 'Pemeriksaanlab',
			'pemeriksaanrad_id' => 'Pemeriksaanrad',
			'jenispemeriksaan' => 'Jenispemeriksaan',
			'pasienmasukpenunjang_id' => 'Pasienmasukpenunjang',
			'no_masukpenunjang' => 'No Masukpenunjang',
			'tarif_satuan' => 'Tarif Satuan',
			'qty_tindakan' => 'Qty Tindakan',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'tindakansudahbayar_id' => 'Tindakansudahbayar',
			'tgl_tindakan' => 'Tgl. Tindakan',
			'carabayar_id' => 'Jenis Penjamin',
			'carabayar_nama' => 'Carabayar Nama',
			'penjamin_id' => 'Penjamin',
			'penjamin_nama' => 'Penjamin Nama',
			'tarif_kompsatuan' => 'Tarif Kompsatuan',
			'tarif_tindakankomp' => 'Nominal Tarifkomp',
			'pendaftaran_id' => 'Pendaftaran',
			'no_pendaftaran' => 'No. Pendaftaran',
			'pasienkirimkeunitlain_id' => 'Pasienkirimkeunitlain',
			'tgl_kirimpasien' => 'Tgl. Kirimpasien',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
			'instalasi_nama' => 'Instalasi Nama',
			'nourut' => 'Nourut',
			'pegawai_id' => 'Pegawai',
			'gelardepan' => 'Gelardepan',
			'nama_pegawai' => 'Nama Pegawai',
			'gelarbelakang_nama' => 'Gelarbelakang Nama',
			'jabatan_id' => 'Jabatan',
			'jabatan_nama' => 'Jabatan Nama',
			'kelompokpegawai_id' => 'Kelompokpegawai',
			'kelompokpegawai_nama' => 'Kelompokpegawai Nama',
			'tglmasukpenunjang' => 'Tglmasukpenunjang',
			'pasien_id' => 'Pasien',
			'namadepan' => 'Namadepan',
			'nama_pasien' => 'Nama Pasien',
			'nama_bin' => 'Nama Bin',
			'jeniskelamin' => 'Jenis Kelamin',
			'alamat_pasien' => 'Alamat Pasien',
			'ruanganasal_id' => 'Ruanganasal',
			'ruanganasal_nama' => 'Ruanganasal Nama',
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

		$criteria->compare('tindakanpelayanan_id',$this->tindakanpelayanan_id);
		$criteria->compare('daftartindakan_id',$this->daftartindakan_id);
		$criteria->compare('daftartindakan_kode',$this->daftartindakan_kode,true);
		$criteria->compare('daftartindakan_nama',$this->daftartindakan_nama,true);
		$criteria->compare('daftartindakan_katakunci',$this->daftartindakan_katakunci,true);
		$criteria->compare('pemeriksaanlab_id',$this->pemeriksaanlab_id);
		$criteria->compare('pemeriksaanrad_id',$this->pemeriksaanrad_id);
		$criteria->compare('jenispemeriksaan',$this->jenispemeriksaan,true);
		$criteria->compare('pasienmasukpenunjang_id',$this->pasienmasukpenunjang_id);
		$criteria->compare('no_masukpenunjang',$this->no_masukpenunjang,true);
		$criteria->compare('tarif_satuan',$this->tarif_satuan);
		$criteria->compare('qty_tindakan',$this->qty_tindakan);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id,true);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id,true);
		$criteria->compare('create_ruangan',$this->create_ruangan,true);
		$criteria->compare('tindakansudahbayar_id',$this->tindakansudahbayar_id);
		$criteria->compare('tgl_tindakan',$this->tgl_tindakan,true);
		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('carabayar_nama',$this->carabayar_nama,true);
		$criteria->compare('penjamin_id',$this->penjamin_id);
		$criteria->compare('penjamin_nama',$this->penjamin_nama,true);
		$criteria->compare('tarif_kompsatuan',$this->tarif_kompsatuan);
		$criteria->compare('tarif_tindakankomp',$this->tarif_tindakankomp);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('no_pendaftaran',$this->no_pendaftaran,true);
		$criteria->compare('pasienkirimkeunitlain_id',$this->pasienkirimkeunitlain_id);
		$criteria->compare('tgl_kirimpasien',$this->tgl_kirimpasien,true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);
		$criteria->compare('instalasi_nama',$this->instalasi_nama,true);
		$criteria->compare('nourut',$this->nourut,true);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('gelardepan',$this->gelardepan,true);
		$criteria->compare('nama_pegawai',$this->nama_pegawai,true);
		$criteria->compare('gelarbelakang_nama',$this->gelarbelakang_nama,true);
		$criteria->compare('jabatan_id',$this->jabatan_id);
		$criteria->compare('jabatan_nama',$this->jabatan_nama,true);
		$criteria->compare('kelompokpegawai_id',$this->kelompokpegawai_id);
		$criteria->compare('kelompokpegawai_nama',$this->kelompokpegawai_nama,true);
		$criteria->compare('tglmasukpenunjang',$this->tglmasukpenunjang,true);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('namadepan',$this->namadepan,true);
		$criteria->compare('nama_pasien',$this->nama_pasien,true);
		$criteria->compare('nama_bin',$this->nama_bin,true);
		$criteria->compare('jeniskelamin',$this->jeniskelamin,true);
		$criteria->compare('alamat_pasien',$this->alamat_pasien,true);
		$criteria->compare('ruanganasal_id',$this->ruanganasal_id);
		$criteria->compare('ruanganasal_nama',$this->ruanganasal_nama,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function getDokterPengirim(){
		return $this->gelardepan.' '.$this->nama_pegawai.' '.$this->gelarbelakang_nama;
	}
}