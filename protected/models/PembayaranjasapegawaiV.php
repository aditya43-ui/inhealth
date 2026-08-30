<?php

/**
 * This is the model class for table "pembayaranjasapegawai_v".
 *
 * The followings are the available columns in table 'pembayaranjasapegawai_v':
 * @property integer $pembayaranjasa_id
 * @property string $periodejasa
 * @property integer $pegawai_id
 * @property string $gelardepan
 * @property string $nama_pegawai
 * @property string $nama_keluarga
 * @property string $tglbayarjasa
 * @property string $nobayarjasa
 * @property double $totaljasa
 * @property double $totalbayarjasa
 * @property double $totaltarif
 * @property double $pajakprogressif
 * @property string $pegawai_gelarbelakang
 * @property string $nomorindukpegawai
 * @property string $no_kartupegawainegerisipil
 * @property string $no_karis_karsu
 * @property string $no_taspen
 * @property string $no_askes
 * @property string $npwp
 * @property string $no_rekening
 * @property string $bank_no_rekening
 * @property string $jenisidentitas
 * @property string $noidentitas
 * @property string $tempatlahir_pegawai
 * @property string $tgl_lahirpegawai
 * @property string $jeniskelamin
 * @property string $statusperkawinan
 * @property string $alamat_pegawai
 * @property integer $kelurahan_id
 * @property string $kelurahan_nama
 * @property integer $kecamatan_id
 * @property string $kecamatan_nama
 * @property integer $kabupaten_id
 * @property string $kabupaten_nama
 * @property integer $propinsi_id
 * @property string $propinsi_nama
 * @property string $agama
 * @property string $golongandarah
 * @property string $rhesus
 * @property string $alamatemail
 * @property string $notelp_pegawai
 * @property string $nomobile_pegawai
 * @property string $warganegara_pegawai
 * @property string $jeniswaktukerja
 * @property string $kelompokjabatan
 * @property string $kategoripegawai
 * @property string $kategoripegawaiasal
 * @property string $photopegawai
 * @property string $nofingerprint
 * @property double $tinggibadan
 * @property double $beratbadan
 * @property string $kemampuanbahasa
 * @property string $warnakulit
 * @property string $nip_lama
 * @property string $tglditerima
 * @property string $tglberhenti
 * @property double $gajipokok
 * @property string $suratizinpraktek
 * @property string $unit_perusahaan
 * @property string $deskripsi
 * @property integer $suku_id
 * @property string $suku_nama
 * @property integer $pendidikan_id
 * @property integer $indexing_id
 * @property integer $profilrs_id
 * @property string $nokode_rumahsakit
 * @property string $nama_rumahsakit
 * @property string $kelas_rumahsakit
 * @property integer $jabatan_id
 * @property string $jabatan_nama
 * @property integer $pangkat_id
 * @property string $pangkat_nama
 * @property integer $golonganpegawai_id
 * @property string $golonganpegawai_nama
 * @property double $total_terima
 * @property string $menyetujui
 * @property string $mengetahui_pt
 * @property string $mengetahui
 */
