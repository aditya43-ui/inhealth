<?php

/**
 * This is the model class for table "kantong_transfusi_darah_t".
 *
 * The followings are the available columns in table 'kantong_transfusi_darah_t':
 * @property integer $kantong_transfusi_darah_id
 * @property integer $pegawai_id
 * @property integer $pasien_id
 * @property integer $pendaftaran_id
 * @property string $waktu_darah_diterima
 * @property double $suhu_coolbox
 * @property string $create_time
 * @property string $update_time
 * @property integer $creale_login
 * @property integer $update_loginpemakai_id
 * @property integer $ruangan_id
 *
 * The followings are the available model relations:
 * @property PendaftaranT $pendaftaran
 * @property PasienM $pasien
 * @property PegawaiM $pegawai
 * @property ObatSebelumTransfusiT[] $obatSebelumTransfusiTs
 * @property KantongTransfusiDarahDetT[] $kantongTransfusiDarahDetTs
 */
class KantongTransfusiDarahT extends CActiveRecord
{
    public $nama_pegawai, $kantong_transfusi_darah_det_id;
    public $set_obat_sebelum_transfusi;
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KantongTransfusiDarahT the static model class
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
		return 'kantong_transfusi_darah_t';
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
			array('pegawai_id, pasien_id, pendaftaran_id, create_loginpemakai_id, update_loginpemakai_id, ruangan_id', 'numerical', 'integerOnly'=>true),
			array('suhu_coolbox', 'numerical'),
			array('waktu_darah_diterima, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('kantong_transfusi_darah_id, pegawai_id, pasien_id, pendaftaran_id, waktu_darah_diterima, suhu_coolbox, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, ruangan_id', 'safe', 'on'=>'search'),
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
			'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
			'obatSebelumTransfusiTs' => array(self::HAS_MANY, 'ObatSebelumTransfusiT', 'observasi_transfusi_darah_id'),
			'kantongTransfusiDarahDetTs' => array(self::HAS_MANY, 'KantongTransfusiDarahDetT', 'kantong_transfusi_darah_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'kantong_transfusi_darah_id' => 'Kantong Transfusi Darah',
			'pegawai_id' => 'Pegawai',
			'pasien_id' => 'Pasien',
			'pendaftaran_id' => 'Pendaftaran',
			'waktu_darah_diterima' => 'Waktu Darah Diterima',
			'suhu_coolbox' => 'Suhu Coolbox',
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

		$criteria->compare('kantong_transfusi_darah_id',$this->kantong_transfusi_darah_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('waktu_darah_diterima',$this->waktu_darah_diterima,true);
		$criteria->compare('suhu_coolbox',$this->suhu_coolbox);
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
         * load obat sebelum transfusi
         * @return type
         */
        public function loadObatSebelumTransfusi(){
            $load = null;
            
            //will be prosess, if observasi_transfusi_darah_id is not empty
            if (!empty($this->kantong_transfusi_darah_id)){
                $cri = new CDbCriteria();
                $cri->select = " nama_obat ";
                $cri->addCondition(" observasi_transfusi_darah_id = ".$this->kantong_transfusi_darah_id);
                                        
                $load = ObatSebelumTransfusiT::model()->findAll($cri);
            }                        
            
            return $load;
        }
}