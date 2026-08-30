<?php

/**
 * This is the model class for table "permohonanoadetail_t".
 *
 * The followings are the available columns in table 'permohonanoadetail_t':
 * @property integer $permohonanoadetail_id
 * @property integer $permohonanoa_id
 * @property integer $obatalkes_id
 * @property integer $satuankecil_id
 * @property double $permohonanoadetail_qty
 *
 * The followings are the available model relations:
 * @property PermohonanoaT $permohonanoa
 * @property ObatalkesM $obatalkes
 * @property SatuankecilM $satuankecil
 */
class PermohonanoadetailT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PermohonanoadetailT the static model class
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
		return 'permohonanoadetail_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('permohonanoa_id, obatalkes_id, satuankecil_id', 'required'),
			array('permohonanoa_id, obatalkes_id, satuankecil_id', 'numerical', 'integerOnly'=>true),
			array('permohonanoadetail_qty', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('permohonanoadetail_id, permohonanoa_id, obatalkes_id, satuankecil_id, permohonanoadetail_qty', 'safe', 'on'=>'search'),
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
			'permohonanoa' => array(self::BELONGS_TO, 'PermohonanoaT', 'permohonanoa_id'),
			'obatalkes' => array(self::BELONGS_TO, 'ObatalkesM', 'obatalkes_id'),
			'satuankecil' => array(self::BELONGS_TO, 'SatuankecilM', 'satuankecil_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'permohonanoadetail_id' => 'Permohonanoadetail',
			'permohonanoa_id' => 'Permohonanoa',
			'obatalkes_id' => 'Obatalkes',
			'satuankecil_id' => 'Satuankecil',
			'permohonanoadetail_qty' => 'Permohonanoadetail Jumlah',
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

		$criteria->compare('permohonanoadetail_id',$this->permohonanoadetail_id);
		$criteria->compare('permohonanoa_id',$this->permohonanoa_id);
		$criteria->compare('obatalkes_id',$this->obatalkes_id);
		$criteria->compare('satuankecil_id',$this->satuankecil_id);
		$criteria->compare('permohonanoadetail_qty',$this->permohonanoadetail_qty);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}