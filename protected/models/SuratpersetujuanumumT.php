<?php

/**
 * This is the model class for table "suratpersetujuanumum_t".
 *
 * The followings are the available columns in table 'suratpersetujuanumum_t':
 * @property integer $suratpersetujuanumum_id
 * @property string $tgl_persetujuan
 * @property integer $pendaftaran_id
 * @property string $tandatangan_nama
 * @property string $tandatangan_jeniskelamin
 * @property string $tandatangan_tanggal_lahir
 * @property string $tandatangan_telepon
 * @property string $tandatangan_hubungan
 * @property string $pasien_nama
 * @property string $pasien_jeniskelamin
 * @property string $pasien_tanggal_lahir
 * @property string $pasien_no_rekam_medik
 * @property string $pasien_alamat
 * @property string $pelepasan_informasi
 * @property boolean $ijin_mengunjungi
 * @property boolean $ingin_privasi
 * @property string $privasi_khusus
 * @property string $petugas_admisi
 * @property string $penanggungjawab_pasien
 * @property string $saksi_pasien
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property PendaftaranT $pendaftaran
 */
class SuratpersetujuanumumT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SuratpersetujuanumumT the static model class
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
		return 'suratpersetujuanumum_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tgl_persetujuan, pendaftaran_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pendaftaran_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('penanggungjawab_pekerjaan', 'length', 'max'=>100),
			array('penanggungjawab_noktp', 'length', 'max'=>20),
			array('tandatangan_alamat, tandatangan_nama, tandatangan_jeniskelamin, tandatangan_tanggal_lahir, tandatangan_telepon, tandatangan_hubungan, pasien_nama, pasien_jeniskelamin, pasien_tanggal_lahir, pasien_no_rekam_medik, pasien_alamat, pelepasan_informasi, ijin_mengunjungi, ingin_privasi, privasi_khusus, petugas_admisi, penanggungjawab_pasien, saksi_pasien, update_time, is_keuangan, peraturankeuangan, petugas_saksi', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('suratpersetujuanumum_id, tgl_persetujuan, pendaftaran_id, tandatangan_nama, tandatangan_jeniskelamin, tandatangan_tanggal_lahir, tandatangan_telepon, tandatangan_hubungan, pasien_nama, pasien_jeniskelamin, pasien_tanggal_lahir, pasien_no_rekam_medik, pasien_alamat, pelepasan_informasi, ijin_mengunjungi, ingin_privasi, privasi_khusus, petugas_admisi, penanggungjawab_pasien, saksi_pasien, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, is_keuangan, penanggungjawab_pekerjaan, penanggungjawab_noktp, peraturankeuangan,petugas_saksi', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'suratpersetujuanumum_id' => 'Suratpersetujuanumum',
			'tgl_persetujuan' => 'Tgl. Persetujuan',
			'pendaftaran_id' => 'Pendaftaran',
			'tandatangan_nama' => 'Tandatangan Nama',
			'tandatangan_jeniskelamin' => 'Tandatangan Jeniskelamin',
			'tandatangan_tanggal_lahir' => 'Tandatangan Tanggal Lahir',
			'tandatangan_telepon' => 'Tandatangan Telepon',
			'tandatangan_hubungan' => 'Tandatangan Hubungan',
			'pasien_nama' => 'Pasien Nama',
			'pasien_jeniskelamin' => 'Pasien Jeniskelamin',
			'pasien_tanggal_lahir' => 'Pasien Tanggal Lahir',
			'pasien_no_rekam_medik' => 'Pasien No Rekam Medik',
			'pasien_alamat' => 'Pasien Alamat',
			'pelepasan_informasi' => 'Pelepasan Informasi',
			'ijin_mengunjungi' => 'Ijin Mengunjungi',
			'ingin_privasi' => 'Ingin Privasi',
			'privasi_khusus' => 'Privasi Khusus',
			'petugas_admisi' => 'Petugas Admisi',
			'penanggungjawab_pasien' => 'Penanggungjawab Pasien',
			'saksi_pasien' => 'Saksi Pasien',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
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

		$criteria->compare('suratpersetujuanumum_id',$this->suratpersetujuanumum_id);
		$criteria->compare('tgl_persetujuan',$this->tgl_persetujuan,true);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('tandatangan_nama',$this->tandatangan_nama,true);
		$criteria->compare('tandatangan_jeniskelamin',$this->tandatangan_jeniskelamin,true);
		$criteria->compare('tandatangan_tanggal_lahir',$this->tandatangan_tanggal_lahir,true);
		$criteria->compare('tandatangan_telepon',$this->tandatangan_telepon,true);
		$criteria->compare('tandatangan_hubungan',$this->tandatangan_hubungan,true);
		$criteria->compare('pasien_nama',$this->pasien_nama,true);
		$criteria->compare('pasien_jeniskelamin',$this->pasien_jeniskelamin,true);
		$criteria->compare('pasien_tanggal_lahir',$this->pasien_tanggal_lahir,true);
		$criteria->compare('pasien_no_rekam_medik',$this->pasien_no_rekam_medik,true);
		$criteria->compare('pasien_alamat',$this->pasien_alamat,true);
		$criteria->compare('pelepasan_informasi',$this->pelepasan_informasi,true);
		$criteria->compare('ijin_mengunjungi',$this->ijin_mengunjungi);
		$criteria->compare('ingin_privasi',$this->ingin_privasi);
		$criteria->compare('privasi_khusus',$this->privasi_khusus,true);
		$criteria->compare('petugas_admisi',$this->petugas_admisi,true);
		$criteria->compare('penanggungjawab_pasien',$this->penanggungjawab_pasien,true);
		$criteria->compare('saksi_pasien',$this->saksi_pasien,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}