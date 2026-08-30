<?php

/**
 * This is the model class for table "balancecairan_t".
 *
 * The followings are the available columns in table 'balancecairan_t':
 * @property integer $balancecairan_id
 * @property integer $pasienadmisi_id
 * @property integer $pasien_id
 * @property string $tanggal_pencatatan
 * @property integer $petugas_pengisi
 * @property string $tindakan_pasien
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai
 * @property string $update_loginpemakai
 * @property integer $create_ruangan_id
 *
 * The followings are the available model relations:
 * @property PasienadmisiT $pasienadmisi
 * @property PasienM $pasien
 * @property PegawaiM $petugasPengisi
 * @property BalancecairanmasukT[] $balancecairanmasukTs
 * @property BalancecairankeluarT[] $balancecairankeluarTs
 * @property BalancecairanoksigenT[] $balancecairanoksigenTs
 * @property BalancecairandietT[] $balancecairandietTs
 * @property PrograminfusT[] $programinfusTs
 */
class BalancecairanT extends CActiveRecord
{
	public $petugas_pengisi_nama, $pegawai_nama;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BalancecairanT the static model class
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
		return 'balancecairan_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasien_id, create_time, create_loginpemakai, create_ruangan_id', 'required'),
			array('pasienadmisi_id, pasien_id, petugas_pengisi, create_ruangan_id', 'numerical', 'integerOnly'=>true),
			array('create_loginpemakai, update_loginpemakai', 'length', 'max'=>200),
			array('tindakan_pasien, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('balancecairan_id, pasienadmisi_id, pasien_id, tanggal_pencatatan, petugas_pengisi, tindakan_pasien, create_time, update_time, create_loginpemakai, update_loginpemakai, create_ruangan_id', 'safe', 'on'=>'search'),
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
			'pasienadmisi' => array(self::BELONGS_TO, 'PasienadmisiT', 'pasienadmisi_id'),
			'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
			'petugasPengisi' => array(self::BELONGS_TO, 'PegawaiM', 'petugas_pengisi'),
			'balancecairanmasukTs' => array(self::HAS_MANY, 'BalancecairanmasukT', 'balancecairan_id'),
			'balancecairankeluarTs' => array(self::HAS_MANY, 'BalancecairankeluarT', 'balancecairan_id'),
			'balancecairanoksigenTs' => array(self::HAS_MANY, 'BalancecairanoksigenT', 'balancecairan_id'),
			'balancecairandietTs' => array(self::HAS_MANY, 'BalancecairandietT', 'balancecairan_id'),
			'programinfusTs' => array(self::HAS_MANY, 'PrograminfusT', 'balancecairan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'balancecairan_id' => 'Balancecairan',
			'pasienadmisi_id' => 'Pasienadmisi',
			'pasien_id' => 'Pasien',
			'tanggal_pencatatan' => 'Tanggal Pencatatan',
			'petugas_pengisi' => 'Petugas Pengisi',
			'tindakan_pasien' => 'Pemeriksaan/ Tindakan',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai' => 'Create Loginpemakai',
			'update_loginpemakai' => 'Update Loginpemakai',
			'create_ruangan_id' => 'Create Ruangan',
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

		$criteria->compare('balancecairan_id',$this->balancecairan_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('tanggal_pencatatan',$this->tanggal_pencatatan,true);
		$criteria->compare('petugas_pengisi',$this->petugas_pengisi);
		$criteria->compare('tindakan_pasien',$this->tindakan_pasien,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai',$this->create_loginpemakai,true);
		$criteria->compare('update_loginpemakai',$this->update_loginpemakai,true);
		$criteria->compare('create_ruangan_id',$this->create_ruangan_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchRiwayat()
	{

		$criteria=new CDbCriteria;

		if(!empty($this->pasienadmisi_id)){
			$criteria->addCondition('pasienadmisi_id = '.$this->pasienadmisi_id);
		}
		$criteria->order = 'tanggal_pencatatan asc';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

}
