<?php

/**
 * This is the model class for table "komponenresponden_m".
 *
 * The followings are the available columns in table 'komponenresponden_m':
 * @package models
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @author Andyka <andykaputra@.com> 
 * @version     2.0.0
 * @link    <http://172.9.1.15/simpp/docs/>
 * @link    <http://piindonesia.co.id> 
 * @property integer $komponenresponden_id
 * @property string $tiperesponden
 * @property string $nama_komponen
 * @property integer $bobot_komponen
 * @property string $urutan
 * @property boolean $komponenresponden_aktif
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property SurveykepuasanRespondenT[] $surveykepuasanRespondenTs
 */
class KomponenrespondenM extends CActiveRecord
{
    public $komponenresponden_aktif_sementara;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KomponenrespondenM the static model class
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
		return 'komponenresponden_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tiperesponden, nama_komponen, bobot_komponen, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('bobot_komponen, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('tiperesponden, nama_komponen, urutan', 'length', 'max'=>45),
			array('komponenresponden_aktif, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('komponenresponden_id, tiperesponden, nama_komponen, bobot_komponen, urutan, komponenresponden_aktif, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'surveykepuasanRespondenTs' => array(self::HAS_MANY, 'SurveykepuasanRespondenT', 'komponenresponden_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'komponenresponden_id' => 'Komponen Responden',
			'tiperesponden' => 'Tipe Responden',
			'nama_komponen' => 'Nama Komponen',
			'bobot_komponen' => 'Bobot Komponen',
			'urutan' => 'Urutan',
			'komponenresponden_aktif' => 'Komponen Responden Aktif',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
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

		$criteria->compare('komponenresponden_id',$this->komponenresponden_id);
		$criteria->compare('tiperesponden',$this->tiperesponden,true);
		$criteria->compare('nama_komponen',$this->nama_komponen,true);
		$criteria->compare('bobot_komponen',$this->bobot_komponen);
		$criteria->compare('urutan',$this->urutan,true);
                $criteria->compare('komponenresponden_aktif',isset($this->komponenresponden_aktif)?$this->komponenresponden_aktif:true);
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