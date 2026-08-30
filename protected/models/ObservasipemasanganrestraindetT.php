<?php

/**
 * This is the model class for table "observasipemasanganrestraindet_t".
 *
 * The followings are the available columns in table 'observasipemasanganrestraindet_t':
 * @property integer $observasipemasanganrestraindet_id
 * @property integer $observasipemasanganrestrain_id
 * @property string $kes
 * @property string $td
 * @property string $hr
 * @property string $rr
 * @property string $s
 * @property string $taka
 * @property string $taki
 * @property string $kaka
 * @property string $kaki
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai
 * @property integer $update_loginpemakai
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property ObservasipemasanganrestrainT $observasipemasanganrestrain
 */
class ObservasipemasanganrestraindetT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ObservasipemasanganrestraindetT the static model class
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
		return 'observasipemasanganrestraindet_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('observasipemasanganrestrain_id, create_time, create_loginpemakai, create_ruangan', 'required'),
			array('observasipemasanganrestrain_id, create_loginpemakai, update_loginpemakai, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('kes, td, hr, rr, s, taka, taki, kaka, kaki', 'length', 'max'=>100),
			array('update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('observasipemasanganrestraindet_id, observasipemasanganrestrain_id, kes, td, hr, rr, s, taka, taki, kaka, kaki, create_time, update_time, create_loginpemakai, update_loginpemakai, create_ruangan,luka', 'safe', 'on'=>'search'),
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
			'observasipemasanganrestrain' => array(self::BELONGS_TO, 'ObservasipemasanganrestrainT', 'observasipemasanganrestrain_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'observasipemasanganrestraindet_id' => 'Observasipemasanganrestraindet',
			'observasipemasanganrestrain_id' => 'Observasipemasanganrestrain',
			'kes' => 'KES',
			'td' => 'TD',
			'hr' => 'HR',
			'rr' => 'RR',
			's' => 'S',
			'taka' => 'Taka',
			'taki' => 'Taki',
			'kaka' => 'Kaka',
			'kaki' => 'Kaki',
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

		$criteria->compare('observasipemasanganrestraindet_id',$this->observasipemasanganrestraindet_id);
		$criteria->compare('observasipemasanganrestrain_id',$this->observasipemasanganrestrain_id);
		$criteria->compare('kes',$this->kes,true);
		$criteria->compare('td',$this->td,true);
		$criteria->compare('hr',$this->hr,true);
		$criteria->compare('rr',$this->rr,true);
		$criteria->compare('s',$this->s,true);
		$criteria->compare('taka',$this->taka,true);
		$criteria->compare('taki',$this->taki,true);
		$criteria->compare('kaka',$this->kaka,true);
		$criteria->compare('kaki',$this->kaki,true);
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