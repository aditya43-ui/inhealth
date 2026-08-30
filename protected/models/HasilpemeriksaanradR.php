<?php

/**
 * This is the model class for table "hasilpemeriksaanrad_r".
 * 
 * @author  Andyka Putra <andykaputra@.com>
 * @package application.models
 * 
 * The followings are the available columns in table 'hasilpemeriksaanrad_r':
 * @property integer $riwayathasilpemeriksaanrad_id
 * @property integer $pasienadmisi_id
 * @property integer $pendaftaran_id
 * @property integer $pasienmasukpenunjang_id
 * @property integer $tindakanpelayanan_id
 * @property integer $pasien_id
 * @property integer $pemeriksaanrad_id
 * @property string $tglpemeriksaanrad
 * @property string $hasilexpertise
 * @property string $kesan_hasilrad
 * @property string $kesimpulan_hasilrad
 * @property string $tglpengambilanhasilrad
 * @property boolean $printhasilrad
 * @property string $dokterpj_luarrs
 * @property string $statusperiksahasil
 * @property integer $dokter_id
 * @property integer $radiografer_id
 * @property string $hasil_radiologi
 * @property string $statuskirim_hasilrad
 * @property string $tgl_sdhterima
 * @property string $tgl_sdhambil
 * @property integer $tat_pelayanan_pasien
 * @property string $tglverifikasi_dpjp
 * @property integer $pegawai_verifikasi_id
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 *
 * The followings are the available model relations:
 * @property PendaftaranT $pendaftaran
 * @property PemeriksaanradM $pemeriksaanrad
 * @property PasienmasukpenunjangT $pasienmasukpenunjang
 * @property PasienadmisiT $pasienadmisi
 * @property PasienM $pasien
 */
class HasilpemeriksaanradR extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return HasilpemeriksaanradR the static model class
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
		return 'hasilpemeriksaanrad_r';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pasienadmisi_id, pendaftaran_id, pasienmasukpenunjang_id, tindakanpelayanan_id, pasien_id, pemeriksaanrad_id, dokter_id, radiografer_id, tat_pelayanan_pasien, pegawai_verifikasi_id', 'numerical', 'integerOnly'=>true),
			array('dokterpj_luarrs', 'length', 'max'=>50),
			array('statusperiksahasil, hasil_radiologi', 'length', 'max'=>20),
			array('statuskirim_hasilrad', 'length', 'max'=>25),
			array('tglpemeriksaanrad, hasilexpertise, kesan_hasilrad, kesimpulan_hasilrad, tglpengambilanhasilrad, printhasilrad, tgl_sdhterima, tgl_sdhambil, tglverifikasi_dpjp, update_time, update_loginpemakai_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('riwayathasilpemeriksaanrad_id, pasienadmisi_id, pendaftaran_id, pasienmasukpenunjang_id, tindakanpelayanan_id, pasien_id, pemeriksaanrad_id, tglpemeriksaanrad, hasilexpertise, kesan_hasilrad, kesimpulan_hasilrad, tglpengambilanhasilrad, printhasilrad, dokterpj_luarrs, statusperiksahasil, dokter_id, radiografer_id, hasil_radiologi, statuskirim_hasilrad, tgl_sdhterima, tgl_sdhambil, tat_pelayanan_pasien, tglverifikasi_dpjp, pegawai_verifikasi_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
			'pemeriksaanrad' => array(self::BELONGS_TO, 'PemeriksaanradM', 'pemeriksaanrad_id'),
			'pasienmasukpenunjang' => array(self::BELONGS_TO, 'PasienmasukpenunjangT', 'pasienmasukpenunjang_id'),
			'pasienadmisi' => array(self::BELONGS_TO, 'PasienadmisiT', 'pasienadmisi_id'),
			'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
			'hasilperiksa' => array(self::BELONGS_TO, 'HasilpemeriksaanradT', 'pemeriksaanrad_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'riwayathasilpemeriksaanrad_id' => 'Riwayathasilpemeriksaanrad',
			'pasienadmisi_id' => 'Pasienadmisi',
			'pendaftaran_id' => 'Pendaftaran',
			'pasienmasukpenunjang_id' => 'Pasienmasukpenunjang',
			'tindakanpelayanan_id' => 'Tindakanpelayanan',
			'pasien_id' => 'Pasien',
			'pemeriksaanrad_id' => 'Pemeriksaanrad',
			'tglpemeriksaanrad' => 'Tglpemeriksaanrad',
			'hasilexpertise' => 'Hasilexpertise',
			'kesan_hasilrad' => 'Kesan Hasilrad',
			'kesimpulan_hasilrad' => 'Kesimpulan Hasilrad',
			'tglpengambilanhasilrad' => 'Tglpengambilanhasilrad',
			'printhasilrad' => 'Printhasilrad',
			'dokterpj_luarrs' => 'Dokterpj Luarrs',
			'statusperiksahasil' => 'Statusperiksahasil',
			'dokter_id' => 'Dokter',
			'radiografer_id' => 'Radiografer',
			'hasil_radiologi' => 'Hasil Radiologi',
			'statuskirim_hasilrad' => 'Statuskirim Hasilrad',
			'tgl_sdhterima' => 'Tgl Sdhterima',
			'tgl_sdhambil' => 'Tgl Sdhambil',
			'tat_pelayanan_pasien' => 'Tat Pelayanan Pasien',
			'tglverifikasi_dpjp' => 'Tglverifikasi Dpjp',
			'pegawai_verifikasi_id' => 'Pegawai Verifikasi',
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

		$criteria->compare('riwayathasilpemeriksaanrad_id',$this->riwayathasilpemeriksaanrad_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasienmasukpenunjang_id',$this->pasienmasukpenunjang_id);
		$criteria->compare('tindakanpelayanan_id',$this->tindakanpelayanan_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pemeriksaanrad_id',$this->pemeriksaanrad_id);
		$criteria->compare('tglpemeriksaanrad',$this->tglpemeriksaanrad,true);
		$criteria->compare('hasilexpertise',$this->hasilexpertise,true);
		$criteria->compare('kesan_hasilrad',$this->kesan_hasilrad,true);
		$criteria->compare('kesimpulan_hasilrad',$this->kesimpulan_hasilrad,true);
		$criteria->compare('tglpengambilanhasilrad',$this->tglpengambilanhasilrad,true);
		$criteria->compare('printhasilrad',$this->printhasilrad);
		$criteria->compare('dokterpj_luarrs',$this->dokterpj_luarrs,true);
		$criteria->compare('statusperiksahasil',$this->statusperiksahasil,true);
		$criteria->compare('dokter_id',$this->dokter_id);
		$criteria->compare('radiografer_id',$this->radiografer_id);
		$criteria->compare('hasil_radiologi',$this->hasil_radiologi,true);
		$criteria->compare('statuskirim_hasilrad',$this->statuskirim_hasilrad,true);
		$criteria->compare('tgl_sdhterima',$this->tgl_sdhterima,true);
		$criteria->compare('tgl_sdhambil',$this->tgl_sdhambil,true);
		$criteria->compare('tat_pelayanan_pasien',$this->tat_pelayanan_pasien);
		$criteria->compare('tglverifikasi_dpjp',$this->tglverifikasi_dpjp,true);
		$criteria->compare('pegawai_verifikasi_id',$this->pegawai_verifikasi_id);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id,true);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id,true);
		$criteria->compare('create_ruangan',$this->create_ruangan,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}