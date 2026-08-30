<?php

/**
 * This is the model class for table "laporanpermenkesjumlahpendonor_v".
 *
 * @author  Andyka Putra <andykaputra@.com>
 * @package application.models
 * 
 * The followings are the available columns in table 'laporanpermenkesjumlahpendonor_v':
 * @property integer $daftardonasi_id
 * @property string $no_formulir
 * @property string $waktu_pendaftaran
 * @property integer $donasi_ke
 * @property integer $pendonor_id
 * @property string $no_pendonor
 * @property string $no_identitas
 * @property string $nama_lengkap
 * @property string $tgllahir
 * @property string $jenis_kelamin
 * @property string $gol_darah
 * @property string $rhesus
 * @property integer $donor_itd_ke
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $seleksidonor_id
 * @property string $tglseleksidonor
 * @property integer $seleksi_umur
 * @property string $kelompok_umur
 * @property string $jenisdonor
 * @property boolean $is_gagalseleksi
 */
class LaporanpermenkesjumlahpendonorV extends CActiveRecord
{
        public $tgl_awal, $tgl_akhir, $jns_periode, $bln_awal, $bln_akhir, $thn_awal, $thn_akhir, $data, $jumlah;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporanpermenkesjumlahpendonorV the static model class
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
		return 'laporanpermenkesjumlahpendonor_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('daftardonasi_id, donasi_ke, pendonor_id, donor_itd_ke, ruangan_id, seleksidonor_id, seleksi_umur', 'numerical', 'integerOnly'=>true),
			array('no_formulir, no_pendonor, no_identitas, ruangan_nama', 'length', 'max'=>50),
			array('nama_lengkap', 'length', 'max'=>100),
			array('jenis_kelamin, rhesus', 'length', 'max'=>20),
			array('gol_darah', 'length', 'max'=>2),
			array('jenisdonor', 'length', 'max'=>255),
			array('waktu_pendaftaran, tgllahir, tglseleksidonor, kelompok_umur, is_gagalseleksi', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('daftardonasi_id, no_formulir, waktu_pendaftaran, donasi_ke, pendonor_id, no_pendonor, no_identitas, nama_lengkap, tgllahir, jenis_kelamin, gol_darah, rhesus, donor_itd_ke, ruangan_id, ruangan_nama, seleksidonor_id, tglseleksidonor, seleksi_umur, kelompok_umur, jenisdonor, is_gagalseleksi', 'safe', 'on'=>'search'),
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
			'daftardonasi_id' => 'Daftardonasi',
			'no_formulir' => 'No Formulir',
			'waktu_pendaftaran' => 'Waktu Pendaftaran',
			'donasi_ke' => 'Donasi Ke',
			'pendonor_id' => 'Pendonor',
			'no_pendonor' => 'No Pendonor',
			'no_identitas' => 'No Identitas',
			'nama_lengkap' => 'Nama Lengkap',
			'tgllahir' => 'Tgllahir',
			'jenis_kelamin' => 'Jenis Kelamin',
			'gol_darah' => 'Gol Darah',
			'rhesus' => 'Rhesus',
			'donor_itd_ke' => 'Donor Itd Ke',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
			'seleksidonor_id' => 'Seleksidonor',
			'tglseleksidonor' => 'Tglseleksidonor',
			'seleksi_umur' => 'Seleksi Umur',
			'kelompok_umur' => 'Kelompok Umur',
			'jenisdonor' => 'Jenisdonor',
			'is_gagalseleksi' => 'Is Gagalseleksi',
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

		$criteria->compare('daftardonasi_id',$this->daftardonasi_id);
		$criteria->compare('no_formulir',$this->no_formulir,true);
		$criteria->compare('waktu_pendaftaran',$this->waktu_pendaftaran,true);
		$criteria->compare('donasi_ke',$this->donasi_ke);
		$criteria->compare('pendonor_id',$this->pendonor_id);
		$criteria->compare('no_pendonor',$this->no_pendonor,true);
		$criteria->compare('no_identitas',$this->no_identitas,true);
		$criteria->compare('nama_lengkap',$this->nama_lengkap,true);
		$criteria->compare('tgllahir',$this->tgllahir,true);
		$criteria->compare('jenis_kelamin',$this->jenis_kelamin,true);
		$criteria->compare('gol_darah',$this->gol_darah,true);
		$criteria->compare('rhesus',$this->rhesus,true);
		$criteria->compare('donor_itd_ke',$this->donor_itd_ke);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);
		$criteria->compare('seleksidonor_id',$this->seleksidonor_id);
		$criteria->compare('tglseleksidonor',$this->tglseleksidonor,true);
		$criteria->compare('seleksi_umur',$this->seleksi_umur);
		$criteria->compare('kelompok_umur',$this->kelompok_umur,true);
		$criteria->compare('jenisdonor',$this->jenisdonor,true);
		$criteria->compare('is_gagalseleksi',$this->is_gagalseleksi);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}