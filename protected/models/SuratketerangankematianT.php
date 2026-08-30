<?php

/**
 * This is the model class for table "suratketerangankematian_t".
 *
 * The followings are the available columns in table 'suratketerangankematian_t':
 * @property integer $suratketerangankematian_id
 * @property integer $pendaftaran_id
 * @property string $pasien_nama
 * @property string $pasien_jeniskelamin
 * @property string $pasien_tanggal_lahir
 * @property string $pasien_no_rekam_medik
 * @property string $pasien_alamat
 * @property string $pasien_tempat_lahir
 * @property string $tanggal_meninggal
 * @property string $pemeriksa_pasienmeninggal
 * @property string $tanggal_pemeriksaan
 * @property string $jenis_pemeriksaan
 * @property string $penyebab_langsung
 * @property string $penyebab_yangmendasari
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property PendaftaranT $pendaftaran
 */
class SuratketerangankematianT extends CActiveRecord
{
        public $diagnosa_nama, $diagnosa_nama2;
        public $kondisikeluar_id, $dpjp_nama;
        
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'suratketerangankematian_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendaftaran_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pendaftaran_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('pemeriksa_pasienmeninggal, jenis_pemeriksaan', 'length', 'max'=>20),
			array('pasien_nama, pasien_jeniskelamin, pasien_tanggal_lahir, pasien_no_rekam_medik, pasien_alamat, pasien_tempat_lahir, tanggal_meninggal, tanggal_pemeriksaan, penyebab_langsung, penyebab_yangmendasari, update_time, tempat_meninggal', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('suratketerangankematian_id, pendaftaran_id, pasien_nama, pasien_jeniskelamin, pasien_tanggal_lahir, pasien_no_rekam_medik, pasien_alamat, pasien_tempat_lahir, tanggal_meninggal, pemeriksa_pasienmeninggal, tanggal_pemeriksaan, jenis_pemeriksaan, penyebab_langsung, penyebab_yangmendasari, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
                    'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),                    
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'suratketerangankematian_id' => 'Suratketerangankematian',
			'pendaftaran_id' => 'Pendaftaran',
			'pasien_nama' => 'Pasien Nama',
			'pasien_jeniskelamin' => 'Pasien Jeniskelamin',
			'pasien_tanggal_lahir' => 'Pasien Tanggal Lahir',
			'pasien_no_rekam_medik' => 'Pasien No Rekam Medik',
			'pasien_alamat' => 'Pasien Alamat',
			'pasien_tempat_lahir' => 'Pasien Tempat Lahir',
			'tanggal_meninggal' => 'Tanggal Meninggal',
			'pemeriksa_pasienmeninggal' => 'Pemeriksa Pasienmeninggal',
			'tanggal_pemeriksaan' => 'Tanggal Pemeriksaan',
			'jenis_pemeriksaan' => 'Jenis Pemeriksaan',
			'penyebab_langsung' => 'Penyebab Langsung',
			'penyebab_yangmendasari' => 'Penyebab Yangmendasari',
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

		$criteria->compare('suratketerangankematian_id',$this->suratketerangankematian_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasien_nama',$this->pasien_nama,true);
		$criteria->compare('pasien_jeniskelamin',$this->pasien_jeniskelamin,true);
		$criteria->compare('pasien_tanggal_lahir',$this->pasien_tanggal_lahir,true);
		$criteria->compare('pasien_no_rekam_medik',$this->pasien_no_rekam_medik,true);
		$criteria->compare('pasien_alamat',$this->pasien_alamat,true);
		$criteria->compare('pasien_tempat_lahir',$this->pasien_tempat_lahir,true);
		$criteria->compare('tanggal_meninggal',$this->tanggal_meninggal,true);
		$criteria->compare('pemeriksa_pasienmeninggal',$this->pemeriksa_pasienmeninggal,true);
		$criteria->compare('tanggal_pemeriksaan',$this->tanggal_pemeriksaan,true);
		$criteria->compare('jenis_pemeriksaan',$this->jenis_pemeriksaan,true);
		$criteria->compare('penyebab_langsung',$this->penyebab_langsung,true);
		$criteria->compare('penyebab_yangmendasari',$this->penyebab_yangmendasari,true);
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
	 * @return SuratketerangankematianT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public static function simpanData($model, $post){
            
            $pesan = '';
            $ok = true;
            
            $model->attributes = $post;
            $model->pasien_tanggal_lahir = !empty($model->pasien_tanggal_lahir)?MyFormatter::formatDateTimeForDb($model->pasien_tanggal_lahir):null;
            $model->tanggal_pemeriksaan = !empty($model->tanggal_pemeriksaan)?MyFormatter::formatDateTimeForDb($model->tanggal_pemeriksaan):null;            
            
            if (empty($model->suratketerangankematian_id)){
                $model->create_time = date('Y-m-d H:i:s');
                $model->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
            }else{
                $model->update_time = date('Y-m-d H:i:s');
                $model->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
            }
            
            $ok &= $model->save();
            
            if (!$ok){
                $pesan .= 'Data surat kematian gagal disimpan '.MyExceptionMessage::getErrorMessage($model);
            }
            
            
            return [
                'model'=>$model,
                'pesan'=>$pesan,
                'sukses'=>$ok
            ];                        
        }
        
        public function loadInput(){            
            $this->dpjp_nama = !empty($this->pendaftaran->pegawai)?$this->pendaftaran->pegawai->namaLengkap:'-';
        }
}
