<?php

/**
 * This is the model class for table "rl1datars_v".
 *
 * The followings are the available columns in table 'rl1datars_v':
 * @property integer $profilrs_id
 * @property string $tglregistrasi
 * @property string $nokode_rumahsakit
 * @property string $nama_rumahsakit
 * @property string $jenisrs_profilrs
 * @property string $namakepemilikanrs
 * @property string $kelas_rumahsakit
 * @property string $namadirektur_rumahsakit
 * @property string $statuskepemilikanrs
 * @property string $kabupaten_nama
 * @property string $kode_pos
 * @property string $no_telp_profilrs
 * @property string $no_faksimili
 * @property string $email
 * @property string $notelphumas
 * @property string $website
 * @property string $luastanah
 * @property string $luasbangunan
 * @property string $nomor_suratizin
 * @property string $tgl_suratizin
 * @property string $oleh_suratizin
 * @property string $sifat_suratizin
 * @property string $masaberlakutahun_suratizin
 * @property string $statusakreditasrs
 * @property string $pentahapanakreditasrs
 * @property string $statusrsswasta
 * @property string $akreditasirs
 * @property string $tglakreditasi
 */
class Rl1datarsV extends CActiveRecord
{
        public $tgl_awal, $tgl_akhir;
        public $bln_awal, $bln_akhir;
        public $thn_awal, $thn_akhir;
        public $jns_periode;        
                
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Rl1datarsV the static model class
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
		return 'rl1datars_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('profilrs_id', 'numerical', 'integerOnly'=>true),
			array('nokode_rumahsakit', 'length', 'max'=>10),
			array('nama_rumahsakit, jenisrs_profilrs, namakepemilikanrs, statuskepemilikanrs, notelphumas, luastanah, luasbangunan', 'length', 'max'=>100),
			array('kelas_rumahsakit', 'length', 'max'=>1),
			array('namadirektur_rumahsakit, kabupaten_nama, email, website, sifat_suratizin, statusakreditasrs, pentahapanakreditasrs, statusrsswasta', 'length', 'max'=>50),
			array('kode_pos, no_telp_profilrs, no_faksimili', 'length', 'max'=>15),
			array('nomor_suratizin', 'length', 'max'=>20),
			array('oleh_suratizin', 'length', 'max'=>30),
			array('masaberlakutahun_suratizin', 'length', 'max'=>4),
			array('akreditasirs', 'length', 'max'=>200),
			array('tglregistrasi, tgl_suratizin, tglakreditasi', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('profilrs_id, tglregistrasi, nokode_rumahsakit, nama_rumahsakit, jenisrs_profilrs, namakepemilikanrs, kelas_rumahsakit, namadirektur_rumahsakit, statuskepemilikanrs, kabupaten_nama, kode_pos, no_telp_profilrs, no_faksimili, email, notelphumas, website, luastanah, luasbangunan, nomor_suratizin, tgl_suratizin, oleh_suratizin, sifat_suratizin, masaberlakutahun_suratizin, statusakreditasrs, pentahapanakreditasrs, statusrsswasta, akreditasirs, tglakreditasi', 'safe', 'on'=>'search'),
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
			'profilrs_id' => 'Profilrs',
			'tglregistrasi' => 'Tglregistrasi',
			'nokode_rumahsakit' => 'Nokode Rumahsakit',
			'nama_rumahsakit' => 'Nama Rumahsakit',
			'jenisrs_profilrs' => 'Jenisrs Profilrs',
			'namakepemilikanrs' => 'Namakepemilikanrs',
			'kelas_rumahsakit' => 'Kelas Rumahsakit',
			'namadirektur_rumahsakit' => 'Namadirektur Rumahsakit',
			'statuskepemilikanrs' => 'Statuskepemilikanrs',
			'kabupaten_nama' => 'Kabupaten Nama',
			'kode_pos' => 'Kode Pos',
			'no_telp_profilrs' => 'No. Telp Profilrs',
			'no_faksimili' => 'No. Faksimili',
			'email' => 'Email',
			'notelphumas' => 'Notelphumas',
			'website' => 'Website',
			'luastanah' => 'Luastanah',
			'luasbangunan' => 'Luasbangunan',
			'nomor_suratizin' => 'Nomor Suratizin',
			'tgl_suratizin' => 'Tgl. Suratizin',
			'oleh_suratizin' => 'Oleh Suratizin',
			'sifat_suratizin' => 'Sifat Suratizin',
			'masaberlakutahun_suratizin' => 'Masaberlakutahun Suratizin',
			'statusakreditasrs' => 'Statusakreditasrs',
			'pentahapanakreditasrs' => 'Pentahapanakreditasrs',
			'statusrsswasta' => 'Statusrsswasta',
			'akreditasirs' => 'Akreditasirs',
			'tglakreditasi' => 'Tglakreditasi',
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

		$criteria->compare('profilrs_id',$this->profilrs_id);
		$criteria->compare('tglregistrasi',$this->tglregistrasi,true);
		$criteria->compare('nokode_rumahsakit',$this->nokode_rumahsakit,true);
		$criteria->compare('nama_rumahsakit',$this->nama_rumahsakit,true);
		$criteria->compare('jenisrs_profilrs',$this->jenisrs_profilrs,true);
		$criteria->compare('namakepemilikanrs',$this->namakepemilikanrs,true);
		$criteria->compare('kelas_rumahsakit',$this->kelas_rumahsakit,true);
		$criteria->compare('namadirektur_rumahsakit',$this->namadirektur_rumahsakit,true);
		$criteria->compare('statuskepemilikanrs',$this->statuskepemilikanrs,true);
		$criteria->compare('kabupaten_nama',$this->kabupaten_nama,true);
		$criteria->compare('kode_pos',$this->kode_pos,true);
		$criteria->compare('no_telp_profilrs',$this->no_telp_profilrs,true);
		$criteria->compare('no_faksimili',$this->no_faksimili,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('notelphumas',$this->notelphumas,true);
		$criteria->compare('website',$this->website,true);
		$criteria->compare('luastanah',$this->luastanah,true);
		$criteria->compare('luasbangunan',$this->luasbangunan,true);
		$criteria->compare('nomor_suratizin',$this->nomor_suratizin,true);
		$criteria->compare('tgl_suratizin',$this->tgl_suratizin,true);
		$criteria->compare('oleh_suratizin',$this->oleh_suratizin,true);
		$criteria->compare('sifat_suratizin',$this->sifat_suratizin,true);
		$criteria->compare('masaberlakutahun_suratizin',$this->masaberlakutahun_suratizin,true);
		$criteria->compare('statusakreditasrs',$this->statusakreditasrs,true);
		$criteria->compare('pentahapanakreditasrs',$this->pentahapanakreditasrs,true);
		$criteria->compare('statusrsswasta',$this->statusrsswasta,true);
		$criteria->compare('akreditasirs',$this->akreditasirs,true);
		$criteria->compare('tglakreditasi',$this->tglakreditasi,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}