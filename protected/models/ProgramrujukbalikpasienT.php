<?php

/**
 * This is the model class for table "programrujukbalikpasien_t".
 *
 * The followings are the available columns in table 'programrujukbalikpasien_t':
 * @property integer $programrujukbalikpasien_id
 * @property integer $pendaftaran_id
 * @property integer $sep_id
 * @property string $tglbuat_prb
 * @property string $programprb_kode
 * @property string $programprb_nama
 * @property integer $dpjp_id
 * @property string $saran
 * @property string $keterangan
 * @property string $user_pembuat
 * @property string $nosrb
 * @property string $tglsrb
 * @property string $no_telepon_peserta
 * @property string $respon_bridging
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan_id
 *
 * The followings are the available model relations:
 * @property PendaftaranT $pendaftaran
 * @property ObatprogramrujukbalikpasienT[] $obatprogramrujukbalikpasienTs
 */
class ProgramrujukbalikpasienT extends CActiveRecord
{
        public $dpjp_nama, $diagnosabpjskode;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'programrujukbalikpasien_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendaftaran_id, sep_id, tglbuat_prb, programprb_kode, programprb_nama, dpjp_id, user_pembuat, create_time, create_loginpemakai_id, alamatemail', 'required'),
			array('pendaftaran_id, sep_id, dpjp_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan_id', 'numerical', 'integerOnly'=>true),
			array('programprb_kode', 'length', 'max'=>20),
			array('programprb_nama, user_pembuat, nosrb', 'length', 'max'=>200),
			array('saran, keterangan, tglsrb, no_telepon_peserta, respon_bridging, update_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('programrujukbalikpasien_id, pendaftaran_id, sep_id, tglbuat_prb, programprb_kode, programprb_nama, dpjp_id, saran, keterangan, user_pembuat, nosrb, tglsrb, no_telepon_peserta, respon_bridging, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan_id, alamatemail', 'safe', 'on'=>'search'),
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
			'obatprogramrujukbalikpasienTs' => array(self::HAS_MANY, 'ObatprogramrujukbalikpasienT', 'programrujukbalikpasien_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'programrujukbalikpasien_id' => 'Programrujukbalikpasien',
			'pendaftaran_id' => 'Pendaftaran',
			'sep_id' => 'Sep',
			'tglbuat_prb' => 'Tglbuat Prb',
			'programprb_kode' => 'Programprb Kode',
			'programprb_nama' => 'Programprb Nama',
			'dpjp_id' => 'Dpjp',
			'saran' => 'Saran',
			'keterangan' => 'Keterangan',
			'user_pembuat' => 'User Pembuat',
			'nosrb' => 'Nosrb',
			'tglsrb' => 'Tglsrb',
			'no_telepon_peserta' => 'No Telepon Peserta',
			'respon_bridging' => 'Respon Bridging',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan_id' => 'Create Ruangan',
			'alamatemail' => 'Email'
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

		$criteria->compare('programrujukbalikpasien_id',$this->programrujukbalikpasien_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('sep_id',$this->sep_id);
		$criteria->compare('tglbuat_prb',$this->tglbuat_prb,true);
		$criteria->compare('programprb_kode',$this->programprb_kode,true);
		$criteria->compare('programprb_nama',$this->programprb_nama,true);
		$criteria->compare('dpjp_id',$this->dpjp_id);
		$criteria->compare('saran',$this->saran,true);
		$criteria->compare('keterangan',$this->keterangan,true);
		$criteria->compare('user_pembuat',$this->user_pembuat,true);
		$criteria->compare('nosrb',$this->nosrb,true);
		$criteria->compare('tglsrb',$this->tglsrb,true);
		$criteria->compare('no_telepon_peserta',$this->no_telepon_peserta,true);
		$criteria->compare('respon_bridging',$this->respon_bridging,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan_id',$this->create_ruangan_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ProgramrujukbalikpasienT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public static function simpanData($model, $post){
            $ok = true;
            $pesan = '';
            
            $model->attributes = $post;
            $model->tglbuat_prb = !empty($model->tglbuat_prb)?MyFormatter::formatDateTimeForDb($model->tglbuat_prb):null;
            $model->tglsrb = !empty($model->tglsrb)?MyFormatter::formatDateTimeForDb($model->tglsrb):null;
            
            if (empty($model->programrujukbalikpasien_id)){
                $model->create_time = date('Y-m-d H:i:s');
                $model->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                $model->create_ruangan_id = Yii::app()->user->getState('ruangan_id');
            }else{
                $model->update_time = date('Y-m-d H:i:s');
                $model->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');                
            }
            
            $ok &= $model->save();
            
            if (!$ok) {
                $pesan .= '<br/>program rujuk balik : ' . MyExceptionMessage::getErrorMessage($model);
            }
            
            $data['sukses'] = $ok;
            $data['model'] = $model;
            $data['pesan'] = $pesan;
            
            return $data;
        }
}
