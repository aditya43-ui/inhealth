<?php

/**
 * This is the model class for table "partografpasien_t".
 *
 * The followings are the available columns in table 'partografpasien_t':
 * @property integer $partografpasien_id
 * @property integer $pendaftaran_id
 * @property string $tglawal_pelayanan
 * @property string $jamawal_pelayanan
 * @property integer $petugaspemeriksa_id
 * @property string $ketubahpecahsejak_jam
 * @property string $mulessejak_jam
 * @property integer $gravida
 * @property integer $para
 * @property integer $abortus
 * @property integer $jml_anakhidup
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 *
 * The followings are the available model relations:
 * @property PendaftaranT $pendaftaran
 */
class PartografpasienT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PartografpasienT the static model class
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
		return 'partografpasien_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendaftaran_id, tglawal_pelayanan, jamawal_pelayanan, petugaspemeriksa_id, create_loginpemakai_id', 'required'),
			array('pendaftaran_id, petugaspemeriksa_id, gravida, para, abortus, jml_anakhidup, create_loginpemakai_id, update_loginpemakai_id, perkiraan_usiahamil_byhaid, perkiraan_usiahamil_byfundus, perkiraan_usiahamil_byusg, siklushaid', 'numerical', 'integerOnly'=>true),
			array('ketubahpecahsejak_jam, mulessejak_jam, create_time, update_time, perkiraanlahir_tgl, haripertamahaidterakhir', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('partografpasien_id, pendaftaran_id, tglawal_pelayanan, jamawal_pelayanan, petugaspemeriksa_id, ketubahpecahsejak_jam, mulessejak_jam, gravida, para, abortus, jml_anakhidup, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, perkiraan_usiahamil_byhaid, perkiraan_usiahamil_byfundus, perkiraan_usiahamil_byusg, siklushaid, perkiraanlahir_tgl, haripertamahaidterakhir', 'safe', 'on'=>'search'),
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
			'petugas' => array(self::BELONGS_TO, 'PegawaiM', 'petugaspemeriksa_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'partografpasien_id' => 'Partografpasien',
			'pendaftaran_id' => 'Pendaftaran',
			'tglawal_pelayanan' => 'Tanggal Awal Pelayanan',
			'jamawal_pelayanan' => 'Jam Awal Pelayanan',
			'petugaspemeriksa_id' => 'Petugas Pemeriksa',
			'ketubahpecahsejak_jam' => 'Ketubah Pecah Sejak Jam',
			'mulessejak_jam' => 'Mules Sejak Jam',
			'gravida' => 'Gravida',
			'para' => 'Para',
			'abortus' => 'Abortus',
			'jml_anakhidup' => 'Jml Anakhidup',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
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

		$criteria->compare('partografpasien_id',$this->partografpasien_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('tglawal_pelayanan',$this->tglawal_pelayanan,true);
		$criteria->compare('jamawal_pelayanan',$this->jamawal_pelayanan,true);
		$criteria->compare('petugaspemeriksa_id',$this->petugaspemeriksa_id);
		$criteria->compare('ketubahpecahsejak_jam',$this->ketubahpecahsejak_jam,true);
		$criteria->compare('mulessejak_jam',$this->mulessejak_jam,true);
		$criteria->compare('gravida',$this->gravida);
		$criteria->compare('para',$this->para);
		$criteria->compare('abortus',$this->abortus);
		$criteria->compare('jml_anakhidup',$this->jml_anakhidup);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}