<?php

/**
 * This is the model class for table "ekstubasipasien_t".
 *
 * The followings are the available columns in table 'ekstubasipasien_t':
 * @property integer $ekstubasipasien_id
 * @property integer $pasien_id
 * @property integer $diagnosa_id
 * @property string $ket_diagnosa
 * @property string $tgl_tindakan
 * @property integer $dpjp_id
 * @property integer $dokteranestesi_id
 * @property integer $perawatjaga_id
 * @property boolean $pasiensadar
 * @property boolean $analisagas
 * @property boolean $modepernafasan
 * @property boolean $hemodinamik
 * @property boolean $pasienkooperatif
 * @property boolean $refleksbatuk
 * @property boolean $tidakadaperdarahan
 * @property boolean $pasiendipuasakan
 * @property boolean $sepengetahuankonsultan
 * @property boolean $sudahvisualisasi
 * @property boolean $alatdanobatsiap
 *
 * The followings are the available model relations:
 * @property PasienM $pasien
 * @property PegawaiM $dpjp
 * @property PegawaiM $perawatjaga
 */
class EkstubasipasienT extends CActiveRecord
{
        public $nama_pasien, $dpjp_nama, $diagnosa_nama;
        public $dokterjaga_nama, $dokteranestesi_nama, $perawatjaga_nama;
        public $default;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ekstubasipasien_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasien_id, diagnosa_id, dpjp_id, dokteranestesi_id, perawatjaga_id', 'required'),
			array('pasien_id, diagnosa_id, dpjp_id, dokteranestesi_id, perawatjaga_id', 'numerical', 'integerOnly'=>true),
			array('dokterjaga_id, ket_diagnosa, tgl_tindakan, pasiensadar, analisagas, modepernafasan, hemodinamik, pasienkooperatif, refleksbatuk, tidakadaperdarahan, pasiendipuasakan, sepengetahuankonsultan, sudahvisualisasi, alatdanobatsiap', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('ekstubasipasien_id, pasien_id, diagnosa_id, ket_diagnosa, tgl_tindakan, dpjp_id, dokteranestesi_id, perawatjaga_id, pasiensadar, analisagas, modepernafasan, hemodinamik, pasienkooperatif, refleksbatuk, tidakadaperdarahan, pasiendipuasakan, sepengetahuankonsultan, sudahvisualisasi, alatdanobatsiap', 'safe', 'on'=>'search'),
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
                    'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
                    'dpjp' => array(self::BELONGS_TO, 'PegawaiM', 'dpjp_id'),
                    'perawatjaga' => array(self::BELONGS_TO, 'PegawaiM', 'perawatjaga_id'),
                    'dokterjaga' => array(self::BELONGS_TO, 'PegawaiM', 'dokterjaga_id'),
                    'dokteranestesi' => array(self::BELONGS_TO, 'PegawaiM', 'dokteranestesi_id'),
                    'diagnosa' => array(self::BELONGS_TO, 'DiagnosaM', 'diagnosa_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ekstubasipasien_id' => 'Ekstubasipasien',
			'pasien_id' => 'Pasien',
			'diagnosa_id' => 'Diagnosa',
			'ket_diagnosa' => 'Ket Diagnosa',
			'tgl_tindakan' => 'Tgl Tindakan',
			'dpjp_id' => 'Dpjp',
			'dokteranestesi_id' => 'Dokter Anestesi',
			'perawatjaga_id' => 'Perawat Jaga',
			'pasiensadar' => 'Pasiensadar',
			'analisagas' => 'Analisagas',
			'modepernafasan' => 'Modepernafasan',
			'hemodinamik' => 'Hemodinamik',
			'pasienkooperatif' => 'Pasienkooperatif',
			'refleksbatuk' => 'Refleksbatuk',
			'tidakadaperdarahan' => 'Tidakadaperdarahan',
			'pasiendipuasakan' => 'Pasiendipuasakan',
			'sepengetahuankonsultan' => 'Sepengetahuankonsultan',
			'sudahvisualisasi' => 'Sudahvisualisasi',
			'alatdanobatsiap' => 'Alatdanobatsiap',
                        'diagnosa_nama' => 'Diagnosa',
                        'nama_pasien' => 'Nama Pasien',
                        'dpjp_id' => 'DPJP',
                        'dokterjaga_id' => 'Dokter Jaga'
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

		$criteria->compare('ekstubasipasien_id',$this->ekstubasipasien_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('diagnosa_id',$this->diagnosa_id);
		$criteria->compare('ket_diagnosa',$this->ket_diagnosa,true);
		$criteria->compare('tgl_tindakan',$this->tgl_tindakan,true);
		$criteria->compare('dpjp_id',$this->dpjp_id);
		$criteria->compare('dokteranestesi_id',$this->dokteranestesi_id);
		$criteria->compare('perawatjaga_id',$this->perawatjaga_id);
		$criteria->compare('pasiensadar',$this->pasiensadar);
		$criteria->compare('analisagas',$this->analisagas);
		$criteria->compare('modepernafasan',$this->modepernafasan);
		$criteria->compare('hemodinamik',$this->hemodinamik);
		$criteria->compare('pasienkooperatif',$this->pasienkooperatif);
		$criteria->compare('refleksbatuk',$this->refleksbatuk);
		$criteria->compare('tidakadaperdarahan',$this->tidakadaperdarahan);
		$criteria->compare('pasiendipuasakan',$this->pasiendipuasakan);
		$criteria->compare('sepengetahuankonsultan',$this->sepengetahuankonsultan);
		$criteria->compare('sudahvisualisasi',$this->sudahvisualisasi);
		$criteria->compare('alatdanobatsiap',$this->alatdanobatsiap);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return EkstubasipasienT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        /**
         * 
         */
        public function searchRiwayat()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
                $criteria->select = [
                    'tgl_tindakan',
                    'ekstubasipasien_id'
                ];
		
		$criteria->compare('pasien_id',$this->pasien_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        /**
         * 
         */
        public static function simpanData($model, $post){
            
            $format = new MyFormatter;
            $pesan = '';
            $sukses = true;
            
            $model->attributes = $post;
            $model->tgl_tindakan = !empty($model->tgl_tindakan)?$format->formatDateTimeForDb($model->tgl_tindakan):null;
                       
            
            $sukses &= $model->save();
            
            if (!$sukses){
                $pesan .= 'ekstubasi pasien <br/>:'.MyExceptionMessage::getErrorMessage($model);
            }
            
            return [
                'sukses' => $sukses,
                'pesan' => $pesan,
                'model' => $model
            ];
        }
        
        public function loadInput(){
            $this->dpjp_nama = !empty($this->dpjp)?$this->dpjp->namaLengkap:'';
            $this->perawatjaga_nama = !empty($this->perawatjaga)?$this->perawatjaga->namaLengkap:'';
            $this->dokteranestesi_nama = !empty($this->dokteranestesi)?$this->dokteranestesi->namaLengkap:'';
            $this->dokterjaga_nama = !empty($this->dokterjaga)?$this->dokterjaga->namaLengkap:'';
            $this->nama_pasien = !empty($this->pasien)?$this->pasien->nama_pasien:'';
            $this->diagnosa_nama = !empty($this->diagnoas)?$this->diagnosa->diagnosa_nama:'';
        }
}
