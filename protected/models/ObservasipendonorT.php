<?php

/**
 * This is the model class for table "observasipendonor_t".
 * 
 * @author  M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @author  Andyka <andykaputra@.com>
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @package application.models
 * @category model
 * The followings are the available columns in table 'observasipendonor_t':
 * @property integer $observasipendonor_id
 * @property integer $pendonor_id
 * @property integer $daftardonasi_id
 * @property string $tglmulaiobservasi
 * @property string $sd_observasi
 * @property string $kelancarandarah
 * @property integer $nadi_observasi
 * @property string $keluhan_pendonor
 * @property string $ket_observasi
 * @property double $suhu_observasi
 * @property integer $td_systolic
 * @property integer $td_diastolic
 * @property string $pernapasan
 * @property string $kesadaran
 * @property integer $petugas_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class ObservasipendonorT extends CActiveRecord
{
        public $jamawal;
        public $jamakhir;
        public $det;
        public $petugas_nama;
        public $detalasan;        
        public $petugaspenyadapan_nama, $selisih_hari, $nomor_urut, $waktu_observasi, $nomor, $nama_pegawai;

        /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ObservasipendonorT the static model class
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
		return 'observasipendonor_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendonor_id, daftardonasi_id, tglmulaiobservasi, sd_observasi, kelancarandarah, petugas_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pendonor_id, daftardonasi_id, nadi_observasi, td_systolic, td_diastolic, petugas_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('suhu_observasi', 'numerical'),                    			
			array('kelancarandarah', 'length', 'max'=>20),
			array('pernapasan, kesadaran', 'length', 'max'=>100),
			array('durasi_penyadapan, ket_alasanbatal, seleksidonor_id, waktu_observasi, is_batalpenyadapan, alasanbatal_penyadapan, keluhan_pendonor, ket_observasi, update_time', 'safe'),
                        array('adakeluhan_setelahpenyadapan, tanggalobservasi_setelahpenyadapan, kelancarandarah_setelahpenyadapan, keluhan_setelahpenyadapan, nadi_setelahpenyadapan, suhu_setelahpenyadapan','safe'),
                        array('petugaspenyadapan_id, td_systolic_setelahpenyadapan, td_diastolic_setelahpenyadapan, pernafasan_setelahpenyadapan, kesadaran_setelahpenyadapan, keterangan_setelahpenyadapan, tindakan_setelahpenyadapan','safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('observasipendonor_id, pendonor_id, daftardonasi_id, tglmulaiobservasi, sd_observasi, kelancarandarah, nadi_observasi, keluhan_pendonor, ket_observasi, suhu_observasi, td_systolic, td_diastolic, pernapasan, kesadaran, petugas_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
                    'petugas' => array(self::BELONGS_TO,'PegawaiM','petugas_id'),
                    'pendonor' => array(self::BELONGS_TO,'PendonorM','pendonor_id'),
                    'petugaspenyadapan' => array(self::BELONGS_TO,'PegawaiM','petugaspenyadapan_id')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'observasipendonor_id' => 'Observasipendonor',
			'pendonor_id' => 'Pendonor',
			'daftardonasi_id' => 'Daftardonasi',
			'tglmulaiobservasi' => 'Tglmulaiobservasi',
			'sd_observasi' => 'Sd Observasi',
			'kelancarandarah' => 'Kelancarandarah',
			'nadi_observasi' => 'Nadi Observasi',
			'keluhan_pendonor' => 'Keluhan Pendonor',
			'ket_observasi' => 'Ket Observasi',
			'suhu_observasi' => 'Suhu Observasi',
			'td_systolic' => 'Td Systolic',
			'td_diastolic' => 'Td Diastolic',
			'pernapasan' => 'Pernapasan',
			'kesadaran' => 'Kesadaran',
			'petugas_id' => 'Petugas',
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

		$criteria->compare('observasipendonor_id',$this->observasipendonor_id);
		$criteria->compare('pendonor_id',$this->pendonor_id);
		$criteria->compare('daftardonasi_id',$this->daftardonasi_id);
		$criteria->compare('tglmulaiobservasi',$this->tglmulaiobservasi,true);
		$criteria->compare('sd_observasi',$this->sd_observasi,true);
		$criteria->compare('kelancarandarah',$this->kelancarandarah,true);
		$criteria->compare('nadi_observasi',$this->nadi_observasi);
		$criteria->compare('keluhan_pendonor',$this->keluhan_pendonor,true);
		$criteria->compare('ket_observasi',$this->ket_observasi,true);
		$criteria->compare('suhu_observasi',$this->suhu_observasi);
		$criteria->compare('td_systolic',$this->td_systolic);
		$criteria->compare('td_diastolic',$this->td_diastolic);
		$criteria->compare('pernapasan',$this->pernapasan,true);
		$criteria->compare('kesadaran',$this->kesadaran,true);
		$criteria->compare('petugas_id',$this->petugas_id);
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