<?php

/**
 * This is the model class for table "formtransferpasien_t".
 *
 * The followings are the available columns in table 'formtransferpasien_t':
 * @property integer $formtransferpasien_id
 * @property integer $pendaftaran_id
 * @property integer $pasienadmisi_id
 * @property string $tanggal_transfer
 * @property string $waktu_transfer
 * @property integer $instalasitujuan_id
 * @property integer $ruangantujuan_id
 * @property integer $ruanganasal_id
 * @property string $alasanditransfer
 * @property string $kebutuhanpelayanan
 * @property string $indikasidirawat
 * @property string $jamringkas_riwayatpasien
 * @property string $dokter_keluhanutama
 * @property string $dokter_keadaanumum
 * @property integer $ttvdokter_td_systolic
 * @property integer $ttvdokter_td_diastolic
 * @property double $ttvdokter_suhutubuh
 * @property integer $ttvdokter_nadi
 * @property string $dokter_catatanlainlain
 * @property integer $dokterpengirim_id
 * @property boolean $ispasienditerima
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai
 * @property string $update_loginpemakai
 * @property integer $create_petugaspengisi_id
 * @property integer $create_ruangan_id
 *
 * The followings are the available model relations:
 * @property PendaftaranT $pendaftaran
 * @property PasienadmisiT $pasienadmisi
 */
