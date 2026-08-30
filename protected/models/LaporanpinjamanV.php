<?php

/**
 * This is the model class for table "laporanpinjaman_v".
 *
 * The followings are the available columns in table 'laporanpinjaman_v':
 * @property integer $pegawai_id
 * @property string $nomorindukpegawai
 * @property string $gelardepan
 * @property string $nama_pegawai
 * @property integer $gelarbelakang_id
 * @property string $gelarbelakang_nama
 * @property string $tempatlahir_pegawai
 * @property string $tgl_lahirpegawai
 * @property string $jeniskelamin
 * @property string $agama
 * @property string $statusperkawinan
 * @property string $alamat_pegawai
 * @property integer $kelurahan_id
 * @property string $kelurahan_nama
 * @property string $kode_pos
 * @property string $kategoripegawai
 * @property integer $golonganpegawai_id
 * @property string $golonganpegawai_nama
 * @property integer $pangkat_id
 * @property string $pangkat_nama
 * @property integer $jabatan_id
 * @property string $jabatan_nama
 * @property integer $keanggotaan_id
 * @property string $nokeanggotaan
 * @property integer $pinjaman_id
 * @property string $jenispinjaman
 * @property string $no_pinjaman
 * @property string $tglpinjaman
 * @property string $jatuh_tempo
 * @property integer $jangka_waktu_bln
 * @property integer $jml_kali_angsur
 * @property double $persen_jasa_pinjaman
 * @property string $untuk_keperluan
 * @property string $jaminan_berupa
 * @property double $jml_pinjaman
 * @property double $jasapinjaman
 */