class PembayaranjasapegawaiV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PembayaranjasapegawaiV the static model class
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
		return 'pembayaranjasapegawai_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pembayaranjasa_id, pegawai_id, kelurahan_id, kecamatan_id, kabupaten_id, propinsi_id, suku_id, pendidikan_id, indexing_id, profilrs_id, jabatan_id, pangkat_id, golonganpegawai_id, jurnalrekening_id', 'numerical', 'integerOnly'=>true),
			array('totaljasa, totalbayarjasa, totaltarif, pajakprogressif, tinggibadan, beratbadan, gajipokok, total_terima', 'numerical'),
			array('gelardepan, nokode_rumahsakit', 'length', 'max'=>10),
			array('nama_pegawai, nama_keluarga, kelurahan_nama, kecamatan_nama, kabupaten_nama, propinsi_nama, notelp_pegawai, nomobile_pegawai, kategoripegawaiasal, suku_nama, pangkat_nama, golonganpegawai_nama', 'length', 'max'=>50),
			array('nobayarjasa, pegawai_gelarbelakang', 'length', 'max'=>15),
			array('nomorindukpegawai, no_kartupegawainegerisipil, no_karis_karsu, no_taspen, no_askes, tempatlahir_pegawai, kelompokjabatan', 'length', 'max'=>30),
			array('npwp, warganegara_pegawai', 'length', 'max'=>25),
			array('no_rekening, bank_no_rekening, noidentitas, alamatemail, kemampuanbahasa, nip_lama, suratizinpraktek, nama_rumahsakit, jabatan_nama', 'length', 'max'=>100),
			array('jenisidentitas, jeniskelamin, statusperkawinan, agama, rhesus, jeniswaktukerja, nofingerprint', 'length', 'max'=>20),
			array('golongandarah', 'length', 'max'=>2),
			array('kategoripegawai', 'length', 'max'=>128),
			array('photopegawai', 'length', 'max'=>200),
			array('unit_perusahaan', 'length', 'max'=>70),
			array('kelas_rumahsakit', 'length', 'max'=>1),
			array('periodejasa, tglbayarjasa, tgl_lahirpegawai, alamat_pegawai, warnakulit, tglditerima, tglberhenti, deskripsi, menyetujui, mengetahui_pt, mengetahui', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pembayaranjasa_id, periodejasa, pegawai_id, gelardepan, nama_pegawai, nama_keluarga, tglbayarjasa, nobayarjasa, totaljasa, totalbayarjasa, totaltarif, pajakprogressif, pegawai_gelarbelakang, nomorindukpegawai, no_kartupegawainegerisipil, no_karis_karsu, no_taspen, no_askes, npwp, no_rekening, bank_no_rekening, jenisidentitas, noidentitas, tempatlahir_pegawai, tgl_lahirpegawai, jeniskelamin, statusperkawinan, alamat_pegawai, kelurahan_id, kelurahan_nama, kecamatan_id, kecamatan_nama, kabupaten_id, kabupaten_nama, propinsi_id, propinsi_nama, agama, golongandarah, rhesus, alamatemail, notelp_pegawai, nomobile_pegawai, warganegara_pegawai, jeniswaktukerja, kelompokjabatan, kategoripegawai, kategoripegawaiasal, photopegawai, nofingerprint, tinggibadan, beratbadan, kemampuanbahasa, warnakulit, nip_lama, tglditerima, tglberhenti, gajipokok, suratizinpraktek, unit_perusahaan, deskripsi, suku_id, suku_nama, pendidikan_id, indexing_id, profilrs_id, nokode_rumahsakit, nama_rumahsakit, kelas_rumahsakit, jabatan_id, jabatan_nama, pangkat_id, pangkat_nama, golonganpegawai_id, golonganpegawai_nama, total_terima, menyetujui, mengetahui_pt, mengetahui, jurnalrekening_id', 'safe', 'on'=>'search'),
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
			'pembayaranjasa_id' => 'Pembayaranjasa',
			'periodejasa' => 'Periodejasa',
			'pegawai_id' => 'Pegawai',
			'gelardepan' => 'Gelardepan',
			'nama_pegawai' => 'Nama Pegawai',
			'nama_keluarga' => 'Nama Keluarga',
			'tglbayarjasa' => 'Tglbayarjasa',
			'nobayarjasa' => 'Nobayarjasa',
			'totaljasa' => 'Totaljasa',
			'totalbayarjasa' => 'Totalbayarjasa',
			'totaltarif' => 'Totaltarif',
			'pajakprogressif' => 'Pajakprogressif',
			'pegawai_gelarbelakang' => 'Pegawai Gelarbelakang',
			'nomorindukpegawai' => 'Nomorindukpegawai',
			'no_kartupegawainegerisipil' => 'No Kartupegawainegerisipil',
			'no_karis_karsu' => 'No Karis Karsu',
			'no_taspen' => 'No Taspen',
			'no_askes' => 'No. Askes',
			'npwp' => 'Npwp',
			'no_rekening' => 'No. Rekening',
			'bank_no_rekening' => 'Bank No Rekening',
			'jenisidentitas' => 'Jenisidentitas',
			'noidentitas' => 'Noidentitas',
			'tempatlahir_pegawai' => 'Tempatlahir Pegawai',
			'tgl_lahirpegawai' => 'Tgl. Lahir Pegawai',
			'jeniskelamin' => 'Jenis Kelamin',
			'statusperkawinan' => 'Statusperkawinan',
			'alamat_pegawai' => 'Alamat Pegawai',
			'kelurahan_id' => 'Kelurahan',
			'kelurahan_nama' => 'Kelurahan Nama',
			'kecamatan_id' => 'Kecamatan',
			'kecamatan_nama' => 'Kecamatan Nama',
			'kabupaten_id' => 'Kabupaten',
			'kabupaten_nama' => 'Kabupaten Nama',
			'propinsi_id' => 'Provinsi',
			'propinsi_nama' => 'Propinsi Nama',
			'agama' => 'Agama',
			'golongandarah' => 'Golongandarah',
			'rhesus' => 'Rhesus',
			'alamatemail' => 'Alamatemail',
			'notelp_pegawai' => 'Notelp Pegawai',
			'nomobile_pegawai' => 'Nomobile Pegawai',
			'warganegara_pegawai' => 'Warganegara Pegawai',
			'jeniswaktukerja' => 'Jeniswaktukerja',
			'kelompokjabatan' => 'Kelompokjabatan',
			'kategoripegawai' => 'Kategoripegawai',
			'kategoripegawaiasal' => 'Kategoripegawaiasal',
			'photopegawai' => 'Photopegawai',
			'nofingerprint' => 'Nofingerprint',
			'tinggibadan' => 'Tinggibadan',
			'beratbadan' => 'Beratbadan',
			'kemampuanbahasa' => 'Kemampuanbahasa',
			'warnakulit' => 'Warnakulit',
			'nip_lama' => 'Nip Lama',
			'tglditerima' => 'Tglditerima',
			'tglberhenti' => 'Tglberhenti',
			'gajipokok' => 'Gajipokok',
			'suratizinpraktek' => 'Suratizinpraktek',
			'unit_perusahaan' => 'Unit Perusahaan',
			'deskripsi' => 'Deskripsi',
			'suku_id' => 'Suku',
			'suku_nama' => 'Suku Nama',
			'pendidikan_id' => 'Pendidikan',
			'indexing_id' => 'Indexing',
			'profilrs_id' => 'Profilrs',
			'nokode_rumahsakit' => 'Nokode Rumahsakit',
			'nama_rumahsakit' => 'Nama Rumahsakit',
			'kelas_rumahsakit' => 'Kelas Rumahsakit',
			'jabatan_id' => 'Jabatan',
			'jabatan_nama' => 'Jabatan Nama',
			'pangkat_id' => 'Pangkat',
			'pangkat_nama' => 'Pangkat Nama',
			'golonganpegawai_id' => 'Golonganpegawai',
			'golonganpegawai_nama' => 'Golonganpegawai Nama',
			'total_terima' => 'Total Terima',
			'menyetujui' => 'Menyetujui',
			'mengetahui_pt' => 'Mengetahui Pt',
			'mengetahui' => 'Mengetahui',
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

		$criteria->compare('pembayaranjasa_id',$this->pembayaranjasa_id);
		$criteria->compare('periodejasa',$this->periodejasa,true);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('gelardepan',$this->gelardepan,true);
		$criteria->compare('nama_pegawai',$this->nama_pegawai,true);
		$criteria->compare('nama_keluarga',$this->nama_keluarga,true);
		$criteria->compare('tglbayarjasa',$this->tglbayarjasa,true);
		$criteria->compare('nobayarjasa',$this->nobayarjasa,true);
		$criteria->compare('totaljasa',$this->totaljasa);
		$criteria->compare('totalbayarjasa',$this->totalbayarjasa);
		$criteria->compare('totaltarif',$this->totaltarif);
		$criteria->compare('pajakprogressif',$this->pajakprogressif);
		$criteria->compare('pegawai_gelarbelakang',$this->pegawai_gelarbelakang,true);
		$criteria->compare('nomorindukpegawai',$this->nomorindukpegawai,true);
		$criteria->compare('no_kartupegawainegerisipil',$this->no_kartupegawainegerisipil,true);
		$criteria->compare('no_karis_karsu',$this->no_karis_karsu,true);
		$criteria->compare('no_taspen',$this->no_taspen,true);
		$criteria->compare('no_askes',$this->no_askes,true);
		$criteria->compare('npwp',$this->npwp,true);
		$criteria->compare('no_rekening',$this->no_rekening,true);
		$criteria->compare('bank_no_rekening',$this->bank_no_rekening,true);
		$criteria->compare('jenisidentitas',$this->jenisidentitas,true);
		$criteria->compare('noidentitas',$this->noidentitas,true);
		$criteria->compare('tempatlahir_pegawai',$this->tempatlahir_pegawai,true);
		$criteria->compare('tgl_lahirpegawai',$this->tgl_lahirpegawai,true);
		$criteria->compare('jeniskelamin',$this->jeniskelamin,true);
		$criteria->compare('statusperkawinan',$this->statusperkawinan,true);
		$criteria->compare('alamat_pegawai',$this->alamat_pegawai,true);
		$criteria->compare('kelurahan_id',$this->kelurahan_id);
		$criteria->compare('kelurahan_nama',$this->kelurahan_nama,true);
		$criteria->compare('kecamatan_id',$this->kecamatan_id);
		$criteria->compare('kecamatan_nama',$this->kecamatan_nama,true);
		$criteria->compare('kabupaten_id',$this->kabupaten_id);
		$criteria->compare('kabupaten_nama',$this->kabupaten_nama,true);
		$criteria->compare('propinsi_id',$this->propinsi_id);
		$criteria->compare('propinsi_nama',$this->propinsi_nama,true);
		$criteria->compare('agama',$this->agama,true);
		$criteria->compare('golongandarah',$this->golongandarah,true);
		$criteria->compare('rhesus',$this->rhesus,true);
		$criteria->compare('alamatemail',$this->alamatemail,true);
		$criteria->compare('notelp_pegawai',$this->notelp_pegawai,true);
		$criteria->compare('nomobile_pegawai',$this->nomobile_pegawai,true);
		$criteria->compare('warganegara_pegawai',$this->warganegara_pegawai,true);
		$criteria->compare('jeniswaktukerja',$this->jeniswaktukerja,true);
		$criteria->compare('kelompokjabatan',$this->kelompokjabatan,true);
		$criteria->compare('kategoripegawai',$this->kategoripegawai,true);
		$criteria->compare('kategoripegawaiasal',$this->kategoripegawaiasal,true);
		$criteria->compare('photopegawai',$this->photopegawai,true);
		$criteria->compare('nofingerprint',$this->nofingerprint,true);
		$criteria->compare('tinggibadan',$this->tinggibadan);
		$criteria->compare('beratbadan',$this->beratbadan);
		$criteria->compare('kemampuanbahasa',$this->kemampuanbahasa,true);
		$criteria->compare('warnakulit',$this->warnakulit,true);
		$criteria->compare('nip_lama',$this->nip_lama,true);
		$criteria->compare('tglditerima',$this->tglditerima,true);
		$criteria->compare('tglberhenti',$this->tglberhenti,true);
		$criteria->compare('gajipokok',$this->gajipokok);
		$criteria->compare('suratizinpraktek',$this->suratizinpraktek,true);
		$criteria->compare('unit_perusahaan',$this->unit_perusahaan,true);
		$criteria->compare('deskripsi',$this->deskripsi,true);
		$criteria->compare('suku_id',$this->suku_id);
		$criteria->compare('suku_nama',$this->suku_nama,true);
		$criteria->compare('pendidikan_id',$this->pendidikan_id);
		$criteria->compare('indexing_id',$this->indexing_id);
		$criteria->compare('profilrs_id',$this->profilrs_id);
		$criteria->compare('nokode_rumahsakit',$this->nokode_rumahsakit,true);
		$criteria->compare('nama_rumahsakit',$this->nama_rumahsakit,true);
		$criteria->compare('kelas_rumahsakit',$this->kelas_rumahsakit,true);
		$criteria->compare('jabatan_id',$this->jabatan_id);
		$criteria->compare('jabatan_nama',$this->jabatan_nama,true);
		$criteria->compare('pangkat_id',$this->pangkat_id);
		$criteria->compare('pangkat_nama',$this->pangkat_nama,true);
		$criteria->compare('golonganpegawai_id',$this->golonganpegawai_id);
		$criteria->compare('golonganpegawai_nama',$this->golonganpegawai_nama,true);
		$criteria->compare('total_terima',$this->total_terima);
		$criteria->compare('menyetujui',$this->menyetujui,true);
		$criteria->compare('mengetahui_pt',$this->mengetahui_pt,true);
		$criteria->compare('mengetahui',$this->mengetahui,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}