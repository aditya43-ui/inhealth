<?php

/**
 * @author Andyka Putra <andykaputra@.com>
 * @package application.models
 * 
 * This is the model class for table "evaluasi_prainduksi_t".
 *
 * The followings are the available columns in table 'evaluasi_prainduksi_t':
 * @property integer $evaluasi_prainduksi_id
 * @property string $tglevaluasi_praanestesi
 * @property integer $pendaftaran_id
 * @property integer $pasien_id
 * @property string $makanterakhir
 * @property string $minumterakhir
 * @property integer $tekanandarah_sistolik
 * @property integer $tekanandarah_diastolik
 * @property integer $denyutjantung
 * @property double $suhu
 * @property integer $spo2
 * @property boolean $masalahsaatinduksi_ada
 * @property boolean $masalahsaatinduksi_tidakada
 * @property string $masalahsaatinduksi_ada_keterangan
 * @property boolean $perubahanrencanaanestesi_ada
 * @property boolean $perubahanrencanaanestesi_tidakada
 * @property string $perubahanrencanaanestesi_ada_keterangan
 * @property integer $premedikasi_agen1
 * @property integer $premedikasi_agen2
 * @property integer $premedikasi_agen3
 * @property integer $premedikasi_agen4
 * @property integer $pegawai1_evaluasi_id
 * @property integer $pegawai2_evaluasi_id
 * @property integer $pegawai_pramedikasi_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 * @property integer $pasienanastesi_id
 * @property integer $pegawai2_pramedikasi_id
 */
class EvaluasiPrainduksiT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return EvaluasiPrainduksiT the static model class
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
		return 'evaluasi_prainduksi_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tglevaluasi_praanestesi, pendaftaran_id, pasien_id, create_time, create_loginpemakai_id', 'required'),
			array('pendaftaran_id, pasien_id, tekanandarah_sistolik, tekanandarah_diastolik, denyutjantung, spo2, premedikasi_agen1, premedikasi_agen2, premedikasi_agen3, premedikasi_agen4, pegawai1_evaluasi_id, pegawai2_evaluasi_id, pegawai_pramedikasi_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, pasienanastesi_id, pegawai2_pramedikasi_id', 'numerical', 'integerOnly'=>true),
			array('suhu', 'numerical'),
			array('masalahsaatinduksi_ada_keterangan, perubahanrencanaanestesi_ada_keterangan', 'length', 'max'=>250),
			array('makanterakhir, minumterakhir, masalahsaatinduksi_ada, masalahsaatinduksi_tidakada, perubahanrencanaanestesi_ada, perubahanrencanaanestesi_tidakada, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('evaluasi_prainduksi_id, tglevaluasi_praanestesi, pendaftaran_id, pasien_id, makanterakhir, minumterakhir, tekanandarah_sistolik, tekanandarah_diastolik, denyutjantung, suhu, spo2, masalahsaatinduksi_ada, masalahsaatinduksi_tidakada, masalahsaatinduksi_ada_keterangan, perubahanrencanaanestesi_ada, perubahanrencanaanestesi_tidakada, perubahanrencanaanestesi_ada_keterangan, premedikasi_agen1, premedikasi_agen2, premedikasi_agen3, premedikasi_agen4, pegawai1_evaluasi_id, pegawai2_evaluasi_id, pegawai_pramedikasi_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, pasienanastesi_id, pegawai2_pramedikasi_id', 'safe', 'on'=>'search'),
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
			'evaluasi_prainduksi_id' => 'Evaluasi Prainduksi',
			'tglevaluasi_praanestesi' => 'Tglevaluasi Praanestesi',
			'pendaftaran_id' => 'Pendaftaran',
			'pasien_id' => 'Pasien',
			'makanterakhir' => 'Makanterakhir',
			'minumterakhir' => 'Minumterakhir',
			'tekanandarah_sistolik' => 'Tekanandarah Sistolik',
			'tekanandarah_diastolik' => 'Tekanandarah Diastolik',
			'denyutjantung' => 'Denyutjantung',
			'suhu' => 'Suhu',
			'spo2' => 'Spo2',
			'masalahsaatinduksi_ada' => 'Masalahsaatinduksi Ada',
			'masalahsaatinduksi_tidakada' => 'Masalahsaatinduksi Tidakada',
			'masalahsaatinduksi_ada_keterangan' => 'Masalahsaatinduksi Ada Keterangan',
			'perubahanrencanaanestesi_ada' => 'Perubahanrencanaanestesi Ada',
			'perubahanrencanaanestesi_tidakada' => 'Perubahanrencanaanestesi Tidakada',
			'perubahanrencanaanestesi_ada_keterangan' => 'Perubahanrencanaanestesi Ada Keterangan',
			'premedikasi_agen1' => 'Premedikasi Agen1',
			'premedikasi_agen2' => 'Premedikasi Agen2',
			'premedikasi_agen3' => 'Premedikasi Agen3',
			'premedikasi_agen4' => 'Premedikasi Agen4',
			'pegawai1_evaluasi_id' => 'Pegawai1 Evaluasi',
			'pegawai2_evaluasi_id' => 'Pegawai2 Evaluasi',
			'pegawai_pramedikasi_id' => 'Pegawai Pramedikasi',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
			'pasienanastesi_id' => 'Pasienanastesi',
			'pegawai2_pramedikasi_id' => 'Pegawai2 Pramedikasi',
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

		$criteria->compare('evaluasi_prainduksi_id',$this->evaluasi_prainduksi_id);
		$criteria->compare('tglevaluasi_praanestesi',$this->tglevaluasi_praanestesi,true);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('makanterakhir',$this->makanterakhir,true);
		$criteria->compare('minumterakhir',$this->minumterakhir,true);
		$criteria->compare('tekanandarah_sistolik',$this->tekanandarah_sistolik);
		$criteria->compare('tekanandarah_diastolik',$this->tekanandarah_diastolik);
		$criteria->compare('denyutjantung',$this->denyutjantung);
		$criteria->compare('suhu',$this->suhu);
		$criteria->compare('spo2',$this->spo2);
		$criteria->compare('masalahsaatinduksi_ada',$this->masalahsaatinduksi_ada);
		$criteria->compare('masalahsaatinduksi_tidakada',$this->masalahsaatinduksi_tidakada);
		$criteria->compare('masalahsaatinduksi_ada_keterangan',$this->masalahsaatinduksi_ada_keterangan,true);
		$criteria->compare('perubahanrencanaanestesi_ada',$this->perubahanrencanaanestesi_ada);
		$criteria->compare('perubahanrencanaanestesi_tidakada',$this->perubahanrencanaanestesi_tidakada);
		$criteria->compare('perubahanrencanaanestesi_ada_keterangan',$this->perubahanrencanaanestesi_ada_keterangan,true);
		$criteria->compare('premedikasi_agen1',$this->premedikasi_agen1);
		$criteria->compare('premedikasi_agen2',$this->premedikasi_agen2);
		$criteria->compare('premedikasi_agen3',$this->premedikasi_agen3);
		$criteria->compare('premedikasi_agen4',$this->premedikasi_agen4);
		$criteria->compare('pegawai1_evaluasi_id',$this->pegawai1_evaluasi_id);
		$criteria->compare('pegawai2_evaluasi_id',$this->pegawai2_evaluasi_id);
		$criteria->compare('pegawai_pramedikasi_id',$this->pegawai_pramedikasi_id);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);
		$criteria->compare('pasienanastesi_id',$this->pasienanastesi_id);
		$criteria->compare('pegawai2_pramedikasi_id',$this->pegawai2_pramedikasi_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}