<?php

/**
 * This is the model class for table "lappembayaranklaimpiutang_v".
 *
 * The followings are the available columns in table 'lappembayaranklaimpiutang_v':
 * @property integer $pasien_id
 * @property string $no_rekam_medik
 * @property string $nama_pasien
 * @property string $nama_bin
 * @property string $jenisidentitas
 * @property string $no_identitas_pasien
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
 * @property integer $anakke
 * @property integer $jumlah_bersaudara
 * @property string $no_telepon_pasien
 * @property string $no_mobile_pasien
 * @property string $warga_negara
 * @property string $photopasien
 * @property string $alamatemail
 * @property string $statusrekammedis
 * @property string $tgl_meninggal
 * @property boolean $ispasienluar
 * @property string $nama_ibu
 * @property string $nama_ayah
 * @property integer $pendaftaran_id
 * @property string $tgl_pendaftaran
 * @property string $no_pendaftaran
 * @property integer $carabayar_id
 * @property string $carabayar_nama
 * @property integer $penjamin_id
 * @property string $penjamin_nama
 * @property double $diskon_tagihan
 * @property double $diskon_klaim
 * @property double $biaya_administrasi
 * @property double $diskon_rj
 * @property double $diskon_rd
 * @property double $diskon_ri
 * @property integer $pembayarklaim_id
 * @property string $tglpembayaranklaim
 * @property string $nopembayaranklaim
 * @property double $totalpiutang
 * @property double $telahbayar
 * @property double $totalbayar
 * @property double $totalsisapiutang
 * @property integer $bayarke
 * @property string $pembayaranmelalui
 * @property string $nobuktisetor
 * @property string $alamatpenyetor
 * @property string $namabank
 * @property string $norekbank
 * @property integer $pembklaimdetal_id
 * @property integer $pengajuanklaimdetail_id
 * @property double $jmlpiutang
 * @property double $jmltelahbayar
 * @property double $jumlahbayar
 * @property double $jmlsisapiutang
 * @property double $jmldiskon
 * @property double $diskonpersen
 */
