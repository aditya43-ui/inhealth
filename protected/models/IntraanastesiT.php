<?php

/**
 * This is the model class for table "intraanastesi_t".
 * @author      Elham Budianto <elhambudianto@.com>
 * @package     application.models
 * 
 * The followings are the available columns in table 'intraanastesi_t':
 * @property integer $intraanastesi_id
 * @property integer $pasienanastesi_id
 * @property integer $pasien_id
 * @property integer $pendaftaran_id
 * @property integer $pegawai_id
 * @property string $tanggal
 * @property string $jam_masuk_ok
 * @property string $jam_ab_profilakasis
 * @property string $jam_insisi
 * @property boolean $ventilasi_circuit
 * @property boolean $ventilasi_spontan
 * @property boolean $ventilasi_assisted
 * @property boolean $ventilasi_cmv
 * @property boolean $ventilasi_pcv
 * @property string $ventilasi_tv
 * @property string $ventilasi_rate
 * @property string $ventilasi_peep
 * @property boolean $gasflow_n2o
 * @property integer $gasflow_n2o_keterangan
 * @property boolean $gasflow_o2
 * @property integer $gasflow_o2_keterangan
 * @property boolean $gasflow_air
 * @property string $gasflow_air_keterangan
 * @property boolean $gasflow_gasinhalasi
 * @property string $jam_selesai_ok
 * @property string $jam_selesai_anastesi
 * @property string $ebv
 * @property string $bayi_lahir_jam
 * @property boolean $kondisifisik_bugar
 * @property boolean $kondisifisik_tidakbugar
 * @property integer $apgar_score
 * @property integer $berat_badan
 * @property integer $tinggi_badan
 * @property string $catatan
 * @property boolean $selesaioperasi_esktubasi
 * @property boolean $selesaioperasi_intubasi
 * @property boolean $selesaioperasi_awake
 * @property boolean $selesaioperasi_icu
 * @property boolean $selesaioperasi_drowsy
 * @property boolean $selesaioperasi_rr
 * @property boolean $selesaioperasi_stabil
 * @property boolean $selesaioperasi_tidakstabil
 * @property boolean $selesaioperasi_oral
 * @property string $tanggal_selesai
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class IntraanastesiT extends CActiveRecord
{
    public $cek_kondisi_fisik,$nama_pegawai;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return IntraanastesiT the static model class
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
		return 'intraanastesi_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasienanastesi_id, pasien_id, pendaftaran_id, pegawai_id, tanggal, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pasienanastesi_id, pasien_id, pendaftaran_id, pegawai_id, gasflow_n2o_keterangan, gasflow_o2_keterangan, apgar_score, berat_badan, tinggi_badan, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('ventilasi_tv, ventilasi_rate, ventilasi_peep, gasflow_air_keterangan, ebv', 'length', 'max'=>100),
			array('jam_masuk_ok, jam_ab_profilakasis, jam_insisi, ventilasi_circuit, ventilasi_spontan, ventilasi_assisted, ventilasi_cmv, ventilasi_pcv, gasflow_n2o, gasflow_o2, gasflow_air, gasflow_gasinhalasi, jam_selesai_ok, jam_selesai_anastesi, bayi_lahir_jam, kondisifisik_bugar, kondisifisik_tidakbugar, catatan, selesaioperasi_esktubasi, selesaioperasi_intubasi, selesaioperasi_awake, selesaioperasi_icu, selesaioperasi_drowsy, selesaioperasi_rr, selesaioperasi_stabil, selesaioperasi_tidakstabil, selesaioperasi_oral, tanggal_selesai, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('intraanastesi_id, pasienanastesi_id, pasien_id, pendaftaran_id, pegawai_id, tanggal, jam_masuk_ok, jam_ab_profilakasis, jam_insisi, ventilasi_circuit, ventilasi_spontan, ventilasi_assisted, ventilasi_cmv, ventilasi_pcv, ventilasi_tv, ventilasi_rate, ventilasi_peep, gasflow_n2o, gasflow_n2o_keterangan, gasflow_o2, gasflow_o2_keterangan, gasflow_air, gasflow_air_keterangan, gasflow_gasinhalasi, jam_selesai_ok, jam_selesai_anastesi, ebv, bayi_lahir_jam, kondisifisik_bugar, kondisifisik_tidakbugar, apgar_score, berat_badan, tinggi_badan, catatan, selesaioperasi_esktubasi, selesaioperasi_intubasi, selesaioperasi_awake, selesaioperasi_icu, selesaioperasi_drowsy, selesaioperasi_rr, selesaioperasi_stabil, selesaioperasi_tidakstabil, selesaioperasi_oral, tanggal_selesai, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'intraanastesi_id' => 'Intraanastesi',
			'pasienanastesi_id' => 'Pasienanastesi',
			'pasien_id' => 'Pasien',
			'pendaftaran_id' => 'Pendaftaran',
			'pegawai_id' => 'Pegawai',
			'tanggal' => 'Tanggal',
			'jam_masuk_ok' => 'Jam Masuk Ok',
			'jam_ab_profilakasis' => 'Jam Ab Profilakasis',
			'jam_insisi' => 'Jam Insisi',
			'ventilasi_circuit' => 'Ventilasi Circuit',
			'ventilasi_spontan' => 'Ventilasi Spontan',
			'ventilasi_assisted' => 'Ventilasi Assisted',
			'ventilasi_cmv' => 'Ventilasi Cmv',
			'ventilasi_pcv' => 'Ventilasi Pcv',
			'ventilasi_tv' => 'Ventilasi Tv',
			'ventilasi_rate' => 'Ventilasi Rate',
			'ventilasi_peep' => 'Ventilasi Peep',
			'gasflow_n2o' => 'Gasflow N2o',
			'gasflow_n2o_keterangan' => 'Gasflow N2o Keterangan',
			'gasflow_o2' => 'Gasflow O2',
			'gasflow_o2_keterangan' => 'Gasflow O2 Keterangan',
			'gasflow_air' => 'Gasflow Air',
			'gasflow_air_keterangan' => 'Gasflow Air Keterangan',
			'gasflow_gasinhalasi' => 'Gasflow Gasinhalasi',
			'jam_selesai_ok' => 'Jam Selesai Ok',
			'jam_selesai_anastesi' => 'Jam Selesai Anastesi',
			'ebv' => 'Ebv',
			'bayi_lahir_jam' => 'Bayi Lahir Jam',
			'kondisifisik_bugar' => 'Kondisifisik Bugar',
			'kondisifisik_tidakbugar' => 'Kondisifisik Tidakbugar',
			'apgar_score' => 'Apgar Score',
			'berat_badan' => 'Berat Badan',
			'tinggi_badan' => 'Tinggi Badan',
			'catatan' => 'Catatan',
			'selesaioperasi_esktubasi' => 'Selesaioperasi Esktubasi',
			'selesaioperasi_intubasi' => 'Selesaioperasi Intubasi',
			'selesaioperasi_awake' => 'Selesaioperasi Awake',
			'selesaioperasi_icu' => 'Selesaioperasi Icu',
			'selesaioperasi_drowsy' => 'Selesaioperasi Drowsy',
			'selesaioperasi_rr' => 'Selesaioperasi Rr',
			'selesaioperasi_stabil' => 'Selesaioperasi Stabil',
			'selesaioperasi_tidakstabil' => 'Selesaioperasi Tidakstabil',
			'selesaioperasi_oral' => 'Selesaioperasi Oral',
			'tanggal_selesai' => 'Tanggal Selesai',
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

		$criteria->compare('intraanastesi_id',$this->intraanastesi_id);
		$criteria->compare('pasienanastesi_id',$this->pasienanastesi_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('tanggal',$this->tanggal,true);
		$criteria->compare('jam_masuk_ok',$this->jam_masuk_ok,true);
		$criteria->compare('jam_ab_profilakasis',$this->jam_ab_profilakasis,true);
		$criteria->compare('jam_insisi',$this->jam_insisi,true);
		$criteria->compare('ventilasi_circuit',$this->ventilasi_circuit);
		$criteria->compare('ventilasi_spontan',$this->ventilasi_spontan);
		$criteria->compare('ventilasi_assisted',$this->ventilasi_assisted);
		$criteria->compare('ventilasi_cmv',$this->ventilasi_cmv);
		$criteria->compare('ventilasi_pcv',$this->ventilasi_pcv);
		$criteria->compare('ventilasi_tv',$this->ventilasi_tv,true);
		$criteria->compare('ventilasi_rate',$this->ventilasi_rate,true);
		$criteria->compare('ventilasi_peep',$this->ventilasi_peep,true);
		$criteria->compare('gasflow_n2o',$this->gasflow_n2o);
		$criteria->compare('gasflow_n2o_keterangan',$this->gasflow_n2o_keterangan);
		$criteria->compare('gasflow_o2',$this->gasflow_o2);
		$criteria->compare('gasflow_o2_keterangan',$this->gasflow_o2_keterangan);
		$criteria->compare('gasflow_air',$this->gasflow_air);
		$criteria->compare('gasflow_air_keterangan',$this->gasflow_air_keterangan,true);
		$criteria->compare('gasflow_gasinhalasi',$this->gasflow_gasinhalasi);
		$criteria->compare('jam_selesai_ok',$this->jam_selesai_ok,true);
		$criteria->compare('jam_selesai_anastesi',$this->jam_selesai_anastesi,true);
		$criteria->compare('ebv',$this->ebv,true);
		$criteria->compare('bayi_lahir_jam',$this->bayi_lahir_jam,true);
		$criteria->compare('kondisifisik_bugar',$this->kondisifisik_bugar);
		$criteria->compare('kondisifisik_tidakbugar',$this->kondisifisik_tidakbugar);
		$criteria->compare('apgar_score',$this->apgar_score);
		$criteria->compare('berat_badan',$this->berat_badan);
		$criteria->compare('tinggi_badan',$this->tinggi_badan);
		$criteria->compare('catatan',$this->catatan,true);
		$criteria->compare('selesaioperasi_esktubasi',$this->selesaioperasi_esktubasi);
		$criteria->compare('selesaioperasi_intubasi',$this->selesaioperasi_intubasi);
		$criteria->compare('selesaioperasi_awake',$this->selesaioperasi_awake);
		$criteria->compare('selesaioperasi_icu',$this->selesaioperasi_icu);
		$criteria->compare('selesaioperasi_drowsy',$this->selesaioperasi_drowsy);
		$criteria->compare('selesaioperasi_rr',$this->selesaioperasi_rr);
		$criteria->compare('selesaioperasi_stabil',$this->selesaioperasi_stabil);
		$criteria->compare('selesaioperasi_tidakstabil',$this->selesaioperasi_tidakstabil);
		$criteria->compare('selesaioperasi_oral',$this->selesaioperasi_oral);
		$criteria->compare('tanggal_selesai',$this->tanggal_selesai,true);
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