<?php

/**
 * This is the model class for table "evaluasiaskepdet_t".
 *
 * The followings are the available columns in table 'evaluasiaskepdet_t':
 * @property integer $evaluasiaskepdet_id
 * @property integer $diagnosakep_id
 * @property integer $evaluasiaskep_id
 * @property string $evaluasiaskepdet_subjektif
 * @property string $evaluasiaskepdet_objektif
 * @property string $evaluasiaskepdet_assessment
 * @property string $evaluasiaskepdet_planning
 * @property string $evaluasiaskepdet_hasil
 *
 * The followings are the available model relations:
 * @property DiagnosakepM $diagnosakep
 * @property EvaluasiaskepT $evaluasiaskep
 */
class EvaluasiaskepdetT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return EvaluasiaskepdetT the static model class
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
		return 'evaluasiaskepdet_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('diagnosakep_id, evaluasiaskep_id, evaluasiaskepdet_subjektif, evaluasiaskepdet_objektif, evaluasiaskepdet_assessment, evaluasiaskepdet_planning, evaluasiaskepdet_hasil', 'required'),
			array('diagnosakep_id, evaluasiaskep_id, implementasiaskepdet_id', 'numerical', 'integerOnly'=>true),
			array('evaluasiaskepdet_hasil', 'length', 'max'=>30),
                        array('evaluasiaskepdet_implementasi', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('evaluasiaskepdet_id, diagnosakep_id, evaluasiaskep_id, evaluasiaskepdet_subjektif, evaluasiaskepdet_objektif, evaluasiaskepdet_assessment, evaluasiaskepdet_planning, evaluasiaskepdet_hasil', 'safe', 'on'=>'search'),
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
			'diagnosakep' => array(self::BELONGS_TO, 'DiagnosakepM', 'diagnosakep_id'),
			'evaluasiaskep' => array(self::BELONGS_TO, 'EvaluasiaskepT', 'evaluasiaskep_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'evaluasiaskepdet_id' => 'Evaluasiaskepdet',
			'diagnosakep_id' => 'Diagnosakep',
			'evaluasiaskep_id' => 'Evaluasiaskep',
			'evaluasiaskepdet_subjektif' => 'Evaluasiaskepdet Subjektif',
			'evaluasiaskepdet_objektif' => 'Evaluasiaskepdet Objektif',
			'evaluasiaskepdet_assessment' => 'Evaluasiaskepdet Assessment',
			'evaluasiaskepdet_planning' => 'Evaluasiaskepdet Planning',
			'evaluasiaskepdet_hasil' => 'Evaluasiaskepdet Hasil',
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

		$criteria->compare('evaluasiaskepdet_id',$this->evaluasiaskepdet_id);
		$criteria->compare('diagnosakep_id',$this->diagnosakep_id);
		$criteria->compare('evaluasiaskep_id',$this->evaluasiaskep_id);
		$criteria->compare('evaluasiaskepdet_subjektif',$this->evaluasiaskepdet_subjektif,true);
		$criteria->compare('evaluasiaskepdet_objektif',$this->evaluasiaskepdet_objektif,true);
		$criteria->compare('evaluasiaskepdet_assessment',$this->evaluasiaskepdet_assessment,true);
		$criteria->compare('evaluasiaskepdet_planning',$this->evaluasiaskepdet_planning,true);
		$criteria->compare('evaluasiaskepdet_hasil',$this->evaluasiaskepdet_hasil,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}