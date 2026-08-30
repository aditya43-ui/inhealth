<?php

/**
 * This is the model class for table "laporanoperasi_t".
 *
 * The followings are the available columns in table 'laporanoperasi_t':
 * @property integer $laporanoperasi_id
 * @property integer $pasien_id
 * @property integer $pendaftaran_id
 * @property integer $pasienadmisi_id
 * @property integer $pasienmasukpenunjang_id
 * @property integer $rencanaoperasi_id
 * @property boolean $is_cyto
 * @property integer $operasi_id
 * @property string $golonganoperasi_keterangan
 * @property string $jenis_anestesi
 * @property boolean $is_dikirimpemeriksaan
 * @property boolean $is_pa
 * @property boolean $is_vc
 * @property boolean $is_kultur
 * @property boolean $is_analisa
 * @property string $jaringan
 * @property string $drain
 * @property string $alatimplan
 * @property string $perdarahan
 * @property string $persiapanoperasi
 * @property string $posisipasien
 * @property string $desinfeksi
 * @property string $insisikulit
 * @property string $pendapataneksplorasi
 * @property string $deskripsioeprasi
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property OperasiM $operasi
 * @property PasienM $pasien
 * @property PasienadmisiT $pasienadmisi
 * @property PasienmasukpenunjangT $pasienmasukpenunjang
 * @property PendaftaranT $pendaftaran
 * @property RencanaoperasiT $rencanaoperasi
 */
