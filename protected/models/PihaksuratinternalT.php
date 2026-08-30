<?php

/**
 * This is the model class for table "pihaksuratinternal_t".
 *
 * The followings are the available columns in table 'pihaksuratinternal_t':
 * @property integer $pihaksuratinternal_id
 * @property integer $suratinternal_id
 * @property string $jenispihak
 * @property integer $pegawai_id
 */
class PihaksuratinternalT extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'pihaksuratinternal_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('suratinternal_id, pegawai_id', 'numerical', 'integerOnly'=>true),
			array('jenispihak', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('pihaksuratinternal_id, suratinternal_id, jenispihak, pegawai_id', 'safe', 'on'=>'search'),
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
			'pihaksuratinternal_id' => 'Pihaksuratinternal',
			'suratinternal_id' => 'Suratinternal',
			'jenispihak' => 'Jenispihak',
			'pegawai_id' => 'Pegawai',
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

		$criteria->compare('pihaksuratinternal_id',$this->pihaksuratinternal_id);
		$criteria->compare('suratinternal_id',$this->suratinternal_id);
		$criteria->compare('jenispihak',$this->jenispihak,true);
		$criteria->compare('pegawai_id',$this->pegawai_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PihaksuratinternalT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
