<?php

/**
 * This is the model class for table "cpispasien_t".
 *
 * The followings are the available columns in table 'cpispasien_t':
 * @property integer $cpispasien_id
 * @property integer $pendaftaran_id
 * @property integer $pasienadmisi_id
 * @property string $tanggalpengkajian
 * @property integer $petugaspengkaji_id
 * @property integer $dpjp_id
 * @property string $total_skor
 * @property string $monitoring_petugas
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai
 * @property string $update_loginpemakai
 * @property integer $create_petugaspengisi_id
 * @property integer $create_ruangan_id
 *
 * The followings are the available model relations:
 * @property CpispasiendetT $cpispasiendetT
 * @property PegawaiM $dpjp
 * @property PasienadmisiT $pasienadmisi
 * @property PendaftaranT $pendaftaran
 * @property PegawaiM $petugaspengkaji
 */
class CpispasienT extends CActiveRecord
{
        public $default, $setLoadCpisPoint;
        public $petugaspengkaji_nama;
        public $allHasilKultur, $det;
        public $gelardepan, $gelarbelakang_nama;
        
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cpispasien_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendaftaran_id, tanggalpengkajian, petugaspengkaji_id, dpjp_id, create_time, create_loginpemakai', 'required'),
			array('pendaftaran_id, pasienadmisi_id, petugaspengkaji_id, dpjp_id, create_petugaspengisi_id, create_ruangan_id', 'numerical', 'integerOnly'=>true),
			array('total_skor', 'length', 'max'=>50),
			array('monitoring_petugas', 'length', 'max'=>200),
			array('create_loginpemakai, update_loginpemakai', 'length', 'max'=>100),
			array('update_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('cpispasien_id, pendaftaran_id, pasienadmisi_id, tanggalpengkajian, petugaspengkaji_id, dpjp_id, total_skor, monitoring_petugas, create_time, update_time, create_loginpemakai, update_loginpemakai, create_petugaspengisi_id, create_ruangan_id', 'safe', 'on'=>'search'),
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
			'cpispasiendetT' => array(self::HAS_ONE, 'CpispasiendetT', 'cpispasien_id'),
			'dpjp' => array(self::BELONGS_TO, 'PegawaiM', 'dpjp_id'),
			'pasienadmisi' => array(self::BELONGS_TO, 'PasienadmisiT', 'pasienadmisi_id'),
			'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
			'petugaspengkaji' => array(self::BELONGS_TO, 'PegawaiM', 'petugaspengkaji_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'cpispasien_id' => 'Cpispasien',
			'pendaftaran_id' => 'Pendaftaran',
			'pasienadmisi_id' => 'Pasienadmisi',
			'tanggalpengkajian' => 'Hari/ Tanggal Pemantauan',
			'petugaspengkaji_id' => 'Nama Perawat',
			'dpjp_id' => 'Dpjp',
			'total_skor' => 'Total Skor',
			'monitoring_petugas' => 'Monitoring Petugas',
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

		$criteria->compare('cpispasien_id',$this->cpispasien_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('tanggalpengkajian',$this->tanggalpengkajian,true);
		$criteria->compare('petugaspengkaji_id',$this->petugaspengkaji_id);
		$criteria->compare('dpjp_id',$this->dpjp_id);
		$criteria->compare('total_skor',$this->total_skor,true);
		$criteria->compare('monitoring_petugas',$this->monitoring_petugas,true);
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

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CpispasienT the static model class
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
                    'tanggalpengkajian',
                    'cpispasien_id'
                ];
		
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);		

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
            $model->tanggalpengkajian = !empty($model->tanggalpengkajian)?$format->formatDateTimeForDb($model->tanggalpengkajian):null;
            
            if (empty($model->cpispasien_id)){
                $model->create_time = date('Y-m-d H:i:s');
                $model->create_loginpemakai = Yii::app()->user->getState('loginpemakai_id');
                $model->create_petugaspengisi_id = Yii::app()->user->getState('pegawai_id');
                $model->create_ruangan_id = Yii::app()->user->getState('create_ruangan');
            }else{
                $model->update_time = date('Y-m-d H:i:s');
                $model->update_loginpemakai = Yii::app()->user->getState('loginpemakai_id');                
            }
            
            $sukses &= $model->save();
            
            if (!$sukses){
                $pesan .= 'CPIS pasien <br/>:'.MyExceptionMessage::getErrorMessage($model);
            }
            
            return [
                'sukses' => $sukses,
                'pesan' => $pesan,
                'model' => $model
            ];
        }
        
        public function loadInput(){
            $this->petugaspengkaji_nama = !empty($this->petugaspengkaji)?$this->petugaspengkaji->namaLengkap:'';
        }
        
        public function listRiwayatByDaftarId(){
            $this->allHasilKultur = '';
            
            $kultur = [];
            $res = [];
            if (!empty($this->pendaftaran_id)){
                $cri = new CDbCriteria;   
                $cri->select = [
                    "t.*",
                    "peg.gelardepan",
                    "peg.nama_pegawai as petugaspengkaji_nama",
                    "gelar.gelarbelakang_nama"
                ];
                $cri->join = " LEFT JOIN pegawai_m peg ON peg.pegawai_id = t.petugaspengkaji_id "
                           . " LEFT JOIN gelarbelakang_m gelar ON gelar.gelarbelakang_id = peg.gelarbelakang_id ";
                $cri->addCondition(" pendaftaran_id = ".$this->pendaftaran_id);
                
                $model = self::model()->findAll($cri);
                
                foreach($model as $key => $val){                    
                    $res[$val->cpispasien_id] = $val;
                    $res[$val->cpispasien_id]->petugaspengkaji_nama = $val->gelardepan.' '.$val->petugaspengkaji_nama.' '.$val->gelarbelakang_nama;
                    
                    $det = new CpispasiendetT;
                    $det->cpispasien_id = $val->cpispasien_id;

                    $dettes = [];                    
                    foreach($det->loadDetail() as $k => $v){
                        $init = $v->cpispasien_id;
                        $initDet = $v->cpispasiendet_id;

                        $res[$init]->det[$initDet] = $v;                       
                        $kultur[$v->hasil_kultur] = $v->hasil_kultur;
                    }
                }
                
                $this->allHasilKultur = implode(', ', $kultur);
            }                      
            
            return $res;
        }                
}