class LaporanoperasiT extends CActiveRecord
{
	public $tglrencanoeprasi, $kirimpemeriksaanket;
        public $setLoadDiagnosaX, $setLoadDiagnosaIX;
        public $dokterpelaksana1_id, $dokterpelaksana2_id;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'laporanoperasi_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasien_id, pendaftaran_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pasien_id, pendaftaran_id, pasienadmisi_id, pasienmasukpenunjang_id, rencanaoperasi_id, operasi_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('golonganoperasi_keterangan, jenis_anestesi', 'length', 'max'=>50),
			array('jaringan, drain, alatimplan, perdarahan', 'length', 'max'=>100),
			array('dokterpelaksana_id, pasienmasukpenunjang_id, is_cyto, is_dikirimpemeriksaan, is_pa, is_vc, is_kultur, is_analisa, persiapanoperasi, posisipasien, desinfeksi, insisikulit, pendapataneksplorasi, deskripsioeprasi, update_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('laporanoperasi_id, pasien_id, pendaftaran_id, pasienadmisi_id, pasienmasukpenunjang_id, rencanaoperasi_id, is_cyto, operasi_id, golonganoperasi_keterangan, jenis_anestesi, is_dikirimpemeriksaan, is_pa, is_vc, is_kultur, is_analisa, jaringan, drain, alatimplan, perdarahan, persiapanoperasi, posisipasien, desinfeksi, insisikulit, pendapataneksplorasi, deskripsioeprasi, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
                    'operasi' => array(self::BELONGS_TO, 'OperasiM', 'operasi_id'),
                    'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
                    'pasienadmisi' => array(self::BELONGS_TO, 'PasienadmisiT', 'pasienadmisi_id'),
                    'pasienmasukpenunjang' => array(self::BELONGS_TO, 'PasienmasukpenunjangT', 'pasienmasukpenunjang_id'),
                    'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
                    'rencanaoperasi' => array(self::BELONGS_TO, 'RencanaoperasiT', 'rencanaoperasi_id'),
                    'dokterpelaksana' => array(self::BELONGS_TO, 'PegawaiM', 'dokterpelaksana_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'laporanoperasi_id' => 'Laporanoperasi',
			'pasien_id' => 'Pasien',
			'pendaftaran_id' => 'Pendaftaran',
			'pasienadmisi_id' => 'Pasienadmisi',
			'pasienmasukpenunjang_id' => 'Pasienmasukpenunjang',
			'rencanaoperasi_id' => 'Rencanaoperasi',
			'is_cyto' => 'Is Cyto',
			'operasi_id' => 'Operasi',
			'golonganoperasi_keterangan' => 'Golonganoperasi Keterangan',
			'jenis_anestesi' => 'Jenis Anestesi',
			'is_dikirimpemeriksaan' => 'Is Dikirimpemeriksaan',
			'is_pa' => 'Is Pa',
			'is_vc' => 'Is Vc',
			'is_kultur' => 'Is Kultur',
			'is_analisa' => 'Is Analisa',
			'jaringan' => 'Jaringan',
			'drain' => 'Drain',
			'alatimplan' => 'Alatimplan',
			'perdarahan' => 'Perdarahan',
			'persiapanoperasi' => 'Persiapanoperasi',
			'posisipasien' => 'Posisipasien',
			'desinfeksi' => 'Desinfeksi',
			'insisikulit' => 'Insisikulit',
			'pendapataneksplorasi' => 'Pendapataneksplorasi',
			'deskripsioeprasi' => 'Deskripsioeprasi',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
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

		$criteria->compare('laporanoperasi_id',$this->laporanoperasi_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('pasienmasukpenunjang_id',$this->pasienmasukpenunjang_id);
		$criteria->compare('rencanaoperasi_id',$this->rencanaoperasi_id);
		$criteria->compare('is_cyto',$this->is_cyto);
		$criteria->compare('operasi_id',$this->operasi_id);
		$criteria->compare('golonganoperasi_keterangan',$this->golonganoperasi_keterangan,true);
		$criteria->compare('jenis_anestesi',$this->jenis_anestesi,true);
		$criteria->compare('is_dikirimpemeriksaan',$this->is_dikirimpemeriksaan);
		$criteria->compare('is_pa',$this->is_pa);
		$criteria->compare('is_vc',$this->is_vc);
		$criteria->compare('is_kultur',$this->is_kultur);
		$criteria->compare('is_analisa',$this->is_analisa);
		$criteria->compare('jaringan',$this->jaringan,true);
		$criteria->compare('drain',$this->drain,true);
		$criteria->compare('alatimplan',$this->alatimplan,true);
		$criteria->compare('perdarahan',$this->perdarahan,true);
		$criteria->compare('persiapanoperasi',$this->persiapanoperasi,true);
		$criteria->compare('posisipasien',$this->posisipasien,true);
		$criteria->compare('desinfeksi',$this->desinfeksi,true);
		$criteria->compare('insisikulit',$this->insisikulit,true);
		$criteria->compare('pendapataneksplorasi',$this->pendapataneksplorasi,true);
		$criteria->compare('deskripsioeprasi',$this->deskripsioeprasi,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LaporanoperasiT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function searchRiwayat()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}
		if(!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id = '.$this->pasien_id);
		}

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function dropListPasienKirimByPasien(){
            $res = [];
            $format = new MyFormatter;
            if (!empty($this->pasien_id)){
                $load = PasienkirimkeunitlainT::model()->findAll(" pasien_id = ".$this->pasien_id." AND pasienmasukpenunjang_id IS NOT NULL");
                
                foreach($load as $k => $v){
                    $init = $v->pasienmasukpenunjang_id;
                    $res[$init] = 'Permintaan Bedah Tanggal - '.$format->formatDateTimeForUser($v->tgl_kirimpasien);
                }
            }
            
            return $res;
        }
        
        public function dropListDoterBedah(){
            $res = [];
            if (!empty($this->dokterpelaksana1_id) || !empty($this->dokterpelaksana2_id)){
                $cri = new CDbCriteria;
                $cri->addInCondition("pegawai_id", [$this->dokterpelaksana1_id, $this->dokterpelaksana2_id]);
                $load = PegawaiV::model()->findAll($cri);
                
                foreach($load as $k => $v){
                    $res[$v->pegawai_id] = $v->namaLengkap;
                }
            }
            
            return $res;
        }
	
}
