<?php

/**
 * This is the model class for table "informasirencanaumumpengadaan_v".
 * @author Elham Budianto <elhambudianto@>
 * @package application.models
 * @category model
 * 
 * The followings are the available columns in table 'informasirencanaumumpengadaan_v':
 * @property integer $rencanaumumpengadaan_id
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 * @property string $rencanaumumpengadaan_nomor
 * @property string $rencanaumumpengadaan_tanggal
 * @property string $rencanaumumpengadaan_kategori
 * @property integer $periodeanggaran_id
 * @property string $tahunanggaran
 * @property string $anggaran_nama
 * @property string $rencanaumumpengadaan_tahun
 * @property integer $programkerja_id
 * @property string $programkerja_kode
 * @property string $programkerja_nama
 * @property integer $subprogramkerja_id
 * @property string $subprogramkerja_kode
 * @property string $subprogramkerja_nama
 * @property integer $kegiatanprogram_id
 * @property string $kegiatanprogram_kode
 * @property string $kegiatanprogram_nama
 * @property integer $subkegiatanprogram_id
 * @property string $subkegiatanprogram_kode
 * @property string $subkegiatanprogram_nama
 * @property string $nama_pekerjaan
 * @property string $volume_pekerjaan
 * @property string $uraian_pekerjaan
 * @property string $metode_pengadaan
 * @property string $daftarjenispengadaan
 * @property string $daftarsumberdana
 * @property boolean $isprodukdalamnegeri
 * @property boolean $isusahakecil
 * @property boolean $ispradpa
 * @property string $nomor_kppuas
 * @property string $nomorizin_tahunjamak
 * @property string $pemanfaatanbarang_tglawal
 * @property string $pemanfaatanbarang_tglakhir
 * @property string $pelaksanaankontrak_tglawal
 * @property string $pelaksanaankontrak_tglakhir
 * @property string $pemilihanpenyedia_tglawal
 * @property string $pemilihanpenyedia_tglakhir
 * @property string $swakelola_tipe
 * @property string $swakelola_penyelenggara
 * @property string $swakelola_satker
 * @property double $total_pagu
 * @property double $dpa_pagu
 * @property string $kode_rup
 * @property string $rencanaumumpengadaan_status
 * @property integer $pegawaippk_id
 * @property string $peg_ppk
 * @property integer $pegawaipa_id
 * @property string $peg_pa
 * @property integer $pegawaikpa_id
 * @property string $peg_kpa
 */
