<?php

/**
 * This is the model class for table "laporanpelayanancheckup_v".
 * digunakan untuk model modul mcu lapaoran pelayanan checkup
 * RSST-3651
 * @author          Yusuf Putra Anugrah <yusufputra@.com>
 * @version         2.0.0
 * @link            http://172.9.1.15/simpp/docs/
 * @package application.models
 * The followings are the available columns in table 'laporanpelayanancheckup_v':
 * @property integer $pasien_id
 * @property string $jenisidentitas
 * @property string $no_identitas_pasien
 * @property string $namadepan
 * @property string $nama_pasien
 * @property string $nama_bin
 * @property string $jeniskelamin
 * @property string $tempat_lahir
 * @property string $tanggal_lahir
 * @property string $alamat_pasien
 * @property integer $rt
 * @property integer $rw
 * @property string $agama
 * @property string $golongandarah
 * @property string $photopasien
 * @property string $alamatemail
 * @property string $statusrekammedis
 * @property string $statusperkawinan
 * @property string $no_rekam_medik
 * @property string $tgl_rekam_medik
 * @property integer $pendaftaran_id
 * @property string $no_pendaftaran
 * @property string $tgl_pendaftaran
 * @property string $no_urutantri
 * @property string $statuspasien
 * @property string $kunjungan
 * @property boolean $alihstatus
 * @property boolean $byphone
 * @property boolean $kunjunganrumah
 * @property string $statusmasuk
 * @property string $umur
 * @property string $nomorsurat
 * @property string $keterangan
 * @property integer $jenissurat_id
 * @property string $jenissurat_nama
 * @property integer $tipepaket_id
 * @property string $tipepaket_nama
 * @property integer $kelaspelayanan_id
 * @property string $kelaspelayanan_nama
 * @property string $create_time
 * @property string $create_loginpemakai_id
 * @property string $create_ruangan
 * @property integer $shift_id
 */
