<?php

/**
 * This is the model class for table "laporanangsuran_v".
 *
 * The followings are the available columns in table 'laporanangsuran_v':
 * @property integer $pegawai_id
 * @property string $nomorindukpegawai
 * @property string $gelardepan
 * @property string $nama_pegawai
 * @property integer $gelarbelakang_id
 * @property string $gelarbelakang_nama
 * @property string $tempatlahir_pegawai
 * @property string $tgl_lahirpegawai
 * @property string $jeniskelamin
 * @property string $statusperkawinan
 * @property string $alamat_pegawai
 * @property integer $kelurahan_id
 * @property string $kelurahan_nama
 * @property string $kategoripegawai
 * @property integer $golonganpegawai_id
 * @property string $golonganpegawai_nama
 * @property integer $jabatan_id
 * @property string $jabatan_nama
 * @property integer $pangkat_id
 * @property string $pangkat_nama
 * @property integer $keanggotaan_id
 * @property string $nokeanggotaan
 * @property integer $pinjaman_id
 * @property string $tglpinjaman
 * @property string $no_pinjaman
 * @property string $jenispinjaman
 * @property integer $jangka_waktu_bln
 * @property double $persen_jasa_pinjaman
 * @property string $jatuh_tempo
 * @property integer $jml_kali_angsur
 * @property double $jml_pinjaman
 * @property double $jasa_pinjaman
 * @property integer $jmlangsuran_id
 * @property string $tglangsuran
 * @property string $tgljatuhtempoangs
 * @property boolean $status_bayar
 * @property boolean $status_pengajuan
 * @property integer $angsuran_ke
 * @property double $jmlpokok_angsuran
 * @property double $jmljasa_angsuran
 * @property double $jmldenda_angsuran
 * @property double $pokok_angsuran
 * @property double $jasa_angsuran
 * @property double $denda_angsuran
 * @property double $bayar_angsuran
 * @property double $sisa_angsuran
 */
