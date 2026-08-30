<?php

/**
 * This is the model class for table "minimentalexampasien_t".
 *
 * The followings are the available columns in table 'minimentalexampasien_t':
 * @property integer $minimentalexampasien_id
 * @property integer $askepgeriatri_id
 * @property integer $minimentalexam_id
 * @property integer $nilai_responden
 * @property string $keterangan
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan_id
 *
 * The followings are the available model relations:
 * @property AskepgeriatriT $askepgeriatri
 * @property MinimentalexamM $minimentalexam
 * @property MinimentalexampasiendetT[] $minimentalexampasiendetTs
 */
class MinimentalexampasienT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MinimentalexampasienT the static model class
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
		return 'minimentalexampasien_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('askepgeriatri_id, create_time, create_loginpemakai_id', 'required'),
			array('askepgeriatri_id, minimentalexam_id, nilai_responden, create_loginpemakai_id, update_loginpemakai_id, create_ruangan_id', 'numerical', 'integerOnly'=>true),
			array('keterangan, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('minimentalexampasien_id, askepgeriatri_id, minimentalexam_id, nilai_responden, keterangan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan_id', 'safe', 'on'=>'search'),
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
			'askepgeriatri' => array(self::BELONGS_TO, 'AskepgeriatriT', 'askepgeriatri_id'),
			'minimentalexam' => array(self::BELONGS_TO, 'MinimentalexamM', 'minimentalexam_id'),
			'minimentalexampasiendetTs' => array(self::HAS_MANY, 'MinimentalexampasiendetT', 'minimentalexampasien_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'minimentalexampasien_id' => 'Minimentalexampasien',
			'askepgeriatri_id' => 'Askepgeriatri',
			'minimentalexam_id' => 'Minimentalexam',
			'nilai_responden' => 'Nilai Responden',
			'keterangan' => 'Keterangan',
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

		$criteria->compare('minimentalexampasien_id',$this->minimentalexampasien_id);
		$criteria->compare('askepgeriatri_id',$this->askepgeriatri_id);
		$criteria->compare('minimentalexam_id',$this->minimentalexam_id);
		$criteria->compare('nilai_responden',$this->nilai_responden);
		$criteria->compare('keterangan',$this->keterangan,true);
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