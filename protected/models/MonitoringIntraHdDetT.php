<?php

/**
 * This is the model class for table "monitoring_intra_hd_det_t".
 *
 * The followings are the available columns in table 'monitoring_intra_hd_det_t':
 * @property integer $monitoring_intra_hd_det_id
 * @property integer $monitoring_intra_hd_id
 * @property integer $penyulit_hd_id
 * @property integer $perkembangan_terintegrasi_pasien_id
 * @property string $jenis_observasi
 * @property string $jam_observasi
 * @property double $blood_flow
 * @property double $uf_rate
 * @property integer $tensi_sistolik
 * @property integer $tensi_diastolik
 * @property integer $nadi
 * @property double $suhu
 * @property integer $respirasi
 * @property boolean $intake_nacl
 * @property string $intake_nacl_keterangan
 * @property boolean $intake_lainnya
 * @property string $intake_lainnya_keterangan
 * @property boolean $output_uf_goal
 * @property string $output_uf_goal_keterangan
 * @property boolean $output_lainnya
 * @property string $output_lainnya_keterangan
 * @property string $create_time
 * @property string $update_time
 * @property integer $creale_login
 * @property integer $update_loginpemakai_id
 * @property integer $ruangan_id
 *
 * The followings are the available model relations:
 * @property PerkembanganTerintegrasiPasienT[] $perkembanganTerintegrasiPasienTs
 */
class MonitoringIntraHdDetT extends CActiveRecord
{
    public $tanggal, $dpjp_id, $pendaftaran_id;
    public $penyulit_hd_nama;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MonitoringIntraHdDetT the static model class
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
		return 'monitoring_intra_hd_det_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('create_time, creale_login, ruangan_id', 'required'),
			array('monitoring_intra_hd_det_id, monitoring_intra_hd_id, penyulit_hd_id, perkembangan_terintegrasi_pasien_id, tensi_sistolik, tensi_diastolik, nadi, respirasi, creale_login, update_loginpemakai_id, ruangan_id', 'numerical', 'integerOnly'=>true),
			array('blood_flow, uf_rate, suhu', 'numerical'),
			array('jenis_observasi, intake_nacl_keterangan, intake_lainnya_keterangan, output_uf_goal_keterangan, output_lainnya_keterangan', 'length', 'max'=>50),
			array('jam_observasi, intake_nacl, intake_lainnya, output_uf_goal, output_lainnya, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('monitoring_intra_hd_det_id, monitoring_intra_hd_id, penyulit_hd_id, perkembangan_terintegrasi_pasien_id, jenis_observasi, jam_observasi, blood_flow, uf_rate, tensi_sistolik, tensi_diastolik, nadi, suhu, respirasi, intake_nacl, intake_nacl_keterangan, intake_lainnya, intake_lainnya_keterangan, output_uf_goal, output_uf_goal_keterangan, output_lainnya, output_lainnya_keterangan, create_time, update_time, creale_login, update_loginpemakai_id, ruangan_id', 'safe', 'on'=>'search'),
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
			'perkembanganTerintegrasiPasienTs' => array(self::HAS_MANY, 'PerkembanganTerintegrasiPasienT', 'monitoring_intra_hd_det_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'monitoring_intra_hd_det_id' => 'Monitoring Intra Hd Det',
			'monitoring_intra_hd_id' => 'Monitoring Intra Hd',
			'penyulit_hd_id' => 'Penyulit Hd',
			'perkembangan_terintegrasi_pasien_id' => 'Perkembangan Terintegrasi Pasien',
			'jenis_observasi' => 'Jenis Observasi',
			'jam_observasi' => 'Jam Observasi',
			'blood_flow' => 'Blood Flow',
			'uf_rate' => 'Uf Rate',
			'tensi_sistolik' => 'Tensi Sistolik',
			'tensi_diastolik' => 'Tensi Diastolik',
			'nadi' => 'Nadi',
			'suhu' => 'Suhu',
			'respirasi' => 'Respirasi',
			'intake_nacl' => 'Intake Nacl',
			'intake_nacl_keterangan' => 'Intake Nacl Keterangan',
			'intake_lainnya' => 'Intake Lainnya',
			'intake_lainnya_keterangan' => 'Intake Lainnya Keterangan',
			'output_uf_goal' => 'Output Uf Goal',
			'output_uf_goal_keterangan' => 'Output Uf Goal Keterangan',
			'output_lainnya' => 'Output Lainnya',
			'output_lainnya_keterangan' => 'Output Lainnya Keterangan',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'creale_login' => 'Creale Login',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'ruangan_id' => 'Ruangan',
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

		$criteria->compare('monitoring_intra_hd_det_id',$this->monitoring_intra_hd_det_id);
		$criteria->compare('monitoring_intra_hd_id',$this->monitoring_intra_hd_id);
		$criteria->compare('penyulit_hd_id',$this->penyulit_hd_id);
		$criteria->compare('perkembangan_terintegrasi_pasien_id',$this->perkembangan_terintegrasi_pasien_id);
		$criteria->compare('jenis_observasi',$this->jenis_observasi,true);
		$criteria->compare('jam_observasi',$this->jam_observasi,true);
		$criteria->compare('blood_flow',$this->blood_flow);
		$criteria->compare('uf_rate',$this->uf_rate);
		$criteria->compare('tensi_sistolik',$this->tensi_sistolik);
		$criteria->compare('tensi_diastolik',$this->tensi_diastolik);
		$criteria->compare('nadi',$this->nadi);
		$criteria->compare('suhu',$this->suhu);
		$criteria->compare('respirasi',$this->respirasi);
		$criteria->compare('intake_nacl',$this->intake_nacl);
		$criteria->compare('intake_nacl_keterangan',$this->intake_nacl_keterangan,true);
		$criteria->compare('intake_lainnya',$this->intake_lainnya);
		$criteria->compare('intake_lainnya_keterangan',$this->intake_lainnya_keterangan,true);
		$criteria->compare('output_uf_goal',$this->output_uf_goal);
		$criteria->compare('output_uf_goal_keterangan',$this->output_uf_goal_keterangan,true);
		$criteria->compare('output_lainnya',$this->output_lainnya);
		$criteria->compare('output_lainnya_keterangan',$this->output_lainnya_keterangan,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('creale_login',$this->creale_login);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}