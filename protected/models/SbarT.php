<?php

/**
 * This is the model class for table "sbar_t".
 *
 * The followings are the available columns in table 'sbar_t':
 * @property integer $sbar_id
 * @property string $tgl_sbar
 * @property integer $pegawai_sbar
 * @property integer $diagnosis_masuk
 * @property string $keluhan
 * @property integer $ruangan_id
 * @property string $riwayatpenyakit
 * @property string $alergi
 * @property string $terapi_dpjp
 * @property string $kesadaran
 * @property string $gcs
 * @property string $tekanan_darah
 * @property string $nadi
 * @property string $respirasi
 * @property string $suhu
 * @property string $skala_nyeri
 * @property string $tindakan
 * @property string $istruksi_dokter
 *
 * The followings are the available model relations:
 * @property PegawaiM $pegawaiSbar
 * @property DiagnosaM $diagnosisMasuk
 */
class SbarT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SbarT the static model class
	 */
	public $diagnosis_nama, $pegawaiverifikasi_nama;

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'sbar_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pegawai_sbar, tindakan, istruksi_dokter', 'required'),
			array('pegawai_sbar, diagnosis_masuk, ruangan_id, pendaftaran_id, pasien_id, pegawaiverifikasi_id', 'numerical', 'integerOnly'=>true),
			array('jenispenginputan_nama', 'length', 'max'=>50),
			array('tgl_sbar, keluhan, riwayatpenyakit, alergi, terapi_dpjp, kesadaran, gcs, tekanan_darah, nadi, respirasi, suhu, skala_nyeri, jenispenginputan, situation, background, assesmen, rekomendasi, tgl_verifikasi, hasil_review, isstatusverifikasi', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('sbar_id, tgl_sbar, pegawai_sbar, diagnosis_masuk, keluhan, ruangan_id, riwayatpenyakit, alergi, terapi_dpjp, kesadaran, gcs, tekanan_darah, nadi, respirasi, suhu, skala_nyeri, tindakan, istruksi_dokter, jenispenginputan, jenispenginputan_nama, pendaftaran_id, pasien_id, situation, background, assesmen, rekomendasi, pegawaiverifikasi_id, tgl_verifikasi, hasil_review, isstatusverifikasi', 'safe', 'on'=>'search'),
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
			'pegawaiSbar' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_sbar'),
			'diagnosisMasuk' => array(self::BELONGS_TO, 'DiagnosaM', 'diagnosis_masuk'),
			'pegawaiverifikasi' => array(self::BELONGS_TO, 'PegawaiM', 'pegawaiverifikasi_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'sbar_id' => 'Sbar',
			'tgl_sbar' => 'Tanggal SBAR',
			'pegawai_sbar' => 'Pegawai SBAR',
			'diagnosis_masuk' => 'Diagnosis Masuk',
			'keluhan' => 'Keluhan',
			'ruangan_id' => 'Ruangan',
			'riwayatpenyakit' => 'Riwayatpenyakit',
			'alergi' => 'Alergi',
			'terapi_dpjp' => 'Terapi Dpjp',
			'kesadaran' => 'Kesadaran',
			'gcs' => 'Gcs',
			'tekanan_darah' => 'Tekanan Darah',
			'nadi' => 'Nadi',
			'respirasi' => 'Respirasi',
			'suhu' => 'Suhu',
			'skala_nyeri' => 'Skala Nyeri',
			'tindakan' => 'Tindakan',
			'istruksi_dokter' => 'Istruksi Dokter',
			'jenispenginputan_nama'=>'Jenis Penginputan'
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

		$criteria->compare('sbar_id',$this->sbar_id);
		$criteria->compare('tgl_sbar',$this->tgl_sbar,true);
		$criteria->compare('pegawai_sbar',$this->pegawai_sbar);
		$criteria->compare('diagnosis_masuk',$this->diagnosis_masuk);
		$criteria->compare('keluhan',$this->keluhan,true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('riwayatpenyakit',$this->riwayatpenyakit,true);
		$criteria->compare('alergi',$this->alergi,true);
		$criteria->compare('terapi_dpjp',$this->terapi_dpjp,true);
		$criteria->compare('kesadaran',$this->kesadaran,true);
		$criteria->compare('gcs',$this->gcs,true);
		$criteria->compare('tekanan_darah',$this->tekanan_darah,true);
		$criteria->compare('nadi',$this->nadi,true);
		$criteria->compare('respirasi',$this->respirasi,true);
		$criteria->compare('suhu',$this->suhu,true);
		$criteria->compare('skala_nyeri',$this->skala_nyeri,true);
		$criteria->compare('tindakan',$this->tindakan,true);
		$criteria->compare('istruksi_dokter',$this->istruksi_dokter,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchRiwayat()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}

		$criteria->order = "tgl_sbar ASC";
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


}
