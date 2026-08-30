<?php

/**
 * This is the model class for table "infopenilaianpegawai_v".
 *
 * The followings are the available columns in table 'infopenilaianpegawai_v':
 * @property integer $pegawai_id
 * @property string $nomorindukpegawai
 * @property string $gelardepan
 * @property string $nama_pegawai
 * @property integer $gelarbelakang_id
 * @property string $gelarbelakang_nama
 * @property string $kategoripegawai
 * @property integer $jabatan_id
 * @property string $jabatan_nama
 * @property integer $unitkerja_id
 * @property string $kodeunitkerja
 * @property string $namaunitkerja
 * @property integer $penilaianpegawai_id
 * @property string $tglpenilaian
 * @property string $periodepenilaian
 * @property string $sampaidengan
 * @property integer $jumlahpenilaian
 * @property integer $nilairatapenilaian
 * @property string $penilaianpegawai_keterangan
 * @property string $rekomendasi
 * @property string $catatan
 * @property string $diterimatanggalpegawai
 * @property string $keberatanpegawai
 * @property string $tanggal_keberatanpegawai
 * @property string $penilainip
 * @property string $penilainama
 * @property string $penilaijabatan
 * @property string $dibuattanggalpejabat
 * @property string $tanggapanpejabat
 * @property string $tanggal_tanggapanpejabat
 * @property string $pimpinannip
 * @property string $pimpinannama
 * @property string $pimpinanjabatan
 * @property string $diterimatanggalatasan
 * @property string $keputusanatasan
 * @property string $tanggal_keputusanatasan
 * @property integer $penilaianpegawaidet_id
 * @property integer $jenispenilaian_id
 * @property string $jenispenilaian_sifat
 * @property string $jenispenilaian_nama
 * @property integer $kompetensi_id
 * @property string $kompetensi_nama
 * @property integer $indikatorperilaku_id
 * @property string $indikatorperilaku_nama
 * @property integer $kolomrating_id
 * @property string $kolomrating_namalevel
 * @property string $kolomrating_uraian
 * @property string $kolomrating_deskripsi
 * @property integer $kolomrating_point
 * @property integer $kolomrating_nilaiawal
 * @property integer $kolomrating_nilaiakhir
 * @property string $keterangan
 */
