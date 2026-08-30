<?php

/**
 * This is the model class for table "monitoringintraanastesi_t".
 *
 * The followings are the available columns in table 'monitoringintraanastesi_t':
 * @property integer $monitoringintraanastesi_id
 * @property integer $pasienanastesi_id
 * @property integer $pasien_id
 * @property integer $pendaftaran_id
 * @property integer $menit_ke
 * @property integer $nadi
 * @property integer $tekanandarah_sistolik
 * @property integer $tekanandarah_diastolik
 * @property integer $mean_arterial_press
 * @property integer $spont_respiration
 * @property integer $assissted_respiration
 * @property integer $controlled_respiration
 * @property integer $tourniquet
 * @property integer $spo2
 * @property integer $etco2
 * @property integer $cvp_spo2
 * @property integer $bis
 * @property integer $temp
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 *   
 * @package application.models
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link    <http://172.9.1.15/simpp/docs/>
 * @link    <http://piindonesia.co.id> 
 */
class MonitoringintraanastesiT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MonitoringintraanastesiT the static model class
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
		return 'monitoringintraanastesi_t';
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
			array('pasienanastesi_id, pasien_id, pendaftaran_id, menit_ke, nadi, tekanandarah_sistolik, tekanandarah_diastolik, mean_arterial_press, spont_respiration, assissted_respiration, controlled_respiration, tourniquet, spo2, etco2, cvp_spo2, bis, temp, create_loginpemakai_id, update_loginpemakai_id', 'numerical', 'integerOnly'=>true),
			array('create_ruangan, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('monitoringintraanastesi_id, pasienanastesi_id, pasien_id, pendaftaran_id, menit_ke, nadi, tekanandarah_sistolik, tekanandarah_diastolik, mean_arterial_press, spont_respiration, assissted_respiration, controlled_respiration, tourniquet, spo2, etco2, cvp_spo2, bis, temp, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id', 'safe', 'on'=>'search'),
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
			'monitoringintraanastesi_id' => 'Monitoringintraanastesi',
			'pasienanastesi_id' => 'Pasienanastesi',
			'pasien_id' => 'Pasien',
			'pendaftaran_id' => 'Pendaftaran',
			'menit_ke' => 'Menit Ke',
			'nadi' => 'Nadi',
			'tekanandarah_sistolik' => 'Tekanandarah Sistolik',
			'tekanandarah_diastolik' => 'Tekanandarah Diastolik',
			'mean_arterial_press' => 'Mean Arterial Press',
			'spont_respiration' => 'Spont Respiration',
			'assissted_respiration' => 'Assissted Respiration',
			'controlled_respiration' => 'Controlled Respiration',
			'tourniquet' => 'Tourniquet',
			'spo2' => 'Spo2',
			'etco2' => 'Etco2',
			'cvp_spo2' => 'Cvp Spo2',
			'bis' => 'Bis',
			'temp' => 'Temp',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
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

		$criteria->compare('monitoringintraanastesi_id',$this->monitoringintraanastesi_id);
		$criteria->compare('pasienanastesi_id',$this->pasienanastesi_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('menit_ke',$this->menit_ke);
		$criteria->compare('nadi',$this->nadi);
		$criteria->compare('tekanandarah_sistolik',$this->tekanandarah_sistolik);
		$criteria->compare('tekanandarah_diastolik',$this->tekanandarah_diastolik);
		$criteria->compare('mean_arterial_press',$this->mean_arterial_press);
		$criteria->compare('spont_respiration',$this->spont_respiration);
		$criteria->compare('assissted_respiration',$this->assissted_respiration);
		$criteria->compare('controlled_respiration',$this->controlled_respiration);
		$criteria->compare('tourniquet',$this->tourniquet);
		$criteria->compare('spo2',$this->spo2);
		$criteria->compare('etco2',$this->etco2);
		$criteria->compare('cvp_spo2',$this->cvp_spo2);
		$criteria->compare('bis',$this->bis);
		$criteria->compare('temp',$this->temp);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        /**
         * @author Andyka <andykaputra@.com>
         * 
         * Fungsi untuk load grafik nadi
         * @param type $pasienanastesi_id
         * @return type
         */
        
}