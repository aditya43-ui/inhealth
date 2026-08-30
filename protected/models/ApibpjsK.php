<?php

/**
 * This is the model class for table "apibpjs_k".
 *
 * The followings are the available columns in table 'apibpjs_k':
 * @property integer $apibpjs_id
 * @property string $api
 * @property string $keterangan
 * @property integer $resposnse_time
 */
class ApibpjsK extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'apibpjs_k';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('resposnse_time', 'numerical', 'integerOnly'=>true),
			array('keterangan', 'length', 'max'=>50),
			array('api', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('apibpjs_id, api, keterangan, resposnse_time', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'apibpjs_id' => 'Apibpjs',
			'api' => 'Api',
			'keterangan' => 'Keterangan',
			'resposnse_time' => 'Resposnse Time',
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

		$criteria->compare('apibpjs_id',$this->apibpjs_id);
		$criteria->compare('api',$this->api,true);
		$criteria->compare('keterangan',$this->keterangan,true);
		$criteria->compare('resposnse_time',$this->resposnse_time);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ApibpjsK the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