class LappembayaranklaimpiutangV extends CActiveRecord
{
	public $tgl_awal;
	public $tgl_akhir;
	public $data;
	public $jumlah;
	public $bln_awal;
	public $bln_akhir;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LappembayaranklaimpiutangV the static model class
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
		return 'lappembayaranklaimpiutang_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasien_id, rt, rw, kelurahan_id, kecamatan_id, kabupaten_id, propinsi_id, anakke, jumlah_bersaudara, pendaftaran_id, carabayar_id, penjamin_id, pembayarklaim_id, bayarke, pembklaimdetal_id, pengajuanklaimdetail_id', 'numerical', 'integerOnly'=>true),
			array('diskon_tagihan, diskon_klaim, biaya_administrasi, diskon_rj, diskon_rd, diskon_ri, totalpiutang, telahbayar, totalbayar, totalsisapiutang, jmlpiutang, jmltelahbayar, jumlahbayar, jmlsisapiutang, jmldiskon, diskonpersen', 'numerical'),
			array('no_rekam_medik, statusrekammedis', 'length', 'max'=>10),
			array('nama_pasien, nama_bin, kelurahan_nama, kecamatan_nama, kabupaten_nama, propinsi_nama, nama_ibu, nama_ayah, carabayar_nama, penjamin_nama, nopembayaranklaim', 'length', 'max'=>50),
			array('jenisidentitas, jeniskelamin, statusperkawinan, agama, rhesus, no_mobile_pasien, no_pendaftaran', 'length', 'max'=>20),
			array('no_identitas_pasien', 'length', 'max'=>30),
			array('tempat_lahir, warga_negara', 'length', 'max'=>25),
			array('golongandarah', 'length', 'max'=>2),
			array('no_telepon_pasien', 'length', 'max'=>15),
			array('photopasien', 'length', 'max'=>200),
			array('alamatemail, pembayaranmelalui, nobuktisetor, namabank, norekbank', 'length', 'max'=>100),
			array('tanggal_lahir, alamat_pasien, tgl_meninggal, ispasienluar, tgl_pendaftaran, tglpembayaranklaim, alamatpenyetor', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pasien_id, no_rekam_medik, nama_pasien, nama_bin, jenisidentitas, no_identitas_pasien, jeniskelamin, tempat_lahir, tanggal_lahir, alamat_pasien, rt, rw, kelurahan_id, kelurahan_nama, kecamatan_id, kecamatan_nama, kabupaten_id, kabupaten_nama, propinsi_id, propinsi_nama, statusperkawinan, agama, golongandarah, rhesus, anakke, jumlah_bersaudara, no_telepon_pasien, no_mobile_pasien, warga_negara, photopasien, alamatemail, statusrekammedis, tgl_meninggal, ispasienluar, nama_ibu, nama_ayah, pendaftaran_id, tgl_pendaftaran, no_pendaftaran, carabayar_id, carabayar_nama, penjamin_id, penjamin_nama, diskon_tagihan, diskon_klaim, biaya_administrasi, diskon_rj, diskon_rd, diskon_ri, pembayarklaim_id, tglpembayaranklaim, nopembayaranklaim, totalpiutang, telahbayar, totalbayar, totalsisapiutang, bayarke, pembayaranmelalui, nobuktisetor, alamatpenyetor, namabank, norekbank, pembklaimdetal_id, pengajuanklaimdetail_id, jmlpiutang, jmltelahbayar, jumlahbayar, jmlsisapiutang, jmldiskon, diskonpersen', 'safe', 'on'=>'search'),
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
			'no_rekam_medik' => 'No. Rekam Medik',
			'nama_pasien' => 'Nama Pasien',
			'nama_bin' => 'Nama Bin',
			'jenisidentitas' => 'Jenisidentitas',
			'no_identitas_pasien' => 'No Identitas Pasien',
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
			'anakke' => 'Anakke',
			'jumlah_bersaudara' => 'Jumlah Bersaudara',
			'no_telepon_pasien' => 'No. Telepon Pasien',
			'no_mobile_pasien' => 'No. Handphone Pasien',
			'warga_negara' => 'Warga Negara',
			'photopasien' => 'Photopasien',
			'alamatemail' => 'Alamatemail',
			'statusrekammedis' => 'Statusrekammedis',
			'tgl_meninggal' => 'Tgl. Meninggal',
			'ispasienluar' => 'Ispasienluar',
			'nama_ibu' => 'Nama Ibu',
			'nama_ayah' => 'Nama Ayah',
			'pendaftaran_id' => 'Pendaftaran',
			'tgl_pendaftaran' => 'Tgl. Pendaftaran',
			'no_pendaftaran' => 'No. Pendaftaran',
			'carabayar_id' => 'Jenis Penjamin',
			'carabayar_nama' => 'Carabayar Nama',
			'penjamin_id' => 'Penjamin',
			'penjamin_nama' => 'Penjamin Nama',
			'diskon_tagihan' => 'Keringanan Tagihan',
			'diskon_klaim' => 'Keringanan Klaim',
			'biaya_administrasi' => 'Biaya Administrasi',
			'diskon_rj' => 'Keringanan Rj',
			'diskon_rd' => 'Keringanan Rd',
			'diskon_ri' => 'Keringanan Ri',
			'pembayarklaim_id' => 'Pembayarklaim',
			'tglpembayaranklaim' => 'Tglpembayaranklaim',
			'nopembayaranklaim' => 'Nopembayaranklaim',
			'totalpiutang' => 'Totalpiutang',
			'telahbayar' => 'Telahbayar',
			'totalbayar' => 'Totalbayar',
			'totalsisapiutang' => 'Totalsisapiutang',
			'bayarke' => 'Bayarke',
			'pembayaranmelalui' => 'Pembayaranmelalui',
			'nobuktisetor' => 'Nobuktisetor',
			'alamatpenyetor' => 'Alamatpenyetor',
			'namabank' => 'Namabank',
			'norekbank' => 'Norekbank',
			'pembklaimdetal_id' => 'Pembklaimdetal',
			'pengajuanklaimdetail_id' => 'Pengajuanklaimdetail',
			'jmlpiutang' => 'Jmlpiutang',
			'jmltelahbayar' => 'Jmltelahbayar',
			'jumlahbayar' => 'Jumlahbayar',
			'jmlsisapiutang' => 'Jmlsisapiutang',
			'jmldiskon' => 'Jumlah Keringanan',
			'diskonpersen' => 'Persen Keringanan',
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
		$criteria->compare('no_rekam_medik',$this->no_rekam_medik,true);
		$criteria->compare('nama_pasien',$this->nama_pasien,true);
		$criteria->compare('nama_bin',$this->nama_bin,true);
		$criteria->compare('jenisidentitas',$this->jenisidentitas,true);
		$criteria->compare('no_identitas_pasien',$this->no_identitas_pasien,true);
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
		$criteria->compare('anakke',$this->anakke);
		$criteria->compare('jumlah_bersaudara',$this->jumlah_bersaudara);
		$criteria->compare('no_telepon_pasien',$this->no_telepon_pasien,true);
		$criteria->compare('no_mobile_pasien',$this->no_mobile_pasien,true);
		$criteria->compare('warga_negara',$this->warga_negara,true);
		$criteria->compare('photopasien',$this->photopasien,true);
		$criteria->compare('alamatemail',$this->alamatemail,true);
		$criteria->compare('statusrekammedis',$this->statusrekammedis,true);
		$criteria->compare('tgl_meninggal',$this->tgl_meninggal,true);
		$criteria->compare('ispasienluar',$this->ispasienluar);
		$criteria->compare('nama_ibu',$this->nama_ibu,true);
		$criteria->compare('nama_ayah',$this->nama_ayah,true);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('tgl_pendaftaran',$this->tgl_pendaftaran,true);
		$criteria->compare('no_pendaftaran',$this->no_pendaftaran,true);
		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('carabayar_nama',$this->carabayar_nama,true);
		$criteria->compare('penjamin_id',$this->penjamin_id);
		$criteria->compare('penjamin_nama',$this->penjamin_nama,true);
		$criteria->compare('diskon_tagihan',$this->diskon_tagihan);
		$criteria->compare('diskon_klaim',$this->diskon_klaim);
		$criteria->compare('biaya_administrasi',$this->biaya_administrasi);
		$criteria->compare('diskon_rj',$this->diskon_rj);
		$criteria->compare('diskon_rd',$this->diskon_rd);
		$criteria->compare('diskon_ri',$this->diskon_ri);
		$criteria->compare('pembayarklaim_id',$this->pembayarklaim_id);
		$criteria->compare('tglpembayaranklaim',$this->tglpembayaranklaim,true);
		$criteria->compare('nopembayaranklaim',$this->nopembayaranklaim,true);
		$criteria->compare('totalpiutang',$this->totalpiutang);
		$criteria->compare('telahbayar',$this->telahbayar);
		$criteria->compare('totalbayar',$this->totalbayar);
		$criteria->compare('totalsisapiutang',$this->totalsisapiutang);
		$criteria->compare('bayarke',$this->bayarke);
		$criteria->compare('pembayaranmelalui',$this->pembayaranmelalui,true);
		$criteria->compare('nobuktisetor',$this->nobuktisetor,true);
		$criteria->compare('alamatpenyetor',$this->alamatpenyetor,true);
		$criteria->compare('namabank',$this->namabank,true);
		$criteria->compare('norekbank',$this->norekbank,true);
		$criteria->compare('pembklaimdetal_id',$this->pembklaimdetal_id);
		$criteria->compare('pengajuanklaimdetail_id',$this->pengajuanklaimdetail_id);
		$criteria->compare('jmlpiutang',$this->jmlpiutang);
		$criteria->compare('jmltelahbayar',$this->jmltelahbayar);
		$criteria->compare('jumlahbayar',$this->jumlahbayar);
		$criteria->compare('jmlsisapiutang',$this->jmlsisapiutang);
		$criteria->compare('jmldiskon',$this->jmldiskon);
		$criteria->compare('diskonpersen',$this->diskonpersen);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}