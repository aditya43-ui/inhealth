<?php

/**
 * This is the model class for table "ubahperawat_r".
 *
 * The followings are the available columns in table 'ubahperawat_r':
 * @property integer $ubahperawat_id
 * @property integer $perawatlama_id
 * @property integer $perawatbaru_id
 * @property string $tglubahperawat
 * @property string $alasanperubahanperawat
 * @property string $keterangan
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 * @property integer $pendaftaran_id
 * @property integer $pasienadmisi_id
 */
class UbahperawatR extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UbahperawatR the static model class
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
		return 'ubahperawat_r';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('perawatlama_id, perawatbaru_id, tglubahperawat, alasanperubahanperawat, create_time, create_loginpemakai_id, create_ruangan, pendaftaran_id', 'required'),
			array('perawatlama_id, perawatbaru_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, pendaftaran_id, pasienadmisi_id', 'numerical', 'integerOnly'=>true),
			array('alasanperubahanperawat', 'length', 'max'=>200),
			array('pasienmasukpenunjang_id, keterangan, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ubahperawat_id, perawatlama_id, perawatbaru_id, tglubahperawat, alasanperubahanperawat, keterangan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, pendaftaran_id, pasienadmisi_id', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ubahperawat_id' => 'Ubahperawat',
			'perawatlama_id' => 'Perawatlama',
			'perawatbaru_id' => 'Perawatbaru',
			'tglubahperawat' => 'Tglubahperawat',
			'alasanperubahanperawat' => 'Alasanperubahanperawat',
			'keterangan' => 'Keterangan',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'pendaftaran_id' => 'Pendaftaran',
			'pasienadmisi_id' => 'Pasienadmisi',
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

		$criteria->compare('ubahperawat_id',$this->ubahperawat_id);
		$criteria->compare('perawatlama_id',$this->perawatlama_id);
		$criteria->compare('perawatbaru_id',$this->perawatbaru_id);
		$criteria->compare('tglubahperawat',$this->tglubahperawat,true);
		$criteria->compare('alasanperubahanperawat',$this->alasanperubahanperawat,true);
		$criteria->compare('keterangan',$this->keterangan,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}