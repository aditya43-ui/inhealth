<?php

/**
 * This is the model class for table "pilihrencanaaskep_t".
 *
 * The followings are the available columns in table 'pilihrencanaaskep_t':
 * @property integer $pilihrencanaaskep_id
 * @property integer $rencanaaskepdet_id
 * @property integer $tandagejala_id
 * @property integer $intervensidet_id
 * @property integer $kriteriahasildet_id
 * @property integer $rencanaaskep_ir
 * @property integer $rencanaaskep_er
 * @property integer $alternatifdx_id
 *
 * The followings are the available model relations:
 * @property IntervensidetM $intervensidet
 * @property KriteriahasildetM $kriteriahasildet
 * @property RencanaaskepdetT $rencanaaskepdet
 * @property TandagejalaM $tandagejala
 */
class PilihrencanaaskepT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PilihrencanaaskepT the static model class
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
		return 'pilihrencanaaskep_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('rencanaaskepdet_id', 'required'),
			array('rencanaaskepdet_id, tandagejala_id, intervensidet_id, kriteriahasildet_id, rencanaaskep_er, alternatifdx_id', 'numerical', 'integerOnly'=>true),
                        array('rencanaaskep_ir', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pilihrencanaaskep_id, rencanaaskepdet_id, tandagejala_id, intervensidet_id, kriteriahasildet_id, rencanaaskep_ir, rencanaaskep_er, alternatifdx_id', 'safe', 'on'=>'search'),
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
			'intervensidet' => array(self::BELONGS_TO, 'IntervensidetM', 'intervensidet_id'),
			'kriteriahasildet' => array(self::BELONGS_TO, 'KriteriahasildetM', 'kriteriahasildet_id'),
			'rencanaaskepdet' => array(self::BELONGS_TO, 'RencanaaskepdetT', 'rencanaaskepdet_id'),
			'tandagejala' => array(self::BELONGS_TO, 'TandagejalaM', 'tandagejala_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pilihrencanaaskep_id' => 'Pilihrencanaaskep',
			'rencanaaskepdet_id' => 'Rencanaaskepdet',
			'tandagejala_id' => 'Tandagejala',
			'intervensidet_id' => 'Intervensidet',
			'kriteriahasildet_id' => 'Kriteriahasildet',
			'rencanaaskep_ir' => 'Rencanaaskep Ir',
			'rencanaaskep_er' => 'Rencanaaskep Er',
			'alternatifdx_id' => 'Alternatifdx',
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

		$criteria->compare('pilihrencanaaskep_id',$this->pilihrencanaaskep_id);
		$criteria->compare('rencanaaskepdet_id',$this->rencanaaskepdet_id);
		$criteria->compare('tandagejala_id',$this->tandagejala_id);
		$criteria->compare('intervensidet_id',$this->intervensidet_id);
		$criteria->compare('kriteriahasildet_id',$this->kriteriahasildet_id);
		$criteria->compare('rencanaaskep_ir',$this->rencanaaskep_ir);
		$criteria->compare('rencanaaskep_er',$this->rencanaaskep_er);
		$criteria->compare('alternatifdx_id',$this->alternatifdx_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}