<?php

/**
 * This is the model class for table "resepturok_t".
 *
 * The followings are the available columns in table 'resepturok_t':
 * @property integer $resepturok_id
 * @property integer $pasienmasukpenunjang_id
 * @property integer $pendaftaran_id
 * @property integer $petugasfarmasi_id
 * @property integer $penjualanresep_id
 * @property string $noresep_ok
 * @property string $tglresep_ok
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $create_ruangan
 */
class ResepturokT extends CActiveRecord
{

	public $nama_pasien, $paket_obat;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'resepturok_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasienmasukpenunjang_id, pendaftaran_id, petugasfarmasi_id, noresep_ok, tglresep_ok', 'required'),
			array('pasienmasukpenunjang_id, pendaftaran_id, petugasfarmasi_id, penjualanresep_id, create_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('noresep_ok', 'length', 'max'=>50),
			array('update_time', 'safe'),

			array('create_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'insert'),
			array('update_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'update,insert'),
			array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
			array('create_ruangan','default','value'=>Yii::app()->user->getState('ruangan_id'),'on'=>'insert'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('resepturok_id, pasienmasukpenunjang_id, pendaftaran_id, petugasfarmasi_id, penjualanresep_id, noresep_ok, tglresep_ok, create_time, update_time, create_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'petugasfarmasi'=>array(self::BELONGS_TO, 'PegawaiM', 'petugasfarmasi_id'),
			'pendaftaran'=>array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),

		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'resepturok_id' => 'Resepturok',
			'pasienmasukpenunjang_id' => 'Pasienmasukpenunjang',
			'pendaftaran_id' => 'Pendaftaran',
			'petugasfarmasi_id' => 'Petugas Farmasi',
			'penjualanresep_id' => 'Penjualanresep',
			'noresep_ok' => 'Noresep Ok',
			'tglresep_ok' => 'Tglresep Ok',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
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

		$criteria->compare('resepturok_id',$this->resepturok_id);
		$criteria->compare('pasienmasukpenunjang_id',$this->pasienmasukpenunjang_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('petugasfarmasi_id',$this->petugasfarmasi_id);
		$criteria->compare('penjualanresep_id',$this->penjualanresep_id);
		$criteria->compare('noresep_ok',$this->noresep_ok,true);
		$criteria->compare('tglresep_ok',$this->tglresep_ok,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ResepturokT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getDokterItems($ruangan_id=null){
		if (Yii::app()->user->getState('dokterruangan')==false){
			if(empty($ruangan_id))
				$ruangan_id = Yii::app()->user->getState('ruangan_id');
			if(!empty($ruangan_id))
				return DokterV::model()->findAllByAttributes(array('pegawai_aktif'=>true,'ruangan_id'=>$ruangan_id),array('order'=>'nama_pegawai'));
			else
				return array();
		}else{
			//criteria disamakan dengan dokter_v
			$criteria = new CDbCriteria();
			$criteria->addInCondition('kelompokpegawai_id', array(Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK, Params::KELOMPOKPEGAWAI_ID_PARAMEDIS_KEPERAWATAN));
			$criteria->addCondition("pegawai_aktif = TRUE");
			$criteria->order = 'nama_pegawai';
			return PegawaiM::model()->findAll($criteria);
		}
	}
}
