<?php

/**
 * This is the model class for table "kesejahteraanibunaditd_t".
 *
 * The followings are the available columns in table 'kesejahteraanibunaditd_t':
 * @property integer $kesejahteraanibunaditd_id
 * @property integer $kesejahteraanibu_id
 * @property integer $nadi
 * @property integer $td_systolic
 * @property integer $td_diastolic
 *
 * The followings are the available model relations:
 * @property KesejahteraanibuT $kesejahteraanibu
 */
class KesejahteraanibunaditdT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KesejahteraanibunaditdT the static model class
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
		return 'kesejahteraanibunaditd_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kesejahteraanibu_id', 'required'),
			array('kesejahteraanibu_id, nadi, td_systolic, td_diastolic', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('kesejahteraanibunaditd_id, kesejahteraanibu_id, nadi, td_systolic, td_diastolic', 'safe', 'on'=>'search'),
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
			'kesejahteraanibu' => array(self::BELONGS_TO, 'KesejahteraanibuT', 'kesejahteraanibu_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'kesejahteraanibunaditd_id' => 'Kesejahteraanibunaditd',
			'kesejahteraanibu_id' => 'Kesejahteraanibu',
			'nadi' => 'Nadi',
			'td_systolic' => 'Tekanan Darah',
			'td_diastolic' => 'Td Diastolic',
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

		$criteria->compare('kesejahteraanibunaditd_id',$this->kesejahteraanibunaditd_id);
		$criteria->compare('kesejahteraanibu_id',$this->kesejahteraanibu_id);
		$criteria->compare('nadi',$this->nadi);
		$criteria->compare('td_systolic',$this->td_systolic);
		$criteria->compare('td_diastolic',$this->td_diastolic);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}