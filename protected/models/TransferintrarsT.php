<?php

/**
 * This is the model class for table "transferintrars_t".
 *
 * The followings are the available columns in table 'transferintrars_t':
 * @property integer $transferintrars_id
 * @property integer $pendaftaran_id
 * @property integer $pasien_id
 * @property integer $pasienadmisi_id
 * @property string $tgl_transfer
 * @property string $tgl_diterima
 * @property integer $dokter_id
 * @property integer $pendamping1_id
 * @property integer $pendamping2_id
 * @property integer $petugaspenerima_id
 * @property string $indikasimrs
 * @property string $alasantransfer
 * @property string $derajatpasien
 * @property string $caratransfer
 * @property string $diagnosa
 * @property string $ditransfer_anamnesa
 * @property string $ditransfer_kesadaran
 * @property integer $ditransfer_sistolik
 * @property integer $ditransfer_diastolik
 * @property integer $ditransfer_pernapasan
 * @property integer $ditransfer_nadi
 * @property double $ditransfer_suhu
 * @property integer $ditransfer_gcs_eye
 * @property integer $ditransfer_gcs_verbal
 * @property integer $ditransfer_gcs_motorik
 * @property boolean $is_diterima
 * @property string $diterima_anamnesa
 * @property string $diterima_kesadaran
 * @property integer $diterima_sistolik
 * @property integer $diterima_diastolik
 * @property integer $diterima_pernapasan
 * @property integer $diterima_nadi
 * @property double $diterima_suhu
 * @property integer $diterima_gcs_eye
 * @property integer $diterima_gcs_verbal
 * @property integer $diterima_gcs_motorik
 * @property boolean $is_berkasfotorontgen
 * @property boolean $is_berkasusg
 * @property boolean $is_berkashasillab
 * @property string $berkaslainlain
 * @property boolean $is_alatbantuinfus
 * @property boolean $is_alatbantukateter
 * @property boolean $is_alatbantungt
 * @property boolean $is_alatbantudrain
 * @property boolean $is_alatbantuoksigen
 * @property string $alatbantuoksigen_ket
 * @property string $alabantulainlain
 * @property string $pemeriksaandiagnostik
 * @property string $tndakanterapeutik
 * @property string $rencanatindakan
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $createruangan_id
 *
 * The followings are the available model relations:
 * @property PegawaiM $dokter
 * @property PasienM $pasien
 * @property PasienadmisiT $pasienadmisi
 * @property PendaftaranT $pendaftaran
 * @property PegawaiM $pendamping1
 * @property PegawaiM $pendamping2
 * @property PegawaiM $petugaspenerima
 */
