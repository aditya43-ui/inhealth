<?php

/**
 * This is the model class for table "laporanrencanadiklateksternal_v".
 *
 * The followings are the available columns in table 'laporanrencanadiklateksternal_v':
 * @property integer $rencanadiklat_id
 * @property string $norencanadiklat
 * @property string $tglrencanadiklat
 * @property string $namadiklat
 * @property string $rencanadiklat_periode
 * @property string $rencanadiklat_sampaidgn
 * @property string $jam_mulai
 * @property string $jam_akhir
 * @property string $tempat_diklat
 * @property string $alamat_diklat
 * @property double $total_jam
 * @property double $total_menit
 * @property string $keterangan_diklat
 * @property string $status_rencana
 * @property integer $pegawai_id
 * @property string $gelardepan
 * @property string $nama_pegawai
 * @property integer $gelarbelakang_id
 * @property string $gelarbelakang_nama
 * @property integer $jabatan_id
 * @property string $jabatan_nama
 * @property double $biaya_pelatihan
 * @property double $biaya_transportasi
 * @property double $biaya_penginapan
 * @property double $biaya_perjalanandinas
 * @property double $biaya_lainlain
 * @property double $total_biaya
 */
class LaporanrencanadiklateksternalV extends CActiveRecord
{
	public $jenisdiklat_id;
	public $tgl_awal;
	public $tgl_akhir;
	public $jns_periode;
	public $bln_awal;
	public $bln_akhir;
	public $thn_awal;
	public $thn_akhir;
	
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporanrencanadiklateksternalV the static model class
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
		return 'laporanrencanadiklateksternal_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('rencanadiklat_id, pegawai_id, gelarbelakang_id, jabatan_id', 'numerical', 'integerOnly'=>true),
			array('total_jam, total_menit, biaya_pelatihan, biaya_transportasi, biaya_penginapan, biaya_perjalanandinas, biaya_lainlain, total_biaya', 'numerical'),
			array('norencanadiklat, nama_pegawai', 'length', 'max'=>50),
			array('namadiklat, tempat_diklat, status_rencana, jabatan_nama', 'length', 'max'=>100),
			array('alamat_diklat, keterangan_diklat', 'length', 'max'=>500),
			array('gelardepan', 'length', 'max'=>10),
			array('gelarbelakang_nama', 'length', 'max'=>15),
			array('tglrencanadiklat, rencanadiklat_periode, rencanadiklat_sampaidgn, jam_mulai, jam_akhir', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('rencanadiklat_id, norencanadiklat, tglrencanadiklat, namadiklat, rencanadiklat_periode, rencanadiklat_sampaidgn, jam_mulai, jam_akhir, tempat_diklat, alamat_diklat, total_jam, total_menit, keterangan_diklat, status_rencana, pegawai_id, gelardepan, nama_pegawai, gelarbelakang_id, gelarbelakang_nama, jabatan_id, jabatan_nama, biaya_pelatihan, biaya_transportasi, biaya_penginapan, biaya_perjalanandinas, biaya_lainlain, total_biaya', 'safe', 'on'=>'search'),
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
			'rencanadiklat_id' => 'Rencanadiklat',
			'norencanadiklat' => 'Norencanadiklat',
			'tglrencanadiklat' => 'Tglrencanadiklat',
			'namadiklat' => 'Namadiklat',
			'rencanadiklat_periode' => 'Rencanadiklat Periode',
			'rencanadiklat_sampaidgn' => 'Rencanadiklat Sampaidgn',
			'jam_mulai' => 'Jam Mulai',
			'jam_akhir' => 'Jam Akhir',
			'tempat_diklat' => 'Tempat Diklat',
			'alamat_diklat' => 'Alamat Diklat',
			'total_jam' => 'Total Jam',
			'total_menit' => 'Total Menit',
			'keterangan_diklat' => 'Keterangan Diklat',
			'status_rencana' => 'Status Rencana',
			'pegawai_id' => 'Pegawai',
			'gelardepan' => 'Gelardepan',
			'nama_pegawai' => 'Nama Pegawai',
			'gelarbelakang_id' => 'Gelarbelakang',
			'gelarbelakang_nama' => 'Gelarbelakang Nama',
			'jabatan_id' => 'Jabatan',
			'jabatan_nama' => 'Jabatan Nama',
			'biaya_pelatihan' => 'Biaya Pelatihan',
			'biaya_transportasi' => 'Biaya Transportasi',
			'biaya_penginapan' => 'Biaya Penginapan',
			'biaya_perjalanandinas' => 'Biaya Perjalanandinas',
			'biaya_lainlain' => 'Biaya Lainlain',
			'total_biaya' => 'Total Biaya',
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

		$criteria->compare('rencanadiklat_id',$this->rencanadiklat_id);
		$criteria->compare('norencanadiklat',$this->norencanadiklat,true);
		$criteria->compare('tglrencanadiklat',$this->tglrencanadiklat,true);
		$criteria->compare('namadiklat',$this->namadiklat,true);
		$criteria->compare('rencanadiklat_periode',$this->rencanadiklat_periode,true);
		$criteria->compare('rencanadiklat_sampaidgn',$this->rencanadiklat_sampaidgn,true);
		$criteria->compare('jam_mulai',$this->jam_mulai,true);
		$criteria->compare('jam_akhir',$this->jam_akhir,true);
		$criteria->compare('tempat_diklat',$this->tempat_diklat,true);
		$criteria->compare('alamat_diklat',$this->alamat_diklat,true);
		$criteria->compare('total_jam',$this->total_jam);
		$criteria->compare('total_menit',$this->total_menit);
		$criteria->compare('keterangan_diklat',$this->keterangan_diklat,true);
		$criteria->compare('status_rencana',$this->status_rencana,true);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('gelardepan',$this->gelardepan,true);
		$criteria->compare('nama_pegawai',$this->nama_pegawai,true);
		$criteria->compare('gelarbelakang_id',$this->gelarbelakang_id);
		$criteria->compare('gelarbelakang_nama',$this->gelarbelakang_nama,true);
		$criteria->compare('jabatan_id',$this->jabatan_id);
		$criteria->compare('jabatan_nama',$this->jabatan_nama,true);
		$criteria->compare('biaya_pelatihan',$this->biaya_pelatihan);
		$criteria->compare('biaya_transportasi',$this->biaya_transportasi);
		$criteria->compare('biaya_penginapan',$this->biaya_penginapan);
		$criteria->compare('biaya_perjalanandinas',$this->biaya_perjalanandinas);
		$criteria->compare('biaya_lainlain',$this->biaya_lainlain);
		$criteria->compare('total_biaya',$this->total_biaya);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	/**
	 * - digunakan untuk menggabungkan gerlar depan, nama pegawai dan gelar belakang menjadi 1
	 * @return type
	 * @addedBy		M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
	 * @category		action
	 * @website		<piindonesia.co.id>
	 * @wiki			<https://piiproject.atlassian.net/wiki/spaces/MDO/> 
	 */
		
	public function getNamaLengkap(){
		return $this->gelardepan.' '.$this->nama_pegawai.' '.$this->gelarbelakang_nama;
	}
}