<?php

/**
 * This is the model class for table "laporanpermintaandarahpasien_v".
 *
 * The followings are the available columns in table 'laporanpermintaandarahpasien_v':
 * @property string $tgl_pendaftaran
 * @property string $no_pendaftaran
 * @property integer $permintaandarah_id
 * @property string $tglpermintaan
 * @property string $no_permintaandarah
 * @property string $ruangan_nama
 * @property string $nama_pegawai
 * @property string $no_rekam_medik
 * @property string $jeniskelamin
 * @property string $nama_pasien
 * @property string $alamat_pasien
 * @property string $umur
 * @property string $kesimpulan_uji
 * @property string $namakomponendrh
 * @property string $singkatan_komp
 * @property string $golongan_darah
 * @property string $jml_kantong
 * @property string $jml_penyerahan
 */
class LaporanpermintaandarahpasienV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporanpermintaandarahpasienV the static model class
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
		return 'laporanpermintaandarahpasien_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('permintaandarah_id', 'numerical', 'integerOnly'=>true),
			array('no_pendaftaran, jeniskelamin', 'length', 'max'=>20),
			array('no_permintaandarah, ruangan_nama, nama_pegawai, nama_pasien', 'length', 'max'=>50),
			array('no_rekam_medik, golongan_darah', 'length', 'max'=>10),
			array('umur', 'length', 'max'=>30),
			array('namakomponendrh', 'length', 'max'=>100),
			array('singkatan_komp', 'length', 'max'=>5),
			array('tgl_pendaftaran, tglpermintaan, alamat_pasien, kesimpulan_uji, jml_kantong, jml_penyerahan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tgl_pendaftaran, no_pendaftaran, permintaandarah_id, tglpermintaan, no_permintaandarah, ruangan_nama, nama_pegawai, no_rekam_medik, jeniskelamin, nama_pasien, alamat_pasien, umur, kesimpulan_uji, namakomponendrh, singkatan_komp, golongan_darah, jml_kantong, jml_penyerahan', 'safe', 'on'=>'search'),
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
			'tgl_pendaftaran' => 'Tgl. Pendaftaran',
			'no_pendaftaran' => 'No. Pendaftaran',
			'permintaandarah_id' => 'Permintaandarah',
			'tglpermintaan' => 'Tglpermintaan',
			'no_permintaandarah' => 'No Permintaandarah',
			'ruangan_nama' => 'Ruangan Nama',
			'nama_pegawai' => 'Nama Pegawai',
			'no_rekam_medik' => 'No. Rekam Medik',
			'jeniskelamin' => 'Jenis Kelamin',
			'nama_pasien' => 'Nama Pasien',
			'alamat_pasien' => 'Alamat Pasien',
			'umur' => 'Umur',
			'kesimpulan_uji' => 'Kesimpulan Uji',
			'namakomponendrh' => 'Namakomponendrh',
			'singkatan_komp' => 'Singkatan Komp',
			'golongan_darah' => 'Golongan Darah',
			'jml_kantong' => 'Jml Kantong',
			'jml_penyerahan' => 'Jml Penyerahan',
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

		$criteria->compare('tgl_pendaftaran',$this->tgl_pendaftaran,true);
		$criteria->compare('no_pendaftaran',$this->no_pendaftaran,true);
		$criteria->compare('permintaandarah_id',$this->permintaandarah_id);
		$criteria->compare('tglpermintaan',$this->tglpermintaan,true);
		$criteria->compare('no_permintaandarah',$this->no_permintaandarah,true);
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);
		$criteria->compare('nama_pegawai',$this->nama_pegawai,true);
		$criteria->compare('no_rekam_medik',$this->no_rekam_medik,true);
		$criteria->compare('jeniskelamin',$this->jeniskelamin,true);
		$criteria->compare('nama_pasien',$this->nama_pasien,true);
		$criteria->compare('alamat_pasien',$this->alamat_pasien,true);
		$criteria->compare('umur',$this->umur,true);
		$criteria->compare('kesimpulan_uji',$this->kesimpulan_uji,true);
		$criteria->compare('namakomponendrh',$this->namakomponendrh,true);
		$criteria->compare('singkatan_komp',$this->singkatan_komp,true);
		$criteria->compare('golongan_darah',$this->golongan_darah,true);
		$criteria->compare('jml_kantong',$this->jml_kantong,true);
		$criteria->compare('jml_penyerahan',$this->jml_penyerahan,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}