class FormtransferpasienT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return FormtransferpasienT the static model class
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
		return 'formtransferpasien_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendaftaran_id, create_time, create_loginpemakai, instalasitujuan_id, ruangantujuan_id, waktu_transfer, tanggal_transfer, dokterpengirim_id', 'required'),
			array('pendaftaran_id, pasienadmisi_id, instalasitujuan_id, ruangantujuan_id, ruanganasal_id, ttvdokter_td_systolic, ttvdokter_td_diastolic, ttvdokter_nadi, dokterpengirim_id, create_petugaspengisi_id, create_ruangan_id', 'numerical', 'integerOnly'=>true),
			array('ttvdokter_suhutubuh', 'numerical'),
			array('dokter_keluhanutama, dokter_keadaanumum', 'length', 'max'=>300),
			array('create_loginpemakai, update_loginpemakai', 'length', 'max'=>100),
			array('tanggal_transfer, waktu_transfer, alasanditransfer, kebutuhanpelayanan, indikasidirawat, jamringkas_riwayatpasien, dokter_catatanlainlain, ispasienditerima, update_time, dokter_tindakanmedisygdilakukan, dokter_pemberianterapi, riwayatpenyakitterdahulu, riwayatalergi, diagnosamasukrs, dokter_ringkasanriwayatpasien', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('formtransferpasien_id, pendaftaran_id, pasienadmisi_id, tanggal_transfer, waktu_transfer, instalasitujuan_id, ruangantujuan_id, ruanganasal_id, alasanditransfer, kebutuhanpelayanan, indikasidirawat, jamringkas_riwayatpasien, dokter_keluhanutama, dokter_keadaanumum, ttvdokter_td_systolic, ttvdokter_td_diastolic, ttvdokter_suhutubuh, ttvdokter_nadi, dokter_catatanlainlain, dokterpengirim_id, ispasienditerima, create_time, update_time, create_loginpemakai, update_loginpemakai, create_petugaspengisi_id, create_ruangan_id, dokter_tindakanmedisygdilakukan, dokter_pemberianterapi, riwayatpenyakitterdahulu, riwayatalergi, diagnosamasukrs', 'safe', 'on'=>'search'),
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
			'pasienadmisi' => array(self::BELONGS_TO, 'PasienadmisiT', 'pasienadmisi_id'),
                    'dokterpengirim' => array(self::BELONGS_TO, 'PegawaiM', 'dokterpengirim_id'),
                    'ruanganasal' => array(self::BELONGS_TO, 'RuanganM', 'ruanganasal_id'),
                    'ruangantujuan' => array(self::BELONGS_TO, 'RuanganM', 'ruangantujuan_id'),
                    'instalasitujuan' => array(self::BELONGS_TO, 'InstalasiM', 'instalasitujuan_id'),

		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'formtransferpasien_id' => 'Formtransferpasien',
			'pendaftaran_id' => 'Pendaftaran',
			'pasienadmisi_id' => 'Pasienadmisi',
			'tanggal_transfer' => 'Tanggal Transfer',
			'waktu_transfer' => 'Waktu',
			'instalasitujuan_id' => 'Instalasi Tujuan',
			'ruangantujuan_id' => 'Ruangan Tujuan',
			'ruanganasal_id' => 'Ruangan Asal',
			'alasanditransfer' => 'Alasan di Transfer',
			'kebutuhanpelayanan' => 'Kebutuhan Pelayanan',
			'indikasidirawat' => 'Indikasi Pasien Di Rawat',
			'jamringkas_riwayatpasien' => 'Pukul',
			'dokter_keluhanutama' => 'Keluhan Utama',
			'dokter_keadaanumum' => 'Keadaan Umum',
			'ttvdokter_td_systolic' => 'Ttvdokter Td Systolic',
			'ttvdokter_td_diastolic' => 'Ttvdokter Td Diastolic',
			'ttvdokter_suhutubuh' => 'Ttvdokter Suhutubuh',
			'ttvdokter_nadi' => 'Ttvdokter Nadi',
			'dokter_catatanlainlain' => 'Dokter Catatanlainlain',
			'dokterpengirim_id' => 'Dokterpengirim',
			'ispasienditerima' => 'Ispasienditerima',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai' => 'Create Loginpemakai',
			'update_loginpemakai' => 'Update Loginpemakai',
			'create_petugaspengisi_id' => 'Create Petugaspengisi',
			'create_ruangan_id' => 'Create Ruangan',
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

		$criteria->compare('formtransferpasien_id',$this->formtransferpasien_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('tanggal_transfer',$this->tanggal_transfer,true);
		$criteria->compare('waktu_transfer',$this->waktu_transfer,true);
		$criteria->compare('instalasitujuan_id',$this->instalasitujuan_id);
		$criteria->compare('ruangantujuan_id',$this->ruangantujuan_id);
		$criteria->compare('ruanganasal_id',$this->ruanganasal_id);
		$criteria->compare('alasanditransfer',$this->alasanditransfer,true);
		$criteria->compare('kebutuhanpelayanan',$this->kebutuhanpelayanan,true);
		$criteria->compare('indikasidirawat',$this->indikasidirawat,true);
		$criteria->compare('jamringkas_riwayatpasien',$this->jamringkas_riwayatpasien,true);
		$criteria->compare('dokter_keluhanutama',$this->dokter_keluhanutama,true);
		$criteria->compare('dokter_keadaanumum',$this->dokter_keadaanumum,true);
		$criteria->compare('ttvdokter_td_systolic',$this->ttvdokter_td_systolic);
		$criteria->compare('ttvdokter_td_diastolic',$this->ttvdokter_td_diastolic);
		$criteria->compare('ttvdokter_suhutubuh',$this->ttvdokter_suhutubuh);
		$criteria->compare('ttvdokter_nadi',$this->ttvdokter_nadi);
		$criteria->compare('dokter_catatanlainlain',$this->dokter_catatanlainlain,true);
		$criteria->compare('dokterpengirim_id',$this->dokterpengirim_id);
		$criteria->compare('ispasienditerima',$this->ispasienditerima);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai',$this->create_loginpemakai,true);
		$criteria->compare('update_loginpemakai',$this->update_loginpemakai,true);
		$criteria->compare('create_petugaspengisi_id',$this->create_petugaspengisi_id);
		$criteria->compare('create_ruangan_id',$this->create_ruangan_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
