<?php

/**
 * This is the model class for table "cpptpasien_t".
 *
 * The followings are the available columns in table 'cpptpasien_t':
 * @property integer $cpptpasien_id
 * @property integer $pendaftaran_id
 * @property integer $pasienadmisi_id
 * @property integer $pasien_id
 * @property string $tanggal_cppt
 * @property integer $ppa_jenis
 * @property string $ppa_namajenis
 * @property integer $pegawaippa_id
 * @property integer $dpjp_id
 * @property string $soap_subjective
 * @property string $soap_objective
 * @property string $soap_asesmen
 * @property string $soap_planning
 * @property string $soapgizi_asesmen
 * @property string $soapgizi_diagnosagizi
 * @property string $soapgizi_intervensi
 * @property string $soapgizi_monitoring
 * @property string $soapgizi_evaluasi
 * @property string $instruksi
 * @property integer $ruangan_id
 * @property boolean $isverifikasidpjp
 * @property string $verifikasidpjp_tanggal
 * @property string $verifikasidpjp_hasilreview
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
 * @property PasienM $pasien
 */
class CpptpasienT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CpptpasienT the static model class
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
		return 'cpptpasien_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendaftaran_id, pasien_id, ppa_jenis, pegawaippa_id, dpjp_id, ruangan_id, create_loginpemakai, create_ruangan_id', 'required'),
			array('pendaftaran_id, pasienadmisi_id, pasien_id, pegawaippa_id, dpjp_id, ruangan_id, create_petugaspengisi_id, create_ruangan_id', 'numerical', 'integerOnly'=>true),
			array('ppa_namajenis', 'length', 'max'=>50),
			array('create_loginpemakai, update_loginpemakai', 'length', 'max'=>100),
			array('tanggal_cppt, soap_subjective, soap_objective, soap_asesmen, soap_planning, soapgizi_asesmen, soapgizi_diagnosagizi, soapgizi_intervensi, soapgizi_monitoring, soapgizi_evaluasi, instruksi, isverifikasidpjp, verifikasidpjp_tanggal, verifikasidpjp_hasilreview, create_time, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('cpptpasien_id, pendaftaran_id, pasienadmisi_id, pasien_id, tanggal_cppt, ppa_jenis, ppa_namajenis, pegawaippa_id, dpjp_id, soap_subjective, soap_objective, soap_asesmen, soap_planning, soapgizi_asesmen, soapgizi_diagnosagizi, soapgizi_intervensi, soapgizi_monitoring, soapgizi_evaluasi, instruksi, ruangan_id, isverifikasidpjp, verifikasidpjp_tanggal, verifikasidpjp_hasilreview, create_time, update_time, create_loginpemakai, update_loginpemakai, create_petugaspengisi_id, create_ruangan_id', 'safe', 'on'=>'search'),
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
			'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
                    'ruangan' => array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
                    'pegawaippa' => array(self::BELONGS_TO, 'PegawaiM', 'pegawaippa_id'),
                    'dpjp' => array(self::BELONGS_TO, 'PegawaiM', 'dpjp_id'),
					'supervisi' => array(self::BELONGS_TO, 'PegawaiM', 'dpjp_id'),
					
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'cpptpasien_id' => 'Cpptpasien',
			'pendaftaran_id' => 'Pendaftaran',
			'pasienadmisi_id' => 'Pasienadmisi',
			'pasien_id' => 'Pasien',
			'tanggal_cppt' => 'Tanggal Cppt',
			'ppa_jenis' => 'Ppa Jenis',
			'ppa_namajenis' => 'Profesional Pemberi Asuhan (PPA)',
			'pegawaippa_id' => 'Nama Profesional Pemberi Asuhan (PPA)',
			'dpjp_id' => 'DPJP',
			'soap_subjective' => 'Soap Subjective',
			'soap_objective' => 'Soap Objective',
			'soap_asesmen' => 'Soap Asesmen',
			'soap_planning' => 'Soap Planning',
			'soapgizi_asesmen' => 'Soapgizi Asesmen',
			'soapgizi_diagnosagizi' => 'Soapgizi Diagnosagizi',
			'soapgizi_intervensi' => 'Soapgizi Intervensi',
			'soapgizi_monitoring' => 'Soapgizi Monitoring',
			'soapgizi_evaluasi' => 'Soapgizi Evaluasi',
			'instruksi' => 'Instruksi',
			'ruangan_id' => 'Ruangan',
			'isverifikasidpjp' => 'Isverifikasidpjp',
			'verifikasidpjp_tanggal' => 'Verifikasidpjp Tanggal',
			'verifikasidpjp_hasilreview' => 'Verifikasidpjp Hasilreview',
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

		$criteria->compare('cpptpasien_id',$this->cpptpasien_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('tanggal_cppt',$this->tanggal_cppt,true);
		$criteria->compare('ppa_jenis',$this->ppa_jenis);
		$criteria->compare('ppa_namajenis',$this->ppa_namajenis,true);
		$criteria->compare('pegawaippa_id',$this->pegawaippa_id);
		$criteria->compare('dpjp_id',$this->dpjp_id);
		$criteria->compare('soap_subjective',$this->soap_subjective,true);
		$criteria->compare('soap_objective',$this->soap_objective,true);
		$criteria->compare('soap_asesmen',$this->soap_asesmen,true);
		$criteria->compare('soap_planning',$this->soap_planning,true);
		$criteria->compare('soapgizi_asesmen',$this->soapgizi_asesmen,true);
		$criteria->compare('soapgizi_diagnosagizi',$this->soapgizi_diagnosagizi,true);
		$criteria->compare('soapgizi_intervensi',$this->soapgizi_intervensi,true);
		$criteria->compare('soapgizi_monitoring',$this->soapgizi_monitoring,true);
		$criteria->compare('soapgizi_evaluasi',$this->soapgizi_evaluasi,true);
		$criteria->compare('instruksi',$this->instruksi,true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('isverifikasidpjp',$this->isverifikasidpjp);
		$criteria->compare('verifikasidpjp_tanggal',$this->verifikasidpjp_tanggal,true);
		$criteria->compare('verifikasidpjp_hasilreview',$this->verifikasidpjp_hasilreview,true);
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