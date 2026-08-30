<?php

/**
 * This is the model class for table "resumemedis_morbiditas_r".
 *
 * The followings are the available columns in table 'resumemedis_morbiditas_r':
 * @property integer $resumemedis_morbiditas_id
 * @property integer $resumemedis_id
 * @property integer $diagnosa_id
 * @property string $diagnosa_kode
 * @property string $diagnosa_nama
 * @property integer $kelompokdiagnosa_id
 * @property integer $pasienmorbiditas_id
 * @property string $created_time
 */
class ResumemedisMorbiditasR extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'resumemedis_morbiditas_r';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('created_time', 'required'),
			array('resumemedis_id, diagnosa_id, kelompokdiagnosa_id, pasienmorbiditas_id', 'numerical', 'integerOnly'=>true),
			array('diagnosa_kode, diagnosa_nama', 'length', 'max'=>255),

			array('created_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'insert'),
			
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('resumemedis_morbiditas_id, resumemedis_id, diagnosa_id, diagnosa_kode, diagnosa_nama, kelompokdiagnosa_id, pasienmorbiditas_id, created_time', 'safe', 'on'=>'search'),
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
			'diagnosa' => array(self::BELONGS_TO, 'DiagnosaM', 'diagnosa_id'),
			'kelompokdiagnosa'=>array(self::BELONGS_TO,  'KelompokdiagnosaM', 'kelompokdiagnosa_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'resumemedis_morbiditas_id' => 'Resumemedis Morbiditas',
			'resumemedis_id' => 'Resumemedis',
			'diagnosa_id' => 'Diagnosa',
			'diagnosa_kode' => 'Diagnosa Kode',
			'diagnosa_nama' => 'Diagnosa Nama',
			'kelompokdiagnosa_id' => 'Kelompokdiagnosa',
			'pasienmorbiditas_id' => 'Pasienmorbiditas',
			'created_time' => 'Created Time',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('resumemedis_morbiditas_id',$this->resumemedis_morbiditas_id);
		$criteria->compare('resumemedis_id',$this->resumemedis_id);
		$criteria->compare('diagnosa_id',$this->diagnosa_id);
		$criteria->compare('diagnosa_kode',$this->diagnosa_kode,true);
		$criteria->compare('diagnosa_nama',$this->diagnosa_nama,true);
		$criteria->compare('kelompokdiagnosa_id',$this->kelompokdiagnosa_id);
		$criteria->compare('pasienmorbiditas_id',$this->pasienmorbiditas_id);
		$criteria->compare('created_time',$this->created_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ResumemedisMorbiditasR the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
