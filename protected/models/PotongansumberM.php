<?php

/**
 * This is the model class for table "potongansumber_m".
 *
 * The followings are the available columns in table 'potongansumber_m':
 * @property integer $potongansumber_id
 * @property string $namapotongan
 * @property string $namapotonganlainnya
 * @property boolean $potongansumber_aktif
 */
class PotongansumberM extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'potongansumber_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('namapotongan', 'required'),
			array('namapotongan, namapotonganlainnya', 'length', 'max'=>100),
			array('potongansumber_aktif', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('potongansumber_id, namapotongan, namapotonganlainnya, potongansumber_aktif', 'safe', 'on'=>'search'),
		
			array('create_time','default','value'=>date('Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'insert'),
			array('update_time','default','value'=>date('Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'update,insert'),
			array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
			array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'update,insert'),
			array('create_ruangan','default','value'=>Yii::app()->user->getState('ruangan_id'),'on'=>'insert'),
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
			'potongansumber_id' => 'ID',
			'namapotongan' => 'Nama Potongan',
			'namapotonganlainnya' => 'Nama Lainnya',
			'potongansumber_aktif' => 'Aktif',
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

		$criteria->compare('potongansumber_id',$this->potongansumber_id);
		$criteria->compare('LOWER(namapotongan)',strtolower($this->namapotongan),true);
		$criteria->compare('LOWER(namapotonganlainnya)',strtolower($this->namapotonganlainnya),true);
		$criteria->compare('potongansumber_aktif',isset($this->potongansumber_aktif)?$this->potongansumber_aktif:true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function searchPrint()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('potongansumber_id',$this->potongansumber_id);
		$criteria->compare('LOWER(namapotongan)',strtolower($this->namapotongan),true);
		$criteria->compare('LOWER(namapotonganlainnya)',strtolower($this->namapotonganlainnya),true);
		$criteria->compare('potongansumber_aktif',isset($this->potongansumber_aktif)?$this->potongansumber_aktif:true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PotongansumberM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
