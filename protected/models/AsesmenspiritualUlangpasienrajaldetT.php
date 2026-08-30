<?php

/**
 * This is the model class for table "asesmenspiritual_ulangpasienrajaldet_t".
 *
 * The followings are the available columns in table 'asesmenspiritual_ulangpasienrajaldet_t':
 * @property integer $asesmenspiritual_ulangpasienrajaldet_id
 * @property integer $asesmenspiritual_ulangpasienrajal_id
 * @property integer $pendaftaran_id
 * @property integer $pasien_id
 * @property integer $ruangan_id
 * @property string $tanggal
 * @property string $diagnosaspiritual
 * @property boolean $wudhu
 * @property boolean $tayamum
 * @property boolean $sebelum_disiplin
 * @property boolean $sebelum_kadang
 * @property boolean $sebelum_tidakdisiplin
 * @property boolean $selama_disiplin
 * @property boolean $selama_kadang
 * @property boolean $selama_tidakdisiplin
 * @property string $masalahpsiko
 * @property string $rencanaedukasiislami
 * @property boolean $sumber_pasien
 * @property string $nama_pasien
 * @property boolean $sumber_keluarga
 * @property string $nama_keluarga
 * @property integer $petugas_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property PendaftaranT $pendaftaran
 * @property PasienM $pasien
 * @property RuanganM $ruangan
 * @property PegawaiM $petugas
 */