class InfopenilaianpegawaiV extends CActiveRecord
{
	public $tgl_awal;
	public $tgl_akhir;
	
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InfopenilaianpegawaiV the static model class
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
		return 'infopenilaianpegawai_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pegawai_id, gelarbelakang_id, jabatan_id, unitkerja_id, penilaianpegawai_id, jumlahpenilaian, nilairatapenilaian, penilaianpegawaidet_id, jenispenilaian_id, kompetensi_id, indikatorperilaku_id, kolomrating_id, kolomrating_point, kolomrating_nilaiawal, kolomrating_nilaiakhir', 'numerical', 'integerOnly'=>true),
			array('nomorindukpegawai', 'length', 'max'=>30),
			array('gelardepan', 'length', 'max'=>10),
			array('nama_pegawai, kodeunitkerja, penilainip, penilaijabatan, pimpinannip', 'length', 'max'=>50),
			array('gelarbelakang_nama', 'length', 'max'=>15),
			array('kategoripegawai', 'length', 'max'=>128),
			array('jabatan_nama, penilainama, pimpinannama, pimpinanjabatan, jenispenilaian_nama, kompetensi_nama, kolomrating_namalevel', 'length', 'max'=>100),
			array('namaunitkerja', 'length', 'max'=>200),
			array('jenispenilaian_sifat', 'length', 'max'=>25),
			array('indikatorperilaku_nama', 'length', 'max'=>300),
			array('kolomrating_uraian', 'length', 'max'=>500),
			array('tglpenilaian, periodepenilaian, sampaidengan, penilaianpegawai_keterangan, rekomendasi, catatan, diterimatanggalpegawai, keberatanpegawai, tanggal_keberatanpegawai, dibuattanggalpejabat, tanggapanpejabat, tanggal_tanggapanpejabat, diterimatanggalatasan, keputusanatasan, tanggal_keputusanatasan, kolomrating_deskripsi, keterangan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pegawai_id, nomorindukpegawai, gelardepan, nama_pegawai, gelarbelakang_id, gelarbelakang_nama, kategoripegawai, jabatan_id, jabatan_nama, unitkerja_id, kodeunitkerja, namaunitkerja, penilaianpegawai_id, tglpenilaian, periodepenilaian, sampaidengan, jumlahpenilaian, nilairatapenilaian, penilaianpegawai_keterangan, rekomendasi, catatan, diterimatanggalpegawai, keberatanpegawai, tanggal_keberatanpegawai, penilainip, penilainama, penilaijabatan, dibuattanggalpejabat, tanggapanpejabat, tanggal_tanggapanpejabat, pimpinannip, pimpinannama, pimpinanjabatan, diterimatanggalatasan, keputusanatasan, tanggal_keputusanatasan, penilaianpegawaidet_id, jenispenilaian_id, jenispenilaian_sifat, jenispenilaian_nama, kompetensi_id, kompetensi_nama, indikatorperilaku_id, indikatorperilaku_nama, kolomrating_id, kolomrating_namalevel, kolomrating_uraian, kolomrating_deskripsi, kolomrating_point, kolomrating_nilaiawal, kolomrating_nilaiakhir, keterangan', 'safe', 'on'=>'search'),
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
			'kategoripegawai' => 'Status',
			'jabatan_id' => 'Jabatan',
			'jabatan_nama' => 'Jabatan Nama',
			'unitkerja_id' => 'Unit Kerja',
			'kodeunitkerja' => 'Kodeunitkerja',
			'namaunitkerja' => 'Namaunitkerja',
			'penilaianpegawai_id' => 'Penilaianpegawai',
			'tglpenilaian' => 'Tglpenilaian',
			'periodepenilaian' => 'Periodepenilaian',
			'sampaidengan' => 'Sampaidengan',
			'jumlahpenilaian' => 'Jumlahpenilaian',
			'nilairatapenilaian' => 'Nilairatapenilaian',
			'penilaianpegawai_keterangan' => 'Penilaianpegawai Keterangan',
			'rekomendasi' => 'Rekomendasi',
			'catatan' => 'Catatan',
			'diterimatanggalpegawai' => 'Diterimatanggalpegawai',
			'keberatanpegawai' => 'Keberatanpegawai',
			'tanggal_keberatanpegawai' => 'Tanggal Keberatanpegawai',
			'penilainip' => 'Penilainip',
			'penilainama' => 'Penilainama',
			'penilaijabatan' => 'Penilaijabatan',
			'dibuattanggalpejabat' => 'Dibuattanggalpejabat',
			'tanggapanpejabat' => 'Tanggapanpejabat',
			'tanggal_tanggapanpejabat' => 'Tanggal Tanggapanpejabat',
			'pimpinannip' => 'Pimpinannip',
			'pimpinannama' => 'Pimpinannama',
			'pimpinanjabatan' => 'Pimpinanjabatan',
			'diterimatanggalatasan' => 'Diterimatanggalatasan',
			'keputusanatasan' => 'Keputusanatasan',
			'tanggal_keputusanatasan' => 'Tanggal Keputusanatasan',
			'penilaianpegawaidet_id' => 'Penilaianpegawaidet',
			'jenispenilaian_id' => 'Jenispenilaian',
			'jenispenilaian_sifat' => 'Jenispenilaian Sifat',
			'jenispenilaian_nama' => 'Jenispenilaian Nama',
			'kompetensi_id' => 'Kompetensi',
			'kompetensi_nama' => 'Kompetensi Nama',
			'indikatorperilaku_id' => 'Indikatorperilaku',
			'indikatorperilaku_nama' => 'Indikatorperilaku Nama',
			'kolomrating_id' => 'Kolomrating',
			'kolomrating_namalevel' => 'Kolomrating Namalevel',
			'kolomrating_uraian' => 'Kolomrating Uraian',
			'kolomrating_deskripsi' => 'Kolomrating Deskripsi',
			'kolomrating_point' => 'Kolomrating Point',
			'kolomrating_nilaiawal' => 'Kolomrating Nilaiawal',
			'kolomrating_nilaiakhir' => 'Kolomrating Nilaiakhir',
			'keterangan' => 'Keterangan',
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
		$criteria->compare('kategoripegawai',$this->kategoripegawai,true);
		$criteria->compare('jabatan_id',$this->jabatan_id);
		$criteria->compare('jabatan_nama',$this->jabatan_nama,true);
		$criteria->compare('unitkerja_id',$this->unitkerja_id);
		$criteria->compare('kodeunitkerja',$this->kodeunitkerja,true);
		$criteria->compare('namaunitkerja',$this->namaunitkerja,true);
		$criteria->compare('penilaianpegawai_id',$this->penilaianpegawai_id);
		$criteria->compare('tglpenilaian',$this->tglpenilaian,true);
		$criteria->compare('periodepenilaian',$this->periodepenilaian,true);
		$criteria->compare('sampaidengan',$this->sampaidengan,true);
		$criteria->compare('jumlahpenilaian',$this->jumlahpenilaian);
		$criteria->compare('nilairatapenilaian',$this->nilairatapenilaian);
		$criteria->compare('penilaianpegawai_keterangan',$this->penilaianpegawai_keterangan,true);
		$criteria->compare('rekomendasi',$this->rekomendasi,true);
		$criteria->compare('catatan',$this->catatan,true);
		$criteria->compare('diterimatanggalpegawai',$this->diterimatanggalpegawai,true);
		$criteria->compare('keberatanpegawai',$this->keberatanpegawai,true);
		$criteria->compare('tanggal_keberatanpegawai',$this->tanggal_keberatanpegawai,true);
		$criteria->compare('penilainip',$this->penilainip,true);
		$criteria->compare('penilainama',$this->penilainama,true);
		$criteria->compare('penilaijabatan',$this->penilaijabatan,true);
		$criteria->compare('dibuattanggalpejabat',$this->dibuattanggalpejabat,true);
		$criteria->compare('tanggapanpejabat',$this->tanggapanpejabat,true);
		$criteria->compare('tanggal_tanggapanpejabat',$this->tanggal_tanggapanpejabat,true);
		$criteria->compare('pimpinannip',$this->pimpinannip,true);
		$criteria->compare('pimpinannama',$this->pimpinannama,true);
		$criteria->compare('pimpinanjabatan',$this->pimpinanjabatan,true);
		$criteria->compare('diterimatanggalatasan',$this->diterimatanggalatasan,true);
		$criteria->compare('keputusanatasan',$this->keputusanatasan,true);
		$criteria->compare('tanggal_keputusanatasan',$this->tanggal_keputusanatasan,true);
		$criteria->compare('penilaianpegawaidet_id',$this->penilaianpegawaidet_id);
		$criteria->compare('jenispenilaian_id',$this->jenispenilaian_id);
		$criteria->compare('jenispenilaian_sifat',$this->jenispenilaian_sifat,true);
		$criteria->compare('jenispenilaian_nama',$this->jenispenilaian_nama,true);
		$criteria->compare('kompetensi_id',$this->kompetensi_id);
		$criteria->compare('kompetensi_nama',$this->kompetensi_nama,true);
		$criteria->compare('indikatorperilaku_id',$this->indikatorperilaku_id);
		$criteria->compare('indikatorperilaku_nama',$this->indikatorperilaku_nama,true);
		$criteria->compare('kolomrating_id',$this->kolomrating_id);
		$criteria->compare('kolomrating_namalevel',$this->kolomrating_namalevel,true);
		$criteria->compare('kolomrating_uraian',$this->kolomrating_uraian,true);
		$criteria->compare('kolomrating_deskripsi',$this->kolomrating_deskripsi,true);
		$criteria->compare('kolomrating_point',$this->kolomrating_point);
		$criteria->compare('kolomrating_nilaiawal',$this->kolomrating_nilaiawal);
		$criteria->compare('kolomrating_nilaiakhir',$this->kolomrating_nilaiakhir);
		$criteria->compare('keterangan',$this->keterangan,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function getNamaLengkap(){
		return $this->gelardepan.' '.$this->nama_pegawai.', '.$this->gelarbelakang_nama;
	}
}