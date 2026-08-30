<?php

/**
 * This is the model class for table "grouplayanankasiroa_m".
 *
 * The followings are the available columns in table 'grouplayanankasiroa_m':
 * @property integer $grouplayanankasiroa_id
 * @property integer $jenisobatalkes_id
 * @property integer $grouplayanan_id
 *
 * The followings are the available model relations:
 * @property JenisobatalkesM $jenisobatalkes
 * @property GrouplayananM $grouplayanan
 */
class GrouplayanankasiroaM extends CActiveRecord
{
	public $grouplayanan_nama;
	public $jenisobatalkes_nama;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return GrouplayanankasiroaM the static model class
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
		return 'grouplayanankasiroa_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jenisobatalkes_id, grouplayanan_id', 'required'),
			array('jenisobatalkes_id, grouplayanan_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('grouplayanankasiroa_id, jenisobatalkes_id, grouplayanan_id', 'safe', 'on'=>'search'),
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
			'jenisobatalkes' => array(self::BELONGS_TO, 'JenisobatalkesM', 'jenisobatalkes_id'),
			'grouplayanan' => array(self::BELONGS_TO, 'GrouplayananM', 'grouplayanan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'grouplayanankasiroa_id' => 'Grouplayanankasiroa',
			'jenisobatalkes_id' => 'Jenisobatalkes',
			'grouplayanan_id' => 'Grouplayanan',
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

		$criteria->compare('grouplayanankasiroa_id',$this->grouplayanankasiroa_id);
		$criteria->compare('jenisobatalkes_id',$this->jenisobatalkes_id);
		$criteria->compare('grouplayanan_id',$this->grouplayanan_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('grouplayanankasiroa_id',$this->grouplayanankasiroa_id);
		$criteria->compare('jenisobatalkes_id',$this->jenisobatalkes_id);
		$criteria->compare('grouplayanan_id',$this->grouplayanan_id);
		$criteria->limit = -1;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false
		));
	}
}