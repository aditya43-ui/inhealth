<?php

/**
 * This is the model class for table "operasisignin_t".
 *
 * The followings are the available columns in table 'operasisignin_t':
 * @property integer $operasisignin_id
 * @property integer $rencanaoperasi_id
 * @property integer $pendaftaran_id
 * @property integer $pasienadmisi_id
 * @property integer $kamarruangan_id
 * @property integer $pasienkirimkeunitlain_id
 * @property integer $pasien_id
 * @property string $signin_tindakan
 * @property string $signin_tgl
 * @property string $signin_diagnosapreop
 * @property integer $perawatsirkuler_id
 * @property integer $dokteranestesi_id
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class OperasisigninT extends CActiveRecord
{
	public $perawatsirkuler_nama;
	public $dokteranestesi_nama;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return OperasisigninT the static model class
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
		return 'operasisignin_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendaftaran_id, pasien_id, signin_tgl, perawatsirkuler_id, dokteranestesi_id, create_time, update_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('rencanaoperasi_id, pendaftaran_id, pasienadmisi_id, kamarruangan_id, pasienkirimkeunitlain_id, pasien_id, perawatsirkuler_id, dokteranestesi_id', 'numerical', 'integerOnly'=>true),
			array('signin_tindakan, signin_diagnosapreop', 'length', 'max'=>250),
			array('update_loginpemakai_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('operasisignin_id, rencanaoperasi_id, pendaftaran_id, pasienadmisi_id, kamarruangan_id, pasienkirimkeunitlain_id, pasien_id, signin_tindakan, signin_tgl, signin_diagnosapreop, perawatsirkuler_id, dokteranestesi_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'perawatsirkuler' => array(self::BELONGS_TO,'PegawaiM','perawatsirkuler_id'),
			'dokteranestesi' => array(self::BELONGS_TO,'PegawaiM','dokteranestesi_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'operasisignin_id' => 'Operasisignin',
			'rencanaoperasi_id' => 'Rencanaoperasi',
			'pendaftaran_id' => 'Pendaftaran',
			'pasienadmisi_id' => 'Pasienadmisi',
			'kamarruangan_id' => 'Kamarruangan',
			'pasienkirimkeunitlain_id' => 'Pasienkirimkeunitlain',
			'pasien_id' => 'Pasien',
			'signin_tindakan' => 'Signin Tindakan',
			'signin_tgl' => 'Signin Tgl',
			'signin_diagnosapreop' => 'Signin Diagnosapreop',
			'perawatsirkuler_id' => 'Perawat Sirkuler',
			'dokteranestesi_id' => 'Dokter Anestesi',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
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

		$criteria->compare('operasisignin_id',$this->operasisignin_id);
		$criteria->compare('rencanaoperasi_id',$this->rencanaoperasi_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('kamarruangan_id',$this->kamarruangan_id);
		$criteria->compare('pasienkirimkeunitlain_id',$this->pasienkirimkeunitlain_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('signin_tindakan',$this->signin_tindakan,true);
		$criteria->compare('signin_tgl',$this->signin_tgl,true);
		$criteria->compare('signin_diagnosapreop',$this->signin_diagnosapreop,true);
		$criteria->compare('perawatsirkuler_id',$this->perawatsirkuler_id);
		$criteria->compare('dokteranestesi_id',$this->dokteranestesi_id);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id,true);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id,true);
		$criteria->compare('create_ruangan',$this->create_ruangan,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}