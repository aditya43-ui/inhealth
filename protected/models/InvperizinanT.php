<?php

/**
 * This is the model class for table "invperizinan_t".
 *
 * The followings are the available columns in table 'invperizinan_t':
 * @property integer $invperizinan_id
 * @property integer $invperalatan_id
 * @property string $invperizinan_no
 * @property string $invperizinan_tgl
 * @property string $invperizinan_sdtgl
 * @property string $invperizinan_ket
 * @property string $lampiranfile_1
 * @property string $lampiranfile_2
 * @property string $lampiranfile_3
 * @property integer $pelaksana_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property InvperalatanT $invperalatan
 */
class InvperizinanT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InvperizinanT the static model class
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
		return 'invperizinan_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('invperalatan_id, invperizinan_no, invperizinan_tgl, invperizinan_sdtgl, invperizinan_ket, pelaksana_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('invperalatan_id, pelaksana_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('invperizinan_no', 'length', 'max'=>200),
			array('lampiranfile_1, lampiranfile_2, lampiranfile_3', 'length', 'max'=>255),
			array('update_time, lampiranfile_1', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('invperizinan_id, invperalatan_id, invperizinan_no, invperizinan_tgl, invperizinan_sdtgl, invperizinan_ket, lampiranfile_1, lampiranfile_2, lampiranfile_3, pelaksana_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'invperalatan' => array(self::BELONGS_TO, 'InvperalatanT', 'invperalatan_id'),
                        'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pelaksana_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'invperizinan_id' => 'Invperizinan',
			'invperalatan_id' => 'Invperalatan',
			'invperizinan_no' => 'Invperizinan No',
			'invperizinan_tgl' => 'Invperizinan Tgl',
			'invperizinan_sdtgl' => 'Invperizinan Sdtgl',
			'invperizinan_ket' => 'Invperizinan Ket',
			'lampiranfile_1' => 'Lampiranfile 1',
			'lampiranfile_2' => 'Lampiranfile 2',
			'lampiranfile_3' => 'Lampiranfile 3',
			'pelaksana_id' => 'Pelaksana',
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

		$criteria->compare('invperizinan_id',$this->invperizinan_id);
		$criteria->compare('invperalatan_id',$this->invperalatan_id);
		$criteria->compare('invperizinan_no',$this->invperizinan_no,true);
		$criteria->compare('invperizinan_tgl',$this->invperizinan_tgl,true);
		$criteria->compare('invperizinan_sdtgl',$this->invperizinan_sdtgl,true);
		$criteria->compare('invperizinan_ket',$this->invperizinan_ket,true);
		$criteria->compare('lampiranfile_1',$this->lampiranfile_1,true);
		$criteria->compare('lampiranfile_2',$this->lampiranfile_2,true);
		$criteria->compare('lampiranfile_3',$this->lampiranfile_3,true);
		$criteria->compare('pelaksana_id',$this->pelaksana_id);
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