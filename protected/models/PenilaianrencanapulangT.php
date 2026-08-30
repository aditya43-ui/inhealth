<?php

/**
 * This is the model class for table "penilaianrencanapulang_t".
 *
 * The followings are the available columns in table 'penilaianrencanapulang_t':
 * @property integer $penilaianrencanapulang_id
 * @property integer $askepgeriatri_id
 * @property string $penilaian
 * @property string $penilaian_lainnya
 * @property string $hasil
 * @property string $keterangan
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan_id
 *
 * The followings are the available model relations:
 * @property AskepgeriatriT $askepgeriatri
 */
class PenilaianrencanapulangT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PenilaianrencanapulangT the static model class
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
		return 'penilaianrencanapulang_t';
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
			array('askepgeriatri_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan_id', 'numerical', 'integerOnly'=>true),
			array('hasil', 'length', 'max'=>50),
			array('penilaian, penilaian_lainnya, keterangan, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('penilaianrencanapulang_id, askepgeriatri_id, penilaian, penilaian_lainnya, hasil, keterangan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan_id', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'penilaianrencanapulang_id' => 'Penilaianrencanapulang',
			'askepgeriatri_id' => 'Askepgeriatri',
			'penilaian' => 'Penilaian',
			'penilaian_lainnya' => 'Penilaian Lainnya',
			'hasil' => 'Hasil',
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

		$criteria->compare('penilaianrencanapulang_id',$this->penilaianrencanapulang_id);
		$criteria->compare('askepgeriatri_id',$this->askepgeriatri_id);
		$criteria->compare('penilaian',$this->penilaian,true);
		$criteria->compare('penilaian_lainnya',$this->penilaian_lainnya,true);
		$criteria->compare('hasil',$this->hasil,true);
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