<?php

/**
 * This is the model class for table "kartusimpanan_v".
 *
 * The followings are the available columns in table 'kartusimpanan_v':
 * @property integer $pegawai_id
 * @property string $nomorindukpegawai
 * @property string $gelardepan
 * @property string $nama_pegawai
 * @property integer $gelarbelakang_id
 * @property string $gelarbelakang_nama
 * @property string $nama_keluarga
 * @property string $jeniskelamin
 * @property string $statusperkawinan
 * @property string $alamat_pegawai
 * @property string $kategoripegawai
 * @property integer $golonganpegawai_id
 * @property string $golonganpegawai_nama
 * @property integer $jabatan_id
 * @property string $jabatan_nama
 * @property integer $pangkat_id
 * @property string $pangkat_nama
 * @property integer $keanggotaan_id
 * @property string $tglkeanggotaaan
 * @property string $nokeanggotaan
 * @property integer $jenissimpanan_id
 * @property string $jenissimpanan
 * @property string $tglsimpanan
 * @property string $nosimpanan
 * @property double $jumlahsimpanan
 * @property string $satuan
 * @property string $keterangansimpanan
 * @property string $makstglpenarikan
 * @property integer $jangkawaktusimpanan
 * @property double $persenjasa_thn
 * @property double $persenpajak_thn
 * @property integer $buktikasmasukkop_id
 * @property string $tglbuktibayar
 * @property string $nobuktimasuk
 * @property string $carapembayaran
 * @property string $darinama_bkm
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class KartusimpananV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KartusimpananV the static model class
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
		return 'kartusimpanan_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pegawai_id, gelarbelakang_id, golonganpegawai_id, jabatan_id, pangkat_id, keanggotaan_id, jenissimpanan_id, jangkawaktusimpanan, buktikasmasukkop_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('jumlahsimpanan, persenjasa_thn, persenpajak_thn', 'numerical'),
			array('nomorindukpegawai', 'length', 'max'=>30),
			array('gelardepan', 'length', 'max'=>10),
			array('nama_pegawai, nama_keluarga, golonganpegawai_nama, pangkat_nama, nokeanggotaan, jenissimpanan, satuan, nobuktimasuk, carapembayaran', 'length', 'max'=>50),
			array('gelarbelakang_nama', 'length', 'max'=>15),
			array('jeniskelamin, statusperkawinan, nosimpanan', 'length', 'max'=>20),
			array('kategoripegawai', 'length', 'max'=>128),
			array('jabatan_nama, darinama_bkm', 'length', 'max'=>100),
			array('alamat_pegawai, tglkeanggotaaan, tglsimpanan, keterangansimpanan, makstglpenarikan, tglbuktibayar, create_time, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pegawai_id, nomorindukpegawai, gelardepan, nama_pegawai, gelarbelakang_id, gelarbelakang_nama, nama_keluarga, jeniskelamin, statusperkawinan, alamat_pegawai, kategoripegawai, golonganpegawai_id, golonganpegawai_nama, jabatan_id, jabatan_nama, pangkat_id, pangkat_nama, keanggotaan_id, tglkeanggotaaan, nokeanggotaan, jenissimpanan_id, jenissimpanan, tglsimpanan, nosimpanan, jumlahsimpanan, satuan, keterangansimpanan, makstglpenarikan, jangkawaktusimpanan, persenjasa_thn, persenpajak_thn, buktikasmasukkop_id, tglbuktibayar, nobuktimasuk, carapembayaran, darinama_bkm, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'nomorindukpegawai' => 'Nomorindukpegawai',
			'gelardepan' => 'Gelardepan',
			'nama_pegawai' => 'Nama Pegawai',
			'gelarbelakang_id' => 'Gelarbelakang',
			'gelarbelakang_nama' => 'Gelarbelakang Nama',
			'nama_keluarga' => 'Nama Keluarga',
			'jeniskelamin' => 'Jenis Kelamin',
			'statusperkawinan' => 'Statusperkawinan',
			'alamat_pegawai' => 'Alamat Pegawai',
			'kategoripegawai' => 'Kategoripegawai',
			'golonganpegawai_id' => 'Golonganpegawai',
			'golonganpegawai_nama' => 'Golonganpegawai Nama',
			'jabatan_id' => 'Jabatan',
			'jabatan_nama' => 'Jabatan Nama',
			'pangkat_id' => 'Pangkat',
			'pangkat_nama' => 'Pangkat Nama',
			'keanggotaan_id' => 'Keanggotaan',
			'tglkeanggotaaan' => 'Tglkeanggotaaan',
			'nokeanggotaan' => 'No. Anggota',
			'jenissimpanan_id' => 'Jenis Simpanan',
			'jenissimpanan' => 'Jenis Simpanan',
			'tglsimpanan' => 'Tglsimpanan',
			'nosimpanan' => 'No Simpanan',
			'jumlahsimpanan' => 'Jumlahsimpanan',
			'satuan' => 'Satuan',
			'keterangansimpanan' => 'Keterangansimpanan',
			'makstglpenarikan' => 'Makstglpenarikan',
			'jangkawaktusimpanan' => 'Jangkawaktusimpanan',
			'persenjasa_thn' => 'Persenjasa Thn',
			'persenpajak_thn' => 'Persenpajak Thn',
			'buktikasmasukkop_id' => 'Buktikasmasukkop',
			'tglbuktibayar' => 'Tglbuktibayar',
			'nobuktimasuk' => 'Nobuktimasuk',
			'carapembayaran' => 'Carapembayaran',
			'darinama_bkm' => 'Darinama Bkm',
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
		$criteria->compare('nama_keluarga',$this->nama_keluarga,true);
		$criteria->compare('jeniskelamin',$this->jeniskelamin,true);
		$criteria->compare('statusperkawinan',$this->statusperkawinan,true);
		$criteria->compare('alamat_pegawai',$this->alamat_pegawai,true);
		$criteria->compare('kategoripegawai',$this->kategoripegawai,true);
		$criteria->compare('golonganpegawai_id',$this->golonganpegawai_id);
		$criteria->compare('golonganpegawai_nama',$this->golonganpegawai_nama,true);
		$criteria->compare('jabatan_id',$this->jabatan_id);
		$criteria->compare('jabatan_nama',$this->jabatan_nama,true);
		$criteria->compare('pangkat_id',$this->pangkat_id);
		$criteria->compare('pangkat_nama',$this->pangkat_nama,true);
		$criteria->compare('keanggotaan_id',$this->keanggotaan_id);
		$criteria->compare('tglkeanggotaaan',$this->tglkeanggotaaan,true);
		$criteria->compare('nokeanggotaan',$this->nokeanggotaan,true);
		$criteria->compare('jenissimpanan_id',$this->jenissimpanan_id);
		$criteria->compare('jenissimpanan',$this->jenissimpanan,true);
		$criteria->compare('tglsimpanan',$this->tglsimpanan,true);
		$criteria->compare('nosimpanan',$this->nosimpanan,true);
		$criteria->compare('jumlahsimpanan',$this->jumlahsimpanan);
		$criteria->compare('satuan',$this->satuan,true);
		$criteria->compare('keterangansimpanan',$this->keterangansimpanan,true);
		$criteria->compare('makstglpenarikan',$this->makstglpenarikan,true);
		$criteria->compare('jangkawaktusimpanan',$this->jangkawaktusimpanan);
		$criteria->compare('persenjasa_thn',$this->persenjasa_thn);
		$criteria->compare('persenpajak_thn',$this->persenpajak_thn);
		$criteria->compare('buktikasmasukkop_id',$this->buktikasmasukkop_id);
		$criteria->compare('tglbuktibayar',$this->tglbuktibayar,true);
		$criteria->compare('nobuktimasuk',$this->nobuktimasuk,true);
		$criteria->compare('carapembayaran',$this->carapembayaran,true);
		$criteria->compare('darinama_bkm',$this->darinama_bkm,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function getTotalSP($provider) {
		$prov = clone $provider;
		$prov->pagination = false;
		$total = 0;
		foreach ($prov->data as $item) {
			if ($item->jenissimpanan =='Pokok')
			$total += $item->jumlahsimpanan;
		}
		return $total;
	}

	public function getTotalSW($provider) {
		$prov = clone $provider;
		$prov->pagination = false;
		$total = 0;
		foreach ($prov->data as $item) {
			if ($item->jenissimpanan =='Wajib')
			$total += $item->jumlahsimpanan;
		}
		return $total;
	}

	public function getTotalSS($provider) {
		$prov = clone $provider;
		$prov->pagination = false;
		$total = 0;
		foreach ($prov->data as $item) {
			if ($item->jenissimpanan =='Sukarela')
			$total += $item->jumlahsimpanan;
		}
		return $total;
	}

	public function getTotalSD($provider) {
		$prov = clone $provider;
		$prov->pagination = false;
		$total = 0;
		foreach ($prov->data as $item) {
			if ($item->jenissimpanan =='Deposito')
			$total += $item->jumlahsimpanan;
		}
		return $total;
	}

	public function getTotalSemua($provider) {
		return
		$this->getTotalSP($provider) +
		$this->getTotalSW($provider) +
		$this->getTotalSS($provider) +
		$this->getTotalSD($provider);
	}
        
        public function getNamaLengkap()
        {
            return $this->gelardepan.' '.$this->nama_pegawai.' '.$this->gelarbelakang_nama;
        }
}