class InformasirencanaumumpengadaanV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasirencanaumumpengadaanV the static model class
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
		return 'informasirencanaumumpengadaan_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('rencanaumumpengadaan_id, instalasi_id, periodeanggaran_id, programkerja_id, subprogramkerja_id, kegiatanprogram_id, subkegiatanprogram_id, pegawaippk_id, pegawaipa_id, pegawaikpa_id', 'numerical', 'integerOnly'=>true),
			array('total_pagu, dpa_pagu', 'numerical'),
			array('instalasi_nama, nomor_kppuas, nomorizin_tahunjamak, kode_rup, peg_ppk, peg_pa, peg_kpa', 'length', 'max'=>50),
			array('rencanaumumpengadaan_nomor, rencanaumumpengadaan_kategori', 'length', 'max'=>20),
			array('tahunanggaran, rencanaumumpengadaan_tahun', 'length', 'max'=>4),
			array('anggaran_nama, volume_pekerjaan, metode_pengadaan, swakelola_tipe, rencanaumumpengadaan_status', 'length', 'max'=>100),
			array('programkerja_kode, subprogramkerja_kode, kegiatanprogram_kode, subkegiatanprogram_kode', 'length', 'max'=>5),
			array('programkerja_nama, subprogramkerja_nama, kegiatanprogram_nama, subkegiatanprogram_nama', 'length', 'max'=>500),
			array('nama_pekerjaan', 'length', 'max'=>300),
			array('uraian_pekerjaan', 'length', 'max'=>2000),
			array('swakelola_penyelenggara, swakelola_satker', 'length', 'max'=>200),
			array('rencanaumumpengadaan_tanggal, daftarjenispengadaan, daftarsumberdana, isprodukdalamnegeri, isusahakecil, ispradpa, pemanfaatanbarang_tglawal, pemanfaatanbarang_tglakhir, pelaksanaankontrak_tglawal, pelaksanaankontrak_tglakhir, pemilihanpenyedia_tglawal, pemilihanpenyedia_tglakhir', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('rencanaumumpengadaan_id, instalasi_id, instalasi_nama, rencanaumumpengadaan_nomor, rencanaumumpengadaan_tanggal, rencanaumumpengadaan_kategori, periodeanggaran_id, tahunanggaran, anggaran_nama, rencanaumumpengadaan_tahun, programkerja_id, programkerja_kode, programkerja_nama, subprogramkerja_id, subprogramkerja_kode, subprogramkerja_nama, kegiatanprogram_id, kegiatanprogram_kode, kegiatanprogram_nama, subkegiatanprogram_id, subkegiatanprogram_kode, subkegiatanprogram_nama, nama_pekerjaan, volume_pekerjaan, uraian_pekerjaan, metode_pengadaan, daftarjenispengadaan, daftarsumberdana, isprodukdalamnegeri, isusahakecil, ispradpa, nomor_kppuas, nomorizin_tahunjamak, pemanfaatanbarang_tglawal, pemanfaatanbarang_tglakhir, pelaksanaankontrak_tglawal, pelaksanaankontrak_tglakhir, pemilihanpenyedia_tglawal, pemilihanpenyedia_tglakhir, swakelola_tipe, swakelola_penyelenggara, swakelola_satker, total_pagu, dpa_pagu, kode_rup, rencanaumumpengadaan_status, pegawaippk_id, peg_ppk, pegawaipa_id, peg_pa, pegawaikpa_id, peg_kpa', 'safe', 'on'=>'search'),
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
			'rencanaumumpengadaan_id' => 'Rencanaumumpengadaan',
			'instalasi_id' => 'Instalasi',
			'instalasi_nama' => 'Instalasi Nama',
			'rencanaumumpengadaan_nomor' => 'Rencanaumumpengadaan Nomor',
			'rencanaumumpengadaan_tanggal' => 'Rencanaumumpengadaan Tanggal',
			'rencanaumumpengadaan_kategori' => 'Rencanaumumpengadaan Kategori',
			'periodeanggaran_id' => 'Periodeanggaran',
			'tahunanggaran' => 'Tahunanggaran',
			'anggaran_nama' => 'Anggaran Nama',
			'rencanaumumpengadaan_tahun' => 'Rencanaumumpengadaan Tahun',
			'programkerja_id' => 'Programkerja',
			'programkerja_kode' => 'Programkerja Kode',
			'programkerja_nama' => 'Programkerja Nama',
			'subprogramkerja_id' => 'Subprogramkerja',
			'subprogramkerja_kode' => 'Subprogramkerja Kode',
			'subprogramkerja_nama' => 'Subprogramkerja Nama',
			'kegiatanprogram_id' => 'Kegiatanprogram',
			'kegiatanprogram_kode' => 'Kegiatanprogram Kode',
			'kegiatanprogram_nama' => 'Kegiatanprogram Nama',
			'subkegiatanprogram_id' => 'Subkegiatanprogram',
			'subkegiatanprogram_kode' => 'Subkegiatanprogram Kode',
			'subkegiatanprogram_nama' => 'Subkegiatanprogram Nama',
			'nama_pekerjaan' => 'Nama Pekerjaan',
			'volume_pekerjaan' => 'Volume Pekerjaan',
			'uraian_pekerjaan' => 'Uraian Pekerjaan',
			'metode_pengadaan' => 'Metode Pengadaan',
			'daftarjenispengadaan' => 'Daftarjenispengadaan',
			'daftarsumberdana' => 'Daftarsumberdana',
			'isprodukdalamnegeri' => 'Isprodukdalamnegeri',
			'isusahakecil' => 'Isusahakecil',
			'ispradpa' => 'Ispradpa',
			'nomor_kppuas' => 'Nomor Kppuas',
			'nomorizin_tahunjamak' => 'Nomorizin Tahunjamak',
			'pemanfaatanbarang_tglawal' => 'Pemanfaatanbarang Tglawal',
			'pemanfaatanbarang_tglakhir' => 'Pemanfaatanbarang Tglakhir',
			'pelaksanaankontrak_tglawal' => 'Pelaksanaankontrak Tglawal',
			'pelaksanaankontrak_tglakhir' => 'Pelaksanaankontrak Tglakhir',
			'pemilihanpenyedia_tglawal' => 'Pemilihanpenyedia Tglawal',
			'pemilihanpenyedia_tglakhir' => 'Pemilihanpenyedia Tglakhir',
			'swakelola_tipe' => 'Swakelola Tipe',
			'swakelola_penyelenggara' => 'Swakelola Penyelenggara',
			'swakelola_satker' => 'Swakelola Satker',
			'total_pagu' => 'Total Pagu',
			'dpa_pagu' => 'Dpa Pagu',
			'kode_rup' => 'Kode Rup',
			'rencanaumumpengadaan_status' => 'Rencanaumumpengadaan Status',
			'pegawaippk_id' => 'Pegawaippk',
			'peg_ppk' => 'Peg Ppk',
			'pegawaipa_id' => 'Pegawaipa',
			'peg_pa' => 'Peg Pa',
			'pegawaikpa_id' => 'Pegawaikpa',
			'peg_kpa' => 'Peg Kpa',
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

		$criteria->compare('rencanaumumpengadaan_id',$this->rencanaumumpengadaan_id);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('instalasi_nama',$this->instalasi_nama,true);
		$criteria->compare('rencanaumumpengadaan_nomor',$this->rencanaumumpengadaan_nomor,true);
		$criteria->compare('rencanaumumpengadaan_tanggal',$this->rencanaumumpengadaan_tanggal,true);
		$criteria->compare('rencanaumumpengadaan_kategori',$this->rencanaumumpengadaan_kategori,true);
		$criteria->compare('periodeanggaran_id',$this->periodeanggaran_id);
		$criteria->compare('tahunanggaran',$this->tahunanggaran,true);
		$criteria->compare('anggaran_nama',$this->anggaran_nama,true);
		$criteria->compare('rencanaumumpengadaan_tahun',$this->rencanaumumpengadaan_tahun,true);
		$criteria->compare('programkerja_id',$this->programkerja_id);
		$criteria->compare('programkerja_kode',$this->programkerja_kode,true);
		$criteria->compare('programkerja_nama',$this->programkerja_nama,true);
		$criteria->compare('subprogramkerja_id',$this->subprogramkerja_id);
		$criteria->compare('subprogramkerja_kode',$this->subprogramkerja_kode,true);
		$criteria->compare('subprogramkerja_nama',$this->subprogramkerja_nama,true);
		$criteria->compare('kegiatanprogram_id',$this->kegiatanprogram_id);
		$criteria->compare('kegiatanprogram_kode',$this->kegiatanprogram_kode,true);
		$criteria->compare('kegiatanprogram_nama',$this->kegiatanprogram_nama,true);
		$criteria->compare('subkegiatanprogram_id',$this->subkegiatanprogram_id);
		$criteria->compare('subkegiatanprogram_kode',$this->subkegiatanprogram_kode,true);
		$criteria->compare('subkegiatanprogram_nama',$this->subkegiatanprogram_nama,true);
		$criteria->compare('nama_pekerjaan',$this->nama_pekerjaan,true);
		$criteria->compare('volume_pekerjaan',$this->volume_pekerjaan,true);
		$criteria->compare('uraian_pekerjaan',$this->uraian_pekerjaan,true);
		$criteria->compare('metode_pengadaan',$this->metode_pengadaan,true);
		$criteria->compare('daftarjenispengadaan',$this->daftarjenispengadaan,true);
		$criteria->compare('daftarsumberdana',$this->daftarsumberdana,true);
		$criteria->compare('isprodukdalamnegeri',$this->isprodukdalamnegeri);
		$criteria->compare('isusahakecil',$this->isusahakecil);
		$criteria->compare('ispradpa',$this->ispradpa);
		$criteria->compare('nomor_kppuas',$this->nomor_kppuas,true);
		$criteria->compare('nomorizin_tahunjamak',$this->nomorizin_tahunjamak,true);
		$criteria->compare('pemanfaatanbarang_tglawal',$this->pemanfaatanbarang_tglawal,true);
		$criteria->compare('pemanfaatanbarang_tglakhir',$this->pemanfaatanbarang_tglakhir,true);
		$criteria->compare('pelaksanaankontrak_tglawal',$this->pelaksanaankontrak_tglawal,true);
		$criteria->compare('pelaksanaankontrak_tglakhir',$this->pelaksanaankontrak_tglakhir,true);
		$criteria->compare('pemilihanpenyedia_tglawal',$this->pemilihanpenyedia_tglawal,true);
		$criteria->compare('pemilihanpenyedia_tglakhir',$this->pemilihanpenyedia_tglakhir,true);
		$criteria->compare('swakelola_tipe',$this->swakelola_tipe,true);
		$criteria->compare('swakelola_penyelenggara',$this->swakelola_penyelenggara,true);
		$criteria->compare('swakelola_satker',$this->swakelola_satker,true);
		$criteria->compare('total_pagu',$this->total_pagu);
		$criteria->compare('dpa_pagu',$this->dpa_pagu);
		$criteria->compare('kode_rup',$this->kode_rup,true);
		$criteria->compare('rencanaumumpengadaan_status',$this->rencanaumumpengadaan_status,true);
		$criteria->compare('pegawaippk_id',$this->pegawaippk_id);
		$criteria->compare('peg_ppk',$this->peg_ppk,true);
		$criteria->compare('pegawaipa_id',$this->pegawaipa_id);
		$criteria->compare('peg_pa',$this->peg_pa,true);
		$criteria->compare('pegawaikpa_id',$this->pegawaikpa_id);
		$criteria->compare('peg_kpa',$this->peg_kpa,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}