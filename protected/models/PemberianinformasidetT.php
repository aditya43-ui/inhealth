<?php

/**
 * This is the model class for table "pemberianinformasidet_t".
 *
 * The followings are the available columns in table 'pemberianinformasidet_t':
 * @property integer $pemberianinformasidet_id
 * @property integer $pemberianinformasi_id
 * @property integer $jenisinformasi_id
 * @property string $pemberianinformasi_isian
 * @property string $pemberianinformasi_hasil
 *
 * The followings are the available model relations:
 * @property PemberianinformasiT $pemberianinformasi
 * @property JenisinformasiM $jenisinformasi
 * @property ChecklistpemberianinformasiT[] $checklistpemberianinformasiTs
 */
class PemberianinformasidetT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PemberianinformasidetT the static model class
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
		return 'pemberianinformasidet_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pemberianinformasi_id, jenisinformasi_id', 'required'),
			array('pemberianinformasi_id, jenisinformasi_id', 'numerical', 'integerOnly'=>true),
			array('pemberianinformasi_hasil', 'length', 'max'=>200),
			array('pemberianinformasi_isian', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pemberianinformasidet_id, pemberianinformasi_id, jenisinformasi_id, pemberianinformasi_isian, pemberianinformasi_hasil', 'safe', 'on'=>'search'),
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
			'pemberianinformasi' => array(self::BELONGS_TO, 'PemberianinformasiT', 'pemberianinformasi_id'),
			'jenisinformasi' => array(self::BELONGS_TO, 'JenisinformasiM', 'jenisinformasi_id'),
			'checklistpemberianinformasiTs' => array(self::HAS_MANY, 'ChecklistpemberianinformasiT', 'pemberianinformasidet_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pemberianinformasidet_id' => 'Pemberianinformasidet',
			'pemberianinformasi_id' => 'Pemberianinformasi',
			'jenisinformasi_id' => 'Jenisinformasi',
			'pemberianinformasi_isian' => 'Pemberianinformasi Isian',
			'pemberianinformasi_hasil' => 'Pemberianinformasi Hasil',
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

		$criteria->compare('pemberianinformasidet_id',$this->pemberianinformasidet_id);
		$criteria->compare('pemberianinformasi_id',$this->pemberianinformasi_id);
		$criteria->compare('jenisinformasi_id',$this->jenisinformasi_id);
		$criteria->compare('pemberianinformasi_isian',$this->pemberianinformasi_isian,true);
		$criteria->compare('pemberianinformasi_hasil',$this->pemberianinformasi_hasil,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}