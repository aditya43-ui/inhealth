<?php

/**
 * This is the model class for table "scoringdetail_t".
 *
 * The followings are the available columns in table 'scoringdetail_t':
 * @property integer $scoringdetail_id
 * @property integer $kelrem_id
 * @property integer $personalscoring_id
 * @property integer $indexing_id
 * @property integer $index_personal
 * @property integer $ratebobot_personal
 * @property integer $score_personal
 */
class ScoringdetailT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ScoringdetailT the static model class
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
		return 'scoringdetail_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kelrem_id, personalscoring_id, indexing_id', 'required'),
			array('kelrem_id, personalscoring_id, indexing_id, ratebobot_personal', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('scoringdetail_id, kelrem_id, personalscoring_id, indexing_id, index_personal, ratebobot_personal, score_personal', 'safe', 'on'=>'search'),
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
                                    'kelrem'=>array(self::BELONGS_TO,'KelremM','kelrem_id'),
                                    'indexing'=>array(self::BELONGS_TO,'IndexingM','indexing_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'scoringdetail_id' => 'ID',
			'kelrem_id' => 'Kelompok',
			'personalscoring_id' => 'Personalscoring',
			'indexing_id' => 'Indexing',
			'index_personal' => 'Index',
			'ratebobot_personal' => 'bobot',
			'score_personal' => 'Score',
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

//		$criteria->compare('scoringdetail_id',$this->scoringdetail_id);
//		$criteria->compare('kelrem_id',$this->kelrem_id);
//		$criteria->compare('personalscoring_id',$this->personalscoring_id);
//		$criteria->compare('indexing_id',$this->indexing_id);
//		$criteria->compare('index_personal',$this->index_personal);
//		$criteria->compare('ratebobot_personal',$this->ratebobot_personal);
//		$criteria->compare('score_personal',$this->score_personal);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('scoringdetail_id',$this->scoringdetail_id);
		$criteria->compare('kelrem_id',$this->kelrem_id);
		$criteria->compare('personalscoring_id',$this->personalscoring_id);
		$criteria->compare('indexing_id',$this->indexing_id);
		$criteria->compare('index_personal',$this->index_personal);
		$criteria->compare('ratebobot_personal',$this->ratebobot_personal);
		$criteria->compare('score_personal',$this->score_personal);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}