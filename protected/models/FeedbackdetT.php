<?php

/**
 * This is the model class for table "feedbackdet_t".
 *
 * The followings are the available columns in table 'feedbackdet_t':
 * @property integer $feedbackdet_id
 * @property integer $feedback_id
 * @property integer $kritikdansaran_id
 * @property string $soal
 * @property string $jawaban_soal
 * @property string $ket_jawaban
 */
class FeedbackdetT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return FeedbackdetT the static model class
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
		return 'feedbackdet_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('feedback_id, kritikdansaran_id', 'required'),
			array('feedback_id, kritikdansaran_id', 'numerical', 'integerOnly'=>true),
			array('soal', 'length', 'max'=>1000),
			array('jawaban_soal', 'length', 'max'=>5),
			array('ket_jawaban', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('feedbackdet_id, feedback_id, kritikdansaran_id, soal, jawaban_soal, ket_jawaban', 'safe', 'on'=>'search'),
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
			'feedbackdet_id' => 'Feedbackdet',
			'feedback_id' => 'Feedback',
			'kritikdansaran_id' => 'Kritikdansaran',
			'soal' => 'Soal',
			'jawaban_soal' => 'Jawaban Soal',
			'ket_jawaban' => 'Ket Jawaban',
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

		$criteria->compare('feedbackdet_id',$this->feedbackdet_id);
		$criteria->compare('feedback_id',$this->feedback_id);
		$criteria->compare('kritikdansaran_id',$this->kritikdansaran_id);
		$criteria->compare('soal',$this->soal,true);
		$criteria->compare('jawaban_soal',$this->jawaban_soal,true);
		$criteria->compare('ket_jawaban',$this->ket_jawaban,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}