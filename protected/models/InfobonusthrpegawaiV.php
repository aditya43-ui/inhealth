<?php

/**
 * This is the model class for table "infobonusthrpegawai_v".
 *
 * The followings are the available columns in table 'infobonusthrpegawai_v':
 * @property integer $pengbonusthr_id
 * @property string $nopengajuan
 * @property string $tglpengajuan
 * @property string $jenisgaji
 * @property integer $mengetahuirs_id
 * @property string $pegawai_mengetahuirs
 * @property string $pegawai_mengetahuipt
 * @property string $pegawai_menyetujui
 * @property integer $mengetahui_pt
 * @property integer $menyetujui_id
 * @property string $keteranganpengajuan
 * @property integer $pengbonusthrdetail_id
 * @property integer $pegawai_id
 * @property string $nama_pegawai
 * @property string $statuspegawai
 * @property string $tglditerima
 * @property string $jenisgajipegawai
 * @property double $gajipokok
 * @property double $tunjangantetap
 * @property double $totalthr
 * @property double $totalpajak
 * @property double $nilaibonus
 * @property string $keteranganbonus
 * @property integer $jabatan_id
 * @property string $jabatan_nama
 * @property integer $kelompokpegawai_id
 * @property string $kelompokpegawai_nama
 * @property integer $unitkerja_id
 * @property string $namaunitkerja
 */
class InfobonusthrpegawaiV extends CActiveRecord
{
	public $total, $jenis;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InfobonusthrpegawaiV the static model class
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
		return 'infobonusthrpegawai_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			
			array('jenisgaji', 'required'),
			array('pengbonusthr_id, mengetahuirs_id, mengetahui_pt, menyetujui_id, pengbonusthrdetail_id, pegawai_id, jabatan_id, kelompokpegawai_id, unitkerja_id', 'numerical', 'integerOnly'=>true),
			array('gajipokok, tunjangantetap, totalthr, totalpajak, nilaibonus', 'numerical'),
			array('nopengajuan, jabatan_nama', 'length', 'max'=>100),
			array('jenisgaji, jenisgajipegawai', 'length', 'max'=>20),
			array('pegawai_mengetahuirs, pegawai_mengetahuipt, pegawai_menyetujui, nama_pegawai, statuspegawai', 'length', 'max'=>50),
			array('kelompokpegawai_nama', 'length', 'max'=>30),
			array('namaunitkerja', 'length', 'max'=>200),
			array('tglpengajuan, keteranganpengajuan, tglditerima, keteranganbonus, periodebonusthr', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pengbonusthr_id, nopengajuan, tglpengajuan, jenisgaji, mengetahuirs_id, pegawai_mengetahuirs, pegawai_mengetahuipt, pegawai_menyetujui, mengetahui_pt, menyetujui_id, keteranganpengajuan, pengbonusthrdetail_id, pegawai_id, nama_pegawai, statuspegawai, tglditerima, jenisgajipegawai, gajipokok, tunjangantetap, totalthr, totalpajak, nilaibonus, keteranganbonus, jabatan_id, jabatan_nama, kelompokpegawai_id, kelompokpegawai_nama, unitkerja_id, namaunitkerja, periodebonusthr', 'safe', 'on'=>'search'),
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
			'pegawai'=>array(self::BELONGS_TO,'PegawaiM','pegawai_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pengbonusthr_id' => 'Pengbonusthr',
			'nopengajuan' => 'Nopengajuan',
			'tglpengajuan' => 'Tglpengajuan',
			'jenisgaji' => 'Jenis Gaji',
			'mengetahuirs_id' => 'Mengetahuirs',
			'pegawai_mengetahuirs' => 'Pegawai Mengetahuirs',
			'pegawai_mengetahuipt' => 'Pegawai Mengetahuipt',
			'pegawai_menyetujui' => 'Pegawai Menyetujui',
			'mengetahui_pt' => 'Mengetahui Pt',
			'menyetujui_id' => 'Menyetujui',
			'keteranganpengajuan' => 'Keteranganpengajuan',
			'pengbonusthrdetail_id' => 'Pengbonusthrdetail',
			'pegawai_id' => 'Pegawai',
			'nama_pegawai' => 'Nama Pegawai',
			'statuspegawai' => 'Statuspegawai',
			'tglditerima' => 'Tglditerima',
			'jenisgajipegawai' => 'Jenisgajipegawai',
			'gajipokok' => 'Gajipokok',
			'tunjangantetap' => 'Tunjangantetap',
			'totalthr' => 'Totalthr',
			'totalpajak' => 'Totalpajak',
			'nilaibonus' => 'Nilaibonus',
			'keteranganbonus' => 'Keteranganbonus',
			'jabatan_id' => 'Jabatan',
			'jabatan_nama' => 'Jabatan Nama',
			'kelompokpegawai_id' => 'Kelompokpegawai',
			'kelompokpegawai_nama' => 'Kelompokpegawai Nama',
			'unitkerja_id' => 'Unitkerja',
			'namaunitkerja' => 'Namaunitkerja',
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

		$criteria->compare('pengbonusthr_id',$this->pengbonusthr_id);
		$criteria->compare('nopengajuan',$this->nopengajuan,true);
		$criteria->compare('tglpengajuan',$this->tglpengajuan,true);
		$criteria->compare('jenisgaji',$this->jenisgaji,true);
		$criteria->compare('mengetahuirs_id',$this->mengetahuirs_id);
		$criteria->compare('pegawai_mengetahuirs',$this->pegawai_mengetahuirs,true);
		$criteria->compare('pegawai_mengetahuipt',$this->pegawai_mengetahuipt,true);
		$criteria->compare('pegawai_menyetujui',$this->pegawai_menyetujui,true);
		$criteria->compare('mengetahui_pt',$this->mengetahui_pt);
		$criteria->compare('menyetujui_id',$this->menyetujui_id);
		$criteria->compare('keteranganpengajuan',$this->keteranganpengajuan,true);
		$criteria->compare('pengbonusthrdetail_id',$this->pengbonusthrdetail_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('nama_pegawai',$this->nama_pegawai,true);
		$criteria->compare('statuspegawai',$this->statuspegawai,true);
		$criteria->compare('tglditerima',$this->tglditerima,true);
		$criteria->compare('jenisgajipegawai',$this->jenisgajipegawai,true);
		$criteria->compare('gajipokok',$this->gajipokok);
		$criteria->compare('tunjangantetap',$this->tunjangantetap);
		$criteria->compare('totalthr',$this->totalthr);
		$criteria->compare('totalpajak',$this->totalpajak);
		$criteria->compare('nilaibonus',$this->nilaibonus);
		$criteria->compare('keteranganbonus',$this->keteranganbonus,true);
		$criteria->compare('jabatan_id',$this->jabatan_id);
		$criteria->compare('jabatan_nama',$this->jabatan_nama,true);
		$criteria->compare('kelompokpegawai_id',$this->kelompokpegawai_id);
		$criteria->compare('kelompokpegawai_nama',$this->kelompokpegawai_nama,true);
		$criteria->compare('unitkerja_id',$this->unitkerja_id);
		$criteria->compare('namaunitkerja',$this->namaunitkerja,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function getNik()
	{
		$model = PegawaiM::model()->findByAttributes(array('pegawai_id'=>$this->pegawai_id));
		return $model->nomorindukpegawai;
	}
}