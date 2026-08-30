<?php

/**
 * This is the model class for table "persiapanpengadaan_t".
 * @author  Yusuf Putra Anugrah <yusufputra@.com>
 * @package application.models
 * The followings are the available columns in table 'persiapanpengadaan_t':
 * @property integer $persiapanpengadaan_id
 * @property string $persiapanpengadaan_nomor
 * @property string $persiapanpengadaan_tanggal
 * @property integer $rencanaumumpengadaan_id
 * @property integer $pegawaipembuat_id
 * @property integer $unitkerja_id
 * @property integer $instalasi_id
 * @property integer $periodeanggaran_id
 * @property integer $subprogram_id
 * @property integer $metodepengadaan_id
 * @property string $metodepengadaan_nama
 * @property double $total_harga
 * @property double $total_pajak
 * @property double $total_hargaseluruhnya
 * @property double $persiapanpengadaan_pagu
 * @property string $pemanfaatanbarang_tglawal
 * @property string $pemanfaatanbarang_tglakhir
 * @property string $pemilihanpenyedia_tglawal
 * @property string $pemilihanpenyedia_tglakhir
 * @property string $pelaksanaankontrak_tglawal
 * @property string $pelaksanaankontrak_tglakhir
 * @property string $swakelola_tipe
 * @property string $persiapanpengadaan_status
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property PersiapanpengadaandetT[] $persiapanpengadaandetTs
 * @property InstalasiM $instalasi
 * @property PegawaiM $pegawaipembuat
 * @property PeriodeanggaranK $periodeanggaran
 * @property SubprogramkerjaM $subprogram
 * @property UnitkerjaM $unitkerja
 * @property MetodepengadaanM $metodepengadaan
 * @property RencanaumumpengadaanT $rencanaumumpengadaan
 * @package      application.models 
 * @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @author      Elham Budianto <elhambudianto@.com>
 * @version     2.0.0
 * @link      <http://piindonesia.co.id>
 * @link      <http://172.9.1.15/simpp/docs/>
 * 
 */