class TransferintrarsT extends CActiveRecord
{
	public $dokter_nama, $pendamping1_nama, $pendamping2_nama, $petugaspenerima_nama;
	public $is_lain, $is_lain2;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'transferintrars_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendaftaran_id, pasien_id, create_time, create_loginpemakai_id, createruangan_id', 'required'),
			array('pendaftaran_id, pasien_id, pasienadmisi_id, dokter_id, pendamping1_id, pendamping2_id, petugaspenerima_id, ditransfer_sistolik, ditransfer_diastolik, ditransfer_pernapasan, ditransfer_nadi, ditransfer_gcs_eye, ditransfer_gcs_verbal, ditransfer_gcs_motorik, diterima_sistolik, diterima_diastolik, diterima_pernapasan, diterima_nadi, diterima_gcs_eye, diterima_gcs_verbal, diterima_gcs_motorik, create_loginpemakai_id, update_loginpemakai_id, createruangan_id', 'numerical', 'integerOnly'=>true),
			array('ditransfer_suhu, diterima_suhu', 'numerical'),
			array('derajatpasien', 'length', 'max'=>20),
			array('caratransfer, ditransfer_kesadaran, diterima_kesadaran', 'length', 'max'=>100),
			array('berkaslainlain, alatbantuoksigen_ket, alabantulainlain', 'length', 'max'=>150),
			array('tgl_transfer, tgl_diterima, indikasimrs, alasantransfer, diagnosa, ditransfer_anamnesa, is_diterima, diterima_anamnesa, is_berkasfotorontgen, is_berkasusg, is_berkashasillab, is_alatbantuinfus, is_alatbantukateter, is_alatbantungt, is_alatbantudrain, is_alatbantuoksigen, pemeriksaandiagnostik, tndakanterapeutik, rencanatindakan, update_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('transferintrars_id, pendaftaran_id, pasien_id, pasienadmisi_id, tgl_transfer, tgl_diterima, dokter_id, pendamping1_id, pendamping2_id, petugaspenerima_id, indikasimrs, alasantransfer, derajatpasien, caratransfer, diagnosa, ditransfer_anamnesa, ditransfer_kesadaran, ditransfer_sistolik, ditransfer_diastolik, ditransfer_pernapasan, ditransfer_nadi, ditransfer_suhu, ditransfer_gcs_eye, ditransfer_gcs_verbal, ditransfer_gcs_motorik, is_diterima, diterima_anamnesa, diterima_kesadaran, diterima_sistolik, diterima_diastolik, diterima_pernapasan, diterima_nadi, diterima_suhu, diterima_gcs_eye, diterima_gcs_verbal, diterima_gcs_motorik, is_berkasfotorontgen, is_berkasusg, is_berkashasillab, berkaslainlain, is_alatbantuinfus, is_alatbantukateter, is_alatbantungt, is_alatbantudrain, is_alatbantuoksigen, alatbantuoksigen_ket, alabantulainlain, pemeriksaandiagnostik, tndakanterapeutik, rencanatindakan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, createruangan_id', 'safe', 'on'=>'search'),
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
			'dokter' => array(self::BELONGS_TO, 'PegawaiM', 'dokter_id'),
			'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
			'pasienadmisi' => array(self::BELONGS_TO, 'PasienadmisiT', 'pasienadmisi_id'),
			'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
			'pendamping1' => array(self::BELONGS_TO, 'PegawaiM', 'pendamping1_id'),
			'pendamping2' => array(self::BELONGS_TO, 'PegawaiM', 'pendamping2_id'),
			'petugaspenerima' => array(self::BELONGS_TO, 'PegawaiM', 'petugaspenerima_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'transferintrars_id' => 'Transferintrars',
			'pendaftaran_id' => 'Pendaftaran',
			'pasien_id' => 'Pasien',
			'pasienadmisi_id' => 'Pasienadmisi',
			'tgl_transfer' => 'Tgl Transfer',
			'tgl_diterima' => 'Tgl Diterima',
			'dokter_id' => 'Dokter',
			'pendamping1_id' => 'Pendamping1',
			'pendamping2_id' => 'Pendamping2',
			'petugaspenerima_id' => 'Petugaspenerima',
			'indikasimrs' => 'Indikasimrs',
			'alasantransfer' => 'Alasantransfer',
			'derajatpasien' => 'Derajatpasien',
			'caratransfer' => 'Caratransfer',
			'diagnosa' => 'Diagnosa',
			'ditransfer_anamnesa' => 'Ditransfer Anamnesa',
			'ditransfer_kesadaran' => 'Ditransfer Kesadaran',
			'ditransfer_sistolik' => 'Ditransfer Sistolik',
			'ditransfer_diastolik' => 'Ditransfer Diastolik',
			'ditransfer_pernapasan' => 'Ditransfer Pernapasan',
			'ditransfer_nadi' => 'Ditransfer Nadi',
			'ditransfer_suhu' => 'Ditransfer Suhu',
			'ditransfer_gcs_eye' => 'Ditransfer Gcs Eye',
			'ditransfer_gcs_verbal' => 'Ditransfer Gcs Verbal',
			'ditransfer_gcs_motorik' => 'Ditransfer Gcs Motorik',
			'is_diterima' => 'Is Diterima',
			'diterima_anamnesa' => 'Diterima Anamnesa',
			'diterima_kesadaran' => 'Diterima Kesadaran',
			'diterima_sistolik' => 'Diterima Sistolik',
			'diterima_diastolik' => 'Diterima Diastolik',
			'diterima_pernapasan' => 'Diterima Pernapasan',
			'diterima_nadi' => 'Diterima Nadi',
			'diterima_suhu' => 'Diterima Suhu',
			'diterima_gcs_eye' => 'Diterima Gcs Eye',
			'diterima_gcs_verbal' => 'Diterima Gcs Verbal',
			'diterima_gcs_motorik' => 'Diterima Gcs Motorik',
			'is_berkasfotorontgen' => 'Is Berkasfotorontgen',
			'is_berkasusg' => 'Is Berkasusg',
			'is_berkashasillab' => 'Is Berkashasillab',
			'berkaslainlain' => 'Berkaslainlain',
			'is_alatbantuinfus' => 'Is Alatbantuinfus',
			'is_alatbantukateter' => 'Is Alatbantukateter',
			'is_alatbantungt' => 'Is Alatbantungt',
			'is_alatbantudrain' => 'Is Alatbantudrain',
			'is_alatbantuoksigen' => 'Is Alatbantuoksigen',
			'alatbantuoksigen_ket' => 'Alatbantuoksigen Ket',
			'alabantulainlain' => 'Alabantulainlain',
			'pemeriksaandiagnostik' => 'Pemeriksaandiagnostik',
			'tndakanterapeutik' => 'Tndakanterapeutik',
			'rencanatindakan' => 'Rencanatindakan',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'createruangan_id' => 'Createruangan',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('transferintrars_id',$this->transferintrars_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('tgl_transfer',$this->tgl_transfer,true);
		$criteria->compare('tgl_diterima',$this->tgl_diterima,true);
		$criteria->compare('dokter_id',$this->dokter_id);
		$criteria->compare('pendamping1_id',$this->pendamping1_id);
		$criteria->compare('pendamping2_id',$this->pendamping2_id);
		$criteria->compare('petugaspenerima_id',$this->petugaspenerima_id);
		$criteria->compare('indikasimrs',$this->indikasimrs,true);
		$criteria->compare('alasantransfer',$this->alasantransfer,true);
		$criteria->compare('derajatpasien',$this->derajatpasien,true);
		$criteria->compare('caratransfer',$this->caratransfer,true);
		$criteria->compare('diagnosa',$this->diagnosa,true);
		$criteria->compare('ditransfer_anamnesa',$this->ditransfer_anamnesa,true);
		$criteria->compare('ditransfer_kesadaran',$this->ditransfer_kesadaran,true);
		$criteria->compare('ditransfer_sistolik',$this->ditransfer_sistolik);
		$criteria->compare('ditransfer_diastolik',$this->ditransfer_diastolik);
		$criteria->compare('ditransfer_pernapasan',$this->ditransfer_pernapasan);
		$criteria->compare('ditransfer_nadi',$this->ditransfer_nadi);
		$criteria->compare('ditransfer_suhu',$this->ditransfer_suhu);
		$criteria->compare('ditransfer_gcs_eye',$this->ditransfer_gcs_eye);
		$criteria->compare('ditransfer_gcs_verbal',$this->ditransfer_gcs_verbal);
		$criteria->compare('ditransfer_gcs_motorik',$this->ditransfer_gcs_motorik);
		$criteria->compare('is_diterima',$this->is_diterima);
		$criteria->compare('diterima_anamnesa',$this->diterima_anamnesa,true);
		$criteria->compare('diterima_kesadaran',$this->diterima_kesadaran,true);
		$criteria->compare('diterima_sistolik',$this->diterima_sistolik);
		$criteria->compare('diterima_diastolik',$this->diterima_diastolik);
		$criteria->compare('diterima_pernapasan',$this->diterima_pernapasan);
		$criteria->compare('diterima_nadi',$this->diterima_nadi);
		$criteria->compare('diterima_suhu',$this->diterima_suhu);
		$criteria->compare('diterima_gcs_eye',$this->diterima_gcs_eye);
		$criteria->compare('diterima_gcs_verbal',$this->diterima_gcs_verbal);
		$criteria->compare('diterima_gcs_motorik',$this->diterima_gcs_motorik);
		$criteria->compare('is_berkasfotorontgen',$this->is_berkasfotorontgen);
		$criteria->compare('is_berkasusg',$this->is_berkasusg);
		$criteria->compare('is_berkashasillab',$this->is_berkashasillab);
		$criteria->compare('berkaslainlain',$this->berkaslainlain,true);
		$criteria->compare('is_alatbantuinfus',$this->is_alatbantuinfus);
		$criteria->compare('is_alatbantukateter',$this->is_alatbantukateter);
		$criteria->compare('is_alatbantungt',$this->is_alatbantungt);
		$criteria->compare('is_alatbantudrain',$this->is_alatbantudrain);
		$criteria->compare('is_alatbantuoksigen',$this->is_alatbantuoksigen);
		$criteria->compare('alatbantuoksigen_ket',$this->alatbantuoksigen_ket,true);
		$criteria->compare('alabantulainlain',$this->alabantulainlain,true);
		$criteria->compare('pemeriksaandiagnostik',$this->pemeriksaandiagnostik,true);
		$criteria->compare('tndakanterapeutik',$this->tndakanterapeutik,true);
		$criteria->compare('rencanatindakan',$this->rencanatindakan,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('createruangan_id',$this->createruangan_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TransferintrarsT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

