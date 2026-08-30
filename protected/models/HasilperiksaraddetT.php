<?php

/**
 * This is the model class for table "hasilperiksaraddet_t".
 *
 * The followings are the available columns in table 'hasilperiksaraddet_t':
 * @property integer $hasperiksaraddet_id
 * @property integer $hasilpemeriksaanrad_id
 * @property integer $refhasildet_id
 * @property string $hasperiksaraddet_tgl
 * @property string $hasperiksaraddet_expertise
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property HasilpemeriksaanradT $hasilpemeriksaanrad
 * @property ReferensihasildetM $refhasildet
 */
class HasilperiksaraddetT extends CActiveRecord
{
	public $refhasildet_nama;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return HasilperiksaraddetT the static model class
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
		return 'hasilperiksaraddet_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('hasilpemeriksaanrad_id, refhasildet_id, hasperiksaraddet_tgl, create_time, create_loginpemakai_id', 'required'),
			array('hasilpemeriksaanrad_id, refhasildet_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('hasperiksaraddet_expertise, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('hasperiksaraddet_id, hasilpemeriksaanrad_id, refhasildet_id, hasperiksaraddet_tgl, hasperiksaraddet_expertise, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'hasilpemeriksaanrad' => array(self::BELONGS_TO, 'HasilpemeriksaanradT', 'hasilpemeriksaanrad_id'),
			'refhasildet' => array(self::BELONGS_TO, 'ReferensihasildetM', 'refhasildet_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'hasperiksaraddet_id' => 'Hasperiksaraddet',
			'hasilpemeriksaanrad_id' => 'Hasilpemeriksaanrad',
			'refhasildet_id' => 'Refhasildet',
			'hasperiksaraddet_tgl' => 'Hasperiksaraddet Tgl',
			'hasperiksaraddet_expertise' => 'Hasperiksaraddet Expertise',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
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

		$criteria->compare('hasperiksaraddet_id',$this->hasperiksaraddet_id);
		$criteria->compare('hasilpemeriksaanrad_id',$this->hasilpemeriksaanrad_id);
		$criteria->compare('refhasildet_id',$this->refhasildet_id);
		$criteria->compare('hasperiksaraddet_tgl',$this->hasperiksaraddet_tgl,true);
		$criteria->compare('hasperiksaraddet_expertise',$this->hasperiksaraddet_expertise,true);
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