class AsesmenspiritualUlangpasienrajaldetT extends CActiveRecord
{
        public $ruangan_nama, $sumber;
        public $petugas_nama;
        public $rencanaedukasiislami_lain;
        public $jenis;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'asesmenspiritual_ulangpasienrajaldet_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('asesmenspiritual_ulangpasienrajal_id, pendaftaran_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('asesmenspiritual_ulangpasienrajal_id, pendaftaran_id, pasien_id, ruangan_id, petugas_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('nama_pasien', 'length', 'max'=>50),
			array('tanggal, diagnosaspiritual, wudhu, tayamum, sebelum_disiplin, sebelum_kadang, sebelum_tidakdisiplin, selama_disiplin, selama_kadang, selama_tidakdisiplin, masalahpsiko, rencanaedukasiislami, sumber_pasien, sumber_keluarga, nama_keluarga, update_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('asesmenspiritual_ulangpasienrajaldet_id, asesmenspiritual_ulangpasienrajal_id, pendaftaran_id, pasien_id, ruangan_id, tanggal, diagnosaspiritual, wudhu, tayamum, sebelum_disiplin, sebelum_kadang, sebelum_tidakdisiplin, selama_disiplin, selama_kadang, selama_tidakdisiplin, masalahpsiko, rencanaedukasiislami, sumber_pasien, nama_pasien, sumber_keluarga, nama_keluarga, petugas_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
			'ruangan' => array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
			'petugas' => array(self::BELONGS_TO, 'PegawaiM', 'petugas_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'asesmenspiritual_ulangpasienrajaldet_id' => 'Asesmenspiritual Ulangpasienrajaldet',
			'asesmenspiritual_ulangpasienrajal_id' => 'Asesmenspiritual Ulangpasienrajal',
			'pendaftaran_id' => 'Pendaftaran',
			'pasien_id' => 'Pasien',
			'ruangan_id' => 'Ruangan',
			'tanggal' => 'Tanggal',
			'diagnosaspiritual' => 'Diagnosaspiritual',
			'wudhu' => 'Wudhu',
			'tayamum' => 'Tayamum',
			'sebelum_disiplin' => 'Sebelum Disiplin',
			'sebelum_kadang' => 'Sebelum Kadang',
			'sebelum_tidakdisiplin' => 'Sebelum Tidakdisiplin',
			'selama_disiplin' => 'Selama Disiplin',
			'selama_kadang' => 'Selama Kadang',
			'selama_tidakdisiplin' => 'Selama Tidakdisiplin',
			'masalahpsiko' => 'Masalahpsiko',
			'rencanaedukasiislami' => 'Rencanaedukasiislami',
			'sumber_pasien' => 'Sumber Pasien',
			'nama_pasien' => 'Nama Pasien',
			'sumber_keluarga' => 'Sumber Keluarga',
			'nama_keluarga' => 'Nama Keluarga',
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

		$criteria->compare('asesmenspiritual_ulangpasienrajaldet_id',$this->asesmenspiritual_ulangpasienrajaldet_id);
		$criteria->compare('asesmenspiritual_ulangpasienrajal_id',$this->asesmenspiritual_ulangpasienrajal_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('tanggal',$this->tanggal,true);
		$criteria->compare('diagnosaspiritual',$this->diagnosaspiritual,true);
		$criteria->compare('wudhu',$this->wudhu);
		$criteria->compare('tayamum',$this->tayamum);
		$criteria->compare('sebelum_disiplin',$this->sebelum_disiplin);
		$criteria->compare('sebelum_kadang',$this->sebelum_kadang);
		$criteria->compare('sebelum_tidakdisiplin',$this->sebelum_tidakdisiplin);
		$criteria->compare('selama_disiplin',$this->selama_disiplin);
		$criteria->compare('selama_kadang',$this->selama_kadang);
		$criteria->compare('selama_tidakdisiplin',$this->selama_tidakdisiplin);
		$criteria->compare('masalahpsiko',$this->masalahpsiko,true);
		$criteria->compare('rencanaedukasiislami',$this->rencanaedukasiislami,true);
		$criteria->compare('sumber_pasien',$this->sumber_pasien);
		$criteria->compare('nama_pasien',$this->nama_pasien,true);
		$criteria->compare('sumber_keluarga',$this->sumber_keluarga);
		$criteria->compare('nama_keluarga',$this->nama_keluarga,true);
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

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AsesmenspiritualUlangpasienrajaldetT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public static function simpanData($model, $post, $multiple = false){
            
            $sukses = 1;
            $pesan = '';
          
            if (!$multiple){
                $modDet = $model;
                $modDet->attributes = $post;

                $modDet = self::set_audit($model, $modDet, $post);
                
                $sukses &= $modDet->save();

                if (!$sukses){
                    $pesan .= 'asesmen ulang detail <br/>:'.MyExceptionMessage::getErrorMessage($model);
                }
            }else{
                $mod = get_called_class();
                $modDet = [];
                
                foreach($post as $key => $val){
                    $modDet[$key] = new $mod;
                    if (!empty($val['asesmenspiritual_ulangpasienrajaldet_id'])){
                        $cek = $mod::model()->findByPk($val['asesmenspiritual_ulangpasienrajaldet_id']);
                        if (!empty($cek)){
                            $modDet[$key] = $cek;
                        }
                    }
                    $modDet[$key]->attributes = $val;      
                    
                    $modDet[$key] = self::set_audit($model, $modDet[$key], $val);

                    $sukses &= $modDet[$key]->save();

                    if (!$sukses){
                        $pesan .= 'asesmen ulang detail <br/>:'.MyExceptionMessage::getErrorMessage($modDet[$key]);
                    }                    
                }
            }
          
            return [
                'model' => $modDet,
                'sukses' => $sukses,
                'pesan' => $pesan
            ];
        }
        
        /**
        * 
        * @param type $model
        * @param type $modDet
        * @param type $post
        * @return type
        */
       public static function set_audit($model, $modDet, $post){                

           $modDet->attributes = $post; 
           $modDet->tanggal = !empty($modDet->tanggal)?MyFormatter::formatDateTimeForDb($modDet->tanggal):null;

           if (isset($post['sumber'])){
               if ($post['sumber'] == 'pasien'){
                   $modDet->sumber_pasien = true;
               }else if ($post['sumber'] == 'keluarga'){
                   $modDet->sumber_keluarga = true;
               }               
           }
           
           if (is_array($modDet->masalahpsiko)){
               $modDet->masalahpsiko = implode(", ", $modDet->masalahpsiko);
           }
           
           if (is_array($modDet->rencanaedukasiislami)){
               $modDet->rencanaedukasiislami = implode(", ", $modDet->rencanaedukasiislami);
           }
           
           
           if (!empty($post['rencanaedukasiislami_lain'])){
               $modDet->rencanaedukasiislami = str_replace('Lain-lain', $post['rencanaedukasiislami_lain'], $modDet->rencanaedukasiislami);
           }
           
                      
           
           if (empty($model->asesmenspiritual_ulangpasienrajaldet_id)){
               $modDet->create_time = date('Y-m-d H:i:s');
               $modDet->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
               $modDet->create_ruangan = Yii::app()->user->getState('ruangan_id');
           }else{
               $modDet->update_time = date('Y-m-d H:i:s');
               $modDet->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
           }

           return $modDet;
       }
       
       public function listPilihan(){
            $thoharoh = LookupM::getItemsUrutan('thaharoh');
            $sebelumsakit = LookupM::getItemsUrutan('sebelum_ibadah');                    
            $selamasakit = LookupM::getItemsUrutan('selama_ibadah');   
            $psiko = LookupM::model()->findAll("lookup_type = 'masalahpsiko' AND lookup_aktif = TRUE"); 
            $rencanaedukasi = LookupM::model()->findAll("lookup_type = 'rencanaedukasiislami' AND lookup_aktif = TRUE");
            
            return [
                'thoharoh'=> $thoharoh,
                'sebelumsakit'=> $sebelumsakit,
                'selamasakit'=> $selamasakit,
                'psiko'=> $psiko,
                'rencanaedukasi'=> $rencanaedukasi
            ];
       }
       
       public function loadInput(){
           $this->ruangan_nama = (!empty($this->ruangan)?$this->ruangan->ruangan_nama:'');
           $this->petugas_nama = (!empty($this->petugas)?$this->petugas->namaLengkap:'');
           $this->masalahpsiko = !empty($this->masalahpsiko)?explode(', ',$this->masalahpsiko):[];
           $this->rencanaedukasiislami = !empty($this->rencanaedukasiislami)?explode(', ',$this->rencanaedukasiislami):[];
           
           $rencanaedukasi = LookupM::model()->findAll("lookup_type = 'rencanaedukasiislami' AND lookup_aktif = TRUE");
           $listrencana = [];
           foreach($rencanaedukasi as $key => $val){
                $listrencana[$val->lookup_name] = $val->lookup_name;
           }
           
           $notlist = '';
           $list = [];
           foreach($this->rencanaedukasiislami as $key => $val){
               if (!in_array($val, $listrencana)){
                   $notlist = $val;
                   $list['Lain-lain'] = 'Lain-lain';
               }else{
                   $list[$val] = $val;
               }
           }
           $this->rencanaedukasiislami = $list;
           $this->rencanaedukasiislami_lain = $notlist;
       }
}
