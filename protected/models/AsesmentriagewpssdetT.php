<?php

/**
 * This is the model class for table "asesmentriagewpssdet_t".
 *
 * The followings are the available columns in table 'asesmentriagewpssdet_t':
 * @property integer $asesmentriagewpssdet_id
 * @property integer $pasien_id
 * @property integer $pendaftaran_id
 * @property integer $asesmentriagewpss_id
 * @property integer $pemeriksaantriage_id
 * @property integer $detailpemeriksaantriage_id
 * @property integer $skor
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property AsesmentriagewpssT $asesmentriagewpss
 * @property DetailpemeriksaantriageM $detailpemeriksaantriage
 * @property PasienM $pasien
 * @property PemeriksaantriageM $pemeriksaantriage
 * @property PendaftaranT $pendaftaran
 */
class AsesmentriagewpssdetT extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'asesmentriagewpssdet_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pasien_id, pendaftaran_id, asesmentriagewpss_id, pemeriksaantriage_id, detailpemeriksaantriage_id, skor, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('update_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('asesmentriagewpssdet_id, pasien_id, pendaftaran_id, asesmentriagewpss_id, pemeriksaantriage_id, detailpemeriksaantriage_id, skor, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'asesmentriagewpss' => array(self::BELONGS_TO, 'AsesmentriagewpssT', 'asesmentriagewpss_id'),
			'detailpemeriksaantriage' => array(self::BELONGS_TO, 'DetailpemeriksaantriageM', 'detailpemeriksaantriage_id'),
			'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
			'pemeriksaantriage' => array(self::BELONGS_TO, 'PemeriksaantriageM', 'pemeriksaantriage_id'),
			'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'asesmentriagewpssdet_id' => 'Asesmentriagewpssdet',
			'pasien_id' => 'Pasien',
			'pendaftaran_id' => 'Pendaftaran',
			'asesmentriagewpss_id' => 'Asesmentriagewpss',
			'pemeriksaantriage_id' => 'Pemeriksaantriage',
			'detailpemeriksaantriage_id' => 'Detailpemeriksaantriage',
			'skor' => 'Skor',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
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

		$criteria->compare('asesmentriagewpssdet_id',$this->asesmentriagewpssdet_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('asesmentriagewpss_id',$this->asesmentriagewpss_id);
		$criteria->compare('pemeriksaantriage_id',$this->pemeriksaantriage_id);
		$criteria->compare('detailpemeriksaantriage_id',$this->detailpemeriksaantriage_id);
		$criteria->compare('skor',$this->skor);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AsesmentriagewpssdetT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
