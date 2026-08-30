<?php

/**
 * This is the model class for table "asesmenprainduksi_t".
 *
 * The followings are the available columns in table 'asesmenprainduksi_t':
 * @property integer $asesmenprainduksi_id
 * @property integer $pasien_id
 * @property integer $pendaftaran_id
 * @property integer $pasienadmisi_id
 * @property integer $pasienmasukpenunjang_id
 * @property integer $rencanaoperasi_id
 * @property integer $statusfisik_asa
 * @property double $beratbadan
 * @property integer $td_sitolik
 * @property integer $td_diastolik
 * @property integer $detaknadi
 * @property double $suhutubuh
 * @property double $hb_pasien
 * @property integer $jenisanastesi_id
 * @property string $teknikanastesi
 * @property integer $resiko_anastesi
 * @property string $hasil_asesmen
 * @property string $posisi_pasien
 * @property string $spesimen_diambil
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property PasienM $pasien
 * @property PendaftaranT $pendaftaran
 * @property PasienadmisiT $pasienadmisi
 * @property PasienmasukpenunjangT $pasienmasukpenunjang
 * @property RencanaoperasiT $rencanaoperasi
 */
class AsesmenprainduksiT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AsesmenprainduksiT the static model class
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
		return 'asesmenprainduksi_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasien_id, pendaftaran_id, pasienmasukpenunjang_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pasien_id, pendaftaran_id, pasienadmisi_id, pasienmasukpenunjang_id, rencanaoperasi_id, statusfisik_asa, td_sitolik, td_diastolik, detaknadi, jenisanastesi_id, resiko_anastesi, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('beratbadan, suhutubuh, hb_pasien', 'numerical'),
			array('posisi_pasien, spesimen_diambil, teknikanastesi, hasil_asesmen, posisi_pasien, spesimen_diambil, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('asesmenprainduksi_id, pasien_id, pendaftaran_id, pasienadmisi_id, pasienmasukpenunjang_id, rencanaoperasi_id, statusfisik_asa, beratbadan, td_sitolik, td_diastolik, detaknadi, suhutubuh, hb_pasien, jenisanastesi_id, teknikanastesi, resiko_anastesi, hasil_asesmen, posisi_pasien, spesimen_diambil, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
			'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
			'pasienadmisi' => array(self::BELONGS_TO, 'PasienadmisiT', 'pasienadmisi_id'),
			'pasienmasukpenunjang' => array(self::BELONGS_TO, 'PasienmasukpenunjangT', 'pasienmasukpenunjang_id'),
			'rencanaoperasi' => array(self::BELONGS_TO, 'RencanaoperasiT', 'rencanaoperasi_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'asesmenprainduksi_id' => 'Asesmenprainduksi',
			'pasien_id' => 'Pasien',
			'pendaftaran_id' => 'Pendaftaran',
			'pasienadmisi_id' => 'Pasienadmisi',
			'pasienmasukpenunjang_id' => 'Pasienmasukpenunjang',
			'rencanaoperasi_id' => 'Rencanaoperasi',
			'statusfisik_asa' => 'Status Fisik ASA',
			'beratbadan' => 'Berat Badan',
			'td_sitolik' => 'Td Sitolik',
			'td_diastolik' => 'Td Diastolik',
			'detaknadi' => 'Nadi',
			'suhutubuh' => 'Suhu',
			'hb_pasien' => 'Hb',
			'jenisanastesi_id' => 'Jenis Anestesi',
			'teknikanastesi' => 'Teknik Anestesi',
			'resiko_anastesi' => 'Resiko Anestesi',
			'hasil_asesmen' => 'Hasil Asesmen',
			'posisi_pasien' => 'Posisi Pasien',
			'spesimen_diambil' => 'Spesimen Diambil',
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

		$criteria->compare('asesmenprainduksi_id',$this->asesmenprainduksi_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('pasienmasukpenunjang_id',$this->pasienmasukpenunjang_id);
		$criteria->compare('rencanaoperasi_id',$this->rencanaoperasi_id);
		$criteria->compare('statusfisik_asa',$this->statusfisik_asa);
		$criteria->compare('beratbadan',$this->beratbadan);
		$criteria->compare('td_sitolik',$this->td_sitolik);
		$criteria->compare('td_diastolik',$this->td_diastolik);
		$criteria->compare('detaknadi',$this->detaknadi);
		$criteria->compare('suhutubuh',$this->suhutubuh);
		$criteria->compare('hb_pasien',$this->hb_pasien);
		$criteria->compare('jenisanastesi_id',$this->jenisanastesi_id);
		$criteria->compare('teknikanastesi',$this->teknikanastesi,true);
		$criteria->compare('resiko_anastesi',$this->resiko_anastesi);
		$criteria->compare('hasil_asesmen',$this->hasil_asesmen,true);
		$criteria->compare('posisi_pasien',$this->posisi_pasien,true);
		$criteria->compare('spesimen_diambil',$this->spesimen_diambil,true);
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