<?php

/**
 * This is the model class for table "usulanpenghapusan_t".
 *
 * The followings are the available columns in table 'usulanpenghapusan_t':
 * @property integer $usulanpenghapusanaset_id
 * @property string $usulanpenghapusanaset_nomor
 * @property string $usulanpenghapusanaset_tanggal
 * @property integer $pegpengusul_id
 * @property integer $lokasi_id
 * @property integer $pegverifikasi_id
 * @property string $tanggal_verifikasi
 * @property integer $lokasisementara_id
 * @property integer $pengeluaranaset_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property UsulanpenghapusanasetdetT[] $usulanpenghapusanasetdetTs
 * @property PegawaiM $pegpengusul
 * @property LokasiasetM $lokasi
 * @property PengeluaranasetT $pengeluaranaset
 * @property LokasiasetM $lokasisementara
 * @property PegawaiM $pegverifikasi
 */
class UsulanpenghapusanT extends CActiveRecord
{
        public $pegpengusul_nama, $pegverifikasi_nama;
        public $lokasisementara_nama, $lokasiaset_namalokasi;
        public $jenis_transaksi;
                
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UsulanpenghapusanT the static model class
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
		return 'usulanpenghapusanaset_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('usulanpenghapusanaset_nomor, usulanpenghapusanaset_tanggal, pegpengusul_id, lokasi_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pegpengusul_id, lokasi_id, pegverifikasi_id, lokasisementara_id, pengeluaranaset_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('usulanpenghapusanaset_nomor', 'length', 'max'=>20),
			array('tanggal_verifikasi, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('usulanpenghapusanaset_id, usulanpenghapusanaset_nomor, usulanpenghapusanaset_tanggal, pegpengusul_id, lokasi_id, pegverifikasi_id, tanggal_verifikasi, lokasisementara_id, pengeluaranaset_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'usulanpenghapusanasetdetTs' => array(self::HAS_MANY, 'UsulanpenghapusanasetdetT', 'usulanpenghapusanaset_id'),
			'pegpengusul' => array(self::BELONGS_TO, 'PegawaiM', 'pegpengusul_id'),
			'lokasi' => array(self::BELONGS_TO, 'LokasiasetM', 'lokasi_id'),
			'pengeluaranaset' => array(self::BELONGS_TO, 'PengeluaranasetT', 'pengeluaranaset_id'),
			'lokasisementara' => array(self::BELONGS_TO, 'LokasiasetM', 'lokasisementara_id'),
			'pegverifikasi' => array(self::BELONGS_TO, 'PegawaiM', 'pegverifikasi_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'usulanpenghapusanaset_id' => 'Usulanpenghapusanaset',
			'usulanpenghapusanaset_nomor' => 'Nomor Usulan',
			'usulanpenghapusanaset_tanggal' => 'Tanggal Usulan',
			'pegpengusul_id' => 'Pegpengusul',
                        'pegpengusul_nama' => 'Pegawai Mengusulkan',
			'lokasi_id' => 'Lokasi',
                        'lokasiaset_namalokasi' => 'Lokasi Aset',
			'pegverifikasi_id' => 'Pegverifikasi',
                        'pegverifikasi_nama' => 'Pegawai Verifikasi',
			'tanggal_verifikasi' => 'Tanggal Verifikasi',
			'lokasisementara_id' => 'Lokasisementara',
			'pengeluaranaset_id' => 'Pengeluaranaset',
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

		$criteria->compare('usulanpenghapusanaset_id',$this->usulanpenghapusanaset_id);
		$criteria->compare('usulanpenghapusanaset_nomor',$this->usulanpenghapusanaset_nomor,true);
		$criteria->compare('usulanpenghapusanaset_tanggal',$this->usulanpenghapusanaset_tanggal,true);
		$criteria->compare('pegpengusul_id',$this->pegpengusul_id);
		$criteria->compare('lokasi_id',$this->lokasi_id);
		$criteria->compare('pegverifikasi_id',$this->pegverifikasi_id);
		$criteria->compare('tanggal_verifikasi',$this->tanggal_verifikasi,true);
		$criteria->compare('lokasisementara_id',$this->lokasisementara_id);
		$criteria->compare('pengeluaranaset_id',$this->pengeluaranaset_id);
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
         * 
         * @param type $model
         * @param type $post
         * @return type
         */
        public static function simpan_data($model,$post){
            $ok = true;
            $format = new MyFormatter();
            $pesan = '';
            
            $model->attributes = $post;
            $model->usulanpenghapusanaset_tanggal = !empty($model->usulanpenghapusanaset_tanggal)?$format->formatDateTimeForDb($model->usulanpenghapusanaset_tanggal):null;                        
            $model->tanggal_verifikasi = !empty($model->tanggal_verifikasi)?$format->formatDateTimeForDb($model->tanggal_verifikasi):null;                        
            
            if (empty($model->usulanpenghapusanaset_id)){
                $model->usulanpenghapusanaset_nomor = MyGenerator::noUsulanHapusAset();
                $model->create_time = date('Y-m-d H:i:s');
                $model->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');                
            }else{
                $model->update_time = date('Y-m-d H:i:s');
                $model->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
            }
            
            $ok &= $model->save();
            
            if (!$ok){
                $pesan .= '<br/>Usulan Penghapusan Aset :'.MyExceptionMessage::getErrorMessage($model);
            }else{
                if ($model->jenis_transaksi == 'verifikasi'){
                    $proses = $model->simpanPengeluaranAset();
                    $ok &= $proses['sukses'];
                    $pesan .= $proses['pesan'];
                    
                    $model->pengeluaranaset_id = $proses['model']->pengeluaranaset_id;
                    $ok &= $model->update();                                        
                }
            }
            
            $data['sukses'] = $ok;
            $data['model'] = $model;
            $data['pesan'] = $pesan;
            
            return $data;
        }
        
        public function simpanPengeluaranAset(){
            $ok = true;
            $format = new MyFormatter();
            $pesan = '';
            
            $model = new PengeluaranasetT;
            $model->tglpengeluaranaset = $this->tanggal_verifikasi;
            $model->nopengeluaranaset = $this->usulanpenghapusanaset_nomor;
            $model->kd_lokasi_kode = '130007050';
            $model->lokasiaset_kode = $this->lokasi->lokasiaset_kode;
            $model->lokasipenerima_kode = $this->lokasisementara->lokasiaset_kode;
            $model->penerimaaset = 'RSUD DR. SOETOMO';
            $model->jenisperuntukan = 'Rusak/Usang';
            $model->tglpenyerahan = $this->tanggal_verifikasi;
            $model->pegpengeluaran_id = $this->pegverifikasi_id;
            $model->pegmengetahui_id = $this->pegverifikasi_id;
            $model->lokasi_id = $this->lokasi_id;
            $model->ruangan_id = $this->lokasi->ruangan_id;            
            $model->create_time = date('Y-m-d H:i:s');
            $model->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
            $model->create_ruangan = Yii::app()->user->getState('ruangan_id');            
            
            $ok &= $model->save();
            
            if (!$ok){
                $pesan .= '<br/>Pengeluaran Aset :'.MyExceptionMessage::getErrorMessage($model);
            }
            
            $data['sukses'] = $ok;
            $data['model'] = $model;
            $data['pesan'] = $pesan;
            
            return $data;
        }
}