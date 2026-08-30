<?php

/**
 * This is the model class for table "jenispemeriksaansesuaiform_v".
 *
 * The followings are the available columns in table 'jenispemeriksaansesuaiform_v':
 * @property integer $jenispemeriksaanlab_id
 * @property string $jenispemeriksaanlab_nama
 * @property integer $jenisform_id
 */
class JenispemeriksaansesuaiformV extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'jenispemeriksaansesuaiform_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jenispemeriksaanlab_id, jenisform_id', 'numerical', 'integerOnly'=>true),
			array('jenispemeriksaanlab_nama', 'length', 'max'=>92),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('jenispemeriksaanlab_id, jenispemeriksaanlab_nama, jenisform_id', 'safe', 'on'=>'search'),
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
			'jenispemeriksaanlab_id' => 'Jenispemeriksaanlab',
			'jenispemeriksaanlab_nama' => 'Jenispemeriksaanlab Nama',
			'jenisform_id' => 'Jenisform',
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

		$criteria->compare('jenispemeriksaanlab_id',$this->jenispemeriksaanlab_id);
		$criteria->compare('jenispemeriksaanlab_nama',$this->jenispemeriksaanlab_nama,true);
		$criteria->compare('jenisform_id',$this->jenisform_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return JenispemeriksaansesuaiformV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