class LaporanangsuranV extends CActiveRecord
{
        public $tgl_awal, $bln_awal, $thn_awal;
        public $tgl_akhir, $bln_akhir, $thn_akhir;
        public $jns_periode;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporanangsuranV the static model class
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
		return 'laporanangsuran_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pegawai_id, gelarbelakang_id, kelurahan_id, golonganpegawai_id, jabatan_id, pangkat_id, keanggotaan_id, pinjaman_id, jangka_waktu_bln, jml_kali_angsur, jmlangsuran_id, angsuran_ke', 'numerical', 'integerOnly'=>true),
			array('persen_jasa_pinjaman, jml_pinjaman, jasa_pinjaman, jmlpokok_angsuran, jmljasa_angsuran, jmldenda_angsuran, pokok_angsuran, jasa_angsuran, denda_angsuran, bayar_angsuran, sisa_angsuran', 'numerical'),
			array('nomorindukpegawai, tempatlahir_pegawai', 'length', 'max'=>30),
			array('gelardepan', 'length', 'max'=>10),
			array('nama_pegawai, kelurahan_nama, golonganpegawai_nama, pangkat_nama, nokeanggotaan, no_pinjaman, jenispinjaman', 'length', 'max'=>50),
			array('gelarbelakang_nama', 'length', 'max'=>15),
			array('jeniskelamin, statusperkawinan', 'length', 'max'=>20),
			array('kategoripegawai', 'length', 'max'=>128),
			array('jabatan_nama', 'length', 'max'=>100),
			array('tgl_lahirpegawai, alamat_pegawai, tglpinjaman, jatuh_tempo, tglangsuran, tgljatuhtempoangs, status_bayar, status_pengajuan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pegawai_id, nomorindukpegawai, gelardepan, nama_pegawai, gelarbelakang_id, gelarbelakang_nama, tempatlahir_pegawai, tgl_lahirpegawai, jeniskelamin, statusperkawinan, alamat_pegawai, kelurahan_id, kelurahan_nama, kategoripegawai, golonganpegawai_id, golonganpegawai_nama, jabatan_id, jabatan_nama, pangkat_id, pangkat_nama, keanggotaan_id, nokeanggotaan, pinjaman_id, tglpinjaman, no_pinjaman, jenispinjaman, jangka_waktu_bln, persen_jasa_pinjaman, jatuh_tempo, jml_kali_angsur, jml_pinjaman, jasa_pinjaman, jmlangsuran_id, tglangsuran, tgljatuhtempoangs, status_bayar, status_pengajuan, angsuran_ke, jmlpokok_angsuran, jmljasa_angsuran, jmldenda_angsuran, pokok_angsuran, jasa_angsuran, denda_angsuran, bayar_angsuran, sisa_angsuran', 'safe', 'on'=>'search'),
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
			'tempatlahir_pegawai' => 'Tempatlahir Pegawai',
			'tgl_lahirpegawai' => 'Tgl. Lahir Pegawai',
			'jeniskelamin' => 'Jenis Kelamin',
			'statusperkawinan' => 'Statusperkawinan',
			'alamat_pegawai' => 'Alamat Pegawai',
			'kelurahan_id' => 'Kelurahan',
			'kelurahan_nama' => 'Kelurahan Nama',
			'kategoripegawai' => 'Kategoripegawai',
			'golonganpegawai_id' => 'Golonganpegawai',
			'golonganpegawai_nama' => 'Golonganpegawai Nama',
			'jabatan_id' => 'Jabatan',
			'jabatan_nama' => 'Jabatan Nama',
			'pangkat_id' => 'Pangkat',
			'pangkat_nama' => 'Pangkat Nama',
			'keanggotaan_id' => 'Keanggotaan',
			'nokeanggotaan' => 'Nokeanggotaan',
			'pinjaman_id' => 'Pinjaman',
			'tglpinjaman' => 'Tglpinjaman',
			'no_pinjaman' => 'No Pinjaman',
			'jenispinjaman' => 'Jenispinjaman',
			'jangka_waktu_bln' => 'Jangka Waktu Bln',
			'persen_jasa_pinjaman' => 'Persen Jasa Pinjaman',
			'jatuh_tempo' => 'Jatuh Tempo',
			'jml_kali_angsur' => 'Jml Kali Angsur',
			'jml_pinjaman' => 'Jml Pinjaman',
			'jasa_pinjaman' => 'Jasa Pinjaman',
			'jmlangsuran_id' => 'Jmlangsuran',
			'tglangsuran' => 'Tglangsuran',
			'tgljatuhtempoangs' => 'Tgljatuhtempoangs',
			'status_bayar' => 'Status Bayar',
			'status_pengajuan' => 'Status Pengajuan',
			'angsuran_ke' => 'Angsuran Ke',
			'jmlpokok_angsuran' => 'Jmlpokok Angsuran',
			'jmljasa_angsuran' => 'Jmljasa Angsuran',
			'jmldenda_angsuran' => 'Jmldenda Angsuran',
			'pokok_angsuran' => 'Pokok Angsuran',
			'jasa_angsuran' => 'Jasa Angsuran',
			'denda_angsuran' => 'Denda Angsuran',
			'bayar_angsuran' => 'Bayar Angsuran',
			'sisa_angsuran' => 'Sisa Angsuran',
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
		$criteria->compare('statusperkawinan',$this->statusperkawinan,true);
		$criteria->compare('alamat_pegawai',$this->alamat_pegawai,true);
		$criteria->compare('kelurahan_id',$this->kelurahan_id);
		$criteria->compare('kelurahan_nama',$this->kelurahan_nama,true);
		$criteria->compare('kategoripegawai',$this->kategoripegawai,true);
		$criteria->compare('golonganpegawai_id',$this->golonganpegawai_id);
		$criteria->compare('golonganpegawai_nama',$this->golonganpegawai_nama,true);
		$criteria->compare('jabatan_id',$this->jabatan_id);
		$criteria->compare('jabatan_nama',$this->jabatan_nama,true);
		$criteria->compare('pangkat_id',$this->pangkat_id);
		$criteria->compare('pangkat_nama',$this->pangkat_nama,true);
		$criteria->compare('keanggotaan_id',$this->keanggotaan_id);
		$criteria->compare('nokeanggotaan',$this->nokeanggotaan,true);
		$criteria->compare('pinjaman_id',$this->pinjaman_id);
		$criteria->compare('tglpinjaman',$this->tglpinjaman,true);
		$criteria->compare('no_pinjaman',$this->no_pinjaman,true);
		$criteria->compare('jenispinjaman',$this->jenispinjaman,true);
		$criteria->compare('jangka_waktu_bln',$this->jangka_waktu_bln);
		$criteria->compare('persen_jasa_pinjaman',$this->persen_jasa_pinjaman);
		$criteria->compare('jatuh_tempo',$this->jatuh_tempo,true);
		$criteria->compare('jml_kali_angsur',$this->jml_kali_angsur);
		$criteria->compare('jml_pinjaman',$this->jml_pinjaman);
		$criteria->compare('jasa_pinjaman',$this->jasa_pinjaman);
		$criteria->compare('jmlangsuran_id',$this->jmlangsuran_id);
		$criteria->compare('tglangsuran',$this->tglangsuran,true);
		$criteria->compare('tgljatuhtempoangs',$this->tgljatuhtempoangs,true);
		$criteria->compare('status_bayar',$this->status_bayar);
		$criteria->compare('status_pengajuan',$this->status_pengajuan);
		$criteria->compare('angsuran_ke',$this->angsuran_ke);
		$criteria->compare('jmlpokok_angsuran',$this->jmlpokok_angsuran);
		$criteria->compare('jmljasa_angsuran',$this->jmljasa_angsuran);
		$criteria->compare('jmldenda_angsuran',$this->jmldenda_angsuran);
		$criteria->compare('pokok_angsuran',$this->pokok_angsuran);
		$criteria->compare('jasa_angsuran',$this->jasa_angsuran);
		$criteria->compare('denda_angsuran',$this->denda_angsuran);
		$criteria->compare('bayar_angsuran',$this->bayar_angsuran);
		$criteria->compare('sisa_angsuran',$this->sisa_angsuran);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function getTotPA($provider) {
		$prov = clone $provider;
		$prov->pagination = false;
		$total = 0;
		foreach ($prov->data as $item) {
			$total += $item->jmlpokok_angsuran;
		}
		return $total;
	}

	public function getTotJA($provider) {
		$prov = clone $provider;
		$prov->pagination = false;
		$total = 0;
		foreach ($prov->data as $item) {
			$total += $item->jmljasa_angsuran;
		}
		return $total;
	}

	public function getTotDA($provider) {
		$prov = clone $provider;
		$prov->pagination = false;
		$total = 0;
		foreach ($prov->data as $item) {
			$total += $item->jmldenda_angsuran;
		}
		return $total;
	}

	public function getTotBayar($provider) {
		$prov = clone $provider;
		$prov->pagination = false;
		$total = 0;
		foreach ($prov->data as $item) {
			$total += $item->bayar_angsuran;
		}
		return $total;
	}

	public function getTotSisa($provider) {
		$prov = clone $provider;
		$prov->pagination = false;
		$total = 0;
		foreach ($prov->data as $item) {
			$total += $item->sisa_angsuran;
		}
		return $total;
	}
        
        public function getNamaLengkap()
        {
            return $this->gelardepan.' '.$this->nama_pegawai.' '.$this->gelarbelakang_nama;
        }
}