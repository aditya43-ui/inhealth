<?php

/**
 * This is the model class for table "grouplayanankasir_m".
 *
 * The followings are the available columns in table 'grouplayanankasir_m':
 * @property integer $grouplayanankasir_id
 * @property integer $daftartindakan_id
 * @property integer $grouplayanan_id
 *
 * The followings are the available model relations:
 * @property DaftartindakanM $daftartindakan
 * @property GrouplayananM $grouplayanan
 */
class GrouplayanankasirM extends CActiveRecord
{
	public $grouplayanan_nama;
	public $daftartindakan_nama;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return GrouplayanankasirM the static model class
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
		return 'grouplayanankasir_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('daftartindakan_id, grouplayanan_id', 'required'),
			array('daftartindakan_id, grouplayanan_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('grouplayanankasir_id, daftartindakan_id, grouplayanan_id', 'safe', 'on'=>'search'),
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
			'daftartindakan' => array(self::BELONGS_TO, 'DaftartindakanM', 'daftartindakan_id'),
			'grouplayanan' => array(self::BELONGS_TO, 'GrouplayananM', 'grouplayanan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'grouplayanankasir_id' => 'Grouplayanankasir',
			'daftartindakan_id' => 'Daftartindakan',
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

		$criteria->compare('grouplayanankasir_id',$this->grouplayanankasir_id);
		$criteria->compare('daftartindakan_id',$this->daftartindakan_id);
		$criteria->compare('grouplayanan_id',$this->grouplayanan_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('grouplayanankasir_id',$this->grouplayanankasir_id);
		$criteria->compare('daftartindakan_id',$this->daftartindakan_id);
		$criteria->compare('grouplayanan_id',$this->grouplayanan_id);
		$criteria->limit = -1;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false
		));
	}
}