<?php

/**
 * This is the model class for table "pengkajiannyeriskalabps_t".
 *
 * The followings are the available columns in table 'pengkajiannyeriskalabps_t':
 * @property integer $pengkajiannyeriskalabps_id
 * @property integer $pengkajiannyeri_id
 * @property string $parameter
 * @property string $bps_penilaian
 * @property integer $bps_skor
 * @property boolean $ispakaiventilator
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan_id
 *
 * The followings are the available model relations:
 * @property PengkajiannyeriT $pengkajiannyeri
 */
class PengkajiannyeriskalabpsT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PengkajiannyeriskalabpsT the static model class
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
		return 'pengkajiannyeriskalabps_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pengkajiannyeri_id, parameter, bps_skor, create_time, create_loginpemakai_id', 'required'),
			array('pengkajiannyeri_id, bps_skor, create_loginpemakai_id, update_loginpemakai_id, create_ruangan_id', 'numerical', 'integerOnly'=>true),
			array('parameter', 'length', 'max'=>100),
			array('bps_penilaian', 'length', 'max'=>255),
			array('update_time, ispakaiventilator', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pengkajiannyeriskalabps_id, pengkajiannyeri_id, parameter, bps_penilaian, bps_skor, ispakaiventilator, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan_id', 'safe', 'on'=>'search'),
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
			'pengkajiannyeri' => array(self::BELONGS_TO, 'PengkajiannyeriT', 'pengkajiannyeri_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pengkajiannyeriskalabps_id' => 'Pengkajiannyeriskalabps',
			'pengkajiannyeri_id' => 'Pengkajiannyeri',
			'parameter' => 'Parameter',
			'bps_penilaian' => 'Bps Penilaian',
			'bps_skor' => 'Bps Skor',
			'ispakaiventilator' => 'Ispakaiventilator',
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

		$criteria->compare('pengkajiannyeriskalabps_id',$this->pengkajiannyeriskalabps_id);
		$criteria->compare('pengkajiannyeri_id',$this->pengkajiannyeri_id);
		$criteria->compare('parameter',$this->parameter,true);
		$criteria->compare('bps_penilaian',$this->bps_penilaian,true);
		$criteria->compare('bps_skor',$this->bps_skor);
		$criteria->compare('ispakaiventilator',$this->ispakaiventilator);
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