<?php

/**
 * This is the model class for table "asesmenspiritual_ulangpasienrajal_t".
 *
 * The followings are the available columns in table 'asesmenspiritual_ulangpasienrajal_t':
 * @property integer $asesmenspiritual_ulangpasienrajal_id
 * @property integer $pendaftaran_id
 * @property integer $pasien_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property PendaftaranT $pendaftaran
 * @property PasienM $pasien
 */
class AsesmenspiritualUlangpasienrajalT extends CActiveRecord
{   
        public $default;
        public $ruangan_nama, $tanggal;
        
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'asesmenspiritual_ulangpasienrajal_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendaftaran_id, pasien_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pendaftaran_id, pasien_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('update_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('asesmenspiritual_ulangpasienrajal_id, pendaftaran_id, pasien_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'asesmenspiritual_ulangpasienrajal_id' => 'Asesmenspiritual Ulangpasienrajal',
			'pendaftaran_id' => 'Pendaftaran',
			'pasien_id' => 'Pasien',
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

		$criteria->compare('asesmenspiritual_ulangpasienrajal_id',$this->asesmenspiritual_ulangpasienrajal_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasien_id',$this->pasien_id);
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
	 * @return AsesmenspiritualUlangpasienrajalT the static model class
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
                $criteria->join = "  
                    JOIN asesmenspiritual_ulangpasienrajaldet_t det ON det.asesmenspiritual_ulangpasienrajal_id = t.asesmenspiritual_ulangpasienrajal_id 
                    JOIN ruangan_m r ON r.ruangan_id = det.ruangan_id
                ";                
		$criteria->select = $criteria->group = " det.tanggal, r.ruangan_nama, t.asesmenspiritual_ulangpasienrajal_id ";
		$criteria->compare('t.pendaftaran_id',$this->pendaftaran_id);

                if (!empty($this->default)){
                    $criteria->addCondition("t.asesmenspiritual_ulangpasienrajal_id is null");
                }
                
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
            
            if (empty($model->asesmenspiritual_ulangpasienrajal_id)){
                $model->create_time = date('Y-m-d H:i:s');
                $model->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');                
                $model->create_ruangan = Yii::app()->user->getState('create_ruangan');
            }else{
                $model->update_time = date('Y-m-d H:i:s');
                $model->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');                
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
}
