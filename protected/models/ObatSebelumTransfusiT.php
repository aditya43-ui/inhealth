<?php

/**
 * This is the model class for table "obat_sebelum_transfusi_t".
 *
 * The followings are the available columns in table 'obat_sebelum_transfusi_t':
 * @property integer $obat_diberikan_id
 * @property integer $observasi_transfusi_darah_id
 * @property integer $pasien_id
 * @property integer $pendaftaran_id
 * @property string $nama_obat
 *
 * The followings are the available model relations:
 * @property KantongTransfusiDarahT $observasiTransfusiDarah
 * @property PendaftaranT $pendaftaran
 * @property PasienM $pasien
 */
class ObatSebelumTransfusiT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ObatSebelumTransfusiT the static model class
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
		return 'obat_sebelum_transfusi_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('observasi_transfusi_darah_id, pasien_id, pendaftaran_id', 'numerical', 'integerOnly'=>true),
			array('nama_obat', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('obat_diberikan_id, observasi_transfusi_darah_id, pasien_id, pendaftaran_id, nama_obat', 'safe', 'on'=>'search'),
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
			'observasiTransfusiDarah' => array(self::BELONGS_TO, 'KantongTransfusiDarahT', 'observasi_transfusi_darah_id'),
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
			'obat_diberikan_id' => 'Obat Diberikan',
			'observasi_transfusi_darah_id' => 'Observasi Transfusi Darah',
			'pasien_id' => 'Pasien',
			'pendaftaran_id' => 'Pendaftaran',
			'nama_obat' => 'Nama Obat',
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

		$criteria->compare('obat_diberikan_id',$this->obat_diberikan_id);
		$criteria->compare('observasi_transfusi_darah_id',$this->observasi_transfusi_darah_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('nama_obat',$this->nama_obat,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}