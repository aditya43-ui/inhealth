<?php

/**
 * This is the model class for table "reaksi_transfusi_t".
 *
 * The followings are the available columns in table 'reaksi_transfusi_t':
 * @property integer $reaksi_transfusi_id
 * @property integer $observasi_transfusi_darah_id
 * @property integer $pasien_id
 * @property integer $pendaftaran_id
 * @property string $nama_reaksi_transfusi
 *
 * The followings are the available model relations:
 * @property PendaftaranT $pendaftaran
 * @property PasienM $pasien
 * @property ObservasiTransfusiDarahT $observasiTransfusiDarah
 */
class ReaksiTransfusiT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ReaksiTransfusiT the static model class
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
		return 'reaksi_transfusi_t';
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
			array('nama_reaksi_transfusi', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('reaksi_transfusi_id, observasi_transfusi_darah_id, pasien_id, pendaftaran_id, nama_reaksi_transfusi', 'safe', 'on'=>'search'),
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
			'observasiTransfusiDarah' => array(self::BELONGS_TO, 'ObservasiTransfusiDarahT', 'observasi_transfusi_darah_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'reaksi_transfusi_id' => 'Reaksi Transfusi',
			'observasi_transfusi_darah_id' => 'Observasi Transfusi Darah',
			'pasien_id' => 'Pasien',
			'pendaftaran_id' => 'Pendaftaran',
			'nama_reaksi_transfusi' => 'Nama Reaksi Transfusi',
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

		$criteria->compare('reaksi_transfusi_id',$this->reaksi_transfusi_id);
		$criteria->compare('observasi_transfusi_darah_id',$this->observasi_transfusi_darah_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('nama_reaksi_transfusi',$this->nama_reaksi_transfusi,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}