<?php

/**
 * This is the model class for table "apgarscore_t".
 *
 * The followings are the available columns in table 'apgarscore_t':
 * @property integer $apgarscore_id
 * @property integer $kelahiranbayi_id
 * @property integer $metodeapgar_id
 * @property integer $interpretasiskor_id
 * @property string $tglapgarscore
 * @property integer $menitke
 * @property integer $nilai_apgar
 * @property integer $jmlscore
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class ApgarscoreT extends CActiveRecord
{
    public $kriteria;
    public $nilai_2;
    public $nilai_1;
    public $nilai_0; 
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ApgarscoreT the static model class
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
		return 'apgarscore_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kelahiranbayi_id, metodeapgar_id, interpretasiskor_id, tglapgarscore, menitke, nilai_apgar, jmlscore, create_time, create_loginpemakai_id', 'required'),
			array('kelahiranbayi_id, metodeapgar_id, interpretasiskor_id, menitke, nilai_apgar, jmlscore', 'numerical', 'integerOnly'=>true),
                        //array('menitke','unique'),
			array('update_time, update_loginpemakai_id, create_ruangan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('apgarscore_id, kelahiranbayi_id, metodeapgar_id, interpretasiskor_id, tglapgarscore, menitke, nilai_apgar, jmlscore, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'apgarscore_id' => 'Apgarscore',
			'kelahiranbayi_id' => 'Kelahiranbayi',
			'metodeapgar_id' => 'Metodeapgar',
			'interpretasiskor_id' => 'Interpretasiskor',
			'tglapgarscore' => 'Tglapgarscore',
			'menitke' => 'Menitke',
			'nilai_apgar' => 'Nilai Apgar',
			'jmlscore' => 'Jmlscore',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
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

		$criteria->compare('apgarscore_id',$this->apgarscore_id);
		$criteria->compare('kelahiranbayi_id',$this->kelahiranbayi_id);
		$criteria->compare('metodeapgar_id',$this->metodeapgar_id);
		$criteria->compare('interpretasiskor_id',$this->interpretasiskor_id);
		$criteria->compare('LOWER(tglapgarscore)',strtolower($this->tglapgarscore),true);
		$criteria->compare('menitke',$this->menitke);
		$criteria->compare('nilai_apgar',$this->nilai_apgar);
		$criteria->compare('jmlscore',$this->jmlscore);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('apgarscore_id',$this->apgarscore_id);
		$criteria->compare('kelahiranbayi_id',$this->kelahiranbayi_id);
		$criteria->compare('metodeapgar_id',$this->metodeapgar_id);
		$criteria->compare('interpretasiskor_id',$this->interpretasiskor_id);
		$criteria->compare('LOWER(tglapgarscore)',strtolower($this->tglapgarscore),true);
		$criteria->compare('menitke',$this->menitke);
		$criteria->compare('nilai_apgar',$this->nilai_apgar);
		$criteria->compare('jmlscore',$this->jmlscore);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}