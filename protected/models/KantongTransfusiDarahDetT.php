<?php

/**
 * This is the model class for table "kantong_transfusi_darah_det_t".
 *
 * The followings are the available columns in table 'kantong_transfusi_darah_det_t':
 * @property integer $kantong_transfusi_darah_det_id
 * @property integer $kantong_transfusi_darah_id
 * @property integer $petugas_transfusi_id
 * @property integer $petugas_verifikasi_id
 * @property integer $jeniskomponendarah_id
 * @property integer $pendaftaran_id
 * @property integer $pasien_id
 * @property string $no_kantongdarah
 * @property integer $volume_darah
 * @property string $create_time
 * @property string $update_time
 * @property integer $creale_login
 * @property integer $update_loginpemakai_id
 * @property integer $ruangan_id
 *
 * The followings are the available model relations:
 * @property ObservasiTransfusiDarahT[] $observasiTransfusiDarahTs
 * @property PendaftaranT $pendaftaran
 * @property JeniskomponendarahM $jeniskomponendarah
 * @property PegawaiM $petugasVerifikasi
 * @property PegawaiM $petugasTransfusi
 * @property KantongTransfusiDarahT $kantongTransfusiDarah
 * @property PasienM $pasien
 */
class KantongTransfusiDarahDetT extends CActiveRecord
{
    public $petugas_transfusi_nama, $petugas_verifikasi_nama, $jeniskomponendarah_nama, $jeniskomponenedarah_nama, $namakomponendrh, $volume;
    public $set_observasi_dan_kantong_darah;    
        
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KantongTransfusiDarahDetT the static model class
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
		return 'kantong_transfusi_darah_det_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('create_time, create_loginpemakai_id, ruangan_id', 'required'),
			array('kantong_transfusi_darah_id, petugas_transfusi_id, petugas_verifikasi_id, jeniskomponendarah_id, pendaftaran_id, pasien_id, volume_darah, create_loginpemakai_id, update_loginpemakai_id, ruangan_id', 'numerical', 'integerOnly'=>true),
			array('no_kantongdarah', 'length', 'max'=>100),
			array('update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('kantong_transfusi_darah_det_id, kantong_transfusi_darah_id, petugas_transfusi_id, petugas_verifikasi_id, jeniskomponendarah_id, pendaftaran_id, pasien_id, no_kantongdarah, volume_darah, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, ruangan_id', 'safe', 'on'=>'search'),
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
			'observasiTransfusiDarahTs' => array(self::HAS_MANY, 'ObservasiTransfusiDarahT', 'kantong_transfusi_darah_det_id'),
			'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
			'jeniskomponendarah' => array(self::BELONGS_TO, 'JeniskomponendarahM', 'jeniskomponendarah_id'),
			'petugasVerifikasi' => array(self::BELONGS_TO, 'PegawaiM', 'petugas_verifikasi_id'),
			'petugasTransfusi' => array(self::BELONGS_TO, 'PegawaiM', 'petugas_transfusi_id'),
			'kantongTransfusiDarah' => array(self::BELONGS_TO, 'KantongTransfusiDarahT', 'kantong_transfusi_darah_id'),
			'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'kantong_transfusi_darah_det_id' => 'Kantong Transfusi Darah Det',
			'kantong_transfusi_darah_id' => 'Kantong Transfusi Darah',
			'petugas_transfusi_id' => 'Petugas Transfusi',
			'petugas_verifikasi_id' => 'Petugas Verifikasi',
			'jeniskomponendarah_id' => 'Jeniskomponendarah',
			'pendaftaran_id' => 'Pendaftaran',
			'pasien_id' => 'Pasien',
			'no_kantongdarah' => 'No Kantongdarah',
			'volume_darah' => 'Volume Darah',
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

		$criteria->compare('kantong_transfusi_darah_det_id',$this->kantong_transfusi_darah_det_id);
		$criteria->compare('kantong_transfusi_darah_id',$this->kantong_transfusi_darah_id);
		$criteria->compare('petugas_transfusi_id',$this->petugas_transfusi_id);
		$criteria->compare('petugas_verifikasi_id',$this->petugas_verifikasi_id);
		$criteria->compare('jeniskomponendarah_id',$this->jeniskomponendarah_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('no_kantongdarah',$this->no_kantongdarah,true);
		$criteria->compare('volume_darah',$this->volume_darah);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('creale_login',$this->creale_login);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        /**
         * find observasi and kantong darah
         * @return type
         */
        public function loadObservasiDanKantongDarah(){
            $load = [];
            
            //being executed, if kantong_transfusi_darah_det_id is not empty
            if (!empty($this->kantong_transfusi_darah_det_id)){
                $cri = new CDbCriteria();
                $cri->join = "  JOIN kantong_transfusi_darah_det_t kan_det ON kan_det.kantong_transfusi_darah_det_id = t.kantong_transfusi_darah_det_id "
                            . " LEFT JOIN jeniskomponendarah_m jkd ON jkd.jeniskomponendarah_id = kan_det.jeniskomponendarah_id "
                            . " LEFT JOIN pegawai_m pegtr ON pegtr.pegawai_id = kan_det.petugas_transfusi_id "
                            . " LEFT JOIN pegawai_m pegver ON pegver.pegawai_id = kan_det.petugas_verifikasi_id "
                            . " LEFT JOIN reaksi_transfusi_t rt ON rt.observasi_transfusi_darah_id = t.observasi_transfusi_darah_id "
                            . " LEFT JOIN pegawai_m pegobs ON pegobs.pegawai_id = t.petugas_observasi_id ";
                $cri->select = [
                    't.*',
                    'jkd.jeniskomponenedarah_nama as jeniskomponendarah_nama',
                    'kan_det.no_kantongdarah',
                    'kan_det.volume_darah',
                    'kan_det.kantong_transfusi_darah_id',
                    'pegtr.nama_pegawai as petugas_transfusi_nama',
                    'pegver.nama_pegawai as petugas_verifikasi_nama',
                    'rt.reaksi_transfusi_id',
                    'rt.nama_reaksi_transfusi',
                    'pegobs.nama_pegawai as petugas_observasi_nama'
                ];
                $cri->addCondition("kan_det.kantong_transfusi_darah_id = ".$this->kantong_transfusi_darah_id);
                
                
                $mod = ObservasiTransfusiDarahT::model()->findAll($cri);
                      
                foreach($mod as $det){
                    $init = $det->no_kantongdarah;
                    
                    if (!isset($load[$init])){
                        $load[$init] = [
                            'no_kantongdarah' => $det->no_kantongdarah,
                            'jeniskomponendarah_nama' => $det->jeniskomponendarah_nama,
                            'volume_darah' => $det->volume_darah,
                            'petugas_transfusi_nama' => $det->petugas_transfusi_nama,
                            'petugas_verifikasi_nama' => $det->petugas_verifikasi_nama,                            
                        ]; 
                    }
                    
                    $init2 = $det->observasi_transfusi_darah_id;
                                        
                    $load[$init]['obs'][$init2] = [
                        'tanggal_observasi' => $det->tanggal_observasi,
                        'jam_observasi' => $det->jam_observasi,
                        'keluhan' => $det->keluhan,
                        'kesadaran' => $det->kesadaran,
                        'tekanan_darah' => $det->tensi_sistolik.'/'.$det->tensi_diatolik,
                        'nadi' => $det->nadi,
                        'suhu' => $det->suhu,
                        'pernapasan' => $det->pernapasan,
                        'lainnya' => $det->lainnya,
                        'petugas_observasi_nama' => $det->petugas_observasi_nama
                            
                    ];
                    
                    $load[$init]['obs'][$init2]['reaksi'][$det->reaksi_transfusi_id] = $det->nama_reaksi_transfusi;
                }
            }
            
            return $load;
        }
}