<?php

/**
 * This is the model class for table "periksaronggamulut_t".
 *
 * The followings are the available columns in table 'periksaronggamulut_t':
 * @property integer $periksaronggamulut_id
 * @property integer $pendaftaran_id
 * @property integer $pegawai_id
 * @property integer $pasien_id
 * @property string $tglperiksaronggamulut
 * @property string $jenispemeriksaan
 * @property string $deskripsi_les
 *
 * The followings are the available model relations:
 * @property PendaftaranT $pendaftaran
 * @property PegawaiM $pegawai
 * @property PasienM $pasien
 * @property PemeriksaangambarronggamulutT[] $pemeriksaangambarronggamulutTs
 */
class PeriksaronggamulutT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PeriksaronggamulutT the static model class
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
		return 'periksaronggamulut_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendaftaran_id, pegawai_id, pasien_id, tglperiksaronggamulut', 'required'),
			array('pendaftaran_id, pegawai_id, pasien_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('periksaronggamulut_id, pendaftaran_id, pegawai_id, pasien_id, tglperiksaronggamulut', 'safe', 'on'=>'search'),
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
			'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
			'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
			'pemeriksaangambarronggamulutTs' => array(self::HAS_MANY, 'PemeriksaangambarronggamulutT', 'periksaronggamulut_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'periksaronggamulut_id' => 'Periksaronggamulut',
			'pendaftaran_id' => 'Pendaftaran',
			'pegawai_id' => 'Dokter Pemeriksa',
			'pasien_id' => 'Pasien',
			'tglperiksaronggamulut' => 'Tgl. Pemeriksaan',
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

		$criteria->compare('periksaronggamulut_id',$this->periksaronggamulut_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('tglperiksaronggamulut',$this->tglperiksaronggamulut,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}