<?php

/**
 * This is the model class for table "laporansimpanan_v".
 *
 * The followings are the available columns in table 'laporansimpanan_v':
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
 * @property integer $pangkat_id
 * @property string $pangkat_nama
 * @property integer $jabatan_id
 * @property string $jabatan_nama
 * @property integer $keanggotaan_id
 * @property string $tglkeanggotaaan
 * @property string $nokeanggotaan
 * @property string $tglsimpanan
 * @property double $total_simpananpokok
 * @property double $total_simpananwajib
 * @property double $total_simpanansukarela
 * @property double $total_simpanandeposito
 */
class LaporansimpananV extends CActiveRecord
{
        public $tgl_awal, $bln_awal, $thn_awal;
        public $tgl_akhir, $bln_akhir, $thn_akhir;
        public $jns_periode;
        
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporansimpananV the static model class
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
		return 'laporansimpanan_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pegawai_id, gelarbelakang_id, golonganpegawai_id, pangkat_id, jabatan_id, keanggotaan_id', 'numerical', 'integerOnly'=>true),
			array('total_simpananpokok, total_simpananwajib, total_simpanansukarela, total_simpanandeposito', 'numerical'),
			array('nomorindukpegawai, tempatlahir_pegawai', 'length', 'max'=>30),
			array('gelardepan', 'length', 'max'=>10),
			array('nama_pegawai, golonganpegawai_nama, pangkat_nama, nokeanggotaan', 'length', 'max'=>50),
			array('gelarbelakang_nama', 'length', 'max'=>15),
			array('jeniskelamin', 'length', 'max'=>20),
			array('kategoripegawai', 'length', 'max'=>128),
			array('jabatan_nama', 'length', 'max'=>100),
			array('tgl_lahirpegawai, alamat_pegawai, tglkeanggotaaan, tglsimpanan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pegawai_id, nomorindukpegawai, gelardepan, nama_pegawai, gelarbelakang_id, gelarbelakang_nama, tempatlahir_pegawai, tgl_lahirpegawai, jeniskelamin, alamat_pegawai, kategoripegawai, golonganpegawai_id, golonganpegawai_nama, pangkat_id, pangkat_nama, jabatan_id, jabatan_nama, keanggotaan_id, tglkeanggotaaan, nokeanggotaan, tglsimpanan, total_simpananpokok, total_simpananwajib, total_simpanansukarela, total_simpanandeposito', 'safe', 'on'=>'search'),
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
			'alamat_pegawai' => 'Alamat Pegawai',
			'kategoripegawai' => 'Kategoripegawai',
			'golonganpegawai_id' => 'Golonganpegawai',
			'golonganpegawai_nama' => 'Golonganpegawai Nama',
			'pangkat_id' => 'Pangkat',
			'pangkat_nama' => 'Pangkat Nama',
			'jabatan_id' => 'Jabatan',
			'jabatan_nama' => 'Jabatan Nama',
			'keanggotaan_id' => 'Keanggotaan',
			'tglkeanggotaaan' => 'Tglkeanggotaaan',
			'nokeanggotaan' => 'Nokeanggotaan',
			'tglsimpanan' => 'Tglsimpanan',
			'total_simpananpokok' => 'Total Simpananpokok',
			'total_simpananwajib' => 'Total Simpananwajib',
			'total_simpanansukarela' => 'Total Simpanansukarela',
			'total_simpanandeposito' => 'Total Simpanandeposito',
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
		$criteria->compare('pangkat_id',$this->pangkat_id);
		$criteria->compare('pangkat_nama',$this->pangkat_nama,true);
		$criteria->compare('jabatan_id',$this->jabatan_id);
		$criteria->compare('jabatan_nama',$this->jabatan_nama,true);
		$criteria->compare('keanggotaan_id',$this->keanggotaan_id);
		$criteria->compare('tglkeanggotaaan',$this->tglkeanggotaaan,true);
		$criteria->compare('nokeanggotaan',$this->nokeanggotaan,true);
		$criteria->compare('tglsimpanan',$this->tglsimpanan,true);
		$criteria->compare('total_simpananpokok',$this->total_simpananpokok);
		$criteria->compare('total_simpananwajib',$this->total_simpananwajib);
		$criteria->compare('total_simpanansukarela',$this->total_simpanansukarela);
		$criteria->compare('total_simpanandeposito',$this->total_simpanandeposito);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function getTotal($data, $attr) {
		$total = 0;
		foreach ($data as $item) {
			$total += $item[$attr];
		}
		return $total;
	}

	public function getTotalJumSimpPok($provider) {
		$prov = clone $provider;
		$prov->pagination = false;
		$total = 0;
		foreach ($prov->data as $item) {
			$total += $item->total_simpananpokok;
		}
		return $total;
	}

	public function getTotalJumSimpWjb($provider) {
		$prov = clone $provider;
		$prov->pagination = false;
		$total = 0;
		foreach ($prov->data as $item) {
			$total += $item->total_simpananwajib;
		}
		return $total;
	}

	public function getTotalJumSimpSkrl($provider) {
		$prov = clone $provider;
		$prov->pagination = false;
		$total = 0;
		foreach ($prov->data as $item) {
			$total += $item->total_simpanansukarela;
		}
		return $total;
	}

	public function getTotalJumSimpDep($provider) {
		$prov = clone $provider;
		$prov->pagination = false;
		$total = 0;
		foreach ($prov->data as $item) {
			$total += $item->total_simpanandeposito;
		}
		return $total;
	}

	public function getPersenJasaSR() {
		$jasa = SimpananT::model()->findByAttributes(array('keanggotaan_id'=>$this->keanggotaan_id),array('condition'=>"nosimpanan ilike '%SS%'"));
		if (!empty($jasa)) return ($jasa->persenjasa_thn * $this->total_simpanansukarela)/100;
		else return '-';
	}

	public function getTotJasaSR($provider){
		$prov = clone $provider;
		$prov->pagination = false;
		$total = 0;
		foreach ($prov->data as $item) {
			$total += $item->PersenJasaSR;
		}
		return $total;
	}

	public function getPersenJasaDP() {
		$jasa = SimpananT::model()->findByAttributes(array('keanggotaan_id'=>$this->keanggotaan_id),array('condition'=>"nosimpanan ilike '%SD%'"));
		if (!empty($jasa)) return ($jasa->persenjasa_thn * $this->total_simpanandeposito)/100;
		else return '-';
	}

	public function getTotJasaDP($provider){
		$prov = clone $provider;
		$prov->pagination = false;
		$total = 0;
		foreach ($prov->data as $item) {
			$total += $item->PersenJasaDP;
		}
		return $total;
	}
        
        public function getNamaLengkap()
        {
            return $this->gelardepan.' '.$this->nama_pegawai.' '.$this->gelarbelakang_nama;
        }
}