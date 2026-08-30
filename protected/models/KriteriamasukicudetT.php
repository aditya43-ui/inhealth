<?php

/**
 * This is the model class for table "kriteriamasukicudet_t".
 *
 * The followings are the available columns in table 'kriteriamasukicudet_t':
 * @property integer $kriteriamasukicudet_id
 * @property integer $kriteriamasukicu_id
 * @property integer $kriteriaicu_id
 * @property string $jenis_kriteri
 * @property boolean $is_kriteria
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai
 * @property integer $update_loginpemakai
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property KriteriamasukicuT $kriteriamasukicu
 * @property KriteriaicuM $kriteriaicu
 */
class KriteriamasukicudetT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KriteriamasukicudetT the static model class
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
		return 'kriteriamasukicudet_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kriteriamasukicu_id, kriteriaicu_id, jenis_kriteri, create_time, create_loginpemakai, create_ruangan', 'required'),
			array('kriteriamasukicu_id, kriteriaicu_id, create_loginpemakai, update_loginpemakai, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('jenis_kriteri', 'length', 'max'=>200),
			array('is_kriteria, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('kriteriamasukicudet_id, kriteriamasukicu_id, kriteriaicu_id, jenis_kriteri, is_kriteria, create_time, update_time, create_loginpemakai, update_loginpemakai, create_ruangan', 'safe', 'on'=>'search'),
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
			'kriteriamasukicu' => array(self::BELONGS_TO, 'KriteriamasukicuT', 'kriteriamasukicu_id'),
			'kriteriaicu' => array(self::BELONGS_TO, 'KriteriaicuM', 'kriteriaicu_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'kriteriamasukicudet_id' => 'Kriteriamasukicudet',
			'kriteriamasukicu_id' => 'Kriteriamasukicu',
			'kriteriaicu_id' => 'Kriteriaicu',
			'jenis_kriteri' => 'Jenis Kriteri',
			'is_kriteria' => 'Is Kriteria',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai' => 'Create Loginpemakai',
			'update_loginpemakai' => 'Update Loginpemakai',
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

		$criteria->compare('kriteriamasukicudet_id',$this->kriteriamasukicudet_id);
		$criteria->compare('kriteriamasukicu_id',$this->kriteriamasukicu_id);
		$criteria->compare('kriteriaicu_id',$this->kriteriaicu_id);
		$criteria->compare('jenis_kriteri',$this->jenis_kriteri,true);
		$criteria->compare('is_kriteria',$this->is_kriteria);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai',$this->create_loginpemakai);
		$criteria->compare('update_loginpemakai',$this->update_loginpemakai);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}