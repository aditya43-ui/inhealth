<?php

/**
 * This is the model class for table "monitoringpascaanastesi_t".
 *
 * The followings are the available columns in table 'monitoringpascaanastesi_t':
 * 
 * @package      application.models 
 * @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link      <http://piindonesia.co.id>
 * @link      <http://172.9.1.15/simpp/docs/>
 * 
 * @property integer $monitoringpascaanastesi_id
 * @property integer $pasienanastesi_id
 * @property integer $pasien_id
 * @property integer $pendaftaran_id
 * @property integer $diagnosa_id
 * @property integer $monitoringpeg_id
 * @property string $jam_masuk
 * @property string $jam_keluar
 * @property integer $menit_ke
 * @property integer $temperature
 * @property integer $respiration_rate
 * @property integer $nadi
 * @property integer $tekanandarah_sistolik
 * @property integer $tekanandarah_diastolik
 * @property string $komentar
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class MonitoringpascaanastesiT extends CActiveRecord
{
        public $monitoringpeg_nama;
        public $diagnosa_nama;
        
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MonitoringpascaanastesiT the static model class
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
		return 'monitoringpascaanastesi_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('create_time, create_loginpemakai_id', 'required'),
			array('pasienanastesi_id, pasien_id, pendaftaran_id, diagnosa_id, monitoringpeg_id, temperature, respiration_rate, nadi, tekanandarah_sistolik, tekanandarah_diastolik, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('menit_ke, jam_masuk, jam_keluar, komentar, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pasienanastesi_id, pasien_id, pendaftaran_id, diagnosa_id, monitoringpeg_id, jam_masuk, jam_keluar, menit_ke, temperature, respiration_rate, nadi, tekanandarah_sistolik, tekanandarah_diastolik, komentar, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
                    'diagnosa' => array(self::BELONGS_TO,'DiagnosaM','diagnosa_id'),
                    'monitoringpeg' => array(self::BELONGS_TO,'PegawaiM','monitoringpeg_id')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'monitoringpascaanastesi_id' => 'Monitoringpascaanastesi',
			'pasienanastesi_id' => 'Pasienanastesi',
			'pasien_id' => 'Pasien',
			'pendaftaran_id' => 'Pendaftaran',
			'diagnosa_id' => 'Diagnosa',
			'monitoringpeg_id' => 'Monitoringpeg',
			'jam_masuk' => 'Jam Masuk',
			'jam_keluar' => 'Jam Keluar',
			'menit_ke' => 'Menit Ke',
			'temperature' => 'Temperature',
			'respiration_rate' => 'Respiration Rate',
			'nadi' => 'Nadi',
			'tekanandarah_sistolik' => 'Tekanandarah Sistolik',
			'tekanandarah_diastolik' => 'Tekanandarah Diastolik',
			'komentar' => 'Komentar',
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

		$criteria->compare('monitoringpascaanastesi_id',$this->monitoringpascaanastesi_id);
		$criteria->compare('pasienanastesi_id',$this->pasienanastesi_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('diagnosa_id',$this->diagnosa_id);
		$criteria->compare('monitoringpeg_id',$this->monitoringpeg_id);
		$criteria->compare('jam_masuk',$this->jam_masuk,true);
		$criteria->compare('jam_keluar',$this->jam_keluar,true);
		$criteria->compare('menit_ke',$this->menit_ke);
		$criteria->compare('temperature',$this->temperature);
		$criteria->compare('respiration_rate',$this->respiration_rate);
		$criteria->compare('nadi',$this->nadi);
		$criteria->compare('tekanandarah_sistolik',$this->tekanandarah_sistolik);
		$criteria->compare('tekanandarah_diastolik',$this->tekanandarah_diastolik);
		$criteria->compare('komentar',$this->komentar,true);
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