<?php

/**
 * This is the model class for table "pemberhentiananggota_v".
 *
 * The followings are the available columns in table 'pemberhentiananggota_v':
 * @property integer $pegawai_id
 * @property string $nomorindukpegawai
 * @property string $gelardepan
 * @property string $nama_pegawai
 * @property integer $gelarbelakang_id
 * @property string $gelarbelakang_nama
 * @property string $nama_keluarga
 * @property string $tempatlahir_pegawai
 * @property string $tgl_lahirpegawai
 * @property string $jeniskelamin
 * @property string $alamat_pegawai
 * @property string $photopegawai
 * @property string $no_rekening
 * @property string $bank_no_rekening
 * @property string $npwp
 * @property string $kategoripegawai
 * @property string $jeniswaktukerja
 * @property string $notelp_pegawai
 * @property string $nomobile_pegawai
 * @property string $statusperkawinan
 * @property string $agama
 * @property string $no_kartupegawainegerisipil
 * @property string $jenisidentitas
 * @property string $noidentitas
 * @property integer $jabatan_id
 * @property string $jabatan_nama
 * @property integer $pangkat_id
 * @property string $pangkat_nama
 * @property integer $golonganpegawai_id
 * @property string $golonganpegawai_nama
 * @property string $tglkeanggotaaan
 * @property string $nokeanggotaan
 * @property integer $keanggotaan_id
 * @property string $tglpermintaanberhenti
 * @property string $tglberhenti_dipecat
 * @property string $sebabberhenti
 * @property string $alasanberhenti
 * @property string $tgldisetujuiperm
 * @property double $jmlsimpanan_berhenti
 * @property double $jmltunggakan_berhenti
 * @property string $lamamenjadi_anggota
 */
