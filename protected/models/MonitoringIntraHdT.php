<?php

/**
 * This is the model class for table "monitoring_intra_hd_t".
 *
 * The followings are the available columns in table 'monitoring_intra_hd_t':
 * @property integer $monitoring_intra_hd_id
 * @property integer $pasien_id
 * @property integer $pendaftaran_id
 * @property integer $dpjp_id
 * @property integer $perawat1_id
 * @property integer $perawat2_id
 * @property string $tanggal
 * @property string $akses_vaskular
 * @property boolean $heparinisasi_ya
 * @property string $heparinisasi_ya_dosis_awal
 * @property string $heparinisasi_ya_dosis_maintenan
 * @property boolean $heparinisasi_tidak
 * @property string $heparinisasi_tidak_per_jam
 * @property string $heparinisasi_tidak_per_setengah
 * @property double $jumlah_intake_nacl
 * @property double $jumlah_intake_lainnya
 * @property double $total_intake
 * @property double $jumlah_output_ufgoal
 * @property double $jumlah_output_lainnya
 * @property integer $total_output
 * @property string $create_time
 * @property string $update_time
 * @property integer $creale_login
 * @property integer $update_loginpemakai_id
 * @property integer $ruangan_id
 */
class MonitoringIntraHdT extends CActiveRecord
{
    public $dpjp_nama, $perawat1_nama, $perawat2_nama, $per_jam, $per_setengah;
    public $set_intra_det;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MonitoringIntraHdT the static model class
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
		return 'monitoring_intra_hd_t';
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
			array('monitoring_intra_hd_id, pasien_id, pendaftaran_id, dpjp_id, perawat1_id, perawat2_id, creale_login, update_loginpemakai_id, ruangan_id', 'numerical', 'integerOnly'=>true),
			array('jumlah_intake_nacl, jumlah_intake_lainnya, total_intake, jumlah_output_ufgoal, jumlah_output_lainnya, total_output', 'numerical'),
			array('akses_vaskular', 'length', 'max'=>100),
			array('heparinisasi_ya_dosis_awal, heparinisasi_ya_dosis_maintenan, heparinisasi_tidak_per_jam, heparinisasi_tidak_per_setengah', 'length', 'max'=>50),
			array('tanggal, heparinisasi_ya, heparinisasi_tidak, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('monitoring_intra_hd_id, pasien_id, pendaftaran_id, dpjp_id, perawat1_id, perawat2_id, tanggal, akses_vaskular, heparinisasi_ya, heparinisasi_ya_dosis_awal, heparinisasi_ya_dosis_maintenan, heparinisasi_tidak, heparinisasi_tidak_per_jam, heparinisasi_tidak_per_setengah, jumlah_intake_nacl, jumlah_intake_lainnya, total_intake, jumlah_output_ufgoal, jumlah_output_lainnya, total_output, create_time, update_time, creale_login, update_loginpemakai_id, ruangan_id', 'safe', 'on'=>'search'),
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
                    'dpjp' => array(self::BELONGS_TO, 'PegawaiM', 'dpjp_id'),
                    'perawat1' => array(self::BELONGS_TO, 'PegawaiM', 'perawat1_id'),
                    'perawat2' => array(self::BELONGS_TO, 'PegawaiM', 'perawat2_id'),
                    'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'monitoring_intra_hd_id' => 'Monitoring Intra Hd',
			'pasien_id' => 'Pasien',
			'pendaftaran_id' => 'Pendaftaran',
			'dpjp_id' => 'Dpjp',
			'perawat1_id' => 'Perawat1',
			'perawat2_id' => 'Perawat2',
			'tanggal' => 'Tanggal',
			'akses_vaskular' => 'Akses Vaskular',
			'heparinisasi_ya' => 'Heparinisasi Ya',
			'heparinisasi_ya_dosis_awal' => 'Heparinisasi Ya Dosis Awal',
			'heparinisasi_ya_dosis_maintenan' => 'Heparinisasi Ya Dosis Maintenan',
			'heparinisasi_tidak' => 'Heparinisasi Tidak',
			'heparinisasi_tidak_per_jam' => 'Heparinisasi Tidak Per Jam',
			'heparinisasi_tidak_per_setengah' => 'Heparinisasi Tidak Per Setengah',
			'jumlah_intake_nacl' => 'Jumlah Intake Nacl',
			'jumlah_intake_lainnya' => 'Jumlah Intake Lainnya',
			'total_intake' => 'Total Intake',
			'jumlah_output_ufgoal' => 'Jumlah Output Ufgoal',
			'jumlah_output_lainnya' => 'Jumlah Output Lainnya',
			'total_output' => 'Total Output',
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

		$criteria->compare('monitoring_intra_hd_id',$this->monitoring_intra_hd_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('dpjp_id',$this->dpjp_id);
		$criteria->compare('perawat1_id',$this->perawat1_id);
		$criteria->compare('perawat2_id',$this->perawat2_id);
		$criteria->compare('tanggal',$this->tanggal,true);
		$criteria->compare('akses_vaskular',$this->akses_vaskular,true);
		$criteria->compare('heparinisasi_ya',$this->heparinisasi_ya);
		$criteria->compare('heparinisasi_ya_dosis_awal',$this->heparinisasi_ya_dosis_awal,true);
		$criteria->compare('heparinisasi_ya_dosis_maintenan',$this->heparinisasi_ya_dosis_maintenan,true);
		$criteria->compare('heparinisasi_tidak',$this->heparinisasi_tidak);
		$criteria->compare('heparinisasi_tidak_per_jam',$this->heparinisasi_tidak_per_jam,true);
		$criteria->compare('heparinisasi_tidak_per_setengah',$this->heparinisasi_tidak_per_setengah,true);
		$criteria->compare('jumlah_intake_nacl',$this->jumlah_intake_nacl);
		$criteria->compare('jumlah_intake_lainnya',$this->jumlah_intake_lainnya);
		$criteria->compare('total_intake',$this->total_intake);
		$criteria->compare('jumlah_output_ufgoal',$this->jumlah_output_ufgoal);
		$criteria->compare('jumlah_output_lainnya',$this->jumlah_output_lainnya);
		$criteria->compare('total_output',$this->total_output);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('creale_login',$this->creale_login);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function loadIntraDet(){
            $load = [];
            if (!empty($this->monitoring_intra_hd_id)){
                $cri = new CDbCriteria();
                $cri->select = [
                    't.*',
                    'pen.penyulit_hd_nama'
                ];
                $cri->join = " LEFT JOIN penyulit_hd_m pen ON pen.penyulit_hd_id = t.penyulit_hd_id ";
                $cri->addCondition(" monitoring_intra_hd_id = ".$this->monitoring_intra_hd_id);
                $mod = MonitoringIntraHdDetT::model()->findAll($cri);
                                
                foreach($mod as $det){
                    $init = $det->jenis_observasi;
                    $init2 = $det->monitoring_intra_hd_det_id;
                    
                    $load[$init]['jenis'] = $det->jenis_observasi;
                    
                    $load[$init]['det'][$init2] = [
                        'jam_observasi' => $det->jam_observasi,
                        'blood_flow' => $det->blood_flow,
                        'uf_rate' => $det->uf_rate,
                        'tensi_sistolik' => $det->tensi_sistolik,
                        'tensi_diastolik' => $det->tensi_diastolik,
                        'nadi' => $det->nadi,
                        'suhu' => $det->suhu,
                        'respirasi' => $det->respirasi,
                        'penyulit_hd_nama' => $det->penyulit_hd_nama
                    ];
                }
            }
            
            return $load;
        }
}