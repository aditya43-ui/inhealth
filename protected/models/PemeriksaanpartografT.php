<?php

/**
 * This is the model class for table "pemeriksaanpartograf_t".
 *
 * The followings are the available columns in table 'pemeriksaanpartograf_t':
 * @property integer $pemeriksaanpartograf_id
 * @property integer $pendaftaran_id
 * @property integer $persalinan_id
 * @property string $tglperiksa
 * @property string $tglketubanpecah
 * @property string $tglmules
 * @property integer $usiakehamilan
 * @property integer $gravida
 * @property integer $para
 * @property integer $abortus
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property PendaftaranT $pendaftaran
 * @property PemeriksaanpartografdetT[] $pemeriksaanpartografdetTs
 */
class PemeriksaanpartografT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PemeriksaanpartografT the static model class
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
		return 'pemeriksaanpartograf_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendaftaran_id, tglperiksa, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pendaftaran_id, persalinan_id, usiakehamilan, gravida, para, abortus, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('tinggibadan, beratbadan, tinggifundus, panggul_ukuran, panggul_posisipengukuran, perhatiankhusus, perkiraan_usiahamil_byhaid, perkiraan_usiahamil_byfundus, perkiraan_usiahamil_byusg, is_selaputketubanpecah, selaputketubanpecah_tgl, selaputketubanpecah_jam, perkiraanlahir_tgl, beratjanin, tglketubanpecah, update_time, tglmules', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pemeriksaanpartograf_id, pendaftaran_id, persalinan_id, tglperiksa, tglketubanpecah, tglmules, usiakehamilan, gravida, para, abortus, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'pemeriksaanpartografdetTs' => array(self::HAS_MANY, 'PemeriksaanpartografdetT', 'pemeriksaanpartograf_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pemeriksaanpartograf_id' => 'ID',
			'pendaftaran_id' => 'Pendaftaran',
			'persalinan_id' => 'Persalinan',
			'tglperiksa' => 'Tanggal Periksa',
			'tglketubanpecah' => 'Tanggal Ketuban Pecah',
			'tglmules' => 'Tanggal Mules',
			'usiakehamilan' => 'Usia Kehamilan',
			'gravida' => 'Gravida',
			'para' => 'Para',
			'abortus' => 'Abortus',
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

		$criteria->compare('pemeriksaanpartograf_id',$this->pemeriksaanpartograf_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('persalinan_id',$this->persalinan_id);
		$criteria->compare('tglperiksa',$this->tglperiksa,true);
		$criteria->compare('tglketubanpecah',$this->tglketubanpecah,true);
		$criteria->compare('tglmules',$this->tglmules,true);
		$criteria->compare('usiakehamilan',$this->usiakehamilan);
		$criteria->compare('gravida',$this->gravida);
		$criteria->compare('para',$this->para);
		$criteria->compare('abortus',$this->abortus);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}