<?php

/**
 * This is the model class for table "stokminimal_t".
 *
 * The followings are the available columns in table 'stokminimal_t':
 * @property integer $stokminimal_id
 * @property integer $obatalkes_id
 * @property integer $ruangan_id
 * @property double $jmlminimalstok
 *
 * The followings are the available model relations:
 * @property ObatalkesM $obatalkes
 * @property RuanganM $ruangan
 */
class StokminimalT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return StokminimalT the static model class
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
		return 'stokminimal_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('obatalkes_id, ruangan_id, jmlminimalstok', 'required'),
			array('obatalkes_id, ruangan_id', 'numerical', 'integerOnly'=>true),
			array('jmlminimalstok', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('stokminimal_id, obatalkes_id, ruangan_id, jmlminimalstok', 'safe', 'on'=>'search'),
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
			'obatalkes' => array(self::BELONGS_TO, 'ObatalkesM', 'obatalkes_id'),
			'ruangan' => array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'stokminimal_id' => 'Stokminimal',
			'obatalkes_id' => 'Obatalkes',
			'ruangan_id' => 'Ruangan',
			'jmlminimalstok' => 'Jmlminimalstok',
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

		$criteria->compare('stokminimal_id',$this->stokminimal_id);
		$criteria->compare('obatalkes_id',$this->obatalkes_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('jmlminimalstok',$this->jmlminimalstok);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}