class LaporanpinjamanV extends CActiveRecord
{
        public $tgl_awal, $bln_awal, $thn_awal;
        public $tgl_akhir, $bln_akhir, $thn_akhir;
        public $jns_periode;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporanpinjamanV the static model class
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
		return 'laporanpinjaman_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pegawai_id, gelarbelakang_id, kelurahan_id, golonganpegawai_id, pangkat_id, jabatan_id, keanggotaan_id, pinjaman_id, jangka_waktu_bln, jml_kali_angsur', 'numerical', 'integerOnly'=>true),
			array('persen_jasa_pinjaman, jml_pinjaman, jasapinjaman', 'numerical'),
			array('nomorindukpegawai, tempatlahir_pegawai', 'length', 'max'=>30),
			array('gelardepan', 'length', 'max'=>10),
			array('nama_pegawai, kelurahan_nama, golonganpegawai_nama, pangkat_nama, nokeanggotaan, jenispinjaman, no_pinjaman', 'length', 'max'=>50),
			array('gelarbelakang_nama, kode_pos', 'length', 'max'=>15),
			array('jeniskelamin, agama, statusperkawinan', 'length', 'max'=>20),
			array('kategoripegawai', 'length', 'max'=>128),
			array('jabatan_nama, jaminan_berupa', 'length', 'max'=>100),
			array('tgl_lahirpegawai, alamat_pegawai, tglpinjaman, jatuh_tempo, untuk_keperluan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pegawai_id, nomorindukpegawai, gelardepan, nama_pegawai, gelarbelakang_id, gelarbelakang_nama, tempatlahir_pegawai, tgl_lahirpegawai, jeniskelamin, agama, statusperkawinan, alamat_pegawai, kelurahan_id, kelurahan_nama, kode_pos, kategoripegawai, golonganpegawai_id, golonganpegawai_nama, pangkat_id, pangkat_nama, jabatan_id, jabatan_nama, keanggotaan_id, nokeanggotaan, pinjaman_id, jenispinjaman, no_pinjaman, tglpinjaman, jatuh_tempo, jangka_waktu_bln, jml_kali_angsur, persen_jasa_pinjaman, untuk_keperluan, jaminan_berupa, jml_pinjaman, jasapinjaman', 'safe', 'on'=>'search'),
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
			'agama' => 'Agama',
			'statusperkawinan' => 'Statusperkawinan',
			'alamat_pegawai' => 'Alamat Pegawai',
			'kelurahan_id' => 'Kelurahan',
			'kelurahan_nama' => 'Kelurahan Nama',
			'kode_pos' => 'Kode Pos',
			'kategoripegawai' => 'Kategoripegawai',
			'golonganpegawai_id' => 'Golonganpegawai',
			'golonganpegawai_nama' => 'Golonganpegawai Nama',
			'pangkat_id' => 'Pangkat',
			'pangkat_nama' => 'Pangkat Nama',
			'jabatan_id' => 'Jabatan',
			'jabatan_nama' => 'Jabatan Nama',
			'keanggotaan_id' => 'Keanggotaan',
			'nokeanggotaan' => 'Nokeanggotaan',
			'pinjaman_id' => 'Pinjaman',
			'jenispinjaman' => 'Jenispinjaman',
			'no_pinjaman' => 'No Pinjaman',
			'tglpinjaman' => 'Tglpinjaman',
			'jatuh_tempo' => 'Jatuh Tempo',
			'jangka_waktu_bln' => 'Jangka Waktu Bln',
			'jml_kali_angsur' => 'Jml Kali Angsur',
			'persen_jasa_pinjaman' => 'Persen Jasa Pinjaman',
			'untuk_keperluan' => 'Untuk Keperluan',
			'jaminan_berupa' => 'Jaminan Berupa',
			'jml_pinjaman' => 'Jml Pinjaman',
			'jasapinjaman' => 'Jasapinjaman',
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
		$criteria->compare('agama',$this->agama,true);
		$criteria->compare('statusperkawinan',$this->statusperkawinan,true);
		$criteria->compare('alamat_pegawai',$this->alamat_pegawai,true);
		$criteria->compare('kelurahan_id',$this->kelurahan_id);
		$criteria->compare('kelurahan_nama',$this->kelurahan_nama,true);
		$criteria->compare('kode_pos',$this->kode_pos,true);
		$criteria->compare('kategoripegawai',$this->kategoripegawai,true);
		$criteria->compare('golonganpegawai_id',$this->golonganpegawai_id);
		$criteria->compare('golonganpegawai_nama',$this->golonganpegawai_nama,true);
		$criteria->compare('pangkat_id',$this->pangkat_id);
		$criteria->compare('pangkat_nama',$this->pangkat_nama,true);
		$criteria->compare('jabatan_id',$this->jabatan_id);
		$criteria->compare('jabatan_nama',$this->jabatan_nama,true);
		$criteria->compare('keanggotaan_id',$this->keanggotaan_id);
		$criteria->compare('nokeanggotaan',$this->nokeanggotaan,true);
		$criteria->compare('pinjaman_id',$this->pinjaman_id);
		$criteria->compare('jenispinjaman',$this->jenispinjaman,true);
		$criteria->compare('no_pinjaman',$this->no_pinjaman,true);
		$criteria->compare('tglpinjaman',$this->tglpinjaman,true);
		$criteria->compare('jatuh_tempo',$this->jatuh_tempo,true);
		$criteria->compare('jangka_waktu_bln',$this->jangka_waktu_bln);
		$criteria->compare('jml_kali_angsur',$this->jml_kali_angsur);
		$criteria->compare('persen_jasa_pinjaman',$this->persen_jasa_pinjaman);
		$criteria->compare('untuk_keperluan',$this->untuk_keperluan,true);
		$criteria->compare('jaminan_berupa',$this->jaminan_berupa,true);
		$criteria->compare('jml_pinjaman',$this->jml_pinjaman);
		$criteria->compare('jasapinjaman',$this->jasapinjaman);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function getTotalPinjaman($provider) {
		$prov = clone $provider;
		$prov->pagination = false;
		$total = 0;
		foreach ($prov->data as $item) {
			$total += $item->jml_pinjaman;
		}
		return $total;
	}

	public function getTotalJasa($provider) {
		$prov = clone $provider;
		$prov->pagination = false;
		$total = 0;
		foreach ($prov->data as $item) {
			$total += $item->jasapinjaman;
		}
		return $total;
	}
}