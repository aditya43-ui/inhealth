<?php

/**
 * This is the model class for table "daftarkeluarga_gangguangjiwa_t".
 *
 * The followings are the available columns in table 'daftarkeluarga_gangguangjiwa_t':
 * @property integer $daftarkeluarga_gangguangjiwa_id
 * @property integer $askepkesehatanjiwa_id
 * @property string $hubungankeluarga
 * @property string $gejala
 * @property string $riwayatpengobatan
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan_id
 *
 * The followings are the available model relations:
 * @property AskepkesehatanjiwaT $askepkesehatanjiwa
 */
class DaftarkeluargaGangguangjiwaT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DaftarkeluargaGangguangjiwaT the static model class
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
		return 'daftarkeluarga_gangguangjiwa_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('askepkesehatanjiwa_id, create_time, create_loginpemakai_id, update_loginpemakai_id', 'required'),
			array('askepkesehatanjiwa_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan_id', 'numerical', 'integerOnly'=>true),
			array('hubungankeluarga', 'length', 'max'=>100),
			array('gejala, riwayatpengobatan, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('daftarkeluarga_gangguangjiwa_id, askepkesehatanjiwa_id, hubungankeluarga, gejala, riwayatpengobatan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan_id', 'safe', 'on'=>'search'),
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
			'askepkesehatanjiwa' => array(self::BELONGS_TO, 'AskepkesehatanjiwaT', 'askepkesehatanjiwa_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'daftarkeluarga_gangguangjiwa_id' => 'Daftarkeluarga Gangguangjiwa',
			'askepkesehatanjiwa_id' => 'Askepkesehatanjiwa',
			'hubungankeluarga' => 'Hubungan Keluarga',
			'gejala' => 'Gejala',
			'riwayatpengobatan' => 'Riwayat Pengobatan',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan_id' => 'Create Ruangan',
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

		$criteria->compare('daftarkeluarga_gangguangjiwa_id',$this->daftarkeluarga_gangguangjiwa_id);
		$criteria->compare('askepkesehatanjiwa_id',$this->askepkesehatanjiwa_id);
		$criteria->compare('hubungankeluarga',$this->hubungankeluarga,true);
		$criteria->compare('gejala',$this->gejala,true);
		$criteria->compare('riwayatpengobatan',$this->riwayatpengobatan,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan_id',$this->create_ruangan_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}