class PersiapanpengadaanT extends CActiveRecord
{
        public $pegawaipembuat_nama, $namaunitkerja, $rencanaumumpengadaan_nomor, $rencanaumumpengadaan_nomortemp; 
        public $nama_pekerjaan, $programkerja_nama, $subprogramkerja_nama, $jenispengadaan_nama, $rencanaumumpengadaan_kategori;
        public $programkerja_id, $subprogramkerja_id,$instalasi_nama;
        public $subkegiatanprogram_nama,$kode_sirup;
        
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PersiapanpengadaanT the static model class
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
		return 'persiapanpengadaan_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('persiapanpengadaan_nomor, persiapanpengadaan_tanggal, persiapanpengadaan_pagu, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('rencanaumumpengadaan_id, pegawaipembuat_id, unitkerja_id, instalasi_id, periodeanggaran_id, subprogram_id, metodepengadaan_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('total_harga, total_pajak, total_hargaseluruhnya, persiapanpengadaan_pagu', 'numerical'),
			array('persiapanpengadaan_nomor', 'length', 'max'=>20),
                        array('kode_sirup', 'length', 'max'=>50),
			array('metodepengadaan_nama, swakelola_tipe, persiapanpengadaan_status', 'length', 'max'=>100),
			array('kode_sirup,subkegiatanprogram_id, dpa_pagu, isumumkanpengadaan, diumumkan_tanggal, subkegiatanprogram_id, pajak_persen, pemanfaatanbarang_tglawal, pemanfaatanbarang_tglakhir, pemilihanpenyedia_tglawal, pemilihanpenyedia_tglakhir, pelaksanaankontrak_tglawal, pelaksanaankontrak_tglakhir, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('kode_sirup,persiapanpengadaan_id, persiapanpengadaan_nomor, persiapanpengadaan_tanggal, rencanaumumpengadaan_id, pegawaipembuat_id, unitkerja_id, instalasi_id, periodeanggaran_id, subprogram_id, metodepengadaan_id, metodepengadaan_nama, total_harga, total_pajak, total_hargaseluruhnya, persiapanpengadaan_pagu, pemanfaatanbarang_tglawal, pemanfaatanbarang_tglakhir, pemilihanpenyedia_tglawal, pemilihanpenyedia_tglakhir, pelaksanaankontrak_tglawal, pelaksanaankontrak_tglakhir, swakelola_tipe, persiapanpengadaan_status, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'persiapanpengadaandetTs' => array(self::HAS_MANY, 'PersiapanpengadaandetT', 'persiapanpengadaan_id'),
			'instalasi' => array(self::BELONGS_TO, 'InstalasiM', 'instalasi_id'),
			'pegawaipembuat' => array(self::BELONGS_TO, 'PegawaiM', 'pegawaipembuat_id'),
			'periodeanggaran' => array(self::BELONGS_TO, 'PeriodeanggaranK', 'periodeanggaran_id'),
			'subprogram' => array(self::BELONGS_TO, 'SubprogramkerjaM', 'subprogram_id'),
			'unitkerja' => array(self::BELONGS_TO, 'UnitkerjaM', 'unitkerja_id'),
			'metodepengadaan' => array(self::BELONGS_TO, 'MetodepengadaanM', 'metodepengadaan_id'),
			'rencanaumumpengadaan' => array(self::BELONGS_TO, 'RencanaumumpengadaanT', 'rencanaumumpengadaan_id'),
                        'subkegiatanprogram' => array(self::BELONGS_TO, 'SubkegiatanprogramM', 'subkegiatanprogram_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'persiapanpengadaan_id' => 'Persiapanpengadaan',
			'persiapanpengadaan_nomor' => 'Persiapanpengadaan Nomor',
			'persiapanpengadaan_tanggal' => 'Persiapanpengadaan Tanggal',
			'rencanaumumpengadaan_id' => 'Rencanaumumpengadaan',
			'pegawaipembuat_id' => 'Pegawaipembuat',
			'unitkerja_id' => 'Unitkerja',
			'instalasi_id' => 'Instalasi',
			'periodeanggaran_id' => 'Periodeanggaran',
			'subprogram_id' => 'Subprogram',
			'metodepengadaan_id' => 'Metodepengadaan',
			'metodepengadaan_nama' => 'Metodepengadaan Nama',
			'total_harga' => 'Total Harga',
			'total_pajak' => 'Total Pajak',
			'total_hargaseluruhnya' => 'Total Hargaseluruhnya',
			'persiapanpengadaan_pagu' => 'Persiapanpengadaan Pagu',
			'pemanfaatanbarang_tglawal' => 'Pemanfaatanbarang Tglawal',
			'pemanfaatanbarang_tglakhir' => 'Pemanfaatanbarang Tglakhir',
			'pemilihanpenyedia_tglawal' => 'Pemilihanpenyedia Tglawal',
			'pemilihanpenyedia_tglakhir' => 'Pemilihanpenyedia Tglakhir',
			'pelaksanaankontrak_tglawal' => 'Tanggal Awal Pelaksanaan',
			'pelaksanaankontrak_tglakhir' => 'Tanggal Akhir Pelaksanaan',
			'swakelola_tipe' => 'Swakelola Tipe',
			'persiapanpengadaan_status' => 'Persiapanpengadaan Status',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
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

		$criteria->compare('persiapanpengadaan_id',$this->persiapanpengadaan_id);
		$criteria->compare('persiapanpengadaan_nomor',$this->persiapanpengadaan_nomor,true);
		$criteria->compare('persiapanpengadaan_tanggal',$this->persiapanpengadaan_tanggal,true);
		$criteria->compare('rencanaumumpengadaan_id',$this->rencanaumumpengadaan_id);
		$criteria->compare('pegawaipembuat_id',$this->pegawaipembuat_id);
		$criteria->compare('unitkerja_id',$this->unitkerja_id);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('periodeanggaran_id',$this->periodeanggaran_id);
		$criteria->compare('subprogram_id',$this->subprogram_id);
		$criteria->compare('metodepengadaan_id',$this->metodepengadaan_id);
		$criteria->compare('metodepengadaan_nama',$this->metodepengadaan_nama,true);
		$criteria->compare('total_harga',$this->total_harga);
		$criteria->compare('total_pajak',$this->total_pajak);
		$criteria->compare('total_hargaseluruhnya',$this->total_hargaseluruhnya);
		$criteria->compare('persiapanpengadaan_pagu',$this->persiapanpengadaan_pagu);
		$criteria->compare('pemanfaatanbarang_tglawal',$this->pemanfaatanbarang_tglawal,true);
		$criteria->compare('pemanfaatanbarang_tglakhir',$this->pemanfaatanbarang_tglakhir,true);
		$criteria->compare('pemilihanpenyedia_tglawal',$this->pemilihanpenyedia_tglawal,true);
		$criteria->compare('pemilihanpenyedia_tglakhir',$this->pemilihanpenyedia_tglakhir,true);
		$criteria->compare('pelaksanaankontrak_tglawal',$this->pelaksanaankontrak_tglawal,true);
		$criteria->compare('pelaksanaankontrak_tglakhir',$this->pelaksanaankontrak_tglakhir,true);
		$criteria->compare('swakelola_tipe',$this->swakelola_tipe,true);
		$criteria->compare('persiapanpengadaan_status',$this->persiapanpengadaan_status,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}