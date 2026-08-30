<?php

/**
 * This is the model class for table "infopenerimaanpotongan_v".
 *
 * The followings are the available columns in table 'infopenerimaanpotongan_v':
 * @property integer $pegawai_id
 * @property string $nomorindukpegawai
 * @property string $gelardepan
 * @property string $nama_pegawai
 * @property integer $gelarbelakang_id
 * @property string $gelarbelakang_nama
 * @property string $tempatlahir_pegawai
 * @property string $tgl_lahirpegawai
 * @property string $jeniskelamin
 * @property string $alamat_pegawai
 * @property string $kategoripegawai
 * @property integer $golonganpegawai_id
 * @property string $golonganpegawai_nama
 * @property integer $jabatan_id
 * @property string $jabatan_nama
 * @property integer $pangkat_id
 * @property string $pangkat_nama
 * @property integer $keanggotaan_id
 * @property string $nokeanggotaan
 * @property integer $potongansumber_id
 * @property string $namapotongan
 * @property integer $pengajuanpembayaran_id
 * @property string $tglpengajuanpemb
 * @property string $nopengajuan
 * @property integer $pembayaranangsuran_id
 * @property string $tglpembayaranangsuran
 * @property integer $byrangsuranke
 * @property integer $lamahari_sdhjthtempo
 * @property double $simpananwajib
 * @property double $simpanansukarela
 * @property double $jmlpokok_byrangsuran
 * @property double $jmljasa_byrangsuran
 * @property double $jmldenda_byrangsuran
 * @property double $jmlpengajuan_pengangsuran
 * @property double $jmlsisa_pembangsuran
 * @property double $jmlbayar_pembangsuran
 * @property integer $buktikasmasukkop_id
 * @property string $tglbuktibayar
 * @property string $nobuktimasuk
 * @property string $carapembayaran
 * @property string $sebagaipembayaran_bkm
 * @property double $jmlpembayaran
 * @property double $uangditerima
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class InfopenerimaanpotonganV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InfopenerimaanpotonganV the static model class
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
		return 'infopenerimaanpotongan_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pegawai_id, gelarbelakang_id, golonganpegawai_id, jabatan_id, pangkat_id, keanggotaan_id, potongansumber_id, pengajuanpembayaran_id, pembayaranangsuran_id, byrangsuranke, lamahari_sdhjthtempo, buktikasmasukkop_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('simpananwajib, simpanansukarela, jmlpokok_byrangsuran, jmljasa_byrangsuran, jmldenda_byrangsuran, jmlpengajuan_pengangsuran, jmlsisa_pembangsuran, jmlbayar_pembangsuran, jmlpembayaran, uangditerima', 'numerical'),
			array('nomorindukpegawai, tempatlahir_pegawai', 'length', 'max'=>30),
			array('gelardepan', 'length', 'max'=>10),
			array('nama_pegawai, golonganpegawai_nama, pangkat_nama, nokeanggotaan, nopengajuan, nobuktimasuk, carapembayaran', 'length', 'max'=>50),
			array('gelarbelakang_nama', 'length', 'max'=>15),
			array('jeniskelamin', 'length', 'max'=>20),
			array('kategoripegawai', 'length', 'max'=>128),
			array('jabatan_nama, namapotongan, sebagaipembayaran_bkm', 'length', 'max'=>100),
			array('tgl_lahirpegawai, alamat_pegawai, tglpengajuanpemb, tglpembayaranangsuran, tglbuktibayar, create_time, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pegawai_id, nomorindukpegawai, gelardepan, nama_pegawai, gelarbelakang_id, gelarbelakang_nama, tempatlahir_pegawai, tgl_lahirpegawai, jeniskelamin, alamat_pegawai, kategoripegawai, golonganpegawai_id, golonganpegawai_nama, jabatan_id, jabatan_nama, pangkat_id, pangkat_nama, keanggotaan_id, nokeanggotaan, potongansumber_id, namapotongan, pengajuanpembayaran_id, tglpengajuanpemb, nopengajuan, pembayaranangsuran_id, tglpembayaranangsuran, byrangsuranke, lamahari_sdhjthtempo, simpananwajib, simpanansukarela, jmlpokok_byrangsuran, jmljasa_byrangsuran, jmldenda_byrangsuran, jmlpengajuan_pengangsuran, jmlsisa_pembangsuran, jmlbayar_pembangsuran, buktikasmasukkop_id, tglbuktibayar, nobuktimasuk, carapembayaran, sebagaipembayaran_bkm, jmlpembayaran, uangditerima, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'pegawai_id' => 'Pegawai',
			'nomorindukpegawai' => 'NIP',
			'gelardepan' => 'Gelardepan',
			'nama_pegawai' => 'Nama Pegawai',
			'gelarbelakang_id' => 'Gelar belakang',
			'gelarbelakang_nama' => 'Gelar Belakang',
			'tempatlahir_pegawai' => 'Tempat Lahir Pegawai',
			'tgl_lahirpegawai' => 'Tgl. Lahir Pegawai',
			'jeniskelamin' => 'Jenis Kelamin',
			'alamat_pegawai' => 'Alamat Pegawai',
			'kategoripegawai' => 'Kategori Pegawai',
			'golonganpegawai_id' => 'Golongan Pegawai',
			'golonganpegawai_nama' => 'Golongan Pegawai',
			'jabatan_id' => 'Jabatan',
			'jabatan_nama' => 'Jabatan',
			'pangkat_id' => 'Pangkat',
			'pangkat_nama' => 'Pangkat',
			'keanggotaan_id' => 'Keanggotaan',
			'nokeanggotaan' => 'No Keanggotaan',
			'potongansumber_id' => 'Potongansumber',
			'namapotongan' => 'Potongan',
			'pengajuanpembayaran_id' => 'Pengajuanpembayaran',
			'tglpengajuanpemb' => 'Tgl. Pengajuanpemb',
			'nopengajuan' => 'No. Pengajuan',
			'pembayaranangsuran_id' => 'Pembayaran Angsuran',
			'tglpembayaranangsuran' => 'Tgl. Pembayaran Angsuran',
			'byrangsuranke' => 'Bayar Angsuran Ke',
			'lamahari_sdhjthtempo' => 'Lamahari Sdhjthtempo',
			'simpananwajib' => 'Simpanan Wajib',
			'simpanansukarela' => 'Simpanan Sukarela',
			'jmlpokok_byrangsuran' => 'Jml Pokok Byrangsuran',
			'jmljasa_byrangsuran' => 'Jml Jasa Byrangsuran',
			'jmldenda_byrangsuran' => 'Jml Denda Byrangsuran',
			'jmlpengajuan_pengangsuran' => 'Jmlpengajuan Pengangsuran',
			'jmlsisa_pembangsuran' => 'Jmlsisa Pembangsuran',
			'jmlbayar_pembangsuran' => 'Jmlbayar Pembangsuran',
			'buktikasmasukkop_id' => 'Buktikasmasukkop',
			'tglbuktibayar' => 'Tglbuktibayar',
			'nobuktimasuk' => 'No. Bukti Masuk',
			'carapembayaran' => 'Carapembayaran',
			'sebagaipembayaran_bkm' => 'Sebagaipembayaran Bkm',
			'jmlpembayaran' => 'Jmlpembayaran',
			'uangditerima' => 'Uang Diterima',
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

		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('nomorindukpegawai',$this->nomorindukpegawai,true);
		$criteria->compare('gelardepan',$this->gelardepan,true);
		$criteria->compare('nama_pegawai',$this->nama_pegawai,true);
		$criteria->compare('gelarbelakang_id',$this->gelarbelakang_id);
		$criteria->compare('gelarbelakang_nama',$this->gelarbelakang_nama,true);
		$criteria->compare('tempatlahir_pegawai',$this->tempatlahir_pegawai,true);
		$criteria->compare('tgl_lahirpegawai',$this->tgl_lahirpegawai,true);
		$criteria->compare('jeniskelamin',$this->jeniskelamin,true);
		$criteria->compare('alamat_pegawai',$this->alamat_pegawai,true);
		$criteria->compare('kategoripegawai',$this->kategoripegawai,true);
		$criteria->compare('golonganpegawai_id',$this->golonganpegawai_id);
		$criteria->compare('golonganpegawai_nama',$this->golonganpegawai_nama,true);
		$criteria->compare('jabatan_id',$this->jabatan_id);
		$criteria->compare('jabatan_nama',$this->jabatan_nama,true);
		$criteria->compare('pangkat_id',$this->pangkat_id);
		$criteria->compare('pangkat_nama',$this->pangkat_nama,true);
		$criteria->compare('keanggotaan_id',$this->keanggotaan_id);
		$criteria->compare('nokeanggotaan',$this->nokeanggotaan,true);
		$criteria->compare('potongansumber_id',$this->potongansumber_id);
		$criteria->compare('namapotongan',$this->namapotongan,true);
		$criteria->compare('pengajuanpembayaran_id',$this->pengajuanpembayaran_id);
		$criteria->compare('tglpengajuanpemb',$this->tglpengajuanpemb,true);
		$criteria->compare('nopengajuan',$this->nopengajuan,true);
		$criteria->compare('pembayaranangsuran_id',$this->pembayaranangsuran_id);
		$criteria->compare('tglpembayaranangsuran',$this->tglpembayaranangsuran,true);
		$criteria->compare('byrangsuranke',$this->byrangsuranke);
		$criteria->compare('lamahari_sdhjthtempo',$this->lamahari_sdhjthtempo);
		$criteria->compare('simpananwajib',$this->simpananwajib);
		$criteria->compare('simpanansukarela',$this->simpanansukarela);
		$criteria->compare('jmlpokok_byrangsuran',$this->jmlpokok_byrangsuran);
		$criteria->compare('jmljasa_byrangsuran',$this->jmljasa_byrangsuran);
		$criteria->compare('jmldenda_byrangsuran',$this->jmldenda_byrangsuran);
		$criteria->compare('jmlpengajuan_pengangsuran',$this->jmlpengajuan_pengangsuran);
		$criteria->compare('jmlsisa_pembangsuran',$this->jmlsisa_pembangsuran);
		$criteria->compare('jmlbayar_pembangsuran',$this->jmlbayar_pembangsuran);
		$criteria->compare('buktikasmasukkop_id',$this->buktikasmasukkop_id);
		$criteria->compare('tglbuktibayar',$this->tglbuktibayar,true);
		$criteria->compare('nobuktimasuk',$this->nobuktimasuk,true);
		$criteria->compare('carapembayaran',$this->carapembayaran,true);
		$criteria->compare('sebagaipembayaran_bkm',$this->sebagaipembayaran_bkm,true);
		$criteria->compare('jmlpembayaran',$this->jmlpembayaran);
		$criteria->compare('uangditerima',$this->uangditerima);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function searchPrint(){
		$provider = $this->search();
		$provider->setPagination(false);
		$provider->setSort(false);
		return $provider;
	}

	public function getTotSW($provider) {
		$prov = clone $provider;
		$prov->pagination = false;
		$total = 0;
		foreach ($prov->data as $item) {
			$total += $item->simpananwajib;
		}
		return $total;
	}

	public function getTotSS($provider) {
		$prov = clone $provider;
		$prov->pagination = false;
		$total = 0;
		foreach ($prov->data as $item) {
			$total += $item->simpanansukarela;
		}
		return $total;
	}

	public function getTotPA($provider) {
		$prov = clone $provider;
		$prov->pagination = false;
		$total = 0;
		foreach ($prov->data as $item) {
			$total += $item->jmlpokok_byrangsuran;
		}
		return $total;
	}

	public function getTotJA($provider) {
		$prov = clone $provider;
		$prov->pagination = false;
		$total = 0;
		foreach ($prov->data as $item) {
			$total += $item->jmljasa_byrangsuran;
		}
		return $total;
	}

	public function getTotDA($provider) {
		$prov = clone $provider;
		$prov->pagination = false;
		$total = 0;
		foreach ($prov->data as $item) {
			$total += $item->jmldenda_byrangsuran;
		}
		return $total;
	}

	public function getTotPengajuan($provider) {
		$prov = clone $provider;
		$prov->pagination = false;
		$total = 0;
		foreach ($prov->data as $item) {
			$total += $item->jmlpengajuan_pengangsuran;
		}
		return $total;
	}

	public function getTotPotongan($provider) {
		$prov = clone $provider;
		$prov->pagination = false;
		$total = 0;
		foreach ($prov->data as $item) {
			$total += $item->jmlbayar_pembangsuran;
		}
		return $total;
	}

	public function getTotSisa($provider) {
		$prov = clone $provider;
		$prov->pagination = false;
		$total = 0;
		foreach ($prov->data as $item) {
			$total += $item->jmlsisa_pembangsuran;
		}
		return $total;
	}
}