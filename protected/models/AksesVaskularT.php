<?php

/**
 * This is the model class for table "akses_vaskular_t".
 *
 * The followings are the available columns in table 'akses_vaskular_t':
 * @property integer $akses_vaskular_id
 * @property integer $monitoring_pre_hd_id
 * @property integer $pendaftaran_id
 * @property integer $pasien_id
 * @property string $nama_akses_vaskular
 *
 * The followings are the available model relations:
 * @property PasienM $pasien
 * @property PendaftaranT $pendaftaran
 * @property MonitoringPreHdT $monitoringPreHd
 */

class AksesVaskularT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AksesVaskularT the static model class
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
		return 'akses_vaskular_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('monitoring_pre_hd_id, pendaftaran_id, pasien_id', 'numerical', 'integerOnly'=>true),
			array('nama_akses_vaskular', 'length', 'max'=>100),
                        ['hd_kateter, is_kanan, is_kiri, problem','safe'],
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('akses_vaskular_id, monitoring_pre_hd_id, pendaftaran_id, pasien_id, nama_akses_vaskular', 'safe', 'on'=>'search'),
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
			'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
			'monitoringPreHd' => array(self::BELONGS_TO, 'MonitoringPreHdT', 'monitoring_pre_hd_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'akses_vaskular_id' => 'Akses Vaskular',
			'monitoring_pre_hd_id' => 'Monitoring Pre Hd',
			'pendaftaran_id' => 'Pendaftaran',
			'pasien_id' => 'Pasien',
			'nama_akses_vaskular' => 'Nama Akses Vaskular',
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

		$criteria->compare('akses_vaskular_id',$this->akses_vaskular_id);
		$criteria->compare('monitoring_pre_hd_id',$this->monitoring_pre_hd_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('nama_akses_vaskular',$this->nama_akses_vaskular,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
