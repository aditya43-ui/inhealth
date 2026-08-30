<?php

/**
 * This is the model class for table "skriningmst_t".
 *
 * The followings are the available columns in table 'skriningmst_t':
 * @property integer $skriningmst_id
 * @property integer $pendaftaran_id
 * @property integer $pasienadmisi_id
 * @property integer $pasien_id
 * @property integer $ruangan_id
 * @property integer $pegawai_id
 * @property integer $skrininggizimst_id
 * @property integer $skriningmst_jawaban
 * @property boolean $is_skriningmst_ya
 * @property boolean $is_skriningmst_tidak
 * @property string $total_skor
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai
 * @property integer $update_loginpemakai
 * @property integer $create_ruangan_id
 *
 * The followings are the available model relations:
 * @property PasienM $pasien
 * @property PasienadmisiT $pasienadmisi
 * @property PegawaiM $pegawai
 * @property PendaftaranT $pendaftaran
 * @property RuanganM $ruangan
 */
class SkriningmstT extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'skriningmst_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendaftaran_id, create_time', 'required'),
			array('pendaftaran_id, pasienadmisi_id, pasien_id, ruangan_id, pegawai_id, skrininggizimst_id, skriningmst_jawaban, create_loginpemakai, update_loginpemakai, create_ruangan_id, skrininggizi_id', 'numerical', 'integerOnly'=>true),
			array('total_skor', 'length', 'max'=>15),
			array('is_skriningmst_ya, is_skriningmst_tidak, update_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('skriningmst_id, pendaftaran_id, pasienadmisi_id, pasien_id, ruangan_id, pegawai_id, skrininggizimst_id, skriningmst_jawaban, is_skriningmst_ya, is_skriningmst_tidak, total_skor, create_time, update_time, create_loginpemakai, update_loginpemakai, create_ruangan_id, skrininggizi_id', 'safe', 'on'=>'search'),
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
			'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
			'pasienadmisi' => array(self::BELONGS_TO, 'PasienadmisiT', 'pasienadmisi_id'),
			'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
			'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
			'ruangan' => array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'skriningmst_id' => 'Skriningmst',
			'pendaftaran_id' => 'Pendaftaran',
			'pasienadmisi_id' => 'Pasienadmisi',
			'pasien_id' => 'Pasien',
			'ruangan_id' => 'Ruangan',
			'pegawai_id' => 'Pegawai',
			'skrininggizimst_id' => 'Skrininggizimst',
			'skriningmst_jawaban' => 'Skriningmst Jawaban',
			'is_skriningmst_ya' => 'Is Skriningmst Ya',
			'is_skriningmst_tidak' => 'Is Skriningmst Tidak',
			'total_skor' => 'Total Skor',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai' => 'Create Loginpemakai',
			'update_loginpemakai' => 'Update Loginpemakai',
			'create_ruangan_id' => 'Create Ruangan',
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

		$criteria->compare('skriningmst_id',$this->skriningmst_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('skrininggizimst_id',$this->skrininggizimst_id);
		$criteria->compare('skriningmst_jawaban',$this->skriningmst_jawaban);
		$criteria->compare('is_skriningmst_ya',$this->is_skriningmst_ya);
		$criteria->compare('is_skriningmst_tidak',$this->is_skriningmst_tidak);
		$criteria->compare('total_skor',$this->total_skor,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai',$this->create_loginpemakai);
		$criteria->compare('update_loginpemakai',$this->update_loginpemakai);
		$criteria->compare('create_ruangan_id',$this->create_ruangan_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SkriningmstT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