class PemberhentiananggotaV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PemberhentiananggotaV the static model class
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
		return 'pemberhentiananggota_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pegawai_id, gelarbelakang_id, jabatan_id, pangkat_id, golonganpegawai_id, keanggotaan_id', 'numerical', 'integerOnly'=>true),
			array('jmlsimpanan_berhenti, jmltunggakan_berhenti', 'numerical'),
			array('nomorindukpegawai, tempatlahir_pegawai, no_kartupegawainegerisipil', 'length', 'max'=>30),
			array('gelardepan', 'length', 'max'=>10),
			array('nama_pegawai, nama_keluarga, notelp_pegawai, nomobile_pegawai, pangkat_nama, golonganpegawai_nama, nokeanggotaan', 'length', 'max'=>50),
			array('gelarbelakang_nama', 'length', 'max'=>15),
			array('jeniskelamin, jeniswaktukerja, statusperkawinan, agama, jenisidentitas, lamamenjadi_anggota', 'length', 'max'=>20),
			array('photopegawai, sebabberhenti', 'length', 'max'=>200),
			array('no_rekening, bank_no_rekening, noidentitas, jabatan_nama', 'length', 'max'=>100),
			array('npwp', 'length', 'max'=>25),
			array('kategoripegawai', 'length', 'max'=>128),
			array('tgl_lahirpegawai, alamat_pegawai, tglkeanggotaaan, tglpermintaanberhenti, tglberhenti_dipecat, alasanberhenti, tgldisetujuiperm', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pegawai_id, nomorindukpegawai, gelardepan, nama_pegawai, gelarbelakang_id, gelarbelakang_nama, nama_keluarga, tempatlahir_pegawai, tgl_lahirpegawai, jeniskelamin, alamat_pegawai, photopegawai, no_rekening, bank_no_rekening, npwp, kategoripegawai, jeniswaktukerja, notelp_pegawai, nomobile_pegawai, statusperkawinan, agama, no_kartupegawainegerisipil, jenisidentitas, noidentitas, jabatan_id, jabatan_nama, pangkat_id, pangkat_nama, golonganpegawai_id, golonganpegawai_nama, tglkeanggotaaan, nokeanggotaan, keanggotaan_id, tglpermintaanberhenti, tglberhenti_dipecat, sebabberhenti, alasanberhenti, tgldisetujuiperm, jmlsimpanan_berhenti, jmltunggakan_berhenti, lamamenjadi_anggota', 'safe', 'on'=>'search'),
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
			'nomorindukpegawai' => 'NIP',
			'gelardepan' => 'Gelardepan',
			'nama_pegawai' => 'Nama Pegawai',
			'gelarbelakang_id' => 'Gelarbelakang',
			'gelarbelakang_nama' => 'Gelarbelakang Nama',
			'nama_keluarga' => 'Nama Keluarga',
			'tempatlahir_pegawai' => 'Tempatlahir Pegawai',
			'tgl_lahirpegawai' => 'Tgl. Lahir Pegawai',
			'jeniskelamin' => 'Jenis Kelamin',
			'alamat_pegawai' => 'Alamat Pegawai',
			'photopegawai' => 'Photopegawai',
			'no_rekening' => 'No. Rekening',
			'bank_no_rekening' => 'Bank No Rekening',
			'npwp' => 'Npwp',
			'kategoripegawai' => 'Kategoripegawai',
			'jeniswaktukerja' => 'Jeniswaktukerja',
			'notelp_pegawai' => 'Notelp Pegawai',
			'nomobile_pegawai' => 'Nomobile Pegawai',
			'statusperkawinan' => 'Statusperkawinan',
			'agama' => 'Agama',
			'no_kartupegawainegerisipil' => 'No Kartupegawainegerisipil',
			'jenisidentitas' => 'Jenisidentitas',
			'noidentitas' => 'Noidentitas',
			'jabatan_id' => 'Jabatan',
			'jabatan_nama' => 'Jabatan Nama',
			'pangkat_id' => 'Pangkat',
			'pangkat_nama' => 'Pangkat Nama',
			'golonganpegawai_id' => 'Golonganpegawai',
			'golonganpegawai_nama' => 'Golonganpegawai Nama',
			'tglkeanggotaaan' => 'Tanggal Keanggotaan',
			'nokeanggotaan' => 'No. Anggota',
			'keanggotaan_id' => 'Keanggotaan',
			'tglpermintaanberhenti' => 'Tglpermintaanberhenti',
			'tglberhenti_dipecat' => 'Tglberhenti Dipecat',
			'sebabberhenti' => 'Sebabberhenti',
			'alasanberhenti' => 'Alasanberhenti',
			'tgldisetujuiperm' => 'Tgldisetujuiperm',
			'jmlsimpanan_berhenti' => 'Jmlsimpanan Berhenti',
			'jmltunggakan_berhenti' => 'Jmltunggakan Berhenti',
			'lamamenjadi_anggota' => 'Lama Keanggotaan',
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
		$criteria->compare('nama_keluarga',$this->nama_keluarga,true);
		$criteria->compare('tempatlahir_pegawai',$this->tempatlahir_pegawai,true);
		$criteria->compare('tgl_lahirpegawai',$this->tgl_lahirpegawai,true);
		$criteria->compare('jeniskelamin',$this->jeniskelamin,true);
		$criteria->compare('alamat_pegawai',$this->alamat_pegawai,true);
		$criteria->compare('photopegawai',$this->photopegawai,true);
		$criteria->compare('no_rekening',$this->no_rekening,true);
		$criteria->compare('bank_no_rekening',$this->bank_no_rekening,true);
		$criteria->compare('npwp',$this->npwp,true);
		$criteria->compare('kategoripegawai',$this->kategoripegawai,true);
		$criteria->compare('jeniswaktukerja',$this->jeniswaktukerja,true);
		$criteria->compare('notelp_pegawai',$this->notelp_pegawai,true);
		$criteria->compare('nomobile_pegawai',$this->nomobile_pegawai,true);
		$criteria->compare('statusperkawinan',$this->statusperkawinan,true);
		$criteria->compare('agama',$this->agama,true);
		$criteria->compare('no_kartupegawainegerisipil',$this->no_kartupegawainegerisipil,true);
		$criteria->compare('jenisidentitas',$this->jenisidentitas,true);
		$criteria->compare('noidentitas',$this->noidentitas,true);
		$criteria->compare('jabatan_id',$this->jabatan_id);
		$criteria->compare('jabatan_nama',$this->jabatan_nama,true);
		$criteria->compare('pangkat_id',$this->pangkat_id);
		$criteria->compare('pangkat_nama',$this->pangkat_nama,true);
		$criteria->compare('golonganpegawai_id',$this->golonganpegawai_id);
		$criteria->compare('golonganpegawai_nama',$this->golonganpegawai_nama,true);
		$criteria->compare('tglkeanggotaaan',$this->tglkeanggotaaan,true);
		$criteria->compare('nokeanggotaan',$this->nokeanggotaan,true);
		$criteria->compare('keanggotaan_id',$this->keanggotaan_id);
		$criteria->compare('tglpermintaanberhenti',$this->tglpermintaanberhenti,true);
		$criteria->compare('tglberhenti_dipecat',$this->tglberhenti_dipecat,true);
		$criteria->compare('sebabberhenti',$this->sebabberhenti,true);
		$criteria->compare('alasanberhenti',$this->alasanberhenti,true);
		$criteria->compare('tgldisetujuiperm',$this->tgldisetujuiperm,true);
		$criteria->compare('jmlsimpanan_berhenti',$this->jmlsimpanan_berhenti);
		$criteria->compare('jmltunggakan_berhenti',$this->jmltunggakan_berhenti);
		$criteria->compare('lamamenjadi_anggota',$this->lamamenjadi_anggota,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}