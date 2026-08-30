<?php

/**
 * This is the model class for table "jawabkonsulpoli_t".
 *
 * The followings are the available columns in table 'jawabkonsulpoli_t':
 * @property integer $jawabkonsulpoli_id
 * @property integer $konsulpoli_id
 * @property integer $ruangan_id
 * @property integer $pegawai_id
 * @property integer $pendaftaran_id
 * @property integer $pasienadmisi_id
 * @property integer $pasien_id
 * @property integer $asalpoliklinikkonsul_id
 * @property string $nojawabkonsul
 * @property string $tgljawabkonsul
 * @property string $jawabankonsul
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 *
 * The followings are the available model relations:
 * @property KonsulpoliT $konsulpoli
 * @property RuanganM $ruangan
 * @property PegawaiM $pegawai
 * @property PendaftaranT $pendaftaran
 * @property PasienadmisiT $pasienadmisi
 * @property PasienM $pasien
 */
class JawabkonsulpoliT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JawabkonsulpoliT the static model class
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
		return 'jawabkonsulpoli_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('konsulpoli_id, ruangan_id, pendaftaran_id, pasien_id, asalpoliklinikkonsul_id, nojawabkonsul, tgljawabkonsul, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('konsulpoli_id, ruangan_id, pegawai_id, pendaftaran_id, pasienadmisi_id, pasien_id, asalpoliklinikkonsul_id', 'numerical', 'integerOnly'=>true),
			array('nojawabkonsul', 'length', 'max'=>6),
			array('jawabankonsul, update_time, update_loginpemakai_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('jawabkonsulpoli_id, konsulpoli_id, ruangan_id, pegawai_id, pendaftaran_id, pasienadmisi_id, pasien_id, asalpoliklinikkonsul_id, nojawabkonsul, tgljawabkonsul, jawabankonsul, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'konsulpoli' => array(self::BELONGS_TO, 'KonsulpoliT', 'konsulpoli_id'),
			'ruangan' => array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
			'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
			'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
			'pasienadmisi' => array(self::BELONGS_TO, 'PasienadmisiT', 'pasienadmisi_id'),
			'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'jawabkonsulpoli_id' => 'Jawabkonsulpoli',
			'konsulpoli_id' => 'Konsulpoli',
			'ruangan_id' => 'Ruangan',
			'pegawai_id' => 'Pegawai',
			'pendaftaran_id' => 'Pendaftaran',
			'pasienadmisi_id' => 'Pasienadmisi',
			'pasien_id' => 'Pasien',
			'asalpoliklinikkonsul_id' => 'Asalpoliklinikkonsul',
			'nojawabkonsul' => 'Nojawabkonsul',
			'tgljawabkonsul' => 'Tgljawabkonsul',
			'jawabankonsul' => 'Jawabankonsul',
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

		$criteria->compare('jawabkonsulpoli_id',$this->jawabkonsulpoli_id);
		$criteria->compare('konsulpoli_id',$this->konsulpoli_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('asalpoliklinikkonsul_id',$this->asalpoliklinikkonsul_id);
		$criteria->compare('nojawabkonsul',$this->nojawabkonsul,true);
		$criteria->compare('tgljawabkonsul',$this->tgljawabkonsul,true);
		$criteria->compare('jawabankonsul',$this->jawabankonsul,true);
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