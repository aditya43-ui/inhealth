<?php

/**
 * This is the model class for table "pelepasanrestaint_t".
 *
 * The followings are the available columns in table 'pelepasanrestaint_t':
 * @property integer $pelepasanrestrain_id
 * @property integer $pendaftaran_id
 * @property integer $pasienadmisi_id
 * @property string $kesadaran
 * @property string $gcs_eye
 * @property string $gcs_verbal
 * @property string $gcs_motorik
 * @property string $tekanandarah
 * @property integer $pernapasan
 * @property double $suhu
 * @property double $nadi
 * @property integer $skala_nyeri
 * @property string $hasilobservasi
 * @property string $restrain_nonfarmotologi
 * @property boolean $lainnya_nonfarmotologi
 * @property string $keterangan_lainnya
 * @property string $restrain_farmatologi
 * @property boolean $restraindilanjutkan
 * @property boolean $restraintidak_dilanjutkan
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
class PelepasanrestaintT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PelepasanrestaintT the static model class
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
		return 'pelepasanrestaint_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendaftaran_id, create_time, create_loginpemakai, create_ruangan', 'required'),
			array('pendaftaran_id, pasienadmisi_id, pernapasan, skala_nyeri, create_loginpemakai, update_loginpemakai, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('suhu, nadi', 'numerical'),
			array('kesadaran, keterangan_lainnya, restrain_farmatologi, pemberi_informasi, penerima_informasi', 'length', 'max'=>200),
			array('gcs_eye, gcs_verbal, gcs_motorik, tekanandarah', 'length', 'max'=>100),
			array('hasilobservasi, restrain_nonfarmotologi, lainnya_nonfarmotologi, restraindilanjutkan, restraintidak_dilanjutkan, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pelepasanrestrain_id, pendaftaran_id, pasienadmisi_id, kesadaran, gcs_eye, gcs_verbal, gcs_motorik, tekanandarah, pernapasan, suhu, nadi, skala_nyeri, hasilobservasi, restrain_nonfarmotologi, lainnya_nonfarmotologi, keterangan_lainnya, restrain_farmatologi, restraindilanjutkan, restraintidak_dilanjutkan, pemberi_informasi, penerima_informasi, create_time, update_time, create_loginpemakai, update_loginpemakai, create_ruangan', 'safe', 'on'=>'search'),
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
			'pelepasanrestrain_id' => 'Pelepasanrestrain',
			'pendaftaran_id' => 'Pendaftaran',
			'pasienadmisi_id' => 'Pasienadmisi',
			'kesadaran' => 'Kesadaran',
			'gcs_eye' => 'GCS Eye',
			'gcs_verbal' => 'GCS Verbal',
			'gcs_motorik' => 'GCS Motorik',
			'tekanandarah' => 'Tekanan Darah',
			'pernapasan' => 'Pernapasan',
			'suhu' => 'Suhu',
			'nadi' => 'Nadi',
			'skala_nyeri' => 'Skala Nyeri',
			'hasilobservasi' => 'Hasilobservasi',
			'restrain_nonfarmotologi' => 'Restrain Nonfarmotologi',
			'lainnya_nonfarmotologi' => 'Lainnya Nonfarmotologi',
			'keterangan_lainnya' => 'Keterangan Lainnya',
			'restrain_farmatologi' => 'Restrain Farmatologi',
			'restraindilanjutkan' => 'Restraindilanjutkan',
			'restraintidak_dilanjutkan' => 'Restraintidak Dilanjutkan',
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

		$criteria->compare('pelepasanrestrain_id',$this->pelepasanrestrain_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('kesadaran',$this->kesadaran,true);
		$criteria->compare('gcs_eye',$this->gcs_eye,true);
		$criteria->compare('gcs_verbal',$this->gcs_verbal,true);
		$criteria->compare('gcs_motorik',$this->gcs_motorik,true);
		$criteria->compare('tekanandarah',$this->tekanandarah,true);
		$criteria->compare('pernapasan',$this->pernapasan);
		$criteria->compare('suhu',$this->suhu);
		$criteria->compare('nadi',$this->nadi);
		$criteria->compare('skala_nyeri',$this->skala_nyeri);
		$criteria->compare('hasilobservasi',$this->hasilobservasi,true);
		$criteria->compare('restrain_nonfarmotologi',$this->restrain_nonfarmotologi,true);
		$criteria->compare('lainnya_nonfarmotologi',$this->lainnya_nonfarmotologi);
		$criteria->compare('keterangan_lainnya',$this->keterangan_lainnya,true);
		$criteria->compare('restrain_farmatologi',$this->restrain_farmatologi,true);
		$criteria->compare('restraindilanjutkan',$this->restraindilanjutkan);
		$criteria->compare('restraintidak_dilanjutkan',$this->restraintidak_dilanjutkan);
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