class LaporanpelayanancheckupV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporanpelayanancheckupV the static model class
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
		return 'laporanpelayanancheckup_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasien_id, rt, rw, pendaftaran_id, jenissurat_id, tipepaket_id, kelaspelayanan_id, shift_id', 'numerical', 'integerOnly'=>true),
			array('jenisidentitas, namadepan, jeniskelamin, agama, statusperkawinan, no_pendaftaran', 'length', 'max'=>20),
			array('no_identitas_pasien, umur', 'length', 'max'=>30),
			array('nama_pasien, nama_bin, statuspasien, kunjungan, statusmasuk, tipepaket_nama, kelaspelayanan_nama', 'length', 'max'=>50),
			array('tempat_lahir', 'length', 'max'=>25),
			array('golongandarah', 'length', 'max'=>2),
			array('photopasien, jenissurat_nama', 'length', 'max'=>200),
			array('alamatemail, nomorsurat', 'length', 'max'=>100),
			array('statusrekammedis, no_rekam_medik', 'length', 'max'=>10),
			array('no_urutantri', 'length', 'max'=>6),
			array('tanggal_lahir, alamat_pasien, tgl_rekam_medik, tgl_pendaftaran, alihstatus, byphone, kunjunganrumah, keterangan, create_time, create_loginpemakai_id, create_ruangan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pasien_id, jenisidentitas, no_identitas_pasien, namadepan, nama_pasien, nama_bin, jeniskelamin, tempat_lahir, tanggal_lahir, alamat_pasien, rt, rw, agama, golongandarah, photopasien, alamatemail, statusrekammedis, statusperkawinan, no_rekam_medik, tgl_rekam_medik, pendaftaran_id, no_pendaftaran, tgl_pendaftaran, no_urutantri, statuspasien, kunjungan, alihstatus, byphone, kunjunganrumah, statusmasuk, umur, nomorsurat, keterangan, jenissurat_id, jenissurat_nama, tipepaket_id, tipepaket_nama, kelaspelayanan_id, kelaspelayanan_nama, create_time, create_loginpemakai_id, create_ruangan, shift_id', 'safe', 'on'=>'search'),
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
			'pasien_id' => 'Pasien',
			'jenisidentitas' => 'Jenisidentitas',
			'no_identitas_pasien' => 'No Identitas Pasien',
			'namadepan' => 'Namadepan',
			'nama_pasien' => 'Nama Pasien',
			'nama_bin' => 'Nama Bin',
			'jeniskelamin' => 'Jenis Kelamin',
			'tempat_lahir' => 'Tempat Lahir',
			'tanggal_lahir' => 'Tanggal Lahir',
			'alamat_pasien' => 'Alamat Pasien',
			'rt' => 'RT',
			'rw' => 'RW',
			'agama' => 'Agama',
			'golongandarah' => 'Golongandarah',
			'photopasien' => 'Photopasien',
			'alamatemail' => 'Alamatemail',
			'statusrekammedis' => 'Statusrekammedis',
			'statusperkawinan' => 'Statusperkawinan',
			'no_rekam_medik' => 'No. Rekam Medik',
			'tgl_rekam_medik' => 'Tgl. Rekam Medik',
			'pendaftaran_id' => 'Pendaftaran',
			'no_pendaftaran' => 'No. Pendaftaran',
			'tgl_pendaftaran' => 'Tgl. Pendaftaran',
			'no_urutantri' => 'No Urutantri',
			'statuspasien' => 'Statuspasien',
			'kunjungan' => 'Kunjungan',
			'alihstatus' => 'Alihstatus',
			'byphone' => 'Byphone',
			'kunjunganrumah' => 'Kunjunganrumah',
			'statusmasuk' => 'Statusmasuk',
			'umur' => 'Umur',
			'nomorsurat' => 'Nomorsurat',
			'keterangan' => 'Keterangan',
			'jenissurat_id' => 'Jenissurat',
			'jenissurat_nama' => 'Jenissurat Nama',
			'tipepaket_id' => 'Tipepaket',
			'tipepaket_nama' => 'Tipepaket Nama',
			'kelaspelayanan_id' => 'Kelaspelayanan',
			'kelaspelayanan_nama' => 'Kelaspelayanan Nama',
			'create_time' => 'Waktu Create',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'shift_id' => 'Shift',
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

		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('jenisidentitas',$this->jenisidentitas,true);
		$criteria->compare('no_identitas_pasien',$this->no_identitas_pasien,true);
		$criteria->compare('namadepan',$this->namadepan,true);
		$criteria->compare('nama_pasien',$this->nama_pasien,true);
		$criteria->compare('nama_bin',$this->nama_bin,true);
		$criteria->compare('jeniskelamin',$this->jeniskelamin,true);
		$criteria->compare('tempat_lahir',$this->tempat_lahir,true);
		$criteria->compare('tanggal_lahir',$this->tanggal_lahir,true);
		$criteria->compare('alamat_pasien',$this->alamat_pasien,true);
		$criteria->compare('rt',$this->rt);
		$criteria->compare('rw',$this->rw);
		$criteria->compare('agama',$this->agama,true);
		$criteria->compare('golongandarah',$this->golongandarah,true);
		$criteria->compare('photopasien',$this->photopasien,true);
		$criteria->compare('alamatemail',$this->alamatemail,true);
		$criteria->compare('statusrekammedis',$this->statusrekammedis,true);
		$criteria->compare('statusperkawinan',$this->statusperkawinan,true);
		$criteria->compare('no_rekam_medik',$this->no_rekam_medik,true);
		$criteria->compare('tgl_rekam_medik',$this->tgl_rekam_medik,true);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('no_pendaftaran',$this->no_pendaftaran,true);
		$criteria->compare('tgl_pendaftaran',$this->tgl_pendaftaran,true);
		$criteria->compare('no_urutantri',$this->no_urutantri,true);
		$criteria->compare('statuspasien',$this->statuspasien,true);
		$criteria->compare('kunjungan',$this->kunjungan,true);
		$criteria->compare('alihstatus',$this->alihstatus);
		$criteria->compare('byphone',$this->byphone);
		$criteria->compare('kunjunganrumah',$this->kunjunganrumah);
		$criteria->compare('statusmasuk',$this->statusmasuk,true);
		$criteria->compare('umur',$this->umur,true);
		$criteria->compare('nomorsurat',$this->nomorsurat,true);
		$criteria->compare('keterangan',$this->keterangan,true);
		$criteria->compare('jenissurat_id',$this->jenissurat_id);
		$criteria->compare('jenissurat_nama',$this->jenissurat_nama,true);
		$criteria->compare('tipepaket_id',$this->tipepaket_id);
		$criteria->compare('tipepaket_nama',$this->tipepaket_nama,true);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('kelaspelayanan_nama',$this->kelaspelayanan_nama,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id,true);
		$criteria->compare('create_ruangan',$this->create_ruangan,true);
		$criteria->compare('shift_id',$this->shift_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}