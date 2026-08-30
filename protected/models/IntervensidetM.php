<?php

/**
 * This is the model class for table "intervensidet_m".
 *
 * The followings are the available columns in table 'intervensidet_m':
 * @property integer $intervensidet_id
 * @property integer $intervensi_id
 * @property string $intervensidet_indikator
 * @property boolean $intervensidet_aktif
 *
 * The followings are the available model relations:
 * @property PilihrencanaaskepT[] $pilihrencanaaskepTs
 * @property IntervensiM $intervensi
 */
class IntervensidetM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return IntervensidetM the static model class
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
		return 'intervensidet_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('intervensi_id, intervensidet_indikator, intervensidet_aktif', 'required'),
			array('intervensi_id, jenisintervensi_id', 'numerical', 'integerOnly'=>true),
			array('intervensidet_indikator', 'length', 'max'=>200),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('intervensidet_id, intervensi_id, intervensidet_indikator, intervensidet_aktif', 'safe', 'on'=>'search'),
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
			'pilihrencanaaskepTs' => array(self::HAS_MANY, 'PilihrencanaaskepT', 'intervensidet_id'),
			'intervensi' => array(self::BELONGS_TO, 'IntervensiM', 'intervensi_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'intervensidet_id' => 'Intervensidet',
			'intervensi_id' => 'Intervensi',
			'intervensidet_indikator' => 'Intervensidet Indikator',
			'intervensidet_aktif' => 'Intervensidet Aktif',
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

		$criteria->compare('intervensidet_id',$this->intervensidet_id);
		$criteria->compare('intervensi_id',$this->intervensi_id);
		$criteria->compare('intervensidet_indikator',$this->intervensidet_indikator,true);
		$criteria->compare('intervensidet_aktif',$this->intervensidet_aktif);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}