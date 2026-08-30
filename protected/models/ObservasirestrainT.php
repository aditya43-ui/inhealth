<?php

/**
 * This is the model class for table "observasirestrain_t".
 *
 * The followings are the available columns in table 'observasirestrain_t':
 * @property integer $observasirestrain_id
 * @property integer $pendaftaran_id
 * @property integer $pasienadmisi_id
 * @property string $tanggal_pengkajian
 * @property string $dilakukanoleh
 * @property string $pengkajian_restrain
 * @property string $dokteryang_merawat
 * @property boolean $dihubungi
 * @property string $persetujuanolehdokter
 * @property string $dokter_persetujuan
 * @property string $saksi
 * @property boolean $iskeluarga_diberitahu
 * @property string $nama_keluarga
 * @property string $hubungan_keluarga
 * @property boolean $kebutuhan_restrain_fisik
 * @property boolean $kebutuhanrestrain_obatobatan
 * @property string $tujuan_restrain
 * @property string $pemberi_informasi
 * @property string $penerima_informasi
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai
 * @property integer $update_loginpemakai
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property PasienadmisiT $pasienadmisi
 * @property PendaftaranT $pendaftaran
 */
class ObservasirestrainT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ObservasirestrainT the static model class
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
		return 'observasirestrain_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendaftaran_id, tanggal_pengkajian, dilakukanoleh, create_time, create_loginpemakai, create_ruangan', 'required'),
			array('pendaftaran_id, pasienadmisi_id, create_loginpemakai, update_loginpemakai, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('dilakukanoleh', 'length', 'max'=>100),
			array('pengkajian_restrain, dokteryang_merawat, dokter_persetujuan, saksi, nama_keluarga, hubungan_keluarga, tujuan_restrain, pemberi_informasi, penerima_informasi', 'length', 'max'=>200),
			array('dihubungi, persetujuanolehdokter, iskeluarga_diberitahu, kebutuhan_restrain_fisik, kebutuhanrestrain_obatobatan, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('observasirestrain_id, pendaftaran_id, pasienadmisi_id, tanggal_pengkajian, dilakukanoleh, pengkajian_restrain, dokteryang_merawat, dihubungi, persetujuanolehdokter, dokter_persetujuan, saksi, iskeluarga_diberitahu, nama_keluarga, hubungan_keluarga, kebutuhan_restrain_fisik, kebutuhanrestrain_obatobatan, tujuan_restrain, pemberi_informasi, penerima_informasi, create_time, update_time, create_loginpemakai, update_loginpemakai, create_ruangan', 'safe', 'on'=>'search'),
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
			'pasienadmisi' => array(self::BELONGS_TO, 'PasienadmisiT', 'pasienadmisi_id'),
			'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'observasirestrain_id' => 'Observasirestrain',
			'pendaftaran_id' => 'Pendaftaran',
			'pasienadmisi_id' => 'Pasienadmisi',
			'tanggal_pengkajian' => 'Tanggal Pengkajian',
			'dilakukanoleh' => 'Dilakukan oleh',
			'pengkajian_restrain' => 'Pengkajian Restrain',
			'dokteryang_merawat' => 'Dokter yang Merawat',
			'dihubungi' => 'Dihubungi',
			'persetujuanolehdokter' => 'Persetujuanolehdokter',
			'dokter_persetujuan' => 'Dokter',
			'saksi' => 'Saksi',
			'iskeluarga_diberitahu' => 'Keluarga Sudah diberitahu',
			'nama_keluarga' => 'Nama',
			'hubungan_keluarga' => 'Hubungan dengan pasien',
			'kebutuhan_restrain_fisik' => 'Kebutuhan Restrain Fisik',
			'kebutuhanrestrain_obatobatan' => 'Kebutuhanrestrain Obatobatan',
			'tujuan_restrain' => 'Tujuan Restrain',
			'pemberi_informasi' => 'Pemberi Informasi',
			'penerima_informasi' => 'Penerima Informasi',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai' => 'Create Loginpemakai',
			'update_loginpemakai' => 'Update Loginpemakai',
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

		$criteria->compare('observasirestrain_id',$this->observasirestrain_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('tanggal_pengkajian',$this->tanggal_pengkajian,true);
		$criteria->compare('dilakukanoleh',$this->dilakukanoleh,true);
		$criteria->compare('pengkajian_restrain',$this->pengkajian_restrain,true);
		$criteria->compare('dokteryang_merawat',$this->dokteryang_merawat,true);
		$criteria->compare('dihubungi',$this->dihubungi);
		$criteria->compare('persetujuanolehdokter',$this->persetujuanolehdokter,true);
		$criteria->compare('dokter_persetujuan',$this->dokter_persetujuan,true);
		$criteria->compare('saksi',$this->saksi,true);
		$criteria->compare('iskeluarga_diberitahu',$this->iskeluarga_diberitahu);
		$criteria->compare('nama_keluarga',$this->nama_keluarga,true);
		$criteria->compare('hubungan_keluarga',$this->hubungan_keluarga,true);
		$criteria->compare('kebutuhan_restrain_fisik',$this->kebutuhan_restrain_fisik);
		$criteria->compare('kebutuhanrestrain_obatobatan',$this->kebutuhanrestrain_obatobatan);
		$criteria->compare('tujuan_restrain',$this->tujuan_restrain,true);
		$criteria->compare('pemberi_informasi',$this->pemberi_informasi,true);
		$criteria->compare('penerima_informasi',$this->penerima_informasi,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai',$this->create_loginpemakai);
		$criteria->compare('update_loginpemakai',$this->update_loginpemakai);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchPasien()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}